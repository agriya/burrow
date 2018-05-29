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
 * Default Acl plugin.  Custom Acl plugin should override this value.
 */
Configure::write('Site.acl_plugin', 'Acl');
/**
 * Locale
 */
Configure::write('Config.language', 'eng');
/**
 * Admin theme
 */
//Configure::write('Site.admin_theme', 'sample');

/**
 * Cache configuration
 */
$cacheConfig = array(
    'duration' => '+1 hour',
    'path' => CACHE . 'queries',
    'engine' => 'File',
);
// models
Cache::config('setting_write_configuration', $cacheConfig);
// components
Cache::config('cms_blocks', $cacheConfig);
Cache::config('cms_menus', $cacheConfig);
Cache::config('cms_nodes', $cacheConfig);
Cache::config('cms_types', $cacheConfig);
Cache::config('cms_vocabularies', $cacheConfig);
// controllers
Cache::config('nodes_view', $cacheConfig);
Cache::config('nodes_promoted', $cacheConfig);
Cache::config('nodes_term', $cacheConfig);
Cache::config('nodes_index', $cacheConfig);
Cache::config('contacts_view', $cacheConfig);
/**
 * Failed login attempts
 *
 * Default is 5 failed login attempts in every 5 minutes
 */
Configure::write('User.failed_login_limit', 5);
Configure::write('User.failed_login_duration', 300);
Cache::config('users_login', array_merge($cacheConfig, array(
    'duration' => '+' . Configure::read('User.failed_login_duration') . ' seconds',
)));
/**
 * Plugins
 */
$aclPlugin = Configure::read('Site.acl_plugin');
$pluginBootstraps = Configure::read('Hook.bootstraps');
$plugins = array_filter(explode(',', $pluginBootstraps));
if (!in_array($aclPlugin, $plugins)) {
    $plugins = Set::merge($aclPlugin, $plugins);
}
if ($hp = array_search('HighPerformance', $plugins)) {
	$plugins = array($hp => $plugins[$hp]) + $plugins;
}
foreach($plugins AS $plugin) {
    $pluginName = Inflector::camelize($plugin);
    if (!file_exists(APP . 'Plugin' . DS . $pluginName)) {
        CakeLog::write(LOG_ERR, 'Plugin not found during bootstrap: ' . $pluginName);
        continue;
    }
    $bootstrapFile = APP . 'Plugin' . DS . $pluginName . DS . 'Config' . DS . 'bootstrap.php';
    $bootstrap = file_exists($bootstrapFile);
    $routesFile = APP . 'Plugin' . DS . $pluginName . DS . 'Config' . DS . 'routes.php';
    $routes = file_exists($routesFile);
    $option = array(
        $pluginName => array(
            'bootstrap' => $bootstrap,
            'routes' => $routes,
        )
    );
    CmsPlugin::load($option);
    _pluginControllerCache($pluginName);
}
_pluginControllerCache('Extensions');
function _pluginControllerCache($pluginName)
{
    $plugins_controllers = Cache::read($pluginName . '_controllers_list', 'long');
    if ($plugins_controllers != 'null' || $plugins_controllers === false) {
        $plugins_controllers = App::objects($pluginName . '.Controller');
        foreach($plugins_controllers as & $value) {
            $value = '\/' . str_replace('_controller', '', Inflector::underscore($value));
        }
        foreach($plugins_controllers as $key) {
            $plugins_controllers[] = Inflector::singularize($key) . '\/';
        }
        $plugins_controllers = implode('|', $plugins_controllers);
        Cache::write($pluginName . '_controllers_list', $plugins_controllers, 'long');
    }
    Configure::write('plugins.' . strtolower(Inflector::underscore($pluginName)) , $plugins_controllers);
}
CmsEventManager::loadListeners();
