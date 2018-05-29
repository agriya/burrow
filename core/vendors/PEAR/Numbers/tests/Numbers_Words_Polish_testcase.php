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
// Numbers_Words class extension to spell numbers in Polish.
//

require_once 'Numbers/Words.php';
require_once 'PHPUnit/TestCase.php';

class Numbers_Words_Polish_TestCase extends PHPUnit_TestCase
{
    var $db;
    var $handle;

    function Numbers_Words_Polish_TestCase($name)
    {
        $this->handle = new Numbers_Words();
        $this->PHPUnit_TestCase($name);
    }

    function setUp()
    {
    }

    function tearDown()
    {
    }

    /**
    * Testing numbers between 0 and 9
    */
    function testDigits()
    {
        $digits = array('zero',
                        'jeden',
                        'dwa',
                        'trzy',
                        'cztery',
                        'piêæ',
                        'sze¶æ',
                        'siedem',
                        'osiem',
                        'dziewiêæ'
                       );
        for ($i = 0; $i < 10; $i++)
        {
            $number = $this->handle->toWords($i, 'pl');
            $this->assertEquals($digits[$i], $number);
        }
    }

    /**
    * Testing numbers between 10 and 99
    */
    function testTens()
    {
        $tens = array(11 => 'jedena¶cie',
                      12 => 'dwana¶cie',
                      16 => 'szesna¶cie',
                      19 => 'dziewiêtna¶cie',
                      20 => 'dwadzie¶cia',
                      21 => 'dwadzie¶cia jeden',
                      26 => 'dwadzie¶cia sze¶æ',
                      30 => 'trzydzie¶ci',
                      31 => 'trzydzie¶ci jeden',
                      40 => 'czterdzie¶ci',
                      43 => 'czterdzie¶ci trzy',
                      50 => 'piêædziesi±t',
                      55 => 'piêædziesi±t piêæ',
                      60 => 'sze¶ædziesi±t',
                      67 => 'sze¶ædziesi±t siedem',
                      70 => 'siedemdziesi±t',
                      79 => 'siedemdziesi±t dziewiêæ'
                     );
        foreach ($tens as $number => $word) {
            $this->assertEquals($word, $this->handle->toWords($number, 'pl'));
        }
    }

    /**
    * Testing numbers between 100 and 999
    */
    function testHundreds()
    {
        $hundreds = array(100 => 'sto',
                          101 => 'sto jeden',
                          199 => 'sto dziewiêædziesi±t dziewiêæ',
                          203 => 'dwie¶cie trzy',
                          287 => 'dwie¶cie osiemdziesi±t siedem',
                          300 => 'trzysta',
                          356 => 'trzysta piêædziesi±t sze¶æ',
                          410 => 'czterysta dziesiêæ',
                          434 => 'czterysta trzydzie¶ci cztery',
                          578 => 'piêæset siedemdziesi±t osiem',
                          689 => 'sze¶æset osiemdziesi±t dziewiêæ',
                          729 => 'siedemset dwadzie¶cia dziewiêæ',
                          894 => 'osiemset dziewiêædziesi±t cztery',
                          999 => 'dziewiêæset dziewiêædziesi±t dziewiêæ'
                         );
        foreach ($hundreds as $number => $word) {
            $this->assertEquals($word, $this->handle->toWords($number, 'pl'));
        }
    }

    /**
    * Testing numbers between 1000 and 9999
    */
    function testThousands()
    {
        $thousands = array(1000 => 'jeden tysi±c',
                           1001 => 'jeden tysi±c jeden',
                           1097 => 'jeden tysi±c dziewiêædziesi±t siedem',
                           1104 => 'jeden tysi±c sto cztery',
                           1243 => 'jeden tysi±c dwie¶cie czterdzie¶ci trzy',
                           2385 => 'dwa tysi±ce trzysta osiemdziesi±t piêæ',
                           3766 => 'trzy tysi±ce siedemset sze¶ædziesi±t sze¶æ',
                           4196 => 'cztery tysi±ce sto dziewiêædziesi±t sze¶æ',
                           5846 => 'piêæ tysiêcy osiemset czterdzie¶ci sze¶æ',
                           6459 => 'sze¶æ tysiêcy czterysta piêædziesi±t dziewiêæ',
                           7232 => 'siedem tysiêcy dwie¶cie trzydzie¶ci dwa',
                           8569 => 'osiem tysiêcy piêæset sze¶ædziesi±t dziewiêæ',
                           9539 => 'dziewiêæ tysiêcy piêæset trzydzie¶ci dziewiêæ'
                          );
        foreach ($thousands as $number => $word) {
            $this->assertEquals($word, $this->handle->toWords($number, 'pl'));
        }
    }
}

?>
