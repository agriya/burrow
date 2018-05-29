<?php /* SVN: $Id: $ */ ?>
<div class="amenities index js-response">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Amenities               </li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
<div class="clearfix">
	<?php 
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Active) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Enabled').'">'.__l('Enabled').'</dt>
						<dd title="'.$this->Html->cInt($active,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($active ,false).'</dd>                  	
					</dl>'
					, array('action'=>'index','filter_id' => ConstMoreAction::Active), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Inactive) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Disabled').'">'.__l('Disabled').'</dt>
						<dd title="'.$this->Html->cInt($inactive,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($inactive ,false).'</dd>                  	
					</dl>'
					, array('action'=>'index','filter_id' => ConstMoreAction::Inactive), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (empty($this->request->params['named']['filter_id'])) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Total').'">'.__l('Total').'</dt>
						<dd title="'.$this->Html->cInt($active + $inactive,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($active + $inactive,false).'</dd>                  	
					</dl>'
					, array('action'=>'index'), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				
				?>
				</div><div class="clearfix dc">
					
					<div class="pull-right top-space mob-clr dc top-mspace">
					 
					<?php echo $this->Html->link('<span class="ver-smspace"><i class="icon-plus-sign no-pad top-smspace"></i></span>', array( 'action' => 'add'), array('escape' => false,'class' => 'add btn btn-primary textb text-18 whitec','title'=>__l('Add'))); ?>
				</div>
			
     
 </div>
	   <?php echo $this->element('paging_counter');?>
<?php
	echo $this->Form->create('Amenity' , array('class' => 'normal','action' => 'update'));
	echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); 
?>
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
        <th class="sep-right dc span2"><?php echo __l('Select'); ?></th>
        <th class="sep-right dc span2"><?php echo __l('Actions');?></th>
        <th class="dc sep-right"><?php echo $this->Paginator->sort( 'created',__l('Created'));?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort( 'name',__l('Name'));?></th>
    </tr></thead><tbody>
<?php
if (!empty($amenities)):

$i = 0;
foreach ($amenities as $amenity):
	$class = null;
	$active_class = '';
	if ($i++ % 2 == 0) {
	   $class = 'altrow';
	}
	if($amenity['Amenity']['is_active']):
		$status_class = 'js-checkbox-active';
	else:
        $active_class = 'disable';
		$status_class = 'js-checkbox-inactive';
	endif;
?>
<tr class="<?php echo $class.' '.$active_class;?>">
		<td class="dc"><?php echo $this->Form->input('Amenity.'.$amenity['Amenity']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$amenity['Amenity']['id'], 'label' => "", 'div' => 'top-space', 'class' => $status_class.' js-checkbox-list')); ?></td>
		<td class="dc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			
					<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'edit', $amenity['Amenity']['id']), array('escape' => false,'class' => 'delete', 'title' => __l('Edit')));?></li>
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $amenity['Amenity']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
			   </ul>
							 </span>
                            </td>
		<td class="dc"><?php echo $this->Html->cDateTime($amenity['Amenity']['created']);?></td>
		<td class="dl"><?php echo $this->Html->cText($amenity['Amenity']['name']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7"<div class="space dc grayc"><p class="ver-mspace top-space text-16 ">><?php echo __l('No Amenities available');?></p></div></td>
	</tr>
<?php
endif;
?>
</table>
<?php
if (!empty($amenities)):
?> <div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
                        <?php echo __l('Select:'); ?></span>
                        <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
						<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
						<?php if(!isset($this->request->params['named']['filter_id'])) {?>
						<?php echo $this->Html->link(__l('Enable'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"} hor-smspace grayc', 'title' => __l('Enable'))); ?>
						<?php echo $this->Html->link(__l('Disable'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"} hor-smspace grayc', 'title' => __l('Disable'))); ?>
						<?php } ?>
             </div><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit js-no-pjax span5', 'div'=>false,'label' => false, 'empty' => __l('-- More actions --'))); ?></span>
            <?php endif; ?>
         </div>
          <div class="js-pagination pagination pull-right no-mar mob-clr dc">
            <?php echo $this->element('paging_links'); ?>
        </div>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
        <?php
    echo $this->Form->end();
    ?>
</div>