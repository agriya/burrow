<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Request Flag'), array('controller'=>'request_flags','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Edit Request Flag'); ?></li>
</ul>
<div class="requestFlags requestFlags-form form sep-top">
    	<?php echo $this->Form->create('RequestFlag', array('class' => 'form-horizontal space'));?>
       <fieldset class="form-block round-5">
<?php
				echo $this->Form->input('id');
				echo $this->Form->input('request_id');
				echo $this->Form->input('request_flag_category_id');
				echo $this->Form->input('message');
?>
    	</fieldset>
	<div class="form-actions">
	<?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
	</div>
	<?php echo $this->Form->end();?>
</div>