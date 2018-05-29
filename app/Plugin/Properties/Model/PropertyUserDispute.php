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
class PropertyUserDispute extends AppModel
{
    public $name = 'PropertyUserDispute';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Property' => array(
            'className' => 'Properties.Property',
            'foreignKey' => 'property_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'PropertyUser' => array(
            'className' => 'Properties.PropertyUser',
            'foreignKey' => 'property_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'DisputeType' => array(
            'className' => 'Properties.DisputeType',
            'foreignKey' => 'dispute_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'DisputeStatus' => array(
            'className' => 'Properties.DisputeStatus',
            'foreignKey' => 'dispute_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'DisputeClosedType' => array(
            'className' => 'Properties.DisputeClosedType',
            'foreignKey' => 'dispute_closed_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    public $hasMany = array(
        'Message' => array(
            'className' => 'Properties.Message',
            'foreignKey' => 'property_user_dispute_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->isFilterOptions = array(
            ConstDisputeStatus::Open => __l('Open') ,
            ConstDisputeStatus::UnderDiscussion => __l('UnderDiscussion') ,
            ConstDisputeStatus::WaitingForAdministratorDecision => __l('WaitingForAdministratorDecision') ,
            ConstDisputeStatus::Closed => __l('Closed') ,
        );
        $this->validate = array(
            'dispute_type_id' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'reason' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
        );
    }
    function _resolveByRefund($dispute)
    {
		App::import('Model', 'Payment');
		$this->Payment = new Payment();
		$refund_percentage = Configure::read('dispute.refund_amount_during_dispute_cancellation')/100;
		$host_transaction_amount = ($dispute['PropertyUser']['price']-$dispute['PropertyUser']['host_service_amount']) * $refund_percentage;
		$traveler_transaction_amount = $dispute['PropertyUser']['price']*$refund_percentage;
		$update_buyer_balance = $dispute['PropertyUser']['User']['available_wallet_amount'] + $dispute['PropertyUser']['price']*$refund_percentage;
		$_data['PropertyUser']['id'] = $dispute['PropertyUser']['id'];
		if ($dispute['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived) {
			$_data['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::PaymentCleared;
		}
		$_data['PropertyUser']['is_payment_cleared'] = 1;
		$this->PropertyUser->save($_data, false);
		$this->PropertyUser->User->updateAll(array(
			'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
		) , array(
			'User.id' => $dispute['PropertyUser']['user_id']
		));
		$this->User->Transaction->log($dispute['PropertyUser']['id'], 'Properties.PropertyUser', $dispute['PropertyUser']['payment_gateway_id'], ConstTransactionTypes::RefundForPropertySpecificationDispute, $traveler_transaction_amount);
		$this->User->Transaction->log($dispute['PropertyUser']['id'], 'Properties.PropertyUser', $dispute['PropertyUser']['payment_gateway_id'], ConstTransactionTypes::HostAmountCleared, $host_transaction_amount);
    }
    function _resolveByDeposit($dispute)
    {
        App::import('Model', 'Payment');
        $this->Payment = new Payment();	
		$update_seller_balance = $dispute['Property']['User']['available_wallet_amount']+$dispute['PropertyUser']['security_deposit'];
		if ($dispute['PropertyUser']['security_deposit_status'] == ConstSecurityDepositStatus::Blocked) {
			$PropertyUser['PropertyUser']['id'] = $dispute['PropertyUser']['id'];
			$PropertyUser['PropertyUser']['security_deposit_status'] = ConstSecurityDepositStatus::SentToHost;
			$this->PropertyUser->save($PropertyUser);
		}
		$this->PropertyUser->User->updateAll(array(
			'User.available_wallet_amount' => "'" . $update_seller_balance . "'"
		) , array(
			'User.id' => $dispute['Property']['user_id']
		));
		$this->User->Transaction->log($dispute['PropertyUser']['id'], 'Properties.PropertyUser', $dispute['PropertyUser']['payment_gateway_id'], ConstTransactionTypes::SecurityDepositSentToHost, $dispute['PropertyUser']['security_deposit']);
    }
    function _resolveByDepositRefund($dispute)
    {
		$update_traveler_balance = $dispute['PropertyUser']['User']['available_wallet_amount']+$dispute['PropertyUser']['security_deposit'];
		if ($dispute['PropertyUser']['security_deposit_status'] == ConstSecurityDepositStatus::Blocked) {
			$PropertyUser['PropertyUser']['id'] = $dispute['PropertyUser']['id'];
			$PropertyUser['PropertyUser']['security_deposit_status'] = ConstSecurityDepositStatus::RefundedToTraveler;
			$this->PropertyUser->save($PropertyUser);
		}
		$this->PropertyUser->User->updateAll(array(
			'User.available_wallet_amount' => "'" . $update_traveler_balance . "'"
		) , array(
			'User.id' => $dispute['PropertyUser']['user_id']
		));
		$this->User->Transaction->log($dispute['PropertyUser']['id'], 'Properties.PropertyUser', $dispute['PropertyUser']['payment_gateway_id'], ConstTransactionTypes::SecurityDepositRefundedToTraveler, $dispute['PropertyUser']['security_deposit']);
    }
    function _resolveByReview($dispute)
    {
        $feedback = $this->Property->PropertyFeedback->_getFeedback($dispute['PropertyUser']['id']);
        $update_feedback_message = __l("Based on Dispute ID#") . $dispute['PropertyUserDispute']['id'] . ' ' . __l("Feedback has been changed by site administrator") . '. ';
        $update_feedback_message.= "<p>" . __l("Original Feedback:") . ' ' . $feedback['PropertyFeedback']['feedback'] . "</p>";
        $propertyFeedback['PropertyFeedback']['id'] = $feedback['PropertyFeedback']['id'];
        $propertyFeedback['PropertyFeedback']['feedback'] = $update_feedback_message;
        $propertyFeedback['PropertyFeedback']['is_satisfied'] = 1;
        $this->Property->PropertyFeedback->save($propertyFeedback, false);
    }
    // @todo "Auto review" _resolveByTravlerReview function
    function _closeDispute($close_type, $dispute)
    {
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        // SENDING CLOSE DISPUTE MAIL //
        $template = $this->EmailTemplate->selectTemplate("Dispute Resolved Notification");
        $emailFindReplace = array(
            '##ORDER_ID##' => $dispute['PropertyUserDispute']['property_user_id'],
            '##DISPUTE_ID##' => $dispute['PropertyUserDispute']['id'],
            '##DISPUTER##' => $dispute['User']['username'],
            '##DISPUTER_USER_TYPE##' => (!empty($dispute['PropertyUserDispute']['is_traveler']) ? $dispute['User']['username'] : $dispute['Property']['User']['username']) ,
            '##REASON##' => $dispute['PropertyUserDispute']['reason'],
            '##FROM_EMAIL##' => ($template['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $template['from'],
            '##CONTACT_URL##' => Router::url(array(
                'controller' => 'contacts',
                'action' => 'add'
            ) , true) ,
            '##SITE_LOGO##' => Router::url(array(
                'controller' => 'img',
                'action' => 'logo.png',
                'admin' => false
            ) , true) ,
            '##SITE_URL##' => Router::url('/', true) ,
			'##SITE_NAME##' => Configure::read('site.name') ,
        );
        if (!empty($close_type['close_type_8'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Host") . ' (' . $dispute['Property']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('8');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_role_id = 0;
        } elseif (!empty($close_type['close_type_4'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Host") . ' (' . $dispute['Property']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('4');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_role_id = 0;
        } elseif (!empty($close_type['close_type_1'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Traveler") . ' (' . $dispute['PropertyUser']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('1');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_role_id = 1;
        } elseif (!empty($close_type['close_type_7'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Traveler") . ' (' . $dispute['PropertyUser']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('7');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_role_id = 1;
        } elseif (!empty($close_type['close_type_6'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Host") . ' (' . $dispute['Property']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('6');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_role_id = 0;
        } elseif (!empty($close_type['close_type_10'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Traveler") . ' (' . $dispute['PropertyUser']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('10');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_role_id = 1;
        } elseif (!empty($close_type['close_type_11']) || !empty($close_type['close_type_12'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Host") . ' (' . $dispute['Property']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('11');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_role_id = 0;
        } elseif (!empty($close_type['close_type_9'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Host") . ' (' . $dispute['Property']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('9');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_role_id = 0;
        } elseif (!empty($close_type['close_type_2'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Host") . ' (' . $dispute['Property']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('2');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_role_id = 0;
        } elseif (!empty($close_type['close_type_3'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Traveler") . ' (' . $dispute['PropertyUser']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('3');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_role_id = 1;
        } elseif (!empty($close_type['close_type_5'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Traveler") . ' (' . $dispute['PropertyUser']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('5');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_role_id = 1;
        }
        if (Configure::read('messages.is_send_internal_message')) {
            $users = array(
                $dispute['Property']['User']['id'] => $dispute['Property']['User']['username'],
                $dispute['PropertyUser']['User']['id'] => $dispute['PropertyUser']['User']['username']
            );
            $k = 0;
            foreach($users as $key => $value) {
                $username = $value;
                $user = $key;
                $emailFindReplace['##USERNAME##'] = $username;
                $message = strtr($template['email_text_content'], $emailFindReplace);
                $subject = strtr($template['subject'], $emailFindReplace);
                $disp_stat = ($k == 0) ? ConstPropertyUserStatus::DisputeClosed : ConstPropertyUserStatus::DisputeClosedTemp;
                $message_id = $this->Message->sendNotifications($user, $subject, $message, $dispute['PropertyUserDispute']['property_user_id'], '0', $dispute['PropertyUserDispute']['property_id'], $disp_stat, $dispute['PropertyUserDispute']['id']);
                if (Configure::read('messages.is_send_email_on_new_message')) {
                    $sender_emails = array(
                        $dispute['Property']['User']['email'],
                        $dispute['User']['email']
                    );
                    $content['subject'] = $subject;
                    $content['message'] = $subject;
                    if ($this->_checkUserNotifications($sender_emails[$k], ConstPropertyUserStatus::DisputeOpened, 0)) {
                        $this->_sendAlertOnNewMessage($sender_emails[$k], $content, $message_id, 'Booking Alert Mail');
                    }
                    $k++;
                }
            }
        }
        // END OF SENDING MAIL //
        // UN-HOLDING ORDER PROCESS //
        $this->PropertyUser->updateAll(array(
            'PropertyUser.is_under_dispute' => 0
        ) , array(
            'PropertyUser.id' => $dispute['PropertyUserDispute']['property_user_id']
        ));
        // END OF HOLD //
        // UPDATING DISPUTE STATUS ORDER PROCESS //
        $this->updateAll(array(
            'PropertyUserDispute.dispute_status_id' => ConstDisputeStatus::Closed,
            'PropertyUserDispute.resolved_date' => "'" . date('Y-m-d H:i:s') . "'",
            'PropertyUserDispute.is_favor_traveler' => $favour_role_id,
            'PropertyUserDispute.dispute_closed_type_id' => $reason_for_closing['DisputeClosedType']['id'],
        ) , array(
            'PropertyUserDispute.id' => $dispute['PropertyUserDispute']['id']
        ));
        // END OF STATUS UPDATE //

    }
}
?>