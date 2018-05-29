<?php /* SVN: $Id: $ */ ?>
<div class="siteCategories index">
<h2><?php echo __l('Site Categories');?></h2>
<?php echo $this->element('paging_counter');?>
<table class="list">
    <tr>
        <th class="actions span2"><?php echo __l('Actions');?></th>
        <th><?php echo $this->Paginator->sort('id');?></th>
        <th><?php echo $this->Paginator->sort('created');?></th>
        <th><?php echo $this->Paginator->sort('modified');?></th>
        <th><?php echo $this->Paginator->sort('name');?></th>
        <th><?php echo $this->Paginator->sort('slug');?></th>
        <th><?php echo $this->Paginator->sort('is_active');?></th>
    </tr>
<?php
if (!empty($siteCategories)):

$i = 0;
foreach ($siteCategories as $siteCategory):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="actions"><span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $siteCategory['SiteCategory']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span> <span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $siteCategory['SiteCategory']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></td>
		<td><?php echo $this->Html->cInt($siteCategory['SiteCategory']['id']);?></td>
		<td><?php echo $this->Html->cDateTime($siteCategory['SiteCategory']['created']);?></td>
		<td><?php echo $this->Html->cDateTime($siteCategory['SiteCategory']['modified']);?></td>
		<td><?php echo $this->Html->cText($siteCategory['SiteCategory']['name']);?></td>
		<td><?php echo $this->Html->cText($siteCategory['SiteCategory']['slug']);?></td>
		<td><?php echo $this->Html->cBool($siteCategory['SiteCategory']['is_active']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Site Categories available');?></p></div></td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($siteCategories)) {
    echo $this->element('paging_links');
}
?>
</div>
