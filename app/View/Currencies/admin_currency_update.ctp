<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Currencies'), array('controller'=>'currencies','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Currency Conversion'); ?></li>
</ul>
<div class="currencies form js-response space sep-top">
<div class="alert alert-info">
	<?php if(Configure::read('site.is_auto_currency_updation') == 1):?>
		<?php echo __l('Automatic Currency Conversion Updation is currently enabled. You can disable it from').' '.$this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 4), array('target' => '_blank')).' '.__l('page if you prefer to manually update the values here.');?>
	<?php else:?>
		<?php echo __l('Automatic Currency Conversion Updation is currently disabled. You can enable it from').' '.$this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 4), array('target' => '_blank')).' '.__l('page. When you enabled automatic update, you don\'t have to manually update the values here.');?>
	<?php endif;?>
</div>
<?php echo $this->Form->create('Currency', array('action' => 'admin_currency_update', 'class' => 'form-horizontal space'));?>
	<?php
		echo $this->Form->input('currency_id', array('label' =>__l('Base Currency'), 'class' => 'js-onchange-currency'));
	?>
	<div class="overflow-block js-currency-input">
		  <table class="table no-round table-striped">
			<thead>
			  <tr class="well no-mar no-pad">     	
				<th class="dc graydarkc sep-right"><?php echo __l('Conversion');?></th>
				<th class="dc graydarkc sep-right"><?php echo __l('Rate');?></th>
			</tr>
			
			<?php  for($i=0; $i< count($this->request->data['CurrencyConversion']); $i++) {?>
				<tr>
					<td class="dc"> <?php echo $this->request->data['CurrencyConversion'][$i]['code']; ?></td>
					<td class="dc"><?php
						$read_only = '';
						//echo $currencies[$this->request->data['Currency']['currency_id']] .'=='. $this->request->data['CurrencyConversion'][$i]['code'];
 						if($currencies[$this->request->data['Currency']['currency_id']] == $this->request->data['CurrencyConversion'][$i]['code']){
							$read_only = 'readonly';
						}
						echo $this->Form->input('CurrencyConversion.'.$i.'.id', array('label' => false, 'type' => 'hidden'));
						echo $this->Form->input('CurrencyConversion.'.$i.'.code', array('label' => false,  'type' => 'hidden'));
						echo $this->Form->input('CurrencyConversion.'.$i.'.rate', array('label' => false)); 
						?>
					</td>
				</tr>
			<?php } ?>						
		</table>
		</div>
<div class="form-actions">
	<?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16')); ?>
</div>
<?php echo $this->Form->end(); ?>        
</div>
