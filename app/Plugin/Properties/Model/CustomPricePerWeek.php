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
class CustomPricePerWeek extends AppModel
{
    public $name = 'CustomPricePerWeek';
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
            )
        );
    }
    function _getCalendarMontlyBooking($property_id, $month, $year)
    {
        $conditions = array();
        $conditions['CustomPricePerWeek.property_id'] = $property_id;
        // checkin must be within the given month n year //
        $conditions['CustomPricePerWeek.start_date <= '] = $year . '-' . $month . '-' . '31' . ' 00:00:00';
        $conditions['CustomPricePerWeek.end_date >= '] = $year . '-' . $month . '-' . '01' . ' 00:00:00';
        // must be active status //
        //$conditions['CustomPricePerNight.is_available'] = 1;
        $custom_weeks_temp = array();
        $custom_weeks = $this->find('all', array(
            'conditions' => $conditions,
            'fields' => array(
                'CustomPricePerWeek.start_date',
                'CustomPricePerWeek.end_date',
                'CustomPricePerWeek.price',
            ) ,
            'order' => array(
                'CustomPricePerWeek.start_date' => 'ASC'
            ) ,
            'recursive' => -1
        ));
        foreach($custom_weeks as $custom_week) {
            $start_date = explode('-', $custom_week['CustomPricePerWeek']['start_date']);
            $end_date = explode('-', $custom_week['CustomPricePerWeek']['end_date']);
            $week = '';
            if ($start_date[1] < $month) {
                $week = $this->getWeekOfTheMonth($start_date[0], $month, 1);
            } else if ($end_date[1] > $month) {
                $week = $this->getWeekOfTheMonth($start_date[0], $month, 28);
            } else {
                $week = $this->getWeekOfTheMonth($start_date[0], $start_date[1], $start_date[2]);
            }
            $custom_weeks_temp[$week] = $custom_week;
        }
        return $custom_weeks_temp;
    }
    function getWeekOfTheMonth($year = 2007, $month = 5, $day = 5)
    {
        return ceil(($day+date("w", mktime(0, 0, 0, $month, 1, $year))) /7);
    }
}
?>