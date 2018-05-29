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
class SocialMarketingEventHandler extends Object implements CakeEventListener
{
    /**
     * implementedEvents
     *
     * @return array
     */
    public function implementedEvents()
    {
        return array(
			'Controller.SocialMarketing.getShareUrl' => array(
                'callable' => 'getShareUrl',
            ) ,
			'Controller.SocialMarketing.redirectToShareUrl' => array(
                'callable' => 'redirectToShareUrl',
            ) ,
        );
    }
	public function getShareUrl($event)
	{
		$obj = $event->subject();
		$data = $event->data['data'];
		$publish_action = $event->data['publish_action'];
		if(isset($event->data['request'])){
			$event->data['social_url'] = Router::url(array(
				'controller' => 'social_marketings',
				'action' => 'publish_request',
				$data,
				'type' => 'facebook',
				'publish_action' => $publish_action,
				'admin' => false
			) , true);
		}else{
		$event->data['social_url'] = Router::url(array(
				'controller' => 'social_marketings',
				'action' => 'publish',
				$data,
				'type' => 'facebook',
				'publish_action' => $publish_action,
				'admin' => false
			) , true);
		}
	}
	public function redirectToShareUrl($event)
	{
		$obj = $event->subject();
		$data = $event->data['data'];
		$request = $event->data['request'];
		$publish_action = $event->data['publish_action'];
			if($request==1){
				$obj->redirect(array(
					'controller' => 'social_marketings',
					'action' => 'publish_request',
					$data,
					'type' => 'facebook',
					'publish_action' => $publish_action,
						'admin' => false
				));			
			}
			else{
				$obj->redirect(array(
					'controller' => 'social_marketings',
					'action' => 'publish',
					$data,
					'type' => 'facebook',
					'publish_action' => $publish_action,
					'admin' => false
				));
			}
	}	    
}
?>