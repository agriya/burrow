<?php if (isPluginEnabled('Wallet')) { ?>
<ul class="unstyled">
  <li><b><?php echo __l('User Withdraw Requests');?></b></li>
  <li><i class="icon-caret-right grayc"></i><?php echo $this->Html->link(__l('Pending') . ' (' . $pending_withdraw_count. ')', array('controller'=> 'user_cash_withdrawals', 'action' => 'index', 'filter_id' =>ConstWithdrawalStatus::Pending), array('class' => 'grayc'));?></li>
</ul>
<?php } ?>