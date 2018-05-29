<?php /* SVN: $Id: $ */ ?>
<h2 class="space sep-bot"><?php echo __l("Add Amount to Wallet");?></h2>
<div class="payments order add-wallet  js-responses js-main-order-block js-submit-target-block">
	<?php
		if(isset($this->request->data['UserAddWalletAmount']['wallet']) && $this->request->data['UserAddWalletAmount']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && !empty($sudopay_gateway_settings) && $sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
			echo $this->element('sudopay_button', array('data' => $sudopay_data, 'cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
		} else {
	?>
			<div class="current-balance mspace">
				<span class="wallet-info textb"><?php echo __l('Your current available balance:').' '. $this->Html->siteCurrencyFormat($user_info['User']['available_wallet_amount']);?></span>
			</div>
			<?php echo $this->Form->create('Wallet', array('action' => 'add_to_wallet', 'id' => 'PaymentOrderForm', 'class' => 'js-submit-target')); ?>
			<div class="padd-center">
				<?php
					echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Auth->user('id')));
					if (!Configure::read('wallet.max_wallet_amount')):
						$max_amount = 'No limit';
					else:
						$max_amount = $this->Html->siteCurrencyFormat(Configure::read('wallet.max_wallet_amount'));
					endif;
					$currency_code = Configure::read('site.currency_id');
					Configure::write('site.currency', $GLOBALS['currencies'][$currency_code]['Currency']['symbol']);
					echo $this->Form->input('UserAddWalletAmount.amount', array('label' => __l('Amount (').configure::read('site.currency').__l(')')));
					echo $this->Form->input('type', array('type' => 'hidden'));
				?>
			</div>
			<legend><?php echo __l('Select Payment Type'); ?></legend>
			<?php echo $this->element('payment-get_gateways', array('model' => 'UserAddWalletAmount', 'type' => 'is_enable_for_add_to_wallet', 'is_enable_wallet' => 0, 'cache' => array('config' => 'sec'))); ?>
	<?php } ?>
	<?php echo $this->Form->end();?>
</div>
