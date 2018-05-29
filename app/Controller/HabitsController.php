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
class HabitsController extends AppController
{
    public $name = 'Habits';
    public function admin_index()
    {
        $this->pageTitle = __l('Habits');
        $conditions = array();
        $this->set('active', $this->Habit->find('count', array(
            'conditions' => array(
                'Habit.is_active' => 1
            ) ,
            'recursive' => -1
        )));
        $this->set('inactive', $this->Habit->find('count', array(
            'conditions' => array(
                'Habit.is_active' => 0
            ) ,
            'recursive' => -1
        )));
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['Habit.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['Habit.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'Habit.id' => 'desc'
            ) ,
            'recursive' => -1
        );
        $this->set('habits', $this->paginate());
        $moreActions = $this->Habit->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Habit');
        if (!empty($this->request->data)) {
            $this->Habit->create();
            if ($this->Habit->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Habit has been added') , $this->request->data['Habit']['name']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Habit could not be added. Please, try again.') , $this->request->data['Habit']['name']) , 'default', null, 'error');
            }
        }
        // Quick Fix // initialize model to use in form helper
        $moreActions = $this->Habit->moreActions;
        $userProfiles = $this->Habit->UserProfile->find('list');
        $this->set(compact('userProfiles'));
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Habit');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->Habit->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Habit has been updated') , $this->request->data['Habit']['name']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Habit could not be updated. Please, try again.') , $this->request->data['Habit']['name']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Habit->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Habit']['name'];
        $userProfiles = $this->Habit->UserProfile->find('list');
        $this->set(compact('userProfiles'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Habit->delete($id)) {
            $this->Session->setFlash(__l('Habit deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>