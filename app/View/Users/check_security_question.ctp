<div class="clearfix">
    <h2 class="ver-space sep-bot top-mspace text-32"><?php echo __l('Security Question'); ?></h2>
  <?php
  echo $this->Form->create('User', array('action' => 'reset/'.$user_id.'/'.$hash ,'class' => 'form-horizontal space')); ?>
    <?php
  echo $this->Form->input('user_id', array('type' => 'hidden'));
  echo $this->Form->input('hash', array('type' => 'hidden'));
  if(isPluginEnabled('SecurityQuestions')) {
  echo $this->Form->input('security_answer', array('label' => $security_questions['SecurityQuestion']['name'], 'id' => 'security_answer', 'autocomplete' => 'off'));
  }
  ?>
	<div class="form-actions">
	<?php echo $this->Form->submit(__l('Submit'), array('class' => 'btn btn-large btn-primary textb text-16')); ?> 
	</div>
   <?php echo $this->Form->end(); ?> 
</div>
