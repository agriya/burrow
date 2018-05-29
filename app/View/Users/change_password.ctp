<?php if (empty($this->request->params['prefix'])): ?>
	<div class ="ver-space clearfix sep-bot top-mspace ">
	<h2 class="text-32 span"><?php echo __l('Change Password'); ?></h2><?php echo $this->element('sidebar', array('config' => 'sec')); ?>
	</div>
	<div class="side1 ">
<?php endif; ?>
<?php if ((isset($this->request->params['prefix']) and $this->request->params['prefix'] == 'admin')) {?>
<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Users'), array('controller'=>'users','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Change Password'); ?></li>
</ul>
<div class="sep-top">
<?php } ?>
<div class="form">
				<?php
					echo $this->Form->create('User', array('action' => 'change_password' ,'class' => 'form-horizontal space')); ?>
					<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin) :
						echo $this->Form->input('user_id', array('empty' => 'Select'));
					endif;
					if($this->Auth->user('role_id') != ConstUserTypes::Admin) :
						echo $this->Form->input('user_id', array('type' => 'hidden'));
						echo $this->Form->input('old_password', array('type' => 'password','label' => __l('Old password') ,'id' => 'old-password'));
					endif;
					echo $this->Form->input('passwd', array('type' => 'password','label' => __l('Enter a new password') , 'id' => 'new-password'));
					echo $this->Form->input('confirm_password', array('type' => 'password', 'label' => __l('Confirm Password'))); ?>
					<div class="form-actions">
						<?php echo $this->Form->submit(__l('Submit'),array('class' => 'btn btn-large btn-primary textb text-16'));?>
					</div>
				<?php echo $this->Form->end();?>
			
</div>
<?php if (empty($this->request->params['prefix'])): ?>
	</div>
<?php endif; ?>