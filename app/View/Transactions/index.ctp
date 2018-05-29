<?php /* SVN: $Id: index.ctp 32471 2010-11-08 11:23:30Z aravindan_111act10 $ */ ?>
<?php if(empty($this->request->params['named']['stat']) && !isset($this->request->data['Transaction']['tab_check']) && !$isAjax): ?>
	<div class="ver-space top-mspace sep-bot clearfix"><h2 class="text-32  span"><?php echo __l('My Transactions'); ?></h2>
	<?php echo $this->element('sidebar', array('config' => 'sec')); ?></div>
	<?php if(isPluginEnabled('Wallet')){ ?>
		<div class="summary-block clearfix">
			<h3 class="well space textb text-16 ver-mspace"><?php echo __l('Account Summary'); ?></h3>
			<dl class="clearfix">
				<dt class="hor-space span textn no-mar hor-space"><?php echo __l('Account Balance');?></dt>
					<dd class="span graydarkc textb"><?php echo $this->Html->siteCurrencyFormat($user_available_balance);?></dd>
			</dl>
			<?php if(isPluginEnabled('Withdrawals')){ ?>
				<dl class="clearfix">
					<dt class="hor-space span textn no-mar hor-space"><?php echo __l('Withdraw Request');?></dt>
						<dd class="span graydarkc textb"><?php echo $this->Html->siteCurrencyFormat($blocked_amount);?></dd>
				</dl>
			<?php } ?>
		</div>
	<?php } ?>
	<?php echo $this->Form->create('Transaction', array('action' => 'index' ,'class' => 'normal pr js-ajax-form form-horizontal {"container":"js-responses","transaction":"true"}')); ?>
	<div class="transaction-category clearfix">
	<div class="no-mar span24 span20-sm">
		<div class="input radio radio-active-style no-mar">
			<?php echo $this->Form->input('filter', array('default'=>__l('all'),'type' => 'radio','options'=>$filter, 'div' => false, 'legend'=>false,'class' =>'js-transaction-filter ')); ?>
		</div>
	</div>
		<div class="js-filter-window hide clearfix">
			<div class="clearfix transection-date-time-block date-time-block">
				<div class="input date-time clearfix">
					<div class="js-datetime">
					  <div class="js-cake-date">
						<?php echo $this->Form->input('from_date', array('label' => __l('From'), 'type' => 'date', 'orderYear' => 'asc', 'minYear' => date('Y')-10, 'maxYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
					  </div>
					</div>
				</div>
				<div class="input date-time end-date-time-block clearfix">
					<div class="js-datetime">
					  <div class="js-cake-date">
						<?php echo $this->Form->input('to_date', array('label' => __l('To '),  'type' => 'date', 'orderYear' => 'asc', 'minYear' => date('Y')-10, 'maxYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
					  </div>
					</div>
				</div>
			</div>
			<?php
				echo $this->Form->input('tab_check', array('type' => 'hidden','value' => 'tab_check'));
				echo $this->Form->submit(__l('Filter') , array('class' => 'btn btn-large hor-mspace btn-primary textb text-16'));
			?>
		</div>
	</div>
	
	<?php echo $this->Form->end(); ?>
	
	<?php if (!empty($transactions)):
		echo $this->element('paging_counter');
	endif;?>
	<div class="transactions index js-response js-responses">
<?php endif; ?>
		<div class="ver-space">
         <div id="active-users" class="tab-pane active in no-mar">
		<table class="table no-round table-striped">
			<thead>
			<tr class=" well no-mar no-pad">
				<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'created',__l('Date'));?></div></th>
				<th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('transaction_type_id',__l('Description'));?></div></th>
				<th class="dr sep-right"><div class="js-pagination credit"><span class="round-3"><?php echo $this->Paginator->sort( 'amount',__l('Credit')).' ('.Configure::read('site.currency').')';?></span></div></th>
				<th class="dr sep-right"><div class="js-pagination debit dc"><span class="round-3"><?php echo $this->Paginator->sort( 'amount',__l('Debit')).' ('.Configure::read('site.currency').')';?></span></div></th>
			</tr></thead><tbody>
			<?php
				if (!empty($transactions)):
					$i = 0;
					$j = 1;
					$total_credit=0;
					$total_debit=0;
					foreach ($transactions as $transaction):
						if(!empty($transaction['TransactionType']['id'])) {
						$to= $this->Html->cDate($duration_to);
						$from=$this->Html->cDate($duration_from);
						?>
					<?php 
						$paypal_text = '';
					?>
						<tr>
							<td class="dc span3"><?php echo $this->Html->cDateTimeHighlight($transaction['Transaction']['created']);?></td>
							<td class="dl">
								<?php if(in_array($transaction['Transaction']['transaction_type_id'], array(ConstTransactionTypes::AdminAddFundToWallet, ConstTransactionTypes::AdminDeductFundFromWallet, ConstTransactionTypes::CashWithdrawalRequestApproved)) && !empty($transaction['Transaction']['description'])) {
										echo $this->Html->cText($transaction['Transaction']['description']);
									} else {
										echo $this->Html->transactionDescription($transaction);
									} ?>
							</td>
							<td class="dr">
								<?php
								  if ($transaction['TransactionType']['id'] == ConstTransactionTypes::SecurityDepositSentToHost && $transaction['Transaction']['receiver_user_id'] == $this->Auth->user('id') && empty($transaction['TransactionType']['is_credit_to_receiver'])) {
									echo '--';
								  } elseif ($transaction['TransactionType']['is_credit'] || ($transaction['Transaction']['receiver_user_id'] == $this->Auth->user('id') && $transaction['TransactionType']['is_credit_to_receiver'])) {
									if($transaction['TransactionType']['id'] == ConstTransactionTypes::BookProperty) {
										echo $this->Html->cCurrency($transaction['Transaction']['amount'] - $transaction['PropertyUser']['traveler_service_amount']);
									}else {
										echo $this->Html->cCurrency($transaction['Transaction']['amount']);
									}
								  } else {
									  echo '--';
								  }
								?>
							</td>
							<td class="dr">
								<?php
								  if ($transaction['TransactionType']['id'] == ConstTransactionTypes::SecurityDepositSentToHost && $transaction['Transaction']['receiver_user_id'] == $this->Auth->user('id') && empty($transaction['TransactionType']['is_credit_to_receiver'])) {
									echo $this->Html->cCurrency($transaction['Transaction']['amount']);
								  } elseif ($transaction['TransactionType']['is_credit'] || ($transaction['Transaction']['receiver_user_id'] == $this->Auth->user('id') && $transaction['TransactionType']['is_credit_to_receiver'])) {
									echo '--';
								  } else {
									if ($transaction['TransactionType']['id'] == ConstTransactionTypes::RefundForRejectedBooking) {
										echo $this->Html->cCurrency($transaction['Transaction']['amount'] - $transaction['PropertyUser']['traveler_service_amount']);
									}else {
										echo $this->Html->cCurrency($transaction['Transaction']['amount']);
									}
								  }
								?>
							</td>
						</tr>
						<?php
					$j++;
					}
				endforeach;
			?>
			<tr class="total-block tb">
				<td class="total dc" colspan="2"><span><?php echo __l('Total ');?></span><span class="duration sfont"><?php echo $from . ' ' . __l('to') . ' ' . $to; ?></span></td>
				<td class="dr credit-total"><?php echo $this->Html->cCurrency($total_credit_amount);?></td>
				<td class="dr debit-total"><?php echo $this->Html->cCurrency($total_debit_amount);?></td>
			</tr>
			<?php
				else:
			?>
			<tr class="">
				<td colspan="11">
					<div class="space dc grayc">
						<p class="ver-mspace top-space text-16 "><?php echo __l('No Transactions available');?></p>
					</div>
				</td>
			</tr>
			<?php
				endif;
			?>
		</table>
		</div>
		</div>
		<?php if (!empty($transactions)) { ?>
			<div class="<?php if(!empty($this->request->params['isAjax'])) { ?> js-pagination <?php } ?> pull-right">
				<?php echo $this->element('paging_links'); ?>
			</div>
		<?php } ?>
<?php if(empty($this->request->params['named']['stat']) && !isset($this->request->data['Transaction']['tab_check']) && !$isAjax): ?>
	</div>
<?php endif; ?>