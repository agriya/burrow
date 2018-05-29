<?php /* SVN: $Id: $ */ ?>
<div class="properties properties-craigslist js-responses">
	<h2 class="ver-space top-mspace text-32 sep-bot"><?php echo __l('Post to Craigslist') . ' - ' . $this->Html->cText($property['Property']['title'],false);?> </h2>
	<?php echo $this->Form->create('Property', array('action' => 'post_to_craigslist', 'class' => 'form-horizontal space add-property js-post-craigslist-form {"container":"js-responses"}'));?>
		<div>
			<fieldset>
					<?php echo $this->Form->input('title', array('label' => __l('Posting Title'))); ?>
					<?php echo $this->Form->input('craigslist_category_id', array('label' => __l('Category'), 'empty' => __l('Please Select'))); ?>
					<?php echo $this->Form->input('craigslist_market_id', array('label' => __l('Market'), 'empty' => __l('Please Select'))); ?>
					<?php echo $this->Form->input('property_id', array('type' => 'hidden')); ?>
			</fieldset>
			<div class="form-actions">
				<?php echo $this->Form->submit(__l('Post to Craigslist'), array('class' => 'btn btn-large btn-primary textb text-16')); ?>
			</div>
		</div>
	<?php echo $this->Form->end();?>
</div>
<div class="hide js-craigslist-form"></div>