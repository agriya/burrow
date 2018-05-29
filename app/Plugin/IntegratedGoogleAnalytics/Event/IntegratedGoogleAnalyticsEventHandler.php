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
class IntegratedGoogleAnalyticsEventHandler extends Object implements CakeEventListener
{
    /**
     * implementedEvents
     *
     * @return array
     */
    public function implementedEvents()
    {
        return array(
            'Controller.IntegratedGoogleAnalytics.trackEvent' => array(
                'callable' => 'onTrackEvent',
            ) ,
           'Controller.IntegratedGoogleAnalytics.trackEcommerce' => array(
                'callable' => 'onTrackEcommerce',
            ) ,
           'Model.IntegratedGoogleAnalytics.trackEvent' => array(
                'callable' => 'onTrackEvent',
            ) ,
           'Model.IntegratedGoogleAnalytics.trackEcommerce' => array(
                'callable' => 'onTrackEcommerce',
            ) ,
           'View.IntegratedGoogleAnalytics.pushScript' => array(
                'callable' => 'pushScript',
            ) ,
        );
    }
    public function onTrackEvent($event)
    {
		if (empty($_SESSION['_trackEvent'])) {
			$_SESSION['_trackEvent'] = array();
		}
		array_push($_SESSION['_trackEvent'], $event->data);
    }
    public function onTrackEcommerce($event)
    {
		if (empty($_SESSION['_trackEcommerce'])) {
			$_SESSION['_trackEcommerce'] = array();
		}
		array_push($_SESSION['_trackEcommerce'], $event->data);
    }
    public function pushScript($event)
    {
        $obj = $event->subject();
		$return = '';
		if (!empty($_SESSION['_trackEvent'])) {
			foreach($_SESSION['_trackEvent'] as $trackEvent) {
				$trackEvent['_trackEvent']['category'] = !empty($trackEvent['_trackEvent']['category']) ? $trackEvent['_trackEvent']['category'] : '';
				$trackEvent['_trackEvent']['action'] = !empty($trackEvent['_trackEvent']['action']) ? $trackEvent['_trackEvent']['action'] : '';
				$trackEvent['_trackEvent']['label'] = !empty($trackEvent['_trackEvent']['label']) ? $trackEvent['_trackEvent']['label'] : '';
				$trackEvent['_trackEvent']['value'] = !empty($trackEvent['_trackEvent']['value']) ? $trackEvent['_trackEvent']['value'] : '';
				$return .= "<script>";
				if (!empty($trackEvent['_setCustomVar'])) {
					foreach($trackEvent['_setCustomVar'] as $customVar => $customValue) {
						$return .= "_gaq.push(['_setCustomVar', " . constant(sprintf('ConstCustomVariable::%s', $customVar)) . ", '" . $customVar . "', '" . $customValue . "', 2]);";
					}
				}
				$return .= "_gaq.push(['_trackEvent', '" . $trackEvent['_trackEvent']['category'] . "', '" . $trackEvent['_trackEvent']['action'] . "', '" . $obj->Html->cText($trackEvent['_trackEvent']['label']). "', " . $trackEvent['_trackEvent']['value'] . "]);";
				$return .= "</script>";
			}
			unset($_SESSION['_trackEvent']);
		}
		if (!empty($_SESSION['_trackEcommerce'])) {
			foreach($_SESSION['_trackEcommerce'] as $trackEcommerce) {
				$return .= "<script>";
				if (!empty($trackEcommerce['_setCustomVar'])) {
					foreach($trackEcommerce['_setCustomVar'] as $customVar => $customValue) {
						$return .= "_gaq.push(['_setCustomVar', " . constant(sprintf('ConstCustomVariable::%s', $customVar)) . ", '" . $customVar . "', '" . $customValue . "', 2]);";
					}
				}
				if (!empty($trackEcommerce['_addTrans'])) {
					$return .= "_gaq.push(['_addTrans', '" . $trackEcommerce['_addTrans']['order_id'] . "', '" . $obj->Html->cText($trackEcommerce['_addTrans']['name']) . "', ' " . $trackEcommerce['_addTrans']['total'] . "', '', '', '', '', '']);";
				}
				if (!empty($trackEcommerce['_addItem'])) {
				$trackEcommerce['_addItem']['category'] = (!empty($trackEcommerce['_addItem']['category'])) ? $trackEcommerce['_addItem']['category'] : '';
					$return .= "_gaq.push(['_addItem', '" . $trackEcommerce['_addItem']['order_id'] . "' , '" . $trackEcommerce['_addItem']['sku'] . "', '" . $obj->Html->cText($trackEcommerce['_addItem']['name'], false) . "', '" . $trackEcommerce['_addItem']['category'] . "', '" . $trackEcommerce['_addItem']['unit_price'] . "', 1]);";
				}
				$return .= "_gaq.push(['_trackTrans']);";
				$return .= "</script>";
			}
			unset($_SESSION['_trackEcommerce']);
		}
        $event->data['content'] = $return;
    }
	
}
?>