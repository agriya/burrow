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
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $acl_links = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'controller' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'action' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'named_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'named_value' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'pass_value' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
	public $adaptive_ipn_logs = array(
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
	public $adaptive_transaction_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'foreign_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'transaction_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'amount' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'primary' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'invoice_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'refunded_amount' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'pending_refund' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'sender_transaction_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'sender_transaction_status' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'timestamp' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ack' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'correlation_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'build' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'currency_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'sender_email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tracking_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'paypal_pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'action_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'fees_payer' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'memo' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'reverse_all_parallel_payments_on_error' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'refund_status' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'refund_net_amount' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'refund_fee_amount' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'refund_gross_amount' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'total_of_alll_refunds' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'refund_has_become_full' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'encrypted_refund_transaction_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'refund_transaction_status' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'paypal_post_vars' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'transaction_id' => array('column' => 'transaction_id', 'unique' => 0),
			'class' => array('column' => 'class', 'unique' => 0),
			'foreign_id' => array('column' => 'foreign_id', 'unique' => 0),
			'invoice_id' => array('column' => 'invoice_id', 'unique' => 0),
			'tracking_id' => array('column' => 'tracking_id', 'unique' => 0),
			'correlation_id' => array('column' => 'correlation_id', 'unique' => 0),
			'sender_transaction_id' => array('column' => 'sender_transaction_id', 'unique' => 0),
			'encrypted_refund_transaction_id' => array('column' => 'encrypted_refund_transaction_id', 'unique' => 0)
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
			'payment_gateway_id' => array('column' => 'payment_gateway_id', 'unique' => 0),
			'affiliate_cash_withdrawal_status_id' => array('column' => 'affiliate_cash_withdrawal_status_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $affiliate_commission_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
		'is_approved' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4),
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
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $affiliate_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'model_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'commission' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'affiliate_commission_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'plugin_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 220, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'affiliate_commission_type_id' => array('column' => 'affiliate_commission_type_id', 'unique' => 0),
			'plugin_name' => array('column' => 'plugin_name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $affiliates = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'class' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'foreign_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'affiliate_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'affliate_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'affiliate_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'commission_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'commission_holding_start_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'class' => array('column' => 'class', 'unique' => 0),
			'foreign_id' => array('column' => 'foreign_id', 'unique' => 0),
			'affiliate_type_id' => array('column' => 'affiliate_type_id', 'unique' => 0),
			'affliate_user_id' => array('column' => 'affliate_user_id', 'unique' => 0),
			'affiliate_status_id' => array('column' => 'affiliate_status_id', 'unique' => 0)
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
		'amazon_s3_thumb_url' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'amazon_s3_original_url' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
	public $blocks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'region_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'alias' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'body' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'show_title' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
		'element' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'visibility_roles' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'visibility_paths' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'visibility_php' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'params' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'plugin_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 220, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'alias' => array('column' => 'alias', 'unique' => 1),
			'region_id' => array('column' => 'region_id', 'unique' => 0),
			'plugin_name' => array('column' => 'plugin_name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $blog_comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'blog_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'comment' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'is_admin_suspended' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'is_system_flagged' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'detected_suspicious_words' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'blog_id' => array('column' => 'blog_id', 'unique' => 0),
			'is_admin_suspended' => array('column' => 'is_admin_suspended', 'unique' => 0),
			'is_system_flagged' => array('column' => 'is_system_flagged', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'project_id' => array('column' => 'project_id', 'unique' => 0),
			'project_type_id' => array('column' => 'project_type_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $blog_tags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 110, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'blog_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $blog_views = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'blog_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'blog_id' => array('column' => 'blog_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $blogs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 260, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'detected_suspicious_words' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'blog_comment_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'blog_view_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'blog_tag_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'is_admin_suspended' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_published' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_system_flagged' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'project_id' => array('column' => 'project_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'project_type_id' => array('column' => 'project_type_id', 'unique' => 0),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $blogs_blog_tags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'blog_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'blog_tag_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'blog_id' => array('column' => 'blog_id', 'unique' => 0),
			'blog_tag_id' => array('column' => 'blog_tag_id', 'unique' => 0)
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
	public $cities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'country_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'state_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'latitude' => array('type' => 'float', 'null' => true, 'default' => null),
		'longitude' => array('type' => 'float', 'null' => true, 'default' => null),
		'timezone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'dma_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'county' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 25, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_approved' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'project_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'language_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'country_id' => array('column' => 'country_id', 'unique' => 0),
			'state_id' => array('column' => 'state_id', 'unique' => 0),
			'is_approved' => array('column' => 'is_approved', 'unique' => 0),
			'slug' => array('column' => 'slug', 'unique' => 0),
			'dma_id' => array('column' => 'dma_id', 'unique' => 0),
			'language_id' => array('column' => 'language_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'node_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'website' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ip' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'body' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'rating' => array('type' => 'integer', 'null' => true, 'default' => null),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'notify' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'comment_type' => array('type' => 'string', 'null' => false, 'default' => 'comment', 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'parent_id' => array('column' => 'parent_id', 'unique' => 0),
			'node_id' => array('column' => 'node_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'lft' => array('column' => 'lft', 'unique' => 0),
			'rght' => array('column' => 'rght', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $contacts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'first_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'last_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'message' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'telephone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
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
	public $credit_scores = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'interest_rate' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'suggested_interest_rate' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'is_approved' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $donate_project_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'donate_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'is_approved' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $donate_project_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'donate_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null, 'key' => 'index'),
		'message' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'is_active' => array('column' => 'is_active', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $educations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'education' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
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
		'email_text_content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email_html_content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email_variables' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1000, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_html' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $employments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'employment' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $facebook_comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'facebook_user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'facebook_comment_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'facebook_comment_creater_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'comment_content' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'href' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'facebook_user_id' => array('column' => 'facebook_user_id', 'unique' => 0),
			'facebook_comment_id' => array('column' => 'facebook_comment_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $form_field_groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 100, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'project_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'form_field_step_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'info' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'order' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'class' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'is_deletable' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'is_editable' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 0),
			'project_type_id' => array('column' => 'project_type_id', 'unique' => 0),
			'form_field_step_id' => array('column' => 'form_field_step_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
	public $form_field_steps = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'project_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'info' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'order' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'is_deletable' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_splash' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'additional_info' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'is_payment_step' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_editable' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 0),
			'project_type_id' => array('column' => 'project_type_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
	public $form_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'display_text' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'label' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8_unicode_ci', 'comment' => 'text', 'charset' => 'utf8'),
		'info' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'project_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'required' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'depends_on' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'depends_value' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'order' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'options' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'form_field_group_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'is_deletable' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'is_dynamic_field' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_show_display_text_field' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'is_editable' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'project_type_id' => array('column' => 'project_type_id', 'unique' => 0),
			'form_field_group_id' => array('column' => 'form_field_group_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $genders = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $income_ranges = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'income' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $invest_project_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'invest_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'is_approved' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $invest_project_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'invest_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null, 'key' => 'index'),
		'message' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'is_active' => array('column' => 'is_active', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $ips = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'ip' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'host' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'city_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'state_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'country_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'timezone_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'latitude' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,6'),
		'longitude' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,6'),
		'user_agent' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'city_id' => array('column' => 'city_id', 'unique' => 0),
			'state_id' => array('column' => 'state_id', 'unique' => 0),
			'country_id' => array('column' => 'country_id', 'unique' => 0),
			'timezone_id' => array('column' => 'timezone_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $jobs_act_entries = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'net_worth' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'annual_income_individual' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'annual_income_with_spouse' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'total_asset' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'household_income' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'annual_expenses' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'liquid_net_worth' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'number_of_dependents' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
	public $languages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 80, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'iso2' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 5, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'iso3' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 5, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $lend_names = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'average_rate' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'total_repayment_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'total_repayment_percentage' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'total_repayment_interest_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'project_fund_count' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $lend_names_credit_scores = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'lend_name_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'credit_score_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'lend_name_id' => array('column' => 'lend_name_id', 'unique' => 0),
			'credit_score_id' => array('column' => 'credit_score_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $lend_names_lend_project_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'lend_name_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'lend_project_category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'lend_name_id' => array('column' => 'lend_name_id', 'unique' => 0),
			'lend_project_category_id' => array('column' => 'lend_project_category_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $lend_names_loan_terms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'lend_name_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'loan_term_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'lend_name_id' => array('column' => 'lend_name_id', 'unique' => 0),
			'loan_term_id' => array('column' => 'loan_term_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $lend_project_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'lend_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'is_approved' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $lend_project_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'lend_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null, 'key' => 'index'),
		'message' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'is_active' => array('column' => 'is_active', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $links = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'menu_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'class' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'link' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'target' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'rel' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'visibility_roles' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'params' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'parent_id' => array('column' => 'parent_id', 'unique' => 0),
			'menu_id' => array('column' => 'menu_id', 'unique' => 0),
			'lft' => array('column' => 'lft', 'unique' => 0),
			'rght' => array('column' => 'rght', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $loan_terms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'months' => array('type' => 'integer', 'null' => false, 'default' => null),
		'is_approved' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $menus = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'alias' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'class' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
		'link_count' => array('type' => 'integer', 'null' => false, 'default' => null),
		'params' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'alias' => array('column' => 'alias', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $message_contents = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'subject' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'message' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_admin_suspended' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_system_flagged' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'detected_suspicious_words' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $message_filters = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'from_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'to_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'has_words' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'does_not_has_words' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'to_user_id' => array('column' => 'to_user_id', 'unique' => 0),
			'subject' => array('column' => 'subject', 'unique' => 0),
			'from_user_id' => array('column' => 'from_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $message_folders = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $messages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'foreign_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'other_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'parent_message_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'message_content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'message_folder_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'is_sender' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_starred' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'is_read' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_private' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_deleted' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_archived' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_communication' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'size' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'project_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_type_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'key' => 'index'),
		'project_status_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'key' => 'index'),
		'root' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'freshness_ts' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'key' => 'index'),
		'depth' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'index'),
		'path' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'materialized_path' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 256, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'activity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'activity_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'is_activity' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_anonymous_fund' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_hide_from_public' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_child_replied' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_hide_rejected_activity' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'other_user_id' => array('column' => 'other_user_id', 'unique' => 0),
			'parent_message_id' => array('column' => 'parent_message_id', 'unique' => 0),
			'message_content_id' => array('column' => 'message_content_id', 'unique' => 0),
			'message_folder_id' => array('column' => 'message_folder_id', 'unique' => 0),
			'project_id' => array('column' => 'project_id', 'unique' => 0),
			'root' => array('column' => 'root', 'unique' => 0),
			'freshness_ts' => array('column' => 'freshness_ts', 'unique' => 0),
			'depth' => array('column' => 'depth', 'unique' => 0),
			'materialized_path' => array('column' => 'materialized_path', 'unique' => 0),
			'activity_id' => array('column' => 'activity_id', 'unique' => 0),
			'project_type_id' => array('column' => 'project_type_id', 'unique' => 0),
			'activity_user_id' => array('column' => 'activity_user_id', 'unique' => 0),
			'project_status_id' => array('column' => 'project_status_id', 'unique' => 0),
			'foreign_id' => array('column' => 'foreign_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $meta = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'model' => array('type' => 'string', 'null' => false, 'default' => 'Node', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'value' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $money_transfer_accounts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'payment_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'account' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_default' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'payment_gateway_id' => array('column' => 'payment_gateway_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $nodes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'body' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'excerpt' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'mime_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'comment_status' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1),
		'comment_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'promote' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'path' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'terms' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'sticky' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'visibility_roles' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'string', 'null' => false, 'default' => 'node', 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'type_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'plugin_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 220, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'parent_id' => array('column' => 'parent_id', 'unique' => 0),
			'slug' => array('column' => 'slug', 'unique' => 0),
			'lft' => array('column' => 'lft', 'unique' => 0),
			'rght' => array('column' => 'rght', 'unique' => 0),
			'type_id' => array('column' => 'type_id', 'unique' => 0),
			'plugin_name' => array('column' => 'plugin_name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $nodes_taxonomies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'node_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'taxonomy_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'node_id' => array('column' => 'node_id', 'unique' => 0),
			'taxonomy_id' => array('column' => 'taxonomy_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $payapi_ipn_logs = array(
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
	public $payapi_transaction_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'payment_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'class' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'foreign_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'payapi_pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'merchant_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'gateway_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'gateway_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'payment_type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'buyer_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'buyer_email' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'buyer_address' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'display_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'gateway_fees' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'transaction_count' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20),
		'payment_gateway_setting_count' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20),
		'is_test_mode' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_mass_pay_enabled' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $paypal_accounts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'payment_types' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 8, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'first_name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'last_name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'dob' => array('type' => 'date', 'null' => true, 'default' => null),
		'address1' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'address2' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'state' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'paypal_country_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'zip' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'paypal_citizenship_country_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'currency_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'phone' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'create_account_key' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'paypal_country_id' => array('column' => 'paypal_country_id', 'unique' => 0),
			'paypal_citizenship_country_id' => array('column' => 'paypal_citizenship_country_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $paypal_citizenship_countries = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'code' => array('column' => 'code', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $paypal_countries = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'code' => array('column' => 'code', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $paypal_transaction_logs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'date_added' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'transaction_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'currency_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'txn_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'payer_email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'payment_date' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'to_digicurrency' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'to_account_no' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'to_account_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'fees_paid_by' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'mc_gross' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '50,5'),
		'mc_fee' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '50,5'),
		'mc_currency' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 12, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'payment_status' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'pending_reason' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'receiver_email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'paypal_response' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'error_no' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4),
		'error_message' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'memo' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'paypal_post_vars' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_mass_pay' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'mass_pay_status' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'masspay_response' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'user_cash_withdrawal_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'affiliate_cash_withdrawal_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'txn_id' => array('column' => 'txn_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'transaction_id' => array('column' => 'transaction_id', 'unique' => 0),
			'user_cash_withdrawal_id' => array('column' => 'user_cash_withdrawal_id', 'unique' => 0),
			'affiliate_cash_withdrawal_id' => array('column' => 'affiliate_cash_withdrawal_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $persistent_logins = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'series' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'token' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'expires' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
	public $pledge_project_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 265, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'pledge_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'is_approved' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $pledge_project_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'pledge_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'message' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_donate_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'donate_project_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'index'),
		'donate_project_category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'pledge_type_id' => array('type' => 'integer', 'null' => true, 'default' => '1', 'length' => 20, 'key' => 'index'),
		'min_amount_to_fund' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'project_donate_goal_reached_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'is_allow_over_donating' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'project_id' => array('column' => 'project_id', 'unique' => 0),
			'pledge_type_id' => array('column' => 'pledge_type_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'donate_project_status_id' => array('column' => 'donate_project_status_id', 'unique' => 0),
			'donate_project_category_id' => array('column' => 'donate_project_category_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_feeds = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'favicon' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sitename' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'link' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'date' => array('type' => 'datetime', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'date' => array('column' => 'date', 'unique' => 0),
			'project_type_id' => array('column' => 'project_type_id', 'unique' => 0),
			'project_id' => array('column' => 'project_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
	public $project_flag_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'date', 'null' => false, 'default' => null),
		'modified' => array('type' => 'date', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'project_flag_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_flags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'date', 'null' => false, 'default' => null),
		'modified' => array('type' => 'date', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'project_flag_category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'message' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'project_flag_category_id' => array('column' => 'project_flag_category_id', 'unique' => 0),
			'project_id' => array('column' => 'project_id', 'unique' => 0),
			'project_type_id' => array('column' => 'project_type_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_followers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'project_id' => array('column' => 'project_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'project_type_id' => array('column' => 'project_type_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_fund_donate_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'project_fund_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'description' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'project_fund_id' => array('column' => 'project_fund_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
	public $project_fund_invest_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'project_fund_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'shares_allocated' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'project_fund_id' => array('column' => 'project_fund_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_fund_lend_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'project_fund_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'interest_rate' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'project_fund_id' => array('column' => 'project_fund_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_fund_pledge_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'project_fund_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_reward_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'shipping_address' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shipping_address1' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'city_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'state_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'country_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'zip_code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'additional_info' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'project_fund_id' => array('column' => 'project_fund_id', 'unique' => 0),
			'project_reward_id' => array('column' => 'project_reward_id', 'unique' => 0),
			'city_id' => array('column' => 'city_id', 'unique' => 0),
			'state_id' => array('column' => 'state_id', 'unique' => 0),
			'country_id' => array('column' => 'country_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
	public $project_fund_repayments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'owner_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_fund_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_repayment_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'interest' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'interest_rate' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'term' => array('type' => 'integer', 'null' => false, 'default' => null),
		'is_late' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'owner_user_id' => array('column' => 'owner_user_id', 'unique' => 0),
			'project_id' => array('column' => 'project_id', 'unique' => 0),
			'project_fund_id' => array('column' => 'project_fund_id', 'unique' => 0),
			'project_repayment_id' => array('column' => 'project_repayment_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_funds = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'owner_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'referred_by_user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'payment_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'is_delayed_chained_payment' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'lend_name_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'user_paypal_connection_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'site_fee' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'is_anonymous' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4),
		'project_fund_status_id' => array('type' => 'integer', 'null' => true, 'default' => '4', 'length' => 4, 'key' => 'index'),
		'is_canceled_from_paypal' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'auth_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'auth_amount' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'commission_amount' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'admin_commission_amount' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'affiliate_commission_amount' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'mc_currency' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'paypal_pay_key' => array('type' => 'binary', 'null' => true, 'default' => null),
		'latitude' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'longitude' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'coupon_code' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'unique_coupon_code' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_given' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'reward_given_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'project_reward_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_widget_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'canceled_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'key' => 'index'),
		'is_collection' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'project_id' => array('column' => 'project_id', 'unique' => 0),
			'auth_id' => array('column' => 'auth_id', 'unique' => 0),
			'user_paypal_connection_id' => array('column' => 'user_paypal_connection_id', 'unique' => 0),
			'owner_user_id' => array('column' => 'owner_user_id', 'unique' => 0),
			'project_type_id' => array('column' => 'project_type_id', 'unique' => 0),
			'canceled_by_user_id' => array('column' => 'canceled_by_user_id', 'unique' => 0),
			'referred_by_user_id' => array('column' => 'referred_by_user_id', 'unique' => 0),
			'payment_gateway_id' => array('column' => 'payment_gateway_id', 'unique' => 0),
			'lend_name_id' => array('column' => 'lend_name_id', 'unique' => 0),
			'project_fund_status_id' => array('column' => 'project_fund_status_id', 'unique' => 0),
			'project_reward_id' => array('column' => 'project_reward_id', 'unique' => 0),
			'project_widget_id' => array('column' => 'project_widget_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_invest_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'invest_project_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'invest_project_category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_fund_goal_reached_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'total_shares' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'shares_allocated' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'is_seis_or_eis' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'project_id' => array('column' => 'project_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'invest_project_status_id' => array('column' => 'invest_project_status_id', 'unique' => 0),
			'invest_project_category_id' => array('column' => 'invest_project_category_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_lend_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'lend_project_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'lend_project_category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'credit_score_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'loan_term_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'repayment_schedule_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_fund_goal_reached_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'target_interest_rate' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'next_repayment_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'next_repayment_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'repayment_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'repayment_percentage' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'repayment_interest_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'is_repayment_notified' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_late_repayment_notified' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_collection' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'repayment_count' => array('type' => 'integer', 'null' => false, 'default' => null),
		'late_repayment_count' => array('type' => 'integer', 'null' => false, 'default' => null),
		'total_arrear_count' => array('type' => 'integer', 'null' => false, 'default' => null),
		'total_no_of_repayment' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'credit_score_id' => array('column' => 'credit_score_id', 'unique' => 0),
			'loan_term_id' => array('column' => 'loan_term_id', 'unique' => 0),
			'repayment_schedule_id' => array('column' => 'repayment_schedule_id', 'unique' => 0),
			'project_id' => array('column' => 'project_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'lend_project_status_id' => array('column' => 'lend_project_status_id', 'unique' => 0),
			'lend_project_category_id' => array('column' => 'lend_project_category_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_pledge_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'pledge_project_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'index'),
		'pledge_project_category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'pledge_type_id' => array('type' => 'integer', 'null' => true, 'default' => '1', 'length' => 20, 'key' => 'index'),
		'min_amount_to_fund' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'project_fund_goal_reached_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'is_allow_over_funding' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'project_id' => array('column' => 'project_id', 'unique' => 0),
			'pledge_type_id' => array('column' => 'pledge_type_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'pledge_project_status_id' => array('column' => 'pledge_project_status_id', 'unique' => 0),
			'pledge_project_category_id' => array('column' => 'pledge_project_category_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_ratings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'rating' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '5,2'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'project_id' => array('column' => 'project_id', 'unique' => 0),
			'project_type_id' => array('column' => 'project_type_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_repayments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'late_fee' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'interest' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'term' => array('type' => 'integer', 'null' => false, 'default' => null),
		'is_late' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'project_id' => array('column' => 'project_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_rewards = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'pledge_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'reward' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'estimated_delivery_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'pledge_max_user_limit' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20),
		'project_fund_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'is_shipping' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_having_additional_info' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'additional_info_label' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'project_id' => array('column' => 'project_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'project_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'form_field_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'form_field_step_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'form_field_group_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'project_fund_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'project_fund_amount' => array('type' => 'float', 'null' => false, 'default' => null),
		'site_revenue' => array('type' => 'float', 'null' => false, 'default' => null),
		'commission_percentage' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'commission_percentage_not_reached_need_amount' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'listing_fee' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'listing_fee_type' => array('type' => 'integer', 'null' => true, 'default' => null),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'key' => 'index'),
		'funder_slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'is_active' => array('column' => 'is_active', 'unique' => 0),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_view_types = array(
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
	public $project_views = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_view_type_id' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 20, 'key' => 'index'),
		'project_widget_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'project_id' => array('column' => 'project_id', 'unique' => 0),
			'project_type_id' => array('column' => 'project_type_id', 'unique' => 0),
			'project_widget_id' => array('column' => 'project_widget_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0),
			'project_view_type_id' => array('column' => 'project_view_type_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $project_widgets = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 100, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'url' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
	public $projects = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hash' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'short_description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'parent_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'referred_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'project_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'payment_method_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'index'),
		'city_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'state_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'country_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'address' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'address1' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 500, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'latitude' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'longitude' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'project_start_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'project_end_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'project_cancelled_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'collected_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'collected_percentage' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'needed_amount' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'fee_amount' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'admin_commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'affiliate_commission_amount' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'paypal_pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'payapi_payment_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'payapi_pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'feed_url' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'facebook_feed_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'twitter_feed_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'video_embed_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'total_ratings' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '5,2'),
		'actual_rating' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'mean_rating' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'project_rating_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'project_view_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'project_feed_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'project_fund_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'project_flag_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'project_comment_count' => array('type' => 'integer', 'null' => false, 'default' => null),
		'blog_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'project_follower_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'message_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'embed_view_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'referred_purchase_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'facebook_share_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'twitter_share_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'gmail_share_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'linkedin_share_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'rewarded_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'reward_given_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'detected_suspicious_words' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 512, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_admin_suspended' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_system_flagged' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_user_flagged' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_draft' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_private' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_featured' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_paid' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'is_successful' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'tracked_steps' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_pending_action_to_admin' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'angelist_startup_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_reward_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'name' => array('column' => 'name', 'unique' => 0),
			'slug' => array('column' => 'slug', 'unique' => 0),
			'project_type_id' => array('column' => 'project_type_id', 'unique' => 0),
			'city_id' => array('column' => 'city_id', 'unique' => 0),
			'state_id' => array('column' => 'state_id', 'unique' => 0),
			'country_id' => array('column' => 'country_id', 'unique' => 0),
			'angelist_startup_id' => array('column' => 'angelist_startup_id', 'unique' => 0),
			'parent_id' => array('column' => 'parent_id', 'unique' => 0),
			'referred_by_user_id' => array('column' => 'referred_by_user_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0),
			'payment_method_id' => array('column' => 'payment_method_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $projects_users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'project_id' => array('column' => 'project_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
	public $regions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'alias' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'block_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'alias' => array('column' => 'alias', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $relationships = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'relationship' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $repayment_schedules = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'day' => array('type' => 'integer', 'null' => false, 'default' => null),
		'is_particular_day_of_month' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_approved' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
	public $security_questions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
	public $seis_entries = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'company_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'number_of_employees' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'year_of_founding' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'total_asset' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'is_seis_or_eis' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'project_id' => array('column' => 'project_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
	public $setting_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'plugin_name' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 0),
			'parent_id' => array('column' => 'parent_id', 'unique' => 0),
			'plugin_name' => array('column' => 'plugin_name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $settings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'setting_category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'setting_category_parent_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'value' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 8, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'options' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'label' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'order' => array('type' => 'integer', 'null' => false, 'default' => null),
		'plugin_name' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'setting_category_id' => array('column' => 'setting_category_id', 'unique' => 0),
			'name' => array('column' => 'name', 'unique' => 0),
			'plugin_name' => array('column' => 'plugin_name', 'unique' => 0)
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
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 250, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'facebook_user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'twitter_user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'googleplus_user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'angellist_user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'social_contact_count' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'facebook_user_id' => array('column' => 'facebook_user_id', 'unique' => 0),
			'twitter_user_id' => array('column' => 'twitter_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
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
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
	public $states = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'country_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
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
	public $submission_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'submission_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'form_field_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'form_field' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'response' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'submission_id' => array('column' => 'submission_id', 'unique' => 0),
			'form_field_id' => array('column' => 'form_field_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $submissions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'project_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'ip' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'page' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'project_type_id' => array('column' => 'project_type_id', 'unique' => 0),
			'project_id' => array('column' => 'project_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $subscriptions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'is_subscribed' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'unsubscribed_on' => array('type' => 'date', 'null' => false, 'default' => null),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'invite_hash' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
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
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
	public $taxonomies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'term_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'vocabulary_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'parent_id' => array('column' => 'parent_id', 'unique' => 0),
			'term_id' => array('column' => 'term_id', 'unique' => 0),
			'vocabulary_id' => array('column' => 'vocabulary_id', 'unique' => 0),
			'lft' => array('column' => 'lft', 'unique' => 0),
			'rght' => array('column' => 'rght', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $terms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $timezones = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'code' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'gmt_offset' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'dst_offset' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'raw_offset' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hasdst' => array('type' => 'boolean', 'null' => false, 'default' => null),
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
		'message' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'message_for_admin' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'message_for_receiver' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
		'transaction_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'payment_gateway_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'project_type_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'key' => 'index'),
		'gateway_fees' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'remarks' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'transaction_type_id' => array('column' => 'transaction_type_id', 'unique' => 0),
			'payment_gateway_id' => array('column' => 'payment_gateway_id', 'unique' => 0),
			'foreign_id' => array('column' => 'foreign_id', 'unique' => 0),
			'class' => array('column' => 'class', 'unique' => 0),
			'receiver_user_id' => array('column' => 'receiver_user_id', 'unique' => 0),
			'project_type_id' => array('column' => 'project_type_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $translations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'name' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'lang_text' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_translated' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_google_translate' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_verified' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'language_id' => array('column' => 'language_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'alias' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'format_show_author' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'format_show_date' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'comment_status' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1),
		'comment_approve' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'comment_spam_protection' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'comment_captcha' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'params' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'plugin' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'alias' => array('column' => 'alias', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $types_vocabularies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'vocabulary_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'vocabulary_id' => array('column' => 'vocabulary_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_add_wallet_amounts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'paypal_pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'payment_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'is_success' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'user_paypal_connection_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'payment_gateway_id' => array('column' => 'payment_gateway_id', 'unique' => 0),
			'user_paypal_connection_id' => array('column' => 'user_paypal_connection_id', 'unique' => 0)
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
		'payment_gateway_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'withdrawal_status_id' => array('column' => 'withdrawal_status_id', 'unique' => 0),
			'payment_gateway_id' => array('column' => 'payment_gateway_id', 'unique' => 0)
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
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
	public $user_logins = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'persistent_login_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_agent' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'persistent_login_id' => array('column' => 'persistent_login_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
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
	public $user_paypal_connections = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'valid_from' => array('type' => 'date', 'null' => false, 'default' => null, 'key' => 'index'),
		'valid_to' => array('type' => 'date', 'null' => false, 'default' => null, 'key' => 'index'),
		'sender_email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'pre_approval_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => null),
		'charged_amount' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,2'),
		'charged_count' => array('type' => 'integer', 'null' => false, 'default' => null),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_default' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'valid_from' => array('column' => 'valid_from', 'unique' => 0),
			'valid_to' => array('column' => 'valid_to', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_profiles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'language_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'first_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'last_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'middle_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'gender_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 2, 'key' => 'index'),
		'dob' => array('type' => 'date', 'null' => true, 'default' => null),
		'about_me' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'address' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'address1' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 500, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'city_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'state_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'country_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'zip_code' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'education_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'employment_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'income_range_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'relationship_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'message_page_size' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3),
		'message_signature' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'paypal_account' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'paypal_first_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'paypal_last_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'city_id' => array('column' => 'city_id', 'unique' => 0),
			'state_id' => array('column' => 'state_id', 'unique' => 0),
			'country_id' => array('column' => 'country_id', 'unique' => 0),
			'gender_id' => array('column' => 'gender_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'education_id' => array('column' => 'education_id', 'unique' => 0),
			'employment_id' => array('column' => 'employment_id', 'unique' => 0),
			'income_range_id' => array('column' => 'income_range_id', 'unique' => 0),
			'relationship_id' => array('column' => 'relationship_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_views = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'viewing_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'viewing_user_id' => array('column' => 'viewing_user_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $user_websites = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'website' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 512, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'role_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'index'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'available_wallet_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'blocked_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'facebook_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'timezone_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'auto_detected_timezone_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'user_openid_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'user_login_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'user_view_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'project_fund_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'project_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'project_flag_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'project_follower_count' => array('type' => 'integer', 'null' => false, 'default' => null),
		'project_comment_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'project_rating_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'blog_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'blog_comment_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'unique_project_fund_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'cookie_hash' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'cookie_time_modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'is_openid_register' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_agree_terms_conditions' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_email_confirmed' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_affiliate_user' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'total_commission_pending_amount' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'total_commission_canceled_amount' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'total_commission_completed_amount' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'commission_line_amount' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'commission_withdraw_request_amount' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'commission_paid_amount' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'total_amount_withdrawn' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'referred_purchase_count' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20),
		'referred_project_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'affiliate_refer_purchase_count' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20),
		'ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'last_login_ip_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'last_logged_in_time' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'twitter_access_token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'twitter_user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'twitter_access_key' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'linkedin_user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'linkedin_access_token' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_linkedin_register' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1),
		'is_angellist_register' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_angellist_connected' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'angellist_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'key' => 'index'),
		'angellist_access_token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'angellist_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'openid_user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 200, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'facebook_access_token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'google_user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'google_access_token' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'yahoo_user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'yahoo_access_token' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_google_register' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1),
		'is_yahoo_register' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1),
		'is_facebook_register' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_twitter_register' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_facebook_connected' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_twitter_connected' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_google_connected' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_yahoo_connected' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'is_linkedin_connected' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'twitter_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_paid' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'site_state_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'key' => 'index'),
		'paypal_pay_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'payapi_pay_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'payapi_payment_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'latitude' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'longitude' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'referred_by_user_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'referred_by_user_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'pwd_reset_token' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'pwd_reset_requested_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'security_question_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'security_answer' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'total_withdraw_request_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'is_accredited_investor' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'mobile_app_hash' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'mobile_app_time_modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'fb_friends_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'twitter_followers_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'linkedin_contacts_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'google_contacts_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'yahoo_contacts_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'is_skipped_fb' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_skipped_twitter' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_skipped_linkedin' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_skipped_google' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_skipped_yahoo' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_send_activities_mail' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'total_needed_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'total_collected_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'total_funded_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'site_revenue' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'invite_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'user_avatar_source_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'key' => 'index'),
		'googleplus_user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_googleplus_register' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1),
		'is_googleplus_connected' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'googleplus_contacts_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'googleplus_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'withdrawn_no_of_loans' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'withdrawn_average_rate' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'withdrawn_total_lent' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'withdrawn_total_capital_returned' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'withdrawn_total_interest_returned' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'collection_no_of_loans' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'collection_average_rate' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'collection_total_lent' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'collection_total_capital_returned' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'collection_total_interest_returned' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'closed_no_of_loans' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'closed_average_rate' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'closed_total_lent' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'closed_total_capital_returned' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'closed_total_interest_returned' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'default_no_of_loans' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'default_average_rate' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'default_total_lent' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'default_total_capital_returned' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'default_total_interest_returned' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'is_idle' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'is_funded' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_project_posted' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'is_engaged' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'google_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'linkedin_avatar_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'angellist_contacts_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'activity_message_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'username' => array('column' => 'username', 'unique' => 0),
			'email' => array('column' => 'email', 'unique' => 0),
			'role_id' => array('column' => 'role_id', 'unique' => 0),
			'facebook_user_id' => array('column' => 'facebook_user_id', 'unique' => 0),
			'timezone_id' => array('column' => 'timezone_id', 'unique' => 0),
			'auto_detected_timezone_id' => array('column' => 'auto_detected_timezone_id', 'unique' => 0),
			'ip_id' => array('column' => 'ip_id', 'unique' => 0),
			'last_login_ip_id' => array('column' => 'last_login_ip_id', 'unique' => 0),
			'twitter_user_id' => array('column' => 'twitter_user_id', 'unique' => 0),
			'linkedin_user_id' => array('column' => 'linkedin_user_id', 'unique' => 0),
			'angellist_user_id' => array('column' => 'angellist_user_id', 'unique' => 0),
			'openid_user_id' => array('column' => 'openid_user_id', 'unique' => 0),
			'google_user_id' => array('column' => 'google_user_id', 'unique' => 0),
			'yahoo_user_id' => array('column' => 'yahoo_user_id', 'unique' => 0),
			'site_state_id' => array('column' => 'site_state_id', 'unique' => 0),
			'referred_by_user_id' => array('column' => 'referred_by_user_id', 'unique' => 0),
			'security_question_id' => array('column' => 'security_question_id', 'unique' => 0),
			'user_avatar_source_id' => array('column' => 'user_avatar_source_id', 'unique' => 0),
			'googleplus_user_id' => array('column' => 'googleplus_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $vocabularies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'alias' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'required' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'multiple' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'tags' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'plugin' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'alias' => array('column' => 'alias', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	public $withdrawal_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'user_cash_withdrawal_count' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
}
