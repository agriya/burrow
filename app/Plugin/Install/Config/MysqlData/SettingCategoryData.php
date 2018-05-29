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
class SettingCategoryData {

	public $table = 'setting_categories';

	public $records = array(
		array(
			'id' => '1',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'System',
			'description' => 'Manage site name, contact email, from email, reply to email.',
			'plugin_name' => ''
		),
		array(
			'id' => '2',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Developments',
			'description' => 'Manage Maintenance mode.',
			'plugin_name' => ''
		),
		array(
			'id' => '3',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'SEO',
			'description' => 'Manage content, meta data and other information relevant to browsers or search engines',
			'plugin_name' => ''
		),
		array(
			'id' => '4',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Regional, Currency & Language',
			'description' => 'Manage site default language, currency, date-time format',
			'plugin_name' => ''
		),
		array(
			'id' => '5',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Account',
			'description' => 'Manage different type of login option such as Facebook, Twitter, Yahoo and Gmail',
			'plugin_name' => ''
		),
		array(
			'id' => '6',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Payment',
			'description' => 'Manage payment related settings such as wallet, cash withdrawal. Manage different types payment gateway settings of the site. [Wallet, PayPal, Authorize.net, PagSeguro]. <a title=\"Update Payment Gateway Settings\" class=\"paymentgateway-link\" href=\"##PAYMENT_SETTINGS_URL##\">Update Payment Gateway Settings</a>',
			'plugin_name' => ''
		),
		array(
			'id' => '7',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Property',
			'description' => 'Manage & configure settings related to property listing and booking options.',
			'plugin_name' => ''
		),
		array(
			'id' => '8',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Revenue',
			'description' => 'Manage & configure settings related to properties, listing fee, verification fee, commission and properties list options.',
			'plugin_name' => ''
		),
		array(
			'id' => '9',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Request',
			'description' => 'Manage & configure settings related to requests auto approve & enable and disable options for request flag.',
			'plugin_name' => 'Requests'
		),
		array(
			'id' => '10',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Suspicious Words Detector',
			'description' => 'Manage Suspicious word detector feature, Auto suspend property on system flag, Auto suspend request on system flag, Auto suspend message on system flag.',
			'plugin_name' => ''
		),
		array(
			'id' => '11',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Messages',
			'description' => 'Manage and configure settings such as email notification, send message option.',
			'plugin_name' => ''
		),
		array(
			'id' => '13',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Dispute',
			'description' => 'Manage Dispute Conversation count, Number of days to reply dispute.',
			'plugin_name' => ''
		),
		array(
			'id' => '14',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Affiliate',
			'description' => 'Manage affiliate information,  commission and withdraw amount details.',
			'plugin_name' => 'Affiliates'
		),
		array(
			'id' => '15',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Third Party API',
			'description' => 'Manage third party settings such as Facebook, Twitter, Gmail, Yahoo, MSN for authentication, importing contacts and posting.',
			'plugin_name' => ''
		),
		array(
			'id' => '21',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '1',
			'name' => 'Site Information',
			'description' => 'Here you can modify site related settings such as site name.',
			'plugin_name' => ''
		),
		array(
			'id' => '22',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '1',
			'name' => 'E-mails',
			'description' => 'Here you can modify email related settings such as contact email, from email, reply-to email.',
			'plugin_name' => ''
		),
		array(
			'id' => '23',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '2',
			'name' => 'Server',
			'description' => 'Here you can change server settings such as maintenance mode, SSL settings.',
			'plugin_name' => ''
		),
		array(
			'id' => '24',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '3',
			'name' => 'Metadata',
			'description' => 'Here you can set metadata settings such as meta keyword and description.',
			'plugin_name' => ''
		),
		array(
			'id' => '25',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '3',
			'name' => 'SEO',
			'description' => 'Here you can set SEO settings such as inserting tracker code and robots.',
			'plugin_name' => ''
		),
		array(
			'id' => '26',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '4',
			'name' => 'Regional',
			'description' => 'Here you can change regional setting such as site language.',
			'plugin_name' => 'Translation'
		),
		array(
			'id' => '27',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '4',
			'name' => 'Date and Time',
			'description' => 'Here you can modify date time settings such as timezone, date time format.',
			'plugin_name' => ''
		),
		array(
			'id' => '28',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '5',
			'name' => 'Logins',
			'description' => 'Here you can modify user login settings such as enabling 3rd party logins and other login options.',
			'plugin_name' => ''
		),
		array(
			'id' => '29',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '5',
			'name' => 'Account Settings',
			'description' => 'Here you can modify account settings such as admin approval, email verification, and other site account settings.',
			'plugin_name' => ''
		),
		array(
			'id' => '30',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '6',
			'name' => 'Wallet',
			'description' => 'Here you can modify wallet related setting such as enabling groupon-like wallet, maximum and minimum funding limit settings.',
			'plugin_name' => 'Wallet'
		),
		array(
			'id' => '31',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '6',
			'name' => 'Cash Withdraw',
			'description' => 'Here you can modify cash withdraw settings for a user such as enabling withdrawal and setting withdraw limit',
			'plugin_name' => 'Wallet'
		),
		array(
			'id' => '32',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '7',
			'name' => 'List Configuration',
			'description' => 'Here you can modify property list related settings such as auto approve property, maximum photo upload per property',
			'plugin_name' => 'Properties'
		),
		array(
			'id' => '33',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '7',
			'name' => 'Booking Configuration',
			'description' => 'Here you can modify property booking related settings such as maximum negotiation discount, auto expire booking',
			'plugin_name' => 'Properties'
		),
		array(
			'id' => '34',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '7',
			'name' => 'Configuration',
			'description' => '',
			'plugin_name' => ''
		),
		array(
			'id' => '35',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '7',
			'name' => 'Barcode',
			'description' => 'Here you can modify barcode settings such as width, height settings. You can enable/disable barcode here. If you use barcode reader with computer, it will help to mark it as checkin/checkout easily.',
			'plugin_name' => ''
		),
		array(
			'id' => '36',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '8',
			'name' => 'Configuration',
			'description' => 'Here you can modify enable and disable PayPal connection, PayPal embedded option',
			'plugin_name' => ''
		),
		array(
			'id' => '37',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '8',
			'name' => 'Booking Commission',
			'description' => 'Here you can manage booking commission percentage from host and traveler',
			'plugin_name' => ''
		),
		array(
			'id' => '38',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '8',
			'name' => 'Other Fee Options',
			'description' => 'Here you can manage property listing, verification and use membership fee',
			'plugin_name' => ''
		),
		array(
			'id' => '39',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '9',
			'name' => 'Configuration',
			'description' => 'Here you can modify request related settings such as auto approve request',
			'plugin_name' => 'Requests'
		),
		array(
			'id' => '40',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '10',
			'name' => 'Configuration',
			'description' => '<p>Here you can update the Suspicious Words Detector related settings.</p> <p>Here you can place various words, which accepts regular expressions also, to match with your terms and policies. </p> <h4>Common Regular expressions</h4> <dl class=\"list clearfix\"> <dt>Email</dt> <dd>\\w+([-+.]\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*([,;]\\s*\\w+([-+.]\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*)*</dd> <dt>Phone Number</dt> <dd>^0[234679]{1}[\\s]{0,1}[\\-]{0,1}[\\s]{0,1}[1-9]{1}[0-9]{6}$</dd> <dt>URL</dt> <dd>((https?|ftp|gopher|telnet|file|notes|ms-help):((//)|(\\\\\\\\))+[\\w\\d:#@%/;$()~_?\\+-=\\\\\\.&]*)</dd> </dl>',
			'plugin_name' => ''
		),
		array(
			'id' => '41',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '10',
			'name' => 'Auto Suspend Module',
			'description' => 'Here you can enable / disable auto suspend for requests, messages and properties on system flag.',
			'plugin_name' => ''
		),
		array(
			'id' => '42',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '11',
			'name' => 'Configuration',
			'description' => 'Here you modify message settings such as send message options and other message related settings.',
			'plugin_name' => 'Properties'
		),
		array(
			'id' => '43',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '12',
			'name' => 'Configuration',
			'description' => 'Here you can modify friend settings such as auto accept and other friendship related settings.',
			'plugin_name' => ''
		),
		array(
			'id' => '44',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '13',
			'name' => 'Configuration',
			'description' => 'Here you can modify dispute related settings such as cancellation percentage from traveler.',
			'plugin_name' => ''
		),
		array(
			'id' => '45',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '14',
			'name' => 'Configuration',
			'description' => 'Here you can modify affiliate related settings such as enabling affiliate and referral expire time.',
			'plugin_name' => 'Affiliates'
		),
		array(
			'id' => '46',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '14',
			'name' => 'Commission',
			'description' => 'Here you can modify affiliate related commission settings such as commission holding period, commission pay type settings.',
			'plugin_name' => 'Affiliates'
		),
		array(
			'id' => '47',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '14',
			'name' => 'Withdrawal',
			'description' => 'Here you can modify affiliate withdrawal settings such as threshold limit, transaction fee settings.',
			'plugin_name' => 'Affiliates'
		),
		array(
			'id' => '48',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '15',
			'name' => 'Facebook',
			'description' => 'Facebook is used for login and posting message using its account details. For doing above, our site must be configured with existing Facebook account. <a target=\"_blank\" href=\"http://dev1products.dev.agriya.com/doku.php?id=facebook-setup\"> http://dev1products.dev.agriya.com/doku.php?id=facebook-setup </a>',
			'plugin_name' => ''
		),
		array(
			'id' => '49',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '15',
			'name' => 'Twitter',
			'description' => 'Twitter is used for login and posting message using its account details. For doing above, our site must be configured with existing Twitter account. <a target=\"_blank\" href=\"http://dev1products.dev.agriya.com/doku.php?id=twitter-setup\"> http://dev1products.dev.agriya.com/doku.php?id=twitter-setup </a>',
			'plugin_name' => ''
		),
		array(
			'id' => '50',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '15',
			'name' => 'Yahoo',
			'description' => 'We use this service for importing contacts from Yahoo for friends invite. For doing above, our site must be configured with existing Yahoo account. <a target=\"_blank\" href=\"http://dev1products.dev.agriya.com/doku.php?id=yahoo-setup\"> http://dev1products.dev.agriya.com/doku.php?id=yahoo-setup </a>',
			'plugin_name' => ''
		),
		array(
			'id' => '51',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '15',
			'name' => 'Google',
			'description' => 'We use this service for importing contacts from Gmail for friends invite. For doing above, our site must be configured with existing Gmail account. <a target=\"_blank\" href=\"http://dev1products.dev.agriya.com/doku.php?id=google_setup\"> http://dev1products.dev.agriya.com/doku.php?id=google_setup </a>',
			'plugin_name' => ''
		),
		array(
			'id' => '78',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '5',
			'name' => 'Remember me',
			'description' => '',
			'plugin_name' => ''
		),
		array(
			'id' => '53',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '15',
			'name' => 'Flickr',
			'description' => 'We use this service to show photos near to city in property view page. For doing above, our site must be configured with existing Flickr account. <a href=\"http://dev1products.dev.agriya.com/doku.php?id=flickr-setup\"> http://dev1products.dev.agriya.com/doku.php?id=flickr-setup </a>',
			'plugin_name' => ''
		),
		array(
			'id' => '54',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '16',
			'name' => 'Module',
			'description' => 'Here you can modify module settings such as enabling/disabling master modules settings.',
			'plugin_name' => ''
		),
		array(
			'id' => '55',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Mobile Apps',
			'description' => 'All mobile apps will send secret key (hard coded in Mobile App) to fetch data from server. App\'s key should be matched with this value.<br/>Warning: changing this value may break your mobile apps.',
			'plugin_name' => 'MobileApp'
		),
		array(
			'id' => '56',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '4',
			'name' => 'Currency Settings',
			'description' => 'Here you can modify site currency settings such as currency position, default currency and conversion currency.',
			'plugin_name' => ''
		),
		array(
			'id' => '57',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '5',
			'name' => 'Privacy',
			'description' => 'Here you can modify option to change language & currency for user.',
			'plugin_name' => ''
		),
		array(
			'id' => '58',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '15',
			'name' => 'Google Translations',
			'description' => '<p>We use this service for quick translation to support new languages in ##TRANSLATIONADD##.</p> <p>Note that Google Translate API is now a <a href=\"http://code.google.com/apis/language/translate/v2/pricing.html\" target=\"_blank\">paid service</a>. Getting Api key, refer <a href=\"http://dev1products.dev.agriya.com/doku.php?id=google-translation-setup\" target=\"_blank\">http://dev1products.dev.agriya.com/doku.php?id=google-translation-setup</a>.</p>',
			'plugin_name' => 'Translation'
		),
		array(
			'id' => '60',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '17',
			'name' => 'Configuration',
			'description' => '',
			'plugin_name' => ''
		),
		array(
			'id' => '61',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '15',
			'name' => 'LinkedIn',
			'description' => 'LinkedIn is used for login and fetching contacts.',
			'plugin_name' => ''
		),
		array(
			'id' => '62',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '15',
			'name' => 'Google+',
			'description' => 'We use this service for importing contacts from Google+ for friends invite. For doing above, our site must be configured with existing Gmail account. <a href=\"http://dev1products.dev.agriya.com/doku.php?id=google-hybridauth-setup\"> http://dev1products.dev.agriya.com/doku.php?id=google-hybridauth-setup </a>',
			'plugin_name' => ''
		),
		array(
			'id' => '64',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '2',
			'name' => 'Site State',
			'description' => 'Here you can change the site state as Prelaunch, Private Beta or Launch',
			'plugin_name' => 'LaunchModes'
		),
		array(
			'id' => '65',
			'created' => '2013-02-19 19:39:52',
			'modified' => '2013-02-19 19:39:55',
			'parent_id' => '15',
			'name' => 'Google Analytics',
			'description' => '',
			'plugin_name' => 'IntegratedGoogleAnalytics'
		),
		array(
			'id' => '67',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '66',
			'name' => 'CloudFlare',
			'description' => 'CloudFlare acts as a CDN and is capable of mitigating DDoS attacks.',
			'plugin_name' => 'HighPerformance'
		),
		array(
			'id' => '68',
			'created' => '2013-09-25 16:03:53',
			'modified' => '2013-09-25 16:03:53',
			'parent_id' => '66',
			'name' => 'Google PageSpeed',
			'description' => 'Google PageSpeed is also easy to setup through DNS change. This will optimize site\'s HTML, JavaScript, Style Sheets and images on the fly. You may not usually need to turn this on as Agriya Burrow script is highly optimized already.',
			'plugin_name' => 'HighPerformance'
		),
		array(
			'id' => '69',
			'created' => '2012-02-27 12:03:49',
			'modified' => '2012-02-27 12:03:55',
			'parent_id' => '66',
			'name' => 'Pull CDN',
			'description' => 'By configuring Pull CDN services and entering the CDN domains below, we can make assets to be delivered through CDN easily.',
			'plugin_name' => 'HighPerformance'
		),
		array(
			'id' => '70',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '66',
			'name' => 'Email Delivery',
			'description' => 'Normally emails will be delivered through PHP. By enabling this option, email will be sent through this custom SMTP server. For performance, cloud email services like Amazon SES, Sendgrid, Mandrill, Gmail can be configured. ',
			'plugin_name' => 'HighPerformance'
		),
		array(
			'id' => '71',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '66',
			'name' => 'Redis',
			'description' => 'By enabling this, session data will be stored in Redis instead from the database or files. This will improve site performance when site\'s user base is high.',
			'plugin_name' => 'HighPerformance'
		),
		array(
			'id' => '72',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '66',
			'name' => 'Memcached',
			'description' => 'By enabling this, database queries\' results will be stored in Memcached. As this reducing direct database access to some extent, this will improve site performance.',
			'plugin_name' => 'HighPerformance'
		),
		array(
			'id' => '73',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '66',
			'name' => 'Full-page Caching',
			'description' => 'By enabling this, most of the pages will be disk-cached. This will avoid PHP and database access. Caveat of this approach is that users will be presented with little outdated contents. Since, this Agriya Burrow script is highly optimized for this approach, this is highly recommended for good performance. ',
			'plugin_name' => 'HighPerformance'
		),
		array(
			'id' => '74',
			'created' => '2013-04-29 12:12:09',
			'modified' => '2013-04-29 12:12:12',
			'parent_id' => '66',
			'name' => 'Amazon S3',
			'description' => 'By enabling this, uploaded contents and static (CSS, JavaScript, images, etc) will be stored in Amazon S3 and will be delivered from there. This will have 2 benefits: 1. You may reduce storage and bandwidth cost--based on your server plan, 2. As files will be delivered from Amazon S3 infrastructure, site\'s loading speed may improve. ',
			'plugin_name' => 'HighPerformance'
		),
		array(
			'id' => '75',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Social Marketing',
			'description' => 'Manage & configure settings such as invite, share content etc.,',
			'plugin_name' => 'SocialMarketing'
		),
		array(
			'id' => '76',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '75',
			'name' => 'Invite',
			'description' => '',
			'plugin_name' => 'SocialMarketing'
		),
		array(
			'id' => '77',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '75',
			'name' => 'Share',
			'description' => '',
			'plugin_name' => 'SocialMarketing'
		),
		array(
			'id' => '80',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '1',
			'name' => 'CAPTCHA',
			'description' => 'Here you can select the CAPTCHA option. Solve Media offers revenue sharing by showing Ads in CAPTCHA display. If you choose Solve Media, enter the application key in ##APPLICATION_KEY##',
			'plugin_name' => ''
		),
		array(
			'id' => '81',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '15',
			'name' => 'Solve Media',
			'description' => 'Solve Media offers revenue sharing by showing Ads in CAPTCHA display. You can enable it in ##CATPCHA_CONF## For getting API keys, refer ##DEMO_URL##',
			'plugin_name' => ''
		),
		array(
			'id' => '82',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Widget',
			'description' => 'Widgets for footer, project view page. Widgets can be in iframe and JavaScript embed code, etc (e.g., Twitter Widget, Facebook Like Box, Facebook Feeds Code, Google Ads).',
			'plugin_name' => ''
		),
		array(
			'id' => '83',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '80',
			'name' => 'Widget #1',
			'description' => '',
			'plugin_name' => ''
		),
		array(
			'id' => '84',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '80',
			'name' => 'Widget #2',
			'description' => '',
			'plugin_name' => ''
		),
		array(
			'id' => '85',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '80',
			'name' => 'Widget #3',
			'description' => '',
			'plugin_name' => ''
		),
		array(
			'id' => '86',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '80',
			'name' => 'Widget #4',
			'description' => '',
			'plugin_name' => ''
		),
		array(
			'id' => '66',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'High Performance',
			'description' => 'Manage high performance related settings',
			'plugin_name' => 'HighPerformance'
		),
	);

}
