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
class UserNotificationsController extends AppController
{
    public $name = 'UserNotifications';
    public function edit($id = null)
    {
        $this->pageTitle = __l('Manage Email Settings');
        if (!empty($this->request->data)) {
            if (empty($this->request->data['User']['id'])) {
                $this->request->data['UserNotification']['user_id'] = $this->Auth->user('id');
            }
            $user_notifications = $this->UserNotification->find('first', array(
                'conditions' => array(
                    'UserNotification.user_id' => $this->request->data['UserNotification']['user_id']
                ) ,
                'recursive' => -1
            ));
            if (!empty($user_notifications)) {
                $this->request->data['UserNotification']['id'] = $user_notifications['UserNotification']['id'];
            }
            $this->request->data['UserNotification']['user_id'] = $this->Auth->user('id');
            if ($this->UserNotification->save($this->request->data)) {
                $this->Session->setFlash(__l('User Notification has been updated') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('User Notification could not be updated. Please try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->UserNotification->find('first', array(
                'conditions' => array(
                    'UserNotification.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            if (empty($this->request->data['UserNotification'])) {
                $this->request->data['UserNotification']['user_id'] = $this->Auth->user('id');
                $this->UserNotification->save($this->request->data['UserNotification']);
            }
        }
    }
}
?>