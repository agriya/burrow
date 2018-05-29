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
class PropertyTypesController extends AppController
{
    public $name = 'PropertyTypes';
    public function admin_index()
    {
        $this->_redirectPOST2Named(array(
            'filter_id',
            'q'
        ));
		$this->pageTitle = __l('Property Types');
        $conditions = array();
        $this->set('active', $this->PropertyType->find('count', array(
            'conditions' => array(
                'PropertyType.is_active' => 1
            ) ,
            'recursive' => -1
        )));
        $this->set('inactive', $this->PropertyType->find('count', array(
            'conditions' => array(
                'PropertyType.is_active' => 0
            ) ,
            'recursive' => -1
        )));
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['PropertyType.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['PropertyType.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
		if (isset($this->request->params['named']['q'])) {
            $this->request->data['PropertyType']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
		if (isset($this->request->data['PropertyType']['q'])) {
            $conditions['PropertyType.name LIKE'] = '%' . $this->request->data['PropertyType']['q'] . '%';
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'PropertyType.id' => 'desc'
            ) ,
            'recursive' => -1
        );
        $this->set('propertyTypes', $this->paginate());
        $moreActions = $this->PropertyType->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Property Type');
        if (!empty($this->request->data)) {
            $this->PropertyType->create();
            if ($this->PropertyType->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Property Type has been added') , $this->request->data['PropertyType']['name']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Property Type could not be added. Please, try again.') , $this->request->data['PropertyType']['name']) , 'default', null, 'error');
            }
        }
        // Quick Fix // initialize model to use in form helper
        $moreActions = $this->PropertyType->moreActions;
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Property Type');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->PropertyType->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Property Type has been updated') , $this->request->data['PropertyType']['name']) , 'default', null, 'success');
				$this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Property Type could not be updated. Please, try again.') , $this->request->data['PropertyType']['name']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->PropertyType->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['PropertyType']['name'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->PropertyType->delete($id)) {
            $this->Session->setFlash(__l('Property Type deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>