<?php
require_once ('UploadBehavior.php');
class ImageUploadBehavior extends UploadBehavior
{
    function setup(Model $model, $config = array())
    {
        // Overriding defaults
        $this->__defaultSettings['allowedMime'] = array(
            'image/jpeg',
            'image/gif',
            'image/png',
            'image/bmp'
        );
        $this->__defaultSettings['allowedExt'] = array(
            'jpeg',
            'jpg',
            'gif',
            'png',
            'bmp'
        );
        $this->_is_use_imagick = false;
        parent::setup($model, $config);
    }
    function _afterProcessUpload(Model $model, $data, $direct)
    {
		if (file_exists($model->absolutePath())) {
			list($width, $height) = getimagesize($model->absolutePath());
			$model->data[$model->name]['width'] = $width;
			$model->data[$model->name]['height'] = $height;
		}
        return true;
    }
    function _beforeProcessUpload(Model $model, $data, $direct)
    {
        return true;
    }
	function original(Model $model, $original, $destination)
    {
        if ($this->_is_use_imagick) {
            $new_image_obj = new imagick($original);
            $new_image = $new_image_obj->clone();
            $new_image->flattenImages();
            if (!$new_image->writeImage($destination)) {
                die('couldn\'t  move file to webdir');
            }
        } else {
            if (!copy($original, $destination)) {
                die('couldn\'t  move file to webdir');
            }
        }
		$info = pathinfo($destination);
		if (!empty($info['extension']) && $info['extension'] == 'png') {
			exec('pngcrush -reduce -brute ' . $destination . ' ' . $destination);
		}
    }
    function resize(Model $model, $id = null, $width = 600, $height = 400, $writeTo = false, $aspect = true, $fullPath = null, $is_beyond_original = false)
    {
        if ($id === null && $model->id) {
            $id = $model->id;
        } elseif (!$id) {
            $id = null;
        }
        extract($this->settings[$model->name]);
        return $this->resizeFile($model, $fullPath, $width, $height, $writeTo, $aspect, $is_beyond_original);
    }
    //http://www.php.net/imagecreatefromjpeg#60241 && http://in2.php.net/imagecreatefrompng#73546
    function _setMemoryLimitForImage($image_path)
    {
        $imageInfo = getimagesize($image_path);
        $imageInfo['channels'] = !empty($imageInfo['channels']) ? $imageInfo['channels'] : 1;
        $imageInfo['bits'] = !empty($imageInfo['bits']) ? $imageInfo['bits'] : 1;
        $memoryNeeded = round(($imageInfo[0] * $imageInfo[1] * $imageInfo['bits'] * $imageInfo['channels'] / 8 + Pow(2, 16)) * 1.65);
        if (function_exists('memory_get_usage') && memory_get_usage() + $memoryNeeded > (integer)ini_get('memory_limit') * pow(1024, 2)) {
            ini_set('memory_limit', (integer)ini_get('memory_limit') + ceil(((memory_get_usage() + $memoryNeeded) - (integer)ini_get('memory_limit') * pow(1024, 2)) / pow(1024, 2)) . 'M');
        }
    }
    function resizeFile(Model $model, $fullPath, $width = 600, $height = 400, $writeTo = false, $aspect = true, $is_beyond_original = false)
    {
        if (!$width || !$height) {
            return false;
        }
        extract($this->settings[$model->name]);
        if (!($size = getimagesize($fullPath))) {
            // image doesn't exist
            return false;
        }
        list($currentWidth, $currentHeight, $currentType) = $size;
        $return = false;
        if ($this->_is_use_imagick) {
            $new_image_obj = new imagick($fullPath);
            $new_image = $new_image_obj->clone();
            $new_image->setImageColorspace(Imagick::COLORSPACE_RGB);
            $new_image->flattenImages();
            if ($is_beyond_original && ($width > $currentWidth || $height > $currentHeight)) {
                $width = $currentWidth;
                $height = $currentHeight;
            }
            if (!$aspect) {
                $new_image->cropThumbnailImage($width, $height);
            } else {
                $new_image->scaleImage($width, $height, false);
            }
            if ($new_image->writeImage($writeTo)) {
                $return = true;
            }
        } else {
            $target['width'] = $currentWidth;
            $target['height'] = $currentHeight;
            $target['x'] = $target['y'] = 0;
            $types = array(
                1 => "gif",
                "jpeg",
                "png",
                "swf",
                "psd",
                "wbmp"
            );
            //rajesh_04ag02 // 2008-09-25 // fix for memory error
            $this->_setMemoryLimitForImage($fullPath);
            $image = call_user_func('imagecreatefrom' . $types[$currentType], $fullPath);
            ini_restore('memory_limit');
            // adjust to aspect.
            if ($aspect) {
                if (($currentHeight / $height) > ($currentWidth / $width)) {
                    $width = ceil(($currentWidth / $currentHeight) * $height);
                } else {
                    $height = ceil($width / ($currentWidth / $currentHeight));
                }
            } else {
                //rajesh_04ag02 // 2008-02-20
                // Optimized crop adopted from http://in2.php.net/imagecopyresized#71182
                $proportion_X = $currentWidth / $width;
                $proportion_Y = $currentHeight / $height;
                if ($proportion_X > $proportion_Y) {
                    $proportion = $proportion_Y;
                } else {
                    $proportion = $proportion_X;
                }
                $target['width'] = $width * $proportion;
                $target['height'] = $height * $proportion;
                $original['diagonal_center'] = round(sqrt(($currentWidth * $currentWidth) + ($currentHeight * $currentHeight)) / 2);
                $target['diagonal_center'] = round(sqrt(($target['width'] * $target['width']) + ($target['height'] * $target['height'])) / 2);
                $crop = round($original['diagonal_center'] - $target['diagonal_center']);
                if ($proportion_X < $proportion_Y) {
                    $target['x'] = 0;
                    $target['y'] = round((($currentHeight / 2) * $crop) / $target['diagonal_center']);
                } else {
                    $target['x'] = round((($currentWidth / 2) * $crop) / $target['diagonal_center']);
                    $target['y'] = 0;
                }
            }
            if ($is_beyond_original && ($width > $currentWidth || $height > $currentHeight)) {
                $width = $currentWidth;
                $height = $currentHeight;
            }
            if (function_exists("imagecreatetruecolor") && ($temp = imagecreatetruecolor($width, $height))) {
                imagecopyresampled($temp, $image, 0, 0, $target['x'], $target['y'], $width, $height, $target['width'], $target['height']);
            } else {
                $temp = imagecreate($width, $height);
                imagecopyresized($temp, $image, 0, 0, 0, 0, $width, $height, $currentWidth, $currentHeight);
            }
			// Watermark
			if (function_exists('isPluginEnabled') && isPluginEnabled('ImageResources')) {
				App::import('Behavior', 'ImageResources.Watermark');
				$this->Watermark = new WatermarkBehavior();
				$temp = $this->Watermark->watermark($temp, $model->model, $model->size, $currentWidth, $currentHeight, $width, $height);
			}
            if ($writeTo) {
                App::uses('File', 'Utility');
				new File($writeTo, true);
				if ($types[$currentType] == 'jpeg') {
                    if (call_user_func("image" . $types[$currentType], $temp, $writeTo, 100)) {
                        $return = true;
                    }
                } else {
                    if (call_user_func("image" . $types[$currentType], $temp, $writeTo)) {
                        $return = true;
                    }
                }
            } else {
                ob_start();
                call_user_func("image" . $types[$currentType], $temp);
                $return = ob_get_clean();
            }
            imagedestroy($image);
            imagedestroy($temp);
        }
		$info = pathinfo($writeTo);
		if (!empty($info['extension']) && $info['extension'] == 'png') {
			exec('pngcrush -reduce -brute ' . $writeTo . ' ' . $writeTo);
		}
        return $return;
    }
}
?>