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
class AffiliateTypeData {

	public $table = 'affiliate_types';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2011-02-08 00:00:00',
			'modified' => '2012-04-03 11:18:59',
			'name' => 'Sign Up',
			'model_name' => 'User',
			'commission' => '0.00',
			'affiliate_commission_type_id' => '2',
			'is_active' => '1'
		),
		array(
			'id' => '2',
			'created' => '2011-02-08 00:00:00',
			'modified' => '2012-04-03 11:18:59',
			'name' => 'Booking',
			'model_name' => 'PropertyUser',
			'commission' => '2.00',
			'affiliate_commission_type_id' => '1',
			'is_active' => '1'
		),
	);

}
