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
/* SVN FILE: $Id: app_controller.php 173 2009-01-31 12:51:40Z rajesh_04ag02 $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7805 $
 * @modifiedby    $LastChangedBy: AD7six $
 * @lastmodified  $Date: 2008-10-30 23:00:26 +0530 (Thu, 30 Oct 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
App::uses('Controller', 'Controller');
class AppController extends Controller
{
	public $components = array(
        'Security',
        'Auth',
        'Acl.AclFilter',
        'XAjax',
        'RequestHandler',
        'Cookie',
        'Cms',

    );
    /**
     * Helpers
     *
     * @var array
     * @access public
     */
    public $helpers = array(
        'Html',
        'Form',
        'Javascript',
        'Session',
        'Text',
        'Js',
        'Time',
        'Layout',
        'Auth',
    );
    public $isHome = false;
    public $homePageId;
    var $cookieTerm = '+4 weeks';
    //    var $view = 'Theme';
    var $theme = '';
    function beforeRender()
    {
        $this->set('meta_for_layout', Configure::read('meta'));
        $this->set('js_vars_for_layout', (isset($this->js_vars)) ? $this->js_vars : '');
        parent::beforeRender();
    }
    public function __construct($request = null, $response = null)
    {
		App::uses('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Security');
        $this->Security = new SecurityComponent($collection);
        App::import('Component', 'Auth');
        $this->Auth = new AuthComponent($collection);
        App::import('Component', 'Session');
        $this->Session = new SessionComponent($collection);
        Cms::applyHookProperties('Hook.controller_properties', $this);
        parent::__construct($request, $response);
        if ($this->name == 'CakeError') {
            $this->_set(Router::getPaths());
            $this->request->params = Router::getParams();
            $this->constructClasses();
            $this->startupProcess();
        }
		if (file_exists(APP . 'Config' . DS . 'settings.yml')) {
			// Writing Currency in cache
			$this->_cacheWriteCurrency();
		}
    }
    function beforeFilter()
    {
		 //Fix to upload the file through the flash multiple uploader
        if ((isset($_SERVER['HTTP_USER_AGENT']) and ((strtolower($_SERVER['HTTP_USER_AGENT']) == 'shockwave flash') or (strpos(strtolower($_SERVER['HTTP_USER_AGENT']) , 'adobe flash player') !== false))) and isset($this->params['pass'][0]) and ($this->params['action'] == 'flashupload' || $this->params['action'] == 'thumbnail')) {
			$this->Session->id($this->request->params['pass'][0]);
        }
		$cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];		
		if ($this->Auth->user('id')) {
			App::import('Model', 'User');
			$this->User = new User();
			$user = $this->User->find('first', array(
				'conditions' => array(
					'User.id' => $this->Auth->user('id')
				) ,
				'recursive' => -1
			));
		}
		if (!$this->Auth->user('id')) {
			if (!empty($_COOKIE['_gz'])) {
				setcookie('_gz', '', time() -3600, '/');
			}
		}
		if ($this->Auth->user('id') && empty($_COOKIE['_gz'])) {
			$hashed_val = md5($this->Auth->user('id') . session_id() . PERMANENT_CACHE_GZIP_SALT);
            $hashed_val = substr($hashed_val, 0, 7);
            $form_cookie = $this->Auth->user('id') . '|' . $hashed_val;
			setcookie('_gz', $form_cookie, time() + 60 * 60 * 24, '/');
		}	
	
		$is_redirect_to_social_marketing = 1;
		if(Configure::read('user.signup_fee') && $this->Auth->user('id') && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
			if (!in_array($cur_page, Configure::read('signup_fee.exception_arr')) && empty($user['User']['is_paid'])) {
				$this->redirect(array(
					'controller' => 'payments',
					'action' => 'membership_pay_now',
					$this->Auth->user('id'),
					$this->User->getActivateHash($this->Auth->user('id'))
				));
			}
			if(empty($user['User']['is_paid'])) {
				$is_redirect_to_social_marketing = 0;
			}
		}
		$cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];
		if (isPluginEnabled('SocialMarketing') && !empty($is_redirect_to_social_marketing)) {
			if ($this->Auth->user('id') && $this->Auth->user('role_id') != ConstUserTypes::Admin && !in_array($cur_page, Configure::read('social_marketing.exception_arr')) && !empty($user) && (!$user['User']['is_skipped_fb'] || !$user['User']['is_skipped_twitter'] || !$user['User']['is_skipped_google'] || !$user['User']['is_skipped_yahoo'] )) {
                if (!$user['User']['is_skipped_fb']) {
                    $type = 'facebook';
                } elseif (!$user['User']['is_skipped_twitter']) {
                    $type = 'twitter';
                } elseif (!$user['User']['is_skipped_google']) {
                    $type = 'gmail';
                } elseif (!$user['User']['is_skipped_yahoo']) {
                    $type = 'yahoo';
                } 
                $this->redirect(array(
                    'controller' => 'social_marketings',
                    'action' => 'import_friends',
                    'type' => $type,
                    'admin' => false
                ));
            }
        }
		if (isPluginEnabled('LaunchModes')) {
			if($this->Auth->user('role_id') != ConstUserTypes::Admin) {
				if (Configure::read('site.launch_mode') == 'Pre-launch' && !in_array($cur_page, Configure::read('prelaunch.exception_arr'))) {
					if (empty($this->request->params['prefix'])) {
						$this->redirect(array(
							'controller' => 'properties',
							'action' => 'search',
							'admin' => false
						));
					}
				}
			}
			if($this->Auth->user('role_id') != ConstUserTypes::Admin) {
				if (Configure::read('site.launch_mode') == 'Private Beta' && !in_array($cur_page, Configure::read('private_beta.exception_arr')) && !$this->Auth->user('id')) {
					if (empty($this->request->params['prefix'])) {
						$this->redirect(array(
							'controller' => 'properties',
							'action' => 'search',
							'admin' => false
						));
					} else {
						$this->redirect(array(
							'controller' => 'users',
							'action' => 'login'
						));
					}
				}
			}
        }
		

		// Coding done to disallow demo user to change the admin settings
        if ($this->request->params['action'] != 'flashupload') {
            $cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];
            if ($this->Auth->user('id') && !Configure::read('site.is_admin_settings_enabled') && (in_array($this->request->params['action'], Configure::read('site.admin_demo_mode_not_allowed_actions')) || (!empty($this->request->data) && in_array($cur_page, Configure::read('site.admin_demo_mode_update_not_allowed_pages'))))) {
                $this->Session->setFlash(__l('Sorry. We have disabled this action in demo mode') , 'default', null, 'error');
                if (in_array($this->request->params['controller'], array(
                    'settings',
                    'email_templates'
                ))) {
                    unset($this->request->data);
                } else {
                    $this->redirect(array(
                        'controller' => $this->request->params['controller'],
                        'action' => 'index'
                    ));
                }
            }
        }
        $this->layout = 'default';
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin && (isset($this->request->params['prefix']) and $this->request->params['prefix'] == 'admin')) {
            $this->layout = 'admin';
        }
        if (Configure::read('site.maintenance_mode') && !$this->Auth->user('role_id')) {
            $this->layout = 'maintenance';
        }
		if ($this->Auth->user('id')) {
            App::import('Model', 'User');
            $user_model_obj = new User();
            $user = $user_model_obj->find('first', array(
                'conditions' => array(
                    'User.id =' => $this->Auth->user('id') ,
                ) ,
                'contain' => array(
                    'UserAvatar',
                    'UserProfile' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name'
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2'
                            )
                        )
                    ) ,
                ) ,
                'recursive' => 2
            ));
            $this->set('logged_in_user', $user);
        }
        $cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];
        // check ip is banned or not. redirect it to 403 if ip is banned
        $this->loadModel('BannedIp');
        $bannedIp = $this->BannedIp->checkIsIpBanned($this->RequestHandler->getClientIP());
        if (empty($bannedIp)) {
            $bannedIp = $this->BannedIp->checkRefererBlocked(env('HTTP_REFERER'));
        }
        if (!empty($bannedIp)) {
            if (!empty($bannedIp['BannedIp']['redirect'])) {
                header('location: ' . $bannedIp['BannedIp']['redirect']);
            } else {
                throw new ForbiddenException(__l('Invalid request'));
            }
        }
        if (Configure::read('site.is_ssl_enabled')) {
            $cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];
            if (in_array($cur_page, Configure::read('ssl.secure_url_arr'))) {
                $this->Security->blackHoleCallback = 'forceSSL';
                $this->Security->requireSecure($this->request->params['action']);
            } else if (env('HTTPS') && !$this->RequestHandler->isAjax()) {
                $this->_unforceSSL();
            }
        }
        // Writing site name in cache, required for getting sitename retrieving in cron
        if (!(Cache::read('site_url_for_shell', 'long'))) {
            Cache::write('site_url_for_shell', Router::url('/', true) , 'long');
        }
		// referral link that update cookies
        $this->_affiliate_referral();
        // check site is under maintenance mode or not. admin can set in settings page and then we will display maintenance message, but admin side will work.
        if (Configure::read('site.maintenance_mode') && $this->Auth->user('role_id') != ConstUserTypes::Admin && empty($this->request->params['prefix']) && !in_array($cur_page, Configure::read('maintenance.exception_arr'))) {
            throw new MaintenanceModeException(__l('Maintenance Mode'));
        }
        
        $cookie_slug = $this->Cookie->read('slug');
        

        if (strpos($this->request->here, '/view/') !== false) {
            trigger_error('*** dev1framework: Do not view page through /view/; use singular/slug', E_USER_ERROR);
        }
        // check the method is exist or not in the controller
        $methods = array_flip($this->methods);
        if (!isset($methods[strtolower($this->request->params['action']) ])) {
            throw new NotFoundException('Invalid request');
        }
        // user avail balance
        if ($this->Auth->user('id')) {
            App::import('Model', 'User');
            $user_model_obj = new User();
            $this->set('user_available_balance', $user_model_obj->checkUserBalance($this->Auth->user('id')));
        }
        // <-- For iPhone App code
		// Todo need to check.. request from iOS device or not
		// Also $_GET['key'] need to check with site setting
        if (!empty($_GET['key'])) {
            $response = Cms::dispatchEvent('Controller.Property.handleApp', $this);
        }
        // For iPhone App code -->
        $this->AclFilter->_checkAuth();
		if (Configure::read('site.theme')) {
            $this->theme = Configure::read('site.theme');
        }
        parent::beforeFilter();
    }
    function siteCurrencyFormat($amount, $wrap = 'span')
    {
        $_currencies = $GLOBALS['currencies'];
        $currency_code = Configure::read('site.currency_id');
        if (!empty($_COOKIE['CakeCookie']['user_currency'])) {
            $currency_code = $_COOKIE['CakeCookie']['user_currency'];
        }
        if ($_currencies[$currency_code]['Currency']['is_prefix_display_on_left']) {
            return $_currencies[$currency_code]['Currency']['prefix'] . $this->cCurrency($amount, false);
        } else {
            return $this->cCurrency($amount, false) . $_currencies[$currency_code]['Currency']['prefix'];
        }
    }
    function cCurrency($str, $wrap = 'span', $title = false)
    {
        $_precision = 2;
        $_currencies = $GLOBALS['currencies'];
        $currency_code = Configure::read('site.currency_id');
        if (!empty($_COOKIE['CakeCookie']['user_currency'])) {
            $currency_code = $_COOKIE['CakeCookie']['user_currency'];
            $str = round($str*$_currencies[Configure::read('site.currency_id') ]['CurrencyConversion'][$currency_code], 2);
        }
        $changed = (($r = floatval($str)) != $str);
        $rounded = (($rt = round($r, $_precision)) != $r);
        $r = $rt;
        if ($wrap) {
            if (!$title) {
                $title = ucwords(Numbers_Words::toCurrency($r, 'en_US', $_currencies[$currency_code]['Currency']['code']));
            }
            $r = '<' . $wrap . ' class="c' . $changed . ' cr' . $rounded . '" title="' . $title . '">' . number_format($r, $_precision, $_currencies[$currency_code]['Currency']['dec_point'], $_currencies[$currency_code]['Currency']['thousands_sep']) . '</' . $wrap . '>';
        }
        return $r;
    }
    function autocomplete($param_encode = null, $param_hash = null)
    {
        $modelClass = Inflector::singularize($this->name);
        $conditions = false;
        if (isset($this->{$modelClass}->_schema['is_approved'])) {
            $conditions['is_approved = '] = '1';
        }
        $this->XAjax->autocomplete($param_encode, $param_hash, $conditions);
    }
    function _redirectGET2Named($whitelist_param_names = null)
    {
        $query_strings = array();
        if (is_array($whitelist_param_names)) {
            foreach($whitelist_param_names as $param_name) {
                if (isset($this->request->query[$param_name])) { // querystring
                    $query_strings[$param_name] = $this->request->query[$param_name];
                }
            }
        } else {
            $query_strings = $this->request->query;
            unset($query_strings['url']); // Can't use ?url=foo

        }
        if (!empty($query_strings)) {
            $query_strings = array_merge($this->request->params['named'], $query_strings);
            $this->redirect($query_strings, null, true);
        }
    }
    function _redirectPOST2Named($paramNames = array())
    {
        //redirect the URL with query string to namedArg like URL structure...
        $query_strings = array();
        foreach($paramNames as $paramName) {
            if (isset($this->request->data['Property'][$paramName])) { //via GET query string
                $query_strings[$paramName] = $this->request->data['Property'][$paramName];
            } elseif (isset($this->request->data['Request'][$paramName])) {
                $query_strings[$paramName] = $this->request->data['Request'][$paramName];
            }
        }
        $query_string_url_format = '';
        if (!empty($query_strings)) {
            // preserve other named params
            $query_strings = array_merge($this->request->params['named'], $query_strings);
            foreach($query_strings as $key => $val) {
                if (($key == 'checkin' || $key == 'checkout') && is_array($val)) {
                    $query_string_url_format.= '/' . strtolower($key) . ':' . date('Y-m-d', mktime(0, 0, 0, $val['month'], $val['day'], $val['year']));
                } else if (is_array($val)) {
                    $query_string_url_format.= '/' . strtolower($key) . ':' . implode(',', $val);
                } else {
                    $query_string_url_format.= '/' . strtolower($key) . ':' . $val;
                }
            }
            //save search keyword into search log
            $searchkeyword = array();
            App::import('Model', 'Properties.SearchKeyword');
            $searchKeywordObj = new SearchKeyword();
            $searchkeyword['SearchKeyword']['keyword'] = $query_string_url_format;
            $searchKeywordObj->save($searchkeyword, false);
            $keyword_id = $searchKeywordObj->getLastInsertId();
            //maintain in search log
            $searchlog = array();
            App::import('Model', 'Properties.SearchLog');
            $searchLogObj = new SearchLog();
            $searchlog['SearchLog']['search_keyword_id'] = $keyword_id;
            $searchlog['SearchLog']['ip_id'] = $searchLogObj->toSaveIp();
            if ($this->Auth->user('id')) {
                $searchlog['SearchLog']['user_id'] = $this->Auth->user('id');
            }
            $searchLogObj->save($searchlog, false);
            //salt mixing
            $salt = $keyword_id+786;
            $hash_query_string = '/' . dechex($keyword_id) . '/' . substr(dechex($salt) , 0, 2);
            if (isset($this->request->data['Property'])) {
                if ($this->RequestHandler->prefers('json')) {
                    $this->redirect(array(
                        'controller' => 'properties',
                        'action' => 'index',
                        $hash_query_string,
                        'admin' => false,
                        'ext' => 'json'
                    ) , null, true);
                } else {
                    $this->redirect(array(
                        'controller' => 'properties',
                        'action' => 'index',
                        $hash_query_string,
                        'admin' => false
                    ) , null, true);
                }
            } else {
                $this->redirect(array(
                    'controller' => 'requests',
                    'action' => 'index',
                    $hash_query_string,
                    'admin' => false
                ) , null, true);
            }
        }
    }
    function show_captcha()
    {
        include_once VENDORS . DS . 'securimage' . DS . 'securimage.php';
        $img = new securimage();
        $img->show(); // alternate use:  $img->show('/path/to/background.jpg');
        $this->autoRender = false;
    }
    function captcha_play($session_var = null)
    {
        include_once VENDORS . DS . 'securimage' . DS . 'securimage.php';
        $img = new Securimage();
        $img->session_var = $session_var;
        $this->disableCache();
        $this->RequestHandler->respondAs('mp3', array(
            'attachment' => 'captcha.mp3'
        ));
        $img->audio_format = 'mp3';
        echo $img->getAudibleCode('mp3');
        $this->autoRender = false;
    }
    function admin_update_status($id = null, $action = null)
    {
		App::import('Model', 'Properties.PropertyUser');
		$this->PropertyUser = new PropertyUser();
		App::import('Model', 'EmailTemplate');
		$this->EmailTemplate = new EmailTemplate();
        App::import('Model', 'Properties.Message');
        $this->Message = new Message();
        $success_message = '';
        $error_message = '';
        if (!empty($this->request->params['named']['featured']) && ($this->request->params['named']['featured'] == 'deactivate')) {
            $field = 'is_featured';
            $value = '0';
        } elseif (!empty($this->request->params['named']['featured']) && ($this->request->params['named']['featured'] == 'activate')) {
            $field = 'is_featured';
            $value = '1';
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'deactivate')) {
            $field = 'is_active';
            $value = '0';
            $success_message = __l('User blocked successfully');
            $this->_sendAdminActionMail($id, 'Admin User Deactivate');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'activate')) {
            $field = 'is_active';
            $value = '1';
            $success_message = __l('User activated successfully');
        } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'suspend')) {
            $field = 'admin_suspend';
            $value = '1';
			if ($this->modelClass == 'Property' && $this->Auth->user('role_id') == ConstUserTypes::Admin) {
				$get_orders = $this->Property->find('first', array(
					'conditions' => array(
						'Property.id' => $id,
					) ,
					'contain' => array(
						'PropertyUser' => array(
							'conditions' => array(
								'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::WaitingforAcceptance
							)
						)
					) ,
					'recursive' => 1
				));
				if (!empty($get_orders['PropertyUser'])) {
					foreach($get_orders['PropertyUser'] as $property_users) {
						$this->PropertyUser->updateStatus($property_users['id'], ConstPropertyUserStatus::CanceledByAdmin);
					}
				}
			}
            $success_message = $this->modelClass . ' ' . __l('suspended successfully');
        } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'unsuspend')) {
            $field = 'admin_suspend';
            $value = '0';
            $success_message = $this->modelClass . ' ' . __l('unsuspended successfully');
        } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'active')) {
            $field = 'is_system_flagged';
            $value = '1';
            $success_message = $this->modelClass . ' ' . __l('flagged successfully');
        } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'deactivate')) {
            $field = 'is_system_flagged';
            $value = '0';
            $success_message = $this->modelClass . ' ' . __l('flag cleared successfully');
        } elseif (!empty($this->request->params['named']['user_flag']) && ($this->request->params['named']['user_flag'] == 'deactivate')) {
            $field = 'is_user_flagged';
            $value = '0';
            $success_message = $this->modelClass . ' ' . __l('flag cleared successfully');
        } elseif (!empty($this->request->params['named']['verify']) && ($this->request->params['named']['verify'] == 'active')) {
            $field = 'is_verified';
            $value = '1';
            $ajax_repsonse = 'verified';
            $success_message = $this->modelClass . ' ' . __l('verified successfully');
        } elseif (!empty($this->request->params['named']['verify']) && ($this->request->params['named']['verify'] == 'deactivate')) {
            $field = 'is_verified';
            $value = '0';
            $success_message = $this->modelClass . ' ' . __l('unverified successfully');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'disapproved')) {
            $field = 'is_approved';
            $value = '0';
            $success_message = $this->modelClass . ' ' . __l('disapproved successfully');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'approved')) {
            $field = 'is_approved';
            $value = '1';
            if ($this->modelClass == 'Property') {
				$this->Property->autofacebookpost($id);
                $property = $this->Property->find('first', array(
                    'conditions' => array(
                        'Property.id' => $id,
                    ) ,
                    'contain' => array(
                        'User'
                    ) ,
                    'recursive' => 0
                ));
                $mail_template = 'New Property Activated';
                if (!empty($mail_template)) {
                    $template = $this->EmailTemplate->selectTemplate($mail_template);
                    $emailFindReplace = array(
                        '##USERNAME##' => $property['User']['username'],
                        '##PROPERTY_NAME##' => $property['Property']['title'],
                        '##PROPERTY_URL##' => Router::url(array(
                            'controller' => 'properties',
                            'action' => 'view',
                            $property['Property']['slug'],
                            'admin' => false,
                        ) , true) ,
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##SITE_URL##' => Router::url('/', true) ,
                        '##FROM_EMAIL##' => ($template['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $template['from'],
						'##UNSUBSCRIBE_LINK##' => Router::url(array(
							'controller' => 'user_notifications',
							'action' => 'edit',
							'admin' => false
						), true),
						'##CONTACT_URL##' => Router::url(array(
							'controller' => 'contacts',
							'action' => 'add',
							'admin' => false
						), true),
                    );
                    $host_email = $property['User']['email'];
                    $email_message = __l('Your property has been activated');
                    $message = strtr($template['email_text_content'], $emailFindReplace);
                    $subject = strtr($template['subject'], $emailFindReplace);
                    if (Configure::read('messages.is_send_internal_message')) {
                        $message_id = $this->Message->sendNotifications($property['User']['id'], $subject, $message, 0, $is_review = 0, $property['Property']['id'], 0);
                        if (Configure::read('messages.is_send_email_on_new_message')) {
                            $content['subject'] = $subject;
                            $content['message'] = $message;
                            if (!empty($host_email)) {
                                $this->Property->_sendAlertOnNewMessage($host_email, $content, $message_id, 'Booking Alert Mail');
                            }
                        }
                    }
                }
            }
            $success_message = $this->modelClass . ' ' . __l('approved successfully');
        } 
        if ($this->modelClass == 'Message' && !empty($this->request->params['named']['flag'])) {
            $this->Message->MessageContent->updateAll(array(
                $field => $value
            ) , array(
                'MessageContent.id' => $id
            ));
            if (!empty($this->request->params['named']['flag']) == 'deactivate') {
                if (Configure::read('messages.is_send_email_on_new_message')) {
                    $this->_reSendMail($id);
                }
            }
            if (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'active')) {
                $success_message = __l('Message flagged successfully');
            } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'deactivate')) {
                $success_message = __l('Message flag cleared successfully');
            }
        } elseif ($this->modelClass == 'Property' && (isset($this->request->params['named']['verify']) && $this->request->params['named']['verify'] == 'active')) {
            $this->{$this->modelClass}->updateAll(array(
                $this->modelClass . '.' . $field => $value,
                $this->modelClass . '.verified_date' => '\'' . date('Y-m-d h:i:s') . '\''
            ) , array(
                $this->modelClass . '.id' => $id
            ));
            $this->Session->setFlash($success_message, 'default', null, 'success');
        } else {
             if (empty($error_message)) {
                $this->{$this->modelClass}->updateAll(array(
                    $this->modelClass . '.' . $field => $value
                ) , array(
                    $this->modelClass . '.id' => $id
                ));
               
                $this->Session->setFlash($success_message, 'default', null, 'success');
            } else {
                $this->Session->setFlash($error_message, 'default', null, 'error');
            }
        }
		$this->redirect(array(
			'action' => 'index',
		));
    }
	function _reSendMail($message_content_id = null)
    {
        App::import('Model', 'Message');
        $this->Message = new Message();
        if (!empty($message_content_id)) {
            $getMessage = $this->Message->find('first', array(
                'conditions' => array(
                    'Message.message_content_id' => $message_content_id,
                    'Message.is_sender' => 1
                ) ,
                'contain' => array(
                    'User',
                    'MessageContent'
                ) ,
                'recursive' => 0
            ));
            if (!empty($getMessage)) {
                $message['message'] = $getMessage['MessageContent']['message'];
                $message['subject'] = $getMessage['MessageContent']['subject'];
                $this->Message->_sendAlertOnNewMessage($getMessage['User']['email'], $message, $message_content_id, 'Alert Mail');
            }
        }
    }
    function admin_update()
    {
        if (!empty($this->request->data[$this->modelClass])) {
            if ($this->modelClass == 'Message' || $this->modelClass == 'MessageContent') {
				// Detach the model for message and message content,so to disable flagging for admin functions
				$this->Message->MessageContent->Behaviors->detach('SuspiciousWordsDetector');
			}
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $ids = array();
            foreach($this->request->data[$this->modelClass] as $id => $is_checked) {
                if ($is_checked['id']) {
                    $ids[] = $id;
                }
            }
            if ($actionid && !empty($ids)) {
                switch ($actionid) {
                    case ConstMoreAction::Inactive:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_active' => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been disabled') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Active:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_active' => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been enabled') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Disapproved:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_approved' => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been disabled') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Approved:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_approved' => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
						if ($this->modelClass == 'Property') {
							App::import('Model','EmailTemplate');
							$this->EmailTemplate = new EmailTemplate();
							 App::import('Model', 'Properties.Message');
							$this->Message = new Message();
							foreach($ids as $id){
							$property = $this->Property->find('first', array(
								'conditions' => array(
									'Property.id' => $id,
								) ,
								'contain' => array(
									'User'
								) ,
								'recursive' => 0
							));
							$mail_template = 'New Property Activated';
								if (!empty($mail_template)) {
									
									$template = $this->EmailTemplate->selectTemplate($mail_template);
									$emailFindReplace = array(
										'##USERNAME##' => $property['User']['username'],
										'##PROPERTY_NAME##' => $property['Property']['title'],
										'##PROPERTY_URL##' => Router::url(array(
											'controller' => 'properties',
											'action' => 'view',
											$property['Property']['slug'],
											'admin' => false,
										) , true) ,
										'##SITE_NAME##' => Configure::read('site.name') ,
										'##SITE_URL##' => Router::url('/', true) ,
										'##FROM_EMAIL##' => ($template['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $template['from'],
										'##UNSUBSCRIBE_LINK##' => Router::url(array(
											'controller' => 'user_notifications',
											'action' => 'edit',
											'admin' => false
										), true),
										'##CONTACT_URL##' => Router::url(array(
											'controller' => 'contacts',
											'action' => 'add',
											'admin' => false
										), true),
									);
									$host_email = $property['User']['email'];
									$email_message = __l('Your property has been activated');
									$message = strtr($template['email_text_content'], $emailFindReplace);
									$subject = strtr($template['subject'], $emailFindReplace);
									if (Configure::read('messages.is_send_internal_message')) {
										$message_id = $this->Message->sendNotifications($property['User']['id'], $subject, $message, 0, $is_review = 0, $property['Property']['id'], 0);
										if (Configure::read('messages.is_send_email_on_new_message')) {
											$content['subject'] = $subject;
											$content['message'] = $message;
											if (!empty($host_email)) {
												$this->Property->_sendAlertOnNewMessage($host_email, $content, $message_id, 'Booking Alert Mail');
											}
										}
									}
								}
							}
						}
                        $this->Session->setFlash(__l('Checked records has been Approved') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Suspend:
                        if ($this->modelClass == 'Message') {
                            $this->{$this->modelClass}->MessageContent->updateAll(array(
                                'MessageContent.admin_suspend' => 1
                            ) , array(
                                'MessageContent.id' => $ids
                            ));
						} else {
							$this->{$this->modelClass}->updateAll(array(
								$this->modelClass . '.admin_suspend' => 1
							) , array(
								$this->modelClass . '.id' => $ids
							));
						}
                        if ($this->modelClass == 'Property') {
                            foreach($ids as $id) {
                                $get_orders = $this->Property->find('first', array(
                                    'conditions' => array(
                                        'Property.id' => $id,
                                    ) ,
                                    'contain' => array(
                                        'PropertyUser'
                                    ) ,
                                    'recursive' => 0
                                ));
                                if (!empty($get_orders['PropertyUser'])) {
                                    foreach($get_orders['PropertyUser'] as $property_user) {
										$this->PropertyUser->updateStatus($property_users['id'], ConstPropertyUserStatus::CanceledByAdmin);
                                    }
                                }
                            }
                        }
                        $this->Session->setFlash(__l('Checked records has been Suspended') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Unsuspend:
                        if ($this->modelClass == 'Message') {
                            $this->{$this->modelClass}->MessageContent->updateAll(array(
                                'MessageContent.admin_suspend' => 0
                            ) , array(
                                'MessageContent.id' => $ids
                            ));
						} else {
							$this->{$this->modelClass}->updateAll(array(
								$this->modelClass . '.admin_suspend' => 0
							) , array(
								$this->modelClass . '.id' => $ids
							));
						}
                        $this->Session->setFlash(__l('Checked records has been changed to Unsuspended') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Unflagged:
                        foreach($ids as $id) {
                            if (!empty($id)) {
                                $messageUserId = $this->Message->find('first', array(
                                    'conditions' => array(
                                        'Message.id' => $id
                                    ) ,
                                    'recursive' => -1
                                ));
                                $saveMessage['id'] = $messageUserId['Message']['message_content_id'];
                                if (Configure::read('messages.is_send_email_on_new_message')) {
                                    $this->_reSendMail($messageUserId['Message']['message_content_id']); // RESEND CLEARED MESSAGES //

                                }
                                $saveMessage['is_system_flagged'] = 0;
                                $this->Message->MessageContent->save($saveMessage);
                            }
                        }
                        $this->Session->setFlash(__l('Checked records has been changed to Unflagged') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Flagged:
                        foreach($ids as $id) {
                            if (!empty($id)) {
                                $messageUserId = $this->Message->find('first', array(
                                    'conditions' => array(
                                        'Message.id' => $id
                                    ) ,
                                    'recursive' => -1
                                ));
                                $saveMessage['id'] = $messageUserId['Message']['message_content_id'];
                                $saveMessage['is_system_flagged'] = 1;
                                $this->Message->MessageContent->save($saveMessage);
                            }
                        }
                        $this->Session->setFlash(__l('Checked records has been changed to flagged') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Delete:
                        $is_not_deleted = $is_deleted = 0;
                        foreach($ids as $id) {
                            if ($this->modelClass == 'CancellationPolicy') {
								$properties_count="";
								if(isPluginEnabled('Properties')){
									$properties_count = $this->CancellationPolicy->Property->find('count', array(
										'conditions' => array(
											'Property.cancellation_policy_id' => $id
										) ,
										'recursive' => -1
									));
								}
                                if (!empty($properties_count)) {
                                    $is_not_deleted = 1;
                                } else {
                                    $is_deleted = 1;
                                    $this->{$this->modelClass}->delete($id);
                                }
                            } else {
                                $this->{$this->modelClass}->delete($id);
                            }
                        }
                        if (!empty($is_not_deleted) && !empty($is_deleted)) {
                            $this->Session->setFlash(__l('Checked records has been deleted. Some records are not deleted due to properties was assigned to the cancellation policy.') , 'default', null, 'success');
                        } elseif (!empty($is_not_deleted)) {
                            $this->Session->setFlash(__l('No records deleted. Some properties was assigned to the cancellation policy.') , 'default', null, 'error');
                        } else {
                            $this->Session->setFlash(__l('Checked records has been deleted') , 'default', null, 'success');
                        }
                        break;

                    case ConstMoreAction::Export:
                        $user_ids = implode(',', $userIds);
                        $hash = $this->{$this->modelClass}->getUserIdHash($user_ids);
                        $_SESSION['user_export'][$hash] = $userIds;
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'export',
                            'ext' => 'csv',
                            $hash,
                            'admin' => true
                        ));
                        break;
                    }
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
    public function updateactions($id = null, $action = null)
    {
		if (isset($_GET['r'])) {
            $r = $_GET['r'];
        } else {
            $r = '';
        }
        //check valid user
        $valid = $this->
        {
            $this->modelClass}->find('first', array(
                'conditions' => array(
                    $this->modelClass . '.id' => $id,
                    $this->modelClass . '.user_id' => $this->Auth->user('id')
                ) ,
                'fields' => array(
                    $this->modelClass . '.id'
                ) ,
                'recursive' => -1
            ));
            if (empty($valid)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            if (!empty($action) && $action == 'inactive') {
                $this->{$this->modelClass}->updateAll(array(
                    $this->modelClass . '.is_active' => 0
                ) , array(
                    $this->modelClass . '.id' => $id
                ));
				$setFlash = $this->modelClass . ' ' . __l(' has been disabled');
            } elseif (!empty($action) && $action == 'active') {
                $this->{$this->modelClass}->updateAll(array(
                    $this->modelClass . '.is_active' => 1
                ) , array(
                    $this->modelClass . '.id' => $id
                ));
				$setFlash = $this->modelClass . ' ' . __l(' has been enabled');
            } elseif (!empty($action) && $action == 'verified') {
                $this->{$this->modelClass}->updateAll(array(
                    $this->modelClass . '.is_verified' => 2
                ) , array(
                    $this->modelClass . '.id' => $id
                ));
                $setFlash = $this->modelClass . ' ' . __l(' has been sent for verified');
            } elseif (!empty($action) && $action == 'delete') {
                $this->{$this->modelClass}->deleteAll(array(
                    $this->modelClass . '.id' => $id
                ));
                $setFlash = $this->modelClass . ' ' . __l(' has been deleted');
            }
            if (!$this->RequestHandler->isAjax()) {
				$this->Session->setFlash($setFlash , 'default', null, 'success');
                $this->redirect(Router::url('/', true) . $r);
            } else {
                //$this->redirect($r);
                exit;
            }
        }
        function update_propertyUserStatus($id = null, $status_id = null)
        {
            $r = $_GET['r'];
            if (!empty($status_id)) {
                $this->{$this->modelClass}->updateAll(array(
                    $this->modelClass . '.property_user_status_id' => $status_id
                ) , array(
                    $this->modelClass . '.id' => $id
                ));
                $this->Session->setFlash(__l('Booking status updated') , 'default', null, 'success');
            }
            if (!$this->RequestHandler->isAjax()) {
                $this->redirect(Router::url('/', true) . $r);
            } else {
                $this->redirect($r);
            }
        }
        function _uuid()
        {
            return sprintf('%07x%1x', mt_rand(0, 0xffff) , mt_rand(0, 0x000f));
        }
        function _unum()
        {
            $acceptedChars = '0123456789';
            $max = strlen($acceptedChars) -1;
            $unique_code = '';
            for ($i = 0; $i < 8; $i++) {
                $unique_code.= $acceptedChars{mt_rand(0, $max) };
            }
            return $unique_code;
        }
        function _affiliate_referral()
        {
            foreach($this->request->params['named'] as $key => $value) {
                if (empty($key)) {
					App::import('Model', 'User');
					$this->User = new User();
					if ($this->User->find('count', array(
                        'conditions' => array(
                            'User.username' => $value,
                            'User.is_affiliate_user' => 1
                        ) ,
                        'recursive' => -1
                    ))) {
                        $this->request->params['named']['r'] = $value;
                        unset($this->request->params['named'][$key]);
                        unset($this->request->params['named']['referer']);
                    }
                }
            }
            if (!empty($this->request->params['named']['r'])) {
				App::import('Model', 'User');
				$this->User = new User();
                $referrer = array();
                $user = $this->User->find('first', array(
                    'conditions' => array(
                        'User.username' => $this->request->params['named']['r'],
                        'User.is_affiliate_user' => 1
                    ) ,
                    'fields' => array(
                        'User.username',
                        'User.id'
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($user)) {
                    // not check for particular url or page, so that set in refer_id in common, future apply for specific url
                    $referrer = $user['User']['id'];
                    $this->Cookie->delete('referrer');
                    $this->Cookie->write('referrer', $referrer, false, sprintf('+%s hours', Configure::read('affiliate.referral_cookie_expire_time')));
                    unset($this->request->params['named']['r']);
                    $params = '';
                    foreach($this->request->params['pass'] as $value) {
                        $params.= $value . '/';
                    }
                    foreach($this->request->params['named'] as $key => $value) {
                        if ($key != 'r') {
                            $params.= $key . ':' . $value . '/';
                        }
                    }
                    $this->redirect(array(
                        'controller' => $this->request->params['controller'],
                        'action' => $this->request->params['action'],
                        $params
                    ));
                }
            }
        }
        function __excludeZeroArray($array)
        {
            foreach($array as $array_key => $array_item) {
                if ($array[$array_key] == 0) {
                    unset($array[$array_key]);
                }
            }
            return $array;
        }
        // For iPhone App code -->
        function _cacheWriteCurrency()
        {
            // write currency in cache
            $_currencies = Cache::read('site_currencies');
            if (empty($_currencies)) {
                App::import('Model', 'Currency');
                $this->Currency = new Currency();
                $_currencies = $this->Currency->cacheCurrency();
                Cache::write('site_currencies', $_currencies);
            }
            $GLOBALS['currencies'] = Cache::read('site.currencies');
            $currency_code = Configure::read('site.currency_id');
            if (!empty($_COOKIE['CakeCookie']['user_currency'])) {
                $currency_code = $_COOKIE['CakeCookie']['user_currency'];
            }
            if (!empty($GLOBALS['currencies'][$currency_code]['Currency']['is_prefix_display_on_left'])) {
                Configure::write('site.currency_symbol_place', 'left');
            } else {
                Configure::write('site.currency_symbol_place', 'right');
            }
            Configure::write('site.currency', !empty($GLOBALS['currencies'][$currency_code]['Currency']['symbol']) ? $GLOBALS['currencies'][$currency_code]['Currency']['symbol'] : '');
        }
        function forceSSL()
        {
            if (!env('HTTPS')) {
                $this->redirect('https://' . env('SERVER_NAME') . $this->request->here);
            }
        }
        function _unforceSSL()
        {
            if (empty($this->request->params['requested'])) {
                $this->redirect('http://' . $_SERVER['SERVER_NAME'] . $this->request->here);
            }
        }
    }