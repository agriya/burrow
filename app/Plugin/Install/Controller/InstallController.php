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
App::uses('InstallAppController', 'Install.Controller');
class InstallController extends InstallAppController
{
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Install';
    /**
     * No models required
     *
     * @var array
     * @access public
     */
    public $uses = null;
    /**
     * No components required
     *
     * @var array
     * @access public
     */
    public $components = null;
    /**
     * Default configuration
     *
     * @var array
     * @access public
     */
    public $defaultConfig = array(
        'name' => 'default',
        'datasource' => 'Database/Mysql',
        'persistent' => false,
        'host' => 'localhost',
        'login' => 'root',
        'password' => '',
        'database' => 'burrow',
        'schema' => null,
        'prefix' => null,
        'encoding' => 'UTF8',
        'port' => null,
    );
    /**
     * beforeFilter
     *
     * @return void
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->layout = 'install';
        App::import('Component', 'Session');
        $this->Session = new SessionComponent($this->Components);
    }
    /**
     * If settings.yml exists, app is already installed
     *
     * @return void
     */
    protected function _check()
    {
        if (Configure::read('Install.installed') && Configure::read('Install.secured')) {
            $this->Session->setFlash('Already Installed');
            $this->redirect('/');
        }
    }
    /**
     * Step 0: welcome
     *
     * A simple welcome message for the installer.
     *
     * @return void
     * @access public
     */
    public function index()
    {
        $this->_check();
        $this->set('title_for_layout', __l('Installation: Welcome'));
    }
    /**
     * Step 1: Server Requirements
     *
     * A simple welcome message for the installer.
     *
     * @return void
     * @access public
     */
    public function requirements()
    {
        $this->_check();
        $this->set('title_for_layout', __l('Installation: Server Requirements'));
    }
    /**
     * Step 2: File Permissions
     *
     * A simple welcome message for the installer.
     *
     * @return void
     * @access public
     */
    public function permissions()
    {
        $this->_check();
        $this->set('title_for_layout', __l('Installation: File Permissions'));
    }
    /**
     * Step 3: License
     *
     * A simple welcome message for the installer.
     *
     * @return void
     * @access public
     */
    public function license()
    {
        $this->_check();
        $this->set('title_for_layout', __l('Installation: License Configuration'));
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['Install']['license'])) {
                App::uses('File', 'Utility');
                $file = new File(APP . 'Config' . DS . 'config.php', true);
                $content = $file->read();
                $tokens = token_get_all($content);
                $old_license_key = '';
                foreach($tokens as $token) {
                    if (is_array($token)) {
                        if (empty($is_license_key)) {
                            if ($token[0] == T_CONSTANT_ENCAPSED_STRING && $token[1] == "'license_key'") {
                                $is_license_key = 1;
                            }
                        } else {
                            if ($token[0] == T_CONSTANT_ENCAPSED_STRING) {
                                $old_license_key = $token[1];
                                break;
                            }
                        }
                    }
                }
                $content = str_replace($old_license_key, '\'' . $this->request->data['Install']['license'] . '\'', $content);
                if ($file->write($content)) {
                    return $this->redirect(array(
                        'action' => 'database'
                    ));
                } else {
                    $this->Session->setFlash(__l('Could not write config.php file.') , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(__l('Please enter your license key') , 'default', null, 'error');
            }
        }
    }
    /**
     * Step 4: database
     *
     * Try to connect to the database and give a message if that's not possible so the user can check their
     * credentials or create the missing database
     * Create the database file and insert the submitted details
     *
     * @return void
     * @access public
     */
    public function database()
    {
        $this->_check();
        $this->set('title_for_layout', __l('Installation: Database'));
        if (empty($this->request->data)) {
            $this->_CmsPlugin = new CmsPlugin();
            $pluginAliases = $this->_CmsPlugin->getPlugins();
            $plugins = array();
            foreach($pluginAliases as $pluginAlias) {
                $temp_plugins = $this->_CmsPlugin->getData($pluginAlias);
                $plugins[] = $temp_plugins['name'];
            }
            $this->set('plugins', $plugins);
            return;
        }
        @App::import('Model', 'ConnectionManager');
        $config = $this->defaultConfig;
        foreach($this->request->data['Install'] AS $key => $value) {
            if (isset($this->request->data['Install'][$key])) {
                $config[$key] = $value;
            }
        }
        try {
            @ConnectionManager::create('default', $config);
            $db = ConnectionManager::getDataSource('default');
        }
        catch(MissingConnectionException $e) {
            $this->Session->setFlash(sprintf(__l('Could not connect to database: %s') , $e->getMessage()) , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'database'
            ));
        }
        if (!$db->isConnected()) {
            $this->Session->setFlash(__l('Could not connect to database.') , 'default', null, 'error');
            return;
        }
		if ($this->request->data['Install']['datasource'] == 'Database/Mysql') {
			$version = $db->query('SELECT VERSION() as version');
			if (!empty($version[0][0]['version'])) {
				$mysql_version = explode('.', $version[0][0]['version']);
				if ($mysql_version[0] < 5) {
					$this->Session->setFlash(__l('MySQL Version Should be 5.x') , 'default', null, 'error');
					$this->redirect(array(
						'action' => 'database'
					));
				}
			}
		}
        copy(APP . 'Config' . DS . 'database.php.install', APP . 'Config' . DS . 'database.php');
        App::uses('File', 'Utility');
        $file = new File(APP . 'Config' . DS . 'database.php', true);
        $content = $file->read();
        foreach($config AS $configKey => $configValue) {
            $content = str_replace('{default_' . $configKey . '}', $configValue, $content);
        }
        if ($file->write($content)) {
            return $this->redirect(array(
                'action' => 'data',
                'run' => true
            ));
        } else {
            $this->Session->setFlash(__l('Could not write database.php file.') , 'default', null, 'error');
        }
    }
    /**
     * Step 5: Run the initial sql scripts to create the db and seed it with data
     *
     * @return void
     * @access public
     */
    public function data()
    {
        $this->_check();
        $this->set('title_for_layout', __l('Installation: Build database'));
        if (isset($this->params['named']['run'])) {
            App::uses('File', 'Utility');
            App::import('Model', 'CakeSchema', false);
            App::import('Model', 'ConnectionManager');
            $db = ConnectionManager::getDataSource('default');
            if (!$db->isConnected()) {
                $this->Session->setFlash(__l('Could not connect to database.') , 'default', null, 'error');
            } else {
				$schema_file = 'mysql';
				if ($db->config['datasource'] == 'Database/Postgres') {
					$schema_file = 'postgres';
				}
                $schema = &new CakeSchema(array(
                    'name' => 'app',
                    'file' => $schema_file . '_schema.php',
                ));
                $schema = $schema->load();
                foreach($schema->tables as $table => $fields) {
                    $create = $db->createSchema($schema, $table);
                    try {
                        $db->execute($create);
                    }
                    catch(PDOException $e) {
                        $this->Session->setFlash(sprintf(__l('Could not create table: %s') , $e->getMessage()) , 'default', null, 'error');
                        $this->redirect(array(
                            'action' => 'database'
                        ));
                    }
                }
                $path = App::pluginPath('Install') . DS . 'Config' . DS . ucfirst($schema_file) . 'Data' . DS;
                $dataObjects = App::objects('class', $path);
                foreach($dataObjects as $data) {
                    include ($path . $data . '.php');
                    $classVars = get_class_vars($data);
                    $modelAlias = substr($data, 0, -4);
                    $table = $classVars['table'];
                    $records = $classVars['records'];
                    App::import('Model', 'Model', false);
                    $modelObject = &new Model(array(
                        'name' => $modelAlias,
                        'table' => $table,
                        'ds' => 'default',
                    ));
                    if (is_array($records) && count($records) > 0) {
                        foreach($records as $record) {
							$record = array_map('stripslashes', $record);
                            $modelObject->create($record);
                            $modelObject->save();
                        }
                    }
                }
                $this->redirect(array(
                    'action' => 'configuration'
                ));
            }
        }
    }
    /**
     * Step 3: Configurations
     *
     * A simple welcome message for the installer.
     *
     * @return void
     * @access public
     */
    public function configuration()
    {
        $this->_check();
        $this->set('title_for_layout', __l('Installation: Settings Configuration'));
        if (!empty($this->request->data)) {
            App::import('Model', 'Model', false);
            $modelObject = &new Model(array(
                'name' => 'Setting',
                'table' => 'settings',
                'ds' => 'default',
            ));
            foreach($this->request->data as $primary_key => $tmpData) {
                $key_arr = array_keys($tmpData);
                $key_arr_size = sizeof($key_arr);
                for ($i = 0; $i < $key_arr_size; $i++) {
                    if ($primary_key == 'site' && ($key_arr[$i] == 'from_email' || $key_arr[$i] == 'admin_email')) {
                        $primary_key = 'EmailTemplate';
                    }
                    $setting = $modelObject->find('first', array(
                        'conditions' => array(
                            'name' => $primary_key . '.' . $key_arr[$i]
                        ) ,
                        'recursive' => -1
                    ));
                    if (!empty($setting)) {
                        $modelObject->updateAll(array(
                            'Setting.value' => "'" . $tmpData[$key_arr[$i]] . "'"
                        ) , array(
                            'Setting.id' => $setting['Setting']['id']
                        ));
                    }
                }
            }
            $this->redirect(array(
                'action' => 'finish'
            ));
        }
    }
    /**
     * Step 5: finish
     *
     * Copy settings.yml file into place and set admin's password
     *
     * @return void
     * @access public
     */
    public function finish()
    {
        $this->set('title_for_layout', __l('Installation is Complete!'));
        $this->_check();
        $this->loadModel('Install.Install');
        $this->Install->finalize();
    }
}
