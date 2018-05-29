<?php /* SVN: $Id: $ */ ?>
<div class="Roles form">
	<?php
		echo $this->Form->create('Role', array('url' => array('controller' => 'roles', 'action' => 'add','admin' => true)));
		echo $this->Form->input('name');
		if (!empty($parent_id)):
			echo $this->Form->input('parent_id', array('type' => 'hidden', 'value' => $parent_id));
		endif;
	?>

 <div class="form-actions">
        <?php echo $this->Form->submit(__l('Add')); ?>	
		<div class="cancel-block">
			<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'roles', 'action' => 'index'), array('title' => __l('Cancel'), 'escape' => false)); ?>
		</div>
    </div>
	<?php  echo $this->Form->end(); ?>
</div>