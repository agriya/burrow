<span class="amenu-left">
	<span class="amenu-right">
		<span class="menu-center admin-affiliates"><?php echo __l('Partners');?></span>
	</span>
</span>
<div class="admin-sub-block">
	<div class="admin-top-lblock">
		<div class="admin-top-rblock">
			<div class="admin-top-cblock"></div>
		</div>
	</div>
	<div class="admin-sub-lblock">
		<div class="admin-sub-rblock">
			<div class="admin-sub-cblock clearfix">
  			  <h4><?php echo __l('Affiliates');?></h4>
				<ul class="admin-sub-links">
					<?php $class = ($this->request->params['controller'] == 'affiliates') ? ' class="active"' : null; ?>
					<li <?php echo $class;?>><?php echo $this->Html->link(__l('Affiliates'), array('controller' => 'affiliates', 'action' => 'index'),array('title' => __l('Affiliates'))); ?></li>
					<?php $class = ($this->request->params['controller'] == 'affiliate_requests') ? ' class="active"' : null; ?>
					<li <?php echo $class;?>><?php echo $this->Html->link(__l('Requests'), array('controller' => 'affiliate_requests', 'action' => 'index'), array('title' => __l('Affiliate Requests'))); ?></li>
					<li class="setting-overview payment-overview"><?php echo $this->Html->link(__l('Common Settings'), array('controller' => 'settings', 'action' => 'edit', 14), array('title' => __l('Common Settings'), 'class' => 'affiliate-settings')); ?></li>
					<?php $class = ($this->request->params['controller'] == 'affiliate_types') ? ' class="active"' : null; ?>
					<li <?php echo $class;?>><?php echo $this->Html->link(__l('Commission Settings'), array('controller' => 'affiliate_types', 'action' => 'edit'),array('title' => __l('Commission Settings'))); ?></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="admin-bot-lblock">
		<div class="admin-bot-rblock">
			<div class="admin-bot-cblock"></div>
		</div>
	</div>
</div>