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
class PropertyFeedback extends AppModel
{
    public $name = 'PropertyFeedback';
    public $actsAs = array(
        'BayesianAverageable' => array(
            'fields' => array(
                'itemId' => 'property_id',
                'rating' => 'is_satisfied',
                'ratingsCount' => 'property_feedback_count',
                'totalRatings' => 'positive_feedback_count',
                'meanRating' => 'mean_rating',
                'bayesianRating' => 'actual_rating',
            ) ,
            'itemModel' => 'Property',
            'cache' => array(
                'config' => null,
                'prefix' => 'BayesianAverage_',
                'calculationDuration' => 10,
            ) ,
        ) ,
        'Aggregatable'
    );
    public $hasMany = array(
        'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_id',
            'conditions' => array(
                'Attachment.class =' => 'PropertyFeedback'
            ) ,
            'dependent' => true
        )
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'Property' => array(
            'className' => 'Properties.Property',
            'foreignKey' => 'property_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'PropertyUser' => array(
            'className' => 'Properties.PropertyUser',
            'foreignKey' => 'property_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Ip' => array(
            'className' => 'Ip',
            'foreignKey' => 'ip_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
		$this->_permanentCacheAssociations = array(
			'Property',
		);
        $this->validate = array(
            'feedback' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
        $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
    function beforeFind($queryData)
    {
        $queryData['conditions']['PropertyFeedback.is_auto_review !='] = 1;
        return parent::beforeFind($queryData);
    }
    function afterSave($created)
    {
        $PropertyFeedback = $this->find('first', array(
            'conditions' => array(
                'PropertyFeedback.id' => $this->id,
            ) ,
            'fields' => array(
                'PropertyFeedback.property_id',
            ) ,
            'recursive' => -1
        ));
        $this->data['PropertyFeedback']['property_id'] = !empty($this->data['PropertyFeedback']['property_id']) ? $this->data['PropertyFeedback']['property_id'] : $PropertyFeedback['PropertyFeedback']['property_id'];
        $this->_updateFeedbackCount($this->data['PropertyFeedback']['property_id']);
        return true;
    }
    function beforeDelete($cascade = true)
    {
        $PropertyFeedback = $this->find('first', array(
            'conditions' => array(
                'PropertyFeedback.id' => $this->id,
            ) ,
            'fields' => array(
                'PropertyFeedback.property_id',
            ) ,
            'recursive' => -1
        ));
        $this->data['PropertyFeedback']['property_id'] = $PropertyFeedback['PropertyFeedback']['property_id'];
        return true;
    }
    function afterDelete()
    {
        $this->_updateFeedbackCount($this->data['PropertyFeedback']['property_id']);
        return true;
    }
    function _updateFeedbackCount($property_id)
    {
        $Property = $this->PropertyUser->Property->find('first', array(
            'conditions' => array(
                'Property.id' => $property_id
            ) ,
            'fields' => array(
                'Property.user_id',
            ) ,
            'recursive' => -1
        ));
        $user_id = $Property['Property']['user_id'];
        $property_ids = $this->PropertyUser->Property->find('list', array(
            'conditions' => array(
                'Property.user_id' => $user_id
            ) ,
            'fields' => array(
                'Property.id',
                'Property.id',
            ) ,
            'recursive' => -1
        ));
        $PropertyPossitive = $this->find('count', array(
            'conditions' => array(
                'property_id' => $property_id,
                'is_satisfied' => 1
            ) ,
            'recursive' => -1
        ));
        $emptyData = $_data['Property']['id'] = $property_id;
        $_data['Property']['positive_feedback_count'] = $PropertyPossitive;
        $this->PropertyUser->Property->save($_data);
        //update user table
        $UserPossitive = $this->find('count', array(
            'conditions' => array(
                'property_id' => $property_ids,
                'is_satisfied' => 1
            ) ,
            'recursive' => -1
        ));
        $UserProperty = $this->find('count', array(
            'conditions' => array(
                'property_id' => $property_ids,
            ) ,
            'recursive' => -1
        ));
        $_data['User']['id'] = $user_id;
        $_data['User']['positive_feedback_count'] = $UserPossitive;
        $_data['User']['property_feedback_count'] = $UserProperty;
        $this->PropertyUser->Property->User->save($_data);
    }
    function _getFeedback($Property_order_id)
    {
        $get_feedback = $this->find('first', array(
            'conditions' => array(
                'PropertyFeedback.Property_user_id' => $Property_order_id,
            ) ,
            'recursive' => -1
        ));
        if (!empty($get_feedback)) {
            return $get_feedback;
        } else {
            return '';
        }
    }
}
?>