<div class="js-response" id="js-update-block-submit">
        <div class="properties-middle-block side-property clearfix">
      
        <h3 class="well space textb text-16 no-mar"><?php echo __l('Properties');?></h3>
          <div class="properties-middle-inner-block">
            <?php echo $this->Form->create('PropertyUser', array('class' => 'normal', 'action'=>'index'));
            echo $this->Form->input('PropertyUser.type',array('type'=>'hidden','value'=>'myworks'));
            echo $this->Form->input('PropertyUser.status',array('type'=>'hidden','value'=>'waiting_for_acceptance'));
            ?>
            <ol class="properties-list myproperties-list unstyled no-mar">
            <?php
            if (!empty($properties)): ?>
            <?php
            $i = 0;
            foreach ($properties as $property):
            	$class = null;
            	if ($i++ % 2 == 0) {
            		$class = ' altrow ';
            	}
            	if($property['Property']['is_active']) {
            		$status='Active';
            	}
            	else
            	{
            		$status='Not Active';
            	}

            	if($property['Property']['is_verified']) {
            		$status.=' and Approved';
            	}
            	else
    	{
    		$status.=' and not Approved';
    	}
		$_SESSION['Property_Calender'][$property['Property']['id']] = $i;
    ?>
    	<li class=" sep-bot ver-space<?php echo $class;?> clearfix">
    	<div class="properties-left-block pull-left">
    	  <?php
    		$options = array($property['Property']['id'] => '');
			if(!empty($this->request->params['named']['property_id']))
			{
    			$checked = in_array($property['Property']['id'], explode(',', $this->request->params['named']['property_id'])) ? 'checked' : '';
			}
			else
			{
				$checked = 'checked';
			}
    		echo $this->Form->input('Property.' .$i. '.property', array('type' => 'checkbox', 'class' => 'js-checkbox-list', 'checked' => $checked, 'legend' => false, 'label' => "",  'value' => $property['Property']['id'], 'div' => false, 'options' => $options));
			$property['Attachment'][0] = !empty($property['Attachment'][0]) ? $property['Attachment'][0] : array();
            echo $this->Html->link($this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('title' => $this->Html->cText($property['Property']['title'],false), 'class' => 'left-smspace mob-hor-mspace', 'escape' => false));
    	 ?>
    	 </div>
    	 <div class="properties-right-block span6 pull-left">
    		<h4 class="properties-title">
    		<?php echo sprintf('P%s: ',$i),$this->Html->link($this->Html->cText($property['Property']['title']), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'],  'admin' => false), array('title' => $this->Html->cText($property['Property']['title'], false), 'escape' => false));	?>
    		</h4>
			<div class=" clearfix">
			<div class="span2 no-mar">
			<?php 
			    		echo $this->Form->input('Property.' .$i. '.id', array ('type' => 'hidden','value'=>$property['Property']['id']));
			echo $this->Form->input('Property.' .$i. '.price_per_night', array ('size' => '3', 'label' => 'Night','value'=>$property['Property']['price_per_night'],'div'=>false,'class'=>'js-input-price span2')); ?>
			</div>
			<div class="span2">
			<?php echo $this->Form->input('Property.' .$i. '.price_per_week', array ('size' => '3', 'label' => 'Week','value'=>$property['Property']['price_per_week'],'div'=>false,'class'=>'js-input-price span2')); ?>
			</div>
			<div class="span2">
			<?php echo $this->Form->input('Property.' .$i. '.price_per_month', array ('size' => '3', 'label' => 'Month','value'=>$property['Property']['price_per_month'],'div'=>false,'class'=>'js-input-price span2')); ?>
			</div>
		
        </div>
           </div>
    	</li>
    <?php
    endforeach; ?>
    <?php
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
    if (!empty($properties)) { ?>
   <div class="select-block select-block">
            <?php echo __l('Select:'); ?>
            <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select-all','title' => __l('All'))); ?>
            <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select-none','title' => __l('None'))); ?>
 		  
        </div>
        <div class="clearfix save-filter-block top-space">
          <?php
                echo $this->Form->submit(__l('Save'),array('class'=>'js-update-button btn btn-primary btn-large textb inactive-search dc' ,'div' =>'submit tb'));
            ?>
			<div class="clearfix pull-right">
          <?php
             echo $this->Form->submit(__l('Filter'),array('class'=>'js-filter-button btn btn-primary btn-large textb'));
            ?></div>
        </div>
         <?php } ?>
    	<?php echo $this->Form->end(); ?>

 
    </div>
    </div>
</div>
