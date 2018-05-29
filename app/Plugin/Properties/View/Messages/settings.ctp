<?php /* SVN: $Id: settings.ctp 4216 2010-04-21 12:14:26Z siva_063at09 $ */ ?>
<div class="mail-right-block ">
   <h4><?php echo __l('Mail');?></h4>
	<div class="main-section main-message-block">
		<?php echo $this->element('message_message-left_sidebar', array('config' => 'sec')); ?>
	</div>
</div>
<div class="messages-settings message-side2">
	<h2 class="title"><?php echo __l('General Settings');?>
</h2>
<?php
    echo $this->Form->create('Message', array('action' => 'settings', 'class' => 'form-horizontal space  js-form-settings')); ?>
    <div id="message-settings">
      <?php
            echo $this->Form->input('UserProfile.message_page_size', array('label' => __l('Message Page Size')));
            echo $this->Form->input('UserProfile.message_signature', array('label' => __l('Message Signature'), 'type' => 'textarea'));
          ?>
	</div>
	<div class="form-actions">
    <?php
      echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16'));
    </div>
<?php
	echo $this->Form->end();
?>


</div>
