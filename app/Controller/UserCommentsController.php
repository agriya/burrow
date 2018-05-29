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
class UserCommentsController extends AppController
{
    public $name = 'UserComments';
    public $components = array(
        'Email'
    );
    public function beforeFilter()
    {
        parent::beforeFilter();
    }
    public function index($username = null)
    {
        $this->pageTitle = __l('Recommendations');
        $user = $this->UserComment->User->find('first', array(
            'conditions' => array(
                'User.username' => $username
            ) ,
            'fields' => array(
                'User.role_id',
                'User.username',
                'User.id',
                'User.facebook_user_id',
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            throw new NotFoundException(__l('Invalid request'));
        }
		$group = array();
		if(!empty($this->request->params['named']['view']) && $this->request->params['named']['view'] == 'popular') {
			$group = array(
				'PostedUser.id',
				'UserComment.id',
				'User.id'
			);
		}
        $this->paginate = array(
            'conditions' => array(
                'UserComment.user_id' => $user['User']['id']
            ) ,
            'contain' => array(
                'PostedUser',
                'User' => array(
                    'fields' => array(
                        'User.role_id',
                        'User.username',
                        'User.id',
                        'User.facebook_user_id',
                    )
                )
            ) ,
            'order' => array(
                'UserComment.id DESC'
            ),
			'group' => $group
        );
        $this->UserComment->recursive = 0;
        $this->set('userComments', $this->paginate());
        $this->set('user', $user);
        $this->request->data['UserComment']['user_id'] = $user['User']['id'];
        $this->set('username', $username);				
		if(!empty($this->request->params['named']['view']) && $this->request->params['named']['view'] == 'popular') {
			$this->render('popular');
		}
    }
    public function view($id = null, $view_name = 'view')
    {
        $this->pageTitle = __l('Recommendation');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $userComment = $this->UserComment->find('first', array(
            'conditions' => array(
                'UserComment.id = ' => $id
            ) ,
            'contain' => array(
                'PostedUser'
            ) ,
            'recursive' => 2,
        ));
        if (empty($userComment)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $userComment['UserComment']['id'];
        $this->set('userComment', $userComment);
        $this->render($view_name);
    }
    public function add()
    {
        $this->pageTitle = __l('Add Recommendation');
        if (!empty($this->request->data)) {
            $user = $this->UserComment->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['UserComment']['user_id']
                ) ,
                'fields' => array(
                    'User.username',
                    'User.role_id',
                    'User.email',
                    'User.id'
                ) ,
                'contain' => array(
                    'UserProfile',
                ) ,
                'recursive' => 1
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $this->request->data['UserComment']['posted_user_id'] = $this->Auth->user('id');
            $this->UserComment->create();
            if ($this->UserComment->save($this->request->data)) {
                // To send email when post comments
                if (Configure::read('user.is_send_email_on_profile_comments') && $this->UserComment->_checkForPrivacy('Profile-is_receive_email_for_new_comment', $user['User']['id'], $this->Auth->user('id'))) {
                    $this->_sendAlertOnCommentPost($user, $this->request->data['UserComment']['comment'], $user['User']['username'], $user['User']['id']);
                }
                $this->Session->setFlash(__l('Recommendation has been added') , 'default', null, 'success');
                if (!$this->RequestHandler->isAjax()) {
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'view',
                        $user['User']['username']
                    ));
                } else {
                    // Ajax: return added blog comment
                    $this->setAction('view', $this->UserComment->getLastInsertId() , 'view_ajax');
                }
            } else {
                $this->Session->setFlash(__l('Recommendation could not be added. Please, try again.') , 'default', null, 'error');
            }
            $this->set('user', $user);
        }
    }
    public function _sendAlertOnCommentPost($email, $comment, $username, $user_id)
    {
        // @todo "User activation" check user.is_send_email_notifications_only_to_verified_email_account
		App::import('Model', 'EmailTemplate');
		$this->EmailTemplate = new EmailTemplate();
        $language_code = $this->UserComment->getUserLanguageIso($user_id);
        $email_message = $this->EmailTemplate->selectTemplate('New Comment Profile', $language_code);
        $email_replace = array(
            '##FROM_EMAIL##' => $this->UserComment->changeFromEmail(($email_message['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email_message['from']) ,
            '##PROFILEUSERNAME##' => $username,
            '##USERNAME##' => $this->Auth->user('username') ,
            '##PROFILE_LINK##' => Router::url(array(
                'controller' => 'users',
                'action' => 'view',
                $username,
                '#tabs-1',
                'admin' => false
            ) , true) ,
            '##COMMENT##' => $comment,
        );
        // Send e-mail to users
		$from = ($email_message['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email_message['from'];
		$email_message['reply_to'] = ($email_message['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email_message['reply_to'];
		$this->UserComment->_sendEmail($email_message, $email_replace, $email['User']['email'], $from);
    }
    public function edit($id = null)
    {
        $this->pageTitle = __l('Edit Recommendation');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->UserComment->save($this->request->data)) {
                $this->Session->setFlash(__l('Recommendation has been updated') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('Recommendation could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->UserComment->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['UserComment']['id'];
        $users = $this->UserComment->User->find('list');
        $this->set(compact('users'));
    }
    public function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        // Check is user allow to delete
        $userComment = $this->UserComment->find('first', array(
            'conditions' => array(
                'UserComment.id' => $id,
                'OR' => array(
                    'UserComment.posted_user_id' => $this->Auth->user('id') ,
                    'UserComment.user_id' => $this->Auth->user('id')
                )
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.username',
                        'User.role_id'
                    ) ,
                ) ,
            ) ,
            'recursive' => 2
        ));
        if (empty($userComment)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserComment->delete($id)) {
            $this->Session->setFlash(__l('Recommendation deleted') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'view',
                $userComment['User']['username']
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Recommendations');
        $this->UserComment->recursive = 0;
        $this->paginate = array(
            'order' => array(
                'UserComment.id' => 'desc'
            )
        );
        $this->set('userComments', $this->paginate());
        $moreActions = $this->UserComment->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Recommendation');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->UserComment->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('Recommendation has been updated') , $this->request->data['UserComment']['id']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('Recommendation could not be updated. Please, try again.') , $this->request->data['UserComment']['id']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->UserComment->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['UserComment']['id'];
        $users = $postedUsers = $this->UserComment->User->find('list');
        $this->set(compact('users', 'postedUsers'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserComment->delete($id)) {
            $this->Session->setFlash(__l('Recommendation deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>