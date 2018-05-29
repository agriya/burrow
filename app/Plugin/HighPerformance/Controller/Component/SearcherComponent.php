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
 * Adds search capability to existing controllers.
 *
 * @author    Kevin van Zonneveld <kvz@php.net>
 */
class SearcherComponent extends Component
{
    public $Controller;
    public $LeadModel;
    public $settings = array();
    public $serializer;
    protected $_default = array();
    public function __construct(ComponentCollection $collection, $settings = array()) 
    {
        $settings = Set::merge($this->_default, $settings);
        parent::__construct($collection, $settings);
    }
    public function initialize(Controller $Controller, $settings = array()) 
    {
        $this->Controller = $Controller;
    }
    public function searcher() 
    {
        $this->Searcher->searchAction($this->RequestHandler->isAjax());
    }
    public function admin_searcher() 
    {
        $this->Searcher->searchAction($this->RequestHandler->isAjax());
    }
    public function searchAction($ajax) 
    {
        if ($this->opt('model') === '_all') {
            $this->LeadingModel = ClassRegistry::init($this->opt('leading_model'));
            $this->LeadingModel->fullIndex = true;
        } else {
            $this->LeadingModel = new City();
            $this->LeadingModel->fullIndex = false;
        }
        if (!$this->LeadingModel) {
            return null;
        }
        if ($this->Controller->action !== $this->mOpt($this->LeadingModel, 'searcher_action')) {
            //return null;
            
        }
        if (!($query = @$this->Controller->passedArgs[$this->mOpt($this->LeadingModel, 'searcher_param') ])) {
            if (!($query = @$this->Controller->data[$this->mOpt($this->LeadingModel, 'searcher_param') ])) {
                return $this->err('No search query. ');
            }
        }
        $queryParams = array();
        if ($ajax) {
            $queryParams['limit'] = 100;
        }
        $response = $this->search($query, $queryParams);
        if ($ajax) {
            return $this->respond($response);
        }
        $this->Controller->set('results', $response);
        $this->Controller->render('searcher');
    }
    public function search($query, $queryParams) 
    {
        $raw_results = $this->LeadingModel->elastic_search($query, $queryParams);
        if (is_string($raw_results)) {
            return $this->err('Error while doing search: %s', $raw_results);
        }
        if (!is_array($raw_results)) {
            return $this->err('Received invalid raw_results: %s', $raw_results);
        }
        if (empty($raw_results)) {
            return array();
        }
        $i = 0;
        $cats = array();
        $results = array();
        foreach($raw_results as $result) {
            $this->_enrich($result);
            // Add te response
            $results[$i] = $result;
            $cats[$i] = $result['category'];
            $i++;
        }
        $response = Set::sort($results, '/category', 'asc');
        return $response;
    }
    protected function _enrich(&$result) 
    {
        $result['label'] = @$result['data']['_label'];
        $result['descr'] = @$result['data']['_descr'];
        $result['url'] = @$result['data']['_url'];
        $result['model'] = @$result['data']['_model'];
        $result['category'] = @$result['data']['_model_title'];
        if (($html = @$result['highlights']['_label'][0])) {
            $result['html'] = $html;
        } else {
            $result['html'] = $result['label'];
        }
    }
    public function err($format, $arg1 = null, $arg2 = null, $arg3 = null) 
    {
        $arguments = func_get_args();
        $format = array_shift($arguments);
        $str = $format;
        if (count($arguments)) {
            foreach($arguments as $k => $v) {
                $arguments[$k] = is_scalar($v) ? $v : json_encode($v);
            }
            $str = vsprintf($str, $arguments);
        }
        return $this->respond(array(
            'errors' => explode('; ', $str) ,
        ));
    }
    public function respond($response) 
    {
        Configure::write('debug', 0);
        if (!headers_sent()) {
            header('Content-type: application/json');
            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        }
        $serializer = $this->mOpt($this->LeadingModel, 'searcher_serializer');
        if (@$GLOBALS['XHPROF_ON'] && @$GLOBALS['XHPROF_NAMESPACE'] && @$GLOBALS['TIME_START']) {
            echo 'sad';
            $xhprof_data = xhprof_disable();
            $xhprof_runs = new XHProfRuns_Default();
            $run_id = $xhprof_runs->save_run($xhprof_data, $GLOBALS['XHPROF_NAMESPACE']);
            $parsetime = number_format(getmicrotime() -$GLOBALS['TIME_START'], 3);
            $xhprof = sprintf('http://%s%s/xhprof/xhprof_html/index.php?run=%s&source=%s', $_SERVER['HTTP_HOST'], Configure::read('App.urlpath') , $run_id, $GLOBALS['XHPROF_NAMESPACE']);
            $response['@' . $parsetime] = $xhprof;
        }
        if (!is_callable('json_encode')) {
            echo json_encode(array(
                'errors' => array(
                    'Serializer ' . $serializer . ' was not callable',
                ) ,
            ));
        } else {
            echo call_user_func($serializer, $response);
        }
        die();
    }
    /**
     * Returns appropriate Model or false on not active
     *
     * @return mixed Object or false on failure
     */
    public function isEnabled(Controller $Controller) 
    {
        if (!isset($Controller)) {
            return false;
        }
        if (!isset($Controller->modelClass)) {
            return false;
        }
        $modelName = $Controller->modelClass;
        if (!isset($Controller->$modelName)) {
            return false;
        }
        if (!is_object($Controller->$modelName)) {
            return false;
        }
        $Model = $Controller->$modelName;
        return ($Model->Behaviors->attached('Searchable') && $Model->elastic_enabled());
    }
    public function mOpt($Model, $key) 
    {
        return @$Model->Behaviors->Searchable->settings[$Model->alias][$key];
    }
    public function opt($key) 
    {
        return @$this->settings[$key];
    }
}
