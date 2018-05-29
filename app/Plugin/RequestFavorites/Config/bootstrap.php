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
		 'request' => array(
					'title' => __l('Requests') ,
					'url' => '',
					'weight' => 90,
				 ) ,
				'request_favorites' => array(
					'title' => __l('Request Favorites') ,
					'url' => array(
						'admin' => true,
						'controller' => 'request_favorites',
						'action' => 'index',
					) ,
					'weight' => 100,
				),
			),
		));
