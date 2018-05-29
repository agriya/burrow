<?php
/**
 * XAjax - Extended Ajax
 *
 * @author      rajesh_04ag02 // 2008-12-01
 * Note: Original version from http://cakeforge.org/snippet/download.php?type=snippet&id=286 (AutocompleteComponent)
 *      But, heavily modified it to work with Router::parseExetensions() and make it automatic as much as possible
 */
class XAjaxComponent extends Component
{
    var $enabled = true;
    var $autocompleteLimit = 250;
    function startup(Controller $controller)
    {
        $this->Controller = $controller;
    }
	function autocomplete($param_encode = null, $param_hash = null, $conditions = false, $recursive = -1)
    {
        $controller = $this->Controller;
        if (is_null($param_encode) || is_null($param_hash)) {
            $controller->cakeError('error404');
        }
        $exp_param_hash = substr(md5(Configure::read('Security.salt') . $param_encode) , 5, 7);
        if (strcmp($exp_param_hash, $param_hash) !== 0) {
            $controller->cakeError('error404');
        }
        $params = unserialize(gzinflate(base64_url_decode($param_encode)));
        $this->autocomplete2(@$params['acFieldKey'], @$params['acFields'], @$params['acSearchFieldNames'], $conditions, $recursive);
    }
    //@todo the search fields array to be handled for proper condition formation
    function autocomplete2($fieldKey = null, $fieldNames = null, $autocompleteSearchFieldNames = null, $conditions = false, $recursive)
    {
        $controller = $this->Controller;
        $modelClass = Inflector::singularize($controller->name);
        if (!$this->enabled || !$controller->RequestHandler->isAjax() || !$controller->RequestHandler->prefers('json')) {
            //            $controller->cakeError('error404');

        }
        $controller->view = 'Json';
        $findOptions = array(
            'recursive' => $recursive
        );
        if (is_null($fieldKey)) {
            $fieldKey = 'id';
        }
        if (is_null($fieldNames)) {
            $findOptions['fields'] = array(
                $fieldKey,
                $controller->{$modelClass}->displayField
            );
        } else {
            $findOptions['fields'] = $fieldNames;
        }
        if ($conditions) {
            $findOptions['conditions'] = $conditions;
        }
        $findOptions['limit'] = $this->autocompleteLimit;
        if (isset($controller->request->query['term'])) {
            if (is_null($autocompleteSearchFieldNames)) {
                $autocompleteSearchFieldNames = $controller->{$modelClass}->displayField;
            } else { // array
                //@todo handle array
                $autocompleteSearchFieldNames = $autocompleteSearchFieldNames[0];
            }
            $findOptions['conditions'][$autocompleteSearchFieldNames . ' LIKE '] = '%' . $controller->request->query['term'] . '%';
        }
        $data = $controller->{$modelClass}->find('list', $findOptions);
        $controller->set('json', $data);
    }
    function flashuploadset($data)
    {
        Configure::write('debug', 0);
        $controller = $this->Controller;
        $_SESSION['flashupload_data'][$controller->name] = $data;
        echo 'flashupload';
        exit;
    }
		// show thumbnail
	function thumbnail($file_id)
	{
		//Work around the Flash Player Cookie Bug
        if (empty($_SESSION['property_file_info'][$file_id])) {
            header('HTTP/1.1 404 Not found');
            exit(0);
        }
        header('Content-type: '.$_SESSION['property_file_info'][$file_id]['type']);
        header('Content-Length: ' . strlen($_SESSION['property_file_info'][$file_id]['thumb']));
        echo $_SESSION['property_file_info'][$file_id]['thumb'];
        exit(0);
    }
	function _setMemoryLimitForImage($image_path)
    {
        $imageInfo = getimagesize($image_path);
        $memoryNeeded = round(($imageInfo[0] * $imageInfo[1] * $imageInfo['bits'] * $imageInfo['channels'] / 8 + Pow(2, 16)) * 1.65);
        if (function_exists('memory_get_usage') && memory_get_usage() + $memoryNeeded > (integer)ini_get('memory_limit') * pow(1024, 2)) {
            ini_set('memory_limit', (integer)ini_get('memory_limit') + ceil(((memory_get_usage() + $memoryNeeded) - (integer)ini_get('memory_limit') * pow(1024, 2)) / pow(1024, 2)) . 'M');
        }
    }
	// preview image
	function previewImage()
    {
        // Check the upload
        if (!isset($_FILES['Filedata']) || !is_uploaded_file($_FILES['Filedata']['tmp_name']) || $_FILES['Filedata']['error'] != 0) {
            echo 'ERROR:invalid upload';
            exit(0);
        }
		if (!($size = getimagesize($_FILES['Filedata']['tmp_name']))) {
            // image doesn't exist
            return false;
        }
        list($currentWidth, $currentHeight, $currentType) = $size;
		$types = array(
			1 => 'gif',
			'jpeg',
			'png',
			'swf',
			'psd',
			'wbmp'
		);
		$width = 120;
        $height = 90;
		$this->_setMemoryLimitForImage( $_FILES['Filedata']['tmp_name']);
		$image = call_user_func('imagecreatefrom' . $types[$currentType], $_FILES['Filedata']['tmp_name']);

		ini_restore('memory_limit');
        if (!$image) {
            echo 'ERROR:could not create image handle ';
            exit(0);
        }
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

		if (($width > $currentWidth || $height > $currentHeight)) {
			$width = $currentWidth;
			$height = $currentHeight;
		}
		if (function_exists("imagecreatetruecolor") && ($temp = imagecreatetruecolor($width, $height))) {
			imagecopyresampled($temp, $image, 0, 0, $target['x'], $target['y'], $width, $height, $target['width'], $target['height']);
		} else {
			$temp = imagecreate($width, $height);
			imagecopyresized($temp, $image, 0, 0, 0, 0, $width, $height, $currentWidth, $currentHeight);
		}
        // Use a output buffering to load the image into a variable
        ob_start();
		call_user_func('image' . $types[$currentType], $temp);
        $imagevariable = ob_get_contents();
        ob_end_clean();
        $file_id = md5($_FILES['Filedata']['tmp_name']+rand() *100000);

		$_SESSION['property_file_info'][$file_id]['type'] = get_mime($_FILES['Filedata']['tmp_name']);
		$_SESSION['property_file_info'][$file_id]['filename'] = $_FILES['Filedata']['name'];
		$_SESSION['property_file_info'][$file_id]['thumb'] = $imagevariable;
        $handle = fopen($_FILES['Filedata']['tmp_name'], 'r');
        $contents = fread($handle, filesize($_FILES['Filedata']['tmp_name']));
        fclose($handle);
        //Encode for web service
        $base64string = base64_encode($contents);
		$_SESSION['property_file_info'][$file_id]['original'] = $base64string;
		//extension removal
		$file_name=preg_replace('/\.[^.]*$/', '', $_FILES['Filedata']['name']);
        echo $file_id.'|'.$file_name;
        exit;
    }
    function flashupload($multiple = false)
    {
        $controller = $this->Controller;
        $modelClass = Inflector::singularize($controller->name);
        if (isset($_FILES['Filedata']['name']) and !empty($_SESSION['flashupload_data'][$controller->name])) {
            $_FILES['Filedata']['type'] = get_mime($_FILES['Filedata']['tmp_name']);
            $this->data = $_SESSION['flashupload_data'][$controller->name];
            if ($multiple) {
                // update the title field with the file name
                $t_filename = $_FILES['Filedata']['name'];
                $this->data[$modelClass]['title'] = Inflector::humanize(str_replace(array(
                    '_',
                    '-'
                ) , ' ', basename($t_filename, substr($t_filename, strrpos($t_filename, '.')))));
                $controller->{$modelClass}->create();
                if ($controller->{$modelClass}->save($this->data, false)) {
                    $attachments = array();
                    $attachments['Attachment']['filename'] = $_FILES['Filedata'];
                    $attachments['Attachment']['class'] = $modelClass;
                    $attachments['Attachment']['foreign_id'] = $controller->{$modelClass}->getLastInsertId();
                    $controller->{$modelClass}->Attachment->create();
                    $controller->{$modelClass}->Attachment->save($attachments);
                    // save in session to retrieve the last inserted id in controller
                    $_SESSION['flash_uploaded']['data'][] = $controller->{$modelClass}->getLastInsertId();
                }
            } else {
                $attachments = array();
                $attachments['Attachment']['filename'] = $_FILES['Filedata'];
                $attachments['Attachment']['class'] = $modelClass;
                $attachments['Attachment']['foreign_id'] = $this->data['Attachment']['foreign_id'];
                $controller->{$modelClass}->Attachment->create();
                $controller->{$modelClass}->Attachment->save($attachments);
            }
            echo ' '; // Prevent bug in Mac OS 8 flash player
            session_write_close(); // Write session variables!
            exit();
        }
    }
    function normalupload($data, $multiple = false)
    {
        $controller = $this->Controller;
        $modelClass = Inflector::singularize($controller->name);
        if ($multiple) {
            foreach($data['Attachment'] as $attachment) {
                $controller->{$modelClass}->Attachment->Behaviors->attach('ImageUpload');
                if (!empty($attachment['filename']['name'])) {
                    // update the title field with the file name
                    $t_filename = $attachment['filename']['name'];
                    $data[$modelClass]['title'] = Inflector::humanize(str_replace(array(
                        '_',
                        '-'
                    ) , ' ', basename($t_filename, substr($t_filename, strrpos($t_filename, '.')))));
                }
                $controller->{$modelClass}->create();
                if (!empty($attachment['filename']['name']) && $controller->{$modelClass}->save($data, false)) {
                    $attachments = array();
					$attachments['Attachment']['description'] = !empty($attachment['description'])?$attachment['description']:'';
                    $attachments['Attachment']['filename'] = $attachment['filename'];
                    $attachments['Attachment']['class'] = $modelClass;
                    $attachments['Attachment']['foreign_id'] = $controller->{$modelClass}->getLastInsertId();
                    $controller->{$modelClass}->Attachment->create();
                    $controller->{$modelClass}->Attachment->save($attachments);
                    // save in session to retrieve the last inserted id in controller
                    $_SESSION['flash_uploaded']['data'][] = $controller->{$modelClass}->getLastInsertId();
                }
                $controller->{$modelClass}->Attachment->Behaviors->detach('ImageUpload');
            }
        } else {
            foreach($data['Attachment'] as $attachment) {
                $attachments = array();
                if (!empty($attachment['filename']['name'])) {
                    $attachments['Attachment']['filename'] = $attachment['filename'];
                    $attachments['Attachment']['class'] = $modelClass;
                    $attachments['Attachment']['foreign_id'] = $data['foreign_id'];
                    $controller->{$modelClass}->Attachment->create();
                    $controller->{$modelClass}->Attachment->save($attachments);
                }
            }
        }
    }
}
?>
