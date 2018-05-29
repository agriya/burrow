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
/* SVN FILE: $Id: sessions.php 173 2009-01-31 12:51:40Z rajesh_04ag02 $ */
/*Sessions schema generated on: 2007-11-25 07:11:54 : 1196004714*/
/**
 * This is Sessions Schema file
 *
 * Use it to configure database for Sessions
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config.sql
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7805 $
 * @modifiedby    $LastChangedBy: AD7six $
 * @lastmodified  $Date: 2008-10-30 23:00:26 +0530 (Thu, 30 Oct 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/*
*
* Using the Schema command line utility
* cake schema run create Sessions
*
*/
class SessionsSchema extends CakeSchema
{
    var $name = 'Sessions';
    function before($event = array()) 
    {
        return true;
    }
    function after($event = array()) 
    {
    }
    var $cake_sessions = array(
        'id' => array(
            'type' => 'string',
            'null' => false,
            'key' => 'primary'
        ) ,
        'data' => array(
            'type' => 'text',
            'null' => true,
            'default' => NULL
        ) ,
        'expires' => array(
            'type' => 'integer',
            'null' => true,
            'default' => NULL
        ) ,
        'indexes' => array(
            'PRIMARY' => array(
                'column' => 'id',
                'unique' => 1
            )
        )
    );
}
?>