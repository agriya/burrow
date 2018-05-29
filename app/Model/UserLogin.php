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
class UserLogin extends AppModel
{
    public $name = 'UserLogin';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'Ip' => array(
            'className' => 'Ip',
            'foreignKey' => 'user_login_ip_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
    public function insertUserLogin($user_id)
    {
        $this->data['UserLogin']['user_id'] = $user_id;
        $this->data['UserLogin']['user_login_ip_id'] = $this->toSaveIp();
        $this->data['UserLogin']['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $this->save($this->data);
        if (!empty($_COOKIE['PHPSESSID'])) {
            $hashed_val = md5($_SESSION['Auth']['User']['id'] . session_id() . PERMANENT_CACHE_GZIP_SALT);
            $hashed_val = substr($hashed_val, 0, 7);
            $form_cookie = $_SESSION['Auth']['User']['id'] . '|' . $hashed_val;
            setcookie('_gz', $form_cookie, time() + 60 * 60 * 24, '/');
			setcookie('il', '1', time() + 3600, '/');
			if (!empty($_SESSION['Auth']['User']['is_facebook_friends_fetched']) && !empty($_SESSION['Auth']['User']['is_show_facebook_friends']) && (strtotime($_SESSION['Auth']['User']['last_facebook_friend_fetched_date']) <= strtotime('now -' . Configure::read('user.days_after_fetch_facebook_friends') . ' days'))) {
            $oldFacebookFriends = $this->User->UserFacebookFriend->find('list', array(
                'conditions' => array(
                    'UserFacebookFriend.user_id' => $_SESSION['Auth']['User']['id']
                ) ,
                'fields' => array(
                    'UserFacebookFriend.facebook_friend_id',
                    'UserFacebookFriend.facebook_friend_name',
                ) ,
                'recursive' => -1
            ));
            
			App::uses('HttpSocket', 'Network/Http');
            $HttpSocket = new HttpSocket();
            $friends = $HttpSocket->get('https://graph.facebook.com/me/friends?access_token=' . $_SESSION['Auth']['User']['facebook_access_token']);
            $friends = json_decode($friends->body);
            if (!empty($friends->data)) {
                foreach($friends->data as $friend) {
                    $currentFacebookFriends[$friend->id] = $friend->name;
                }
                $newFacebookFriends = array_diff_key($currentFacebookFriends, $oldFacebookFriends);
                if (!empty($newFacebookFriends)) {
                    foreach($newFacebookFriends as $newFacebookFriendId => $newFacebookFriendName) {
                        $_data['UserFacebookFriend']['user_id'] = $_SESSION['Auth']['User']['id'];
                        $_data['UserFacebookFriend']['facebook_friend_name'] = $newFacebookFriendName;
                        $_data['UserFacebookFriend']['facebook_friend_id'] = $newFacebookFriendId;
                        $this->User->UserFacebookFriend->create();
                        $this->User->UserFacebookFriend->save($_data['UserFacebookFriend']);
                    }
                    $this->User->updateAll(array(
                        'User.last_facebook_friend_fetched_date' => "'" . date('Y-m-d') . "'",
                        'User.user_facebook_friend_count' => 'User.user_facebook_friend_count + ' . count($newFacebookFriends) ,
                    ) , array(
                        'User.id' => $_SESSION['Auth']['User']['id']
                    ));
                }
            }
			
        }		
        }
		if (!empty($_SESSION['order_redirect_url'])) {
			$order_redirect_url = $_SESSION['order_redirect_url'];
			unset($_SESSION['order_redirect_url']);
			header('Location: ' . $order_redirect_url);
			exit;
		}
		
    }
    public function afterSave($created)
    {
        $this->User->updateAll(array(
            'User.last_login_ip_id' => '\'' . $this->toSaveIp() . '\'',
            'User.last_logged_in_time' => '\'' . date('Y-m-d H:i:s') . '\'',
        ) , array(
            'User.id' => $_SESSION['Auth']['User']['id']
        ));
		return true;
    }	
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
		$this->_permanentCacheAssociations = array(
			'Chart',
		);
        $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete')
        );
    }
}
?>