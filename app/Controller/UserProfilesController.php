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
class UserProfilesController extends AppController
{
    public $name = 'UserProfiles';
    public $uses = array(
        'UserProfile',
        'Attachment',
        'EmailTemplate',
        'Payment'
    );
    public $components = array(
        'Email'
    );
	public $permanentCacheAction = array(
		'admin' => array(
			'edit',
		) ,
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'UserAvatar.filename',
            'City.id',
            'State.id',
            'UserProfile.country_id',
            'UserProfile.gender_id',
            'State.name',
            'City.name',
        );
        parent::beforeFilter();
    }
    public function edit($user_id = null)
    {
        $this->pageTitle = __l('Edit Profile');
        $this->UserProfile->User->UserAvatar->Behaviors->attach('ImageUpload', Configure::read('avatar.file'));
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            unset($this->UserProfile->validate['dob']);
            unset($this->UserProfile->validate['address']);
            unset($this->UserProfile->validate['gender_id']);
			unset($this->UserProfile->validate['country_id']);
            unset($this->UserProfile->City->validate['name']);
            unset($this->UserProfile->State->validate['name']);
        }
        if (!empty($this->request->data)) {
            if (empty($this->request->data['User']['id'])) {
                $this->request->data['User']['id'] = $this->Auth->user('id');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id',
                            'UserProfile.language_id',
                        )
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            if (!empty($user)) {
                $this->request->data['UserProfile']['id'] = $user['UserProfile']['id'];
                if (!empty($user['UserAvatar']['id'])) {
                    $this->request->data['UserAvatar']['id'] = $user['UserAvatar']['id'];
                }
            }
            $this->request->data['UserProfile']['user_id'] = $this->request->data['User']['id'];
            if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                $this->request->data['UserAvatar']['filename']['type'] = get_mime($this->request->data['UserAvatar']['filename']['tmp_name']);
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name']) || (!Configure::read('avatar.file.allowEmpty') && empty($this->request->data['UserAvatar']['id']))) {
                $this->UserProfile->User->UserAvatar->set($this->request->data);
            }
            if (empty($this->request->data['UserProfile']['gender_id'])) {
                $this->request->data['UserProfile']['gender_id'] = '';
            }
            $this->UserProfile->set($this->request->data);
            $this->UserProfile->User->set($this->request->data);
            $this->UserProfile->State->set($this->request->data);
            $this->UserProfile->City->set($this->request->data);
			$this->request->data['Country']['iso_alpha2'] = $this->request->data['UserProfile']['country_id'];
            $ini_upload_error = 1;
            if (isset($this->request->data['UserAvatar']['filename']) && $this->request->data['UserAvatar']['filename']['error'] == 1) {
                $ini_upload_error = 0;
            }
            if ($this->UserProfile->User->validates() &$this->UserProfile->validates() &$this->UserProfile->User->UserAvatar->validates() && $ini_upload_error) {
                if (!empty($this->request->data['UserProfile']['country_id'])) {
                    $this->request->data['UserProfile']['country_id'] = $this->UserProfile->Country->findCountryId($this->request->data['UserProfile']['country_id']);
                }
                $this->request->data['UserProfile']['city_id'] = !empty($this->request->data['City']['id']) ? $this->request->data['City']['id'] : $this->UserProfile->City->findOrSaveAndGetId($this->request->data['City']['name']);
                $this->request->data['UserProfile']['state_id'] = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->UserProfile->State->findOrSaveAndGetId($this->request->data['State']['name']);
                if ($this->UserProfile->save($this->request->data)) {
                    // @todo "Language Filter"
                    if(!empty($this->request->data['UserProfile']['language_id'])){
                    $this->UserProfile->User->Property->updateAll(array(
                        'Property.language_id' => $this->request->data['UserProfile']['language_id'],
                    ) , array(
                        'Property.user_id' => $this->request->data['UserProfile']['user_id']
                    ));}
                    if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                        $this->Attachment->create();
                        $this->request->data['UserAvatar']['class'] = 'UserAvatar';
                        $this->request->data['UserAvatar']['foreign_id'] = $this->request->data['User']['id'];
                        $this->Attachment->save($this->request->data['UserAvatar']);
                        $this->request->data['User']['attachment_id'] = $this->Attachment->id;
                    }
                    $this->UserProfile->User->save($this->request->data['User']);
					if(empty($user['User']['is_active'])){
						if(!empty($this->request->data['User']['is_active'])){
							$this->_sendAdminActionMail($this->request->data['User']['id'], 'Admin User Active');
						}
					}else{
						if(empty($this->request->data['User']['is_active'])){
							$this->_sendAdminActionMail($this->request->data['User']['id'], 'Admin User Deactivate');
						}
					}
                }
				Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'UserProfile',
                        'action' => 'Updated',
                        'label' => $this->Auth->user('username') ,
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'ud' => $this->Auth->user('id') ,
                        'rud' => $this->Auth->user('referred_by_user_id') ,
                    )
                ));
                $this->Session->setFlash(__l('User Profile has been updated') , 'default', null, 'success');
                if ($this->Auth->user('role_id') == ConstUserTypes::Admin and $this->Auth->user('id') != $this->request->data['User']['id'] and Configure::read('user.is_mail_to_user_for_profile_edit')) {
                    // Send mail to user to activate the account and send account details
                    $email = $this->EmailTemplate->selectTemplate('Admin User Edit');
                    $emailFindReplace = array(
                        '##USERNAME##' => $user['User']['username'],
                    );
					$this->UserProfile->_sendEmail($email,$emailFindReplace,$user['User']['email']);
                }
            } else {
                if (isset($this->request->data['UserAvatar']['filename']) && $this->request->data['UserAvatar']['filename']['error'] == 1) {
                    $this->UserProfile->User->UserAvatar->validationErrors['filename'] = sprintf(__l('The file uploaded is too big, only files less than %s permitted') , ini_get('upload_max_filesize'));
                }
                $this->Session->setFlash(__l('User Profile could not be updated. Please, try again.') , 'default', null, 'error');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id'
                        )
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    )
                ) ,
                'recursive' => 2
            ));
            if (!empty($user['User'])) {
                unset($user['UserProfile']);
                $this->request->data['User'] = array_merge($user['User'], $this->request->data['User']);
                $this->request->data['User']['UserAvatar'] = $user['UserAvatar'];
            }
			$this->redirect(array(
				'controller' => 'user_profiles',
				'action' => 'edit',
				$this->request->data['User']['id']
			));
        } else {
            if (empty($user_id)) {
                $user_id = $this->Auth->user('id');
            }
			if(isPluginEnabled('Properties')){
				$contain_prop = array(
                    'Habit' => array(
                        'fields' => array(
                            'Habit.id',
                            'Habit.name',
                        )
                    ) 
				) ;
			}
			$contain = array(
                    'User' => array(
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.dir',
                                'UserAvatar.filename',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        ) ,
                    ) ,
                    'City' => array(
                        'fields' => array(
                            'City.name'
                        )
                    ) ,
                    'State' => array(
                        'fields' => array(
                            'State.name'
                        )
                    ) ,
					'Country' => array(
						'fields' => array(
							'Country.iso_alpha2'
						)
					) ,
				) ;
				
			$contain= array_merge($contain_prop,$contain);
            $user = $this->UserProfile->find('first', array(
                'conditions' => array(
                    'UserProfile.user_id' => $user_id
                ) ,
                'contain' => $contain,
                'recursive' => 2
            ));
            if (empty($user)) {
                if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                    $user_id = $this->Auth->user('id');
                }
                $user = $this->UserProfile->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $user_id
                    ) ,
                    'contain' => array(
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.dir',
                                'UserAvatar.filename',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        ) ,
                    ) ,
                    'recursive' => 2
                ));
            }
            $this->request->data = $user;
            if (!empty($this->request->data['UserProfile']['City'])) {
                $this->request->data['City']['name'] = $this->request->data['UserProfile']['City']['name'];
            }
            if (!empty($this->request->data['UserProfile']['State']['name'])) {
                $this->request->data['State']['name'] = $this->request->data['UserProfile']['State']['name'];
            }
			if (!empty($this->request->data['Country']['iso_alpha2'])) {
                $this->request->data['UserProfile']['country_id'] = $this->request->data['Country']['iso_alpha2'];
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
        }
        $this->pageTitle.= ' - ' . $this->request->data['User']['username'];
        $genders = $this->UserProfile->Gender->find('list');
		$user_educations = array();
		if(isPluginEnabled('Insights')){
			$userEducations = $this->UserProfile->UserEducation->find('list', array(
				'conditions' => array(
					'UserEducation.is_active' => 1
				),
				'fields' => array(
					'UserEducation.education'
				),
				'recursive' => -1,
			));
		}
        $userEmployments = $this->UserProfile->UserEmployment->find('list', array(
            'conditions' => array(
				'UserEmployment.is_active' => 1
			),
            'fields' => array(
                'UserEmployment.employment'
            ),
			'recursive' => -1,
        ));
        $userIncomeRanges = $this->UserProfile->UserIncomeRange->find('list', array(
            'conditions' => array(
				'UserIncomeRange.is_active' => 1
			),
            'fields' => array(
                'UserIncomeRange.income'
            ),
			'recursive' => -1,
        ));
        $userRelationships = $this->UserProfile->UserRelationship->find('list', array(
			'conditions' => array(
				'UserRelationship.is_active' => 1
			),
            'fields' => array(
                'UserRelationship.relationship'
            ),
			'recursive' => -1,
        ));
        $habits = $this->UserProfile->Habit->find('list', array(
			'conditions' => array(
				'Habit.is_active' => 1
			),
			'recursive' => -1,
		));
		$countries = $this->UserProfile->Country->find('list', array(
            'fields' => array(
                'Country.iso_alpha2',
                'Country.name'
            ) ,
            'order' => array(
                'Country.name' => 'ASC'
            ),
			'recursive' => -1,
        ));
        $languages = $this->UserProfile->Language->find('list', array(
            'conditions' => array(
                'Language.is_active' => 1
            ),
			'recursive' => -1,
        ));
        $this->set(compact('genders', 'userEducations', 'userEmployments', 'userIncomeRanges', 'userRelationships', 'countries', 'languages', 'habits'));
    }
	public function profile_image($user_id = null)
    {
        $this->pageTitle = sprintf(__l('%s Image') , __l('Profile'));
        $this->UserProfile->User->UserAvatar->Behaviors->attach('ImageUpload', Configure::read('avatar.file'));
        if (!empty($this->request->data)) {
            if (empty($this->request->data['User']['id'])) {
                $this->request->data['User']['id'] = $this->Auth->user('id');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserAvatar'
                ) ,
                'recursive' => 0
            ));
            if (!empty($user)) {
                if (!empty($user['UserAvatar']['id'])) {
                    $this->request->data['UserAvatar']['id'] = $user['UserAvatar']['id'];
                }
            }

            if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                $this->request->data['UserAvatar']['filename']['type'] = get_mime($this->request->data['UserAvatar']['filename']['tmp_name']);
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name']) || !empty($this->request->data['s3_file_url']) || (!Configure::read('avatar.file.allowEmpty') && empty($this->request->data['UserAvatar']['id']))) {
                $this->UserProfile->User->UserAvatar->set($this->request->data);
            }

            $this->UserProfile->User->set($this->request->data);
			$ini_upload_error = 1;
            if ($this->request->data['UserAvatar']['filename']['error'] == 1 && empty($this->request->data['s3_file_url'])) {
                $ini_upload_error = 0;
            }

			if ($this->UserProfile->User->validates() && $this->UserProfile->User->UserAvatar->validates() && $ini_upload_error ) {
				$this->UserProfile->User->save($this->request->data['User']);
				if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
					$this->Attachment->create();
					$this->request->data['UserAvatar']['class'] = 'UserAvatar';
					$this->request->data['UserAvatar']['foreign_id'] = $this->request->data['User']['id'];
					$this->Attachment->save($this->request->data['UserAvatar']);
				}
				$this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Profile Image')) , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'user_profiles',
                    'action' => 'profile_image',
                    $this->request->data['User']['id']
                ));
			} else {
				if ($this->request->data['UserAvatar']['filename']['error'] == 1) {
					$this->UserProfile->User->UserAvatar->validationErrors['filename'] = sprintf(__l('The file uploaded is too big, only files less than %s permitted') , ini_get('upload_max_filesize'));
				}
				$this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Profile Image')) , 'default', null, 'error');
			}

            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id'
                        )
                    ) ,
                    'UserAvatar'
                ) ,
                'recursive' => 0
            ));
            if (!empty($user['User'])) {
                unset($user['UserProfile']);
                $this->request->data['User'] = array_merge($user['User'], $this->request->data['User']);
                $this->request->data['UserAvatar'] = $user['UserAvatar'];
            }
        } else {
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                $user_id = $this->Auth->user('id');
            } else {
                $user_id = $user_id ? $user_id : $this->Auth->user('id');
            }
            $this->request->data = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id
                ) ,
                'contain' => array(
                    'UserAvatar'
                ) ,
                'recursive' => 0
            ));
        }
        $this->pageTitle.= ' - ' . $this->request->data['User']['username'];
    }
    public function admin_edit($id = null)
    {
        if (is_null($id) && empty($this->request->data)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->setAction('edit', $id);
    }
    public function _sendAdminActionMail($user_id, $email_template)
    {
        // @todo "User activation" check user.is_send_email_notifications_only_to_verified_email_account
        $user = $this->UserProfile->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'contain' => array(
                'UserProfile'
            ) ,
            'recursive' => 1
        ));
        $email = $this->EmailTemplate->selectTemplate($email_template);
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
            '##FROM_EMAIL##' => ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'],
        );
		$this->UserProfile->_sendEmail($email,$emailFindReplace, $user['User']['email']);
    }
}
?>