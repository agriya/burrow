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
class Currency extends AppModel
{
    public $name = 'Currency';
    public $displayField = 'code';
    //$validate set in __construct for multi-language support
    public $hasMany = array(
        'CurrencyConversion' => array(
            'className' => 'CurrencyConversion',
            'foreignKey' => 'currency_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'name' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'code' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'symbol' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
    }
    function cacheCurrency($is_supported = null)
    {
        $conditions = array();
        $conditions['Currency.is_enabled'] = 1;
        $tmpCurrencies = $this->find('all', array(
            'conditions' => $conditions,
            'contain' => array(
                'CurrencyConversion' => array(
                    'fields' => array(
                        'converted_currency_id',
                        'rate',
                    )
                ) ,
            ) ,
            'fields' => array(
                'Currency.id',
                'Currency.name',
                'Currency.code',
                'Currency.symbol',
                'Currency.prefix',
                'Currency.dec_point',
                'Currency.thousands_sep',
                'Currency.is_prefix_display_on_left'
            ) ,
            'order' => array(
                'Currency.code' => 'ASC'
            ) ,
            'recursive' => 1
        ));
        if (!empty($tmpCurrencies)) {
            $i = 0;
            foreach($tmpCurrencies as $currency) {
                $currencies[$currency['Currency']['id']]['Currency'] = $currency['Currency'];
                if (!empty($currency['CurrencyConversion'])) {
                    $j = 0;
                    foreach($currency['CurrencyConversion'] as $currencyConversion) {
                        $currencies[$currency['Currency']['id']]['CurrencyConversion'][$currencyConversion['converted_currency_id']] = $currencyConversion['rate'];
                        $j++;
                    }
                }
                $i++;
            }
        }
        Cache::write('site_currencies', $currencies);
        return $currencies;
    }
    function afterSave($created)
    {
        Cache::delete('site_currencies');
		return true;
    }
    function afterDelete()
    {
        Cache::delete('site_currencies');
		return true;
    }
    function _retrieveCurrencies()
    {
        //Check whther we have already cached the currencies this session...
        //...we haven't, so load utility classes needed
        App::uses('HttpSocket', 'Network/Http');
        App::import('Xml');
        //Create an http socket
        $http = new HttpSocket();
        //And retrieve rates as an XML object
        $currencies = Xml::build('http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml');
        //Convert XML to array
        $currencies = Set::reverse($currencies);
        //Filter down to just the rates
        $currencies = $currencies['Envelope']['Cube']['Cube']['Cube'];
        //Create an array to hold the rates
        $currencyList = array();
        //European Central bank gives us everything against Euro so add this manually
        $currencyList['EUR'] = 1;
        //Now iterate through and add the rates provided
        foreach($currencies as $currency) {
            $currencyList[$currency['@currency']] = $currency['@rate'];
        }
        //Return rates array from session
        //return $this->Session->read('Currencies');
        return $currencyList;
    }
    function table($base = 'EUR', $decimals = 2)
    {
        //Create array to holds rates
        $rateTable = array();
        //Get rate table array
        $rates = $this->_retrieveCurrencies();
        //Iterate throught each rate converting it against $base
        foreach($rates as $key => $value) {
            $rateTable[$key] = number_format(1/$rates[$base]*$rates[$key], $decimals);
        }
        //Return result array
        return $rateTable;
    }
    function convert_rate($rates = array() , $base = 'EUR', $decimals = 2)
    {
        //Create array to holds rates
        $rateTable = array();
        //Get rate table array
        if (empty($rates)) {
            $rates = $this->_retrieveCurrencies();
        }
        //Iterate throught each rate converting it against $base
        foreach($rates as $key => $value) {
            if (!empty($rates[$base]) && !empty($rates[$key])) {
	            $rateTable[$key] = number_format(1/$rates[$base]*$rates[$key], $decimals);
			}
        }
        //Return result array
        return $rateTable;
    }
    function currency_conversion($is_manual_update = 0)
    {
        if (!empty($is_manual_update)) {
            $this->rate_conversion();
        } elseif (Configure::read('site.is_auto_currency_updation')) {
            $this->rate_conversion();
        }
    }
    function rate_conversion($conversion_updates = array())
    {
        $currencyLists = $this->find('all', array(
            'recursive' => -1
        ));
        $supported_currencyLists = $this->find('list', array(
            'fields' => array(
                'Currency.id',
                'Currency.code',
            ) ,
            'recursive' => -1
        ));
        $currency_conversions = $this->CurrencyConversion->find('all', array(
            'recursive' => -1
        ));
        if (!empty($conversion_updates)) {
            $rate_lists = $conversion_updates;
        } else {
            $rate_lists = $this->_retrieveCurrencies();
        }
        foreach($currencyLists as $currencyList) {
            $rates = $this->convert_rate($rate_lists, $currencyList['Currency']['code'], 2);
            foreach($supported_currencyLists as $id => $code) {
                $data = array();
                foreach($currency_conversions as $currency_conversion) {
                    if (($currency_conversion['CurrencyConversion']['currency_id'] == $currencyList['Currency']['id']) && ($currency_conversion['CurrencyConversion']['converted_currency_id'] == $id)) {
                        $data['CurrencyConversion']['id'] = $currency_conversion['CurrencyConversion']['id'];
                        $data['CurrencyConversionHistory']['rate_before_change'] = $currency_conversion['CurrencyConversion']['rate'];
                    }
                }
                if (empty($data['CurrencyConversion'])) {
                    $this->CurrencyConversion->create();
                }
                if (!empty($rates[$code])) {
                    $data['CurrencyConversion']['rate'] = $rates[$code];
                    $data['CurrencyConversion']['converted_currency_id'] = $id;
                    $data['CurrencyConversion']['currency_id'] = $currencyList['Currency']['id'];
                    $this->CurrencyConversion->save($data);
                    if (Configure::read('site.is_currency_conversion_history_updation')) {
                        $this->CurrencyConversion->CurrencyConversionHistory->create();
                        $data['CurrencyConversionHistory']['rate'] = $rates[$code];
                        $data['CurrencyConversionHistory']['currency_conversion_id'] = (!empty($data['CurrencyConversion']['id'])) ? $data['CurrencyConversion']['id'] : $this->CurrencyConversion->getLastInsertId();
                        $this->CurrencyConversion->CurrencyConversionHistory->save($data['CurrencyConversionHistory']);
                    }
                }
            }
        }
        Cache::delete('site_currencies');
    }
}
?>