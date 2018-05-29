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
class TransactionsController extends AppController
{
    public $name = 'Transactions';
	public $permanentCacheAction = array(
		'user' => array(
			'index',
		) ,
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Transaction.from_date',
            'Transaction.to_date',
            'Transaction.user_id',
            'User.username',
            'ProeprtyUser.Id',
            'Property.title',
            'Property.id',
        );
        parent::beforeFilter();
    }
    public function index()
    {
        $this->pageTitle = __l('My Transactions');
        $blocked_conditions['UserCashWithdrawal.user_id'] = $conditions['OR']['Transaction.receiver_user_id'] = $conditions['OR']['Transaction.user_id'] = $this->Auth->user('id');
        if (!empty($this->request->params['named']['from_date']) && !empty($this->request->params['named']['to_date'])) {
            list($this->request->data['Transaction']['from_date']['year'], $this->request->data['Transaction']['from_date']['month'], $this->request->data['Transaction']['from_date']['day']) = explode('-', $this->request->params['named']['from_date']);
            list($this->request->data['Transaction']['to_date']['year'], $this->request->data['Transaction']['to_date']['month'], $this->request->data['Transaction']['to_date']['day']) = explode('-', $this->request->params['named']['to_date']);
        }
        if (!empty($this->request->data['Transaction']['from_date']) && !empty($this->request->data['Transaction']['to_date'])) {
            $from = $this->request->data['Transaction']['from_date'];
            $to = $this->request->data['Transaction']['to_date'];
            $from_date = mktime(0, 0, 0, $from['month'], $from['day'], $from['year']);
            $to_date = mktime(0, 0, 0, $to['month'], $to['day'], $to['year']);
            if ($from_date <= $to_date) {
                $blocked_conditions['UserCashWithdrawal.created >='] = $conditions['Transaction.created >='] = $credit_conditions['Transaction.created >='] = $debit_conditions['Transaction.created >='] = $this->request->data['Transaction']['from_date']['year'] . '-' . $this->request->data['Transaction']['from_date']['month'] . '-' . $this->request->data['Transaction']['from_date']['day'] . ' 00:00:00';
                $blocked_conditions['UserCashWithdrawal.created <='] = $conditions['Transaction.created <='] = $credit_conditions['Transaction.created <='] = $debit_conditions['Transaction.created <='] = $this->request->data['Transaction']['to_date']['year'] . '-' . $this->request->data['Transaction']['to_date']['month'] . '-' . $this->request->data['Transaction']['to_date']['day'] . ' 23:59:59';
                $this->request->params['named']['from_date'] = $this->request->data['Transaction']['from_date']['year'] . '-' . $this->request->data['Transaction']['from_date']['month'] . '-' . $this->request->data['Transaction']['from_date']['day'];
                $this->request->params['named']['to_date'] = $this->request->data['Transaction']['to_date']['year'] . '-' . $this->request->data['Transaction']['to_date']['month'] . '-' . $this->request->data['Transaction']['to_date']['day'];
            } else {
                $this->Session->setFlash(__l('To date should greater than From date. Please, try again.') , 'default', null, 'error');
            }
        }
        if (!empty($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $credit_conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $debit_conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' - today');
        }
        if (!empty($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $credit_conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $debit_conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - in this week');
        }
        if (!empty($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['Transaction.created >='] = $credit_conditions['Transaction.created >='] = $debit_conditions['Transaction.created >='] = date("Y-01-01");
            $conditions['Transaction.created <='] = $credit_conditions['Transaction.created <='] = $debit_conditions['Transaction.created <='] = date("Y-12-31");
            $conditions['Transaction.created >='] = $credit_conditions['Transaction.created >='] = $debit_conditions['Transaction.created >='] = date("Y-m-01");
            $conditions['Transaction.created <='] = $credit_conditions['Transaction.created <='] = $debit_conditions['Transaction.created <='] = date("Y-m-t");
            $this->pageTitle.= __l(' - in this month');
        }
        $this->paginate = array(
			'conditions' => $conditions,
			'contain' => array(
				'TransactionType',
				'User' => array(
					'fields' => array(
						'User.id',
						'User.username',
					)
				) ,
				'Property' => array(
					'User' => array(
						'fields' => array(
							'User.id',
							'User.username',
						)
					) ,
					'fields' => array(
						'Property.id',
						'Property.title',
						'Property.slug',
					)
				) ,
				'PropertyUser' => array(
					'Property' => array(
						'User' => array(
							'fields' => array(
								'User.id',
								'User.username',
							)
						) ,
						'fields' => array(
							'Property.id',
							'Property.title',
							'Property.slug',
						)
					) ,
					'User' => array(
						'fields' => array(
							'User.id',
							'User.username',
						)
					) ,
					'fields' => array(
						'PropertyUser.id',
						'PropertyUser.traveler_service_amount',
						'PropertyUser.host_service_amount',
						'PropertyUser.price',
						'PropertyUser.security_deposit',
					)
				) ,
			) ,
			'order' => array(
				'Transaction.id' => 'desc'
			) ,
			'recursive' => 3
		);
        $transactions = $this->paginate();
        $this->set('transactions', $transactions);
        $credit_conditions['OR'][] = array(
            'Transaction.user_id' => $this->Auth->user('id') ,
            'TransactionType.is_credit' => 1
        );
        $credit_conditions['OR'][] = array(
            'Transaction.receiver_user_id' => $this->Auth->user('id') ,
            'TransactionType.is_credit_to_receiver' => 1
        );
        $debit_conditions['OR'][] = array(
            'Transaction.user_id' => $this->Auth->user('id') ,
            'TransactionType.is_credit' => 0
        );
		$dr_conditions = $conditions;
        unset($dr_conditions['OR']);
        $credit = $this->Transaction->find('first', array(
            'conditions' => array(
                $conditions,
                $credit_conditions,
				'NOT' => array('Transaction.transaction_type_id' => array(
                        ConstTransactionTypes::CashWithdrawalRequest,
						ConstTransactionTypes::CashWithdrawalRequestPaid,
						ConstTransactionTypes::CashWithdrawalRequestRejected,
						ConstTransactionTypes::CashWithdrawalRequestApproved,
						ConstTransactionTypes::CashWithdrawalRequestFailed,
                    ))
            ) ,
            'fields' => array(
                'SUM(Transaction.amount) as total_amount'
            ) ,
            'recursive' => 0
        ));
        $credit1 = !empty($credit[0]['total_amount']) ? $credit[0]['total_amount'] : 0;
        $debit = $this->Transaction->find('first', array(
            'conditions' => array(
                $dr_conditions,
                $debit_conditions,
				'NOT' => array('Transaction.transaction_type_id' => array(
                        ConstTransactionTypes::CashWithdrawalRequest,
						ConstTransactionTypes::CashWithdrawalRequestPaid,
						ConstTransactionTypes::CashWithdrawalRequestRejected,
						ConstTransactionTypes::CashWithdrawalRequestApproved,
						ConstTransactionTypes::CashWithdrawalRequestFailed,
                    ))
            ) ,
            'fields' => array(
                'SUM(Transaction.amount) as total_amount'
            ) ,
            'recursive' => 0
        ));
        $debit1 = !empty($debit[0]['total_amount']) ? $debit[0]['total_amount'] : 0;
        $debit2 = $credit2 = 0;
        if (isPluginEnabled('Withdrawals')) {
            $withdrawalTransactions = $this->Transaction->find('all', array(
                'conditions' => array(
                    $conditions,
                    'Transaction.transaction_type_id' => array(
                        ConstTransactionTypes::CashWithdrawalRequest,
						ConstTransactionTypes::CashWithdrawalRequestPaid,
						ConstTransactionTypes::CashWithdrawalRequestRejected,
						ConstTransactionTypes::CashWithdrawalRequestApproved,
						ConstTransactionTypes::CashWithdrawalRequestFailed,
                    )
                ) ,
                'fields' => array(
                    'DISTINCT(Transaction.foreign_id)'
                ) ,
                'recursive' => 0
            ));
            if (!empty($withdrawalTransactions)) {
                $userCashWithdrawalIds = array();
                foreach($withdrawalTransactions as $withdrawalTransaction) {
                    $userCashWithdrawalIds[] = $withdrawalTransaction['Transaction']['foreign_id'];
                }
                $this->loadModel('Withdrawals.UserCashWithdrawal');
                $userCashWithdrawals = $this->UserCashWithdrawal->find('all', array(
                    'conditions' => array(
                        'UserCashWithdrawal.id' => $userCashWithdrawalIds
                    ) ,
                    'fields' => array(
                        'UserCashWithdrawal.amount',
                        'UserCashWithdrawal.withdrawal_status_id',
                    ) ,
                    'recursive' => -1
                ));
                foreach($userCashWithdrawals as $userCashWithdrawal) {
                    if (in_array($userCashWithdrawal['UserCashWithdrawal']['withdrawal_status_id'], array(
                        ConstWithdrawalStatus::Rejected
                    ))) {
                        $credit2+= $userCashWithdrawal['UserCashWithdrawal']['amount'];
                    } else {
                        $debit2+= $userCashWithdrawal['UserCashWithdrawal']['amount'];
                    }
                }
            }
        }
        $this->set('total_credit_amount', $credit1+$credit2);
        $this->set('total_debit_amount', $debit1+$debit2);
        $from = $this->Transaction->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'Transaction.created'
            ) ,
            'limit' => 1,
            'order' => array(
                'Transaction.created asc'
            ) ,
            'recursive' => 0
        ));
        $to = $this->Transaction->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'Transaction.created'
            ) ,
            'limit' => 1,
            'order' => array(
                'Transaction.created desc'
            ) ,
            'recursive' => 0
        ));
        $this->set('duration_from', $from['Transaction']['created']);
        $this->set('duration_to', $to['Transaction']['created']);
        if (isPluginEnabled('Wallet') && isPluginEnabled('Withdrawals')) {
            $blocked_amount = $this->Transaction->User->UserCashWithdrawal->find('first', array(
                'conditions' => $blocked_conditions,
                'fields' => array(
                    'SUM(UserCashWithdrawal.amount) as total_amount'
                ) ,
                'group' => array(
                    'UserCashWithdrawal.user_id'
                ) ,
                'recursive' => 0
            ));
            $this->set('blocked_amount', !empty($blocked_amount[0]['total_amount']) ? $blocked_amount[0]['total_amount'] : 0);
        }
        $filter = array(
            'all' => __l('All') ,
            'day' => __l('Today') ,
            'week' => __l('This Week') ,
            'month' => __l('This Month') ,
            'custom' => __l('Custom') ,
        );
        if ($this->RequestHandler->isAjax()) {
            $this->set('isAjax', true);
        } else {
            $this->set('isAjax', false);
        }
        $this->set('filter', $filter);
        if (empty($this->request->data['Transaction']['from_date'])) {
            $this->request->data['Transaction']['from_date'] = date('Y-m-d', strtotime('-90 days'));
        }
        if (empty($this->request->data['Transaction']['to_date'])) {
            $this->request->data['Transaction']['to_date'] = date('Y-m-d');
        }
    }
    public function admin_index()
    {
		$this->Transaction->User->validate = array();
		$conditions = array();
		$this->pageTitle = __l('Transactions');
		if (empty($this->request->data['Transaction']['user_id']) && !empty($this->request->data['Transaction']['username'])) {
			$users = $this->Transaction->User->find('list', array(
				'conditions' => array(
					'User.username LIKE' => '%' . $this->request->data['Transaction']['username'] . '%',
				) ,
				'fields' => array(
					'User.id'
				) ,
				'recursive' => -1
			));
			if (!empty($users)) {
				$this->request->params['named']['user_id'] = array_values($users);
			}
		}
		if (!empty($this->request->data['Transaction']['user_id'])) {
			$this->request->params['named']['user_id'] = $this->request->data['Transaction']['user_id'];
		}
		if (!empty($this->request->data['Property']['title'])) {
			$properties = $this->Transaction->Property->find('list', array(
				'conditions' => array(
					'Property.title LIKE' => '%' . $this->request->data['Property']['title'] . '%',
				) ,
				'fields' => array(
					'Property.id'
				) ,
				'recursive' => -1
			));
			if (!empty($properties)) {
				$this->request->params['named']['property_id'] = array_values($properties);
			}
		}
		if (!empty($this->request->data['Transaction']['property_id'])) {
			$this->request->params['named']['property_id'] = $this->request->data['Transaction']['property_id'];
		}
		if (!empty($this->request->data['PropertyUser']['Id'])) {
			$conditions['Transaction.foreign_id'] = $this->request->data['PropertyUser']['Id'];
			$conditions['Transaction.class'] = 'PropertyUser';
		}
		if (!empty($this->request->params['named']['user_id'])) {
			$conditions['OR']['Transaction.user_id'] = $conditions['OR']['Transaction.receiver_user_id'] = $this->request->params['named']['user_id'];
			$credit_conditions['OR']['Transaction.receiver_user_id'] = $this->request->params['named']['user_id'];
			$credit_conditions['OR']['Transaction.user_id'] = $this->request->params['named']['user_id'];
			$debit_conditions['OR']['Transaction.user_id'] = $this->request->params['named']['user_id'];
			$debit_conditions['OR']['Transaction.receiver_user_id'] = $this->request->params['named']['user_id'];
		}
		if (!empty($this->request->params['named']['property_id'])) {
			$conditions['OR'][] = array(
				'Transaction.foreign_id' => $this->request->params['named']['property_id'],
				'Transaction.class' => 'Property'
			);
			$property_users = $this->Transaction->PropertyUser->find('list', array(
				'conditions' => array(
					'PropertyUser.property_id' => $this->request->params['named']['property_id'],
				) ,
				'fields' => array(
					'PropertyUser.id'
				) ,
				'recursive' => -1
			));
			if (!empty($property_users)) {
				$conditions['OR'][] = array(
					'Transaction.foreign_id' => array_values($property_users),
					'Transaction.class' => 'PropertyUser'
				);
			}
		}
		$this->set('credit_type', 'is_credit');
		$is_credit = 'is_credit';
		if (empty($this->request->params['named']['filter_id']) && empty($this->request->params['named']['user_id']) && empty($this->request->params['named']['property_id']) && empty($this->request->params['named']['from_date']) && empty($this->request->params['named']['to_date'])) {
			$is_credit = 'is_credit_to_admin';
			$this->set('credit_type', 'is_credit_to_admin');
			if(empty($this->request->data['Transaction']['filter_id'])){
				$conditions['OR'][]['Transaction.user_id'] = ConstUserIds::Admin;
				$credit_conditions['OR'][]['Transaction.user_id'] = ConstUserIds::Admin;
				$debit_conditions['OR'][]['Transaction.user_id'] = ConstUserIds::Admin;
			}
		}
		$credit_conditions['TransactionType.' . $is_credit] = 1;
		$debit_conditions['TransactionType.' . $is_credit] = 0;
		if (!empty($this->request->params['named']['from_date']) && !empty($this->request->params['named']['to_date'])) {
			list($this->request->data['Transaction']['from_date']['year'], $this->request->data['Transaction']['from_date']['month'], $this->request->data['Transaction']['from_date']['day']) = explode('-', $this->request->params['named']['from_date']);
			list($this->request->data['Transaction']['to_date']['year'], $this->request->data['Transaction']['to_date']['month'], $this->request->data['Transaction']['to_date']['day']) = explode('-', $this->request->params['named']['to_date']);
		}
		if(!empty($this->request->params['named']['filter_id'])){
			$this->request->data['Transaction']['filter_id']=$this->request->params['named']['filter_id'];
		}
		if (!empty($this->request->data['Transaction']['from_date']['year']) || !empty($this->request->data['Transaction']['to_date']['year'])) {
			$from = $this->request->data['Transaction']['from_date'];
			$to = $this->request->data['Transaction']['to_date'];
			$from_date = mktime(0, 0, 0, $from['month'], $from['day'], $from['year']);
			$to_date = mktime(0, 0, 0, $to['month'], $to['day'], $to['year']);
			if ($from_date <= $to_date) {
				if (!empty($this->request->data['Transaction']['from_date']['year'])) {
					$conditions['Transaction.created >='] = $this->request->data['Transaction']['from_date']['year'] . '-' . $this->request->data['Transaction']['from_date']['month'] . '-' . $this->request->data['Transaction']['from_date']['day'] . ' 00:00:00';
					if (!empty($this->request->params['named']['from_date']) && !empty($this->request->params['named']['to_date'])) {
						$credit_conditions['Transaction.created >='] = $this->request->params['named']['from_date'];
						$credit_conditions['Transaction.created <='] = $this->request->params['named']['to_date'];
						$debit_conditions['Transaction.created >='] = $this->request->params['named']['from_date'];
						$debit_conditions['Transaction.created <='] = $this->request->params['named']['to_date'];
					}
				} else {
				}
				if (!empty($this->request->data['Transaction']['to_date']['year'])) {
					$conditions['Transaction.created <='] = $this->request->data['Transaction']['to_date']['year'] . '-' . $this->request->data['Transaction']['to_date']['month'] . '-' . $this->request->data['Transaction']['to_date']['day'] . ' 23:59:59';
					if (!empty($this->request->params['named']['from_date']) && !empty($this->request->params['named']['to_date'])) {
						$credit_conditions['Transaction.created >='] = $this->request->params['named']['from_date'];
						$credit_conditions['Transaction.created <='] = $this->request->params['named']['to_date'];
						$debit_conditions['Transaction.created >='] = $this->request->params['named']['from_date'];
						$debit_conditions['Transaction.created <='] = $this->request->params['named']['to_date'];
					}
				} else {
				}
				$this->request->params['named']['from_date'] = $this->request->data['Transaction']['from_date']['year'] . '-' . $this->request->data['Transaction']['from_date']['month'] . '-' . $this->request->data['Transaction']['from_date']['day'];
				$this->request->params['named']['to_date'] = $this->request->data['Transaction']['to_date']['year'] . '-' . $this->request->data['Transaction']['to_date']['month'] . '-' . $this->request->data['Transaction']['to_date']['day'];
			} else {
				$this->Session->setFlash(__l('To date should greater than From date. Please, try again.') , 'default', null, 'error');
			}
		}
		if ($this->RequestHandler->prefers('csv')) {
            Configure::write('debug', 0);
            $this->set('transactions', $this);
            $this->set('conditions', $conditions);
        } else {
		$this->paginate = array(
			'conditions' => $conditions,
			'contain' => array(
				'TransactionType',
				'User' => array(
					'fields' => array(
						'User.id',
						'User.username',
						'User.role_id',
						'User.facebook_user_id',
						'User.attachment_id',
					)
				) ,
				'Property' => array(
					'User' => array(
						'fields' => array(
							'User.id',
							'User.username',
							'User.role_id',
							'User.facebook_user_id',
							'User.attachment_id',
						)
					) ,
					'fields' => array(
						'Property.id',
						'Property.title',
						'Property.slug',
					)
				) ,
				'PropertyUser' => array(
					'Property' => array(
						'User' => array(
							'fields' => array(
								'User.id',
								'User.username',
								'User.role_id',
								'User.facebook_user_id',
								'User.attachment_id',
							)
						) ,
						'fields' => array(
							'Property.id',
							'Property.title',
							'Property.slug',
						)
					) ,
					'User' => array(
						'fields' => array(
							'User.id',
							'User.username',
							'User.role_id',
							'User.facebook_user_id',
							'User.attachment_id',
						)
					) ,
					'fields' => array(
						'PropertyUser.id',
						'PropertyUser.traveler_service_amount',
						'PropertyUser.host_service_amount',
						'PropertyUser.price',
						'PropertyUser.security_deposit',
					)
				) ,
			) ,
			'order' => array(
				'Transaction.id' => 'desc'
			) ,
			'recursive' => 3
		);
		$this->set('transactions', $this->paginate());
		$credit = $this->Transaction->find('first', array(
			'conditions' => $credit_conditions,
			'fields' => array(
				'SUM(Transaction.amount) as total_amount'
			) ,
			'recursive' => 0
		));
		$credit1 = !empty($credit[0]['total_amount']) ? $credit[0]['total_amount'] : 0;
		$debit = $this->Transaction->find('first', array(
			'conditions' => $debit_conditions,
			'fields' => array(
				'SUM(Transaction.amount) as total_amount'
			) ,
			'recursive' => 0
		));
		$debit1 = !empty($debit[0]['total_amount']) ? $debit[0]['total_amount'] : 0;
		$debit2 = $credit2 = 0;
		if (isPluginEnabled('Withdrawals')) {
			$withdrawalTransactions = $this->Transaction->find('all', array(
				'conditions' => array(
					$conditions,
					'Transaction.transaction_type_id' => array(
						ConstTransactionTypes::CashWithdrawalRequest,
						ConstTransactionTypes::CashWithdrawalRequestPaid,
						ConstTransactionTypes::CashWithdrawalRequestRejected,
						ConstTransactionTypes::CashWithdrawalRequestApproved,
						ConstTransactionTypes::CashWithdrawalRequestFailed,
					)
				) ,
				'fields' => array(
					'DISTINCT(Transaction.foreign_id)'
				) ,
				'recursive' => 0
			));
			if (!empty($withdrawalTransactions)) {
				$userCashWithdrawalIds = array();
				foreach($withdrawalTransactions as $withdrawalTransaction) {
					if (!empty($withdrawalTransaction['Transaction']['foreign_id'])) {
						$userCashWithdrawalIds[] = $withdrawalTransaction['Transaction']['foreign_id'];
					}
				}
				$this->loadModel('Withdrawals.UserCashWithdrawal');
				$userCashWithdrawals = $this->UserCashWithdrawal->find('all', array(
					'conditions' => array(
						'UserCashWithdrawal.id' => $userCashWithdrawalIds
					) ,
					'fields' => array(
						'UserCashWithdrawal.amount',
						'UserCashWithdrawal.withdrawal_status_id',
					) ,
					'recursive' => -1
				));
				foreach($userCashWithdrawals as $userCashWithdrawal) {
					if (in_array($userCashWithdrawal['UserCashWithdrawal']['withdrawal_status_id'], array(
						ConstWithdrawalStatus::Rejected
					))) {
						$credit2+= $userCashWithdrawal['UserCashWithdrawal']['amount'];
					} else {
						$debit2+= $userCashWithdrawal['UserCashWithdrawal']['amount'];
					}
				}
			}
		}
		$this->set('total_credit_amount', $credit1+$credit2);
		$this->set('total_debit_amount', $debit1+$debit2);
		$this->Transaction->validate = array();
		$this->set('transactions', $this->paginate());
		}
	}
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Transaction->delete($id)) {
            $this->Session->setFlash(__l('Transaction deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>
