<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="properties index">
<?php //echo $this->element('paging_counter');?>
<ol class="list" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($properties)):

$i = 0;
foreach ($properties as $property):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' altrow';
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
	<li class=" clearfix <?php echo $class;?>">
	<div class="">
	  <?php 
	    echo $this->Html->link($this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'city' => $property['Property']['slug'], 'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false));		  
	 ?>
	 </div>
	<div class="">
	
		<?php if(isset($current_latitude) && isset($current_longitude)): ?>
		<p><?php echo number_format($this->Html->distance($current_latitude,$current_longitude,$property['Property']['latitude'],$property['Property']['longitude'],'k'),1).__l(' KM Away'); ?></p>
		<?php endif;?>
		<p><?php
			echo  $this->Html->siteCurrencyFormat($property['Property']['price_per_night']) ."/Night";
		?>
		</p>
		<?php 
			echo $this->Html->getUserAvatarLink($property['User'], 'small_thumb');
		?>	
		</div>
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

<?php
if (!empty($properties)) {
	if(count($properties)> 5){
    echo $this->element('paging_links');
	}
}
?>
</div>
