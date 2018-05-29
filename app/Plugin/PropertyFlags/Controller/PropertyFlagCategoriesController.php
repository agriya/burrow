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
class PropertyFlagCategoriesController extends AppController
{
    public $name = 'PropertyFlagCategories';
    public function beforeFilter()
    {
        parent::beforeFilter();
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Property Flag Categories');
        $conditions = array();
        $this->set('active', $this->PropertyFlagCategory->find('count', array(
            'conditions' => array(
                'PropertyFlagCategory.is_active' => 1
            ) ,
            'recursive' => -1
        )));
        $this->set('inactive', $this->PropertyFlagCategory->find('count', array(
            'conditions' => array(
                'PropertyFlagCategory.is_active' => 0
            ) ,
            'recursive' => -1
        )));
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['PropertyFlagCategory.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['PropertyFlagCategory.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'PropertyFlagCategory.id' => 'desc'
            ) ,
            'recursive' => -1
        );
        $this->set('propertyFlagCategories', $this->paginate());
        $filters = $this->PropertyFlagCategory->isFilterOptions;
        $moreActions = $this->PropertyFlagCategory->moreActions;
        $this->set(compact('moreActions', 'filters'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add') . ' ' . __l('Flag Category');
        if (!empty($this->request->data)) {
            $this->PropertyFlagCategory->create();
            if ($this->PropertyFlagCategory->save($this->request->data)) {
                $this->Session->setFlash(__l('Flag Category has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Flag Category could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        // Quick Fix // initialize model to use in form helper
        $moreActions = $this->PropertyFlagCategory->moreActions;
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Flag Category');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->PropertyFlagCategory->save($this->request->data)) {
                $this->Session->setFlash(__l('Flag Category has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Flag Category could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->PropertyFlagCategory->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['PropertyFlagCategory']['name'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->PropertyFlagCategory->delete($id)) {
            $this->Session->setFlash(__l('Flag Category deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>