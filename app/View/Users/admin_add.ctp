<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Users'), array('controller'=>'users','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Add User'); ?></li>
</ul>
<div class="users form sep-top">
<?php echo $this->Form->create('User', array('class' => 'form-horizontal space'));?>
	<fieldset>	
	<?php
        echo $this->Form->input('role_id', array('label' => __l('User Type')));
		echo $this->Form->input('email');
		echo $this->Form->input('username');
		echo $this->Form->input('passwd', array('label' => __l('Password')));
	?>
	</fieldset>
<div class="form-actions">
	<?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-large btn-primary textb text-16')); ?>
</div>
<?php echo $this->Form->end(); ?>
</div>