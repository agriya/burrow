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
class CmsTheme extends Object
{
    /**
     * Constructor
     */
    public function __construct() 
    {
        $this->Setting = ClassRegistry::init('Setting');
    }
    /**
     * Get theme aliases (folder names)
     *
     * @return array
     */
    public function getThemes() 
    {
        $themes = array(
            'default' => 'default',
        );
        $this->folder = new Folder;
        $viewPaths = App::path('views');
        foreach($viewPaths as $viewPath) {
            $this->folder->path = $viewPath . 'Themed';
            $themeFolders = $this->folder->read();
            foreach($themeFolders['0'] as $themeFolder) {
                $this->folder->path = $viewPath . 'Themed' . DS . $themeFolder . DS . 'webroot';
                $themeFolderContent = $this->folder->read();
                if (in_array('theme.json', $themeFolderContent['1'])) {
                    $themes[$themeFolder] = $themeFolder;
                }
            }
        }
        return $themes;
    }
    /**
     * Get the content of theme.json file from a theme
     *
     * @param string $alias theme folder name
     * @return array
     */
    public function getData($alias = null) 
    {
        if ($alias == null || $alias == 'default') {
            $manifestFile = WWW_ROOT . 'theme.json';
        } else {
            $viewPaths = App::path('views');
            foreach($viewPaths as $viewPath) {
                if (file_exists($viewPath . 'Themed' . DS . $alias . DS . 'webroot' . DS . 'theme.json')) {
                    $manifestFile = $viewPath . 'Themed' . DS . $alias . DS . 'webroot' . DS . 'theme.json';
                    continue;
                }
            }
            if (!isset($manifestFile)) {
                $manifestFile = WWW_ROOT . 'theme.json';
            }
        }
        if (isset($manifestFile) && file_exists($manifestFile)) {
            $themeData = json_decode(file_get_contents($manifestFile) , true);
            if ($themeData == null) {
                $themeData = array();
            }
        } else {
            $themeData = array();
        }
        return $themeData;
    }
    /**
     * Get the content of theme.json file from a theme
     *
     * @param string $alias theme folder name
     * @return array
     * @deprecated use getData()
     */
    public function getThemeData($alias = null) 
    {
        return $this->getData($alias);
    }
    /**
     * Activate theme $alias
     * @param $alias theme alias
     * @return mixed On success Setting::$data or true, false on failure
     */
    public function activate($alias) 
    {
        if ($alias == 'default' || $alias == null) {
            $alias = '';
        }
        $js_files = glob(JS . '*.cache.*');
        $css_files = glob(CSS . '*.cache.*');
        $cache_files = array_merge($js_files, $css_files);
        foreach($cache_files as $file) {
            @unlink($file);
        }
        @unlink(WWW_ROOT . 'index.html');
        return $this->Setting->write('site.theme', $alias);
    }
}
