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
/* SVN FILE: $Id: routes.php 173 2009-01-31 12:51:40Z rajesh_04ag02 $ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7820 $
 * @modifiedby    $LastChangedBy: renan.saddam $
 * @lastmodified  $Date: 2008-11-03 23:57:56 +0530 (Mon, 03 Nov 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
CakePlugin::routes();
Router::parseExtensions('rss', 'csv', 'json', 'txt', 'xml', 'svg', 'js','css');
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
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
//	CmsRouter::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
//  pages/install as home page...
CmsRouter::connect('/how-it-works', array(
    'controller' => 'pages',
    'action' => 'how_it_works',
));
CmsRouter::connect('/pages/*', array(
	'controller' => 'pages',
	'action' => 'display'
));
CmsRouter::connect('/admin/pages/tools', array(
	'controller' => 'pages',
	'action' => 'display',
	'tools',
	'prefix' => 'admin',
	'admin' => true
));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
CmsRouter::connect('/admin', array(
    'controller' => 'users',
    'action' => 'stats',
    'prefix' => 'admin',
    'admin' => 1
));
//Code to show the images uploaded by upload behaviour
CmsRouter::connect('/img/:size/*', array(
    'controller' => 'images',
    'action' => 'view'
) , array(
    'size' => '(?:[a-zA-Z_]*)*'
));
CmsRouter::connect('/files/*', array(
    'controller' => 'images',
    'action' => 'view',
    'size' => 'original'
));
CmsRouter::connect('/img/*', array(
    'controller' => 'images',
    'action' => 'view',
    'size' => 'original'
));
CmsRouter::connect('/robots', array(
    'controller' => 'devs',
    'action' => 'robots'
));
CmsRouter::connect('/sitemap', array(
    'controller' => 'devs',
    'action' => 'sitemap'
));
CmsRouter::connect('/yadis', array(
    'controller' => 'devs',
    'action' => 'yadis'
));
CmsRouter::connect('/css/*', array(
	'controller' => 'devs',
	'action' => 'asset_css'
));
CmsRouter::connect('/js/*', array(
	'controller' => 'devs',
	'action' => 'asset_js'
));
CmsRouter::connect('/cron/:action/*', array(
    'controller' => 'crons',
));
CmsRouter::connect('/users/twitter/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'twitter'
));
CmsRouter::connect('/users/facebook/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'facebook'
));
CmsRouter::connect('/users/yahoo/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'yahoo'
));
CmsRouter::connect('/users/gmail/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'gmail'
));
CmsRouter::connect('/users/openid/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'openid'
));
CmsRouter::connect('/contactus', array(
    'controller' => 'contacts',
    'action' => 'add'
));
CmsRouter::connect('/dashboard', array(
    'controller' => 'users',
    'action' => 'dashboard',
));
CmsRouter::connect('/users/register', array(
    'controller' => 'users',
    'action' => 'register',
    'type' => 'social'
));
CmsRouter::connect('/users/register/manual', array(
    'controller' => 'users',
    'action' => 'register'
));
CmsRouter::connect('/r::username', array(
    'controller' => 'users',
    'action' => 'refer'
), array(
	'username' => '[^\/]*'
));
?>