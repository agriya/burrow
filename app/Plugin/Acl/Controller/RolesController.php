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
class RolesController extends AppController
{
    public $name = 'Roles';
    public $helpers = array(
        'Tree'
    );
    function admin_index() 
    {
        $this->pageTitle = __l('Roles');
        $Roles = $this->Role->find('threaded', array(
            'order' => array(
                'Role.id' => 'desc'
            ) ,
            'recursive' => -1
        ));
        $this->set('Roles', $Roles);
    }
    function admin_add($parent_id = null) 
    {
        $this->pageTitle = sprintf(__l('Add %s') , __l('Role'));
        if (!empty($this->request->data['Role']['parent_id'])) {
            $parent_id = $this->request->data['Role']['parent_id'];
        }
        if (!empty($parent_id)) {
            $parentRole = $this->Role->find('first', array(
                'conditions' => array(
                    'Role.id' => $parent_id
                ) ,
                'recursive' => -1
            ));
            $this->pageTitle.= ' | ' . $parentRole['Role']['name'];
            $this->set('parentRole', $parentRole);
        }
        if (!empty($this->request->data)) {
            $this->Role->create();
            if ($this->Role->save($this->request->data)) {
                $role_id = $this->Role->getLastInsertId();
                $aclLinks = $this->Role->AclLink->find('all', array(
                    'fields' => array(
                        'AclLink.id'
                    ) ,
                    'recursive' => -1
                ));
                foreach($aclLinks as $aclLink) {
                    $aclLinkRole = array();
                    $aclLinkRole['AclLinksRole']['role_id'] = $role_id;
                    $aclLinkRole['AclLinksRole']['acl_link_id'] = $aclLink['AclLink']['id'];
                    $aclLinkRole['AclLinksRole']['acl_link_status_id'] = ConstAclStatuses::Owner;
                    $this->Role->AclLink->AclLinksRole->create();
                    $this->Role->AclLink->AclLinksRole->save($aclLinkRole);
                }
                $this->Session->setFlash(sprintf(__l('%s has been added') , __l('Role')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Role')) , 'default', null, 'error');
            }
        }
        $this->set('parent_id', $parent_id);
    }
    function admin_edit($id = null) 
    {
        $this->pageTitle = sprintf(__l('Edit %s') , __l('Role'));
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->request->data)) {
            if ($this->Role->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Role')) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Role')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Role->find('first', array(
                'conditions' => array(
                    'Role.id' => $id
                ) ,
                'recursive' => -1
            ));
            if (empty($this->request->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Role']['name'];
    }
    function admin_delete($id = null) 
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->Role->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Role')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    public function admin_permission() 
    {
        $this->pageTitle = sprintf(__l('Edit %s') , __l('Permission'));
        $aclLinks = $this->Role->AclLink->find('all', array(
            'order' => array(
                'AclLink.id' => 'DESC'
            ) ,
            'recursive' => -1
        ));
        $this->set('aclLinks', $aclLinks);
        $roles = $this->Role->find('all', array(
            'recursive' => -1
        ));
        App::import('Model', 'Acl.AclLinkStatus');
        $this->AclLinkStatus = new AclLinkStatus();
        $aclLinkStatuses = $this->AclLinkStatus->find('all', array(
            'recursive' => -1
        ));
        $this->set(compact('aclLinkStatuses', 'roles'));
    }
    public function admin_toggle($link_id, $role_id, $status_id) 
    {
        if (is_null($link_id) || is_null($role_id) || is_null($status_id)) {
            throw new NotFoundException(__l('Invalid request'));
        } else {
            $aclLinksRole = array();
            $aclLinksRole['AclLinksRole']['role_id'] = $role_id;
            $aclLinksRole['AclLinksRole']['acl_link_id'] = $link_id;
            $aclLinksRole['AclLinksRole']['acl_link_status_id'] = $status_id;
            $acl_link_role = $this->Role->AclLink->AclLinksRole->find('first', array(
                'conditions' => array(
                    'AclLinksRole.role_id' => $role_id,
                    'AclLinksRole.acl_link_id' => $link_id
                ),
				'recursive' => -1,
            ));
            if (!empty($acl_link_role['AclLinksRole']['id'])) {
                $aclLinksRole['AclLinksRole']['id'] = $acl_link_role['AclLinksRole']['id'];
            } else {
                $this->Role->AclLink->AclLinksRole->create();
            }
            $this->Role->AclLink->AclLinksRole->save($aclLinksRole);
            $this->Session->setFlash(__l('Permission has been set successfully') , 'default', null, 'success');
            $this->redirect(array(
                'admin' => true,
                'controller' => 'roles',
                'action' => 'permission',
            ));
        }
    }
}
?>