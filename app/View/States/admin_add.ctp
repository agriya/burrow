<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('States'), array('controller'=>'states','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Add State'); ?></li>
</ul>
<div class="states form sep-top">
<?php echo $this->Form->create('State',  array('class' => 'form-horizontal space','action'=>'add'));?>
<fieldset>
 <?php
	echo $this->Form->input('country_id',array('empty'=>__l('Please Select')));
	echo $this->Form->input('name', array('label' => __l('Name')));
	echo $this->Form->input('code', array('label' => __l('Code')));
	echo $this->Form->input('adm1code', array('label' => __l('Adm1code')));
	echo $this->Form->input('is_approved', array('label' => __l('Enable')));
?>
</fieldset>
<div class="form-actions">
	<?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-large btn-primary textb text-16')); ?>
</div>
<?php echo $this->Form->end(); ?>
</div>