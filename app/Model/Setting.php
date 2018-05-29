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
 * Setting Model
 *
 * Site settings.
 *
 */
App::uses('File', 'Utility');
class Setting extends AppModel
{
    var $validate = array();
    public $belongsTo = array(
        'SettingCategory' => array(
            'className' => 'SettingCategory',
            'foreignKey' => 'setting_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
	
	public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'ExtensionsPlugin',
        );
	}
    /**
     * afterSave callback
     *
     * @return void
     */
    public function afterSave($created)
    {
        $this->updateYaml();
        $this->writeConfiguration();
		@unlink(APP . 'webroot' . DS . 'index.html');
		return true;
    }
    /**
     * afterDelete callback
     *
     * @return void
     */
    public function afterDelete()
    {
        $this->updateYaml();
        $this->writeConfiguration();
		return true;
    }
    /**
     * Creates a new record with name/value pair if name does not exist.
     *
     * @param string $name
     * @param string $value
     * @param array $options
     * @return boolean
     */
    public function write($key, $value, $options = array())
    {
        $_options = array(
            'description' => '',
            'input_type' => '',
            'editable' => 0,
            'params' => '',
        );
        $options = array_merge($_options, $options);
        $setting = $this->findByName($key);
        if (isset($setting['Setting']['id'])) {
            $setting['Setting']['id'] = $setting['Setting']['id'];
            $setting['Setting']['value'] = $value;
            $setting['Setting']['description'] = $options['description'];
            $setting['Setting']['input_type'] = $options['input_type'];
            $setting['Setting']['editable'] = $options['editable'];
            $setting['Setting']['params'] = $options['params'];
        } else {
            $setting = array();
            $setting['name'] = $key;
            $setting['value'] = $value;
            $setting['description'] = $options['description'];
            $setting['input_type'] = $options['input_type'];
            $setting['editable'] = $options['editable'];
            $setting['params'] = $options['params'];
        }
        $this->id = false;
        if ($this->save($setting)) {
            Configure::write($key, $value);
            return true;
        } else {
            return false;
        }
    }
    /**
     * Deletes setting record for given key
     *
     * @param string $key
     * @return boolean
     */
    public function deleteKey($key)
    {
        $setting = $this->findByName($key);
        if (isset($setting['Setting']['id']) && $this->delete($setting['Setting']['id'])) {
            return true;
        }
        return false;
    }
    /**
     * All key/value pairs are made accessible from Configure class
     *
     * @return void
     */
    public function writeConfiguration()
    {
        $settings = $this->find('all', array(
            'fields' => array(
                'Setting.name',
                'Setting.value',
            ) ,
            'cache' => array(
                'name' => 'setting_write_configuration',
                'config' => 'setting_write_configuration',
            ) ,
			'recursive' => -1,
        ));
        foreach($settings AS $setting) {
            Configure::write($setting['Setting']['name'], $setting['Setting']['value']);
        }
    }
    /**
     * Find list and save yaml dump in app/config/settings.yml file.
     * Data required in bootstrap.
     *
     * @return void
     */
    public function updateYaml()
    {
        $list = $this->find('list', array(
            'fields' => array(
                'name',
                'value',
            ) ,
            'order' => array(
                'Setting.name' => 'ASC',
            ) ,
			'recursive' => -1
        ));
        $filePath = APP . 'Config' . DS . 'settings.yml';
        $file = new File($filePath, true);
        $listYaml = Spyc::YAMLDump($list, 4, 60);
        $file->write($listYaml);
    }
}
