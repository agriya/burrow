<?php $this->pageTitle = __l('Tools'); ?>
 <ul class="breadcrumb top-mspace ver-space">
		<li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
		<li class="active"><?php echo __l('Tools'); ?></li>
	</ul>
<div class="pull-left sep-top space" id="js-confirm-message-block ">
	<div class="alert alert-info "><?php echo __l('When cron is not working, you may trigger it by clicking below link. For the processes that happen during a cron run, refer the ').$this->Html->link('product manual','http://dev1products.dev.agriya.com/doku.php?id=burrow-install#manual_cron_update_process', array('target'=>'_blank'));?></div>
	<div class="space"><?php echo $this->Html->link(__l('Manually trigger cron to update property and booking status'), array('controller' => 'crons', 'action' => 'main', 'admin' => false, '?r=' . $this->request->url), array('class' => 'js-confirm-mess trigger1 btn', 'title' => __l('You can use this to update property and booking status. This will be used in the scenario where cron is not working.'))); ?></div>
	<div class="space"><?php echo $this->Html->link(__l('Manually trigger cron to update currency conversion rate'), array('controller' => 'crons', 'action' => 'daily','admin'=>false, '?r=' . $this->request->url), array('class' => 'js-confirm-mess trigger1 btn', 'title' => __l('You can use this to update currency conversion rate. This will be used in the scenario where cron is not working')));?></div>
</div>