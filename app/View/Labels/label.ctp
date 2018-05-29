<div class="labels form">
<h2 class="degree-title" id="message-title-info"><?php echo __l('Please enter a new label name:'); ?></h2>
<?php echo $this->Form->create('Label', array('action' =>'label', 'class' => 'admin-form' ));
 echo $this->Form->input('name');
 echo $this->Form->end(__l('Add'));?>
</div> 