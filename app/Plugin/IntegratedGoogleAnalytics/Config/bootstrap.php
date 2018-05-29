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
require_once 'constants.php';
CmsNav::add('analytics', array(
    'title' => __l('Analytics') ,
    'icon-class' => 'bar-chart',
	'weight' => 21,
    'children' => array(
        'google_analytics' => array(
            'title' => __l('Google Analytics') ,
            'url' => array(
                'admin' => true,
                'controller' => 'google_analytics',
                'action' => 'analytics_chart',
            ) ,
			'htmlAttributes' => array(
                'class' => 'js-no-pjax'
            ) ,
            'weight' => 10,
        ) ,
    )
));
CmsHook::setJsFile(array(
    APP . 'Plugin' . DS . 'IntegratedGoogleAnalytics' . DS . 'webroot' . DS . 'js' . DS . 'common.js'
) , 'default');
?>