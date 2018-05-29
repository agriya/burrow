<h2><?php echo __l('Ticket'); ?></h2>
<?php
		echo $this->element('properties-simple-view', array('slug' => $propertyUser['Property']['slug'], 'order_id' => $propertyUser['PropertyUser']['id'], 'config' => 'sec'));
	$show_checkinout = array();
	if(($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Confirmed) && (date('Y-m-d') >= $propertyUser['PropertyUser']['checkin']) && (empty($propertyUser['PropertyUser']['is_host_checkin']))):
			if((($propertyUser['Property']['checkin'] == '00:00:00') || (date('H:i:s') >= $propertyUser['Property']['checkin'])) || ($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived)):
				$show_checkinout['show'] = 1;
				$show_checkinout['value'] = __l('Check in');
				$show_checkinout['action'] = 'check_in';
			endif;
		endif;
		if(empty($show_checkinout) && ($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::PaymentCleared) && (date('Y-m-d') >= $propertyUser['PropertyUser']['checkout']) && empty($propertyUser['PropertyUser']['is_host_checkout'])):
			if(($propertyUser['Property']['checkout'] == '00:00:00') || (date('H:i:s') <= $propertyUser['Property']['checkout'])):
				$show_checkinout['show'] = 1;
				$show_checkinout['value'] = __l('Check out');
				$show_checkinout['action'] = 'check_out';
			endif;
		endif;
	?>
<?php if(!empty($show_checkinout)): ?>
<div id="messages-activities">
<div class="js-response-actions status-link ui-tabs-block  clearfix">
<div class="js-tabs menu-tabs ui-tabs clearfix">
			<ul class="clearfix">			
			<?php if(!empty($show_checkinout['show'])):?>
				<li  class="check-in"><?php echo $this->Html->link($show_checkinout['value'], array('controller' => 'property_users', 'action' => 'process_checkinout', 'order_id' => $propertyUser['PropertyUser']['id'], 'p_action' => $show_checkinout['action'], 'via' => 'ticket'), array('title' => $show_checkinout['value']));?></li>
			<?php endif;?>						
		</ul>			 		
</div>
</div>
</div> 
<?php endif; ?>
