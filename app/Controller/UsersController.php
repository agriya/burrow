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
class UsersController extends AppController
{
    public $name = 'Users';
    public $components = array(
        'Email',
		'PersistentLogin'
    );
	public $uses = array(
		'User'
    );
    public $helpers = array(
        'Csv',
    );
	
    public $permanentCacheAction = array(
		'user' => array(
			'show_header',
			'dashboard',
			'hosting_panel',
			'change_password',
			'refer',
			'add_to_wallet',
			'social',
		) ,
		'public' => array(
			'top_rated',
		) ,
        'is_view_count_update' => true
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'User.send_to_user_id',
            'User.referred_by_user_id',
            'User.adaptive_normal',
            'User.adaptive_connect',
            'User.payment_type',
            'User.is_show_new_card',
			'adcopy_response',
            'adcopy_challenge',
        );
        parent::beforeFilter();
    }
    public function view($username = null)
    {
        $this->pageTitle = __l('User');
        if (is_null($username)) {
            throw new NotFoundException(__l('Invalid request'));
        }
		$contain = array(
            'UserProfile' => array(
				'fields' => array(
					'UserProfile.created',
					'UserProfile.about_me',
				) ,
			)
        );
		if (isPluginEnabled('SocialMarketing')) {
            $contain['UserFollower'] = array(
				'conditions' => array(
					'UserFollower.user_id' => $this->Auth->user('id') ,
				)
			);
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.username = ' => $username
            ) ,
            'contain' => $contain,
            'recursive' => 2
        ));
        if ($this->RequestHandler->prefers('kml')) {
            $this->set('user', $user);
        } else {
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $this->User->UserView->create();
            $this->request->data['UserView']['user_id'] = $user['User']['id'];
            $this->request->data['UserView']['viewing_user_id'] = $this->Auth->user('id');
            $this->request->data['UserView']['ip_id'] = $this->User->UserView->toSaveIp();;
            $this->User->UserView->save($this->request->data);
            $this->pageTitle.= ' - ' . $username;
            $this->set('user', $user);
        }
    }
    public function register()
    {
		App::import('Model', 'Payment');
		$this->Payment = new Payment();
        $this->pageTitle = __l('User Registration');
        $is_register = 1;
        $user_type_check = $this->Session->read('user_type');
        if((!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'social') && ( !Configure::read('twitter.is_enabled_twitter_connect') && !Configure::read('facebook.is_enabled_facebook_connect') && !Configure::read('linkedin.is_enabled_linkedin_connect') && !Configure::read('yahoo.is_enabled_yahoo_connect') &&  !Configure::read('google.is_enabled_google_connect') && !Configure::read('googleplus.is_enabled_googleplus_connect') && !Configure::read('openid.is_enabled_openid_connect'))) {
			$this->redirect(array(
				'controller' => 'users',
				'action' => 'register',
			));
		}
        if (Configure::read('site.launch_mode') == "Private Beta" && !empty($this->request->data) || !empty($_SESSION['invite_hash'])) {
            if (!empty($_SESSION['invite_hash'])) {
			} elseif (isset($this->request->data['User']['invite_hash']) && !empty($this->request->data['User']['invite_hash'])) {
				$is_valid = "";
				if(isPluginEnabled('LaunchModes')){
					$is_valid = $this->Subscription->find('count', array(
						'conditions' => array(
							'Subscription.invite_hash' => $this->request->data['User']['invite_hash']
						),
						'recursive' => -1,
					));
				}
                if ($is_valid) {
                    $this->Session->setFlash(sprintf(__l('You have submitted invitation code successfully, Welcome to %s'), Configure::read('site.name')) , 'default', null, 'success');
                    unset($this->request->data['User']);
                }
            }
        } elseif (Configure::read('site.launch_mode') == "Private Beta") {
			if (empty($socialuser))
			{
				$this->redirect(Router::url('/', true));
				$is_register = 0;
			}
        }
		if ($is_register) {
			if ($referred_by_user_id = $this->Cookie->read('referrer')) {
				$referredByUser = $this->User->find('first', array(
					'conditions' => array(
						'User.id' => $referred_by_user_id
					) ,
					'contain' => array(
						'UserAvatar',
						'UserProfile'
					) ,
					'recursive' => 2
				));
				$this->set('referredByUser', $referredByUser);
			}
			$captcha_flag = 1;
			$socialuser = $this->Session->read('socialuser');
			if (!empty($socialuser) && empty($this->request->data)) {
				$this->Session->delete('socialuser');
				$this->request->data['User'] = $socialuser;
				$captcha_flag = 0;
			}
			if (!empty($this->request->data)) {
				$captcha_error = 0;
                if ($captcha_flag) {
                    if (Configure::read('system.captcha_type') == "Solve Media") {
                        if (!$this->User->_isValidCaptchaSolveMedia()) {
                            $captcha_error = 1;
                        }
                    }
                }
				if (empty($captcha_error)) {
					$this->User->set($this->request->data);
					if ($this->User->validates() &$this->User->UserProfile->validates()) {
						$this->User->create();
						if (!isset($this->request->data['User']['passwd']) && !isset($this->request->data['User']['twitter_user_id'])) {
							$this->request->data['User']['password'] = getCryptHash($this->request->data['User']['email'] . Configure::read('Security.salt'));
							//For open id register no need for email confirm, this will override is_email_verification_for_register setting
							$this->request->data['User']['is_agree_terms_conditions'] = 1;
							$this->request->data['User']['is_email_confirmed'] = 1;
						} elseif (!empty($this->request->data['User']['twitter_user_id'])) { // Twitter modified registration: password  -> twitter user id and salt //
							$this->request->data['User']['password'] = getCryptHash($this->request->data['User']['twitter_user_id'] . Configure::read('Security.salt'));
							$this->request->data['User']['is_email_confirmed'] = 1;
						} else {
							$this->request->data['User']['password'] = getCryptHash($this->request->data['User']['passwd']);
							$this->request->data['User']['is_email_confirmed'] = (Configure::read('user.is_email_verification_for_register')) ? 0 : 1;
						}
						if (!Configure::read('user.signup_fee')) {
							$this->request->data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;
						}
						$this->request->data['User']['role_id'] = ConstUserTypes::User;
						$this->request->data['User']['ip_id'] = $this->User->toSaveIp();
						if (Configure::read('site.launch_mode') == 'Private Beta' && isset($_SESSION['invite_hash'])) {
							$Subscription = "";
							if(isPluginEnabled('LaunchModes')){
								App::import('Model', 'LaunchModes.Subscription');
								$this->Subscription = new Subscription;
								$Subscription = $this->Subscription->find('first', array(
									'fields' => array(
										'Subscription.id',
										'Subscription.site_state_id'
									),
									'conditions' => array(
										'Subscription.invite_hash' => $_SESSION['invite_hash']
									),
									'recursive' => -1,
								));
							}
							$this->request->data['User']['is_sent_private_beta_mail'] = 1;
							if(!empty($Subscription)) {
								$this->request->data['User']['site_state_id'] = $Subscription['Subscription']['site_state_id'];
							} else {
								$this->request->data['User']['site_state_id'] = ConstSiteState::PrivateBeta;
							}
						} else {
							$Subscription = "";
							if(isPluginEnabled('LaunchModes')){
								App::import('Model', 'LaunchModes.Subscription');
								$this->Subscription = new Subscription;
								$Subscription = $this->Subscription->find('first', array(
									'fields' => array(
										'Subscription.id',
										'Subscription.site_state_id'
									),
									'conditions' => array(
										'Subscription.email' => $this->request->data['User']['email']
									),
									'recursive' => -1,
								));
							}
							if(!empty($Subscription)) {
								$this->request->data['User']['site_state_id'] = $Subscription['Subscription']['site_state_id'];;
							} else {
								$this->request->data['User']['site_state_id'] = ConstSiteState::Launched;
							}
						}
						if ($this->User->save($this->request->data, false)) {
							if ($referred_by_user_id = $this->Cookie->read('referrer')) {
								$referredUser = $this->User->find('first', array(
									'conditions' => array(
										'User.id' => $referred_by_user_id
									) ,
									'recursive' => -1
								));
								$this->request->data['User']['referred_by_user_id'] = $referred_by_user_id;
								if(isPluginEnabled('SocialMarketing'))
								{
									$this->_referer_follow($this->User->id, $referred_by_user_id, $this->request->data['User']['username']);
									$this->_referer_follow($referred_by_user_id, $this->User->id, $referredUser['User']['username']);
								}
							}
							if(!empty($Subscription)) {
								$this->request->data['Subscription']['user_id'] = $this->User->id;
								$this->request->data['Subscription']['id'] = $Subscription['Subscription']['id'];
								$this->Subscription->save($this->request->data);
							}
							unset($_SESSION['invite_hash']);
							if(!empty($_SESSION['refer_id'])) {
								$this->User->updateAll(array(
									'User.referred_by_user_count' => 'User.referred_by_user_count + ' . '1'
								) , array(
									'User.id' => $_SESSION['refer_id']
								));
								unset($_SESSION['refer_id']);
							}
							$this->request->data['User']['id'] = $this->request->data['UserProfile']['user_id'] = $this->User->getLastInsertId();
							$this->User->UserProfile->create();
							$this->User->UserProfile->save($this->request->data['UserProfile'], false);
							$_data['UserProfile'] = $this->request->data['UserProfile'];
							$_data['UserProfile']['id'] = $this->User->UserProfile->getLastInsertId();
							// send to admin mail if is_admin_mail_after_register is true
								App::import('Model', 'EmailTemplate');
								$this->EmailTemplate = new EmailTemplate();
								$email = $this->EmailTemplate->selectTemplate('New User Join');						
							  if(Configure::read('user.is_admin_mail_after_register')==1) {
								  $emailFindReplace = array(
									'##USERNAME##' => $this->request->data['User']['username'],
									'##USEREMAIL##' => $this->request->data['User']['email'],
									// @todo "IP table logic"
									'##FROM_EMAIL##' => ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'],
									'##EMAIL##' => $this->request->data['User']['email'],
									'##SIGNUP_IP##' => $this->RequestHandler->getClientIP() ,
								);
							   // Send e-mail to users
								$this->User->_sendEmail($email, $emailFindReplace, Configure::read('site.contact_email'));
								}
								if (Configure::read('user.is_admin_activate_after_register')) {
									$this->Session->setFlash(__l('You have successfully registered with our site. after administrator approval you can login to site') , 'default', null, 'success');
								} else {
									$this->Session->setFlash(__l('You have successfully registered with our site.') , 'default', null, 'success');
								}
							if (!empty($this->request->data['User']['openid_url'])) {
								$this->request->data['UserOpenid']['openid'] = $this->request->data['User']['openid_url'];
								$this->request->data['UserOpenid']['user_id'] = $this->User->id;
								$this->User->UserOpenid->create();
								$this->User->UserOpenid->save($this->request->data);
							}
							if (Configure::read('user.signup_fee')) {
								$is_third_party_register = 0;
								// Twitter modified registration: conditions added for twitter login after registration //
								if (!empty($this->request->data['User']['is_openid_register']) || !empty($this->request->data['User']['is_linkedin_register']) || !empty($this->request->data['User']['is_google_register']) || !empty($this->request->data['User']['is_googleplus_register']) || !empty($this->request->data['User']['is_yahoo_register']) || !empty($this->request->data['User']['is_facebook_register']) || !empty($this->request->data['User']['is_twitter_register'])) {
									$is_third_party_register = 1;
									// send welcome mail to user if is_welcome_mail_after_register is true
									if (Configure::read('user.is_welcome_mail_after_register')) {
										$this->_sendWelcomeMail($this->User->id, $this->request->data['User']['email'], $this->request->data['User']['username']);
									}
									$this->_checkOrderPlaced($this->User->id);
									$this->_sendMembershipMail($this->request->data['User']['id'], $this->User->getActivateHash($this->request->data['User']['id']));
									if (Configure::read('user.is_admin_activate_after_register') && Configure::read('user.is_email_verification_for_register') && empty($is_third_party_register)) {
										$this->Session->setFlash(__l(' You have successfully registered with our site you can login after email verification and administrator approval, but you can able to access all features after paying signup fee.') , 'default', null, 'success');
									} else if (Configure::read('user.is_admin_activate_after_register')) {
										$this->Session->setFlash(__l(' You have successfully registered with our site after administrator approval you can login to site, but you can able to access all features after paying signup fee.') , 'default', null, 'success');
									} else if (Configure::read('user.is_email_verification_for_register') && empty($is_third_party_register)) {
										$this->Session->setFlash(__l(' You have successfully registered with our site you can login after email verification, but you can able to access all features after paying signup fee.') , 'default', null, 'success');
									} else {
										$this->Session->setFlash(__l(' You have successfully registered with our site you can login now, but you can able to access all features after paying signup fee.') , 'default', null, 'success');
									}
									$this->redirect(array(
										'controller' => 'payments',
										'action' => 'membership_pay_now',
										$this->request->data['User']['id'],
										$this->User->getActivateHash($this->request->data['User']['id'])
									));
									if ($this->Auth->login($this->request->data)) {
										$this->User->UserLogin->insertUserLogin($this->request->data['User']['id']);
										if ($this->RequestHandler->isAjax()) {
											echo 'success';
											exit;
										} else {
											$this->redirect(array(
												'controller' => 'user_profiles',
												'action' => 'edit'
											));
										}
									}
								} else {
									//For openid register no need to send the activation mail, so this code placed in the else
									// @todo "User activation" check setting (Yahoo, Gmail, Openid & Normal) and send "Activation Request" mail
									if (Configure::read('user.is_email_verification_for_register')) {
										$this->Session->setFlash(__l('You have successfully registered with our site and your activation mail has been sent to your mail inbox.') , 'default', null, 'success');
										$this->_sendActivationMail($this->request->data['User']['email'], $this->User->id, $this->User->getActivateHash($this->request->data['User']['id']));
									}
									
									$this->_checkOrderPlaced($this->User->id);
									if (Configure::read('user.signup_fee')) {
										$this->_sendMembershipMail($this->request->data['User']['id'], $this->User->getActivateHash($this->request->data['User']['id']));
										$this->Session->setFlash(__l(' You have successfully registered with our site after paying membership fee only login to site.') , 'default', null, 'success');
										$this->redirect(array(
											'controller' => 'payments',
											'action' => 'membership_pay_now',
											$this->request->data['User']['id'],
											$this->User->getActivateHash($this->request->data['User']['id'])
										));
									}
								}
							} else {
								$user = $this->User->find('first', array(
										'conditions' => array(
											'User.id' => $this->User->id
										) ,
										'recursive' => -1
									));
									if (!empty($this->request->data['User']['is_linkedin_register'])) {
										$label = 'LinkedIn';
									} else if (!empty($this->request->data['User']['is_facebook_register'])) {
										$label = 'Facebook';
									} else if (!empty($this->request->data['User']['is_twitter_register'])) {
										$label = 'Twitter';
									} else if (!empty($this->request->data['User']['is_yahoo_register'])) {
										$label = 'Yahoo!';
									} else if (!empty($this->request->data['User']['is_google_register'])) {
										$label = 'Gmail';
									} else if (!empty($this->request->data['User']['is_googleplus_register'])) {
										$label = 'GooglePlus';
									} else {
										$label = 'Direct';
									}
									$this->_checkOrderPlaced($this->User->id);
									Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
										'_trackEvent' => array(
											'category' => 'User',
											'action' => 'Registered',
											'label' => $label,
											'value' => '',
										) ,
										'_setCustomVar' => array(
											'ud' => $user['User']['id'],
											'rud' => $user['User']['referred_by_user_id'],
										)
									));
									if (!empty($user['User']['referred_by_user_id'])) {
										$referredUser = $this->User->find('first', array(
											'conditions' => array(
												'User.id' => $user['User']['referred_by_user_id']
											) ,
											'recursive' => -1
										));
										Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
											'_trackEvent' => array(
												'category' => 'User',
												'action' => 'Referred',
												'label' => $referredUser['User']['username'],
												'value' => '',
											) ,
											'_setCustomVar' => array(
												'ud' => $user['User']['id'],
												'rud' => $user['User']['referred_by_user_id'],
											)
										));
									}
							}
							if (Configure::read('user.is_admin_activate_after_register')) {
                                $this->Session->setFlash(__l('You have successfully registered with our site. after administrator approval you can login to site') , 'default', null, 'success');
                            } else {
                                $this->Session->setFlash(__l('You have successfully registered with our site.') , 'default', null, 'success');
                            }
                            if (!empty($this->request->data['User']['openid_user_id']) || !empty($this->request->data['User']['linkedin_user_id']) || !empty($this->request->data['User']['google_user_id']) || !empty($this->request->data['User']['googleplus_user_id']) || !empty($this->request->data['User']['facebook_user_id']) || !empty($this->request->data['User']['twitter_user_id']) || !empty($this->request->data['User']['yahoo_user_id'])) {
                                // send welcome mail to user if is_welcome_mail_after_register is true
                                if (Configure::read('user.is_welcome_mail_after_register')) {
                                    $this->_sendWelcomeMail($this->User->id, $this->request->data['User']['email'], $this->request->data['User']['username']);
                                }
                                if ($this->Auth->login()) {
                                    $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                                }
                            } else {
                                //For openid register no need to send the activation mail, so this code placed in the else
                                if (Configure::read('user.is_email_verification_for_register')) {
                                    $this->Session->setFlash(__l('You have successfully registered with our site and your activation mail has been sent to your mail inbox.') , 'default', null, 'success');
                                    $this->_sendActivationMail($this->request->data['User']['email'], $this->User->id, $this->User->getActivateHash($this->request->data['User']['id']));
                                }
                            }
							if (!$this->Auth->user('id')) {
								// send welcome mail to user if is_welcome_mail_after_register is true
								if (!Configure::read('user.is_email_verification_for_register') and !Configure::read('user.is_admin_activate_after_register') and Configure::read('user.is_welcome_mail_after_register')) {
									$this->_sendWelcomeMail($this->User->id, $this->request->data['User']['email'], $this->request->data['User']['username']);
								}
								// @todo "User activation" check setting (Yahoo, Gmail, Openid & Normal) and do auto login
								if (!Configure::read('user.is_email_verification_for_register') and !Configure::read('user.is_admin_activate_after_register') and Configure::read('user.is_auto_login_after_register')) {
									$this->Session->setFlash(__l('You have successfully registered with our site.') , 'default', null, 'success');
									if ($this->Auth->login()) {
										$cookie_value = $this->Cookie->read('referrer');
										if (!empty($cookie_value) && (!isPluginEnabled('Affiliates'))) {
											$this->Cookie->delete('referrer'); // Delete referer cookie

										}
										$this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
										if ($this->RequestHandler->isAjax()) {
											echo 'success';
											exit;
										} else {
											$this->redirect(array(
												'controller' => 'user_profiles',
												'action' => 'edit'
											));
										}
									}
								}
							}
							if ($this->RequestHandler->isAjax()) {
								echo 'success';
								exit;
							} else {
								$this->redirect(array(
									'controller' => 'users',
									'action' => 'login'
								));
							}
						}
					} else {
						if(!empty($this->request->data['User']['provider'])) {
							if (!empty($this->request->data['User']['is_google_register'])) {
								$flash_verfy = 'Gmail';
							} elseif (!empty($this->request->data['User']['is_googleplus_register'])) {
								$flash_verfy = 'GooglePlus';
							} elseif (!empty($this->request->data['User']['is_yahoo_register'])) {
								$flash_verfy = 'Yahoo!';
							} else {
								$flash_verfy = $this->request->data['User']['provider'];
							}
							$this->Session->setFlash($flash_verfy . ' ' . __l('verification is completed successfully. But you have to fill the following required fields to complete our registration process.') , 'default', null, 'success');
						} else {
								$this->request->data['User']['captcha'] = null;
							$this->Session->setFlash(__l('Your registration process is not completed. Please, try again.') , 'default', null, 'error');
						}
					}
				} else {
                    $this->Session->setFlash(__l('Please enter valid captcha') , 'default', null, 'error');
                }
			}
			unset($this->request->data['User']['passwd']);
            // When already logged user trying to access the registration page we are redirecting to site home page
            if ($this->Auth->user()) {
                $this->redirect(Router::url('/', true));
            }
			if (isPluginEnabled('SecurityQuestions')) {
				App::import('Model', 'SecurityQuestions.SecurityQuestion');
				$this->SecurityQuestion = new SecurityQuestion();						
                $securityQuestions = $this->SecurityQuestion->find('list', array(
					'conditions' => array(
						'SecurityQuestion.is_active' => 1
					),
					'recursive' => -1,
                ));
                $this->set(compact('securityQuestions'));
            }
			if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'social' && $is_register) {
                $this->render('thirdparty_register');
            }
		}
        //for user referral system
        if (empty($this->request->data) && isPluginEnabled('Affiliates')) {
            //user id will be set in cookie
            $cookie_value = $this->Cookie->read('referrer');
            if (!empty($cookie_value)) {
                $this->request->data['User']['referred_by_user_id'] = $cookie_value['refer_id'];
            }
        }
        unset($this->request->data['User']['passwd']);
        // When already logged user trying to access the registration page we are redirecting to site home page
        if ($this->Auth->user()) {
            $this->redirect(Router::url('/', true));
        }
        if ($this->RequestHandler->isAjax()) {
            $this->render('register_ajax');
        }
		if (!$is_register && empty($socialuser)) {
            $this->layout = 'subscription';
            $this->render('invite_page');
        }
    }
    // For iPhone App code -->
    function oauth_facebook()
    {
        App::import('Vendor', 'facebook/facebook');
        $this->facebook = new Facebook(array(
            'appId' => Configure::read('facebook.app_id') ,
            'secret' => Configure::read('facebook.secrect_key') ,
            'cookie' => true
        ));
        $this->autoRender = false;
        if (!empty($_REQUEST['code'])) {
            $tokens = $this->facebook->setAccessToken(array(
                'redirect_uri' => Router::url(array(
                    'controller' => 'users',
                    'action' => 'oauth_facebook',
                    'admin' => false
                ) , true) ,
                'code' => $_REQUEST['code']
            ));
            $fb_return_url = $this->Session->read('fb_return_url');
            $this->redirect($fb_return_url);
        } else {
            $this->Session->setFlash(__l('Invalid Facebook Connection.') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
        exit;
    }
	 public function validate_user()
    {
		$this->Session->delete('HA::CONFIG');
        $this->Session->delete('HA::STORE');
        $this->Auth->logout();
        Cms::dispatchEvent('Controller.User.validate_user', $this, array(
            'data' => $this->request->data
        ));
    }
    public function _checkOrderPlaced($user_id)
    {
        if (!empty($_SESSION['order_id'])) {
            $order_id = $_SESSION['order_id'];
            $propertyUser = $this->User->PropertyUser->find('first', array(
                'conditions' => array(
                    'PropertyUser.id' => $order_id,
                ) ,
                'recursive' => -1
            ));
            if (empty($propertyUser['PropertyUser']['user_id']) && $this->Auth->user('id') != $propertyUser['PropertyUser']['owner_user_id']) {
                $data = array();
                $data['PropertyUser']['id'] = $order_id;
                $data['PropertyUser']['user_id'] = $user_id;
                $this->User->PropertyUser->save($data, false);
                unset($_SESSION['order_id']);
				$_SESSION['order_redirect_url'] = Router::url(array(
					'controller' => 'properties',
					'action' => 'order',
					$propertyUser['PropertyUser']['property_id'],
					'order_id' => $propertyUser['PropertyUser']['id']
				), true);
            }
        }
    }
    // For iPhone App code -->
    public function dashboard()
    {
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'contain' => array(
                'Property',
                'PropertyUser'
            ) ,
            'recursive' => 1
        ));
        $this->pageTitle = __l('Dashboard');
        $purchase_conditions['PropertyUser.user_id'] = $this->Auth->user('id');
        $purchase_conditions['NOT']['PropertyUser.property_user_status_id'] = array(
            ConstPropertyUserStatus::Canceled,
            ConstPropertyUserStatus::Rejected,
            ConstPropertyUserStatus::Expired,
            ConstPropertyUserStatus::CanceledByAdmin,
        );
        $total_purchased = $this->User->PropertyUser->find('first', array(
            'conditions' => $purchase_conditions,
            'fields' => array(
                'SUM(PropertyUser.price) as total_amount'
            ) ,
            'recursive' => -1
        ));
        $this->set('user', $user);
        $this->set('total_purchased', $total_purchased);
        // Buyer Orders //
        $filter_count = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        $all_count = ($filter_count['User']['travel_expired_count']+$filter_count['User']['travel_rejected_count']+$filter_count['User']['travel_canceled_count']+$filter_count['User']['travel_review_count']+$filter_count['User']['travel_completed_count']+$filter_count['User']['travel_arrived_count']+$filter_count['User']['travel_confirmed_count']+$filter_count['User']['travel_waiting_for_acceptance_count']+$filter_count['User']['travel_negotiation_count']+$filter_count['User']['travel_payment_pending_count']+$filter_count['User']['travel_arrived_count']);
        $this->set('all_count', $all_count);
        $status = array(
            __l('Arrived / Confirmed') => array(
                'in_progress',
                ($filter_count['User']['travel_arrived_count']+$filter_count['User']['travel_confirmed_count']) ,
                'arrivedconfirmed'
            ) ,
            __l('Pending Host Accept') => array(
                'waiting_for_acceptance',
                $filter_count['User']['travel_waiting_for_acceptance_count'],
                'pendinghostaccept'
            ) ,
            __l('Arrived') => array(
                'arrived',
                $filter_count['User']['travel_arrived_count'],
                'arrived'
            ) ,
            __l('Waiting For Your Review') => array(
                'waiting_for_review',
                $filter_count['User']['travel_review_count'],
                'waitingforyourreview'
            ) ,
            __l('Completed') => array(
                'completed',
                $filter_count['User']['travel_completed_count'],
                'completed'
            ) ,
            __l('Canceled') => array(
                'canceled',
                $filter_count['User']['travel_canceled_count'],
                'cancelled'
            ) ,
            __l('Host Rejected') => array(
                'rejected',
                $filter_count['User']['travel_rejected_count'],
                'hostrejected'
            ) ,
            __l('Expired') => array(
                'expired',
                $filter_count['User']['travel_expired_count'],
                'expired'
            ) ,
            __l('Negotiation') => array(
                'negotiation',
                $filter_count['User']['travel_negotiation_count'],
                'negotiationrequested'
            ) ,
            __l('Payment Pending') => array(
                'payment_pending',
                $filter_count['User']['travel_payment_pending_count'],
                'paymentpending'
            ) ,
        );
        $this->set('moreActions', $status);
        App::import('Model', 'Properties.Property');
		$this->Property = new Property();
		$this->set('host_all_count', $this->Property->find('count', array(
                'conditions' => array(
                    'Property.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            )));
        $host_status = array(
            __l('Confirmed') => array(
                'confirmed',
                ($filter_count['User']['host_confirmed_count']) ,
                'confirmed'
            ) ,
            __l('Waiting for Acceptance') => array(
                'waiting_for_acceptance',
                $filter_count['User']['host_waiting_for_acceptance_count'],
                'waitingforacceptance'
            ) ,
            __l('Waiting for Traveler Review') => array(
                'waiting_for_review',
                $filter_count['User']['host_review_count'],
                'waitingforyourreview'
            ) ,
            __l('Completed') => array(
                'completed',
                $filter_count['User']['host_completed_count'],
                'completed'
            ) ,
            __l('Arrived') => array(
                'arrived',
                $filter_count['User']['host_arrived_count'],
                'arrived'
            ) ,
            __l('Canceled') => array(
                'canceled',
                $filter_count['User']['host_canceled_count'],
                'cancelled'
            ) ,
            __l('Rejected') => array(
                'rejected',
                $filter_count['User']['host_rejected_count'],
                'rejected'
            ) ,
            __l('Expired') => array(
                'expired',
                $filter_count['User']['host_expired_count'],
                'expired'
            ) ,
            __l('Negotiation') => array(
                'negotiation',
                $filter_count['User']['host_negotiation_count'],
                'negotiationrequested'
            ) ,
            __l('Payment Cleared') => array(
                'payment_cleared',
                $filter_count['User']['host_payment_cleared_count'],
                'payment_cleared '
            ) ,
        );
        $this->set('host_moreActions', $host_status);
    }
    public function hosting_panel()
    {
        $user_id = $this->request->params['named']['user_id'];
        if (!empty($user_id)) {
            $periods = array(
                'day' => array(
                    'display' => __l('Today') ,
                    'conditions' => array(
						'created >=' => date('Y-m-d 00:00:00', strtotime('now')) ,
						'created <=' => date('Y-m-d H:i:s', strtotime('now')) ,
                    )
                ) ,
                'week' => array(
                    'display' => __l('This week') ,
                    'conditions' => array(
                        'created >=' => date('Y-m-d', strtotime('now -7 days')) , 
                    )
                ) ,
                'month' => array(
                    'display' => __l('This month') ,
                    'conditions' => array(
                        'created >=' => date('Y-m-d', strtotime('now -30 days')) , 
                    )
                ) ,
                'total' => array(
                    'display' => __l('Total') ,
                    'conditions' => array()
                )
            );
            $models[] = array(
                'PropertyUser' => array(
                    'display' => __l('Cleared') ,
                    'isNeedLoop' => false,
                    'alias' => 'PropertyUser',
                    'colspan' => 1
                )
            );
            $models[] = array(
                'PropertyUser' => array(
                    'display' => '',
                    'conditions' => array(
                        'PropertyUser.owner_user_id' => $user_id,
                        'PropertyUser.is_payment_cleared' => 1
                    ) ,
                    'alias' => 'ClearedRevenueAmountRecieved',
                    'type' => 'cInt',
                    'isSub' => 'PropertyUsers',
                    'class' => 'highlight-cleared'
                )
            );
            $models[] = array(
                'PropertyUser' => array(
                    'display' => __l('Pipeline') ,
                    'isNeedLoop' => false,
                    'alias' => 'PropertyUsers',
                    'colspan' => 1
                )
            );
            // @todo "Auto review" add condition CompletedAndClosedByAdmin
            $models[] = array(
                'PropertyUser' => array(
                    'display' => '',
                    'conditions' => array(
                        'PropertyUser.owner_user_id' => $user_id,
                        'PropertyUser.property_user_status_id' => array(
                            ConstPropertyUserStatus::Confirmed,
                            ConstPropertyUserStatus::Arrived,
                            ConstPropertyUserStatus::WaitingforReview,
                            ConstPropertyUserStatus::Completed
                        ) ,
                        'PropertyUser.is_payment_cleared' => 0,
                    ) ,
                    'alias' => 'PipelineRevenueAmountRecieved',
                    'type' => 'cInt',
                    'isSub' => 'PropertyUsers',
                    'class' => 'highlight-pipeline'
                )
            );
            $models[] = array(
                'PropertyUser' => array(
                    'display' => __l('Lost') ,
                    'isNeedLoop' => false,
                    'alias' => 'PropertyUsers',
                    'colspan' => 1
                )
            );
            $models[] = array(
                'PropertyUser' => array(
                    'display' => '',
                    'conditions' => array(
                        'PropertyUser.owner_user_id' => $user_id,
                        'PropertyUser.property_user_status_id' => array(
                            ConstPropertyUserStatus::Canceled,
                            ConstPropertyUserStatus::Rejected,
                            ConstPropertyUserStatus::Expired,
                            ConstPropertyUserStatus::CanceledByAdmin,
                        )
                    ) ,
                    'alias' => 'LostRevenueAmountRecieved',
                    'type' => 'cInt',
                    'isSub' => 'PropertyUsers',
                    'class' => 'highlight-lost'
                )
            );
            foreach($models as $unique_model) {
                foreach($unique_model as $model => $fields) {
                    foreach($periods as $key => $period) {
                        $conditions = $period['conditions'];
                        if (!empty($fields['conditions'])) {
                            $conditions = array_merge($periods[$key]['conditions'], $fields['conditions']);
                        }
                        $aliasName = !empty($fields['alias']) ? $fields['alias'] : $model;
                        if ($model == 'PropertyUser') {
                            $RevenueRecieved = $this->User->PropertyUser->find('first', array(
                                'conditions' => $conditions,
                                'fields' => array(
                                    'SUM(PropertyUser.price) as total_amount'
                                ) ,
                                'recursive' => -1
                            ));
                            $this->set($aliasName . $key, $RevenueRecieved['0']['total_amount']);
                        }
                    }
                }
            }
        }
        $this->set(compact('periods', 'models'));
    }
    public function _openid()
    {
        //open id component included
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Openid');
        $this->Openid = new OpenidComponent($collection);
        $returnTo = Router::url(array(
            'controller' => 'users',
            'action' => $this->request->data['User']['redirect_page']
        ) , true);
        $siteURL = Router::url('/', true);
        // send openid url and fields return to our server from openid
        if (!empty($this->request->data)) {
            try {
                $this->Openid->authenticate($this->request->data['User']['openid'], $returnTo, $siteURL, array(
                    'sreg_required' => array(
                        'email',
                        'nickname'
                    )
                ) , array());
            }
            catch(InvalidArgumentException $e) {
                $this->Session->setFlash(__l('Invalid OpenID') , 'default', null, 'error');
            }
            catch(Exception $e) {
                $this->Session->setFlash($e->getMessage());
            }
        }
    }
    public function _sendActivationMail($user_email, $user_id, $hash)
    {
		$user = $this->User->find('first', array(
            'conditions' => array(
                'User.email' => $user_email
            ) ,
            'recursive' => -1
        ));
		App::import('Model', 'EmailTemplate');
		$this->EmailTemplate = new EmailTemplate();
        $email = $this->EmailTemplate->selectTemplate('Activation Request');
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
            '##ACTIVATION_URL##' => Router::url(array(
                'controller' => 'users',
                'action' => 'activation',
                $user['User']['id'],
                $hash
            ) , true) ,
            '##FROM_EMAIL##' => ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'],
        );
		$this->User->_sendEmail($email, $emailFindReplace, $user_email);
		 return true;
    }
    public function _sendMembershipMail($user_id, $hash)
    {
        //send membership mail to users
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
		App::import('Model', 'EmailTemplate');
		$this->EmailTemplate = new EmailTemplate();
        $email = $this->EmailTemplate->selectTemplate('Membership Fee');
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
            '##MEMBERSHIP_URL##' => Router::url(array(
                'controller' => 'payments',
                'action' => 'membership_pay_now',
                $this->User->id,
                $hash,
                'admin' => false,
            ) , true) ,
            '##FROM_EMAIL##' => ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'],
        );
		$this->User->_sendEmail($email,$emailFindReplace,$user['User']['email']);
		return true;
    }
    public function _sendWelcomeMail($user_id, $user_email, $username)
    {
		App::import('Model', 'EmailTemplate');
		$this->EmailTemplate = new EmailTemplate();
        $email = $this->EmailTemplate->selectTemplate('Welcome Email');
        $emailFindReplace = array(
            '##USERNAME##' => $username,
            '##FROM_EMAIL##' => ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'],
        );
		$this->User->_sendEmail($email,$emailFindReplace,$user_email);
    }
    public function activation($user_id = null, $hash = null)
    {
        $this->pageTitle = __l('Activate your account');
        if (is_null($user_id) or is_null($hash)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
                'User.is_email_confirmed' => 0
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            $this->Session->setFlash(__l('Invalid activation request, please register again'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register'
            ));
        }
        if (!$this->User->isValidActivateHash($user_id, $hash)) {
            $hash = $this->User->getResendActivateHash($user_id);
            $this->Session->setFlash(__l('Invalid activation request'));
            $this->set('show_resend', 1);
            $resend_url = Router::url(array(
                'controller' => 'users',
                'action' => 'resend_activation',
                $user_id,
                $hash
            ) , true);
            $this->set('resend_url', $resend_url);
        } else {
            $this->request->data['User']['id'] = $user_id;
            $this->request->data['User']['is_email_confirmed'] = 1;
            // admin will activate the user condition check
            if (!Configure::read('user.signup_fee')) {
                $this->request->data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;
            }
            $this->User->save($this->request->data);
            // active is false means redirect to home page with message
            if (!$user['User']['is_active']) {
                if ((Configure::read('user.signup_fee') && $user['User']['is_paid'] == 0) || !Configure::read('user.is_admin_activate_after_register')) {
                    App::import('Model', 'Payment');
                    $this->Payment = new Payment();
                    $this->Session->setFlash(__l('You have successfully activated your account. But you can login after pay the membership fee.') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'payments',
                        'action' => 'membership_pay_now',
                        $user['User']['id'],
                        $this->User->getActivateHash($user['User']['id'])
                    ));
                } else {
                    $this->Session->setFlash(__l('You have successfully activated your account. But you can login after admin activate your account.') , 'default', null, 'success');
                }
                $this->redirect(Router::url('/', true));
            }
            // send welcome mail to user if is_welcome_mail_after_register is true
            if (Configure::read('user.is_welcome_mail_after_register')) {
                $this->_sendWelcomeMail($user['User']['id'], $user['User']['email'], $user['User']['username']);
            }
            // after the user activation check script check the auto login value. it is true then automatically logged in
            if (Configure::read('user.is_auto_login_after_register')) {
                $this->Session->setFlash(__l('You have successfully activated and logged in to your account.') , 'default', null, 'success');
                $this->request->data['User']['email'] = $user['User']['email'];
                $this->request->data['User']['username'] = $user['User']['username'];
                $this->request->data['User']['password'] = $user['User']['password'];
                if ($this->Auth->login()) {
                    $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                    $this->redirect(array(
                        'controller' => 'user_profiles',
                        'action' => 'edit'
                    ));
                }
            }
            // user is active but auto login is false then the user will redirect to login page with message
            $this->Session->setFlash(sprintf(__l('You have successfully activated your account. Now you can login with your %s.') , Configure::read('user.using_to_login')) , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
    }
    public function resend_activation($user_id = null, $hash = null)
    {
        if (is_null($user_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin || $this->User->isValidResendActivateHash($user_id, $hash)) {
            $hash = $this->User->getActivateHash($user_id);
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id
                ) ,
                'recursive' => -1
            ));
            if ($this->_sendActivationMail($user['User']['email'], $user_id, $hash)) {
                if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                    $this->Session->setFlash(__l('Activation mail has been resent.') , 'default', null, 'success');
                } else {
                    $this->Session->setFlash(__l('A Mail for activating your account has been sent.') , 'default', null, 'success');
                }
            } else {
                $this->Session->setFlash(__l('Try some time later as mail could not be dispatched due to some error in the server') , 'default', null, 'error');
            }
        } else {
            $this->Session->setFlash(__l('Invalid resend activation request, please register again'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register'
            ));
        }
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'index',
                'admin' => true
            ));
        } else {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
    }

    public function genreteFBName($fb_user)
    {
        if (!empty($fb_user[0]['name'])) {
            $this->request->data['User']['username'] = $this->User->checkUsernameAvailable(str_replace('.', '_', $fb_user[0]['name']));
        }
        if (empty($this->request->data['User']['username']) && strlen($fb_user[0]['first_name']) > 2) {
            $this->request->data['User']['username'] = $this->User->checkUsernameAvailable(strtolower($fb_user[0]['first_name']));
        }
        if (empty($this->request->data['User']['username']) && strlen($fb_user[0]['first_name'] . $fb_user[0]['last_name']) > 2) {
            $this->request->data['User']['username'] = $this->User->checkUsernameAvailable(strtolower($fb_user[0]['first_name'] . $fb_user[0]['last_name']));
        }
        if (empty($this->request->data['User']['username']) && strlen($fb_user[0]['first_name'] . $fb_user[0]['middle_name'] . $fb_user[0]['last_name']) > 2) {
            $this->request->data['User']['username'] = $this->User->checkUsernameAvailable(strtolower($fb_user[0]['first_name'] . $fb_user[0]['middle_name'] . $fb_user[0]['last_name']));
        }
        $this->request->data['User']['username'] = str_replace(' ', '', $this->request->data['User']['username']);
        $this->request->data['User']['username'] = str_replace('.', '_', $this->request->data['User']['username']);
        // A condtion to avoid unavilability of user username in our sites
        if (strlen($this->request->data['User']['username']) <= 2) {
            $this->request->data['User']['username'] = !empty($fb_user[0]['first_name']) ? str_replace(' ', '', strtolower($fb_user[0]['first_name'])) : 'fbuser';
            $i = 1;
            $created_user_name = $this->request->data['User']['username'] . $i;
            while (!$this->User->checkUsernameAvailable($created_user_name)) {
                $created_user_name = $this->request->data['User']['username'] . $i++;
            }
            $this->request->data['User']['username'] = $created_user_name;
        }
        return strtolower($this->request->data['User']['username']);
    }
    public function login()
    {
		$socialuser = $this->Session->read('socialuser');
        if (!empty($socialuser)) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register',
                'admin' => false,
            ));
        }
        $this->pageTitle = __l('Login');
        if ($this->Auth->user()) {
            $this->redirect(array(
				'controller' => 'users',
				'action' => 'dashboard',
				'admin' => false,
			));
        }
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
                ) ,
			    'GooglePlus' => array(
                    'enabled' => Configure::read('googleplus.is_enabled_googleplus_connect') ,
                    'keys' => array(
                        'id' => Configure::read('googleplus.consumer_key') ,
                        'secret' => Configure::read('googleplus.consumer_secret')
                    ) ,
                ) ,
                'Yahoo' => array(
                    'enabled' => Configure::read('yahoo.is_enabled_yahoo_connect') ,
                    'keys' => array(
                        'key' => Configure::read('invite.yahoo_consumer_key') ,
                        'secret' => Configure::read('invite.yahoo_secret_key')
                    ) ,
                ) ,
                'Openid' => array(
                    'enabled' => Configure::read('openid.is_enabled_openid_connect') ,
                ) ,
                'Linkedin' => array(
                    'enabled' => Configure::read('linkedin.is_enabled_linkedin_connect') ,
                    'keys' => array(
                        'key' => Configure::read('linkedin.consumer_key') ,
                        'secret' => Configure::read('linkedin.consumer_secret')
                    ) ,
                ) ,
            )
        );
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'contact') {
            $options = array();
            $social_type = $this->request->params['named']['type'];
            if ($social_type == 'openid') {
                $options = array(
                    'openid_identifier' => 'https://openid.stackexchange.com/'
                );
            }
			try
		    {
            require_once (APP . DS . WEBROOT_DIR . DS . 'socialauth/Hybrid/Auth.php');
            $hybridauth = new Hybrid_Auth($config);
            if (!empty($this->request->params['named']['redirecting'])) {
                $adapter = $hybridauth->authenticate(ucfirst($social_type) , $options);
                $loggedin_contact = $social_profile = $adapter->getUserProfile();
				$social_profile = (array)$social_profile;
                $social_profile['username'] = $social_profile['displayName'];
                if ($social_type != 'openid') {
                    $session_data = $this->Session->read('HA::STORE');
                    $stored_access_token = $session_data['hauth_session.' . $social_type . '.token.access_token'];
                    $temp_access_token = explode(":", $stored_access_token);
                    $temp_access_token = str_replace('"', "", $temp_access_token);
                    $temp_access_token = str_replace(';', "", $temp_access_token);
                    $access_token = $temp_access_token[2];
                }
				$social_profile['provider'] = ucfirst($social_type);
                $social_profile['is_' . $social_type . '_register'] = 1;
                $social_profile[$social_type . '_user_id'] = $social_profile['identifier'];
                if ($social_type != 'openid') {
                    $social_profile[$social_type . '_access_token'] = $access_token;
                }
                $condition['User.' . $social_type . '_user_id'] = $social_profile['identifier'];
				if ($social_type != 'openid') {
					$condition['OR'] = array(
						'User.is_' . $social_type . '_register' => 1,
						'User.is_' . $social_type . '_connected' => 1
					);
				} else {
					$condition['User.is_' . $social_type . '_register'] = 1;
				}
                $user = $this->User->find('first', array(
                    'conditions' => $condition,
					'recursive' => -1
                ));
                $is_social = 0;
                if (!empty($user)) {
                    $this->request->data['User']['username'] = $user['User']['username'];
                    $this->request->data['User']['password'] = $user['User']['password'];
                    $is_social = 1;
                } else {
					if (Configure::read('site.launch_mode') == 'Pre-launch' || (Configure::read('site.launch_mode') == 'Private Beta' && empty($_SESSION['invite_hash']))) {
						if (Configure::read('site.launch_mode') == 'Pre-launch') {
							$this->Session->setFlash(__l('Sorry!!. Cannot register into the site in pre-launch mode') , 'default', null, 'error');
						} else {
							$this->Session->setFlash(__l('Sorry!!. Cannot register into the site without invitation') , 'default', null, 'error');
						}
						$this->Session->delete('HA::CONFIG');
						$this->Session->delete('HA::STORE');
						$this->Session->delete('socialuser');
						if (stripos(getenv('HTTP_HOST') , 'touch.') === 0) {
							$this->redirect(Router::url('/', true));
						} else {
							echo '<script>window.close();</script>';
							exit;
						}
					}
					$this->Session->delete('HA::CONFIG');
					$this->Session->delete('HA::STORE');
                    $this->Session->write('socialuser', $social_profile);
					if (stripos(getenv('HTTP_HOST') , 'touch.') === 0) {
						$this->redirect(Router::url(array(
							'controller' => 'users',
							'action' => 'register'
						)));
					} else {
						echo '<script>window.close();</script>';
						exit;
					}
                }
            } else {
                $reditect = Router::url(array(
                    'controller' => 'users',
                    'action' => 'login',
                    'type' => $social_type,
                    'redirecting' => $social_type
                ) , true);;
                $this->layout = 'redirection';
                $this->pageTitle.= ' - ' . ucfirst($social_type);
                $this->set('redirect_url', $reditect);
                $this->set('authorize_name', ucfirst($social_type));
                $this->render('authorize');
            }
		  }
		  catch( Exception $e ){
				$error = "";
				switch( $e->getCode() ){
					case 6 :
							$error = __l("User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.");
							$this->Session->delete('HA::CONFIG');
							$this->Session->delete('HA::STORE');
							break;
					case 7 :
							$this->Session->delete('HA::CONFIG');
							$this->Session->delete('HA::STORE');
							$error = __l("User not connected to the provider.");
							break;
					default: $error = __l("Authentication failed. The user has canceled the authentication or the provider refused the connection"); break;
				}
				$this->Session->setFlash($error, 'default', null, 'error');
				if (stripos(getenv('HTTP_HOST') , 'touch.') === 0) {
					$this->redirect(Router::url(array(
						'controller' => 'users',
						'action' => 'register'
					)));
				} else {
					echo '<script>window.close();</script>';
					exit;
				}
			}
        }
        if (!empty($this->request->data)) {
            $this->request->data['User'][Configure::read('user.using_to_login') ] = !empty($this->request->data['User'][Configure::read('user.using_to_login') ]) ? trim($this->request->data['User'][Configure::read('user.using_to_login') ]) : '';
            //Important: For login unique username or email check validation not necessary. Also in login method authentication done before validation.
            unset($this->User->validate[Configure::read('user.using_to_login') ]['rule3']);
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                if (empty($social_type)) {
                    if (!empty($this->request->data['User'][Configure::read('user.using_to_login') ])) {
                        $user = $this->User->find('first', array(
                            'conditions' => array(
                                'User.' . Configure::read('user.using_to_login') => $this->request->data['User'][Configure::read('user.using_to_login') ]
                            ) ,
                            'recursive' => -1
                        ));
                        $this->request->data['User']['password'] = crypt($this->request->data['User']['passwd'], $user['User']['password']);
                    }
                }
                if ($this->Auth->login()) {
					if (!empty($social_type) && $social_type == 'facebook') {
						App::uses('HttpSocket', 'Network/Http');
						$HttpSocket = new HttpSocket();
						$friends = $HttpSocket->get('https://graph.facebook.com/me/friends?access_token=' . $social_profile[$social_type . '_access_token']);
						$friends = json_decode($friends->body);
						$allow_login = 1;
						if (count($friends->data) < Configure::read('facebook.login_allow_friends_count')) {
							$allow_login = 0;
						}
							if (!empty($friends->data)) {
								foreach($friends->data as $friend) {
									$this->request->data['UserFacebookFriend']['user_id'] = $this->Auth->user('id');
									$this->request->data['UserFacebookFriend']['facebook_friend_name'] = $friend->name;
									$this->request->data['UserFacebookFriend']['facebook_friend_id'] = $friend->id;
									$this->User->UserFacebookFriend->create();
									$this->User->UserFacebookFriend->save($this->request->data['UserFacebookFriend']);
								}
							}
							$_data = array();
							$_data['User']['id'] = $user['User']['id'];
							$_data['User']['is_facebook_friends_fetched'] = 1;
							$_data['User']['last_facebook_friend_fetched_date'] = "'" . date('Y-m-d') . "'";
							$_data['User']['is_show_facebook_friends'] = 1;
							$_data['User']['network_fb_user_id'] = $social_profile['identifier'];
							$this->User->save($_data);
							$_SESSION['Auth']['User']['is_facebook_friends_fetched'] = 1;
							$_SESSION['Auth']['User']['is_show_facebook_friends'] = 1;
							$_SESSION['Auth']['User']['network_fb_user_id'] = $social_profile['identifier'];
					}
					if (!empty($social_type) && $social_type == 'twitter' && !empty($social_profile['photoURL'])) {
						$_data = array();
						$_data['User']['id'] = $user['User']['id'];
						$_data['User']['twitter_avatar_url'] = $social_profile['photoURL'];
						$this->User->save($_data);
					}
                    if (isPluginEnabled('SocialMarketing') && !empty($social_type) && $social_type != 'openid') {
						App::import('Model', 'SocialMarketing.SocialMarketing');
						$this->SocialMarketing = new SocialMarketing();
						$social_contacts = $adapter->getUserContacts();
						array_push($social_contacts, $loggedin_contact);
						$this->SocialMarketing->import_contacts($social_contacts, $social_type);
                    }
					if (!empty($social_type)) {
						$this->Session->delete('HA::CONFIG');
						$this->Session->delete('HA::STORE');
					}
					$this->_checkOrderPlaced($this->Auth->user('id'));
                    $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                    if ($this->Auth->user()) {
						Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
							'_trackEvent' => array(
								'category' => 'User',
								'action' => 'Loggedin',
								'label' => $this->Auth->user('username'),
								'value' => '',
							) ,
							'_setCustomVar' => array(
								'ud' => $this->Auth->user('id'),
								'rud' => $this->Auth->user('referred_by_user_id'),
							)
						));
                        if (!empty($this->request->data['User']['is_remember'])) {
                            $user = $this->User->find('first', array(
                                'conditions' => array(
                                    'User.id' => $this->Auth->user('id')
                                ) ,
								'recursive' => -1
                            ));
                            $this->PersistentLogin->_persistent_login_create_cookie($user, $this->request->data);
                        }
                       if (!empty($is_social)) {
							if (stripos(getenv('HTTP_HOST') , 'touch.') === 0) {
								$this->redirect(Router::url('/'), true);
							} else {
	                            echo '<script>window.close();</script>';
		                        exit;
							}
                        }
                        if ($this->layoutPath != 'touch') {
							if (!empty($this->request->data['User']['f'])) {
                                $this->redirect(Router::url('/', true) . $this->request->data['User']['f']);
                            } elseif ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                                $this->redirect(array(
                                    'controller' => 'users',
                                    'action' => 'stats',
                                    'admin' => true
                                ));
                            } else {
                                $this->redirect(array(
                                    'controller' => 'users',
                                    'action' => 'dashboard',
                                    'admin' => false,
                                ));
                            }
                        } else {
                            $this->redirect(array(
                                'controller' => 'properties',
                                'action' => 'index',
                                'admin' => true
                            ));
                        }
                    }
                } else {					
                    if (!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') {
                        $this->Session->setFlash(sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login')) , 'default', null, 'error');
                    } else {
                        $this->Session->setFlash($this->Auth->loginError, 'default', null, 'error');
                    }
					if (!empty($is_social)) {
						if (stripos(getenv('HTTP_HOST') , 'touch.') === 0) {
							$this->redirect(Router::url(array(
								'controller' => 'users',
								'action' => 'login'
							)));
						} else {
							echo '<script>window.close();</script>';
							exit;
						}
					}
                }
            }
        }
		$this->request->data['User']['passwd'] = '';
    }
    public function genreteTWName($data)
    {
        $created_user_name = $this->User->checkUsernameAvailable($data['User']['screen_name']);
        if (strlen($created_user_name) <= 2) {
            $this->request->data['User']['username'] = !empty($data['User']['screen_name']) ? $data['User']['screen_name'] : 'twuser';
            $i = 1;
            $created_user_name = $this->request->data['User']['username'] . $i;
            while (!$this->User->checkUsernameAvailable($created_user_name)) {
                $created_user_name = $this->request->data['User']['username'] . $i++;
            }
        }
        return $created_user_name;
    }
    public function logout()
    {
        if ($this->Auth->user('facebook_user_id')) {
            // Quick fix for facebook redirect loop issue.
            $this->Session->write('is_fab_session_cleared', 1);
            $this->Session->delete('fbuser');
        }
        unset($_SESSION['network_level']);
        $this->Auth->logout();
        $this->Cookie->delete('User');
        $this->Cookie->delete('user_language');
		$cookie_name = $this->PersistentLogin->_persistent_login_get_cookie_name();
        $cookie_val = $this->Cookie->read($cookie_name);
        if (!empty($cookie_val)) {
            list($uid, $series, $token) = explode(':', $cookie_val);
            $this->User->PersistentLogin->deleteAll(array(
                'PersistentLogin.user_id' => $uid,
                'PersistentLogin.series' => $series
            ));
        }
        if (!empty($_COOKIE['_gz'])) {
            setcookie('_gz', '', time() -3600, '/');
        }
        $this->Session->setFlash(__l('You are now logged out of the site.') , 'default', null, 'success');
        $this->redirect(Router::url(array('controller' => 'users', 'action' => 'login') , true));
    }
    public function forgot_password()
    {
        unset($this->User->validate['email']['rule3']);
        unset($this->User->validate['email']['rule4']);
        $this->pageTitle = __l('Forgot Password');
        if ($this->Auth->user('id')) {
            $this->redirect(Router::url('/', true));
        }
        if (!empty($this->request->data)) {
            $this->User->set($this->request->data);
            //Important: For forgot password unique email id check validation not necessary.
            unset($this->User->validate['email']['rule3']);
            unset($this->User->validate['email']['rule4']);
			$captcha_error = 0;
            if (!$this->RequestHandler->isAjax()) {
                if (Configure::read('user.is_enable_forgot_password_captcha') && Configure::read('system.captcha_type') == "Solve Media") {
                    if (!$this->User->_isValidCaptchaSolveMedia()) {
                        $captcha_error = 1;
                    }
                }
            }
            if (empty($captcha_error)) {
				if ($this->User->validates()) {
					$user = $this->User->find('first', array(
						'conditions' => array(
							'User.email =' => $this->request->data['User']['email'],
							'User.is_active' => 1
						) ,
						'fields' => array(
							'User.id',
							'User.email'
						) ,
						'recursive' => -1
					));
					if (!empty($user['User']['email'])) {
						if (!empty($user['User']['is_openid_register']) || !empty($user['User']['is_yahoo_register']) || !empty($user['User']['is_google_register']) || !empty($user['User']['is_googleplus_register']) || !empty($user['User']['is_facebook_register']) || !empty($user['User']['is_twitter_register'])) {
                            if (!empty($user['User']['is_yahoo_register'])) {
                                $site = __l('Yahoo!');
                            } elseif (!empty($user['User']['is_google_register'])) {
                                $site = __l('Gmail');
                            } elseif (!empty($user['User']['is_googleplus_register'])) {
                                $site = __l('GooglePlus');
                            } elseif (!empty($user['User']['is_openid_register'])) {
                                $site = __l('OpenID');
                            } elseif (!empty($user['User']['is_facebook_register'])) {
                                $site = __l('Facebook');
                            } elseif (!empty($user['User']['is_twitter_register'])) {
                                $site = __l('Twitter');
                            }
                            $emailFindReplace = array(
                                '##SITE_NAME##' => Configure::read('site.name') ,
                                '##SITE_URL##' => Router::url('/', true) ,
                                '##OTHER_SITE##' => $site,
                                '##USERNAME##' => $user['User']['username'],
                            );
                            $email_template = "Failed Social User";
                        } else {
                            $user = $this->User->find('first', array(
                                'conditions' => array(
                                    'User.email' => $user['User']['email']
                                ) ,
                                'recursive' => -1
                            ));
                            $reset_token = $this->User->getResetPasswordHash($user['User']['id']);
                            $this->User->updateAll(array(
                                'User.pwd_reset_token' => '\'' . $reset_token . '\'',
                                'User.pwd_reset_requested_date' => '\'' . date("Y-m-d H:i:s", time()) . '\'',
                            ) , array(
                                'User.id' => $user['User']['id']
                            ));
                            $emailFindReplace = array(
                                '##USERNAME##' => $user['User']['username'],
                                '##FIRST_NAME##' => (isset($user['User']['first_name'])) ? $user['User']['first_name'] : '',
                                '##LAST_NAME##' => (isset($user['User']['last_name'])) ? $user['User']['last_name'] : '',
                                '##SITE_NAME##' => Configure::read('site.name') ,
                                '##SITE_URL##' => Router::url('/', true) ,
                                '##RESET_URL##' => Router::url(array(
                                    'controller' => 'users',
                                    'action' => 'reset',
                                    $user['User']['id'],
                                    $reset_token
                                ) , true),
							);
                            $email_template = 'Forgot Password';
                        }
					} else {
						$email_template = 'Failed Forgot Password';
                        $emailFindReplace = array(
                            '##SITE_NAME##' => Configure::read('site.name') ,
                            '##SITE_URL##' => Router::url('/', true) ,
                            '##user_email##' => $this->request->data['User']['email']
                        );
					}
					App::import('Model', 'EmailTemplate');
                    $this->EmailTemplate = new EmailTemplate();
                    $template = $this->EmailTemplate->selectTemplate($email_template);
                    $this->User->_sendEmail($template, $emailFindReplace, $this->request->data['User']['email']);
                    $this->Session->setFlash(sprintf(__l('We have sent an email to %s with further instructions.'), $this->request->data['User']['email']), 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'login'
                    ));
				}
			}  else {
                $this->Session->setFlash(__l('Please enter valid captcha') , 'default', null, 'error');
            }
        }
        if ($this->RequestHandler->isAjax()) {
            $this->render('forgot_password_ajax');
        }
    }
    public function reset($user_id = null, $hash = null)
    {
        $this->pageTitle = __l('Reset Password');
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
                'User.is_active' => 1,
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'date(User.pwd_reset_requested_date) as request_date',
                'User.pwd_reset_requested_date',
                'User.pwd_reset_token',
                'User.email',
                'User.security_question_id',
                'User.security_answer',
            ) ,
            'recursive' => -1
        ));
        $expected_date_diff = strtotime('now') -strtotime($user['User']['pwd_reset_requested_date']);
        if (empty($user) || empty($user['User']['pwd_reset_token']) || ($expected_date_diff < 0)) {
            $this->Session->setFlash(__l('Invalid request'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
		if (isPluginEnabled('SecurityQuestions')) {
            $security_questions = $this->User->SecurityQuestion->find('first', array(
                'conditions' => array(
                    'SecurityQuestion.id' => $user['User']['security_question_id']
                )
            ));
        }
        $this->set('user_id', $user_id);
        $this->set('hash', $hash);
        if (!empty($this->request->data)) {
			if (isset($this->request->data['User']['security_answer']) && isPluginEnabled('SecurityQuestions')) {
                if (strcmp($this->request->data['User']['security_answer'], $user['User']['security_answer'])) {
                    $this->Session->setFlash(__l('Sorry incorrect answer. Please try again') , 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'reset',
                        $user_id,
                        $hash
                    ));
                }
				else{
					$this->Session->setFlash(__l('Entered security answer is correct. Now You can reset your password.') , 'default', null, 'success');
				}
            } else {
				if ($this->User->isValidResetPasswordHash($this->request->data['User']['user_id'], $this->request->data['User']['hash'], $user[0]['request_date'])) {
					$this->User->set($this->request->data);
					if ($this->User->validates()) {
						$this->User->updateAll(array(
							'User.password' => '\'' . getCryptHash($this->request->data['User']['passwd']) . '\'',
							'User.pwd_reset_token' => '\'' . '' . '\'',
						) , array(
							'User.id' => $this->request->data['User']['user_id']
						));
						$emailFindReplace = array(
							'##SITE_NAME##' => Configure::read('site.name') ,
							'##SITE_URL##' => Router::url('/', true) ,
							'##USERNAME##' => $user['User']['username']
						);
						App::import('Model', 'EmailTemplate');
						$this->EmailTemplate = new EmailTemplate();
						$template = $this->EmailTemplate->selectTemplate('Password Changed');
						$this->User->_sendEmail($template, $emailFindReplace, $user['User']['email']);
						$this->Session->setFlash(__l('Your password has been changed successfully, Please login now') , 'default', null, 'success');
						$this->redirect(array(
							'controller' => 'users',
							'action' => 'login'
						));
					}
					$this->request->data['User']['passwd'] = '';
					$this->request->data['User']['confirm_password'] = '';
				} else {
					$this->Session->setFlash(__l('Invalid change password request'));
					$this->redirect(array(
						'controller' => 'users',
						'action' => 'login'
					));
				}
			}
        } else {
            if (is_null($user_id) or is_null($hash)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            if (empty($user)) {
                $this->Session->setFlash(__l('User cannot be found in server or admin deactivated your account, please register again'));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'register'
                ));
            }
            if (!$this->User->isValidResetPasswordHash($user_id, $hash, $user[0]['request_date'])) {
                $this->Session->setFlash(__l('Invalid request'));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login'
                ));
            }
            $this->request->data['User']['user_id'] = $user_id;
            $this->request->data['User']['hash'] = $hash;
            if (isPluginEnabled('SecurityQuestions') && !empty($user['User']['security_question_id']) && !empty($user['User']['security_answer'])) {
                $this->set('security_questions', $security_questions);
                $this->render('check_security_question');
            }
        }
    }
    public function change_password($user_id = null)
    {
        $this->pageTitle = __l('Change Password');
        // No change password for facebook, twitter or openid //
        if ($this->Auth->user('is_openid_register') || $this->Auth->user('is_facebook_register') || $this->Auth->user('is_twitter_register')) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                if ($this->User->updateAll(array(
                    'User.password' => '\'' . getCryptHash($this->request->data['User']['passwd']) . '\'',
                ) , array(
                    'User.id' => $this->request->data['User']['user_id']
                ))) {
                    if ($this->Auth->user('role_id') != ConstUserTypes::Admin && Configure::read('user.is_logout_after_change_password')) {
                        $this->Auth->logout();
                        $this->Session->setFlash(__l('Your password has been changed successfully. Please login now') , 'default', null, 'success');
                        $this->redirect(array(
                            'action' => 'login'
                        ));
                    } elseif ($this->Auth->user('role_id') == ConstUserTypes::Admin && $this->Auth->user('id') != $this->request->data['User']['user_id']) {
                        // @todo "User activation" check user.is_send_email_notifications_only_to_verified_email_account
                        $user = $this->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $this->request->data['User']['user_id']
                            ) ,
                            'contain' => array(
                                'UserProfile'
                            ) ,
                            'recursive' => 1
                        ));
						App::import('Model', 'EmailTemplate');
						$this->EmailTemplate = new EmailTemplate();
                        $email = $this->EmailTemplate->selectTemplate('Admin Change Password');
                        $emailFindReplace = array(
                            '##PASSWORD##' => $this->request->data['User']['passwd'],
                            '##USERNAME##' => $user['User']['username'],
                            '##FROM_EMAIL##' => ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'],                      
                        );
                        // Send e-mail to users
                       $this->User->_sendEmail($email,$emailFindReplace,$user['User']['email']);
                    }
                    $this->Session->setFlash(__l('Password has been changed successfully') , 'default', null, 'success');
                    if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                        $this->redirect(array(
                            'action' => 'index'
                        ));
                    }
                } else {
                    $this->Session->setFlash(__l('Password could not be changed') , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(__l('Password could not be changed') , 'default', null, 'error');
            }
            unset($this->request->data['User']['old_password']);
            unset($this->request->data['User']['passwd']);
            unset($this->request->data['User']['confirm_password']);
        } else {
            if (empty($user_id)) {
                $user_id = $this->Auth->user('id');
            }
        }
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $conditions = array(
                'User.is_facebook_register' => 0,
                'User.is_twitter_register' => 0,
                'User.is_google_register' => 0,
                'User.is_googleplus_register' => 0,
                'User.is_yahoo_register' => 0,
                'User.is_linkedin_register' => 0,
                'User.is_openid_register' => 0,
            );
            $users = $this->User->find('list', array(
                'conditions' => $conditions,
				'recursive' => -1,
            ));
            $this->set(compact('users'));
        }
        $this->request->data['User']['user_id'] = (!empty($this->request->data['User']['user_id'])) ? $this->request->data['User']['user_id'] : $user_id;
    }
    public function refer()
    {
        $cookie_value = $this->Cookie->read('referrer');
        $user_refername = '';
        if (!empty($this->request->params['named']['r'])) {
            $user_refername = $this->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['r']
                ) ,
                'recursive' => -1
            ));
            if (empty($user_refername)) {
                $this->Session->setFlash(__l('Referrer username does not exist.') , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'register'
                ));
            }
        }
        //cookie value should be empty or same user id should not be over written
        if (!empty($user_refername) && (empty($cookie_value) || (!empty($cookie_value) && (!empty($user_refername)) && ($cookie_value['refer_id'] != $user_refername['User']['id'])))) {
            $this->Cookie->delete('referrer');
            $referrer['refer_id'] = $user_refername['User']['id'];
            $referrer['type'] = 'User';
            $referrer['slug'] = '';
            if (isPluginEnabled('Affiliates')) {
                $this->Cookie->write('referrer', $referrer['refer_id'], false, sprintf('+%s hours', Configure::read('affiliate.referral_cookie_expire_time')));
            }
            $cookie_value = $this->Cookie->read('referrer');
        }
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'register'
        ));
    }
    public function top_rated()
    {
        $conditions = array();
        $order = array();
        if (!empty($this->request->params['named']['type'])) {
            if ($this->request->params['named']['type'] == 'top_seller') {
                $order['User.actual_rating'] = 'desc';
                $conditions['User.actual_rating !='] = '0';
            }
            $users = $this->User->find('all', array(
                'conditions' => $conditions,
                'recursive' => -1,
                'order' => $order,
                'limit' => 5
            ));
            $this->set('users', $users);
        }
    }
    public function fb_update()
    {
        App::import('Vendor', 'facebook/facebook');
        $this->facebook = new Facebook(array(
            'appId' => Configure::read('facebook.api_id') ,
            'secret' => Configure::read('facebook.secrect_key') ,
            'cookie' => true
        ));
        if ($fb_session = $this->Session->read('fbuser')) {
            App::uses('HttpSocket', 'Network/Http');
			$HttpSocket = new HttpSocket();
            $friends = $HttpSocket->get('https://graph.facebook.com/me/friends?access_token=' . $fb_session['access_token']);
            $friends = json_decode($friends->body);
            if (!empty($friends->data)) {
                foreach($friends->data as $friend) {
                    $this->request->data['UserFacebookFriend']['user_id'] = $this->Auth->user('id');
                    $this->request->data['UserFacebookFriend']['facebook_friend_name'] = $friend->name;
                    $this->request->data['UserFacebookFriend']['facebook_friend_id'] = $friend->id;
                    $this->User->UserFacebookFriend->create();
                    $this->User->UserFacebookFriend->save($this->request->data['UserFacebookFriend']);
                }
            }
            $this->User->updateAll(array(
                'User.is_facebook_friends_fetched' => 1,
                'User.facebook_access_token' => "'" . $fb_session['access_token'] . "'",
                'User.network_fb_user_id' => "'" . $fb_session['id'] . "'",
                'User.facebook_user_id' => "'" . $fb_session['id'] . "'",
                'User.last_facebook_friend_fetched_date' => "'" . date('Y-m-d') . "'",
                'User.user_facebook_friend_count' => count($friends->data),
                'User.is_facebook_connected' => 1,
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
            $_SESSION['Auth']['User']['is_facebook_friends_fetched'] = 1;
            $_SESSION['Auth']['User']['is_show_facebook_friends'] = 1;
            $_SESSION['Auth']['User']['network_fb_user_id'] = $fb_session['id'];
            $this->Session->setFlash(__l('You have successfully connected with Facebook.') , 'default', null, 'success');
            $this->Session->delete('fbuser');
        }
        $this->redirect(array(
            'controller' => 'social_marketings',
            'action' => 'myconnections',
			'facebook',
        ));
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'role_id',
            'filter_id',
            'q'
        ));
        $this->pageTitle = __l('Users');
        // total approved users list
        $this->set('pending', $this->User->find('count', array(
            'conditions' => array(
                'User.is_active = ' => 0,
            ) ,
            'recursive' => -1
        )));
        // total approved users list
        $this->set('approved', $this->User->find('count', array(
            'conditions' => array(
                'User.is_active = ' => 1,
                          ) ,
            'recursive' => -1
        )));
        // total openid users list
        $this->set('openid', $this->User->find('count', array(
            'conditions' => array(
                'User.is_openid_register = ' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        // total Gmail users list
        $this->set('gmail', $this->User->find('count', array(
            'conditions' => array(
                'User.is_google_register = ' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        // total Yahoo users list
        $this->set('yahoo', $this->User->find('count', array(
            'conditions' => array(
                'User.is_yahoo_register = ' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('facebook', $this->User->find('count', array(
            'conditions' => array(
                'User.is_facebook_register' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('twitter', $this->User->find('count', array(
            'conditions' => array(
                'User.is_twitter_register' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
		$this->set('linkedin', $this->User->find('count', array(
            'conditions' => array(
                'User.is_linkedin_register' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
		$this->set('googleplus', $this->User->find('count', array(
            'conditions' => array(
                'User.is_googleplus_register' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
         // total admin list
        $this->set('admin_count', $this->User->find('count', array(
                'conditions' => array(
                    'User.role_id' => ConstUserTypes::Admin,
                ) ,
                'recursive' => -1
            )));
            // total user list
        $this->set('users_count', $this->User->find('count', array(
                'conditions' => array(
                    'User.role_id' => ConstUserTypes::User,
                ) ,
                'recursive' => -1
            )));
        // For enagement metrics//
        $total_users = $this->User->find('count', array(
            'recursive' => -1
        ));
        $idle_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_idle' => 1
            ) ,
            'recursive' => -1
        ));
        $posted_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_property_posted' => 1
            ) ,
            'recursive' => -1
        ));
        $requested_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_requested' => 1
            ) ,
            'recursive' => -1
        ));
        $booked_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_property_booked' => 1
            ) ,
            'recursive' => -1
        ));
        
        $this->set('total_users', $total_users);
        $this->set('idle_users', $idle_users);
        $this->set('posted_users', $posted_users);
        $this->set('requested_users', $requested_users);
        $this->set('booked_users', $booked_users);     
        
        // engagment metircs data ends here
			
        $conditions = array();
        // check the filer passed through named parameter
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['User']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['User.created ='] = date('Y-m-d', strtotime('now'));
            $this->pageTitle.= __l(' - Registered today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['User.created >='] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - Registered in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['User.created >='] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - Registered in this month');
        }
        if (!empty($this->request->params['named']['main_filter_id'])){
             if($this->request->params['named']['main_filter_id'] == ConstUserTypes::Admin){
					$conditions['User.role_id'] = ConstUserTypes::Admin;
					$this->pageTitle.= __l(' - Admin ');
                }else if($this->request->params['named']['main_filter_id'] == ConstUserTypes::User){
					$conditions['User.role_id'] = ConstUserTypes::User;
					$this->pageTitle.= __l(' - Normal ');
               }else if (isPluginEnabled('LaunchModes') && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Prelaunch) {
                    $conditions['User.site_state_id'] = ConstSiteState::Prelaunch;
                    $this->pageTitle.= ' - ' . __l('Pre-launch Users');
                } else if (isPluginEnabled('LaunchModes') && $this->request->params['named']['main_filter_id'] == ConstMoreAction::PrivateBeta) {
                    $conditions['User.site_state_id'] = ConstSiteState::PrivateBeta;
                    $this->pageTitle.= ' - ' . __l('Private Beta Users');
                }			   
         }
		if (isPluginEnabled('LaunchModes')) {
			$this->loadModel('LaunchModes.Subscription');
			// total pre-launch users list
			$this->set('prelaunch_users', $this->User->find('count', array(
				'conditions' => array(
					'User.site_state_id' => ConstSiteState::Prelaunch
				) ,
				'recursive' => -1
			)));
			// total privatebeta users list
			$this->set('privatebeta_users', $this->User->find('count', array(
				'conditions' => array(
					'User.site_state_id' => ConstSiteState::PrivateBeta
				) ,
				'recursive' => -1
			)));
			// total pre-launch subscribed users list
			$this->set('prelaunch_subscribed', $this->Subscription->find('count', array(
				'conditions' => array(
					'Subscription.site_state_id = ' => ConstSiteState::Prelaunch
				),
				'recursive' => -1,
			)));
			// total privatebeta subscribed users list
			$this->set('privatebeta_subscribed', $this->Subscription->find('count', array(
				'conditions' => array(
					'Subscription.site_state_id = ' => ConstSiteState::PrivateBeta
				),
				'recursive' => -1,
			)));
		}		 
        if (!empty($this->request->data['User']['filter_id'])) {
              if ($this->request->data['User']['filter_id'] == ConstMoreAction::OpenID) {
                $conditions['User.is_openid_register'] = 1;
                $this->pageTitle.= __l(' - Registered through OpenID ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Gmail) {
                $conditions['User.is_google_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Gmail ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Yahoo) {
                $conditions['User.is_yahoo_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Yahoo ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Active) {
                $conditions['User.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Twitter) {
                $conditions['User.is_twitter_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Twitter ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Facebook) {
                $conditions['User.is_facebook_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Facebook ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::LinkedIn) {
                $conditions['User.is_linkedin_register'] = 1;
                $this->pageTitle.= __l(' - Registered through LinkedIn ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::GooglePlus) {
                $conditions['User.is_googleplus_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Google+ ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['User.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::NotifiedInactiveUsers) {
                $conditions['User.last_sent_inactive_mail !='] = NULL;
                $this->pageTitle.= __l(' - Notified Inactive Users ');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['User']['filter_id'];
        }
		if (!empty($this->request->params['named']['q'])) {
			$this->request->data['User']['q'] = $this->request->params['named']['q'];
		}
        if (isset($this->request->data['User']['q'])) {
           $conditions['AND']['OR'][]['User.email LIKE'] = '%' . $this->request->data['User']['q'] . '%';
			$conditions['AND']['OR'][]['User.username LIKE'] = '%' . $this->request->data['User']['q'] . '%';
			$this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->data['User']['q']);
        }
        $this->set('page_title', $this->pageTitle);
        if ($this->RequestHandler->ext == 'csv') {
             Configure::write('debug', 0);
            $this->set('user', $this);
            $this->set('conditions', $conditions);
            if (isset($this->request->data['User']['q'])) {
                $this->set('q', $this->request->data['User']['q']);
            }
         } else {
            $this->User->recursive = 2;
            $this->paginate = array(
                'conditions' => $conditions,
                'contain' => array(
                    'Ip' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name',
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name',
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2',
                            )
                        ) ,
                        'Timezone' => array(
                            'fields' => array(
                                'Timezone.name',
                            )
                        ) ,
                        'fields' => array(
                            'Ip.ip',
                            'Ip.latitude',
                            'Ip.longitude',
                            'Ip.host',
                        )
                    ) ,
				    'LastLoginIp' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name',
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name',
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2',
                            )
                        ) ,
                        'fields' => array(
                            'LastLoginIp.ip',
                            'LastLoginIp.latitude',
                            'LastLoginIp.longitude',
                            'LastLoginIp.host'
                        )
                    ) ,
					'UserAvatar',
                    'UserProfile' => array(
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2',
                            )
                        )
                    ) ,
                ) ,
                'order' => array(
                    'User.id' => 'desc'
                )
            );
            $this->set('users', $this->paginate());
            $filters = $this->User->isFilterOptions;
            $moreActions = $this->User->moreActions;
            $roles = $this->User->Role->find('list');
            $this->request->data['User']['role_id'] = !empty($this->request->params['named']['role_id']) ? $this->request->params['named']['role_id'] : '';
            $this->set(compact('filters', 'moreActions', 'roles'));
        }
    }
    public function sales_revenues()
    {
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'User.sales_cleared_amount',
                'User.sales_pipeline_amount',
                'User.sales_lost_amount',
            ) ,
            'recursive' => -1
        ));
        $this->set('user', $user);
    }
    public function admin_add()
    {
          $this->pageTitle = __l('Add New User/Admin');
        if (!empty($this->request->data)) {
            $this->request->data['User']['password'] = getCryptHash($this->request->data['User']['passwd']);
            $this->request->data['User']['is_agree_terms_conditions'] = '1';
            // @todo "User activation"
            $this->request->data['User']['is_email_confirmed'] = 1;
            $this->request->data['User']['is_active'] = 1;
            // @todo "IP table logic"
            $this->request->data['User']['ip_id'] = $this->User->toSaveIp();
            $this->User->create();
            if ($this->User->save($this->request->data)) {
              // Send mail to user to activate the account and send account details
				App::import('Model', 'EmailTemplate');
				$this->EmailTemplate = new EmailTemplate();
                $email = $this->EmailTemplate->selectTemplate('Admin User Add');
                $emailFindReplace = array(
                    '##USERNAME##' => $this->request->data['User']['username'],
                    '##LOGINLABEL##' => ucfirst(Configure::read('user.using_to_login')) ,
                    '##USEDTOLOGIN##' => $this->request->data['User'][Configure::read('user.using_to_login') ],
					'##PASSWORD##' => $this->request->data['User']['passwd'],
                    '##FROM_EMAIL##' => ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'],
                );
				$this->User->_sendEmail($email,$emailFindReplace,$this->request->data['User']['email']);
                $this->Session->setFlash(__l('User has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                unset($this->request->data['User']['passwd']);
                $this->Session->setFlash(__l('User could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
        if (!isset($this->request->data['User']['role_id'])) {
            $this->request->data['User']['role_id'] = ConstUserTypes::User;
        }
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
		$user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $id
            ) ,
            'recursive' => -1
        ));
		if(!empty($user['User']['email']))
		{
		$this->_sendAdminActionMail($id, 'Admin User Delete');
		}
        if ($this->User->delete($id)) {
            $this->Session->setFlash(__l('User has been deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_update()
    {
        if (!empty($this->request->data['User'])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $userIds = array();
            foreach($this->request->data['User'] as $user_id => $is_checked) {
                if ($is_checked['id']) {
                    $userIds[] = $user_id;
                }
            }
            if ($actionid && !empty($userIds)) {
                if ($actionid == ConstMoreAction::Inactive) {
                    $this->User->updateAll(array(
                        'User.is_active' => 0
                    ) , array(
                        'User.id' => $userIds
                    ));
                    foreach($userIds as $key => $user_id) {
                        $this->_sendAdminActionMail($user_id, 'Admin User Deactivate');
                    }
                    $this->Session->setFlash(__l('Checked users has been inactivated') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Active) {
                    $this->User->updateAll(array(
                        'User.is_active' => 1
                    ) , array(
                        'User.id' => $userIds
                    ));
                    foreach($userIds as $key => $user_id) {
                        $this->_sendAdminActionMail($user_id, 'Admin User Active');
                    }
                    $this->Session->setFlash(__l('Checked users has been activated') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Delete) {
                    foreach($userIds as $key => $user_id) {
                       $user = $this->User->find('first', array(
							'conditions' => array(
								'User.id' => $user_id
							) ,
							'recursive' => -1
						));
						if(!empty($user['User']['email']))
						{
							 $this->_sendAdminActionMail($user_id, 'Admin User Delete');
						}
						$this->User->delete(array(
							'User.id' => $user_id
						));
                    }
                    $this->Session->setFlash(__l('Checked users has been deleted') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Export) {
                    $user_ids = implode(',', $userIds);
                    $hash = $this->User->getUserIdHash($user_ids);
                    $_SESSION['user_export'][$hash] = $userIds;
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'export',
                        'ext' => 'csv',
                        $hash,
                        'admin' => true
                    ));
                }
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
    public function _sendAdminActionMail($user_id, $email_template)
    {
        // @todo "User activation" check user.is_send_email_notifications_only_to_verified_email_account
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'contain' => array(
                'UserProfile'
            ) ,
            'recursive' => 1
        ));
		App::import('Model', 'EmailTemplate');
		$this->EmailTemplate = new EmailTemplate();
        $email = $this->EmailTemplate->selectTemplate($email_template);
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
			'##FROM_EMAIL##' => ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'],
        );
		$this->User->_sendEmail($email,$emailFindReplace,$user['User']['email']);
    }
    public function admin_stats()
    {
        $this->pageTitle = __l('Snapshot');
    }
    public function admin_change_password($user_id = null)
    {
        $this->setAction('change_password', $user_id);
    }
    public function admin_send_mail()
    {
        $this->pageTitle = __l('Email to users');
        if (!empty($this->request->data)) {
			$this->request->data['User']['send_to'] = trim($this->request->data['User']['send_to'], " ,");
			 $this->User->set($this->request->data);
            if ($this->User->validates()) {
                $conditions = $emails = array();
                $notSendCount = $sendCount = 0;
                if (!empty($this->request->data['User']['send_to'])) {
                    $sendTo = explode(',', $this->request->data['User']['send_to']);
                    foreach($sendTo as $email) {
                        $email = trim($email);
                        if (!empty($email)) {
                            if ($this->User->find('count', array(
                                'conditions' => array(
                                    'User.email' => $email
                                ) ,
                                'recursive' => -1
                            ))) {
                                $emails[] = $email;
                                $sendCount++;
                            } else {
                                $notSendCount++;
                            }
                        }
                    }
                }
                if (!empty($this->request->data['User']['bulk_mail_option_id'])) {
                    if ($this->request->data['User']['bulk_mail_option_id'] == 2) {
                        $conditions['User.is_active'] = 0;
                    }
                    if ($this->request->data['User']['bulk_mail_option_id'] == 3) {
                        $conditions['User.is_active'] = 1;
                    }
                    // @todo "User activation" check user.is_send_email_notifications_only_to_verified_email_account
                    $users = $this->User->find('all', array(
                        'conditions' => $conditions,
                        'fields' => array(
                            'User.email'
                        ) ,
                        'recursive' => -1
                    ));
                    if (!empty($users)) {
                        $sendCount++;
                        foreach($users as $user) {
                            $emails[] = $user['User']['email'];
                        }
                    }
                }
				$message_content['text'] = $this->request->data['User']['message'] . "\n\n" . Configure::read('site.name') . "\n" . Router::url('/', true);
                if (!empty($emails)) {
                    App::uses('CakeEmail', 'Network/Email');
                    $this->Email = new CakeEmail();
                    foreach($emails as $email) {
                        if (!empty($email)) {
                            $this->Email->to(trim($email));
                            $this->Email->from(Configure::read('site.from_email'));
                            $this->Email->subject($this->request->data['User']['subject']);
							$this->Email->emailFormat('text');
                            $this->Email->send($message_content);
                        }
                    }
                }
                if ($sendCount && !$notSendCount) {
                    $this->Session->setFlash(__l('Email sent successfully') , 'default', null, 'success');
                    if (!empty($this->request->data['Contact']['id'])) {
                        $this->User->Contact->updateAll(array(
                            'Contact.is_replied' => 1
                        ) , array(
                            'Contact.id' => $this->request->data['Contact']['id']
                        ));
                        $this->redirect(array(
                            'controller' => 'contacts',
                            'action' => 'index'
                        ));
                    }
                    unset($this->request->data);
                } elseif ($sendCount && $notSendCount) {
                    $this->Session->setFlash(__l('Email sent successfully. Some emails are not sent') , 'default', null, 'success');
                    unset($this->request->data);
                } else {
                    $this->Session->setFlash(__l('No email send') , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(__l('Email couldn\'t be sent! Enter all required fields') , 'default', null, 'error');
                if (!empty($this->request->data['Contact']['id'])) {
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'send_mail',
                        'contact' => $this->request->data['Contact']['id']
                    ));
                }
            }
        }
        // Just to do the admin conatact us repay mangement
        if (!empty($this->request->params['named']['contact'])) {
            $contact_deatil = $this->User->Contact->find('first', array(
                'conditions' => array(
                    'Contact.id' => $this->request->params['named']['contact'],
                ) ,
                'contain' => array(
                    'ContactType'
                ) ,
                'recursive' => 0
            ));
            if (!empty($contact_deatil['Contact']['subject'])) {
                $subject = $contact_deatil['Contact']['subject'];
            } else {
                $subject = $contact_deatil['ContactType']['name'];
            }
            $this->pageTitle = __l('Contact us - Reply');
            $this->request->data['Contact']['id'] = $this->request->params['named']['contact'];
            $this->request->data['User']['subject'] = __l('Re:') . $subject;
            $this->request->data['User']['message'] = "\n\n\n";
            $this->request->data['User']['message'].= '------------------------------';
            $this->request->data['User']['message'].= "\n" . $contact_deatil['Contact']['message'];
            $this->request->data['User']['send_to'] = $contact_deatil['Contact']['email'];
        }
        $bulkMailOptions = $this->User->bulkMailOptions;
        $this->set(compact('bulkMailOptions'));
    }
    public function admin_login()
    {
        $this->setAction('login');
    }
    public function admin_logout()
    {
        $this->setAction('logout');
    }
    public function admin_export($hash = null)
    {
        $conditions = array();
        if (!empty($hash) && isset($_SESSION['user_export'][$hash])) {
            $user_ids = implode(',', $_SESSION['user_export'][$hash]);
            if ($this->User->isValidUserIdHash($user_ids, $hash)) {
                $conditions['User.id'] = $_SESSION['user_export'][$hash];
            } else {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $users = $this->User->find('all', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        Configure::write('debug', 0);
        if (!empty($users)) {
            foreach($users as $user) {
                $data[]['User'] = array(
                    'Username' => $user['User']['username'],
                    'Email' => $user['User']['email'],
                    'Available Wallet Amount' => $user['User']['available_wallet_amount'],
                    'Property Count' => $user['User']['property_count'],
                    'Total Bookings as Traveler' => $user['User']['travel_total_booked_count'],
                    'Site Revenue' => $user['User']['travel_total_site_revenue']+$user['User']['host_total_site_revenue'],
                    'Login count' => $user['User']['user_login_count'],
                );
            }
        }
        $this->set('data', $data);
    }
    public function whois($ip = null)
    {
        if (!empty($ip)) {
            $this->redirect(Configure::read('site.look_up_url') . $ip);
        }
    }
    public function admin_diagnostics()
    {
        $this->pageTitle = __l('Diagnostics');
        $this->set('pageTitle', $this->pageTitle);
    }
    public function admin_recent_users()
    {
        //recently registered users
        $recentUsers = $this->User->find('all', array(
            'conditions' => array(
                'User.is_active' => 1,
                'User.role_id != ' => ConstUserTypes::Admin
            ) ,
            'fields' => array(
                'User.role_id',
                'User.username',
                'User.id',
            ) ,
            'recursive' => -1,
            'limit' => 10,
            'order' => array(
                'User.id' => 'desc'
            )
        ));
        $this->set(compact('recentUsers'));
    }
    public function admin_online_users()
    {
        //online users
        $onlineUsers = $this->User->find('all', array(
            'conditions' => array(
                'User.is_active' => 1,
                'CkSession.user_id != ' => 0,
                'User.role_id != ' => ConstUserTypes::Admin
            ) ,
            'contain' => array(
                'CkSession' => array(
                    'fields' => array(
                        'CkSession.user_id'
                    )
                )
            ) ,
            'fields' => array(
                'DISTINCT User.username',
                'User.role_id',
                'User.id',
            ) ,
            'recursive' => 1,
            'limit' => 10,
            'order' => array(
                'User.last_logged_in_time' => 'desc'
            )
        ));
        $this->set(compact('onlineUsers'));
    }
	public function show_header()
    {
		$this->disableCache();
    }
	 public function _referer_follow($user_id, $followed_user_id, $username)
    {
        $this->User->UserFollower->create();
        $this->request->data['UserFollower']['user_id'] = $user_id;
        $this->request->data['UserFollower']['followed_user_id'] = $followed_user_id;
        $this->request->data['UserFollower']['action'] = 'add';
        $this->User->UserFollower->save($this->request->data);
        Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
            '_trackEvent' => array(
                'category' => 'UserFollower',
                'action' => 'Followed',
                'label' => $username,
                'value' => '',
            ) ,
            '_setCustomVar' => array(
                'ud' => $user_id,
            )
        ));
    }
    public function facepile()
    {
        $conditions = array(
            'OR' => array(
                array(
                    'User.is_facebook_connected' => 1
                ) ,
                array(
                    'User.is_facebook_register' => 1
                )
            ) ,
            'User.is_active' => 1,
        );
        $users = $this->User->find('all', array(
            'conditions' => $conditions,
            'contain' => array(
                'UserAvatar'
            ) ,
            'order' => array(
                'User.created' => 'desc'
            ) ,
            'limit' => 12,
            'recursive' => 0
        ));
        $this->set('users', $users);
        $totalUserCount = $this->User->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        $this->set('totalUserCount', $totalUserCount);
    }	
	public function follow_friends()
    {
		$conditions = array();
		$type = $this->request->params['named']['type'];
        $social_conditions['SocialContact.user_id'] = $this->Auth->user('id');
        if ($type == 'facebook') {
            $social_conditions['SocialContact.social_source_id'] = ConstSocialSource::facebook;
        } elseif ($type == 'twitter') {
            $social_conditions['SocialContact.social_source_id'] = ConstSocialSource::twitter;
        }
        App::import('Model', 'SocialMarketing.SocialContact');
        $this->SocialContact = new SocialContact();
        App::import('Model', 'SocialMarketing.UserFollower');
        $this->UserFollower = new UserFollower();		
        $socialContacts = $this->SocialContact->find('all', array(
            'conditions' => $social_conditions,
			'recursive' => 0
        ));
		if (!empty($socialContacts)) {
			if ($type == 'facebook') {
				foreach($socialContacts as $socialContact) {
					$contacts[] = $socialContact['SocialContactDetail']['facebook_user_id'];
				}
				$conditions['User.facebook_user_id'] = $contacts;
			} else if ($type == 'twitter') {
				foreach($socialContacts as $socialContact) {
					$contacts[] = $socialContact['SocialContactDetail']['twitter_user_id'];
				}
				$conditions['User.twitter_user_id'] = $contacts;
			} else if ($type == 'gmail' || $type == 'yahoo' || $type == 'linkedin') {
				foreach($socialContacts as $socialContact) {
					$contacts[] = $socialContact['SocialContactDetail']['email'];
				}
				$conditions['User.email'] = $contacts;
			}
			$userFollowers = $this->UserFollower->find('all', array(
				'conditions' => array(
					'UserFollower.user_id' => $this->Auth->user('id')
				) ,
				'recursive' => -1
			));
			if (!empty($userFollowers)) {
				foreach($userFollowers as $userFollower) {
					$userFollowerIds[] = $userFollower['UserFollower']['followed_user_id'];
				}
				$userFollowerIds[] = $this->Auth->user('id');
				$conditions['User.id NOT'] = $userFollowerIds;
			}
			$conditions['User.id NOT'] = $this->Auth->user('id');
			$this->paginate = array(
				'conditions' => $conditions,
				'limit' => 15,
				'order' => array(
					'User.id' => 'desc'
				) ,
				'recursive' => -1
			);
			$this->set('followFriends', $this->paginate());
		}
    }
	public function show_admin_control_panel()
    {
        $this->disableCache();
        if (!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'user') {
            App::import('Model', 'User');
            $this->User = new User();
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->params['named']['id']
                ) ,
                'recursive' => -1
            ));
            $this->set('user', $user);
        }
        $this->layout = 'ajax';
    }
}
?>