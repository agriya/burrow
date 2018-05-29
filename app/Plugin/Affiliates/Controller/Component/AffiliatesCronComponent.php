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
class AffiliatesCronComponent extends Component
{
    public function main()
    {
        App::import('Model', 'Affiliates.Affiliate');
        $this->Affiliate = new Affiliate();
        $this->Affiliate->update_affiliate_status();
    }
}