<ul class="unstyled user-menu span dc">		
	<?php if ($inbox == 0): ?>
		<li class="sep-top sep-default-left <?php echo (((isset($folder_type)) and ($folder_type == 'inbox')) ? 'active' : 'inactive'); ?>">
			<?php echo $this->Html->link('<i class="icon-inbox text-24 no-pad"></i>' , array('controller' => 'messages', 'action' => 'inbox'),array('escape'=>false, 'class'=>'graydarkc show no-under js-bootstrap-tooltip', 'title' => __l('Inbox'))); ?>
		</li>
	<?php else: ?>
		<li class="sep-top sep-default-left <?php echo (((isset($folder_type)) and ($folder_type == 'inbox')) ? 'active' : 'inactive'); ?>">
			<?php echo $this->Html->link('<i class="icon-inbox text-24 no-pad"></i>', array('controller' => 'messages', 'action' => 'inbox'),array('escape'=>false, 'class'=>'graydarkc show no-under js-bootstrap-tooltip', 'title' => __l('Inbox'). ' (' . $inbox . ')')); ?>
		</li>
	<?php endif; ?>
	<li class="sep-top sep-primary-left <?php echo (((isset($folder_type)) and ($folder_type == 'sent')) ? 'active' : 'inactive'); ?>">
		<?php echo $this->Html->link('<i class="icon-signout text-24 no-pad"></i>' , array('controller' => 'messages', 'action' => 'sentmail'),array('escape'=>false, 'class'=>'graydarkc show no-under js-bootstrap-tooltip', 'title' => __l('Sent Mail'))); ?>
	</li>
	<li class="sep-top sep-secondary-left starred <?php echo (isset($folder_type) and $folder_type == 'all' and isset($is_starred) and $is_starred == 1) ? 'active' : 'inactive'; ?>">
		<?php echo $this->Html->link('<i class="icon-star text-24 no-pad"></i>', array('controller' => 'messages', 'action' => 'starred'),array('escape'=>false, 'class'=>'graydarkc show no-under js-bootstrap-tooltip', 'title' => __l('Starred') . ' (' . $stared . ')')); ?><em class="starred"></em>
	</li>
	<li class="sep-top sep-bot sep-default-left <?php echo (isset($folder_type) and $folder_type == 'all' and isset($is_starred) and $is_starred == 0) ? 'active' : 'inactive'; ?>">
		<?php echo $this->Html->link('<i class="icon-th-large text-24 no-pad"></i>' , array('controller' => 'messages', 'action' => 'all'),array('escape'=>false, 'class'=>'graydarkc show no-under js-bootstrap-tooltip', 'title' => __l('All Mail'))); ?>
	</li>
</ul>