<?php /* SVN: $Id: $ */ ?>
<div class="properties index">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link( 'Properties', array('controller'=>'properties','action'=>'index'), array('escape' => false));?> <span class="divider">/</span></li>
              <li class="active"><?php echo __l('Manage Collections'); ?></li>
            </ul> 
<?php echo $this->Form->create('Collection', array('class' => 'form-horizontal space collectioneditform', 'action'=>'add_collection')); ?>
        <div class="clearfix sep-top">
			<div class="required pull-left span4 span4-sm no-mar ver-space dr mob-dl">
				<span class="hor-space show"><?php echo __l('Selected Properties'); ?></span>
			</div>
			<ul class="clearfix span ver-space unstyled no-mar">
			<?php
					$i=0;
					foreach($properties as $property): ?>
					 <li>
					<?php                        
					echo $this->Html->link($this->Html->cText($property['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('class' => 'grayc', 'title'=>$this->Html->cText($property['Property']['title'], false),'escape' => false));
					 ?>
					</li>
			   <?php $i++; endforeach; ?>
			</ul>
        </div>
		<div class="amenities-list">
			<div class="clearfix">
				<div class="required pull-left span4 span4-sm no-mar dr mob-dl">
					<label class="hor-space show"><?php echo __l('Choose collections'); ?></label>
				</div>
				<div class="input checkbox pull-left hor-smspace no-mar span20">
					<?php echo $this->Form->input('Collection', array('type'=>'select', 'multiple'=>'checkbox', 'div' =>false, 'label' => false, 'class' => 'checkbox span6 no-mar')); ?>
				</div>
			</div>
		</div>


<?php
	echo $this->Form->input('property_list',array('type'=>'hidden','value' =>$property_list));
?>
<div class="form-actions">
    <?php
    	echo $this->Form->submit(__l('Map it'), array('class' => 'btn btn-large btn-primary textb text-16'));
    ?>
</div>
<?php
    echo $this->Form->end();
?>
</div>