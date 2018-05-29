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
class AffiliateCashWithdrawalsController extends AppController
{
    public $name = 'AffiliateCashWithdrawals';
    public function index() 
    {
        $this->pageTitle = __l('Affiliate Fund Withdrawal Request');
        $conditions = array();
        $conditions['AffiliateCashWithdrawal.user_id'] = $this->Auth->user('id');
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['Affiliate']['filter_id'] = $this->request->params['named']['filter_id'];
            $this->request->data['AffiliateCashWithdrawal']['affiliate_cash_withdrawal_status_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data['AffiliateCashWithdrawal']['affiliate_cash_withdrawal_status_id'])) {
            switch ($this->request->data['AffiliateCashWithdrawal']['affiliate_cash_withdrawal_status_id']) {
                case ConstAffiliateCashWithdrawalStatus::Pending:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Pending;
                    $this->pageTitle.= ' - ' . __l('Pending');
                    break;

                case ConstAffiliateCashWithdrawalStatus::Approved:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Approved;
                    $this->pageTitle.= ' - ' . __l('Accepted');
                    break;

                case ConstAffiliateCashWithdrawalStatus::Rejected:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Rejected;
                    $this->pageTitle.= ' - ' . __l('Rejected');
                    break;

                case ConstAffiliateCashWithdrawalStatus::Success:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Success;
                    $this->pageTitle.= ' - ' . __l('Paid');
                    break;
            }
            $this->request->params['named']['filter_id'] = $this->request->data['Affiliate']['filter_id'];
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.username'
                    )
                ) ,
                'AffiliateCashWithdrawalStatus' => array(
                    'fields' => array(
                        'AffiliateCashWithdrawalStatus.name',
                        'AffiliateCashWithdrawalStatus.id'
                    )
                )
            ) ,
            'order' => array(
                'AffiliateCashWithdrawal.id' => 'desc'
            ) ,
            'recursive' => 0
        );
        $moneyTransferAccounts = $this->AffiliateCashWithdrawal->User->MoneyTransferAccount->find('count', array(
            'conditions' => array(
                'MoneyTransferAccount.user_id' => $this->Auth->User('id') ,
            ) ,
            'recursive' => 0
        ));
        $user = $this->AffiliateCashWithdrawal->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->User('id') ,
            ) ,
            'recursive' => -1
        ));
        $this->set('user', $user);
        $this->set('moneyTransferAccounts', $moneyTransferAccounts);
        $this->request->data['AffiliateCashWithdrawal']['user_id'] = $this->Auth->user('id');
        $this->set('userCashWithdrawals', $this->paginate());
    }
    public function add() 
    {
        $this->pageTitle = sprintf(__l('Add %s') , __l('Affiliate Cash Withdrawal'));
        if (!empty($this->request->data)) {
            $affilate_transaction_fee_enabled = Configure::read('affiliate.site_commission_amount');
            if (!empty($affilate_transaction_fee_enabled)) {
                if (Configure::read('affiliate.site_commission_type') == 'percentage') {
                    $this->request->data['AffiliateCashWithdrawal']['commission_amount'] = ($this->request->data['AffiliateCashWithdrawal']['amount']*Configure::read('affiliate.site_commission_amount') /100);
                } else {
                    $this->request->data['AffiliateCashWithdrawal']['commission_amount'] = Configure::read('affiliate.site_commission_amount');
                }
            }
            $this->AffiliateCashWithdrawal->set($this->request->data);
            $this->AffiliateCashWithdrawal->validationErrors = array();
            if ($this->AffiliateCashWithdrawal->validates() &$this->AffiliateCashWithdrawal->validationErrors['amount'] = $this->AffiliateCashWithdrawal->_checkAmount($this->request->data['AffiliateCashWithdrawal']['amount'])) {
                $this->request->data['AffiliateCashWithdrawal']['affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Pending;
                $this->request->data['AffiliateCashWithdrawal']['modified'] = date('Y-m-d');
                $this->AffiliateCashWithdrawal->create();
                if ($this->AffiliateCashWithdrawal->save($this->request->data)) {
                    $this->AffiliateCashWithdrawal->User->Transaction->log($this->AffiliateCashWithdrawal->getLastInsertId() , 'Affiliates.AffiliateCashWithdrawal', ConstPaymentGateways::ManualPay, ConstTransactionTypes::AffiliateCashWithdrawalRequest);
                    $this->AffiliateCashWithdrawal->User->updateAll(array(
                        'User.commission_line_amount' => 'User.commission_line_amount -' . $this->request->data['AffiliateCashWithdrawal']['amount']
                    ) , array(
                        'User.id' => $this->request->data['AffiliateCashWithdrawal']['user_id']
                    )); //
                    $this->AffiliateCashWithdrawal->User->updateAll(array(
                        'User.commission_withdraw_request_amount' => 'User.commission_withdraw_request_amount + ' . $this->request->data['AffiliateCashWithdrawal']['amount']
                    ) , array(
                        'User.id' => $this->request->data['AffiliateCashWithdrawal']['user_id']
                    ));
                    $this->Session->setFlash(sprintf(__l('%s has been added') , __l('Affiliate cash withdrawal request')) , 'default', null, 'success');
                    $ajax_url = Router::url(array(
                        'controller' => 'affiliate_cash_withdrawals',
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
                    $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Affiliate cash withdrawal request')) , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Affiliate cash withdrawal request')) , 'default', null, 'error');
            }
        } else {
            $this->request->data['AffiliateCashWithdrawal']['user_id'] = $this->Auth->user('id');
        }
    }
    public function admin_index() 
    {
        if (!isPluginEnabled('Withdrawals')) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $title = '';
        $conditions = array();
        $this->_redirectGET2Named(array(
            'filter_id',
            'q',
            'account_id',
        ));
        $this->pageTitle = __l('Withdraw Fund Requests - from Affiliates');
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['AffiliateCashWithdrawal']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!isset($this->request->params['named']['filter_id']) && !isset($this->request->params['named']['filter_id'])) {
            $this->request->data['AffiliateCashWithdrawal']['filter_id'] = $this->request->params['named']['filter_id'] = 1;
        }
        if (!empty($this->request->data['AffiliateCashWithdrawal']['filter_id']) && $this->request->data['AffiliateCashWithdrawal']['filter_id'] != 'all') {
            $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = $this->request->data['AffiliateCashWithdrawal']['filter_id'];
            $status = $this->AffiliateCashWithdrawal->AffiliateCashWithdrawalStatus->find('first', array(
                'conditions' => array(
                    'AffiliateCashWithdrawalStatus.id' => $this->request->data['AffiliateCashWithdrawal']['filter_id'],
                ) ,
                'fields' => array(
                    'AffiliateCashWithdrawalStatus.name'
                ) ,
                'recursive' => -1
            ));
            $title = $status['AffiliateCashWithdrawalStatus']['name'];
        }
        if (!empty($this->request->data['AffiliateCashWithdrawal']['filter_id'])) {
            switch ($this->request->data['AffiliateCashWithdrawal']['filter_id']) {
                case ConstAffiliateCashWithdrawalStatus::Pending:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Pending;
                    $this->pageTitle.= ' - ' . __l('Pending');
                    break;

                case ConstAffiliateCashWithdrawalStatus::Approved:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Approved;
                    $this->pageTitle.= ' - ' . __l('Under Process');
                    break;

                case ConstAffiliateCashWithdrawalStatus::Rejected:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Rejected;
                    $this->pageTitle.= ' - ' . __l('Rejected');
                    break;

                case ConstAffiliateCashWithdrawalStatus::Success:
                    $conditions['AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id'] = ConstAffiliateCashWithdrawalStatus::Success;
                    $this->pageTitle.= ' - ' . __l('Success');
                    break;
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                    'fields' => array(
                        'User.username',
                    ) ,
                    'MoneyTransferAccount' => array(
                        'fields' => array(
                            'MoneyTransferAccount.id',
                            'MoneyTransferAccount.payment_gateway_id'
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
                'AffiliateCashWithdrawalStatus' => array(
                    'fields' => array(
                        'AffiliateCashWithdrawalStatus.name',
                        'AffiliateCashWithdrawalStatus.id',
                    )
                )
            ) ,
            'order' => array(
                'AffiliateCashWithdrawal.id' => 'desc'
            ) ,
            'recursive' => 3,
        );
        $AffiliateCashWithdrawalStatuses = $this->AffiliateCashWithdrawal->AffiliateCashWithdrawalStatus->find('all', array(
            'recursive' => -1
        ));
        $this->set('AffiliateCashWithdrawalStatuses', $AffiliateCashWithdrawalStatuses);
        $paymentGateways = $this->AffiliateCashWithdrawal->User->MoneyTransferAccount->PaymentGateway->find('all', array(
            'conditions' => array(
                'PaymentGateway.is_mass_pay_enabled' => 1
            ) ,
            'recursive' => -1
        ));
        $this->set('paymentGateways', $paymentGateways);
        $moreActions = $this->AffiliateCashWithdrawal->moreActions;
        if (!empty($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Pending)) {
            unset($moreActions[ConstAffiliateCashWithdrawalStatus::Pending]);
        }
        $this->set('moreActions', $moreActions);
        $this->set('affiliateCashWithdrawals', $this->paginate());
        $this->set('approved', $this->AffiliateCashWithdrawal->find('count', array(
            'conditions' => array(
                'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id' => ConstAffiliateCashWithdrawalStatus::Approved,
            ) ,
            'recursive' => -1
        )));
        $this->set('success', $this->AffiliateCashWithdrawal->find('count', array(
            'conditions' => array(
                'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id' => ConstAffiliateCashWithdrawalStatus::Success,
            ) ,
            'recursive' => -1
        )));
        $this->set('pending', $this->AffiliateCashWithdrawal->find('count', array(
            'conditions' => array(
                'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id' => ConstAffiliateCashWithdrawalStatus::Pending,
            ) ,
            'recursive' => -1
        )));
        $this->set('rejected', $this->AffiliateCashWithdrawal->find('count', array(
            'conditions' => array(
                'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id' => ConstAffiliateCashWithdrawalStatus::Rejected,
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
        if ($this->AffiliateCashWithdrawal->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Affiliate cash withdrawal')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_update() 
    {
        if (!empty($this->request->data['AffiliateCashWithdrawal'])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $userCashWithdrawalIds = array();
            foreach($this->request->data['AffiliateCashWithdrawal'] as $userCashWithdrawal_id => $is_checked) {
                if ($is_checked['id']) {
                    $userCashWithdrawalIds[] = $userCashWithdrawal_id;
                }
            }
            if ($actionid && !empty($userCashWithdrawalIds)) {
                if ($actionid == ConstAffiliateCashWithdrawalStatus::Pending) {
                    $this->AffiliateCashWithdrawal->updateAll(array(
                        'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id' => ConstAffiliateCashWithdrawalStatus::Pending
                    ) , array(
                        'AffiliateCashWithdrawal.id' => $userCashWithdrawalIds
                    ));
                    $this->Session->setFlash(__l('Checked requests have been moved to pending status') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'affiliate_cash_withdrawals',
                        'action' => 'index'
                    ));
                } else if ($actionid == ConstAffiliateCashWithdrawalStatus::Rejected) {
                    // Need to Refund the Money to User
                    $canceled_withdraw_requests = $this->AffiliateCashWithdrawal->find('all', array(
                        'conditions' => array(
                            'AffiliateCashWithdrawal.id' => $userCashWithdrawalIds
                        ) ,
                        'recursive' => -1
                    ));
                    // Updating user balance
                    foreach($canceled_withdraw_requests as $canceled_withdraw_request) {
                        // Updating transactions
                        if (!empty($canceled_withdraw_request)) {
                            $this->AffiliateCashWithdrawal->User->Transaction->log($canceled_withdraw_request['AffiliateCashWithdrawal']['id'], 'Affiliates.AffiliateCashWithdrawal', ConstPaymentGateways::ManualPay, ConstTransactionTypes::AffiliateCashWithdrawalRequestRejected);
                        }
                        // Addding to user's Available Balance
                        $this->AffiliateCashWithdrawal->User->updateAll(array(
                            'User.commission_line_amount' => 'User.commission_line_amount +' . $canceled_withdraw_request['AffiliateCashWithdrawal']['amount']
                        ) , array(
                            'User.id' => $canceled_withdraw_request['AffiliateCashWithdrawal']['user_id']
                        ));
                        // Deducting user's Available Balance
                        $this->AffiliateCashWithdrawal->User->updateAll(array(
                            'User.commission_withdraw_request_amount' => 'User.commission_withdraw_request_amount -' . $canceled_withdraw_request['AffiliateCashWithdrawal']['amount']
                        ) , array(
                            'User.id' => $canceled_withdraw_request['AffiliateCashWithdrawal']['user_id']
                        ));
                        $this->AffiliateCashWithdrawal->updateAll(array(
                            'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id' => ConstAffiliateCashWithdrawalStatus::Rejected
                        ) , array(
                            'AffiliateCashWithdrawal.id' => $canceled_withdraw_request['AffiliateCashWithdrawal']['id']
                        ));
                    }
                    //
                    $this->Session->setFlash(__l('Checked requests have been moved to rejected status, Amount sent back tot the users.') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'affiliate_cash_withdrawals',
                        'action' => 'index',
                        'filter_id' => ConstAffiliateCashWithdrawalStatus::Pending
                    ));
                } else if ($actionid == ConstWithdrawalStatus::Approved) {
                    $paymentGateways = $this->AffiliateCashWithdrawal->User->MoneyTransferAccount->PaymentGateway->find('list', array(
                        'conditions' => array(
                            'PaymentGateway.is_mass_pay_enabled' => 1
                        ) ,
                        'fields' => array(
                            'PaymentGateway.id',
                            'PaymentGateway.name',
                        ) ,
                        'recursive' => -1
                    ));
                    $conditions['AffiliateCashWithdrawal.id'] = $userCashWithdrawalIds;
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
                            'AffiliateCashWithdrawalStatus' => array(
                                'fields' => array(
                                    'AffiliateCashWithdrawalStatus.name',
                                    'AffiliateCashWithdrawalStatus.id',
                                )
                            )
                        ) ,
                        'order' => array(
                            'AffiliateCashWithdrawal.id' => 'desc'
                        ) ,
                        'recursive' => 3,
                    );
                    $affiliateCashWithdrawals = $this->paginate();
                    foreach($affiliateCashWithdrawals as $key => $affiliateCashWithdrawal) {
                        $payment_gates = array();
                        $payment_gates[ConstPaymentGateways::ManualPay] = __l('Mark as paid/manual');
                        if (!empty($affiliateCashWithdrawal['User']['MoneyTransferAccount'])) {
                            foreach($affiliateCashWithdrawal['User']['MoneyTransferAccount'] as $gateway) {
                                $payment_gates[$gateway['payment_gateway_id']] = __l('Pay via ') . $gateway['PaymentGateway']['display_name'] . ' ' . __l('API') . ' (' . substr($gateway['account'], 0, 10) . '...)';
                                if ($gateway['is_default'] == 1) {
                                    $this->request->data['AffiliateCashWithdrawal'][$key]['gateways'] = $gateway['payment_gateway_id'];
                                }
                            }
                        }
                        foreach($payment_gates as $id => $name) {
                            if (ConstPaymentGateways::ManualPay != $id && empty($paymentGateways[$id])) {
                                unset($payment_gates[$id]);
                            }
                        }
                        $affiliateCashWithdrawals[$key]['paymentways'] = $payment_gates;
                    }
                    $this->pageTitle = __l('Withdraw Fund Requests - Approved');
                    $this->set('affiliateCashWithdrawals', $affiliateCashWithdrawals);
                    $this->render('admin_pay_to_user');
                }
            } else {
                $this->redirect(array(
                    'controller' => 'affiliate_cash_withdrawals',
                    'action' => 'index',
                    'filter_id' => ConstAffiliateCashWithdrawalStatus::Pending
                ));
            }
        } else {
            $this->redirect(array(
                'controller' => 'affiliate_cash_withdrawals',
                'action' => 'index',
                'filter_id' => ConstAffiliateCashWithdrawalStatus::Pending
            ));
        }
    }
    public function admin_pay_to_user() 
    {
        $this->pageTitle = __l('Withdraw Fund Requests - Approved');
        if (!empty($this->request->data)) {
            $approve_list = $approve_list_id = array();
            if (!empty($this->request->data['AffiliateCashWithdrawal'])) {
                foreach($this->request->data['AffiliateCashWithdrawal'] as $list) {
                    $approve_list[$list['gateways']][$list['id']] = $list;
                    $approve_list_id[$list['gateways']][] = $list['id'];
                }
                if (!empty($approve_list)) {
                    foreach($approve_list_id as $gateway => $list_id) {
                        if ($gateway == ConstPaymentGateways::ManualPay) { // manual pay
                            $affiliateCashWithdrawals = $this->AffiliateCashWithdrawal->find('all', array(
                                'conditions' => array(
                                    'AffiliateCashWithdrawal.id' => $list_id,
                                    'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id' => ConstWithdrawalStatus::Pending,
                                ) ,
                                'recursive' => -1
                            ));
                            foreach($affiliateCashWithdrawals as $affiliateCashWithdrawal) {
                                $logTableData = array();
                                $affiliateCashWithdrawal_response['mc_fee'] = 0;
                                $affiliateCashWithdrawal_response['mc_gross'] = $affiliateCashWithdrawal['AffiliateCashWithdrawal']['amount'];
                                $affiliateCashWithdrawal['AffiliateCashWithdrawal']['description'] = $approve_list[$gateway][$affiliateCashWithdrawal['AffiliateCashWithdrawal']['id']]['info'];
                                $this->AffiliateCashWithdrawal->onSuccessProcess($affiliateCashWithdrawal, $affiliateCashWithdrawal_response, $logTableData);
                                $this->Session->setFlash(__l('Manual payment process has been completed.') , 'default', null, 'success');
                            }
                        } else {
                            $paymentGateway = $this->AffiliateCashWithdrawal->User->MoneyTransferAccount->PaymentGateway->find('first', array(
                                'conditions' => array(
                                    'PaymentGateway.id' => $gateway
                                ) ,
                                'recursive' => -1
                            ));
                            $modelName = Inflector::camelize('mass_pay_' . strtolower($paymentGateway['PaymentGateway']['name']) . 'Adaptive');
                            APP::import('Model', 'Withdrawals.' . $modelName);
                            $this->obj = new $modelName();
                            $status = $this->obj->_transferAmount($list_id, 'AffiliateCashWithdrawal');
                            if (!empty($status['error'])) {
                                $this->Session->setFlash($status['message'], 'default', null, 'error');
                            } else {
                                $this->AffiliateCashWithdrawal->onApprovedProcess($list_id, $status);
                                $this->Session->setFlash(sprintf(__l('Mass payment request is submitted in %s. User will be paid once process completed.') , strtolower($paymentGateway['PaymentGateway']['name'])) , 'default', null, 'success');
                            }
                        }
                    }
                }
            }
        }
        $this->redirect(array(
            'controller' => 'affiliate_cash_withdrawals',
            'action' => 'index',
            'filter_id' => ConstAffiliateCashWithdrawalStatus::Pending
        ));
    }
    public function admin_move_to($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $affiliateCashWithdrawal = $this->AffiliateCashWithdrawal->find('first', array(
            'conditions' => array(
                'AffiliateCashWithdrawal.id' => $id,
                'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id' => ConstAffiliateCashWithdrawalStatus::Approved,
            ) ,
            'recursive' => 1
        ));
        if (empty($affiliateCashWithdrawal)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->request->params['named']['type'] == 'success') {
            $logTableData['currency_id'] = $affiliateCashWithdrawal[$logTable]['currency_id'];
            $logTableData['converted_currency_id'] = $affiliateCashWithdrawal[$logTable]['converted_currency_id'];
            $logTableData['rate'] = $affiliateCashWithdrawal[$logTable]['rate'];
            $affiliateCashWithdrawal_response['mc_fee'] = 0;
            $affiliateCashWithdrawal_response['mc_gross'] = 0;
            $this->AffiliateCashWithdrawal->onSuccessProcess($affiliateCashWithdrawal, $affiliateCashWithdrawal_response);
        } elseif ($this->request->params['named']['type'] == 'failed') {
            $this->AffiliateCashWithdrawal->onFailedProcess($affiliateCashWithdrawal);
        }
        $this->Session->setFlash(sprintf(__l('Withdrawal has been successfully moved to %s') , $this->request->params['named']['type']) , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'affiliate_cash_withdrawals',
            'action' => 'index',
            'filter_id' => ConstAffiliateCashWithdrawalStatus::Approved
        ));
    }
}
?>