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
class CancellationPolicyData {

	public $table = 'cancellation_policies';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2011-03-11 20:15:24',
			'modified' => '2011-03-11 20:15:24',
			'name' => 'Flexible',
			'days' => '1',
			'percentage' => '100.00',
			'is_active' => '1',
			'property_count' => '0'
		),
		array(
			'id' => '2',
			'created' => '2011-03-11 20:15:24',
			'modified' => '2011-12-15 09:45:53',
			'name' => 'Moderate',
			'days' => '5',
			'percentage' => '100.00',
			'is_active' => '1',
			'property_count' => '0'
		),
		array(
			'id' => '3',
			'created' => '2011-03-11 20:15:24',
			'modified' => '2012-03-15 07:34:44',
			'name' => 'Strict',
			'days' => '7',
			'percentage' => '50.00',
			'is_active' => '1',
			'property_count' => '0'
		),
	);

}
