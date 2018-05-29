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
class SubscriptionsController extends AppController
{
    public $name = 'Subscriptions';
    public $components = array(
        'Email'
    );
	public $helpers = array(
        'Csv'
    );
    public function add()
    {
		if (Configure::read('site.launch_mode') == "Launched") {
			throw new NotFoundException(__l('Invalid request'));
		}
		if (empty($this->request->params['requested']) && empty($this->request->data) && (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'invite_request')) {
			$this->redirect(Router::url('/', true));
		}
        $this->pageTitle = __l('Subscription');
        if (!empty($this->request->data)) {
            if (Configure::read('site.launch_mode') == "Pre-launch") {
				$this->request->data['Subscription']['site_state_id'] = ConstSiteState::Prelaunch;
				$this->request->data['Subscription']['invite_hash'] = md5(Configure::read('Security.salt') . $this->request->data['Subscription']['email']);
			} else if (Configure::read('site.launch_mode') == "Private Beta") {
                $this->request->data['Subscription']['site_state_id'] = ConstSiteState::PrivateBeta;
                $this->request->data['Subscription']['invite_hash'] = md5(Configure::read('Security.salt') . $this->request->data['Subscription']['email']);
            }
            $this->Subscription->set($this->request->data);
            if($this->Subscription->validates()){
				$Subscription = $this->Subscription->find('first', array(
					'conditions' => array(
						'Subscription.email' => $this->request->data['Subscription']['email']
					) ,
					'recursive' => -1
				));
				if (empty($Subscription)) {
					$cookie_value = $this->Cookie->read('social_like');
					if (!empty($cookie_value)) {
						$this->request->data['Subscription']['is_social_like'] = 1;
					}
					$this->request->data['Subscription']['ip_id'] = $this->Subscription->toSaveIp();
					$this->Subscription->create();
					$this->Subscription->save($this->request->data);					
					$this->set('success_msg','1');
				} else {
					$this->set('success_msg','0');
					$this->Session->setFlash(__l('You have already subscribed') , 'default', null, 'error');
				}
				unset($this->request->data);
			} else {
				$this->Session->setFlash(__l('Unable to subscribe. Please try again.') , 'default', null, 'error');
				$this->set('success_msg', '0');
        	}
        } else{
			$this->set('success_msg','0');

			if(!empty($_SESSION['message'])) 
			{
				$this->set('success_msg','2');
			}
        }
		unset($_SESSION['message']);
        $this->layout = "subscription";
		$messages = $this->Session->read('Message');
		if(!empty($messages['error'])) {
			$this->set('error_message', 1);
			$this->set('success_msg','0');
		}
		if(isset($_SESSION['refer_id']) && !empty($_SESSION['refer_id'])) {
			App::import('Model', 'User');
			$this->User = new User(); 
			$user = $this->User->find('first', array(
				'conditions' => array(
					'User.id' => $_SESSION['refer_id']
				),
				'contain' => array(
					'UserAvatar',
					'UserProfile'
				),
				'fields' => array(
					'User.id',
					'User.username',
					'UserProfile.first_name',
					'UserProfile.middle_name',
					'UserProfile.last_name',
					'UserAvatar.filename',
					'UserAvatar.dir',
				),

				'recursive' => 1
			));
			$this->request->data = $user;
			$this->render('invited_friend');
		} else {
			if(Configure::read('site.launch_mode') == 'Private Beta' && !empty($this->request->params['named']['type'])) {
                if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'invite_request') {
					$this->set('success_msg', '3');
				}
				$this->render('invite_page');
			}
		}
    }
	public function check_invitation() {
		if(!empty($this->request->data['Subscription']['invite_hash'])) {
			$Subscription = $this->Subscription->find('first', array(
				'conditions' => array(
					'Subscription.invite_hash' => $this->request->data['Subscription']['invite_hash'],
					'user_id' => NULL
				),
				'recursive' => -1,
			));
			if(!empty($Subscription)) {
				$_SESSION['invite_hash'] = $this->request->data['Subscription']['invite_hash'];
				$_SESSION['is_allow_to_register'] = 1;
				$this->Session->setFlash(sprintf(__l('You have submitted invitation code successfully, Welcome to %s'), Configure::read('site.name')) , 'default', null, 'success');	
				if(!empty($Subscription['Subscription']['is_invite']) && !empty($Subscription['Subscription']['invite_user_id'])) {
					$this->Cookie->write('referrer', $Subscription['Subscription']['invite_user_id'] , false, sprintf('+%s hours', Configure::read('affiliate.referral_cookie_expire_time')));
					$_SESSION['refer_id'] = $Subscription['Subscription']['invite_user_id'];
					$this->redirect(array(
						'action' => 'add',
					));
				}
				$this->redirect(array(
					'controller' => 'users',
					'action' => 'register',
					'type' => 'social'
				));
			} else {
				$this->Session->setFlash(__l('Sorry. entered invitation code is expired or invalid.') , 'default', null, 'error');
				$this->redirect(array(
					'action' => 'add',
				));
			}
		} else {
			$this->redirect(array(
                'action' => 'index'
            ));
		}
	}
	public function invite_friends()
	{
		$this->pageTitle = __l('Invite Friends');
		App::import('Model', 'User');
		$this->User = new User(); 
		App::import('Model', 'EmailTemplate');
		$this->EmailTemplate = new EmailTemplate();
		$email_template = $this->EmailTemplate->selectTemplate('Invite Friend');
		if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
			$user_id = $this->Auth->user('id');
		} else {
			$user_id = (!empty($user_id)) ? $user_id : $this->Auth->user('id');
		}
		$user = $this->User->find('first', array(
			'conditions' => array(
				'User.id' => $user_id
			),
			'fields' => array(
				'User.id',
				'User.username',
				'User.invite_count'
			),
			'recursive' => 0
		));
		$no_of_users_to_invite = Configure::read('site.no_of_users_to_invite');
		if(empty($no_of_users_to_invite) || !is_numeric($no_of_users_to_invite)) {
			$is_limited = false;
		} else {
			$is_limited = true;
			$remining_invite = $no_of_users_to_invite - $user['User']['invite_count'];
		}
		if (!empty($this->request->data)) {
			$invite_count = 0;
			$multipleEmails = explode(',', $this->request->data['Subscription']['invite_emails']);
			foreach($multipleEmails as $key => $singleEmail) {
				if (Validation::email(trim($singleEmail))) {
					if($is_limited && $invite_count >= $remining_invite) {
						break;
					}
					$Subscription = $this->Subscription->find('first', array(
						'conditions' => array(
							'Subscription.email' => trim($singleEmail)
						) ,
						'recursive' => -1
					));
					if(empty($Subscription)) {
						$this->request->data['Subscription']['invite_user_id'] = $user_id;
						$Subscription['Subscription']['email'] = $this->request->data['Subscription']['email'] = trim($singleEmail);
						$this->request->data['Subscription']['is_subscribed'] = 0;
						$this->request->data['Subscription']['is_invite'] = 1;
						$this->request->data['Subscription']['site_state_id'] = ConstSiteState::PrivateBeta;
						$this->request->data['Subscription']['is_sent_private_beta_mail'] = 1;
						$Subscription['Subscription']['invite_hash'] = $this->request->data['Subscription']['invite_hash'] = $this->User->getInviteHash();
						$this->Subscription->create();
                		$this->Subscription->save($this->request->data);
					}
					$emailFindReplace = array(
						'##USER_NAME##' => $this->Auth->user('username'),
						'##INVITE_CODE##' => $Subscription['Subscription']['invite_hash'],
						'##INVITE_LINK##' => Router::url(array(
							'controller' => 'users',
							'action' => 'register',
							'type' => 'social',
							'admin' => false
						) , true),
					);
					$invite_count++;
					$this->Subscription->_sendEmail($email_template, $emailFindReplace, $Subscription['Subscription']['email']);
				}
			}
			$invite_count = $user['User']['invite_count'] + $invite_count;
			$this->User->updateAll(array(
					'User.invite_count' => $invite_count
				), array(
					'User.id' => $user_id
			));
			$this->Session->setFlash(sprintf(__l('%s has been sent'), __l('Invitation')), 'default', null, 'success');
			$this->redirect(array(
				'controller' => 'subscriptions',
				'action' => 'invite_friends'
			));
		} else {
			$this->request->data['User'] = $user['User'];
			if($is_limited) {
				$this->set('is_limited', $is_limited);
				$this->request->data['User']['remining_invite'] = $remining_invite;
			} else {
				$this->set('is_limited', $is_limited);
			}
		}
	}
	public function admin_send_invitation($id = null)
    {
		App::import('Model', 'EmailTemplate');
		$this->EmailTemplate = new EmailTemplate();
		$email_template = $this->EmailTemplate->selectTemplate('Invite User');
		$Subscription = $this->Subscription->find('first', array(
			'conditions' => array(
				'Subscription.id' => $id,
				'Subscription.is_sent_private_beta_mail' => 0
			) ,
			'recursive' => -1
		));
		if(!empty($Subscription)) {

			$emailFindReplace = array(
				'##INVITE_CODE##' => $Subscription['Subscription']['invite_hash'],
				'##INVITE_LINK##' => Router::url(array(
					'controller' => 'users',
					'action' => 'register',
					'type' => 'social',
					'admin' => false
				) , true),
			);
			$this->Subscription->_sendEmail($email_template, $emailFindReplace, $Subscription['Subscription']['email']);
			$this->Subscription->updateAll(array(
                'Subscription.is_sent_private_beta_mail' => 1
            ) , array(
                'Subscription.id' => $id
            ));
			$this->Session->setFlash(sprintf(__l('%s has been sent'), __l('Invitation')), 'default', null, 'success');
				
				if(!empty($this->request->query['r'])) {
					 $this->redirect(Router::url('/',true).$this->request->query['r']);
				} else {
					$this->redirect(array(
						'action' => 'index'
					));
				}
		} else {
			$this->Session->setFlash(__l('Invalid Request'), 'default', null, 'error');
			$this->redirect(array(
				'controller' => 'subscriptions',
				'action' => 'invite_friends'
			));
		}
	}
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->Subscription->recursive = 0;
		$this->pageTitle = __l('Users');
        $conditions = array();
		if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data[$this->modelClass]['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data[$this->modelClass]['filter_id'])) {
            if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::Subscribed) {
                $this->pageTitle.= ' - ' . __l('Subscribed');
                $conditions[$this->modelClass . '.is_subscribed'] = 1;
            } else if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::PrelaunchSubscribed) {
                $this->pageTitle.= ' - ' . __l('Subscribed for Pre-launch');
                $conditions[$this->modelClass . '.site_state_id '] = ConstSiteState::Prelaunch;
            } else if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::PrivateBetaSubscribed) {
                $this->pageTitle.= ' - ' . __l('Subscribed for Private Beta');
                $conditions[$this->modelClass . '.site_state_id '] = ConstSiteState::PrivateBeta;
            }
            $this->request->params['named']['filter_id'] = $this->request->data[$this->modelClass]['filter_id'];
        }
		if (!empty($this->request->params['named']['q'])) {
            $conditions['AND']['OR'][]['Subscription.email LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
		if (!empty($this->request->data['Subscription']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->data['Subscription']['q']
            ));
        }
        $this->set('subscribed', $this->Subscription->find('count', array(
            'conditions' => array(
                'Subscription.is_subscribed = ' => 1
            ),
			'recursive' => -1,
        )));
		App::import('Model', 'User');
		$this->User = new User(); 
		$this->set('pending', $this->User->find('count', array(
            'conditions' => array(
                'User.is_active' => 0
            ) ,
            'recursive' => -1
        )));
        // total approved users list
        $this->set('approved', $this->User->find('count', array(
            'conditions' => array(
                'User.is_active' => 1
            ) ,
            'recursive' => -1
        )));
        // total openid users list
        $this->set('openid', $this->User->find('count', array(
            'conditions' => array(
                'User.is_openid_register' => 1,
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
        $this->set('gmail', $this->User->find('count', array(
            'conditions' => array(
                'User.is_google_register' => 1,
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
        $this->set('yahoo', $this->User->find('count', array(
            'conditions' => array(
                'User.is_yahoo_register' => 1,
                'User.role_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('users_count', $this->User->find('count', array(
                'conditions' => array(
                    'User.role_id' => ConstUserTypes::User,
                ) ,
                'recursive' => -1
            )));		
        $this->set('site_users', $this->User->find('count', array(
            'conditions' => array(
                'User.is_facebook_register =' => 0,
                'User.is_twitter_register =' => 0,
                'User.is_openid_register =' => 0,
                'User.is_yahoo_register =' => 0,
                'User.is_google_register =' => 0,
				'User.is_googleplus_register =' => 0,
                'User.is_linkedin_register' => 0,
                'User.role_id !=' => ConstUserTypes::Admin,
            ) ,
            'recursive' => -1
        )));
        $this->set('admin_count', $this->User->find('count', array(
            'conditions' => array(
                'User.role_id' => ConstUserTypes::Admin,
            ) ,
            'recursive' => -1
        )));
		if(isPluginEnabled('Affiliates')) {
			$this->set('affiliate_user_count', $this->User->find('count', array(
				'conditions' => array(
					'User.is_affiliate_user' => 1,
				) ,
				'recursive' => -1
			)));
		}
        // total users list
        $this->set('total_users_count', $this->User->find('count', array(
            'recursive' => -1
        )));
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
		if ($this->RequestHandler->ext == 'csv') {
            Configure::write('debug', 0);
            $this->set('subscription', $this);
            $this->set('conditions', $conditions);
            if (isset($this->request->data['Subscription']['q'])) {
                $this->set('q', $this->request->data['Subscription']['q']);
            }
        } else {
			$this->paginate = array(
			'conditions' => $conditions,
			'contain' => array(
			       'User',
				   'InviteUser',
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
                        'fields' => array(
                            'Ip.ip',
                            'Ip.latitude',
                            'Ip.longitude',
                            'Ip.host'
                        )
                    ) ,
			),
			'order' => array(
                    'Subscription.id' => 'desc'
              ),
		    );
			$this->set('subscriptions', $this->paginate());
			$moreActions = $this->Subscription->moreActions;
			$this->set('moreActions',$moreActions);
		}
    }
    public function admin_delete($id = null)
    {	
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Subscription->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Subscription')), 'default', null, 'success');
		if(!empty($this->request->query['r'])) {
			 $this->redirect(Router::url('/',true).$this->request->query['r']);
		} else {
			$this->redirect(array(
				'action' => 'index'
			));
		}
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }

	public function social_like()
    {
        $cookie_value = $this->Cookie->read('subscription_id');
        if (empty($cookie_value)) {
            $this->Cookie->write('social_like', '1', false, sprintf('+%s hours', Configure::read('affiliate.referral_cookie_expire_time')));
        } else {
            $_data['Subscription']['id'] = $cookie_value;
            $_data['Subscription']['is_social_like'] = 1;
            $this->Subscription->save($_data);
        }
        exit;
    }

	public function confirmation($id = null)
	{
		$Subscription = $this->Subscription->find('first', array(
			'conditions' => array(
				'Subscription.id' => $id,
			) ,
			'recursive' => -1
		));
		if(empty($Subscription)) {
			$this->Session->setFlash(__l('Invalid request, please subscribe again'), 'default', null, 'error');
		}
		if(empty($Subscription['Subscription']['is_email_verified'])) {
			$this->Subscription->updateAll(array('Subscription.is_email_verified'=>1),
				array('Subscription.id'=>$id)
			);
			$_SESSION['message']= 1;
		} else {
			$this->Session->setFlash(__l('Email address already verified .') , 'default', null, 'error');
		}
		$this->redirect(array(
			'controller' => $this->request->params['controller'],
			'action' => 'add'
		));
	}


}
?>