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
class UserIncomeRangesController extends AppController
{
    public $name = 'UserIncomeRanges';
    public function admin_index()
    {
        $this->pageTitle = __l('Income Ranges');
        $conditions = array();
        $this->set('active', $this->UserIncomeRange->find('count', array(
            'conditions' => array(
                'UserIncomeRange.is_active' => 1
            ) ,
            'recursive' => -1
        )));
        $this->set('inactive', $this->UserIncomeRange->find('count', array(
            'conditions' => array(
                'UserIncomeRange.is_active' => 0
            ) ,
            'recursive' => -1
        )));
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['UserIncomeRange.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['UserIncomeRange.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'UserIncomeRange.id' => 'desc'
            ) ,
            'recursive' => -1
        );
        $this->set('userIncomeRanges', $this->paginate());
        $moreActions = $this->UserIncomeRange->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Income Range');
        if (!empty($this->request->data)) {
            $this->UserIncomeRange->create();
            if ($this->UserIncomeRange->save($this->request->data)) {
                $this->Session->setFlash(__l('Income Range has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Income Range could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        // Quick Fix // initialize model to use in form helper
        $moreActions = $this->UserIncomeRange->moreActions;
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Income Range');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->UserIncomeRange->save($this->request->data)) {
                $this->Session->setFlash(__l('Income Range has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Income Range could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->UserIncomeRange->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
		$this->pageTitle.= ' - ' . $this->request->data['UserIncomeRange']['income'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserIncomeRange->delete($id)) {
            $this->Session->setFlash(__l('Income Range deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>