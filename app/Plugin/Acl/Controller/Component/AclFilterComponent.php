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
class AclFilterComponent extends Component
{
    var $components = array(
        'PersistentLogin',
        'Cookie'
    );
    /**
     * @param object $controller controller
     * @param array  $settings   settings
     */
    public function initialize(Controller $controller, $settings = array())
    {
        $this->controller = $controller;
    }
    /**
     * _checkAuth
     *
     * @return void
     */
    public function _checkAuth()
    {
        $this->controller->Auth->autoRedirect = false;
        $this->controller->Auth->authenticate = array(
            'Form' => array(
				'fields' => array(
		            'username' => Configure::read('user.using_to_login') ,
					'password' => 'password'
				),
                'scope' => array(
                    'User.is_active' => 1,
                    'User.is_email_confirmed' => 1
                )
            )
        );
        $this->controller->Auth->loginError = sprintf(__l('Sorry, login failed.  Either your %s or password are incorrect or admin deactivated your account.') , Configure::read('user.using_to_login'));
        $exception_array = Configure::read('site.exception_array');
        $cur_page = $this->controller->request->params['controller'] . '/' . $this->controller->request->params['action'];
        $cookie_name = $this->PersistentLogin->_persistent_login_get_cookie_name();
        if (!$this->controller->Auth->user('id') && !empty($_COOKIE[$cookie_name])) {
            $return = $this->PersistentLogin->_persistent_login_check();
            App::uses('User', 'Model');
            $user_model_obj = new User();
            if ($return and $this->PersistentLogin->_persistent_login_match($cur_page)) {
                $this->controller->request->data['User']['email'] = $return['User']['email'];
                $this->controller->request->data['User']['username'] = $return['User']['username'];
                $this->controller->request->data['User']['password'] = $return['User']['password'];
                // auto login if cookie is present
                if ($this->controller->Auth->login()) {
                    $user_model_obj->UserLogin->insertUserLogin($return['User']['id']);
                    $this->controller->redirect(Router::url('/', true) . $this->controller->request->url);
                }
            }
        }
        if (!in_array($cur_page, $exception_array) && $this->controller->request->params['action'] != 'flashupload' && $this->controller->request->params['controller'] != 'install') {
            // ACL Check For User
            if ($this->controller->Auth->user('id') && $this->controller->Auth->user('role_id') != ConstUserTypes::Admin) {
                if (empty($_SESSION['acl.user_id'])) {
                    $this->controller->loadModel('Acl.AclLinksRole');
                    $aclLinks = $this->controller->AclLinksRole->find('all', array(
                        'conditions' => array(
                            'AclLinksRole.role_id' => $this->controller->Auth->user('role_id')
                        ) ,
                        'contain' => array(
                            'AclLink' => array(
                                'fields' => array(
                                    'AclLink.id',
                                    'AclLink.controller',
                                    'AclLink.action',
                                    'AclLink.named_key',
                                    'AclLink.named_value',
                                    'AclLink.pass_value'
                                )
                            )
                        ) ,
                        'recursive' => 0
                    ));
                    foreach($aclLinks as $aclLink) {
                        $config_name = (!empty($aclLink['AclLink']['controller'])) ? $aclLink['AclLink']['controller'] : '';
                        $config_name.= (!empty($aclLink['AclLink']['action'])) ? '_' . $aclLink['AclLink']['action'] : '';
                        $config_name.= (!empty($aclLink['AclLink']['named_key'])) ? '_' . $aclLink['AclLink']['named_key'] : '';
                        $config_name.= (!empty($aclLink['AclLink']['named_value'])) ? '_' . $aclLink['AclLink']['named_value'] : '';
                        $config_name.= (!empty($aclLink['AclLink']['pass_value'])) ? '_' . $aclLink['AclLink']['pass_value'] : '';
                        $_SESSION['acl.' . $config_name] = $aclLink['AclLinksRole']['acl_link_status_id'];
                        $_SESSION['acl.user_id'] = $this->controller->Auth->user('id');
                    }
                    unset($aclLinks);
                }
                $skip = array_flip(array(
                    'page',
                    'limit',
                    'order',
                    'sort',
                    'direction',
                    'return'
                ));
                $is_allow_user = '';
                if (!empty($this->controller->request->params['named'])) {
                    foreach($this->controller->request->params['named'] as $key => $value) {
                        if (!array_key_exists($key, $skip)) {
                            $named = $key;
                            $is_allow_user = !empty($_SESSION['acl.' . $this->controller->request->params['controller'] . '_' . $this->controller->request->params['action'] . '_' . $named]) ? $_SESSION['acl.' . $this->controller->request->params['controller'] . '_' . $this->controller->request->params['action'] . '_' . $named] : '';
                            if (!empty($is_allow_user)) {
                                break;
                            }
                            $named.= '_' . $value;
                            $is_allow_user = !empty($_SESSION['acl.' . $this->controller->request->params['controller'] . '_' . $this->controller->request->params['action'] . '_' . $named]) ? $_SESSION['acl.' . $this->controller->request->params['controller'] . '_' . $this->controller->request->params['action'] . '_' . $named] : '';
                            if (!empty($is_allow_user)) {
                                break;
                            }
                        }
                    }
                }
                if (empty($is_allow_user) && !empty($this->controller->request->params['pass'])) {
                    foreach($this->controller->request->params['pass'] as $key => $value) {
                        if (!is_numeric($value)) {
                            $is_allow_user = !empty($_SESSION['acl.' . $this->controller->request->params['controller'] . '_' . $this->controller->request->params['action'] . '_' . $value]) ? $_SESSION['acl.' . $this->controller->request->params['controller'] . '_' . $this->controller->request->params['action'] . '_' . $value] : '';
                            if (!empty($is_allow_user)) {
                                break;
                            }
                        }
                    }
                }
                if (empty($is_allow_user)) {
                    $is_allow_user = !empty($_SESSION['acl.' . $this->controller->request->params['controller'] . '_' . $this->controller->request->params['action']]) ? $_SESSION['acl.' . $this->controller->request->params['controller'] . '_' . $this->controller->request->params['action']] : '';
                }
                $_SESSION['acl_is_allow_user'] = $is_allow_user;
                if (!empty($is_allow_user) && $is_allow_user == ConstAclStatuses::None) {
                    $this->controller->Session->setFlash(__l('You are not authorized to view this page') , 'default', null, 'error');
                    throw new NotFoundException(__l('Invalid request'));
                }
                if (!empty($is_allow_user) && $is_allow_user == ConstAclStatuses::Group && empty($_SESSION['acl.group_user_id'])) {
                    $directChildren = array();
                    $aclGroupUserIds[] = $this->controller->Auth->user('id');
                    $getPath = $this->controller->User->getpath($this->controller->Auth->user('id'));
                    if (sizeof($getPath) > 1) {
                        $id = $getPath[sizeof($getPath) -2]['User']['id'];
                        $directChildren = $this->controller->User->children($id, true);
                        $is_group_having_child = 0;
                        if (!empty($directChildren)) {
                            foreach($directChildren as $children) {
                                $numChildren = $this->controller->User->childCount($children['User']['id'], true);
                                if ($numChildren) {
                                    $is_group_having_child = 1;
                                    break;
                                }
                                $groupUserIds[] = $children['User']['id'];
                            }
                        }
                        unset($directChildren);
                        if (empty($is_group_having_child)) {
                            $aclGroupUserIds = $groupUserIds;
                        }
                    }
                    $allChildren = $this->controller->User->children($this->controller->Auth->user('id'));
                    if (!empty($allChildren)) {
                        foreach($allChildren as $children) {
                            $aclGroupUserIds[] = $children['User']['id'];
                        }
                    }
                    $_SESSION['acl_group_user_ids'] = $aclGroupUserIds;
                    $_SESSION['acl.group_user_id'] = $this->controller->Auth->user('id');
                    unset($getPath);
                    unset($allChildren);
                }
            }
            if (!$this->controller->Auth->user('id')) {
                $this->controller->Session->setFlash(__l('Authorization Required'));
                $is_admin = false;
                if (isset($this->controller->request->params['prefix']) and $this->controller->request->params['prefix'] == 'admin') {
                    $is_admin = true;
                }
                $this->controller->redirect(array(
                    'controller' => 'users',
                    'action' => 'login',
                    'admin' => $is_admin,
                    '?f=' . $this->controller->request->url
                ));
            }
            if (isset($this->controller->request->params['prefix']) and $this->controller->request->params['prefix'] == 'admin' and $this->controller->Auth->user('role_id') != ConstUserTypes::Admin) {
                $this->controller->redirect('/');
            }
        } else {
            $this->controller->Auth->allow('*');
        }
    }
}
?>