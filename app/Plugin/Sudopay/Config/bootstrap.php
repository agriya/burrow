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
require_once 'constants.php';
CmsHook::setExceptionUrl(array(
    'sudopays/cancel_payment',
    'sudopays/success_payment',
    'sudopays/process_payment',
    'sudopays/process_ipn',
    'sudopays/update_account',
));
$pluginModel = array();
if (isPluginEnabled('Properties')) {
    $pluginModel = array(
        'PropertyUser' => array(
            'belongsTo' => array(
                'SudopayPaymentGateway' => array(
                    'className' => 'Sudopay.SudopayPaymentGateway',
                    'foreignKey' => 'sudopay_gateway_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => '',
                    'counterCache' => false
                ) ,
            ) ,
        ) ,
    );
}
CmsHook::bindModel($pluginModel);
?>