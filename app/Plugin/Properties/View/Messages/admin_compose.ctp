<div class="messages form">
	<div class="admin-title">
	 <h2><?php echo __l('Compose Message'); ?></h2>
   	</div>
	<?php //echo $this->element('admin-sidebar', array('config' => 'sec'));?>
<?php
	if (!empty($all_parents)) :
	    foreach($all_parents as $parent_message) :
?>

			<div class="mail-content-curve-top-left"></div>
			<div class="mail-content-curve-top-center">
				<div class="mail-sender-name">
					<h1><?php echo $this->Html->cText($parent_message['OtherUser']['email']); ?></h1>
					<p><?php echo __l('to me'); ?></p>
				</div>
				<div class="mail-date-time sfont dr "></div>
				<div class="mail-reply-button"></div>
			</div>
			<div class="mail-content-curve-top-right"></div>
			<div class="mail-content-curve-middle">
				<p>
					<span class="c"><?php echo $this->Html->cText($parent_message['MessageContent']['message']); ?></span>
				</p>
			</div>
			<div></div>
			<div class="clear"></div>
			<div class="mail-content-curve-bottom-left"></div>
			<div class="mail-content-curve-bottom-center"></div>
			<div class="mail-content-curve-bottom-right"></div>
<?php  endforeach;
	endif;
?>
<?php
echo $this->Form->create('Message', array('action' => 'compose', 'class' => 'normal', 'enctype' => 'multipart/form-data'));
?>
		<fieldset>
			<?php echo $this->Form->autocomplete('to', array('acFieldKey' => 'Friend.id', 'acFields' => array('User.first_name'), 'acSearchFieldNames' => array('User.first_name'), 'maxlength' => '100')); ?>
                <div class="or"> <?php echo __l('OR');?> </div>
                <div class = "message-select-block">
                	<?php echo $this->Form->input('to_user', array('type' => 'select', 'options' => $option, 'div' => false, 'label' => '', 'class' => 'js-select-option'));
						  echo $this->Form->input('subject', array('id' => 'MessSubject', 'maxlength' => '100'));
?>
                </div>
                <?php echo $this->Form->input('message', array('type' => 'textarea', 'label' => '')); ?>
		</fieldset>

<?php echo $this->Form->end(__l('Add')); ?>
</div>

