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
if (Configure::read('mail.is_smtp_enabled')) {
    require_once 'email.php';
}
if (Configure::read('RedisSession.is_redis_session_enabled')) {
    Configure::write('Session.handler.engine', 'HighPerformance.RedisSession');
}
if (Configure::read('Memcached.is_memcached_enabled')) {
    Cms::hookBehavior('*', 'HighPerformance.Memcached', array());
    Cache::config('queries', array(
        'engine' => 'Memcache',
        'servers' => explode(',', Configure::read('Memcached.servers')) ,
        'compress' => false,
        'duration' => '+1 weeks',
    ));
}
if (Configure::read('s3.is_enabled')) {
    Cms::hookBehavior('Attachment', 'HighPerformance.S3', array());
    Configure::write('thumbs', array(
        'UserAvatar' => array(
            'micro_thumb',
            'small_thumb',
            'medium_thumb',
            'medium_big_thumb',
            'big_thumb',
			'small_big_thumb'
        ) ,
        'Property' => array(
            'small_thumb',
            'collage_thumb',
            'collection_thumb',
            'medium_big_thumb',
			'normal_big_thumb',
			'normal_thumb',
			'rectagle_thumb',
			'very_big_thumb',
			'big_thumb',
        ) ,
		'Collection' => array(
            'collage_thumb',
            'collection_thumb',
			'rectagle_thumb',
        ) ,
    ));
}
if (Configure::read('HtmlCache.is_htmlcache_enabled')) {
    Cms::hookComponent('*', 'HighPerformance.StaticCacheHook');
    Cms::hookHelper('*', 'HighPerformance.StaticCache');
	Cms::hookBehavior('Property', 'HighPerformance.FullPageCaching', array());
    Cms::hookBehavior('User', 'HighPerformance.FullPageCaching', array());
    CmsHook::setJsFile(array(
        APP . 'Plugin' . DS . 'HighPerformance' . DS . 'webroot' . DS . 'js' . DS . 'highperformance.js',
    ));
}
if (Configure::read('Elasticsearch.is_elasticsearch_enabled')) {
    Cms::hookComponent('Cities', 'HighPerformance.Searcher', array(
        'model' => '_all',
        'leading_model' => 'City'
    ));
    Cms::hookBehavior('City', 'HighPerformance.Searchable', array(
        'debug_traces' => true,
        'searcher_enabled' => 1,
        'searcher_action' => 'searcher',
        'index_find_params' => array(
            'limit' => 1,
            'fields' => array(
                'id',
                'name',
            ) ,
            'order' => array(
                'City.id' => 'DESC',
            ) ,
        ) ,
        'realtime_update' => true,
        'error_handler' => 'php',
        'enforce' => array(
            'City/id' => 1,
            // or a callback: '#Customer/id' => array('LiveUser', 'id'),
            
        ) ,
        'highlight_excludes' => array(
            // if you're always restricting results by customer, that
            // query should probably not be part of your highlight
            // instead of dumping _all and going over all fields except Customer/id,
            // you can also exclude it:
            'City/id',
        ) ,
    ));
}
CmsHook::setExceptionUrl(array(
		'high_performances/update_content',
		'high_performances/show_project_comments',
		'crons/encode',
));
if (Configure::read('cloudflare.is_cloudflare_enabled')) {
	Cms::hookBehavior('Property', 'HighPerformance.CloudFlare', array());
    Cms::hookBehavior('User', 'HighPerformance.CloudFlare', array());
}
?>