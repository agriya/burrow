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
class CitiesController extends AppController
{
    public $name = 'Cities';
	public $permanentCacheAction = array(
		'public' => array(
			'index',
		) ,
    );
    public function index()
    {
        $this->paginate = array(
            'conditions' => array(
                'City.is_approved' => 1,
            ) ,
            'fields' => array(
                'City.name',
                'City.slug',
                'City.property_count',
                'City.country_id',
                'City.request_count',
            ) ,
            'contain' => array(
                'Country' => array(
                    'fields' => array(
                        'Country.name',
                        'Country.iso_alpha2',
                    )
                ) ,
            ) ,
            'order' => array(
                'City.property_count' => 'desc',
                'City.request_count' => 'desc',
                'City.name' => 'asc'
            ) ,
            'limit' => 18,
            'recursive' => 1
        );
        $this->set('cities', $this->paginate());
        $this->set('all_property_count', $this->City->Property->find('count', array(
            'conditions' => array(
                'Property.is_approved = ' => 1,
                'Property.is_active = ' => 1,
                'Property.admin_suspend = ' => 0,
            ) ,
            'recursive' => -1
        )));
		
		if(isPluginEnabled('Requests')){
        $this->set('all_request_count', $this->City->Request->find('count', array(
            'conditions' => array(
                'Request.is_approved = ' => 1,
                'Request.is_active = ' => 1,
                'Request.checkin >=' => date('Y-m-d') ,
            ) ,
            'recursive' => -1
        )));
		}
    }
    public function admin_index()
    {
        $this->_redirectPOST2Named(array(
            'filter_id',
            'q'
        ));
        $this->disableCache();
        $this->pageTitle = __l('Cities');
        $conditions = array();
        $this->City->validate = array();
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data[$this->modelClass]['filter_id'] = $this->request->params['named']['filter_id'];
        }
        $this->set('active', $this->City->find('count', array(
            'conditions' => array(
                'City.is_approved' => 1
            ) ,
            'recursive' => -1
        )));
        $this->set('inactive', $this->City->find('count', array(
            'conditions' => array(
                'City.is_approved' => 0
            ) ,
            'recursive' => -1
        )));
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['City.is_approved'] = 1;
                $this->pageTitle.= __l(' - Approved');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['City.is_approved'] = 0;
                $this->pageTitle.= __l(' - Disapproved');
            }
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['City']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->City->recursive = 0;
		if (isset($this->request->data['City']['q'])) {
            $conditions['City.name LIKE'] = '%' . $this->request->data['City']['q'] . '%';
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'City.id',
                'City.name',
                'City.latitude',
                'City.longitude',
                'City.timezone',
                'City.county',
                'City.code',
                'City.is_approved',
                'State.name',
                'Country.name',
            ) ,
            'order' => array(
                'City.name' => 'asc'
            ) ,
            'limit' => 15
        );
        
        $this->set('cities', $this->paginate());
        $filters = $this->City->isFilterOptions;
        $moreActions = $this->City->moreActions;
        $this->set(compact('filters', 'moreActions'));
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit City');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->City->save($this->request->data)) {
                $this->Session->setFlash(__l('City has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('City could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->City->find('first', array(
                'conditions' => array(
                    'City.id' => $id
                ) ,
                'recursive' => -1
            ));
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['City']['name'];
        $countries = $this->City->Country->find('list');
        $states = $this->City->State->find('list', array(
            'conditions' => array(
                'State.is_approved' => 1
            ),
			'recursive' => -1,
        ));
        $this->set(compact('countries', 'states'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add City');
        if (!empty($this->request->data)) {
            $this->request->data['City']['is_approved'] = 1;
            $this->City->create();
            if ($this->City->save($this->request->data)) {
                $this->Session->setFlash(__l(' City has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l(' City could not be added. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data['City']['is_approved'] = 1;
        }
        $countries = $this->City->Country->find('list');
        $states = $this->City->State->find('list', array(
            'conditions' => array(
                'State.is_approved =' => 1
            ) ,
            'order' => array(
                'State.name'
            ),
			'recursive' => -1,
        ));
        $this->set(compact('countries', 'states'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->City->delete($id)) {
            $this->Session->setFlash(__l('City deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>