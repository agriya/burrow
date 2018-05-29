<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link(__l('Diagnostics'), array('controller' => 'users', 'action' => 'diagnostics'),array('escape' => false)); ?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Debug & Error Log'); ?></li>
</ul>
<div class="users stats  space sep-top">
	<div class="clear-log clearfix ">
		<h3 class="well space textb text-16"><?php echo __l('Disk Usage'); ?></h3>
			<div class="clearfix pull-right">
				<span class="pull-right "><i class="icon-remove"></i><?php echo $this->Html->link(__l('Clear Cache'), array('controller' => 'devs', 'action' => 'clear_cache'), array('class' => 'redc  js-delete', 'title' => __l('Clear Cache'))); ?></span>
			</div>
			<dl class="dl-horizontal clearfix">
				<dt ><?php echo __l('Used Cache Memory');?></dt>
					<dd ><?php echo $tmpCacheFileSize; ?></dd>
				<dt><?php echo __l('Used Log Memory');?></dt>
					<dd><?php echo $tmpLogsFileSize; ?></dd>
			</dl>
	</div>
	<h3 class="well space textb text-16"><?php echo __l('Recent Errors & Logs'); ?></h3>
	<div class="clear-log clearfix ">
	
			<div class="clearfix ">
				<h4 class="textb"><?php echo __l('Error Log')?></h4>
				<span class="pull-right "><i class="icon-remove"></i><?php echo $this->Html->link(__l('Clear Error Log'), array('controller' => 'devs', 'action' => 'clear_logs', 'type' => 'error'), array('class' => 'js-delete redc', 'title' => __l('Clear Error Log'))); ?></span>
			</div>
			<div class="bot-mspace"><textarea rows="15" class=" span24 js-skip"><?php echo !empty($error_log) ? $error_log : '';?></textarea></div>
		
		
			<div class="clearfix">
				<h4 class="textb" ><?php echo __l('Debug Log')?></h4>
				<span class="pull-right "><i class="icon-remove"></i><?php echo $this->Html->link(__l('Clear Debug Log'), array('controller' => 'devs', 'action' => 'clear_logs', 'type' => 'debug'), array('class' => 'js-delete redc', 'title' => __l('Clear Debug Log'))); ?></span>
			</div>
			<div class="bot-mspace"><textarea rows="15" class=" span24 js-skip"><?php echo !empty($debug_log) ? $debug_log : '';?></textarea></div>
		
		
			<div class="clearfix ">
				<h4 class="textb" ><?php echo __l('Email Log')?></h4>
				<span class="pull-right "><i class="icon-remove"></i><?php echo $this->Html->link(__l('Clear Email Log'), array('controller' => 'devs', 'action' => 'clear_logs', 'type' => 'email'), array('class' => 'js-delete redc', 'title' => __l('Clear Email Log'))); ?></span>
			</div>
			<div><textarea rows="15" class=" span24 js-skip"><?php echo !empty($email_log) ? $email_log : '';?></textarea></div>
		
	</div>
</div>