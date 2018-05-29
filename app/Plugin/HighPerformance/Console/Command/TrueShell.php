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
/**
 * Adds logging goodness, help framework, let's you create autoloaders, draw
 * CLI columns
 */
$file_trueshell = APP . '/Console/Command/TrueShell.php';
if (file_exists($file_trueshell)) {
    require_once $file_trueshell;
    return;
}
class TrueShell extends Shell
{
    public function sensible($arguments) 
    {
        if (is_object($arguments)) {
            return get_class($arguments);
        }
        if (!is_array($arguments)) {
            if (!is_numeric($arguments) && !is_bool($arguments)) {
                $arguments = "'" . $arguments . "'";
            }
            return $arguments;
        }
        $arr = array();
        foreach($arguments as $key => $val) {
            if (is_array($val)) {
                $val = json_encode($val);
            } elseif (is_object($val)) {
                $val = get_class($val);
            } elseif (!is_numeric($val) && !is_bool($val)) {
                $val = "'" . $val . "'";
            }
            if (strlen($val) > 33) {
                $val = substr($val, 0, 30) . '...';
            }
            $arr[] = $key . ': ' . $val;
        }
        return join(', ', $arr);
    }
    protected function _log($level, $format, $arg1 = null, $arg2 = null, $arg3 = null) 
    {
        $arguments = func_get_args();
        $level = array_shift($arguments);
        $format = array_shift($arguments);
        $str = $format;
        if (count($arguments)) {
            foreach($arguments as $k => $v) {
                $arguments[$k] = $this->sensible($v, '');
            }
            $str = vsprintf($str, $arguments);
        }
        $this->out($level . ': ' . $str);
        return $str;
    }
    public function crit($format, $arg1 = null, $arg2 = null, $arg3 = null) 
    {
        $args = func_get_args();
        array_unshift($args, __FUNCTION__);
        $str = call_user_func_array(array(
            $this,
            '_log'
        ) , $args);
        trigger_error($str, E_USER_ERROR);
        exit(1);
    }
    public function err($format, $arg1 = null, $arg2 = null, $arg3 = null) 
    {
        $args = func_get_args();
        array_unshift($args, __FUNCTION__);
        $str = call_user_func_array(array(
            $this,
            '_log'
        ) , $args);
        trigger_error($str, E_USER_ERROR);
        return false;
    }
    public function warn($format, $arg1 = null, $arg2 = null, $arg3 = null) 
    {
        $args = func_get_args();
        array_unshift($args, __FUNCTION__);
        $str = call_user_func_array(array(
            $this,
            '_log'
        ) , $args);
        return false;
    }
    public function info($format, $arg1 = null, $arg2 = null, $arg3 = null) 
    {
        $args = func_get_args();
        array_unshift($args, __FUNCTION__);
        $str = call_user_func_array(array(
            $this,
            '_log'
        ) , $args);
        return true;
    }
    public function humanize($str) 
    {
        return Inflector::humanize(trim(str_replace('/', ' ', $str)));
    }
}
