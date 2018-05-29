<?php $text_class=(Configure::read('property.listing_fee') && !Configure::read('property.is_auto_approve'))? "text-12" : "text-16";?>
<div class="project_guideline ver-space clearfix">
	<ul class="add-pg-block clearfix unstyled no-mar">
			  <li class="span no-mar"><span class="btn btn-large mob-clr"><?php echo __l('Add Property'); ?> </span> 	</li>
         <?php if (Configure::read('property.listing_fee')) {
						$fee =__l('Listing Fee ');
						$fee .=$this->Html->siteCurrencyFormat(Configure::read('property.listing_fee'),false);
				?>

				<li class="span no-mar"> <span class="btn btn-large offset1 mob-clr "><?php echo __l('Pay Listing Fee');?> <span class="<?php echo $text_class;?>"><?php echo __l(' ('.$fee.')'); ?> </span></span></li>
				<?php } ?>
				<?php if (!Configure::read('property.is_auto_approve')) { ?>
				<li class="span no-mar"> <span class="btn btn-large offset1 mob-clr "><?php echo __l('Pending'); ?> <span class="<?php echo $text_class;?>"><?php echo  __l('(Admin will approve your property)'); ?></span> </span></li>
				<?php } ?>
				<li class="span no-mar"><div class="offset1"> <div class="btn btn-large mob-clr"><?php echo __l('Listed'); ?></div></div></li>
			</ul>
 </div>