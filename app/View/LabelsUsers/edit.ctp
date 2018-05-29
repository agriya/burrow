<?php /* SVN: $Id: $ */ ?>
	<div id="breadcrumb">
			<?php echo $this->Html->addCrumb(__l('Labels')); ?>
			<?php echo $this->Html->getCrumbs(' &raquo; ', __l('Home')); ?>
	 </div>
<div class="messages index">
<h2 class="title">
<?php echo __l('Edit Label');?>
</h2>
<?php echo $this->element('message_message-left_sidebar', array('config' => 'sec'));?>
	<div class="labelsUsers form">
	<?php echo $this->Form->create('LabelsUser', array('action'=>'edit','class' => 'js-form normal'));?>
		<?php
			echo $this->Form->input('id',array('type'=>'hidden'));
			echo $this->Form->input('label');
		?>

	<?php echo $this->Form->end(__l('Update'));?>
	</div>
</div>