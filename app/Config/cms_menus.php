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
$content_dashboard = $content_user = $content_affiliates = '';
if (isPluginEnabled('IntegratedGoogleAnalytics')) {
    $content_dashboard = __l('and to analyze the site analytic status');
}
if (isPluginEnabled('LaunchModes')) {
    $content_user = __l('and manage prelaunch subscribed email list');
}
if (isPluginEnabled('Affiliates')) {
    $content_affiliates = __l(', affiliates and their requests etc');
}
CmsNav::add('dashboard', array(
    'title' => __l('Dashboard') ,
    'data-bootstro-step' => '1',
    'data-bootstro-content' => __l('To see overall site activities and to notify the actions that admin need to taken') . ' ' . $content_dashboard,
    'icon-class' => 'home',
    'allowedActions' => array(
        'admin_stats',
        'admin_user_insights',
        'admin_analytics_chart',
    ) ,
    'weight' => 10,
    'children' => array(
        'users' => array(
            'title' => __l('Snapshot') ,
            'url' => array(
                'admin' => true,
                'controller' => 'users',
                'action' => 'stats',
            ) ,
            'weight' => 10,
        ) ,
    )
));
CmsNav::add('users', array(
    'title' => __l('Users') ,
    'url' => array(
        'admin' => true,
        'controller' => 'users',
        'action' => 'index',
    ) ,
    'notAllowedActions' => array(
        'admin_stats',
        'admin_diagnostics',
        'admin_logs'
    ) ,
    'data-bootstro-step' => '2',
    'data-bootstro-content' => __l('To manage the site user list, to send bulk email to site users') . ' ' . $content_user,
    'icon-class' => 'user',
    'weight' => 20,
    'children' => array(
        'users' => array(
				'title' => __l('Users') ,
				'url' => array(
					'admin' => true,
					'controller' => 'users',
					'action' => 'index',
				) ,
				'weight' => 10,
		 ) ,
		 
		'Send Email to Users' => array(
			'title' => __l('Send Email to Users') ,
			'url' => array(
				'admin' => true,
				'controller' => 'users',
				'action' => 'send_mail',
			) ,
			'weight' => 20,
		)
  )
));
CmsNav::add('activities', array(
    'title' => __l('Activities') ,
    'url' => array(
        'admin' => true,
        'controller' => 'users',
        'action' => 'index',
    ) ,
    'data-bootstro-step' => '6',
    'data-bootstro-content' => __l('To manage the overall site activities like comments, messages, views etc.') . ' ' . $content_user,
    'icon-class' => 'time',
    'weight' => 60,
    'children' => array(
		'Users' => array(
            'title' => __l('Users') ,
            'url' => '',
            'weight' => 10,
        ) ,
		'user_logins' => array(
			'title' => __l('User Logins') ,
			'url' => array(
				'admin' => true,
				'controller' => 'user_logins',
				'action' => 'index',
			) ,
			'weight' => 10,
		) ,
		'user_views' => array(
			'title' => __l('User Views') ,
			'url' => array(
				'admin' => true,
				'controller' => 'user_views',
				'action' => 'index',
			) ,
			'weight' => 20,
		) ,
		'Messages' => array(
			'title' => __l('User Messages') ,
			'url' => array(
				'admin' => true,
				'controller' => 'messages',
				'action' => 'index',
			) ,
			'weight' => 30,
		),
  ) ,
));
App::import('Model', 'SettingCategory');
$SettingCategory = new SettingCategory();
$plugins = explode(',', Configure::read('Hook.bootstraps'));
array_push($plugins, '');
$settingCategories = $SettingCategory->find('all', array(
    'conditions' => array(
        'SettingCategory.parent_id' => 0,
        'SettingCategory.plugin_name' => $plugins,
    ) ,
    'recursive' => -1
));
$tmp_settings = array();
$i = 0;
foreach($settingCategories as $settingCategory) {
    $i = $i+10;
    $tmp_settings[$settingCategory['SettingCategory']['name']] = array(
        'title' => $settingCategory['SettingCategory']['name'],
        'url' => array(
            'admin' => true,
            'controller' => 'settings',
            'action' => 'edit',
            $settingCategory['SettingCategory']['id'],
        ) ,
        'weight' => $i,
    );
}
CmsNav::add('settings', array(
    'title' => __l('Settings') ,
    'data-bootstro-step' => '10',
    'data-bootstro-content' => __l('To manage overall settings of the site.') ,
    'column_1' => 9,
    'url' => array(
        'admin' => true,
        'controller' => 'settings',
        'action' => 'prefix',
        'Site',
    ) ,
    'column' => 2,
    'icon-class' => 'cog',
    'weight' => 100,
    'children' => $tmp_settings,
));
CmsNav::add('payments', array(
    'title' => __l('Payments') ,
    'show_title' => 1,
    'data-bootstro-step' => '7',
    'data-bootstro-content' => __l('To manage and monitor all the payment related things such as transactions, payment gateway management') . ' ' . $content_affiliates,
    'icon-class' => 'admin-payment',
    'url' => array(
        'admin' => true,
        'controller' => 'transactions',
        'action' => 'index',
    ) ,
    'weight' => 70,
    'children' => array(
        'Transactions' => array(
            'title' => __l('Transactions') ,
            'url' => array(
                'admin' => true,
                'controller' => 'transactions',
                'action' => 'index',
            ) ,
            'weight' => 100,
        ) ,
        'Payment Gateways' => array(
            'title' => __l('Payment Gateways') ,
            'url' => array(
                'admin' => true,
                'controller' => 'payment_gateways',
                'action' => 'index',
            ) ,
            'htmlAttributes' => array(
                'class' => 'payment-gateway span4 no-mar'
            ) ,
            'weight' => 110,
        ) ,
    )
));
CmsNav::add('cms', array(
    'title' => __l('Site Builder') ,
    'data-bootstro-step' => '9',
    'data-bootstro-content' => __l('To customize and manage the project form and their pricing type, also manage the site themes, contents, menu etc.') ,
    'url' => array(
        'admin' => true,
        'controller' => 'pages',
        'action' => 'index',
    ) ,
    'allowedControllers' => array(
        'extensions_themes',
        'pages',
        'menus',
        'blocks',
        'links',
        'attachments',
        'comments',
    ) ,
    'notAllowedActions' => array(
        'admin_tools',
    ) ,
    'is_hide_title' => 1,
    'icon-class' => 'random',
    'weight' => 80,
    'children' => array()
));
CmsNav::add('masters', array(
    'title' => __l('Masters') ,
    'data-bootstro-step' => '11',
    'data-bootstro-content' => __l('To manage all the master. Master includes cities, countries, states, email template, project categories and project statuses etc.') ,
    'is_hide_title' => 1,
    'column' => 2,
    'column_1' => 9,
    'url' => array(
        'admin' => true,
        'controller' => 'email_templates',
        'action' => 'index',
    ) ,
    'icon-class' => 'align-justify',
    'allowedControllers' => array(
        'terms'
    ) ,
    'weight' => 200,
    'children' => array(
        'Regional' => array(
            'title' => __l('Regional') ,
            'url' => '',
            'weight' => 100,
        ) ,
        'Banned IPs' => array(
            'title' => __l('Banned IPs') ,
            'url' => array(
                'admin' => true,
                'controller' => 'banned_ips',
                'action' => 'admin_index',
            ) ,
            'weight' => 110,
        ) ,
        'Cities' => array(
            'title' => __l('Cities') ,
            'url' => array(
                'admin' => true,
                'controller' => 'cities',
                'action' => 'admin_index',
            ) ,
            'weight' => 120,
        ) ,
        'Countries' => array(
            'title' => __l('Countries') ,
            'url' => array(
                'admin' => true,
                'controller' => 'countries',
                'action' => 'admin_index',
            ) ,
            'weight' => 130,
        ) ,
        'States' => array(
            'title' => __l('States') ,
            'url' => array(
                'admin' => true,
                'controller' => 'states',
                'action' => 'admin_index',
            ) ,
            'weight' => 140,
        ) , 
		'Currencies' => array(
            'title' => __l('Currencies') ,
            'url' => array(
                'admin' => true,
                'controller' => 'currencies',
                'action' => 'admin_index',
            ) ,
            'weight' => 150,
        ) ,
        'Email' => array(
            'title' => __l('Email') ,
            'url' => '',
            'weight' => 200,
        ) ,
        'Email Templates' => array(
            'title' => __l('Email Templates') ,
            'url' => array(
                'admin' => true,
                'controller' => 'email_templates',
                'action' => 'index',
            ) ,
            'weight' => 210,
        ) ,
        'Others' => array(
            'title' => __l('Others') ,
            'url' => '',
            'weight' => 4000,
        ) , 
        'IPs' => array(
            'title' => __l('IPs') ,
            'url' => array(
                'admin' => true,
                'controller' => 'ips',
                'action' => 'admin_index',
            ) ,
            'weight' => 4020,
        ) , 
        'Transaction Types' => array(
            'title' => __l('Transaction Types') ,
            'url' => array(
                'admin' => true,
                'controller' => 'transaction_types',
                'action' => 'admin_index',
            ) ,
            'weight' => 4030,
        ) ,
    )
));

