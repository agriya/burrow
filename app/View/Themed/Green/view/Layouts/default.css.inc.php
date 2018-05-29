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
$css_files = array(
    APP . 'View' . DS . 'Themed' . DS . 'Green' . DS . 'webroot' . DS . 'css' . DS . 'dev1bootstrap.less',
    APP . 'View' . DS . 'Themed' . DS . 'Green' . DS . 'webroot' . DS . 'css' . DS . 'responsive.less',
    APP . 'View' . DS . 'Themed' . DS . 'Green' . DS . 'webroot' . DS . 'css' . DS . 'bootstrap-datetimepicker.min.css',
    APP . 'View' . DS . 'Themed' . DS . 'Green' . DS . 'webroot' . DS . 'css' . DS . 'ui.slider.extras.css',
    APP . 'View' . DS . 'Themed' . DS . 'Green' . DS . 'webroot' . DS . 'css' . DS . 'calendar.css',
    APP . 'View' . DS . 'Themed' . DS . 'Green' . DS . 'webroot' . DS . 'css' . DS . 'jquery-ui-1.10.3.custom.css',
    APP . 'View' . DS . 'Themed' . DS . 'Green' . DS . 'webroot' . DS . 'css' . DS . 'flag.css',
);
$css_files = Set::merge($css_files, Configure::read('site.default.css_files'));
?>