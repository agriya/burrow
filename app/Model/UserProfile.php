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
class UserProfile extends AppModel
{
    public $name = 'UserProfile';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Gender' => array(
            'className' => 'Gender',
            'foreignKey' => 'gender_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'state_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UserEducation' => array(
            'className' => 'UserEducation',
            'foreignKey' => 'user_education_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UserEmployment' => array(
            'className' => 'UserEmployment',
            'foreignKey' => 'user_employment_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UserIncomeRange' => array(
            'className' => 'UserIncomeRange',
            'foreignKey' => 'user_income_range_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UserRelationship' => array(
            'className' => 'UserRelationship',
            'foreignKey' => 'user_relationship_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Language' => array(
            'className' => 'Language',
            'foreignKey' => 'language_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
		$this->_permanentCacheAssociations = array(
			'User',
		);
        $this->validate = array(
            'dob' => array(
                'rule3' => array(
                    'rule' => '_isValidDob',
                    'message' => __l('Must be a valid date')
                ) ,
                'rule2' => array(
                    'rule' => 'date',
                    'message' => __l('Must be a valid date')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'gender_id' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'address' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
			'country_id' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
        );
    }
    function _isValidDob()
    {
        return Date('Y') . '-' . Date('m') . '-' . Date('d') >= $this->data[$this->name]['dob'];
    }
}
?>