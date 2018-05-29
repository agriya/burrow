<div class="js-response">
	<ul class="breadcrumb top-mspace ver-space">
		<li><?php echo $this->Html->link('Dashboard', array('controller' => 'users', 'action' => 'stats'), array('escape' => false));?> <span class="divider">/</span></li>
		<li class="active"><?php echo __l('Diagnostics'); ?></li>
	</ul>
	<div class="space sep-top">
		<div class="alert alert-info"><?php echo __l('Diagnostics are for developer purpose only.'); ?></div>
		<div class="row-fluid">
			<div class="well span12">
				<h3><?php echo $this->Html->link(__l('ZazPay Transaction Log'), array('controller' => 'sudopay_transaction_logs', 'action' => 'index'),array('title' => __l('ZazPay Transaction Log'))); ?></h3>
				<?php echo __l('View the transaction logs done via ZazPay'); ?>
			</div>
			<div class="well span12">
				<h3><?php echo $this->Html->link(__l('ZazPay IPN Log'), array('controller' => 'sudopay_ipn_logs', 'action' => 'index'),array('title' => __l('ZazPay IPN Log'))); ?></h3>
				<?php echo __l('View the ipn logs done via ZazPay'); ?>
			</div>
		</div>
		<div class="row-fluid">
			<div class="well span12">
				<h3><?php echo $this->Html->link(__l('Debug & Error Log'), array('controller' => 'devs', 'action' => 'logs'),array('title' => __l('Debug & Error Log'))); ?></h3>
				<div><?php echo __l('View debug, error log, used cache memory and used log memory'); ?></div>
			</div>
		</div>
	</div>
</div>