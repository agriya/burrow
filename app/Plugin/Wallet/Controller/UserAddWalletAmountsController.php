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
class UserAddWalletAmountsController extends AppController
{
    public $name = 'UserAddWalletAmounts';
    public function admin_index()
    {
        $this->pageTitle = __l('User Add Wallet Amounts');
        $this->UserAddWalletAmount->recursive = 0;
        $this->set('userAddWalletAmounts', $this->paginate());
    }
    public function admin_add_fund($user_id = null)
    {
        $this->pageTitle = sprintf(__l('Add %s'), __l('Fund'));
        if (!empty($this->request->data['UserAddWalletAmount']['user_id'])) {
            $user_id = $this->request->data['UserAddWalletAmount']['user_id'];
        }
        if (is_null($user_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $user = $this->UserAddWalletAmount->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $user['User']['username'];
        if (!empty($this->request->data)) {
			$this->UserAddWalletAmount->set($this->request->data);
			$this->request->data['UserAddWalletAmount']['is_success'] = 1;
			if ($this->UserAddWalletAmount->validates()) {
				if ($this->UserAddWalletAmount->save()) {
					$this->UserAddWalletAmount->User->updateAll(array(
						'User.available_wallet_amount' => 'User.available_wallet_amount +' . $this->request->data['UserAddWalletAmount']['amount']
					) , array(
						'User.id' => $this->request->data['UserAddWalletAmount']['user_id']
					));
					$this->UserAddWalletAmount->User->Transaction->log($this->UserAddWalletAmount->id, 'Wallet.UserAddWalletAmount', ConstPaymentGateways::ManualPay, ConstTransactionTypes::AdminAddFundToWallet);
					$this->Session->setFlash(sprintf(__l('%s has been added'), __l('Fund')), 'default', null, 'success');
					$this->redirect(array(
						'controller' => 'users',
						'action' => 'index'
					));
				} else {
					$this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('Fund')), 'default', null, 'error');
				}
			} else {
				$this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('Fund')), 'default', null, 'error');
			}
        }
		$this->request->data['UserAddWalletAmount']['user_id'] = $user_id;
        $this->set('user', $user);
    }
    public function admin_deduct_fund($user_id = null)
    {
        $this->pageTitle = __l('Deduct Fund');
        if (!empty($this->request->data['UserAddWalletAmount']['user_id'])) {
            $user_id = $this->request->data['UserAddWalletAmount']['user_id'];
        }
        if (is_null($user_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $user = $this->UserAddWalletAmount->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $user['User']['username'];
        if (!empty($this->request->data)) {
			if ($user['User']['available_wallet_amount'] < $this->request->data['UserAddWalletAmount']['amount']) {
				$this->Session->setFlash(__l('Deduct amount should be less than the available wallet amount') , 'default', null, 'error');
			} else {
				$this->UserAddWalletAmount->set($this->request->data);
				$this->request->data['UserAddWalletAmount']['is_success'] = 1;
				if ($this->UserAddWalletAmount->validates()) {
					if ($this->UserAddWalletAmount->save()) {
						$this->UserAddWalletAmount->User->updateAll(array(
							'User.available_wallet_amount' => 'User.available_wallet_amount -' . $this->request->data['UserAddWalletAmount']['amount'],
						) , array(
							'User.id' => $this->request->data['UserAddWalletAmount']['user_id']
						));
						$this->UserAddWalletAmount->User->Transaction->log($this->UserAddWalletAmount->id, 'Wallet.UserAddWalletAmount', ConstPaymentGateways::ManualPay, ConstTransactionTypes::AdminDeductFundFromWallet);
						$this->Session->setFlash(__l('Fund has been deducted') , 'default', null, 'success');
						$this->redirect(array(
							'controller' => 'users',
							'action' => 'index'
						));
					} else {
						$this->Session->setFlash(__l('Fund could not be deducted. Please, try again.') , 'default', null, 'error');
					}
				} else {
					$this->Session->setFlash(__l('Fund could not be deducted. Please, try again.') , 'default', null, 'error');
				}
            }
        }
		$this->request->data['UserAddWalletAmount']['user_id'] = $user_id;
        $this->set('user', $user);
    }
}
?>