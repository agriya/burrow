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
class SettingsController extends AppController
{
    public $components = array(
        'Cookie'
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'SiteLogo.filename',
            'Setting'
        );
        parent::beforeFilter();
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Settings');
		$plugins = explode(',', Configure::read('Hook.bootstraps'));
        array_push($plugins, '');
        $setting_categories = $this->Setting->SettingCategory->find('all', array(
            'conditions' => array(
                'SettingCategory.parent_id' => 0,				
                'SettingCategory.plugin_name' => $plugins,
                "NOT" => array(
                    "SettingCategory.id" => array(
                        65
                    )
                )
            ) , // Images category will not showed
            'name' => array(
                'order ASC'
            ) ,
            'recursive' => 0
        ));
        $this->set('setting_categories', $setting_categories);
        $this->set('pageTitle', $this->pageTitle);
    }
    public function admin_edit($category_id = 1)
    {
		$settingCategory = $this->Setting->SettingCategory->find('first', array(
            'conditions' => array(
                'SettingCategory.id = ' => $category_id
            ) ,
            'recursive' => -1
        ));
        $categoryName = $settingCategory['SettingCategory']['name'];
        $plugins = explode(',', Configure::read('Hook.bootstraps'));
        if (in_array($categoryName, array(
            'Properties',
            'Wallet',
            'Withdrawals',
            'Affiliates'
        ))) {
            if ($categoryName == 'Withdrawals' && !isPluginEnabled('Wallet')) {
                throw new NotFoundException(__l('Invalid request'));
            } else if (!isPluginEnabled($categoryName)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        if (!empty($this->request->data['Setting']['plugin_name'])) {
            $plugin_name = $this->request->data['Setting']['plugin_name'];
            unset($this->request->data['Setting']['plugin_name']);
        }
        $save_check_flag = 0;
        $ssl_enable = true;
        $this->disableCache();
		App::import('Model', 'Attachment');
		$this->Attachment = new Attachment(); 
        if (!empty($this->request->data)) {
			if (!empty($this->request->data['Setting']['plugin_name'])) {
			   $plugin_name = $this->request->data['Setting']['plugin_name'];
			   unset($this->request->data['Setting']['plugin_name']);
			}
            if (Configure::read('site.is_admin_settings_enabled')) {
                // Save settings
                if (!empty($this->request->data['Setting']['22'])) {
                    $this->Cookie->write('user_language', $this->request->data['Setting']['22']['name'], false);
                }
                $category_id = $this->request->data['Setting']['setting_category_id'];
                unset($this->request->data['Setting']['setting_category_id']);
                $validate['error'] = '';
                if (!empty($this->request->data['Setting']['316']['name'])) {
                    if (!stristr(substr($this->request->data['Setting']['316']['name'], -1, 1) , '/') === false) {
                        $validate['error'] = __l('Settings could not be updated. Please try again.');
                        $this->Setting->validationErrors[316]['name'] = __l('This is image base URL should not trailing slash');
                    }
                }
                if (!empty($this->request->data['Setting']['317']['name'])) {
                    if (stristr(substr($this->request->data['Setting']['317']['name'], -1, 1) , '/') === false) {
                        $validate['error'] = __l('Settings could not be updated. Please try again.');
                        $this->Setting->validationErrors[317]['name'] = __l('This is css base URL should have trailing slash');
                    }
                }
                if (!empty($this->request->data['Setting']['318']['name'])) {
                    if (stristr(substr($this->request->data['Setting']['318']['name'], -1, 1) , '/') === false) {
                        $validate['error'] = __l('Settings could not be updated. Please try again.');
                        $this->Setting->validationErrors[318]['name'] = __l('This is JS base URL should have trailing slash');
                    }
                }
                if (empty($validate['error'])) {
                    foreach($this->request->data['Setting'] as $id => $value) {
                        $settings['Setting']['id'] = $id;
						if ($id == '342') {
                            $subscription_check = $this->Setting->find('first', array(
                                'conditions' => array(
                                    'Setting.id' => 342
                                ) ,
                                'recursive' => -1
                            ));
                            if ($value['name'] == 'Launched') {
                                if ($subscription_check['Setting']['value'] == 'Launched') {
                                    $subscription_flag = 0;
                                } else {
                                    $subscription_flag = 1;
                                    $launch_type = $subscription_check['Setting']['value'];
                                }
                            }
                            if ($value['name'] == 'Private Beta') {
                                if ($subscription_check['Setting']['value'] == 'Pre-launch') {
                                    $subscription_flag = 1;
                                    $launch_type = 'private_beta';
                                }
                            }
                        }
                        if ($id == '345') { // Writing default city name in cache.
                            if (!empty($this->request->data['Setting']['345']['is_delete_attachemnt']) || !empty($this->request->data['Setting']['345']['name']['name'])) {
                                $this->Attachment->deleteAll(array(
                                    'Attachment.class' => 'Setting',
                                    'Attachment.foreign_id' => $settings['Setting']['id'],
                                ));
                            }
                            if (!empty($this->request->data['Setting']['345']['name']['name'])) {
							$this->Attachment->create();
                                $this->request->data['Attachment']['filename'] = $this->request->data['Setting']['345']['name'];
                                $this->request->data['Attachment']['class'] = 'Setting';
                                $this->request->data['Attachment']['foreign_id'] = $settings['Setting']['id'];
                                //$this->Attachment->create();
                                $this->Attachment->save($this->request->data['Attachment']);
                            }
                        }
                        if (count($value['name']) == 1) {
                            $settings['Setting']['id'] = $id;
                            $settings['Setting']['value'] = $value['name'];
                            $this->Setting->save($settings['Setting']);
                            $save_check_flag = 1;
                        }
                        if ($id == '8') { // Writing default city name in cache.
                            Cache::delete('site_paypal_conversion_currency');
                            Cache::delete('site_paypal_conversion_currency_rate');
                            Cache::delete('site_supported_currencies');
                            Configure::write('site.currency_id', $value['name']);
                        }
                        if ($id == '23') { // Writing default city name in cache.
                            if (($default_city = Cache::read('site.default_city', 'long')) === false) {
                                Cache::write('site.default_city', $value['name'], array(
                                    'config' => 'long'
                                ));
                            } else {
                                Cache::delete('site.default_city', 'long');
                                Cache::write('site.default_city', $value['name'], array(
                                    'config' => 'long'
                                ));
                            }
                        }
                        if ($id == '24') { // Writing city routing url in cache
                            if (($city_url = Cache::read('site.city_url', 'long')) === false) {
                                Cache::write('site.city_url', $value['name'], array(
                                    'config' => 'long'
                                ));
                                Cache::write('site.city_url', $value['name'], 'long');
                            } else {
                                Cache::delete('site.city_url', 'long');
                                Cache::write('site.city_url', $value['name'], array(
                                    'config' => 'long'
                                ));
                            }
                        }
                        if ($id == '9') { // Writing conversion currency details in cache
                            Cache::delete('site_paypal_conversion_currency');
                            Cache::delete('site_paypal_conversion_currency_rate');
                            Cache::delete('site_supported_currencies');
                            Configure::write('site.paypal_currency_converted_id', $value['name']);
                            $this->_cacheWriteCurrency();
                        }
						if (!empty($subscription_flag)) {
							$this->Session->setFlash(__l('Settings updated successfully.') , 'default', null, 'success');
							if (isPluginEnabled('LaunchModes')) {
								$this->redirect(array(
									'action' => 'confirm_page',
									$launch_type,
									'admin' => true
								));
							}
						}
                        if (count($value['name']) == 1) {
                            $settings['Setting']['value'] = $value['name'];
                            $this->Setting->save($settings['Setting']);
                            $save_check_flag = 1;
                        }
                    }
                    if (!empty($save_check_flag)) {
                        $this->Session->setFlash(__l('Settings updated successfully.') , 'default', null, 'success');
						if (isset($plugin_name) && !empty($plugin_name)) {
							$this->redirect(array(
								'action' => 'plugin_settings',
								$plugin_name,
								'admin' => true
							));
						}
                    }
                } else {
                    $this->Session->setFlash($validate['error'], 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(__l('Sorry. You Cannot Update the Settings in Demo Mode') , 'default', null, 'error');
            }
        }
        $this->request->data['Setting']['setting_category_id'] = $category_id;
        $conditions = array();
        $setting_categories_plugin_names = array();
        $conditions['Setting.setting_category_parent_id'] = $category_id;
        array_push($plugins, '');
        $conditions['Setting.plugin_name'] = $plugins;
        $settings = $this->Setting->find('all', array(
            'conditions' => $conditions,
            'order' => array(
                'Setting.setting_category_id' => 'asc',
                'Setting.order' => 'asc'
            ) ,
            'recursive' => 0
        ));
        if ($category_id == 1) {
            $url = "https://" . $_SERVER['SERVER_NAME'];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if (curl_exec($ch) === false) {
                $ssl_enable = false;
            }
            // Close handle
            curl_close($ch);
        }
        $this->request->data['Setting']['setting_category_id'] = $category_id;
        $main_setting_categories = $this->Setting->SettingCategory->find('first', array(
            'conditions' => array(
                'SettingCategory.id = ' => $category_id
            ) ,
            'recursive' => -1
        ));
        $setting_categories = $this->Setting->SettingCategory->find('all', array(
            'conditions' => array(
                'SettingCategory.parent_id = ' => $category_id
            ) ,
            'recursive' => -1
        ));
        $this->set('setting_categories', $main_setting_categories);
        $this->set('setting_category_name', $main_setting_categories);
        $this->pageTitle = $main_setting_categories['SettingCategory']['name'] . __l(' Settings');
        $beyondOriginals = array();
        $aspects = array();
        foreach($settings as $setting) {
            $field_name = explode('.', $setting['Setting']['name']);
            if (isset($field_name[2])) {
                if ($field_name[2] == 'is_not_allow_resize_beyond_original_size') {
                    $beyondOriginals[$setting['Setting']['id']] = Inflector::humanize(Inflector::underscore($field_name[1]));
                    $this->request->data['Setting']['not_allow_beyond_original'][] = ($setting['Setting']['value']) ? $setting['Setting']['id'] : '';
                } else if ($field_name[2] == 'is_handle_aspect') {
                    $aspects[$setting['Setting']['id']] = Inflector::humanize(Inflector::underscore($field_name[1]));
                    $this->request->data['Setting']['allow_handle_aspect'][] = ($setting['Setting']['value']) ? $setting['Setting']['id'] : '';
                }
            }
        }
        $fb_login_url = Router::url(array(
            'controller' => 'settings',
            'action' => 'update_credentials',
			'type' => 'facebook'
        ) , true);
        $tw_login_url = Router::url(array(
            'controller' => 'settings',
            'action' => 'update_credentials',
			'type' => 'twitter'
        ) , true);
		$google_login_url = Router::url(array(
            'controller' => 'settings',
            'action' => 'update_credentials',
			'type' => 'google'
        ) , true);
		$appliation_key_link = Router::url(array(
            'controller' => 'settings',
            'action' => 'edit',
            15
        ) , true);
        $captcha_conf_link = Router::url(array(
            'controller' => 'settings',
            'action' => 'edit',
            1
        ) , true);
        $this->set('captcha_conf_link', $captcha_conf_link);
        $this->set('appliation_key_link', $appliation_key_link);
        $this->set('ssl_enable', $ssl_enable);
        $this->set('fb_login_url', $fb_login_url);
        $this->set('tw_login_url', $tw_login_url);
		$this->set('google_login_url', $google_login_url);
        $this->set(compact('settings', 'beyondOriginals', 'aspects'));
        $this->set('pageTitle', $this->pageTitle);
    }
    public function _traverse_directory($dir, $dir_count)
    {
        $handle = opendir($dir);
        while (false !== ($readdir = readdir($handle))) {
            if ($readdir != '.' && $readdir != '..') {
                $path = $dir . '/' . $readdir;
                if (is_dir($path)) {
                    @chmod($path, 0777);
                    ++$dir_count;
                    $this->_traverse_directory($path, $dir_count);
                }
                if (is_file($path)) {
                    @chmod($path, 0777);
                    @unlink($path);
                    //so that page wouldn't hang
                    flush();
                }
            }
        }
        closedir($handle);
        @rmdir($dir);
        return true;
    }
    public function fb_update()
    {
        App::import('Vendor', 'facebook/facebook');
        $this->facebook = new Facebook(array(
            'appId' => Configure::read('facebook.app_id') ,
            'secret' => Configure::read('facebook.secrect_key') ,
            'cookie' => true
        ));
        if ($fb_session = $this->Session->read('fbuser')) {
            $settings = $this->Setting->find('all', array(
                'conditions' => array(
                    'Setting.name' => array(
                        'facebook.fb_access_token',
                        'facebook.fb_user_id'
                    )
                ) ,
                'fields' => array(
                    'Setting.id',
                    'Setting.name'
                ) ,
                'recursive' => -1
            ));
            foreach($settings as $setting) {
                $this->request->data['Setting']['id'] = $setting['Setting']['id'];
                if ($setting['Setting']['name'] == 'facebook.fb_user_id') {
                    $this->request->data['Setting']['value'] = $fb_session['id'];
                } elseif ($setting['Setting']['name'] == 'facebook.fb_access_token') {
                    $this->request->data['Setting']['value'] = $fb_session['access_token'];
                }
                if ($this->Setting->save($this->request->data)) {
                    $this->Session->setFlash(__l('Facebook credentials updated') , 'default', null, 'success');
                } else {
                    $this->Session->setFlash(__l('Facebook credentials could not be updated. Please, try again.') , 'default', null, 'error');
                }
            }
        }
        $this->redirect(array(
            'action' => 'index',
            'admin' => true
        ));
    }
    public function crush()
    {
        $this->autoRender = false;
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'cron');
        $this->Cron = new CronComponent($collection);
        $this->Cron->crushPng(APP . WEBROOT_DIR, 0);
        if (!empty($_GET['f'])) {
            $this->Session->setFlash(__l('PNG images crushed successfully') , 'default', null, 'success');
            $this->redirect(Router::url('/', true) . $_GET['f']);
        }
    }	
    public function admin_plugin_settings($plugin_name = '')
    {
		App::import('Model', 'Attachment');
		$this->Attachment = new Attachment(); 
        $save_check_flag = 0;
        $ssl_enable = true;
        $this->disableCache();
        $settings = $this->Setting->find('all', array(
            'conditions' => array(
                'Setting.plugin_name' => $plugin_name
            ) ,
            'order' => array(
                'Setting.setting_category_id' => 'asc',
                'Setting.order' => 'asc'
            ) ,
            'recursive' => 0
        ));
        $is_module = false;
        $active_module = true;
        $this->set('active_module', $active_module);
        $this->set('is_module', $is_module);
        $setting_categories = $this->Setting->SettingCategory->find('all', array(
            'conditions' => array(
                'SettingCategory.plugin_name = ' => $plugin_name
            ) ,
            'recursive' => -1
        ));
        $this->pageTitle = $plugin_name . __l(' Settings');
        $this->set('plugin_name', $plugin_name);
        $is_submodule = false;
        $active_submodule = true;
        foreach($setting_categories as $setting_category) {
            $this->set('is_submodule', $is_submodule);
            $this->set('active_submodule', $active_submodule);
        }
        $beyondOriginals = array();
        $aspects = array();
        foreach($settings as $setting) {
            $field_name = explode('.', $setting['Setting']['name']);
            if (isset($field_name[2])) {
                if ($field_name[2] == 'is_not_allow_resize_beyond_original_size') {
                    $beyondOriginals[$setting['Setting']['id']] = Inflector::humanize(Inflector::underscore($field_name[1]));
                    $this->request->data['Setting']['not_allow_beyond_original'][] = ($setting['Setting']['value']) ? $setting['Setting']['id'] : '';
                } else if ($field_name[2] == 'is_handle_aspect') {
                    $aspects[$setting['Setting']['id']] = Inflector::humanize(Inflector::underscore($field_name[1]));
                    $this->request->data['Setting']['allow_handle_aspect'][] = ($setting['Setting']['value']) ? $setting['Setting']['id'] : '';
                }
            }
        }
        $appliation_key_link = Router::url(array(
            'controller' => 'settings',
            'action' => 'edit',
            15
        ) , true);
        $captcha_conf_link = Router::url(array(
            'controller' => 'settings',
            'action' => 'edit',
            1
        ) , true);
        $this->set('setting_categories', false);
        $this->set('captcha_conf_link', $captcha_conf_link);
        $this->set('appliation_key_link', $appliation_key_link);
        $this->set(compact('settings', 'beyondOriginals', 'aspects'));
        $this->set('pageTitle', $this->pageTitle);
        if ($plugin_name == 'LaunchModes') {
            $attachment = $this->Attachment->find('first', array(
                'conditions' => array(
                    'Attachment.class = ' => 'Setting'
                ) ,
                'recursive' => -1
            ));
            $this->set('attachment', $attachment);
        }
        $this->render('admin_edit');
    }
	public function admin_update_credentials()
    {
        $config = array(
            'base_url' => Router::url('/', true) . 'socialauth/',
            'providers' => array(
                'Facebook' => array(
                    'enabled' => Configure::read('facebook.is_enabled_facebook_connect') ,
                    'keys' => array(
                        'id' => Configure::read('facebook.app_id') ,
                        'secret' => Configure::read('facebook.secrect_key')
                    ) ,
                    'scope' => 'email, user_about_me, user_birthday, user_hometown',
                ) ,
                'Twitter' => array(
                    'enabled' => Configure::read('twitter.is_enabled_twitter_connect') ,
                    'keys' => array(
                        'key' => Configure::read('twitter.consumer_key') ,
                        'secret' => Configure::read('twitter.consumer_secret')
                    ) ,
                ) ,
                'Google' => array(
                    'enabled' => true,
                    'keys' => array(
                        'id' => Configure::read('google.consumer_key') ,
                        'secret' => Configure::read('google.consumer_secret')
                    ) ,
                    'scope' => 'https://www.googleapis.com/auth/analytics.readonly',
                    'access_type' => 'offline',
                    'approval_prompt' => 'force'
                ) ,
            )
        );
        if (!empty($this->request->params['named']['type'])) {
            $options = array();
            $social_type = $this->request->params['named']['type'];
            try {
                require_once (APP . DS . WEBROOT_DIR . DS . 'socialauth/Hybrid/Auth.php');
                $hybridauth = new Hybrid_Auth($config);
                $adapter = $hybridauth->authenticate(ucfirst($social_type) , $options);
                if ($social_type == 'facebook') {
                    $social_profile = (array)$adapter->getUserProfile();
                    $user_id = $social_profile['identifier'];
                }
                $session_data = $this->Session->read('HA::STORE');
                if (!empty($session_data['hauth_session.' . $social_type . '.token.access_token'])) {
                    $access_token = unserialize($session_data['hauth_session.' . $social_type . '.token.access_token']);
                }
                if (!empty($session_data['hauth_session.' . $social_type . '.token.access_token_secret'])) {
                    $access_key = unserialize($session_data['hauth_session.' . $social_type . '.token.access_token_secret']);
                }
                if ($social_type == 'google') {
                    $refresh_token = unserialize($session_data['hauth_session.' . $social_type . '.token.refresh_token']);
                    $expired_in = unserialize($session_data['hauth_session.' . $social_type . '.token.expires_in']);
                    $expires_at = unserialize($session_data['hauth_session.' . $social_type . '.token.expires_at']);
                }
                $settings = $this->Setting->find('all', array(
                    'conditions' => array(
                        'Setting.name' => array(
                            'facebook.fb_access_token',
                            'facebook.fb_user_id',
                            'twitter.site_user_access_key',
                            'twitter.site_user_access_token',
                            'google_analytics.access_token',
                        )
                    ) ,
                    'fields' => array(
                        'Setting.id',
                        'Setting.name'
                    ) ,
                    'recursive' => -1
                ));
                foreach($settings as $setting) {
                    $_data = array();
                    $_data['Setting']['id'] = $setting['Setting']['id'];
                    if ($social_type == 'facebook') {
                        if ($setting['Setting']['name'] == 'facebook.fb_access_token') {
                            $_data['Setting']['value'] = $access_token;
                        } elseif ($setting['Setting']['name'] == 'facebook.fb_user_id') {
                            $_data['Setting']['value'] = $user_id;
                        }
                    } elseif ($social_type == 'twitter') {
                        if ($setting['Setting']['name'] == 'twitter.site_user_access_token') {
                            $_data['Setting']['value'] = $access_token;
                        } elseif ($setting['Setting']['name'] == 'twitter.site_user_access_key') {
                            $_data['Setting']['value'] = $access_key;
                        }
                    } elseif ($social_type == 'google') {
                        if ($setting['Setting']['name'] == 'google_analytics.access_token') {
                            $access_token_arr['access_token'] = $access_token;
                            $access_token_arr['refresh_token'] = $refresh_token;
                            $access_token_arr['created'] = $expired_in;
                            $access_token_arr['expires_in'] = $expires_at;
                            $_data['Setting']['value'] = json_encode($access_token_arr);
                        }
                    }
                    $this->Setting->save($_data);
                }
                $this->Session->delete('HA::CONFIG');
                $this->Session->delete('HA::STORE');
                $this->Session->setFlash(sprintf(__l('%s credentials has been updated') , ucfirst($social_type)) , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'settings',
                    'action' => 'edit',
                    15
                ));
            }
            catch(Exception $e) {
                $error = "";
				switch ($e->getCode()) {
                    case 6:
                        $error = __l("User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.");
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                        break;

                    case 7:
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                        $error = __l("User not connected to the provider.");
                        break;

                    default:
                        $error = __l("Authentication failed. The user has canceled the authentication or the provider refused the connection");
                        break;
                }
                $this->Session->setFlash($error, 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'settings',
                    'action' => 'edit',
                    15
                ));
            }
        }
    }
    public function admin_confirm_page($launch_type = null)
    {
        if (!empty($this->request->data['Setting'])) {
            $_data['Setting']['launch_type'] = $this->request->data['Setting']['launch_type'];
            Cms::dispatchEvent('Controller.Settings.redirectToPreLaunch', $this, array(
                'data' => $_data
            ));
			if ($this->request->data['Setting']['launch_type'] == 'private_beta') {
				$this->Session->setFlash(__l('Private beta mail sent to subscribed users successfully.') , 'default', null, 'success');
			}
			if ($this->request->data['Setting']['launch_type'] == 'Pre-launch' || $this->request->data['Setting']['launch_type'] == 'Private Beta') {
				$this->Session->setFlash(__l('Launch mail sent to subscribed users successfully.') , 'default', null, 'success');
			}
            $this->redirect(array(
                'action' => 'index',
                'admin' => true
            ));
        }
        $this->request->data['Setting']['launch_type'] = $launch_type;
        $from = $this->request->data['Setting']['launch_type'];
        if ($this->request->data['Setting']['launch_type'] == 'Pre-launch') {
            $from = __l('Pre launch');
        }
        $to = __l('Launch Mode');
        if ($this->request->data['Setting']['launch_type'] == 'private_beta') {
            $from = __l('Pre launch');
            $to = __l('Private Beta');
        }
        $this->pageTitle = $from . ' -> ' . $to;
    }
}
?>