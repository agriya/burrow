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
class FullPageCachingBehavior extends ModelBehavior
{
    /**
     * Setup
     *
     * @param object $model
     * @param array  $config
     * @return void
     */
    public function beforeDelete(Model $model, $cascade = true)
    {
        $this->deleteFullPageCache($model);
        parent::beforeDelete($model);
    }
    public function afterSave(Model $model, $created)
    {
        $this->deleteFullPageCache($model);
        parent::afterSave($model, $created);
    }
    public function deleteFullPageCache($Model)
    {
		if ($Model->alias == 'Property') {
            App::import('Model', 'Properties.Property');
        }else if ($Model->alias == 'Request') {
            App::import('Model', 'Requests.Request');
        } else {
            if($Model->alias == 'OwnerUser') {
				App::import('Model', 'User');
			} else {
				App::import('Model', $Model->alias);
			}
        }
		if (!empty($Model->data[$Model->alias]['id'])) {
			if($Model->alias == 'OwnerUser') {
				$model_obj = new User();
				$data = $model_obj->find('first', array(
					'conditions' => array(
						'User.id =' => $Model->data[$Model->alias]['id'],
					) ,
					'recursive' => -1
				));
			} else {
				$model_obj = new $Model->alias();
				$data = $model_obj->find('first', array(
					'conditions' => array(
						$Model->alias . '.id =' => $Model->data[$Model->alias]['id'],
					) ,
					'recursive' => -1
				));
			}
			$url_arr = array();
			if ($Model->alias == 'Property') {
				$slug = $data[$Model->alias]['slug'];
				$url_arr = array(
					WWW_ROOT . DS . 'cache' . DS . 'property' . DS . $slug . DS . 'index.html',
				);
				$dir = WWW_ROOT . 'cache' . DS . 'properties';
				$this->_traverse_directory($dir, '');
			} else if ($Model->alias == 'Request') {
				$slug = $data[$Model->alias]['slug'];
				$url_arr = array(
					WWW_ROOT . DS . 'cache' . DS . 'request' . DS . $slug . DS . 'index.html',
				);
				$dir = WWW_ROOT . 'cache' . DS . 'requests';
				$this->_traverse_directory($dir, '');
			} else if ($Model->alias == 'User') {
				$slug = $data[$Model->alias]['username'];
				$url_arr = array(
					 WWW_ROOT . DS . 'cache' . DS . 'user' . DS . $slug . DS . 'index.html'
				);
			}
			foreach($url_arr as $url) {
				@unlink($url);
			}
		}
    }
	public function _traverse_directory($dir, $dir_count)
    {
		if(is_dir($dir)) {
        $handle = opendir($dir);
        while (false !== ($readdir = readdir($handle))) {
            if ($readdir != '.' && $readdir != '..') {
                $path = $dir . '/' . $readdir;
                if (is_dir($path)) {
                    @chmod($path, 0777);
                    ++$dir_count;
                    $this->_traverse_directory($path, $dir_count);
                }
                if (is_file($path)) {
                    @chmod($path, 0777);
                    @unlink($path);
                    //so that page wouldn't hang
                    flush();
                }
            }
        }
        closedir($handle);
        @rmdir($dir);
        return true;
    }
	}
}
