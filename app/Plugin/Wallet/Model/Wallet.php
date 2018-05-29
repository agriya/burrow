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
class Wallet extends AppModel
{
    public $useTable = false;
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
    }
    public function processAddtoWallet($user_add_wallet_amount_id, $payment_gateway_id = null)
    {
		App::import('Model', 'User');
        $this->User = new User();
        $userAddWalletAmount = $this->User->UserAddWalletAmount->find('first', array(
            'conditions' => array(
                'UserAddWalletAmount.id' => $user_add_wallet_amount_id,
            ) ,
            'contain' => array(
                'User'
            ) ,
            'recursive' => 0
        ));
        if (empty($userAddWalletAmount)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (empty($userAddWalletAmount['UserAddWalletAmount']['is_success'])) {
			$this->User->Transaction->log($userAddWalletAmount['UserAddWalletAmount']['id'], 'Wallet.UserAddWalletAmount', $payment_gateway_id, ConstTransactionTypes::AddedToWallet);
            $_Data['UserAddWalletAmount']['id'] = $user_add_wallet_amount_id;
            $_Data['UserAddWalletAmount']['is_success'] = 1;
            $this->User->UserAddWalletAmount->save($_Data);
            $User['id'] = $userAddWalletAmount['UserAddWalletAmount']['user_id'];
            $User['available_wallet_amount'] = $userAddWalletAmount['User']['available_wallet_amount'] + $userAddWalletAmount['UserAddWalletAmount']['amount'];
            $this->User->save($User);
			Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
                '_addTrans' => array(
                    'order_id' => 'Wallet-' . $userAddWalletAmount['UserAddWalletAmount']['id'],
                    'name' => 'Wallet',
                    'total' => $userAddWalletAmount['UserAddWalletAmount']['amount']
                ) ,
                '_addItem' => array(
                    'order_id' => 'Wallet-' . $userAddWalletAmount['UserAddWalletAmount']['id'],
                    'sku' => 'W' . $userAddWalletAmount['UserAddWalletAmount']['id'],
                    'name' => 'Wallet',
                    'category' => $userAddWalletAmount['User']['username'],
                    'unit_price' => $userAddWalletAmount['UserAddWalletAmount']['amount']
                ) ,
                '_setCustomVar' => array(
                    'ud' => $_SESSION['Auth']['User']['id'],
                    'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
                )
            ));
			return true;
        } elseif (!empty($userAddWalletAmount['UserAddWalletAmount']['is_success'])) {
            return true;
        }
        return false;
    }
	public function processPayToProperty($user_id, $total_amount, $property_id, $transaction_type) {
		App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'User.email',
                'User.available_wallet_amount',
            ) ,
            'recursive' => -1
        ));
        if ($user['User']['available_wallet_amount'] < ($total_amount)) {
            return false;
        } else {
            App::import('Model', 'Properties.Property');
            $this->Property = new Property();
            $return['error'] = 0;
            $buyer_info = $user;
            // Updating buyer balance //
            $update_buyer_balance = $buyer_info['User']['available_wallet_amount']-$total_amount;
            $this->Property->User->updateAll(array(
                'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
            ) , array(
                'User.id' => $user_id
            ));
			if($transaction_type == ConstPaymentType::PropertyListingFee) {
				$property = $this->Property->find('first', array(
					'conditions' => array(
						'Property.id' => $property_id
					) ,
					'recursive' => 0
				));
				Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
					'_addTrans' => array(
						'order_id' => 'PropertyListing-' . $property['Property']['id'],
						'name' => $property['Property']['title'],
						'total' => $total_amount
					) ,
					'_addItem' => array(
						'order_id' => 'ProjectListing-' . $property['Property']['id'],
						'sku' => 'P' . $property['Property']['id'],
						'name' => $property['Property']['title'],
						'unit_price' => $total_amount
					) ,
					'_setCustomVar' => array(
						'pd' => $property['Property']['id'],
						'ud' => $_SESSION['Auth']['User']['id'],
						'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
					)
				));
				$this->Property->processPayment($property_id, $total_amount, ConstPaymentGateways::Wallet, ConstPaymentType::PropertyListingFee);
			} else if($transaction_type == ConstPaymentType::PropertyVerifyFee) {
				$property = $this->Property->find('first', array(
					'conditions' => array(
						'Property.id' => $property_id
					) ,
					'recursive' => 0
				));
				Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
					'_addTrans' => array(
						'order_id' => 'PropertyListing-' . $property['Property']['id'],
						'name' => $property['Property']['title'],
						'total' => $total_amount
					) ,
					'_addItem' => array(
						'order_id' => 'ProjectListing-' . $property['Property']['id'],
						'sku' => 'P' . $property['Property']['id'],
						'name' => $property['Property']['title'],
						'unit_price' => $total_amount
					) ,
					'_setCustomVar' => array(
						'pd' => $property['Property']['id'],
						'ud' => $_SESSION['Auth']['User']['id'],
						'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
					)
				));
				$this->Property->processPayment($property_id, $total_amount, ConstPaymentGateways::Wallet, ConstPaymentType::PropertyVerifyFee);
			} else if($transaction_type == ConstPaymentType::BookingAmount) {
				$propertyUser = $this->Property->PropertyUser->find('first', array(
					'conditions' => array(
						'PropertyUser.id' => $property_id
					) ,
					'recursive' => -1
				));
				$property = $this->Property->find('first', array(
					'conditions' => array(
						'Property.id' => $propertyUser['PropertyUser']['property_id']
					) ,
					'recursive' => 0
				));
				Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
					'_addTrans' => array(
						'order_id' => 'PropertyBooking-' . $property['Property']['id'],
						'name' => $property['Property']['title'],
						'total' => $total_amount
					) ,
					'_addItem' => array(
						'order_id' => 'ProjectListing-' . $propertyUser['PropertyUser']['id'],
						'sku' => 'P' . $property['Property']['id'],
						'name' => $property['Property']['title'],
						'unit_price' => $total_amount
					) ,
					'_setCustomVar' => array(
						'pd' => $property['Property']['id'],
						'ud' => $_SESSION['Auth']['User']['id'],
						'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
					)
				));
				$this->Property->processPayment($property_id, $total_amount, ConstPaymentGateways::Wallet, ConstPaymentType::BookingAmount, $propertyUser['PropertyUser']['id']);
			}
        }
        return true;
	}
}
?>