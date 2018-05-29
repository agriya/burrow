<?php
define('DS', DIRECTORY_SEPARATOR);
$app_dir = dirname(dirname(__FILE__));
$tmp_dir = $app_dir . DS . 'tmp';
$webroot_dir = dirname(__FILE__);
$js_dir = $webroot_dir . DS . 'js';
$css_dir = $webroot_dir . DS . 'css';
$img_dir = $webroot_dir . DS . 'img';
$cache_dir = $webroot_dir . DS . 'cache';
$touch_dir = $webroot_dir . DS . 'Touch';
/*$js_files = glob($js_dir . DS . '*.cache.*');
$css_files = glob($css_dir . DS . '*.cache.*');
$cache_files = array_merge($js_files, $css_files);
foreach ($cache_files as $file) {
	@unlink($file);
}*/
_traverse_directory($tmp_dir, 0, !empty($_GET['p']) ? 0 : 1);
// index.html
@unlink($webroot_dir . DS . 'index.html');
// delete cache folders
//_traverse_directory($cache_dir, 0);
//_traverse_directory($touch_dir, 0);
_traverse_directory($img_dir . DS . 'big_thumb', 0);
_traverse_directory($img_dir . DS . 'collage_thumb', 0);
_traverse_directory($img_dir . DS . 'collection_thumb', 0);
_traverse_directory($img_dir . DS . 'medium_big_thumb', 0);
_traverse_directory($img_dir . DS . 'micro_thumb', 0);
_traverse_directory($img_dir . DS . 'normal_big_thumb', 0);
_traverse_directory($img_dir . DS . 'small_big_thumb', 0);
_traverse_directory($img_dir . DS . 'small_thumb', 0);
_traverse_directory($img_dir . DS . 'very_big_thumb', 0);
_traverse_directory($img_dir . DS . 'medium_thumb', 0);
_traverse_directory($img_dir . DS . 'normal_thumb', 0);
_traverse_directory($img_dir . DS . 'rectagle_thumb', 0);
function _traverse_directory($dir, $dir_count, $unlink = 1)
{
	$handle = opendir($dir);
	while (false !== ($readdir = readdir($handle))) {
		if ($readdir != '.' && $readdir != '..' && $readdir != '.svn') {
			$path = $dir . '/' . $readdir;
			if (is_dir($path)) {
				@chmod($path, 0777);
				++$dir_count;
				_traverse_directory($path, $dir_count, $unlink);
			}
			if (is_file($path)) {
				@chmod($path, 0777);
				if (!empty($unlink)) {
					@unlink($path);
				}
				//so that page wouldn't hang
				flush();
			}
		}
	}
	closedir($handle);
	//@rmdir($dir);
	return true;
}