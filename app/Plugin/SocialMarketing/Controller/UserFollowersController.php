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
class UserFollowersController extends AppController
{
    public $name = 'UserFollowers';
    public $permanentCacheAction = array(
        'user' => array(
            'index',
        ) ,
    );
    public function index($user_id = null)
    {
		if(!empty($user_id)) {
			$conditions['UserFollower.user_id'] = $user_id;
		} elseif(isset($this->request->params['named']['user'])) {
			$conditions['UserFollower.user_id'] = $this->request->params['named']['user'];
		}elseif($this->Auth->user('id')) {
			$conditions['UserFollower.user_id'] = $this->Auth->user('id');
		}
        $limit = 20;
        $this->pageTitle = __l('User Followers');
        if (!empty($this->request->params['named']['type']) and $this->request->params['named']['view'] != 'compact') {
            if ($this->Auth->user('id') && isPluginEnabled('SocialMarketing')) {
                if (Configure::read('site.friend_ids')) {
                    $conditions['NOT']['UserFollower.user_id'] = Configure::read('site.friend_ids');
                }
            }
            $limit = 5;
        }
        $this->UserFollower->recursive = 1;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    ) ,
                    'fields' => array(
                        'username',
						'role_id',
						'facebook_user_id',
						'user_avatar_source_id',
						'twitter_avatar_url'
                    ) ,
                ) ,
                'FollowUser' => array(
                    'fields' => array(
                        'FollowUser.id',
						'FollowUser.username',
						'FollowUser.role_id',
						'FollowUser.facebook_user_id',
						'FollowUser.user_avatar_source_id',
						'FollowUser.twitter_avatar_url'
                    )
                )
            ) ,
            'limit' => $limit,
            'order' => array(
                'UserFollower.id' => 'desc'
            )
        );
        $total_follow = $this->UserFollower->find('count', array(
            'conditions' => $conditions,
			'recursive' => -1,
        ));
        $this->set('total_follow', $total_follow);
        $this->set('userFollowers', $this->paginate());
        if (!empty($this->request->params['named']['type']) and $this->request->params['named']['type'] == 'followers') {
            if ($this->Auth->user('id') && isPluginEnabled('SocialMarketing')) {
                unset($conditions['NOT']);
                if (!Configure::read('site.friend_ids')) {
                    $conditions['UserFollower.user_id'] = 0;
                } else {
                    $conditions['UserFollower.user_id'] = array_values(Configure::read('site.friend_ids'));
                }
                $userFollowerFriends = $this->UserFollower->find('all', array(
                    'conditions' => $conditions,
                    'contain' => array(
                        'User' => array(
                            'UserAvatar' => array(
                                'fields' => array(
                                    'UserAvatar.id',
                                    'UserAvatar.filename',
                                    'UserAvatar.dir',
                                    'UserAvatar.width',
                                    'UserAvatar.height'
                                )
                            ) ,
                            'fields' => array(
                                'username',
								'role_id',
								'facebook_user_id',
								'user_avatar_source_id',
								'twitter_avatar_url'
                            ) ,
                        ) ,
                        'Property' => array(
                            'fields' => array(
                                'User.id',
                                'User.user_follower_count',
								'User.role_id'
                            )
                        )
                    ) ,
                    'recursive' => 2,
                    'limit' => $limit
                ));
                $this->set('userFollowerFriends', $userFollowerFriends);
            } else {
                $userFollowerFriends = array();
                $this->set('userFollowerFriends', $userFollowerFriends);
            }
            $this->autoRender = false;
            $this->render('following');
        }
    }
	public function add_multiple()
	{
		if (!empty($this->request->data['UserFollower'])) {
			$redirect_url = $this->request->data['UserFollower']['r'];
			unset($this->request->data['UserFollower']['r']);
			foreach($this->request->data['UserFollower'] as $user_id => $is_checked) {
				if ($is_checked['id']) {
					$userIds[] = $user_id;
				}
			}
			if (!empty($userIds)) {
				foreach($userIds as $val) {
					if (!empty($val)) {
						$this->UserFollower->create();
						$this->request->data['UserFollower']['user_id'] = $this->Auth->user('id');
						$this->request->data['UserFollower']['followed_user_id'] = $val;
						$this->UserFollower->save($this->request->data);
					}
				}
				$this->Session->setFlash(__l('Checked users has been followed') , 'default', null, 'success');
			} else {
				$this->Session->setFlash(__l('Please select users to follow') , 'default', null, 'error');
			}
			$this->redirect($redirect_url);
		}
	}
    public function add($username = null)
    {
        if (is_null($username)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $user = $this->UserFollower->User->find('first', array(
            'conditions' => array(
                'User.username' => $username
            ) ,
            'fields' => array(
                'User.id',
                'User.username'
            ) ,
            'contain' => array(
                'UserFollower' => array(
                    'fields' => array(
                        'UserFollower.followed_user_id',
                        'UserFollower.id'
                    ) ,
                    'conditions' => array(
                        'UserFollower.user_id' => $this->Auth->user('id')
                    )
                )
            ) ,
            'recursive' => 1
        ));
        if (!empty($user)) {
            if ($user['User']['id'] != $this->Auth->user('id')) {
                if (empty($user['UserFollower'])) {
                    $this->UserFollower->create();
                    $this->request->data['UserFollower']['user_id'] = $this->Auth->user('id');
                    $this->request->data['UserFollower']['followed_user_id'] = $user['User']['id'];
                    $this->request->data['UserFollower']['action'] = 'add';
                    if ($this->UserFollower->save($this->request->data)) {
                        $response = array(
                            'message' => __l('You are successfully following this user'),
                            'url' => 'user_followers/unfollow/' . $this->UserFollower->getLastInsertId() ,
                            'class' => 'Unfollow'
                        );
                        $this->Session->setFlash(__l('You are successfully following this user') , 'default', null, 'success');
                        $follower_id = $this->UserFollower->getLastInsertId();
						Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
							'_trackEvent' => array(
								'category' => 'UserFollower',
								'action' => 'Followed',
								'label' => $this->Auth->user('username'),
								'value' => '',
							) ,
							'_setCustomVar' => array(
								'ud' => $this->Auth->user('id'),
								'rud' => $this->Auth->user('referred_by_user_id'),
								'fud' => $user['User']['id']
							)
						));
                        if ($this->RequestHandler->isAjax()) {
                            $ajax_url = Router::url(array(
                                'controller' => 'user_followers',
                                'action' => 'delete',
                                $user['User']['id'],
                            ));
                            echo "delete" . '|' . $ajax_url;
                            exit;
                        }
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'view',
                            $user['User']['username']
                        ));
                    } else {
                        $this->Session->setFlash(__l('User could not be added as follower. Please, try again') , 'default', null, 'error');
                        $response = array(
                            'message' => __l('User could not be added as follower'),
                            'url' => 'user_followers/add/' . $user['User']['id'],
                            'class' => 'Follow'
                        );
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'view',
                            $user['User']['username']
                        ));
                    }
                } else {
                    $this->Session->setFlash(__l('You are already following this user') , 'default', null, 'error');
                    $response = array(
                        'message' => __l('You are already following this user'),
                        'url' => 'user_followers/unfollow/' . $user['UserFollower'][0]['id'],
                        'class' => 'Unfollow'
                    );
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'view',
                        $user['User']['username']
                    ));
                }
                if ($this->RequestHandler->isAjax()) {
                    $follower_id = $this->UserFollower->id;
                    $this->set('followers_id', $follower_id);
                    $this->render('followers');
                }
            } else {
                $this->Session->setFlash(__l('You can not follow yourself') , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'view',
                    $user['User']['username']
                ));
            }
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $userFollower = $this->UserFollower->find('first', array(
            'conditions' => array(
                'UserFollower.id' => $id
            ) ,
            'fields' => array(
                'FollowUser.username',
                'FollowUser.id'
            ) ,
            'recursive' => 0
        ));
        if (empty($userFollower)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserFollower->delete($id)) {
            $this->Session->setFlash(__l('You have unfollowed this user') , 'default', null, 'success');
            if ($this->RequestHandler->isAjax()) {
                $ajax_url = Router::url(array(
                    'controller' => 'user_followers',
                    'action' => 'add',
                    $id,
                ));
                echo "add" . '|' . $ajax_url;
                exit;
            } else if (!$this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'view',
                    $userFollower['FollowUser']['username']
                ));
            }
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'view',
                $userFollower['FollowUser']['username']
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function unfollow($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $userFollower = $this->UserFollower->find('first', array(
            'conditions' => array(
                'UserFollower.id' => $id
            ) ,
            'fields' => array(
                'User.slug',
                'User.id'
            ) ,
            'recursive' => 0
        ));
        if (empty($userFollower)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserFollower->delete($id)) {
            $this->Session->setFlash(__l('You have unfollowed this user') , 'default', null, 'success');
            $response = array(
                'message' => __l('You have unfollowed this user'),
                'url' => 'user_followers/add/' . $userFollower['User']['id'],
                'class' => 'Follow'
            );
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->RequestHandler->prefers('json') && !empty($this->request->query['key'])) {
            $event_data = $response;
            Cms::dispatchEvent('Controller.Property.unfollow', $this, array(
                'data' => $event_data
            ));
        }
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = __l('User Followers');
        $conditions = '';
        $this->UserFollower->recursive = 0;
        if (!empty($this->request->params['named']['q'])) {
            $conditions['AND']['OR'][]['User.name LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR'][]['User.username LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->request->data['UserFollower']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (!empty($this->request->params['named']['user_id'])) {
            $conditions['UserFollower.user_id'] = $this->request->params['named']['user_id'];
            $user_name = $this->UserFollower->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->params['named']['user_id'],
                ) ,
                'fields' => array(
                    'User.username',
                ) ,
                'recursive' => -1,
            ));
            $this->pageTitle.= sprintf(__l(' - User - %s') , $user_name['User']['username']);
        }
        if (isset($this->request->params['named']['user_id'])) {
            $conditions['UserFollower.user_id'] = $this->request->params['named']['user_id'];
            $user_name = $this->UserFollower->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->params['named']['user_id'],
                ) ,
                'fields' => array(
                    'User.name',
                ) ,
                'recursive' => -1,
            ));
            $this->pageTitle.= $user_name['User']['name'];
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User',
                'User' => array(
                    'UserAvatar'
                ) ,
            ) ,
            'order' => array(
                'UserFollower.id' => 'desc'
            )
        );
        $this->set('userFollowers', $this->paginate());
        $moreActions = $this->UserFollower->moreActions;
        $this->set('moreActions',$moreActions);
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $userFollower = $this->UserFollower->find('first', array(
            'conditions' => array(
                'UserFollower.id' => $id
            ) ,
            'fields' => array(
                'User.slug',
                'User.id'
            ) ,
            'recursive' => 0
        ));
        if (empty($userFollower)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserFollower->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('User Follower')), 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'user_followers',
                'action' => 'index',
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
	public function following($user_id = null)
    {
		if(!empty($user_id)) {
			$conditions['UserFollower.user_id'] = $user_id;
		} elseif($this->Auth->user('id')) {
			$conditions['UserFollower.user_id'] = $this->Auth->user('id');
		}
        $limit = 20;
        $this->pageTitle = __l('User Followers');
        $this->UserFollower->recursive = 1;
		$userFollowers = $this->UserFollower->find('list', array(
            'conditions' => $conditions,
			'fields' => array(
				'UserFollower.followed_user_id'
			),
			'limit' => $limit,
            'order' => array(
                'UserFollower.id' => 'desc'
            ),
			'recursive' => -1,
        ));
        $users = $this->UserFollower->User->find('list', array(
            'conditions' => $userFollowers,
            'contain' => array(
				'UserAvatar' => array(
					'fields' => array(
						'UserAvatar.id',
						'UserAvatar.filename',
						'UserAvatar.dir',
						'UserAvatar.width',
						'UserAvatar.height'
					)
				) ,
            ) ,
            'limit' => $limit,
			'recursive' => 0,
        ));
        $total_follow = $this->UserFollower->find('count', array(
            'conditions' => $conditions,
			'recursive' => -1,
        ));
        $this->set('total_follow', $total_follow);
        $this->set('userFollowers', $users);
    }
}
?>