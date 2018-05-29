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
class Region extends AppModel
{
    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'Region';
    /**
     * Behaviors used by the Model
     *
     * @var array
     * @access public
     */
    public $actsAs = array(
        'Cached' => array(
            'prefix' => array(
                'region_',
                'cms_regions',
                'block_',
                'cms_blocks_',
            ) ,
        ) ,
    );
    /**
     * Model associations: hasMany
     *
     * @var array
     * @access public
     */
    public $hasMany = array(
        'Block' => array(
            'className' => 'Block',
            'foreignKey' => 'region_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '3',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
        ) ,
    );
    /**
     * Display fields for this model
     *
     * @var array
     */
    protected $_displayFields = array(
        'id',
        'title',
        'alias',
    );
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'title' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
            ) ,
            'alias' => array(
                'rule2' => array(
                    'rule' => 'isUnique',
                    'message' => __l('Already exists') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required') ,
                    'allowEmpty' => false
                ) ,
            ) ,
        );
    }
}
