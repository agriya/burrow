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
class DAclBehavior extends ModelBehavior
{
    public function setup(&$Model, $config = array()) 
    {
        if (!is_array($config)) {
            $config = array();
        }
        $this->settings[$Model->alias] = $config;
    }
    public function beforeFind(&$model, $query) 
    {
        return $this->_dAclQuery($model, $query);
    }
    public function beforeSave(&$model, $query) 
    {
        return $this->_dAclQuery($model, $query);
    }
    public function beforeDelete(&$model) 
    {
        return $this->_deleteAclQuery($model);
    }
    public function _deleteAclQuery($model) 
    {
        $query = $this->_dAclQuery($model);
        $query['conditions'][$model->alias . '.' . $model->primaryKey] = $model->id;
        $mData = $model->find('first', array(
            $query,
            'recursive' => -1
        ));
        if (empty($mData)) {
            return false;
        }
        return true;
    }
    public function _dAclQuery($model, $query = null) 
    {
        if (!empty($_SESSION['Auth']['User']['role_id']) && $_SESSION['Auth']['User']['role_id'] != ConstUserTypes::Admin) {
            if (($model->alias == 'User' && $model->findQueryType == 'list') || $model->alias != 'User') {
                if (!empty($_SESSION['acl_is_allow_user']) && $_SESSION['acl_is_allow_user'] == ConstAclStatuses::Group) {
                    if (!empty($_SESSION['acl_group_user_ids'])) {
                        $query['conditions'][$model->alias . '.' . $this->settings[$model->alias]['fields']] = $_SESSION['acl_group_user_ids'];
                    }
                } elseif (!empty($_SESSION['acl_is_allow_user']) && $_SESSION['acl_is_allow_user'] == ConstAclStatuses::Owner) {
                    $query['conditions'][$model->alias . '.' . $this->settings[$model->alias]['fields']] = $_SESSION['Auth']['User']['id'];
                }
            }
        }
        return $query;
    }
}
?>