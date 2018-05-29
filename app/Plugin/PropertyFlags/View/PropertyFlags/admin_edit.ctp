<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Property Flags'), array('controller'=>'property_flags','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Edit Property Flag'); ?></li>
</ul>
<div class="propertyFlags propertyFlags-form form sep-top">
    	<?php echo $this->Form->create('PropertyFlag', array('class' => 'form-horizontal space'));?>
       <fieldset class="form-block round-5">
<?php
				echo $this->Form->input('id');
				echo $this->Form->autocomplete('PropertyFlag.title', array('label'=> __l('Property'), 'acFieldKey' => 'PropertyFlag.property_id', 'acFields' => array('Property.title'), 'acSearchFieldNames' => array('Item.title'), 'maxlength' => '100', 'acMultiple' => false));
				echo $this->Form->input('property_flag_category_id');
				echo $this->Form->input('message');
?>
    	</fieldset>
	<div class="form-actions">
	<?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
	</div>
	<?php echo $this->Form->end();?>

</div>