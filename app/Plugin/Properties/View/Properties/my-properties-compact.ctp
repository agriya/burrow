<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php if(empty($this->request->params['isAjax'])): ?>
<div class="properties index js-response">
<?php endif; ?>
<h2 class="ver-space top-mspace text-32 sep-bot"><?php echo __l('Assign a property for') . ' "' . $this->Html->cText($request_name,false) . '"';?></h2>
<?php
echo $this->Form->create('Property', array('class' => 'normal','action'=>'manage_property', 'enctype' => 'multipart/form-data'));
echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url));
echo $this->Form->input('request_id',array('type'=>'hidden'));
if (!empty($properties)): ?>
<ol class="properties-list1 clearfix unstyled " start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
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
	<li class="<?php echo $class;?> sep-bot ver-space  clearfix">	
		<div class="span1">
		  <?php
			  $options = array($property['Property']['id'] => '');
			echo $this->Form->input('Property.property', array ("div"=>"span input radio",'type' => 'radio', 'options' => $options, 'value' => $property['Property']['id'] . '#' . $property['Property']['id'])); 
			?>
		</div>
		<div class="span">
	 <?php 	echo $this->Html->link($this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'],  'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false));		  
	 ?> </div>
		<div class="span">
		<?php echo $this->Html->link($this->Text->truncate($property['Property']['title'],45,array('ending' => '...','exact' => false)), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug']),array('title' =>$property['Property']['title']));?>
			<?php if(in_array($property['Property']['id'], $available_list)) { ?>	
			<div class="label span no-mar"><?php echo __l('exact'); ?></div>
		<?php } ?>
		</div>
	</li>
<?php
    endforeach; ?>
    </ol>

    <div class="form-actions">
    <?php
        	echo $this->Form->submit(__l('Assign'), array('class' => 'btn btn-large btn-primary textb text-16','div'=>'pull-right submit')); ?>
	</div>
	<?php

else:
?>
<ol class="list clearfix js-response unstyled" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
				<li class="sep-bot">
					<div class="space dc grayc">
						<p class="ver-mspace top-space text-16">
							<?php echo __l('No Matched Properties available');?>
						</p>
					</div>
				</li>		
	</ol>
<?php
endif;
		echo $this->Form->end();
?>


<?php if (!empty($properties)) { ?>
<div class="<?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?>">
<?php  echo $this->element('paging_links'); ?>	
</div>
<?php 
}
?>

<?php if(empty($this->request->params['isAjax'])): ?>
</div>
 <h4 class="dc"> <?php echo __l('OR'); ?> </h4>
<?php endif; ?>