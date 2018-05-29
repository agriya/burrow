<?php /* SVN: $Id: edit.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
<div class="userCashWithdrawals form">
<?php echo $this->Form->create('UserCashWithdrawal', array('class' => 'normal'));?>
	<fieldset>
 		<h2><?php echo __l('Edit Withdraw Fund Request');?></h2>
	<?php
		if(Configure::read('site.currency_symbol_place') == 'left'):
			$currecncy_place = 'between';
		else:
			$currecncy_place = 'after';
		endif;	
	?>		
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id',array('label' => __l('User')));
		echo $this->Form->input('withdrawal_status_id',array('label' => __l('Withdrawal Status ')));
		echo $this->Form->input('amount',array('label' => __l('Amount'),$currecncy_place => '<span class="currency">'.Configure::read('site.currency'). '</span>'));
		echo $this->Form->input('remark',array('label' => __l('Remark')));
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Update'));?>
</div>