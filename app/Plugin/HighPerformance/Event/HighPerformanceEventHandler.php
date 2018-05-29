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
class HighPerformanceEventHandler extends Object implements CakeEventListener
{
    /**
     * implementedEvents
     *
     * @return array
     */
    public function implementedEvents()
    {
        return array(
            'Model.HighPerformance.getCachedQuery' => array(
                'callable' => 'onGetCachedQuery',
            ) ,
            'Model.HighPerformance.setCachedQuery' => array(
                'callable' => 'onSetCachedQuery',
            ) ,
            'Helper.HighPerformance.getAssetUrl' => array(
                'callable' => 'onGetAssetUrl',
            ) ,
        );
    }
    public function onGetCachedQuery($event)
    {
        $model = $event->subject();
        $tag = !empty($model->name) ? '_' . $model->name : 'appmodel';
        $version = (int)Cache::read($tag, 'queries');
        $event->data['version'] = $version;
        $fullTag = $tag . '_' . env('HTTP_HOST') . '_' . $event->data['type'] . '_' . md5(serialize($event->data['params']));
        $event->data['fullTag'] = $fullTag;
        if ($result = Cache::read($fullTag, 'queries')) {
            if ($result['version'] == $version) {
                $event->data['result'] = $result['data'];
            }
        }
    }
    public function onSetCachedQuery($event)
    {
        if (!empty($event->data['result'])) {
            $model = $event->subject();
            $tag = isset($model->name) ? '_' . $model->name : 'appmodel';
            Cache::write($event->data['fullTag'], $event->data['result'], 'queries');
            Cache::write($tag, $event->data['result']['version'], 'queries');
        }
    }
    public function onGetAssetUrl($event)
    {
		if (Configure::read('cdn.is_cdn_enabled')) {
			$options = $event->data['options'];
			$assetURL = '';
			if ($options['pathPrefix'] == IMAGES_URL) {
				$assetURL = Configure::read('cdn.images') . '/';
			} elseif ($options['pathPrefix'] == JS_URL) {
				$assetURL = Configure::read('cdn.js') . '/';
			} elseif ($options['pathPrefix'] == CSS_URL) {
				$assetURL = Configure::read('cdn.css') . '/';
			}
			$event->data['assetURL'] = $assetURL;
		} elseif (Configure::read('s3.upload_static_content_enabled')) {
			$options = $event->data['options'];
			$assetURL = 'http://' . Configure::read('s3.bucket_name') . '.' . Configure::read('s3.end_point') . '/';
			if (Configure::read('s3.is_cname_enabled')) {
				$assetURL = 'http://' . Configure::read('s3.bucket_name') . '/';
			}
			$event->data['assetURL'] = $assetURL;
		}
    }
}
?>