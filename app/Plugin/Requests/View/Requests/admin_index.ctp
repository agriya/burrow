<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="requests index js-response">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active"><?php echo __l('Requests'); ?></li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
                <div class="clearfix">
				<?php 
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Active) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Enabled').'">'.__l('Enabled').'</dt>
						<dd title="'.$this->Html->cInt($active_requests ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($active_requests ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'requests','action'=>'index','filter_id' => ConstMoreAction::Active), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
					$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Suspend) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Admin Suspended').'">'.__l('Admin Suspended').'</dt>
						<dd title="'.$this->Html->cInt($suspended_requests ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($suspended_requests ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'requests','action'=>'index','filter_id' => ConstMoreAction::Suspend), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Inactive) ? 'active' : null;
				
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Disabled').'">'.__l('Disabled').'</dt>
						<dd title="'.$this->Html->cInt($user_suspended_requests ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($user_suspended_requests ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'requests','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				if(isPluginEnabled("RequestFlags"))
				{
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Flagged) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('System flagged').'">'.__l('System flagged').'</dt>
						<dd title="'.$this->Html->cInt($system_flagged ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($system_flagged ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'requests','action'=>'index','filter_id' => ConstMoreAction::Flagged), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				}
				$class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 			'user-flag') ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('User Flaged').'">'.__l('User Flaged').'</dt>
						<dd title="'.$this->Html->cInt($user_flagged ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($user_flagged ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'requests','action'=>'index','type' => 'user-flag'), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				
				$class = (empty($this->request->params['named']['filter_id'])) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Total Users').'">'.__l('Total Users').'</dt>
						<dd title="'.$this->Html->cInt($total_requests ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($total_requests,false).'</dd>                  	
					</dl>'
					, array('controller'=>'requests','action'=>'index'), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				
				?>
              </div>
			  
		<div class="clearfix dc">
					<?php echo $this->Form->create('Request', array('type' => 'get', 'class' => 'form-search bot-mspace big-input span', 'action'=>'index')); ?>
					<?php echo $this->Form->input('q', array('placeholder' => __l('Keyword'),'class'=>'span9 ver-mspace text-16','label' => false)); ?>
					<?php echo $this->Form->submit(__l('Search'), array('class'=>'btn btn-large hor-mspace btn-primary textb text-16'));?>
					<?php echo $this->Form->end(); ?>
					
			</div>
		<?php echo $this->element('paging_counter'); ?>
   
<?php echo $this->Form->create('Request' , array('class' => 'normal','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<?php
	$view_count_url = Router::url(array(
		'controller' => 'requests',
		'action' => 'update_view_count',
	), true);
?>
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
<table class="table list no-round" id="js-expand-table">
	<thead>
	<tr class=" well no-mar no-pad js-even">

		<th class="dc graydarkc sep-right span2"><?php echo __l('Select'); ?></th>
		<th class="dl graydarkc sep-right"><?php echo $this->Paginator->sort( 'name',__l('Name')); ?></th>
		<th class="dl graydarkc sep-right"><?php echo $this->Paginator->sort( 'address',__l('Address')); ?></th>
		<th class="dl graydarkc sep-right"><?php echo $this->Paginator->sort( 'User.username',__l('Username'));?></th>
	   	<th class="dc graydarkc sep-right"><?php echo $this->Paginator->sort( 'property_count',__l('Offered')); ?></th>
        <th class="dc graydarkc sep-right"><?php echo $this->Paginator->sort( 'is_approved',__l('Approved?')); ?></th>
	</tr>
<?php
if (!empty($requests)):

$i = 0;
foreach ($requests as $request):
	$class = null;
	$active_class = '';
	if ($i++ % 2 == 0):
		 $class = 'altrow';
	endif;

	if($request['Request']['is_active']):
		$status_class = 'js-checkbox-active';
	else:
		$active_class = 'disable';
       	$status_class = 'js-checkbox-inactive';
	endif;
	if($request['Request']['admin_suspend']):
		$status_class.= ' js-checkbox-suspended';
	else:
		$status_class.= ' js-checkbox-unsuspended';
	endif;
	if($request['Request']['is_system_flagged']):
		$status_class.= ' js-checkbox-flagged';
	else:
		$status_class.= ' js-checkbox-unflagged';
	endif;
	if(!empty($Request['RequestFlag'])):
		$status_class.= ' js-checkbox-user-reported';
	else:
		$status_class.= ' js-checkbox-unreported';
	endif;
	if($request['User']['is_active']):
		$status_class.= ' js-checkbox-activeusers';
	else:
		$status_class.= ' js-checkbox-deactiveusers';
	endif;
	if ($request['Request']['is_approved']):
		$status_class = 'js-checkbox-approved';
		$style_class = 'pending';
	else:
		$style_class = 'approve';
		$active_class = 'disable';
		$status_class = 'js-checkbox-disapproved';
	endif;
?><tbody>
	 <tr class="<?php echo $class.' '.$active_class;?> expand-row js-odd">
		<td class="<?php echo $class;?> select dc"><div class="arrow"></div><?php echo $this->Form->input('Request.'.$request['Request']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$request['Request']['id'], 'label' => "", 'div' => 'top-space', 'before' => '<span class="show pull-left hor-smspace"><i class="icon-caret-down"></i></span>', 'class' => $status_class.' js-checkbox-list')); ?></td>
		
		<td class="dl">
			<?php echo $this->Html->link($this->Html->cText($request['Request']['title'], false), array('controller' => 'requests', 'action' => 'view', $request['Request']['slug'], 'admin' => false), array('title' => $this->Html->cText($request['Request']['title'], false),'escape' => false, 'class' => 'graydarkc htruncate js-bootstrap-tooltip span5'));?>
             <?php
				if (empty($request['Request']['is_active'])):
					echo '<span title="disabled" class="label disabled">'.__l('Disabled').'</span>';
				endif; ?>		
			<?php 
				if ($request['Request']['admin_suspend']):
					echo '<span title="Admin Suspended" class="label adminsuspended">'.__l('Admin Suspended').'</span>';
				endif;
				if ($request['Request']['is_system_flagged']):
					echo '<span  title="System Flagged" class="label label-warning">'.__l('System Flagged').'</span>';
				endif; 
				
			?>
			<?php $user_flagged_count = count($request['RequestFlag']);
						if($user_flagged_count >0){?>
							<div class ="user-flagged">
								<?php echo $this->Html->link('<span class="label label-important">' . __l('User Flagged') . ' (' . $user_flagged_count . ') </span>', array('controller'=> 'request_flags', 'action' => 'index', 'request'=>$request['Request']['slug'], 'admin' => true), array('escape' => false,'class'=>'round-3','title'=>__l('User Flagged') . ' (' . $user_flagged_count . ')'));?>
							</div>
						<?php } ?>
		</td>
		<td class="dl"><?php if(!empty($request['Country']['iso_alpha2'])): ?>
									<span class="flags flag-<?php echo strtolower($request['Country']['iso_alpha2']); ?>" title ="<?php echo $request['Country']['name']; ?>"><?php echo $request['Country']['name']; ?></span>
							<?php endif; ?>
							<div class="htruncate js-bootstrap-tooltip span5" title="<?php echo $this->Html->cText($request['Request']['address'],false);?>"><?php echo $this->Html->cText($request['Request']['address'],false);?></div>
							
        </td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($request['User']['username']), array('controller'=> 'users', 'action'=>'view', $request['User']['username'], 'admin' => false), array('escape' => false));?></td>
		<td class="dc"><?php echo $this->Html->cInt($request['Request']['property_count']);?></td>
       	<td class="dc"><?php echo $this->Html->cText(($request['Request']['is_approved']) ? __l('Approved') : __l('Waiting for approval'));?></td>
	</tr>
	<tr class="hide">
         <td colspan="14" class="action-block">
           <div class="top-space clearfix">
            <div class="pull-right dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle btn btn-large text-14 textb graylighterc no-shad" title="Edit" href="#"><i class="icon-cog graydarkc  no-pad text-16"></i> <span class="caret"></span></a>
                 <ul class="dropdown-menu arrow arrow-right">
		        <li>	<?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action'=>'delete', $request['Request']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?>
            </li>
           <li> <?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action'=>'edit', $request['Request']['id']), array('escape' => false,'class' => 'edit js-edit', 'title' => __l('Edit')));?>
                </li>
            <?php if($request['Request']['is_system_flagged']):?>

					<?php if($request['User']['is_active']):?>
						<li>	<?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Deactivate User'), array('controller' => 'users', 'action' => 'admin_update_status', $request['User']['id'], 'status' => 'deactivate'), array('escape' => false,'class' => 'js-confirm deactive-user', 'title' => __l('Deactivate user')));?>
					</li>
					<?php else:?>
							<li><?php echo $this->Html->link(__l('Activate User'), array('controller' => 'users', 'action' => 'admin_update_status', $request['User']['id'], 'status' => 'activate'), array('escape' => false,'class' => 'js-confirm active-user', 'title' => __l('Activate user')));?>
							</li>
					<?php endif;?>
             <?php endif;?>
             <?php if($request['Request']['is_system_flagged']):?>
						<li>	<?php echo $this->Html->link('<i class="icon-flag"></i>'.__l('Clear system flag'), array('action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'deactivate'), array('escape' => false,'class' => 'js-confirm clear-flag', 'title' => __l('Clear system flag')));?>
					<?php else: ?>
						</li>
						<li>	<?php echo $this->Html->link('<i class="icon-flag"></i>'.__l('Flag'), array('action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'active'), array('escape' => false,'class' => 'js-confirm flag', 'title' => __l('Flag')));?>
						</li>
			 <?php endif;?>
             <?php if($request['Request']['is_user_flagged']):?>
						<li>	<?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Clear user flag'), array('action' => 'admin_update_status', $request['Request']['id'], 'user_flag' => 'deactivate'), array('escape' => false,'class' => 'js-confirm clear-flag', 'title' => __l('Clear user flag')));?>
						</li>
			 <?php endif;?>
             <?php if($request['Request']['admin_suspend']):?>
							<li><?php echo $this->Html->link('<i class="icon-on"></i>'.__l('Unsuspend'), array('action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'unsuspend'), array('escape' => false,'class' => 'js-confirm  unsuspend', 'title' => __l('Unsuspend')));?>
						</li>
					<?php else:?>
						<li>	<?php echo $this->Html->link('<i class="icon-off"></i>'.__l('Suspend'), array('action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'suspend'), array('escape' => false,'class' => 'js-confirm suspend', 'title' => __l('Suspend')));?>
					</li>
			<?php endif;?>
		<li>	<?php echo $this->Html->link((($request['Request']['is_approved']) ? '<i class="icon-thumbs-down"></i>'.__l('Disapprove') : '<i class="icon-thumbs-up"></i>'.__l('Approve')), array('action' => 'admin_update_status',  $request['Request']['id'], 'status' => (($request['Request']['is_approved']) ? 'disapproved' : 'approved')), array('escape' => false,'class' => 'js-confirm ' . $style_class, 'title' => (( $request['Request']['is_approved']) ? __l('Disapprove') : __l('Approve')))); ?>
              </li> </ul>
                
            </div>
			<ul id="myTab3" class="nav nav-tabs top-smspace">
                 <li class="active"><a href="#As-Price-<?php echo $request['Request']['id']; ?>" data-toggle="tab"><?php echo __l('Overview');?></a> </li>                                
             </ul>
		<div class="sep-right sep-left sep-bot tab-round tab-content" id="myTabContent3">
		<div class="tab-pane space active" id="As-Price-<?php echo $request['Request']['id']; ?>">
			<div class="row no-mar">
				<div class="pull-left">
					<div class="span13 right-space">
						<h3 class="well space textb text-16 no-mar"><?php echo __l('Details'); ?></h3>
						<div class="clearfix ver-space bot-mspace">
							<dl class="list sep-right list">
								<dt class="pr hor-mspace text-11"><?php echo __l('Price'); ?></dt>
								<dd title="" class="textb text-16 graydarkc pr hor-mspace"><?php echo Configure::read('site.currency').$this->Html->cCurrency($request['Request']['price_per_night']);?></dd>
							</dl>
							<dl class="list sep-right list">
								<dt class="pr hor-mspace text-11"><?php echo __l('Check in'); ?></dt>
								<dd title="" class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->cDate($request['Request']['checkin']);?></dd>
							</dl>
							<dl class="list sep-right list">
								<dt class="pr hor-mspace text-11"><?php echo __l('Check out'); ?></dt>
								<dd title="" class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->cDate(getCheckoutDate($request['Request']['checkout']));?></dd>
							</dl>
							<dl class="list">
								<dt class="pr hor-mspace text-11"><?php echo __l('Accomodates'); ?></dt>
								<dd title="" class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->cInt($request['Request']['accommodates']);?></dd>
							</dl>
						</div>
					</div>
				</div>
				<div class="pull-left">
					<div class="span13 right-space">
						<h3 class="well space textb text-16 no-mar"><?php echo __l('Others'); ?></h3>
						<div class="clearfix ver-space bot-mspace">
							<dl class="list sep-right">
								<dt class="pr hor-mspace text-11"><?php echo __l('Posted On'); ?></dt>
								<dd title="" class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->cDateTimeHighlight($request['Request']['created']);?></dd>
							</dl>
							<dl class="list sep-right">
								<dt class="pr hor-mspace text-11"><?php echo __l('Offered'); ?></dt>
								<dd title="" class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->cInt($request['Request']['property_count']);?></dd>
							</dl>
							<dl class="list sep-right">
								<dt class="pr hor-mspace text-11"><?php echo __l('Views'); ?></dt>
								<dd title="" class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->link($this->Html->cInt($request['Request']['request_view_count']), array('controller'=> 'request_views', 'action'=>'index', 'request_id'=>$request['Request']['id'], 'admin' => true), array('escape' => false));?></dd>
							</dl>
							<dl class="list sep-right">
								<dt class="pr hor-mspace text-11"><?php echo __l('Flags'); ?></dt>
								<dd title="" class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->link($this->Html->cInt($request['Request']['request_flag_count']), array('controller'=> 'request_flags', 'action'=>'index', 'request_id'=>$request['Request']['id'], 'admin' => true), array('escape' => false));?></dd>
							</dl>
							<dl class="list">
								<dt class="pr hor-mspace text-11"><?php echo __l('Favorites'); ?></dt>
								<dd title="" class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->link($this->Html->cInt($request['Request']['request_favorite_count']), array('controller'=> 'request_favorites', 'action'=>'index', 'request_id'=>$request['Request']['id'], 'admin' => true), array('escape' => false));?></dd>
							</dl>
						</div>
					</div>
				</div>
			</div>
			</div>
			</div>
           </div>
         </td>
    </tr> </tbody>
<?php
    endforeach;
else:
?>
	<tr class="js-odd">
		<td colspan="51"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Requests available');?></p></div></td>
	</tr>
<?php
endif;
?>
</table>
    <?php
    if (!empty($requests)) :
        ?>
        <div class="admin-select-block ver-mspace pull-left mob-clr dc">
			<div class="span top-mspace">
				<span class="graydarkc">
					<?php echo __l('Select:'); ?>
				</span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
				<?php echo $this->Html->link(__l('Disapproved'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-disapproved","unchecked":"js-checkbox-approved"} hor-smspace grayc', 'title' => __l('Disapproved'))); ?>
				<?php echo $this->Html->link(__l('Approved'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-approved","unchecked":"js-checkbox-disapproved"} hor-smspace grayc', 'title' => __l('Approved'))); ?>
				<span class="hor-mspace">
					<?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit js-no-pjax span5', 'div'=>false,'label' => false, 'empty' => __l('-- More actions --'))); ?>
				</span>
				</div>
            </div>
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