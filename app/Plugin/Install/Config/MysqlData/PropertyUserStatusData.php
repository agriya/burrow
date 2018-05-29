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
class PropertyUserStatusData {

	public $table = 'property_user_statuses';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2011-04-28 18:06:17',
			'modified' => '2011-04-28 18:06:19',
			'name' => 'Waiting for Acceptance',
			'property_user_count' => '0',
			'slug' => 'waiting-for-acceptance',
			'description' => 'Your payment for this booking was successfully collected by ##SITE_NAME##. Host will be paid after ##TRAVELER## checkin. Booking was made by the ##TRAVELER## on ##CREATED_DATE##. Waiting for Host ##HOSTER## to accept the order.'
		),
		array(
			'id' => '2',
			'created' => '2011-04-28 18:06:17',
			'modified' => '2011-04-28 18:06:19',
			'name' => 'Confirmed',
			'property_user_count' => '0',
			'slug' => 'confirmed',
			'description' => 'Booking was accepted by ##HOSTER## on ##ACCEPTED_DATE##.'
		),
		array(
			'id' => '3',
			'created' => '2011-04-28 18:06:17',
			'modified' => '2011-04-28 18:06:19',
			'name' => 'Rejected',
			'property_user_count' => '0',
			'slug' => 'rejected',
			'description' => 'Booking was rejected by the ##HOSTER##. Booking amount has been refunded.'
		),
		array(
			'id' => '4',
			'created' => '2011-04-28 18:06:17',
			'modified' => '2011-04-28 18:06:19',
			'name' => 'Canceled',
			'property_user_count' => '0',
			'slug' => 'canceled',
			'description' => 'Booking was canceled by ##TRAVELER##. Booking amount has been refunded based on cancellation policies.'
		),
		array(
			'id' => '5',
			'created' => '2011-04-28 18:06:17',
			'modified' => '2011-04-28 18:06:19',
			'name' => 'Arrived',
			'property_user_count' => '0',
			'slug' => 'arrived',
			'description' => '##TRAVELER## has arrived.'
		),
		array(
			'id' => '6',
			'created' => '2011-04-28 18:06:17',
			'modified' => '2011-04-28 18:06:19',
			'name' => 'Waiting for Review',
			'property_user_count' => '0',
			'slug' => 'waiting-for-review',
			'description' => '##TRAVELER## has checked out.'
		),
		array(
			'id' => '7',
			'created' => '2011-04-28 18:06:17',
			'modified' => '2011-04-28 18:06:19',
			'name' => 'Payment Cleared',
			'property_user_count' => '0',
			'slug' => 'payment-cleared',
			'description' => '##HOSTER## amount has been released'
		),
		array(
			'id' => '8',
			'created' => '2011-04-28 18:06:17',
			'modified' => '2011-04-28 18:06:19',
			'name' => 'Past',
			'property_user_count' => '0',
			'slug' => 'completed',
			'description' => 'Order completed.'
		),
		array(
			'id' => '9',
			'created' => '2011-04-28 18:06:17',
			'modified' => '2011-04-28 18:06:19',
			'name' => 'Expired',
			'property_user_count' => '0',
			'slug' => 'expired',
			'description' => 'Booking was expired due to non acceptance by the host ##HOSTER##. Booking amount has been refunded.'
		),
		array(
			'id' => '10',
			'created' => '2011-04-28 18:06:17',
			'modified' => '2011-04-28 18:06:19',
			'name' => 'Canceled By Admin',
			'property_user_count' => '0',
			'slug' => 'canceled-by-admin',
			'description' => 'Booking was canceled by Administrator. Booking amount has been refunded based on cancellation policies.'
		),
		array(
			'id' => '12',
			'created' => '2011-05-12 18:17:20',
			'modified' => '2011-05-12 18:17:20',
			'name' => 'PaymentPending',
			'property_user_count' => '0',
			'slug' => 'payment-pending',
			'description' => 'Booking is in payment pending status.'
		),
	);

}
