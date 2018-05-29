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
$controllers = Cache::read('controllers_list', 'default');
if ($controllers === false) {
    $controllers = App::objects('controller');
    foreach($controllers as &$value) {
        $value = Inflector::underscore($value);
    }
    foreach($controllers as $value) {
        $controllers[] = Inflector::singularize($value);
    }
    array_push($controllers, 'admin');
    $controllers = implode('|', $controllers);
    Cache::write('controllers_list', $controllers);
}
CmsRouter::connect('/feeds', array(
    'controller' => 'properties',
    'action' => 'index',
    'plugin' => 'properties',
    'ext' => 'rss',
));
CmsRouter::connect('/', array(
    'controller' => 'properties',
    'action' => 'search',
));
CmsRouter::connect('/properties/guest', array(
    'controller' => 'properties',
    'action' => 'datafeed'
) , array(
    'method' => 'guest',
    'startdate' => '[0-9\-]+',
    'enddate' => '[0-9\-]+',
    'property_id' => '[0-9\-]+',
    'year' => '[0-9\-]+',
    'month' => 'a-zA-Z]+',
));
CmsRouter::connect('/myproperties', array(
    'controller' => 'properties',
    'action' => 'index',
    'type' => 'myproperties',
));
CmsRouter::connect('/map', array(
    'controller' => 'properties',
    'action' => 'map',
));
CmsRouter::connect('/calendar', array(
    'controller' => 'property_users',
    'action' => 'index',
    'type' => 'myworks',
    'status' => 'waiting_for_acceptance',
));
CmsRouter::connect('/trips', array(
    'controller' => 'property_users',
    'action' => 'index',
    'type' => 'mytours',
    'status' => 'in_progress',
));
CmsRouter::connect('/properties/favorites', array(
    'controller' => 'properties',
    'action' => 'index',
    'type' => 'favorite'
));
CmsRouter::connect('/:city/properties', array(
    'controller' => 'properties',
    'action' => 'index'
) , array(
    'city' => '(?!' . $controllers . ')[^\/]*'
));
CmsRouter::connect('/activity/:order_id', array(
    'controller' => 'messages',
    'action' => 'activities',
) , array(
    'order_id' => '[0-9]+'
));
CmsRouter::connect('/collection/:slug', array(
    'controller' => 'properties',
    'action' => 'index',
	'type' => 'collection',
) , array(
    'slug' => '[^\/]*'
));
?>