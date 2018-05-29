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
class PaymentGateway extends AppModel
{
    public $name = 'PaymentGateway';
    public $displayField = 'name';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $hasMany = array(
        'PaymentGatewaySetting' => array(
            'className' => 'PaymentGatewaySetting',
            'foreignKey' => 'payment_gateway_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'name' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
        // filter options in admin index
        $this->isFilterOptions = array(
            0 => __l('All') ,
            1 => __l('Active') ,
            2 => __l('Inactive') ,
            3 => __l('Test Mode') ,
            4 => __l('Live Mode') ,
            5 => __l('Auto Approved') ,
            6 => __l('Non Auto Approved')
        );
    }
    //It will fetch payment_gateway and payment_gateway_settings and normalize the array in to single array
    function getPaymentSettings($id = null)
    {
        if (is_null($id)) {
            return false;
        }
        $paymentGateway = $this->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => $id
            ) ,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'fields' => array(
                        'PaymentGatewaySetting.name',
                        'PaymentGatewaySetting.test_mode_value',
                        'PaymentGatewaySetting.live_mode_value'
                    )
                )
            ) ,
            'recursive' => 1
        ));
        if (!empty($paymentGateway['PaymentGatewaySetting'])) {
            foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                $paymentGateway['PaymentGateway'][$paymentGatewaySetting['name']] = ($paymentGateway['PaymentGateway']['is_test_mode']) ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
            }
        } else {
            return false;
        }
        unset($paymentGateway['PaymentGatewaySetting']);
        return $paymentGateway;
    }
	function getPaymentGatewayIsactive($gateway_name)
	{		 
		 $payment_gateway = $this->find('all',array(
			'conditions' => array(
				'PaymentGateway.name' => $gateway_name,
				'PaymentGateway.is_active' => 1,
			),
			'recursive' => -1
		));	
		return $payment_gateway;
	}
	function getMassPayIsactive($gateway_name)
	{		 
		 $massPay = $this->find('all',array(
			'conditions' => array(
				'PaymentGateway.name' => $gateway_name,
				'PaymentGateway.is_mass_pay_enabled' => 1,
			),
			'recursive' => -1
		));	

		return $massPay;
	}
}
?>