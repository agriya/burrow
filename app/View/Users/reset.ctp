<h2 class="ver-space sep-bot top-mspace text-32"><?php echo __l('Reset your password'); ?></h2>
<?php
	echo $this->Form->create('User', array('action' => 'reset/'.$user_id.'/'.$hash ,'class' => 'form-horizontal space')); ?>
	<?php
	echo $this->Form->input('user_id', array('type' => 'hidden'));
	echo $this->Form->input('hash', array('type' => 'hidden'));
	echo $this->Form->input('passwd', array('type' => 'password','label' => __l('Enter a new password') ,'id' => 'password'));
	echo $this->Form->input('confirm_password', array('type' => 'password','label' => __l('Confirm Password')));
    ?>
    <div class="form-actions">
<?php
	echo $this->Form->submit(__l('Change password'), array('class' => 'btn btn-large btn-primary textb text-16')); 
?>
</div>
<?php echo $this->Form->end(); ?>