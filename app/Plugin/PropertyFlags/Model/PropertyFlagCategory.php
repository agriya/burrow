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
class PropertyFlagCategory extends AppModel
{
    public $name = 'PropertyFlagCategory';
    public $displayField = 'name';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $hasMany = array(
        'PropertyFlag' => array(
            'className' => 'PropertyFlags.PropertyFlag',
            'foreignKey' => 'property_flag_category_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
		$this->_permanentCacheAssociations = array(
			'PropertyFlag',
		);
        $this->validate = array(
            'name' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            )
        );
        $this->moreActions = array(
            ConstMoreAction::Inactive => __l('Disable') ,
            ConstMoreAction::Active => __l('Enable') ,
            ConstMoreAction::Delete => __l('Delete')
        );
        $this->isFilterOptions = array(
			ConstMoreAction::Active => __l('Enable'),
            ConstMoreAction::Inactive => __l('Disable') 
            
        );
    }
}
?>