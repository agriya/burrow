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
class PropertyUserFeedback extends AppModel
{
    public $name = 'PropertyUserFeedback';
    public $actsAs = array(
        'Aggregatable'
    );
    public $hasMany = array(
        'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_id',
            'conditions' => array(
                'Attachment.class =' => 'PropertyUserFeedback'
            ) ,
            'dependent' => true
        )
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'PropertyUser' => array(
            'className' => 'Properties.PropertyUser',
            'foreignKey' => 'property_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Property' => array(
            'className' => 'Properties.Property',
            'foreignKey' => 'property_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'host_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
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
        $queryData['conditions']['PropertyUserFeedback.is_auto_review !='] = 1;
        return parent::beforeFind($queryData);
    }
    function afterSave($created)
    {
        $PropertyUserFeedback = $this->find('first', array(
            'conditions' => array(
                'PropertyUserFeedback.id' => $this->id,
            ) ,
            'fields' => array(
                'PropertyUserFeedback.traveler_user_id',
            ) ,
            'recursive' => -1
        ));
        $this->data['PropertyUserFeedback']['traveler_user_id'] = !empty($this->data['PropertyUserFeedback']['traveler_user_id']) ? $this->data['PropertyUserFeedback']['traveler_user_id'] : $PropertyUserFeedback['PropertyUserFeedback']['traveler_user_id'];
        $this->_updateFeedbackCount($this->data['PropertyUserFeedback']['traveler_user_id']);
        return true;
    }
    function beforeDelete($cascade = true)
    {
        $PropertyUserFeedback = $this->find('first', array(
            'conditions' => array(
                'PropertyUserFeedback.id' => $this->id,
            ) ,
            'fields' => array(
                'PropertyUserFeedback.property_user_id',
            ) ,
            'recursive' => -1
        ));
        $this->data['PropertyUserFeedback']['property_user_id'] = $PropertyUserFeedback['PropertyUserFeedback']['property_user_id'];
        return true;
    }
    function afterDelete()
    {
        $this->_updateFeedbackCount($this->data['PropertyUserFeedback']['property_user_id']);
        return true;
    }
    function _updateFeedbackCount($traveler_user_id)
    {
        $PropertyPossitive = $this->find('count', array(
            'conditions' => array(
                'traveler_user_id' => $traveler_user_id,
                'is_satisfied' => 1
            ) ,
            'recursive' => -1
        ));
        $PropertyFeedback = $this->find('count', array(
            'conditions' => array(
                'traveler_user_id' => $traveler_user_id,
            ) ,
            'recursive' => -1
        ));
        $_data['User']['id'] = $traveler_user_id;
        $_data['User']['traveler_positive_feedback_count'] = $PropertyPossitive;
        $_data['User']['traveler_property_user_count'] = $PropertyFeedback;
        $this->PropertyUser->User->updateAll(array(
            'User.traveler_positive_feedback_count' => $PropertyPossitive,
            'User.traveler_property_user_count' => $PropertyFeedback,
        ) , array(
            'User.id' => $traveler_user_id
        ));
    }
    function _getFeedback($property_user_id)
    {
        $get_feedback = $this->find('first', array(
            'conditions' => array(
                'PropertyUserFeedback.property_user_id' => $property_user_id,
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