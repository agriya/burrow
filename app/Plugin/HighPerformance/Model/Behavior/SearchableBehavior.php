<?php
/**
 * Burrow
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    Burrow
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
/**
 * Searchable
 *
 * Copyright (c) 2011 Kevin van Zonneveld (http://kevin.vanzonneveld.net || kvz@php.net)
 *
 * @author Kevin van Zonneveld (kvz)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
class SearchableBehavior extends ModelBehavior {
	public $mapMethods = array(
		'/elastic_search_opt/' => 'opt',
		'/elastic_search/' => 'search',
		'/elastic_fill/' => 'fill',
		'/elastic_enabled/' => 'enabled',
	);

	protected $_default = array(
		'highlight' => array(
			'pre_tags' => array('<em class="highlight">'),
			'post_tags' => array('</em>'),
			'fields' => array(
				'_all' => array(
					'fragment_size' => 60,
					'number_of_fragments' => 1,
				),
			),
		),
		'highlight_excludes' => array(
		),
		'curl_connect_timeout' => 3,
		'curl_total_timeout' => 0,
		'fake_fields' => array(),
		'debug_traces' => false,
		'searcher_enabled' => true,
		'searcher_action' => 'searcher',
		'searcher_param' => 'q',
		'searcher_serializer' => 'json_encode',
		'realtime_update' => true,
		'cb_progress' => false,
		'limit' => 1000,
		'index_find_params' => array(),
		'index_name' => 'main',
		'index_chunksize' => 10000,
		'static_url_generator' => array('{model}', 'modelUrl'),
		'error_handler' => 'disklog',
		'enforce' => array(),
		'fields' => '_all',
		'fields_excludes' => array(
			'_url',
			'_model',
			'_label',
		),
	);

	public $localFields = array(
		'_label',
		'_descr',
		'_model',
		'_model_title',
		'_model_titles',
		'_url',
	);

	protected $_Client;
	protected $_fields = array();
	public $settings = array();
	public $errors = array();

	protected static $_autoLoaderPrefix = '';
	public static function createAutoloader ($prefix = '', $path = null) {
		self::$_autoLoaderPrefix = $prefix;
		if ($path) {
			set_include_path(get_include_path() . PATH_SEPARATOR . $path);
		}
		spl_autoload_register(array('SearchableBehavior', 'autoloader'));
	}
	public static function autoloader ($className) {
		if (substr($className, 0, strlen(self::$_autoLoaderPrefix)) !== self::$_autoLoaderPrefix) {
			// Only autoload stuff for which we created this loader
			#echo 'Not trying to autoload ' . $className. "\n";
			return;
		}

		$path = str_replace('_', '/', $className) . '.php';

		include($path);
	}

	/**
	 * Goes through filesystem and returns all models that have
	 * elasticsearch enabled.
	 *
	 * @return <type>
	 */
	public static function allModels ($instantiated = false) {
		$models = array();
		foreach (glob(APP . 'Model' . DS . '*.php') as $filePath) {
			$models[] = self::_getModel($filePath, $instantiated);
		}
		foreach (CakePlugin::loaded() as $plugin) {
			foreach (glob(CakePlugin::path($plugin) . 'Model' . DS . '*.php') as $filePath) {
				if (false === stripos($filePath, 'ToolbarAccess')) {
					$models[] = self::_getModel($filePath, $instantiated, $plugin);
				}
			}
		}
		return array_values(array_filter($models));
	}

	protected static function _getModel($filePath, $instantiated, $plugin = null) {
		// Hacky, but still better than instantiating all Models:
//		$buf = file_get_contents($filePath);
//		if (false === stripos($buf, 'HighPerformance.Searchable')) {
//			return false;
//		}

		if ($plugin) {
			$plugin .= '.';
		}
		$base      = basename($filePath, '.php');
		$modelName = Inflector::classify($base);
		$Model = ClassRegistry::init($plugin . $modelName);
		if (!$Model->Behaviors->attached('Searchable') || !$Model->elastic_enabled()) {
			return false;
		}

		if ($instantiated) {
			return $Model;
		}
		return $plugin . $modelName;
	}

	public function afterSave (Model $Model, $created) {
		if (!$this->opt($Model, 'realtime_update')) {
			return true;
		}
		if (!($data = @$Model->data[$Model->alias])) {
			return true;
		}

		if (!($id = @$data[$Model->primaryKey])) {
			$id = $Model->id;
		}

		$res = $this->_fillChunk($Model, null, null, $id);

		// Index needs a moment to be updated
		$this->execute($Model, 'POST', '_refresh');

		return !!$res;
	}

	public function fill () {
		$args = func_get_args();

		// Strip model from args if needed
		if (is_object(@$args[0])) {
			$Model = array_shift($args);
		} else {
			return $this->err('First argument needs to be a model');
		}

		// Strip method from args if needed (e.g. when called via $Model->mappedMethod())
		if (is_string(@$args[0])) {
			foreach ($this->mapMethods as $pattern => $meth) {
				if (preg_match($pattern, $args[0])) {
					$method = array_shift($args);
					break;
				}
			}
		}

		// cbProgress
		$cbProgress = array_key_exists(0, $args) ? array_shift($args) : null;
		if (is_callable($cbProgress)) {
			$this->opt($Model, 'cb_progress', $cbProgress);
		}

		// Create index
		$u = $this->execute($Model, 'PUT', '', array('fullIndex' => true, ));
		$d = $this->execute($Model, 'DELETE', '');
		$o = $this->execute($Model, 'POST', '_refresh', array('fullIndex' => true, ));

		// Get records
		$offset = 0;
		$limit  = $this->opt($Model, 'index_chunksize');
		$count  = 0;
		while (true) {
			$curCount = $this->_fillChunk($Model, $offset, $limit);
			$count   += $curCount;

			if ($curCount < $limit) {
				$this->progress($Model, 'Reached curCount ' . $curCount . ' < ' . $limit);
				break;
			}
			$offset += $limit;
		}

		// Index needs a moment to be updated
		$this->execute($Model, 'POST', '_refresh', array('fullIndex' => true, ));

		return $count;
	}

	public function progress ($Model, $str) {
		$cbProgress = $this->opt($Model, 'cb_progress');
		if (!is_callable($cbProgress)) {
			return;
		}

		return call_user_func($cbProgress, $str);
	}

	protected function _fillChunk ($Model, $offset, $limit, $id = null) {
		// Set params
		if (!($params = $this->opt($Model, 'index_find_params'))) {
			$params = array();
		}

		$index_name = $this->opt($Model, 'index_name');
		$type       = $this->opt($Model, 'type');


		$primKeyPath  = $Model->alias . '/' . $Model->primaryKey;
		$labelKeyPath = $Model->alias . '/' . $Model->displayField;
		if (!empty($Model->labelField)) {
			$labelKeyPath = $Model->alias . '/' . $Model->labelField;
		}

		$descKeyPath = false;
		if (@$Model->descripField) {
			$descKeyPath = $Model->alias . '/' . @$Model->descripField;
		}

		$isQuery = is_string($params);
		if ($isQuery) {
			$sqlLimit = '';

			if ($limit) {
				$sqlLimit = 'LIMIT ' . $limit;
			}
			if ($offset) {
				$sqlLimit = str_replace('LIMIT ', 'LIMIT ' . $offset .',', $sqlLimit);
			}

			$sql = $params;
			$sql = str_replace('{offset_limit_placeholder}', $sqlLimit, $sql);

			if ($id !== null) {
				$singleSql = 'AND `' . $Model->useTable . '`.`' . $Model->primaryKey . '` = "' . addslashes($id) . '"';
				$sql = str_replace('{single_placeholder}', $singleSql, $sql);
			} else {
				$sql = str_replace('{single_placeholder}', '', $sql);
			}

			// Directly addressing datasource cause we don't want
			// any of Cake's array restructuring. We're going for raw
			// performance here, and we're flattening everything to go
			// into Elasticsearch anyway
			$DB = ConnectionManager::getDataSource($Model->useDbConfig);
			$this->progress($Model, '(select_start: ' . $offset .  '-' . ($offset+$limit) . ')');
			if (!($rawRes = $DB->execute($sql))) {
				return $this->err($Model, 'Error in query: %s. %s', $sql, mysql_error());
			}

			$sqlCount = $rawRes->rowCount();

			$results = array();
			while ($row = $rawRes->fetch()) {
				$id = $row[$primKeyPath];
				if (empty($results[$id])) {
					$childCnt = 0;
				}
				foreach ($row as $key => $val) {
					if ($key != 'queryString') {
						$results[$id][str_replace('{n}', $childCnt, $key)] = $val;
					}
				}
				$childCnt++;
			}
		} else {
			if ($id) {
				$params['conditions'][$Model->primaryKey] = $id;
			} else {
				$params['offset'] = $offset;
				if (empty($params['limit'])) {
					$params['limit'] = $limit;
				}
				$this->progress($Model, '(select_start: ' . $params['offset'] .  '-' . ($params['offset']+$params['limit']) . ')');
			}

			if (!$Model->Behaviors->attached('Containable')) {
				$Model->Behaviors->attach('Containable');
			}
			$results = $Model->find('all', $params);
		}

//        $sources = ConnectionManager::sourceList();
//        $logs = array();
//        foreach ($sources as $source):
//            $db =& ConnectionManager::getDataSource($source);
//            if (!$db->isInterfaceSupported('getLog')):
//                continue;
//            endif;
//            $logs[$source] = $db->getLog();
//        endforeach;
//        prd(compact('logs'));

		if (empty($results)) {
			return array();
		}

		// Add documents
		$urlCb = $this->opt($Model, 'static_url_generator');
		if ($urlCb[0] === '{model}') {
			$urlCb[0] = $Model->name;
		}
		if (!method_exists($urlCb[0], $urlCb[1])) {
			$urlCb = false;
		}
		$commands    = "";
		$fake_fields = $this->opt($Model, 'fake_fields');

		$docCount = 0;
		foreach ($results as $result) {
			if ($isQuery) {
				$doc = $result;
			} else {
				$doc = Set::flatten($result, '/');
			}

			if (empty($doc[$primKeyPath])) {
				return $this->err(
					$Model,
					'I need at least primary key: %s->%s inside the index data. Please include in the index_find_params',
					$Model->alias,
					$Model->primaryKey
				);
			}

			$meta = array(
				'_index' => $index_name,
				'_type' => $type,
				'_id' => $doc[$primKeyPath],
			);

			//$doc['_id'] = $doc[$primKeyPath];

			if (!($meta['_id'] % 100)) {
				$this->progress($Model, '(compile: @' . $meta['_id'] . ')');
			}

			$doc['_label'] = '';
			if (array_key_exists($labelKeyPath, $doc)) {
				$doc['_label'] = $doc[$labelKeyPath];
			}

			// FakeFields
			if (is_array(reset($fake_fields))) {
				foreach ($fake_fields as $fake_field => $xPaths) {
					$concats = array();
					foreach ($xPaths as $xPath) {
						if (array_key_exists($xPath, $doc)) {
							$concats[] = $doc[$xPath];
						} else {
							$concats[] = $xPath;
						}
					}

					$doc[$fake_field] = join(' ', $concats);
				}
			}

			$doc['_descr'] = '';
			if ($descKeyPath && array_key_exists($descKeyPath, $doc)) {
				$doc['_descr'] = $doc[$descKeyPath];
			}


			$doc['_model'] = $Model->name;

			if (!@$Model->title) {
				$Model->title = Inflector::humanize(Inflector::underscore($doc['_model']));
			}
			$doc['_model_title'] = $Model->title;

			if (!@$Model->titlePlu) {
				$Model->titlePlu = Inflector::pluralize($Model->title);
			}
			$doc['_model_titles'] = $Model->titlePlu;

			$doc['_url']   = '';
			if (is_array($urlCb)) {
				$doc['_url'] = call_user_func($urlCb, $meta['_id'], $doc['_model']);
			}

			$commands .= json_encode(array('create' => $meta)) . "\n";
			$commands .= $this->_serializeDocument($Model, $doc) . "\n";
			$docCount++;
		}

		$this->progress($Model, '(store)' . "\n");

		if ($docCount == 1) {
			$res = $this->execute($Model, 'PUT', '_bulk', $doc);
		} else {
			$res = $this->execute($Model, 'PUT', '_bulk', $commands, array('prefix' => '', ));
		}

		if (is_string($res)) {
			return $this->err(
				$Model,
				'Unable to add items. %s',
				$res
			);
		} else {
			//$this->progress($Model, json_encode($res). "\n");
		}
//		} else if (is_array(@$res['items'])) {
//            foreach ($res['items'] as $i => $payback) {
//                if (@$payback['create']['error']) {
//                    printf(
//                        'Unable to create %s #%s. %s' . "\n",
//                        $Model->alias,
//                        @$payback['create']['_id'],
//                        @$payback['create']['error']
//                    );
//                }
//            }

		return @$sqlCount ? @$sqlCount : $docCount;
	}

	protected function _serializeDocument ($Model, $content) {

		$serializer = $this->opt($Model, 'searcher_serializer');
		if (!is_callable($serializer)) {
			$content = json_encode($content);
		} else {
			$content = call_user_func($serializer, $content);
		}
		return $content;
	}

	protected function _queryParams ($Model, $queryParams, $keys) {
		foreach ($keys as $key) {
			if (array_key_exists($key, $queryParams)) {
				continue;
			}

			if (($opt = $this->opt($Model, $key))) {
				$queryParams[$key] = $opt;
			} else {
				$queryParams[$key] = null;
			}
		}

		return $queryParams;
	}

	public function execute ($Model, $method, $path, $payload = array(), $options = array()) {
		if (!array_key_exists('prefix', $options)) $options['prefix'] = null;
		if (!array_key_exists('fullIndex', $options)) $options['fullIndex'] = $Model->fullIndex;

		$conn = curl_init();

		if ($options['prefix'] !== null) {
			$prefix = $options['prefix'];
		} else {
			$prefix = $this->opt($Model, 'index_name');
			if (!$options['fullIndex']) {
				$prefix .= '/' . $this->opt($Model, 'type');
			}
			$prefix .= '/';
		}

		$path = $prefix . $path;

		$uri = sprintf(
			'http://%s:%s/%s',
			$this->opt($Model, 'host'),
			$this->opt($Model, 'port'),
			$path
		);
		curl_setopt($conn, CURLOPT_URL, $uri);
		curl_setopt($conn, CURLOPT_CONNECTTIMEOUT, $this->opt($Model, 'curl_connect_timeout'));
		curl_setopt($conn, CURLOPT_TIMEOUT, $this->opt($Model, 'curl_total_timeout'));
		curl_setopt($conn, CURLOPT_PORT, $this->opt($Model, 'port'));
		curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($conn, CURLOPT_CUSTOMREQUEST, $method);

		if (!empty($payload)) {
			if (is_array($payload)) {
				$content = $this->_serializeDocument($Model, $payload);
			} else {
				$content = $payload;
			}

			// Escaping of / not necessary. Causes problems in base64 encoding of files
			$content = str_replace('\/', '/', $content);
			curl_setopt($conn, CURLOPT_POSTFIELDS, $content);
		}

		$json     = curl_exec($conn);
		$response = json_decode($json, true);


		if (($e = curl_error($conn))) {
			return sprintf('Error from elasticsearch server while contacting %s (%s)', $uri, $e);
		}
		if (false === $response) {
			return sprintf('Invalid response from elasticsearch server while contacting %s (%s)', $uri, $json);
		}
		if (@$response['error']) {
			if ($response['error'] === 'ActionRequestValidationException[Validation Failed: 1: no requests added;]') {
				return $response;
			}
			return sprintf('Error from elasticsearch server while contacting %s (%s)', $uri, @$response['error']);
		}

		return $response;
	}

	public function query ($Model, $query, $queryParams) {
		$queryParams = $this->_queryParams($Model, $queryParams, array(
			'enforce',
			'highlight',
			'limit',
			'fields',
		));

		$payload = array();

		if ($queryParams['highlight']) {
			$payload['highlight'] = $queryParams['highlight'];
		}
		if ($queryParams['limit']) {
			$payload['size'] = $queryParams['limit'];
		}
		if (@$queryParams['sort']) {
			$payload['sort'] = $queryParams['sort'];
		}

		$payload['query']['bool']['must'][0]['query_string'] = array(
			'query' => $query,
			'use_dis_max' => true,
		);
		if (is_array($queryParams['fields'])) {
			$payload['query']['bool']['must'][0]['query_string']['fields'] = $queryParams['fields'];
		}

		if ($queryParams['enforce']) {
			$i = count ($payload['query']['bool']['must']);
			$payload['query']['bool']['must'][$i]['term'] = $queryParams['enforce'];
		}

		return $payload;
	}

	/**
	 * Search. Arguments can be different wether the call is made like
	 *  - $Model->elastic_search, or
	 *  - $this->search
	 * that's why I eat&check away arguments with array_shift
	 *
	 * @return string
	 */
	public function search () {

		$args = func_get_args();

		// Strip model from args if needed
		if (is_object(@$args[0])) {
			$LeadingModel = array_shift($args);
		} else if (is_string(@$args[0])) {
			$LeadingModel = ClassRegistry::init(array_shift($args));
		}
		if (empty($LeadingModel)) {
			return $this->err('First argument needs to be a valid model');
		}

		// Strip method from args if needed (e.g. when called via $Model->mappedMethod())
		if (is_string(@$args[0])) {
			foreach ($this->mapMethods as $pattern => $meth) {
				if (preg_match($pattern, $args[0])) {
					$method = array_shift($args);
					break;
				}
			}
		}

		// No query!
		if (!($query = array_shift($args))) {
			return;
		}

		// queryParams
		$queryParams = array_key_exists(0, $args) ? array_shift($args) : array();

		// Build Query
		$payload = $this->query($LeadingModel, $query, $queryParams);

		// Custom Elasticsearch CuRL Job
		$r = $this->execute($LeadingModel, 'GET', '_search', $payload);

		// String means error
		if (is_string($r))  {
			return $r;
		}

		$results = array();
		foreach ($r['hits']['hits'] as $hit) {
			$results[] = array(
				'data' => $hit['_source'],
				'score' => $hit['_score'],
				'id' => $hit['_id'],
				'type' => $hit['_type'],
				'highlights' => @$hit['highlight'],
			);
		}

		return $results;
	}

	/**
	 * Caching wrapper
	 *
	 * @todo: implement :)
	 *
	 * @param <type> $Model
	 * @return <type>
	 */
	protected function _allFields ($Model, $unsetFields = null) {
		$key = join(',', array(
			$Model->name,
			$Model->fullIndex,
		));

		if (!array_key_exists($key, $this->_fields)) {
			// @todo Persist
			$this->_fields[$key] = $this->__allFields($Model);
		}

		$fields = $this->_fields[$key];

		// Filter
		if (is_array($unsetFields))  {
			$fields = array_diff($fields, $unsetFields);

			// Re-order nummerically so this will be a js array != object
			$fields = array_values($fields);
		}

		return $fields;
	}

	protected function __allFields ($Model) {
		$fields = $this->localFields;

		if ($Model->fullIndex === true) {
			$Models = SearchableBehavior::allModels(true);
		} else {
			$Models = array($Model);
		}

		foreach ($Models as $Model) {
			$modelAlias  = $Model->alias;
			$modelFields = array();
			$params      = $this->opt($Model, 'index_find_params');

			// If params is a custom query (possible for indexing speed)
			if (is_string($params)) {
				$pattern = '/\sAS\s\'(([a-z0-9_\{\}]+)(\/([a-z0-9_\{\}]+))+)\'/i';
				if (preg_match_all($pattern, $params, $matches)) {
					$modelFields = $matches[1];
				}
			} else {
				$flats = Set::flatten($params, '/');
				foreach ($flats as $flat => $field) {
					$flat = '/' . $flat;
					if (false !== ($pos = strpos($flat, '/fields'))) {
						$flat   = substr($flat, 0, $pos);
						$prefix = str_replace(array('/contain', '/fields', '/limit'), '' , $flat);

						if ($prefix === '') {
							$prefix = $modelAlias;
						}

						$field  = $prefix . '/' . $field;

						if (substr($field, 0, 1) === '/') {
							$field = substr($field, 1);
						}

						$modelFields[] = $field;
					}
				}
			}

			// Merge model fields in overall fields, make unique
			$fields = array_unique(array_merge($fields, $modelFields));

			// Replace {n} with range 0-3. May need to be configurable later on
			foreach ($fields as $i => $field) {
				if (false !== strpos($field, '{n}')) {
					for ($j = 0; $j <= 3; $j++) {
						$fields[] = str_replace('{n}', $j, $field);
					}
					unset($fields[$i]);
				}
			}

			// Re-order nummerically so this will be a js array != object
			$fields = array_values($fields);
		}

		return $fields;
	}

	protected function _filter_fields ($Model, $val) {
		if ($val === '_all' || empty($val)) {
			if (!$this->opt($Model, 'fields_excludes')) {
				$val = '_all';
			} else {
				$val = $this->_allFields(
					$Model,
					$this->opt($Model, 'fields_excludes')
				);
			}
		}

		return $val;
	}

	protected function _filter_enforce ($Model, $val) {
		foreach ($val as $k => $v) {
			if (substr($k, 0 ,1) === '#' && is_array($v)) {
				$args   = $v;
				$Class  = array_shift($args);
				$method = array_shift($args);

				$v = call_user_func_array(array($Class, $method), $args);
				// If null is returned, effictively remove key from enforce
				// params
				if ($v !== null) {
					$val[substr($k, 1)] = $v;
				}
				unset($val[$k]);
			}
		}

		return $val;
	}

	/**
	 * Hack so you can now do highlights on '_all'.
	 * Elasticsearch does not support that syntax for highlights yet,
	 * just for queries.
	 *
	 * @param object $Model
	 * @param array  $val
	 *
	 * @return array
	 */
	protected function _filter_highlight ($Model, $val) {
		$val = Set::normalize($val);

		if (($params = @$val['fields']['_all'])) {
			unset($val['fields']['_all']);
			if (false !== ($k = array_search('_no_all', $val['fields'], true))) {
				return $val;
			}

			$fields = $this->_allFields(
				$Model,
				$this->opt($Model, 'highlight_excludes')
			);

			// Copy original parameters to expanded fields
			if (is_array($fields)) {
				foreach ($fields as $field) {
					$val['fields'][$field] = $params;
				}
			}

			// If we exclude fields, exclude them for highlights as well
			foreach ($this->opt($Model, 'fields_excludes') as $field_exclude) {
				unset($val['fields'][$field_exclude]);
			}
		}

		return $val;
	}

	public function enabled ($Model, $method) {

		if ($this->opt($Model, 'searcher_enabled') === false) {
			return false;
		}
		return true;
	}

	public function setup(Model $Model, $settings = array()) {
		$this->settings[$Model->alias] = array_merge(
			$this->_default,
			$settings
		);

		$DB = ConnectionManager::enumConnectionObjects();

		$this->settings[$Model->alias]['host'] = Configure::read('Elasticsearch.hostname');
		$this->settings[$Model->alias]['port'] = Configure::read('Elasticsearch.port');

		//$this->settings[$Model->alias]['index_name'] = $this->opt($Model, 'index_name');
		$this->settings[$Model->alias]['type'] = Inflector::underscore($Model->alias);
	}

	public function err ($Model, $format, $arg1 = null, $arg2 = null, $arg3 = null) {
		$arguments = func_get_args();
		$Model     = array_shift($arguments);
		$format    = array_shift($arguments);

		$str = $format;
		if (count($arguments)) {
			foreach($arguments as $k => $v) {
				$arguments[$k] = $this->sensible($v);
			}
			$str = vsprintf($str, $arguments);
		}

		$this->errors[] = $str;

		if (@$this->settings[$Model->alias]['error_handler'] === 'php') {
			trigger_error($str, E_USER_ERROR);
		} else if (@$this->settings[$Model->alias]['error_handler'] === 'disklog') {
			CakeLog::error($str);
		}

		return false;
	}

	public function sensible ($arguments) {
		if (is_object($arguments)) {
			return get_class($arguments);
		}
		if (!is_array($arguments)) {
			if (!is_numeric($arguments) && !is_bool($arguments)) {
				$arguments = "'" . $arguments . "'";
			}
			return $arguments;
		}
		$arr = array();
		foreach ($arguments as $key => $val) {
			if (is_array($val)) {
				$val = json_encode($val);
			} elseif (is_object($val)) {
				$val = get_class($val);
			} elseif (!is_numeric($val) && !is_bool($val)) {
				$val = "'" . $val . "'";
			}

			if (strlen($val) > 33) {
				$val = substr($val, 0, 30) . '...';
			}

			$arr[] = $key . ': ' . $val;
		}
		return join(', ', $arr);
	}

	public function opt () {
		$args  = func_get_args();

		// Strip model from args if needed
		if (is_object($args[0])) {
			$Model = array_shift($args);
		} else {
			return $this->err('First argument needs to be a model');
		}

		// Strip method from args if needed (e.g. when called via $Model->mappedMethod())
		if (is_string($args[0])) {
			foreach ($this->mapMethods as $pattern => $meth) {
				if (preg_match($pattern, $args[0])) {
					$method = array_shift($args);
					break;
				}
			}
		}

		$count = count($args);
		$key   = @$args[0];
		$val   = @$args[1];
		if ($count > 1) {
			$this->settings[$Model->alias][$key] = $val;
		} else if ($count > 0) {
			if (!array_key_exists($key, $this->settings[$Model->alias])) {
				return $this->err(
					$Model,
					'Option %s was not set',
					$key
				);
			}

			$val = $this->settings[$Model->alias][$key];

			// Filter with callback
			$cb = array($this, '_filter_' . $key);
			if (method_exists($cb[0], $cb[1])) {
				$val = call_user_func($cb, $Model, $val);
			}

			return $val;
		} else {
			return $this->err(
				$Model,
				'Found remaining arguments: %s Opt needs more arguments (1 for Model; 1 more for getting, 2 more for setting)',
				$args
			);
		}
	}
}
SearchableBehavior::createAutoloader('HighPerformance');
