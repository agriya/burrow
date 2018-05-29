<?php /* SVN: $Id: $ */ ?>
<div class="affiliateCashWithdrawals form">
 <div class="affiliate-information">
	<div class="alert alert-info">
    	<?php echo __l('The requested amount will be deducted from your affiliate commission amount and the amount will be blocked until it get approved or rejected by the administrator. Once it\'s approved, the requested amount will be sent to your paypal account. In case of failure, the amount will be refunded to your affiliate commission amount.'); ?>
    </div>
<?php	echo $this->Form->create('AffiliateCashWithdrawal', array('class' => "form-horizontal  js-ajax-form1 {container:'js-ajax-form-container',responsecontainer:'js-responses'}"));
			echo $this->Form->input('user_id', array('type' => 'hidden')); ?>
<div class="clearfix affiliatecashwithdrawal-block pr">
 <div class="">
	
	<?php 		
		if($this->Auth->user('role_id') == ConstUserTypes::User){
			$min = Configure::read('affiliate.payment_threshold_for_threshold_limit_reach');	
			$cleared_amount = $logged_in_user['User']['commission_line_amount'];
			$transaction_fee = Configure::read('affiliate.site_commission_amount');
			$transaction_fee_type = Configure::read('affiliate.site_commission_type');
			if(!empty($transaction_fee)){
				$transactions = ($transaction_fee_type == 'amount') ? $this->Html->siteCurrencyFormat($transaction_fee) : $transaction_fee.'%';
				$transactions = '<br/>'.__l('Transaction Fee').':'. $transactions;
			}
			else{
				$transactions = '';
			}	
		}
	?>
 <?php
		if(Configure::read('site.currency_symbol_place') == 'left'):
			$currecncy_place = 'between';
		else:
			$currecncy_place = 'after';
		endif;	
	?> <?php $info =  sprintf(__l('Minimum withdraw amount: %s <br/>  Commission amount: %s  %s'),$this->Html->siteCurrencyFormat($min), $this->Html->siteCurrencyFormat($cleared_amount), $transactions);
        			echo $this->Form->input('amount',array('label' => __l('Amount'), $currecncy_place => '<span class="textb left-space">'.Configure::read('site.currency').'</span>','info' =>$info));
                	?>
          	    </div>
				
				<div class="form-actions">
						<?php echo $this->Form->submit(__l('Request Withdraw'),array('class' => 'btn btn-large btn-primary textb text-16'));?>
			    </div>
	          </div>
            <?php echo $this->Form->end();?>
   
</div>
</div>

