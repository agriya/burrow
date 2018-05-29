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
class UserAddWalletAmount extends AppModel
{
    public $name = 'UserAddWalletAmount';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'PaymentGateway' => array(
            'className' => 'PaymentGateway',
            'foreignKey' => 'payment_gateway_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
		$this->_permanentCacheAssociations = array(
            'User',
            'Transaction',
            'Wallet',
        );
        $this->validate = array(
            'user_id' => array(
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
            'amount' => array(
                'rule5' => array(
                    'rule' => array(
                        '_checkMAximumAmount'
                    ) ,
					'allowEmpty' => false,
                    'message' => sprintf(__l('Given amount should lies from  %s%s to %s%s') , Configure::read('wallet.min_wallet_amount') , Configure::read('site.currency') , Configure::read('wallet.max_wallet_amount') , Configure::read('site.currency'))
                ) ,
                'rule4' => array(
                    'rule' => array(
                        '_checkMinimumAmount'
                    ) ,
					'allowEmpty' => false,
                    'message' => sprintf(__l('Amount should be greater than minimum amount %s%s') , Configure::read('wallet.min_wallet_amount') , Configure::read('site.currency'))
                ) ,
				'rule3' => array(
                    'rule' =>array('comparison', '>', 0),
					'allowEmpty' => false,
                    'message' => __l('Amount should be greater than Zero')
                ) ,
                'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Amount should be numeric') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required') ,
                    'allowEmpty' => false
                )
            ) ,
            'description' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
        );
    }
    public function _checkMinimumAmount()
    {
        $amount = $this->data['UserAddWalletAmount']['amount'];
        if (!empty($amount) && $amount < Configure::read('wallet.min_wallet_amount')) {
            return false;
        }
        return true;
    }
    public function _checkMAximumAmount()
    {
        $amount = $this->data['UserAddWalletAmount']['amount'];
        if (Configure::read('wallet.max_wallet_amount') && !empty($amount) && $amount > Configure::read('wallet.max_wallet_amount')) {
            return false;
        }
        return true;
    }
    public function getReceiverdata($foreign_id, $transaction_type, $payee_account)
    {
		$UserAddWalletAmount = $this->find('first', array(
            'conditions' => array(
                'UserAddWalletAmount.id' => $foreign_id
            ) ,
            'contain' => array(
                'User'
            ) ,
            'recursive' => 0
        ));
        $return['receiverEmail'] = array(
            $payee_account
        );
        $return['amount'] = array(
            $UserAddWalletAmount['UserAddWalletAmount']['amount']
        );
        $return['fees_payer'] = 'buyer';
        if (Configure::read('wallet.wallet_fee_payer') == 'Site') {
            $return['fees_payer'] = 'merchant';
        }
        $return['sudopay_gateway_id'] = $UserAddWalletAmount['UserAddWalletAmount']['sudopay_gateway_id'];
        $return['buyer_email'] = $UserAddWalletAmount['User']['email'];
        return $return;
    }
}
?>