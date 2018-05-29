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
class RequestFlagCategoriesController extends AppController
{
    public $name = 'RequestFlagCategories';
    public function admin_index()
    {
        $this->pageTitle = __l('Request Flag Categories');
        $conditions = array();
        $this->set('active', $this->RequestFlagCategory->find('count', array(
            'conditions' => array(
                'RequestFlagCategory.is_active' => 1
            ) ,
            'recursive' => -1
        )));
        $this->set('inactive', $this->RequestFlagCategory->find('count', array(
            'conditions' => array(
                'RequestFlagCategory.is_active' => 0
            ) ,
            'recursive' => -1
        )));
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['RequestFlagCategory.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['RequestFlagCategory.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'RequestFlagCategory.id' => 'desc'
            ) ,
            'recursive' => -1
        );
        $this->set('requestFlagCategories', $this->paginate());
        $filters = $this->RequestFlagCategory->isFilterOptions;
        $moreActions = $this->RequestFlagCategory->moreActions;
        $this->set(compact('moreActions', 'filters'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Request Flag Category');
        if (!empty($this->request->data)) {
            $this->RequestFlagCategory->create();
            if ($this->RequestFlagCategory->validates($this->request->data)) {
                if ($this->RequestFlagCategory->save($this->request->data)) {
                    $this->Session->setFlash(__l('Request Flag Category has been added') , 'default', null, 'success');
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                }
            } else {
                $this->Session->setFlash(__l('Request Flag Category could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $users = $this->RequestFlagCategory->User->find('list');
        $this->set(compact('users'));
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Request Flag Category');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->RequestFlagCategory->save($this->request->data)) {
                $this->Session->setFlash(__l('Request Flag Category has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Request Flag Category could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->RequestFlagCategory->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['RequestFlagCategory']['name'];
        $users = $this->RequestFlagCategory->User->find('list');
        $this->set(compact('users'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->RequestFlagCategory->delete($id)) {
            $this->Session->setFlash(__l('Request Flag Category deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>