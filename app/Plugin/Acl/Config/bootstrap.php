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
CmsHook::setCssFile(array(
    APP . 'Plugin' . DS . 'Acl' . DS . 'webroot' . DS . 'css' . DS . 'acl.css'
) , 'admin');
CmsHook::setJsFile(array(
    APP . 'Plugin' . DS . 'Acl' . DS . 'webroot' . DS . 'js' . DS . 'common.js'
) , 'default');
