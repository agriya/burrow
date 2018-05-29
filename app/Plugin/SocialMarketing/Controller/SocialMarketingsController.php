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
class SocialMarketingsController extends AppController
{
    public $name = 'SocialMarketings';
    public $components = array(
        'RequestHandler'
    );
    public $permanentCacheAction = array(
        'user' => array(
            'publish',
            'import_friends',
        ) ,
    );
    public function import_friends()
    {
        $this->pageTitle = __l('Find Friends');
		App::import('Model', 'User');
		$this->User = new User();   
        $config = array(
            'base_url' => Router::url('/', true) . 'socialauth/',
            'providers' => array(
                'Facebook' => array(
                    'enabled' => true,
                    'keys' => array(
                        'id' => Configure::read('facebook.app_id') ,
                        'secret' => Configure::read('facebook.secrect_key')
                    ) ,
                    'scope' => 'email, user_about_me, user_birthday, user_hometown',
                ) ,
                'Twitter' => array(
                    'enabled' => true,
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
				'Googleplus' => array(
                    'enabled' => true,
                    'keys' => array(
                        'id' => Configure::read('googleplus.consumer_key') ,
                        'secret' => Configure::read('googleplus.consumer_secret')
                    ) ,
                ) ,
                'Yahoo' => array(
                    'enabled' => true,
                    'keys' => array(
                        'key' => Configure::read('invite.yahoo_consumer_key') ,
                        'secret' => Configure::read('invite.yahoo_secret_key')
                    ) ,
                ) ,
                'Linkedin' => array(
                    'enabled' => true,
                    'keys' => array(
                        'key' => Configure::read('linkedin.consumer_key') ,
                        'secret' => Configure::read('linkedin.consumer_secret')
                    ) ,
                ) ,
            )
        );
        if ($this->request->params['named']['type'] == 'facebook') {
            $this->pageTitle.= ' - Facebook';
            $next_action = 'twitter';
        } elseif ($this->request->params['named']['type'] == 'twitter') {
            $this->pageTitle.= ' - Twitter';
            $next_action = 'gmail';
            $this->User->updateAll(array(
                'User.is_skipped_fb' => 1
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
        } elseif ($this->request->params['named']['type'] == 'gmail') {
            $this->pageTitle.= ' - Gmail';
            $next_action = 'yahoo';
            $this->User->updateAll(array(
                'User.is_skipped_twitter' => 1
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
        } elseif ($this->request->params['named']['type'] == 'yahoo') {
            $this->pageTitle.= ' - Yahoo!';
            $this->User->updateAll(array(
                'User.is_skipped_google' => 1,
				'User.is_skipped_yahoo' => 1
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
        }
        if (!empty($this->request->params['named']['import'])) {
            $options = array();
            if ($this->request->params['named']['import'] == 'openid') {
                $options = array(
                    'openid_identifier' => 'https://openid.stackexchange.com/'
                );
            }
			try{
            require_once (APP . DS . WEBROOT_DIR . DS . 'socialauth/Hybrid/Auth.php');
            $hybridauth = new Hybrid_Auth($config);
            if (!empty($this->request->params['named']['redirecting'])) {
                $adapter = $hybridauth->authenticate(ucfirst($this->request->params['named']['import']) , $options);
                $loggedin_contact = $social_profile = $adapter->getUserProfile();
                $is_correct_user = $this->User->_checkConnection($social_profile, $this->request->params['named']['import']);
                if ($is_correct_user) {
                    $this->User->updateSocialContact($social_profile, $this->request->params['named']['import']);
                    $social_contacts = $adapter->getUserContacts();
					array_push($social_contacts, $loggedin_contact);
                    $this->SocialMarketing->import_contacts($social_contacts, $this->request->params['named']['import']);
					$this->Session->delete('HA::CONFIG');
					$this->Session->delete('HA::STORE');
                    if (!empty($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'social') {
                        $this->Session->setFlash(sprintf(__l('You have connected %s successfully!') , $this->request->params['named']['import']) , 'default', null, 'success');
					} elseif (empty($this->request->params['named']['from'])) {
						$this->Session->setFlash(sprintf(__l('Your %s contact has been imported successfully!.') , $this->request->params['named']['import']) , 'default', null, 'success');
					}
					echo '<script>window.close();</script>';
					exit;
                } else {
					$this->Session->delete('HA::CONFIG');
					$this->Session->delete('HA::STORE');
                    $this->Session->setFlash(__l('This social network account already connected by other user.') , 'default', null, 'error');
					echo '<script>window.close();</script>';
					exit;
                }
            } else {
                $reditect = Router::url(array(
                    'controller' => 'social_marketings',
                    'action' => 'import_friends',
                    'type' => $this->request->params['named']['type'],
                    'import' => $this->request->params['named']['import'],
                    'redirecting' => $this->request->params['named']['import'],
                    'from' => !empty($this->request->params['named']['from']) ? $this->request->params['named']['from'] : '',
                ) , true);
                $this->layout = 'redirection';
                $this->set('redirect_url', $reditect);
                $this->set('authorize_name', ucfirst($this->request->params['named']['import']));
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
					echo '<script>window.close();</script>';
					exit;
			}
        }
        $this->set(compact('next_action'));
    }
    public function publish_request($id = null)
    {
		App::import('Model', 'Requests.Request');
		$this->Request = new Request();
		App::import('Model', 'User');
		$this->User = new User();   
        if (empty($id) || empty($this->request->params['named']['type']) || empty($this->request->params['named']['publish_action'])) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'dashboard',
            ));
        }
		if ($this->request->params['named']['publish_action'] == 'add') {
			$condition['Request.id'] = $id;
			$request = $this->Request->find('first', array(
				'conditions' => $condition,
				'contain' => array(
					'User',
				) ,
				'recursive' => 0
			));
		   $request['Request']['information'] = $request['Request']['title'];
		   $page_title = $this->Auth->user('username').' '.__l('posted').' ';
		} elseif ($this->request->params['named']['publish_action'] == 'follow') {
			$condition['RequestFavorite.id'] = $id;
			$RequestFavorite = $this->Property->RequestFavorite->find('first', array(
				'conditions' => $condition,
				'contain' => array(
					'Request' => array(
						'PropertyType'
					) ,
				) ,
				'recursive' => 2
			));
			App::import('Model', 'User');
			$this->User = new User();   
			$user = $this->User->find('first', array(
				'conditions' => array(
						'User.id' => $RequestFavorite['PropertyFavorite']['user_id']
				),
				'fields' => array(
					'User.username',
				) ,
				'recursive' => -1
			));
			$request['Request'] = $RequestFavorite['Request'];
			$page_title = $user['User']['username'].' '.__l('followed').' ';
			$request['Request']['information'] = $page_title.' '.$property['Request']['title'];
		}
		if (empty($request['Request']['is_active'])) {
			throw new NotFoundException(__l('Invalid request'));
		}
		$request_url = Router::url(array(
			'controller' => 'requests',
			'action' => 'view',
			$request['Request']['slug'],
		) , true);
		if ($this->request->params['named']['type'] == 'facebook') {
			$user = $this->User->find('first', array(
				'conditions' => array(
					'id' => $this->Auth->user('id')
				) ,
				'recursive' => -1
			));
			$next_action = 'twitter';
		} elseif ($this->request->params['named']['type'] == 'twitter') {
			$next_action = 'others';
		} elseif ($this->request->params['named']['type'] == 'others') {
			$next_action = 'promote';
		}
        $this->pageTitle = $request['Request']['title'] . ' - ' . __l('Share');
        $this->set(compact('request_url', 'request', 'next_action', 'id'));
    }
    public function publish($id = null)
    {
		App::import('Model', 'Properties.Property');
		$this->Property = new Property();
		App::import('Model', 'User');
		$this->User = new User();   
		
        if (empty($id) || empty($this->request->params['named']['type']) || empty($this->request->params['named']['publish_action'])) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'dashboard',
            ));
        }
		if ($this->request->params['named']['publish_action'] == 'add') {
			$condition['Property.id'] = $id;
			$property = $this->Property->find('first', array(
				'conditions' => $condition,
				'contain' => array(
					'PropertyType',
					'Attachment'=>array(
						'fields' => array(
							'Attachment.id',
							'Attachment.dir',
							'Attachment.filename',
							'Attachment.width',
							'Attachment.height',
							'Attachment.description'
						)
					) ,
					'User',
				) ,
				'recursive' => 2
			));
			$property['Attachment'] = $property['Attachment'];
		   $property['Property']['information'] = $property['Property']['title'];
		   $page_title = $this->Auth->user('username').' '.__l('posted').' ';
		} elseif ($this->request->params['named']['publish_action'] == 'follow') {
			if(isPluginEnabled('PropertyFavorites')) {
			$condition['PropertyFavorite.id'] = $id;
			$PropertyFavorite = $this->Property->PropertyFavorite->find('first', array(
				'conditions' => $condition,
				'contain' => array(
					'Property' => array(
						'Attachment',
						'PropertyType'
					) ,
				) ,
				'recursive' => 2
			));
			$property['Property'] = $PropertyFavorite['Property'];
			$property['PropertyType'] = $PropertyFavorite['Property']['PropertyType'];
			$property['Attachment'] = $PropertyFavorite['Property']['Attachment'];
			}
			App::import('Model', 'User');
			$this->User = new User();   
			$user = $this->User->find('first', array(
				'conditions' => array(
						'User.id' => $PropertyFavorite['PropertyFavorite']['user_id']
				),
				'fields' => array(
					'User.username',
				) ,
				'recursive' => -1
			));
			$page_title = $user['User']['username'].' '.__l('followed').' ';
			$property['Property']['information'] = $page_title.' '.$property['Property']['title'];
		}
		if (empty($property['Property']['is_active'])) {
			throw new NotFoundException(__l('Invalid request'));
		}
		$image_options = array(
			'dimension' => 'small_big_thumb',
			'class' => '',
			'alt' => $property['Property']['title'],
			'title' => $property['Property']['title'],
			'type' => 'png',
			'full_url' => true
		);
		$property_image = getImageUrl('Property', $property['Attachment'][0], $image_options);
		$property_url = Router::url(array(
			'controller' => 'properties',
			'action' => 'view',
			$property['Property']['slug'],
		) , true);
		if ($this->request->params['named']['type'] == 'facebook') {
			$user = $this->User->find('first', array(
				'conditions' => array(
					'id' => $this->Auth->user('id')
				) ,
				'recursive' => -1
			));
			$next_action = 'twitter';
		} elseif ($this->request->params['named']['type'] == 'twitter') {
			$next_action = 'others';
		} elseif ($this->request->params['named']['type'] == 'others') {
			$next_action = 'promote';
		}
        $this->pageTitle = $property['Property']['title'] . ' - ' . __l('Share');
        $this->set(compact('property_image', 'property_url', 'property', 'next_action', 'id'));
    }
    public function publish_success($current_page, $id, $action)
    {
        $this->set(compact('current_page', 'id', 'action'));
        $this->layout = 'ajax';
    }
    public function myconnections($social_type = null)
    {
        $this->pageTitle = __l('Social');
		if (!empty($this->request->data)) {
			$this->request->data['User']['id'] = $this->Auth->user('id');
			$this->User->save($this->request->data);
			$_SESSION['Auth']['User']['is_show_facebook_friends'] = $this->request->data['User']['is_show_facebook_friends'];
			$this->Session->setFlash(__l('Social networks settings updated successfully.') , 'default', null, 'success');
		}
        if (!empty($social_type)) {
			App::import('Model', 'User');
			$this->User = new User();   
			$__data = array();
            $_data['User']['id'] = $this->Auth->user('id');
			$_data['User']['is_'.$social_type.'_connected'] = 0;
			$_data['User']['user_avatar_source_id'] = 0;
            $this->User->save($_data);
            $this->Session->setFlash(sprintf(__l('You have disconnected from %s') , $social_type) , 'default', null, 'success');
			$this->redirect(array(
				'controller' => 'social_marketings',
				'action' => 'myconnections',
			));
        }
    }
    public function promote_retailmenot($id)
    {
		//empty
    }
}
?>