<?php /* SVN: $Id: $ */ ?>
<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Cancellation Policies'), array('controller'=>'cancellation_policies','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Add Cancellation Policy'); ?></li>
</ul>
<div class="cancellationPolicies form sep-top">
	<?php echo $this->Form->create('CancellationPolicy', array('class' => 'form-horizontal space'));?>
		<fieldset>
			<?php
				echo $this->Form->input('name', array('label' => __l('Name')));
				echo $this->Form->input('days', array('label' => __l('Prior Days'), 'info' => __l('Traveler can get percentage of refund, if he canceled before the given no. of days before check-in date.')));
				echo $this->Form->input('percentage', array('label' => __l('Percentage'), 'info' => __l('Percentage of amount will be refund to traveler')));
				echo $this->Form->input('is_active', array('type' => 'checkbox', 'label' => __l('Enable')));
			?>
		</fieldset>
	<div class="form-actions">
		<?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
    </div>
    <?php echo $this->Form->end();?>		
</div>