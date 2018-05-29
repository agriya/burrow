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
/* SVN: $Id: config.php 91 2008-07-08 13:13:19Z rajesh_04ag02 $ */
/**
 * Custom configurations
 */
if (!defined('DEBUG')) {
    define('DEBUG', 0);
    // permanent cache re1ated settings
    define('PERMANENT_CACHE_CHECK', (!empty($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] != '127.0.0.1') ? true : false);
    // site default language
    define('PERMANENT_CACHE_DEFAULT_LANGUAGE', 'en');
    // cookie variable name for site language
    define('PERMANENT_CACHE_COOKIE', 'user_language');
	// salt used in setcookie
    define('PERMANENT_CACHE_GZIP_SALT', 'e9a556134534545ab47c6c81c14f06c0b8sdfsdf');
	// Enable support for HTML5 History/State API
	// By enabling this, users will not see full page load
	define('IS_ENABLE_HTML5_HISTORY_API', false);
	// Force hashbang based URL for all browsers
	// When this is disabled, browsers that don't support History API (IE, etc) alone will use hashbang based URL. When enabled, all browsers--including links in Google search results will use hashbang based URL (similar to new Twitter).
    define('IS_ENABLE_HASHBANG_URL', false);
    $_is_hashbang_supported_bot = (!empty($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Googlebot') !== false);
    define('IS_HASHBANG_SUPPORTED_BOT', $_is_hashbang_supported_bot);
}
$config['debug'] = DEBUG;
$config['site']['license_key'] = '13480-6652-156-1330341231-26e359e8';
// site actions that needs random attack protection...
$config['site']['_hashSecuredActions'] = array(
    'edit',
    'delete',
    'update',
    'download',
    'v',
);
$config['permanent_cache']['view_action'] = array(
	'properties',
	'requests',
	'users',
);
$config['image']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/pjpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => false
);
$config['photo']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/pjpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => false
);
$config['property']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/pjpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => true
);
$config['avatar']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/pjpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => true
);
$config['message']['file'] = array(
    'allowedMime' => '*',
    'allowedExt' =>'*',
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => true
);
$config['property']['payment_gateway_flow_id'] = 'Buyer -> Site -> Seller';
$config['StretchType']=array(
     "Repeat" => 'bg-repeat',
     "Stretch" => 'bg-stretch',
     "AutoResize" => 'bg-stretch-autoresize'
);
$config['barcode']['symbology'] = 'qr';
$config['flickr']['url'] = 'http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key';
$config['propertyfeedbacks']['max_upload_photo'] = 5;
$config['messages']['content_length'] = 50;
$config['messages']['page_size'] = 50;
$config['messages']['allowed_message_size_unit'] = 'MB';
$config['messages']['allowed_message_size'] = 2;
$config['sitemap']['models'] = array(
    'Property' => array(
		'conditions' => array(
			'Property.admin_suspend' => 0,
			'Property.is_approved' => 1,
			'Property.is_active' => 1,
			'Property.is_paid' => 1
		)
	) ,
    'Request' => array(
		'conditions' => array(
			'Request.admin_suspend' => 0,
			'Request.is_approved' => 1,
			'Request.is_active' => 1,
			'Request.checkin >=' => date('Y-m-d')
		)
	)
);
$config['property']['network_level'] = 2;
if (class_exists('CmsHook') && method_exists('CmsHook', 'setExceptionUrl')) {
    CmsHook::setExceptionUrl(array(
	'pages/view',
	'pages/how_it_works',
	'pages/display',
	'settings/fb_update',
	'users/register',
	'users/login',
	'users/logout',
	'users/reset',
	'users/forgot_password',
	'users/openid',
	'users/activation',
	'users/resend_activation',
	'users/view',
	'users/show_captcha',
	'users/captcha_play',
	'images/view',
	'users/validate_user',
	'users/facepile',
	'devs/robots',
	'devs/asset_css',
	'devs/asset_js',
	'devs/sitemap',
	'contacts/add',
	'users/admin_login',
	'users/admin_logout',
	'languages/change_language',
	'contacts/show_captcha',
	'contacts/captcha_play',
	'payments/order',
	'users/oauth_callback',
	'user_comments/index',
	'countries/check_country',
	'property_comments/index',
	'cities/index',
	'crons/main',
	'users/oauth_facebook',
	'users/refer',
	'users/show_header',
	'currencies/change_currency',
	'payments/membership_pay_now',
	'payments/cancel_user_payment',
	'payments/success_user_payment',
	'payments/cancel_preapproval_order',
	'payments/success_preapproval_order',
	'payments/process_preapproval_order',
	'payments/get_gateways',
	'devs/yadis',
	'properties/popular_properties',
    ));
}


$config['signup_fee']['exception_arr'] = array(
	'devs/asset_js',
	'devs/asset_css',
	'users/login',
	'users/logout',
	'payments/membership_pay_now',
	'payments/get_gateways',
	'users/show_header',
);
$config['social_marketing']['exception_arr'] = array(
	'users/login',
	'users/logout',
	'devs/asset_js',
	'devs/asset_css',
	'properties/search',
	'properties/popular_properties',
	'properties/map',
	'cities/index',
	'currencies/change_currency',
	'social_marketings/import_friends',
	'social_contacts/index',
	'social_contacts/update',
	'users/follow_friends',
	'user_followers/add_multiple',
	'messages/activities',
	'messages/notifications',
	'users/show_header',
	'social_marketings/publish_success',
	'pages/view',
	'pages/how_it_works',
	'contacts/add',
);
$config['prelaunch']['exception_arr'] = array(
	'subscriptions/add',
	'subscriptions/check_invitation',
	'subscriptions/confirmation',
	'users/login',
	'users/logout',
	'users/facepile',
	'users/admin_login',
	'nodes/view',
	'pages/view',
	'images/view',
	'devs/asset_js',
	'devs/asset_css',
	'devs/robots',
	'devs/sitemap',
	'properties/search',
	'users/show_captcha',
	'users/captcha_play',
	'payments/user_pay_now',
	'payments/get_gateways',
	'users/show_header',
	'cities/index',
);
$config['private_beta']['exception_arr'] = array_merge($config['prelaunch']['exception_arr'], array(
	'users/register',
	'users/login',
	'users/logout',
	'users/show_captcha',
	'users/captcha_play',
	'users/facepile',
	'users/show_header',
	'users/forgot_password',
	'users/activation',
	'users/reset',
	'cities/index',
	'sudopays/process_ipn',
	'sudopays/process_payment',
	'sudopays/success_payment',
	'sudopays/cancel_payment',
	'payments/user_pay_now',
	'payments/_processPayment',
	'payments/success_payment',
	'payments/cancel_payment',
	'payments/get_gateways',
	'users/admin_login',
				
));
$config['ssl']['secure_url_arr'] = array(
	'users/login',
	'users/admin_login',
	'users/register',
	'wallers/add_to_wallet',
	'properties/property_verify_now',
	'properties/property_pay_now',
	'payments/membership_pay_now',
	'properties/order',
);
$config['maintenance']['exception_arr'] = array(
	'devs/asset_js',
	'devs/asset_css',
	'devs/robots',
	'devs/sitemap',
);

$default_timezone = 'Europe/Berlin';
if (ini_get('date.timezone')) {
	$default_timezone = ini_get('date.timezone');
}
date_default_timezone_set($default_timezone);
$config['Property']['normal_big_thumb']['is_handle_aspect'] = 1;
$config['Property']['normal_big_thumb']['is_not_allow_resize_beyond_original_size'] = 1;
/*
date_default_timezone_set('Asia/Calcutta');

Configure::write('Config.language', 'spa');
setlocale (LC_TIME, 'es');
*/
/*
** to do move to settings table
*/
$config['site']['is_admin_settings_enabled'] = true;
if (!empty($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'burrow.dev.agriya.com' && !in_array($_SERVER['REMOTE_ADDR'], array('182.72.136.170'))) {
	$config['site']['is_admin_settings_enabled'] = false;
	$config['site']['admin_demo_mode_update_not_allowed_pages'] = array(
		'users/admin_send_mail',
		'pages/admin_edit',
		'settings/admin_edit',
		'email_templates/admin_edit',
	);
	$config['site']['admin_demo_mode_not_allowed_actions'] = array(
		'admin_delete',
		'admin_update',
	);
}
?>