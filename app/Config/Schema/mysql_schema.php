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
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $acl_link_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $acl_links = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'controller' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'action' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'named_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'named_value' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'pass_value' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $acl_links_roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'role_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'acl_link_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'acl_link_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'acl_link_id' => array('column' => 'acl_link_id', 'unique' => 0),
			'acl_link_status_id' => array('column' => 'acl_link_status_id', 'unique' => 0),
			'role_id' => array('column' => 'role_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $affiliate_cash_withdrawal_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $affiliate_cash_withdrawals = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'affiliate_cash_withdrawal_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'payment_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'affiliate_cash_withdrawal_status_id' => array('column' => 'affiliate_cash_withdrawal_status_id', 'unique' => 0),
			'payment_gateway_id' => array('column' => 'payment_gateway_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $affiliate_commission_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $affiliate_requests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'site_name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'site_description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'site_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'site_category_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'why_do_you_want_affiliate' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_web_site_marketing' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_search_engine_marketing' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_email_marketing' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'special_promotional_method' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'special_promotional_description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_approved' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 2),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'site_category_id' => array('column' => 'site_category_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $affiliate_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'date', 'null' => false, 'default' => null),
		'modified' => array('type' => 'date', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $affiliate_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'model_name' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'commission' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'affiliate_commission_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'affiliate_commission_type_id' => array('column' => 'affiliate_commission_type_id', 'unique' => 0),
			'model_name' => array('column' => 'model_name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $affiliates = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'foreign_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'affiliate_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'affliate_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'affiliate_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'commission_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'commission_holding_start_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'affiliate_type_id' => array('column' => 'affiliate_type_id', 'unique' => 0),
			'affliate_user_id' => array('column' => 'affliate_user_id', 'unique' => 0),
			'affiliate_status_id' => array('column' => 'affiliate_status_id', 'unique' => 0),
			'class' => array('column' => 'class', 'unique' => 0),
			'foreign_id' => array('column' => 'foreign_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $amenities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $amenities_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'amenity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'index'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'amenity_id' => array('column' => 'amenity_id', 'unique' => 0),
			'property_id' => array('column' => 'property_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $amenities_requests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'amenity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'index'),
		'request_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'amenity_id' => array('column' => 'amenity_id', 'unique' => 0),
			'request_id' => array('column' => 'request_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $attachments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'foreign_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'filename' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'dir' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'mimetype' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'filesize' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'height' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'width' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'thumb' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'amazon_s3_thumb_url' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'amazon_s3_original_url' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'foreign_id' => array('column' => 'foreign_id', 'unique' => 0),
			'class' => array('column' => 'class', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $banned_ips = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'address' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'range' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'referer_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'reason' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'redirect' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'thetime' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 15),
		'timespan' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 15),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'address' => array('column' => 'address', 'unique' => 0),
			'range' => array('column' => 'range', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $bed_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $cake_sessions = array(
		'id' => array('type' => 'string', 'null' => false, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'data' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'expires' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $cancellation_policies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'days' => array('type' => 'integer', 'null' => false, 'default' => null),
		'percentage' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'property_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $cities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'country_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'state_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'latitude' => array('type' => 'float', 'null' => true, 'default' => null),
		'longitude' => array('type' => 'float', 'null' => true, 'default' => null),
		'timezone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'dma_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'county' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 25, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_approved' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'property_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'request_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'country_id' => array('column' => 'country_id', 'unique' => 0),
			'state_id' => array('column' => 'state_id', 'unique' => 0),
			'slug' => array('column' => 'slug', 'unique' => 0),
			'dma_id' => array('column' => 'dma_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $collections = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'property_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'city_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'country_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $collections_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'collection_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'display_order' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'collection_id' => array('column' => 'collection_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $contacts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'first_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'last_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'message' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'telephone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $countries = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'iso_alpha2' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'iso_alpha3' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'iso_numeric' => array('type' => 'integer', 'null' => true, 'default' => null),
		'fips_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'capital' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'areainsqkm' => array('type' => 'float', 'null' => true, 'default' => null),
		'population' => array('type' => 'integer', 'null' => true, 'default' => null),
		'continent' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tld' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'currency' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'currencyName' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'Phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'postalCodeFormat' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'postalCodeRegex' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'languages' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'geonameId' => array('type' => 'integer', 'null' => true, 'default' => null),
		'neighbours' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'equivalentFipsCode' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	public $craigslist_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'code' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $craigslist_markets = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'code' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $currencies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'symbol' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_enabled' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'prefix' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_prefix_display_on_left' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'suffix' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'decimals' => array('type' => 'integer', 'null' => true, 'default' => '2', 'length' => 10),
		'dec_point' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'thousands_sep' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 2, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'locale' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'format_string' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'grouping_algorithm_callback' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_use_graphic_symbol' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $currency_conversion_histories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'currency_conversion_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'rate_before_change' => array('type' => 'float', 'null' => true, 'default' => '0.000000', 'length' => '10,6'),
		'rate' => array('type' => 'float', 'null' => true, 'default' => '0.000000', 'length' => '10,6'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'currency_conversion_id' => array('column' => 'currency_conversion_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $currency_conversions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'currency_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'converted_currency_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'rate' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,6'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'currency_id' => array('column' => 'currency_id', 'unique' => 0),
			'converted_currency_id' => array('column' => 'converted_currency_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $custom_price_per_months = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'start_date' => array('type' => 'date', 'null' => false, 'default' => null, 'key' => 'index'),
		'end_date' => array('type' => 'date', 'null' => false, 'default' => null, 'key' => 'index'),
		'price' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'is_available' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'end_date' => array('column' => 'end_date', 'unique' => 0),
			'start_date' => array('column' => 'start_date', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $custom_price_per_nights = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'start_date' => array('type' => 'date', 'null' => false, 'default' => null, 'key' => 'index'),
		'end_date' => array('type' => 'date', 'null' => false, 'default' => null, 'key' => 'index'),
		'price' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'is_available' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'end_date' => array('column' => 'end_date', 'unique' => 0),
			'start_date' => array('column' => 'start_date', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $custom_price_per_weeks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'start_date' => array('type' => 'date', 'null' => false, 'default' => null, 'key' => 'index'),
		'end_date' => array('type' => 'date', 'null' => false, 'default' => null, 'key' => 'index'),
		'price' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'end_date' => array('column' => 'end_date', 'unique' => 0),
			'start_date' => array('column' => 'start_date', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $dispute_closed_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'dispute_type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'is_traveler' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'reason' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'resolve_type' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'dispute_type_id' => array('column' => 'dispute_type_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $dispute_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $dispute_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_traveler' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $email_templates = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'from' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'reply_to' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email_content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email_text_content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email_variables' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1000, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_html' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $genders = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $habits = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $habits_user_profiles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'habit_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'index'),
		'user_profile_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'habit_id' => array('column' => 'habit_id', 'unique' => 0),
			'user_profile_id' => array('column' => 'user_profile_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $holiday_type_properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'holiday_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'index'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'holiday_type_id' => array('column' => 'holiday_type_id', 'unique' => 0),
			'property_id' => array('column' => 'property_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $holiday_type_requests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'holiday_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'index'),
		'request_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'holiday_type_id' => array('column' => 'holiday_type_id', 'unique' => 0),
			'request_id' => array('column' => 'request_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $holiday_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $ips = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'ip' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'host' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'city_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'state_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'country_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'timezone_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'latitude' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,6'),
		'longitude' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,6'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'city_id' => array('column' => 'city_id', 'unique' => 0),
			'state_id' => array('column' => 'state_id', 'unique' => 0),
			'country_id' => array('column' => 'country_id', 'unique' => 0),
			'timezone_id' => array('column' => 'timezone_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $languages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'iso2' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'iso3' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $message_contents = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'subject' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'message' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'admin_suspend' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_system_flagged' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'detected_suspicious_words' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $messages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'other_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'parent_message_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'message_content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'message_folder_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'is_sender' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_starred' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'is_read' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_deleted' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_archived' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_review' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_communication' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'hash' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'size' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'property_user_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_user_dispute_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'request_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'other_user_id' => array('column' => 'other_user_id', 'unique' => 0),
			'parent_message_id' => array('column' => 'parent_message_id', 'unique' => 0),
			'message_content_id' => array('column' => 'message_content_id', 'unique' => 0),
			'message_folder_id' => array('column' => 'message_folder_id', 'unique' => 0),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'property_user_id' => array('column' => 'property_user_id', 'unique' => 0),
			'property_user_status_id' => array('column' => 'property_user_status_id', 'unique' => 0),
			'request_id' => array('column' => 'request_id', 'unique' => 0),
			'property_user_dispute_id' => array('column' => 'property_user_dispute_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $money_transfer_accounts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'payment_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'account' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_default' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'payment_gateway_id' => array('column' => 'payment_gateway_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $pages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'template' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'draft' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'level' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3),
		'meta_keywords' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'meta_description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'url' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_default' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'title' => array('column' => 'title', 'unique' => 0),
			'parent_id' => array('column' => 'parent_id', 'unique' => 0),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $payment_gateway_settings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'payment_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 256, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 8, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'options' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'test_mode_value' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'live_mode_value' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'payment_gateway_id' => array('column' => 'payment_gateway_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $payment_gateways = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'display_name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'gateway_fees' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'transaction_count' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20),
		'payment_gateway_setting_count' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20),
		'is_mass_pay_enabled' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_test_mode' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $persistent_logins = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'series' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'token' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'expires' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $private_addresses = array(
		'address_prefix' => array('type' => 'string', 'null' => false, 'length' => 11, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'address_prefix', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'cancellation_policy_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'room_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'bed_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'city_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'state_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'country_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'street_view' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'accommodates' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'address' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 300, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'address1' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 300, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'unit' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 256, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'phone' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'commission_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'security_deposit' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'property_flag_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'price_per_night' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'price_per_week' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'price_per_month' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'additional_guest' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 10),
		'additional_guest_price' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'backup_phone' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'house_rules' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'house_manual' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'size' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'measurement' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 256, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'minimum_nights' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'maximum_nights' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'checkin' => array('type' => 'time', 'null' => true, 'default' => null),
		'checkout' => array('type' => 'time', 'null' => true, 'default' => null),
		'verified_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'latitude' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,6'),
		'longitude' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,6'),
		'zoom_level' => array('type' => 'integer', 'null' => false, 'default' => null),
		'rate' => array('type' => 'float', 'null' => true, 'default' => null),
		'bed_rooms' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'beds' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'bath_rooms' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'property_size' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'actual_rating' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'mean_rating' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'detected_suspicious_words' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'price_currency' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'custom_price_per_week_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'custom_price_per_night_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'custom_price_per_month_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'property_user_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'sales_cleared_amount' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'sales_cleared_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'sales_pending_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'sales_pipeline_amount' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'sales_pipeline_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'sales_completed_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'sales_rejected_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'sales_canceled_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'sales_expired_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'sales_lost_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'sales_lost_amount' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'property_view_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'request_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'revenue' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'property_favorite_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'positive_feedback_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'property_feedback_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'property_user_failure_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'property_user_success_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'referred_booking_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'negotiation_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'in_collection_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'admin_suspend' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_pets' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_negotiable' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_system_flagged' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_user_flagged' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_featured' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_approved' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_verified' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'is_show_in_home_page' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_paid' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'video_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'location_manual' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'amenities_set' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 63, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'holiday_types_set' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 15, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_imported_from_airbnb' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'airbnb_property_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'verification_payment_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'verification_sudopay_payment_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'verification_sudopay_pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'verification_sudopay_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'verification_sudopay_revised_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'verification_sudopay_token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'verification_fee' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'listing_payment_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'listing_sudopay_payment_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'listing_sudopay_pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'listing_sudopay_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'listing_sudopay_revised_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'listing_sudopay_token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'listing_fee' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'cancellation_policy_id' => array('column' => 'cancellation_policy_id', 'unique' => 0),
			'property_type_id' => array('column' => 'property_type_id', 'unique' => 0),
			'room_type_id' => array('column' => 'room_type_id', 'unique' => 0),
			'bed_type_id' => array('column' => 'bed_type_id', 'unique' => 0),
			'state_id' => array('column' => 'state_id', 'unique' => 0),
			'airbnb_property_id' => array('column' => 'airbnb_property_id', 'unique' => 0),
			'city_id' => array('column' => 'city_id', 'unique' => 0),
			'country_id' => array('column' => 'country_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0),
			'verification_payment_gateway_id' => array('column' => 'verification_payment_gateway_id', 'unique' => 0),
			'verification_sudopay_pay_key' => array('column' => 'verification_sudopay_pay_key', 'unique' => 0),
			'verification_sudopay_gateway_id' => array('column' => 'verification_sudopay_gateway_id', 'unique' => 0),
			'listing_payment_gateway_id' => array('column' => 'listing_payment_gateway_id', 'unique' => 0),
			'listing_sudopay_pay_key' => array('column' => 'listing_sudopay_pay_key', 'unique' => 0),
			'listing_sudopay_gateway_id' => array('column' => 'listing_sudopay_gateway_id', 'unique' => 0),
			'language_id' => array('column' => 'language_id', 'unique' => 0),
			'verification_sudopay_payment_id' => array('column' => 'verification_sudopay_payment_id', 'unique' => 0),
			'listing_sudopay_payment_id' => array('column' => 'listing_sudopay_payment_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $properties_requests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'request_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'order_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'request_id' => array('column' => 'request_id', 'unique' => 0),
			'order_id' => array('column' => 'order_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $property_favorites = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $property_feedbacks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'feedback' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'admin_comments' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'is_satisfied' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'is_auto_review' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'video_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'property_user_id' => array('column' => 'property_user_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $property_flag_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'date', 'null' => false, 'default' => null),
		'modified' => array('type' => 'date', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'property_flag_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $property_flags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_flag_category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'message' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'property_flag_category_id' => array('column' => 'property_flag_category_id', 'unique' => 0),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $property_ratings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'rating' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '5,2'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'project_id' => array('column' => 'property_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $property_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $property_user_disputes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'is_traveler' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'dispute_type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'reason' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'dispute_status_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'resolved_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'is_favor_traveler' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'last_replied_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'last_replied_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'dispute_closed_type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'dispute_converstation_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'property_user_id' => array('column' => 'property_user_id', 'unique' => 0),
			'dispute_type_id' => array('column' => 'dispute_type_id', 'unique' => 0),
			'dispute_status_id' => array('column' => 'dispute_status_id', 'unique' => 0),
			'last_replied_user_id' => array('column' => 'last_replied_user_id', 'unique' => 0),
			'dispute_closed_type_id' => array('column' => 'dispute_closed_type_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $property_user_feedbacks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'host_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'traveler_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'feedback' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'admin_comments' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'is_satisfied' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'is_auto_review' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'video_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'host_user_id' => array('column' => 'host_user_id', 'unique' => 0),
			'traveler_user_id' => array('column' => 'traveler_user_id', 'unique' => 0),
			'property_user_id' => array('column' => 'property_user_id', 'unique' => 0),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $property_user_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'property_user_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $property_users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_user_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_paypal_connection_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'owner_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'guests' => array('type' => 'integer', 'null' => false, 'default' => null),
		'price' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'original_price' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'reason_for_cancellation' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'affiliate_commission_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'traveler_service_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'host_service_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'security_deposit' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'security_deposit_status' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 2),
		'original_search_address' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 300, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true, 'default' => '1', 'length' => 20, 'key' => 'index'),
		'is_delayed_chained_payment' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_preapproval_payment' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'checkin' => array('type' => 'date', 'null' => false, 'default' => null),
		'checkout' => array('type' => 'date', 'null' => false, 'default' => null),
		'actual_checkin_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'actual_checkout_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'referred_by_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'is_auto_checkin' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'auto_checkin_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'is_host_checkin' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'host_checkin_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'is_traveler_checkin' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'traveler_checkin_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'is_auto_checkout' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'auto_checkout_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'is_host_checkout' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_host_reviewed' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'host_checkout_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'is_traveler_checkout' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'traveler_checkout_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'accepted_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'top_code' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'bottum_code' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'payment_profile_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'cim_approval_code' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'cim_transaction_id' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_payment_cleared' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_negotiation_requested' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'message' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'negotiation_discount' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'negotiate_amount' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'is_negotiated' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_under_dispute' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_security_deposit_dispute_raised' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'message_count' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20),
		'host_private_note' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'traveler_private_note' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'checkin_via_ticket' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'checkout_via_ticket' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'sudopay_payment_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'sudopay_pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'payment_gateway_id' => array('column' => 'payment_gateway_id', 'unique' => 0),
			'property_user_status_id' => array('column' => 'property_user_status_id', 'unique' => 0),
			'user_paypal_connection_id' => array('column' => 'user_paypal_connection_id', 'unique' => 0),
			'owner_user_id' => array('column' => 'owner_user_id', 'unique' => 0),
			'referred_by_user_id' => array('column' => 'referred_by_user_id', 'unique' => 0),
			'payment_profile_id' => array('column' => 'payment_profile_id', 'unique' => 0),
			'sudopay_gateway_id' => array('column' => array('sudopay_gateway_id', 'sudopay_pay_key'), 'unique' => 0),
			'cim_transaction_id' => array('column' => 'cim_transaction_id', 'unique' => 0),
			'sudopay_payment_id' => array('column' => 'sudopay_payment_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $property_views = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0),
			'property_id' => array('column' => 'property_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $request_favorites = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'request_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'request_id' => array('column' => 'request_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $request_flag_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'date', 'null' => false, 'default' => null),
		'modified' => array('type' => 'date', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'request_flag_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $request_flags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'request_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'request_flag_category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'message' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'request_flag_category_id' => array('column' => 'request_flag_category_id', 'unique' => 0),
			'request_id' => array('column' => 'request_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $request_views = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'request_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'request_id' => array('column' => 'request_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $requests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'city_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'state_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'country_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'currency_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'property_type_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'bed_type_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'room_type_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'address' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'accommodates' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'latitude' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,6'),
		'longitude' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,6'),
		'zoom_level' => array('type' => 'integer', 'null' => true, 'default' => '5'),
		'postal_code' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 15),
		'preference' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'checkin' => array('type' => 'date', 'null' => true, 'default' => null),
		'checkout' => array('type' => 'date', 'null' => true, 'default' => null),
		'price_per_night' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_alert' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_system_flagged' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20),
		'is_user_flagged' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'admin_suspend' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'detected_suspicious_words' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'property_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'request_flag_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'request_view_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'request_favorite_count' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20),
		'is_approved' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'amenities_set' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 63, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'holiday_types_set' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 15, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'city_id' => array('column' => 'city_id', 'unique' => 0),
			'state_id' => array('column' => 'state_id', 'unique' => 0),
			'country_id' => array('column' => 'country_id', 'unique' => 0),
			'currency_id' => array('column' => 'currency_id', 'unique' => 0),
			'property_type_id' => array('column' => 'property_type_id', 'unique' => 0),
			'bed_type_id' => array('column' => 'bed_type_id', 'unique' => 0),
			'room_type_id' => array('column' => 'room_type_id', 'unique' => 0),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $revisions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 15, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'node_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'revision_number' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'node_id' => array('column' => 'node_id', 'unique' => 0),
			'revision_number' => array('column' => 'revision_number', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'type' => array('column' => 'type', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $room_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $search_keywords = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'keyword' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'search_log_count' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $search_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'search_keyword_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'type' => array('type' => 'integer', 'null' => true, 'default' => '6'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'search_keyword_id' => array('column' => 'search_keyword_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $security_questions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $setting_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'plugin_name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0),
			'parent_id' => array('column' => 'parent_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $settings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'setting_category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'setting_category_parent_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'value' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 8, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'options' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'label' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'order' => array('type' => 'integer', 'null' => false, 'default' => null),
		'plugin_name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'setting_category_id' => array('column' => 'setting_category_id', 'unique' => 0),
			'name' => array('column' => 'name', 'unique' => 0),
			'setting_category_parent_id' => array('column' => 'setting_category_parent_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $site_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $social_contact_details = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'facebook_user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'twitter_user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'googleplus_user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'angellist_user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'linkedin_user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'social_contact_count' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'facebook_user_id' => array('column' => 'facebook_user_id', 'unique' => 0),
			'twitter_user_id' => array('column' => 'twitter_user_id', 'unique' => 0),
			'googleplus_user_id' => array('column' => 'googleplus_user_id', 'unique' => 0),
			'angellist_user_id' => array('column' => 'angellist_user_id', 'unique' => 0),
			'linkedin_user_id' => array('column' => 'linkedin_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $social_contacts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'social_source_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'social_contact_detail_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'social_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'social_source_id' => array('column' => 'social_source_id', 'unique' => 0),
			'social_contact_detail_id' => array('column' => 'social_contact_detail_id', 'unique' => 0),
			'social_user_id' => array('column' => 'social_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $states = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'country_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 8, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'adm1code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_approved' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'country_id' => array('column' => 'country_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $subscriptions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_subscribed' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'unsubscribed_on' => array('type' => 'date', 'null' => false, 'default' => null),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'invite_hash' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'site_state_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'key' => 'index'),
		'is_sent_private_beta_mail' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_social_like' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_invite' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'invite_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'is_email_verified' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'email' => array('column' => 'email', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0),
			'site_state_id' => array('column' => 'site_state_id', 'unique' => 0),
			'invite_user_id' => array('column' => 'invite_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $sudopay_ipn_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'ip' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'post_variable' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $sudopay_payment_gateways = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'sudopay_gateway_name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'sudopay_payment_group_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'sudopay_gateway_details' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_marketplace_supported' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'sudopay_gateway_id' => array('column' => 'sudopay_gateway_id', 'unique' => 0),
			'sudopay_payment_group_id' => array('column' => 'sudopay_payment_group_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $sudopay_payment_gateways_users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'sudopay_payment_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'sudopay_payment_gateway_id' => array('column' => 'sudopay_payment_gateway_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $sudopay_payment_groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'sudopay_group_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'thumb_url' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'sudopay_group_id' => array('column' => 'sudopay_group_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $sudopay_transaction_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'payment_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'foreign_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'sudopay_pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'merchant_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'gateway_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'gateway_name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'payment_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'buyer_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'buyer_email' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'buyer_address' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'payment_id' => array('column' => 'payment_id', 'unique' => 0),
			'class' => array('column' => 'class', 'unique' => 0),
			'foreign_id' => array('column' => 'foreign_id', 'unique' => 0),
			'merchant_id' => array('column' => 'merchant_id', 'unique' => 0),
			'gateway_id' => array('column' => 'gateway_id', 'unique' => 0),
			'buyer_id' => array('column' => 'buyer_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $timezones = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'gmt_offset' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $transaction_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_credit' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_credit_to_receiver' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_credit_to_admin' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'message' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'message_for_receiver' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'message_for_admin' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'transaction_variables' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $transactions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'receiver_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'foreign_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 25, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'transaction_type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'gateway_fees' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'transaction_type_id' => array('column' => 'transaction_type_id', 'unique' => 0),
			'payment_gateway_id' => array('column' => 'payment_gateway_id', 'unique' => 0),
			'foreign_id' => array('column' => 'foreign_id', 'unique' => 0),
			'class' => array('column' => 'class', 'unique' => 0),
			'receiver_user_id' => array('column' => 'receiver_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $translations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'name' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'lang_text' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_translated' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_google_translate' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_verified' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'language_id' => array('column' => 'language_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_add_wallet_amounts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'payment_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'is_success' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'user_paypal_connection_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'sudopay_payment_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'sudopay_pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'sudopay_revised_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'sudopay_token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'payment_gateway_id' => array('column' => 'payment_gateway_id', 'unique' => 0),
			'user_paypal_connection_id' => array('column' => 'user_paypal_connection_id', 'unique' => 0),
			'sudopay_gateway_id' => array('column' => array('sudopay_gateway_id', 'sudopay_pay_key'), 'unique' => 0),
			'sudopay_payment_id' => array('column' => 'sudopay_payment_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_cash_withdrawals = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'withdrawal_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'remark' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'withdrawal_status_id' => array('column' => 'withdrawal_status_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'posted_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'comment' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'posted_user_id' => array('column' => 'posted_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_educations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'education' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_employments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'employment' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_facebook_friends = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'facebook_friend_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'facebook_friend_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'facebook_friend_id' => array('column' => 'facebook_friend_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_followers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'followed_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'followed_user_id' => array('column' => 'followed_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_income_ranges = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'income' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_logins = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_login_ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'user_agent' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'dns' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'user_login_ip_id' => array('column' => 'user_login_ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_notifications = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'is_new_property_order_host_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_new_property_order_traveler_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_accept_property_order_traveler_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_accept_property_order_host_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_reject_property_order_traveler_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_reject_property_order_host_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_cancel_property_order_host_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_cancel_property_order_traveler_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_arrival_host_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_arrival_traveler_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_review_property_order_traveler_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_review_property_order_host_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_cleared_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_complete_property_order_host_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_complete_property_order_traveler_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_expire_property_order_host_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_expire_property_order_traveler_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_admin_cancel_property_order_host_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_admin_cancel_traveler_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_complete_later_property_order_host_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_complete_later_property_order_traveler_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_recieve_dispute_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_contact_notification' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_openids = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'openid' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_profiles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'language_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'first_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'last_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'middle_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'gender_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 2, 'key' => 'index'),
		'dob' => array('type' => 'date', 'null' => true, 'default' => null),
		'about_me' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'school' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'work' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'paypal_account' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'paypal_first_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'paypal_last_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'own_home' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'have_children' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'user_education_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_employment_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_income_range_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_relationship_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'address' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'city_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'state_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'country_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'zip_code' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'backup_phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'message_page_size' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3),
		'message_signature' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'city_id' => array('column' => 'city_id', 'unique' => 0),
			'state_id' => array('column' => 'state_id', 'unique' => 0),
			'country_id' => array('column' => 'country_id', 'unique' => 0),
			'gender_id' => array('column' => 'gender_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'language_id' => array('column' => 'language_id', 'unique' => 0),
			'user_education_id' => array('column' => 'user_education_id', 'unique' => 0),
			'user_employment_id' => array('column' => 'user_employment_id', 'unique' => 0),
			'user_incomerange_id' => array('column' => 'user_income_range_id', 'unique' => 0),
			'user_relationship_id' => array('column' => 'user_relationship_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_relationships = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'relationship' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_views = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'viewing_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'viewing_user_id' => array('column' => 'viewing_user_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'role_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'index'),
		'attachment_id' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 20, 'key' => 'index'),
		'username' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'available_wallet_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'blocked_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'cleared_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'dns' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'total_amount_withdrawn' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'total_withdraw_request_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'total_amount_deposited' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'property_feedback_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'host_expired_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'host_canceled_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'host_rejected_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'host_completed_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'host_review_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'host_arrived_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'host_confirmed_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'host_waiting_for_acceptance_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'host_negotiation_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'host_payment_cleared_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'host_total_booked_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'host_total_lost_booked_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'host_total_earned_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'host_total_lost_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'host_total_pipeline_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'host_total_site_revenue' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'travel_expired_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'travel_rejected_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'travel_canceled_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'travel_review_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'travel_completed_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'travel_arrived_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'travel_confirmed_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'travel_payment_pending_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'travel_waiting_for_acceptance_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'travel_negotiation_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'travel_payment_cleared_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'traveler_positive_feedback_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'traveler_property_user_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'travel_total_booked_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'travel_total_booked_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'travel_total_lost_booked_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'travel_total_site_revenue' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'positive_feedback_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'property_favorite_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'property_user_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'request_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'property_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'property_pending_approval_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'property_inactive_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'referred_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'referred_by_user_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'referred_booking_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'affiliate_refer_booking_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'user_referred_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'total_commission_pending_amount' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'total_commission_canceled_amount' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'total_commission_completed_amount' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'commission_line_amount' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'commission_withdraw_request_amount' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'commission_paid_amount' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'cim_profile_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_login_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'user_view_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'user_friend_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'user_comment_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'cookie_hash' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'cookie_time_modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'is_agree_terms_conditions' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_email_confirmed' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_affiliate_user' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'ip_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'last_login_ip_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'last_logged_in_time' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_facebook_friend_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'is_show_facebook_friends' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'is_facebook_friends_fetched' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'network_fb_user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'last_facebook_friend_fetched_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'is_paid' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'security_question_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'security_answer' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_facebook_register' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_twitter_register' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_google_register' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_googleplus_register' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_yahoo_register' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_linkedin_register' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_openid_register' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'facebook_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'facebook_access_token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'twitter_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'twitter_access_token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'twitter_access_key' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'google_user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'google_access_token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'googleplus_user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'yahoo_user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'yahoo_access_token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'linkedin_user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'linkedin_access_token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'openid_user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'twitter_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'google_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'googleplus_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'linkedin_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'facebook_friends_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'twitter_followers_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'google_contacts_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'googleplus_contacts_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'yahoo_contacts_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'linkedin_contacts_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'user_openid_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'is_skipped_fb' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_skipped_twitter' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_skipped_google' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_skipped_yahoo' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_skipped_linkedin' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_facebook_connected' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_twitter_connected' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_google_connected' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_googleplus_connected' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_yahoo_connected' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_linkedin_connected' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'site_state_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'key' => 'index'),
		'user_avatar_source_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'key' => 'index'),
		'mobile_app_hash' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'mobile_app_time_modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'is_idle' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_property_posted' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_requested' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_property_booked' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'invite_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'activity_message_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'payment_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'sudopay_pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'sudopay_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'sudopay_payment_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'sudopay_revised_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'sudopay_token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'pwd_reset_token' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'pwd_reset_requested_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'role_id' => array('column' => 'role_id', 'unique' => 0),
			'username' => array('column' => 'username', 'unique' => 0),
			'email' => array('column' => 'email', 'unique' => 0),
			'referred_by_user_id' => array('column' => 'referred_by_user_id', 'unique' => 0),
			'network_fb_user_id' => array('column' => 'network_fb_user_id', 'unique' => 0),
			'cim_profile_id' => array('column' => 'cim_profile_id', 'unique' => 0),
			'activity_message_id' => array('column' => 'activity_message_id', 'unique' => 0),
			'payment_gateway_id' => array('column' => array('payment_gateway_id', 'sudopay_pay_key', 'sudopay_gateway_id'), 'unique' => 0),
			'attachment_id' => array('column' => 'attachment_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0),
			'last_login_ip_id' => array('column' => 'last_login_ip_id', 'unique' => 0),
			'security_question_id' => array('column' => 'security_question_id', 'unique' => 0),
			'facebook_user_id' => array('column' => 'facebook_user_id', 'unique' => 0),
			'twitter_user_id' => array('column' => 'twitter_user_id', 'unique' => 0),
			'google_user_id' => array('column' => 'google_user_id', 'unique' => 0),
			'googleplus_user_id' => array('column' => 'googleplus_user_id', 'unique' => 0),
			'yahoo_user_id' => array('column' => 'yahoo_user_id', 'unique' => 0),
			'linkedin_user_id' => array('column' => 'linkedin_user_id', 'unique' => 0),
			'openid_user_id' => array('column' => 'openid_user_id', 'unique' => 0),
			'site_state_id' => array('column' => 'site_state_id', 'unique' => 0),
			'user_avatar_source_id' => array('column' => 'user_avatar_source_id', 'unique' => 0),
			'sudopay_gateway_id' => array('column' => 'sudopay_gateway_id', 'unique' => 0),
			'sudopay_payment_id' => array('column' => 'sudopay_payment_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $withdrawal_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'user_cash_withdrawal_count' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
}
