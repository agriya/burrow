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
class LaunchModesCronComponent extends Component
{
    public function daily() 
    {
        if(Configure::read('site.launch_mode') == 'Private Beta') {
			$last_sent_date = Configure::read('site.last_invited_date');
			$duration = Configure::read('site.duration_to_invite');
			switch ($duration) {
				case 'Daily':
					$diff = 1;
					break;

				case 'Weekly':
					$diff = 7;
					break;

				case 'Monthly':
					$diff = 30;
					break;
			}
			App::import('Model', 'LaunchModes.Subscription');
			$this->Subscription = new Subscription();
			$limit = Configure::read('site.no_of_users_to_invite_per_time');
			$subscribers = $this->Subscription->find('all', array(
				'conditions' => array(
					'Subscription.is_sent_private_beta_mail' => 0,
				) ,
				'order' => array(
					'Subscription.is_social_like' => 'desc',
					'Subscription.id' => 'asc'
				) ,
				'limit' => $limit,
				'recursive' => -1
			));
			if (!empty($subscribers)) {
				$ids = array();
				foreach($subscribers as $subscriber) {
					array_push($ids, $subscriber['Subscription']['id']);
					$emailFindReplace = array(
						'##INVITE_LINK##' => Router::url(array(
							'controller' => 'users',
							'action' => 'register',
							'type' => 'social',
							'admin' => false
						) , true) ,
						'##INVITE_CODE##' => $subscriber['Subscription']['invite_hash'],
					);
					App::import('Model', 'EmailTemplate');
					$this->EmailTemplate = new EmailTemplate();
					$email_template = $this->EmailTemplate->selectTemplate('Invite User');
					$this->Subscription->_sendEmail($email_template, $emailFindReplace, $subscriber['Subscription']['email']);
				}
				$this->Subscription->updateAll(array(
					'Subscription.is_sent_private_beta_mail' => 1
				) , array(
					'Subscription.id' => $ids
				));
				App::import('Model', 'Setting');
				$this->Setting = new Setting();
				$this->Setting->updateAll(array(
					'Setting.value' => date('Y-m-d')
				) , array(
					'Setting.name' => 'site.last_invited_date'
				));
			}
		}
    }
}
