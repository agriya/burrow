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
class CustomPricePerNight extends AppModel
{
    public $name = 'CustomPricePerNight';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'Property' => array(
            'className' => 'Properties.Property',
            'foreignKey' => 'property_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
		$this->_memcacheModels = array(
			'Property'
		);
        $this->validate = array(
            'property_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
        );
    }
    function _getCalendarMontlyBooking($property_id, $month, $year)
    {
        $conditions = array();
        $conditions['CustomPricePerNight.property_id'] = $property_id;
        // checkin must be within the given month n year //
        $conditions['CustomPricePerNight.start_date <= '] = $year . '-' . $month . '-' . '31' . ' 00:00:00';
        $conditions['CustomPricePerNight.end_date >= '] = $year . '-' . $month . '-' . '01' . ' 00:00:00';
        // must be active status //
        //$conditions['CustomPricePerNight.is_available'] = 1;
        $custom_nights = $this->find('all', array(
            'conditions' => $conditions,
            'fields' => array(
                'CustomPricePerNight.id',
                'CustomPricePerNight.start_date',
                'CustomPricePerNight.end_date',
                'CustomPricePerNight.price',
                'CustomPricePerNight.is_available',
            ) ,
            'order' => array(
                'CustomPricePerNight.start_date' => 'ASC'
            ) ,
            'recursive' => -1
        ));
        return $custom_nights;
    }
}
?>
