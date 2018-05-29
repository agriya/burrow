<section class="no-pad top-mspace">
<div class="no-mar no-bor clearfix well no-mar space">
  <h5 class="pull-left textb graydarkc text-14 "><i class="icon-warning-sign hor-smspace text-16"></i><span><?php echo __l('Actions to Be Taken'); ?></span></h5>
</div>
<section class="space left-mspace">
  <p class="textb graydarkc text-12 top-mspace"><?php echo __l('Properties');?></p>
  <ul class="unstyled no-mar ver-space">
		<li><i class="icon-angle-right "></i><?php echo $this->Html->link(__l('Waiting For Approval') . ' (' . $pending_for_approval_count. ')', array('controller'=> 'properties', 'action' => 'index', 'filter_id' =>ConstMoreAction::Disapproved, 'admin' => true), array('class' => 'grayc'));?></li>
		<li><i class="icon-angle-right "></i><?php echo $this->Html->link(__l('Waiting for verification') . ' (' . $pending_for_verification_count. ')', array('controller'=> 'properties', 'action' => 'index', 'filter_id' => ConstMoreAction::WaitingForVerification, 'admin' => true), array('class' => 'grayc'));?></li>
  </ul>
	<?php if(isPluginEnabled('Requests')):?>
	<p class="textb graydarkc top-mspace text-12"><?php echo __l('Requests');?></p>
	<ul class="unstyled no-mar ver-space">
	<li><i class="icon-angle-right "></i><?php echo $this->Html->link(__l('Waiting For Approval') . ' (' . $request_pending_for_approval_count. ')', array('controller'=> 'requests', 'action' => 'index', 'filter_id' =>ConstMoreAction::Inactive, 'admin' => true), array('class' => 'grayc'));?></li>
	</ul>
	<?php endif;?>

<?php if(isPluginEnabled('Withdrawals')) :?>
<p class="textb graydarkc text-12 top-mspace"><?php echo __l('Withdrawal Requests');?></p>
<ul class="unstyled no-mar ver-space">
<li><i class="icon-angle-right "></i><?php echo $this->Html->link(__l('Users') . ' (' . $pending_withdraw_count. ')', array('controller'=> 'user_cash_withdrawals', 'action' => 'index', 'filter_id' =>ConstWithdrawalStatus::Pending, 'admin' => true), array('class' => 'grayc'));?></li>
<?php if(isPluginEnabled('Affiliates')) :?>
	<li><i class="icon-angle-right "></i><?php echo $this->Html->link(__l('Affiliates') . ' (' . $afffiliate_pending_withdraw_count. ')', array('controller'=> 'affiliate_cash_withdrawals', 'action' => 'index', 'filter_id' => ConstAffiliateCashWithdrawalStatus::Pending, 'admin' => true), array('class' => 'grayc'));?></li>
<?php endif;?>
</ul>
<?php endif;?>			  
<p class="textb graydarkc text-12 top-mspace"><?php echo __l('Disputes');?></p>
<ul class="unstyled no-mar ver-space">
<li><i class="icon-angle-right "></i><?php echo $this->Html->link(__l('Waiting for Administrator Decision') . ' (' . $propery_displute_count. ')', array('controller'=> 'property_user_disputes', 'action' => 'index', 'filter_id' => ConstDisputeStatus::Open, 'admin' => true), array('class' => 'grayc'));?></li>
</ul>
<?php if(isPluginEnabled('PropertyFlags')) :?>
<p class="textb graydarkc text-12 top-mspace"><?php echo __l('Flagged Properties');?></p>
<ul class="unstyled no-mar ver-space">
<li><i class="icon-angle-right "></i><?php echo $this->Html->link(__l('User') . ' (' . $property_user_flagged_count. ')', array('controller'=> 'properties', 'action' => 'index', 'type' =>'user-flag','admin' => true), array('class' => 'grayc'));?></li>
<li><i class="icon-angle-right "></i><?php echo $this->Html->link(__l('System') . ' (' . $property_system_flagged_count. ')', array('controller'=> 'properties', 'action' => 'index', 'filter_id' =>ConstMoreAction::Flagged, 'admin' => true), array('class' => 'grayc'));?></li>
</ul>
<?php endif;?>
<?php if(isPluginEnabled('RequestFlags')): ?>
<p class="textb graydarkc text-12 top-mspace"><?php echo __l('Flagged Requests');?></p>
<ul class="unstyled no-mar ver-space">
<li><i class="icon-angle-right "></i><?php echo $this->Html->link(__l('User') . ' (' . $request_user_flagged_count. ')', array('controller'=> 'requests', 'action' => 'index', 'type' =>'user-flag',  'admin' => true), array('class' => 'grayc'));?></li>
<li><i class="icon-angle-right "></i><?php echo $this->Html->link(__l('System') . ' (' . $request_system_flagged_count. ')', array('controller'=> 'requests', 'action' => 'index', 'filter_id' =>ConstMoreAction::Flagged, 'admin' => true), array('class' => 'grayc'));?></li>
</ul>
<?php endif;?>			  
</section>
          </section>
