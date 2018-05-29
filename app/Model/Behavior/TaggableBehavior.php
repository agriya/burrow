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
 * CounterCacheHabtmBehavior - add counter cache support for HABTM relations
 *
 * Based on CounterCacheBehavior by Derick Ng aka dericknwq
 *
 * @see http://bakery.cakephp.org/articles/view/counter-cache-behavior-for-habtm-relations
 * @author Yuri Pimenov aka Danaki (http://blog.gate.lv)
 * @version 2009-05-28
 */
class TaggableBehavior extends ModelBehavior
{
    var $foreignTableIDs = array();
    /**
     * For each HABTM association using given id, find related foreign ids
     * that represent in the join table. Save results to $foreignTableIDs array.
     *
     * @param mixed $model
     * @access private
     * @return void
     */
    function findForeignIDs(Model $model) 
    {
        foreach($model->hasAndBelongsToMany as $assocKey => $assocData) {
            $assocModel = &$model->{$assocData['className']};
            $field = Inflector::underscore($model->name) . '_count';
            if ($assocModel->hasField($field)) {
                $joinModel = &$model->{$assocData['with']};
                $joinIDs = $joinModel->find('all', array(
                    'fields' => array(
                        $assocData['associationForeignKey']
                    ) ,
                    'conditions' => array(
                        $assocData['foreignKey'] => $model->id
                    ) ,
                    'group' => $assocData['associationForeignKey']
                ));
                $this->foreignTableIDs[$assocData['className']] = array_keys(Set::combine($joinIDs, '{n}.' . $assocData['with'] . '.' . $assocData['associationForeignKey']));
            }
        }
    }
    /**
     * For each HABTM association, using ids from $foreignTableIDs array find
     * counts and update counter cache field in the associated table
     *
     * @param mixed $model
     * @access private
     * @return void
     */
    function updateCounters(Model $model) 
    {
        foreach($model->hasAndBelongsToMany as $assocKey => $assocData) if (isset($this->foreignTableIDs[$assocData['className']]) && $this->foreignTableIDs[$assocData['className']]) {
            $assocModel = &$model->{$assocData['className']};
            $joinModel = &$model->{$assocData['with']};
            $field = Inflector::underscore($model->name) . '_count';
            if ($assocModel->hasField($field)) {
                $saveArr = array();
                // in case of delete $rawCounts array may be empty -- update associated model anyway
                foreach($this->foreignTableIDs[$assocData['className']] as $assocId) $saveArr[$assocId] = array(
                    'id' => $assocId,
                    $field => 0
                );
                // if 'unique' set to false - update counter cache with the number of only unique pairs
                $rawCounts = $joinModel->find('all', array(
                    'fields' => array(
                        $assocData['associationForeignKey'],
                        ($assocData['unique'] ? 'COUNT(*)' : 'COUNT(DISTINCT ' . $assocData['associationForeignKey'] . ',' . $assocData['foreignKey'] . ')') . ' AS count'
                    ) ,
                    'conditions' => array(
                        $assocData['associationForeignKey'] => $this->foreignTableIDs[$assocData['className']]
                    ) ,
                    'group' => $assocData['associationForeignKey']
                ));
                $counts = Set::combine($rawCounts, '{n}.' . $assocData['with'] . '.' . $assocData['associationForeignKey'], '{n}.0.count');
                // override $saveArr with count() data
                foreach($counts as $assocId => $count) {
                    $saveArr[$assocId] = array(
                        'id' => $assocId,
                        $field => $count
                    );
                }
                $delArr = array();
                if (!empty($saveArr)) {
                    foreach($saveArr as $key => $value) {
                        if ($value[$field] == 0) {
                            $delArr[] = $value['id'];
                            unset($saveArr[$key]);
                        }
                    }
                }
                if (!empty($delArr)) {
                    $assocModel->deleteAll(array(
                        'id' => $delArr
                    ));
                }
                if (!empty($saveArr)) {
                    $assocModel->saveAll($saveArr, array(
                        'validate' => false,
                        'fieldList' => array(
                            $field
                        ) ,
                        'callbacks' => false
                    ));
                }
            }
        }
    }
    /**
     * On update fill $foreignTableIDs for each HABTM association from user form data
     *
     * @param mixed $model
     * @access public
     * @return boolean
     */
    function beforeSave(Model $model) 
    {
        foreach($model->hasAndBelongsToMany as $assocKey => $assocData) {
            $assocModel = &$model->{$assocData['className']};
            $field = Inflector::underscore($model->name) . '_count';
            if ($assocModel->hasField($field) && isset($model->data[$model->name]['tag'])) {
                if (!empty($model->id)) {
                    $this->findForeignIDs($model);
                    $model->data[$assocData['className']][$assocData['className']] = $this->_saveTags($model, $assocModel, $model->data[$model->name]['tag']);
                    if (isset($model->data[$assocData['className']]) && isset($model->data[$assocData['className']][$assocData['className']]) && is_array($model->data[$assocData['className']][$assocData['className']])) {
                        $this->foreignTableIDs[$assocData['className']] = Set::merge(isset($this->foreignTableIDs[$assocData['className']]) ? $this->foreignTableIDs[$assocData['className']] : array() , $model->data[$assocData['className']][$assocData['className']]);
                    }
                } else {
                    $model->data[$assocData['className']][$assocData['className']] = $this->_saveTags($model, $assocModel, $model->data[$model->name]['tag']);
                }
            }
        }
        return true;
    }
    /**
     * Update counter cache after all data saved
     *
     * @param mixed $model
     * @param boolean $created
     * @access public
     * @return void
     */
    function afterSave(Model $model, $created) 
    {
        if ($created) {
            foreach($model->hasAndBelongsToMany as $assocKey => $assocData) {
                $assocModel = &$model->{$assocData['className']};
                $field = Inflector::underscore($model->name) . '_count';
                if ($assocModel->hasField($field) && isset($model->data[$assocData['className']][$assocData['className']])) $this->foreignTableIDs[$assocData['className']] = $model->data[$assocData['className']][$assocData['className']];
            }
        }
        $this->updateCounters($model);
        foreach($model->hasAndBelongsToMany as $assocKey => $assocData) {
            $field = Inflector::underscore($assocKey) . '_count';
            if ($model->hasField($field)) {
                $joinModel = &$model->{$assocData['with']};
                // if 'unique' set to false - update counter cache with the number of only unique pairs
                $count = $joinModel->field(($assocData['unique'] ? 'COUNT(*)' : 'COUNT(DISTINCT ' . $assocData['associationForeignKey'] . ')') . ' AS count', array(
                    $assocData['foreignKey'] => $model->id
                ));
                $model->saveField($field, $count, array(
                    'validate' => false,
                    'callbacks' => false
                ));
            }
        }
        $this->foreignTableIDs = array();
		return true;
    }
    /**
     * Fill $foreignTableIDs array just before deletion
     *
     * @param mixed $model
     * @access public
     * @return boolean
     */
    function beforeDelete(Model $model, $cascade = true) 
    {
        $this->findForeignIDs($model);
        return true;
    }
    /**
     * Update counter cache after deletion
     *
     * @param mixed $model
     * @access public
     * @return void
     */
    function afterDelete(Model $model) 
    {
        $this->updateCounters($model);
        $this->foreignTableIDs = array();
		return true;
    }
    /**
     * Select tags
     *
     * @param mixed $model
     * @param array $conditions
     * @access public
     * @return tag cloud array
     */
    function selectTag(Model $model, $conditions = array()) 
    {
        $result = array();
        foreach($model->hasAndBelongsToMany as $assocKey => $assocData) {
            $assocModel = &$model->{$assocData['className']};
            $field = Inflector::underscore($model->name) . '_count';
            if ($assocModel->hasField($field)) {
                $Tags = $assocModel->find('all', array(
                    'conditions' => $conditions,
                    'fields' => array(
                        'id',
                        'name',
                        'slug',
                        $field,
                    ) ,
                    'order' => array(
                        $field => 'desc'
                    ) ,
                    'recursive' => -1,
                ));
                $tags = $map_count = array();
                if ($Tags) {
                    foreach($Tags as $key => $Tag) {
                        $tags[$key] = $Tag[$assocData['className']]['name'];
                        $map_count[] = $Tag[$assocData['className']][$field];
                    }
                    natcasesort($tags);
                    // creating class
                    $min_tag_classes = 1;
                    $max_tag_classes = 6;
                    $spread = max(array_values($map_count)) -min(array_values($map_count));
                    $spread = (0 == $spread) ? 1 : $spread;
                    $step = ($max_tag_classes-$min_tag_classes) /($spread);
                    foreach($tags as $key => $value) {
                        $size = ceil($min_tag_classes+(($Tags[$key][$assocData['className']][$field]-min(array_values($map_count))) *$step));
                        $Tags[$key][$assocData['className']]['class'] = 'tag' . $size;
                        $result[] = $Tags[$key];
                    }
                }
            }
        }
        return $result;
    }
    /**
     * Save tags
     *
     * @param mixed $model
     * @param mixed $model
     * @param comma separated tag string $tagNames
     * @access private
     * @return array of tag ids
     */
    function _saveTags(Model $model, &$assocModel, $tagNames = null) 
    {
        $tag_ids = array();
        if (!empty($tagNames)) {
            $tagNames = explode(',', $tagNames);
            foreach($tagNames as $tagName) {
                $tagName = trim($tagName);
                if (!empty($tagName)) {
                    $tags = $assocModel->find('first', array(
                        'conditions' => array(
                            'name =' => $tagName
                        ) ,
                        'fields' => array(
                            'id'
                        ) ,
                        'recursive' => -1
                    ));
                    if (!empty($tags)) {
                        $tag_ids[] = $tags[$assocModel->name]['id'];
                    } else {
                        $data[$assocModel->name]['name'] = $tagName;
                        $assocModel->create();
                        if ($assocModel->save($data)) {
                            $tag_ids[] = $assocModel->id;
                        }
                    }
                }
            }
        }
        return $tag_ids;
    }
    /**
     * format Tags
     *
     * @param mixed $model
     * @param array $tags
     * @access public
     * @return comma separated tag string for a give tags array
     */
    function formatTags(Model $model, $tags) 
    {
        $commaSeperatedTags = array();
        //Procsssing the tags for ModelnameTag (eg., PhotoTag) key in 1st domenstion of array
        if (isset($tags[0][$model->name . 'Tag']) or !empty($tags[0][$model->name . 'Tag'])) {
            foreach($tags as $tag) {
                if (!empty($tag[$model->name . 'Tag'])) {
                    $commaSeperatedTags[][$model->name . 'Tag'] = $this->formatTags($model, $tag[$model->name . 'Tag']);
                } else {
                    $commaSeperatedTags[][$model->name . 'Tag'] = array();
                }
            }
            return $commaSeperatedTags;
        }
        $commaSeperatedTags = '';
        if (!empty($tags)) {
            foreach($tags as $tag) {
                $commaSeperatedTags.= $tag['name'] . ', ';
            }
            $commaSeperatedTags = substr($commaSeperatedTags, 0, -2);
        }
        return $commaSeperatedTags;
    }
}
?>