<?php /* SVN: $Id: $ */ ?>
<div class="affiliateTypes index">
<h2><?php echo __l('Affiliate Types');?></h2>
<?php echo $this->element('paging_counter');?>
 <div class="overflow-block">
<table class="list">
    <tr>
        <th class="actions span2"><?php echo __l('Actions');?></th>
        <th><?php echo $this->Paginator->sort('name',__l('Name'));?></th>
        <th><?php echo $this->Paginator->sort('commission',__l('Commission'));?></th>
        <th><?php echo __l('Commission Type');?></th>
        <th><?php echo $this->Paginator->sort('is_active',__l('Active?'));?></th>
    </tr>
<?php
if (!empty($affiliateTypes)):

$i = 0;
foreach ($affiliateTypes as $affiliateType):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	if($affiliateType['AffiliateType']['is_active']):
		$status_class = 'js-checkbox-active';
	else:
		$status_class = 'js-checkbox-inactive';
	endif;
	}
?>
	<tr<?php echo $class;?>>
		<td class="actions"><span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $affiliateType['AffiliateType']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span></td>
		<td><?php echo $this->Html->cText($affiliateType['AffiliateType']['name']);?></td>
		<td><?php echo $this->Html->siteCurrencyFormat($affiliateType['AffiliateType']['commission']);?></td>
		<td><?php echo $this->Html->cText( $affiliateType['AffiliateCommissionType']['description'] . ' ('.$affiliateType['AffiliateCommissionType']['name'].')');?></td>
		<td><?php echo $this->Html->cBool($affiliateType['AffiliateType']['is_active']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="5">
			<div class="space dc">
				<p class="ver-mspace grayc top-space text-16 "><?php echo __l('No Affiliate Types available');?></p>
			</div>
		</td>
	</tr>
<?php
endif;
?>
</table>
</div>
</div>