<?php /* SVN: $Id: $ */ ?>
<div class="properties index js-response">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active"><?php echo __l('Properties'); ?></li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
                <div class="clearfix">
				<?php 
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Disapproved) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Waiting For Approval').'">'.__l('Waiting For Approval').'</dt>
						<dd title="'.$this->Html->cInt($waiting_for_approval ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($waiting_for_approval ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::Disapproved), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Active) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Enabled').'">'.__l('Enabled').'</dt>
						<dd title="'.$this->Html->cInt($active_properties ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($active_properties ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::Active), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Inactive) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Disabled').'">'.__l('Disabled').'</dt>
						<dd title="'.$this->Html->cInt($inactive_properties ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($inactive_properties ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Suspend) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Admin Suspended').'">'.__l('Admin Suspended').'</dt>
						<dd title="'.$this->Html->cInt($suspended_properties ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($suspended_properties ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::Suspend), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Flagged) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('System flagged').'">'.__l('System flagged').'</dt>
						<dd title="'.$this->Html->cInt($system_flagged ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($system_flagged ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::Flagged), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				
				$class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 			'user-flag') ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('User Flaged').'">'.__l('User Flaged').'</dt>
						<dd title="'.$this->Html->cInt($user_flagged ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($user_flagged ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'properties','action'=>'index','type' => 'user-flag'), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Featured) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Featured').'">'.__l('Featured').'</dt>
						<dd title="'.$this->Html->cInt($featured ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($featured ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::Featured), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::HomePage) ? 'active' : null;
				/*echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Home Page').'">'.__l('Home Page').'</dt>
						<dd title="'.$this->Html->cInt($home ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($home ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::HomePage), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur')); */
				
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Verified) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Verified').'">'.__l('Verified').'</dt>
						<dd title="'.$this->Html->cInt($verified ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($verified ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::Verified), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::WaitingForVerification) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Waiting For Verification').'">'.__l('Waiting For Verification').'</dt>
						<dd title="'.$this->Html->cInt($waiting_for_verification ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($waiting_for_verification ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::WaitingForVerification), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Imported) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Imported').'">'.__l('Imported').'</dt>
						<dd title="'.$this->Html->cInt($imported_from_airbnb_count ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($imported_from_airbnb_count ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::Imported), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
					
				$class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'total') ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Total').'">'.__l('Total').'</dt>
						<dd title="'.$this->Html->cInt($total_properties ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($total_properties ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'properties','action'=>'index','type' => 'total'), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				
				?>
              </div>
			  <div class="clearfix dc">
					<?php echo $this->Form->create('Property', array('type' => 'get', 'class' => 'form-search bot-mspace big-input span', 'action'=>'index')); ?>
					<?php echo $this->Form->input('q', array('placeholder' => __l('Keyword'),'class'=>'span9 ver-mspace text-16','label' => false)); ?>
					<?php echo $this->Form->submit(__l('Search'), array('class'=>'btn btn-large hor-mspace btn-primary textb text-16'));?>
					<?php echo $this->Form->end(); ?>
					
			</div>
		<?php echo $this->element('paging_counter'); ?>
     <div class="ver-space">
        <div id="active-users" class="tab-pane active in no-mar">
    <?php echo $this->Form->create('Property' , array('class' => 'normal','action' => 'update')); ?>
   <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
    <div class="overflow-block">
    <?php
    	$view_count_url = Router::url(array(
    		'controller' => 'properties',
    		'action' => 'update_view_count',
    	), true);
    ?>
	<table id="js-expand-table"  class="table list no-round js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}" >
	<thead>
	<tr class=" well no-mar no-pad js-even">
		<th class="dc graydarkc sep-right" rowspan="2"><?php echo __l('Select');?></th>
        <th class="dl graydarkc sep-right" rowspan="2"><div class="js-pagination span6"><?php echo $this->Paginator->sort('title',__l('Title'));?></div></th>
        <th class="dl graydarkc sep-right" rowspan="2"><div class="js-pagination span6"><?php echo $this->Paginator->sort('address',__l('Address'));?></div></th>
        <th class="dl graydarkc sep-right" rowspan="2"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username',__l('Host'));?></div></th>	
		<th class="dc graydarkc sep-right sep-bot" colspan="3"><?php echo  __l('Bookings');  ?></th>
		<th class="dr graydarkc sep-right" rowspan="2"><div class="js-pagination"><?php echo $this->Paginator->sort( 'revenue',__l('Revenue') . ' (' . Configure::read('site.currency') . ')');?></div></th>
		<th rowspan="2" class="dc graydarkc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'is_approved',__l('Approved?')); ?></div></th>
    </tr>
	<tr class="js-even well no-mar no-pad">
		<th class="dc graydarkc sep-right"><?php echo  __l('Waiting for Acceptance'); ?></th>
		<th class="dc graydarkc sep-right"><?php echo  __l('Pipeline'); ?></th>
		<th class="dc graydarkc sep-right"><?php echo  __l('Successful'); ?></th>
	</tr>
	</thead>
	<tbody>


<?php
if (!empty($properties)):

$i = 0;
foreach ($properties as $property):
	$class = null;
	$active_class = '';
	if ($i++ % 2 == 0):
		$class = 'altrow';
	endif;
	if ($property['Property']['is_active']):
		$status_class = 'js-checkbox-active';
	else:
	    $active_class = 'disable';
		$status_class = 'js-checkbox-inactive';
	endif;
	if ($property['Property']['is_approved']):
		$status_class = 'js-checkbox-active';
	else:
	    $active_class = 'disable';
		$status_class = 'js-checkbox-inactive';
	endif;
	if($property['Property']['is_featured']):
		$status_class.= ' js-checkbox-featured';
	else:
		$status_class.= ' js-checkbox-notfeatured';
	endif;
	if($property['Property']['is_show_in_home_page']):
		$status_class.= ' js-checkbox-homepage';
	else:
		$status_class.= ' js-checkbox-nothomepage';
	endif;
	if($property['Property']['is_verified']):
		$status_class.= ' js-checkbox-verified';
	else:
		$status_class.= ' js-checkbox-notverified';
	endif;
	if($property['Property']['admin_suspend']):
		$status_class.= ' js-checkbox-suspended';
	else:
		$status_class.= ' js-checkbox-unsuspended';
	endif;
	if($property['Property']['is_system_flagged']):
		$status_class.= ' js-checkbox-flagged';
	else:
		$status_class.= ' js-checkbox-unflagged';
	endif;
	if(!empty($property['PropertyFlag'])):
		$status_class.= ' js-checkbox-user-reported';
	else:
		$status_class.= ' js-checkbox-unreported';
	endif;
	if($property['User']['is_active']):
		$status_class.= ' js-checkbox-activeusers';
	else:
		$status_class.= ' js-checkbox-deactiveusers';
	endif;
 

?>
	  <tr class="<?php echo $class.' '.$active_class;?> expand-row js-odd">
	    <td class="<?php echo $class;?> select">
           <?php echo $this->Form->input('Property.'.$property['Property']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$property['Property']['id'], 'label' => "", 'div' => 'top-space', 'before' => '<span class="show pull-left hor-smspace"><i class="icon-caret-down"></i></span>', 'class' => $status_class.' js-checkbox-list')); ?></td>
        <td class="dl">
		<div class="pull-left admin-avatar hor-smspace">
           <?php
					$property['Attachment'][0] = !empty($property['Attachment'][0]) ? $property['Attachment'][0] : array();
					echo $this->Html->link($this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'],  'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false));
				?>
				</div>
				<div class="htruncate js-bootstrap-tooltip span4" title="<?php echo $this->Html->cText($property['Property']['title'],false);?>"><?php echo $this->Html->cText($property['Property']['title'],false);?></div>
           
                <?php
				if($property['Property']['admin_suspend']): ?>
				<div class="clearfix">
					<span class="label suspended" title="<?php echo __l('Admin Suspended'); ?>"><?php echo __l('Admin Suspended'); ?></span>
				</div>
				<?php	
				endif;
				if($property['Property']['is_system_flagged']): ?>
				<div class="clearfix">
					<span class="label label-warning " title="<?php echo __l('System Flagged'); ?>"><?php echo __l('System Flagged'); ?></span>
				</div>
				<?php	
				endif;?>
				<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == 2):?>
				<div class="property-status-info">
					<span class="Waiting-for-verify round-3" title="<?php echo __l('Waiting for verify'); ?>"><?php echo __l('Waiting for verify'); ?></span>
				</div>
				<?php endif;?>
				<?php 		
				if($property['Property']['is_featured']==1): ?>
				<div class="property-status-info">
					<span class="featured round-3" title="<?php echo __l('Featured'); ?>"><?php echo __l('Featured'); ?></span>
				</div>
				<?php
				endif;
				/*if($property['Property']['is_show_in_home_page']==1): ?>
				<div class="property-status-info">
					<span class="homepage round-3" title="<?php echo __l('Home Page'); ?>"><?php echo __l('Home Page'); ?></span>
				</div>
				<?php	 
				endif; */
				if (Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == 1): ?>
				<div class="property-status-info">
					<span class="verified round-3" title="<?php echo __l('Verified'); ?>"><?php echo __l('Verified'); ?></span>
				</div>
				<?php 	
				endif; 
			?>
			 
			<?php $user_flagged_count = count($property['PropertyFlag']);
						if($user_flagged_count >0){?>
							<div class ="user-flagged ">
								<?php echo $this->Html->link(__l('User Flagged') . ' (' . $user_flagged_count . ')', array('controller'=> 'property_flags', 'action' => 'index', 'property'=>$property['Property']['slug'], 'admin' => true), array('escape' => false,'class'=>'label label-important user-flagged','title'=>__l('User Flagged') . ' (' . $user_flagged_count . ')'));?>
							</div>
						<?php } ?> 
            </td>
		<td class="dl"><?php if(!empty($property['Country']['iso_alpha2'])): ?>
									<span class="flags flag-<?php echo strtolower($property['Country']['iso_alpha2']); ?>" title ="<?php echo $property['Country']['name']; ?>"><?php echo $property['Country']['name']; ?></span>
							<?php endif; ?>
							<div class="htruncate js-bootstrap-tooltip span4" title="<?php echo $property['Property']['address'];?>"><?php echo $this->Html->cText($property['Property']['address']);?></div>

        </td>
		<td class="dl"><?php echo $this->Html->cText($property['User']['username']);?></td>
		<td class="dc"><?php echo $this->Html->cInt($property['Property']['sales_pending_count']);?></td>
		<td class="dc"><?php echo $this->Html->cInt($property['Property']['sales_pipeline_count']);?></td>
		<td class="dc"><?php echo $this->Html->cInt($property['Property']['sales_cleared_count']);?></td>
		<td class="dr site-amount"><?php echo $this->Html->cCurrency($property['Property']['revenue']);?></td>
		<td class="dc"><?php echo $this->Html->cBool($property['Property']['is_approved']);?></td>
		
    </tr>
                      <tr class="hide sep-bot sep-medium">
                        <td colspan="9"><div class="top-space clearfix">
                            <div class="clearfix activities-block">
                              <div class="pull-right dropdown"> <a data-toggle="dropdown" class="dropdown-toggle btn btn-large text-14 textb graylighterc no-shad" title="Edit" href="#"><i class="icon-cog graydarkc  no-pad text-16"></i> <span class="caret"></span></a>
                                <ul class="dropdown-menu arrow arrow-right">
			<?php if(empty($property['Property']['is_deleted'])):?>
				<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'edit', $property['Property']['id']), array('escape' => false,'class' => 'graydarkc edit js-edit', 'title' => __l('Edit')));?></li>
				<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $property['Property']['id']), array('escape' => false,'class' => 'graydarkc delete js-delete', 'title' => __l('Disappear property from user side')));?></li>

					<?php if($property['Property']['admin_suspend']) { 
						if($property['User']['is_active']) { ?>
						<li>	<?php echo $this->Html->link('<i class="icon-remove-sign"></i>'.__l('Deactivate User'), array('controller' => 'users', 'action' => 'admin_update_status', $property['User']['id'], 'status' => 'deactivate'), array('escape' => false,'class' => 'graydarkc js-admin-update-property deactive-user', 'title' => __l('Deactivate user')));?>
					</li>
					<?php } else { ?>
							<li><?php echo $this->Html->link('<i class="icon-ok-sign"></i>'.__l('Activate User'), array('controller' => 'users', 'action' => 'admin_update_status', $property['User']['id'], 'status' => 'activate'), array('escape' => false,'class' => 'graydarkc js-admin-update-property active-user', 'title' => __l('Activate user')));?>
							</li>
					<?php } 
						}  ?>

				<?php if($property['Property']['is_featured']):?>
					<li>	<?php echo $this->Html->link('<i class="icon-remove-circle"></i>'.__l('Not Featured'), array('action' => 'admin_update_status', $property['Property']['id'], 'featured' => 'deactivate'), array('escape' => false,'class' => 'graydarkc js-admin-update-property js-unfeatured not-featured', 'title' => __l('Not Featured')));?>
					</li>
				<?php else:?>
					<li>	<?php echo $this->Html->link('<i class="icon-map-marker"></i>'.__l('Featured'), array('action' => 'admin_update_status', $property['Property']['id'], 'featured' => 'activate'), array('escape' => false,'class' => 'graydarkc js-admin-update-property js-featured featured', 'title' => __l('Featured')));?>
					</li>
				<?php endif;?>

					<?php if($property['Property']['is_system_flagged']):?>
						<li>	<?php echo $this->Html->link('<i class="icon-remove-circle"></i>'.__l('Clear system flag'), array('action' => 'admin_update_status', $property['Property']['id'], 'flag' => 'deactivate'), array('escape' => false,'class' => 'graydarkc js-admin-update-property js-unflag clear-flag', 'title' => __l('Clear system flag')));?>
						</li>
					<?php else:?>
						<li>	<?php echo $this->Html->link('<i class="icon-flag"></i>'.__l('Flag'), array('action' => 'admin_update_status', $property['Property']['id'], 'flag' => 'active'), array('escape' => false,'class' => 'graydarkc js-admin-update-property js-flag flag', 'title' => __l('Flag')));?>
						</li>
					<?php endif;?><?php if($property['Property']['is_user_flagged']):?>
						<li>	<?php echo $this->Html->link('<i class="icon-flag"></i>'.__l('Clear user flag'), array('action' => 'admin_update_status', $property['Property']['id'], 'user_flag' => 'deactivate'), array('escape' => false,'class' => 'graydarkc js-admin-update-property js-unflag clear-flag', 'title' => __l('Clear user flag')));?>
						</li>
					<?php endif;?>
					<?php if($property['Property']['admin_suspend']):?>
							<li><?php echo $this->Html->link('<i class="icon-repeat"></i>'.__l('Unsuspend'), array('action' => 'admin_update_status', $property['Property']['id'], 'flag' => 'unsuspend'), array('escape' => false,'class' => 'graydarkc js-admin-update-property  js-unsuspend unsuspend', 'title' => __l('Unsuspend')));?>
						</li>
					<?php else:?>
						<li>	<?php echo $this->Html->link('<i class="icon-off"></i>'.__l('Suspend'), array('action' => 'admin_update_status', $property['Property']['id'], 'flag' => 'suspend'), array('escape' => false,'class' => 'graydarkc js-admin-update-property js-suspend suspend', 'title' => __l('Suspend')));?>
					</li>
					<?php endif;?>
				<?php else:?>
					<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Permanent Delete'), array('action' => 'delete', $property['Property']['id']), array('escape' => false,'class' => 'graydarkc delete js-delete', 'title' => __l('Permanent Delete')));?>
                    </li>

				<?php endif; ?>
				<li><?php echo $this->Html->link((($property['Property']['is_approved']) ? '<i class="icon-thumbs-down"></i>'.__l('Disapprove') : '<i class="icon-thumbs-up"></i>'.__l('Approve')), array('action' => 'admin_update_status',  $property['Property']['id'], 'status' => (($property['Property']['is_approved']) ? 'disapproved' : 'approved')), array('title' => (($property['Property']['is_approved']) ? __l('Disapprove') : __l('Approve')), 'class' => (( $property['Property']['is_approved']) ? 'graydarkc js-admin-update-property js-pending pending' : 'graydarkc js-admin-update-property js-approve approve'), 'escape' => false)); ?></li>
				<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == 2):?>
					<li><?php echo $this->Html->link(__l('Waiting for verify'), array('action' => 'admin_update_status', $property['Property']['id'], 'verify' => 'active'), array('escape' => false,'class' => 'js-confirm js-no-pjax graydarkc js-admin-update-property  unsuspend', 'title' => __l('Waiting for verify')));?></li>
				<?php elseif(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == 1):?>
					<li><?php echo $this->Html->link('<i class="icon-ok"></i>'.__l('Clear verify'), array('action' => 'admin_update_status', $property['Property']['id'], 'verify' => 'deactivate'), array('escape' => false,'class' => 'graydarkc js-admin-update-property clear', 'title' => __l('Clear verify')));?></li>
				<?php endif;?>
				<?php if(empty($property['Property']['admin_suspend']) && !empty($property['Property']['is_active']) && !empty($property['Property']['is_paid']) && !empty($property['Property']['is_approved'])) {?>
					<?php /* if($property['Property']['is_show_in_home_page']):?>
					<li>	<?php echo $this->Html->link(__l('Hide in home page'), array('action' => 'admin_update_status', $property['Property']['id'], 'show' => 'deactivate'), array('escape' => false,'class' => 'graydarkc js-admin-update-property hide-home-page', 'title' => __l('Hide in home page')));?>
					</li>
				<?php else:?>
					<li>	<?php echo $this->Html->link('<i class="icon-plus-sign"></i>'.__l('Show in home page'), array('action' => 'admin_update_status', $property['Property']['id'], 'show' => 'activate'), array('escape' => false,'class' => 'graydarkc js-admin-update-property show-home-page', 'title' => __l('Show in home page')));?>
					</li>
				<?php endif; */?>
				<?php } ?>								
                                </ul>
                              </div>
                              <ul id="myTab3" class="nav nav-tabs top-smspace">
                                <li class="active"><a href="#As-Price-<?php echo $property['Property']['id']; ?>" data-toggle="tab"><?php echo __l('Overview');?></a> </li>                                
                              </ul>
                              <div class="sep-right sep-left sep-bot tab-round tab-content" id="myTabContent3">
                                <div class="tab-pane space active" id="As-Price-<?php echo $property['Property']['id']; ?>">
                                  <div class="row no-mar">
                                    <div class="pull-left">
                                      <div class="span8">
                                        <h3 class="well space textb text-16 no-mar"><?php echo __l('Price'); ?></h3>
                                        <div class="clearfix ver-space bot-mspace">
										<dl class="list">
											<dt class="pr hor-mspace text-11"><?php echo __l('Per Night'); ?></dt>
											<dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']);?></dd>										
                                        </dl>
                                        <dl class=" sep-left list">
											<dt class="pr hor-mspace text-11"><?php echo __l('Per Week'); ?></dt>
											<dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_week']);?></dd>
                                        </dl>
										</div>
										<div class="clearfix ver-space bot-mspace">
                                        <dl class="sep-right list">
											<dt class="pr hor-mspace text-11"><?php echo __l('Per Month'); ?></dt>
											<dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_month']);?></dd>
                                        </dl>
                                        <dl class="list">
											<dt class="pr hor-mspace text-11"><?php echo __l('Additional Guest'); ?></dt>
											<dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($property['Property']['additional_guest_price']);?>
						<?php if($property['Property']['additional_guest_price']) :?>
							<span title="<?php echo __l('per night for each guest after') . " " . $property['Property']['additional_guest']; ?>" class="additional-guest-info"> [<?php echo  $property['Property']['additional_guest']; ?>]</span>
						<?php endif; ?></dd>                                        
                                        </dl>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="pull-right">
                                      <div class="span7">
                                        <h3 class="well space textb text-16 no-mar"><?php echo __l('Booking'); ?> </h3>
                                        <div class="clearfix ver-space bot-mspace">
                                        <dl class="sep-right list">
											<dt class="pr hor-mspace text-11"><?php echo __l('Waiting for Acceptance'); ?></dt>
											<dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->cInt($property['Property']['sales_pending_count']);?></dd>										
                                        </dl>
                                        <dl class="list">
											<dt class="pr hor-mspace text-11"><?php echo __l('Pipeline'); ?></dt>
											<dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->cInt($property['Property']['sales_pipeline_count']);?></dd>
                                        </dl>
										 </div>
										 <div class="clearfix ver-space bot-mspace">
                                        <dl class="sep-right list">
											<dt class="pr hor-mspace text-11"><?php echo __l('Lost'); ?></dt>
											<dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->cInt($property['Property']['sales_lost_count']);?></dd>
                                        </dl>
                                        <dl class="list">
											<dt class="pr hor-mspace text-11"><?php echo __l('Lost'); ?></dt>
											<dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($property['Property']['sales_cleared_count']);?></dd>                                        
                                        </dl>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row no-mar top-space">
                                    <div class="pull-left">
                                      <div class="span8">
                                        <h3 class="well space textb text-16 no-mar"><?php echo __l('Revenue'); ?></h3>
                                        <div class="clearfix ver-space bot-mspace">
                                        <dl class="sep-right list">
											<dt class="pr hor-mspace text-11"><?php echo __l('Cleared'); ?></dt>
											<dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($property['Property']['sales_cleared_amount']);?></dd>
                                        </dl>
                                        <dl class="sep-right list">
											<dt class="pr hor-mspace text-11"><?php echo __l('Lost'); ?></dt>
											<dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($property['Property']['sales_lost_amount']);?></dd>
                                        </dl>
                                        <dl class="list">
											<dt class="pr hor-mspace text-11"><?php echo __l('Pipeline'); ?></dt>
											<dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($property['Property']['sales_pipeline_amount']);?></dd>                                        
                                        </dl>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="pull-right">
                                      <div class="span7">
                                        <h3 class="well space textb text-16 no-mar"><?php echo __l('Reviews'); ?> </h3>
                                        <div class="clearfix ver-space bot-mspace">
										<dl class="list">
											<dt class="pr hor-mspace text-11" title ="<?php echo __l('Positive');?>"><?php echo __l('Positive');?></dt>
												<dd class="textb text-16 graydarkc pr hor-mspace">
												<?php echo numbers_to_higher($property['Property']['positive_feedback_count']); ?>
												</dd>
										</dl>
										<dl class=" list">
											<dt class="pr hor-mspace text-11" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
												<dd  class="textb text-16 graydarkc pr hor-mspace">
												<?php echo numbers_to_higher($property['Property']['property_feedback_count'] - $property['Property']['positive_feedback_count']); ?>
												</dd>
										</dl>
										<dl class="list">
											<dt class="pr hor-mspace text-11" title ="<?php echo __l('Success Rate');?>"><?php echo __l('Success Rate');?></dt>
												<?php if(empty($property['Property']['property_feedback_count'])): ?>
													<dd class="textb text-16 graydarkc pr hor-mspace" title="<?php  echo __l('No Bookings available'); ?>"><?php  echo __l('n/a'); ?></dd>
												<?php else:?>
													<dd class="textb text-16 graydarkc pr hor-mspace">
													<?php
														if(!empty($property['Property']['positive_feedback_count'])):
															$positive = floor(($property['Property']['positive_feedback_count']/$property['Property']['property_feedback_count']) *100);
															$negative = 100 - $positive;
														else:
															$positive = 0;
															$negative = 100;
														endif;
														echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=8DCA35|F47564&amp;chf=bg,s,FFFFFF00', array('width'=>'50px','height'=>'50px','title' => $positive.'%'));
													?>
													</dd>
												<?php endif; ?>
										</dl>	
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>							  

                              </div>
                            </div>
                            <div class="clearfix details-block no-mar pull-right">
                              <div class="thumb pull-left hor-space bot-mspace">
							  <?php echo $this->Html->link($this->Html->showImage('Property', (!empty($property['Attachment'][0]) ? $property['Attachment'][0] : ''), array('dimension' => 'small_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'class' => 'img-polaroid', 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false, 'class' => 'show'));?>
							  </div>
                              <div class="pull-left hor-space ver-mspace span-24 "> 
							  <?php echo $this->Html->link($this->Html->cText($property['Property']['title'],false), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false, 'class' => 'span6 htruncate graydarkc text-24 textb mob-text-24  bot-mspace show'));?>
							 
								<dl class="no-mar clearfix">		  
									<dt class="pull-left textn no-mar"><?php echo __l('Added 0n')?>  </dt>
									<dd class="pull-left hor-space graydarkc textb"><?php echo $this->Html->cDateTimeHighlight($property['Property']['created']); ?> </dd>
								</dl>
								<dl class="no-mar clearfix">
									<dt class="pull-left textn no-mar"><?php echo __l('Views'); ?> </dt>
									<dd class="pull-left hor-space graydarkc textb"><?php echo $this->Html->cInt($property['Property']['property_view_count']);?></dd>
								</dl>
								<dl class="no-mar clearfix">
									<?php if(isPluginEnabled('PropertyFavorites')) : ?>
									<dt class="pull-left textn no-mar"><?php echo __l('Favorites');?></dt>
									<dd class="pull-left hor-space graydarkc textb"><?php echo $this->Html->cInt($property['Property']['property_favorite_count']);?></dd>
									<?php endif;?>
								</dl>
								<dl class="no-mar clearfix">
								<?php if(isPluginEnabled('PrpertyFlags')) : ?>
								<dt class="pull-left textn no-mar"><?php echo __l('Flags');?></dt>
								<dd class="pull-left hor-space graydarkc textb"><?php echo $this->Html->cInt($property['Property']['property_flag_count']);?></dd>				
								<?php endif;?>
								</dl>
								<dl class="no-mar clearfix">
								<dt class="pull-left textn no-mar"><?php echo __l('IP');?></dt>
								<dd class="pull-left hor-space graydarkc textb">
								<?php if(!empty($property['Ip']['ip'])): ?>
											<?php echo  $this->Html->link($property['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $property['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$property['Ip']['host'], 'escape' => false));
											?>
											<p>
											<?php
											if(!empty($property['Ip']['Country'])):
												?>
												<span class="flags flag-<?php echo strtolower($property['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $property['Ip']['Country']['name']; ?>">
													<?php echo $property['Ip']['Country']['name']; ?>
												</span>
												<?php
											endif;
											 if(!empty($property['Ip']['City'])):
											?>
											<span> 	<?php echo $property['Ip']['City']['name']; ?>    </span>
											<?php endif; ?>
											</p>
										<?php else: ?>
											<?php echo __l('N/A'); ?>
										<?php endif; ?>
								</dd>
								</dl>
								<dl class="no-mar clearfix">
									<dt class="pull-left textn no-mar"><?php echo __l('Listing Fee Paid'); ?></dt>
									<dd class="pull-left hor-space graydarkc textb"><?php if($property['Property']['is_paid']) { echo __l('Yes'); } else { echo __l('No');}?></dd>							  
								</dl>		  

                              </div>
                            </div>
                          </div></td>
                      </tr>
<?php
    endforeach;
 
else:
?>
	<tr class="js-odd">
		<td colspan="51"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Properties available');?></p></div></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
</div>
<?php
if (!empty($properties)) :
        ?>
       <div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
            <?php echo __l('Select:'); ?></span>
			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
			<?php echo $this->Html->link(__l('Disabled by user'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-deactiveusers","unchecked":"js-checkbox-activeusers"} hor-smspace grayc', 'title' => __l('Disabled by user'))); ?>
			<?php echo $this->Html->link(__l('Admin Suspended'), '#', array('class' => 'js-select js-no-pjax	{"checked":"js-checkbox-suspended","unchecked":"js-checkbox-unsuspended"} hor-smspace grayc', 'title' => __l('Admin Suspended'))); ?>
			<?php echo $this->Html->link(__l('Featured'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-featured","unchecked":"js-checkbox-notfeatured"} hor-smspace grayc', 'title' => __l('Featured'))); ?>
			<?php //echo $this->Html->link(__l('HomePage'), '#', array('class' => 'js-admin-select-homepage hor-smspace grayc', 'title' => __l('HomePage'))); ?>
			<?php
				if (Configure::read('property.is_property_verification_enabled')):
					echo $this->Html->link(__l('Verified'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-verified","unchecked":"js-checkbox-notverified"} hor-smspace grayc', 'title' => __l('Verified'))); 
				endif; 
			?>
			<?php echo $this->Html->link(__l('Flagged'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-flagged","unchecked":"js-checkbox-unflagged"} hor-smspace grayc', 'title' => __l('Flagged'))); ?>
			<?php echo $this->Html->link(__l('Unflagged'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-unflagged","unchecked":"js-checkbox-flagged"} hor-smspace grayc', 'title' => __l('Unflagged'))); ?>
		 </div>
			<?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit js-no-pjax span5', 'label' => false, 'div'=>false, 'empty' => __l('-- More actions --'))); ?>
			
       
        </div>
          <div class="js-pagination pagination pull-right no-mar mob-clr dc">
            <?php echo $this->element('paging_links'); ?>
        </div>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
</div>
</div>
</div>