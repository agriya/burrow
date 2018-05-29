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
class SiteCategoriesController extends AppController
{
    public $name = 'SiteCategories';
    public function admin_index()
    {
        $this->pageTitle = __l('Site Categories');
        $this->SiteCategory->recursive = 0;
        $this->set('siteCategories', $this->paginate());
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Site Category');
        if (!empty($this->request->data)) {
            $this->SiteCategory->create();
            if ($this->SiteCategory->save($this->request->data)) {
                $this->Session->setFlash(__l('Site Category has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Site Category could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Site Category');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->SiteCategory->save($this->request->data)) {
                $this->Session->setFlash(__l('Site Category has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Site Category could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->SiteCategory->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['SiteCategory']['name'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->SiteCategory->delete($id)) {
            $this->Session->setFlash(__l('Site Category deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>