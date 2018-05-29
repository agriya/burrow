<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="properties index js-response">
<?php if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='favorite' && isPluginEnabled('PropertyFavorites')) : ?>
<h2><?php echo __l('Bookmarked Properties');?></h2>
<?php else: ?>
<h2><?php echo __l('Properties');?></h2>
<?php endif; ?>
<?php
	$view_count_url = Router::url(array(
		'controller' => 'properties',
		'action' => 'update_view_count',
	), true);
?>
<ol class="list js-response js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($properties)):

$i = 0;
foreach ($properties as $property):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' altrow ';
	}
	if($property['Property']['is_active']){
		$status='Active';
	}
	else
	{
		$status='Not Active';
	}

	if($property['Property']['is_verified']){
		$status.=' and Approved';
	}
	else
	{
		$status.=' and not Approved';
	}
?>
	<li class="<?php echo $class;?> clearfix">	
	<div class="">
	  <?php 
	    echo $this->Html->link($this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'city' => $property['Property']['slug'], 'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false), 'escape' => false));		  
	 ?>
	 </div>
	<div class="3">
		<p>
		<?php echo $this->Html->link($this->Html->cText($property['Property']['title']), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'],  'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false));	?>
		</p>
		<p><?php echo $this->Html->cText($property['Property']['description']);?></p>
		<dl class="list request-list clearfix">
		 <dt><?php echo __l('Status');?> </dt>
		 <dd><?php echo $status;?></dd>
		  <dt><?php echo __l('Price');?>Price </dt>
		 <dd><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']);?></dd>
		 <dt><?php echo __l('Viewed');?> </dt>
		 <dd class="js-view-count-property-id js-view-count-property-id-<?php echo $property['Property']['id']; ?> {'id':'<?php echo $property['Property']['id']; ?>'}"><?php echo $this->Html->cInt($property['Property']['property_view_count']);?></dd>
		</dl>
	</div>
<?php
if($this->Auth->user('id') == $property['Property']['user_id']): ?>
		<div class="actions"><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $property['Property']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $property['Property']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></div>

<?php endif; ?>

	</li>
<?php
    endforeach;
else:
?>
	<li>
		<div class="space dc grayc">
			<p class="ver-mspace top-space text-16 "><?php echo __l('No Properties available');?></p>
		</div>
	</li>
<?php
endif;
?>
</ol>
<div class="<?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?>">
<?php
if (!empty($properties)) {
	if(count($properties)> 5){
    echo $this->element('paging_links');
	}
}
?>
</div>
</div>
