<?php /* SVN: $Id: $ */ ?>
<div class="Roles index">
	<div>
		<?php echo $this->Html->link(__l('Add Role'), array('controller'=>'roles','action'=>'add'), array('title' => __l('Add Role'))); ?>
	</div>
	<?php if (!empty($Roles)): ?>
		<?php
			echo $this->Tree->generate($Roles, array('model' => 'Role', 'id' => 'treemenu', 'subclass' => 'treesub', 'typeclass' => 'open', 'nosubclass' => 'nosubmenu', 'show_add_role' => true, 'show_edit_role' => true, 'show_delete_role' => true, 'show_move_role' => false));
		?>
	<?php else: ?>
		<div class="space dc">
			<p class="ver-mspace grayc top-space text-16 "><?php echo sprintf(__l('No %s available'), __l('Roles')); ?></p>
		</div>
	<?php endif; ?>
</div>