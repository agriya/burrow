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
App::uses('ExtensionsInstaller', 'Extensions.Lib');
App::uses('CmsPlugin', 'Extensions.Lib');
class ExtensionsPluginsController extends AppController
{
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'ExtensionsPlugins';
    /**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */
    public $uses = array(
        'Setting',
        'User',
    );
    /**
     * Core plugins
     *
     * @var array
     * @access public
     */
    public $corePlugins = array(
        'Acl',
        'Extensions',
    );
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->_CmsPlugin = new CmsPlugin();
        $this->_CmsPlugin->setController($this);
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Plugins');
        $pluginAliases = $this->_CmsPlugin->getPlugins();
        $pluginGroups = $tempPluginGroups = $tempPluginGroups2 = array();
        foreach($pluginAliases as $pluginAlias) {
            $pluginData = $this->_CmsPlugin->getData($pluginAlias);
            $pluginData['plugin_folder_name'] = $pluginAlias;
            $tmpPluginData[$pluginData['parent'] . '.' . $pluginData['name']] = $pluginData;
        }
        ksort($tmpPluginData);
        foreach($tmpPluginData as $parent => $pluginData) {
            Configure::write('pluginsTree.' . substr($parent, 2) , $pluginData);
        }
        $image_title_icons = array(
            'Modules' => 'modules-icon',
            'Growth Hacking' => 'growthhacking-icon',
            'Payments' => 'payment-icon',
            'Mobile Features' => 'mobile-feature-icon',
            'Others' => 'icon-folder-close',
            'Sudopay' => 'sudopay-icon',
            'Plugins For All Modules' => 'all-module-icon'
        );
        $others = '';
        if(isset($modules)){
          foreach($modules as $module) {
            if (!is_dir(APP . 'Plugin' . DS . $module)) {
                $other_modules[] = $module;
            }
          }
        }
        if (!empty($other_modules)) {
            $others = sprintf(__l('%s modules also available for this product, you can also purchase it in our customers area.') , implode(', ', $other_modules));
        }
        $title_description = array(
            'Modules' => __l('Modules you have purchased in our customer area is listed here.') . ' ' . $others,
            'Plugins For All Modules' => __l('Plugins used in all modules listed here.') ,
            'Payments' => __l('Payment gateway used in all module listed here.') ,
            'Others' => __l('Plugins for additional functionality used in all modules listed here.') ,
            'Growth Hacking' => __l('Growth hacking is a set of tactics and best practices for dealing with problem of user growth.') ,
            'Mobile Features' => __l('By default this site has responsive layout, although this site having separate mobile app features for devices like the iPhone, Android and touch mobile.')
        );
        $this->set('image_title_icons', $image_title_icons);
        $this->set('title_description', $title_description);
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Upload Plugin');
        if (!empty($this->request->data)) {
            $file = $this->request->data['Plugin']['file'];
            unset($this->request->data['Plugin']['file']);
            $Installer = new ExtensionsInstaller;
            try {
                $Installer->extractPlugin($file['tmp_name']);
            }
            catch(CakeException $e) {
                $this->Session->setFlash($e->getMessage(), 'default', null, 'error');
                $this->redirect(array(
                    'action' => 'add'
                ));
            }
            $this->redirect(array(
                'action' => 'index'
            ));
        }
    }
    public function admin_delete($plugin = null)
    {
        if (!$plugin) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('plugin')), 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if ($this->_CmsPlugin->isActive($plugin)) {
            $this->Session->setFlash(__l('You cannot delete a plugin that is currently active.') , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $result = $this->_CmsPlugin->delete($plugin);
        if ($result === true) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Plugin') . ' ' . $plugin) , 'default', null, 'success');
        } elseif (!empty($result[0])) {
            $this->Session->setFlash($result[0], 'default', null, 'error');
        } else {
            $this->Session->setFlash(sprintf(__l('%s could not be deleted. Please, try again.') , __l('Plugin')), 'default', null, 'error');
        }
        $this->redirect(array(
            'action' => 'index'
        ));
    }
    public function admin_toggle($plugin = null)
    {
        if (!$plugin) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('plugin')) , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $paymentGateways = array(
            'Sudopay' => ConstPaymentGateways::SudoPay,
            'Wallet' => ConstPaymentGateways::Wallet,
        );
        $this->loadModel('PaymentGateway');
        if ($this->_CmsPlugin->isActive($plugin)) {
            $this->_CmsPlugin->deactivate($plugin);
            $pluginDetails = $this->_CmsPlugin->getData($plugin);
            if (!empty($pluginDetails['subplugin'])) {
                $subplugins = explode(',', $pluginDetails['subplugin']);
                foreach($subplugins as $subplugin) {
                    $this->_CmsPlugin->deactivate(trim($subplugin));
                }
            }
            if (in_array($plugin, array_keys($paymentGateways))) {
                //To deactivate payments
                $this->PaymentGateway->updateAll(array(
                    'PaymentGateway.is_active' => 0
                ) , array(
                    'PaymentGateway.id' => $paymentGateways[$plugin]
                ));
            }
            $this->Session->setFlash(__l('Plugin disabled successfully.') , 'default', null, 'success');
        } else {
            $pluginData = $this->_CmsPlugin->getPluginData($plugin);
            $dependencies = true;
            if (!empty($pluginData['dependencies']['plugins'])) {
                foreach($pluginData['dependencies']['plugins'] as $requiredPlugin) {
                    $requiredPlugin = ucfirst($requiredPlugin);
                    if (!CakePlugin::loaded($requiredPlugin)) {
                        $dependencies = false;
                        $missingPlugin = $requiredPlugin;
                        break;
                    }
                }
            }
            if ($dependencies) {
                $this->_CmsPlugin->activate($plugin);
                if (in_array($plugin, array_keys($paymentGateways))) {
                    //To activate payments
                    $this->PaymentGateway->updateAll(array(
                        'PaymentGateway.is_active' => 1
                    ) , array(
                        'PaymentGateway.id' => $paymentGateways[$plugin]
                    ));
                }
                $this->Session->setFlash(__l('Plugin enabled successfully.') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('Plugin "%s" depends on "%s" plugin.') , $plugin, $missingPlugin) , 'default', null, 'error');
            }
        }
        if (!empty($this->request->params['named']['type'])) {
            $this->redirect(array(
                'controller' => 'project_types',
                'action' => 'index'
            ));
        } else {
            $this->redirect(array(
                'action' => 'index'
            ));
        }
    }
}
?>