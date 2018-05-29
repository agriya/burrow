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
class SearchLogsController extends AppController
{
    public $name = 'SearchLogs';
    public function admin_index()
    {
        $this->pageTitle = __l('Search Logs');
        $this->SearchLog->recursive = 3;
        $conditions = array();
        $order = array(
            'SearchLog.id' => 'DESC'
        );
        $this->_redirectGET2Named(array(
            'q'
        ));
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['SearchLog.created ='] = date('Y-m-d', strtotime('now'));
            $this->pageTitle.= __l(' - Registered today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['SearchLog.created >='] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - Registered in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['SearchLog.created >='] = date('Y-m-d', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - Registered in this month');
        }
        if (isset($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'SearchKeyword.keyword LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Ip.ip LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    )
                )
            );
            //$this->paginate = array('conditions' => $conditions);
            $this->request->data['SearchLog']['q'] = $this->request->params['named']['q'];
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
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
                'SearchKeyword',
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username'
                    )
                ) ,
            ) ,
            'order' => $order
        );
        $moreActions = $this->SearchLog->moreActions;
        $this->set(compact('moreActions'));
        $this->set('searchLogs', $this->paginate());
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->SearchLog->delete($id)) {
            $this->Session->setFlash(__l('Search Log deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>