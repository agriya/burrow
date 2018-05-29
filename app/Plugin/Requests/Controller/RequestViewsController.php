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
class RequestViewsController extends AppController
{
    public $name = 'RequestViews';
    public function admin_index()
    {
        $this->pageTitle = __l('Request Views');
        $conditions = array();
        $this->_redirectGET2Named(array(
            'q',
        ));
        // check the filer passed through named parameter
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['RequestView.created ='] = date('Y-m-d', strtotime('now'));
            $this->pageTitle.= __l(' - today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
			$conditions['RequestView.created >='] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
			$conditions['RequestView.created >='] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - in this month');
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['RequestView']['q'] = $this->request->params['named']['q'];
			$conditions['AND']['OR'][]['Request.title LIKE'] = '%' . $this->request->params['named']['q'] . '%';
			$conditions['AND']['OR'][]['User.username LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (!empty($this->request->params['named']['request'])) {
            $request = $this->RequestView->Request->find('first', array(
                'conditions' => array(
                    'Request.slug' => $this->request->params['named']['request']
                ) ,
                'fields' => array(
                    'Request.id',
                    'Request.title'
                ) ,
                'recursive' => -1
            ));
            $conditions['RequestView.request_id'] = $request['Request']['id'];
            $this->pageTitle.= ' - ' . $request['Request']['title'];
        }
        if (!empty($this->request->params['named']['request_id'])) {
            $conditions['RequestView.request_id'] = $this->request->params['named']['request_id'];
            $project_name = $this->RequestView->Request->find('first', array(
                'conditions' => array(
                    'Request.id' => $this->request->params['named']['request_id'],
                ) ,
                'fields' => array(
                    'Request.title',
                ) ,
                'recursive' => -1,
            ));
            $this->pageTitle.= sprintf(__l(' - %s') , $project_name['Request']['title']);
        }
        $this->RequestView->recursive = 0;
        $this->RequestView->order = array(
            'RequestView.id' => 'desc'
        );
        $this->paginate = array(
          'contain' => array(
                'Request' => array(
                    'fields' => array(
                        'Request.title',
                        'Request.slug',
                        'Request.id',
                    ) ,
                ) ,
				'User',
                'Ip' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name',
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name',
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2',
                            )
                        ) ,
                        'Timezone' => array(
                            'fields' => array(
                                'Timezone.name',
                            )
                        ) ,
                        'fields' => array(
                            'Ip.ip',
                            'Ip.latitude',
                            'Ip.longitude',
                            'Ip.host',
                        )
                    ) ,
            ) ,
            'conditions' => $conditions,
        );
        $this->set('requestViews', $this->paginate());
        $moreActions = $this->RequestView->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->RequestView->delete($id)) {
            $this->Session->setFlash(__l('Request View deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>