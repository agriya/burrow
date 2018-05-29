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
class UserEducationsController extends AppController
{
    public $name = 'UserEducations';
    public function admin_index()
    {
        $this->pageTitle = __l('Educations');
        $conditions = array();
        $this->set('active', $this->UserEducation->find('count', array(
            'conditions' => array(
                'UserEducation.is_active' => 1
            ) ,
            'recursive' => -1
        )));
        $this->set('inactive', $this->UserEducation->find('count', array(
            'conditions' => array(
                'UserEducation.is_active' => 0
            ) ,
            'recursive' => -1
        )));
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['UserEducation.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['UserEducation.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'UserEducation.id' => 'desc'
            ) ,
            'recursive' => -1
        );
        $this->set('userEducations', $this->paginate());
        $moreActions = $this->UserEducation->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Education');
        if (!empty($this->request->data)) {
            $this->UserEducation->create();
            if ($this->UserEducation->save($this->request->data)) {
                $this->Session->setFlash(__l('Education has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Education could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        // Quick Fix // initialize model to use in form helper
        $moreActions = $this->UserEducation->moreActions;
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Education');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->UserEducation->save($this->request->data)) {
                $this->Session->setFlash(__l('Education has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Education could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->UserEducation->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserEducation->delete($id)) {
            $this->Session->setFlash(__l('Education deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>