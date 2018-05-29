<?php /* SVN: $Id: $ */ ?>
<div class="sudopayTransactionLogs view fields-block">
<div>
  <dl class="dl-horizontal clearfix">
    <dt><?php echo __l('Id');?></dt>
      <dd><?php echo $this->Html->cInt($sudopayTransactionLog['SudopayTransactionLog']['id']);?></dd>
    <dt><?php echo __l('Created');?></dt>
      <dd><?php echo $this->Html->cDateTime($sudopayTransactionLog['SudopayTransactionLog']['created']);?></dd>
    <dt><?php echo __l('Modified');?></dt>
      <dd><?php echo $this->Html->cDateTime($sudopayTransactionLog['SudopayTransactionLog']['modified']);?></dd>
    <dt><?php echo __l('Class');?></dt>
      <dd><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['class']);?></dd>
    <dt><?php echo __l('Payment Id');?></dt>
      <dd><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['payment_id']); ?></dd>
    <dt><?php echo __l('Amount');?></dt>
      <dd><?php echo $this->Html->cCurrency($sudopayTransactionLog['SudopayTransactionLog']['amount']);?></dd>
	<dt><?php echo __l('Pay Key');?></dt>
      <dd><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['sudopay_pay_key']);?></dd>
	<dt><?php echo __l('Merchant Id');?></dt>
      <dd><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['merchant_id']); ?></dd>
	<dt><?php echo __l('Gateway Id');?></dt>
      <dd><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['gateway_id']); ?></dd>
	<dt><?php echo __l('Gateway Name');?></dt>
      <dd><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['gateway_name']); ?></dd>
	<dt><?php echo __l('Status');?></dt>
      <dd><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['status']); ?></dd>
	<dt><?php echo __l('Payment Type');?></dt>
      <dd><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['payment_type']); ?></dd>
	<dt><?php echo __l('Buyer Email');?></dt>
      <dd><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['buyer_email']); ?></dd>
	<dt><?php echo __l('Buyer Address');?></dt>
      <dd><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['buyer_address']); ?></dd>
  </dl>
  </div>
</div>
