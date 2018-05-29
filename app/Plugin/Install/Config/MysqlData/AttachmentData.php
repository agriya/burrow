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
class AttachmentData {

	public $table = 'attachments';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2009-05-11 20:15:24',
			'modified' => '2009-05-11 20:15:24',
			'class' => 'UserAvatar',
			'foreign_id' => '0',
			'filename' => 'default_avatar.jpg',
			'dir' => 'UserAvatar/0',
			'mimetype' => 'image/jpeg',
			'filesize' => '1087',
			'height' => '50',
			'width' => '50',
			'thumb' => '',
			'description' => '',
			'amazon_s3_thumb_url' => '',
			'amazon_s3_original_url' => ''
		),
		array(
			'id' => '2',
			'created' => '2009-05-11 20:16:34',
			'modified' => '2009-05-11 20:16:34',
			'class' => 'PhotoAlbum',
			'foreign_id' => '0',
			'filename' => 'default_album.png',
			'dir' => 'PhotoAlbum/0',
			'mimetype' => 'image/png',
			'filesize' => '40493',
			'height' => '360',
			'width' => '360',
			'thumb' => '',
			'description' => '',
			'amazon_s3_thumb_url' => '',
			'amazon_s3_original_url' => ''
		),
		array(
			'id' => '3',
			'created' => '2009-05-11 20:16:34',
			'modified' => '2009-05-11 20:16:34',
			'class' => 'Property',
			'foreign_id' => '0',
			'filename' => 'property_default.jpg',
			'dir' => 'Property/0',
			'mimetype' => 'image/jpg',
			'filesize' => '60799',
			'height' => '512',
			'width' => '512',
			'thumb' => '',
			'description' => '',
			'amazon_s3_thumb_url' => '',
			'amazon_s3_original_url' => ''
		),
	);

}
