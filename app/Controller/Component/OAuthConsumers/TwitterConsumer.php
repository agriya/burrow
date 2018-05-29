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
class TwitterConsumer extends AbstractConsumer
{
    public function __construct()
    {
        parent::__construct(Configure::read('twitter.consumer_key') , Configure::read('twitter.consumer_secret'));
    }
}
?>