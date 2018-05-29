<?php /* SVN: $Id: pay_now.ctp 1960 2010-05-21 14:46:46Z jayashree_028ac09 $ */ ?>
<div class="payments membership">
  <div class="clearfix">
    <div class="ver-space ver-mspace sep-bot clearfix">
		<h2><?php echo __l('Pay Membership Fee');?></h2>
	</div>
  </div>
  <?php
	if(isset($this->request->data['User']['wallet']) && $this->request->data['User']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && !empty($sudopay_gateway_settings) && $sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
		echo $this->element('sudopay_button', array('data' => $sudopay_data, 'cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
	} else {
	?>
  <?php echo $this->Form->create('Payment', array('url' => array('controller' => 'payments', 'action' => 'membership_pay_now', $user['User']['id'], $this->request->params['pass'][1]), 'class' => 'js-submit-target'));
  echo $this->Form->input('User.id',array('type'=>'hidden'));
  ?>
    <dl class="payment-list clearfix">
	  <dt class="span4 no-mar"><?php echo __l('Membership Fee');?></dt>
	  <dd><?php echo $this->Html->siteCurrencyFormat($total_amount);?></dd>
	</dl>
	<fieldset class="form-block">
		<legend><?php echo __l('Select Payment Type');?></legend>
		<?php echo $this->element('payment-get_gateways', array('model' => 'User', 'type' => 'is_enable_for_signup_fee','foreign_id' => $this->request->data['User']['id'], 'transaction_type' => ConstPaymentType::SignupFee, 'is_enable_wallet' => 0, 'cache' => array('config' => 'sec')));?>
	</fieldset>
	<?php echo $this->Form->end();?>
<?php } ?>
</div>