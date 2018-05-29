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
class ChartsController extends AppController
{
    public $name = 'Charts';
    public $lastDays;
    public $lastMonths;
    public $lastYears;
    public $lastWeeks;
    public $selectRanges;
    public $lastDaysStartDate;
    public $lastMonthsStartDate;
    public $lastYearsStartDate;
    public $lastWeeksStartDate;
    public $lastDaysPrev;
    public $lastWeeksPrev;
    public $lastMonthsPrev;
    public $lastYearsPrev;
    public function initChart() 
    {
        //# last days date settings
        $days = 6;
        $this->lastDaysStartDate = date('Y-m-d', strtotime("-$days days"));
        for ($i = $days; $i > 0; $i--) {
            $this->lastDays[] = array(
                'display' => date('D, M d', strtotime("-$i days")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-d 00:00:00', strtotime("-$i days")) ,
                    '#MODEL#.created <=' => date('Y-m-d 23:59:59', strtotime("-$i days"))
                )
            );
        }
        $this->lastDays[] = array(
            'display' => date('D, M d') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-m-d 00:00:00', strtotime("now")) ,
                '#MODEL#.created <=' => date('Y-m-d 23:59:59', strtotime("now"))
            )
        );
        $days = 13;
        for ($i = $days; $i >= 7; $i--) {
            $this->lastDaysPrev[] = array(
                'display' => date('M d, Y', strtotime("-$i days")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-d 00:00:00', strtotime("-$i days")) ,
                    '#MODEL#.created <=' => date('Y-m-d 23:59:59', strtotime("-$i days"))
                )
            );
        }
        //# last weeks date settings
        $timestamp_end = strtotime('last Saturday');
        $weeks = 3;
        $this->lastWeeksStartDate = date('Y-m-d', $timestamp_end-((($weeks*7) -1) *24*3600));
        for ($i = $weeks; $i > 0; $i--) {
            $start = $timestamp_end-((($i*7) -1) *24*3600);
            $end = $start+(6*24*3600);
            $this->lastWeeks[] = array(
                'display' => date('M d', $start) . ' - ' . date('M d', $end) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-d', $start) ,
                    '#MODEL#.created <=' => date('Y-m-d', $end) ,
                )
            );
        }
        $this->lastWeeks[] = array(
            'display' => date('M d', $timestamp_end+24*3600) . ' - ' . date('M d') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-m-d', $timestamp_end+24*3600) ,
                '#MODEL#.created <=' => date('Y-m-d', strtotime('now'))
            )
        );
        $weeks = 7;
        for ($i = $weeks; $i > 3; $i--) {
            $start = $timestamp_end-((($i*7) -1) *24*3600);
            $end = $start+(6*24*3600);
            $this->lastWeeksPrev[] = array(
                'display' => date('M d', $start) . ' - ' . date('M d', $end) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-d', $start) ,
                    '#MODEL#.created <=' => date('Y-m-d', $end)
                )
            );
        }
        //# last months date settings
        $months = 2;
        $this->lastMonthsStartDate = date('Y-m-01', strtotime("-$months months"));
        for ($i = $months; $i > 0; $i--) {
            $this->lastMonths[] = array(
                'display' => date('M, Y', strtotime("-$i months")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-01', strtotime("-$i months")) ,
                    '#MODEL#.created <=' => date('Y-m-t', strtotime("-$i months")) ,
                )
            );
        }
        $this->lastMonths[] = array(
            'display' => date('M, Y') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-m-01', strtotime('now')) ,
                '#MODEL#.created <=' => date('Y-m-t', strtotime('now')) ,
            )
        );
        $months = 5;
        for ($i = $months; $i > 2; $i--) {
            $this->lastMonthsPrev[] = array(
                'display' => date('M, Y', strtotime("-$i months")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-01', strtotime("-$i months")) ,
                    '#MODEL#.created <=' => date('Y-m-' . date('t', strtotime("-$i months")) , strtotime("-$i months"))
                )
            );
        }
        //# last years date settings
        $years = 2;
        $this->lastYearsStartDate = date('Y-01-01', strtotime("-$years years"));
        for ($i = $years; $i > 0; $i--) {
            $this->lastYears[] = array(
                'display' => date('Y', strtotime("-$i years")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-01-01', strtotime("-$i years")) ,
                    '#MODEL#.created <=' => date('Y-12-31', strtotime("-$i years")) ,
                )
            );
        }
        $this->lastYears[] = array(
            'display' => date('Y') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-01-01', strtotime('now')) ,
                '#MODEL#.created <=' => date('Y-12-31', strtotime('now')) ,
            )
        );
        $years = 5;
        for ($i = $years; $i > 2; $i--) {
            $this->lastYearsPrev[] = array(
                'display' => date('Y', strtotime("-$i years")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-01-01', strtotime("-$i years")) ,
                    '#MODEL#.created <=' => date('Y-12-' . date('t', strtotime("-$i years")) , strtotime("-$i years")) ,
                )
            );
        }
        $this->selectRanges = array(
            'lastDays' => __l('Last 7 days') ,
            'lastWeeks' => __l('Last 4 weeks') ,
            'lastMonths' => __l('Last 3 months') ,
            'lastYears' => __l('Last 3 years')
        );
    }
    public function admin_chart_stats() 
    {
    }
    public function admin_chart_metrics() 
    {
        $this->pageTitle = __l('Metrics');
    }
    public function admin_user_engagement() 
    {
        $idle_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_idle' => 1
            ) ,
            'recursive' => -1
        ));
        $posted_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_property_posted' => 1
            ) ,
            'recursive' => -1
        ));
        $requested_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_requested' => 1
            ) ,
            'recursive' => -1
        ));
        $booked_users = $this->User->find('count', array(
            'conditions' => array(
                'User.is_property_booked' => 1
            ) ,
            'recursive' => -1
        ));
        $total_users = $this->User->find('count', array(
            'recursive' => -1
        ));
        $this->set('total_users', $total_users);
        $this->set('idle_users', $idle_users);
        $this->set('posted_users', $posted_users);
        $this->set('requested_users', $requested_users);
        $this->set('booked_users', $booked_users);
    }
    public function admin_user_activities() 
    {
        App::import('Model', 'Properties.PropertyView');
        $this->PropertyView = new PropertyView();		
		App::import('Model', 'Properties.PropertyUser');
		$this->PropertyUser = new PropertyUser();
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
		App::import('Model', 'Properties.Property');
		$this->Property = new Property();
		if (isset($this->request->params['named']['role_id'])) {
            $this->request->data['Chart']['role_id'] = $this->request->params['named']['role_id'];
        }
        if (isset($this->request->data['Chart']['is_ajax_load'])) {
            $this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
        }
        $this->initChart();
		App::import('Model', 'UserLogin');
		$this->UserLogin = new UserLogin();
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $role_id = ConstUserTypes::User;
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $this->request->data['Chart']['role_id'] = $role_id;
        $_total_user_reg = $_total_user_login = $_total_user_follow = $_total_properties = $_total_property_views = $_total_bookings = $_total_property_flag = $_total_property_favourites = $_total_requests = $_total_request_favorites = $_total_request_flag = $_transaction_data = $_total_transaction_data = 0;
        $_total_user_reg_prev = $_total_user_login_prev = $_total_user_follow_prev = $_total_properties_prev = $_total_property_views_prev = $_total_bookings_prev = $_total_property_flag_prev = $_total_property_favourites_prev = $_total_requests_prev = $_total_request_favorites_prev = $_total_request_flag_prev = $_transaction_data_prev = $_total_transaction_data_prev = $_total_rev_transaction_data = $_total_rev_transaction_data_prev = $total_revenue = $rev_per = 0;
        $prev_select_var = $select_var . 'Prev';
        
        // User Registeration
        $common_conditions = array(
            'User.role_id' => $role_id
        );
        $model_datas['user_reg'] = array(
            'display' => __l('User Regsiteration') ,
            'conditions' => array()
        );
        $_user_reg_data = $this->_setLineData($select_var, $model_datas, 'User', 'User', $common_conditions);
        $_user_reg_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'User', 'User', $common_conditions);
        $sparklin_data = array();
        foreach($_user_reg_data as $display_name => $chart_data):
            $sparklin_data[] = $chart_data['0'];
            $_total_user_reg+= $chart_data['0'];
        endforeach;
        $_user_reg_data = implode(',', $sparklin_data);
        foreach($_user_reg_data_prev as $display_name => $chart_data):
            $_total_user_reg_prev+= $chart_data['0'];
        endforeach;
        // User Login
        $model_datas['user_login'] = array(
            'display' => __l('User Login') ,
            'conditions' => array()
        );
        $_user_log_data = $this->_setLineData($select_var, $model_datas, 'UserLogin', 'UserLogin');
        $_user_log_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'UserLogin', 'UserLogin');
        $sparklin_data = array();
        foreach($_user_log_data as $display_name => $chart_data):
            $sparklin_data[] = $chart_data['0'];
            $_total_user_login+= $chart_data['0'];
        endforeach;
        $_user_log_data = implode(',', $sparklin_data);
        foreach($_user_log_data_prev as $display_name => $chart_data):
            $_total_user_login_prev+= $chart_data['0'];
        endforeach;
        $this->set('user_reg_data', $_user_reg_data);
        $this->set('total_user_reg', $_total_user_reg);
        if (!empty($_total_user_reg_prev) && !empty($_total_user_reg)) {
            $user_reg_data_per = round((($_total_user_reg-$_total_user_reg_prev) *100) /$_total_user_reg_prev);
        } else if (empty($_total_user_reg_prev) && !empty($_total_user_reg)) {
            $user_reg_data_per = 100;
        } else {
            $user_reg_data_per = 0;
        }
        $this->set('user_reg_data_per', $user_reg_data_per);
        $this->set('user_log_data', $_user_log_data);
        $this->set('total_user_login', $_total_user_login);
        if (!empty($_total_user_login_prev) && !empty($_total_user_login)) {
            $user_log_data_per = round((($_total_user_login-$_total_user_login_prev) *100) /$_total_user_login_prev);
        } else if (empty($_total_user_login_prev) && !empty($_total_user_login)) {
            $user_log_data_per = 100;
        } else {
            $user_log_data_per = 0;
        }
        $this->set('user_log_data_per', $user_log_data_per);
        // User Follow
        if (isPluginEnabled('SocialMarketing')) {
            $model_datas['user-follow'] = array(
                'display' => __l('User Followers') ,
                'conditions' => array()
            );
            $_user_follow_data = $this->_setLineData($select_var, $model_datas, 'UserFollower', 'UserFollower');
            $_user_follow_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'UserFollower', 'UserFollower');
            $sparklin_data = array();
            foreach($_user_follow_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_user_follow+= $chart_data['0'];
            endforeach;
            $_user_follow_data = implode(',', $sparklin_data);
            foreach($_user_follow_data_prev as $display_name => $chart_data):
                $_total_user_follow_prev+= $chart_data['0'];
            endforeach;
            $this->set('user_follow_data', $_user_follow_data);
            $this->set('total_user_follow', $_total_user_follow);
            if (!empty($_total_user_follow_prev) && !empty($_total_user_follow)) {
                $user_follow_data_per = round((($_total_user_follow-$_total_user_follow_prev) *100) /$_total_user_follow_prev);
            } else if (empty($_total_user_follow_prev) && !empty($_total_user_follow)) {
                $user_follow_data_per = 100;
            } else {
                $user_follow_data_per = 0;
            }
            $this->set('user_follow_data_per', $user_follow_data_per);
        }
        
         // Properties 
        if (isPluginEnabled('Properties')) {
            $model_datas['properties'] = array(
                'display' => __l('Properties') ,
                'conditions' => array()
            );
            $_properties_data = $this->_setLineData($select_var, $model_datas, 'Property', 'Property');
            $_properties_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'Property', 'Property');
            $sparklin_data = array();
            foreach($_properties_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_properties+= $chart_data['0'];
            endforeach;
            $_properties_data = implode(',', $sparklin_data);
            foreach($_properties_data_prev as $display_name => $chart_data):
                $_total_properties_prev+= $chart_data['0'];
            endforeach;
            $this->set('properties_data', $_properties_data);
            $this->set('total_properties', $_total_properties);
            if (!empty($_total_properties_prev) && !empty($_total_properties)) {
                $properties_data_per = round((($_total_properties-$_total_properties_prev) *100) /$_total_properties_prev);
            } else if (empty($_total_properties_prev) && !empty($_total_properties)) {
                $properties_data_per = 100;
            } else {
                $properties_data_per = 0;
            }
            $this->set('properties_data_per', $properties_data_per);
			
			// Properties Views
            $model_datas['propertyViews'] = array(
                'display' => __l('Property Views') ,
                'conditions' => array()
            );
            $_property_views_data = $this->_setLineData($select_var, $model_datas, 'PropertyView', 'PropertyView');
            $_property_views_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'PropertyView', 'PropertyView');
            $sparklin_data = array();
            foreach($_property_views_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_property_views+= $chart_data['0'];
            endforeach;
            $_property_views_data = implode(',', $sparklin_data);
            foreach($_property_views_data_prev as $display_name => $chart_data):
                $_total_property_views_prev+= $chart_data['0'];
            endforeach;
            $this->set('property_views_data', $_property_views_data);
            $this->set('total_property_views', $_total_property_views);
            if (!empty($_total_property_views_prev) && !empty($_total_property_views)) {
                $property_views_data_per = round((($_total_property_views-$_total_property_views_prev) *100) /$_total_property_views_prev);
            } else if (empty($_total_property_views_prev) && !empty($_total_property_views)) {
                $property_views_data_per = 100;
            } else {
                $property_views_data_per = 0;
            }
            $this->set('property_views_data_per', $property_views_data_per);

			// Bookings
            $model_datas['propertyUsers'] = array(
                'display' => __l('Bookings') ,
                'conditions' => array()
            );
            $_bookings_data = $this->_setLineData($select_var, $model_datas, 'propertyUsers', 'propertyUsers');
            $_bookings_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'propertyUsers', 'propertyUsers');
            $sparklin_data = array();
            foreach($_bookings_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_bookings+= $chart_data['0'];
            endforeach;
            $_bookings_data = implode(',', $sparklin_data);
            foreach($_bookings_data_prev as $display_name => $chart_data):
                $_total_bookings_prev+= $chart_data['0'];
            endforeach;
            $this->set('bookings_data', $_bookings_data);
            $this->set('total_bookings', $_total_bookings);
            if (!empty($_total_bookings_prev) && !empty($_total_bookings)) {
                $bookings_data_per = round((($_total_bookings-$_total_bookings_prev) *100) /$_total_bookings_prev);
            } else if (empty($_total_bookings_prev) && !empty($_total_bookings)) {
                $bookings_data_per = 100;
            } else {
                $bookings_data_per = 0;
            }
            $this->set('bookings_data_per', $bookings_data_per);
        }
        // properties flag
        if (isPluginEnabled('PropertyFlags')) {
            $model_datas['property_flag'] = array(
                'display' => __l('Property Flags') ,
                'conditions' => array()
            );
            $_property_flag_data = $this->_setLineData($select_var, $model_datas, 'PropertyFlag', 'PropertyFlag');
            $_property_flag_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'PropertyFlag', 'PropertyFlag');
            $sparklin_data = array();
            foreach($_property_flag_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_property_flag+= $chart_data['0'];
            endforeach;
            $_property_flag_data = implode(',', $sparklin_data);
            foreach($_property_flag_data_prev as $display_name => $chart_data):
                $_total_property_flag_prev+= $chart_data['0'];
            endforeach;
            $this->set('property_flag_data', $_property_flag_data);
            $this->set('total_property_flag', $_total_property_flag);
            if (!empty($_total_property_flag_prev) && !empty($_total_property_flag)) {
                $property_flag_data_per = round((($_total_property_flag-$_total_property_flag_prev) *100) /$_total_property_flag_prev);
            } else if (empty($_total_property_flag_prev) && !empty($_total_property_flag)) {
                $property_flag_data_per = 100;
            } else {
                $property_flag_data_per = 0;
            }
            $this->set('property_flag_data_per', $property_flag_data_per);
        }
        
        // properties favourites
        if (isPluginEnabled('PropertyFavorites')) {
            $model_datas['property_favorite'] = array(
                'display' => __l('Property Favorites') ,
                'conditions' => array()
            );
            $_property_favourite_data = $this->_setLineData($select_var, $model_datas, 'PropertyFavorite', 'PropertyFavorite');
            $_property_favourite_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'PropertyFavorite', 'PropertyFavorite');
            $sparklin_data = array();
            foreach($_property_favourite_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_property_favourites+= $chart_data['0'];
            endforeach;
            $_property_favourite_data = implode(',', $sparklin_data);
            foreach($_property_favourite_data_prev as $display_name => $chart_data):
                $_total_property_favourites_prev+= $chart_data['0'];
            endforeach;
            $this->set('property_favourite_data', $_property_favourite_data);
            $this->set('total_property_favourite', $_total_property_favourites);
            if (!empty($_total_property_favourites_prev) && !empty($_total_property_favourites)) {
                $property_favourite_data_per = round((($_total_property_favourites-$_total_property_favourites_prev) *100) /$_total_property_favourites_prev);
            } else if (empty($_total_property_favourites_prev) && !empty($_total_property_favourites)) {
                $property_favourite_data_per = 100;
            } else {
                $property_favourite_data_per = 0;
            }
            $this->set('property_favourite_data_per', $property_favourite_data_per);
        }
        
		// Request favourites
        if (isPluginEnabled('RequestFavorites')) {
            $model_datas['request_favorite'] = array(
                'display' => __l('Request Favorites') ,
                'conditions' => array()
            );
            $_request_favorite_data = $this->_setLineData($select_var, $model_datas, 'RequestFavorites', 'RequestFavorites');
            $_request_favorite_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'RequestFavorites', 'RequestFavorites');
            $sparklin_data = array();
            foreach($_request_favorite_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_request_favorites+= $chart_data['0'];
            endforeach;
            $_request_favorite_data = implode(',', $sparklin_data);
            foreach($_request_favorite_data_prev as $display_name => $chart_data):
                $_total_request_favorites_prev+= $chart_data['0'];
            endforeach;
			$this->set('request_favorite_data', $_request_favorite_data);
            $this->set('total_request_favorite', $_total_request_favorites);
            if (!empty($_total_request_favorites_prev) && !empty($_total_request_favorites)) {
                $request_favorite_data_per = round((($_total_request_favorites-$_total_request_favorites_prev) *100) /$_total_request_favorites_prev);
            } else if (empty($_total_property_favorites_prev) && !empty($_total_property_favorites)) {
                $request_favorite_data_per = 100;
            } else {
                $request_favorite_data_per = 0;
            }
            $this->set('request_favorite_data_per', $request_favorite_data_per);
        }

        // Requests
        
        if (isPluginEnabled('Requests')) {
            $model_datas['requests'] = array(
                'display' => __l('Requests') ,
                'conditions' => array()
            );
            $_requests_data = $this->_setLineData($select_var, $model_datas, 'Property', 'Property');
            $_requests_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'Property', 'Property');
            $sparklin_data = array();
            foreach($_requests_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_requests+= $chart_data['0'];
            endforeach;
            $_requests_data = implode(',', $sparklin_data);
            foreach($_requests_data_prev as $display_name => $chart_data):
                $_total_requests_prev+= $chart_data['0'];
            endforeach;
            $this->set('requests_data', $_requests_data);
            $this->set('total_requests', $_total_requests);
            if (!empty($_total_requests_prev) && !empty($_total_requests)) {
                $requests_data_per = round((($_total_requests-$_total_requests_prev) *100) /$_total_requests_prev);
            } else if (empty($_total_requests_prev) && !empty($_total_requests)) {
                $requests_data_per = 100;
            } else {
                $requests_data_per = 0;
            }
            $this->set('requests_data_per', $requests_data_per);
        }
        
        // Request Flags
        if (isPluginEnabled('RequestFlags')) {
            $model_datas['request_flag'] = array(
                'display' => __l('Request Flags') ,
                'conditions' => array()
            );
            $_request_flag_data = $this->_setLineData($select_var, $model_datas, 'RequestFlag', 'RequestFlag');
            $_request_flag_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'RequestFlag', 'RequestFlag');
            $sparklin_data = array();
            foreach($_request_flag_data as $display_name => $chart_data):
                $sparklin_data[] = $chart_data['0'];
                $_total_request_flag+= $chart_data['0'];
            endforeach;
            $_request_flag_data = implode(',', $sparklin_data);
            foreach($_request_flag_data_prev as $display_name => $chart_data):
                $_total_request_flag_prev+= $chart_data['0'];
            endforeach;
            $this->set('request_flag_data', $_request_flag_data);
            $this->set('total_request_flag', $_total_request_flag);
            if (!empty($_total_request_flag_prev) && !empty($_total_request_flag)) {
                $request_flag_data_per = round((($_total_request_flag-$_total_request_flag_prev) *100) /$_total_request_flag_prev);
            } else if (empty($_total_request_flag_prev) && !empty($_total_request_flag)) {
                $request_flag_data_per = 100;
            } else {
                $request_flag_data_per = 0;
            }
            $this->set('request_flag_data_per', $request_flag_data_per);
        }
        
       // Revenue
        $sparklin_data = array();
        $conditions = array();
        $conditions['OR'][]['Transaction.transaction_type_id'] = ConstTransactionTypes::PropertyListingFee;
        $conditions['OR'][]['Transaction.transaction_type_id'] = ConstTransactionTypes::SignupFee;
        $conditions['OR'][]['Transaction.transaction_type_id'] = ConstTransactionTypes::PropertyVerifyFee;
        $model_datas['transaction'] = array(
            'display' => __l('Transaction') ,
            'conditions' => array()
        );
        $_transaction_data = $this->_setLineData($select_var, $model_datas, 'Transaction', 'Transaction', $conditions);
        $_transaction_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'Transaction', 'Transaction', $conditions);
        $return_field = 'amount';
        $common_conditions = array();
        $model_datas['PropertyUser'] = array(
            'display' => __l('PropertyUser') ,
            'conditions' => array()
        );
        $_rev_transaction_data = $this->_setLineData($select_var, $model_datas, 'PropertyUser', 'PropertyUser', $common_conditions, $return_field);
        $_rev_transaction_data_prev = $this->_setLineData($prev_select_var, $model_datas, 'PropertyUser', 'PropertyUser', $common_conditions, $return_field);
        foreach($_rev_transaction_data as $display_name => $chart_data):
            $sparklin_data[$display_name] = $chart_data['0']['0']['total_amount']+$_transaction_data[$display_name]['0']['0']['total_amount'];
            $_total_transaction_data+= $_transaction_data[$display_name]['0']['0']['total_amount'];
            $_total_rev_transaction_data+= $chart_data['0']['0']['total_amount'];
        endforeach;
        foreach($_transaction_data_prev as $display_name => $chart_data):
            $_total_transaction_data_prev+= $chart_data['0']['0']['total_amount'];
            $_total_rev_transaction_data_prev+= $_rev_transaction_data_prev[$display_name]['0']['0']['total_amount'];
        endforeach;
        $revenue = implode(',', $sparklin_data);
        $total_revenue = $_total_transaction_data+$_total_rev_transaction_data;
        $total_revenue_prev = $_total_transaction_data_prev+$_total_rev_transaction_data_prev;
        $this->set('revenue', $revenue);
        $this->set('total_revenue', $total_revenue);
        if (!empty($total_revenue_prev) && !empty($total_revenue)) {
            $rev_per = round((($total_revenue-$total_revenue_prev) *100) /$total_revenue_prev);
        } else if (empty($total_revenue_prev) && !empty($total_revenue)) {
            $rev_per = 100;
        } else {
            $rev_per = 0;
        }
        $this->set('rev_per', $rev_per);
    }
    protected function _setLineData($select_var, $model_datas, $models, $model = '', $common_conditions = array() , $return_field = '') 
    {
        if (is_array($models)) {
            foreach($models as $m) {
                $this->loadModel($m);
            }
        } else {
            $this->loadModel($models);
            $model = $models;
        }
        $_data = array();
        foreach($this->$select_var as $val) {
            foreach($model_datas as $model_data) {
                $new_conditions = array();
                foreach($val['conditions'] as $key => $v) {
                    $key = str_replace('#MODEL#', $model, $key);
                    $new_conditions[$key] = $v;
                }
                $new_conditions = array_merge($new_conditions, $model_data['conditions']);
                $new_conditions = array_merge($new_conditions, $common_conditions);
                if (isset($model_data['model'])) {
                    $modelClass = $model_data['model'];
                } else {
                    $modelClass = $model;
                }
                $_data[$val['display']][] = $this->{$modelClass}->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
            }
        }
        return $_data;
    }
}
?>