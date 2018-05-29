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
class UserCashWithdrawal extends AppModel
{
    public $name = 'UserCashWithdrawal';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'WithdrawalStatus' => array(
            'className' => 'Withdrawals.WithdrawalStatus',
            'foreignKey' => 'withdrawal_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => ''
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'user_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'withdrawal_status_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'amount' => array(
                'rule2' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                ) ,
                'rule1' => array(
                    'rule' => 'numeric',
                    'message' => __l('Should be numeric')
                )
            ) ,
            'description' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
        $this->moreActions = array(
            ConstWithdrawalStatus::Pending => __l('Pending') ,
            ConstWithdrawalStatus::Approved => __l('Approve...') ,
            ConstWithdrawalStatus::Rejected => __l('Reject') ,
        );
    }
    function _checkAmount($amount) 
    {
        $user_available_balance = $this->User->_checkUserBalance($this->data[$this->name]['user_id']);
        if ($user_available_balance < $amount) {
            return __l('Given amount is greater than wallet amount');
        }
        if (($amount < Configure::read('user.minimum_withdraw_amount')) || ($amount > Configure::read('user.maximum_withdraw_amount'))) {
            return sprintf(__l('Given amount should lies from  %s%s to %s%s') , Configure::read('site.currency') , Configure::read('user.minimum_withdraw_amount') , Configure::read('site.currency') , Configure::read('user.maximum_withdraw_amount'));
        }
        return true;
    }
    function _automaticTransferAmount($role_id) 
    {
        $conditions['UserCashWithdrawal.withdrawal_status_id'] = ConstWithdrawalStatus::Pending;
        if ($role_id == ConstUserTypes::User) {
            $conditions['User.role_id'] = ConstUserTypes::User;
        } elseif ($role_id == ConstUserTypes::Merchant) {
            $conditions['User.role_id'] = ConstUserTypes::Merchant;
        }
        $paymentGateways = $this->User->MoneyTransferAccount->PaymentGateway->find('all', array(
            'conditions' => array(
                'PaymentGateway.is_mass_pay_enabled' => 1,
            ) ,
            'recursive' => -1
        ));
        $userCashWithdrawals = $this->find('all', array(
            'conditions' => $conditions,
            'fields' => array(
                'UserCashWithdrawal.id',
                'UserCashWithdrawal.user_id'
            ) ,
            'recursive' => 0
        ));
        if (!empty($paymentGateways)) {
            foreach($paymentGateways as $paymentGateway) {
                $userWithdrawalIds = array();
                foreach($userCashWithdrawals as $userCashWithdrawal) {
                    $isExistMoneyTransferAccount = $this->User->MoneyTransferAccount->find('first', array(
                        'conditions' => array(
                            'MoneyTransferAccount.user_id' => $userCashWithdrawal['UserCashWithdrawal']['user_id'],
                            'MoneyTransferAccount.payment_gateway_id' => $paymentGateway['PaymentGateway']['id'],
                            'MoneyTransferAccount.is_default' => 1,
                        ) ,
                        'recursive' => -1
                    ));
                    if (!empty($isExistMoneyTransferAccount)) {
                        $userWithdrawalIds[$userCashWithdrawal['UserCashWithdrawal']['id']] = $userCashWithdrawal['UserCashWithdrawal']['id'];
                    }
                }
                if (!empty($userWithdrawalIds)) {
                    $modelName = Inflector::camelize('mass_pay_' . strtolower($paymentGateway['PaymentGateway']['name']));
                    APP::Import('Model', $modelName);
                    $this->obj = new $modelName();
                    $status = $this->obj->_transferAmount($userWithdrawalIds, 'UserCashWithdrawal');
                    if (empty($status['error'])) {
                        $this->onApprovedProcess($userWithdrawalIds, $status);
                    }
                }
            }
        }
    }
    function _getWithdrawalRequest($userCashWithdrawalsIds, $role_id, $payment_gateway_id) 
    {
        $conditions['UserCashWithdrawal.withdrawal_status_id'] = ConstWithdrawalStatus::Pending;
        if (!empty($userCashWithdrawalsIds)) {
            $conditions['UserCashWithdrawal.id'] = $userCashWithdrawalsIds;
        } elseif ($role_id == ConstUserTypes::User) {
            $conditions['User.role_id'] = ConstUserTypes::User;
        } elseif ($role_id == ConstUserTypes::Merchant) {
            $conditions['User.role_id'] = ConstUserTypes::Merchant;
        }
        $returns['error'] = 0;
        $userCashWithdrawals = $this->find('all', array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'MoneyTransferAccount' => array(
                        'conditions' => array(
                            'MoneyTransferAccount.payment_gateway_id' => $payment_gateway_id
                        )
                    ) ,
                    'fields' => array(
                        'User.username',
                        'User.available_wallet_amount',
                        'User.blocked_amount'
                    )
                ) ,
            ) ,
            'recursive' => 2
        ));
        $filteredUserCashWithdrawals = array();
        if (!empty($userCashWithdrawals)) {
            foreach($userCashWithdrawals as $userCashWithdrawal) {
                if (empty($userCashWithdrawal['User']['MoneyTransferAccount'])) {
                    $returns['error'] = 1;
                    $returns['message'] = __l('one the selected withdrawal has not configured the money transfer account. Please try again');
                    break;
                } else if ($userCashWithdrawal['User']['blocked_amount'] >= $userCashWithdrawal['UserCashWithdrawal']['amount']) {
                    $filteredUserCashWithdrawals[] = $userCashWithdrawal;
                }
            }
        }
        $returns['data'] = $filteredUserCashWithdrawals;
        return $returns;
    }
    function user_masspay_ipn_process($userCashWithdrawal_id, $userCashWithdrawal_response, $gateway_id = ConstPaymentGateways::SudoPay, $logTable = 'SudopayTransactionLog') 
    {
        $userCashWithdrawal = $this->find('first', array(
            'conditions' => array(
                'UserCashWithdrawal.id' => $userCashWithdrawal_id,
                'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Approved,
            ) ,
            'contain' => array(
                'User',
                $logTable => array(
                    'fields' => array(
                        $logTable . '.id',
                        $logTable . '.user_id',
                        $logTable . '.transaction_id',
                        $logTable . '.user_cash_withdrawal_id',
                        $logTable . '.orginal_amount',
                        $logTable . '.rate',
                        $logTable . '.masspay_response',
                    )
                ) ,
            ) ,
            'recursive' => 1
        ));
        $return = '';
        if (!empty($userCashWithdrawal)) {
            if ($userCashWithdrawal_response['status'] == 'Completed') {
                Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
                    '_addTrans' => array(
                        'order_id' => 'Withdrawal-' . $userCashWithdrawal['UserCashWithdrawal']['id'],
                        'name' => 'Withdrawal',
                        'total' => $userCashWithdrawal['UserCashWithdrawal']['amount']
                    ) ,
                    '_addItem' => array(
                        'order_id' => 'Withdrawal-' . $userCashWithdrawal['UserCashWithdrawal']['id'],
                        'sku' => 'WD' . $userCashWithdrawal['UserCashWithdrawal']['id'],
                        'name' => 'Withdrawal',
                        'category' => $userCashWithdrawal['User']['username'],
                        'unit_price' => $userCashWithdrawal['UserCashWithdrawal']['amount']
                    ) ,
                    '_setCustomVar' => array(
                        'ud' => $_SESSION['Auth']['User']['id'],
                        'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
                    )
                ));
                $transaction_id = $this->onSuccessProcess($userCashWithdrawal, $userCashWithdrawal_response, $logTableData);
            } else {
                $transaction_id = $this->onFailedProcess($userCashWithdrawal);
            }
            $return['transaction_id'] = $transaction_id;
            $return['log_id'] = $userCashWithdrawal[$logTable]['id'];
        }
        return $return;
    }
    public function onSuccessProcess($userCashWithdrawal, $userCashWithdrawal_response = array() , $logTable = array()) 
    {
        $transaction_id = $this->User->Transaction->log($userCashWithdrawal['UserCashWithdrawal']['id'], 'Withdrawals.UserCashWithdrawal', $userCashWithdrawal['UserCashWithdrawal']['payment_gateway_id'], ConstTransactionTypes::CashWithdrawalRequestPaid);
        $this->updateAll(array(
            'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Success,
        ) , array(
            'UserCashWithdrawal.id' => $userCashWithdrawal['UserCashWithdrawal']['id']
        ));
        $this->_updateUserAmount($userCashWithdrawal['UserCashWithdrawal']['user_id']);
        $this->User->updateAll(array(
            'User.blocked_amount' => 'User.blocked_amount -' . $userCashWithdrawal['UserCashWithdrawal']['amount'],
        ) , array(
            'User.id' => $userCashWithdrawal['UserCashWithdrawal']['user_id']
        ));
        return $transaction_id;
    }
    // After Save Update //
    function _updateUserAmount($user_id) 
    {
        if (!empty($user_id)) {
            $user_cash_withdrawal = $this->find('all', array(
                'conditions' => array(
                    'UserCashWithdrawal.user_id' => $user_id,
                    'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Success,
                ) ,
                'fields' => array(
                    'SUM(UserCashWithdrawal.amount) as total_amount_withdrawn',
                    'COUNT(UserCashWithdrawal.amount) as total_amount_withdrawn_count',
                ) ,
                'recursive' => -1
            ));
            if (!empty($user_cash_withdrawal)) {
                $this->User->updateAll(array(
                    'User.total_amount_withdrawn' => $user_cash_withdrawal[0][0]['total_amount_withdrawn'],
                    'User.total_withdraw_request_count' => $user_cash_withdrawal[0][0]['total_amount_withdrawn_count'],
                ) , array(
                    'User.id' => $user_id
                ));
            }
        }
    }
    public function onFailedProcess($userCashWithdrawal) 
    {
        $transaction_id = $this->User->Transaction->log($userCashWithdrawal['UserCashWithdrawal']['id'], 'Withdrawals.UserCashWithdrawal', $userCashWithdrawal['UserCashWithdrawal']['payment_gateway_id'], ConstTransactionTypes::CashWithdrawalRequestFailed);
        $this->User->updateAll(array(
            'User.available_wallet_amount' => 'User.available_wallet_amount +' . $userCashWithdrawal['UserCashWithdrawal']['amount']
        ) , array(
            'User.id' => $userCashWithdrawal['UserCashWithdrawal']['user_id']
        ));
        $this->User->updateAll(array(
            'User.blocked_amount' => 'User.blocked_amount -' . $userCashWithdrawal['UserCashWithdrawal']['amount']
        ) , array(
            'User.id' => $userCashWithdrawal['UserCashWithdrawal']['user_id']
        ));
        return $transaction_id;
    }
    public function onApprovedProcess($userCashWithdrawalIds, $status = array() , $logTable = 'SudopayTransactionLog') 
    {
        APP::Import('Model', $logTable);
        $this->
        {
            $logTable} = new $logTable();
            foreach($userCashWithdrawalIds as $userCashWithdrawalId) {
                $cash_withdraw = $this->find('first', array(
                    'conditions' => array(
                        'UserCashWithdrawal.id' => $userCashWithdrawalId
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($userCashWithdrawalId) && !empty($cash_withdraw)) {
                    $transaction_id = $this->User->Transaction->log($cash_withdraw['UserCashWithdrawal']['id'], 'Withdrawals.UserCashWithdrawal', ConstPaymentGateways::SudoPay, ConstTransactionTypes::CashWithdrawalRequestApproved);
                    // update log transaction id
                    if (!empty($status)) {
                        $log_array = array();
                        $log_array[$logTable]['id'] = $status['log_list'][$userCashWithdrawalId];
                        $log_array[$logTable]['transaction_id'] = $transaction_id;
                        $this->$logTable->save($log_array);
                    }
                    // update status
                    $user_cash_data = array();
                    $user_cash_data['UserCashWithdrawal']['id'] = $userCashWithdrawalId;
                    $user_cash_data['UserCashWithdrawal']['payment_gateway_id'] = ConstPaymentGateways::SudoPay;
                    $user_cash_data['UserCashWithdrawal']['withdrawal_status_id'] = ConstWithdrawalStatus::Approved;
                    $this->save($user_cash_data);
                }
            }
        }
    }
?>