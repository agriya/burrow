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
class Block extends AppModel
{
    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'Block';
    /**
     * Behaviors used by the Model
     *
     * @var array
     * @access public
     */
    public $actsAs = array(
        'Encoder',
        'Ordered' => array(
            'field' => 'weight',
            'foreign_key' => false,
        ) ,
        'Cached' => array(
            'prefix' => array(
                'block_',
                'blocks_',
                'cms_blocks_',
            ) ,
        ) ,
        'Params',
    );
    /**
     * Model associations: belongsTo
     *
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'Region' => array(
            'className' => 'Region',
            'foreignKey' => 'region_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => array(
                'Block.status' => 1
            ) ,
        ) ,
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
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required') ,
                ) ,
            ) ,
        );
        $this->moreActions = array(
            ConstMoreAction::Publish => __l('Publish') ,
            ConstMoreAction::Unpublish => __l('Unpublish') ,
        );
    }
}
