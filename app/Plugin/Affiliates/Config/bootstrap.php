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
CmsNav::add('payments', array(
    'title' => 'Payments',
    'weight' => 70,
    'children' => array(
        'Affiliate' => array(
            'title' => __l('Affiliates') ,
            'url' => '',
            'weight' => 200,
        ) ,
        'Affiliates' => array(
            'title' => __l('Affiliates') ,
            'url' => array(
                'controller' => 'affiliates',
                'action' => 'index',
            ) ,
            'weight' => 210,
        ) ,
        'Requests' => array(
            'title' => __l('Requests') ,
            'url' => array(
                'controller' => 'affiliate_requests',
                'action' => 'index',
            ) ,
            'weight' => 220,
        ) ,
        'Common Settings' => array(
            'title' => __l('Common Settings') ,
            'url' => array(
                'controller' => 'settings',
                'action' => 'edit',
                14
            ) ,
            'weight' => 230,
        ) ,
        'Commission Settings' => array(
            'title' => __l('Commission Settings') ,
            'url' => array(
                'controller' => 'affiliate_types',
                'action' => 'edit'
            ) ,
            'weight' => 240,
        ) ,
    ) ,
));
if (isPluginEnabled('Wallet') && isPluginEnabled('Withdrawals')) {
    CmsNav::add('payments', array(
        'title' => 'Payments',
        'weight' => 70,
        'children' => array(
            'Affiliate Withdraw Fund Requests' => array(
                'title' => __l('Withdraw Fund Requests') ,
                'url' => array(
                    'controller' => 'affiliate_cash_withdrawals',
                    'action' => 'index',
                ) ,
                'weight' => 250,
            )
        )
    ));
}
$affiliate_model = Cache::read('affiliate_model', 'affiliatetype');
if (empty($affiliate_model) and $affiliate_model === false) {
    App::import('Model', 'Affiliates.AffiliateType');
    $affiliateTypeObj = new AffiliateType();
    $affiliateType = $affiliateTypeObj->find('list', array(
        'conditions' => array(
            'AffiliateType.is_active' => 1
        ) ,
        'fields' => array(
            'AffiliateType.model_name',
            'AffiliateType.id'
        ) ,
        'recursive' => -1
    ));
    Cache::write('affiliate_model', $affiliateType, 'affiliatetype');
    $affiliate_model = Cache::read('affiliate_model', 'affiliatetype');
}
$defaultModel = array(
    'User' => array(
        'hasMany' => array(
            'Affiliate' => array(
                'className' => 'Affiliates.Affiliate',
                'foreignKey' => 'affliate_user_id',
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
            'AffiliateCashWithdrawal' => array(
                'className' => 'Affiliates.AffiliateCashWithdrawal',
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
            'AffiliateRequest' => array(
                'className' => 'Affiliates.AffiliateRequest',
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
Cms::hookBehavior('User', 'Affiliates.Affiliate', array());
Cms::hookBehavior('Property', 'Affiliates.Affiliate', array());
Cms::hookBehavior('PropertyUser', 'Affiliates.Affiliate', array());
