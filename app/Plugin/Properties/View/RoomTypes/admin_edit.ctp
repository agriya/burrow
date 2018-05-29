<?php /* SVN: $Id: $ */ ?>
<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Room Types'), array('controller'=>'room_types','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Edit Room Type'); ?></li>
</ul>
<div class="roomTypes form sep-top">
<?php echo $this->Form->create('RoomType', array('class' => 'form-horizontal space'));?>
	<fieldset>
<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array('label' => __l('Name')));
		echo $this->Form->input('is_active', array('label' => __l('Enable')));
	?>
	</fieldset>
	<div class="form-actions">
      	<?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16')); ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
