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
App::uses('Folder', 'Utility');
class ExtensionsInstaller
{
    /**
     * Cache last retrieved plugin names for paths
     *
     * @var array
     */
    protected $_pluginName = array();
    /**
     * Cache last retrieved theme names for paths
     *
     * @var array
     */
    protected $_themeName = array();
    /**
     * Holds the found root paths of checked zip file
     *
     * @var array
     */
    protected $_rootPath = array();
    /**
     * Get Plugin Name from zip file
     *
     * @param string $path Path to zip file of plugin
     * @return string Plugin name
     * @throws CakeException
     */
    public function getPluginName($path = null) 
    {
        if (empty($path)) {
            throw new CakeException(__l('Invalid plugin path'));
        }
        if (isset($this->_pluginName[$path])) {
            return $this->_pluginName[$path];
        }
        $Zip = new ZipArchive;
        if ($Zip->open($path) === true) {
            $searches = array(
                'Config*Activation',
                'Controller*AppController',
                'Model*AppModel',
                'View*AppHelper',
            );
            for ($i = 0; $i < $Zip->numFiles; $i++) {
                $file = $Zip->getNameIndex($i);
                foreach($searches as $search) {
                    $search = str_replace('*', '\/([\w]+)', $search);
                    if (preg_match('/' . $search . '\.php/', $file, $matches)) {
                        $plugin = trim($matches[1]);
                        $this->_rootPath[$path] = str_replace($matches[0], '', $file);
                        break 2;
                    }
                }
            }
            $Zip->close();
            if (!$plugin) {
                throw new CakeException(__l('Invalid plugin'));
            }
            $this->_pluginName[$path] = $plugin;
            return $plugin;
        } else {
            throw new CakeException(__l('Invalid zip archive'));
        }
        return false;
    }
    /**
     * Extract a plugin from a zip file
     *
     * @param string $path Path to extension zip file
     * @param string $plugin Optional plugin name
     * @return boolean
     * @throws CakeException
     */
    public function extractPlugin($path = null, $plugin = null) 
    {
        if (!file_exists($path)) {
            throw new CakeException(__l('Invalid plugin file path'));
        }
        if (empty($plugin)) {
            $plugin = $this->getPluginName($path);
        }
        $pluginHome = current(App::path('Plugin'));
        $pluginPath = $pluginHome . $plugin . DS;
        if (is_dir($pluginPath)) {
            throw new CakeException(__l('Plugin already exists'));
        }
        $Zip = new ZipArchive;
        if ($Zip->open($path) === true) {
            new Folder($pluginPath, true);
            $Zip->extractTo($pluginPath);
            if (!empty($this->_rootPath[$path])) {
                $old = $pluginPath . $this->_rootPath[$path];
                $new = $pluginPath;
                $Folder = new Folder($old);
                $Folder->move($new);
            }
            $Zip->close();
            return true;
        } else {
            throw new CakeException(__l('Failed to extract plugin'));
        }
        return false;
    }
    /**
     * Get name of theme
     *
     * @param string $path Path to zip file of theme
     * @throws CakeException
     */
    public function getThemeName($path = null) 
    {
        if (empty($path)) {
            throw new CakeException(__l('Invalid theme path'));
        }
        if (isset($this->_themeName[$path])) {
            return $this->_themeName[$path];
        }
        $Zip = new ZipArchive;
        if ($Zip->open($path) === true) {
            $search = 'webroot/theme.yml';
            for ($i = 0; $i < $Zip->numFiles; $i++) {
                $file = $Zip->getNameIndex($i);
                if (stripos($file, $search) !== false) {
                    $this->_rootPath[$path] = str_replace($search, '', $file);
                    $yml = $Zip->getFromIndex($i);
                    preg_match('/name: (.+)/', $yml, $matches);
                    if (empty($matches[1])) {
                        throw new CakeException(__l('Invalid YML file'));
                    } else {
                        $theme = trim($matches[1]);
                    }
                    break;
                }
            }
            $Zip->close();
            if (!$theme) {
                throw new CakeException(__l('Invalid theme'));
            }
            $this->_themeName[$path] = $theme;
            return $theme;
        } else {
            throw new CakeException(__l('Invalid zip archive'));
        }
        return false;
    }
    /**
     * Extract a theme from a zip file
     *
     * @param string $path Path to extension zip file
     * @param string $theme Optional theme name
     * @return boolean
     * @throws CakeException
     */
    public function extractTheme($path = null, $theme = null) 
    {
        if (!file_exists($path)) {
            throw new CakeException(__l('Invalid theme file path'));
        }
        if (empty($theme)) {
            $theme = $this->getThemeName($path);
        }
        $themeHome = current(App::path('View')) . 'Themed' . DS;
        $themePath = $themeHome . $theme . DS;
        if (is_dir($themePath)) {
            throw new CakeException(__l('Theme already exists'));
        }
        $Zip = new ZipArchive;
        if ($Zip->open($path) === true) {
            new Folder($themePath, true);
            $Zip->extractTo($themePath);
            if (!empty($this->_rootPath[$path])) {
                $old = $themePath . $this->_rootPath[$path];
                $new = $themePath;
                $Folder = new Folder($old);
                $Folder->move($new);
            }
            $Zip->close();
            return true;
        } else {
            throw new CakeException(__l('Failed to extract theme'));
        }
        return false;
    }
}
