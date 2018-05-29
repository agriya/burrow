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
class WdcalendarComponent extends Component
{
    var $controller;
    function updateDetailedCalendar($id, $property_id, $st, $et, $price, $status, $desc, $model, $color, $timezone, $fromdt, $todt)
    {
        $stime = explode(' ', $st);
        $sdate = explode('/', $stime[0]);
        $start = date('Y-m-d', mktime(0, 0, 0, $sdate[0], $sdate[1], $sdate[2]));
        //end date
        $etime = explode(' ', $et);
        $edate = explode('/', $etime[0]);
        $end = date('Y-m-d', mktime(0, 0, 0, $edate[0], $edate[1], $edate[2]));
        //from date
        $fdate = date('Y-m-d', strtotime($fromdt));
        // to date
        $tdate = date('Y-m-d', strtotime($todt));
        App::import('Model', 'Properties.PropertyUser');
        $this->PropertyUser = new PropertyUser();
        $propertyUserCount = $this->PropertyUser->find('count', array(
            'conditions' => array(
                'PropertyUser.property_id' => $property_id,
                'PropertyUser.checkin <= ' => $tdate,
                'PropertyUser.checkout >= ' => $fdate,
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Confirmed,
                    ConstPropertyUserStatus::Arrived,
                    ConstPropertyUserStatus::WaitingforReview,
                    ConstPropertyUserStatus::PaymentCleared,
                    ConstPropertyUserStatus::Completed,
                )
            ) ,
            'recursive' => -1
        ));
        if (empty($propertyUserCount)) {
            if ($model == 'CustomPricePerNight' || $model == 'CustomPricePerWeek' || $model == 'CustomPricePerMonth') {
                App::import('Model', 'Properties.' . $model);
            } else {
                App::import('Model', $model);
            }
            $this->Model = new $model();
            $records = array();
            if ($model != 'PropertyUser') {
                $records = $this->Model->find('all', array(
                    'conditions' => array(
                        $model . '.start_date <=' => $tdate,
                        $model . '.end_date >=' => $fdate,
                        $model . '.property_id' => $property_id,
                    ) ,
                    'recursive' => -1
                ));
            }
            $ret = array();
            if (!empty($records)) {
				$updated_date_arr = array();
				$fromDateTS = strtotime($fdate);
				$toDateTS = strtotime($tdate);
                foreach($records as $record) {
                    $date_before_select = $date_after_select = $date_between_select = $data = array();
                    $startDateTS = strtotime($record[$model]['start_date']);
                    $endDateTS = strtotime($record[$model]['end_date']);
                    for ($currentDateTS = $startDateTS; $currentDateTS <= $endDateTS; $currentDateTS+= (60*60*24)) {
                        if ($currentDateTS < $fromDateTS) {
                            $date_before_select[] = date('Y-m-d', $currentDateTS);
                        } elseif ($currentDateTS > $toDateTS) {
                            $date_after_select[] = date('Y-m-d', $currentDateTS);
                        } else {
                            $date_between_select[] = date('Y-m-d', $currentDateTS);
                        }
						$updated_date_arr[] = date('Y-m-d', $currentDateTS);
                    }
                    $cnt = 0;
                    if (!empty($date_before_select)) {
                        $this->Model->create();
                        $cnt = count($date_before_select) -1;
                        $data[$model]['property_id'] = $property_id;
                        $data[$model]['price'] = $record[$model]['price'];
                        $data[$model]['start_date'] = $date_before_select[0];
                        $data[$model]['end_date'] = $date_before_select[$cnt];
                        $data[$model]['is_available'] = $record[$model]['is_available'];
                        $this->Model->save($data);
                    }
                    if (!empty($date_between_select)) {
                        $this->Model->create();
                        $cnt = count($date_between_select) -1;
                        $data[$model]['property_id'] = $property_id;
                        $data[$model]['price'] = $price;
                        $data[$model]['start_date'] = $date_between_select[0];
                        $data[$model]['end_date'] = $date_between_select[$cnt];
                        $data[$model]['is_available'] = $status;
                        $this->Model->save($data);
                    }
                    if (!empty($date_after_select)) {
                        $this->Model->create();
                        $cnt = count($date_after_select) -1;
                        $data[$model]['property_id'] = $property_id;
                        $data[$model]['price'] = $record[$model]['price'];
                        $data[$model]['start_date'] = $date_after_select[0];
                        $data[$model]['end_date'] = $date_after_select[$cnt];
                        $data[$model]['is_available'] = $record[$model]['is_available'];
                        $this->Model->save($data);
                    }
                    $this->Model->delete($record[$model]['id']);
                }
				$i = 0;
				$missed_arr = 'before_missed_date';
				for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS+= (60*60*24)) {
					$i++;
					$current_date = date('Y-m-d', $currentDateTS);
					if (!in_array($current_date, $updated_date_arr)) {
						if ($i == 1) {
							${$missed_arr}[0] = date('Y-m-d', $currentDateTS);
							${$missed_arr}[1] = date('Y-m-d', $currentDateTS);
						} else {
							${$missed_arr}[1] = date('Y-m-d', $currentDateTS);
						}
					} else {
						$missed_arr = 'after_missed_date';
						$i = 0;
					}
				}
				if (!empty($before_missed_date)) {
					$data = array();
					$data[$model]['property_id'] = $property_id;
					$data[$model]['price'] = $price;
					$data[$model]['start_date'] = $before_missed_date[0];
					$data[$model]['end_date'] = $before_missed_date[1];
					$data[$model]['is_available'] = $status;
					$this->Model->create();
					$this->Model->save($data);
				}
				if (!empty($after_missed_date)) {
					$data = array();
					$data[$model]['property_id'] = $property_id;
					$data[$model]['price'] = $price;
					$data[$model]['start_date'] = $after_missed_date[0];
					$data[$model]['end_date'] = $after_missed_date[1];
					$data[$model]['is_available'] = $status;
					$this->Model->create();
					$this->Model->save($data);
				}
                $ret['IsSuccess'] = true;
                $ret['Msg'] = 'Updated successfully';
            } else {
                unset($this->Model->validate);
                if ($model == 'PropertyUser') {
                    $this->PropertyUser->updateStatus($id, $status);
                } else {
                    $data[$model]['property_id'] = $property_id;
                    $data[$model]['price'] = $price;
                    $data[$model]['start_date'] = $fdate;
                    $data[$model]['end_date'] = $tdate;
                    $data[$model]['is_available'] = $status;
                    if (!$this->Model->save($data)) {
                        return $this->Model->validationErrors;
                    }
                }
                $ret['IsSuccess'] = true;
                $ret['Msg'] = 'Updated successfully';
            }
        } else {
            $ret['IsSuccess'] = false;
            $ret['Msg'] = 'Updated failed';
        }
        return $ret;
    }
    function listCalendar($sd, $ed, $type = 'host', $view = 'month', $id = null)
    {
        App::import('Model', 'Properties.Property');
        $this->Property = new Property();
        $ret = array();
        $ret['events'] = array();
        $ret['weeks'] = array();
        $ret['property'] = array();
        $ret['monthly'] = array();
        $ret['issort'] = true;
        $ret['start'] = $this->php2JsTime($sd);
        $ret['end'] = $this->php2JsTime($ed);
        $ret['currency_symbol'] = $GLOBALS['currencies'][Configure::read('site.currency_id') ]['Currency']['symbol'];
        $ret['error'] = null;
        try {
            $start = date('Y-m-d', $sd);
            $end = date('Y-m-d', $ed);
            $smonth = date('m', $sd);
            if ($type == 'host') {
                if ($view == 'week') {
                    $week_start = $start;
                    $wtime = explode('-', $start);
                    $smonth = date('m', mktime(0, 0, 0, $wtime[1], 1, $wtime[0]));
                    $start = date('Y-m-d', mktime(0, 0, 0, $wtime[1], 1, $wtime[0]));
                    $month_start = date('Y-m-d', mktime(0, 0, 0, $wtime[1], $wtime[2], $wtime[0]));
                } elseif ($view == 'day') {
                    $day_start = $start;
                    $dtime = explode('-', $start);
                    $smonth = date('m', mktime(0, 0, 0, $dtime[1], 1, $dtime[0]));
                    $start = date('Y-m-d', mktime(0, 0, 0, $dtime[1], 1, $dtime[0]));
                    $month_start = date('Y-m-d', mktime(0, 0, 0, $dtime[1], $dtime[2], $dtime[0]));
                } else {
                    //get time stamp
                    $indate = $start;
                    list($year, $month, $day) = explode('-', $indate);
                    $timestamp = mktime(0, 0, 0, $month, $day, $year);
                    if (Configure::read('property.weekstartson') == 'Monday') {
                        if (date('w', strtotime($start)) == 0) {
                            // quick fix for sunday
                            $cday = 6;
                        } else {
                            $cday = date('w', strtotime($start)) -1;
                        }
                    } elseif (Configure::read('property.weekstartson') == 'Saturday') {
                        $cday = (date('w', strtotime($start)) +1) %7;
                    } else {
                        $cday = date('w', strtotime($start));
                    }
                    $time = explode('-', $start);
                    //calendar start the of the week
                    $start = date('Y-m-d', mktime(0, 0, 0, $time[1], $time[2]-$cday, $time[0]));
                    $month_start = date('Y-m-d', mktime(0, 0, 0, $time[1], $time[2], $time[0]));
                }
            }
            $emonth = date('m', $ed);
            $conditions = array();
            $conditions['AND']['PropertyUser.property_user_status_id'] = array(
                ConstPropertyUserStatus::WaitingforAcceptance,
                ConstPropertyUserStatus::Confirmed,
                ConstPropertyUserStatus::Arrived,
                ConstPropertyUserStatus::PaymentCleared,
                ConstPropertyUserStatus::PaymentPending,
            );
            if (!empty($id)) {
                $property_conditions['Property.id'] = explode(',', $id);
            } else {
                $view = 'full';
                $property_conditions['Property.user_id'] = !empty($_SESSION['Auth']['User']['id']) ? $_SESSION['Auth']['User']['id'] : '';
            }
            $phpTime = strtotime($end);
            $new_end = date('Y-m-d', strtotime('next saturday', mktime(0, 0, -1, date('m', $phpTime) +1, 1, date('Y', $phpTime))));
            $properties = $this->Property->find('all', array(
                'conditions' => $property_conditions,
                'fields' => array(
                    'Property.id',
                    'Property.title',
                    'Property.price_per_night',
                    'Property.price_per_week',
                    'Property.price_per_month',
                ) ,
                'contain' => array(
                    'PropertyUser' => array(
                        'conditions' => array(
                            $conditions,
                            'PropertyUser.checkin <=' => $new_end,
                            'PropertyUser.checkout >=' => $start,
                        ) ,
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.username',
                            ) ,
                        ) ,
                    ) ,
                    'CustomPricePerNight' => array(
                        'conditions' => array(
                            'CustomPricePerNight.start_date <=' => $new_end,
                            'CustomPricePerNight.end_date >=' => $start,
                        ) ,
                    ) ,
                    'CustomPricePerWeek' => array(
                        'conditions' => array(
                            'CustomPricePerWeek.start_date <=' => $new_end,
                            'CustomPricePerWeek.end_date >=' => $start,
                        ) ,
                        'order' => array(
                            'CustomPricePerWeek.start_date' => 'ASC'
                        )
                    ) ,
                    'CustomPricePerMonth' => array(
                        'conditions' => array(
                            'CustomPricePerMonth.start_date <=' => $end,
                            'CustomPricePerMonth.end_date >=' => $month_start,
                        ) ,
                    ) ,
                ) ,
                'recursive' => 2,
            ));
            if (!empty($properties)) {
                foreach($properties as $property) {
                    $pro_list_no = !empty($_SESSION['Property_Calender'][$property['Property']['id']]) ? 'P' . $_SESSION['Property_Calender'][$property['Property']['id']] . ': ' : '';
                    $ret['property'][] = array(
                        'id' => $property['Property']['id'],
                        'title' => $pro_list_no . ' ' .  htmlspecialchars($property['Property']['title'], ENT_QUOTES),
                        'price' => $property['Property']['price_per_night']
                    );
                    $reserved = array();
                    $not_available = array();
                    $weekbooked = array();
                    $boundary = array();
                    $booked = array();
                    $booked_status_data = array();
                    $weekly = array();
                    // Booked information [case1]
                    if (!empty($property['PropertyUser'])) {
                        foreach($property['PropertyUser'] as $propertyUser) {
                            if ((!empty($propertyUser['user_id']) && $propertyUser['property_user_status_id'] != 12) || ($propertyUser['property_user_status_id'] == ConstPropertyUserStatus::PaymentPending && !empty($propertyUser['is_negotiation_requested']) && $propertyUser['is_negotiation_requested'] == ConstNegotiationStatus::NegotiationRequested)) {
                                $p_list_no = !empty($_SESSION['Property_Calender'][$propertyUser['property_id']]) ? 'P' . $_SESSION['Property_Calender'][$propertyUser['property_id']] . ': ' : '';
                                $booking_caption = '';
                                $color = '#4CB050';
                                $time = explode('-', $propertyUser['checkin']);
                                $time1 = explode('-', getCheckoutDate($propertyUser['checkout']));
                                //for guest
                                if ($type == 'guest') {
                                    $start_split = explode('-', $start);
                                    $end_split = explode('-', $end);
                                    $startlimit = date('m', mktime(0, 0, 0, $start_split[1], $start_split[2], $start_split[0]));
                                    $endlimit = date('m', mktime(0, 0, 0, $end_split[1], $end_split[2], $end_split[0]));
                                    $checkin_limit = date('m', mktime(0, 0, 0, $time[1], $time[2], $time[0]));
                                    $checkout_limit = date('m', mktime(0, 0, 0, $time[1], $time[2], $time[0]));
                                    if ($checkin_limit < $startlimit) {
                                        $propertyUser['checkin'] = date('Y-m-d', mktime(0, 0, 0, $startlimit, 1, $time[0]));
                                    }
                                }
                                $time = explode('-', $propertyUser['checkin']);
                                $days = getCheckinCheckoutDiff($propertyUser['checkin'], getCheckoutDate($propertyUser['checkout']));
                                for ($j = 0; $j <= $days; $j++) {
                                    $reserved[] = date('Y-m-d', mktime(0, 0, 0, $time[1], $time[2]+$j, $time[0]));
                                    $booked[] = date('Y-m-d', mktime(0, 0, 0, $time[1], $time[2]+$j, $time[0]));
                                    $te_current_date = date('Y-m-d', mktime(0, 0, 0, $time[1], $time[2]+$j, $time[0]));
                                    switch ($propertyUser['property_user_status_id']) {
                                        case 1:
                                            $booked_status_data[$te_current_date] = 'WaitingforAcceptance';
                                            break;

                                        case 2:
                                            $booked_status_data[$te_current_date] = 'Confirmed';
                                            break;

                                        case 3:
                                            $booked_status_data[$te_current_date] = 'Rejected';
                                            break;
                                    }
                                }
                                $username = '';
                                if ($propertyUser['property_user_status_id'] == ConstPropertyUserStatus::Confirmed || $propertyUser['property_user_status_id'] == ConstPropertyUserStatus::Arrived || $propertyUser['property_user_status_id'] == ConstPropertyUserStatus::PaymentCleared || $propertyUser['property_user_status_id'] == ConstPropertyUserStatus::WaitingforReview || $propertyUser['property_user_status_id'] == ConstPropertyUserStatus::Completed) {
                                    $color = '#8C65D8';
                                    $booking_caption = 'Booked by ';
                                    $username = (!empty($propertyUser['User']['username'])) ? 'Booked by ' . ucfirst($propertyUser['User']['username']) : 'Booked, ';
                                    $username.= ' at price ' . $propertyUser['price'];
                                } else if ($propertyUser['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance) {
                                    $color = '#F1A640';
                                    $booking_caption = 'Book request by ';
                                    $username = (!empty($propertyUser['User']['username'])) ? 'Book request by ' . ucfirst($propertyUser['User']['username']) : 'Book request, ';
                                    $username.= ' at price ' . $propertyUser['price'];
                                } else if ($propertyUser['property_user_status_id'] == ConstPropertyUserStatus::Rejected) {
                                    $color = '#B372B2';
                                    $booking_caption = 'Rejected Property';
                                    $username = (!empty($propertyUser['User']['username'])) ? 'Booking rejected ' . ucfirst($propertyUser['User']['username']) : 'Book reject, ';
                                    $username.= ' at price ' . $propertyUser['price'];
                                } else if ($propertyUser['property_user_status_id'] == ConstPropertyUserStatus::PaymentPending) {
                                    $color = '#B372B2';
                                    $booking_caption = 'Negotiation Request';
                                    $username = (!empty($propertyUser['User']['username'])) ? 'Negotiation request from ' . ucfirst($propertyUser['User']['username']) : 'Negotiation request';
                                    $propertyUser['property_user_status_id'] = ConstPropertyUserStatus::RequestNegotiation;
                                }
                                if (strtotime($propertyUser['checkin']) < time()) {
                                    $propertyUser['checkin'] = date('Y-m-d');
                                }
                                $ret['events'][] = array(
                                    $propertyUser['id'],
                                    $username,
                                    $this->php2JsTime($this->mySql2PhpTime($propertyUser['checkin'])) ,
                                    $this->php2JsTime($this->mySql2PhpTime(getCheckoutDate($propertyUser['checkout']))) ,
                                    1,
                                    0,
                                    0,
                                    $color,
                                    1,
                                    $propertyUser['property_user_status_id'],
                                    $propertyUser['property_id'],
                                    'booked',
                                    'PropertyUser',
                                    $propertyUser['price'],
                                    $p_list_no,
                                    htmlspecialchars($property['Property']['title'], ENT_QUOTES)
                                );
                            }
                        }
                    }
                    //special price [case2]
                    $caption = '';
                    if (!empty($property['CustomPricePerNight'])) {
                        foreach($property['CustomPricePerNight'] as $customPricePerNight) {
                            $p_list_no = !empty($_SESSION['Property_Calender'][$customPricePerNight['property_id']]) ? 'P' . $_SESSION['Property_Calender'][$customPricePerNight['property_id']] . ': ' : '';
                            $time = explode('-', $customPricePerNight['start_date']);
                            $time1 = explode('-', $customPricePerNight['end_date']);
                            $days = (strtotime($customPricePerNight['end_date']) -strtotime($customPricePerNight['start_date'])) /(60*60*24);
                            for ($j = 0; $j <= $days; $j++) {
                                $reserved[] = date('Y-m-d', mktime(0, 0, 0, $time[1], $time[2]+$j, $time[0]));
                                if ($customPricePerNight['is_available'] == 0) {
                                    $not_available[] = date('Y-m-d', mktime(0, 0, 0, $time[1], $time[2]+$j, $time[0]));
                                }
                            }
                            if ($customPricePerNight['is_available'] == 1) { //available
                                $color = '#4CB050';
                                $caption = $customPricePerNight['price'];
                            } else { //not available
                                $color = '#D96566';
                                $caption = 'Not available';
                            }
                            $status = 0;
                            if ($customPricePerNight['is_available'] == 1) {
                                $status = 99; // available calenda status id only

                            }
                            if (strtotime($customPricePerNight['start_date']) < time()) {
                                $customPricePerNight['start_date'] = date('Y-m-d');
                            } else {
                                if (empty($customPricePerNight['is_available'])) {
									$status = 0; // not available calenda status id only
                                }
                            }
                            $ret['events'][] = array(
                                $customPricePerNight['id'],
                                $caption,
                                $this->php2JsTime($this->mySql2PhpTime($customPricePerNight['start_date'])) ,
                                $this->php2JsTime($this->mySql2PhpTime($customPricePerNight['end_date'])) ,
                                1,
                                0,
                                0,
                                $color,
                                1,
                                $status,
                                $customPricePerNight['property_id'],
                                'available',
                                'CustomPricePerNight',
                                $customPricePerNight['price'],
                                $p_list_no,
                               htmlspecialchars($property['Property']['title'], ENT_QUOTES)
                            );
                        }
                    }
                    //default price generation [case3]
                    $time = explode('-', $start);
                    $daily_start = $time[2];
                    $p_list_no = !empty($_SESSION['Property_Calender'][$property['Property']['id']]) ? 'P' . $_SESSION['Property_Calender'][$property['Property']['id']] . ': ' : '';
                    if ($view == 'day') {
                        unset($ret['events']);
                        $start = $day_start;
                        if (!in_array($start, $booked)) {
                            if (strtotime($start) < time()) {
                                $start = date('Y-m-d');
                            }
                            $ret['events'][] = array(
                                '',
                                $property['Property']['price_per_night'],
                                $this->php2JsTime($this->mySql2PhpTime($start)) ,
                                $this->php2JsTime($this->mySql2PhpTime($end)) ,
                                1,
                                0,
                                0,
                                '#4CB050',
                                1,
                                1, //available
                                $property['Property']['id'],
                                'available',
                                'CustomPricePerNight',
                                $property['Property']['price_per_night'],
                                $p_list_no,
                                htmlspecialchars($property['Property']['title'], ENT_QUOTES)
                            );
                        } else {
                            if (strtotime($start) < time()) {
                                $start = date('Y-m-d');
                            }
                            $ret['events'][] = array(
                                '',
                                'Booked',
                                $this->php2JsTime($this->mySql2PhpTime($start)) ,
                                $this->php2JsTime($this->mySql2PhpTime($end)) ,
                                1,
                                0,
                                0,
                                '#F8B7A0',
                                1,
                                '',
                                2,
                                'booked',
                                'PropertyUser',
                                $property['Property']['price_per_night'],
                                $p_list_no,
                                htmlspecialchars($property['Property']['title'], ENT_QUOTES)
                            );
                        }
                    } else {
                        $days = (strtotime($end) -strtotime($start)) /(60*60*24);
                        if ($type == 'guest') {
                            $limit = date('t', $sd);
                        } else {
                            $limit = 41;
                            $ms_time = explode('-', $month_start);
                            $totl_days_in_month = date("t", mktime(0, 0, 0, $ms_time[1], 1, $ms_time[0]));
                            $week_day = date("N", mktime(0, 0, 0, $ms_time[1], 1, $ms_time[0]));
                            $totl_weeks_in_month = ceil(($days+$week_day) /7);
                            if ($totl_weeks_in_month == 6) {
                                $limit = 34+7;
                            }
                        }
                        for ($i = 0; $i <= $limit; $i++) {
                            $current_date = date('Y-m-d', mktime(0, 0, 0, $time[1], $time[2]+$i, $time[0]));
                            if ($current_date >= date('Y-m-d')) {
                                if (!in_array($current_date, $reserved)) {
                                    // $current_date;
                                    if (empty($bstart_date)) {
                                        $bstart_date = $current_date;
                                    }
                                    if ($i == $limit) {
                                        $btime = explode('-', $current_date);
                                        $bend_date = date('Y-m-d', mktime(0, 0, 0, $btime[1], $btime[2], $btime[0]));
                                        $boundary[] = array(
                                            'start_date' => $bstart_date,
                                            'end_date' => $bend_date
                                        );
                                        $bstart_date = '';
                                        $bend_date = '';
                                    }
                                } else {
                                    if (!empty($bstart_date)) {
                                        $btime = explode('-', $current_date);
                                        $bend_date = date('Y-m-d', mktime(0, 0, 0, $btime[1], $btime[2]-1, $btime[0]));
                                        $boundary[] = array(
                                            'start_date' => $bstart_date,
                                            'end_date' => $bend_date
                                        );
                                        $bstart_date = '';
                                        $bend_date = '';
                                    }
                                }
                            }
                        }
                        //default price merging with array
                        foreach($boundary as $bound) {
                            if (strtotime($bound['start_date']) < time()) {
                                //	$bound['start_date'] = date('Y-m-d');
                                //$default_color='#D96566';

                            }
                            $default_color = '#4CB050';
                            $ret['events'][] = array(
                                0,
                                $property['Property']['price_per_night'],
                                $this->php2JsTime($this->mySql2PhpTime($bound['start_date'])) ,
                                $this->php2JsTime($this->mySql2PhpTime($bound['end_date'])) ,
                                1,
                                0,
                                0,
                                $default_color,
                                1,
                                99, //available status id is 11 temprorarly
                                $property['Property']['id'],
                                'available',
                                'CustomPricePerNight',
                                $property['Property']['price_per_night'],
                                $p_list_no,
                               htmlspecialchars($property['Property']['title'], ENT_QUOTES)
                            );
                        }
                        //past date
                        for ($i = 0; $i <= $limit; $i++) {
                            $current_date = date('Y-m-d', mktime(0, 0, 0, $time[1], $time[2]+$i, $time[0]));
                            if ($current_date < date('Y-m-d')) {
                                $default_color = '#D96566';
                                $ret['events'][] = array(
                                    0,
                                    $property['Property']['price_per_night'],
                                    $this->php2JsTime($this->mySql2PhpTime($current_date)) ,
                                    $this->php2JsTime($this->mySql2PhpTime($current_date)) ,
                                    1,
                                    0,
                                    0,
                                    $default_color,
                                    1,
                                    99, //available status id is 11 temprorarly
                                    $property['Property']['id'],
                                    'Not available',
                                    'CustomPricePerNight',
                                    $property['Property']['price_per_night'],
                                    $p_list_no,
                                    htmlspecialchars($property['Property']['title'], ENT_QUOTES)
                                );
                            }
                        }
                    }
                    $weekly_data = array();
                    $customPricePerWeek_data = array();
                    //weekly array generation
                    foreach($property['CustomPricePerWeek'] as $customPricePerWeek) {
                        $time = explode('-', $customPricePerWeek['start_date']);
                        $weekly_data[$customPricePerWeek['start_date']]['price'] = $customPricePerWeek['price'];
                        $weekly_data[$customPricePerWeek['start_date']]['id'] = $customPricePerWeek['id'];
                        $days = (strtotime($customPricePerWeek['end_date']) -strtotime($customPricePerWeek['start_date'])) /(60*60*24);
                        for ($j = 0; $j <= $days; $j++) {
                            $weekly[] = date('Y-m-d', mktime(0, 0, 0, $time[1], $time[2]+$j, $time[0]));
                        }
                    }
                    //get time stamp
                    $indate = $start;
                    list($year, $month, $day) = explode('-', $indate);
                    $timestamp = mktime(0, 0, 0, $month, $day, $year);
                    $time = explode('-', $start);
                    $wstart = date('Y-m-d', mktime(0, 0, 0, $time[1], $time[2], $time[0]));
                    if ($view == 'week') {
                        $wstart = $week_start;
                        //unset the whole array
                        unset($ret['events']);
                        $wtime = explode('-', $wstart);
                        $wend = date('Y-m-d', mktime(0, 0, 0, $wtime[1], $wtime[2]+6, $wtime[0]));
                        if (empty($property['Property']['price_per_week'])) {
                            $default_weekly_price = $property['Property']['price_per_night']*7;
                        } else {
                            $default_weekly_price = $property['Property']['price_per_week'];
                        }
                        $booked_status = 0;
                        //print_r($ret['events']);
                        if (in_array($wstart, $weekly) &in_array($wend, $weekly)) // weekly special price is there
                        {
                            $wtime = explode('-', $wstart);
                            for ($k = 0; $k <= 6; $k++) {
                                $wcurrent = date('Y-m-d', mktime(0, 0, 0, $wtime[1], $wtime[2]+$k, $wtime[0]));
                                if (in_array($wcurrent, $booked)) {
                                    $booked_status = 1;
                                }
                            }
                            if ($booked_status == 1) {
                                if (strtotime($wstart) < time()) {
                                    $wstart = date('Y-m-d');
                                }
                                $ret['events'][] = array(
                                    '',
                                    'Booked',
                                    $this->php2JsTime($this->mySql2PhpTime($wstart)) ,
                                    $this->php2JsTime($this->mySql2PhpTime($wend)) ,
                                    1,
                                    0,
                                    0,
                                    '#F8B7A0',
                                    1,
                                    '',
                                    '',
                                    'booked',
                                    'CustomPricePerWeek',
                                    $default_weekly_price,
                                    $p_list_no,
                                    htmlspecialchars($property['Property']['title'], ENT_QUOTES)
                                );
                            } else {
                                if (strtotime($wstart) < time()) {
                                    $wstart = date('Y-m-d');
                                }
                                $ret['events'][] = array(
                                    $weekly_data[$wstart]['id'],
                                    $weekly_data[$wstart]['price'],
                                    $this->php2JsTime($this->mySql2PhpTime($wstart)) ,
                                    $this->php2JsTime($this->mySql2PhpTime($wend)) ,
                                    1,
                                    0,
                                    0,
                                    '#4CB050',
                                    1,
                                    '',
                                    '',
                                    'Available',
                                    'CustomPricePerWeek',
                                    $weekly_data[$wstart]['price'],
                                    $p_list_no,
                                    '',
                                );
                            }
                        } else {
                            $wtime = explode('-', $wstart);
                            for ($k = 0; $k <= 6; $k++) {
                                $wcurrent = date('Y-m-d', mktime(0, 0, 0, $wtime[1], $wtime[2]+$k, $wtime[0]));
                                if (in_array($wcurrent, $booked)) {
                                    $booked_status = 1;
                                }
                            }
                            if ($booked_status == 1) {
                                if (strtotime($wstart) < time()) {
                                    $wstart = date('Y-m-d');
                                }
                                $ret['events'][] = array(
                                    '',
                                    'Booked',
                                    $this->php2JsTime($this->mySql2PhpTime($wstart)) ,
                                    $this->php2JsTime($this->mySql2PhpTime($wend)) ,
                                    1,
                                    0,
                                    0,
                                    '#F8B7A0',
                                    1,
                                    '',
                                    '',
                                    'booked',
                                    'CustomPricePerWeek',
                                    '',
                                    $p_list_no,
                                    ''
                                );
                            } else {
                                if (strtotime($wstart) < time()) {
                                    $wstart = date('Y-m-d');
                                }
                                $ret['events'][] = array(
                                    '',
                                    $default_weekly_price,
                                    $this->php2JsTime($this->mySql2PhpTime($wstart)) ,
                                    $this->php2JsTime($this->mySql2PhpTime($wend)) ,
                                    1,
                                    0,
                                    0,
                                    '#4CB050',
                                    1,
                                    '',
                                    '',
                                    'Available',
                                    'CustomPricePerWeek',
                                    '',
                                    $p_list_no,
                                    ''
                                );
                            }
                        }
                        $wstart = date('Y-m-d', mktime(0, 0, 0, $wtime[1], $wtime[2]+7, $wtime[0]));
                    } else {
                        //calendar start the of the week
                        for ($i = 0; $i <= 5; $i++) {
                            $jj = $i+1;
                            $wtime = explode('-', $wstart);
                            $wend = date('Y-m-d', mktime(0, 0, 0, $wtime[1], $wtime[2]+6, $wtime[0]));
                            if (empty($property['Property']['price_per_week'])) {
                                $default_weekly_price = $property['Property']['price_per_night']*7;
                            } else {
                                $default_weekly_price = $property['Property']['price_per_week'];
                            }
                            $booked_status = 0;
                            if (in_array($wstart, $weekly) &in_array($wend, $weekly)) // weekly special price is there
                            {
                                $wtime = explode('-', $wstart);
                                $booked_status = 1;
                                $count = 0;
                                for ($k = 0; $k <= 6; $k++) {
                                    $wcurrent = date('Y-m-d', mktime(0, 0, 0, $wtime[1], $wtime[2]+$k, $wtime[0]));
                                    //echo $booked_status_data[$wcurrent];
                                    if (!in_array($wcurrent, $booked) || (!empty($booked_status_data[$wcurrent]) && $booked_status_data[$wcurrent] != 'Confirmed')) {
                                        $booked_status = 0;
                                        $count++;
                                    }
                                }
                                //$not_available
                                //$booked_status = 1;
                                $past = 0;
                                for ($k = 0; $k <= 6; $k++) {
                                    $wcurrent = date('Y-m-d', mktime(0, 0, 0, $wtime[1], $wtime[2]+$k, $wtime[0]));
                                    if (in_array($wcurrent, $not_available) || (in_array($wcurrent, $booked) && !empty($booked_status_data[$wcurrent]) && $booked_status_data[$wcurrent] == 'Confirmed' && $count != 0)) {
                                        $booked_status = 2;
                                    }
                                }
                                if ($booked_status == 1) {
                                    $p_list_no = !empty($_SESSION['Property_Calender'][$property['Property']['id']]) ? 'P' . $_SESSION['Property_Calender'][$property['Property']['id']] . ': ' : '';
                                    $ret['weeks'][$i][] = array(
                                        '',
                                        'Booked',
                                        $this->php2JsTime($this->mySql2PhpTime($wstart)) ,
                                        $this->php2JsTime($this->mySql2PhpTime($wend)) ,
                                        1,
                                        0,
                                        0,
                                        '#8D66D9',
                                        0,
                                        99,
                                        $property['Property']['id'],
                                        'booked',
                                        'CustomPricePerWeek',
                                        $weekly_data[$wstart]['price'],
                                        $p_list_no,
                                        htmlspecialchars($property['Property']['title'], ENT_QUOTES),
                                        $property['Property']['id']
                                    );
                                } else if ($booked_status == 2) {
                                    $p_list_no = !empty($_SESSION['Property_Calender'][$property['Property']['id']]) ? 'P' . $_SESSION['Property_Calender'][$property['Property']['id']] . ': ' : '';
                                    $ret['weeks'][$i][] = array(
                                        '',
                                        $weekly_data[$wstart]['price'],
                                        $this->php2JsTime($this->mySql2PhpTime($wstart)) ,
                                        $this->php2JsTime($this->mySql2PhpTime($wend)) ,
                                        1,
                                        0,
                                        0,
                                        '#D96566',
                                        0,
                                        99,
                                        $property['Property']['id'],
                                        'Not Available',
                                        'CustomPricePerWeek',
                                        $weekly_data[$wstart]['price'],
                                        $p_list_no,
                                        htmlspecialchars($property['Property']['title'], ENT_QUOTES),
                                        $property['Property']['id']
                                    );
                                } else {
                                    // $ret['weekly'][] = '$' . $weekly_data[$wstart]; //sprical price
                                    // $ret['weekly_color'][] = 'color-green';
                                    $p_list_no = !empty($_SESSION['Property_Calender'][$property['Property']['id']]) ? 'P' . $_SESSION['Property_Calender'][$property['Property']['id']] . ': ' : '';
                                    $ret['weeks'][$i][] = array(
                                        $weekly_data[$wstart]['id'],
                                        $weekly_data[$wstart]['price'],
                                        $this->php2JsTime($this->mySql2PhpTime($wstart)) ,
                                        $this->php2JsTime($this->mySql2PhpTime($wend)) ,
                                        1,
                                        0,
                                        0,
                                        '#4CB050',
                                        1,
                                        99,
                                        $property['Property']['id'],
                                        'available',
                                        'CustomPricePerWeek',
                                        $weekly_data[$wstart]['price'],
                                        $p_list_no,
                                        htmlspecialchars($property['Property']['title'], ENT_QUOTES),
                                        $property['Property']['id']
                                    );
                                }
                            } else {
                                $wtime = explode('-', $wstart);
                                $booked_status = 1;
                                $count = 0;
                                $past = 0;
                                for ($k = 0; $k <= 6; $k++) {
                                    $wcurrent = date('Y-m-d', mktime(0, 0, 0, $wtime[1], $wtime[2]+$k, $wtime[0]));
                                    //echo $booked_status_data[$wcurrent];
                                    if (!in_array($wcurrent, $booked) || (!empty($booked_status_data[$wcurrent]) && $booked_status_data[$wcurrent] != 'Confirmed')) {
                                        $booked_status = 0;
                                        $count++;
                                    }
                                    if ($wcurrent < date('Y-m-d')) {
                                        $past = 1;
                                    }
                                }
                                //$not_available
                                //$booked_status = 1;
                                for ($k = 0; $k <= 6; $k++) {
                                    $wcurrent = date('Y-m-d', mktime(0, 0, 0, $wtime[1], $wtime[2]+$k, $wtime[0]));
                                    if (in_array($wcurrent, $not_available) || (in_array($wcurrent, $booked) && !(empty($booked_status_data[$wcurrent])) && $booked_status_data[$wcurrent] == 'Confirmed' && $count != 0)) {
                                        $booked_status = 2;
                                    }
                                }
                                if ($booked_status == 1) {
                                    $p_list_no = !empty($_SESSION['Property_Calender'][$property['Property']['id']]) ? 'P' . $_SESSION['Property_Calender'][$property['Property']['id']] . ': ' : '';
                                    $ret['weeks'][$i][] = array(
                                        '',
                                        'Booked',
                                        $this->php2JsTime($this->mySql2PhpTime($wstart)) ,
                                        $this->php2JsTime($this->mySql2PhpTime($wend)) ,
                                        1,
                                        0,
                                        0,
                                        '#8D66D9',
                                        0,
                                        99,
                                        $property['Property']['id'],
                                        'booked',
                                        'CustomPricePerWeek',
                                        $default_weekly_price,
                                        $p_list_no,
                                        htmlspecialchars($property['Property']['title'], ENT_QUOTES),
                                        $property['Property']['id']
                                    );
                                } else if ($booked_status == 2 || $past == 1) {
                                    $p_list_no = !empty($_SESSION['Property_Calender'][$property['Property']['id']]) ? 'P' . $_SESSION['Property_Calender'][$property['Property']['id']] . ': ' : '';
                                    $ret['weeks'][$i][] = array(
                                        '',
                                        'Not Available',
                                        $this->php2JsTime($this->mySql2PhpTime($wstart)) ,
                                        $this->php2JsTime($this->mySql2PhpTime($wend)) ,
                                        1,
                                        0,
                                        0,
                                        '#D96566',
                                        0,
                                        99,
                                        $property['Property']['id'],
                                        'Not Available',
                                        'CustomPricePerWeek',
                                        $default_weekly_price,
                                        $p_list_no,
                                        htmlspecialchars($property['Property']['title'], ENT_QUOTES),
                                        $property['Property']['id']
                                    );
                                } else {
                                    // $ret['weekly'][] = '' . $default_weekly_price;
                                    //  $ret['weekly_color'][] = 'color-green';
                                    $p_list_no = !empty($_SESSION['Property_Calender'][$property['Property']['id']]) ? 'P' . $_SESSION['Property_Calender'][$property['Property']['id']] . ': ' : '';
                                    $ret['weeks'][$i][] = array(
                                        '',
                                        $default_weekly_price,
                                        $this->php2JsTime($this->mySql2PhpTime($wstart)) ,
                                        $this->php2JsTime($this->mySql2PhpTime($wend)) ,
                                        1,
                                        0,
                                        0,
                                        '#4CB050',
                                        1,
                                        99,
                                        $property['Property']['id'],
                                        'available',
                                        'CustomPricePerWeek',
                                        $default_weekly_price,
                                        $p_list_no,
                                        htmlspecialchars($property['Property']['title'], ENT_QUOTES),
                                        $property['Property']['id']
                                    );
                                }
                            }
                            $wstart = date('Y-m-d', mktime(0, 0, 0, $wtime[1], $wtime[2]+7, $wtime[0]));
                        }
                    }
                    $default_monthly_price = '';
                    $month_available = 1;
                    if (isset($property['CustomPricePerMonth']) && !empty($property['CustomPricePerMonth'])) {
                        foreach($property['CustomPricePerMonth'] as $customPricePerMonth) {
                            $default_monthly_price = $customPricePerMonth['price'];
                            $month_available = 1;
                        }
                    } else {
                        //monthly pricing
                        if (empty($property['Property']['price_per_month'])) {
                            $default_monthly_price = $property['Property']['price_per_night']*30;
                        } else {
                            $default_monthly_price = $property['Property']['price_per_month'];
                        }
                    }
                    if (!empty($property['PropertyUser'])) {
                        $ret['monthly_color'] = 'color-red';
                    } else {
                        $ret['monthly_color'] = 'color-green';
                    }
                    $customPricePerMonth_id = !empty($property['CustomPricePerMonth'][0]['id']) ? $property['CustomPricePerMonth'][0]['id'] : 0;
                    $pro_list_no = !empty($_SESSION['Property_Calender'][$property['Property']['id']]) ? 'P' . $_SESSION['Property_Calender'][$property['Property']['id']] . ': ' : '';
                    // property_id, CustomPricePerMonth_id,
                    if (empty($property['PropertyUser'])) {
                        $ret['monthly'][] = array(
                            $property['Property']['id'],
                            $pro_list_no . ' ' . htmlspecialchars($property['Property']['title'], ENT_QUOTES),
                            $customPricePerMonth_id,
                            $ret['start'],
                            $ret['end'],
                            $default_monthly_price,
                            $month_available
                        );
                    }
                    //get time stamp
                    $time = explode('-', $end);
                    $ret['monthly_name'] = date('F', mktime(0, 0, 0, $time[1], $time[2], $time[0]));
                }
            }
        }
        catch(Exception $e) {
            $ret['error'] = $e->getMessage();
        }
        $time = explode('-', $end);
        $calender_month = date('Y-m-d', mktime(0, 0, 0, $time[1], 1, $time[0]));
        $current_month = date('Y-m-d', mktime(0, 0, 0, date('m') , 1, date('Y')));
        if ($calender_month <= $current_month) $ret['monthly'] = array();
        $ret['IsSuccess'] = true;
        $ret['Msg'] = 'Successfully';
        return $ret;
    }
    function addCalendar($st, $et, $price, $ade, $id, $is_available, $fromdt, $todt)
    {
        $stime = explode(' ', $st);
        $sdate = explode('/', $stime[0]);
        $start = date('Y-m-d', mktime(0, 0, 0, $sdate[0], $sdate[1], $sdate[2]));
        //end date
        $etime = explode(' ', $et);
        $edate = explode('/', $etime[0]);
        $end = date('Y-m-d', mktime(0, 0, 0, $edate[0], $edate[1], $edate[2]));
        //from date
        $fdate = date('Y-m-d', strtotime($fromdt));
        // to date
        $tdate = date('Y-m-d', strtotime($todt));
        App::import('Model', 'Properties.PropertyUser');
        $this->PropertyUser = new PropertyUser();
        $propertyUserCount = $this->PropertyUser->find('count', array(
            'conditions' => array(
                'PropertyUser.property_id' => $id,
                'PropertyUser.checkin <= ' => $tdate,
                'PropertyUser.checkout >= ' => $fdate,
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Confirmed,
                    ConstPropertyUserStatus::Arrived,
                    ConstPropertyUserStatus::WaitingforReview,
                    ConstPropertyUserStatus::PaymentCleared,
                    ConstPropertyUserStatus::Completed,
                )
            ) ,
            'recursive' => -1
        ));
        if (empty($propertyUserCount)) {
            App::import('Model', 'Properties.CustomPricePerNight');
            $this->CustomPricePerNight = new CustomPricePerNight();
            $records = $this->CustomPricePerNight->find('all', array(
                'conditions' => array(
                    'CustomPricePerNight.start_date <=' => $tdate,
                    'CustomPricePerNight.end_date >=' => $fdate,
                    'CustomPricePerNight.property_id' => $id,
                ) ,
                'recursive' => -1
            ));
            $ret = array();
            if (empty($records)) {
                $data['start_date'] = $fdate;
                $data['end_date'] = $tdate;
                $data['property_id'] = $id;
                $data['price'] = $price;
                $data['is_available'] = $is_available;
                $this->CustomPricePerNight->create();
                $this->CustomPricePerNight->save($data);
                $ret['IsSuccess'] = true;
                $ret['Msg'] = 'add success';
            } else {
				$updated_date_arr = array();
				$fromDateTS = strtotime($fdate);
				$toDateTS = strtotime($tdate);
                foreach($records as $record) {
                    $date_before_select = $date_after_select = $date_between_select = $data = array();
                    $startDateTS = strtotime($record['CustomPricePerNight']['start_date']);
                    $endDateTS = strtotime($record['CustomPricePerNight']['end_date']);
                    for ($currentDateTS = $startDateTS; $currentDateTS <= $endDateTS; $currentDateTS+= (60*60*24)) {
                        if ($currentDateTS < $fromDateTS) {
                            $date_before_select[] = date('Y-m-d', $currentDateTS);
                        } elseif ($currentDateTS > $toDateTS) {
                            $date_after_select[] = date('Y-m-d', $currentDateTS);
                        } else {
                            $date_between_select[] = date('Y-m-d', $currentDateTS);
                        }
						$updated_date_arr[] = date('Y-m-d', $currentDateTS);
                    }
                    $cnt = 0;
                    if (!empty($date_before_select)) {
                        $cnt = count($date_before_select) -1;
                        $data['CustomPricePerNight']['property_id'] = $id;
                        $data['CustomPricePerNight']['price'] = $record['CustomPricePerNight']['price'];
                        $data['CustomPricePerNight']['start_date'] = $date_before_select[0];
                        $data['CustomPricePerNight']['end_date'] = $date_before_select[$cnt];
                        $data['CustomPricePerNight']['is_available'] = $record['CustomPricePerNight']['is_available'];
                        $this->CustomPricePerNight->create();
                        $this->CustomPricePerNight->save($data);
                    }
                    if (!empty($date_between_select)) {
                        $cnt = count($date_between_select) -1;
                        $data['CustomPricePerNight']['property_id'] = $id;
                        $data['CustomPricePerNight']['price'] = $price;
                        $data['CustomPricePerNight']['start_date'] = $date_between_select[0];
                        $data['CustomPricePerNight']['end_date'] = $date_between_select[$cnt];
                        $data['CustomPricePerNight']['is_available'] = $is_available;
                        $this->CustomPricePerNight->create();
                        $this->CustomPricePerNight->save($data);
                    }
                    if (!empty($date_after_select)) {
                        $cnt = count($date_after_select) -1;
                        $data['CustomPricePerNight']['property_id'] = $id;
                        $data['CustomPricePerNight']['price'] = $record['CustomPricePerNight']['price'];
                        $data['CustomPricePerNight']['start_date'] = $date_after_select[0];
                        $data['CustomPricePerNight']['end_date'] = $date_after_select[$cnt];
                        $data['CustomPricePerNight']['is_available'] = $record['CustomPricePerNight']['is_available'];
                        $this->CustomPricePerNight->create();
                        $this->CustomPricePerNight->save($data);
                    }
                    $this->CustomPricePerNight->delete($record['CustomPricePerNight']['id']);
                }
				$i = 0;
				$missed_arr = 'before_missed_date';
				for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS+= (60*60*24)) {
					$i++;
					$current_date = date('Y-m-d', $currentDateTS);
					if (!in_array($current_date, $updated_date_arr)) {
						if ($i == 1) {
							${$missed_arr}[0] = date('Y-m-d', $currentDateTS);
							${$missed_arr}[1] = date('Y-m-d', $currentDateTS);
						} else {
							${$missed_arr}[1] = date('Y-m-d', $currentDateTS);
						}
					} else {
						$missed_arr = 'after_missed_date';
						$i = 0;
					}
				}
				if (!empty($before_missed_date)) {
					$data = array();
					$data['CustomPricePerNight']['property_id'] = $id;
					$data['CustomPricePerNight']['price'] = $price;
					$data['CustomPricePerNight']['start_date'] = $before_missed_date[0];
					$data['CustomPricePerNight']['end_date'] = $before_missed_date[1];
					$data['CustomPricePerNight']['is_available'] = $is_available;
					$this->CustomPricePerNight->create();
					$this->CustomPricePerNight->save($data);
				}
				if (!empty($after_missed_date)) {
					$data = array();
					$data['CustomPricePerNight']['property_id'] = $id;
					$data['CustomPricePerNight']['price'] = $price;
					$data['CustomPricePerNight']['start_date'] = $after_missed_date[0];
					$data['CustomPricePerNight']['end_date'] = $after_missed_date[1];
					$data['CustomPricePerNight']['is_available'] = $is_available;
					$this->CustomPricePerNight->create();
					$this->CustomPricePerNight->save($data);
				}
                $ret['IsSuccess'] = true;
                $ret['Msg'] = 'add success';
            }
        } else {
            $ret['IsSuccess'] = false;
            $ret['Msg'] = 'Update failed';
        }
        $ret['Data'] = rand();
        return $ret;
    }
    function getDateIntervals($day, $type)
    {
        $phpTime = $this->js2PhpTime($day);
        switch ($type) {
            case 'month':
                $st = mktime(0, 0, 0, date('m', $phpTime) , 1, date('Y', $phpTime));
                $et = mktime(0, 0, -1, date('m', $phpTime) +1, 1, date('Y', $phpTime));
                $cnt = 50;
                break;

            case 'week':
                //suppose first day of a week is monday
                $monday = date('d', $phpTime) -date('N', $phpTime) +1;
                $st = mktime(0, 0, 0, date('m', $phpTime) , $monday, date('Y', $phpTime));
                $et = mktime(0, 0, -1, date('m', $phpTime) , $monday+7, date('Y', $phpTime));
                $cnt = 20;
                break;

            case 'day':
                $st = mktime(0, 0, 0, date('m', $phpTime) , date('d', $phpTime) , date('Y', $phpTime));
                $et = mktime(0, 0, -1, date('m', $phpTime) , date('d', $phpTime) +1, date('Y', $phpTime));
                $cnt = 5;
                break;
        }
        $return = array();
        $return['start_date'] = $st;
        $return['end_date'] = $et;
        return $return;
    }
    function js2PhpTime($jsdate)
    {
        if (preg_match('@(\d+)/(\d+)/(\d+)\s+(\d+):(\d+)@', $jsdate, $matches) == 1) {
            $ret = mktime($matches[4], $matches[5], 0, $matches[1], $matches[2], $matches[3]);
        } else if (preg_match('@(\d+)/(\d+)/(\d+)@', $jsdate, $matches) == 1) {
            $ret = mktime(0, 0, 0, $matches[1], $matches[2], $matches[3]);
        }
        return $ret;
    }
    function php2JsTime($phpDate)
    {
        return date('m/d/Y H:i', $phpDate);
    }
    function php2MySqlTime($phpDate)
    {
        return date('Y-m-d H:i:s', $phpDate);
    }
    function mySql2PhpTime($sqlDate)
    {
        $arr = date_parse($sqlDate);
        return mktime($arr['hour'], $arr['minute'], $arr['second'], $arr['month'], $arr['day'], $arr['year']);
    }
}
?>