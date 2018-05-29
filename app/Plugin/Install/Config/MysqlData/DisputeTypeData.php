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
class DisputeTypeData {

	public $table = 'dispute_types';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2010-12-22 10:46:41',
			'modified' => '2010-12-22 10:46:41',
			'name' => 'Doesn\'t match the
specification as mentioned by the property owner',
			'is_traveler' => '1',
			'is_active' => '1'
		),
		array(
			'id' => '3',
			'created' => '2010-12-22 10:46:41',
			'modified' => '2010-12-22 10:46:41',
			'name' => 'Traveler given
poor feedback',
			'is_traveler' => '0',
			'is_active' => '1'
		),
		array(
			'id' => '4',
			'created' => '',
			'modified' => '',
			'name' => 'Claim the security damage from traveler',
			'is_traveler' => '0',
			'is_active' => '1'
		),
	);

}
