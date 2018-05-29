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
class PropertyFlagsController extends AppController
{
    public $name = 'PropertyFlags';
    public $permanentCacheAction = array(
		'user' => array(
			'add',
		) ,
    );
	public function beforeFilter()
	{
		$this->Security->disabledFields = array(
            'PropertyFlag.user_id',
			'PropertyFlag.property_id'
			);
		parent::beforeFilter();
	}
    public function add($property_id = null)
    {
        if (!empty($this->request->data)) {
            $this->PropertyFlag->create();
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                $this->request->data['PropertyFlag']['user_id'] = $this->Auth->user('id');
            }
            $this->request->data['PropertyFlag']['property_id'] = $this->request->data['Property']['id'];
            $this->request->data['PropertyFlag']['ip_id'] = $this->PropertyFlag->toSaveIp();
            if ($this->PropertyFlag->save($this->request->data)) {
				$_Data['Property']['id'] = $this->request->data['Property']['id'];
				$_Data['Property']['is_user_flagged'] = 1;
				$this->PropertyFlag->Property->save($_Data);
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
                        'category' => 'PropertyFlag',
                        'action' => 'Flagged',
                        'label' => $_Data['Property']['id'],
                        'value' => '',
                    ) ,
                    '_setCustomVar' => array(
                        'pd' => $_Data['Property']['id'],
                        'ud' => $this->Auth->user('id') ,
                        'rud' => $this->Auth->user('referred_by_user_id') ,
                    )
                ));
                $this->Session->setFlash(__l('Flag has been added') , 'default', null, 'success');
                $property = $this->PropertyFlag->Property->find('first', array(
                    'conditions' => array(
                        'Property.id' => $this->request->data['Property']['id'],
                    ) ,
                    'fields' => array(
                        'Property.slug',
                    ) ,
                    'recursive' => -1
                ));
                if ($this->RequestHandler->isAjax()) {
                    echo "redirect*" . Router::url(array(
                        'controller' => 'properties',
                        'action' => 'view',
                        $property['Property']['slug'],
                        'admin' => false
                    ) , true);
                    exit;
                } else {
                    $this->redirect(array(
                        'controller' => 'properties',
                        'action' => 'view',
                        $property['Property']['slug'],
                        'admin' => false
                    ));
                }
            } else {
                $this->request->data = $this->PropertyFlag->Property->find('first', array(
                    'conditions' => array(
                        'Property.id' => $this->request->data['Property']['id'],
                    ) ,
                    'recursive' => -1
                ));
                $this->Session->setFlash(__l('Flag could not be added. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->PropertyFlag->Property->find('first', array(
                'conditions' => array(
                    'Property.id' => $property_id,
                ) ,
                'recursive' => -1
            ));
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $propertyFlagCategories = $this->PropertyFlag->PropertyFlagCategory->find('list', array(
            'conditions' => array(
                'PropertyFlagCategory.is_active' => 1
            ),
			'recursive' => -1,
        ));
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $users = $this->PropertyFlag->User->find('list');
            $this->set(compact('users'));
        }
        $this->set(compact('propertyFlagCategories'));
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = __l('Property Flags');
        $conditions = array();
        if (!empty($this->request->params['named']['property_flag_category_id '])) {
            $propertyFlagCategory = $this->{$this->modelClass}->PropertyFlagCategory->find('first', array(
                'conditions' => array(
                    'PropertyFlagCategory.id' => $this->request->params['named']['property_flag_category_id ']
                ) ,
                'fields' => array(
                    'PropertyFlagCategory.id',
                    'PropertyFlagCategory.name'
                ) ,
                'recursive' => -1
            ));
            if (empty($propertyFlagCategory)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['PropertyFlagCategory.id'] = $propertyFlagCategory['PropertyFlagCategory']['id'];
            $this->pageTitle.= sprintf(__l(' - Category - %s') , $propertyFlagCategory['PropertyFlagCategory']['name']);
        }
        if (!empty($this->request->params['named']['property']) || !empty($this->request->params['named']['property_id'])) {
            $propertyConditions = !empty($this->request->params['named']['property']) ? array(
                'Property.slug' => $this->request->params['named']['property']
            ) : array(
                'Property.id' => $this->request->params['named']['property_id']
            );
            $property = $this->{$this->modelClass}->Property->find('first', array(
                'conditions' => $propertyConditions,
                'fields' => array(
                    'Property.id',
                    'Property.title'
                ) ,
                'recursive' => -1
            ));
            if (empty($property)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['Property.id'] = $this->request->data[$this->modelClass]['property_id'] = $property['Property']['id'];
            $this->pageTitle.= ' - ' . $property['Property']['title'];
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
            $this->request->data['Property']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['PropertyFlag.created ='] = date('Y-m-d', strtotime('now'));
            $this->pageTitle.= __l(' - Added today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['PropertyFlag.created >='] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - Added in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['PropertyFlag.created >='] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - Added in this month');
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['PropertyFlag']['q'] = $this->request->params['named']['q'];
			$conditions['AND']['OR'][]['PropertyFlag.message LIKE'] = '%' . $this->request->params['named']['q'] . '%';
			$conditions['AND']['OR'][]['PropertyFlagCategory.name LIKE'] = '%' . $this->request->params['named']['q'] . '%';
			$conditions['AND']['OR'][]['Property.title LIKE'] = '%' . $this->request->params['named']['q'] . '%';
			$conditions['AND']['OR'][]['User.username LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (!empty($this->request->data['Property']['filter_id'])) {
            if ($this->request->data['Property']['filter_id'] == ConstMoreAction::UserFlagged) {
                $conditions['Property.property_flag_count'] != 0;
                $conditions['Property.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - User Flagged ');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['Property']['filter_id'];
        }
        $this->PropertyFlag->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.username'
                    )
                ) ,
                'PropertyFlagCategory' => array(
                    'fields' => array(
                        'PropertyFlagCategory.name'
                    )
                ) ,
                'Property' => array(
                    'fields' => array(
                        'Property.title',
                        'Property.slug',
                        'Property.id',
                    ) ,
                    'Attachment' => array(
                        'fields' => array(
                            'Attachment.id',
                            'Attachment.filename',
                            'Attachment.dir',
                            'Attachment.width',
                            'Attachment.height',
                        )
                    )
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
                'PropertyFlag.id' => 'desc'
            )
        );
        $this->set('propertyFlags', $this->paginate());
        $moreActions = $this->PropertyFlag->moreActions;
        $this->set(compact('moreActions'));
        $this->set('page_title', $this->pageTitle);
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Property Flag');
        if (is_null($id)) {
            throw new NotFoundException();
        }
        if (!empty($this->request->data)) {
            if ($this->PropertyFlag->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('Property Flag has been updated') , $this->request->data['PropertyFlag']['id']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('Property Flag could not be updated. Please, try again.') , $this->request->data['PropertyFlag']['id']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->PropertyFlag->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException();
            }
        }
        $users = $this->PropertyFlag->User->find('list');
        $properties = $this->PropertyFlag->Property->find('list');
        $propertyFlagCategories = $this->PropertyFlag->PropertyFlagCategory->find('list', array(
			'conditions' => array(
				'PropertyFlagCategory.is_active' => 1
			),
			'recursive' => -1,
		));
        $this->set(compact('users', 'properties', 'propertyFlagCategories'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->PropertyFlag->delete($id)) {
            $this->Session->setFlash(__l('Flag has been cleared') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>