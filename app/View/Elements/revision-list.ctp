<div class="admin-revisions">
<h3><?php echo __l('Admin'); ?></h3>
<table>
<?php
	foreach ($revisions as $revision):
?>
		<tr>
			<td>
				<?php echo $this->Html->link(__l('Revision ').$revision['Revision']['revision_number'], array('controller' => $this->request->params['controller'], 'action' => 'edit', $revision['Revision']['node_id'], 'rev' => $revision['Revision']['revision_number']),array('title' => __l('Revision')));?>
				<?php echo __l('saved'); ?>
				<?php echo $this->Html->cDateTimeHighlight($revision['Revision']['created']); ?>
				<?php echo __l('by'); ?>
				<?php echo $revision['User']['username']; ?>
			</td>
		</tr>
<?php
	endforeach;
?>
</table>
</div>