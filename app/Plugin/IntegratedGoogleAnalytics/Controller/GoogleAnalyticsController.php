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
class GoogleAnalyticsController extends AppController
{
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
           'IntegratedGoogleAnalytics',
        );
	}
	public function __construct($request = null, $response = null)
	{
		require_once APP . 'Vendor' . DS . 'google-api-php-client' . DS . 'src' . DS . 'Google_Client.php';
		require_once APP . 'Vendor' . DS . 'google-api-php-client' . DS . 'src' . DS . 'contrib' . DS . 'Google_AnalyticsService.php';
		$this->client = new Google_Client();
		$this->client->setClientId(Configure::read('google.consumer_key'));
		$this->client->setClientSecret(Configure::read('google.consumer_secret'));
		$this->client->setRedirectUri(Router::url('/', true) . 'socialauth/?hauth.done=Google');
		$this->client->setApplicationName(Configure::read('site.name'));
		$this->client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));
		$this->client->setUseObjects(true);
		$this->analytics = new Google_AnalyticsService($this->client);
		parent::__construct($request, $response);
	}
    public function initChart()
    {
		$this->lastDays = $this->lastDaysPrev = $this->lastWeeks = $this->lastWeeksPrev = $this->lastMonths = $this->lastMonthsPrev = $this->lastYears = $this->lastYearsPrev = array();
        //# last days date settings
        $days = 7;
		$this->lastDaysStartDate = date('Y-m-d', strtotime("-$days days"));
		for ($i = $days; $i > 0; $i--) {
            $this->lastDays[date('M d, Y', strtotime("-$i days"))] = array(
				'start_date' => date('Y-m-d', strtotime("-$i days")),
				'end_date' => date('Y-m-d', strtotime("-$i days"))
			);
        }
        $days = 14;
		for ($i = $days; $i > 7; $i--) {
            $this->lastDaysPrev[date('M d, Y', strtotime("-$i days"))] = array(
				'start_date' => date('Y-m-d', strtotime("-$i days")),
				'end_date' => date('Y-m-d', strtotime("-$i days"))
			);
        }
        //# last 3 weeks date settings
        $timestamp_end = strtotime('last Saturday');
		$weeks = 3;
		$this->lastWeeksStartDate = date('Y-m-d', $timestamp_end-((($weeks*7) -1) *24*3600));
		for ($i = $weeks; $i > 0; $i--) {
			$start = $timestamp_end-((($i*7) -1) *24*3600);
			$end = $start+(6*24*3600);
			$this->lastWeeks[date('M d', $start) . ' - ' . date('M d', $end)] = array(
				'start_date' => date('Y-m-d', $start),
				'end_date' => date('Y-m-d', $end),
			);
		}
		$this->lastWeeks[date('M d', $timestamp_end+24*3600) . ' - ' . date('M d')] = array(
			'start_date' => date('Y-m-d', $timestamp_end+24*3600) ,
			'end_date' => date('Y-m-d')
		);
		$weeks = 7;
		for ($i = $weeks; $i > 3; $i--) {
			$start = $timestamp_end-((($i*7) -1) *24*3600);
			$end = $start+(6*24*3600);
			$this->lastWeeksPrev[date('M d', $start) . ' - ' . date('M d', $end)] = array(
				'start_date' => date('Y-m-d', $start),
				'end_date' => date('Y-m-d', $end),
			);
		}
        //# last 3 months date settings
        $months = 2;
		$this->lastMonthsStartDate = date('Y-m-01', strtotime("-$months months", strtotime(date("F") . "1")));
		for ($i = $months; $i > 0; $i--) {
            $this->lastMonths[date('M, Y', strtotime("-$i months"))] = array(
				'start_date' => date('Y-m-01', strtotime("-$i months")),
				'end_date' => date('Y-m-' . date('t', strtotime("-$i months")), strtotime("-$i months"))
			);
        }
        $this->lastMonths[date('M, Y')] = array(
			'start_date' => date('Y-m-01', strtotime('now')),
			'end_date' => date('Y-m-d')
        );
        $months = 5;
		for ($i = $months; $i > 2; $i--) {
            $this->lastMonthsPrev[date('M, Y', strtotime("-$i months"))] = array(
				'start_date' => date('Y-m-01', strtotime("-$i months")),
				'end_date' => date('Y-m-' . date('t', strtotime("-$i months")), strtotime("-$i months"))
			);
        }
        //# last 3 years date settings
        $years = 2;
		$this->lastYearsStartDate = date('Y-01-01', strtotime("-$years years"));
		for ($i = $years; $i > 0; $i--) {
            $this->lastYears[date('Y', strtotime("-$i years"))] = array(
				'start_date' => date('Y-01-01', strtotime("-$i years")),
				'end_date' => date('Y-12-' . date('t', strtotime("-$i years")), strtotime("-$i years")),
            );
        }
        $this->lastYears[date('Y')] = array(
			'start_date' => date('Y-01-01', strtotime('now')),
			'end_date' => date('Y-m-d')
		);
        $years = 5;
		for ($i = $years; $i > 2; $i--) {
            $this->lastYearsPrev[date('Y', strtotime("-$i years"))] = array(
				'start_date' => date('Y-01-01', strtotime("-$i years")),
				'end_date' => date('Y-12-' . date('t', strtotime("-$i years")), strtotime("-$i years")),
            );
        }
        $this->selectRanges = array(
            'lastDays' => __l('Last 7 days') ,
            'lastWeeks' => __l('Last 4 weeks') ,
            'lastMonths' => __l('Last 3 months') ,
            'lastYears' => __l('Last 3 years')
        );
    }
	public function admin_chart_metrics()
    {
		$this->pageTitle = __l('Metrics');
		if (!empty($this->request->params['named']['select_range_id'])) {
            $select_range_id = $this->request->params['named']['select_range_id'];
        } else {
            $select_range_id = 'lastDays';
        }
		$this->set('select_range_id', $select_range_id);		
	}
	public function admin_chart_bounces()
    {
		if (Configure::read('google_analytics.access_token')) {
			$this->client->setAccessToken(Configure::read('google_analytics.access_token'));
		}
		$this->initChart();
		if (!empty($this->request->params['named']['select_range_id'])) {
            $select_var = $this->request->params['named']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
		$total_pageviews = $total_visitors = $total_bounces = $total_entrances = 0;
		foreach($this->$select_var as $display => $condition) {
			$stats = $this->_getStats($condition, 'ga:pageviews,ga:visitors,ga:bounces,ga:entrances', array('dimensions' => 'ga:date', 'sort' => 'ga:date'));
			$pageviews_arr[] = $stats->totalsForAllResults['ga:pageviews'];
			$total_pageviews += $stats->totalsForAllResults['ga:pageviews'];
			$visitors_arr[] = $stats->totalsForAllResults['ga:visitors'];
			$total_visitors += $stats->totalsForAllResults['ga:visitors'];
			$bounces_arr[] = $stats->totalsForAllResults['ga:bounces'];
			$total_bounces += $stats->totalsForAllResults['ga:bounces'];
			$total_entrances += $stats->totalsForAllResults['ga:entrances'];
		}
		$prev_select_var = $select_var . 'Prev';
		// previous period comparison
		$prev_total_pageviews = $prev_total_visitors = $prev_total_bounces = $prev_total_entrances = 0;
		foreach($this->$prev_select_var as $display => $condition) {
			$stats = $this->_getStats($condition, 'ga:pageviews,ga:visitors,ga:bounces,ga:entrances', array('dimensions' => 'ga:date', 'sort' => 'ga:date'));
			$prev_total_pageviews += $stats->totalsForAllResults['ga:pageviews'];
			$prev_total_visitors += $stats->totalsForAllResults['ga:visitors'];
			$prev_total_bounces += $stats->totalsForAllResults['ga:bounces'];
			$prev_total_entrances += $stats->totalsForAllResults['ga:entrances'];
		}
		$this->set('pageviews', implode(',', $pageviews_arr));
		$this->set('visitors', implode(',', $visitors_arr));
		$this->set('bounces', implode(',', $bounces_arr));
		$this->set('pageviews_percentage', (!empty($prev_total_pageviews)) ? round((($total_pageviews - $prev_total_pageviews) * 100) / $prev_total_pageviews) : 100);
		$this->set('visitors_percentage', (!empty($prev_total_visitors)) ? round((($total_visitors - $prev_total_visitors) * 100) / $prev_total_visitors) : 100);
		$total_bounce_rate = (!empty($total_entrances)) ? (($total_bounces / $total_entrances) * 100) : '';
		$prev_total_bounce_rate = (!empty($prev_total_entrances)) ? (($prev_total_bounces / $prev_total_entrances) * 100) : '';
		$this->set('bounce_rate_percentage', (!empty($prev_total_bounce_rate)) ? round((($total_bounce_rate - $prev_total_bounce_rate) * 100) / $prev_total_bounce_rate) : 100);
		$this->set('total_pageviews', $total_pageviews);
		$this->set('total_visitors', $total_visitors);
		$this->set('total_bounces', $total_bounces);
	}
	public function admin_chart_visitors()
    {
		if (Configure::read('google_analytics.access_token')) {
			$this->client->setAccessToken(Configure::read('google_analytics.access_token'));
		} else {
			$this->redirect(array(
				'controller' => 'google_analytics',
				'action' => 'oauth_login',
			));
		}
		$this->initChart();
		if (!empty($this->request->params['named']['select_range_id'])) {
            $select_var = $this->request->params['named']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
		foreach($this->$select_var as $display => $condition) {
			$stats = $this->_getStats($condition, 'ga:visits,ga:newVisits', array('dimensions' => 'ga:date', 'sort' => 'ga:date'));
			$visits_vs_newvisits_arr[] = '["' . $display . '", ' . $stats->totalsForAllResults['ga:visits'] . ', ' . $stats->totalsForAllResults['ga:newVisits'] . ']';
		}
		$this->set('visits_vs_newvisits', implode(',', $visits_vs_newvisits_arr));
	}
	private function _getStats($condition, $metric, $params = array())
	{
		$stats = $this->analytics->data_ga->get(
			'ga:'.Configure::read('google_analytics.profile_id'),
			$condition['start_date'],
			$condition['end_date'],
			$metric,
			$params
		);
		return $stats;
	}
	public function admin_analytics_chart()
    {
		$this->pageTitle = __l('Google Analytics');
		if (!$this->RequestHandler->isAjax()) {
			$this->layout = 'admin';
		}
	}
	public function admin_form_bounce_chart()
    {
		if (Configure::read('google_analytics.access_token')) {
			$this->client->setAccessToken(Configure::read('google_analytics.access_token'));
		} else {
			$this->redirect(array(
				'controller' => 'google_analytics',
				'action' => 'oauth_login',
			));
		}
		$this->initChart();
		if (!empty($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (!empty($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
		$this->set('selectRanges', $this->selectRanges);
		$select_var.= 'StartDate';
		$condition = array(
			'start_date' => $this->$select_var,
			'end_date' => date('Y-m-d')
		);
		$property_add_form_bounce_arr = array();
		$property_fund_form_bounce_arr = array();
		// property add form bounce query
		$stats = $this->_getStats($condition, 'ga:totalEvents', array('dimensions' => 'ga:eventLabel', 'sort' => 'ga:eventLabel', 'filters' => 'ga:eventCategory=~Property;ga:eventAction=~PropertyPosted;ga:eventLabel=~Step '));
		$property_add_steps_arr = array();
		$property_add_events_arr = array();
		if(!empty($stats->rows)){
		foreach($stats->rows as $stat) {
			$property_add_steps_arr[] = "'" . $stat[0] . "'";
			$property_add_events_arr[] = $stat[1];
		}
		}
		$property_add_form_bounce_arr[] = '["Form", ' . implode(', ', $property_add_steps_arr) . ']';
		$property_add_form_bounce_arr[] = '["Property Post", ' . implode(', ', $property_add_events_arr) . ']';			
		$this->set('property_add_form_bounces', implode(',', $property_add_form_bounce_arr));
		// property book form bounce query
		$stats = $this->_getStats($condition, 'ga:totalEvents', array('dimensions' => 'ga:eventLabel', 'sort' => 'ga:eventLabel', 'filters' => 'ga:eventCategory=~PropertyUser;ga:eventAction=~Bookit;ga:eventLabel=~Step '));
		$property_fund_events_arr = array();
		$property_fund_steps_arr = array();
		if (!empty($stats->rows)) {
			foreach($stats->rows as $stat) {
				$property_fund_steps_arr[] = "'" . $stat[0] . "'";
				$property_fund_events_arr[] = $stat[1];
			}
			if (!empty($property_fund_events_arr)) {
				$property_fund_form_bounce_arr[] = '["Form", ' . implode(', ', $property_fund_steps_arr) . ']';
				$property_fund_form_bounce_arr[] = '["Property Booking", ' . implode(', ', $property_fund_events_arr) . ']';
			}
		}
		$this->set('property_fund_form_bounces', implode(',', $property_fund_form_bounce_arr));
	}
	public function admin_sources_chart()
    {
		if (Configure::read('google_analytics.access_token')) {
			$this->client->setAccessToken(Configure::read('google_analytics.access_token'));
		} else {
			$this->redirect(array(
				'controller' => 'google_analytics',
				'action' => 'oauth_login',
			));
		}
		$this->initChart();
		if (!empty($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (!empty($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
		$this->set('selectRanges', $this->selectRanges);
		$select_var.= 'StartDate';
		$condition = array(
			'start_date' => $this->$select_var,
			'end_date' => date('Y-m-d')
		);
		// visits by source query
		$visit_by_sources_stats = $this->_getStats($condition, 'ga:visits', array('dimensions' => 'ga:source', 'sort' => 'ga:source'));
		$this->set('visit_by_sources_stats', $visit_by_sources_stats);
		// country query
		$countries_stats = $this->_getStats($condition, 'ga:visitors', array('dimensions' => 'ga:country', 'sort' => 'ga:country'));
		$this->set('countries_stats', $countries_stats);
	}
    public function admin_oauth_login()
    {
		if (!empty($_GET['code'])) {
			$this->client->authenticate();
			App::import('Model', 'Setting');
			$this->Setting = new Setting();				
			$this->Setting->updateAll(array(
				'Setting.value' => "'" . $this->client->getAccessToken() . "'"
			), array(
				'Setting.name' => 'google_analytics.access_token'
			));
			$this->Setting->updateYaml();
			$this->Session->setFlash(sprintf(__l('%s has been updated'), __l('Google Analytics credentials')), 'default', null, 'success');
			$this->redirect(array(
				'controller' => 'settings',
				'action' => 'edit',
				38
			));
		} else {
			header('location: ' . $this->client->createAuthUrl());
			exit;
		}
	}
	public function admin_ecommerce_chart()
    {
		if (Configure::read('google_analytics.access_token')) {
			$this->client->setAccessToken(Configure::read('google_analytics.access_token'));
		} else {
			$this->redirect(array(
				'controller' => 'google_analytics',
				'action' => 'oauth_login',
			));
		}
		$this->initChart();
		if (!empty($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (!empty($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
		$this->set('selectRanges', $this->selectRanges);
		$select_var.= 'StartDate';
		$condition = array(
			'start_date' => $this->$select_var,
			'end_date' => date('Y-m-d')
		);
		// ecommerce query

		$ecommerce_stats = $this->_getStats($condition, 'ga:totalValue', array('dimensions' => 'ga:source'));
		$ecommerce_stats_category = $this->_getStats($condition, 'ga:itemRevenue', array('dimensions' => 'ga:productCategory'));
		$this->set('ecommerce_stats', $ecommerce_stats);
		$this->set('ecommerce_stats_category', $ecommerce_stats_category);
	

	}
	public function admin_ecommerce_transaction_chart()
    {

		if (Configure::read('google_analytics.access_token')) {
			$this->client->setAccessToken(Configure::read('google_analytics.access_token'));
		}
		$this->initChart();
		if (!empty($this->request->params['named']['select_range_id'])) {
            $select_var = $this->request->params['named']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }

		$total_transaction = $total_transactionRevenue = 0;
		foreach($this->$select_var as $display => $condition) {
			$stats = $this->_getStats($condition, 'ga:transactions,ga:transactionRevenue', array('dimensions' => 'ga:date', 'sort' => 'ga:date'));
			$transaction_arr[] = $stats->totalsForAllResults['ga:transactions'];
			$total_transaction += $stats->totalsForAllResults['ga:transactions'];
			$transactionRevenue_arr[] = $stats->totalsForAllResults['ga:transactionRevenue'];
			$total_transactionRevenue += $stats->totalsForAllResults['ga:transactionRevenue'];
		}
		$prev_select_var = $select_var . 'Prev';
		// previous period comparison
		$prev_total_transaction = $prev_total_transactionRevenue =0;
		foreach($this->$prev_select_var as $display => $condition) {
			$stats = $this->_getStats($condition, 'ga:transactions,ga:transactionRevenue', array('dimensions' => 'ga:date', 'sort' => 'ga:date'));
			$prev_total_transaction += $stats->totalsForAllResults['ga:transactions'];
			$prev_total_transactionRevenue += $stats->totalsForAllResults['ga:transactionRevenue'];
		}
		$this->set('transaction', implode(',', $transaction_arr));
		$this->set('transactionRevenue', implode(',', $transactionRevenue_arr));
		$this->set('transaction_percentage', (!empty($prev_total_transaction)) ? round((($total_transaction - $prev_total_transaction) * 100) / $prev_total_transaction) : 100);
		$this->set('transactionRevenue_percentage', (!empty($prev_total_transactionRevenue)) ? round((($total_transactionRevenue - $prev_total_transactionRevenue) * 100) / $prev_total_transactionRevenue) : 100);
		
		$this->set('total_transaction', $total_transaction);
		$this->set('total_transactionRevenue', $total_transactionRevenue);

	}


}
?>