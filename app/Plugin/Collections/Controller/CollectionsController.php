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
class CollectionsController extends AppController
{
    public $name = 'Collections';
	public $permanentCacheAction = array(
		'public' => array(
			'index',
		) ,
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Attachment',
        );
        parent::beforeFilter();
    }
    public function index()
    {
        $this->pageTitle = __l('Collections');
        $this->Collection->recursive = 0;
        $conditions = array();
        $conditions['Collection.is_active'] = 1;
        $conditions['Collection.property_count >'] = 0;
        $this->paginate = array(
            'conditions' => array(
                $conditions
            ) ,
            'contain' => array(
                'CollectionsProperty',
                'Attachment',
                'Property' => array(
                    'Attachment'
                ) ,
            ) ,
            'order' => array(
                'Collection.id' => 'desc'
            )
        );
        $this->set('collections', $this->paginate());
    }
    public function collage()
    {
        // @todo "Collage Script"

    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
		$this->pageTitle = __l('Collections');
        $conditions = array();
        $this->set('active', $this->Collection->find('count', array(
            'conditions' => array(
                'Collection.is_active' => 1
            ) ,
            'recursive' => -1
        )));
        $this->set('inactive', $this->Collection->find('count', array(
            'conditions' => array(
                'Collection.is_active' => 0
            ) ,
            'recursive' => -1
        )));
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['Collection.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['Collection.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
		if (isset($this->request->params['named']['q'])) {
            $conditions['AND']['OR'][]['Collection.title LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR'][]['Collection.description LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
            $this->request->data['Collection']['q'] = $this->request->params['named']['q'];
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'Collection.id' => 'desc'
            ) ,
            'recursive' => -1
        );
        $this->set('collections', $this->paginate());
        $moreActions = $this->Collection->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Collection');
        $this->Collection->Attachment->Behaviors->attach('ImageUpload', Configure::read('image.file'));
        if (!empty($this->request->data)) {
            $this->Collection->create();
            $this->request->data['Attachment']['class'] = 'Collection';
			$this->Collection->Attachment->set($this->request->data);
            $ini_upload_error = 1;
            if ($this->request->data['Attachment']['filename']['error'] == 1) {
                $ini_upload_error = 0;
                $this->request->data['Attachment']['class'] = 'Collection';
            }
			$this->Collection->set($this->request->data);
			if($this->Collection->validates() && $this->Collection->Attachment->validates()) {
				if ($this->Collection->save($this->request->data)) {
					if ($ini_upload_error && !empty($this->request->data['Attachment']['filename']['name'])) {
						$this->request->data['Attachment']['foreign_id'] = $this->Collection->getLastInsertId();
						$this->request->data['Attachment']['class'] = 'Collection';
						$this->Collection->Attachment->create();
						$this->Collection->Attachment->save($this->request->data);
					}
					$this->Session->setFlash(__l('Collection has been added') , 'default', null, 'success');
					$this->redirect(array(
						'action' => 'index'
					));
				} else {
					$this->Session->setFlash(__l(' Collection could not be added. Please, try again.') , 'default', null, 'error');
				}
			} else {
				$this->Session->setFlash(__l(' Collection could not be added. Please, try again.') , 'default', null, 'error');
			}
        }
        $properties = $this->Collection->Property->find('list');
        $users = $this->Collection->User->find('list');
        $this->set(compact('properties', 'users'));
    }
    public function admin_add_collection()
    {
        if (!empty($this->request->data)) {
			if(!empty($this->request->data['Collection']['Collection'])){
            $property_ids = explode(',', $this->request->data['Collection']['property_list']);
            foreach($property_ids as $id) {
                foreach($this->request->data['Collection']['Collection'] as $collection) {
                    $collection_count = $this->Collection->CollectionsProperty->find('count', array(
                        'conditions' => array(
                            'CollectionsProperty.property_id = ' => $id,
                            'CollectionsProperty.collection_id = ' => $collection,
                        ) ,
                        'recursive' => -1,
                    ));
                    if ($collection_count == 0) {
                        $data = array();
                        $data['CollectionsProperty']['collection_id'] = $collection;
                        $data['CollectionsProperty']['property_id'] = $id;
                        $this->Collection->CollectionsProperty->create();
                        $this->Collection->CollectionsProperty->save($data, false);
                        $this->Collection->CollectionsProperty->updateAll(array(
                            'CollectionsProperty.display_order' => $this->Collection->CollectionsProperty->getLastInsertId()
                        ) , array(
                            'CollectionsProperty.id' => $this->Collection->CollectionsProperty->getLastInsertId()
                        ));
                        $this->Collection->updateCount($collection, $id);
                    }
                }
            }
            //update collection count and property count
            $this->Session->setFlash(__l('Properties mapped with collections successfully') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'properties',
                'action' => 'index'
            ));
		} else{
			$this->Session->setFlash(__l('Collection cannot be empty please select collection and try again') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'properties',
                'action' => 'index'
            ));
		}
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Collection');
        $this->Collection->Behaviors->attach('ImageUpload', Configure::read('image.file'));
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            $this->request->data['Attachment']['class'] = 'Collection';
            $ini_upload_error = 1;
            if ($this->request->data['Attachment']['filename']['error'] == 1) {
                $ini_upload_error = 0;
            }
            if (!empty($this->request->data['CollectionsProperty'])) {
                foreach($this->request->data['CollectionsProperty'] as $key => $val) {
                    $this->Collection->CollectionsProperty->updateAll(array(
                        'CollectionsProperty.display_order' => $val['display_order'],
                    ) , array(
                        'CollectionsProperty.property_id' => $key,
                        'CollectionsProperty.collection_id' => $this->request->data['Collection']['id'],
                    ));
                }
                unset($this->request->data['CollectionsProperty']);
            }
            // save collections mapped proties
            //first delete all the mapped properties for this collections
            if (!empty($this->request->data['Property'])) {
                foreach($this->request->data['Property'] as $key => $val) {
                    if ($val['id'] == 1) {
                        $this->Collection->CollectionsProperty->deleteAll(array(
                            'CollectionsProperty.collection_id' => $this->request->data['Collection']['id'],
                            'CollectionsProperty.property_id' => $key
                        ));
                    }
                    $this->Collection->updateCount($this->request->data['Collection']['id'], $key);
                    unset($this->request->data['Property']);
                }
            }
            // @todo "Collage Script"
            if ($this->Collection->save($this->request->data)) {
                if ($ini_upload_error && !empty($this->request->data['Attachment']['filename']['name'])) {
                    $this->request->data['Attachment']['foreign_id'] = $this->request->data['Collection']['id'];
                    $this->request->data['Attachment']['class'] = 'Collection';
                    if (empty($this->request->data['Attachment']['id'])) {
                        $this->Collection->Attachment->create();
                    }
                    $this->Collection->Attachment->save($this->request->data);
                }
                $this->Session->setFlash(__l('Collection has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Collection could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Collection->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Collection']['title'];
        $users = $this->Collection->User->find('list');
        $ids = $this->Collection->CollectionsProperty->find('list', array(
            'conditions' => array(
                'CollectionsProperty.collection_id' => $this->request->data['Collection']['id']
            ) ,
            'fields' => array(
                'CollectionsProperty.id',
                'CollectionsProperty.property_id'
            ) ,
			'recursive' => -1,
        ));
        $properties = $this->Collection->Property->find('all', array(
            'conditions' => array(
                'Property.id' => $ids
            ) ,
            'contain' => array(
                'User',
                'Country',
                'Attachment',
            ) ,
            'recursive' => 2
        ));
        $i = 0;
        foreach($properties as $property) {
            $collection = $this->Collection->CollectionsProperty->find('first', array(
                'conditions' => array(
                    'CollectionsProperty.property_id = ' => $property['Property']['id'],
                    'CollectionsProperty.collection_id = ' => $this->request->data['Collection']['id']
                ) ,
                'fields' => array(
                    'CollectionsProperty.display_order',
                ) ,
                'recursive' => -1,
            ));
            $properties[$i]['Property']['display_order'] = $collection['CollectionsProperty']['display_order'];
            $i++;
        }
        //Sorting code start here
        // compare function
		function cmpi($a, $b)
		{
		    if ($a['Property']['display_order'] == $b['Property']['display_order']) {
		        return 0;
		    }
		    return ($a['Property']['display_order'] < $b['Property']['display_order']) ? -1 : 1;
		}
        // do the array sorting
        usort($properties, 'cmpi');
        //sorting code ends here
        $this->set('properties', $properties);
        $moreActions = $this->Collection->moreActionsProperty;
        $this->set(compact('moreActions'));
        //$properties = $this->Collection->Property->find('list');
        $this->set(compact('users', 'moreActions'));
    }
    public function admin_delete_property($property_id = null, $id = null)
    {
        if (is_null($id) || is_null($property_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Collection->CollectionsProperty->deleteAll(array(
            'CollectionsProperty.collection_id' => $id,
            'CollectionsProperty.property_id' => $property_id
        ))) {
            $this->Collection->updateCount($id, $property_id);
            $this->Session->setFlash(__l('Property deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'edit',
                $id
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Collection->delete($id)) {
            $this->Session->setFlash(__l('Collection deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>