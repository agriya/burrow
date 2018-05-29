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
class UserRelationshipsController extends AppController
{
    public $name = 'UserRelationships';
    public function admin_index()
    {
        $this->pageTitle = __l('Relationships');
        $conditions = array();
        $this->set('active', $this->UserRelationship->find('count', array(
            'conditions' => array(
                'UserRelationship.is_active' => 1
            ) ,
            'recursive' => -1
        )));
        $this->set('inactive', $this->UserRelationship->find('count', array(
            'conditions' => array(
                'UserRelationship.is_active' => 0
            ) ,
            'recursive' => -1
        )));
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['UserRelationship.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['UserRelationship.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'UserRelationship.id' => 'desc'
            ) ,
            'recursive' => -1
        );
        $this->set('userRelationships', $this->paginate());
        $moreActions = $this->UserRelationship->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Relationship');
        if (!empty($this->request->data)) {
            $this->UserRelationship->create();
            if ($this->UserRelationship->save($this->request->data)) {
                $this->Session->setFlash(__l('Relationship has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Relationship could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        // Quick Fix // initialize model to use in form helper
        $moreActions = $this->UserRelationship->moreActions;
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit  Relationship');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->UserRelationship->save($this->request->data)) {
                $this->Session->setFlash(__l('Relationship has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Relationship could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->UserRelationship->read(null, $id);
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
        if ($this->UserRelationship->delete($id)) {
            $this->Session->setFlash(__l('Relationship deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>