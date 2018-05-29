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
class PropertyViewsController extends AppController
{
    public $name = 'PropertyViews';
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'property_id',
            'q'
        ));
        $this->pageTitle = __l('Property Views');
        $conditions = array();
        // check the filer passed through named parameter
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['PropertyView.created ='] = date('Y-m-d', strtotime('now'));
            $this->pageTitle.= __l(' - today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['PropertyView.created >='] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['PropertyView.created >='] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - in this month');
        }
        if (!empty($this->request->params['named']['project'])) {
            $project = $this->PropertyView->Property->find('first', array(
                'conditions' => array(
                    'Property.slug' => $this->request->params['named']['project']
                ) ,
                'fields' => array(
                    'Property.id',
                    'Property.title'
                ) ,
                'recursive' => -1
            ));
            $conditions['PropertyView.property_id'] = $project['Property']['id'];
            $this->pageTitle.= ' - ' . $project['Property']['title'];
        }
        if (isset($this->request->params['named']['q'])) {
            $conditions['AND']['OR'][]['Property.title LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $conditions['AND']['OR'][]['User.username LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
			$this->request->data['PropertyView']['q'] = $this->request->params['named']['q'];
        }
        if (!empty($this->request->params['named']['property_id'])) {
            $conditions['PropertyView.property_id'] = $this->request->params['named']['property_id'];
            $project_name = $this->PropertyView->Property->find('first', array(
                'conditions' => array(
                    'Property.id' => $this->request->params['named']['property_id'],
                ) ,
                'fields' => array(
                    'Property.title',
                ) ,
                'recursive' => -1,
            ));
            $this->pageTitle.= sprintf(__l(' - %s') , $project_name['Property']['title']);
        }
        $this->PropertyView->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.username'
                    )
                ) ,
                'Property',
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
            'order' => array(
                'PropertyView.id' => 'desc'
            ) ,
        );
        $this->set('propertyViews', $this->paginate());
        $moreActions = $this->PropertyView->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->PropertyView->delete($id)) {
            $this->Session->setFlash(__l('Property View deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>