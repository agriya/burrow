<?php /* SVN: $Id: $ */ ?>
<h2><?php echo sprintf(__l('Edit').' %s '.__l('Settings'), $paymentGateway['PaymentGateway']['name']);?></h2>
<div id="breadcrumb">
   <?php $this->Html->addCrumb('Payment Gateways', array('controller' => 'payment_gateways','action' => 'index')); ?>
  <?php $this->Html->addCrumb(__l('Payment Gateway Setting Update')); ?>
  <?php echo $this->Html->getCrumbs(' &raquo; '); ?>
</div>
<?php echo $this->Html->link(__l('Add'), array('controller'=> 'payment_gateway_settings', 'action' => 'add', $paymentGateway['PaymentGateway']['id']), array('class' => 'add'));?>
<?php
if (!empty($paymentGatewaySettings)) {
	echo $this->Form->create('PaymentGatewaySetting', array('action' => 'update', 'class' => 'normal'));
	foreach ($paymentGatewaySettings as $paymentGatewaySetting):
		$name = "PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.name";
		$options = array(
			'type' => $paymentGatewaySetting['PaymentGatewaySetting']['type'],
			'value' => $paymentGatewaySetting['PaymentGatewaySetting']['value'],
			'div' => array('id' => "PaymentGatewaySetting-{$paymentGatewaySetting['PaymentGatewaySetting']['name']}")
		);
		if (!empty($paymentGatewaySetting['PaymentGatewaySetting']['description'])):
			$options['after'] = "<p class=\"setting-desc\">{$paymentGatewaySetting['PaymentGatewaySetting']['description']}</p>";
		endif;
		$options['label'] = Inflector::humanize($paymentGatewaySetting['PaymentGatewaySetting']['name']);
		echo $this->Form->input($name, $options);
	endforeach;
	echo $this->Form->input('payment_gateway_id', array('type' => 'hidden', 'value' => $paymentGatewaySetting['PaymentGatewaySetting']['payment_gateway_id']));
	echo $this->Form->end(__l('Update'));
}else{
?>
	<div class="notice"><?php echo __l('Sorry no settings added.');?></div>
<?php
}
?>