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
class GoogleAnalytic extends AppModel
{
    public $useTable = false;
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
		$this->filterOptions = array(
            ConstFilterOptions::Loggedin => __l('Loggedin Users') ,
            ConstFilterOptions::Refferred => __l('Refferred Users'),
			ConstFilterOptions::Favorited => __l('Favorited Users') ,
			ConstFilterOptions::Voted => __l('Voted Users') ,
			ConstFilterOptions::Commented => __l('Commented Users') ,
			ConstFilterOptions::Booked => __l('Booked Amount Value') ,
			ConstFilterOptions::PropertyPosted => __l('Property Posted Amount Value') 
        );
    }
}
?>