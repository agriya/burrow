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
// Numbers_Words class extension to spell numbers in Spanish (Castellano).
//

require_once 'Numbers/Words.php';
require_once 'PHPUnit/TestCase.php';

class Numbers_Words_spanish_TestCase extends PHPUnit_TestCase
{
    //contains the MDB object of the db once we have connected
    var $db;

    function Numbers_Words_spanish_TestCase($name)
    {
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
        $digits = array('cero',
                        'uno',
                        'dos',
                        'tres',
                        'cuatro',
                        'cinco',
                        'seis',
                        'siete',
                        'ocho',
                        'nueve'
                       );
        for ($i = 0; $i < 10; $i++)
        {
            $number = Numbers_Words::toWords($i, 'es');
            $this->assertEquals($digits[$i], $number);
        }
    }

    /**
    * Testing numbers between 10 and 99
    */
    function testTens()
    {
        $tens = array(11 => 'once',
                      12 => 'doce',
                      16 => 'dieciseis',
                      19 => 'diecinueve',
                      20 => 'veinte',
                      21 => 'veintiuno',
                      26 => 'veintiseis',
                      30 => 'treinta',
                      31 => 'treinta y uno',
                      40 => 'cuarenta',
                      43 => 'cuarenta y tres',
                      50 => 'cincuenta',
                      55 => 'cincuenta y cinco',
                      60 => 'sesenta',
                      67 => 'sesenta y siete',
                      70 => 'setenta',
                      79 => 'setenta y nueve'
                     );
        foreach ($tens as $number => $word) {
            $this->assertEquals($word, Numbers_Words::toWords($number, 'es'));
        }
    }

    /**
    * Testing numbers between 100 and 999
    */
    function testHundreds()
    {
        $hundreds = array(100 => 'cien',
                          101 => 'ciento uno',
                          199 => 'ciento noventa y nueve',
                          203 => 'doscientos tres',
                          287 => 'doscientos ochenta y siete',
                          300 => 'trescientos',
                          356 => 'trescientos cincuenta y seis',
                          410 => 'cuatrocientos diez',
                          434 => 'cuatrocientos treinta y cuatro',
                          578 => 'quinientos setenta y ocho',
                          689 => 'seiscientos ochenta y nueve',
                          729 => 'setecientos veintinueve',
                          894 => 'ochocientos noventa y cuatro',
                          999 => 'novecientos noventa y nueve'
                         );
        foreach ($hundreds as $number => $word) {
            $this->assertEquals($word, Numbers_Words::toWords($number, 'es'));
        }
    }

    /**
    * Testing numbers between 1000 and 9999
    */
    function testThousands()
    {
        $thousands = array(1000 => 'mil',
                           1001 => 'mil uno',
                           1097 => 'mil noventa y siete',
                           1104 => 'mil ciento cuatro',
                           1243 => 'mil doscientos cuarenta y tres',
                           2385 => 'dos mil trescientos ochenta y cinco',
                           3766 => 'tres mil setecientos sesenta y seis',
                           4196 => 'cuatro mil ciento noventa y seis',
                           5846 => 'cinco mil ochocientos cuarenta y seis',
                           6459 => 'seis mil cuatrocientos cincuenta y nueve',
                           7232 => 'siete mil doscientos treinta y dos',
                           8569 => 'ocho mil quinientos sesenta y nueve',
                           9539 => 'nueve mil quinientos treinta y nueve'
                          );
        foreach ($thousands as $number => $word) {
            $this->assertEquals($word, Numbers_Words::toWords($number, 'es'));
        }
    }
}

?>
