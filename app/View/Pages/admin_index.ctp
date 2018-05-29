<?php /* SVN: $Id: admin_index.ctp 54577 2011-05-25 10:39:06Z arovindhan_144at11 $ */ ?>
<div class="page-count-block clearfix">

<div class="pull-left">
<?php echo $this->element('paging_counter');?>
</div>
<div class="pull-right top-space mob-clr dc top-mspace">			
<?php echo $this->Html->link('<span class="ver-smspace"><i class="icon-plus-sign no-pad top-smspace"></i></span>', array('controller' => 'pages', 'action' => 'add'), array('class' => 'add btn btn-primary textb text-18 whitec','title' => __l('Add'),'escape'=>false)); ?>					
	</div>
</div>
<div class="pages index top-space ">
<div class="staticpage index">

<div class="overflow-block">
<table class="table no-round table-striped">
<thead>
    <tr class="well no-mar no-pad js-even">
		<th class="dc graydarkc sep-right span2"><?php echo __l('Actions'); ?></th>
        <th class="dl graydarkc sep-right"><?php echo $this->Paginator->sort('title',__l('Title'));?></th>
        <th class="dl graydarkc sep-right"><?php echo $this->Paginator->sort('content',__l('Content'));?></th>
    </tr>
</thead>
<tbody>
<?php
if (!empty($pages)):

$i = 0;
foreach ($pages as $page):
	$class = null;
	if ($i++ % 2 == 0) :
		$class = ' class="altrow"';
    endif;
?>
	<tr <?php echo $class;?>>
		<td class="actions">
			<span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			
        			<li><?php echo $this->Html->link('<i class="icon-eye-open"></i>'.__l('View'), array('controller' => 'pages', 'action' => 'view', $page['Page']['slug']), array('class' => 'review', 'title' => __l('View'),'escape' => false));?></li>
					<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'edit', $page['Page']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'),'escape' => false));?></li>
					<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $page['Page']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete'),'escape' => false));?></li>
				 </ul>
				  </span>
		</td>
		<td class="dl"><?php echo $this->Html->cText($page['Page']['title']);?></td>
		<td class="dl "><div class="width22 span22 htruncate "><?php echo $this->Html->cText($page['Page']['content'],false);?></div></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="17"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Pages available');?></p></div></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
</div>
<?php
if (!empty($pages)) :
    echo $this->element('paging_links');
endif;
?>

</div>
</div>
