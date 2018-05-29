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
class InsightsController extends AppController
{
    public $name = 'Insights';
    public $lastDays;
    public $lastMonths;
    public $lastYears;
    public $lastWeeks;
    public $selectRanges;
    public $lastDaysStartDate;
    public $lastMonthsStartDate;
    public $lastYearsStartDate;
    public $lastWeeksStartDate;
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
               '#MODEL#.created >=' => date('Y-m-d 00:00:00', strtotime('now')) ,
               '#MODEL#.created <=' => date('Y-m-d H:i:s', strtotime('now')) ,
            )
        );
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
                '#MODEL#.created <=' => date('Y-m-d')
            )
        );
        //# last months date settings
        $months = 2;
        $this->lastMonthsStartDate = date('Y-m-01', strtotime("-$i months", strtotime(date("F") . "1")));
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
        $this->selectRanges = array(
            'lastDays' => __l('Last 7 days') ,
            'lastWeeks' => __l('Last 4 weeks') ,
            'lastMonths' => __l('Last 3 months') ,
            'lastYears' => __l('Last 3 years')
        );
    }
    public function admin_chart_overview()
    {
        $this->initChart();
        App::import('Model', 'Properties.PropertyView');
        $this->PropertyView = new PropertyView();
		App::import('Model', 'Properties.PropertyUser');
		$this->PropertyUser = new PropertyUser();
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        App::import('Model', 'Properties.Property');
        $this->Property = new Property();
		if(isPluginEnabled('Withdrawals')) {
			App::import('Model', 'Withdrawals.UserCashWithdrawal');
			$this->UserCashWithdrawal = new UserCashWithdrawal();						
		}
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $common_conditions = array();
        $conditions = array();
        $transaction_model_datas = array();
        $transaction_model_datas['Total Deposited (Add to wallet) Amount'] = array(
            'display' => __l('Deposited') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::AddedToWallet
            ) ,
        );
        $transaction_model_datas['Total Withdrawn Amount'] = array(
            'display' => __l('Withdrawn Amount') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::CashWithdrawalRequestApproved
            ) ,
        );
        $transaction_model_datas['Total Amount Paid to Host'] = array(
            'display' => __l('Amount Paid to Host') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'PropertyUser',
            'conditions' => array(
                'PropertyUser.is_payment_cleared' => 1
            ) ,
        );
		if(isPluginEnabled('Withdrawals')) {
        $transaction_model_datas['Total Pending Withdraw Request'] = array(
            'display' => __l('Pending Withdraw Request') ,
            'model' => 'UserCashWithdrawal',
            'conditions' => array(
                'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Pending
            ) ,
        );
		}
        $chart_transactions_data = array();
        foreach($this->$select_var as $val) {
            foreach($transaction_model_datas as $model_data) {
                $new_conditions = array();
                if (isset($model_data['model'])) {
                    $modelClass = $model_data['model'];
                } else {
                    $modelClass = 'Transaction';
                }
                foreach($val['conditions'] as $key => $v) {
                    $key = str_replace('#MODEL#', $modelClass, $key);
                    $new_conditions[$key] = $v;
                }
                $new_conditions = array_merge($new_conditions, $model_data['conditions']);
                if ($modelClass == 'Transaction') {
                    $value_count = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Transaction.amount) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else if ($modelClass == 'PropertyUser') {
                    $value_count = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(PropertyUser.host_service_amount) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else {
                    $value_count = $this->{$modelClass}->find('count', array(
                        'conditions' => $new_conditions,
                        'recursive' => 0
                    ));
                }
                $chart_transactions_data[$val['display']][] = $value_count;
            }
        }
        $this->set('chart_transactions_periods', $transaction_model_datas);
        $this->set('chart_transactions_data', $chart_transactions_data);
        //Toatal Bookings
        $booking_model_datas['Pipeline'] = array(
            'display' => __l('Pipeline') ,
            'model' => 'PropertyUser',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Confirmed,
                    ConstPropertyUserStatus::Arrived,
                    ConstPropertyUserStatus::WaitingforReview,
                    ConstPropertyUserStatus::Completed
                ) ,
                'PropertyUser.is_payment_cleared' => 0,
            ) ,
        );
        $booking_model_datas['Cleared'] = array(
            'display' => __l('Cleared') ,
            'model' => 'PropertyUser',
            'conditions' => array(
                'PropertyUser.is_payment_cleared' => 1
            ) ,
        );
        $booking_model_datas['Lost'] = array(
            'display' => __l('Lost') ,
            'model' => 'PropertyUser',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Rejected,
                    ConstPropertyUserStatus::Canceled,
                    ConstPropertyUserStatus::Expired,
                    ConstPropertyUserStatus::CanceledByAdmin
                )
            ) ,
        );
        $chart_booking_data = $this->_setLineData($select_var, $booking_model_datas, 'PropertyUser', $common_conditions);
        $this->set('chart_booking_data', $chart_booking_data);
        $this->set('chart_booking_data_periods', $booking_model_datas);
        //Revenue
        $revenue_model_datas['Membership Fee'] = array(
            'display' => __l('Membership Fee') ,
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::SignupFee,
            ) ,
            'fields' => array(
                'SUM(Transaction.amount) as total_amount'
            ) ,
        );
        $revenue_model_datas['Listing Fee'] = array(
            'display' => __l('Listing Fee') ,
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::PropertyListingFee,
            ) ,
            'fields' => array(
                'SUM(Transaction.amount) as total_amount'
            ) ,
        );
        $revenue_model_datas['Verification Fee'] = array(
            'display' => __l('Verification Fee') ,
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::PropertyVerifyFee,
            ) ,
            'fields' => array(
                'SUM(Transaction.amount) as total_amount'
            ) ,
        );
        $revenue_model_datas['Service Fee From Traveler'] = array(
            'display' => __l('Service Fee From Traveler') ,
            'model' => 'PropertyUser',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Confirmed,
                    ConstPropertyUserStatus::Arrived,
                    ConstPropertyUserStatus::WaitingforReview,
                    ConstPropertyUserStatus::Completed,
                    ConstPropertyUserStatus::PaymentCleared
                )
            ) ,
            'fields' => array(
                'SUM(PropertyUser.traveler_service_amount) as total_amount'
            ) ,
        );
        $revenue_model_datas['Site Commission from Host'] = array(
            'display' => __l('Site Commission from Host') ,
            'model' => 'Transaction',
            'conditions' => array(
                'PropertyUser.is_payment_cleared' => 1
            ) ,
            'fields' => array(
                'SUM(PropertyUser.host_service_amount) as total_amount'
            ) ,
        );
        $chart_revenue_data = $this->_setLineData($select_var, $revenue_model_datas, 'PropertyUser', $common_conditions);
        $this->set('chart_revenue_data', $chart_revenue_data);
        $this->set('chart_revenue_data_periods', $revenue_model_datas);
        //
        $this->_setPropertyViews($select_var);
        $this->set('selectRanges', $this->selectRanges);
    }
    protected function _setPropertyViews($select_var)
    {
        App::import('Model', 'Properties.PropertyView');
        $this->PropertyView = new PropertyView();		
        $common_conditions = array();
        $property_view_model_datas['Property View'] = array(
            'display' => __l('Property View') ,
            'conditions' => array() ,
        );
        $chart_property_views_data = $this->_setLineData($select_var, $property_view_model_datas, array(
            'PropertyView'
        ) , 'PropertyView', $common_conditions);        
        $this->set('chart_property_views_data', $chart_property_views_data);        
    }
    public function admin_chart_users()
    {
        if (isset($this->request->params['named']['role_id'])) {
            $this->request->data['Chart']['role_id'] = $this->request->params['named']['role_id'];
        }
        if (isset($this->request->data['Chart']['is_ajax_load'])) {
            $this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
        }
        $this->initChart();
		App::import('Model', 'User');
		$this->User = new User();
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
        $model_datas['Normal'] = array(
            'display' => __l('Normal') ,
            'conditions' => array(
                'User.is_facebook_register' => 0,
                'User.is_twitter_register' => 0,
                'User.is_openid_register' => 0,
                'User.is_google_register' => 0,
                'User.is_googleplus_register' => 0,
                'User.is_yahoo_register' => 0,
                'User.is_linkedin_register' => 0,
            )
        );
        $model_datas['Twitter'] = array(
            'display' => __l('Twitter') ,
            'conditions' => array(
                'User.is_twitter_register' => 1,
            ) ,
        );
        if (Configure::read('facebook.is_enabled_facebook_connect')) {
            $model_datas['Facebook'] = array(
                'display' => __l('Facebook') ,
                'conditions' => array(
                    'User.is_facebook_register' => 1,
                )
            );
        }
        if (Configure::read('openid.is_enabled_openid_connect') || Configure::read('google.is_enabled_google_connect') || Configure::read('google.is_enabled_googleplus_connect') || Configure::read('yahoo.is_enabled_yahoo_connect')) {
            $model_datas['OpenID'] = array(
                'display' => __l('OpenID') ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                )
            );
        }
        $model_datas['Gmail'] = array(
            'display' => __l('Gmail') ,
            'conditions' => array(
                'User.is_google_register' => 1,
            )
        );
        $model_datas['GooglePlus'] = array(
            'display' => __l('GooglePlus') ,
            'conditions' => array(
                'User.is_googleplus_register' => 1,
            )
        );
        $model_datas['Yahoo'] = array(
            'display' => __l('Yahoo!') ,
            'conditions' => array(
                'User.is_yahoo_register' => 1,
            )
        );
        $model_datas['LinkedIn'] = array(
            'display' => __l('LinkedIn') ,
            'conditions' => array(
                'User.is_linkedin_register' => 1,
            )
        );
        $model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array(
            'User.role_id' => $role_id
        );
        $_data = $this->_setLineData($select_var, $model_datas, 'User', 'User', $common_conditions);
        $this->set('chart_data', $_data);
        $this->set('chart_periods', $model_datas);
        $this->set('selectRanges', $this->selectRanges);
        // overall pie chart
        $select_var.= 'StartDate';
        $startDate = $this->$select_var;
        $endDate = date('Y-m-d 23:59:59');
        $total_users = $this->User->find('count', array(
            'conditions' => array(
                'User.role_id' => $role_id,
                'User.created >=' => date('Y-m-d H:i:s', strtotime($startDate)) ,
                'User.created <=' => date('Y-m-d H:i:s', strtotime($endDate))
            ) ,
            'recursive' => -1
        ));
        unset($model_datas['All']);
        $_pie_data = array();
        if (!empty($total_users)) {
            foreach($model_datas as $_period) {
                $new_conditions = array();
                $new_conditions = array_merge($_period['conditions'], array(
                    'User.created >=' => date('Y-m-d H:i:s', strtotime($startDate)) ,
                    'User.created <=' => date('Y-m-d H:i:s', strtotime($endDate))
                ));
                $new_conditions['User.role_id'] = $role_id;
                $sub_total = $this->User->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => -1
                ));
                $_pie_data[$_period['display']] = number_format(($sub_total/$total_users) *100, 2);
            }
        }
        $this->set('chart_pie_data', $_pie_data);
    }
    public function admin_chart_user_logins()
    {
        $this->initChart();
		App::import('Model', 'UserLogin');
		$this->UserLogin = new UserLogin();
        if (isset($this->request->params['named']['role_id'])) {
            $this->request->data['Chart']['role_id'] = $this->request->params['named']['role_id'];
        }
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['is_ajax_load'])) {
            $this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $role_id = ConstUserTypes::User;
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $this->request->data['Chart']['role_id'] = $role_id;
        $model_datas['Normal'] = array(
            'display' => __l('Normal') ,
            'conditions' => array(
                'User.is_facebook_register' => 0,
                'User.is_twitter_register' => 0,
                'User.is_openid_register' => 0,
                'User.is_google_register' => 0,
                'User.is_googleplus_register' => 0,
                'User.is_yahoo_register' => 0,
                'User.is_linkedin_register' => 0,				
            )
        );
        $model_datas['Twitter'] = array(
            'display' => __l('Twitter') ,
            'conditions' => array(
                'User.is_twitter_register' => 1,
            ) ,
        );
        if (Configure::read('facebook.is_enabled_facebook_connect')) {
            $model_datas['Facebook'] = array(
                'display' => __l('Facebook') ,
                'conditions' => array(
                    'User.is_facebook_register' => 1,
                )
            );
        }
         if (Configure::read('openid.is_enabled_openid_connect') || Configure::read('google.is_enabled_google_connect') || Configure::read('google.is_enabled_googleplus_connect') || Configure::read('yahoo.is_enabled_yahoo_connect')) {
            $model_datas['OpenID'] = array(
                'display' => __l('OpenID') ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                )
            );
        }
        $model_datas['Gmail'] = array(
            'display' => __l('Gmail') ,
            'conditions' => array(
                'User.is_google_register' => 1,
            )
        );
        $model_datas['GooglePlus'] = array(
            'display' => __l('GooglePlus') ,
            'conditions' => array(
                'User.is_googleplus_register' => 1,
            )
        );
        $model_datas['Yahoo'] = array(
            'display' => __l('Yahoo!') ,
            'conditions' => array(
                'User.is_yahoo_register' => 1,
            )
        );
        $model_datas['LinkedIn'] = array(
            'display' => __l('LinkedIn') ,
            'conditions' => array(
                'User.is_linkedin_register' => 1,
            )
        );
        $model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array(
            'User.role_id' => $role_id
        );
        $_data = $this->_setLineData($select_var, $model_datas, 'UserLogin', 'UserLogin', $common_conditions);
        $this->set('chart_data', $_data);
        $this->set('chart_periods', $model_datas);
        $this->set('selectRanges', $this->selectRanges);
        // overall pie chart
        $select_var.= 'StartDate';
        $startDate = $this->$select_var;
        $endDate = date('Y-m-d H:i:s');
        $total_users = $this->UserLogin->find('count', array(
            'conditions' => array(
                'User.role_id' => $role_id,
                'UserLogin.created >=' => $startDate,
                'UserLogin.created <=' => $endDate,
            ) ,
            'recursive' => 0
        ));
        unset($model_datas['All']);
        $_pie_data = array();
        if (!empty($total_users)) {
            foreach($model_datas as $_period) {
                $new_conditions = array();
                $new_conditions = array_merge($_period['conditions'], array(
                    'UserLogin.created >=' => $startDate,
                    'UserLogin.created <=' => $endDate
                ));
                $new_conditions['User.role_id'] = $role_id;
                $sub_total = $this->UserLogin->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $_pie_data[$_period['display']] = number_format(($sub_total/$total_users) *100, 2);
            }
        }
        $this->set('chart_pie_data', $_pie_data);
        $is_ajax_load = false;
        if ($this->RequestHandler->isAjax()) {
            $is_ajax_load = true;
        }
        $this->set('is_ajax_load', $is_ajax_load);
    }
    public function admin_chart_requests()
    {
		if(isPluginEnabled('Requests')){
			App::import('Model', 'Requests.Request');
			$this->Request = new Request();		
			$this->initChart();
			if (isset($this->request->params['named']['select_range_id'])) {
				$this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
			}
			if (isset($this->request->data['Chart']['is_ajax_load'])) {
				$this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
			}
			if (isset($this->request->data['Chart']['select_range_id'])) {
				$select_var = $this->request->data['Chart']['select_range_id'];
			} else {
				$select_var = 'lastDays';
			}
			$this->request->data['Chart']['select_range_id'] = $select_var;
			//# requests
			$conditions = array();
			$not_conditions = array();
			$request_model_datas['Enabled'] = array(
				'display' => __l('Enabled') ,
				'conditions' => array(
					'Request.is_active' => 1
				) ,
			);
			$request_model_datas['Disabled'] = array(
				'display' => __l('Disabled') ,
				'conditions' => array(
					'Request.is_active' => 0
				) ,
			);
			if (!Configure::read('request.is_auto_approve')) {
				$request_model_datas['Waiting for Approval'] = array(
					'display' => __l('Waiting for Approval') ,
					'conditions' => array(
						'Request.is_approved' => 0
					) ,
				);
			}
			$common_conditions = array();
			$chart_requests_data = $this->_setLineData($select_var, $request_model_datas, 'Request', $common_conditions);
			$this->set('chart_requests_data', $chart_requests_data);
			$this->set('chart_requests_periods', $request_model_datas);
			$this->set('selectRanges', $this->selectRanges);
		}
    }
    public function admin_chart_properties()
    {
        $this->initChart();
        App::import('Model', 'Properties.Property');
        $this->Property = new Property();
        App::import('Model', 'Properties.PropertyUserDispute');
        $this->PropertyUserDispute = new PropertyUserDispute();
        App::import('Model', 'Properties.PropertyUserStatus');
        $this->PropertyUserStatus = new PropertyUserStatus();		
        App::import('Model', 'Properties.DisputeStatus');
        $this->DisputeStatus = new DisputeStatus();		
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['is_ajax_load'])) {
            $this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
        //#  Properties
        $property_model_datas['Enabled'] = array(
            'display' => __l('Enabled') ,
            'conditions' => array(
                'Property.is_active' => 1,
            ) ,
        );
        $property_model_datas['Disabled'] = array(
            'display' => __l('Disabled') ,
            'conditions' => array(
                'Property.is_active' => 0,
            ) ,
        );
        if (!Configure::read('property.is_auto_approve')) {
            $property_model_datas['Waiting for Approval'] = array(
                'display' => __l('Waiting for Approval') ,
                'conditions' => array(
                    'Property.is_approved' => 0
                ) ,
            );
        }
        $property_model_datas['Imported from AirBnB'] = array(
            'display' => __l('Imported from AirBnB') ,
            'conditions' => array(
                'Property.is_imported_from_airbnb' => 1,
            ) ,
        );
        if (Configure::read('property.is_property_verification_enabled')) {
            $property_model_datas['Verified'] = array(
                'display' => __l('Verified') ,
                'conditions' => array(
                    'Property.is_verified' => ConstVerification::Verified,
                ) ,
            );
            $property_model_datas['Waiting for Verfication'] = array(
                'display' => __l('Waiting for Verfication') ,
                'conditions' => array(
                    'Property.is_verified' => ConstVerification::WaitingForVerification,
                ) ,
            );
        }
        //# property bookings
        $property_users_statuses = $this->PropertyUserStatus->find('all', array(
            'recursive' => -1
        ));
        foreach($property_users_statuses as $property_user_status) {
            $property_user_model_datas[$property_user_status['PropertyUserStatus']['name']] = array(
                'display' => $property_user_status['PropertyUserStatus']['name'],
                'conditions' => array(
                    'PropertyUser.property_user_status_id' => $property_user_status['PropertyUserStatus']['id']
                ) ,
            );
        }
        //# property user disputes
        $property_user_dispute_statuses = $this->DisputeStatus->find('all', array(
            'recursive' => -1
        ));
        foreach($property_user_dispute_statuses as $property_dispute_status) {
            $property_dispute_model_datas[$property_dispute_status['DisputeStatus']['name']] = array(
                'display' => $property_dispute_status['DisputeStatus']['name'],
                'conditions' => array(
                    'PropertyUserDispute.dispute_status_id' => $property_dispute_status['DisputeStatus']['id']
                ) ,
            );
        }
        $common_conditions = array();
        $chart_property_dispute_data = $this->_setLineData($select_var, $property_dispute_model_datas, 'PropertyUserDispute', $common_conditions);
        $this->set('chart_property_dispute_data', $chart_property_dispute_data);
        $this->set('chart_property_dispute_periods', $property_dispute_model_datas);
        $chart_properties_data = $this->_setLineData($select_var, $property_model_datas, 'Property', $common_conditions);
        $this->set('chart_properties_data', $chart_properties_data);
        $this->set('chart_properties_periods', $property_model_datas);
        $chart_property_user_status_data = $this->_setLineData($select_var, $property_user_model_datas, 'PropertyUser', $common_conditions);
        $this->set('chart_property_user_status_data', $chart_property_user_status_data);
        $this->set('chart_property_user_status_periods', $property_user_model_datas);
        $this->set('selectRanges', $this->selectRanges);
    }
    protected function _setDemographics($total_users, $conditions = array())
    {
		App::import('Model', 'User');
		$this->User = new User();	
        $chart_pie_relationship_data = $chart_pie_education_data = $chart_pie_employment_data = $chart_pie_income_data = $chart_pie_gender_data = $chart_pie_age_data = array();
        if (!empty($total_users)) {
            $not_mentioned = array(
                '0' => __l('Not Mentioned')
            );
            //# education
			$user_educations = array();
			if(isPluginEnabled('Insights')){
				$user_educations = $this->User->UserProfile->UserEducation->find('list', array(
					'conditions' => array(
						'UserEducation.is_active' => 1,
					) ,
					'fields' => array(
						'UserEducation.id',
						'UserEducation.education',
					) ,
					'recursive' => -1
				));
			}
            $user_educations = array_merge($not_mentioned, $user_educations);
            foreach($user_educations As $edu_key => $user_education) {
                $new_conditions = $conditions;
                if ($edu_key == 0) {
                    $new_conditions['UserProfile.user_education_id'] = NULL;
                } else {
                    $new_conditions['UserProfile.user_education_id'] = $edu_key;
                }
                $education_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_education_data[$user_education] = number_format(($education_count/$total_users) *100, 2);
            }
            //# relationships
            $user_relationships = $this->User->UserProfile->UserRelationship->find('list', array(
                'conditions' => array(
                    'UserRelationship.is_active' => 1,
                ) ,
                'fields' => array(
                    'UserRelationship.id',
                    'UserRelationship.relationship',
                ) ,
                'recursive' => -1
            ));
            $user_relationships = array_merge($not_mentioned, $user_relationships);
            foreach($user_relationships As $rel_key => $user_relationship) {
                $new_conditions = $conditions;
                if ($rel_key == 0) {
                    $new_conditions['UserProfile.user_relationship_id'] = NULL;
                } else {
                    $new_conditions['UserProfile.user_relationship_id'] = $rel_key;
                }
                $relationship_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_relationship_data[$user_relationship] = number_format(($relationship_count/$total_users) *100, 2);
            }
            //# employments
            $user_employments = $this->User->UserProfile->UserEmployment->find('list', array(
                'conditions' => array(
                    'UserEmployment.is_active' => 1,
                ) ,
                'fields' => array(
                    'UserEmployment.id',
                    'UserEmployment.employment',
                ) ,
                'recursive' => -1
            ));
            $user_employments = array_merge($not_mentioned, $user_employments);
            foreach($user_employments As $emp_key => $user_employment) {
                $new_conditions = $conditions;
                if ($emp_key == 0) {
                    $new_conditions['UserProfile.user_employment_id'] = NULL;
                } else {
                    $new_conditions['UserProfile.user_employment_id'] = $emp_key;
                }
                $employment_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_employment_data[$user_employment] = number_format(($employment_count/$total_users) *100, 2);
            }
            //# income
            $user_income_ranges = $this->User->UserProfile->UserIncomeRange->find('list', array(
                'conditions' => array(
                    'UserIncomeRange.is_active' => 1,
                ) ,
                'fields' => array(
                    'UserIncomeRange.id',
                    'UserIncomeRange.income',
                ) ,
                'recursive' => -1
            ));
            $user_income_ranges = array_merge($not_mentioned, $user_income_ranges);
            foreach($user_income_ranges As $inc_key => $user_income_range) {
                $new_conditions = $conditions;
                if ($inc_key == 0) {
                    $new_conditions['UserProfile.user_income_range_id'] = NULL;
                } else {
                    $new_conditions['UserProfile.user_income_range_id'] = $inc_key;
                }
                $income_range_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_income_data[$user_income_range] = number_format(($income_range_count/$total_users) *100, 2);
            }
            //# genders
            $genders = $this->User->UserProfile->Gender->find('list');
            $genders = array_merge($not_mentioned, $genders);
            foreach($genders As $gen_key => $gender) {
                $new_conditions = $conditions;
                if ($gen_key == 0) {
                    $new_conditions['UserProfile.gender_id'] = NULL;
                } else {
                    $new_conditions['UserProfile.gender_id'] = $gen_key;
                }
                $gender_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_gender_data[$gender] = number_format(($gender_count/$total_users) *100, 2);
            }
            //# age calculation
            $user_ages = array(
                '1' => __l('18 - 34 Yrs') ,
                '2' => __l('35 - 44 Yrs') ,
                '3' => __l('45 - 54 Yrs') ,
                '4' => __l('55+ Yrs')
            );
            $user_ages = array_merge($not_mentioned, $user_ages);
            foreach($user_ages As $age_key => $user_ages) {
                $new_conditions = $conditions;
                if ($age_key == 1) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -18 years'));
                    $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -34 years'));
                } elseif ($age_key == 2) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -35 years'));
                    $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -44 years'));
                } elseif ($age_key == 3) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -45 years'));
                    $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -54 years'));
                } elseif ($age_key == 4) {
                     $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -55 years'));
                } elseif ($age_key == 0) {
                    $new_conditions['OR']['UserProfile.dob'] = NULL;
                    $new_conditions['UserProfile.dob < '] = date('Y-m-d', strtotime('now -18 years'));
                }
                $age_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_age_data[$user_ages] = number_format(($age_count/$total_users) *100, 2);
            }
        }
        $this->set('chart_pie_education_data', $chart_pie_education_data);
        $this->set('chart_pie_relationship_data', $chart_pie_relationship_data);
        $this->set('chart_pie_employment_data', $chart_pie_employment_data);
        $this->set('chart_pie_income_data', $chart_pie_income_data);
        $this->set('chart_pie_gender_data', $chart_pie_gender_data);
        $this->set('chart_pie_age_data', $chart_pie_age_data);
    }
    protected function _setLineData($select_var, $model_datas, $models, $model = '', $common_conditions = array())
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
	public function admin_chart_user_activities()
    {
		if (isset($this->request->params['named']['role_id'])) {
            $this->request->data['Chart']['role_id'] = $this->request->params['named']['role_id'];
        }
		if (isset($this->request->data['Chart']['is_ajax_load'])) {
            $this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
        }
        $this->initChart();
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $role_id = ConstUserTypes::User;
        $this->request->data['Chart']['role_id'] = $role_id;
        $this->request->data['Chart']['select_range_id'] = $select_var;
        // User Follow
        $model_datas = array();
        $model_datas['user-follow'] = array(
            'display' => __l('User Followers') ,
            'conditions' => array()
        );
        $_user_follow_data = $this->_setLineData($select_var, $model_datas, 'UserFollower', 'UserFollower');
        // Property Flags
        $model_datas = array();
        $this->loadModel('PropertyFlags.PropertyFlag');
        $model_datas['property_flags'] = array(
            'display' => __l('Property Flags') ,
            'conditions' => array()
        );
        $_property_flags_data = $this->_setLineData($select_var, $model_datas, 'PropertyFlag', 'PropertyFlag');
        // Property Favorites
		$this->loadModel('PropertyFavorites.PropertyFavorite');
        $model_datas = array();
        $model_datas['property_favorites'] = array(
            'display' => __l('Property Favorites') ,
            'conditions' => array()
        );
        $_property_favorites_data = $this->_setLineData($select_var, $model_datas, 'PropertyFavorite', 'PropertyFavorite');
        // Request Favorites
		if(isPluginEnabled('RequestFavorites')) { 
			$this->loadModel('RequestFavorites.RequestFavorite');
			$model_datas = array();
			$model_datas['request_favorite'] = array(
				'display' => __l('Request Favorites') ,
				'conditions' => array()
			);
			$_request_favorite_data = $this->_setLineData($select_var, $model_datas, 'RequestFavorite', 'RequestFavorite');
			$this->set('request_favorite_data', $_request_favorite_data);
		}
        // Request Flags
		if(isPluginEnabled('RequestFlags')) { 
			$this->loadModel('RequestFlags.RequestFlag');
			$model_datas = array();
			$model_datas['request_flag'] = array(
				'display' => __l('Request Flags') ,
				'conditions' => array()
			);
			$_request_flag_data = $this->_setLineData($select_var, $model_datas, 'RequestFlag', 'RequestFlag');
			$this->set('request_flag_data', $_request_flag_data);
		}
        $this->set('user_follow_data', $_user_follow_data);
        $this->set('property_flags_data', $_property_flags_data);
        $this->set('property_favorites_data', $_property_favorites_data);
		$this->set('selectRanges', $this->selectRanges);
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Insights');
    }
}
