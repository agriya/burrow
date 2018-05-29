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
class PropertiesCronComponent extends Component
{
    public function main()
    {
        App::import('Model', 'Properties.Property');
        $this->Property = new Property();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        $this->update_for_checkin();
        $this->update_for_checkout();
        $this->update_cleared();
        $this->auto_refund_security_deposit();
        $this->auto_expire();
        $this->auto_expire_payment_pending_booking();
        $this->Property->_updateCityPropertyCount();
        // @todo "Auto review"
    }
    public function daily()
    {
		$this->currency_conversion(Configure::read('site.is_auto_currency_updation'));
    }
    public function currency_conversion($is_update = 0)
    {
        if (!empty($is_update)) {
            App::import('Model', 'Currency');
            $this->Currency = new Currency();
            $this->Currency->rate_conversion();
        }
    }
    public function update_for_checkin($conditions = array())
    {
        $propertyUsers = $this->Property->PropertyUser->find('all', array(
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Confirmed,
                    ConstPropertyUserStatus::Arrived
                ) ,
                'PropertyUser.checkin <=' => date('Y-m-d'),
                'PropertyUser.is_auto_checkin' => 0,
            ) ,
            'recursive' => -1
        ));
		if (!empty($propertyUsers)) {
			foreach($propertyUsers as $propertyUser) {
				$this->Property->PropertyUser->updateStatus($propertyUser['PropertyUser']['id'], ConstPropertyUserStatus::Arrived);
			}
		}
    }
    public function update_cleared($conditions = array())
    {
        // @todo "Auto review" add condition CompletedAndClosedByAdmin
        $propertyUsers = $this->Property->PropertyUser->find('all', array(
            'conditions' => array(
                'PropertyUser.is_under_dispute' => 0,
                'PropertyUser.checkin <=' => date('Y-m-d', strtotime('now - ' . Configure::read('property.days_after_amount_withdraw') . ' days')) ,
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Arrived,
                    ConstPropertyUserStatus::Confirmed,
                    ConstPropertyUserStatus::WaitingforReview,
                    ConstPropertyUserStatus::Completed,
                ) ,
                'PropertyUser.is_payment_cleared' => 0,
            ) ,
            'recursive' => -1
        ));
		if (!empty($propertyUsers)) {
			foreach($propertyUsers as $propertyUser) {
				$this->Property->PropertyUser->updateStatus($propertyUser['PropertyUser']['id'], ConstPropertyUserStatus::PaymentCleared);
			}
		}
    }
    public function update_for_checkout($conditions = array())
    {
        $propertyUsers = $this->Property->PropertyUser->find('all', array(
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Arrived,
                    ConstPropertyUserStatus::PaymentCleared,
                    ConstPropertyUserStatus::WaitingforReview,
                ) ,
				'PropertyUser.checkout <=' => date('Y-m-d'),
                'PropertyUser.is_under_dispute' => 0,
                'PropertyUser.is_auto_checkout' => 0,
            ) ,
            'recursive' => -1
        ));
		if (!empty($propertyUsers)) {
			foreach($propertyUsers as $propertyUser) {
				$this->Property->PropertyUser->updateStatus($propertyUser['PropertyUser']['id'], ConstPropertyUserStatus::WaitingforReview);
			}
		}
    }
    public function auto_expire_payment_pending_booking()
    {
        $propertyUsers = $this->Property->PropertyUser->find('all', array(
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::PaymentPending,
                'PropertyUser.checkout <' => date('Y-m-d')
            ) ,
            'recursive' => -1,
        ));
		if (!empty($propertyUsers)) {
			foreach($propertyUsers as $propertyUser) {
				$_data = array();
				$_data['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
				$_data['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::Expired;
				$this->Property->PropertyUser->save($_data, false);
			}
		}
    }
    public function auto_expire()
    {
        $propertyUsers = $this->Property->PropertyUser->find('all', array(
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::WaitingforAcceptance,
                'PropertyUser.created <=' => date('Y-m-d H:i:s', strtotime('now - ' . Configure::read('property.auto_expire') . ' days'))
            ) ,
            'recursive' => -1
        ));
		if (!empty($propertyUsers)) {
			foreach($propertyUsers as $propertyUser) {
				$this->Property->PropertyUser->updateStatus($propertyUser['PropertyUser']['id'], ConstPropertyUserStatus::Expired);
			}
		}
    }
    public function auto_refund_security_deposit()
    {
        if (Configure::read('property.is_enable_security_deposit')) {
            $propertyInfo = $this->Property->PropertyUser->find('all', array(
                'conditions' => array(
                    'PropertyUser.property_user_status_id' => array(
                        ConstPropertyUserStatus::WaitingforReview,
                        ConstPropertyUserStatus::PaymentCleared,
                        ConstPropertyUserStatus::Completed
                    ) ,
                    'PropertyUser.is_under_dispute' => 0,
                    'PropertyUser.security_deposit_status' => 0,
                    'PropertyUser.checkout >=' => date('Y-m-d', strtotime('now - ' . Configure::read('property.auto_refund_security_deposit') . ' days'))
                ) ,
                'contain' => array(
                    'Property' => array(
                        'User'
                    ) ,
                    'User'
                ) ,
                'recursive' => 2,
            ));
            $cache_site_name = Cache::read('site_url_for_shell', 'long'); // For link generation during Cron run
            foreach($propertyInfo as $propertyUser) {
                $update_traveler_balance = $propertyUser['User']['available_wallet_amount']+$propertyUser['PropertyUser']['security_deposit']; // host security deposit amount
                if ($propertyUser['PropertyUser']['security_deposit_status'] == ConstSecurityDepositStatus::Blocked) {
                    $PropertyUserList['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
                    $PropertyUserList['PropertyUser']['security_deposit_status'] = ConstSecurityDepositStatus::RefundedToTraveler;
                    $this->Property->PropertyUser->save($PropertyUserList, false);
                }
                $this->Property->PropertyUser->User->updateAll(array(
                    'User.available_wallet_amount' => "'" . $update_traveler_balance . "'"
                ) , array(
                    'User.id' => $propertyUser['User']['id']
                ));
				$this->Property->PropertyUser->User->Transaction->log($propertyUser['PropertyUser']['id'], 'Properties.PropertyUser', $propertyUser['PropertyUser']['payment_gateway_id'], ConstTransactionTypes::SecurityDepositAutoRefunded, $propertyUser['PropertyUser']['security_deposit']);
                $mail_template = 'Auto refund notification';
                $template = $this->EmailTemplate->selectTemplate($mail_template);
                $emailFindReplace = array(
                    '##USERNAME##' => $propertyUser['User']['username'],
                    '##PROPERTY_NAME##' => "<a href=" . Router::url(array(
                        'controller' => 'properties',
                        'action' => 'view',
                        $propertyUser['Property']['slug'],
                        'admin' => false
                    ) , true) . ">" . $propertyUser['Property']['title'] . "</a>",
                    '##AMOUNT##' => Configure::read('site.currency') . $propertyUser['PropertyUser']['security_deposit'],
                    '##SITE_NAME##' => Configure::read('site.name') ,
                    '##SITE_URL##' => Router::url('/', true) ,
                    '##ORDERNO##' => $propertyUser['PropertyUser']['id'],
                    '##FROM_EMAIL##' => ($template['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $template['from'],
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
                $message = strtr($template['email_text_content'], $emailFindReplace);
                $subject = strtr($template['subject'], $emailFindReplace);
                $key = 0;
                $message_id = $this->Property->PropertyUser->User->Message->sendNotifications($propertyUser['User']['id'], $subject, $message, $propertyUser['PropertyUser']['id'], $is_review = 0, $propertyUser['Property']['id'], ConstPropertyUserStatus::SecurityDepositRefund);
            }
        }
    }
}
