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
class S3Behavior extends ModelBehavior
{
    /**
     * Setup
     *
     * @param object $model
     * @param array  $config
     * @return void
     */
    public function afterSave(Model $model, $created) 
    {
        if (Configure::read('s3.is_enabled') && Configure::read('s3.keep_copy_in_local')) {
            App::import('Vendor', 'HighPerformance.S3');
            $s3 = new S3(Configure::read('s3.aws_access_key') , Configure::read('s3.aws_secret_key'));
			$s3->setEndpoint(Configure::read('s3.end_point'));
			$img_url = APP . 'media' . '/' . $model->data['Attachment']['dir'] . '/' . $model->data['Attachment']['filename'];
            $s3->putObjectFile($img_url, Configure::read('s3.bucket_name') , $model->data['Attachment']['dir'] . '/' . $model->data['Attachment']['filename'], S3::ACL_PUBLIC_READ);
        }
		return true;
    }
    public function beforeSave(Model $model, $data = array()) 
    {
        if (Configure::read('s3.is_enabled') && !Configure::read('s3.keep_copy_in_local')) {
            App::import('Vendor', 'HighPerformance.S3');
            $file_name = $model->data[$model->name]['filename']['name'];
            $s3 = new S3(Configure::read('s3.aws_access_key') , Configure::read('s3.aws_secret_key'));
			$s3->setEndpoint(Configure::read('s3.end_point'));
            $s3->putObjectFile($model->data[$model->name]['filename']['tmp_name'], Configure::read('s3.bucket_name') , $model->data[$model->name]['dir'] . '/' . $model->data[$model->name]['filename']['name'], S3::ACL_PUBLIC_READ);
            $model->data[$model->name]['filename'] = $file_name;
        }
    }
    function beforeDelete(Model $model, $cascade = true) 
    {
        if (Configure::read('s3.is_enabled')) {
            $s3 = new S3(Configure::read('s3.aws_access_key') , Configure::read('s3.aws_secret_key'));
			$s3->setEndpoint(Configure::read('s3.end_point'));
            $s3->deleteObject(Configure::read('s3.bucket_name') , $model->data[$model->name]['dir'] . '/' . $model->data[$model->name]['filename']['name']);
        }
    }
}
