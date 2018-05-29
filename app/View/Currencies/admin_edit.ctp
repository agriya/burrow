<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Currencies'), array('controller'=>'currencies','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Edit Currency'); ?></li>
</ul>
<div class="currencies form sep-top">
<?php echo $this->Form->create('Currency', array('class' => 'form-horizontal space'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array('label' => __l('Name')));
		echo $this->Form->input('code', array('label' => __l('Code')));
		echo $this->Form->input('symbol', array('label' => __l('Symbol')));		
		echo $this->Form->input('decimals', array('label' => __l('Decimals')));
		echo $this->Form->input('dec_point', array('label' => __l('Decimal Point')));
		echo $this->Form->input('thousands_sep', array('label' => __l('Thousand Separate')));		
		$_currencies = Cache::read('site_currencies');
		$selected_currency = $_currencies[Configure::read('site.currency_id')];
		if(($selected_currency['Currency']['id'] != $this->request->data['Currency']['id'])):
			echo $this->Form->input('is_enabled',array('label' =>__l('Enabled?')));
		endif;
	?>
	</fieldset>
<div class="form-actions">
	<?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16')); ?>
</div>
<?php echo $this->Form->end(); ?>        
</div>
