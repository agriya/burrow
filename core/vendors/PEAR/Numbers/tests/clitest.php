<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
//
// +----------------------------------------------------------------------+
// | PHP version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Xavier Noguer                                               |
// +----------------------------------------------------------------------+
//


  require_once 'Numbers_Words_Spanish_testcase.php';
  require_once 'Numbers_Words_Polish_testcase.php';
  require_once 'PHPUnit.php';

  $langs = array('Spanish','Polish');
  foreach ($langs as $lang) {
    $suite = new PHPUnit_TestSuite("Numbers_Words_${lang}_TestCase");
    $result = PHPUnit::run($suite);

    $failures = $result->failures();
    foreach($failures as $failure)
    {
      echo $failure->toString();
    }
  }
?>
