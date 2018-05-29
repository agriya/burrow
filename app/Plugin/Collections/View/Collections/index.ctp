<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="collections index">
<div class="container_24 clearfix">
<div class="collection-top-block">
<h2 class="top-space top-mspace text-32"><?php echo __l('Collections');?></h2>
<ol class="unstyled clearfix" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($collections)):

$i = 0;
$j = 0;
foreach ($collections as $collection):
	//pr($collection);
	$class = null;
	if ($i++ % 2 == 0) {
		$class = 'altrow';
	}
?>
	<li class="span8 <?php echo (($j % 3) == 0) ? "no-mar" : ""; ?>">
	<?php if(!empty($collection['Attachment']['id'])): ?>
				<span class="show top-space top-mspace">
                <?php
                   echo $this->Html->link($this->Html->showImage('Collection', $collection['Attachment'], array('dimension' => 'collection_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($collection['Collection']['title'], false)), 'title' => $this->Html->cText($collection['Collection']['title'], false),'escape' => false),array('aspect_ratio'=>1)), array('controller' => 'properties', 'action' => 'index', 'type'=>'collection','slug'=>$collection['Collection']['slug']), array('escape' => false));
			  ?>
			  </span>
<?php else: ?>
<a href="<?php echo Router::url(array('controller' => 'properties', 'action' => 'index', 'type'=>'collection','slug'=>$collection['Collection']['slug'], 'admin' => false)); ?>" class="collections show clearfix">

<span class="show top-space top-mspace clearfix">
<?php 
// @todo "Collage Script"
$i=1;
$thumb_class="collection_thumb";
$count = count($collection['Property']);
$span_class="";
foreach($collection['Property'] as $property):
	if($count == 2){
		$thumb_class="collage_thumb";
	}
	if($count>=3){
		if($i==3){
			$thumb_class="collage_thumb";
		} else { 
			$span_class = "collection-imgs pull-left";
			$thumb_class="rectagle_thumb";
		}
	}
	if($i>3) {
		break;
	}
?><span class="show <?php echo $span_class ?>">
<?php echo $this->Html->showImage('Property',$property['Attachment'][0], array('dimension' => $thumb_class, 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($collection['Collection']['title'], false)), 'title' => $this->Html->cText($collection['Collection']['title'], false),'escape' => false));?>
</span>
<?php 
$i++;
endforeach; ?>
</span>
</a>

	<?php endif; ?>
	<h3 class="span8 no-mar htruncate">
		<div class="htruncate js-bootstrap-tooltip span7 no-mar" title="<?php echo $collection['Collection']['title']; ?>"><?php echo $this->Html->link($this->Html->cText($collection['Collection']['title'], false), array('controller' => 'properties', 'action' => 'index', 'type'=>'collection','slug'=>$collection['Collection']['slug'], 'admin' => false), array('title'=>$this->Html->cText($collection['Collection']['title'], false),'escape' => false,'class'=>'graydarkc')); ?></div></h3>
		
		 <dl class="dc list sep-right sep-left">
                      <dt class="pr hor-mspace text-11" title ="<?php echo __l('Properties');?>">
                      <?php echo __l('Properties');?></dt>
                      <dd class="textb text-20 graydarkc pr hor-mspace">
                      <?php echo $this->Html->cInt($collection['Collection']['property_count']); ?>
                      </dd>
         </dl>
		 <dl class="sep-right list">
                      <dt class="pr hor-mspace text-11" title ="<?php echo __l('Countries');?>">
                      <?php echo __l('Countries');?></dt>
                      <dd class="textb text-20 graydarkc pr hor-mspace">
                      <?php echo $this->Html->cInt($collection['Collection']['country_count']); ?>
                      </dd>
         </dl>
		 <dl class="sep-right list">
                      <dt class="pr hor-mspace text-11" title ="<?php echo __l('Cities');?>">
                      <?php echo __l('Cities');?></dt>
                      <dd class="textb text-20 graydarkc pr hor-mspace">
                      <?php echo $this->Html->cInt($collection['Collection']['city_count']); ?>
                      </dd>
         </dl>
		<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
		<ol class="unstyled">
		<li>
			<?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action'=>'edit', $collection['Collection']['id'], 'admin' => true), array('escape' => false,'class' => 'hor-space edit grayc', 'title' => __l('Edit')));?>
		</li>
		<li>
			<?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action'=>'delete', $collection['Collection']['id'], 'admin' => true), array('escape' => false,'class' => 'hor-space delete js-delete grayc', 'title' => __l('Delete')));?>
		</li>
		</ol>
			
		<?php endif; ?>
	</li>
<?php
	$j++;
    endforeach;
else:
?>
	<li>
		<div class="space dc grayc">
			<p class="ver-mspace top-space text-16 "><?php echo __l('No Collections available');?></p>
		</div>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($collections)) {
    echo $this->element('paging_links');
}
?>
</div>
</div>
</div>