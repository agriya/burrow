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
class Sudopay extends AppModel
{
    public $useTable = false;
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
    }
    public function _saveIPNLog()
    {
        App::import('Model', 'Sudopay.SudopayIpnLog');
        $this->SudopayIpnLog = new SudopayIpnLog();
        $sudopay_post_vars_in_str = $this->_parse_array_query($_POST);
        if (!empty($sudopay_post_vars_in_str)) {
            $sudopayIpnLog['post_variable'] = $sudopay_post_vars_in_str;
            $sudopayIpnLog['ip_id'] = $this->SudopayIpnLog->toSaveIp();
            $this->SudopayIpnLog->create();
            $this->SudopayIpnLog->save($sudopayIpnLog);
        }
    }
    public function _parse_array_query($array, $convention = '%s')
    {
        if (count($array) == 0) {
            return '';
        } else {
            $query = '';
            foreach($array as $key => $value) {
                if (is_array($value)) {
                    $new_convention = sprintf($convention, $key) . '[%s]';
                    $query.= $this->_parse_array_query($value, $new_convention);
                } else {
                    $key = urlencode($key);
                    $value = urlencode($value);
                    $query.= sprintf($convention, $key) . "=$value&";
                }
            }
            return $query;
        }
    }
    public function _savePaidLog($foreign_id, $paymentDetails, $class = '')
    {
        App::import('Model', 'Sudopay.SudopayTransactionLog');
        $this->SudopayTransactionLog = new SudopayTransactionLog();
        $sudopayTransactionLog['foreign_id'] = $foreign_id;
        $sudopayTransactionLog['class'] = $class;
        $sudopayTransactionLog['payment_id'] = !empty($paymentDetails['id']) ? $paymentDetails['id'] : '';
        $sudopayTransactionLog['amount'] = !empty($paymentDetails['amount']) ? $paymentDetails['amount'] : '';
        $sudopayTransactionLog['sudopay_pay_key'] = !empty($paymentDetails['paykey']) ? $paymentDetails['paykey'] : '';
        $sudopayTransactionLog['merchant_id'] = !empty($paymentDetails['merchant_id']) ? $paymentDetails['merchant_id'] : '';
        $sudopayTransactionLog['gateway_id'] = !empty($paymentDetails['gateway_id']) ? $paymentDetails['gateway_id'] : '';
        $sudopayTransactionLog['gateway_name'] = !empty($paymentDetails['gateway_name']) ? $paymentDetails['gateway_name'] : '';
        $sudopayTransactionLog['status'] = !empty($paymentDetails['status']) ? $paymentDetails['status'] : '';
        $sudopayTransactionLog['payment_type'] = !empty($paymentDetails['action']) ? $paymentDetails['action'] : '';
        $sudopayTransactionLog['buyer_email'] = !empty($paymentDetails['buyer_email']) ? $paymentDetails['buyer_email'] : '';
        $sudopayTransactionLog['buyer_address'] = !empty($paymentDetails['buyer_address']) ? $paymentDetails['buyer_address'] : '';
        $this->SudopayTransactionLog->create();
        $this->SudopayTransactionLog->save($sudopayTransactionLog);
    }
    public function processPayment($foreign_id, $transaction_type, $sudopay_data)
    {
        $s = $this->getSudoPayObject();
        $return['error'] = 0;
        $post_data = $this->getSudoPayPostData($foreign_id, $transaction_type, $sudopay_data);
        $callAction = $post_data['callAction'];
        $obj = $post_data['obj'];
        unset($post_data['callAction']);
        unset($post_data['obj']);
        $response = $s->
        {
            $callAction}($post_data);
            if ($response['error']['code'] <= 0) {
                $_data = array();
                $data['id'] = $foreign_id;
                if (!empty($response['payment_id'])) {
                    if ($transaction_type == ConstPaymentType::PropertyVerifyFee) {
                        $data['verification_sudopay_payment_id'] = $response['payment_id'];
                        $data['verification_sudopay_pay_key'] = $response['paykey'];
                    } else if ($transaction_type == ConstPaymentType::PropertyListingFee) {
                        $data['listing_sudopay_payment_id'] = $response['payment_id'];
                        $data['listing_sudopay_pay_key'] = $response['paykey'];
                    } else {
                        $data['sudopay_payment_id'] = $response['payment_id'];
                        $data['sudopay_pay_key'] = $response['paykey'];
                    }
                }
                $obj->save($data, false);
                if (!empty($response['status']) && $response['status'] == 'Pending') {
                    $return['pending'] = 1;
                } elseif (!empty($response['status']) && ($response['status'] == 'Captured' || $response['status'] == 'Authorized')) {
                    $return['success'] = 1;
                } elseif (!empty($response['confirmation'])) {
                    if ($transaction_type == ConstPaymentType::PropertyVerifyFee) {
                        App::uses('Properties.Property', 'Model');
                        $obj = new Property();
                    } else if ($transaction_type == ConstPaymentType::PropertyListingFee) {
                        App::uses('Properties.Property', 'Model');
                        $obj = new Property();
                    } elseif ($transaction_type == ConstPaymentType::SignupFee) {
                        App::uses('User', 'Model');
                        $obj = new User();
                    } elseif ($transaction_type == ConstPaymentType::BookingAmount) {
                        App::uses('Properties.PropertyUser', 'Model');
                        $obj = new Property();
                    } elseif ($transaction_type == ConstPaymentType::AddedToWallet) {
                        App::import('Model', 'Wallet.UserAddWalletAmount');
                        $obj = new UserAddWalletAmount();
                    }
                    $data['id'] = $foreign_id;
                    if ($transaction_type == ConstPaymentType::PropertyVerifyFee) {
                        $data['verification_sudopay_revised_amount'] = $response['revised_amount'];
                        $data['verification_sudopay_token'] = $response['confirmation']['token'];
                    } else if ($transaction_type == ConstPaymentType::PropertyListingFee) {
                        $data['listing_sudopay_revised_amount'] = $response['revised_amount'];
                        $data['listing_sudopay_token'] = $response['confirmation']['token'];
                    } else {
                        $data['sudopay_revised_amount'] = $response['revised_amount'];
                        $data['sudopay_token'] = $response['confirmation']['token'];
                    }
                    $obj->save($data, false);
                    $redirect = Router::url(array(
                        'controller' => 'sudopays',
                        'action' => 'confirmation',
                        $foreign_id,
                        $transaction_type,
                        'admin' => false
                    ) , true);
                    header('location: ' . $redirect);
                    exit;
                } elseif (!empty($response['gateway_callback_url'])) {
                    header('location: ' . $response['gateway_callback_url']);
                    exit;
                }
            } else {
                $return['error'] = 1;
                $return['error_message'] = $response['error']['message'];
            }
            return $return;
        }
        public function getSudoPayPostData($foreign_id, $transaction_type, $sudopay_data = array())
        {
            $post_data = array();
			$is_buyer_fees_payer_confirmation_token_needed = false;
            if ($transaction_type == ConstPaymentType::BookingAmount) {
                App::uses('Properties.PropertyUser', 'Model');
                $obj = new PropertyUser();
                $propertyUser = $obj->find('first', array(
                    'contain' => array(
                        'Property',
                        'User',
                    ) ,
                    'conditions' => array(
                        'PropertyUser.id' => $foreign_id
                    ) ,
                    'recursive' => 0
                ));
                $receiver_data = $obj->getReceiverdata($foreign_id, $transaction_type, $propertyUser['User']['email']);
                $post_data['item_name'] = $propertyUser['Property']['title'];
                $post_data['item_description'] = __l('Property Booking');
                $post_data['fees_payer'] = $receiver_data['fees_payer'];
            } else if ($transaction_type == ConstPaymentType::PropertyListingFee) {
                App::uses('Properties.Property', 'Model');
                $obj = new Property();
                $property = $obj->find('first', array(
                    'conditions' => array(
                        'Property.id' => $foreign_id,
                    ) ,
                    'contain' => array(
                        'User',
                    ) ,
                    'recursive' => 0
                ));
                $receiver_data = $obj->getReceiverdata($foreign_id, $transaction_type, $property['User']['email']);
                $post_data['item_name'] = $property['Property']['title'];
                $post_data['item_description'] = __l('Property Listing Fee');
                $post_data['fees_payer'] = $receiver_data['fees_payer'];
                if (Configure::read('property.listing_fee_payer') == 'Host') {
                    $is_buyer_fees_payer_confirmation_token_needed = true;
                }
            } else if ($transaction_type == ConstPaymentType::PropertyVerifyFee) {
                App::uses('Properties.Property', 'Model');
                $obj = new Property();
                $property = $obj->find('first', array(
                    'conditions' => array(
                        'Property.id' => $foreign_id,
                    ) ,
                    'contain' => array(
                        'User',
                    ) ,
                    'recursive' => 0
                ));
                $receiver_data = $obj->getReceiverdata($foreign_id, $transaction_type, $property['User']['email']);
                $post_data['item_name'] = $property['Property']['title'];
                $post_data['item_description'] = __l('Property Verify Fee');
                $post_data['fees_payer'] = $receiver_data['fees_payer'];
                if (Configure::read('property.verify_fee_payer') == 'Host') {
                    $is_buyer_fees_payer_confirmation_token_needed = true;
                }
            } elseif ($transaction_type == ConstPaymentType::SignupFee) {
                App::uses('User', 'Model');
                $obj = new User();
                $user = $obj->find('first', array(
                    'conditions' => array(
                        'User.id' => $foreign_id,
                    ) ,
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email'
                    ) ,
                    'recursive' => -1
                ));
                $receiver_data = $obj->getReceiverdata($foreign_id, $transaction_type, $user['User']['email']);
                $post_data['item_name'] = __l('Signup Fee');
                $post_data['item_description'] = sprintf(__l('%s paying signup fee') , $user['User']['username']);
                $post_data['fees_payer'] = $receiver_data['fees_payer'];
                if (Configure::read('user.signup_fee_payer') == 'User') {
                    $is_buyer_fees_payer_confirmation_token_needed = true;
                }
            } elseif ($transaction_type == ConstPaymentType::AddAmountToWallet) {
                App::import('Model', 'Wallet.UserAddWalletAmount');
                $obj = new UserAddWalletAmount();
                $user = $obj->find('first', array(
                    'conditions' => array(
                        'UserAddWalletAmount.id' => $foreign_id,
                    ) ,
                    'contain' => array(
                        'User',
                    ) ,
                    'recursive' => 0
                ));
                $receiver_data = $obj->getReceiverdata($foreign_id, $transaction_type, $user['User']['email']);
                $post_data['item_name'] = __l('Add to Wallet');
                $post_data['item_description'] = sprintf(__l('%s added amount to wallet') , $user['User']['username']);
                $post_data['fees_payer'] = $receiver_data['fees_payer'];
                if (Configure::read('wallet.wallet_fee_payer') == 'User') {
                    $is_buyer_fees_payer_confirmation_token_needed = true;
                }
            }
            App::import('Model', 'Sudopay.SudopayPaymentGateway');
            $this->SudopayPaymentGateway = new SudopayPaymentGateway();
            $sudopayPaymentGateway = $this->SudopayPaymentGateway->find('first', array(
                'conditions' => array(
                    'SudopayPaymentGateway.sudopay_gateway_id' => $receiver_data['sudopay_gateway_id']
                ) ,
                'recursive' => -1
            ));
            $s = $this->getSudoPayObject();
            $gateway_response = $s->callGateways();
            $form_fields_tpls = $gateway_response['_form_fields_tpls'];
            $sudopayGatewayDetails = unserialize($sudopayPaymentGateway['SudopayPaymentGateway']['sudopay_gateway_details']);
            $extends_tpl = $sudopayGatewayDetails['_form_fields']['_extends_tpl'];
            foreach($sudopayGatewayDetails['_form_fields']['_extends_tpl'] as $k => $value) {
                foreach($gateway_response['_form_fields_tpls'][$value]['_fields'] as $key => $field) {
                    $form_field_arr[] = $key;
                }
            }
            if (!empty($sudopay_data) && !empty($receiver_data['sudopay_gateway_id'])) {
                foreach($sudopay_data as $k => $v) {
                    if (in_array($k, $form_field_arr)) {
                        $post_data[$k] = $v;
                    }
                }
            }
			if($is_buyer_fees_payer_confirmation_token_needed) {
				$post_data['buyer_fees_payer_confirmation_token'] = $sudopayGatewayDetails['buyer_fees_payer_confirmation_token'];
			}
            $post_data['amount'] = $receiver_data['amount']['0'];
			$post_data['buyer_ip'] = $_SERVER['REMOTE_ADDR'];
            $post_data['gateway_id'] = $receiver_data['sudopay_gateway_id'];
            $currency_id = Configure::read('site.currency_id');
			$post_data['currency_code'] = $GLOBALS['currencies'][$currency_id]['Currency']['code'];
            $post_data['notify_url'] = Cache::read('site_url_for_shell', 'long') . 'sudopays/process_ipn/' . $foreign_id . '/' . $transaction_type;
            $post_data['cancel_url'] = Cache::read('site_url_for_shell', 'long') . 'sudopays/cancel_payment/' . $foreign_id . '/' . $transaction_type;
            $post_data['success_url'] = Cache::read('site_url_for_shell', 'long') . 'sudopays/success_payment/' . $foreign_id . '/' . $transaction_type;
            if ($transaction_type == ConstPaymentType::BookingAmount && $sudopayPaymentGateway['SudopayPaymentGateway']['is_marketplace_supported']) {
                $callAction = 'callAuth';
            } else {
                $callAction = 'callCapture';
            }
            $post_data['obj'] = $obj;
            $post_data['callAction'] = $callAction;
            return $post_data;
        }
        public function getSudoPayObject()
        {
            $gateway_settings_options = $this->GetSudoPayGatewaySettings();
            App::import('Vendor', 'Sudopay.sudopay');
            $this->s = new SudoPay_API(array(
                'api_key' => $gateway_settings_options['sudopay_api_key'],
                'merchant_id' => $gateway_settings_options['sudopay_merchant_id'],
                'website_id' => $gateway_settings_options['sudopay_website_id'],
                'secret_string' => $gateway_settings_options['sudopay_secret_string'],
                'is_test' => $gateway_settings_options['is_test_mode'],
                'cache_path' => CACHE . DS
            ));
            return $this->s;
        }
        public function GetSudoPayGatewaySettings()
        {
            App::import('Model', 'PaymentGateway');
            $this->PaymentGateway = new PaymentGateway();
            $paymentGateway = $this->PaymentGateway->find('first', array(
                'conditions' => array(
                    'PaymentGateway.id' => ConstPaymentGateways::SudoPay
                ) ,
                'contain' => array(
                    'PaymentGatewaySetting' => array(
                        'fields' => array(
                            'PaymentGatewaySetting.name',
                            'PaymentGatewaySetting.test_mode_value',
                            'PaymentGatewaySetting.live_mode_value',
                        ) ,
                    ) ,
                ) ,
                'recursive' => 1
            ));
            $gateway_settings_options['is_test_mode'] = (!empty($paymentGateway['PaymentGateway']['is_test_mode'])) ? 1 : 0;
            if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                    if ($paymentGateway['PaymentGateway']['is_test_mode']) {
                        $gateway_settings_options[$paymentGatewaySetting['name']] = $paymentGatewaySetting['test_mode_value'];
                    } else {
                        $gateway_settings_options[$paymentGatewaySetting['name']] = $paymentGatewaySetting['live_mode_value'];
                    }
                }
            }
            return $gateway_settings_options;
        }
        public function isHavingPendingGatewayConnect($foreign_id)
        {
            App::import('Model', 'Sudopay.SudopayPaymentGatewaysUser');
            $this->SudopayPaymentGatewaysUser = new SudopayPaymentGatewaysUser();
            App::import('Model', 'Sudopay.SudopayPaymentGateway');
            $this->SudopayPaymentGateway = new SudopayPaymentGateway();
            $sudopaypaymentgateways_count = $this->SudopayPaymentGateway->find('count', array(
                'conditions' => array(
                    'SudopayPaymentGateway.is_marketplace_supported' => 1,
                ) ,
                'recursive' => -1,
            ));
            $connected_gateways = $this->SudopayPaymentGatewaysUser->find('list', array(
                'conditions' => array(
                    'SudopayPaymentGatewaysUser.user_id' => $foreign_id,
                ) ,
                'fields' => array(
                    'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id',
                ) ,
                'recursive' => -1,
            ));
            $connected_gateways_count = count($connected_gateways);
            if (($sudopaypaymentgateways_count == $connected_gateways_count)) {
                return 0;
            }
            return 1;
        }
        public function GetUserConnectedGateways($foreign_id)
        {
            App::import('Model', 'Sudopay.SudopayPaymentGatewaysUser');
            $this->SudopayPaymentGatewaysUser = new SudopayPaymentGatewaysUser();
            $connected_gateways = $this->SudopayPaymentGatewaysUser->find('list', array(
                'conditions' => array(
                    'SudopayPaymentGatewaysUser.user_id' => $foreign_id,
                ) ,
                'fields' => array(
                    'SudopayPaymentGatewaysUser.sudopay_payment_gateway_id',
                ) ,
                'recursive' => -1,
            ));
            return $connected_gateways;
        }
        public function getGatewayGroups($tmp_gateways)
        {
            $gateways = array();
            if (!empty($tmp_gateways['gateways'])) {
                foreach($tmp_gateways['gateways'] as $group_gateway) {
                    if (!empty($group_gateway['gateways'])) {
                        unset($group_gateway['gateways']);
                        $gateways[] = $group_gateway;
                    }
                }
            }
            return $gateways;
        }
        public function getGateways($tmp_gateways)
        {
            $gateways = array();
            if (!empty($tmp_gateways['gateways'])) {
                foreach($tmp_gateways['gateways'] as $group_gateway) {
                    if (!empty($group_gateway['gateways'])) {
                        foreach($group_gateway['gateways'] as $gateway) {
                            $gateway['group_id'] = $group_gateway['id'];
                            $gateways[] = $gateway;
                        }
                    }
                }
            }
            return $gateways;
        }
        function cancelPreapprovalPayment($foreign_id)
        {
            $return = array();
            App::uses('Properties.PropertyUser', 'Model');
            $this->PropertyUser = new PropertyUser();
            $property_user = $this->PropertyUser->find('first', array(
                'conditions' => array(
                    'PropertyUser.id' => $foreign_id,
                ) ,
                'contain' => array(
                    'Property',
                    'User',
                ) ,
                'recursive' => 0
            ));
            $s = $this->getSudoPayObject();
            $post['gateway_id'] = $property_user['PropertyUser']['sudopay_gateway_id'];
            $post['payment_id'] = $property_user['PropertyUser']['sudopay_payment_id'];
            $post['paykey'] = $property_user['PropertyUser']['sudopay_pay_key'];
            $response = $s->callVoid($post);
            if (!empty($response->error->code)) {
                $return['error'] = 1;
                $return['error_message'] = $response->error->message;
            }
            return $return;
        }
        function processPreapprovalPayment($foreign_id)
        {
            $return = array();
            App::uses('Properties.PropertyUser', 'Model');
            $this->PropertyUser = new PropertyUser();
            $property_user = $this->PropertyUser->find('first', array(
                'conditions' => array(
                    'PropertyUser.id' => $foreign_id,
                ) ,
                'contain' => array(
                    'Property',
                    'User',
                ) ,
                'recursive' => 0
            ));
            $s = $this->getSudoPayObject();
            $post['gateway_id'] = $property_user['PropertyUser']['sudopay_gateway_id'];
            $post['payment_id'] = $property_user['PropertyUser']['sudopay_payment_id'];
            $post['paykey'] = $property_user['PropertyUser']['sudopay_pay_key'];
            $response = $s->callAuthCapture($post);
            if (!empty($response->error->code)) {
                $return['error'] = 1;
                $return['error_message'] = $response->error->message;
            }
            return $return;
        }
    }
?>