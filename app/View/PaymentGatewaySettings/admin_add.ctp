<?php /* SVN: $Id: $ */ ?>
<div class="paymentGatewaySettings form">
<h2><?php echo __l('Add Payment Gateway Settings');?></h2>
<div id="breadcrumb">
   <?php $this->Html->addCrumb('Payment Gateways', array('controller' => 'payment_gateways','action' => 'index')); ?>
  <?php $this->Html->addCrumb(__l('Add Payment Gateway Setting')); ?>
  <?php echo $this->Html->getCrumbs(' &raquo; '); ?>
</div>
<?php echo $this->Form->create('PaymentGatewaySetting', array('class' => 'normal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('payment_gateway_id');
		echo $this->Form->input('name', array('label' => __l('Key')));
		echo $this->Form->input('type', array('type' => 'select', 'options' => array('text' => 'text', 'textarea' => 'textarea', 'checkbox' => 'checkbox', 'radio' => 'radio', 'password' => 'password')));
		echo $this->Form->input('value', array('label' => __l('Value')));
		echo $this->Form->input('description', array('label' => __l('Description')));
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>