<?php /* SVN: $Id: edit.ctp 37 2010-04-07 07:39:04Z aravindan_111act10 $ */ ?>
<div class="userComments form">
<?php echo $this->Form->create('UserComment', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo __l('Edit User Comment');?></h2>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('posted_user_id');
		echo $this->Form->input('comment');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Update'));?>
</div>
