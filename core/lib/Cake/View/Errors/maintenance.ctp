<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake.libs.view.templates.errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<?php $this->pageTitle = $name; ?>
<h1 class="maintenance-title text-46 space blackc"><?php echo __l('Maintenance Mode');?></h1>
<p class="no-mar"><?php echo __l('Sorry for the inconvenience.');?></p>
<p class="no-mar"><?php echo __l('Our website is currently undergoing schedule maintenance.');?></p>
<p class="textb no-mar"><?php echo __l('Please try back after some time.');?></p>
<p class="no-mar"><?php echo __l('Thank you for understanding');?></p>