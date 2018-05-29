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
App::uses('File', 'Utility');
App::uses('Folder', 'Utility');
App::uses('ExtensionsInstaller', 'Extensions.Lib');
App::uses('CmsTheme', 'Extensions.Lib');
class ExtensionsThemesController extends AppController
{
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'ExtensionsThemes';
    /**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */
    public $uses = array(
        'Setting',
        'User'
    );
    /**
     * CmsTheme instance
     */
    protected $_CmsTheme = false;
    public function __construct($request = null, $response = null) 
    {
        $this->_CmsTheme = new CmsTheme();
        parent::__construct($request, $response);
    }
    public function admin_index() 
    {
        $this->pageTitle = __l('Themes');
        $themes = $this->_CmsTheme->getThemes();
        $themesData = array();
        $themesData[] = $this->_CmsTheme->getData();
        foreach($themes as $theme) {
            $themesData[$theme] = $this->_CmsTheme->getData($theme);
        }
        $currentTheme = $this->_CmsTheme->getData(Configure::read('site.theme'));
        $this->set(compact('themes', 'themesData', 'currentTheme'));
    }
    public function admin_activate($alias = null) 
    {
        if ($this->_CmsTheme->activate($alias)) {
            $this->Session->setFlash(__l('Theme activated.') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(__l('Theme activation failed.') , 'default', null, 'success');
        }
        $this->redirect(array(
            'action' => 'index'
        ));
    }
    public function admin_add() 
    {
        $this->pageTitle = __l('Upload Theme');
        if (!empty($this->data)) {
            $file = $this->data['Theme']['file'];
            unset($this->data['Theme']['file']);
            $Installer = new ExtensionsInstaller;
            try {
                $Installer->extractTheme($file['tmp_name']);
                $this->Session->setFlash(__l('Theme uploaded successfully.') , 'default', null, 'success');
            }
            catch(CakeException $e) {
                $this->Session->setFlash($e->getMessage() , 'default', null, 'error');
            }
            $this->redirect(array(
                'action' => 'index'
            ));
        }
    }
    public function admin_editor() 
    {
        $this->pageTitle = __l('Theme Editor');
    }
    public function admin_save() 
    {
    }
    public function admin_delete($alias = null) 
    {
        if ($alias == null) {
            $this->Session->setFlash(__l('Invalid theme') , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if ($alias == 'default') {
            $this->Session->setFlash(__l('Default theme cannot be deleted.') , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        } elseif ($alias == Configure::read('site.theme')) {
            $this->Session->setFlash(__l('You cannot delete a theme that is currently active.') , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $paths = array(
            APP . 'webroot' . DS . 'theme' . DS . $alias . DS,
            APP . 'View' . DS . 'Themed' . DS . $alias . DS,
        );
        $error = 0;
        $folder = &new Folder;
        foreach($paths as $path) {
            if (is_dir($path)) {
                if (!$folder->delete($path)) {
                    $error = 1;
                }
            }
        }
        if ($error == 1) {
            $this->Session->setFlash(__l('An error occurred.') , 'default', null, 'error');
        } else {
            $this->Session->setFlash(__l('Theme deleted successfully.') , 'default', null, 'success');
        }
        $this->redirect(array(
            'action' => 'index'
        ));
    }
}
?>