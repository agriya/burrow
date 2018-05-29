<h2 class="ver-space clearfix sep-bot top-mspace text-32"><?php echo __l('How it Works'); ?></h2>
<div class="text-18 top-mspace top-space textb"><?php echo __l('Book a Property'); ?></div>
<div class= "thumbnail clearfix space">
	<?php echo $this->element('booking_guideline', array('config' => 'sec')); ?>
</div>
<div class="space" >
<span class="textb"><?php echo __l('Site Service Fee from Traveler'); ?> :</span> <?php echo Configure::read('property.booking_service_fee').'%';?>
</div>
<div class="space bot-mspace" >
<span class="textb"><?php echo __l('Site Service Fee from Host'); ?> :</span> <?php echo Configure::read('property.host_commission_amount').'%';?>
</div>