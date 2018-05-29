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
 CmsNav::add('requests', array(
     'title' => __l('Requests') ,
    'url' => array(
        'controller' => 'requests',
        'action' => 'admin_index',
    ) ,
    'data-bootstro-step' => '5',
    'data-bootstro-content' => __l('To monitor the summary, price point statistics of site and also to manage all requests posted in the site.'),
    'icon-class' => 'mail-reply-all ',
    'weight' => 40,
    'children' => array(
		'requests' => array(
            'title' => __l('Requests') ,
            'url' => array(
                'admin' => true,
                'controller' => 'requests',
                'action' => 'admin_index',
            ) ,
            'weight' => 10,
        ) ,
		'Post a Request' => array(
            'title' => __l('Post a Request') ,
            'url' => array(
                'admin' => true,
                'controller' => 'requests',
                'action' => 'add',
            ) ,
            'weight' => 20,
        ) 
    )
));
CmsNav::add('activities', array(
    'title' => __l('Activities') ,
    'icon-class' => 'time',
    'weight' => 60,
    'children' => array(
		 'request' => array(
					'title' => __l('Requests') ,
					'url' => '',
					'weight' => 90,
				 ) ,
				'request_views' => array(
					'title' => __l('Request Views') ,
					'url' => array(
						'admin' => true,
						'controller' => 'request_views',
						'action' => 'admin_index',
					) ,
					'weight' => 90,
				)
			)
		));
CmsNav::add('masters', array(
    'title' => 'Masters',
    'weight' => 200,
    'children' => array(
		 'Request' => array(
            'title' => __l('Request') ,
            'url' => '',
            'weight' => 1050,
        ) ,
        'Request Flag Categories' => array(
            'title' => __l('Request Flag Categories') ,
            'url' => array(
                'admin' => true,
                'controller' => 'request_flag_categories',
                'action' => 'index',
            ) ,
            'weight' => 1051,
        ) ,
    )
));	
$defaultModel = array(
    'Property' => array(
		'hasMany' => array(			
			'PropertiesRequest' => array(
				'className' => 'Requests.PropertiesRequest',
				'foreignKey' => 'property_id',
				'dependent' => false,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			)
		)
    ) ,
    'Message' => array(
		'belongsTo' => array(
			'Request' => array(
				'className' => 'Requests.Request',
				'foreignKey' => 'request_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			) ,
		)
    )
);
CmsHook::bindModel($defaultModel);	
CmsHook::setExceptionUrl(array( 	
	'requests/get_info',	
	'requests/index',
	'requests/view',
	'requests/update_view_count',
 ));

