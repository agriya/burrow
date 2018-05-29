<?php /* SVN: $Id: $ */ ?>
<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Cities'), array('controller'=>'cities','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Edit City'); ?></li>
</ul>
<div class="form sep-top">
<?php echo $this->Form->create('City', array('class' => 'form-horizontal space','action'=>'edit'));?>
 <?php
	echo $this->Form->input('id');
	echo $this->Form->input('country_id', array('empty' => __l('Please Select'), 'label' => __l('Country')));
	echo $this->Form->input('state_id', array('empty' => __l('Please Select'), 'label' => __l('State')));
	echo $this->Form->input('name', array('label' => __l('Name')));
	echo $this->Form->input('latitude', array('label' => __l('Latitude')));
	echo $this->Form->input('longitude', array('label' => __l('Longitude')));
	echo $this->Form->input('timezone', array('label' => __l('Timezone')));
	echo $this->Form->input('county', array('label' => __l('County')));
	echo $this->Form->input('code', array('label' => __l('Code')));
	echo $this->Form->input('is_approved', array('label' => __l('Enable')));
?>
<div class="form-actions">
	<?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16')); ?>
</div>
<?php echo $this->Form->end(); ?>        
</div>