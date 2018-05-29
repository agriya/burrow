<?php /* SVN: $Id: $ */ ?>
<div class="aclLinks form">
	<?php
		echo $this->Form->create('AclLink');
		echo $this->Form->input('name');
		echo $this->Form->input('controller');
		echo $this->Form->input('action');
		echo $this->Form->input('named_key');
		echo $this->Form->input('named_value');
		echo $this->Form->input('pass_value');?>
 <div class="form-actions">
	<?php echo $this->Form->submit(__l('Add')); ?>

</div>
    	<?php
    		echo $this->Form->end();
    	?>
</div>