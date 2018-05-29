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
class SecurityQuestionsController extends AppController
{
    public $name = 'SecurityQuestions';
    public function admin_index()
    {
		$this->pageTitle = __l('Security Questions');
        $this->paginate = array();
		$this->set('approved', $this->SecurityQuestion->find('count', array(
            'conditions' => array(
                'SecurityQuestion.is_active' => 1
            ) ,
            'recursive' => -1
        )));
		$this->set('pending', $this->SecurityQuestion->find('count', array(
            'conditions' => array(
                'SecurityQuestion.is_active' => 0
            ) ,
            'recursive' => -1
        )));
		if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['SecurityQuestion']['filter_id'] = $this->request->params['named']['filter_id'];
        }
		$conditions = array();
		if (!empty($this->request->data['SecurityQuestion']['filter_id'])) {
			if ($this->request->data['SecurityQuestion']['filter_id'] == ConstMoreAction::Active) {
                $conditions['SecurityQuestion.is_active'] = 1;
                $this->pageTitle.= ' - ' . __l('Active');
            }
			else if ($this->request->data['SecurityQuestion']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['SecurityQuestion.is_active'] = 0;
                $this->pageTitle.= ' - ' . __l('Inactive');
            }
		}
		$this->paginate=array('conditions' => $conditions);
        $questions = $this->paginate();
        $this->set('questions', $questions);
        $moreActions = $this->SecurityQuestion->moreActions;
        $this->set('moreActions',$moreActions);
    }
    public function admin_add()
    {
        $this->pageTitle = sprintf(__l('Add %s'), __l('Question'));
		if (!empty($this->request->data)) {
			 $this->SecurityQuestion->set($this->request->data);
             $this->SecurityQuestion->create();
			 if ($this->SecurityQuestion->save($this->request->data)) {
			 	$this->Session->setFlash(sprintf(__l('%s has been added'), __l('Security Question')), 'default', null, 'success');
			 } else {
			 	$this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('Security Question')), 'default', null, 'error');
			 }
			$this->redirect(array(
				'controller' => 'security_questions',
				'action' => 'index',
				'admin' => true
			));
		}
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = sprintf(__l('Edit %s'), __l('Question'));
        if (!empty($this->request->data)) {
			$this->SecurityQuestion->set($this->request->data);
			$this->SecurityQuestion->create();
			if( $this->SecurityQuestion->save($this->request->data)) {
				$this->Session->setFlash(sprintf(__l('%s has been updated'), __l('Security Question')), 'default', null, 'success');
			}	else {
				$this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('Security Question')), 'default', null, 'error');
			}
			$this->redirect(array(
				'controller' => 'security_questions',
				'action' => 'index',
				'admin' => true
			));
		} else {
			$this->request->data = $this->SecurityQuestion->find('first', array(
				'conditions' => array(
					'SecurityQuestion.id = ' => $id,
				) ,
				'recursive' => -1
			));
        }
    }
}
?>