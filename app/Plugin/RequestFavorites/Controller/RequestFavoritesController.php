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
class RequestFavoritesController extends AppController
{
    public $name = 'RequestFavorites';
    public function add($slug = null)
    {
        $this->pageTitle = __l('Add Request Favorite');
        $request = $this->RequestFavorite->Request->find('first', array(
            'conditions' => array(
                'Request.slug = ' => $slug
            ) ,
            'recursive' => -1
        ));
        if (empty($request)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $chkFavorites = $this->RequestFavorite->find('first', array(
            'conditions' => array(
                'user_id' => $this->Auth->user('id') ,
                'request_id' => $request['Request']['id']
            ) ,
            'recursive' => -1
        ));
        if (empty($chkFavorites)) {
            $this->request->data['RequestFavorite']['request_id'] = $request['Request']['id'];
            $this->request->data['RequestFavorite']['user_id'] = $this->Auth->user('id');
            $this->request->data['RequestFavorite']['ip_id'] = $this->RequestFavorite->toSaveIp();
            if (!empty($this->request->data)) {
                $this->request->data['RequestFavorite']['ip_id'] = $this->RequestFavorite->toSaveIp();
                $this->RequestFavorite->create();
                if ($this->RequestFavorite->save($this->request->data)) {
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
							'category' => 'RequestFavorite',
							'action' => 'Favorited',
							'label' => $request['Request']['id'],
							'value' => '',
						) ,
						'_setCustomVar' => array(
							'pd' => $request['Request']['id'],
							'ud' => $this->Auth->user('id'),
							'rud' => $this->Auth->user('referred_by_user_id'),
						)
					));
                    if ($this->RequestHandler->isAjax()) {
						$class = "js-no-pjax js-like un-like tb top-space  show";
						$url = array('controller' => 'request_favorites', 'action'=>"delete", $request['Request']['slug']);
						if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'view'){
							$class ="js-no-pjax js-like un-like show span top-smspace no-under";
							$url = array('controller' => 'request_favorites', 'action'=>"delete", $request['Request']['slug'], 'type' => 'view');
						}						
						$this->set('class', $class);
						$this->set('url', $url);						
						$this->set('is_starred_class', "icon-star no-pad text-18");
						$this->set('title', __l('Unlike'));							
						$this->render('star');					                       
                    }else{
						$this->redirect(array(
							'controller' => 'requests',
							'action' => 'view',
							$request['Request']['slug']
						));
					}
                } else {
                    $this->Session->setFlash(sprintf(__l('"%s" Request Favorite could not be added. Please, try again.') , $this->request->data['RequestFavorite']['id']) , 'default', null, 'error');
                }
            }
        } else {
            $this->Session->setFlash(__l(' Request already added has Favorite') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'requests',
                'action' => 'view',
                $slug
            ));
        }
        $users = $this->RequestFavorite->User->find('list');
        $requests = $this->RequestFavorite->Request->find('list');
        $this->set(compact('users', 'requests'));
    }
    public function delete($slug = null)
    {
        $request = $this->RequestFavorite->Request->find('first', array(
            'conditions' => array(
                'Request.slug = ' => $slug
            ) ,
            'recursive' => -1
        ));
        if (empty($request)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $chkFavorites = $this->RequestFavorite->find('first', array(
            'conditions' => array(
                'RequestFavorite.user_id' => $this->Auth->user('id') ,
                'RequestFavorite.request_id' => $request['Request']['id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($chkFavorites['RequestFavorite']['id'])) {
            $id = $chkFavorites['RequestFavorite']['id'];
            if ($this->RequestFavorite->delete($id)) {
                if ($this->RequestHandler->isAjax()) {
					$class = "js-no-pjax js-like tb like top-space show";
					$url = array('controller' => 'request_favorites', 'action'=>'add', $request['Request']['slug']);
					if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'view'){
						$class ="js-no-pjax js-like like show span top-smspace no-under";
						$url = array('controller' => 'request_favorites', 'action'=>'add', $request['Request']['slug'], 'type' => 'view');
					}								
					$this->set('class', $class);
					$this->set('url', $url);
					$this->set('is_starred_class', "grayc icon-star-empty no-pad text-18");
					$this->set('title', __l('Like'));	
					$this->render('star');                   
                }else{
					$this->Session->setFlash(__l('Request Favorite deleted') , 'default', null, 'success');
					$this->redirect(array(
							'controller' => 'requests',
							'action' => 'view',
							$request['Request']['slug']
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
        $this->pageTitle = __l('Request Favorites');
        $conditions = array();
        if (!empty($this->request->params['named']['request_id'])) {
            $conditions['RequestFavorite.request_id'] = $this->request->params['named']['request_id'];
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User',
                'Request',
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
                'RequestFavorite.id' => 'DESC'
            )
        );
        $this->set('requestFavorites', $this->paginate());
        $moreActions = $this->RequestFavorite->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->RequestFavorite->delete($id)) {
            $this->Session->setFlash(__l('Request Favorite deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>