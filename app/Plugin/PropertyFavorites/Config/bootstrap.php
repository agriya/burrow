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
CmsNav::add('activities', array(
    'title' => __l('Activities') ,
    'icon-class' => 'time',
    'weight' => 60,
    'children' => array(
		 'property' => array(
					'title' => __l('Properties') ,
					'url' => '',
					'weight' => 40,
				 ) ,
				'property_favorites' => array(
					'title' => __l('Property Favorites') ,
					'url' => array(
						'admin' => true,
						'controller' => 'property_favorites',
						'action' => 'index',
					) ,
					'weight' => 60,
				),
			),
		));
