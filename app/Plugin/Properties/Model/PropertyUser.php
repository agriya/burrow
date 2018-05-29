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
class PropertyUser extends AppModel
{
    public $name = 'PropertyUser';
    public $actsAs = array(
        'Aggregatable'
    );
    var $aggregatingFields = array(
        'message_count' => array(
            'mode' => 'real',
            'key' => 'property_user_id',
            'foreignKey' => 'property_user_id',
            'model' => 'Properties.Message',
            'function' => 'COUNT(Message.property_user_id)',
        )
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'OwnerUser' => array(
            'className' => 'User',
            'foreignKey' => 'owner_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'Property' => array(
            'className' => 'Properties.Property',
            'foreignKey' => 'property_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'PaymentGateway' => array(
            'className' => 'PaymentGateway',
            'foreignKey' => 'payment_gateway_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'PropertyUserStatus' => array(
            'className' => 'Properties.PropertyUserStatus',
            'foreignKey' => 'property_user_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    public $hasMany = array(
        'PropertyFeedback' => array(
            'className' => 'Properties.PropertyFeedback',
            'foreignKey' => 'property_user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'Message' => array(
            'className' => 'Properties.Message',
            'foreignKey' => 'message_content_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
    );
    public $hasOne = array(
        'PropertyFeedback' => array(
            'className' => 'Properties.PropertyFeedback',
            'foreignKey' => 'property_user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociatedUsers = array(
            'owner_user_id',
            'user_id',
        );
        $this->_permanentCacheAssociations = array(
            'User',
            'Property',
            'Chart',
        );
        $this->validate = array(
            'property_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'checkin' => array(
                'rule3' => array(
                    'rule' => '_isValidCheckinDate',
                    'message' => __l('Oops, seems you given wrong date or greater than checkout date, please check it!') ,
                    'allowEmpty' => false
                ) ,
                'rule2' => array(
                    'rule' => '_isCheckinDateAvailable',
                    'message' => __l('Selected date not available, Please select some other date or check calendar!') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'checkout' => array(
                'rule3' => array(
                    'rule' => '_isValidCheckoutDate',
                    'message' => __l('Oops, seems you given wrong date or less than checkin date, please check it!') ,
                    'allowEmpty' => false
                ) ,
                'rule2' => array(
                    'rule' => '_isCheckoutDateAvailable',
                    'message' => __l('Selected date not available, Please select some other date or check calendar!') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'checkinout' => array(
                'rule1' => array(
                    'rule' => '_isCheckInOutValid',
                    'message' => __l('Invalid Selection') ,
                    'allowEmpty' => false
                ) ,
            ) ,
            'guests' => array(
                'rule1' => array(
                    'rule' => '_isCheckGuest',
                    'message' => __l('Your selection is exceeded the allowed guest limit') ,
                    'allowEmpty' => false
                ) ,
            )
        );
        $conditions = array();
        $conditions['Message.is_sender'] = 0;
        $conditions['NOT']['Message.property_user_status_id'] = array(
            ConstPropertyUserStatus::SenderNotification,
            ConstPropertyUserStatus::WorkDelivered,
            ConstPropertyUserStatus::WorkReviewed,
            ConstPropertyUserStatus::RequestNegotiation,
            ConstPropertyUserStatus::SecurityDepositRefund
        );
        $this->aggregatingFields['message_count']['conditions'] = $conditions;
        $this->isFilterOptions = array(
            ConstPropertyUserStatus::PaymentPending => __l('Payment Pending') ,
            ConstPropertyUserStatus::WaitingforAcceptance => __l('Waiting for acceptance') ,
            ConstPropertyUserStatus::Confirmed => __l('Confirmed') ,
            ConstPropertyUserStatus::Arrived => __l('Arrived') ,
            ConstPropertyUserStatus::WaitingforReview => __l('Waiting for traveler review') ,
            ConstPropertyUserStatus::Completed => __l('Completed') ,
            ConstPropertyUserStatus::Canceled => __l('Canceled by traveler') ,
            ConstPropertyUserStatus::Rejected => __l('Rejected') ,
            ConstPropertyUserStatus::Expired => __l('Expired') ,
            ConstPropertyUserStatus::CanceledByAdmin => __l('Canceled by admin') ,
        );
        $this->moreActions = array(
            ConstMoreAction::WaitingforAcceptance => __l('Waiting for acceptance') ,
            ConstMoreAction::InProgress => __l('In progress') ,
            ConstMoreAction::Completed => __l('Completed') ,
            ConstMoreAction::Canceled => __l('Canceled') ,
            ConstMoreAction::Rejected => __l('Rejected') ,
            ConstMoreAction::PaymentCleared => __l('Payment Cleared') ,
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
    function _isCheckInOutValid()
    {
        $propertyuser = $this->find('first', array(
            'conditions' => array(
                'PropertyUser.id' => $this->data[$this->name]['order_id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($propertyuser)) {
            $checkinout = $this->data[$this->name]['checkinout']['year'] . '-' . $this->data[$this->name]['checkinout']['month'] . '-' . $this->data[$this->name]['checkinout']['day'];
            if ($propertyuser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed || $propertyuser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived) {
                if ($checkinout >= $propertyuser['PropertyUser']['checkin'] && $checkinout <= $propertyuser['PropertyUser']['checkout']) {
                    return true;
                }
            }
            if (empty($propertyuser['PropertyUser']['actual_checkin_date'])) {
                if ($propertyuser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived || $propertyuser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforReview || $propertyuser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentCleared) {
                    if ($checkinout >= $propertyuser['PropertyUser']['checkout']) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
    function _isCheckGuest()
    {
        $property = $this->Property->find('first', array(
            'conditions' => array(
                'Property.id' => $this->data[$this->name]['property_id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($property)) {
            if ($property['Property']['accommodates'] == 0) {
                return true;
            } else if ($this->data[$this->name]['guests'] > $property['Property']['accommodates']) {
                return false;
            } else {
                return true;
            }
        }
        return false;
    }
    function _isCheckinDateAvailable()
    {
        $return = true;
        $propertyusers = $this->find('all', array(
            'conditions' => array(
                'NOT' => array(
                    'PropertyUser.property_user_status_id ' => array(
                        ConstPropertyUserStatus::WaitingforAcceptance,
                        ConstPropertyUserStatus::Rejected,
                        ConstPropertyUserStatus::Canceled,
                        ConstPropertyUserStatus::CanceledByAdmin,
                        ConstPropertyUserStatus::PaymentPending,
                        ConstPropertyUserStatus::Expired,
                        0,
                    ) ,
                ) ,
                'PropertyUser.property_id' => $this->data[$this->name]['property_id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($propertyusers)) {
            foreach($propertyusers as $propertyuser) {
                if (strtotime($this->data[$this->name]['checkin']) >= strtotime($propertyuser['PropertyUser']['checkin']) && strtotime($this->data[$this->name]['checkin']) <= strtotime($propertyuser['PropertyUser']['checkout'])) {
                    $return = false;
                }
            }
        }
        return $return;
    }
    function _isCheckoutDateAvailable()
    {
        $return = true;
        $propertyusers = $this->find('all', array(
            'conditions' => array(
                'NOT' => array(
                    'PropertyUser.property_user_status_id ' => array(
                        ConstPropertyUserStatus::WaitingforAcceptance,
                        ConstPropertyUserStatus::Rejected,
                        ConstPropertyUserStatus::Canceled,
                        ConstPropertyUserStatus::CanceledByAdmin,
                        ConstPropertyUserStatus::PaymentPending,
                        ConstPropertyUserStatus::Expired,
                        0,
                    ) ,
                ) ,
                'PropertyUser.property_id' => $this->data[$this->name]['property_id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($propertyusers)) {
            foreach($propertyusers as $propertyuser) {
                if (strtotime($this->data[$this->name]['checkout']) >= strtotime($propertyuser['PropertyUser']['checkin']) && strtotime($this->data[$this->name]['checkout']) <= strtotime($propertyuser['PropertyUser']['checkout'])) {
                    $return = false;
                }
            }
        }
        return $return;
    }
    function _isValidCheckinDate()
    {
        if (strtotime($this->data[$this->name]['checkin']) >= strtotime(date('Y-m-d')) && strtotime($this->data[$this->name]['checkin']) <= strtotime($this->data[$this->name]['checkout'])) {
            return true;
        } else {
            return false;
        }
    }
    function _isValidCheckoutDate()
    {
        if (strtotime($this->data[$this->name]['checkout']) >= strtotime($this->data[$this->name]['checkin'])) {
            return true;
        } else {
            return false;
        }
    }
    // After save to update sales and purchase related information after every status gets saved.
    function afterSave($created)
    {
        /* Quick Fix */
        if (!empty($this->data['PropertyUser']['id'])) {
            $proprtyUser = $this->find('first', array(
                'conditions' => array(
                    'PropertyUser.id' => $this->data['PropertyUser']['id'],
                ) ,
                'fields' => array(
                    'PropertyUser.user_id',
                ) ,
                'recursive' => -1,
            ));
            $payment_pending_count = $this->find('count', array(
                'conditions' => array(
                    'PropertyUser.user_id' => $proprtyUser['PropertyUser']['user_id'],
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::PaymentPending,
                ) ,
                'recursive' => -1,
            ));
            $this->User->updateAll(array(
                'User.travel_payment_pending_count' => $payment_pending_count
            ) , array(
                'User.id' => $proprtyUser['PropertyUser']['user_id']
            ));
        }
        return true;
    }
    // common function to get property details //
    function get_property($property_user_id)
    {
        $property = $this->find('first', array(
            'conditions' => array(
                'PropertyUser.id' => $property_user_id
            ) ,
            'contain' => array(
                'Property' => array(
                    'fields' => array(
                        'Property.id',
                        'Property.user_id',
                    ) ,
                )
            ) ,
            'recursive' => 1
        ));
        return $property;
    }
    // common function to get property counts for various conditions passed //
    function property_count($conditions)
    {
        $property_user_count = $this->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        return $property_user_count;
    }
    function _getCalendarMontlyBooking($property_id, $month, $year)
    {
        $conditions = array();
        $conditions['PropertyUser.property_id'] = $property_id;
        // checkin must be within the given month n year //
        $conditions['PropertyUser.checkin <= '] = $year . '-' . $month . '-' . '31' . ' 00:00:00';
        $conditions['PropertyUser.checkout >= '] = $year . '-' . $month . '-' . '01' . ' 00:00:00';
        // must be active status //
        $conditions['PropertyUser.property_user_status_id'] = array(
            ConstPropertyUserStatus::Confirmed,
            ConstPropertyUserStatus::Arrived,
            ConstPropertyUserStatus::WaitingforReview,
            ConstPropertyUserStatus::PaymentCleared,
        );
        $property_users = $this->find('all', array(
            'conditions' => $conditions,
            'fields' => array(
                'PropertyUser.id',
                'PropertyUser.checkin',
                'PropertyUser.checkout',
                'PropertyUser.price',
            ) ,
            'order' => array(
                'PropertyUser.checkin' => 'ASC'
            ) ,
            'recursive' => -1
        ));
        return $property_users;
    }
    function _getCalendarWeekBooking($property_id, $checkin, $checkout)
    {
        $conditions = array();
        $conditions['PropertyUser.property_id'] = $property_id;
        // checkin must be within the given month n year //
        $conditions['PropertyUser.checkin <= '] = $checkout;
        $conditions['PropertyUser.checkin >= '] = $checkin;
        // must be active status //
        $conditions['PropertyUser.property_user_status_id'] = array(
            ConstPropertyUserStatus::Confirmed,
            ConstPropertyUserStatus::Arrived,
            ConstPropertyUserStatus::WaitingforReview,
            ConstPropertyUserStatus::PaymentCleared,
        );
        $property_users = $this->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        return $property_users;
    }
    public function getReceiverdata($foreign_id, $transaction_type, $payee_account)
    {
        $PropertyUser = $this->find('first', array(
            'conditions' => array(
                'PropertyUser.id' => $foreign_id
            ) ,
            'contain' => array(
                'User',
                'OwnerUser',
            ) ,
            'recursive' => 0,
        ));
        $return['receiverEmail'] = array(
            $payee_account
        );
        $amount = $PropertyUser['PropertyUser']['price']+$PropertyUser['PropertyUser']['traveler_service_amount']+$PropertyUser['PropertyUser']['security_deposit'];
        $service_amount = !empty($PropertyUser['PropertyUser']['host_service_amount']) ? $PropertyUser['PropertyUser']['host_service_amount'] : $PropertyUser['PropertyUser	']['traveler_service_amount'];
        $return['amount'] = array(
            $amount,
            $service_amount
        );
        $return['amount'] = array(
            $amount
        );
        $return['fees_payer'] = 'buyer';
        if (Configure::read('property.payment_gateway_fee_id') == 'Site') {
            $return['fees_payer'] = 'merchant';
        }
        $return['sudopay_gateway_id'] = $PropertyUser['PropertyUser']['sudopay_gateway_id'];
        $return['buyer_email'] = $PropertyUser['User']['email'];
        return $return;
    }
    public function updateStatus($order_id, $property_user_status_id, $payment_gateway_id = null, $data = null)
    {
        $propertyUser = $this->Property->PropertyUser->find('first', array(
            'conditions' => array(
                'PropertyUser.id' => $order_id
            ) ,
            'contain' => array(
                'Property' => array(
                    'User',
                    'CancellationPolicy',
                ) ,
                'User',
            ) ,
            'recursive' => 2
        ));
        if (empty($propertyUser)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->{'processStatus' . $property_user_status_id}($propertyUser, $payment_gateway_id, $data);
            return true;
        }
        // WaitingForAcceptance //
        function processStatus1($propertyUser, $payment_gateway_id, $data = null)
        {
            if (in_array($propertyUser['PropertyUser']['property_user_status_id'], array(
                ConstPropertyUserStatus::PaymentPending
            ))) {
                $this->User->Transaction->log($propertyUser['PropertyUser']['id'], 'Properties.PropertyUser', $propertyUser['PropertyUser']['payment_gateway_id'], ConstTransactionTypes::BookProperty);
                $_data['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::WaitingforAcceptance;
                $_data['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
                $this->save($_data, false);
                $this->_processStatusSendMail($propertyUser, 'New Booking Message To Host', ConstPropertyUserStatus::WaitingforAcceptance, true);
                $this->_processStatusSendMail($propertyUser, 'New Booking Message To Traveler', ConstPropertyUserStatus::WaitingforAcceptance, false);
            }
            return true;
        }
        // Confirmed //
        function processStatus2($propertyUser, $payment_gateway_id, $data = null)
        {
            if ($propertyUser['Property']['user_id'] != $_SESSION['Auth']['User']['id']) {
                throw new NotFoundException(__l('Invalid request'));
            }
            if ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance) {
                $return['error'] = 0;
                $is_update_in_wallet = 1;
                if ($propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) {
                    $sudopayGatewayDetails = $this->_getSudopayGatewayDetails($propertyUser['PropertyUser']['sudopay_gateway_id']);
                    if (!empty($sudopayGatewayDetails['SudopayPaymentGateway']['is_marketplace_supported'])) {
                        App::import('Model', 'Sudopay.Sudopay');
                        $this->Sudopay = new Sudopay();
                        $return = $this->Sudopay->processPreapprovalPayment($propertyUser['PropertyUser']['id']);
                        $is_update_in_wallet = 0;
                    }
                }
                if (empty($return['error'])) {
                    $_data['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
                    $_data['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::Confirmed;
                    $_data['PropertyUser']['accepted_date'] = date('Y-m-d H:i:s');
                    $this->save($_data, false);
                    $this->_processStatusSendMail($propertyUser, 'Accepted Booking Message To Host', ConstPropertyUserStatus::Confirmed, true);
                    $this->_processStatusSendMail($propertyUser, 'Accepted Booking Message To Traveler', ConstPropertyUserStatus::Confirmed, false);
                }
            }
        }
        // Rejected //
        function processStatus3($propertyUser, $payment_gateway_id, $data = null)
        {
            if ($propertyUser['Property']['user_id'] != $_SESSION['Auth']['User']['id']) {
                throw new NotFoundException(__l('Invalid request'));
            }
            if ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance) {
                $return['error'] = 0;
                $is_update_in_wallet = 1;
				 $_data['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];                /* Previously stsus changed due to quick ipn response, canceled also called through IPN */
                 $_data['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::Rejected;
                 $this->save($_data, false);
                if ($propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) {
                    $sudopayGatewayDetails = $this->_getSudopayGatewayDetails($propertyUser['PropertyUser']['sudopay_gateway_id']);
                    if (!empty($sudopayGatewayDetails['SudopayPaymentGateway']['is_marketplace_supported'])) {
                        App::import('Model', 'Sudopay.Sudopay');
                        $this->Sudopay = new Sudopay();
                        $return = $this->Sudopay->cancelPreapprovalPayment($propertyUser['PropertyUser']['id']);
                        $is_update_in_wallet = 0;
                    }
                }
                if (empty($return['error'])) {
                    if (!empty($is_update_in_wallet)) {
                        $refund_amount = $propertyUser['User']['available_wallet_amount']+$propertyUser['PropertyUser']['price']+$propertyUser['PropertyUser']['traveler_service_amount']+$propertyUser['PropertyUser']['security_deposit'];
                        $this->User->updateAll(array(
                            'User.available_wallet_amount' => $refund_amount
                        ) , array(
                            'User.id' => $propertyUser['PropertyUser']['user_id']
                        ));
                    }
                    $this->User->Transaction->log($propertyUser['PropertyUser']['id'], 'Properties.PropertyUser', $propertyUser['PropertyUser']['payment_gateway_id'], ConstTransactionTypes::RefundForRejectedBooking);
                    $this->_propertyStatusChangeMail($propertyUser, ConstPropertyUserStatus::WaitingforAcceptance, ConstPropertyUserStatus::Rejected);
                }else{
					$_data['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
                    $_data['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::WaitingforAcceptance;
                    $this->save($_data, false);
				}
            }
        }
        // Canceled //
        function processStatus4($propertyUser, $payment_gateway_id, $data = null)
        {
            $this->_cancelBooking($propertyUser, $payment_gateway_id, $data, false);
        }
        // Arrived //
        function processStatus5($propertyUser, $payment_gateway_id, $data = null)
        {
            if ((strtotime('now') -strtotime($propertyUser['PropertyUser']['checkin'])) >= 0) {
                $_data['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
                if ($propertyUser['PropertyUser']['property_user_status_id'] != ConstPropertyUserStatus::Arrived) {
                    $_data['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::Arrived;
                    $_data['PropertyUser']['actual_checkin_date'] = date('Y-m-d H:i:s');
                }
                if (!empty($_SESSION['Auth']['User']['id']) && $propertyUser['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                    $_data['PropertyUser']['is_traveler_checkin'] = 1;
                    $_data['PropertyUser']['traveler_checkin_date'] = $data['checkinout'];
                } else if (!empty($_SESSION['Auth']['User']['id']) && $propertyUser['PropertyUser']['owner_user_id'] == $_SESSION['Auth']['User']['id']) {
                    $_data['PropertyUser']['is_host_checkin'] = 1;
                    $_data['PropertyUser']['host_checkin_date'] = $data['checkinout'];
                } else {
                    $_data['PropertyUser']['is_auto_checkin'] = 1;
                    $_data['PropertyUser']['auto_checkin_date'] = date('Y-m-d H:i:s');
                }
                $this->save($_data, false);
                if ($propertyUser['PropertyUser']['property_user_status_id'] != ConstPropertyUserStatus::Arrived) {
                    $this->_propertyStatusChangeMail($propertyUser, $propertyUser['PropertyUser']['property_user_status_id'], ConstPropertyUserStatus::Arrived);
                }
            }
        }
        // WaitingforReview //
        function processStatus6($propertyUser, $payment_gateway_id, $data = null)
        {
            if ((strtotime('now') -strtotime($propertyUser['PropertyUser']['checkout'])) > 0) {
                $_data['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
                if ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived) {
                    $_data['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::WaitingforReview;
                }
                $_data['PropertyUser']['actual_checkout_date'] = date('Y-m-d H:i:s');
                if (!empty($_SESSION['Auth']['User']['id']) && $propertyUser['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                    $_data['PropertyUser']['is_traveler_checkout'] = 1;
                    $_data['PropertyUser']['traveler_checkout_date'] = $data['checkinout'];
                } else if (!empty($_SESSION['Auth']['User']['id']) && $propertyUser['PropertyUser']['owner_user_id'] == $_SESSION['Auth']['User']['id']) {
                    $_data['PropertyUser']['is_host_checkout'] = 1;
                    $_data['PropertyUser']['host_checkout_date'] = $data['checkinout'];
                } else {
                    $_data['PropertyUser']['is_auto_checkout'] = 1;
                    $_data['PropertyUser']['auto_checkout_date'] = date('Y-m-d H:i:s');
                }
                $this->save($_data, false);
                if ($propertyUser['PropertyUser']['property_user_status_id'] != ConstPropertyUserStatus::WaitingforReview) {
                    $this->_propertyStatusChangeMail($propertyUser, $propertyUser['PropertyUser']['property_user_status_id'], ConstPropertyUserStatus::WaitingforReview);
                }
            }
        }
        // PaymentCleared //
        function processStatus7($propertyUser, $payment_gateway_id, $data = null)
        {
            $_data['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
            if ($propertyUser['PropertyUser']['property_user_status_id'] != ConstPropertyUserStatus::Completed) {
                $_data['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::PaymentCleared;
            }
            // @todo
            if (empty($propertyUser['PropertyFeedback']) && !empty($propertyUser['PropertyUser']['is_auto_checkout'])) {
                $_data['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::WaitingforReview;
            }
            $_data['PropertyUser']['is_payment_cleared'] = 1;
            $this->save($_data, false);
            $this->User->updateAll(array(
                'User.available_wallet_amount' => 'User.available_wallet_amount + ' . ($propertyUser['PropertyUser']['price']-$propertyUser['PropertyUser']['host_service_amount']) ,
            ) , array(
                'User.id' => $propertyUser['Property']['user_id']
            ));
            $this->User->Transaction->log($propertyUser['PropertyUser']['id'], 'Properties.PropertyUser', $propertyUser['PropertyUser']['payment_gateway_id'], ConstTransactionTypes::HostAmountCleared);
            if (!empty($_data['PropertyUser']['property_user_status_id'])) {
                $this->_propertyStatusChangeMail($propertyUser, $propertyUser['PropertyUser']['property_user_status_id'], $_data['PropertyUser']['property_user_status_id']);
            }
        }
        // Completed //
        function processStatus8($propertyUser, $payment_gateway_id, $data = null)
        {
            if (in_array($propertyUser['PropertyUser']['property_user_status_id'], array(
                ConstPropertyUserStatus::Arrived,
                ConstPropertyUserStatus::PaymentCleared,
                ConstPropertyUserStatus::WaitingforReview
            ))) {
                $_data['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
                $_data['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::Completed;
                $_data['PropertyUser']['actual_checkout_date'] = date('Y-m-d h:i:s');
                if (!empty($_SESSION['Auth']['User']['id']) && $propertyUser['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                    $_data['PropertyUser']['is_traveler_checkout'] = 1;
                    $_data['PropertyUser']['traveler_checkout_date'] = $data['checkinout'];
                } else if (!empty($_SESSION['Auth']['User']['id']) && $propertyUser['PropertyUser']['owner_user_id'] == $_SESSION['Auth']['User']['id']) {
                    $_data['PropertyUser']['is_host_checkout'] = 1;
                    $_data['PropertyUser']['host_checkout_date'] = $data['checkinout'];
                }
                if (isset($data['via']) && $data['via'] == 'ticket') {
                    $_data['PropertyUser']['checkout_via_ticket'] = 1;
                }
                $this->save($_data, false);
                $this->_propertyStatusChangeMail($propertyUser, $propertyUser['PropertyUser']['property_user_status_id'], ConstPropertyUserStatus::Completed);
            }
            return true;
        }
        // Expired //
        function processStatus9($propertyUser, $payment_gateway_id, $data = null)
        {
            $return['error'] = 0;
            $is_refund_via_sudopay = 0;
            if (isPluginEnabled('Sudopay') && $propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) {
                $sudopayGatewayDetails = $this->_getSudopayGatewayDetails($propertyUser['PropertyUser']['sudopay_gateway_id']);
                if (!empty($sudopayGatewayDetails['SudopayPaymentGateway']['is_marketplace_supported'])) {
                    App::import('Model', 'Sudopay.Sudopay');
                    $this->Sudopay = new Sudopay();
                    $return = $this->Sudopay->cancelPreapprovalPayment($propertyUser['PropertyUser']['id']);
                    $is_refund_via_sudopay = 1;
                }
            }
            if (empty($return['error'])) {
                $traveler_balance = $propertyUser['User']['available_wallet_amount']+$propertyUser['PropertyUser']['price']+$propertyUser['PropertyUser']['traveler_service_amount']+$propertyUser['PropertyUser']['security_deposit'];
                if (empty($is_refund_via_sudopay)) {
                    $this->User->updateAll(array(
                        'User.available_wallet_amount' => "'" . $traveler_balance . "'"
                    ) , array(
                        'User.id' => $propertyUser['PropertyUser']['user_id']
                    ));
                }
                $_data['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
                $_data['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::Expired;
                $this->save($_data, false);
                $this->User->Transaction->log($propertyUser['PropertyUser']['id'], 'Properties.PropertyUser', $propertyUser['PropertyUser']['payment_gateway_id'], ConstTransactionTypes::RefundForExpiredBooking);
                $this->_propertyStatusChangeMail($propertyUser, $propertyUser['PropertyUser']['property_user_status_id'], ConstPropertyUserStatus::Expired);
            }
        }
        // CanceledByAdmin //
        function processStatus10($propertyUser, $payment_gateway_id, $data = null)
        {
            $this->_cancelBooking($propertyUser, $payment_gateway_id, $data, true);
        }
        private function _processStatusSendMail($propertyUser, $template, $to_status, $to_host)
        {
            $getHostrating = $this->getRatingCount($propertyUser['Property']['user_id']);
            App::import('Model', 'EmailTemplate');
            $this->EmailTemplate = new EmailTemplate();
            $email_template = $this->EmailTemplate->selectTemplate($template);
            $emailFindReplace = array(
                '##USERNAME##' => ($to_host) ? $propertyUser['Property']['User']['username'] : $propertyUser['User']['username'],
                '##PROPERTY_NAME##' => "<a href=" . Router::url(array(
                    'controller' => 'properties',
                    'action' => 'view',
                    $propertyUser['Property']['slug'],
                ) , true) . ">" . $propertyUser['Property']['title'] . "</a>",
                '##TRAVELER_USERNAME##' => $propertyUser['User']['username'],
                '##ACCEPT_URL##' => "<a href=" . Router::url(array(
                    'controller' => 'property_users',
                    'action' => 'update_order',
                    $propertyUser['PropertyUser']['id'],
                    __l('accept') ,
                ) , true) . ">" . __l('Accept your booking') . "</a>",
                '##REJECT_URL##' => "<a href=" . Router::url(array(
                    'controller' => 'property_users',
                    'action' => 'update_order',
                    $propertyUser['PropertyUser']['id'],
                    __l('reject') ,
                ) , true) . ">" . __l('Reject your booking') . "</a>",
                '##CANCEL_URL##' => "<a href=" . Router::url(array(
                    'controller' => 'property_users',
                    'action' => 'update_order',
                    $propertyUser['PropertyUser']['id'],
                    __l('cancel') ,
                ) , true) . ">" . __l('Cancel your booking') . "</a>",
                '##ORDER_NO##' => $propertyUser['PropertyUser']['id'],
                '##ORDERNO##' => $propertyUser['PropertyUser']['id'],
                '##PROPERTY_FULL_NAME##' => "<a href=" . Router::url(array(
                    'controller' => 'properties',
                    'action' => 'view',
                    $propertyUser['Property']['slug']
                ) , true) . ">" . $propertyUser['Property']['title'] . "</a>",
                '##PROPERTY_DESCRIPTION##' => $propertyUser['Property']['description'],
                '##HOST_NAME##' => $propertyUser['Property']['User']['username'],
                '##HOST_RATING##' => (!empty($getHostrating) && is_numeric($getHostrating)) ? $getHostrating . '% ' . __l('Positive') : __l('Not Reviewed Yet') ,
                '##HOST_CONTACT_LINK##' => "<a href=" . Router::url(array(
                    'controller' => 'messages',
                    'action' => 'compose',
                    'type' => 'contact',
                    'to' => $propertyUser['Property']['User']['username'],
                    'slug' => $propertyUser['Property']['slug'],
                ) , true) . ">" . 'contact host' . "</a>",
                '##HOST_CONTACT##' => "<a href=" . Router::url(array(
                    'controller' => 'messages',
                    'action' => 'compose',
                    'type' => 'contact',
                    'to' => $propertyUser['Property']['User']['username'],
                    'slug' => $propertyUser['Property']['slug'],
                ) , true) . ">" . 'contact host' . "</a>",
                '##CHECK_IN_DATE##' => $propertyUser['PropertyUser']['checkin'],
                '##CHECK_OUT_DATE##' => getCheckoutDate($propertyUser['PropertyUser']['checkout']) ,
                '##PROPERTY_AUTO_EXPIRE_DATE##' => Configure::read('property.auto_expire') ,
                '##SITE_NAME##' => Configure::read('site.name') ,
                '##SITE_URL##' => Router::url('/', true) ,
                '##UNSUBSCRIBE_LINK##' => Router::url(array(
                    'controller' => 'user_notifications',
                    'action' => 'edit',
                    'admin' => false
                ) , true) ,
                '##CONTACT_URL##' => Router::url(array(
                    'controller' => 'contacts',
                    'action' => 'add',
                    'admin' => false
                ) , true) ,
                '##CONTACT_LINK##' => Router::url(array(
                    'controller' => 'contacts',
                    'action' => 'add',
                    'admin' => false
                ) , true) ,
                '##FROM_EMAIL##' => ($email_template['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email_template['from'],
            );
            $message = strtr($email_template['email_text_content'], $emailFindReplace);
            $subject = strtr($email_template['subject'], $emailFindReplace);
            if ($to_host) {
                $this->Property->PropertyUser->_sendEmail($email_template, $emailFindReplace, $propertyUser['Property']['User']['email']);
            } else {
                $this->Property->PropertyUser->_sendEmail($email_template, $emailFindReplace, $propertyUser['User']['email']);
                $this->Property->PropertyUser->User->Message->sendNotifications($propertyUser['PropertyUser']['user_id'], $subject, $message, $propertyUser['PropertyUser']['id'], $is_review = 0, $propertyUser['Property']['id'], $to_status);
            }
        }
        private function _propertyStatusChangeMail($propertyUser, $from_status, $to_status)
        {
            App::import('Model', 'EmailTemplate');
            $this->EmailTemplate = new EmailTemplate();
            $property_user_statuses = $this->PropertyUserStatus->find('list', array(
                'recursive' => -1
            ));
			if($property_user_statuses[$from_status] != $property_user_statuses[$to_status]) {
				$emailTemplate = $this->EmailTemplate->selectTemplate('Property User Change Status Alert');
				$emailFindAndReplace = array(
					'##PREVIOUS_STATUS##' => $property_user_statuses[$from_status],
					'##CURRENT_STATUS##' => $property_user_statuses[$to_status],
					'##PROPERTY##' => $propertyUser['Property']['title'],
					'##PROPERTY_NAME##' => $propertyUser['Property']['title'],
					'##SITE_NAME##' => Configure::read('site.name') ,
					'##SITE_URL##' => Router::url('/', true) ,
					'##UNSUBSCRIBE_LINK##' => Router::url(array(
						'controller' => 'user_notifications',
						'action' => 'edit',
						'admin' => false
					) , true) ,
					'##FROM_EMAIL##' => ($emailTemplate['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $emailTemplate['from'],
					'##CONTACT_URL##' => Router::url(array(
						'controller' => 'contacts',
						'action' => 'add',
						'admin' => false
					) , true) ,
				);
				$message = strtr($emailTemplate['email_text_content'], $emailFindAndReplace);
				$subject = strtr($emailTemplate['subject'], $emailFindAndReplace);
				$this->Property->PropertyUser->_sendEmail($emailTemplate, $emailFindAndReplace, $propertyUser['User']['email']);
				$this->Property->PropertyUser->User->Message->sendNotifications($propertyUser['User']['id'], $subject, $message, $propertyUser['PropertyUser']['id'], $is_review = 0, $propertyUser['Property']['id'], $to_status);
				$this->Property->PropertyUser->_sendEmail($emailTemplate, $emailFindAndReplace, $propertyUser['Property']['User']['email']);
			}
        }
        private function _cancelBooking($propertyUser, $payment_gateway_id, $data = null, $is_admin)
        {
            if (!empty($propertyUser['PropertyUser']) && (in_array($propertyUser['PropertyUser']['property_user_status_id'], array(
                ConstPropertyUserStatus::Confirmed,
                ConstPropertyUserStatus::WaitingforAcceptance
            )))) {
                if (!empty($_SESSION['Auth']['User']['id']) && ($propertyUser['PropertyUser']['user_id'] != $_SESSION['Auth']['User']['id'])) {
                    if ($_SESSION['Auth']['User']['id'] != ConstUserIds::Admin) {
                        throw new NotFoundException(__l('Invalid request'));
                    }
                }
                if ($propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) {
                    $sudopayGatewayDetails = $this->_getSudopayGatewayDetails($propertyUser['PropertyUser']['sudopay_gateway_id']);
                    if (!empty($sudopayGatewayDetails['SudopayPaymentGateway']['is_marketplace_supported'])) {
                        App::import('Model', 'Sudopay.Sudopay');
                        $this->Sudopay = new Sudopay();
                        $return = $this->Sudopay->processPreapprovalPayment($propertyUser['PropertyUser']['id']);
                    }
                }
                $security_deposit = 0;
                if (Configure::read('property.is_enable_security_deposit')) {
                    $security_deposit = $propertyUser['PropertyUser']['security_deposit'];
                }
                $refund_amount = $this->Property->_checkCancellationPolicies($propertyUser);
                if ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed) {
                    if (empty($refund_amount['host_balance'])) {
                        $traveler_transaction_amount = $refund_amount['traveler_balance']+$security_deposit;
                        $traveler_balance = $propertyUser['User']['available_wallet_amount']+$traveler_transaction_amount;
                    } elseif (!empty($refund_amount['host_balance'])) {
                        $host_transaction_amount = $refund_amount['host_balance'];
                        $host_balance = $propertyUser['Property']['User']['available_wallet_amount']+$host_transaction_amount;
                        $traveler_transaction_amount = $refund_amount['traveler_balance']+$security_deposit;
                        $traveler_balance = $propertyUser['User']['available_wallet_amount']+$traveler_transaction_amount;
                    }
                } else {
                    $traveler_transaction_amount = $propertyUser['PropertyUser']['price']+$security_deposit;
                    $traveler_balance = $propertyUser['User']['available_wallet_amount']+$traveler_transaction_amount;
                }
                $_data['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
                $_data['PropertyUser']['property_user_status_id'] = ($is_admin) ? ConstPropertyUserStatus::CanceledByAdmin : ConstPropertyUserStatus::Canceled;
                $this->save($_data, false);
                if (!empty($traveler_balance)) {
                    $this->User->updateAll(array(
                        'User.available_wallet_amount' => "'" . $traveler_balance . "'"
                    ) , array(
                        'User.id' => $propertyUser['PropertyUser']['user_id']
                    ));
                }
                if (!empty($host_balance)) {
                    $this->User->updateAll(array(
                        'User.available_wallet_amount' => "'" . $host_balance . "'"
                    ) , array(
                        'User.id' => $propertyUser['Property']['user_id']
                    ));
                }
                if (!empty($host_transaction_amount)) {
                    $this->User->Transaction->log($propertyUser['PropertyUser']['id'], 'Properties.PropertyUser', $propertyUser['PropertyUser']['payment_gateway_id'], ConstTransactionTypes::HostAmountCleared, $host_transaction_amount);
                }
                if (!empty($traveler_transaction_amount)) {
                    $transaction_type = ($is_admin) ? ConstTransactionTypes::RefundForBookingCanceledByAdmin : ConstTransactionTypes::RefundForCanceledBooking;
                    $this->User->Transaction->log($propertyUser['PropertyUser']['id'], 'Properties.PropertyUser', $propertyUser['PropertyUser']['payment_gateway_id'], $transaction_type, $traveler_transaction_amount);
                }
                $to_status = ($is_admin) ? ConstPropertyUserStatus::CanceledByAdmin : ConstPropertyUserStatus::Canceled;
                $this->_propertyStatusChangeMail($propertyUser, $propertyUser['PropertyUser']['property_user_status_id'], $to_status);
            }
        }
        private function _getSudopayGatewayDetails($sudopay_gateway_id)
        {
            App::import('Model', 'Sudopay.SudopayPaymentGateway');
            $this->SudopayPaymentGateway = new SudopayPaymentGateway();
            return $this->SudopayPaymentGateway->find('first', array(
                'conditions' => array(
                    'SudopayPaymentGateway.sudopay_gateway_id' => $sudopay_gateway_id
                ) ,
                'recursive' => -1
            ));
        }
    }
?>