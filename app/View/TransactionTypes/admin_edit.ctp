<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Transaction Types'), array('controller'=>'transaction_types','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Edit Transaction Type'); ?></li>
</ul>
<div class="transactionTypes form sep-top">
<?php echo $this->Form->create('TransactionType', array('class' => 'form-horizontal space'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');?>
	<?php
		echo $this->Form->input('message',array('label'=>__l('Message'),'info' => $this->Html->cText($this->request->data['TransactionType']['transaction_variables'])));
	?>
	</fieldset>
	<div class="form-actions">
		 <?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
		<div class="cancel-block dc">
			<?php echo $this->Html->link(__l('Cancel') , array('action' => 'index'), array( 'class' => 'btn btn-large textb text-16'));?>
		</div>		 
	</div>
	 <?php echo $this->Form->end();?>
</div>

