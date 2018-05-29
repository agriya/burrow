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
class DisputeClosedTypeData {

	public $table = 'dispute_closed_types';

	public $records = array(
		array(
			'id' => '1',
			'name' => 'Favor Traveler',
			'dispute_type_id' => '1',
			'is_traveler' => '1',
			'reason' => 'Property doesn\'t match with the one
mentioned in property specification',
			'resolve_type' => 'refunded'
		),
		array(
			'id' => '2',
			'name' => 'Favor host',
			'dispute_type_id' => '1',
			'is_traveler' => '0',
			'reason' => 'Property matches with the mentioned
property specification',
			'resolve_type' => 'resolve without any change'
		),
		array(
			'id' => '5',
			'name' => 'Favor Traveler',
			'dispute_type_id' => '3',
			'is_traveler' => '1',
			'reason' => 'Property doesn\'t matches the quality and requirement/specification',
			'resolve_type' => 'resolve without any change'
		),
		array(
			'id' => '6',
			'name' => 'Favor host',
			'dispute_type_id' => '3',
			'is_traveler' => '0',
			'reason' => 'Property matches the quality and requirement/specification, so host rating changed to positive',
			'resolve_type' => 'Update host rating'
		),
		array(
			'id' => '7',
			'name' => 'Favor Traveler',
			'dispute_type_id' => '1',
			'is_traveler' => '1',
			'reason' => 'Failure to respond in time limit',
			'resolve_type' => 'refunded'
		),
		array(
			'id' => '9',
			'name' => 'Favor host',
			'dispute_type_id' => '3',
			'is_traveler' => '0',
			'reason' => 'Failure to respond in time limit',
			'resolve_type' => 'Update
host rating'
		),
		array(
			'id' => '10',
			'name' => 'Favor Traveler',
			'dispute_type_id' => '4',
			'is_traveler' => '1',
			'reason' => 'Claiming reason doesn\'t match with existing conversation',
			'resolve_type' => 'Deposit amount refunded'
		),
		array(
			'id' => '11',
			'name' => 'Favor Host',
			'dispute_type_id' => '4',
			'is_traveler' => '0',
			'reason' => 'Claiming reason matches with existing conversation',
			'resolve_type' => 'Deposit amount to host'
		),
		array(
			'id' => '12',
			'name' => 'Favor host',
			'dispute_type_id' => '4',
			'is_traveler' => '0',
			'reason' => 'Failure to respond in time limit',
			'resolve_type' => 'Deposit amount to host'
		),
	);

}
