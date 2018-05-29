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
/*
* HtmlCache Plugin - Hooked for Croogo CMS (http://croogo.org/)
* Copyright (c) 2009 Matt Curry
* http://pseudocoder.com
* http://github.com/mcurry/html_cache
*
* @author        mattc <matt@pseudocoder.com>
* @license       MIT
*
*/
/**
 * HtmlCacheHookComponent class
 *
 * @uses          Object
 * @package       html_cache
 * @subpackage    html_cache.controllers.components
 */
class StaticCacheHookComponent extends Component
{
    /**
     * clearActions property
     *
     * @var array
     * @access public
     */
    public $clearActions = array(
        'add',
        'edit',
        'admin_add',
        'admin_edit',
        'delete',
        'admin_delete'
    );
    /**
     * startup method
     *
     * @param mixed $controller
     * @return void
     * @access public
     */
    public function startup(Controller $controller) 
    {
        if ($controller->data && in_array($controller->action, $this->clearActions)) {
            App::uses('Folder', 'Utility');
            $Folder = new Folder();
            $Folder->delete(WWW_ROOT . 'cache' . DS . 'd');
            $Folder->delete(WWW_ROOT . 'cache' . DS . 'm');
        }
    }
}
