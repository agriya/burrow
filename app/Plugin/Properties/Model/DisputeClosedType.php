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
class DisputeClosedType extends AppModel
{
    public $name = 'DisputeClosedType';
    public $displayField = 'name';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'DisputeType' => array(
            'className' => 'Properties.DisputeType',
            'foreignKey' => 'dispute_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
    );
    public $hasMany = array(
        'PropertyUserDispute' => array(
            'className' => 'Properties.PropertyUserDispute',
            'foreignKey' => 'dispute_closed_type_id',
            'dependent' => false,
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
    }
    function getDisputeClosedType($close_type_id)
    {
        $get_close_type = $this->find('first', array(
            'conditions' => array(
                'DisputeClosedType.id' => $close_type_id
            ) ,
            'recursive' => -1
        ));
        if (!empty($get_close_type)) {
            return $get_close_type;
        } else {
            return '';
        }
    }
}
?>