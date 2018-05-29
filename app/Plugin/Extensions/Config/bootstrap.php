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
CmsNav::add('plugins', array(
    'title' => __l('Plugins') ,
    'weight' => 70,
    'data-bootstro-step' => '8',
    'data-bootstro-content' => __l('To manage all plugins and their settings.') ,
    'icon-class' => 'certificate',
    'children' => array(
        'plugins' => array(
            'title' => __l('Plugins') ,
            'url' => array(
                'controller' => 'extensions_plugins',
                'action' => 'index',
            ) ,
            'htmlAttributes' => array(
                'class' => 'separator',
            ) ,
            'weight' => 10,
        ) ,
    ) ,
));
