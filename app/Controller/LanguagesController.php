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
class LanguagesController extends AppController
{
    public $name = 'Languages';
    public function admin_index()
    {
        $param_string = "";
        $this->pageTitle = __l('Languages');
        $conditions = array();
        if (!empty($this->request->data['Language']['filter_id'])) {
            $this->request->params['named']['filter_id'] = $this->request->data['Language']['filter_id'];
        }
        if (!empty($this->request->data['Language']['q'])) {
            $this->request->params['named']['q'] = $this->request->data['Language']['q'];
        }
        $param_string.= !empty($this->request->params['named']['filter_id']) ? '/filter_id:' . $this->request->params['named']['filter_id'] : $param_string;
        if (isset($this->request->params['named']['q']) && !empty($this->request->params['named']['q'])) {
            $this->request->data['Language']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
            $param_string = '/q:' . $this->request->params['named']['q'];
        }
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['Language.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['Language.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'Language.name' => 'asc'
            ) ,
            'recursive' => -1
        );
        if (!empty($this->request->params['named']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->params['named']['q']
            ));
        }
        $this->set('param_string', $param_string);
        $this->set('languages', $this->paginate());
        $this->set('pending', $this->Language->find('count', array(
            'conditions' => array(
                'Language.is_active = ' => 0
            ) ,
            'recursive' => -1
        )));
        $this->set('approved', $this->Language->find('count', array(
            'conditions' => array(
                'Language.is_active = ' => 1
            ) ,
            'recursive' => -1
        )));
        $moreActions = $this->Language->moreActions;
        $this->set(compact('moreActions'));
        $this->set('pageTitle', $this->pageTitle);
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Language');
        if (!empty($this->request->data)) {
            $this->Language->create();
            if ($this->Language->save($this->request->data)) {
                $this->Session->setFlash(__l('Language has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Language could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        // Quick Fix // initialize model to use in form helper
        $moreActions = $this->Language->moreActions;
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Language');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->Language->save($this->request->data)) {
                $this->Session->setFlash(__l('Language  has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Language  could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Language->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Language']['name'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Language->delete($id)) {
            $this->Session->setFlash(__l('Language deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
	public function change_language()
    {
		$this->request->data['Language']['language_id'] = !empty($this->request->params['named']['language_id'])?$this->request->params['named']['language_id']:'';
		$this->request->data['Language']['f'] = !empty($this->request->params['named']['f'])?$this->request->params['named']['f']:$_GET['f'];
        if (!empty($this->request->data)) {
            if ($this->Auth->user('id')) {
                $this->Cookie->write('user_language', $this->request->data['Language']['language_id'], false);
            } else {
                $this->Cookie->write('user_language', $this->request->data['Language']['language_id'], false, time() +60*60*4);
            }
			if ($this->request->data['Language']['f'] == 'users/show_header.js') {
				$this->request->data['Language']['f'] = '';
			}
            $this->redirect(Router::url('/', true) . $this->request->data['Language']['f']);
        } else {
            $this->redirect(Router::url('/', true));
        }
    }
}
?>