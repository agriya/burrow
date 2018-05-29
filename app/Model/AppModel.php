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
/* SVN FILE: $Id: app_model.php 173 2009-01-31 12:51:40Z rajesh_04ag02 $ */
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7847 $
 * @modifiedby    $LastChangedBy: renan.saddam $
 * @lastmodified  $Date: 2008-11-08 08:24:07 +0530 (Sat, 08 Nov 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
App::uses('Model', 'Model');
class AppModel extends Model
{
    public $actsAs = array(
        'Containable',
    );
	/**
     * use Caching
     *
     * @var string
     */
	public $useCache = true;
	public $recursive = -1;
	
	public function __construct($id = false, $table = null, $ds = null)
    {
        Cms::applyHookProperties('Hook.model_properties', $this);
        CmsHook::applyBindModel($this);
        parent::__construct($id, $table, $ds);
    }
	public function find($type = 'first', $query = array())
	{
		if (Configure::read('Memcached.is_memcached_enabled')) {
			$cachedQuery = Cms::dispatchEvent('Model.HighPerformance.getCachedQuery', $this, array(
                'type' => $type,
                'params' => $query,
                'version' => '',
                'fullTag' => '',
            ));
            if (!empty($cachedQuery->data['result'])) {
                return $cachedQuery->data['result'];
            }
            $result = array(
                'version' => $cachedQuery->data['version'],
                'data' => parent::find($type, $query)
            );
            Cms::dispatchEvent('Model.HighPerformance.setCachedQuery', $this, array(
                'result' => $result,
                'fullTag' => $cachedQuery->data['fullTag'],
            ));
            return $result['data'];
		} else {
			return parent::find($type, $query);
		}
	}
	public function updateAll($fields, $conditions = true)
    {
        $args = func_get_args();
        $output = call_user_func_array(array(
            'parent',
            'updateAll'
        ) , $args);
        if ($output) {
            $created = false;
            $options = array();
            $field = sprintf('%s.%s', $this->alias, $this->primaryKey);
            if (!empty($args[1][$field])) {
				if (is_array($args[1][$field])) {
					foreach($args[1][$field] as $id) {
						$this->id = $id;
						$event = new CakeEvent('Model.afterSave', $this, array(
							$created,
							$options
						));
						$this->getEventManager()->dispatch($event);
					}
				} else {
					$this->id = $args[1][$field];
					$event = new CakeEvent('Model.afterSave', $this, array(
						$created,
						$options
					));
					$this->getEventManager()->dispatch($event);
				}
            }
            $this->_clearCache();
            return true;
        }
        return false;
    }
	public function deleteAll($conditions, $cascade = true, $callbacks = false)
    {
        $args = func_get_args();
        $output = call_user_func_array(array(
            'parent',
            'deleteAll'
        ) , $args);
        if ($output) {
            $field = sprintf('%s.%s', $this->alias, $this->primaryKey);
            if (!empty($args[1][$field])) {
				if (is_array($args[1][$field])) {
					foreach($args[1][$field] as $id) {
						$this->id = $id;
						$event = new CakeEvent('Model.afterDelete', $this, array(
						));
						$this->getEventManager()->dispatch($event);
					}
				} else {
					$this->id = $args[1][$field];
					$event = new CakeEvent('Model.afterDelete', $this, array(
					));
					$this->getEventManager()->dispatch($event);
				}
            }
            $this->_clearCache();
            return true;
        }
        return false;
    }
    function getIdHash($ids = null)
    {
        return md5($ids . Configure::read('Security.salt'));
    }
    function isValidIdHash($ids = null, $hash = null)
    {
        return (md5($ids . Configure::read('Security.salt')) == $hash);
    }
    function findOrSaveAndGetId($data)
    {
        $findExist = $this->find('first', array(
            'conditions' => array(
                'name' => $data
            ) ,
            'fields' => array(
                'id'
            ) ,
            'recursive' => -1
        ));
        if (!empty($findExist)) {
            return $findExist[$this->name]['id'];
        } else {
            $this->data[$this->name]['name'] = $data;
            $this->save($this->data[$this->name]);
            return $this->id;
        }
    }
    function findCountryId($data)
    {
        $findExist = $this->find('first', array(
            'conditions' => array(
                'Country.iso_alpha2' => $data
            ) ,
            'fields' => array(
                'Country.id'
            ) ,
            'recursive' => -1
        ));
        return $findExist[$this->name]['id'];
    }
    function siteWithCurrencyFormat($amount, $wrap = 'span')
    {
        $_currencies = $GLOBALS['currencies'];
        $currency_code = Configure::read('site.currency_id');
        if (!empty($_COOKIE['CakeCookie']['user_currency'])) {
            $currency_code = $_COOKIE['CakeCookie']['user_currency'];
        }
        if ($_currencies[$currency_code]['Currency']['is_prefix_display_on_left']) {
            return $this->cCurrency($amount, $wrap);
        } else {
            return $this->cCurrency($amount, $wrap);
        }
    }
    function cCurrency($str, $wrap = 'span', $title = false)
    {
        $_precision = 2;
        $_currencies = $GLOBALS['currencies'];
        $currency_code = Configure::read('site.currency_id');
        if (!empty($_COOKIE['CakeCookie']['user_currency'])) {
            $currency_code = $_COOKIE['CakeCookie']['user_currency'];
            $str = round($str*$_currencies[Configure::read('site.currency_id') ]['CurrencyConversion'][$currency_code], 2);
        }
        $changed = (($r = floatval($str)) != $str);
        $rounded = (($rt = round($r, $_precision)) != $r);
        $r = $rt;
        if ($wrap) {
            if (!$title) {
                $title = ucwords(Numbers_Words::toCurrency($r, 'en_US', $_currencies[$currency_code]['Currency']['code']));
            }
            $r = '<' . $wrap . ' class="c' . $changed . ' cr' . $rounded . '" title="' . $title . '">' . number_format($r, $_precision, $_currencies[$currency_code]['Currency']['dec_point'], $_currencies[$currency_code]['Currency']['thousands_sep']) . '</' . $wrap . '>';
        }
        return $r;
    }
    function _isValidCaptcha()
    {
        include_once VENDORS . DS . 'securimage' . DS . 'securimage.php';
        $img = new Securimage();
        return $img->check($this->data[$this->name]['captcha']);
    }
    public function _sendEmail($template, $replace_content, $to, $from = null)
    {
        App::uses('CakeEmail', 'Network/Email');
        $this->Email = new CakeEmail();
		if(isPluginEnabled('HighPerformance') && Configure::read('mail.is_smtp_enabled')) {
			$this->Email->config('smtp');
		}
        $default_content = array(
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##SITE_URL##' => Router::url('/', true) ,
			'##FROM_EMAIL##' => (!empty($from) ? $from : Configure::read('site.from_email')),
			'##UNSUBSCRIBE_LINK##' => Router::url(array(
				'controller' => 'user_notifications',
				'action' => 'edit',
				'admin' => false
			), true),
			'##CONTACT_URL##' => Router::url(array(
				'controller' => 'contacts',
				'action' => 'add',
				'admin' => false
			), true),
        );
        $emailFindReplace = array_merge($default_content, $replace_content);
        $content['text'] = strtr($template['email_text_content'], $emailFindReplace);
		$content['html'] = strtr($template['email_content'], $emailFindReplace);
        $subject = strtr($template['subject'], $emailFindReplace);
        // Send e-mail
        if (!empty($from)) {
            $this->Email->from($from, Configure::read('site.name'));
        } else {
            $this->Email->from(Configure::read('site.from_email') , Configure::read('site.name'));
        }
        $reply_to_email = (!empty($template['reply_to']) && $template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $template['reply_to'];
        if (!empty($reply_to_email)) {
            $this->Email->replyTo($reply_to_email);
        }
        $this->Email->to($to);
        $this->Email->subject($subject);
		$this->Email->emailFormat('both');
        $this->Email->send($content);
    }	
    function _sendAlertOnNewMessage($email, $message, $message_id, $template)
    {
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Model', 'Properties.Message');
        $this->Message = new Message();
        App::import('Model', 'User');
        $this->User = new User();
        App::import('Model', 'Properties.MessageContent');
        $this->MessageContent = new MessageContent();
        App::import('Component', 'Email');
        $this->Email = new EmailComponent($collection);
        $template = $this->EmailTemplate->selectTemplate($template);
        $get_message_hash = $this->Message->find('first', array(
            'conditions' => array(
                'Message.message_content_id = ' => $message_id,
                'Message.is_sender' => 0
            ) ,
            'fields' => array(
                'Message.id',
                'Message.created',
                'Message.user_id',
                'Message.other_user_id',
                'Message.parent_message_id',
                'Message.message_content_id',
                'Message.message_folder_id',
                'Message.is_sender',
                'Message.is_starred',
                'Message.is_read',
                'Message.is_deleted',
                'Message.hash',
            ) ,
            'contain' => array(
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.id',
                        'MessageContent.message',
                        'MessageContent.is_system_flagged',
                        'MessageContent.detected_suspicious_words',
                    ) ,
                )
            ) ,
            'recursive' => 2
        ));
        // @todo "User activation" check user.is_send_email_notifications_only_to_verified_email_account
        if (!empty($get_message_hash) && empty($get_message_hash['MessageContent']['is_system_flagged'])) {
            $get_user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $get_message_hash['Message']['user_id']
                ) ,
                'recursive' => -1
            ));
            $emailFindReplace = array(
                '##MESSAGE##' => $message['message'],
                '##REPLY_LINK##' => Router::url(array(
                    'controller' => 'messages',
                    'action' => 'compose',
                    'admin' => false,
                    $get_message_hash['Message']['id'],
                    'reply'
                ) , true) ,
                '##VIEW_LINK##' => Router::url(array(
                    'controller' => 'messages',
                    'action' => 'v',
                    'admin' => false,
                    $get_message_hash['Message']['id'],
                ) , true) ,
                '##TO_USER##' => $get_user['User']['username'],
                '##FROM_USER##' => (($template == 'Booking Alert Mail') ? 'Administrator' : $_SESSION['Auth']['User']['username']) ,
                '##FROM_USER##' => (($template == 'Booking Alert Mail') ? 'Administrator' : $_SESSION['Auth']['User']['username']) ,
                '##SUBJECT##' => $message['subject'],
                '##FROM_EMAIL##' => ($template['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $template['from'],
            );
			// Send e-mail to users
			$this->_sendEmail($template,$emailFindReplace,$email);
        }
    }
    function _checkUserNotifications($to_user_id, $order_status_id, $is_sender, $is_contact = null)
    {
        App::import('Model', 'Properties.UserNotification');
        $this->UserNotification = new UserNotification();
        $conditions = array();
        $notification_check_array = array(
            '1' => 'is_new_property_order_host_notification',
            '2' => 'is_accept_property_order_traveler_notification',
            '3' => 'is_reject_property_order_traveler_notification',
            '4' => 'is_cancel_property_order_host_notification',
            '5' => 'is_arrival_host_notification',
            '6' => 'is_review_property_order_traveler_notification',
            '7' => 'is_cleared_notification',
            '8' => 'is_complete_property_order_host_notification',
            '9' => 'is_expire_property_order_host_notification',
            '10' => 'is_cancel_property_order_host_notification',
            '11' => 'is_admin_cancel_property_order_host_notification',
            '12' => 'is_complete_later_property_order_host_notification',
            '46' => 'is_recieve_dispute_notification',
        );
        $notification_check_sender_array = array(
            '1' => 'is_new_property_order_traveler_notification',
            '2' => 'is_accept_property_order_host_notification',
            '3' => 'is_reject_property_order_host_notification',
            '4' => 'is_cancel_property_order_traveler_notification',
            '5' => 'is_arrival_traveler_notification',
            '6' => 'is_review_property_order_host_notification',
            '7' => 'is_cleared_notification',
            '8' => 'is_complete_property_order_traveler_notification',
            '9' => 'is_expire_property_order_traveler_notification',
            '10' => 'is_cancel_property_order_traveler_notification',
            '11' => 'is_admin_cancel_traveler_notification',
            '12' => 'is_complete_later_property_order_traveler_notification',
            '15' => 'is_recieve_mutual_cancel_notification',
            '46' => 'is_recieve_dispute_notification',
        );
        if (!empty($is_contact)) {
            $conditions['UserNotification.is_contact_notification'] = 1;
        }
        if (!empty($to_user_id)) {
            $check_notifications = $this->UserNotification->find('first', array(
                'conditions' => array(
                    'UserNotification.user_id' => $to_user_id
                ) ,
                'recursive' => -1
            ));
            if (!empty($check_notifications)) {
                $conditions['UserNotification.user_id'] = $to_user_id;
                if (empty($is_contact)) {
                    if (empty($is_sender)) {
                        if (isset($notification_check_array[$order_status_id])) {
                            $conditions["UserNotification.$notification_check_array[$order_status_id]"] = '1';
                        }
                    } else {
                        $conditions["UserNotification.$notification_check_sender_array[$order_status_id]"] = '1';
                    }
                }
                $check_send_mail = $this->UserNotification->find('first', array(
                    'conditions' => $conditions,
                    'recursive' => -1
                ));
                if (!empty($check_send_mail)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }
    }
    function getRatingCount($user_id)
    {
        App::import('Model', 'Properties.Property');
        $this->Property = new Property();
        $total_property_feedback_count = '';
        $total_property_positive_feedback_count = '';
        $get_user_total_ratings = $this->Property->find('all', array(
            'conditions' => array(
                'Property.user_id' => $user_id
            ) ,
            'recursive' => -1
        ));
        foreach($get_user_total_ratings as $get_user_total_rating) {
            if (!empty($get_user_total_rating['Property']['property_feedback_count'])) {
                $total_property_feedback_count+= $get_user_total_rating['Property']['property_feedback_count'];
                $total_property_positive_feedback_count+= $get_user_total_rating['Property']['positive_feedback_count'];
            }
        }
        $getrating = $this->getPropertyRating($total_property_feedback_count, $total_property_positive_feedback_count);
        return $getrating;
    }
    function getPropertyRating($total_rating, $possitive_rating)
    {
        if (!$total_rating) {
            return __l('Not Reviewed Yet');
        } else {
            if ($possitive_rating) {
                return floor(($possitive_rating/$total_rating) *100) . '% ' . __l('Positive');
            } else {
                return '100% ' . __l('Negative');
            }
        }
    }
    function siteCurrencyFormat($amount)
    {
        if (Configure::read('site.currency_symbol_place') == 'left') {
            return Configure::read('site.currency') . $amount;
        } else {
            return $amount . Configure::read('site.currency');
        }
    }
    function toSaveIp()
    {
        App::import('Model', 'Ip');
        $this->Ip = new Ip();
        $this->data['Ip']['ip'] = RequestHandlerComponent::getClientIP();
        $ip = $this->Ip->find('first', array(
            'conditions' => array(
                'Ip.ip' => $this->data['Ip']['ip']
            ) ,
            'fields' => array(
                'Ip.id'
            ) ,
            'recursive' => -1
        ));
        if (empty($ip)) {
            $this->data['Ip']['host'] = gethostbyaddr($this->data['Ip']['ip']);
            if (!empty($_COOKIE['_geo'])) {
                $_geo = explode('|', $_COOKIE['_geo']);
                $country = $this->Ip->Country->find('first', array(
                    'conditions' => array(
                        'Country.iso_alpha2' => $_geo[0]
                    ) ,
                    'fields' => array(
                        'Country.id'
                    ) ,
                    'recursive' => -1
                ));
                if (empty($country)) {
                    $this->data['Ip']['country_id'] = 0;
                } else {
                    $this->data['Ip']['country_id'] = $country['Country']['id'];
                }
                $state = $this->Ip->State->find('first', array(
                    'conditions' => array(
                        'State.Name' => $_geo[1]
                    ) ,
                    'fields' => array(
                        'State.id'
                    ) ,
                    'recursive' => -1
                ));
                if (empty($state)) {
                    $this->data['State']['name'] = $_geo[1];
                    $this->Ip->State->create();
                    $this->Ip->State->save($this->data['State']);
                    $this->data['Ip']['state_id'] = $this->Ip->State->getLastInsertId();
                } else {
                    $this->data['Ip']['state_id'] = $state['State']['id'];
                }
                $city = $this->Ip->City->find('first', array(
                    'conditions' => array(
                        'City.Name' => $_geo[2]
                    ) ,
                    'fields' => array(
                        'City.id'
                    ) ,
                    'recursive' => -1
                ));
                if (empty($city)) {
                    $this->data['City']['name'] = $_geo[2];
                    $this->Ip->City->create();
                    $this->Ip->City->save($this->data['City']);
                    $this->data['Ip']['city_id'] = $this->Ip->City->getLastInsertId();
                } else {
                    $this->data['Ip']['city_id'] = $city['City']['id'];
                }
                $this->data['Ip']['latitude'] = $_geo[3];
                $this->data['Ip']['longitude'] = $_geo[4];
            }
            $this->Ip->create();
            $this->Ip->save($this->data['Ip']);
            return $this->Ip->getLastInsertId();
        } else {
            return $ip['Ip']['id'];
        }
    }
    function _checkCancellationPolicies($propertyUser)
    {
        $return_amount = array();
        if (!empty($propertyUser['Property']['cancellation_policy_id']) && !empty($propertyUser['PropertyUser']['price'])) {
			$check_in_diff_date = ceil((strtotime($propertyUser['PropertyUser']['checkin']) - strtotime('now')) / (60*60*24));
            if ($check_in_diff_date < $propertyUser['Property']['CancellationPolicy']['days']) {
                if (!empty($propertyUser['Property']['CancellationPolicy']['percentage'])) {
                    $percentage = $propertyUser['Property']['CancellationPolicy']['percentage']/100;
                    $return_amount['traveler_balance'] = $propertyUser['PropertyUser']['price']*$percentage;
					if ($percentage != 1) {
						$return_amount['host_balance'] = $propertyUser['PropertyUser']['price']-$propertyUser['PropertyUser']['host_service_amount']-$return_amount['traveler_balance'];
						$return_amount['host_service_amount'] = $propertyUser['PropertyUser']['host_service_amount'];
					}
                } else {
					$return_amount['traveler_balance'] = $propertyUser['PropertyUser']['price'];
                    $return_amount['full_refund'] = 1;
                }
            } else {
				$return_amount['traveler_balance'] = $propertyUser['PropertyUser']['price'];
                $return_amount['full_refund'] = 1;
            }
            return $return_amount;
        }
    }
    function getGatewayTypes($field = null)
    {
        App::import('Model', 'PaymentGateway');
        $this->PaymentGateway = new PaymentGateway();
        $paymentGateways = $this->PaymentGateway->find('all', array(
            'conditions' => array(
                'PaymentGateway.is_active' => 1
            ) ,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'conditions' => array(
                        'PaymentGatewaySetting.name' => $field,
                        'PaymentGatewaySetting.test_mode_value' => 1
                    ) ,
                ) ,
            ) ,
            'order' => array(
                'PaymentGateway.display_name' => 'asc'
            ) ,
            'recursive' => 1
        ));
        $payment_gateway_types = array();
        foreach($paymentGateways as $paymentGateway) {
            if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                $payment_gateway_types[$paymentGateway['PaymentGateway']['id']] = $paymentGateway['PaymentGateway']['display_name'];
            }
        }
        return $payment_gateway_types;
    }
    function isPaymentGatewayEnabled($payment_gateway_id = null)
    {
        App::import('Model', 'PaymentGateway');
        $this->PaymentGateway = new PaymentGateway();
        $paymentGateway = $this->PaymentGateway->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => $payment_gateway_id,
                'PaymentGateway.is_active' => 1
            ) ,
            'recursive' => -1
        ));
        if (!empty($paymentGateway)) {
            return true;
        }
        return false;
    }
    function getBookingChart($user_id = null, $property_id = null)
    {
        App::import('Model', 'Properties.Property');
        $max_count = 0;
        $this->Property = new Property();
        if (empty($property_id)) {
            $conditions_propery_view = array();
            $conditions_propery_user = array();
            $chart_propery_ids = $this->Property->find('list', array(
                'conditions' => array(
                    'Property.user_id' => $user_id
                ) ,
                'fields' => array(
                    'Property.id'
                ),
				'recursive' => -1,
            ));
            if (!empty($chart_propery_ids)) {
                $conditions_propery_view['PropertyView.property_id'] = $chart_propery_ids;
                $conditions_propery_user['PropertyUser.property_id'] = $chart_propery_ids;
            } else {
                $conditions_propery_view['PropertyView.property_id'] = 0;
                $conditions_propery_user['PropertyUser.property_id'] = 0;
            }
        } else {
            $conditions_propery_view['PropertyView.property_id'] = $property_id;
            $conditions_propery_user['PropertyUser.property_id'] = $property_id;
        }
        $days = 3;
        for ($i = $days; $i > 0; $i--) {		
			 $conditions_propery_view["PropertyView.created >= "] = date('Y-m-d 00:00:00', strtotime("-$i days"));
			 $conditions_propery_view["PropertyView.created <= "] = date('Y-m-d 23:59:59', strtotime("-$i days"));
            $property_view_count = $this->Property->PropertyView->find('count', array(
                'conditions' => $conditions_propery_view,
				'recursive' => -1,
            ));
            $chart_data['PropertyView'][$i]['count'] = $property_view_count;
            if ($property_view_count > $max_count) {
                $max_count = $property_view_count;
            }
        }
        $days = 3;
        for ($i = $days; $i > 0; $i--) {
			 $conditions_propery_user["PropertyUser.created >= "] = date('Y-m-d 00:00:00', strtotime("-$i days"));
			 $conditions_propery_user["PropertyUser.created <= "] = date('Y-m-d 23:59:59', strtotime("-$i days"));
            $property_user_count = $this->Property->PropertyUser->find('count', array(
                'conditions' => $conditions_propery_user,
				'recursive' => -1,
            ));
            $chart_data['PropertyUser'][$i]['count'] = $property_user_count;
            if ($property_user_count > $max_count) {
                $max_count = $property_view_count;
            }
        }
        $chart_data['max_count'] = $max_count;
        return $chart_data;
    }
	public function _isValidCaptchaSolveMedia()
    {
        include_once VENDORS . DS . 'solvemedialib.php';
        $privkey = Configure::read('captcha.verification_key');
        $hashkey = Configure::read('captcha.hash_key');
        $solvemedia_response = solvemedia_check_answer($privkey, $_SERVER["REMOTE_ADDR"], $_POST["adcopy_challenge"], $_POST["adcopy_response"], $hashkey);
        if (!$solvemedia_response->is_valid) {
            //handle incorrect answer
            return false;
        } else {
            return true;
        }
    }
}
?>