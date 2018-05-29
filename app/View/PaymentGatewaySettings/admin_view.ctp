<?php /* SVN: $Id: $ */ ?>
<div class="paymentGatewaySettings view">
<h2><?php echo __l('Payment Gateway Setting');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($paymentGatewaySetting['PaymentGatewaySetting']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Created');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($paymentGatewaySetting['PaymentGatewaySetting']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Modified');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($paymentGatewaySetting['PaymentGatewaySetting']['modified']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Payment Gateway Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($paymentGatewaySetting['PaymentGatewaySetting']['payment_gateway_id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Name');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($paymentGatewaySetting['PaymentGatewaySetting']['name']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Value');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($paymentGatewaySetting['PaymentGatewaySetting']['value']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Description');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($paymentGatewaySetting['PaymentGatewaySetting']['description']);?></dd>
	</dl>
</div>

