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
class PaymentGatewaySettingData {

	public $table = 'payment_gateway_settings';

	public $records = array(
		array(
			'id' => '16',
			'created' => '2010-07-15 12:21:33',
			'modified' => '2010-07-15 12:21:33',
			'payment_gateway_id' => '2',
			'name' => 'is_enable_for_property_listing_fee',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for listing fee.'
		),
		array(
			'id' => '20',
			'created' => '2010-07-15 12:21:33',
			'modified' => '2010-07-15 12:21:33',
			'payment_gateway_id' => '2',
			'name' => 'is_enable_for_property_verified_fee',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for verification fee.'
		),
		array(
			'id' => '47',
			'created' => '2013-07-26 21:44:57',
			'modified' => '2013-07-26 21:44:59',
			'payment_gateway_id' => '1',
			'name' => 'sudopay_subscription_plan',
			'type' => 'text',
			'options' => '',
			'test_mode_value' => '',
			'live_mode_value' => '',
			'description' => 'Subscription plan name'
		),
		array(
			'id' => '45',
			'created' => '2013-07-22 17:09:03',
			'modified' => '2013-07-22 17:09:05',
			'payment_gateway_id' => '1',
			'name' => 'sudopay_api_key',
			'type' => 'text',
			'options' => '',
			'test_mode_value' => '',
			'live_mode_value' => '',
			'description' => ''
		),
		array(
			'id' => '46',
			'created' => '2013-07-22 17:20:49',
			'modified' => '2013-07-22 17:20:51',
			'payment_gateway_id' => '1',
			'name' => 'is_payment_via_api',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '',
			'live_mode_value' => '',
			'description' => 'Enable/Disable the current payment option'
		),
		array(
			'id' => '27',
			'created' => '2010-07-15 12:21:33',
			'modified' => '2010-07-15 12:21:33',
			'payment_gateway_id' => '2',
			'name' => 'is_enable_for_book_a_property',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for book property.'
		),
		array(
			'id' => '44',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'payment_gateway_id' => '1',
			'name' => 'is_enable_for_signup_fee',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/disable the current payment options for membership fee'
		),
		array(
			'id' => '43',
			'created' => '2010-07-15 12:21:33',
			'modified' => '2010-07-15 12:21:33',
			'payment_gateway_id' => '1',
			'name' => 'is_enable_for_book_a_property',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for book property.'
		),
		array(
			'id' => '42',
			'created' => '2010-07-15 12:21:33',
			'modified' => '2010-07-15 12:21:33',
			'payment_gateway_id' => '1',
			'name' => 'is_enable_for_add_to_wallet',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for wallet add.'
		),
		array(
			'id' => '41',
			'created' => '2010-07-15 12:21:33',
			'modified' => '2010-07-15 12:21:33',
			'payment_gateway_id' => '1',
			'name' => 'is_enable_for_property_verified_fee',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for verification fee.'
		),
		array(
			'id' => '40',
			'created' => '2010-07-15 12:21:33',
			'modified' => '2010-07-15 12:21:33',
			'payment_gateway_id' => '1',
			'name' => 'is_enable_for_property_listing_fee',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option for listing fee.'
		),
		array(
			'id' => '39',
			'created' => '2013-05-31 13:38:29',
			'modified' => '2013-05-31 13:38:29',
			'payment_gateway_id' => '1',
			'name' => 'sudopay_secret_string',
			'type' => 'text',
			'options' => '',
			'test_mode_value' => '',
			'live_mode_value' => '',
			'description' => ''
		),
		array(
			'id' => '37',
			'created' => '2013-05-31 13:38:29',
			'modified' => '2013-05-31 13:38:29',
			'payment_gateway_id' => '1',
			'name' => 'sudopay_merchant_id',
			'type' => 'text',
			'options' => '',
			'test_mode_value' => '',
			'live_mode_value' => '',
			'description' => ''
		),
		array(
			'id' => '38',
			'created' => '2013-05-31 13:38:29',
			'modified' => '2013-05-31 13:38:29',
			'payment_gateway_id' => '1',
			'name' => 'sudopay_website_id',
			'type' => 'text',
			'options' => '',
			'test_mode_value' => '',
			'live_mode_value' => '',
			'description' => ''
		),
	);

}
