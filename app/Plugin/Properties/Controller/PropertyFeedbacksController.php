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
class PropertyFeedbacksController extends AppController
{
    public $name = 'PropertyFeedbacks';
    public $components = array(
        'Email',
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
            'PropertyFeedback',
        );
        parent::beforeFilter();
    }
    public function index($property_id = null)
    {
        $conditions = array();
        $this->pageTitle = __l('Feedbacks');
        $this->PropertyFeedback->recursive = 1;
		if(empty($this->request->params['named'])) {
			 throw new NotFoundException(__l('Invalid request'));
		}
        if (!empty($this->request->params['named']['property_id']) && empty($this->request->params['named']['user_id'])) {
            $conditions['PropertyFeedback.property_id'] = $this->request->params['named']['property_id'];
        }
        if (!empty($this->request->params['named']['property_id']) && !empty($this->request->params['named']['user_id'])) {
            $property_ids = $this->PropertyFeedback->Property->find('all', array(
                'conditions' => array(
                    'Property.user_id' => $this->request->params['named']['user_id'],
                    'Property.id !=' => $this->request->params['named']['property_id'],
                ) ,
                'fields' => array(
                    'Property.id',
                ) ,
                'recursive' => -1
            ));
            $propertyids = array();
            foreach($property_ids as $property_id) {
                $propertyids[$property_id['Property']['id']] = $property_id['Property']['id'];
            }
            $conditions['PropertyFeedback.property_id'] = $propertyids;
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'PropertyUser' => array(
                    'User'
                ) ,
                'Attachment',
                'Property' => array(
                    'Attachment',
                )
            ) ,
            'order' => array(
                'PropertyFeedback.id' => 'desc'
            ) ,
            'recursive' => 3,
        );
        $this->set('propertyFeedbacks', $this->paginate());
        if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'photos') {
            $thos->autoRender = false;
            $this->render('photos');
        }
        if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'videos') {
            $thos->autoRender = false;
            $this->render('videos');
        }
    }
    public function add()
    {
        $this->pageTitle = __l('Review');
        if (!empty($this->request->data)) {
           // $this->PropertyFeedback->create();
            $uploaded_photo_count = 0;
            for ($i = 0; $i < count($this->request->data['Attachment']); $i++) {
                if (!empty($this->request->data['Attachment'][$i]['filename'])) {
                    $uploaded_photo_count = 1;
                    break;
                }
            }
            $this->request->data['PropertyFeedback']['ip_id'] = $this->PropertyFeedback->toSaveIp();
            if ($this->PropertyFeedback->validates($this->request->data)) {
                $this->PropertyFeedback->save($this->request->data);
                if ($uploaded_photo_count) // attachment is there then
                {
                    $property_feedback_id = $this->PropertyFeedback->getLastInsertId();
                    $this->PropertyFeedback->Attachment->create();
					  // save attachment
					 for ($i = 0; $i < count($this->request->data['Attachment']); $i++) {
                        if (!empty($this->request->data['Attachment'][$i]['filename']['tmp_name'])) {
                            $this->PropertyFeedback->Attachment->create();
                            $data = array();
                            $data['Attachment']['filename'] = $this->request->data['Attachment'][$i]['filename'];
                            $data['Attachment']['foreign_id'] = $property_feedback_id;
                            $data['Attachment']['class'] = 'PropertyFeedback';
                            $data['Attachment']['dir'] = 'PropertyFeedback/' . $property_feedback_id;
                            $this->PropertyFeedback->Attachment->Behaviors->attach('ImageUpload');
                            $this->PropertyFeedback->Attachment->set($data['Attachment']);
                            $this->PropertyFeedback->Attachment->save($data['Attachment']);
                        }
                    }
                }
                //send
                if (Configure::read('messages.is_send_internal_message')) {
                    $message_id = $this->PropertyFeedback->PropertyUser->User->Message->sendNotifications($this->request->data['PropertyFeedback']['property_user_user_id'], $this->Auth->user('username') . ' has left a feedback on your property', $this->request->data['PropertyFeedback']['feedback'], $this->request->data['PropertyFeedback']['property_user_id'], $is_review = 0, $this->request->data['PropertyFeedback']['property_id'], ConstPropertyUserStatus::Completed);
                    if (Configure::read('messages.is_send_email_on_new_message')) {
                        $content['subject'] = $this->Auth->user('username') . ' has left a feedback on your property';
                        $content['message'] = $this->Auth->user('username') . ' has left a feedback on your property';
                        if (!empty($this->request->data['PropertyFeedback']['property_order_user_email'])) {
                            if ($this->PropertyFeedback->_checkUserNotifications($this->request->data['PropertyFeedback']['property_user_id'], ConstPropertyUserStatus::Completed, 0)) { // (to_user_id, order_status,is_sender);
                                $this->PropertyFeedback->_sendAlertOnNewMessage($this->request->data['PropertyFeedback']['property_order_user_email'], $content, $message_id, 'Booking Alert Mail');
                            }
                        }
                    }
                    $data = array();
                    $data['PropertyUser']['id'] = $this->request->data['PropertyFeedback']['property_order_id'];
                    $data['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::Completed;
                    $this->PropertyFeedback->PropertyUser->save($data);
                }
                $this->redirect(array(
                    'controller' => 'property_users',
                    'action' => 'index',
                    'type' => 'mytours',
                    'status' => 'waiting_for_review',
                    'view' => 'list'
                ));
            } else {
                $this->Session->setFlash(__l('Feedback could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        if (!empty($this->request->params['named']) || !empty($this->request->data['PropertyFeedback']['property_order_id'])) {
            $propertyInfo = $this->PropertyFeedback->Property->PropertyUser->find('first', array(
                'conditions' => array(
                    'PropertyUser.id' => !empty($this->request->data['PropertyFeedback']['property_order_id']) ? $this->request->data['PropertyFeedback']['property_order_id'] : $this->request->params['named']['property_order_id'],
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::WaitingforReview,
                    'PropertyUser.user_id' => $this->Auth->user('id')
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
            if (empty($propertyInfo) || ($propertyInfo['PropertyUser']['user_id'] != $this->Auth->user('id'))) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $message['property_id'] = $propertyInfo['PropertyUser']['property_id'];
            $message['property_order_id'] = $propertyInfo['PropertyUser']['id'];
            $message['property_user_user_id'] = $propertyInfo['PropertyUser']['owner_user_id'];
            $message['property_user_status_id'] = $propertyInfo['PropertyUser']['property_user_status_id'];
            $message['property_seller_username'] = $propertyInfo['Property']['User']['username'];
            $message['property_user_id'] = $propertyInfo['PropertyUser']['id'];
            $message['property_seller_email'] = $propertyInfo['Property']['User']['email'];
            $message['property_username'] = $propertyInfo['Property']['User']['username'];
            $this->set('message', $message);
            $this->set('propertyInfo', $propertyInfo);
        }
        if (empty($this->request->data['PropertyFeedback'])) {
            $this->request->data['PropertyFeedback']['is_satisfied'] = '1';
        }
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Feedback To Host');
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
            $property = $this->PropertyFeedback->Property->find('first', array(
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
            $user = $this->{$this->modelClass}->User->find('first', array(
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
            $this->request->data['PropertyFeedback']['q'] = $this->request->params['named']['q'];
			$conditions['AND']['OR'][]['Property.title LIKE'] = '%' . $this->request->params['named']['q'] . '%';
			$conditions['AND']['OR'][]['PropertyFeedback.feedback LIKE'] = '%' . $this->request->params['named']['q'] . '%';
			$conditions['AND']['OR'][]['PropertyFeedback.admin_comments LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->set('page_title', $this->pageTitle);
        $this->PropertyFeedback->recursive = 2;
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
                'PropertyFeedback.id' => 'desc'
            )
        );
        $moreActions = $this->PropertyFeedback->moreActions;
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
            if ($this->PropertyFeedback->save($this->request->data)) {
                $this->Session->setFlash(__l('Feedback has been updated.') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('Feedback could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->PropertyFeedback->read(null, $id);
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
        if ($this->PropertyFeedback->delete($id)) {
            $this->Session->setFlash(__l('Feedback deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>
