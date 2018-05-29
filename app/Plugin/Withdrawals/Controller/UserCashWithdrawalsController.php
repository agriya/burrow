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
class UserCashWithdrawalsController extends AppController
{
    public $name = 'UserCashWithdrawals';
    public $permanentCacheAction = array(
        'user' => array(
            'index',
            'add',
        ) ,
    );
    public function index() 
    {
		if (!isPluginEnabled('Wallet')) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle = __l('Withdraw Fund Request');
        $this->paginate = array(
            'conditions' => array(
                'UserCashWithdrawal.user_id' => $this->Auth->user('id') ,
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.role_id',
                        'User.username',
                        'User.id',
                    )
                ) ,
                'WithdrawalStatus' => array(
                    'fields' => array(
                        'WithdrawalStatus.name',
                        'WithdrawalStatus.id'
                    )
                )
            ) ,
            'order' => array(
                'UserCashWithdrawal.id' => 'desc'
            ) ,
            'recursive' => 0
        );
        $moneyTransferAccounts = $this->UserCashWithdrawal->User->MoneyTransferAccount->find('count', array(
            'conditions' => array(
                'MoneyTransferAccount.user_id' => $this->Auth->User('id') ,
            ) ,
            'recursive' => -1
        ));
        $userProfile = $this->UserCashWithdrawal->User->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $this->Auth->User('id')
            ) ,
            'recursive' => -1
        ));
        $this->set('moneyTransferAccounts', $moneyTransferAccounts);
        $this->set('userProfile', $userProfile);
        $this->request->data['UserCashWithdrawal']['user_id'] = $this->Auth->user('id');
        $this->set('userCashWithdrawals', $this->paginate());
    }
    public function add() 
    {
        $this->pageTitle = sprintf(__l('Add %s') , __l('Fund Withdraw'));
        if (!empty($this->request->data)) {
            $this->request->data['UserCashWithdrawal']['user_id'];
            if (($this->request->data['UserCashWithdrawal']['user_id'] != $this->Auth->user('id')) || ($this->request->data['UserCashWithdrawal']['role_id'] != $this->Auth->user('role_id'))) {
                $this->Session->setFlash('Invalid request', 'default', null, 'error');
                $ajax_url = Router::url(array(
                    'controller' => 'user_cash_withdrawals',
                    'action' => 'index'
                ));
                if (!empty($this->request->params['isAjax'])) {
                    $success_msg = 'redirect*' . $ajax_url;
                    echo $success_msg;
                    exit;
                } else {
                    $this->redirect($ajax_url);
                }
            }
            $this->UserCashWithdrawal->set($this->request->data);
            $this->UserCashWithdrawal->validationErrors = array();
            if ($this->UserCashWithdrawal->validates() &$this->UserCashWithdrawal->validationErrors['amount'] = $this->UserCashWithdrawal->_checkAmount($this->request->data['UserCashWithdrawal']['amount'])) {
                $MoneyTransferAccount = $this->UserCashWithdrawal->User->MoneyTransferAccount->find('first', array(
                    'conditions' => array(
                        'MoneyTransferAccount.user_id' => $this->Auth->user('id') ,
                    ) ,
                    'fields' => array(
                        'MoneyTransferAccount.payment_gateway_id'
                    ),
					'recursive' => -1,
                ));
                $gateway_id = $MoneyTransferAccount['MoneyTransferAccount']['payment_gateway_id'];
                $this->request->data['UserCashWithdrawal']['payment_gateway_id'] = $gateway_id;
                $this->request->data['UserCashWithdrawal']['withdrawal_status_id'] = ConstWithdrawalStatus::Pending;
                $this->UserCashWithdrawal->create();
                if ($this->UserCashWithdrawal->save($this->request->data)) {
                    $this->UserCashWithdrawal->User->Transaction->log($this->UserCashWithdrawal->getLastInsertId() , 'Withdrawals.UserCashWithdrawal', ConstPaymentGateways::ManualPay, ConstTransactionTypes::CashWithdrawalRequest);
                    $this->UserCashWithdrawal->User->updateAll(array(
                        'User.available_wallet_amount' => 'User.available_wallet_amount -' . $this->request->data['UserCashWithdrawal']['amount']
                    ) , array(
                        'User.id' => $this->request->data['UserCashWithdrawal']['user_id']
                    ));
                    $this->UserCashWithdrawal->User->updateAll(array(
                        'User.blocked_amount' => 'User.blocked_amount +' . $this->request->data['UserCashWithdrawal']['amount']
                    ) , array(
                        'User.id' => $this->request->data['UserCashWithdrawal']['user_id']
                    ));
                    $this->Session->setFlash(sprintf(__l('%s has been added') , __l('Withdraw Fund Request')) , 'default', null, 'success');
                    $ajax_url = Router::url(array(
                        'controller' => 'user_cash_withdrawals',
                        'action' => 'index'
                    ));
                    if ($this->request->params['isAjax'] == 1) {
                        $success_msg = 'redirect*' . $ajax_url;
                        echo $success_msg;
                        exit;
                    } else {
                        $this->redirect($ajax_url);
                    }
                } else {
                    $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Withdraw Fund Request')) , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Withdraw Fund Request')) , 'default', null, 'error');
            }
        }
        $this->request->data['UserCashWithdrawal']['user_id'] = $this->Auth->user('id');
    }
    public function admin_index() 
    {
        if (!isPluginEnabled('Wallet')) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $title = '';
        $conditions = array();
        $this->_redirectGET2Named(array(
            'filter_id',
            'q',
            'account_id'
        ));
        $this->pageTitle = __l('Withdraw Fund Requests');
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['UserCashWithdrawal']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!isset($this->request->params['named']['filter_id']) && !isset($this->request->data['UserCashWithdrawal']['filter_id'])) {
            $this->request->data['UserCashWithdrawal']['filter_id'] = $this->request->params['named']['filter_id'] = 'all';
        }
        if (!empty($this->request->data['UserCashWithdrawal']['filter_id']) && $this->request->data['UserCashWithdrawal']['filter_id'] != 'all') {
            $conditions['UserCashWithdrawal.withdrawal_status_id'] = $this->request->data['UserCashWithdrawal']['filter_id'];
            $status = $this->UserCashWithdrawal->WithdrawalStatus->find('first', array(
                'conditions' => array(
                    'WithdrawalStatus.id' => $this->request->data['UserCashWithdrawal']['filter_id'],
                ) ,
                'fields' => array(
                    'WithdrawalStatus.name'
                ) ,
                'recursive' => -1
            ));
            $title = $status['WithdrawalStatus']['name'];
        }
        if (!empty($title)) {
            $this->pageTitle.= ' - ' . $title;
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                    'MoneyTransferAccount' => array(
                        'fields' => array(
                            'MoneyTransferAccount.id',
                            'MoneyTransferAccount.payment_gateway_id',
                            'MoneyTransferAccount.is_default',
                            'MoneyTransferAccount.account',
                        ) ,
                        'PaymentGateway' => array(
                            'conditions' => array(
                                'PaymentGateway.is_mass_pay_enabled' => 1,
                            ) ,
                            'fields' => array(
                                'PaymentGateway.display_name',
                                'PaymentGateway.name'
                            )
                        )
                    )
                ) ,
                'WithdrawalStatus' => array(
                    'fields' => array(
                        'WithdrawalStatus.name',
                        'WithdrawalStatus.id',
                    )
                )
            ) ,
            'order' => array(
                'UserCashWithdrawal.id' => 'desc'
            ) ,
            'recursive' => 3,
        );
        $withdrawalStatuses = $this->UserCashWithdrawal->WithdrawalStatus->find('all', array(
            'recursive' => -1
        ));
        $this->set('withdrawalStatuses', $withdrawalStatuses);
        $paymentGateways = $this->UserCashWithdrawal->User->MoneyTransferAccount->PaymentGateway->find('all', array(
            'conditions' => array(
                'PaymentGateway.is_mass_pay_enabled' => 1
            ) ,
            'recursive' => -1
        ));
        $this->set('paymentGateways', $paymentGateways);
        $moreActions = $this->UserCashWithdrawal->moreActions;
        if (!empty($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending)) {
            unset($moreActions[ConstWithdrawalStatus::Pending]);
        }
        $this->set('moreActions', $moreActions);
        $this->set('userCashWithdrawals', $this->paginate());
        $this->set('approved', $this->UserCashWithdrawal->find('count', array(
            'conditions' => array(
                'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Approved,
            ) ,
            'recursive' => -1
        )));
        $this->set('success', $this->UserCashWithdrawal->find('count', array(
            'conditions' => array(
                'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Success,
            ) ,
            'recursive' => -1
        )));
        $this->set('pending', $this->UserCashWithdrawal->find('count', array(
            'conditions' => array(
                'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Pending,
            ) ,
            'recursive' => -1
        )));
        $this->set('rejected', $this->UserCashWithdrawal->find('count', array(
            'conditions' => array(
                'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Rejected,
            ) ,
            'recursive' => -1
        )));
        $this->set('pageTitle', $this->pageTitle);
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserCashWithdrawal->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Withdraw Fund Request')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_update() 
    {
        if (!empty($this->request->data['UserCashWithdrawal'])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $userCashWithdrawalIds = array();
            foreach($this->request->data['UserCashWithdrawal'] as $userCashWithdrawal_id => $is_checked) {
                if ($is_checked['id']) {
                    $userCashWithdrawalIds[] = $userCashWithdrawal_id;
                }
            }
            if ($actionid && !empty($userCashWithdrawalIds)) {
                if ($actionid == ConstWithdrawalStatus::Pending) {
                    $this->UserCashWithdrawal->updateAll(array(
                        'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Pending
                    ) , array(
                        'UserCashWithdrawal.id' => $userCashWithdrawalIds
                    ));
                    $this->Session->setFlash(__l('Checked requests have been moved to pending status') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'user_cash_withdrawals',
                        'action' => 'index'
                    ));
                } else if ($actionid == ConstWithdrawalStatus::Rejected) {
                    // Need to Refund the Money to User
                    $canceled_withdraw_requests = $this->UserCashWithdrawal->find('all', array(
                        'conditions' => array(
                            'UserCashWithdrawal.id' => $userCashWithdrawalIds
                        ) ,
                        'recursive' => -1
                    ));
                    // Updating user balance
                    foreach($canceled_withdraw_requests as $canceled_withdraw_request) {
                        // Updating transactions
                        if (!empty($canceled_withdraw_request)) {
                            $this->UserCashWithdrawal->User->Transaction->log($canceled_withdraw_request['UserCashWithdrawal']['id'], 'Withdrawals.UserCashWithdrawal', $canceled_withdraw_request['UserCashWithdrawal']['payment_gateway_id'], ConstTransactionTypes::CashWithdrawalRequestRejected);
                        }
                        // Addding to user's Available Balance
                        $this->UserCashWithdrawal->User->updateAll(array(
                            'User.available_wallet_amount' => 'User.available_wallet_amount +' . $canceled_withdraw_request['UserCashWithdrawal']['amount']
                        ) , array(
                            'User.id' => $canceled_withdraw_request['UserCashWithdrawal']['user_id']
                        ));
                        // Deducting user's Available Balance
                        $this->UserCashWithdrawal->User->updateAll(array(
                            'User.blocked_amount' => 'User.blocked_amount -' . $canceled_withdraw_request['UserCashWithdrawal']['amount']
                        ) , array(
                            'User.id' => $canceled_withdraw_request['UserCashWithdrawal']['user_id']
                        ));
                        $this->UserCashWithdrawal->updateAll(array(
                            'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Rejected
                        ) , array(
                            'UserCashWithdrawal.id' => $canceled_withdraw_request['UserCashWithdrawal']['id']
                        ));
                    }
                    //
                    $this->Session->setFlash(__l('Checked requests have been moved to rejected status, Refunded  Money to Wallet') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'user_cash_withdrawals',
                        'action' => 'index'
                    ));
                } else if ($actionid == ConstWithdrawalStatus::Approved) {
                    $paymentGateways = $this->UserCashWithdrawal->User->MoneyTransferAccount->PaymentGateway->find('list', array(
                        'conditions' => array(
                            'PaymentGateway.is_mass_pay_enabled' => 1
                        ) ,
                        'fields' => array(
                            'PaymentGateway.id',
                            'PaymentGateway.name',
                        ) ,
                        'recursive' => -1
                    ));
                    $conditions['UserCashWithdrawal.id'] = $userCashWithdrawalIds;
                    $this->paginate = array(
                        'conditions' => $conditions,
                        'contain' => array(
                            'User' => array(
                                'UserAvatar',
                                'MoneyTransferAccount' => array(
                                    'fields' => array(
                                        'MoneyTransferAccount.id',
                                        'MoneyTransferAccount.payment_gateway_id',
                                        'MoneyTransferAccount.account',
                                        'MoneyTransferAccount.is_default',
                                    ) ,
                                    'PaymentGateway' => array(
                                        'conditions' => array(
                                            'PaymentGateway.is_mass_pay_enabled' => 1,
                                        ) ,
                                        'fields' => array(
                                            'PaymentGateway.display_name',
                                            'PaymentGateway.name'
                                        )
                                    )
                                )
                            ) ,
                            'WithdrawalStatus' => array(
                                'fields' => array(
                                    'WithdrawalStatus.name',
                                    'WithdrawalStatus.id',
                                )
                            )
                        ) ,
                        'order' => array(
                            'UserCashWithdrawal.id' => 'desc'
                        ) ,
                        'recursive' => 3,
                    );
                    $userCashWithdrawals = $this->paginate();
                    foreach($userCashWithdrawals as $key => $userCashWithdrawal) {
                        $payment_gates = array();
                        $payment_gates[ConstPaymentGateways::ManualPay] = __l('Mark as paid/manual');
                        foreach($payment_gates as $id => $name) {
                            if (ConstPaymentGateways::ManualPay != $id && empty($paymentGateways[$id])) {
                                unset($payment_gates[$id]);
                            }
                        }
                        $userCashWithdrawals[$key]['paymentways'] = $payment_gates;
                    }
                    $this->pageTitle = __l('Withdraw Fund Requests - Approved');
                    $this->set('userCashWithdrawals', $userCashWithdrawals);
                    $this->render('admin_pay_to_user');
                }
            } else {
                $this->redirect(array(
                    'controller' => 'user_cash_withdrawals',
                    'action' => 'index',
                    'filter_id' => ConstWithdrawalStatus::Pending
                ));
            }
        } else {
            $this->redirect(array(
                'controller' => 'user_cash_withdrawals',
                'action' => 'index',
                'filter_id' => ConstWithdrawalStatus::Pending
            ));
        }
    }
    public function admin_pay_to_user() 
    {
        $this->pageTitle = __l('Withdraw Fund Requests - Approved');
        if (!empty($this->request->data)) {
            $approve_list = $approve_list_id = array();
            if (!empty($this->request->data['UserCashWithdrawal'])) {
                foreach($this->request->data['UserCashWithdrawal'] as $list) {
                    $approve_list[$list['gateways']][$list['id']] = $list;
                    $approve_list_id[$list['gateways']][] = $list['id'];
                }
                if (!empty($approve_list)) {
                    foreach($approve_list_id as $gateway => $list_id) {
                        if ($gateway == ConstPaymentGateways::ManualPay) { // manual pay
                            $userCashWithdrawals = $this->UserCashWithdrawal->find('all', array(
                                'conditions' => array(
                                    'UserCashWithdrawal.id' => $list_id,
                                    'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Pending,
                                ) ,
                                'contain' => array(
                                    'User'
                                ) ,
                                'recursive' => 0
                            ));
                            foreach($userCashWithdrawals as $userCashWithdrawal) {
                                $logTableData = array();
                                $userCashWithdrawal_response['mc_fee'] = 0;
                                $userCashWithdrawal_response['mc_gross'] = $userCashWithdrawal['UserCashWithdrawal']['amount'];
                                $userCashWithdrawal['UserCashWithdrawal']['remark'] = $approve_list[$gateway][$userCashWithdrawal['UserCashWithdrawal']['id']]['info'];
                                $this->UserCashWithdrawal->onSuccessProcess($userCashWithdrawal, $userCashWithdrawal_response, $logTableData);
                                Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
                                    '_addTrans' => array(
                                        'order_id' => 'Withdrawal-' . $userCashWithdrawal['UserCashWithdrawal']['id'],
                                        'name' => $userCashWithdrawal['User']['username'],
                                        'total' => $userCashWithdrawal['UserCashWithdrawal']['amount']
                                    ) ,
                                    '_addItem' => array(
                                        'order_id' => 'Withdrawal-' . $userCashWithdrawal['UserCashWithdrawal']['id'],
                                        'sku' => 'W' . $userCashWithdrawal['UserCashWithdrawal']['id'],
                                        'name' => $userCashWithdrawal['User']['username'],
                                        'category' => '',
                                        'unit_price' => $userCashWithdrawal['UserCashWithdrawal']['amount']
                                    ) ,
                                    '_setCustomVar' => array(
                                        'ud' => $_SESSION['Auth']['User']['id'],
                                        'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
                                    )
                                ));
                                $this->Session->setFlash(__l('Manual payment process has been completed.') , 'default', null, 'success');
                            }
                        } else { // other payment gateways
                            $paymentGateway = $this->UserCashWithdrawal->User->MoneyTransferAccount->PaymentGateway->find('first', array(
                                'conditions' => array(
                                    'PaymentGateway.id' => $gateway
                                ) ,
                                'recursive' => -1
                            ));
                            $userCashWithdrawals = $this->UserCashWithdrawal->find('all', array(
                                'conditions' => array(
                                    'UserCashWithdrawal.id' => $list_id,
                                    'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Pending,
                                ) ,
                                'contain' => array(
                                    'User'
                                ) ,
                                'recursive' => 0
                            ));
                            $modelName = Inflector::camelize('mass_pay_' . strtolower($paymentGateway['PaymentGateway']['name']) . 'Adaptive');
                            APP::import('Model', 'Withdrawals.' . $modelName);
                            $this->obj = new $modelName();
                            $status = $this->obj->_transferAmount($list_id, 'UserCashWithdrawal');
                            if (!empty($status['error'])) {
                                $this->Session->setFlash($status['message'], 'default', null, 'error');
                            } else {
                                foreach($userCashWithdrawals as $userCashWithdrawal) {
                                    Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
                                        '_addTrans' => array(
                                            'order_id' => 'Withdrawal-' . $userCashWithdrawal['UserCashWithdrawal']['id'],
                                            'name' => $userCashWithdrawal['User']['username'],
                                            'total' => $userCashWithdrawal['UserCashWithdrawal']['amount']
                                        ) ,
                                        '_addItem' => array(
                                            'order_id' => 'Withdrawal-' . $userCashWithdrawal['UserCashWithdrawal']['id'],
                                            'sku' => 'W' . $userCashWithdrawal['UserCashWithdrawal']['id'],
                                            'name' => $userCashWithdrawal['User']['username'],
                                            'category' => '',
                                            'unit_price' => $userCashWithdrawal['UserCashWithdrawal']['amount']
                                        ) ,
                                        '_setCustomVar' => array(
                                            'ud' => $_SESSION['Auth']['User']['id'],
                                            'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
                                        )
                                    ));
                                }
                                $this->UserCashWithdrawal->onApprovedProcess($list_id, $status);
                                $this->Session->setFlash(sprintf(__l('Mass payment request is submitted in %s. User will be paid once process completed.') , strtolower($paymentGateway['PaymentGateway']['name'])) , 'default', null, 'success');
                            }
                        }
                    }
                }
            }
        }
        $this->redirect(array(
            'controller' => 'user_cash_withdrawals',
            'action' => 'index',
            'filter_id' => ConstWithdrawalStatus::Pending
        ));
    }
    public function admin_move_to($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $userCashWithdrawal = $this->UserCashWithdrawal->find('first', array(
            'conditions' => array(
                'UserCashWithdrawal.id' => $id,
                'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Approved,
            ) ,
            'contain' => array_values($massPaylogTables) ,
            'recursive' => 1
        ));
        if (empty($userCashWithdrawal)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->request->params['named']['type'] == 'success') {
            $userCashWithdrawal_response['mc_fee'] = 0;
            $userCashWithdrawal_response['mc_gross'] = 0;
            $this->UserCashWithdrawal->onSuccessProcess($userCashWithdrawal, $userCashWithdrawal_response);
        } elseif ($this->request->params['named']['type'] == 'failed') {
            $this->UserCashWithdrawal->onFailedProcess($userCashWithdrawal);
        }
        $this->Session->setFlash(sprintf(__l('Withdrawal has been successfully moved to %s') , $this->request->params['named']['type']) , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'user_cash_withdrawals',
            'action' => 'index',
            'filter_id' => ConstWithdrawalStatus::Approved
        ));
    }
}
?>