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
class HighPerformanceCronComponent extends Component
{
    public function encode() 
    {
        if (Configure::read('s3.is_enabled')) {
            if ($this->_getEncodingCronSemaphore() != 'true') {
                $this->_setEncodingCronSemaphore('true');
                App::import('Model', 'Attachment');
                $this->Attachment = new Attachment();
                App::import('Model', 'Image');
                $this->Image = new Image();
				App::import('Vendor', 'HighPerformance.S3');
				$s3 = new S3(Configure::read('s3.aws_access_key') , Configure::read('s3.aws_secret_key'));
				$s3->setEndpoint(Configure::read('s3.end_point'));
                $attachments = $this->Attachment->find('all', array(
                    'conditions' => array(
						'Attachment.amazon_s3_original_url != ' => '',
                        'Attachment.amazon_s3_thumb_url' => '',
                    ) ,
                    'recursive' => -1
                ));
                foreach($attachments as $attachment) {
                    if (!empty($attachments)) {
					foreach($attachments as $attachment) {
						if (Configure::read('thumbs.' . $attachment['Attachment']['class']) != '') {
							$thumbUrl = array();
							foreach(Configure::read('thumbs.' . $attachment['Attachment']['class']) as $thumb_type) {
								if (Configure::read('s3.keep_copy_in_local')) {
									$fullPath = APP . 'media' . '/' . $attachment['Attachment']['dir'] . '/' . $attachment['Attachment']['filename'];
								} else {
									$fullPath = 'http://' . Configure::read('s3.bucket_name') . '.' . Configure::read('s3.end_point') . '/' . $attachment['Attachment']['dir'] . '/' . $attachment['Attachment']['filename'];
									if (Configure::read('s3.is_cname_enabled')) {
										$fullPath = 'http://' . Configure::read('s3.bucket_name') . '/' . $attachment['Attachment']['dir'] . '/' . $attachment['Attachment']['filename'];
									}
								}
								$img_string = $this->Image->resize(null, Configure::read('thumb_size.' . $thumb_type . '.width') , Configure::read('thumb_size.' . $thumb_type . '.height') , false, true, $fullPath, false);
								$s3->putObjectString($img_string, Configure::read('s3.bucket_name') , $thumb_type . '/' . $attachment['Attachment']['dir'] . '/' . $attachment['Attachment']['filename'], $acl = S3::ACL_PUBLIC_READ, $metaHeaders = array() , $attachment['Attachment']['mimetype']);
								$thumbUrl[$thumb_type] = 'http://' . Configure::read('s3.bucket_name') . '.' . Configure::read('s3.end_point') . '/' . $thumb_type . '/' . $attachment['Attachment']['dir'] . '/' . $attachment['Attachment']['filename'];
								if (Configure::read('s3.is_cname_enabled')) {
									$thumbUrl[$thumb_type] = 'http://' . Configure::read('s3.bucket_name') . '/' . $thumb_type . '/' . $attachment['Attachment']['dir'] . '/' . $attachment['Attachment']['filename'];
								}
							}
							$attachment['Attachment']['amazon_s3_thumb_url'] = serialize($thumbUrl);
							$this->Attachment->updateAll(array(
								'Attachment.amazon_s3_thumb_url' => "'" . serialize($thumbUrl) . "'",
							) , array(
								'Attachment.id' => $attachment['Attachment']['id']
							));
						}
					}
				}
                }
				$this->_setEncodingCronSemaphore('');
            }
        }
    }
    public function _setEncodingCronSemaphore($value) 
    {
        @file_put_contents(TMP . 'encoding_cron_semaphore', $value);
    }
    public function _getEncodingCronSemaphore() 
    {
        return @file_get_contents(TMP . 'encoding_cron_semaphore');
    }
}
