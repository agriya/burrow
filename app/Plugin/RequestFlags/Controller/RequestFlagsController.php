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
class RequestFlagsController extends AppController
{
    public $name = 'RequestFlags';
    public $permanentCacheAction = array(
		'user' => array(
			'add',
		) ,
    );
    public function add($request_id = null)
    {
        if (!empty($this->request->data)) {
            $this->RequestFlag->create();
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                $this->request->data['RequestFlag']['user_id'] = $this->Auth->user('id');
            }
            $this->request->data['RequestFlag']['request_id'] = $this->request->data['Request']['id'];
            $this->request->data['RequestFlag']['ip_id'] = $this->RequestFlag->toSaveIp();
            if ($this->RequestFlag->save($this->request->data)) {
				$_Data['Request']['id'] = $this->request->data['Request']['id'];
				$_Data['Request']['is_user_flagged'] = 1;
				$this->RequestFlag->Request->save($_Data);
				Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'User',
                        'action' => 'Flagged',
                        'label' => $this->Auth->user('username') ,
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'ud' => $this->Auth->user('id') ,
                        'rud' => $this->Auth->user('referred_by_user_id') ,
                    )
                ));
                Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                    '_trackEvent' => array(
                        'category' => 'RequestFlag',
                        'action' => 'Flagged',
                        'label' => $request_id,
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'pd' => $request_id,
                        'ud' => $this->Auth->user('id') ,
                        'rud' => $this->Auth->user('referred_by_user_id') ,
                    )
                ));
                $this->Session->setFlash(__l('Flag has been added') , 'default', null, 'success');
                $request = $this->RequestFlag->Request->find('first', array(
                    'conditions' => array(
                        'Request.id' => $this->request->data['Request']['id'],
                    ) ,
                    'fields' => array(
                        'Request.slug',
                    ) ,
                    'recursive' => -1
                ));
                if ($this->RequestHandler->isAjax()) {
                    echo "redirect*" . Router::url(array(
                        'controller' => 'requests',
                        'action' => 'view',
                        $request['Request']['slug'],
                        'admin' => false
                    ) , true);
                    exit;
                } else {
                    $this->redirect(array(
                        'controller' => 'requests',
                        'action' => 'view',
                        $request['Request']['slug'],
                        'admin' => false
                    ));
                }
            } else {
                $this->request->data = $this->RequestFlag->Request->find('first', array(
                    'conditions' => array(
                        'Request.id' => $this->request->data['Request']['id'],
                    ) ,
                    'recursive' => -1
                ));
                $this->Session->setFlash(__l('Flag could not be added. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->RequestFlag->Request->find('first', array(
                'conditions' => array(
                    'Request.id' => $request_id,
                ) ,
                'recursive' => -1
            ));
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $requestFlagCategories = $this->RequestFlag->RequestFlagCategory->find('list', array(
            'conditions' => array(
                'RequestFlagCategory.is_active' => 1
            ),
			'recursive' => -1,
        ));
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $users = $this->RequestFlag->User->find('list');
            $this->set(compact('users'));
        }
        $this->set(compact('requestFlagCategories'));
    }
    public function admin_index()
    {
        $this->_redirectPOST2Named(array(
            'q'
        ));
        $this->pageTitle = __l('Request Flags');
        $conditions = array();
        if (!empty($this->request->params['named']['request_flag_category_id '])) {
            $requestFlagCategory = $this->{$this->modelClass}->RequestFlagCategory->find('first', array(
                'conditions' => array(
                    'RequestFlagCategory.id' => $this->request->params['named']['request_flag_category_id ']
                ) ,
                'fields' => array(
                    'RequestFlagCategory.id',
                    'RequestFlagCategory.name'
                ) ,
                'recursive' => -1
            ));
            if (empty($requestFlagCategory)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['RequestFlagCategory.id'] = $requestFlagCategory['RequestFlagCategory']['id'];
            $this->pageTitle.= sprintf(__l(' - Category - %s') , $requestFlagCategory['RequestFlagCategory']['name']);
        }
        if (!empty($this->request->params['named']['request']) || !empty($this->request->params['named']['request_id'])) {
            $requestConditions = !empty($this->request->params['named']['request']) ? array(
                'Request.slug' => $this->request->params['named']['request']
            ) : array(
                'Request.id' => $this->request->params['named']['request_id']
            );
            $request = $this->{$this->modelClass}->Request->find('first', array(
                'conditions' => $requestConditions,
                'fields' => array(
                    'Request.id',
                    'Request.title'
                ) ,
                'recursive' => -1
            ));
            if (empty($request)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['Request.id'] = $this->request->data[$this->modelClass]['request_id'] = $request['Request']['id'];
            $this->pageTitle.= ' - ' . $request['Request']['title'];
        }
        if (!empty($this->request->params['named']['username']) || !empty($this->request->params['named']['user_id'])) {
            $userConditions = !empty($this->request->params['named']['username']) ? array(
                'User.username' => $this->request->params['named']['username']
            ) : array(
                'User.id' => $this->request->params['named']['user_id']
            );
            $user = $this->{$this->modelClass}->User->find('first', array(
                'conditions' => $userConditions,
                'fields' => array(
                    'User.id',
                    'User.username'
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['User.id'] = $this->request->data[$this->modelClass]['user_id'] = $user['User']['id'];
            $this->pageTitle.= ' - ' . $user['User']['username'];
        }
        // check the filer passed through named parameter
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['Request']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['RequestFlag.created ='] = date('Y-m-d', strtotime('now'));
            $this->pageTitle.= __l(' - Added today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['RequestFlag.created >='] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - Added in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['RequestFlag.created >='] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - Added in this month');
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['RequestFlag']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (!empty($this->request->data['Request']['filter_id'])) {
            if ($this->request->data['Request']['filter_id'] == ConstMoreAction::UserFlagged) {
                $conditions['Request.request_flag_count'] != 0;
                $conditions['Request.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - User Flagged ');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['Request']['filter_id'];
        }
        $this->RequestFlag->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.username'
                    )
                ) ,
                'RequestFlagCategory' => array(
                    'fields' => array(
                        'RequestFlagCategory.name',
                        'RequestFlagCategory.id'
                    )
                ) ,
                'Request' => array(
                    'fields' => array(
                        'Request.title',
                        'Request.slug',
                        'Request.id',
                    ) ,
                ) ,
                'Ip' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name',
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name',
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2',
                            )
                        ) ,
                        'Timezone' => array(
                            'fields' => array(
                                'Timezone.name',
                            )
                        ) ,
                        'fields' => array(
                            'Ip.ip',
                            'Ip.latitude',
                            'Ip.longitude',
                            'Ip.host',
                        )
                    ) ,
            ) ,
            'order' => array(
                'RequestFlag.id' => 'desc'
            )
        );
        if (isset($this->request->data['RequestFlag']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->data['RequestFlag']['q']
            ));
        }
        $this->set('requestFlags', $this->paginate());
        $moreActions = $this->RequestFlag->moreActions;
        $this->set(compact('moreActions'));
        $this->set('page_title', $this->pageTitle);
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Request Flag');
        if (is_null($id)) {
            throw new NotFoundException();
        }
        if (!empty($this->request->data)) {
            if ($this->RequestFlag->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('Request Flag has been updated') , $this->request->data['RequestFlag']['id']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('Request Flag could not be updated. Please, try again.') , $this->request->data['RequestFlag']['id']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->RequestFlag->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException();
            }
        }
        $users = $this->RequestFlag->User->find('list');
        $requests = $this->RequestFlag->Request->find('list');
        $requestFlagCategories = $this->RequestFlag->RequestFlagCategory->find('list', array(
			'conditions' => array(
				'RequestFlagCategory.is_active' => 1
			),
			'recursive' => -1,
		));
        $this->set(compact('users', 'requests', 'requestFlagCategories'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->RequestFlag->delete($id)) {
            $this->Session->setFlash(__l('Request Flag has been deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>