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
class PropertyFavoritesController extends AppController
{
    public $name = 'PropertyFavorites';
    public $components = array(
        'OauthConsumer'
    );
    // Add Favourites and update in facebook and twitter if user is logged in using FB Connect or Twitter Connect //
    public function add($slug = null)
    {
        $property = $this->PropertyFavorite->Property->find('first', array(
            'conditions' => array(
                'Property.slug' => $slug,
                'Property.user_id != ' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        if (empty($property)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $chkFavorites = $this->PropertyFavorite->find('first', array(
            'conditions' => array(
                'user_id' => $this->Auth->user('id') ,
                'property_id' => $property['Property']['id']
            ) ,
            'recursive' => -1
        ));
        if (empty($chkFavorites)) {
            $this->request->data['PropertyFavorite']['property_id'] = $property['Property']['id'];
            $this->request->data['PropertyFavorite']['user_id'] = $this->Auth->user('id');
            $this->request->data['PropertyFavorite']['ip_id'] = $this->PropertyFavorite->toSaveIp();
            if (!empty($this->request->data)) {
                $this->PropertyFavorite->create();
                if ($this->PropertyFavorite->save($this->request->data, false)) {
					$favorite_id = $this->PropertyFavorite->id;
					Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
						'_trackEvent' => array(
							'category' => 'User',
							'action' => 'Favorited ',
							'label' => $this->Auth->user('username'),
							'value' => '',
						) ,
						'_setCustomVar' => array(
							'ud' => $this->Auth->user('id'),
							'rud' => $this->Auth->user('referred_by_user_id'),
						)
					));
					Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
						'_trackEvent' => array(
							'category' => 'PropertyFavorite',
							'action' => 'Favorited',
							'label' => $property['Property']['id'],
							'value' => '',
						) ,
						'_setCustomVar' => array(
							'pd' => $property['Property']['id'],
							'ud' => $this->Auth->user('id'),
							'rud' => $this->Auth->user('referred_by_user_id'),
						)
					));
                    // Update Social Networking//
                    $property = $this->PropertyFavorite->Property->find('first', array(
                        'conditions' => array(
                            'Property.id = ' => $this->request->data['PropertyFavorite']['property_id'],
                        ) ,
                        'fields' => array(
                            'Property.id',
                            'Property.title',
                            'Property.slug',
                            'Property.user_id',
                            'Property.description',
                            'Property.property_view_count',
                            'Property.property_feedback_count',
                            'Property.property_favorite_count',
                            'Property.is_active',
                        ) ,
                        'contain' => array(
                            'Attachment' => array(
                                'fields' => array(
                                    'Attachment.id',
                                    'Attachment.filename',
                                    'Attachment.dir',
                                    'Attachment.width',
                                    'Attachment.height'
                                )
                            ) ,
                        ) ,
                        'recursive' => 2,
                    ));
					$response = '';
					$response = Cms::dispatchEvent('Controller.SocialMarketing.getShareUrl', $this, array(
						'data' => $favorite_id,
						'publish_action' => 'follow'
					));
					$social_url = !empty($response->data['social_url']) ? $response->data['social_url'] : '';
                    $url = Router::url(array(
                        'controller' => 'properties',
                        'action' => 'view',
                        $property['Property']['slug'],
                    ) , true);                   
                    
					if ($this->RequestHandler->isAjax()) {
						$class = "js-like js-no-pjax un-like top-space show no-under";
						$url = array('controller' => 'property_favorites', 'action'=>"delete", $property['Property']['slug']);
						if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'view'){
							$class ="js-like js-no-pjax like show span top-smspace no-under";
							$url = array('controller' => 'property_favorites', 'action'=>"delete", $property['Property']['slug'], 'type' => 'view');
						}						
						$this->set('class', $class);
						$this->set('url', $url);						
						$this->set('is_starred_class', "icon-star no-pad text-18");
						$this->set('title', __l('Unlike'));							
						$this->render('star');                     
                    }else{
						$this->Session->setFlash(__l(' Property has been added to your Favorites') , 'default', null, 'success');
						Cms::dispatchEvent('Controller.SocialMarketing.redirectToShareUrl', $this, array(
							'data' => $favorite_id,
							'publish_action' => 'follow'
						));					
						$this->redirect(array(
							'controller' => 'properties',
							'action' => 'view',
							$property['Property']['slug']
						));
					}
                } else {
                    $this->Session->setFlash(__l(' Property Favorite could not be added. Please, try again.') , 'default', null, 'error');
					$this->redirect(array(
						'controller' => 'properties',
						'action' => 'view',
						$slug
					));
                }
            }
        } else {
            $this->Session->setFlash(__l(' Property already added has Favorite') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'properties',
                'action' => 'view',
                $slug
            ));
        }
    }
    public function delete($slug = null)
    {
        $property = $this->PropertyFavorite->Property->find('first', array(
            'conditions' => array(
                'Property.slug = ' => $slug
            ) ,
            'recursive' => -1
        ));
        if (empty($property)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $chkFavorites = $this->PropertyFavorite->find('first', array(
            'conditions' => array(
                'PropertyFavorite.user_id' => $this->Auth->user('id') ,
                'PropertyFavorite.property_id' => $property['Property']['id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($chkFavorites['PropertyFavorite']['id'])) {
            $id = $chkFavorites['PropertyFavorite']['id'];
            if ($this->PropertyFavorite->delete($id)) {
                if ($this->RequestHandler->isAjax()) {
					$class = "js-like js-no-pjax un-like top-space show no-unde";
					$url = array('controller' => 'property_favorites', 'action'=>'add', $property['Property']['slug']);
					if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'view'){
						$class ="js-like js-no-pjax like show span top-smspace graylightc no-under";
						$url = array('controller' => 'property_favorites', 'action'=>'add', $property['Property']['slug'], 'type' => 'view');
					}								
					$this->set('class', $class);
					$this->set('url', $url);
					$this->set('is_starred_class', "grayc icon-star-empty no-pad text-18");
					$this->set('title', __l('Like'));	
					$this->render('star');                   
                }else{
					$this->Session->setFlash(__l(' Property removed from favorites') , 'default', null, 'success');
					$this->redirect(array(
						'controller' => 'properties',
						'action' => 'view',
						$property['Property']['slug']
					));
				}
            } else {
                throw new NotFoundException(__l('Invalid request'));
            }
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Property Favorites');
        $this->_redirectGET2Named(array(
            'q',
            'username',
        ));
        $conditions = array();
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
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['PropertyFavorite.created ='] = date('Y-m-d', strtotime('now'));
            $this->pageTitle.= __l(' - today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['PropertyFavorite.created >='] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['PropertyFavorite.created >='] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - in this month');
        }
        if (!empty($this->request->params['named']['property'])) {
            $conditions['Property.slug'] = $this->request->params['named']['property'];
        }
		 if (isset($this->request->params['named']['q'])) {
            $this->request->data['PropertyFavorite']['q'] = $this->request->params['named']['q'];
			$conditions['AND']['OR'][]['Property.title LIKE'] = '%' . $this->request->params['named']['q'] . '%';
			$conditions['AND']['OR'][]['User.username LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->PropertyFavorite->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
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
                'User' => array(
                    'UserAvatar',
                ),
                'Property',
            ) ,
            'order' => array(
                'PropertyFavorite.id' => 'desc'
            )
        );
        $moreActions = $this->PropertyFavorite->moreActions;
        $this->set(compact('moreActions'));
        $this->set('propertyFavorites', $this->paginate());
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->PropertyFavorite->delete($id)) {
            $this->Session->setFlash(__l('Property favorite deleted successfully') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>