<div class="messages index">
    <div class="mail-side-two">
		<?php echo $this->element('mail-search', array('config' => 'sec')); ?>
		<div class="mail-main-curve">
		<?php echo $this->Form->create('Message', array('class' => 'compose normal', 'enctype' => 'multipart/form-data')); ?>
			<div class="mail-main-curve-top-left"> </div>
			<div class="mail-main-curve-top-center"></div>
			<div class="mail-main-curve-top-right"></div>
			<div class="mail-main-center">
<?php
	if (!empty($all_parents)) :
    	foreach($all_parents as $parent_message) : ?>
			<div class="mail-content-curve-top-left"></div>
			<div class="mail-content-curve-top-center">
				<div class="mail-sender-name">
					<h1><?php echo $this->Html->cText($parent_message['OtherUser']['email']); ?></h1>
						<p><?php echo __l('to me');?></p>
				</div>
				<div class="mail-date-time sfont dr "></div>
				<div class="mail-reply-button"></div>
			</div>
			<div class="mail-content-curve-top-right"></div>
			<div class="mail-content-curve-middle">
					<p><span class="c"><?php echo $this->Html->cText($parent_message['MessageContent']['message']); ?></span></p>
			</div>
			<div> </div>
			<div class="clear"></div>
			<div class="mail-content-curve-bottom-left"></div>
			<div class="mail-content-curve-bottom-center"></div>
			<div class="mail-content-curve-bottom-right"></div>
<?php
    endforeach;
endif;
?>
 			<div class="mail-top-bg" style="background:#f8fbff;">
 				<div class="mail-top-bg-button mar-top" >
				 <?php echo $this->Form->submit('send-button.png', array('class' => 'js-without-subject', 'div' => 'compose-input', 'name' => 'data[Message][send]')); ?>
				 <?php echo $this->Form->submit('save-now-button.png', array('div' => 'compose-input', 'value' => 'draft', 'name' => 'data[Message][save]')); ?>
				 <?php echo $this->Html->link($this->Html->image('js-admin-action.png') , array('controller' => 'messages', 'action' => 'inbox') , array('class' => 'js-compose-delete compose-delete') , null, false); ?>
				 <?php echo $this->Html->link(__l('Cancel'), array('controller' => 'messages', 'action' => 'inbox') , array('title' => __l('Cancel'))); ?>
				 </div>
			</div>
			<div class="compose-middle-block" id="compose-middle-block" style="width:740px;float:left;">
				<fieldset>
						<div class="input text ">
							<div class="required">
	                        	<?php
									echo $this->Form->input('to', array('id' => 'message-to'));
									echo $this->Form->input('parent_message_id', array('type' => 'hidden'));
								?>
								<?php
									echo $this->Form->input('subject', array('id' => 'MessSubject', 'maxlength' => '100'));?>
				             </div>
							<div class="clear"></div>
						</div>
						<div class="atachment ">
								<?php echo $this->Form->input('Attachment.filename. ', array('type' => 'file', 'label' => '', 'class' => 'multi file attachment', 'div' => false)); ?>
	                             <div class="clear"></div>
	                	</div>
						<div class="input text ">
							<p class="attach-file-more-links"><?php //echo $this->Html->link(__l('Add more attachment'),array('#'),array('class'=>'js-attachmant event'));?></p>
								<div class="clear"></div>
						</div>
						<div class="clear"></div>
	                    <?php echo $this->Form->input('message', array('type' => 'textarea', 'label' => '')); ?>
				</fieldset>
			</div>
			<div class="clear"></div>
		</div>
		<div class="mail-curve-bottom-left"></div>
		<div class="mail-curve-bottom-center">
			<div class="mail-top-bg-button mar-top" >
				<?php echo $this->Form->submit('send-button.png', array('class' => 'js-without-subject', 'div' => 'compose-input')); ?>
				<?php echo $this->Form->submit('save-now-button.png', array('div' => 'compose-input', 'value' => 'draft', 'name' => 'data[Message][save]')); ?>
				<?php echo $this->Html->link($this->Html->image('js-admin-action.png') , array('controller' => 'messages', 'action' => 'inbox') , array('class' => 'js-compose-delete compose-delete') , null, false); ?>
			    <?php echo $this->Html->link(__l('Cancel'), array('controller' => 'messages', 'action' => 'inbox') , array('title' => __l('Cancel'))); ?>
			</div>
		</div>
		<div class="mail-curve-bottom-right"></div>
		<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>