<?php /* SVN: $Id: add.ctp 71289 2011-11-14 12:28:02Z anandam_023ac09 $ */ ?>
<div class="userCashWithdrawals form js-ajax-form-container js-responses">
	<div class="alert alert-info">
    	<?php echo __l('The requested amount will be deducted from your wallet and the amount will be blocked until it get approved or rejected by the administrator. In case of failure, the amount will be refunded to your wallet.'); ?>
    </div>
    <?php echo $this->Form->create('UserCashWithdrawal', array('action' => 'add','class' => "form-horizontal js-ajax-form {container:'js-ajax-form-container',responsecontainer:'js-responses'}"));?>
    <div class="clearfix affiliatecashwithdrawal-block pr">
    <div class="">
	<?php
		if(Configure::read('site.currency_symbol_place') == 'left'):
			$currecncy_place = 'between';
		else:
			$currecncy_place = 'after';
		endif;	
	?>	
	<?php
			$min = Configure::read('user.minimum_withdraw_amount');
			$max = Configure::read('user.maximum_withdraw_amount');
			if(empty($this->request->data['UserCashWithdrawal']['role_id'])) { ?>
			<?php $info= __l('Minimum withdraw amount: '). $this->Html->siteCurrencyFormat($min).'<br/>' . __l(' Maximum withdraw amount: '). $this->Html->siteCurrencyFormat($max);?>
		<?php } else {?>
	          <?php  $info='';
             }?>
        	<?php echo $this->Form->input('amount',array('label' => __l('Amount'),$currecncy_place => '<span class="textb left-space">'.Configure::read('site.currency').'</span>', 'info' =>$info));?>
 	 		<?php echo $this->Form->input('user_id',array('type' => 'hidden'));
		echo $this->Form->input('role_id',array('type' => 'hidden','value'=>$this->Auth->user('role_id')));
	?>
    </div>
        <div class="form-actions">
        <?php
        	echo $this->Form->submit(__l('Request Withdraw'),array('class' => 'btn btn-large btn-primary textb text-16'));
        ?>
        </div>
        </div>
        <?php
        	echo $this->Form->end();
        ?>
</div>