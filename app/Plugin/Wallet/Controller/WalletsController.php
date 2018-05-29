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
class WalletsController extends AppController
{
	public $components = array(
        'Email',
    );
	public $permanentCacheAction = array(
        'wallet' => array(
            'add_to_wallet',
        ) ,
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Wallet.send_to_user_id',
            'Wallet.referred_by_user_id',
            'Wallet.adaptive_normal',
            'Wallet.adaptive_connect',
            'Wallet.payment_type',
            'Wallet.is_show_new_card',
			'UserAddWalletAmount.normal',
            'UserAddWalletAmount.wallet',
            'UserAddWalletAmount.payment_gateway_id',
            'UserAddWalletAmount.sudopay_gateway_id',
			'Sudopay'
        );
        parent::beforeFilter();
    }
    public function add_to_wallet()
    {
        $this->loadModel('User');
        $this->pageTitle = sprintf(__l('Add %s') , __l('Amount to Wallet'));
        if (!empty($this->request->data)) {
            $this->User->UserAddWalletAmount->create();
            if (empty($this->request->data['UserAddWalletAmount']['payment_gateway_id'])) {
                $this->Session->setFlash(__l('Please select payment type') , 'default', null, 'error');
            } else {
                $this->request->data['UserAddWalletAmount']['sudopay_gateway_id'] = 0;
				if ($this->request->data['UserAddWalletAmount']['payment_gateway_id'] != ConstPaymentGateways::Wallet && strpos($this->request->data['UserAddWalletAmount']['payment_gateway_id'], 'sp_') >= 0) {
                    $PaymentGateway['PaymentGateway']['id'] = ConstPaymentGateways::SudoPay;
                    $this->request->data['UserAddWalletAmount']['sudopay_gateway_id'] = str_replace('sp_', '', $this->request->data['UserAddWalletAmount']['payment_gateway_id']);
                    $this->request->data['UserAddWalletAmount']['payment_gateway_id'] = ConstPaymentGateways::SudoPay;
                }
                $this->request->data['UserAddWalletAmount']['user_id'] = $this->Auth->user('id');
                App::uses('PaymentGateway', 'Model');
                $this->PaymentGateway = new PaymentGateway();
                $PaymentGateway = $this->PaymentGateway->find('first', array(
                    'conditions' => array(
                        'PaymentGateway.id' => $this->request->data['UserAddWalletAmount']['payment_gateway_id']
                    ) ,
                    'recursive' => -1
                ));
                if ($this->User->UserAddWalletAmount->save($this->request->data)) {
                    if ($PaymentGateway['PaymentGateway']['id'] == ConstPaymentGateways::SudoPay && isPluginEnabled('Sudopay')) {
                        $this->loadModel('Sudopay.Sudopay');
                        $this->Sudopay = new Sudopay();
                        $sudopay_gateway_settings = $this->Sudopay->GetSudoPayGatewaySettings();
                        $this->set('sudopay_gateway_settings', $sudopay_gateway_settings);
                        if ($sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
                            $sudopay_data = $this->Sudopay->getSudoPayPostData($this->User->UserAddWalletAmount->id, ConstPaymentType::AddAmountToWallet);
                            $sudopay_data['merchant_id'] = $sudopay_gateway_settings['sudopay_merchant_id'];
                            $sudopay_data['website_id'] = $sudopay_gateway_settings['sudopay_website_id'];
                            $sudopay_data['secret_string'] = $sudopay_gateway_settings['sudopay_secret_string'];
                            $sudopay_data['action'] = 'capture';
							$sudopay_data['button_url'] = '\'' . '//d1fhd8b1ym2gwa.cloudfront.net/btn/sudopay_btn.js'. '\'';
							if(!empty($sudopay_gateway_settings['is_test_mode'])){
								$sudopay_data['button_url'] = '\'' . '//d1fhd8b1ym2gwa.cloudfront.net/btn/sandbox/sudopay_btn.js'. '\'';
							}
                            $this->set('sudopay_data', $sudopay_data);
                        } else {
                            $this->request->data['Sudopay'] = !empty($this->request->data['Sudopay']) ? $this->request->data['Sudopay'] : '';
                            $return = $this->Sudopay->processPayment($this->User->UserAddWalletAmount->id, ConstPaymentType::AddAmountToWallet, $this->request->data['Sudopay']);
                        }
                    }
					$redirect = 0;
                    if (!empty($return['pending'])) {
                        $this->Session->setFlash(__l('Your payment is in pending.') , 'default', null, 'success');
						$redirect = 1;
                    } elseif (!empty($return['success'])) {
                        $this->Wallet->processAddtoWallet($this->User->UserAddWalletAmount->id, ConstPaymentGateways::SudoPay);
                        $this->Session->setFlash(__l('Amount added to wallet') , 'default', null, 'success');
						$redirect = 1;
                    } elseif (!empty($return['error'])) {
                        $return['error_message'].= '. ';
                        $this->Session->setFlash($return['error_message'] . __l('Your payment could not be completed.') , 'default', null, 'error');
                    }
					if (!empty($redirect)) {
						$this->redirect(array(
							'controller' => 'wallets',
							'action' => 'add_to_wallet'
						));
					}
                } else {
                    $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Amount')) , 'default', null, 'error');
                }
            }
        }
        $user_info = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'User.available_wallet_amount',
            ) ,
            'recursive' => -1
        ));
        $this->request->data['User']['type'] = 'user';
        $this->set('user_info', $user_info);
    }
}
?>