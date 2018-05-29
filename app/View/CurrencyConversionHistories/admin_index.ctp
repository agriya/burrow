<?php /* SVN: $Id: $ */ ?>
<div class="currencyConversionHistories index">
	<div class="alert alert-info">
		<?php echo __l('Currency Conversion History Updation is currently enabled. You can disable it from').' '.$this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 4), array('target' => '_blank'));?>
	</div>
<?php echo $this->element('paging_counter');?>
 <div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
		<th class="actions sep-right span2"><?php echo __l('Actions');?></th>
			<th class="dc sep-right"><?php echo $this->Paginator->sort('created');?></th>
			<th class="graydarkc sep-right dc"><?php echo $this->Paginator->sort('currency_id');?></th>
			<th class="graydarkc sep-right dc"><?php echo $this->Paginator->sort('converted_currency');?></th>
			<th class="graydarkc sep-right dc"><?php echo $this->Paginator->sort('rate_before_change');?></th>
			<th class="graydarkc sep-right dc"><?php echo $this->Paginator->sort('rate');?></th>
		</tr></thead><tbody>
	<?php
if (!empty($currencyConversionHistories)):
	$i = 0;
	foreach ($currencyConversionHistories as $currencyConversionHistory):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
	   <td class="dc"><span class="dropdown dc"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $currencyConversionHistory['CurrencyConversionHistory']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
			   </ul>
							 </span>
                            </td>
		
		<td class="dc">
			<?php echo $this->Html->cDateTime($currencyConversionHistory['CurrencyConversionHistory']['created']); ?>
		</td>
		<td class="dc">
			<?php echo $this->Html->cText($currencyConversionHistory['CurrencyConversion']['Currency']['code']); ?>
		</td>
		<td class="dc">
			<?php echo $this->Html->cText($currencyConversionHistory['CurrencyConversion']['ConvertedCurrency']['code']); ?>			
		</td>
		<td class="dr">
			<?php echo $this->Html->cFloat($currencyConversionHistory['CurrencyConversionHistory']['rate_before_change']); ?>
		</td>
		<td class="dr">
			<?php echo $this->Html->cFloat($currencyConversionHistory['CurrencyConversionHistory']['rate']); ?>
		</td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="9"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Currency Conversion Histories available');?></p></div></td>
	</tr>
<?php
endif;
?>
</table>
</div>
</div>
<div class="js-pagination pagination pull-right no-mar mob-clr dc">
<?php
if (!empty($currencyConversionHistories)) {
    echo $this->element('paging_links');
}
?>
</div>
</div>
