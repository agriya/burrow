<?php
// http://bin.cakephp.org/view/678922867
/* SVN FILE: $Id: list.php 199 2009-03-23 07:18:35Z rajesh_04ag02 $ */

/**
 * List Behavior
 *
 * Heavly based on the work done by "Kim Biesbjerg", a behavior to make
 * re-ordering models easier.
 *
 * PHP versions 5
 *
 * acmConsulting <www.acmconsulting.eu>
 *
 * Copyright 2006-2008, acmConsulting
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author 			Alex McFadyen (alex@acmconsulting.eu)
 *
 * @copyright		Copyright 2006-2008, acmConsulting
 * @link				http://www.acmconsulting.eu acmConsulting
 *
 * @package    	app
 * @subpackage		models.behaviours
 *
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 *
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class ListBehavior extends ModelBehavior
{
 /**
  * Array containing the basic settings.
  * field = The name of the numeric field that represents the order of the elements (0 = top)
  * position = Where newly inserted items are added
  * groups = An array of fields by which the models are grouped for ordering
  * 				e.g. 	user_id - only models with the same user_id are ordered against each
  * 						other, allowing each user to maintain a list independandtly
  *
  * @var $defaultSettings
  * @access public
  */
	var $defaultSettings = array(
		'field' => 'display_order',
		'position' => 'bottom',
		'groups' => array()
	);


	/**
     * Initiate behaviour for the model using specified settings.
     *
     * @param object $model		Model using the behaviour
     * @param array 	$config		Settings to override for model.
     *
     * @access public
     */
	function setup(Model $model, $config = array())
	{
		$this->settings[$model->name] = am($this->defaultSettings, $config);
		extract($this->settings[$model->name]);
		if(!$model->hasField($field))
		{
			user_error("Model {$model->name} does not have a field called {$field}", E_USER_ERROR);
		}

		if(!empty($groups)){
			foreach($groups as $group_field){
				if(!$model->hasField($group_field)){
					user_error("Model {$model->name} does not have a field called {$group_field}", E_USER_ERROR);
				}
			}

		}
	}

	/**
     * Run before a model is saved, checks if the model is new, if it is, it generates
     * the apropreate order field number
     *
     * @param object $model    Model about to be saved.
     *
     * @access public
     */
	function beforeSave(Model $model)
	{
		extract($this->settings[$model->name]);

		if(empty($model->{$model->primaryKey}))
		{
			$conditions = $this->_get_conditions($model);
			if($position == 'top')
			{
				$model->updateAll(array($field => "`$field` + 1"), $conditions);
				$model->data[$model->name][$field] = 0;
			}
			else
			{
				$conditions = $this->_get_conditions($model);
				$max = $model->field('MAX('.$model->primaryKey.')', $conditions);
				$model->data[$model->name][$field] = $max + 1;
			}
		}
	}
	/**
     * Moves a selected model up one space
     *
     * @param object $model    	Model about to be deleted.
     * @param int	$id				Id of the model to be moved
     *
     * @access public
     */
	function moveUp(Model $model, $id)
	{
		extract($this->settings[$model->name]);

		$model->read(null,$id);
		$conditions = $this->_get_conditions($model, $id);

		/**
		 * Find position for the record we want to move up
		 */
		$item = $model->find(
			$conditions,
			array("{$model->name}.{$model->primaryKey}", "{$model->name}.{$field}"), null, 0);

		/**
		 * Find record above the record we want to move up
		 */
		unset($conditions["{$model->name}.{$model->primaryKey}"]);
		$conditions["{$model->name}.{$field}"] = "< {$item[$model->name][$field]}";

		$itemAbove = $model->find(
			$conditions,
			array("{$model->name}.{$model->primaryKey}", "{$model->name}.{$field}"), "{$model->name}.{$field} DESC", 0);

		/**
		 * If any records above do a position swap
		 */
		if($itemAbove)
		{
			$model->set($item);
			$model->saveField($field, $itemAbove[$model->name][$field]);
			$model->set($itemAbove);
			$model->saveField($field, $item[$model->name][$field]);
			return true;
		}
		return false;
	}


	/**
     * Moves a selected model down one space
     *
     * @param object $model    	Model about to be deleted.
     * @param int	$id				Id of the model to be moved
     *
     * @access public
     */
	function moveDown(Model $model, $id)
	{
		extract($this->settings[$model->name]);

		$model->read(null,$id);
		$conditions = $this->_get_conditions($model, $id);

		/**
		 * Find position for the record we want to move down
		 */
		$item = $model->find(
			$conditions,
			array("{$model->name}.{$model->primaryKey}", "{$model->name}.{$field}"), null, 0);

		/**
		 * Find record below the record we want to move down
		 */
		unset($conditions["{$model->name}.{$model->primaryKey}"]);
		$conditions["{$model->name}.{$field}"] = "> {$item[$model->name][$field]}";

		$itemBelow = $model->find(
			$conditions,
			array("{$model->name}.{$model->primaryKey}", "{$model->name}.{$field}"), "{$model->name}.{$field} ASC", 0);

		/**
		 * If any records below do a position swap
		 */
		if($itemBelow)
		{
			$model->set($item);
			$model->saveField($field, $itemBelow[$model->name][$field]);
			$model->set($itemBelow);
			$model->saveField($field, $item[$model->name][$field]);
			return true;
		}
		return false;
	}


	/**
     * Moves a selected model to a place in the list and updates the rest of the list.
     *
     * @param object $model    	Model about to be deleted.
     * @param int	$id				Id of the model to be moved
     * @param int $target_id		Where the model is to move infront of (-1 is end);
     *
     * @access public
     *
     * @todo Test (NOT WORKING), add check that model exsists.
     */
	function moveTo(Model $model, $id, $target_position)
	{
		extract($this->settings[$model->name]);

		$model->read(null,$id);
		$conditions = $this->_get_conditions($model, $id);

		/**
		 * Find position for the record we want to move up
		 */
		$item = $model->find(
			$conditions,
			array("{$model->name}.{$model->primaryKey}", "{$model->name}.{$field}"), null, 0);

		$old_position = $item[$model->name][$field];

		/*
		 * get correct $target_position
		 */
		unset($conditions["{$model->name}.{$model->primaryKey}"]);

		$item = $model->find($conditions, $field, "$model->name.$field DESC", 0);
		$end = $item[$model->name][$field] + 1;

		if($target_position == -1 OR $target_position >= $end){ //wants to be at the end.
			$model->data[$model->name][$field] = $end;
		}else{
			$model->data[$model->name][$field] = $target_position;
		}


		$conditions = $this->_get_conditions($model);
		//if its moving up
		if($target_position < $old_position){
			/*
			 * Everything above(less than) old position and bellow(grater than) or equal to target position needs +1
			 */
			$conditions[][$field] = "< $old_position";
			$conditions[][$field] = ">= $target_position";
			$model->updateAll(array($field => "`$field` + 1"), $conditions);
		}else{ //going down
			/*
			 * Everything belowe(greater than) old position and above(less than) or equal to target position needs -1
			 */
			$conditions[][$field] = "> $old_position";
			$conditions[][$field] = "<= $target_position";
			$model->updateAll(array($field => "`$field` - 1"), $conditions);
		}
		$model->save();
		die();
	}




	/**
	 * Helper function to generate conditions for selection.
	 *
	 * @param  	object 	$model
	 * @param 	int		$id
	 * @return	array		$conditions
	 */
	function _get_conditions(Model $model, $id = null)
	{
		$conditions = array();
		if($id != null){
			$conditions["{$model->name}.{$model->primaryKey}"] = $id;

			if(!empty($this->settings[$model->name]['groups'])){
				foreach($this->settings[$model->name]['groups'] as $item){
					$conditions["{$model->name}.$item"] = $model->data[$model->name][$item];
				}
			}
		}else{
			if(!empty($this->settings[$model->name]['groups'])){
				foreach($this->settings[$model->name]['groups'] as $item){
					$conditions[$item] = $model->data[$model->name][$item];
				}
			}
		}

		return $conditions;
	}
}
?>
