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
CmsRouter::connect('/requests/favorites', array(
    'controller' => 'requests',
    'action' => 'index',
    'type' => 'favorite'
));
CmsRouter::connect('/myrequests', array(
    'controller' => 'requests',
    'action' => 'index',
    'type' => 'myrequest',
	'status' => 'active',
));
?>