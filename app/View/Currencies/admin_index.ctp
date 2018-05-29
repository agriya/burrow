<?php /* SVN: $Id: $ */ ?>
<div class="currencies index">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Currencies        </li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
<div class="clearfix page-count-block">
    
     <div class="clearfix  dr add-block1">
    	<?php echo $this->Html->link('<i class="icon-time"></i>' . __l('History'),array('controller'=>'currency_conversion_histories','action'=>'index'),array('class'=>'history right-space','title' => __l('History'), 'escape' => false));?>
    	<?php echo $this->Html->link('<i class="icon-refresh"></i>' . __l('Currency Conversion / Exchange Rates'),array('controller'=>'currencies','action'=>'currency_update'),array('title' => __l('Currency Conversion / Exchange Rates'), 'class' => 'update-status', 'escape' => false));?>
		<?php echo $this->Html->link('<span class="ver-smspace"><i class="icon-plus-sign no-pad top-smspace"></i></span>', array('action' => 'add'), array('escape' => false,'class' => 'add btn btn-primary textb text-18 whitec','title'=>__l('Add'))); ?>
    </div>
</div>
        <?php echo $this->element('paging_counter');?>
    
<div class="overflow-block">
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
        <th class="sep-right"><?php echo __l('Action');?></th>
		<th class="dl sep-right"><?php echo $this->Paginator->sort( 'name',__l('Name'));?></th>
        <th class="dc sep-right"><?php echo $this->Paginator->sort( 'code',__l('Code'));?></th>
        <th class="dc sep-right"><?php echo $this->Paginator->sort( 'symbol',__l('Symbol'));?></th>
		<th class="dc sep-right"><?php echo $this->Paginator->sort('created',__l('Added On'));?></th>
		<th class="dc sep-right"><?php echo $this->Paginator->sort( 'decimals',__l('Decimals'));?></th>
		<th class="dc sep-right"><?php echo $this->Paginator->sort( 'dec_point',__l('Dec Point'));?></th>
		<th class="dc sep-right"><?php echo $this->Paginator->sort( 'thousands_sep',__l('Thousands Sep'));?></th>
      </tr></thead><tbody>
<?php
if (!empty($currencies)):

$i = 0;
$_currencies = Cache::read('site_currencies');
$selected_currency = $_currencies[Configure::read('site.currency_id')];
foreach ($currencies as $currency):
	$class = null;
	$active_class = '';
	if ($i++ % 2 == 0) {
		$class = 'altrow';
	}
	if(!$currency['Currency']['is_enabled']):
    $active_class = 'disable';
	endif;
	
?>
 <tr class="<?php echo $class. $active_class;?>">
		<td class=""><div class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">        			
					<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'edit', $currency['Currency']['id']), array('escape' => false,'class' => 'edit', 'title' => __l('Edit')));?></li>
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $currency['Currency']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
			   </ul>
							 </div>
 	</td>
		<td class="dl">
			<?php echo $this->Html->cText($currency['Currency']['name']);?>
		</td>
		<td class="dc"><?php echo $this->Html->cText($currency['Currency']['code']);?></td>
		<td class="dc"><?php echo $this->Html->cText($currency['Currency']['symbol']);?></td>
		<td class="dc"><?php echo $this->Html->cDateTimeHighlight($currency['Currency']['created']);?></td>
		<td class="dc"><?php echo $this->Html->cText($currency['Currency']['decimals']);?></td>
		<td class="dc"><?php echo $this->Html->cText($currency['Currency']['dec_point']);?></td>
		<td class="dc"><?php echo $this->Html->cText($currency['Currency']['thousands_sep']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Currencies available');?></p></div></td>
	</tr>
<?php
endif;
?></tbody>
</table>
</div>
<?php if (!empty($currencies)) {?>	
	 <div class="js-pagination pagination pull-right no-mar mob-clr dc">
            <?php echo $this->element('paging_links'); ?>
        </div>
	<?php }?>
</div>
