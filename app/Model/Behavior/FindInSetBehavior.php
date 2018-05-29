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
 * FindInSet - add set to show filter count in list
 *
 */
class FindInSetBehavior extends ModelBehavior
{
	function setup(Model $model, $settings = array())
    {
		$default = array(
            'setModel' => array(),
            'setKey' => Inflector::tableize($model->alias) . '_set',
			'setField' => array()
        );
        if (!isset($this->__settings[$model->alias])) {
            $this->__settings[$model->alias] = $default;
        }
        $this->__settings[$model->alias] = array_merge($this->__settings[$model->alias], (is_array($settings) ? $settings : array()));
    }
    function afterSave(Model $model, $created)
    {
		if ($created && !empty($this->__settings[$model->alias]['setModel'])) {
			$this->_updateSet($model);
		} elseif (!empty($this->__settings[$model->alias]['setField'])) {
			$this->_updateField($model);
		}
		return true;
    }
	function afterDelete(Model $model)
    {
		if (!empty($this->__settings[$model->alias]['setModel'])) {
			$this->_updateSet($model);
		}
		return true;
    }
	function _updateSet(Model $model)
	{
		$sets = $model->find('list');
		$set = '\'' . implode('\', \'', array_keys($sets)) . '\'';
		foreach($this->__settings[$model->alias]['setModel'] as $set_model) {
			$model->query('ALTER TABLE ' . Inflector::tableize($set_model) . ' CHANGE ' . $this->__settings[$model->alias]['setKey'] . ' ' . $this->__settings[$model->alias]['setKey'] . ' SET(' . $set . ') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL');
		}
	}
	function _updateField(Model $model)
	{
		foreach($this->__settings[$model->alias]['setField'] as $set_field) {
			if (!empty($model->data[$set_field][$set_field])) {
				$model_id = !empty($model->data[$model->alias]['id']) ? $model->data[$model->alias]['id'] : $model->id;
				$model->query('UPDATE `' . Inflector::tableize($model->alias) . '` SET `' . Inflector::tableize($set_field) . '_set' . '` = ' . "'" . implode(',', $model->data[$set_field][$set_field]) . "'" . ' WHERE `id` = ' . $model_id);
			}
		}
	}
	function getFilterCount(Model $model, $conditions)
	{
		if (!empty($this->__settings[$model->alias]['setField'])) {
			$set_fields_arr = array();
			foreach($this->__settings[$model->alias]['setField'] as $set_field) {
				$lists = $model->{$set_field}->find('list');
				$list_table = Inflector::tableize($set_field);
				foreach($lists as $list_id => $list) {
					$set_fields_arr[] = 'SUM(SIGN(FIND_IN_SET(' . $list_id . ', ' . $list_table . '_set))) as ' . $list_table . '_' . $list_id;
				}
			}
			if (!empty($set_fields_arr)) {
				$sets = $model->find('all', array(
					'conditions' => $conditions,
					'fields' => $set_fields_arr,
					'recursive' => -1
				));
			}
			return $sets[0][0];
		}
	}
}
?>