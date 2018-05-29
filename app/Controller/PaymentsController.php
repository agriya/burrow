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
class PaymentsController extends AppController
{
    public $name = 'Payments';
    public $components = array(
        'Email',
    );
    public $permanentCacheAction = array(
        'public' => array(
            'membership_pay_now',
        ) ,
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Payment.connect',
            'Payment.contact',
            'Payment.accept',
            'Payment.negotiation_discount',
            'PropertyUser.message',
            'Payment.wallet',
            'Payment.normal',
            'Payment.is_agree_terms_conditions',
            'Payment.payment_gateway_id',
            'Payment.payment_type',
            'Payment.is_show_new_card',
            'Payment.standard_connect',
            'User.payment_gateway_id',
            'User.wallet',
            'User.normal',
            'User.payment_id',
            'User.gateway_method_id',
            'Sudopay'
        );
        parent::beforeFilter();
    }
    public function membership_pay_now($user_id = null, $hash = null)
    {
        $this->pageTitle = __l('Membership Fee');
        App::import('Model', 'User');
        $this->User = new User();
        $gateway_options = array();
        if (!empty($this->request->data['User']['id'])) {
            $user_id = $this->request->data['User']['id'];
        }
        if (is_null($user_id) or is_null($hash)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->User->isValidActivateHash($user_id, $hash)) {
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id,
                ) ,
                'recursive' => -1,
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $this->pageTitle = __l('Pay Membership Fee - ') . $user['User']['username'];
            $total_amount = Configure::read('user.signup_fee');
            $total_amount = round($total_amount, 2);
            if (!empty($this->request->data)) {
                $this->request->data['User']['sudopay_gateway_id'] = 0;
                if (strpos($this->request->data['User']['payment_gateway_id'], 'sp_') >= 0) {
                    $this->request->data['User']['sudopay_gateway_id'] = str_replace('sp_', '', $this->request->data['User']['payment_gateway_id']);
                    $this->request->data['User']['payment_gateway_id'] = ConstPaymentGateways::SudoPay;
                }
                if (empty($this->request->data['User']['payment_gateway_id'])) {
                    $this->Session->setFlash(__l('Please select the payment type') , 'default', null, 'error');
                } else {
                    $_data = array();
                    $_data['User']['id'] = $this->request->data['User']['id'];
                    $_data['User']['payment_gateway_id'] = $this->request->data['User']['payment_gateway_id'];
                    $_data['User']['sudopay_gateway_id'] = $this->request->data['User']['sudopay_gateway_id'];
                    $this->User->save($_data);
                    if ($this->request->data['User']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) {
                        $this->loadModel('Sudopay.Sudopay');
                        $sudopay_gateway_settings = $this->Sudopay->GetSudoPayGatewaySettings();
                        $this->set('sudopay_gateway_settings', $sudopay_gateway_settings);
                        if ($sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
                            $sudopay_data = $this->Sudopay->getSudoPayPostData($this->request->data['User']['id'], ConstPaymentType::SignupFee);
                            $sudopay_data['merchant_id'] = $sudopay_gateway_settings['sudopay_merchant_id'];
                            $sudopay_data['website_id'] = $sudopay_gateway_settings['sudopay_website_id'];
                            $sudopay_data['secret_string'] = $sudopay_gateway_settings['sudopay_secret_string'];
                            $sudopay_data['action'] = 'capture';
							$sudopay_data['button_url'] = '\'' . '//d1fhd8b1ym2gwa.cloudfront.net/btn/sudopay_btn.js' . '\'';
							if (!empty($sudopay_gateway_settings['is_test_mode'])) {
								$sudopay_data['button_url'] = '\'' . '//d1fhd8b1ym2gwa.cloudfront.net/btn/sandbox/sudopay_btn.js' . '\'';
							}
                            $this->set('sudopay_data', $sudopay_data);
                        } else {
                            $this->request->data['Sudopay'] = !empty($this->request->data['Sudopay']) ? $this->request->data['Sudopay'] : '';
                            $return = $this->Sudopay->processPayment($this->request->data['User']['id'], ConstPaymentType::SignupFee, $this->request->data['Sudopay']);
                            if (!empty($return['pending'])) {
                                $this->Session->setFlash(__l('Your payment is in pending.') , 'default', null, 'success');
                            } elseif (!empty($return['success'])) {
                                $this->Payment->processUserSignupPayment($this->request->data['User']['id'], ConstPaymentGateways::SudoPay);
                                if (!Configure::read('user.is_admin_activate_after_register')) {
                                    $this->Session->setFlash(__l('You have paid signup fee successfully.') , 'default', null, 'success');
                                    $this->redirect(array(
                                        'controller' => 'users',
                                        'action' => 'dashboard',
                                    ));
                                } else {
                                    $this->Session->setFlash(__l('You have paid signup fee successfully. After administrator approval, you can login to site.') , 'default', null, 'success');
                                }
                            } elseif (!empty($return['error'])) {
                                $this->Session->setFlash($return['error_message'] . '. ' . __l('Your payment could not be completed.') , 'default', null, 'error');
                            }
                        }
                    }
                }
            } else {
                $this->request->data = $user;
            }
            $this->set('total_amount', $total_amount);
            $this->set('user', $user);
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    //send welcome mail for new user
    public function _sendWelcomeMail($user_id, $user_email, $username)
    {
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $email = $this->EmailTemplate->selectTemplate('Welcome Email');
        $emailFindReplace = array(
            '##USERNAME##' => $username,
            '##CONTACT_MAIL##' => Configure::read('site.contact_email') ,
            '##FROM_EMAIL##' => ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'],
        );
        $this->Payment->_sendEmail($email, $emailFindReplace, $user_email);
    }
    public function get_gateways()
    {
        App::import('Model', 'User');
        $this->loadModel('User');
        $countries = $this->User->UserProfile->Country->find('list', array(
            'fields' => array(
                'Country.iso_alpha2',
                'Country.name'
            ) ,
            'order' => array(
                'Country.name' => 'ASC'
            ) ,
            'recursive' => -1,
        ));
        $user_profile = $this->User->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $this->Auth->user('id') ,
            ) ,
            'contain' => array(
                'User',
                'City',
                'State',
                'Country'
            ) ,
            'recursive' => 0,
        ));
        if (!empty($this->request->params['named']['type'])) {
            $type = $this->request->params['named']['type'];
            $gateway_types = $this->Payment->getGatewayTypes($type);
        } else {
            $gateway_types = $this->Payment->getGatewayTypes();
        }
        if (isPluginEnabled('Sudopay') && !empty($gateway_types[ConstPaymentGateways::SudoPay])) {
            $this->request->data[$this->request->params['named']['model']]['payment_gateway_id'] = ConstPaymentGateways::SudoPay;
        } elseif (isPluginEnabled('Wallet') && !empty($gateway_types[ConstPaymentGateways::Wallet])) {
            $this->request->data[$this->request->params['named']['model']]['payment_gateway_id'] = ConstPaymentGateways::Wallet;
        }
        if (isPluginEnabled('Sudopay')) {
            $this->loadModel('Sudopay.Sudopay');
            $this->Sudopay = new Sudopay();
            $response = $this->Sudopay->GetSudoPayGatewaySettings();
            $this->set('response', $response);
        }
        $this->set('model', $this->request->params['named']['model']);
        $this->set('foreign_id', $this->request->params['named']['foreign_id']);
        $this->set('transaction_type', $this->request->params['named']['transaction_type']);
        $this->set(compact('countries', 'user_profile', 'gateway_types'));
    }
}
?>