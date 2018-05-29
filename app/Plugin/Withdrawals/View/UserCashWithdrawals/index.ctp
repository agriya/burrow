<?php /* SVN: $Id: index.ctp 70160 2011-11-03 11:54:15Z aravindan_111act10 $ */ ?>
<div class="userCashWithdrawals index js-response js-withdrawal_responses js-responses">
<div class="ver-space bot-mspace sep-bot clearfix">
<h2  class="span text-32"><?php echo __l('Withdraw Fund Request');?></h2>
<?php echo $this->element('sidebar', array('config' => 'sec'));	?>
</div>
<div>
	<?php if(!empty($moneyTransferAccounts)) : ?>
		<?php echo $this->element('withdrawals-add'); ?>
	<?php else:?>
		<div class="alert alert-info">
		<?php echo $this->Html->link(__l('Your money transfer account is empty, so click here to update money transfer account.'), array('controller' => 'money_transfer_accounts', 'action'=>'index'), array('title' => __l('money transfer accounts'))); ?>
		</div>
	<?php endif; ?>
<?php if (!empty($userCashWithdrawals)):
	echo $this->element('paging_counter');
endif;?>
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
		<th class="dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'UserCashWithdrawal.created',__l('Requested On'));?></div></th>
        <th class="dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'UserCashWithdrawal.amount',__l('Amount').' ('.Configure::read('site.currency').')');?></div></th>
        <th class="dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('WithdrawalStatus.name',__l('Status'));?></div></th>
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
		<td class="dc"><?php echo $this->Html->cDateTime($userCashWithdrawal['UserCashWithdrawal']['created']);?></td>
    	<td class="dr"><?php echo $this->Html->cCurrency($userCashWithdrawal['UserCashWithdrawal']['amount']);?></td>
		<td class="dc"><?php echo $this->Html->cText($userCashWithdrawal['WithdrawalStatus']['name']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="8">
			<div class="space dc grayc">
				<p class="ver-mspace top-space text-16 "><?php echo __l('No Withdraw fund requests available');?></p>
			</div>
		</td>
	</tr>
<?php
endif;
?>
</table>
</div>
</div>
<?php if (!empty($userCashWithdrawals)):?>
	<div class="<?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?> pull-right">
		<?php
			echo $this->element('paging_links');
		?>
	</div>
<?php endif;?>
</div>
</div>