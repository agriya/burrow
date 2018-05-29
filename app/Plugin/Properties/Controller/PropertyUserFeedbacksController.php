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
class PropertyUserFeedbacksController extends AppController
{
    public $name = 'PropertyUserFeedbacks';
    public $components = array(
        'Email',
    );
    public $helpers = array(
        'Embed'
    );
	public $permanentCacheAction = array(
		'user' => array(
			'add',
		) ,
		'public' => array(
			'index',
		) ,
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Attachment',
            'Attachment.file',
            'PropertyUserFeedback',
        );
        parent::beforeFilter();
    }
    public function add()
    {
        $this->pageTitle = __l('Review');
        if (!empty($this->request->data)) {
            $this->PropertyUserFeedback->create();
            $this->request->data['PropertyUserFeedback']['ip_id'] = $this->PropertyUserFeedback->toSaveIp();
            if ($this->PropertyUserFeedback->validates($this->request->data)) {
                $this->PropertyUserFeedback->save($this->request->data);
				$this->Session->setFlash(__l('Feedback has been added.') , 'default', null, 'success');
                //send
                if (Configure::read('messages.is_send_internal_message')) {
                    $message_id = $this->PropertyUserFeedback->PropertyUser->User->Message->sendNotifications($this->request->data['PropertyUserFeedback']['property_user_user_id'], $this->Auth->user('username') . ' has left a feedback about you', $this->request->data['PropertyUserFeedback']['feedback'], $this->request->data['PropertyUserFeedback']['property_user_id'], $is_review = 0, $this->request->data['PropertyUserFeedback']['property_id'], ConstPropertyUserStatus::HostReviewed);
                    if (Configure::read('messages.is_send_email_on_new_message')) {
                        $content['subject'] = $this->Auth->user('username') . ' has left a feedback about you';
                        $content['message'] = $this->Auth->user('username') . ' has left a feedback about you';
                        if (!empty($this->request->data['PropertyUserFeedback']['property_order_user_email'])) {
                            if ($this->PropertyUserFeedback->_checkUserNotifications($this->request->data['PropertyUserFeedback']['property_user_id'], ConstPropertyUserStatus::Completed, 0)) { // (to_user_id, order_status,is_sender);
                                $this->PropertyUserFeedback->_sendAlertOnNewMessage($this->request->data['PropertyUserFeedback']['property_order_user_email'], $content, $message_id, 'Booking Alert Mail');
                            }
                        }
                    }
                }
                $data = array();
                $data['PropertyUser']['id'] = $this->request->data['PropertyUserFeedback']['property_order_id'];
                $data['PropertyUser']['is_host_reviewed'] = 1;
                $this->PropertyUserFeedback->PropertyUser->save($data, false);
                $this->redirect(array(
                    'controller' => 'property_users',
                    'action' => 'index',
                    'type' => 'myworks',
                    'status' => 'waiting_for_review',
                ));
            } else {
                $this->Session->setFlash(__l('Feedback could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        if (!empty($this->request->params['named']) || !empty($this->request->data['PropertyUserFeedback']['property_order_id'])) {
            $propertyInfo = $this->PropertyUserFeedback->PropertyUser->find('first', array(
                'conditions' => array(
                    'PropertyUser.id =' => !empty($this->request->data['PropertyUserFeedback']['property_order_id']) ? $this->request->data['PropertyUserFeedback']['property_order_id'] : $this->request->params['named']['property_order_id'],
                    'PropertyUser.property_user_status_id' => array(
                        ConstPropertyUserStatus::WaitingforReview,
                        ConstPropertyUserStatus::PaymentCleared,
                        ConstPropertyUserStatus::Completed
                    ) ,
                    'PropertyUser.is_host_reviewed' => 0,
                    'PropertyUser.owner_user_id' => $this->Auth->user('id')
                ) ,
                'contain' => array(
                    'Property' => array(
                        'User',
                        'Attachment',
                        'City' => array(
                            'fields' => array(
                                'City.id',
                                'City.name',
                                'City.slug',
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2'
                            )
                        ) ,
                    )
                ) ,
                'recursive' => 3,
            ));
            if (empty($propertyInfo) || ($propertyInfo['PropertyUser']['owner_user_id'] != $this->Auth->user('id'))) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $traveler = $this->PropertyUserFeedback->PropertyUser->User->find('first', array(
                'conditions' => array(
                    'User.id' => $propertyInfo['PropertyUser']['user_id']
                ) ,
                'recursive' => -1
            ));
            $this->set('traveler', $traveler);
            $message['property_id'] = $propertyInfo['PropertyUser']['property_id'];
            $message['property_order_id'] = $propertyInfo['PropertyUser']['id'];
            $message['property_user_user_id'] = $propertyInfo['PropertyUser']['user_id'];
            $message['property_user_status_id'] = $propertyInfo['PropertyUser']['property_user_status_id'];
            $message['property_seller_username'] = $propertyInfo['Property']['User']['username'];
            $message['property_user_id'] = $propertyInfo['PropertyUser']['id'];
            $message['property_traveler_email'] = $traveler['User']['email'];
            $message['traveler_username'] = $traveler['User']['username'];
            $message['property_username'] = $propertyInfo['Property']['User']['username'];
            $this->set('message', $message);
            $this->set('propertyInfo', $propertyInfo);
        }
        if (empty($this->request->data['PropertyUserFeedback'])) {
            $this->request->data['PropertyUserFeedback']['is_satisfied'] = '1';
        }
    }
    public function index()
    {
        $conditions = array();
        $this->pageTitle = __l('Feedbacks');
        $this->PropertyUserFeedback->recursive = 1;
		if(empty($this->request->params['named'])) {
			 throw new NotFoundException(__l('Invalid request'));
		}
        if (!empty($this->request->params['named']['user_id'])) {
            $conditions['PropertyUserFeedback.traveler_user_id'] = $this->request->params['named']['user_id'];
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
					'fields' => array(
						'User.username',
						'User.role_id',
						'User.attachment_id',
						'User.facebook_user_id',
						'User.twitter_avatar_url',
						'User.user_avatar_source_id'
					)
				)
            ) ,
            'fields' => array(
                'PropertyUserFeedback.id',
                'PropertyUserFeedback.created',
                'PropertyUserFeedback.property_user_id',
                'PropertyUserFeedback.property_id',
                'PropertyUserFeedback.feedback',
                'PropertyUserFeedback.video_url',
                'PropertyUserFeedback.is_satisfied',
            ) ,
            'order' => array(
                'PropertyUserFeedback.id' => 'desc'
            ) ,
            'recursive' => 2,
        );
        $this->set('propertyUserFeedbacks', $this->paginate());
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Feedback To Traveler');
        $this->_redirectGET2Named(array(
            'q',
        ));
        $conditions = array();
        if (!empty($this->request->params['named']['property']) || !empty($this->request->params['named']['property_id'])) {
            $propertyConditions = !empty($this->request->params['named']['property']) ? array(
                'Property.slug' => $this->request->params['named']['property']
            ) : array(
                'Property.id' => $this->request->params['named']['property_id']
            );
            $property = $this->PropertyUserFeedback->Property->find('first', array(
                'conditions' => $propertyConditions,
                'fields' => array(
                    'Property.id',
                    'Property.title'
                ) ,
                'recursive' => -1
            ));
            if (empty($property)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['Property.id'] = $this->request->data[$this->modelClass]['property_id'] = $property['Property']['id'];
            $this->pageTitle.= ' - ' . $property['Property']['title'];
        }
        if (!empty($this->request->params['named']['username']) || !empty($this->request->params['named']['user_id'])) {
            $userConditions = !empty($this->request->params['named']['username']) ? array(
                'User.username' => $this->request->params['named']['username']
            ) : array(
                'User.id' => $this->request->params['named']['user_id']
            );
            $user = $this->PropertyUserFeedback->PropertyUser->User->find('first', array(
                'conditions' => $userConditions,
                'fields' => array(
                    'User.id',
                    'User.username'
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['User.id'] = $this->request->data[$this->modelClass]['user_id'] = $user['User']['id'];
            $this->pageTitle.= ' - ' . $user['User']['username'];
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['PropertyUserFeedback']['q'] = $this->request->params['named']['q'];
			$conditions['AND']['OR'][]['Property.title LIKE'] = '%' . $this->request->params['named']['q'] . '%';
			$conditions['AND']['OR'][]['PropertyUserFeedback.feedback LIKE'] = '%' . $this->request->params['named']['q'] . '%';
			$conditions['AND']['OR'][]['PropertyUserFeedback.admin_comments LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->set('page_title', $this->pageTitle);
        $this->PropertyUserFeedback->recursive = 2;
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
                'Property' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                        ) ,
                    )
                ) ,
                'PropertyUser' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                        ) ,
                    )
                ) ,
            ) ,
            'order' => array(
                'PropertyUserFeedback.id' => 'desc'
            )
        );
        $moreActions = $this->PropertyUserFeedback->moreActions;
        $this->set(compact('moreActions'));
        $this->set('propertyFeedbacks', $this->paginate());
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Feedback');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->PropertyUserFeedback->save($this->request->data)) {
                $this->Session->setFlash(__l('Feedback has been updated.') , 'default', null, 'success');
				$this->redirect(array(
					'action' => 'index'
				));				
            } else {
                $this->Session->setFlash(__l('Feedback could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->PropertyUserFeedback->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->PropertyUserFeedback->delete($id)) {
            $this->Session->setFlash(__l('Property User Feedback deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>
