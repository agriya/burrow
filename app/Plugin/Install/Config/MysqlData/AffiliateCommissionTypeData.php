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
class AffiliateCommissionTypeData {

	public $table = 'affiliate_commission_types';

	public $records = array(
		array(
			'id' => '1',
			'name' => '%',
			'description' => 'Percentage'
		),
		array(
			'id' => '2',
			'name' => '$',
			'description' => 'Amount'
		),
	);

}
