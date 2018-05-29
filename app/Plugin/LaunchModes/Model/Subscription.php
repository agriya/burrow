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
class Subscription extends AppModel
{
    public $name = 'Subscription';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
	public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
		'InviteUser' => array(
            'className' => 'User',
            'foreignKey' => 'invite_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
		'Ip' => array(
			'className' => 'Ip',
			'foreignKey' => 'ip_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		) ,
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
		$this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete')
        );
        $this->validate = array(
            'email' => array(
             'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                ),
                'rule2' => array(
                    'rule' => 'email',
                    'message' => __l('Must be a valid email')
                ) ,
                'rule3' => array(
                    'rule' => 'isUnique',
                    'message' => __l('Email address already exists')
                ),
				'rule4' => array(
                    'rule' => array(
                        'alreadyEmailExist',
                        'email',
                    ) ,
                    'message' => __l('Email address already registered to the site')
                )
            ),
			'invite_emails' => array(
				'rule1' => array(
					'rule' => 'notempty',
					'message' => __l('Required')
				),
			),
			'invite_hash' => array(
				'rule1' => array(
					'rule' => 'notempty',
					'message' => __l('Required')
				),
			)
        );
    }
	function alreadyEmailExist($email)
    {
		App::import('model','User');
		$user = new User();
		$email_count=$user->find('count', array(
        	'conditions' => array(
				'User.email' => $email
			),
			'recursive' => -1,
    	));
		if($email_count > 0){
			return false;
		} else {
	 		return true;
		}
	}

}
?>