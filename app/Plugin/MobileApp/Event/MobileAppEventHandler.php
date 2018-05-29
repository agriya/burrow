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
class MobileAppEventHandler extends Object implements CakeEventListener
{
    /**
     * implementedEvents
     *
     * @return array
     */
    public function implementedEvents()
    {
        return array(
            'Controller.Property.handleApp' => array(
                'callable' => '_handleApp',
            ) ,
            'Controller.Property.listing' => array(
                'callable' => 'onPropertyListing',
            ) ,
            'Controller.Property.view' => array(
                'callable' => 'onPropertyView',
            ) ,
            'Controller.PropertyUser.listing' => array(
                'callable' => 'onPropertyUserListing',
            ) ,
            'Controller.PropertyUser.UpdateOrder' => array(
                'callable' => 'onUpdateOrder',
            ) ,
			'Controller.User.validate_user' => array(
                'callable' => 'validate_user',
            ) ,
            'Controller.UserPaymentProfile.listing' => array(
                'callable' => 'onUserPaymentProfileListing',
            ) ,
        );
    }
	public function _handleApp($event)
	{
		$controller = $event->subject();
		if (Configure::read('site.iphone_app_key') != $_GET['key']) {
			$controller->set('iphone_response', array(
				'status' => 2,
				'message' => __l('Invalid App key')
			));
		}
        $controller->Security->validatePost = false;
        $controller->loadModel('User');
        if ((!empty($_POST['data']) || (!empty($_GET['data']))) && in_array($controller->request->params['action'], array(
            'validate_user'
        ))) {
            if (!empty($_GET['data'])) {
                $_POST['data'] = $_GET['data'];
            }
            if (!empty($_POST['data'])) {
                foreach($_POST['data'] as $controller => $values) {
                    $controller->request->data[Inflector::camelize(Inflector::singularize($controller)) ] = $values;
                }
            }
        }
		if (!empty($_GET['username']) && $controller->request->params['action'] != 'validate_user') {
			
			$user = $controller->User->find('first', array(
				'conditions' => array(
					'User.mobile_app_hash' => $_GET['passwd']
				) ,
				'fields' => array(
					'User.password',
				) ,
				'recursive' => -1
			));
			if (empty($user)) {
				$controller->set('iphone_response', array(
					'status' => 1,
					'message' => sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login'))
				));
			} else {
				//need to fix
				$controller->request->data['User'][Configure::read('user.using_to_login') ] = trim($_GET['username']);
				$controller->request->data['User']['password'] = $user['User']['password'];
				if (!$controller->Auth->login()) {				
					$controller->set('iphone_response', array(
						'status' => 1,
						'message' => sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login'))
					));
				}
				if ($controller->Auth->user('id') && !empty($_GET['latitude']) && !empty($_GET['longtitude'])) {
					$controller->update_iphone_user($_GET['latitude'], $_GET['longtitude'], $controller->Auth->user('id'));
				}
			}
		}
    }
    function update_iphone_user($latitude, $longitude, $user_id)
    {
        App::uses('User', 'Model');
		$obj->User = new User();
        $obj->User->updateAll(array(
            'User.iphone_latitude' => $latitude,
            'User.iphone_longitude' => $longitude,
            'User.iphone_last_access' => "'" . date("Y-m-d H:i:s") . "'"
        ) , array(
            'User.id' => $user_id
        ));

    }
    public function onPropertyListing($event)
    {
        $obj = $event->subject();
        $page = $event->data['page'];	
        $properties = $obj->paginate();
		$total_properties = $obj->Property->find('count', array(
            'conditions' => $obj->paginate['conditions'],
            'recursive' => 0
        ));		
		for ($i = 0; $i < count($properties); $i++) {
			$properties[$i]['TmpUser'] = $properties[$i]['User'];
			unset($properties[$i]['User']);
			$properties[$i]['User'] = array(
				'username' => $properties[$i]['TmpUser']['username'],
				'iphone_big_thumb' => getImageUrl('UserAvatar', (!empty($properties[$i]['TmpUser']['attachment_id'])) ? array('id' => $properties[$i]['TmpUser']['attachment_id']) : '', array(
										'dimension' => 'iphone_big_thumb',
										'alt' => sprintf('[Image: %s]', $properties[$i]['TmpUser']['username']) ,
										'title' => $properties[$i]['TmpUser']['username'],
										'full_url' => true,					
									)),				
				'iphone_small_thumb' => getImageUrl('UserAvatar', (!empty($properties[$i]['TmpUser']['attachment_id'])) ? array('id' => $properties[$i]['TmpUser']['attachment_id']) : '', array(
										'dimension' => 'iphone_small_thumb',
										'alt' => sprintf('[Image: %s]', $properties[$i]['TmpUser']['username']) ,
										'title' => $properties[$i]['TmpUser']['username'],
										'full_url' => true,					
									)),				
			);
			$properties[$i]['User']['UserComment'] = array();
			// comments
			foreach($properties[$i]['TmpUser']['UserComment'] as $key => $value){
				$properties[$i]['User']['UserComment'][] = array(
						'id' => $value['id'],
						'created' => $value['created'],
						'posted_user_id' => $value['posted_user_id'],
						'comment' => $value['comment'],
						'username' => $value['PostedUser']['username'],
						'iphone_big_thumb' => getImageUrl('UserAvatar', (!empty($value['PostedUser']['attachment_id'])) ? array('id' => $value['PostedUser']['attachment_id']) : '', array(
										'dimension' => 'iphone_big_thumb',
										'alt' => sprintf('[Image: %s]', $value['PostedUser']['username']) ,
										'title' => $value['PostedUser']['username'],
										'full_url' => true,					
									)),
						'iphone_small_thumb' => getImageUrl('UserAvatar', (!empty($value['PostedUser']['attachment_id'])) ? array('id' => $value['PostedUser']['attachment_id']) : '', array(
										'dimension' => 'iphone_small_thumb',
										'alt' => sprintf('[Image: %s]', $value['PostedUser']['username']) ,
										'title' => $value['PostedUser']['username'],
										'full_url' => true,					
									))
					);
			}
			unset($properties[$i]['TmpUser']);
			// PropertyFeedback
			if(!empty($properties[$i]['PropertyFeedback'])){
				$properties[$i]['TmpFeedBack'] = $properties[$i]['PropertyFeedback'];
				$properties[$i]['PropertyFeedback'] = array();
				foreach($properties[$i]['TmpFeedBack'] as $key => $value){
					$properties[$i]['PropertyFeedback'][] = array(
							'feedback' => $value['feedback'],
							'created' => $value['created'],
							'is_satisfied' => $value['is_satisfied'],
							'video_url' => $value['video_url'],
							'username' => $value['PropertyUser']['User']['username'],
							'iphone_big_thumb' => getImageUrl('UserAvatar', (!empty($value['PostedUser']['attachment_id'])) ? array('id' => $value['PostedUser']['attachment_id']) : '', array(
											'dimension' => 'iphone_big_thumb',
											'alt' => sprintf('[Image: %s]', $value['PropertyUser']['User']['username']) ,
											'title' => $value['PropertyUser']['User']['username'],
											'full_url' => true,					
										)),
							'iphone_small_thumb' => getImageUrl('UserAvatar', (!empty($value['PropertyUser']['User']['attachment_id'])) ? array('id' => $value['PropertyUser']['User']['attachment_id']) : '', array(
											'dimension' => 'iphone_small_thumb',
											'alt' => sprintf('[Image: %s]', $value['PropertyUser']['User']['username']) ,
											'title' => $value['PropertyUser']['User']['username'],
											'full_url' => true,					
										))
						);
				}			
				unset($properties[$i]['TmpFeedBack']);
			}
			//views
			$properties[$i]['Property']['views'] = $properties[$i]['Property']['property_view_count'];
			// properties attachments
			foreach($properties[$i]['Attachment'] as $key => $attachment){
				$this->saveiPhoneAppThumb($attachment);
				$image_options = array(
					'dimension' => 'iphone_big_thumb',
					'class' => '',
					'alt' => $properties[$i]['Property']['title'],
					'title' => $properties[$i]['Property']['title'],
					'type' => 'jpg',
					'full_url' => true
				);
				$iphone_big_thumb = getImageUrl('Property', $attachment, $image_options);
				$properties[$i]['Property']['iphone_big_thumb'][] = $iphone_big_thumb;
				$image_options = array(
					'dimension' => 'iphone_small_thumb',
					'class' => '',
					'alt' => $properties[$i]['Property']['title'],
					'title' => $properties[$i]['Property']['title'],
					'type' => 'jpg',
					'full_url' => true
				);
				$iphone_small_thumb = getImageUrl('Property', $properties[$i]['Attachment'][0], $image_options);
				$properties[$i]['Property']['iphone_small_thumb'][] = $iphone_small_thumb;
			}
			unset($properties[$i]['Attachment']);
		}
		$response = array(
			'_metadata' => array(
					'total_properties' => $total_properties,
					'total_page' => ceil($total_properties/20),
					'current_page' => !empty($obj->request->params['named']['page']) ? $obj->request->params['named']['page'] : 1
				),
			'data' => $properties
		);
        $obj->view = 'Json';
		$obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $response : $obj->viewVars['iphone_response']);
    }
    public function onPropertyView($event)
    {
        $obj = $event->subject();
        $property = $event->data['data']['property'];
        $this->saveiPhoneAppThumb($property['Attachment']);
		$image_options = array(
			'dimension' => 'iphone_big_thumb',
			'class' => '',
			'alt' => $property['Property']['title'],
			'title' => $property['Property']['title'],
			'type' => 'jpg',
			'full_url' => true
		);
		$iphone_big_thumb = getImageUrl('Property', $property['Attachment'][0], $image_options);
		$property['Property']['iphone_big_thumb'] = $iphone_big_thumb;
		$image_options = array(
			'dimension' => 'iphone_small_thumb',
			'class' => '',
			'alt' => $property['Property']['title'],
			'title' => $property['Property']['title'],
			'type' => 'jpg',
			'full_url' => true
		);
		$iphone_small_thumb = getImageUrl('Property', $property['Attachment'][0], $image_options);
		$property['Property']['iphone_small_thumb'] = $iphone_small_thumb;
		$obj->view = 'Json';
		$obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $property : $obj->viewVars['iphone_response']);
    }
	public function onPropertyUserListing($event)
    {
        $obj = $event->subject();
        $response = $event->data['data'];
        $propertyUsers = $obj->paginate();
		$total_properties = $obj->PropertyUser->find('count', array(
            'conditions' => $obj->paginate['conditions'],
            'recursive' => 0
        ));
		for ($i = 0; $i < count($propertyUsers); $i++) {
			$this->saveiPhoneAppThumb($propertyUsers[$i]['Property']['Attachment']);
			$image_options = array(
				'dimension' => 'iphone_big_thumb',
				'class' => '',
				'alt' => $propertyUsers[$i]['Property']['title'],
				'title' => $propertyUsers[$i]['Property']['title'],
				'type' => 'jpg',
				'full_url' => true
			);
			$iphone_big_thumb = getImageUrl('Property', $propertyUsers[$i]['Property']['Attachment'][0], $image_options);
			$propertyUsers[$i]['Property']['iphone_big_thumb'] = $iphone_big_thumb;
			$image_options = array(
				'dimension' => 'iphone_small_thumb',
				'class' => '',
				'alt' => $propertyUsers[$i]['Property']['title'],
				'title' => $propertyUsers[$i]['Property']['title'],
				'type' => 'jpg',
				'full_url' => true
			);
			$iphone_small_thumb = getImageUrl('Property', $propertyUsers[$i]['Property']['Attachment'][0], $image_options);
			$propertyUsers[$i]['Property']['iphone_small_thumb'] = $iphone_small_thumb;
			$host_gross = $propertyUsers[$i]['PropertyUser']['price']+$propertyUsers[$i]['PropertyUser']['traveler_service_amount'];
			$propertyUsers[$i]['PropertyUser']['gross'] = $host_gross;
			$days = getCheckinCheckoutDiff($propertyUsers[$i]['PropertyUser']['checkin'], getCheckoutDate($propertyUsers[$i]['PropertyUser']['checkout']));
			$propertyUsers[$i]['PropertyUser']['days'] = $days;
			$propertyUsers[$i]['PropertyUser']['gross'] = $host_gross;
			$propertyUsers[$i]['Property']['iphone_small_thumb'] = $iphone_small_thumb;
			$propertyUsers[$i]['Property']['User']['UserAvatar'][0] = !empty($propertyUsers[$i]['Property']['User']['UserAvatar'][0]) ? $propertyUsers[$i]['Property']['User']['UserAvatar'][0] : array();
			$image_options = array(
				'dimension' => 'iphone_small_thumb',
				'class' => '',
				'alt' => $propertyUsers[$i]['Property']['User']['username'],
				'title' => $propertyUsers[$i]['Property']['User']['username'],
				'type' => 'jpg',
				'full_url' => true
			);
			$iphone_small_thumb = getImageUrl('UserAvatar', $propertyUsers[$i]['Property']['User']['UserAvatar'][0], $image_options);
			$propertyUsers[$i]['Property']['User']['iphone_small_thumb'] = $iphone_small_thumb;
			$propertyUsers[$i]['Property']['total_page'] = ceil($total_properties/20);
			$propertyUsers[$i]['Property']['current_page'] = !empty($obj->request->params['named']['page']) ? $obj->request->params['named']['page'] : 1;
		}
		$obj->view = 'Json';
		$obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $propertyUsers : $obj->viewVars['iphone_response']);
    }
	
    public function validate_user($event)
    {
        $obj = $event->subject();
        if ((Configure::read('user.using_to_login') == 'email') && isset($obj->request->data['User']['username'])) {
            $obj->request->data['User']['email'] = $obj->request->data['User']['username'];
            unset($obj->request->data['User']['username']);
        }
        $obj->request->data['User'][Configure::read('user.using_to_login') ] = trim($obj->request->data['User'][Configure::read('user.using_to_login') ]);
		if (!empty($obj->request->data['User'][Configure::read('user.using_to_login')])) {
			$user = $obj->User->find('first', array(
				'conditions' => array(
					'User.username' => $obj->request->data['User'][Configure::read('user.using_to_login')]
				) ,
				'recursive' => -1
			));
	        $obj->request->data['User']['password'] = crypt($obj->request->data['User']['password'], $user['User']['password']);
		}
        if ($obj->Auth->login()) {
            $mobile_app_hash = md5($obj->_unum() . $obj->request->data['User'][Configure::read('user.using_to_login') ] . $obj->request->data['User']['password'] . Configure::read('Security.salt'));
            $obj->User->updateAll(array(
                'User.mobile_app_hash' => '\'' . $mobile_app_hash . '\'',
                'User.mobile_app_time_modified' => '\'' . date('Y-m-d h:i:s') . '\'',
            ) , array(
                'User.id' => $obj->Auth->user('id')
            ));
            if (!empty($obj->request->data['User']['devicetoken'])) {
                $obj->User->ApnsDevice->findOrSave_apns_device($obj->Auth->user('id') , $obj->request->data['User']);
            }
            if (!empty($_GET['latitude']) && !empty($_GET['longtitude'])) {
                $this->update_iphone_user($_GET['latitude'], $_GET['longtitude'], $obj->Auth->user('id'));
            }
            $resonse = array(
                'status' => 0,
                'message' => __l('Success') ,
                'hash_token' => $mobile_app_hash,
                'username' => $obj->request->data['User'][Configure::read('user.using_to_login') ]
            );
        } else {
            $resonse = array(
                'status' => 1,
                'message' => sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login'))
            );
        }
        if ($obj->RequestHandler->prefers('json')) {
            $obj->view = 'Json';
            $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $resonse : $obj->viewVars['iphone_response']);
        }
    }
	public function onUpdateOrder($event)
    {
        $obj = $event->subject();
        $response = $event->data;
		$response['results'] = $response['results']; // succcess response
		$obj->view = 'Json';
		$obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $response : $obj->viewVars['iphone_response']);
    }
    public function onUserPaymentProfileListing($event)
    {
        $obj = $event->subject();
        $response = $event->data['data'];
		$obj->view = 'Json';
        $obj->set('json', (empty($obj->viewVars['iphone_response'])) ? $obj->paginate() : $obj->viewVars['iphone_response']);
    }
	public function saveiPhoneAppThumb($attachments, $model = 'Property')
    {
        $options[] = array(
            'dimension' => 'iphone_big_thumb',
            'class' => '',
            'alt' => '',
            'title' => '',
            'type' => 'jpg',
			'full_url' => true
        );
        $options[] = array(
            'dimension' => 'iphone_small_thumb',
            'class' => '',
            'alt' => '',
            'title' => '',
            'type' => 'jpg',
			'full_url' => true
        );
        $attachment = $attachments;
        foreach($options as $option) {
			if(!empty($attachment['id'])) {
				$destination = APP . 'webroot' . DS . 'img' . DS . $option['dimension'] . DS . $model . DS . $attachment['id'] . '.' . md5(Configure::read('Security.salt') . $model . $attachment['id'] . $option['type'] . $option['dimension'] . Configure::read('site.name')) . '.' . $option['type'];
				if (!file_exists($destination) && !empty($attachment['id'])) {
					$url = getImageUrl($model, $attachment, $option);
					getimagesize($url);
				}
			}
        }
    }
}
?>