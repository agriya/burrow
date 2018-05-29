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
class CmsHook
{
    public static function setExceptionUrl($exception)
    {
        Configure::write('site.exception_array', Set::merge(Configure::read('site.exception_array') , $exception));
    }
    public static function setCssFile($cssFiles, $layout = 'default')
    {
        Configure::write('site.' . $layout . '.css_files', Set::merge(Configure::read('site.' . $layout . '.css_files') , $cssFiles));
    }
    public static function setJsFile($jsFiles, $layout = 'default')
    {
        Configure::write('site.' . $layout . '.js_files', Set::merge(Configure::read('site.' . $layout . '.js_files') , $jsFiles));
    }
    public static function setSitemapModel($models)
    {
        Configure::write('sitemap.models', Set::merge(Configure::read('sitemap.models') , $models));
    }
    public static function bindModel($associations)
    {
        Configure::write('Hook.bind_associations', Set::merge(Configure::read('Hook.bind_associations') , $associations));
    }
    public static function applyBindModel($object)
    {
        $objectName = empty($object->name) ? get_class($object) : $object->name;
        if (Configure::read('Hook.bind_associations.' . $objectName)) {
            foreach($object->_associations as $association) {
                if (Configure::read('Hook.bind_associations.' . $objectName . '.' . $association)) {
                    $object->{$association} = Set::merge($object->{$association}, Configure::read('Hook.bind_associations.' . $objectName . '.' . $association));
                }
            }
        }
    }
}
