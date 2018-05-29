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
class Affiliate extends AppModel
{
    public $name = 'Affiliate';
    public $actsAs = array(
        'Polymorphic' => array(
            'classField' => 'class',
            'foreignKey' => 'foreign_id',
        )
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'AffiliateType' => array(
            'className' => 'AffiliateType',
            'foreignKey' => 'affiliate_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'AffiliateUser' => array(
            'className' => 'User',
            'foreignKey' => 'affliate_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'AffiliateStatus' => array(
            'className' => 'AffiliateStatus',
            'foreignKey' => 'affiliate_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'foreign_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'class' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'foreign_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'affiliate_type_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'affliate_user_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'affiliate_status_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
    }
    function update_affiliate_status() 
    {
        $conditions['Affiliate.affiliate_status_id'] = ConstAffiliateStatus::PipeLine;
        $affiliates = $this->find('all', array(
            'conditions' => $conditions,
            'fields' => array(
                'Affiliate.id',
                'Affiliate.affiliate_status_id',
                'Affiliate.affliate_user_id',
                'Affiliate.commission_amount',
            ) ,
            'recursive' => -1,
        ));
        if (!empty($affiliates)) {
            $expected_date_diff = strtotime('now') -strtotime($affiliates['Affiliate']['commission_holding_start_date']);
            foreach($affiliates as $affiliate) {
                if (($expected_date_diff != '') && ($expected_date_diff >= Configure::read('affiliate.commission_holding_period'))) {
                    $this->updateAll(array(
                        'Affiliate.affiliate_status_id' => ConstAffiliateStatus::Completed
                    ) , array(
                        'Affiliate.id' => $affiliate['Affiliate']['id']
                    ));
                    $this->AffiliateUser->updateAll(array(
                        'AffiliateUser.total_commission_completed_amount' => 'AffiliateUser.total_commission_completed_amount + ' . $affiliate['Affiliate']['commission_amount'],
                        'AffiliateUser.commission_line_amount' => 'AffiliateUser.commission_line_amount + ' . $affiliate['Affiliate']['commission_amount']
                    ) , array(
                        'AffiliateUser.id' => $affiliate['Affiliate']['affliate_user_id']
                    ));
                }
            }
        }
    }
}
?>