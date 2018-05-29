<?php /* SVN: $Id: $ */ ?>
<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Collections'), array('controller'=>'collections','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Edit Collection'); ?></li>
</ul>
<div class="tabbable ver-space sep-top top-mspace">
<div class="collections form">
<?php echo $this->Form->create('Collection', array('class' => 'form-horizontal space check-form js-propertiesdrag', 'enctype' => 'multipart/form-data'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title', array('label' => __l('Title')));
		echo $this->Form->input('description', array('label' => __l('Description')));
		echo $this->Form->input('Attachment.filename', array('type' => 'file','size' => '33', 'label' => 'Upload Photo','class' =>'browse-field'));
		if(isset($this->request->data['Attachment']['id']))
		{
			echo $this->Form->input('Attachment.id',array('type'=>'hidden'));
		} ?>
		<?php if(isset($this->request->data['Attachment']['id'])): ?>
		<div class="profile-image info">
				<?php $this->request->data['Attachment'] = !empty($this->request->data['Attachment']) ? $this->request->data['Attachment'] : array(); ?>
                <?php echo $this->Html->showImage('Collection', $this->request->data['Attachment'], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($this->request->data['Collection']['title'], false)), 'title' => $this->Html->cText($this->request->data['Collection']['title'], false))); ?>
    		</div>
			<?php endif; ?>
	<?php
		echo "<div class='top-space top-mspace'>".$this->Form->input('is_active', array('label' => __l('Enable'),array('class'=>'top-space')))."</div>";
	?>
 <div class="form-actions">
    <?php
        	echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16','div'=>'pull-right submit')); ?>
	</div>
	</fieldset>
	<div class="clearfix">
    	<h2 class=""><?php echo __l('Manage Properties'); ?></h2>
    	<div class="pull-right top-space mob-clr dc top-mspace">
		    <i class="icon-move"></i>
            <a class="js-dragdrop reorder {'met_tab':'js-tab-list', 'met_drag_cls':'js-drag_property','met_data_action':'js-reorder','met_tr_drag':'js-dragbox', 'met_form_cls':'js-propertiesdrag', 'met_tab_order':'js-propertyorder'}" rel="reorder" title="Reorder" href="#"><?php echo __l('Reorder'); ?></a>
        </div>
    </div>

 <div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped label-sm js-tab-list">
	<thead>
	<tr class=" well no-mar no-pad">
	    <th class="graydarkc dc sep-right span1"><?php echo __l('Select');?></th>
        <th class="graydarkc dc sep-right actions" ><?php echo __l('Actions');?></th>
        <th class="graydarkc dc sep-right"><?php echo __l('Created');?></th>
        <th class="graydarkc sep-right dl"><?php echo __l('Title');?></th>
        <th class="graydarkc sep-right dl"><?php echo __l('Address');?></th>
        <th class="graydarkc sep-right dl"><?php echo __l('User');?></th>
    </tr></thead><tbody>
<?php
if (!empty($properties)):

$i = 0;
foreach ($properties as $property):
?>
	<tr>
	    <td class="dc span1"><?php echo $this->Form->input('Property.'.$property['Property']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$property['Property']['id'], 'label' => "", 'class' => ' js-checkbox-list','div'=>false)); ?></td>
    	
		<td class="dc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			
					
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete_property', $property['Property']['id'],$this->request->data['Collection']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
			   </ul>
							 </span>
                            </td>
                        
		<td class="dc"><?php echo $this->Html->cDateTimeHighlight($property['Property']['created']);?></td>
		<td class="propertys-title-info dl"><div class="clearfix">
         	<?php $attachment = '';?>
        	<?php if(!empty($property['Attachment']['0'])){?>
        	    	<?php if($property['Property']['is_negotiable']):?>
        	<?php endif;?>
				<span class="pull-left right-mspace">
                	<?php echo $this->Html->link($this->Html->showImage('Property', $property['Attachment']['0'], array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('escape' => false));?>
				</span>
            <?php }else{ ?>
				<span class="pull-left right-mspace">
        	  	   <?php echo $this->Html->link($this->Html->showImage('Property', $attachment, array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('escape' => false));?>
				 </span>
        	<?php } ?>
            
            
        	<?php
				if (!empty($property['Property']['admin_suspend'])):?>
				<div class="property-status-info">
					<span class="suspended round-3" title="<?php echo __l('Admin Suspended'); ?>"><?php echo __l('Admin Suspended'); ?></span>
				</div>
				<?php
				endif;
				if(isPluginEnabled('PropertyFlags')){
					if (!empty($property['PropertyFlag'])):
						?>
					<div class="property-status-info">
						<span class="flagged round-3" title="<?php echo __l('Flagged'); ?>"><?php echo __l('Flagged'); ?></span>
					</div>
					<?php 	
					endif;
				}
				if ($property['Property']['is_system_flagged']):?>
				<div class="property-status-info">
					<span class="systemflagged round-3" title="<?php echo __l('System Flagged'); ?>"><?php echo __l('System Flagged'); ?></span>
				</div>
				<?php	
				endif;
				/*if (empty($property['Property']['is_active'])):?>
				<div class="property-status-info">
					<span class="homepage round-3" title="<?php echo __l('Home Page'); ?>"><?php echo __l('Home Page'); ?></span>
				</div>
				<?php	
				endif; */
				if (!empty($property['Property']['is_featured'])):
				?>
				<div class="property-status-info">
					<span class="featured round-3" title="<?php echo __l('Featured'); ?>"><?php echo __l('Featured'); ?></span>
				</div>
				<?php
					
				endif;
				/*if (!empty($property['Property']['is_show_in_home_page'])):?>
				<div class="property-status-info">
					<span class="homepage round-3" title="<?php echo __l('Home Page'); ?>"><?php echo __l('Home Page'); ?></span>
				</div>
				<?php	
				endif; */
				if (Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == ConstVerification::Verified):?>
				<div class="property-status-info">
					<span class="verified round-3" title="<?php echo __l('Verified'); ?>"><?php echo __l('Verified'); ?></span>
				</div>
				<?php 	
				endif;
		      ?>
			<?php echo $this->Html->link($this->Html->cText($property['Property']['title']), array('controller'=> 'properties', 'action'=>'view', $property['Property']['slug'] , 'admin' => false), array('escape' => false, 'class' => 'htruncate js-bootstrap-tooltip span7 fluid-pull-left', 'title' => $this->Html->cText($property['Property']['title'], false) ));?>
			</div>
        </td>
		<td class="dl">
            <?php if(!empty($property['Country']['iso_alpha2'])): ?>
				<span class="flags flag-<?php echo strtolower($property['Country']['iso_alpha2']); ?>" title ="<?php echo $property['Country']['name']; ?>"><?php echo $property['Country']['name']; ?></span>
			<?php endif; ?>
			<div class="htruncate js-bootstrap-tooltip span4 fluid-pull-left" title="<?php echo $property['Property']['address'];?>" >
      		<?php echo $this->Html->cText($property['Property']['address']);?></div>
        </td>
		<td class="hide js-dragbox">
            <?php echo $this->Form->input('CollectionsProperty.'.$property['Property']['id'].'.display_order', array('value' =>  $property['Property']['display_order'], 'class' => 'js-propertyorder'));?>
        </td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($property['User']['username']), array('controller'=> 'users', 'action'=>'view', $property['User']['username'] , 'admin' => false), array('escape' => false));?></td>

    </tr>
<?php
    endforeach;
 
else:
?>
	<tr>
		<td colspan="51" class="notice"><?php echo __l('No Properties available');?></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>

<?php
if (!empty($properties)) :
        ?>
		<div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
                <?php echo __l('Select:'); ?>
				</span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
				
             </div><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit js-no-pjax span5', 'div'=>false,'label' => false, 'empty' => __l('-- More actions --'))); ?></span>
            
         </div>
          
        
        <div class="hide">
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
        <?php
	endif; ?>
   </div>
   <?php  echo $this->Form->end();
    ?>
</div>
</div>
</div>
