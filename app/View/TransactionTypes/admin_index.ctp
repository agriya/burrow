<?php /* SVN: $Id: $ */ ?>
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Transaction Types                 </li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
				<?php echo $this->element('paging_counter');?>
<div class="overflow-block">
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
        <th class="sep-right dc span2"><?php echo __l('Actions');?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort('name',__l('Name'));?></th>
        <th class="dc sep-right"><?php echo $this->Paginator->sort('is_credit',__l('Credit'));?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort('message',__l('Message'));?></th>
    </tr></thead><tbody>
<?php
if (!empty($transactionTypes)):

$i = 0;
foreach ($transactionTypes as $transactionType):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="dc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			
					<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'edit', $transactionType['TransactionType']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Edit')));?></li>
        			
			   </ul>
							 </span>
                            </td>
		<td class="dl"><?php echo $this->Html->cText($transactionType['TransactionType']['name']);?></td>
		<td class="dc"><?php echo $this->Html->cBool($transactionType['TransactionType']['is_credit']);?></td>
		<td class="dl"><?php echo $this->Html->cText($transactionType['TransactionType']['message']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Transaction Types available');?></p></div></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($transactionTypes)) {?>
     <div class="js-pagination pagination pull-right no-mar mob-clr dc">
            <?php echo $this->element('paging_links'); ?>
        </div>
<?php
}
?>
</div>
