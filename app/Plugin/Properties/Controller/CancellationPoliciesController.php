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
class CancellationPoliciesController extends AppController
{
    public $name = 'CancellationPolicies';
    public function admin_index()
    {
        $this->pageTitle = __l('Cancellation Policies');
        $conditions = array();
        $this->set('active', $this->CancellationPolicy->find('count', array(
            'conditions' => array(
                'CancellationPolicy.is_active' => 1
            ) ,
            'recursive' => -1
        )));
        $this->set('inactive', $this->CancellationPolicy->find('count', array(
            'conditions' => array(
                'CancellationPolicy.is_active' => 0
            ) ,
            'recursive' => -1
        )));
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['CancellationPolicy.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['CancellationPolicy.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'CancellationPolicy.id' => 'desc'
            ) ,
            'recursive' => -1
        );
        $this->set('cancellationPolicies', $this->paginate());
        $moreActions = $this->CancellationPolicy->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Cancellation Policy');
        if (!empty($this->request->data)) {
            $this->CancellationPolicy->create();
            if ($this->CancellationPolicy->save($this->request->data)) {
                $this->Session->setFlash(__l('Cancellation Policy has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Cancellation Policy could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        // Quick Fix // initialize model to use in form helper
        $moreActions = $this->CancellationPolicy->moreActions;
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Cancellation Policy');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->CancellationPolicy->save($this->request->data)) {
                $this->Session->setFlash(__l('Cancellation Policy has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Cancellation Policy could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->CancellationPolicy->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['CancellationPolicy']['name'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $properties_count = $this->CancellationPolicy->Property->find('count', array(
            'conditions' => array(
                'Property.cancellation_policy_id' => $id
            ) ,
            'recursive' => -1
        ));
        if (!empty($properties_count)) {
            $this->Session->setFlash(__l('Cancellation policy was assigned to some properties.') , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if ($this->CancellationPolicy->delete($id)) {
            $this->Session->setFlash(__l('Cancellation Policy deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>