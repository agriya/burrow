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
class Page extends AppModel
{
    public $name = 'Page';
    public $displayField = 'title';
    public $actsAs = array(
        'Sluggable' => array(
            'label' => array(
                'title'
            ) ,
            'overwrite' => false
        ) ,
        'Taggable',
        'Tree'
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'title' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'slug' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'content' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
        $this->statusOptions = array(
            '0' => 'Published',
            '1' => 'Draft'
        );
    }
	/* public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
    );*/
    /**
     * Before save callback
     *
     * @return bool Success
     */
    function beforeSave($options = array())
    {
        parent::beforeSave();
        // Construct the absolute page URL
        if (isset($this->data[$this->name]['slug'])) {
            $level = 0;
            if (!isset($this->data[$this->name]['parent_id']) or !is_numeric($this->data[$this->name]['parent_id'])) {
                // Page has no parent
                $this->data[$this->name]['url'] = "/{$this->data[$this->name]['slug']}";
            } else {
                $parentPage = $this->findById($this->data[$this->name]['parent_id'], array(
                    'url'
                ));
                $url = "/{$this->data[$this->name]['slug']}";
                if ($parentPage[$this->name]['url'] !== '/') {
                    $url = $parentPage[$this->name]['url'] . $url;
                }
                $this->data[$this->name]['url'] = $url;
            }
        }
        // Publish?
        if (isset($this->data[$this->name]['publish'])) {
            $this->data[$this->name]['draft'] = 0;
            unset($this->data[$this->name]['publish']);
        }
        return true;
    }
    function updateChildPageUrls($id, $oldUrl, $newUrl)
    {
        // Update child pages URLs
        $children = $this->find('all', array(
            'conditions' => "{$this->name}.url LIKE '$oldUrl%' AND {$this->name}.id != $id",
            'recursive' => -1,
            'fields' => array(
                'id',
                'url',
                'slug'
            ) ,
        ));
        if (!empty($children)) {
            foreach($children as $page) {
                $childNewUrl = str_replace($oldUrl, $newUrl, $page[$this->name]['url']);
                $this->query("UPDATE {$this->useTable} SET url = '$childNewUrl' WHERE id = {$page[$this->name]['id']}");
            }
        }
    }
    /**
     * Find possible parents of a page for select box
     *
     * @deprecated: Use Cake's TreeBehavior::genera...
     * @param int $skipId id to skip
     */
    function getListThreaded($skipId = null, $alias = 'title')
    {
        $parentPages = $this->findAll(null, null, "{$this->name}.lft ASC", null, 1, 0);
        // Array for form::select
        $selectBoxData = array();
        $skipLeft = false;
        $skipRight = false;
        if (empty($parentPages)) return $selectBoxData;
        $rightNodes = array();
        foreach($parentPages as $key => $page) {
            $level = 0;
            // Check if we should remove a node from the stack
            while (!empty($rightNodes) && ($rightNodes[count($rightNodes) -1] < $page[$this->name]['rght'])) {
                array_pop($rightNodes);
            }
            $level = count($rightNodes);
            $dashes = '';
            if ($level > 0) {
                $dashes = str_repeat('-', $level) . '-';
            }
            if ($skipId == $page[$this->name]['id']) {
                $skipLeft = $page[$this->name]['lft'];
                $skipRight = $page[$this->name]['rght'];
            } else {
                if (!($skipLeft && $skipRight && $page[$this->name]['lft'] > $skipLeft && $page[$this->name]['rght'] < $skipRight)) {
                    $alias = $page[$this->name]['title'];
                    //$alias = hsc($page[$this->name]['title']);
                    if (!empty($dashes)) $alias = "$dashes $alias";
                    $selectBoxData[$page[$this->name]['id']] = $alias;
                }
            }
            $rightNodes[] = $page[$this->name]['rght'];
        }
        return $selectBoxData;
    }
}
?>