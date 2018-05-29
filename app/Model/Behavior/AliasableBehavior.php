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
class AliasableBehavior extends ModelBehavior
{
    protected $_byIds = array();
    protected $_byAlias = array();
    public function setup(Model $model, $config = array())
    {
        $config = Set::merge(array(
            'id' => 'id',
            'alias' => 'alias',
        ) , $config);
        $this->settings[$model->alias] = $config;
        $this->reload($model);
    }
    public function reload(Model $model)
    {
        $config = $this->settings[$model->alias];
        $this->_byIds[$model->alias] = $model->find('list', array(
            'fields' => array(
                $config['id'],
                $config['alias']
            ) ,
            'conditions' => array(
                $model->alias . '.' . $config['alias'] . ' != ' => '',
            ) ,
			'recursive' => -1,
        ));
        $this->_byAlias[$model->alias] = array_flip($this->_byIds[$model->alias]);
    }
    public function byId(Model $model, $id)
    {
        if (!empty($this->_byIds[$model->alias][$id])) {
            return $this->_byIds[$model->alias][$id];
        }
        return false;
    }
    public function byAlias(Model $model, $alias)
    {
        if (!empty($this->_byAlias[$model->alias][$alias])) {
            return $this->_byAlias[$model->alias][$alias];
        }
        return false;
    }
    public function listById(Model $model)
    {
        return $this->_byIds[$model->alias];
    }
    public function listByAlias(Model $model)
    {
        return $this->_byAlias[$model->alias];
    }
}
