<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Languages'), array('controller'=>'languages','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Edit Language'); ?></li>
</ul>
<div class="languages form sep-top">
	<?php echo $this->Form->create('Language', array('class' => 'form-horizontal space'));?>
		<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name',array('label' => __l('Name')));
		echo $this->Form->input('iso_alpha2',array('label' => __l('iso_alpha2')));
		echo $this->Form->input('iso_alpha3',array('label' => __l('iso_alpha3')));
		echo $this->Form->input('is_active',array('label' => __l('Enable')));
	?>
	</fieldset>
<div class="form-actions">
	<?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16')); ?>
		<div class="cancel-block">
			<?php echo $this->Html->link(__l('Cancel'), array('action' => 'index'), array('class' =>'btn btn-large textb text-16')); ?>
		</div>	
</div>
<?php echo $this->Form->end(); ?>        
</div>