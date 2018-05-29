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
if (isPluginEnabled('Wallet')) {
    CmsNav::add('payments', array(
        'title' => __l('Payments') ,
        'weight' => 50,
        'children' => array(
            'Withdraw Fund Request' => array(
                'title' => __l('Withdraw Fund Request') ,
                'url' => '',
                'weight' => 400,
            ) ,
            'User Cash Withdrawals' => array(
                'title' => __l('User Cash Withdrawals') ,
                'url' => array(
                    'controller' => 'user_cash_withdrawals',
                    'action' => 'index',
                    'filter_id' => ConstWithdrawalStatus::Pending,
                    'admin' => true,
                ) ,
                'weight' => 410,
            ) ,
        )
    ));
}
$defaultModel = array(
    'User' => array(
        'hasMany' => array(
            'UserCashWithdrawal' => array(
                'className' => 'Withdrawals.UserCashWithdrawal',
                'foreignKey' => 'user_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            ) ,
            'MoneyTransferAccount' => array(
                'className' => 'Withdrawals.MoneyTransferAccount',
                'foreignKey' => 'user_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => '',
            ) ,
        ) ,
    ) ,
);
CmsHook::bindModel($defaultModel);
