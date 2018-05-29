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
class Payment extends AppModel
{
    var $useTable = false;
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'negotiation_discount' => array(
                'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Required') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'is_agree_terms_conditions' => array(
                'rule' => array(
                    'equalTo',
                    '1'
                ) ,
                'message' => __l('You must agree to the terms and conditions')
            ) ,
        );
    }
    public function processUserSignupPayment($user_id, $payment_gateway_id = null)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id = ' => $user_id,
            ) ,
            'recursive' => -1,
        ));
        if (empty($user['User']['is_paid'])) {
            $_Data['User']['id'] = $user['User']['id'];
            $_Data['User']['is_paid'] = 1;
            $_Data['User']['is_active'] = 1;
            if (Configure::read('user.is_email_verification_for_register') && empty($user['User']['is_openid_register']) && empty($user['User']['is_facebook_register']) && empty($user['User']['is_twitter_register']) && empty($user['User']['is_google_register']) && empty($user['User']['is_yahoo_register']) && empty($user['User']['is_linkedin_register'])) {
                if (empty($user['User']['is_active'])) {
                    $_Data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;
                }
            }
            $this->User->save($_Data);
            App::import('Model', 'Transaction');
            $this->Transaction = new Transaction();
            $this->Transaction->log($user_id, 'User', $payment_gateway_id, ConstTransactionTypes::SignupFee);
            return true;
        }
        return false;
    }
    public function _sendActivationMail($user_email, $user_id, $hash)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.email' => $user_email
            ) ,
            'recursive' => -1
        ));
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
            '##ACTIVATION_URL##' => Router::url(array(
                'controller' => 'users',
                'action' => 'activation',
                $user_id,
                $hash
            ) , true) ,
        );
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $template = $this->EmailTemplate->selectTemplate('Activation Request');
        $this->_sendEmail($template, $emailFindReplace, $user_email);
    }
}
?>