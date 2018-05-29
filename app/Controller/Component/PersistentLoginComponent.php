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
class PersistentLoginComponent extends Component
{
    var $components = array(
        'Cookie'
    );
    public function _persistent_login_create_cookie($user, $pers_data = array()) 
    {
        $cookie_name = $this->_persistent_login_get_cookie_name();
        if (!empty($_COOKIE[$cookie_name])) {
            $cookie_val = $_COOKIE[$cookie_name];
        }
        App::import('Model', 'PersistentLogin');
        $this->PersistentLogin = new PersistentLogin();
        if (isset($cookie_val) && !isset($pers_data['pl_series'])) {
            list($user_id, $series, $token) = explode(':', $cookie_val);
            $this->PersistentLogin->deleteAll(array(
                'PersistentLogin.user_id' => $user_id,
                'PersistentLogin.series' => $series
            ));
        }
        $token = $this->get_token($pers_data); // Need to discuss
        $days = Configure::read('user.remember_me_maxlife');
        $expires = (!empty($pers_data['pl_expires']) ? $pers_data['pl_expires'] : (($days > 0) ? strtotime('Now') +$days*86400 : 0));
        $series = (!empty($pers_data['pl_series']) ? $pers_data['pl_series'] : $this->get_token($pers_data));
        $this->_persistent_login_setcookie($cookie_name, $user['User']['id'] . ':' . $series . ':' . $token, $expires > 0 ? $expires : 2147483647);
        if (!empty($_COOKIE[$cookie_name])) {
            $cookie_val = $_COOKIE[$cookie_name];
        }
        $data['PersistentLogin']['user_id'] = $user['User']['id'];
        $data['PersistentLogin']['series'] = $series;
        $data['PersistentLogin']['token'] = $token;
        $data['PersistentLogin']['expires'] = $expires;
        $data['PersistentLogin']['ip_id'] = $this->PersistentLogin->toSaveIp();
		$persistent_login_count = $this->PersistentLogin->find('count', array(
            'conditions' => array(
                'PersistentLogin.user_id' => $user['User']['id']
            ),
			'recursive' => -1
        ));
        if ($persistent_login_count < Configure::read('user.remember_me_maxlogins')) {
            $this->PersistentLogin->save($data);
        }
        return $cookie_name;
    }
    public function _persistent_login_get_cookie_name() 
    {
        $cookie_name = '';
        if (empty($cookie_name)) {
            $cookie_name = Configure::read('user.remember_me_cookie_prefix') . substr(session_name() , 4);
        }
        return $cookie_name;
    }
    public function _persistent_login_setcookie($name, $value, $expire = 0) 
    {
        setcookie($name, $value, $expire, '/');
    }
    public function get_token($data) 
    {
        $remember_hash = md5($data['User'][Configure::read('user.using_to_login') ] . $data['User']['password'] . Configure::read('Security.salt'));
        return $remember_hash;
    }
    public function _persistent_login_check() 
    {
        App::import('Model', 'PersistentLogin');
        $this->PersistentLogin = new PersistentLogin();
        $now = strtotime('now');
        $cookie_name = $this->_persistent_login_get_cookie_name();
        $cookie_val = $_COOKIE[$cookie_name];
        if (!empty($cookie_val) && empty($_SESSION['persistent_login_check'])) {
            $_SESSION['persistent_login_check'] = true;
            list($uid, $series, $token) = explode(':', $cookie_val);
            $persistentLogin = $this->PersistentLogin->find('first', array(
                'conditions' => array(
                    'PersistentLogin.user_id' => $uid,
                    'PersistentLogin.series' => $series,
                ) ,
                'recursive' => -1
            ));
            if (empty($persistentLogin)) {
                // $uid:$series is invalid
                return false;
            } else if ($persistentLogin['PersistentLogin']['expires'] > 0 && $persistentLogin['PersistentLogin']['expires'] < $now) {
                // $uid:$series has expired
                return false;
            }
            if ($persistentLogin['PersistentLogin']['token'] === $token) {
                $this->PersistentLogin->deleteAll(array(
                    'PersistentLogin.user_id' => $uid,
                    'PersistentLogin.series' => $series
                ));
                $user = $this->PersistentLogin->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $uid
                    ) ,
                    'recursive' => -1
                ));
                return $user;
            }
        }
    }
    function _persistent_login_match($path) 
    {
        $secure = Configure::read('user.remember_me_secure');
        $pages = Configure::read('user.remember_me_pages');
        $pages_array = explode(',', $pages);
        $is_secure = 0;
        if ($secure == 'Only the listed pages') {
            $is_secure = 1;
        }
        if (($is_secure && in_array($path, $pages_array)) || (!$is_secure && in_array($path, $pages_array))) {
            return false;
        } else {
            return true;
        }
    }
}
?>