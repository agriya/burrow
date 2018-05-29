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
class EmailTemplatesController extends AppController
{
    public $name = 'EmailTemplates';
    public function admin_index()
    {
        $this->pageTitle = __l('Email Templates');
        $emailTemplates = $this->EmailTemplate->find('all', array(
            'recursive' => -1
        ));
        $this->set('emailTemplates', $emailTemplates);
    }
    public function admin_edit($id = null)
    {
        $this->disableCache();
        $this->pageTitle = __l('Edit Email Template');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->EmailTemplate->save($this->request->data)) {
                $this->Session->setFlash(__l('Email Template has been updated') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('Email Template could not be updated. Please, try again.') , 'default', null, 'error');
            }
            $emailTemplate = $this->EmailTemplate->find('first', array(
                'conditions' => array(
                    'EmailTemplate.id' => $this->request->data['EmailTemplate']['id']
                ) ,
                'fields' => array(
                    'EmailTemplate.name',
                    'EmailTemplate.email_variables'
                ) ,
                'recursive' => -1
            ));
            $this->request->data['EmailTemplate']['name'] = $emailTemplate['EmailTemplate']['name'];
            $this->request->data['EmailTemplate']['email_variables'] = $emailTemplate['EmailTemplate']['email_variables'];
        } else {
            $this->request->data = $this->EmailTemplate->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['EmailTemplate']['name'];
        $this->set('email_variables', explode(',', $this->request->data['EmailTemplate']['email_variables']));
    }
}
?>