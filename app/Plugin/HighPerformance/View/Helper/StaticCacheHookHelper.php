<?php
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
App::uses('StaticCacheBaseHelper', 'HighPerformance.View/Helper');
/**
 * HtmlCacheHookHelper class
 *
 * @uses          HtmlCacheBaseHelper
 * @package       html_cache
 * @subpackage    html_cache.views.helpers
 */
class StaticCacheHookHelper extends StaticCacheBaseHelper
{
    /**
     * isCachable method
     *
     * @return void
     * @access protected
     */
    protected function _isCachable() 
    {
        if ($this->params['controller'] != 'pages' || !empty($this->params['admin'])) {
            return false;
        }
        return parent::_isCachable();
    }
}
