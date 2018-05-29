<?php /* SVN: $Id: index.ctp 1721 2010-04-17 11:06:44Z preethi_083at09 $ */ ?>
<div class="userCashWithdrawals index js-response js-withdrawal_responses js-responses">
    <div class="ver-space ver-mspace sep-bot clearfix"><h2  class="text-32 span"><?php echo __l('Affiliate Fund Withdrawal Request');?></h2>
	<?php echo $this->element('sidebar', array('config' => 'sec')); ?></div>
<?php echo $this->element('withdrawals-add'); ?>
<?php if (!empty($userCashWithdrawals)):
	echo $this->element('paging_counter');
endif;?>
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
		<th class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.created',__l('Requested On'));?></div></th>
        <th class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort( 'AffiliateCashWithdrawal.amount',__l('Amount').' ('.Configure::read('site.currency').')');?></div></th>
<th><div class="js-pagination"><?php echo $this->Paginator->sort('AffiliateCashWithdrawalStatus.name',__l('Status'));?></div></th>
    </tr></thead><tbody>
<?php
if (!empty($userCashWithdrawals)):
$i = 0;
foreach ($userCashWithdrawals as $userCashWithdrawal):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="dc"><?php echo $this->Html->cDateTime($userCashWithdrawal['AffiliateCashWithdrawal']['created']);?></td>
    	<td class="dr"><?php echo $this->Html->siteCurrencyFormat($userCashWithdrawal['AffiliateCashWithdrawal']['amount']);?></td>
		<td>
		<?php 
			if($userCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Pending):
				echo __l('Pending');
			elseif($userCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Approved):
				echo __l('Under Process');
			elseif($userCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Rejected):
				echo __l('Rejected');
			elseif($userCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Failed):
				echo __l('Failed');
			elseif($userCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Success):
				echo __l('Success');
				if(!empty($userCashWithdrawal['AffiliateCashWithdrawal']['commission_amount'])):
				echo "<p>".($this->Html->siteCurrencyFormat($userCashWithdrawal['AffiliateCashWithdrawal']['amount'] - $userCashWithdrawal['AffiliateCashWithdrawal']['commission_amount'])).' = ['.$this->Html->siteCurrencyFormat($userCashWithdrawal['AffiliateCashWithdrawal']['amount']).' - '.$this->Html->siteCurrencyFormat($userCashWithdrawal['AffiliateCashWithdrawal']['commission_amount']).']'."</p>";				
				endif;
			else:
				echo $this->Html->cText($userCashWithdrawal['AffiliateCashWithdrawalStatus']['name']);
			endif;
		?>
		</td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="8">
			<div class="space dc grayc">
				<p class="ver-mspace top-space text-16 "><?php echo __l('No Withdraw requests available');?></p>
			</div>
		</td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($userCashWithdrawals)) { ?>
	<div class="<?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?>"> <?php echo $this->element('paging_links'); ?> </div> 
<?php } ?>
</div>
