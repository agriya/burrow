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
class PropertyUserDisputesController extends AppController
{
    public $name = 'PropertyUserDisputes';
    public $components = array(
        'Email'
    );
	public $permanentCacheAction = array(
		'user' => array(
			'add',
		) ,
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'PropertyUserDispute.close_type_1',
            'PropertyUserDispute.close_type_2',
            'PropertyUserDispute.close_type_3',
            'PropertyUserDispute.close_type_4',
            'PropertyUserDispute.close_type_5',
            'PropertyUserDispute.close_type_6',
            'PropertyUserDispute.close_type_7',
            'PropertyUserDispute.close_type_8',
            'PropertyUserDispute.close_type_9',
            'PropertyUserDispute.close_type_10',
            'PropertyUserDispute.close_type_11',
            'PropertyUserDispute.close_type_12',
        );
        parent::beforeFilter();
    }
    public function add()
    {
        $conditions = array();
        $conditions['PropertyUser.id'] = !empty($this->request->params['named']['order_id']) ? $this->request->params['named']['order_id'] : $this->request->data['PropertyUserDispute']['property_user_id'];
        if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
            $conditions['OR'] = array(
                'PropertyUser.user_id' => $this->Auth->user('id') ,
                'PropertyUser.owner_user_id' => $this->Auth->user('id') ,
            );
        }
        if (!empty($this->request->params['named']['order_id']) || !empty($this->request->data['PropertyUserDispute']['property_user_id'])) {
            $order = $this->PropertyUserDispute->PropertyUser->find('first', array(
                'conditions' => $conditions,
                'contain' => array(
                    'Property' => array(
                        'fields' => array(
                            'Property.id',
                            'Property.slug',
                            'Property.user_id',
                            'Property.title',
                            'Property.security_deposit',
                        ) ,
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.username',
                                'User.email'
                            )
                        ) ,
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email'
                        )
                    ) ,
                    // @todo "Auto review"
                    'PropertyFeedback' => array(
                        'fields' => array(
                            'PropertyFeedback.id',
                            'PropertyFeedback.is_satisfied',
                        ) ,
                    ) ,
                ) ,
                'recursive' => 2
            ));
        }
        if (empty($order)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle = __l('Add Booking Dispute');
        if (!empty($this->request->data)) {
            $this->PropertyUserDispute->create();
            if ($this->request->data['PropertyUserDispute']['dispute_type_id'] == 4) {
                $this->request->data['PropertyUserDispute']['is_security_deposit_dispute_raised'] = 1;
            }
            $this->request->data['PropertyUserDispute']['dispute_status_id'] = ConstDisputeStatus::Open;
            $this->request->data['PropertyUserDispute']['dispute_converstation_count'] = 1;
            $this->request->data['PropertyUserDispute']['last_replied_user_id'] = $this->Auth->user('id');
            $this->request->data['PropertyUserDispute']['last_replied_date'] = date('Y-m-d h:i:s');
            if ($this->PropertyUserDispute->save($this->request->data)) {
                $property_user_dispute_id = $this->PropertyUserDispute->getLastInsertId();
                $order_id = $this->request->data['PropertyUserDispute']['property_user_id'];
                // SENDING MAIL AND UPDATING CONVERSTATION //
				App::import('Model', 'EmailTemplate');
				$this->EmailTemplate = new EmailTemplate();
                $template = $this->EmailTemplate->selectTemplate("Dispute Open Notification");
                $emailFindReplace = array(
                    '##PROPERTY_NAME##' => "<a href=" . Router::url(array(
                        'controller' => 'properties',
                        'action' => 'view',
                        $order['Property']['slug'],
                        'admin' => false,
                    ) , true) . ">" . $order['Property']['title'] . "</a>",
                    '##ORDERNO##' => $order_id,
                    '##MESSAGE##' => $this->request->data['PropertyUserDispute']['reason'],
                    '##REPLY_DAYS##' => Configure::read('dispute.days_left_for_disputed_user_to_reply') . ' ' . __l('days') ,
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
                    '##SITE_URL##' => Router::url('/', true) ,
					'##SITE_NAME##' => Configure::read('site.name') ,
                );
                if (isset($this->request->data['PropertyUserDispute']['is_traveler']) && $this->request->data['PropertyUserDispute']['is_traveler'] == 0) {
                    $emailFindReplace['##USERNAME##'] = $order['User']['username'];
                    $emailFindReplace['##OTHER_USER##'] = $order['Property']['User']['username'];
                    $emailFindReplace['##USER_TYPE##'] = __l("Host") . ' (' . $order['Property']['User']['username'] . ')';
                    $emailFindReplace['##REPLY_LINK##'] = "<a href=" . Router::url(array(
                        'controller' => 'messages',
                        'action' => 'activities',
                        'order_id' => $order_id,
                        'admin' => false,
                    ) , true) . ">" . __l("Activities") . "</a>";
                    $to = $order['User']['id'];
                    $sender_email = $order['User']['email'];
                    $type = 'myworks';
                } elseif (isset($this->request->data['PropertyUserDispute']['is_traveler']) && $this->request->data['PropertyUserDispute']['is_traveler'] == 1) {
                    $emailFindReplace['##OTHER_USER##'] = $order['User']['username'];
                    $emailFindReplace['##USERNAME##'] = $order['Property']['User']['username'];
                    $emailFindReplace['##USER_TYPE##'] = __l("Traveler") . ' (' . $order['User']['username'] . ')';
                    $emailFindReplace['##REPLY_LINK##'] = "<a href=" . Router::url(array(
                        'controller' => 'messages',
                        'action' => 'activities',
                        'order_id' => $order_id,
                        'admin' => false,
                    ) , true) . ">" . __l("Activities") . "</a>";
                    $to = $order['Property']['User']['id'];
                    $sender_email = $order['Property']['User']['email'];
                    $type = 'mytours';
                }
                $get_order_status = $this->PropertyUserDispute->PropertyUser->find('first', array(
                    'conditions' => array(
                        'PropertyUser.id' => $order_id
                    ) ,
                    'recursive' => -1
                ));
                $message = strtr($template['email_text_content'], $emailFindReplace);
                $subject = strtr($template['subject'], $emailFindReplace);
                if (Configure::read('messages.is_send_internal_message')) {
                    $message_id = $this->PropertyUserDispute->Message->sendNotifications($to, $subject, $message, $order_id, '0', $order['Property']['id'], ConstPropertyUserStatus::DisputeOpened, $property_user_dispute_id);
                    if (Configure::read('messages.is_send_email_on_new_message')) {
                        $content['subject'] = $subject;
                        $content['message'] = $subject;
                        if (!empty($sender_email)) {
                            if ($this->PropertyUserDispute->_checkUserNotifications($to, ConstPropertyUserStatus::DisputeOpened, 0)) {
                                $this->PropertyUserDispute->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Booking Alert Mail');
                            }
                        }
                    }
                }
                // END OF SEND MAIL //
                // HOLDING ORDER PROCESS //
                $this->PropertyUserDispute->PropertyUser->updateAll(array(
                    'PropertyUser.is_under_dispute' => 1
                ) , array(
                    'PropertyUser.id' => $order_id
                ));
                // END OF HOLD //
                $this->Session->setFlash(__l('Dispute Opened') , 'default', null, 'success');
                if ($this->RequestHandler->isAjax()) {
                    $ajax_url = Router::url(array(
                        'controller' => 'messages',
                        'action' => 'activities',
                        'order_id' => $order_id,
                    ) , true);
                    $success_msg = 'redirect*' . $ajax_url;
                    echo $success_msg;
                    exit;
                }
            } else {
                $this->Session->setFlash(__l('Enter all required information.') , 'default', null, 'error');
            }
        } else {
            $this->request->data['PropertyUserDispute']['user_id'] = $this->Auth->user('id');
            $this->request->data['PropertyUserDispute']['property_id'] = $order['PropertyUser']['property_id'];
            $this->request->data['PropertyUserDispute']['property_user_id'] = $order['PropertyUser']['id'];
            $this->request->data['PropertyUserDispute']['is_traveler'] = (($order['PropertyUser']['owner_user_id'] == $this->Auth->user('id')) ? 0 : 1);
        }
        $allDisputeTypes = $this->PropertyUserDispute->DisputeType->find('list', array(
            'conditions' => array(
                'DisputeType.is_traveler' => (($order['PropertyUser']['owner_user_id'] == $this->Auth->user('id')) ? 0 : 1)
            ),
			'recursive' => -1,
        ));
        $disputeTypes = array();
        // traveler related disputes
        if ($order['PropertyUser']['user_id'] == $this->Auth->user('id')) {
            if (!empty($order['PropertyUser']['is_auto_checkin']) && empty($order['PropertyUser']['is_payment_cleared'])) {
                // property doesn't match host requirements
                $disputeTypes[1] = $allDisputeTypes[1];
            }
        }
        // host related disputes
        if ($order['PropertyUser']['owner_user_id'] == $this->Auth->user('id')) {
            if (!empty($order['PropertyFeedback']['id']) && empty($order['PropertyFeedback']['is_satisfied'])) {
                // traveler given poor feedback
                $disputeTypes[3] = $allDisputeTypes[3];
            }
            if (Configure::read('property.is_enable_security_deposit') && !empty($order['PropertyUser']['is_auto_checkout']) && $order['PropertyUser']['security_deposit_status'] == ConstSecurityDepositStatus::Blocked) {
                // claim security deposit
                $disputeTypes[4] = $allDisputeTypes[4];
            }
        }
        if (!Configure::read('property.is_enable_security_deposit') || $order['Property']['security_deposit'] == '0.00') {
            // unset security deposit message when disabled
            unset($allDisputeTypes[4]);
        }
        // @todo "Auto review"
        $this->set('disputeTypes', $disputeTypes);
        $this->set('AlldisputeTypes', $allDisputeTypes);
        $this->set('is_under_dispute', $order['PropertyUser']['is_under_dispute']);
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'filter_id',
            'dispute_type_id',
            'q'
        ));
        $this->pageTitle = __l('Booking Disputes');
        $conditions = array();
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstDisputeStatus::Open) {
                $this->pageTitle.= __l(' - Open');
            }
            if ($this->request->params['named']['filter_id'] == ConstDisputeStatus::UnderDiscussion) {
                $this->pageTitle.= __l(' - Under Discussion');
            }
            if ($this->request->params['named']['filter_id'] == ConstDisputeStatus::WaitingForAdministratorDecision) {
                $this->pageTitle.= __l(' - Waiting For Administrator Decision');
            }
            if ($this->request->params['named']['filter_id'] == ConstDisputeStatus::Closed) {
                $this->pageTitle.= __l(' - Closed');
            }
            $conditions['PropertyUserDispute.dispute_status_id'] = $this->request->params['named']['filter_id'];
            $this->request->data['PropertyUserDispute']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (isset($this->request->params['named']['dispute_type_id']) && !empty($this->request->params['named']['dispute_type_id'])) {
            $this->request->data['PropertyUserDispute']['dispute_type_id'] = $this->request->params['named']['dispute_type_id'];
            $conditions['PropertyUserDispute.dispute_type_id'] = $this->request->params['named']['dispute_type_id'];
        }
        if (isset($this->request->params['named']['q']) && !empty($this->request->params['named']['q'])) {
            $this->pageTitle.= sprintf(__l(' - Search') . ' - %s', $this->request->params['named']['q']);
			$conditions['AND']['OR'][]['Property.title LIKE'] = '%' . $this->request->params['named']['q'] . '%';
			$conditions['AND']['OR'][]['PropertyUserDispute.reason LIKE'] = '%' . $this->request->params['named']['q'] . '%';
			$conditions['AND']['OR'][]['User.username LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->request->data['PropertyUserDispute']['q'] = $this->request->params['named']['q'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['PropertyUserDispute.created ='] = date('Y-m-d', strtotime('now'));
            $this->pageTitle.= __l(' -  today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['PropertyUserDispute.created >='] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' -  in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['PropertyUserDispute.created >='] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' -  in this month');
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'Property' => array(
                    'fields' => array(
                        'Property.title',
                        'Property.slug'
                    )
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.username',
                    )
                ) ,
                'PropertyUser' => array(
                    'fields' => array(
                        'PropertyUser.id',
                    ) ,
                    'PropertyUserStatus' => array(
                        'fields' => array(
                            'PropertyUserStatus.name',
                        )
                    )
                ) ,
                'DisputeType' => array(
                    'fields' => array(
                        'DisputeType.name',
                    )
                ) ,
                'DisputeStatus' => array(
                    'fields' => array(
                        'DisputeStatus.name',
                    )
                ) ,
            ) ,
            'recursive' => 1,
            'order' => array(
                'PropertyUserDispute.id' => 'desc'
            )
        );
        if (isset($this->request->data['PropertyUserDispute']['q']) && !empty($this->request->data['PropertyUserDispute']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->data['PropertyUserDispute']['q']
            ));
        }
        $this->set('propertyUserDisputes', $this->paginate());
        $filters = $this->PropertyUserDispute->DisputeStatus->find('list');
        $disputeTypes = $this->PropertyUserDispute->DisputeType->find('list', array(
            'conditions' => array(
                'DisputeType.is_Active = ' => 1
            ),
			'recursive' => -1,
        ));
        $status_count = array();
        $i = 0;
        $total_count = 0;
        foreach($filters as $id => $val) {
            $status_count[$i]['id'] = $id;
            $status_count[$i]['dispaly'] = $val;
            $status_count[$i]['count'] = $this->PropertyUserDispute->find('count', array(
                'conditions' => array(
                    'PropertyUserDispute.dispute_status_id = ' => $id,
                ) ,
                'recursive' => -1
            ));
            $total_count+= $status_count[$i]['count'];
            $i++;
        }
        $status_count[$i]['id'] = '';
        $status_count[$i]['dispaly'] = 'Total';
        $status_count[$i]['count'] = $total_count;
        $this->set(compact('filters', 'disputeTypes'));
        $this->set('status_count', $status_count);
    }
    public function admin_resolve()
    {
        $this->setAction('resolve');
    }
    public function resolve()
    {
        $conditions = array();
        $conditions['PropertyUserDispute.property_user_id'] = !empty($this->request->params['named']['order_id']) ? $this->request->params['named']['order_id'] : $this->request->data['PropertyUserDispute']['property_user_id'];
        $conditions['PropertyUserDispute.dispute_status_id !='] = ConstDisputeStatus::Closed;
        if (!empty($this->request->params['named']['order_id']) || !empty($this->request->data['PropertyUserDispute']['property_user_id'])) {
            $dispute = $this->PropertyUserDispute->find('first', array(
                'conditions' => $conditions,
                'contain' => array(
                    'DisputeStatus',
                    'DisputeType',
                    'Property' => array(
                        'fields' => array(
                            'Property.id',
                            'Property.slug',
                            'Property.user_id',
                            'Property.title',
                        ) ,
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.username',
                                'User.email',
                                'User.blocked_amount',
                                'User.available_wallet_amount',
                            )
                        ) ,
                    ) ,
                    'PropertyUser' => array(
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.username',
                                'User.email',
                                'User.available_wallet_amount',
                            )
                        ) ,
                        'Property'
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email'
                        )
                    ) ,
                ) ,
                'recursive' => 2
            ));
        }
        if (empty($dispute)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['PropertyUserDispute']['close_type_1']) || !empty($this->request->data['PropertyUserDispute']['close_type_7'])) {
                $this->PropertyUserDispute->_resolveByRefund($dispute);
            } elseif (!empty($this->request->data['PropertyUserDispute']['close_type_6']) || !empty($this->request->data['PropertyUserDispute']['close_type_9'])) {
                $this->PropertyUserDispute->_resolveByReview($dispute);
            } elseif (!empty($this->request->data['PropertyUserDispute']['close_type_11']) || !empty($this->request->data['PropertyUserDispute']['close_type_12'])) {
                $this->PropertyUserDispute->_resolveByDeposit($dispute);
            } elseif (!empty($this->request->data['PropertyUserDispute']['close_type_10'])) {
                $this->PropertyUserDispute->_resolveByDepositRefund($dispute);
            }
            // @todo "Auto review"
            // Closing Dispute //
            $this->PropertyUserDispute->_closeDispute($this->request->data['PropertyUserDispute'], $dispute);
            // Redirecting //
            $this->Session->setFlash(__l('Dispute resolved successfully') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'messages',
                'action' => 'activities',
                'order_id' => $dispute['PropertyUserDispute']['property_user_id'],
                'type' => 'admin_order_view',
                'admin' => true
            ));
        }
        $dispute_close_types = $this->PropertyUserDispute->DisputeClosedType->find('all', array(
            'conditions' => array(
                'DisputeClosedType.dispute_type_id' => $dispute['PropertyUserDispute']['dispute_type_id']
            ) ,
            'recursive' => -1
        ));
        $this->set('dispute_close_types', $dispute_close_types);
        $this->set('dispute', $dispute);
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->PropertyUserDispute->delete($id)) {
            $this->Session->setFlash(__l('Booking Dispute deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>