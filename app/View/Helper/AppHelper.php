<?php
/* SVN FILE: $Id: app_helper.php 195 2009-03-18 06:30:14Z rajesh_04ag02 $ */
/**
 * Short description for file.
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
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
 * @subpackage    cake.cake
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7904 $
 * @modifiedby    $LastChangedBy: mark_story $
 * @lastmodified  $Date: 2008-12-05 22:19:43 +0530 (Fri, 05 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::uses('Helper', 'View');
/**
 * This is a placeholder class.
 * Create the same file in app/app_helper.php
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake
 */
class AppHelper extends Helper
{
    public function assetUrl($path, $options = array() , $cdn_path = '')
    {
        $assetURL = Cms::dispatchEvent('Helper.HighPerformance.getAssetUrl', $this->_View, array(
            'options' => $options,
            'assetURL' => '',
        ));
        return parent::assetUrl($path, $options, $assetURL->data['assetURL']);
    }
    function getUserAvatar($user_details, $dimension = 'medium_thumb', $is_link = true, $anonymous = '', $from = '', $isAttachment = '', $from_model = '')
    {
        $width = Configure::read('thumb_size.' . $dimension . '.width');
        $height = Configure::read('thumb_size.' . $dimension . '.height');
        if (!empty($from) && $from == 'layout') {
            $width = '16';
            $height = '16';
        }
        $tooltipClass = 'js-tooltip';
        $title = '';
        if (!$is_link) {
            $tooltipClass = '';
            if (isset($user_details['username'])) {
                $title = $this->cText($user_details['username'], false);
            }
            if (!empty($anonymous) && ($anonymous == 'anonymous')) {
                $title = 'Anonymous';
            }
        }
        if (!empty($from_model) && $from_model == 'modal') {
            $tooltipClass = '';
        }
        if (!empty($from) && $from == 'layout') {
            $tooltipClass = '';
        }
        if (!empty($anonymous) && ($anonymous == 'anonymous')) {
            $username = __l('Anonymous');
            $user_image = $this->showImage('Anonymous', '', array(
                'dimension' => $dimension,
                'class' => $tooltipClass,
                'alt' => sprintf(__l('[Image: %s]') , $this->cText($username, false)) ,
                'title' => (!$is_link) ? $this->cText($username, false) : '',
            ) , null, null, false);
        } elseif (!empty($user_details['user_avatar_source_id']) && $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Facebook) {
            $user_image = $this->getFacebookAvatar($user_details['facebook_user_id'], $height, $width, $user_details['username'], $is_link, $from);
		} elseif (!empty($user_details['user_avatar_source_id']) && $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Linkedin) {
			if (!empty($user['User']['linkedin_avatar_url'])) {
				$user_image = $this->image($user_details['linkedin_avatar_url'], array(
					'title' => $title,
					'width' => $width,
					'height' => $height,
					'border' => 0,
					'class' => $tooltipClass
				));
			} else {
				$user_details['username'] = !empty($user_details['username']) ? $user_details['username'] : '';
				$user_image = $this->image(getImageUrl('UserAvatar', '', array(
					'dimension' => $dimension
				)) , array(
					'width' => $width,
					'height' => $height,
					'class' => $tooltipClass,
					'alt' => sprintf(__l('[Image: %s]') , $this->cText($user_details['username'], false)) ,
					'title' => (!$is_link) ? $this->cText($user_details['username'], false) : '',
				));				
			}
        } elseif (!empty($user_details['user_avatar_source_id']) && $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Twitter) {
            $user_image = $this->image($user_details['twitter_avatar_url'], array(
                'title' => $title,
                'width' => $width,
                'height' => $height,
                'border' => 0,
                'class' => $tooltipClass
            ));
        } else {
            if (empty($user_details['UserAvatar'])) {
                if (!empty($user_details['id'])) {
                    App::uses('User', 'Model');
                    $this->User = new User();
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $user_details['id'],
                        ) ,
                        'contain' => array(
                            'UserAvatar'
                        ) ,
                        'recursive' => 0
                    ));
                    if (!empty($user['UserAvatar']['id'])) {
                        $user_details['UserAvatar'] = $user['UserAvatar'];
                    }
                }
            }
            $user_details['username'] = !empty($user_details['username']) ? $user_details['username'] : '';
            $user_image = $this->image(getImageUrl('UserAvatar', (!empty($user_details['UserAvatar'])) ? $user_details['UserAvatar'] : '', array(
                'dimension' => $dimension
            )) , array(
                'width' => $width,
                'height' => $height,
                'class' => $tooltipClass,
                'alt' => sprintf(__l('[Image: %s]') , $this->cText($user_details['username'], false)) ,
                'title' => (!$is_link) ? $this->cText($user_details['username'], false) : '',
            ));
        }
        $before_span = $after_span = '';
        if ($from != 'facebook') {
            $span_class = '';
            if ($dimension == 'micro_thumb' && $from != 'admin') {
                $span_class = ' span1';
            }
            $pr_class = 'pr';
            if (($this->request->params['controller'] == 'blogs' && !empty($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'activity') || (!empty($this->request->params['named']['load_type']) && $this->request->params['named']['load_type'] == 'modal')) {
                $pr_class = '';
            }
            $before_span = '<span class="' . $pr_class . '"><span class="avtar-box pull-left pr mob-clr">';
            $after_span = '</span></span>';
        }
        $image = (!$is_link) ? $user_image : $this->link($user_image, array(
            'controller' => 'users',
            'action' => 'view',
            $user_details['username'],
            'admin' => false
        ) , array(
            'title' => $this->cText($user_details['username'], false) ,
            'class' => $tooltipClass . ' show no-pad',
            'escape' => false
        ));
        return $before_span . $image . $after_span;
    }
    function getUserAvatarLink($user_details, $dimension = 'medium_thumb', $is_link = true, $linkclass = '', $imgclass = '')
    {
        $width = Configure::read('thumb_size.' . $dimension . '.width');
        $height = Configure::read('thumb_size.' . $dimension . '.height');
        $user_image = '';
        if ((!empty($user_details['user_avatar_source_id']) && $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Facebook)) {
            $user_image = $this->getFacebookAvatar($user_details['facebook_user_id'], $height, $width);
		} elseif (!empty($user_details['user_avatar_source_id']) && $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Linkedin) {
			if (!empty($user['User']['linkedin_avatar_url'])) {
					$user_image = $this->image($user_details['linkedin_avatar_url'], array(
					'title' => $this->cText($user_details['username'], false) ,
					'width' => $width,
					'height' => $height,
					'class' => $imgclass
				));
			} else {
				$user_details['username'] = !empty($user_details['username']) ? $user_details['username'] : '';
                $user_image = $this->Html->Image(getImageUrl('UserAvatar', '', array(
                    'dimension' => $dimension,
                    'alt' => sprintf('[Image: %s]', $user_details['username']) ,
                    'title' => $user_details['username'],
                    'class' => $imgclass
                )) , array(
                    'width' => $width,
                    'height' => $height
                ));
			}
        } elseif (!empty($user_details['user_avatar_source_id']) && $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Twitter) {
            $user_image = $this->image($user_details['twitter_avatar_url'], array(
                'title' => $this->cText($user_details['username'], false) ,
                'width' => $width,
                'height' => $height,
                'class' => $imgclass
            ));
        } else {
            if (empty($user_details['UserAvatar'])) {
                if (!empty($user_details['id'])) {
                    App::uses('User', 'Model');
                    $this->User = new User();
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $user_details['id'],
                        ) ,
                        'contain' => array(
                            'UserAvatar'
                        ) ,
                        'recursive' => 0
                    ));
                    if (!empty($user['UserAvatar']['id'])) {
                        $user_details['UserAvatar'] = $user['UserAvatar'];
                    }
                }
            }
            if (!empty($user_details['UserAvatar'])) {
                $user_details['username'] = !empty($user_details['username']) ? $user_details['username'] : '';
                $user_image = $this->Html->Image(getImageUrl('UserAvatar', $user_details['UserAvatar'], array(
                    'dimension' => $dimension,
                    'alt' => sprintf('[Image: %s]', $user_details['username']) ,
                    'title' => $user_details['username'],
                    'class' => $imgclass
                )) , array(
                    'width' => $width,
                    'height' => $height,
                    'class' => $imgclass
                ));
            } else {
                $user_details['username'] = !empty($user_details['username']) ? $user_details['username'] : '';
                $user_image = $this->Html->Image(getImageUrl('UserAvatar', '', array(
                    'dimension' => $dimension,
                    'alt' => sprintf('[Image: %s]', $user_details['username']) ,
                    'title' => $user_details['username'],
                    'class' => $imgclass
                )) , array(
                    'width' => $width,
                    'height' => $height
                ));
            }
        }
        //return image to user
        return (!$is_link) ? $user_image : $this->link($user_image, array(
            'controller' => 'users',
            'action' => 'view',
            $user_details['username'],
            'admin' => false
        ) , array(
            'title' => $this->cText($user_details['username'], false) ,
            'escape' => false,
            'class' => $linkclass
        ));
    }
    public function getFacebookAvatar($fbuser_id, $height = 35, $width = 35, $username = '', $is_link = '', $from = '')
    {
        $tooltipClass = '';
        $title = '';
        if (!$is_link) {
            $tooltipClass = 'js-tooltip';
            $title = $username;
        }
        if (!empty($from) && $from == 'layout') {
            $tooltipClass = '';
        }
        return $this->image("http://graph.facebook.com/{$fbuser_id}/picture?type=normal&amp;width=$width&amp;height=$height", array(
            'width' => $width,
            'height' => $height,
            'border' => 0,
            'class' => $tooltipClass,
            'title' => $title
        ));
    }
    function getCurrUserInfo($id)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $id,
            ) ,
            'recursive' => -1
        ));
        return $user;
    }
    function getUserLink($user_details)
    {
        if ($user_details['role_id'] == ConstUserTypes::Admin || $user_details['role_id'] == ConstUserTypes::User) {
            return $this->link($this->cText($user_details['username'], false) , array(
                'controller' => 'users',
                'action' => 'view',
                $user_details['username'],
                'admin' => false
            ) , array(
                'title' => $this->cText($user_details['username'], false) ,
                'escape' => false,
                'class' => 'graydarkc'
            ));
        }
    }
    function CheckReview($host_id, $traveler_id, $property_user_id)
    {
        App::import('Model', 'Properties.PropertyUserFeedback');
        $this->PropertyUserFeedback = new PropertyUserFeedback();
        $count = $this->PropertyUserFeedback->find('count', array(
            'conditions' => array(
                'PropertyUserFeedback.host_user_id' => $host_id,
                'PropertyUserFeedback.traveler_user_id' => $traveler_id,
                'PropertyUserFeedback.property_user_id' => $property_user_id,
            ) ,
            'recursive' => -1
        ));
        return $count;
    }
    function transactionDescription($transaction)
    {
        $transaction['PropertyUser']['traveler_service_amount'] = !empty($transaction['PropertyUser']['traveler_service_amount']) ? $transaction['PropertyUser']['traveler_service_amount'] : 0;
        $transaction['PropertyUser']['host_service_amount'] = !empty($transaction['PropertyUser']['host_service_amount']) ? $transaction['PropertyUser']['host_service_amount'] : 0;
        $transaction['PropertyUser']['price'] = !empty($transaction['PropertyUser']['price']) ? $transaction['PropertyUser']['price'] : 0;
        $user_link = $this->link($transaction['User']['username'], array(
            'controller' => 'users',
            'action' => 'view',
            $transaction['User']['username'],
            'admin' => false
        ));
        $property_link = $host_link = $traveler_link = $property_amount = $order_link = $security_deposit = '';
        if ($transaction['Transaction']['class'] == 'PropertyUser') {
            $property_link = $this->link($transaction['PropertyUser']['Property']['title'], array(
                'controller' => 'properties',
                'action' => 'view',
                $transaction['PropertyUser']['Property']['slug'],
                'admin' => false
            ));
            $host_link = $this->link($transaction['PropertyUser']['Property']['User']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $transaction['PropertyUser']['Property']['User']['username'],
                'admin' => false
            ));
            $traveler_link = $this->link($transaction['PropertyUser']['User']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $transaction['PropertyUser']['User']['username'],
                'admin' => false
            ));
            $order_link = $this->link($transaction['PropertyUser']['id'], array(
                'controller' => 'messages',
                'action' => 'activities',
                'order_id' => $transaction['PropertyUser']['id'],
                'admin' => false
            ));
            if (in_array($transaction['TransactionType']['id'], array(
                ConstTransactionTypes::RefundForCanceledBooking,
                ConstTransactionTypes::RefundForBookingCanceledByAdmin,
                ConstTransactionTypes::RefundForExpiredBooking
            ))) {
                $property_amount = $this->siteCurrencyFormat($transaction['PropertyUser']['price']);
            }else if ($transaction['TransactionType']['id'] == ConstTransactionTypes::BookProperty && $transaction['Transaction']['receiver_user_id'] == $_SESSION['Auth']['User']['id']) {
                $property_amount = $this->siteCurrencyFormat($transaction['PropertyUser']['price']);
            } else {
                $property_amount = $this->siteCurrencyFormat($transaction['PropertyUser']['price'] + $transaction['PropertyUser']['traveler_service_amount']);
            }
            if (!empty($transaction['PropertyUser']['security_deposit']) && Configure::read('property.is_enable_security_deposit')) {
                $security_deposit = __l('with security deposit amount') . ' ' . $this->siteCurrencyFormat($transaction['PropertyUser']['security_deposit']);
            }
        } elseif ($transaction['Transaction']['class'] == 'Property') {
            $property_link = $this->link($transaction['Property']['title'], array(
                'controller' => 'properties',
                'action' => 'view',
                $transaction['Property']['slug'],
                'admin' => false
            ));
            $host_link = $this->link($transaction['Property']['User']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $transaction['Property']['User']['username'],
                'admin' => false
            ));
        }
        $transactionReplace = array(
            '##USER##' => $user_link,
            '##AFFILIATE_USER##' => $user_link,
            '##TRAVELER##' => $traveler_link,
            '##HOST##' => $host_link,
            '##PROPERTY##' => $property_link,
            '##ORDER_NO##' => $order_link,
            '##SECURITY_DEPOSIT##' => $security_deposit,
            '##PROPERTY_AMOUNT##' => $property_amount,
        );
        if (!empty($transaction['TransactionType']['message_for_receiver']) && $transaction['Transaction']['receiver_user_id'] == $_SESSION['Auth']['User']['id']) {
            return strtr($transaction['TransactionType']['message_for_receiver'], $transactionReplace);
        } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
            return strtr($transaction['TransactionType']['message_for_admin'], $transactionReplace);
        } else {
            return strtr($transaction['TransactionType']['message'], $transactionReplace);
        }
    }
    function conversationDescription($conversation, $classes = '')
    {
        $conversationReplace = array(
            '##TRAVELER##' => !empty($conversation['PropertyUser']) ? $this->link($conversation['PropertyUser']['User']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $conversation['PropertyUser']['User']['username'],
                'admin' => false
            ) , array(
                'class' => $classes
            )) : '',
            '##HOSTER##' => !empty($conversation['Property']['User']['username']) ? $this->link($conversation['Property']['User']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $conversation['Property']['User']['username'],
                'admin' => false
            ) , array(
                'class' => $classes
            )) : '',
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##CREATED_DATE##' => $this->cDateTime($conversation['PropertyUser']['created']) ,
            '##ACCEPTED_DATE##' => $this->cDateTime($conversation['PropertyUser']['created']) ,
            '##CLEARED_DATE##' => $this->cDateTime(date('Y-m-d H:i:s', strtotime('+' . Configure::read('property.days_after_amount_withdraw') . ' days', strtotime($conversation['PropertyUser']['checkin'])))) ,
            '##CHECKIN_DATE##' => $this->cDateTime($conversation['PropertyUser']['checkin']) ,
            '##CLEARED_DAYS##' => Configure::read('property.days_after_amount_withdraw')
        );
        return strtr($conversation['PropertyUserStatus']['description'], $conversationReplace);
    }
    public function formGooglemap($properydetails = array() , $size = '320x320')
    {
        if ((!(is_array($properydetails))) || empty($properydetails)) {
            return false;
        }
        $mapurl = '//maps.google.com/maps/api/staticmap?center=';
        $mapcenter[] = str_replace(' ', '+', $properydetails['latitude']) . ',' . $properydetails['longitude'];
        $mapcenter[] = 'zoom=' . (!empty($properydetails['zoom_level']) ? $properydetails['zoom_level'] : 8);
        $mapcenter[] = 'size=' . $size;
        $mapcenter[] = 'markers=color:pink|label:M|' . $properydetails['latitude'] . ',' . $properydetails['longitude'];
        $mapcenter[] = 'sensor=false';
        return $mapurl . implode('&amp;', $mapcenter);
    }
    function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        $theta = $lon1-$lon2;
        $dist = sin(deg2rad($lat1)) *sin(deg2rad($lat2)) +cos(deg2rad($lat1)) *cos(deg2rad($lat2)) *cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist*60*1.1515;
        $unit = strtoupper($unit);
        if ($unit == "K") {
            return ($miles*1.609344);
        } else if ($unit == "N") {
            return ($miles*0.8684);
        } else {
            return $miles;
        }
    }
    function getLanguage()
    {
        $languageList = array();
        if (isPluginEnabled('Translation')) {
            App::uses('Translation.Translation', 'Model');
            $modelObj = new Translation();
            $languages = $modelObj->find('all', array(
                'fields' => array(
                    'DISTINCT(Translation.language_id)',
                    'Language.name',
                    'Language.iso2'
                ) ,
                'order' => array(
                    'Language.name' => 'asc'
                ) ,
                'recursive' => 0,
            ));
            if (!empty($languages)) {
                foreach($languages as $language) {
                    if (!empty($language['Language']['name'])) {
                        $languageList[$language['Language']['iso2']] = $language['Language']['name'];
                    }
                }
            }
        }
        return $languageList;
    }
    function displayPercentageRating($total_rating, $possitive_rating)
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
    function siteCurrencyFormat($amount, $wrap = 'span')
    {
        $_currencies = $GLOBALS['currencies'];
        $currency_code = Configure::read('site.currency_id');
        if (!empty($_COOKIE['CakeCookie']['user_currency'])) {
            $currency_code = $_COOKIE['CakeCookie']['user_currency'];
        }
        if ($_currencies[$currency_code]['Currency']['is_prefix_display_on_left']) {
            return $_currencies[$currency_code]['Currency']['prefix'] . $this->cCurrency($amount, $wrap);
        } else {
            return $this->cCurrency($amount, $wrap) . $_currencies[$currency_code]['Currency']['prefix'];
        }
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
    function siteDefaultCurrencyFormat($amount, $wrap = 'span')
    {
        $_currencies = $GLOBALS['currencies'];
        $currency_code = Configure::read('site.currency_id');
        if ($_currencies[$currency_code]['Currency']['is_prefix_display_on_left']) {
            return $_currencies[$currency_code]['Currency']['prefix'] . $this->cDefaultCurrency($amount, $wrap);
        } else {
            return $this->cCurrency($amount, $wrap) . $_currencies[$currency_code]['Currency']['prefix'];
        }
    }
    function cCurrency($str, $wrap = 'span', $title = false)
    {
        $_precision = 2;
        $_currencies = $GLOBALS['currencies'];
        $currency_code = Configure::read('site.currency_id');
        if (!empty($_COOKIE['CakeCookie']['user_currency'])) {
            $currency_code = $_COOKIE['CakeCookie']['user_currency'];
            if (!empty($_currencies[Configure::read('site.currency_id') ]['CurrencyConversion'])) {
                $str = round($str*$_currencies[Configure::read('site.currency_id') ]['CurrencyConversion'][$currency_code], 2);
            }
        }
        $changed = (($r = floatval($str)) != $str);
        $rounded = (($rt = round($r, $_precision)) != $r);
        $r = $rt;
        if ($wrap) {
            if (!$title) {
                $Numbers_Words = new Numbers_Words();
                $title = ucwords($Numbers_Words->toCurrency($r, 'en_US', $_currencies[$currency_code]['Currency']['code']));
            }
            $r = '<' . $wrap . ' class="c' . $changed . ' cr' . $rounded . '" title="' . $title . '">' . number_format($r, $_precision, $_currencies[$currency_code]['Currency']['dec_point'], $_currencies[$currency_code]['Currency']['thousands_sep']) . '</' . $wrap . '>';
        }
        return $r;
    }
    function cDefaultCurrency($str, $wrap = 'span', $title = false)
    {
        $_precision = 2;
        $_currencies = $GLOBALS['currencies'];
        $currency_code = Configure::read('site.currency_id');
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
    function getCurrencies()
    {
        $currencyList = array();
        if (isset($GLOBALS['currencies'])) {
            $currencies = $GLOBALS['currencies'];
            if (!empty($currencies)) {
                foreach($currencies as $currency) {
                    $currencyList[$currency['Currency']['id']] = $currency['Currency']['code'];
                }
            }
        }
        return $currencyList;
    }
    function getUserUnReadMessages($user_id = null)
    {
        App::import('Model', 'Properties.Message');
        $this->Message = new Message();
        $unread_count = $this->Message->find('count', array(
            'conditions' => array(
                'Message.is_read' => '0',
                'Message.user_id' => $user_id,
                'Message.is_sender' => '0',
                'Message.message_folder_id' => ConstMessageFolder::Inbox,
                'MessageContent.is_system_flagged' => 0
            ) ,
            'recursive' => 0
        ));
        return $unread_count;
    }
    function getPaymentGatewayIsactive($gateway_name)
    {
        App::import('Model', 'PaymentGateway');
        $this->PaymentGateway = new PaymentGateway();
        $payment_gateway = $this->PaymentGateway->getPaymentGatewayIsactive($gateway_name);
        return $payment_gateway;
    }
    function getMassPayIsactive($gateway_name)
    {
        App::import('Model', 'PaymentGateway');
        $this->PaymentGateway = new PaymentGateway();
        $massPay = $this->PaymentGateway->getMassPayIsactive($gateway_name);
        return $massPay;
    }
    function getPluginChildren($plugin, $depth, $image_title_icons)
    {
        if (!empty($plugin['Children'])) {
            foreach($plugin['Children'] as $key => $subPlugin) {
                if (empty($subPlugin['name'])) {
                    echo $this->_View->element('plugin_head', array(
                        'key' => $key,
                        'image_title_icons' => $image_title_icons,
                        'depth' => $depth,
                        'cache' => array(
                            'config' => 'sec'
                        )
                    ) , array(
                        'plugin' => 'Extensions'
                    ));
                } else {
                    echo $this->_View->element('plugin', array(
                        'pluginData' => $subPlugin,
                        'depth' => $depth,
                        'cache' => array(
                            'config' => 'sec'
                        )
                    ) , array(
                        'plugin' => 'Extensions'
                    ));
                }
                if (!empty($subPlugin['Children'])) {
                    $depth++;
                    $this->getPluginChildren($subPlugin, $depth, $image_title_icons);
                    $depth = 0;
                }
            }
        }
    }
    function getBgImage()
    {
        App::import('Model', 'Attachment');
        $this->Attachment = new Attachment();
        $attachment = $this->Attachment->find('first', array(
            'conditions' => array(
                'Attachment.class' => 'Setting'
            ) ,
            'fields' => array(
                'Attachment.id',
                'Attachment.dir',
                'Attachment.foreign_id',
                'Attachment.filename',
                'Attachment.width',
                'Attachment.height',
            ) ,
            'recursive' => -1
        ));
        return $attachment;
    }
    public function getUserNotification($user_id = null)
    {
        App::import('Model', 'Properties.Message');
        $this->Message = new Message();
        $conditions = array();
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        $conditions = array(
            'Message.is_sender' => 0,
            'Message.message_folder_id' => ConstMessageFolder::Inbox,
            'Message.is_deleted' => 0,
            'Message.is_archived' => 0,
            'MessageContent.admin_suspend' => 0,
            'Message.property_user_status_id !=' => 0,
        );
        $conditions['OR']['Message.user_id'] = $user_id;
        $PropertyIds = $this->Message->Property->find('list', array(
            'conditions' => array(
                'Property.user_id' => $user_id,
                'Property.admin_suspend' => 0
            ) ,
            'recursive' => -1,
            'fields' => array(
                'Property.id'
            )
        ));
        if (!empty($PropertyIds)) {
            $conditions['OR']['Message.property_id'] = $PropertyIds;
        }
        if (!empty($user['User']['activity_message_id'])) {
            $conditions['Message.id >'] = $user['User']['activity_message_id'];
        }
        $notificationCount = $this->Message->find('count', array(
            'conditions' => $conditions,
            'recursive' => 0
        ));
        return $notificationCount;
    }
    function getUserInvitedFriendsRegisteredCount($id)
    {
        App::import('Model', 'Subscription');
        $this->Subscription = new Subscription();
        $count = $this->Subscription->find('count', array(
            'conditions' => array(
                'Subscription.invite_user_id' => $id,
                'Subscription.user_id !=' => '',
            ) ,
            'recursive' => -1
        ));
        return $count;
    }
    public function beforeLayout($layoutFile)
    {
        if ($this instanceof HtmlHelper && isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) {
            $url = Router::url(array(
                'controller' => 'high_performances',
                'action' => 'update_content',
                'ext' => 'css'
            ) , true);
            if (Configure::read('highperformance.pids') && $this->request->params['controller'] == 'properties' && in_array($this->request->params['action'], array(
                'index',
                'discover'
            ))) {
                $pids = implode(',', Configure::read('highperformance.pids'));
                Configure::write('highperformance.pids', '');
                echo $this->Html->css($url . '?pids=' . $pids, null, array(
                    'inline' => false,
                    'block' => 'highperformance'
                ));
            } elseif (Configure::read('highperformance.pids') && $this->request->params['controller'] == 'properties' && $this->request->params['action'] == 'view') {
                echo $this->Html->css($url . '?pids=' . Configure::read('highperformance.pids') . '&from=property_view', null, array(
                    'inline' => false,
                    'block' => 'highperformance'
                ));
            } elseif (Configure::read('highperformance.rids')) {
                if (is_array(Configure::read('highperformance.rids'))) {
                    $rids = implode(',', Configure::read('highperformance.rids'));
                } else {
                    $rids = Configure::read('highperformance.rids');
                }
                Configure::write('highperformance.rids', '');
                echo $this->Html->css($url . '?rids=' . $rids, null, array(
                    'inline' => false,
                    'block' => 'highperformance'
                ));
            } elseif (Configure::read('highperformance.uids')) {
                echo $this->Html->css($url . '?uids=' . Configure::read('highperformance.uids') , null, array(
                    'inline' => false,
                    'block' => 'highperformance'
                ));
            } elseif (!empty($_SESSION['Auth']['User']['id']) && $_SESSION['Auth']['User']['id'] == ConstUserIds::Admin && empty($this->request->params['prefix'])) {
                echo $this->Html->css($url . '?uids=' . $_SESSION['Auth']['User']['id'], null, array(
                    'inline' => false,
                    'block' => 'highperformance'
                ));
            }
            parent::beforeLayout($layoutFile);
        }
    }
    public function displayActivities($message)
    {
        $activity_messages = "";
        $properties_link = $this->link($message['Property']['title'], array(
            'controller' => 'properties',
            'action' => 'view',
            $message['Property']['slug'],
            'admin' => false
        ) , array(
            'class' => 'notification_link linkc',
            'title' => $message['Property']['title']
        ));
        $host_user_link = $this->link($message['Property']['User']['username'], array(
            'controller' => 'users',
            'action' => 'view',
            $message['Property']['User']['username'],
            'admin' => false
        ) , array(
            'class' => 'notification_link linkc',
            'title' => $message['Property']['User']['username']
        ));
        $travel_user_link = $this->link($message['PropertyUser']['User']['username'], array(
            'controller' => 'users',
            'action' => 'view',
            $message['PropertyUser']['User']['username'],
            'admin' => false
        ) , array(
            'class' => 'notification_link linkc',
            'title' => $message['PropertyUser']['User']['username']
        ));
        if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "You have booked for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . " has booked for your property " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $host_user_link . " property " . $properties_link . " has been booked by " . $travel_user_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "Your booking confirmed for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "You have been confirmed the " . $travel_user_link . "'s booking for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $host_user_link . " has confirmed " . $travel_user_link . "'s booking for " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::Rejected) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "Your booking has been rejected for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "You have been rejected the " . $travel_user_link . "'s booking for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $host_user_link . " has rejected " . $travel_user_link . "'s booking for " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::Canceled) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "You are canceled the booking for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . " canceled the booking for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . " has canceled the booking of " . $host_user_link . "'s " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::Arrived) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "You were arrived on your booking " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . " has arrived for your " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . " has arrived for " . $host_user_link . "'s " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforReview) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "You were checked out your booked " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . " has checked out for your " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . " has checked out booked for " . $host_user_link . "'s " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::PaymentCleared) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "Your booked amount has been released for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s booked amount has been released for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s booked amount has been released for " . $host_user_link . "'s " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::Completed) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "Your booking has closed for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s booking has closed for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s booking has closed for " . $host_user_link . "'s " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::Expired) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "Your booking has expired for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s booking has expired for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s booking has expired for " . $host_user_link . "'s " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::CanceledByAdmin) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "You booking has canceled by admin for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s booking has canceled by admin for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s booking has canceled by admin for" . $host_user_link . "'s " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::FromTravelerConversation) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "You have sent conversation for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s has sent conversation for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s has sent conversation to " . $host_user_link . " for " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::PrivateConversation) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "You have sent private conversation for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s has sent private conversation for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s has sent private conversation to " . $host_user_link . " for " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::NegotiateConversation) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "You have sent negotiation conversation for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s has sent negotiation conversation for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s has sent negotiation conversation to " . $host_user_link . " for " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::RequestNegotiation) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "You have request negotiation for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s has request negotiation for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s has request negotiation for " . $host_user_link . "'s " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::AdminDisputeConversation) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "Your booked dispute conversation has been added by admin for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s booked dispute conversation has been added by admin for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s booked dispute conversation has been added by admin for" . $host_user_link . "'s " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeAdminAction) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "Your booked dispute action has been taken by admin for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s booked dispute action has been taken by admin for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s booked dispute action has been taken by admin for" . $host_user_link . "'s " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::WorkReviewed || $message['Message']['property_user_status_id'] == ConstPropertyUserStatus::HostReviewed) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "Your booked has reviewed for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s booked has reviewed for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s booked has reviewed for" . $host_user_link . "'s " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::WorkDelivered) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "Your booked has reviewed for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s booked has reviewed for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s booked has reviewed for" . $host_user_link . "'s " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeClosed || $message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeClosedTemp) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "Your booked dispute closed for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s booked dispute closed for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s booked dispute closed for" . $host_user_link . "'s " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeConversation) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "Your booked dispute conversation has been added for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s booked dispute conversation has been added for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s booked dispute conversation has been added for" . $host_user_link . "'s " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeOpened) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "Your booked dispute raised for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s booked dispute raised for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s booked dispute raised for" . $host_user_link . "'s " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::SenderNotification) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "Your booked notification received for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s booked notification received for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s booked notification received for" . $host_user_link . "'s " . $properties_link;
            }
        } else if ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::SecurityDepositRefund) {
            if ($message['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = "Your booked has security deposit refund for " . $properties_link;
            } elseif ($message['Property']['user_id'] == $_SESSION['Auth']['User']['id']) {
                $activity_messages = $travel_user_link . "'s booking has security deposit refund for " . $properties_link;
            } elseif ($_SESSION['Auth']['User']['id'] == ConstUserIds::Admin) {
                $activity_messages = $travel_user_link . "'s booking has security deposit refund for " . $host_user_link . "'s " . $properties_link;
            }
        }
        return $activity_messages;
    }
}
