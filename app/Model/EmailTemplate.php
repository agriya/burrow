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
class EmailTemplate extends AppModel
{
    public $name = 'EmailTemplate';
    public $displayField = 'name';
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'from' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'subject' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'email_content' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
    }
    function selectTemplate($tempName)
    {
        $emailTemplate = $this->find('first', array(
            'conditions' => array(
                'EmailTemplate.name' => $tempName
            ) ,
            'recursive' => -1
        ));
        $resultArray = array();
        foreach($emailTemplate as $singleArrayEmailTemplate) {
            foreach($singleArrayEmailTemplate as $key => $value) {
                $resultArray[$key] = $value;
            }
        }
        return $resultArray;
    }
}
?>