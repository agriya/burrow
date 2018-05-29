<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Users'), array('controller'=>'users','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Email to users'); ?></li>
</ul>
<div class="form sep-top">
<?php echo $this->Form->create('User', array('action' => 'send_mail', 'class' => 'form-horizontal space'));?>
	<?php
	if(empty($this->request->data['Contact']['id'])):
		echo $this->Form->input('bulk_mail_option_id', array('empty' => __l('Select'), 'label' => __l('Bulk Mail Option')));
		echo $this->Form->autocomplete('send_to', array('id' => 'message-to',  'label'=> __l('Send To'), 'acFieldKey' => 'User.send_to_user_id',
										'acFields' => array('User.email'),
										'acSearchFieldNames' => array('User.email'),
										'maxlength' => '100', 'acMultiple' => true
									   ));
	else:
		 echo $this->Form->input('send_to', array('readonly' => 'readonly'));
		 echo $this->Form->input('Contact.id',array('type'=>'hidden'));
	endif;
	echo $this->Form->input('subject', array('label' => __l('Subject')));
	echo $this->Form->input('message', array('label' => __l('Message'), 'type' => 'textarea'));
	  ?>

	<div class="form-actions">
	<?php
	echo $this->Form->submit(__l('Send'), array('class' => 'btn btn-large btn-primary textb text-16'));
	if(!empty($this->request->data['Contact']['id'])):
?>
<div class="cancel-block">
		<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'contacts', 'action' => 'index'), array('class' => 'cancel-link dc', 'title' => __l('Cancel'), 'escape' => false));?>
	</div>
<?php endif; ?>
</div>
<?php
	echo $this->Form->end();
?>
</div>