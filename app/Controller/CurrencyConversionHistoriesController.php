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
class CurrencyConversionHistoriesController extends AppController
{
    public $name = 'CurrencyConversionHistories';
    public function admin_index()
    {
        $this->pageTitle = __l('History');
        $this->CurrencyConversionHistory->recursive = 0;
        $this->paginate = array(
            'contain' => array(
                'CurrencyConversion' => array(
                    'Currency' => array(
                        'fields' => array(
                            'Currency.id',
                            'Currency.name',
                            'Currency.code',
                        )
                    ) ,
                    'ConvertedCurrency' => array(
                        'fields' => array(
                            'ConvertedCurrency.id',
                            'ConvertedCurrency.name',
                            'ConvertedCurrency.code',
                        )
                    ) ,
                )
            ) ,
            'order' => array(
                'CurrencyConversionHistory.id' => 'desc'
            )
        );
        $this->set('currencyConversionHistories', $this->paginate());
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->CurrencyConversionHistory->id = $id;
        if (!$this->CurrencyConversionHistory->exists()) {
            throw new NotFoundException(__l('Invalid currency conversion history'));
        }
        if ($this->CurrencyConversionHistory->delete()) {
            $this->Session->setFlash(__l('Currency conversion history deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $this->Session->setFlash(__l('Currency conversion history was not deleted') , 'default', null, 'error');
        $this->redirect(array(
            'action' => 'index'
        ));
    }
}
