<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('User Comments'), array('controller'=>'user_comments','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Add User Comment'); ?></li>
</ul>
<div class="userComments form sep-top">
<?php echo $this->Form->create('UserComment', array('class' => 'form-horizontal space'));?>
	<fieldset>
	<?php
		echo $this->Form->input('user_id',array('label' => __l('User')));
		echo $this->Form->input('posted_user_id',array('label' => __l('Posted User')));
		echo $this->Form->input('comment',array('label' => __l('Comment')));
	?>
	</fieldset>
<div class="form-actions">
	<?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-large btn-primary textb text-16')); ?>
</div>
<?php echo $this->Form->end(); ?>
</div>
