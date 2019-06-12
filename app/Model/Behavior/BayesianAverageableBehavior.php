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
/**
 * BayesianAverageable Behavior
 *
 * CakePHP Behavior calculates Bayesian averages for an item's ratings so you can more
 * accurately order by average rating. See link for more info.
 *
 * PHP 5+ & MySQL databases only.
 *
 * @author joe bartlett (xo@jdbartlett.com)
 * @link http://github.com/jdbartlett/BayesianAverage
 * @package app
 * @subpackage app.models.behaviors
 */
class BayesianAverageableBehavior extends ModelBehavior
{
    /**
     * Default settings
     *
     * @var array
     * @access private
     */
    var $__defaults = array(
        'fields' => array(
            // Fields in the model for ratings:
            'itemId' => 'item_id',
            'rating' => 'rating',
            // Fields in the model for items that are rated:
            'ratingsCount' => 'ratings_count',
            'totalRatings' => 'total_rating',
            'meanRating' => 'mean_rating',
            'bayesianRating' => 'bayesian_rating',
        ) ,
        'itemModel' => false,
        'useForeignKey' => false, // if true, use itemId to find itemModel's primary key (don't set this manually)
        'C' => false,
        'm' => false,
        'cache' => array(
            'config' => null,
            'prefix' => 'BayesianAverage_',
            'calculationDuration' => 1800, // seconds to wait before recalculating C & m
            
        ) ,
    );
    /**
     * Extra models imported into the behavior by the __getExtraModel method.
     *
     * @var array
     * @access private
     */
    var $__extraModels = array();
    /**
     * Settings indexed by model name.
     *
     * @var array
     * @access private
     */
    var $__settings = array();
    /**
     * @param object $Model Model being saved
     * @param bool $created True if a new record has been created
     * @access public
     */
    function afterSave(Model $Model, $created) 
    {
        extract($this->__settings[$Model->alias]);
        if (isset($Model->data[$Model->alias][$fields['rating']])) {
            if (isset($Model->data[$Model->alias][$fields['itemId']])) {
                $itemId = $Model->data[$Model->alias][$fields['itemId']];
            } else {
                $itemId = $Model->field($fields['itemId'], array(
                    "{$Model->alias}.{$Model->primaryKey}" => $Model->id
                ));
            }
            $this->recount($Model, $itemId);
        }
        return true;
    }
    /**
     * Get the name of the model that corresponds to a foreign key.
     *
     * @param object $Model Current model
     * @param string $column Name of the foreign key (should end with "_id")
     * @return string Model name
     * @access public
     */
    function getColumnAssociation(Model $Model, $column) 
    {
        if (!empty($Model->belongsTo)) {
            foreach($Model->belongsTo as $assoc => $data) {
                if ($data['foreignKey'] == $column) {
                    return $assoc;
                }
            }
        }
        return false;
    }
    /**
     * Get the "item" model associated with this "rating" model.
     *
     * @param object $Model "Rating" model
     * @return object Associated "item" model
     * @access public
     */
    function &getItemModel(Model $Model) 
    {
        $itemModel = $this->__settings[$Model->alias]['itemModel'];
        $field_itemId = $this->__settings[$Model->alias]['fields']['itemId'];
        if ($itemModel) {
            if (isset($Model->{$itemModel})) {
                return $Model->{$itemModel};
            } else {
                $ExtraModel = &$this->__getExtraModel($itemModel);
                // If this is our first time using the imported model
                if (!$this->__settings[$Model->alias]['useForeignKey']) {
                    if (!$ExtraModel->schema($field_itemId)) {
                        trigger_error("BayesianAverage Error: {$itemModel}.{$field_itemId} doesn't exist.", E_USER_NOTICE);
                    }
                    $this->__settings[$Model->alias]['useForeignKey'] = true;
                }
                return $ExtraModel;
            }
        } else {
            $itemModel = $this->getColumnAssociation($Model, $field_itemId);
            if (!$itemModel) {
                trigger_error("BayesianAverage Error: no relationship uses {$Model->alias}.{$field_itemId} as a foreign key.", E_USER_NOTICE);
            }
            $this->__settings[$Model->alias]['itemModel'] = $itemModel;
            return $Model->{$itemModel};
        }
    }
    /**
     * Recount the ratings and recalculate the average rating for a particular item.
     *
     * @param object $Model Ratings model this applies to
     * @param number $itemId ID of item whose ratings are being saved
     * @access public
     */
    function recount(Model $Model, $itemId) 
    {
        extract($this->__settings[$Model->alias]['fields'], EXTR_PREFIX_ALL, 'field');
        if ($Model->name == 'Property') {
            $itemStats = $Model->find('first', array(
                'fields' => array(
                    "SUM({$Model->alias}.$field_rating) totalRatings",
                    "SUM($field_ratingsCount) ratingsCount"
                ) ,
                'conditions' => array(
                    "{$Model->alias}.$field_itemId" => $itemId
                ) ,
                'recursive' => -1,
            ));
            $itemStats[0]['meanRating'] = $itemStats[0]['ratingsCount'] ? $itemStats[0]['totalRatings']/$itemStats[0]['ratingsCount'] : 0;
        } else {
            $itemStats = $Model->find('first', array(
                'fields' => array(
                    'COUNT(*) ratingsCount',
                    "AVG({$Model->alias}.$field_rating) meanRating",
                    "COUNT($field_rating) totalRatings"
                ) ,
                'conditions' => array(
                    "{$Model->alias}.$field_itemId" => $itemId
                ) ,
                'recursive' => -1,
            ));
        }
        $ItemModel = &$this->getItemModel($Model);
        // If a foreign key is used to index items in ItemModel, then find the actual primary key
        if ($this->__settings[$Model->alias]['useForeignKey']) {
            $itemModelId = $ItemModel->field($ItemModel->primaryKey, array(
                $field_itemId => $itemId
            ));
            if (!$itemModelId) {
                // If the item doesn't exist, create it!
                $ItemModel->create();
                $itemModelId = NULL;
            }
        } else {
            $itemModelId = $itemId;
        }
        $ItemModel->save(array(
            $ItemModel->alias => array(
                $ItemModel->primaryKey => $itemModelId,
                $field_itemId => $itemId,
                $field_ratingsCount => $itemStats[0]['ratingsCount'],
                $field_totalRatings => $itemStats[0]['totalRatings'],
                $field_meanRating => $itemStats[0]['meanRating'],
            )
        ) , array(
            'validate' => false
        ));
        $this->updateBayesianAverage($Model, $itemId);
    }
    /**
     * Initiate behavior for the model using specified settings.
     *
     * Available settings:
     *
     * - fields: (array, optional) Array of field names (fields themselves only--leave out
     *      the model names); more details are below.
     *      DEFAULTS TO: (array - see fields listed below)
     * - itemModel: (string, optional) Name of the model your ratings model belongsTo. If
     *      this is left false, it will be determined by model associations.
     *      DEFAULTS TO: false
     * - C: (number, optional) Constant: the average number of ratings an item receives.
     *      Left false, this value will be calculated based on existing records. Once you
     *      have a large number of items and votes, you may want to set this field to some
     *      threshold number of votes under which there's insufficient data for the ratings
     *      to be relevant.
     *      DEFAULTS TO: false
     * - m: (number, optional) The average rating an item receives. Like C, this value can
     *      be left false, in which case it will be calculated
     *      DEFAULTS TO: false
     *
     * These are the field names that can be set from the "fields" array setting:
     *
     * - itemId (string, optional) Name of the foreign key indicating which "item" a rating
     *      belongsTo. (i.e., `ItemRating.item_id`)
     *      DEFAULTS TO: 'item_id'
     * - rating (string, optional) Name of the field that stores a single rating. (i.e.,
     *      `ItemRating.rating`)
     *      DEFAULTS TO: 'rating'
     * - ratingsCount (string, optional) Field in "item" table that stores the number of
     *      ratings each item has. (i.e., `Item.ratings_count`)
     *      DEFAULTS TO: 'ratings_count'
     * - meanRating (string, optional) Field in "item" table; average rating for each item
     *      (i.e., `Item.mean_rating`)
     *      DEFAULTS TO: 'mean_rating'
     * - bayesianRating (string, optional) Field in "item" table; calculated Bayesian
     *      average rating for this item (i.e., `Item.bayesian_rating`)
     *      DEFAULTS TO: 'bayesian_rating'
     *
     * @param object $Model Model using the behavior
     * @param array $settings Settings to override for model
     * @access public
     */
    function setup(Model $Model, $settings = array()) 
    {
        if (!isset($this->__settings[$Model->alias])) {
            $this->__settings[$Model->alias] = $this->__defaults;
        }
        $this->__settings[$Model->alias] = array_merge($this->__settings[$Model->alias], $settings);
        $this->__settings[$Model->alias]['fields'] = array_merge($this->__defaults['fields'], $this->__settings[$Model->alias]['fields']);
        $this->__settings[$Model->alias]['cache'] = array_merge($this->__defaults['cache'], $this->__settings[$Model->alias]['cache']);
    }
    /**
     * Updates the Bayesian average(s) for affected items.
     *
     * @param object $Model Ratings model this applies to
     * @param number $itemId ID of item whose ratings are being saved. Updates everything if this is false.
     * @access public
     */
    function updateBayesianAverage(Model $Model, $itemId = false) 
    {
        extract($this->__settings[$Model->alias]);
        $ItemModel = &$this->getItemModel($Model);
        $updateConditions = array(
            $ItemModel->alias . '.' . $fields['ratingsCount'] . ' >' => '0'
        );
        $updateSingle = ($itemId ? true : false); // whether to update Bayesian avg just for this itemId or all items
        // Get constant/mean average from cache or db if either is inexplicit
        if (!$C || !$m) {
            $cache['data'] = Cache::read($cache['prefix'] . $Model->alias, $cache['config']);
            if (!$cache['calculationDuration']) {
                $cacheSettings = Cache::settings();
                $cache['calculationDuration'] = $cacheSettings['duration']/2;
            }
            if (!$cache['data'] || time() -$cache['data']['time'] > $cache['calculationDuration']) {
                // Calculate latest Constant and mean from the database
                $allStats = $ItemModel->find('first', array(
                    'fields' => array(
                        "AVG({$ItemModel->alias}.{$fields['ratingsCount']}) C",
                        "AVG({$ItemModel->alias}.{$fields['meanRating']}) m"
                    ) ,
                    'conditions' => array(
                        "{$ItemModel->alias}.{$fields['ratingsCount']} >" => '0'
                    ) ,
                    'recursive' => -1,
                ));
                if (!$C) {
                    // If cache value isn't set or the difference between it and the current value is greater than 10%, update the cache and all items
                    if (!isset($cache['data']['C']) || (!empty($cache['data']['C']) && abs($allStats[0]['C']-$cache['data']['C'])) > $cache['data']['C']*0.1) {
                        $C = $allStats[0]['C'];
                        $updateSingle = false;
                    } else {
                        $C = $cache['data']['C'];
                    }
                }
                if (!$m) {
                    // If cache value isn't set or the difference between it and the current value is greater than 10%, update the cache and all items
                    if (!isset($cache['data']['m']) || abs($allStats[0]['m']-$cache['data']['m']) > $cache['data']['m']*0.1) {
                        $m = $allStats[0]['m'];
                        $updateSingle = false;
                    } else {
                        $m = $cache['data']['m'];
                    }
                }
                // Update the cache
                Cache::write($cache['prefix'] . $Model->alias, array(
                    'time' => time() ,
                    'C' => $C,
                    'm' => $m,
                ) , $cache['config']);
            } else {
                $C = $cache['data']['C'];
                $m = $cache['data']['m'];
            }
        }
        // Only update the data for one item
        if ($updateSingle) {
            if ($useForeignKey) {
                $updateConditions["{$ItemModel->alias}.{$fields['itemId']}"] = $itemId;
            } else {
                $updateConditions["{$ItemModel->alias}.{$ItemModel->primaryKey}"] = $itemId;
            }
        }
        // Update the affected items' bayesian averages
        if ($C > 2) {
            $n = $ItemModel->escapeField($fields['ratingsCount']);
            $j = $ItemModel->escapeField($fields['meanRating']);
            $formula = "($n / ($n + $C)) * $j + ($C / ($n + $C)) * $m";
        } else {
            $formula = $ItemModel->escapeField($fields['meanRating']);
        }
        $ItemModel->updateAll(array(
            $ItemModel->alias . '.' . $fields['bayesianRating'] => $formula
        ) , $updateConditions);
    }
    /**
     * Used by getItemModel to import extra models when no relationship exists
     * between the Rating model and the "Item" model.
     *
     * @param object string $modelName name of model to import
     * @return object Model
     * @access private
     */
    function &__getExtraModel($modelName) 
    {
        if (!isset($this->__extraModels[$modelName])) {
            if (!class_exists($modelName)) {
                if (!App::import('Model', $modelName)) {
                    trigger_error("BayesianAverage Error: no such model: '{$modelName}'", E_USER_NOTICE);
                }
            }
            $this->__extraModels[$modelName] = new $modelName();
        }
        return $this->__extraModels[$modelName];
    }
}
?>