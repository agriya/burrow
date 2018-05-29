<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin): 
	if ($request['Request']['is_approved']):
		$status_class = 'js-checkbox-approved';
		$style_class = 'pending';
	else:
		$style_class = 'approve';
		$active_class = ' inactive-record';
		$status_class = 'js-checkbox-disapproved';
	endif;
?>
	<div class="accordion-admin-panel" id="js-admin-panel">
		<div class="clearfix js-admin-panel-head admin-panel-block">
			<div class="admin-panel-inner span3 pa accordion-heading no-mar no-bor clearfix box-head admin-panel-menu mob-ps">
				<a data-toggle="collapse" data-parent="#accordion-admin-panel" href="#adminPanel" class="btn js-show-panel accordion-toggle span3 js-no-pjax blackc no-under clearfix"><i class="pull-right caret"></i><i class="icon-user"></i> <?php echo __l('Admin Panel'); ?></a>
			</div>
			<div class="accordion-body no-round no-bor collapse" id="adminPanel">
				<div id="ajax-tab-container-admin" class="accordion-inner thumbnail clearfix no-bor tab-container admin-panel-inner-block pr">
					<ul id="myTab2" class="nav nav-tabs tabs top-space top-mspace">
						<li><?php echo $this->Html->link(__l('Action'), '#admin-action', array('class' => 'js-no-pjax span2', 'title'=>__l('Actions'), 'data-toggle'=>'tab', 'rel' => 'address:/admin_actions')); ?></li>
						<?php if(isPluginEnabled('RequestFavorites')) : ?>
						<li><?php echo $this->Html->link(__l('Request Favorites'), array('controller' => 'request_favorites', 'action' => 'index', 'request_id' => $request['Request']['id'], 'simple_view' => 'user_view', 'admin' => true), array('title'=>'Request favorites', 'class' => ' js-no-pjax','data-target'=>'#Request_favorites')); ?></li>
						<?php endif;?>
						<li><?php echo $this->Html->link(__l('Request Views'), array('controller' => 'request_views', 'action' => 'index', 'request_id' => $request['Request']['id'], 'view_type' => 'user_view', 'admin' => true), array('title'=>'Request views', 'class' => ' js-no-pjax','data-target'=>'#Request_views')); ?></li>
						<?php if(isPluginEnabled('RequestFlags')): ?>
						<li><?php echo $this->Html->link(__l('Request Flags'), array('controller' => 'request_flags', 'action' => 'index', 'request_id' => $request['Request']['id'], 'view_type' => 'user_view', 'admin' => true), array('title'=>'Request flags', 'class' => ' js-no-pjax','data-target'=>'#Request_flags')); ?></li>
						<?php endif;?>
					</ul>
					<div class="sep-right sep-left sep-bot tab-round tab-content" id="myTabContent2">
						<div class="tab-pane space "  id="admin-action">
							<ul class="action-link action-link-view clearfix unstyled">
								<li class="span4"> <?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action'=>'edit', $request['Request']['id']), array('class' => 'edit js-edit grayc', 'title' => __l('Edit') ,'escape'=>false));?></li>
								<li  class="span4">	<?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action'=>'delete', $request['Request']['id']), array('class' => 'delete js-delete grayc', 'title' => __l('Delete'),'escape'=>false));?></li>				
								<?php if($request['Request']['is_system_flagged']):?>
									<?php if($request['User']['is_active']):?>
										<li  class="span4">	<?php echo $this->Html->link(__l('Deactivate User'), array('controller' => 'users', 'action' => 'admin_update_status', $request['User']['id'], 'status' => 'deactivate'), array('class' => 'js-admin-update-property deactive-user', 'title' => __l('Deactivate user')));?></li>
									<?php else:?>
										<li  class="span4"><?php echo $this->Html->link(__l('Activate User'), array('controller' => 'users', 'action' => 'admin_update_status', $request['User']['id'], 'status' => 'activate'), array('class' => 'js-admin-update-property active-user', 'title' => __l('Activate user')));?></li>
									<?php endif;?>
								<?php endif;?>
								<?php if($request['Request']['is_system_flagged']):?>
									<li  class="span4">	<?php echo $this->Html->link(__l('Clear flag'), array('action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'deactivate'), array('class' => 'js-admin-update-property clear-flag', 'title' => __l('Clear flag')));?></li>
								<?php else:?>
									<li  class="span4">	<?php echo $this->Html->link('<i class="icon-flag"></i>'.__l('Flag'), array('action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'active'), array('class' => 'js-admin-update-property flag grayc', 'title' => __l('Flag'),'escape'=>false));?></li>
								<?php endif;?>
								<?php if($request['Request']['admin_suspend']):?>
									<li  class="span4"><?php echo $this->Html->link('<i class="icon-on"></i>'.__l('Unsuspend'), array('action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'unsuspend'), array('class' => 'js-admin-update-property  unsuspend grayc', 'title' => __l('Unsuspend'),'escape'=>false));?></li>
								<?php else:?>
									<li  class="span4">	<?php echo $this->Html->link('<i class="icon-off"></i>'.__l('Suspend'), array('action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'suspend'), array('class' => 'js-admin-update-property suspend grayc', 'title' => __l('Suspend'),'escape'=>false));?></li>
								<?php endif;?>
								<li  class="span4">	<?php echo $this->Html->link((($request['Request']['is_approved']) ? '<i class="icon-thumbs-down"></i>'.__l('Disapprove') : '<i class="icon-thumbs-up"></i>'.__l('Approve')), array('action' => 'admin_update_status',  $request['Request']['id'], 'status' => (($request['Request']['is_approved']) ? 'disapproved' : 'approved')), array('class' => 'js-admin-update-property grayc ' . $style_class, 'title' => (( $request['Request']['is_approved']) ? __l('Disapprove') : __l('Approve')),'escape'=>false)); ?></li>
							</ul>
						</div>
						<div class="tab-pane space" id="Request_favorites"></div>
						<div class="tab-pane space" id="Request_views"></div>
						<div class="tab-pane space" id="Request_flags"></div>
					</div>	
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>