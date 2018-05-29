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
CmsNav::add('properties', array(
     'title' => __l('Properties') ,
    'url' => array(
        'admin' => true,
        'controller' => 'properties',
        'action' => 'admin_index',
    ) ,
    'data-bootstro-step' => '4',
    'data-bootstro-content' => __l('To monitor the summary, price point statistics of site and also to manage all properties & Collections in the site.'),
    'icon-class' => 'building',
    'weight' => 30,
    'children' => array(
		'property' => array(
            'title' => __l('Properties') ,
            'url' => '' ,
            'weight' => 10,
        ) , 
		'properties' => array(
            'title' => __l('Properties') ,
            'url' => array(
                'admin' => true,
                'controller' => 'properties',
                'action' => 'admin_index',
            ) ,
            'weight' => 20,
        ) , 
		'Property Bookings' => array(
            'title' => __l('Property Bookings') ,
            'url' => array(
                'admin' => true,
                'controller' => 'property_users',
                'action' => 'index',
            ) ,
            'weight' => 30,
        ) ,
		'Post a Property' => array(
            'title' => __l('Post a Property') ,
            'url' => array(
                'controller' => 'properties',
                'action' => 'add',
            ) ,
            'weight' => 40,
        ) 
    )
));


CmsNav::add('activities', array(
    'title' => __l('Activities') ,
    'icon-class' => 'time',
    'weight' => 60,
    'children' => array(
		 'property' => array(
						'title' => __l('Properties') ,
						'url' => '',
						'weight' => 40,
				 ) ,
				'property_views' => array(
					'title' => __l('Property Views') ,
					'url' => array(
						'admin' => true,
						'controller' => 'property_views',
						'action' => 'admin_index',
					) ,
					'weight' => 40,
				),
				'properties' => array(
					'title' => __l('Search Logs') ,
					'url' => array(
						'admin' => true,
						'controller' => 'search_logs',
						'action' => 'admin_index',
					) ,
					'weight' => 70,
				) ,
				'feedback' => array(
						'title' => __l('Feedback') ,
						'url' => '',
						'weight' => 120,
				 ) ,
				'property_feedbacks' => array(
					'title' => __l('Feedback To Host') ,
					'url' => array(
						'admin' => true,
						'controller' => 'property_feedbacks',
						'action' => 'admin_index',
					) ,
					'weight' => 120,
				),
				'property_user_feedbacks' => array(
					'title' => __l('Feedback To Traveler') ,
					'url' => array(
						'admin' => true,
						'controller' => 'property_user_feedbacks',
						'action' => 'admin_index',
					) ,
					'weight' => 130,
				),
				'Property' => array(
					'title' => __l('Property Activities') ,
					'url' => array(
						'admin' => true,
						'controller' => 'messages',
						'action' => 'notifications',
						'type' => 'list',
					) ,
					'weight' => 70,
				) ,
				'Disputes' => array(
						'title' => __l('Disputes') ,
						'url' => '',
						'weight' => 140,
				 ) ,
				'property_user_disputes' => array(
					'title' => __l('Disputes') ,
					'url' => array(
						'admin' => true,
						'controller' => 'property_user_disputes',
						'action' => 'admin_index',
					) ,
					'weight' => 140,
				),
			)
		));
CmsNav::add('masters', array(
    'title' => 'Masters',
    'weight' => 200,
    'children' => array(
		 'Property' => array(
            'title' => __l('Property') ,
            'url' => '',
            'weight' => 1000,
        ) ,
        'Property Types' => array(
            'title' => __l('Property Types') ,
            'url' => array(
                'admin' => true,
                'controller' => 'property_types',
                'action' => 'index',
            ) ,
            'weight' => 1001,
        ) ,
		'Property Flag Categories' => array(
            'title' => __l('Property Flag Categories') ,
            'url' => array(
                'admin' => true,
                'controller' => 'property_flag_categories',
                'action' => 'index',
            ) ,
            'weight' => 1002,
        ) ,
		'Bed Types' => array(
            'title' => __l('Bed Types') ,
            'url' => array(
                'admin' => true,
                'controller' => 'bed_types',
                'action' => 'admin_index',
            ) ,
            'weight' => 1003,
        ) ,
		'Holiday Types' => array(
            'title' => __l('Holiday Types') ,
            'url' => array(
                'admin' => true,
                'controller' => 'holiday_types',
                'action' => 'admin_index',
            ) ,
            'weight' => 1004,
        ) ,
		'Room Types' => array(
            'title' => __l('Room Types') ,
            'url' => array(
                'admin' => true,
                'controller' => 'room_types',
                'action' => 'admin_index',
            ) ,
            'weight' => 1005,
        ) ,
		'Cancellation Policies' => array(
            'title' => __l('Cancellation Policies') ,
            'url' => array(
                'admin' => true,
                'controller' => 'cancellation_policies',
                'action' => 'admin_index',
            ) ,
            'weight' => 1006,
        ) ,
		'Amenities' => array(
            'title' => __l('Amenities') ,
            'url' => array(
                'admin' => true,
                'controller' => 'amenities',
                'action' => 'admin_index',
            ) ,
            'weight' => 4010,
        ) ,
    )
));			
CmsHook::setExceptionUrl(array(
	'properties/index',
	'properties/view',
	'properties/calendar',
	'properties/datafeed',
	'properties/map',
	'properties/cluster_data',
	'properties/get_info',
	'properties/pricefeed',
	'properties/price',
	'properties/weather',
	'properties/review_index',
	'properties/home',
	'properties/search',
	'properties/streetview',
	'properties/flickr',
	'properties/bookit',
	'properties/static_map',
	'properties/amenities_around',
	'properties/tweet_around',
	'properties/calendar_edit',
	'property_users/add',
	'property_feedbacks/index',
	'property_user_feedbacks/index',
	'properties/property_calendar',
	'properties/weather_data',
	'properties/update_price',
	'properties/update_view_count',
	'properties/order',
));
$defaultModel = array(
    'User' => array(
		'hasMany' => array(			
			'Property' => array(
				'className' => 'Properties.Property',
				'foreignKey' => 'user_id',
				'dependent' => true,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			) ,
		   'PropertyUser' => array(
				'className' => 'Properties.PropertyUser',
				'foreignKey' => 'user_id',
				'dependent' => true,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			) ,
			'Message' => array(
				'className' => 'Properties.Message',
				'foreignKey' => 'user_id',
				'dependent' => true,
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
	'UserProfile' => array(
		'hasAndBelongsToMany' => array(
		   'Habit' => array(
				'className' => 'Properties.Habit',
				'joinTable' => 'habits_user_profiles',
				'foreignKey' => 'user_profile_id',
				'associationForeignKey' => 'habit_id',
				'unique' => true,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			)
		),
    ) ,
	'Collection' => array(
		'hasAndBelongsToMany' => array(
			'Property' => array(
				'className' => 'Properties.Property',
				'joinTable' => 'collections_properties',
				'foreignKey' => 'collection_id',
				'associationForeignKey' => 'property_id',
				'unique' => true,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			)
		),
    ) ,	
	'Request' => array(
		'hasAndBelongsToMany' => array(
			'Amenity' => array(
				'className' => 'Properties.Amenity',
				'joinTable' => 'amenities_requests',
				'foreignKey' => 'request_id',
				'associationForeignKey' => 'amenity_id',
				'unique' => true,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			) ,
			'HolidayType' => array(
				'className' => 'Properties.HolidayType',
				'joinTable' => 'holiday_type_requests',
				'foreignKey' => 'request_id',
				'associationForeignKey' => 'holiday_type_id',
				'unique' => true,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			) ,
		),
	),
	'AmenitiesRequest' => array(
		'belongsTo' => array(
			'Amenity' => array(
				'className' => 'Properties.Amenity',
				'foreignKey' => 'amenity_id',
				'conditions' => '',
				'fields' => '',
				'order' => '',
			) ,		
		),
    ) ,	
	'Transaction' => array(
		'belongsTo' => array(
		   'PropertyUser' => array(
				'className' => 'Properties.PropertyUser',
				'foreignKey' => 'foreign_id',
				'conditions' => '',
				'fields' => '',
				'order' => '',
			),
			'Property' => array(
				'className' => 'Properties.Property',
				'foreignKey' => 'foreign_id',
				'conditions' => '',
				'fields' => '',
				'order' => '',
			)
		),
    ) ,
	'Ip' => array(
		'PropertyView' => array(
            'className' => 'Properties.PropertyView',
            'foreignKey' => 'ip_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'SearchLog' => array(
            'className' => 'Properties.SearchLog',
            'foreignKey' => 'ip_id',
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
    ) ,
);
CmsHook::bindModel($defaultModel);
$sitemap_conditions = array(
    'Property.admin_suspend' => 0,
	'Property.is_approved' => 1,
	'Property.is_active' => 1,
);
CmsHook::setSitemapModel(array(
    'Property' => array(
        'conditions' => $sitemap_conditions,
        'recursive' => 0
    )
));
?>