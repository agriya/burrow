<div class="pull-right dropdown"> <a href="#" title="Edit" class="dropdown-toggle btn btn-large text-14 textb js-no-pjax graylighterc no-shad" data-toggle="dropdown"><i class="icon-cog graydarkc no-pad text-16"></i> <span class="caret"></span></a>
	<ul class="dropdown-menu arrow arrow-right">
		<?php $class = ($this->request->params['controller'] == 'user_notifications' && $this->request->params['action'] == 'edit') ? ' class="active"' : null; ?>
		<li <?php echo $class;?>><?php echo $this->Html->link('<i class="icon-cog"></i>'.__l('Email settings'), array('controller' => 'user_notifications', 'action' => 'edit'), array('escape'=>false,'title' => __l('Email settings')));?></li>
		<?php if (!$this->Auth->user('is_openid_register') && !$this->Auth->user('facebook_user_id') && !$this->Auth->user('twitter_user_id') && !$this->Auth->user('is_gmail_register') && !$this->Auth->user('is_yahoo_register')): ?>
			<?php $class = ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'change_password') ? ' class="active"' : null; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link('<i class="icon-key"></i>'.__l('Change Password'), array('controller' => 'users', 'action' => 'change_password'), array('escape'=>false,'title' => __l('Change password')));?></li>
		<?php endif;?>
		<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Transactions'), array('controller' => 'transactions', 'action' => 'index'), array('title' => __l('My Transactions'), 'escape' => false));?></li>
		<?php 
			$paymentGateway = $this->Html->getPaymentGatewayIsactive('Wallet');
			if (!empty($paymentGateway) && isPluginEnabled('Wallet') && isPluginEnabled('Withdrawals')):
				$class = ($this->request->params['controller'] == 'user_cash_withdrawals' && $this->request->params['action'] == 'index') ? ' class="active"' : null; 
		?>
		<li <?php echo $class;?>><?php echo $this->Html->link('<i class="icon-money"></i>'.__l('Withdraw Fund Request'), array('controller' => 'user_cash_withdrawals', 'action' => 'index'), array('escape'=>false,'title' => __l('Withdraw Fund Request')));?></li>
		<?php $class = ($this->request->params['controller'] == 'money_transfer_accounts' && $this->request->params['action'] == 'index') ? ' class="active"' : null; ?>
		<li <?php echo $class;?>><?php echo $this->Html->link('<i class="icon-money"></i>'.__l('Money Transfer Accounts'), array('controller' => 'money_transfer_accounts', 'action' => 'index'), array('escape'=>false,'title' => __l('Money Transfer Accounts')));?></li>
		<?php endif;?>
		<?php if(isPluginEnabled('SocialMarketing')):?>
		<li><?php  echo $this->Html->link('<i class="icon-share"></i>'.__l('Social'), array('controller' => 'social_marketings', 'action' => 'myconnections'), array('title' => __l('Social'), 'escape'=>false));?></li>
		<?php endif;?>
		<?php if(isPluginEnabled('Affiliates')):?>
			<li><?php echo $this->Html->link('<i class="icon-group"></i>'.__l('Affiliates'), array('controller' => 'affiliates', 'action' => 'index'), array('title' => __l('Affiliates'), 'escape'=>false));?></li>
		<?php if($this->Auth->user('is_affiliate_user')):?>
			<li><?php echo $this->Html->link('<i class="icon-money"></i>'.__l('Affiliate Cash Withdrawals'), array('controller' => 'affiliate_cash_withdrawals', 'action' => 'index'), array('title' => __l('Affiliate Cash Withdrawals'), 'escape'=>false));?></li>
		<?php endif;?>		
	<?php endif;?>						
	</ul>
</div>