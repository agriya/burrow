<div class="js_subscribe_invitation <?php if ($success_msg): ?>hide <?php endif; ?>">
<?php echo $this->Form->create('Subscription', array('controller' => 'subscription', 'action' => 'check_invitation', 'class' => "ver-space dl clearfix no-mar"));?>
<div>
  <div class="input text span">
  <?php
    echo $this->Form->input('invite_hash', array('label'=>__l('Enter your invitation code'), 'class' => 'span7'));
  ?>
  </div>
</div>
<div class="submit btn-align span">
  <?php echo $this->Form->submit(__l('Sign Up'), array('class' => 'btn btn-large btn-primary textb')); ?>
</div>
<?php echo $this->Form->end();
?>
</div>
<div class="js_subscribe_email <?php if (!$success_msg): ?> hide <?php endif; ?>">
<?php if ($success_msg): ?>
    <?php
      echo $this->Form->create('Subscription', array('controller' => 'subscription', 'action' => 'add', 'class' => "ver-space dl clearfix no-mar js-ajax-form"));
      if(!empty($error_message)) {
        $label = __l('You may request for new invitation code below');
      } else {
        $label = __l('Request Invite');
      }
    ?>
    <div class="span"><?php echo $this->Form->input('email', array('label' => $label,'placeholder' => __l('Enter your email'),'class'=>'span6')); ?></div>
    <div class="submit btn-align span"><?php echo $this->Form->submit(__l('Request Invite'), array('class' => 'btn btn-large btn-primary textb')); ?></div>
    <?php echo $this->Form->end(); ?>
  <?php else: ?>
    
	  <?php if($success_msg!='3') {?>
	  <?php if($success_msg!='2') {?>
		<p class="text-16 top-mspace bot-space thanks"><?php echo __l('Thanks for your interest.'); ?></p>
		<p class="text-16  ver-mspace ver-space blackc"><?php echo __l("Please confirm your email address by checking your inbox");?></p>
	<?php	} else { ?>
		<p class="text-16 top-mspace thanks"><?php echo __l('Email Verified successfully.' ); ?></p>
		<p class="text-16 top-mspace bot-space blackc"><?php echo __l("Sorry, currently we're out of invitation code. We send invitation code in periodic basis.");?></p>
    <div class="top-space"><p class="text-16 top-mspace top-space blackc"><?php echo __l("You will receive email when it's ready for you.");?></p></div>
      <p class="text-16 ver-mspace ver-space thanks"><?php echo __l('Thanks for your interest.');?></p>
	<?php }?>
	<?php }?>

  <?php endif; ?>
 </div>