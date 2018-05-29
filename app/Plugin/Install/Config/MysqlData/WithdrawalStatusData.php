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
class WithdrawalStatusData {

	public $table = 'withdrawal_statuses';

	public $records = array(
		array(
			'id' => '1',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Pending',
			'user_cash_withdrawal_count' => '0'
		),
		array(
			'id' => '2',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Under Process',
			'user_cash_withdrawal_count' => '0'
		),
		array(
			'id' => '3',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Rejected',
			'user_cash_withdrawal_count' => '0'
		),
		array(
			'id' => '4',
			'created' => '2010-04-15 14:20:17',
			'modified' => '2010-04-15 14:20:17',
			'name' => 'Failed',
			'user_cash_withdrawal_count' => '0'
		),
		array(
			'id' => '5',
			'created' => '2010-04-15 14:20:17',
			'modified' => '2010-04-15 14:20:17',
			'name' => 'Success',
			'user_cash_withdrawal_count' => '0'
		),
	);

}
