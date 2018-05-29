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
// | Authors: Piotr Klaban                                                |
// +----------------------------------------------------------------------+
//

/**
 * Test script for Numbers::Words
 **/

error_reporting(E_ALL);

require_once('PEAR.php');
require_once('Numbers/Words.php');

$num = "1121771141";

$html_on = 0;
if (isset($_REQUEST)) {
  $html_on = 1;
}
if (isset($_REQUEST) && is_array($_REQUEST) && isset($_REQUEST['num'])) {
  $num = $_REQUEST['num'];
} elseif (isset($argv) && is_array($argv) && isset($argv[1])) {
  $num = $argv[1];
}
$html_on = 0;

$shownum = $num;

while (strlen($shownum) % 3 != 0) {
  $shownum = " " . $shownum;
}

$shownum = ereg_replace("(...)", "\\1 ", $shownum);
$shownum = ereg_replace(" $", "", $shownum);

if ($html_on)
    echo "<center>Test number: <b><u>$shownum</u></b></center><p>\n";
else
    echo sprintf("%42s", 'Test number: ') . $shownum . "\n\n";

$lang = Numbers_Words::getLocales();
$langs = array();

if ($html_on) {
?>
<center>
<table width="100%" border="1" cellspacing="0">
<tr>
  <th width="50">Symbol</th>
  <th width="100">Number system</th>
  <th width="100%">String</th>
</tr>
<?
}

foreach ($lang as $loc_symbol) {
  $classname = "Numbers_Words_" . $loc_symbol;
  @include_once("Numbers/Words/lang.${loc_symbol}.php");
}

reset($lang);

foreach ($lang as $loc_symbol) {
  $classname = "Numbers_Words_" . $loc_symbol;
  $obj = new $classname;
  $ret = $obj->toWords($num);
  if (PEAR::isError($ret)) {
    if ($html_on) {
    }
    echo "Error ($loc_symbol): " . $ret->message . "\n";
    if ($html_on) {
    }
  } else {
    $loc_name = $obj->lang;
    $langs[$loc_symbol] = $loc_name;
    if ($html_on) {
      ?>
      <tr>
        <td align="center"><?php echo $loc_symbol; ?></td>
        <td><nobr><i><?php echo $loc_name; ?></i></nobr></td>
        <td><b><?php echo $ret; ?></b></td>
      </tr><?
    } else {
      echo sprintf("%30s: '", $loc_name . ' (' . $loc_symbol . ')') . $ret . "'\n";
    }
  }
}

reset($langs);

$num .= '.34';
$handle = new Numbers_Words();

while (list ($loc_symbol, $loc_name) = each ($langs)) {
  $ret = $handle->toCurrency($num, $loc_symbol);
  if (PEAR::isError($ret)) {
    if ($html_on) {
    }
    echo "Error ($loc_symbol): " . $ret->message . "\n";
    if ($html_on) {
    }
  } else {
    if ($html_on) {
      ?>
      <tr>
        <td align="center"><?php echo $loc_symbol; ?></td>
        <td><nobr><i><?php echo $loc_name; ?></i></nobr></td>
        <td><b><?php echo $ret; ?></b></td>
      </tr><?
    } else {
      echo sprintf("%30s: ", $loc_name . ' (' . $loc_symbol . ')') . $ret . "\n";
    }
  }
}

if ($html_on) {
?>
</table>
</center>
<?
}

?>
