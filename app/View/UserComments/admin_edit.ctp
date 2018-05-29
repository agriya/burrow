<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('User Comments'), array('controller'=>'user_comments','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Edit User Comment'); ?></li>
</ul>
<div class="userComments form sep-top">
<?php echo $this->Form->create('UserComment', array('class' => 'form-horizontal space'));?>
	<fieldset>
 		<h2><?php echo __l('Edit User Comment');?></h2>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id',array('label' => __l('User')));
		echo $this->Form->input('posted_user_id',array('label' => __l('Posted user')));
		echo $this->Form->input('comment',array('label' => __l('Comment')));
	?>
	</fieldset>
	<div class="form-actions">
		 <?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
		 <?php echo $this->Form->end();?>
	</div>
</div>
