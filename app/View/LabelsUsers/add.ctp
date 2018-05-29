<?php /* SVN: $Id: $ */ ?>
<div class="labelsUsers form">
<?php echo $this->Form->create('LabelsUser', array('class' => 'admin-form'));?>
	<fieldset>
	<?php
		echo $this->Form->input('label_id');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>
