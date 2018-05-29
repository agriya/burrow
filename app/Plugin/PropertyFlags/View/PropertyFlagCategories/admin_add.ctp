<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Property Flag Categories'), array('controller'=>'property_flag_categories','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Add Flag Category'); ?></li>
</ul>
<div class="propertiesFlagCategories form sep-top">
<?php echo $this->Form->create('PropertyFlagCategory', array('class' => 'form-horizontal space'));?>
	<fieldset>
    	<?php echo $this->Form->input('name', array('label' => __l('Name'))); ?>
    	<?php echo $this->Form->input('is_active',array('label'=> __l('Enable'))); ?>
	</fieldset>
<div class="form-actions">
<?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
</div>
<?php echo $this->Form->end();?>
</div>