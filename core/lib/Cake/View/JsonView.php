<?php
/**
 * Class of view for JSON
 *
 * @author Juan Basso
 * @url http://blog.cakephp-brasil.org/2008/09/11/trabalhando-com-json-no-cakephp-12/
 * @licence MIT
 */
class JsonView extends View
{
    function render($action = null, $layout = null, $file = null)
    {
        if (!isset($this->viewVars['json'])) {
            return parent::render($action, $layout, $file);
        }
		if ($action == 'autocomplete' || $this->action == 'autocomplete') {
			$out = '[';
			$i = 1;
			foreach($this->viewVars['json'] as $val => $text) {
				$out .= '{ "id": "' . $val . '", "value": "' . $text . '" }';
				if (count($this->viewVars['json']) != $i) {
					$out .= ',';
				}
				$i++;
            }
			$out .= ']';
            Configure::write('debug', 0); // Omit time in end of view
            echo $out;
			return false;
        }
        echo $this->renderJson($this->viewVars['json']);
		return false;
    }
    function renderJson($content)
    {
        header('Content-type: application/json');
        if (function_exists('json_encode')) {
            // PHP 5.2+
            $out = json_encode($content);
        } else {
            // For PHP 4 until PHP 5.1
            $out = $this->_jsonEncode($content);
        }
        Configure::write('debug', 0); // Omit time in end of view
        return $out;
    }
    // Adapted from http://www.php.net/manual/en/function.json-encode.php#82904. Author: Steve (30-Apr-2008 05:35)
    function _jsonEncode($content)
    {
        if (is_null($content)) {
            return 'null';
        }
        if ($content === false) {
            return 'false';
        }
        if ($content === true) {
            return 'true';
        }
        if (is_scalar($content)) {
            if (is_float($content)) {
                return floatval(str_replace(",", ".", strval($content)));
            }
            if (is_string($content)) {
                static $jsonReplaces = array(
                    array(
                        "\\",
                        "/",
                        "\n",
                        "\t",
                        "\r",
                        "\b",
                        "\f",
                        '"'
                    ) ,
                    array(
                        '\\\\',
                        '\\/',
                        '\\n',
                        '\\t',
                        '\\r',
                        '\\b',
                        '\\f',
                        '\"'
                    )
                );
                return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $content) . '"';
            } else {
                return $content;
            }
        }
        $isList = true;
        for ($i = 0, reset($content); $i < count($content); $i++, next($content)) {
            if (key($content) !== $i) {
                $isList = false;
                break;
            }
        }
        $result = array();
        if ($isList) {
            foreach($content as $v) {
                $result[] = $this->_jsonEncode($v);
            }
            return '[' . join(',', $result) . ']';
        } else {
            foreach($content as $k => $v) {
                $result[] = $this->_jsonEncode($k) . ':' . $this->_jsonEncode($v);
            }
            return '{' . join(',', $result) . '}';
        }
    }
}
?>