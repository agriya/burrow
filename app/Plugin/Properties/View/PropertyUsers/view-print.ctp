<?php /* SVN: $Id: $ */ ?>
<style type="text/css">
<!--
.style1 {font-size: 20px}
.style2 {
	font-size: 11px;
	font-weight: bold;
}
.style3 {font-size: 11px}
.style4 {font-size: 13px;
    font-weight: bold;
}
.style6 {
	font-size: 15px;
	font-weight: bold;
}
.style7 {font-size: 17px}
.style8 {font-size: 22px}
.style9 {
	font-size: 12px
}
.style10 {font-size: 22px; font-weight: bold; }
.style11 {font-size: 15px}
.style13 {
	font-size: 18px;
}
.style14 {
	font-size: 21px;
}
.link {
    text-decoration:none;
    color:#000;
    margin:0 0 0 15px;
}
-->
</style>
<div style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
<table width="675px" align="center" cellpadding="0" cellspacing="0">
  <tr><td>
  <table style="border-bottom:2px solid #000000;" width="675px" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding:35px 0 0 0;"><span class="style14"><?php echo __l('Ticket'); ?></span></td>
    <td style="padding:35px 0 0 0;"><span class="style13"><?php echo '#' . $propertyUser['PropertyUser']['top_code']; ?></span></td>
    <td><div align="right"><img src="../../img/logo.png" title="<?php echo Configure::read('site.name'); ?>" /></div>
    <div>
      <div style="padding-bottom:5px;" align="right"><?php echo Router::url('/',true);  ?></div>
    </div>    </td>
  </tr>
  </table>
<table  style="border-bottom:1px dashed #000000; padding:10px 0 15px 0;"width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="62%"><span style="color:#F47564;font-size:17px;font-weight:bold;"><?php echo $this->Html->cText($propertyUser['Property']['title'],false);?></span></td>
    <td width="25%"><div align="right" class="style2"><strong><?php echo __l('Phone:'); ?></strong></div></td>
    <td width="13%"><div align="right" class="style3"><?php echo $this->Html->cText($propertyUser['Property']['User']['UserProfile']['phone']) ;?></div></td>
  </tr>
  <tr>
    <td><?php $url = Router::url('/',true); ?><p style="color:#b2b2b2; padding:5px 0 5px 25px; margin:0;" class="style3" title="<?php echo !empty($propertyUser['Property']['Country']['name']) ? $propertyUser['Property']['Country']['name'] : ''; ?> "><?php echo $this->Html->cText($propertyUser['Property']['address']);?>
	</p></td>
    <td><div align="right" class="style3"><strong><?php echo __l('Backup phone:'); ?></strong></div></td>
    <td><div align="right" class="style3"><?php echo $this->Html->cText($propertyUser['Property']['User']['UserProfile']['backup_phone']);?></div></td>
  </tr>
</table>
<?php 
	$start = split('-', $propertyUser['PropertyUser']['checkin']);
	$end = split('-', getCheckoutDate($propertyUser['PropertyUser']['checkout']));
	$days = getCheckinCheckoutDiff($propertyUser['PropertyUser']['checkin'], getCheckoutDate($propertyUser['PropertyUser']['checkout']));
?>
<table style="border-bottom:1px dashed #000000; padding:10px 0 15px 0;" width="485px" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding:0 0 10px 0;" width="35%"><div align="center"><span class="style7"><?php echo date('D, d M Y',mktime(0,0,0,$start[1],$start[2],$start[0])); ?></span></div></td>
    <td style="padding:0 0 10px 0;"width="28%"><div align="center"><span class="style4"><?php echo '(' . $days . ' - ' . __l('nights') . ')'; ?></span></div></td>
    <td style="padding:0 0 10px 0;" width="37%"><div align="center"><span class="style7"><?php echo date('D, d M Y',mktime(0,0,0,$end[1],$end[2],$end[0])); ?></span></div></td>
  </tr>
  <tr>
    <td><div align="center"><span class="style4"><?php echo date('h:i a', strtotime($propertyUser['Property']['checkin'])); ?></span></div></td>
    <td>&nbsp;</td>
    <td><div align="center"><span class="style4"><?php echo date('h:i a', strtotime($propertyUser['Property']['checkout'])); ?></span></div></td>
  </tr>
</table>
<table style="padding:20px 0 10px 0;"width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="19%" style="vertical-align:top;">
	<?php
		echo $this->Html->getUserAvatarLink($propertyUser['Property'], 'big_thumb');
	 ?>
    	<p><strong><?php echo __l('Host'); ?></strong></p>
        <?php echo $propertyUser['Property']['User']['username']; ?></td>
<td width="9%" style="vertical-align:top;"><div align="left"> <?php
	  echo $this->Html->showImage('Property', $propertyUser['Property']['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($propertyUser['Property']['title'], false)), 'title' => $this->Html->cText($propertyUser['Property']['title'], false)));
	 ?></div></td>
    <td width="62%"><div align="right"><?php if(!empty($propertyUser['Property']['address'])): ?>
				<?php $map_zoom_level = !empty($propertyUser['Property']['map_zoom_level']) ? $propertyUser['Property']['zoom_level'] : '10';?>
					<img src="<?php echo $this->Html->formGooglemap($propertyUser['Property'],'284x224'); ?>" width="300" height="150"/>
				<?php endif; ?></div></td>
  </tr>
</table>
<table style="border-bottom:1px dashed #000000;" width="485px" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr><td>&nbsp;</td></tr></table>
<table style="padding-bottom:15px;" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h2 style="font-weight:normal; margin-bottom:0;"><span class="style8"><?php echo __l('Conditions'); ?></span></h2></td>
  </tr>
  <tr>
    <td><h3 style="margin-bottom:0; margin-left:45px;"class="style6"><?php echo __l('Cancellation Policy'); ?></h3>
		<?php
			if ($propertyUser['Property']['CancellationPolicy']['percentage'] == '0.00') {
				$percentage = 'No';
			} elseif ($propertyUser['Property']['CancellationPolicy']['percentage'] == '100.00') {
				$percentage = 'Full';
			} else {
				$percentage = $this->Html->cFloat($propertyUser['Property']['CancellationPolicy']['percentage'], false) . '%';
			}
		?>
      <p style="margin:3px 0 0 50px; line-height:18px;" class="style9"><?php echo $this->Html->cText($propertyUser['Property']['CancellationPolicy']['name'], false) . ': ' . sprintf(__l('%s refund %s day(s) prior to arrival, except fees'), $percentage, $this->Html->cText($propertyUser['Property']['CancellationPolicy']['days'], false)); ?></p></td>
  </tr>
  <?php if(!empty($propertyUser['Property']['house_rules'])): ?>
  <tr>
    <td><h3 style="margin-bottom:0; margin-left:45px;" class="style6"><?php echo __l('House rule'); ?></h3>
      <p style="margin:3px 0 0 50px; line-height:18px" class="style9"><?php echo  $this->Html->cText($propertyUser['Property']['house_rules'],false); ?></p></td>
  </tr>
  <?php endif; ?>
</table>
<table width="485px" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr><td>&nbsp;</td></tr></table>
<?php if(!empty($propertyUser['Property']['house_manual'])): ?>
<table style="padding-bottom:15px;border-top:1px dashed #000000;" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td><h2 class="style10" style="font-weight:normal; margin-bottom:0;"><?php echo __l('House Manual'); ?></h2>
    <p class="style9" style="margin:3px 0 0 30px; line-height:18px"><?php echo  $this->Html->cText($propertyUser['Property']['house_manual'],false); ?></p></td>
  </tr>
</table>
  <?php endif; ?>
  <?php if(!empty($propertyUser['Property']['location_manual'])): ?>
<table style="padding-bottom:15px;border-top:1px dashed #000000;" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td><h2 class="style10" style="font-weight:normal; margin-bottom:0;"><?php echo __l('Location Manual'); ?></h2>
    <p class="style9" style="margin:3px 0 0 30px; line-height:18px"><?php echo  $this->Html->cText($propertyUser['Property']['location_manual'],false); ?></p></td>
  </tr>
</table>
  <?php endif; ?>
<table style="border-bottom:2px solid #000;border-top:2px solid #000;  padding-bottom:15px; position:relative;" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  </tr>
  <tr>
    <td width="100%" style="padding:0 0 0 45px;"><h3 class="style11"><?php echo configure::read('site.name'), __l(' Notes'); ?></h3></td>    
  </tr>
  <tr>
    <td width="100%" style="padding:0 0 5px 45px;"  class="style9"><?php echo sprintf(__l('Full payment will be released on %s. (check in date at the time of booking + %s day(s))'), date('M d, Y h:i A', strtotime('+'.Configure::read('property.days_after_amount_withdraw').' days', strtotime($propertyUser['PropertyUser']['checkin']))), Configure::read('property.days_after_amount_withdraw')); ?></td>
  </tr>
  <tr>
    <td width="100%" style="padding:0 0 5px 45px;"  class="style9"><?php echo __l('Problems? Raise dispute before '),date('M d, Y h:i A', strtotime('+'.Configure::read('property.days_after_amount_withdraw').' days', strtotime($propertyUser['PropertyUser']['checkin']))), __l(' at '), Router::url(array(
							'controller' => 'messages',
							'action' => 'activities',
							'order_id' => $propertyUser['PropertyUser']['id'],
							'admin' => false
						) , true); ?></td>    
  </tr>
  <tr>
    <td width="100%" style="padding:0 0 5px 45px;"  class="style9"><?php echo sprintf(__l('Raising dispute will be available from %s. (check in date at the time of booking)'), date('M d, Y h:i A', strtotime($propertyUser['PropertyUser']['checkin']))); ?></td>    
  </tr>
  <tr>
    <td width="100%" style="padding:0 0 5px 45px;" class="style9"><?php echo __l('To track your trip visit activities page '), Router::url(array(
							'controller' => 'messages',
							'action' => 'activities',
							'order_id' => $propertyUser['PropertyUser']['id'],
							'admin' => false
						) , true); ?></td>    
  </tr>
  <tr>
    <td width="100%" style="padding:0 0 5px 45px;"  class="style9"><?php echo __l('After the check out, be sure to give feedback about the property in '),configure::read('site.name'); ?></td>    
  </tr>  
</table>
<table style="border-bottom:2px solid #000000; margin:0px 0 0 0; padding:15px 0 15px 0;" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="19%" style="padding:0px;margin:0px; vertical-align:top;">
    <h3 style="padding:0 0 7px 0;margin:0px;"><?php echo __l('Host copy'); ?></h3>
    <p style="margin:10px 0 0 0;padding:0px;"><?php echo __l('Ticket'); ?>
    <?php echo '#' . $propertyUser['PropertyUser']['top_code']; ?></p>
    </td>
    <td width="25%" style="padding:0px;margin:0px;vertical-align:top;"><div align="center"><span class="style7"><?php echo date('D, d M Y',mktime(0,0,0,$start[1],$start[2],$start[0])); ?></span></div>
    <div align="center" style="margin:10px 0 0 0;"><span class="style4"><?php echo date('h:i a', strtotime($propertyUser['Property']['checkin'])); ?></span></div>
    </td>
    <td width="14%" style="padding:0px;margin:0px;vertical-align:top;">
    <div align="center">
	<?php
		$days = getCheckinCheckoutDiff($propertyUser['PropertyUser']['checkin'], getCheckoutDate($propertyUser['PropertyUser']['checkout']));
	?>
    <h3 style="padding:4px 0 7px;margin:0px; font-size:12px"><?php echo '(' . $days . ' - ' . __l('nights') . ')'; ?></h3>
    </div>
    </td>
    <td width="26%" style="padding:0px;margin:0px; vertical-align:top;">
    <div align="center"><span class="style7"><?php echo date('D, d M Y',mktime(0,0,0,$end[1],$end[2],$end[0])); ?></span></div>
    <div align="center" style="margin:10px 0 0 0;"><span class="style4"><?php echo date('h:i a', strtotime($propertyUser['Property']['checkout'])); ?></span></div>
    </td>
    <td width="16%" style="padding:0px;margin:0px; vertical-align:top;"><div align="center"><?php
				if(Configure::read('barcode.is_barcode_enabled') == 1) {
					$barcode_width = Configure::read('barcode.width');
					$barcode_height = Configure::read('barcode.height');
					if(Configure::read('barcode.symbology') == 'qr') {
					  $qr_site_url = Router::url(array(
							'controller' => 'property_users',
							'action' => 'check_qr',
							$propertyUser['PropertyUser']['top_code'],
							$propertyUser['PropertyUser']['bottum_code'],
							'admin' => false
						) , true);
					  ?>
					   <img src="http://chart.apis.google.com/chart?cht=qr&chs=<?php echo $barcode_width; ?>x<?php echo $barcode_height; ?>&chl=<?php echo $qr_site_url; ?>" alt = "[Image: Property qr code]"/>
			<?php 
					} 
				}
			?></div>
			<div align="center"><strong> <?php echo  $propertyUser['PropertyUser']['bottum_code']; ?></strong></div>
            </td>
  </tr>

</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><p>&copy;<?php echo __l('2011'); ?> <a href="<?php echo Router::url('/'); ?>" title="<?php echo Configure::read('site.name'); ?>"><?php echo configure::read('site.name'); ?></a><?php echo __l('. All rights reserved.'); ?></p>
      </td>
  </tr>
</table>

</td>
</tr>
</table>
</div>