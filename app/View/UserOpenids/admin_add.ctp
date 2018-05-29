<?php /* SVN: $Id: $ */ ?>
<div class="userOpenids form sep-top">
<?php echo $this->Form->create('UserOpenid', array('class' => 'form-horizontal space'));?>
	<fieldset>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('openid');
		echo $this->Form->input('verify',array('type' => 'checkbox'));
	?>
	</fieldset>
<div class="form-actions">
	<?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-large btn-primary textb text-16')); ?>
</div>
<?php echo $this->Form->end(); ?>
</div>
