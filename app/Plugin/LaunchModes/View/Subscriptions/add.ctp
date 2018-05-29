<?php if (Configure::read('site.launch_mode') == 'Private Beta') { ?>
  <?php if (!$success_msg): ?>
    <?php
      echo $this->Form->create('Subscription', array('class' => " form-horizontal ver-space dl clearfix no-mar js-ajax-form"));
      if(!empty($error_message)) {
        $label = __l('You may request for new invitation code below');
      } else {
        $label = __l('Request Invite');
      }
    ?>
    <div class="span"><?php echo $this->Form->input('email', array('label' => $label,'placeholder' => __l('Enter your email'),'class'=>'span7')); ?></div>
    <div class="submit btn-align span"><?php echo $this->Form->submit(__l('Request Invite'),array('class' => 'btn btn-large btn-primary textb text-16')); ?></div>
    <?php echo $this->Form->end(); ?>
  <?php else: ?>
    <p class="text-16 top-mspace bot-space blackc"><?php echo __l("Sorry, currently we're out of invitation code. We send invitation code in periodic basis.");?></p>
    <div class="top-space"><p class="text-16 top-mspace top-space blackc"><?php echo __l("You will receive email when it's ready for you.");?></p></div>
      <p class="text-16 ver-mspace ver-space thanks"><?php echo __l('Thanks for your interest.');?></p>
  <?php endif; ?>
<?php } else { ?>
  <?php if (!$success_msg): ?>
    <div class="clearfix">
      <?php echo $this->Form->create('Subscription', array('class' => 'ver-space dl clearfix no-mar js-ajax-form')); ?>
      <?php if(!empty($error_message)): ?>     
      <?php endif; ?>
      <div class="input text span"><?php echo $this->Form->input('email', array('label' => __l('Want to be the first to know when site is ready?'), 'placeholder' => __l('Enter your email'),'class'=>'span7')); ?></div>
      <div class="submit  btn-align span"><?php echo $this->Form->submit(__l('Notify Me'),array('class' => 'btn btn-large btn-primary textb')); ?></div>
      <?php echo $this->Form->end(); ?>
    </div>
    <div class="grayc dl bot-space hor-mspace"><?php echo __l('By submitting this email, I am authorizing site to send me emails until I unsubscribe.'); ?>
    <?php echo $this->Html->link(__l('Privacy Policy'), array('controller' => 'pages', 'action' => 'view', 'privacy_policy', 'admin' => false), array('title' => __l('Privacy Policy'), 'class'=>'js-no-pjax', 'data-toggle' => 'modal', 'data-target' => '#js-ajax-modal'));?>
    </div>
				<div id="js-ajax-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-header hide"></div>
					<div class="modal-body js-social-link-div clearfix dl">
						<div class="dc">
						<?php echo $this->Html->image('ajax-circle-loader.gif', array('alt' => __l('[Image:Loader]') ,'width' => 100, 'height' => 100, 'class' => 'js-loader')); ?></div>
					</div>
					<div class="modal-footer"> <a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a> </div>
				</div>
  <?php else: 
	if($success_msg!='2') {?>
		<p class="text-16 top-mspace bot-space thanks"><?php echo __l('Thanks for your interest.'); ?></p>
		<p class="text-16  ver-mspace ver-space blackc"><?php echo __l("You will receive email when it's ready for you.");?></p>
	<?php	} else { ?>
		<p class="text-16 top-mspace thanks"><?php echo __l('Email Verified successfully.' ); ?></p>
		<p class="text-16  ver-mspace ver-space blackc"><?php echo __l("Thanks for your interest. Our team will contact you soon.");?></p>
	<?php }?>
  <?php endif; ?>
<?php } ?>
