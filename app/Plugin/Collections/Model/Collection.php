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
class Collection extends AppModel
{
    public $name = 'Collection';
    public $displayField = 'title';
    public $actsAs = array(
        'Sluggable' => array(
            'label' => array(
                'title'
            )
        ) ,
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    public $hasOne = array(
        'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_id',
            'conditions' => array(
                'Attachment.class =' => 'Collection'
            ) ,
            'dependent' => true
        )
    );
    public $hasAndBelongsToMany = array(
        'Property' => array(
            'className' => 'Properties.Property',
            'joinTable' => 'collections_properties',
            'foreignKey' => 'collection_id',
            'associationForeignKey' => 'property_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
		$this->_memcacheModels = array(
			'Image'
		);
		$this->_permanentCacheAssociations = array(
			'Property'
		);
        $this->validate = array(
            'user_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'title' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'slug' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) 
        );
        $this->moreActions = array(
			ConstMoreAction::Active => __l('Enable') ,
            ConstMoreAction::Inactive => __l('Disable') ,
            ConstMoreAction::Delete => __l('Delete') ,
        );
        $this->moreActionsProperty = array(
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
    function updateCount($collection_id, $property_id)
    {
        // @todo "Collection city count, country count update"
        $collection_count = $this->CollectionsProperty->find('count', array(
            'conditions' => array(
                'CollectionsProperty.property_id' => $property_id,
            ) ,
            'recursive' => -1
        ));
        $property_ids = $this->CollectionsProperty->find('list', array(
            'conditions' => array(
                'CollectionsProperty.collection_id' => $collection_id,
            ) ,
            'fields' => array(
                'CollectionsProperty.id',
                'CollectionsProperty.property_id',
            ) ,
            'recursive' => -1
        ));
        $property_count = $this->Property->find('count', array(
            'conditions' => array(
                'Property.id' => $property_ids,
                'Property.admin_suspend' => 0,
                'Property.is_active' => 1,
                'Property.is_approved' => 1,
                'Property.is_paid' => 1,
                'Property.price_per_night >=' => 1,
            ) ,
            'recursive' => -1
        ));
        $countries = $this->Property->find('all', array(
            'conditions' => array(
                'Property.id' => $property_ids,
            ) ,
            'fields' => array(
				'DISTINCT(Property.country_id)',
            ) ,
            'recursive' => -1
        ));
        $cities = $this->Property->find('all', array(
            'conditions' => array(
                'Property.id' => $property_ids,
            ) ,
			'fields' => array(
				'DISTINCT(Property.city_id)',
            ) ,
            'recursive' => -1
        ));
        //property count update in collection table
        $this->updateAll(array(
            'Collection.property_count' => $property_count,
            'Collection.country_count' => count($countries) ,
            'Collection.city_count' => count($cities)
        ) , array(
            'Collection.id' => $collection_id
        ));
        // in collection count update in property table
        $this->Property->updateAll(array(
            'Property.in_collection_count' => $collection_count
        ) , array(
            'Property.id' => $property_id
        ));
    }
}
?>