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
class MetaBehavior extends ModelBehavior
{
    /**
     * Setup
     *
     * @param object $model
     * @param array  $config
     * @return void
     */
    public function setup(Model $model, $config = array())
    {
        if (is_string($config)) {
            $config = array(
                $config
            );
        }
        $this->settings[$model->alias] = $config;
    }
    /**
     * afterFind callback
     *
     * @param object  $model
     * @param array   $created
     * @param boolean $primary
     * @return array
     */
    public function afterFind(Model $model, $results, $primary)
    {
        if ($primary && isset($results[0][$model->alias])) {
            foreach($results as $i => $result) {
                $customFields = array();
                if (isset($result['Meta']) && count($result['Meta']) > 0) {
                    $customFields = Set::combine($result, 'Meta.{n}.name', 'Meta.{n}.value');
                }
                $results[$i]['CustomFields'] = $customFields;
            }
        } elseif (isset($results[$model->alias])) {
            $customFields = array();
            if (isset($results['Meta']) && count($results['Meta']) > 0) {
                $customFields = Set::combine($results, 'Meta.{n}.name', 'Meta.{n}.value');
            }
            $results['CustomFields'] = $customFields;
        }
        return $results;
    }
    /**
     * Prepare data
     *
     * @param object $model
     * @param array  $data
     * @return array
     */
    public function prepareData(Model $model, $data)
    {
        return $this->_prepareMeta($data);
    }
    /**
     * Private method for MetaBehavior::prepareData()
     *
     * @param object $model
     * @param array  $data
     * @return array
     */
    protected function _prepareMeta($data)
    {
        if (isset($data['Meta']) && is_array($data['Meta']) && count($data['Meta']) > 0 && !Set::numeric(array_keys($data['Meta']))) {
            $meta = $data['Meta'];
            $data['Meta'] = array();
            $i = 0;
            foreach($meta as $metaUuid => $metaArray) {
                $data['Meta'][$i] = $metaArray;
                $i++;
            }
        }
        return $data;
    }
    /**
     * Save with meta
     *
     * @param object $model
     * @param array  $data
     * @param array  $options
     * @return void
     */
    public function saveWithMeta(Model $model, $data, $options = array())
    {
        $data = $this->_prepareMeta($data);
        return $model->saveAll($data, $options);
    }
}
