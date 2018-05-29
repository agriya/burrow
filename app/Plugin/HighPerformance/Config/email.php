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
class EmailConfig
{
    public function __construct() 
    {
        $this->smtp = array(
            'host' => Configure::read('mail.smtp_host') ,
            'port' => Configure::read('mail.smtp_port') ,
            'username' => Configure::read('mail.smtp_username') ,
            'password' => Configure::read('mail.smtp_password') ,
            'transport' => 'SMTP',
        );
    }
}
?>
