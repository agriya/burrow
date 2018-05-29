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
 * Polymorphic Behavior.
 *
 * Allow the model to be associated with any other model object
 *
 * PHP versions 4 and 5
 *
 * Copyright (c) 2008, Andy Dawson
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright (c) 2008, Andy Dawson
 * @link          www.ad7six.com
 * @package       base
 * @subpackage    base.models.behaviors
 * @since         v 0.1
 * @version       $Revision: 689 $
 * @modifiedby    $LastChangedBy: AD7six $
 * @contributor   $Subin@Dev1 $
 * @lastmodified  $Date: 2010-19-02 11:30:07 +0100 (Fri, 19 Feb 2010) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * PolymorphicBehavior class
 *
 * @uses          ModelBehavior
 * @package       base
 * @subpackage    base.models.behaviors
 */
class PolymorphicBehavior extends ModelBehavior
{
    /**
     * defaultSettings property
     *
     * @var array
     * @access protected
     */
    var $_defaultSettings = array(
        'classField' => 'class',
        'foreignKey' => 'foreign_id'
    );
    /**
     * setup method
     *
     * @param mixed $model
     * @param array $config
     * @return void
     * @access public
     */
    function setup(Model $model, $config = array())
    {
        $this->settings[$model->alias] = am($this->_defaultSettings, $config);
    }
    /**
     * afterFind method
     *
     * @param mixed $model
     * @param mixed $results
     * @param bool $primary
     * @access public
     * @return void
     */
    function afterFind(Model $model, $results, $primary = false)
    {
        extract($this->settings[$model->alias]);
        if ($primary && isset($results[0][$model->alias][$classField]) && $model->recursive > 0) {
            foreach($results as $key => $result) {
                $associated = array();
                $class = Inflector::classify($result[$model->alias][$classField]);
                $foreignId = $result[$model->alias][$foreignKey];
                if ($class && $foreignId) {
                    $result = $result[$model->alias];
                    if (!isset($model->$class)) {
                        $model->bindModel(array(
                            'belongsTo' => array(
                                $class => array(
                                    'conditions' => array(
                                        $model->alias . '.' . $classField => $class
                                    ) ,
                                    'foreignKey' => $foreignKey
                                )
                            )
                        ));
                    }
                    $conditions = array(
                        $class . '.id' => $foreignId
                    );
                    $recursive = $model->recursive - 1;
                    $associated = $model->$class->find('first', compact('conditions', 'recursive'));
                    $name = $model->$class->find('list', compact('conditions'));
                    if (!empty($name[$foreignId])) // fix to Skip the 'list,count... ' etc from polymorphic Fix by Subin
                    {
                        $associated[$class]['display_field'] = $name[$foreignId];
                        // Added to include the Recurisve level of polymorphic parant
                        // This simply appedning all the susbarrys to polymorphic parant
                        // Fix by Subin
                        foreach($associated as $sub_module => $sub_associated) {
                            if ($sub_module != $class) {
                                $associated[$class][$sub_module] = $sub_associated;
                            }
                        }
                        $results[$key][$class] = $associated[$class];
                    }
                }
            }
        } elseif (isset($results[$model->alias][$classField])) {
            $associated = array();
            $class = $results[$model->alias][$classField];
            $foreignId = $results[$model->alias][$foreignKey];
            if ($class && $foreignId) {
                $result = $results[$model->alias];
                if (!isset($model->$class)) {
                    $model->bindModel(array(
                        'belongsTo' => array(
                            $class => array(
                                'conditions' => array(
                                    $model->alias . '.' . $classField => $class
                                ) ,
                                'foreignKey' => $foreignKey
                            )
                        )
                    ));
                }
                $associated = $model->$class->find(array(
                    $class . '.id' => $foreignId
                ) , array(
                    'recursive' => -1
                ));
                $associated[$class]['display_field'] = $associated[$class][$model->$class->displayField];
                $results[$class] = $associated[$class];
            }
        }
        return $results;
    }
}
?>