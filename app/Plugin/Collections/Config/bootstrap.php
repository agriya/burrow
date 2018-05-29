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
 CmsHook::setExceptionUrl(array(
	'collections/index',
 ));
CmsNav::add('properties', array(
'title' => __l('Properties') ,
    'url' => '' ,
    'weight' => 30,
    'children' => array(
        'Collection' => array(
            'title' => __l('Collections') ,
            'url' => '' ,
            'weight' => 50,
        ),'Collections' => array(
            'title' => __l('Collections') ,
            'url' => array(
                'controller' => 'collections',
                'action' => 'index',
            ) ,
            'weight' => 60,
        ),
		'Add Collection' => array(
            'title' => __l('Add Collection') ,
            'url' => array(
                'controller' => 'collections',
                'action' => 'add',
            ) ,
            'weight' => 70,
        )
    ) ,
));
$defaultModel = array(
	'Property' => array(
		'hasAndBelongsToMany' => array(
			'Collection' => array(
				'className' => 'Collections.Collection',
				'joinTable' => 'collections_properties',
				'foreignKey' => 'property_id',
				'counterCache' => true,
				'associationForeignKey' => 'collection_id',
				'unique' => true,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			)
		),
    ) ,	
);
CmsHook::bindModel($defaultModel);
