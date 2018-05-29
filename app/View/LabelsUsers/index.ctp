<?php /* SVN: $Id: $ */ ?>
<div class="labelsUsers index">
<h2><?php echo __l('Labels');?></h2>
<div>
	<?php
	echo $this->Html->link(__l('Add'), array('controller' => 'labels', 'action' => 'add'), array('class' => 'add','title'=>__l('Add')));
	?>
</div>
<?php echo $this->element('message_message-left_sidebar', array('config' => 'sec'));?>
<table class="list" >
    <tr>
         <th class="label"><?php echo $this->Paginator->sort('label_id');?></th>
	     <th class="actions"><?php echo __l('Actions');?></th>
    </tr>
<?php
if (!empty($labelsUsers)) {

$i = 0;
foreach ($labelsUsers as $labelsUser) {
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="label"><?php echo $this->Html->link($this->Html->cText($labelsUser['Label']['name'], false),array('controller'=>'messages','action'=>'label',$labelsUser['Label']['slug']));?></td>
		<td class="actions"><span><?php echo $this->Html->link(__l('Rename'), array('action' => 'edit',$labelsUser['LabelsUser']['id']), array('class' => 'edit js-label-edit', 'title' => __l('Edit')));?></span> <span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $labelsUser['LabelsUser']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></td>
	</tr>
<?php
}
}
else {
?>
    <tr>
		<td colspan="2" class="notice"><?php echo __l('No labels added yet.');?></td>
	</tr>
<?php
}
?>
</table>
<?php
if (!empty($labelsUsers)) {
    echo $this->element('paging_links');
}
?>
</div>

