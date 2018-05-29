<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
	<div class="accordion-admin-panel" id="js-admin-panel">
		<div class="clearfix js-admin-panel-head admin-panel-block">
			<div class="admin-panel-inner span3 pa accordion-heading no-mar no-bor clearfix box-head admin-panel-menu mob-ps">
				<a data-toggle="collapse" data-parent="#accordion-admin-panel" href="#adminPanel" class="btn js-show-panel accordion-toggle span3 js-no-pjax blackc no-under clearfix"><i class="pull-right caret"></i><i class="icon-user"></i> <?php echo __l('Admin Panel'); ?></a>
			</div>
			<div class="accordion-body no-round no-bor collapse" id="adminPanel">
				<div id="ajax-tab-container-admin" class="accordion-inner thumbnail clearfix no-bor tab-container admin-panel-inner-block pr">
					<ul id="myTab2" class="nav nav-tabs tabs top-space top-mspace">
						<li class="tab"><?php echo $this->Html->link(__l('Action'), '#admin-action', array('class' => 'js-no-pjax span2', 'title'=>__l('Actions'), 'data-toggle'=>'tab', 'rel' => 'address:/admin_actions')); ?></li>
						<li class="tab"><?php echo $this->Html->link(__l('Property Feedbacks'), array('controller' => 'property_feedbacks', 'action' => 'index', 'property_id' => $property['Property']['id'], 'simple_view' => 'user_view', 'admin' => true), array('title'=>'Property feedbacks', 'class' => ' js-no-pjax','escape' => false,'data-target'=>'#Property_feedbacks','data-toggle'=>'tab')); ?></li>
						<?php if(isPluginEnabled('PropertyFavorites')) :?>
						<li class="tab"><?php echo $this->Html->link(__l('Property Favorites'), array('controller' => 'property_favorites', 'action' => 'index', 'property_id' => $property['Property']['id'], 'simple_view' => 'user_view', 'admin' => true), array('title'=>'Property favorites', 'class' => ' js-no-pjax','escape' => false,'data-target'=>'#Property_favorites','data-toggle'=>'tab')); ?></li>
						<?php endif;?>
						<?php if(isPluginEnabled('PropertyFlags')): ?>
						<li class="tab"><?php echo $this->Html->link(__l('Property Flags'), array('controller' => 'property_flags', 'action' => 'index', 'property_id' => $property['Property']['id'], 'simple_view' => 'user_view', 'admin' => true), array('title'=>'Property flags', 'class' => ' js-no-pjax','escape' => false,'data-target'=>'#Property_flags','data-toggle'=>'tab')); ?></li>
						<?php endif;?>
						<li class="tab"><?php echo $this->Html->link(__l('Bookings'), array('controller' => 'property_users', 'action' => 'index', 'property_id' => $property['Property']['id'], 'simple_view' => 'user_view', 'admin' => true), array('title'=>'Bookings', 'class' => ' js-no-pjax','escape' => false,'data-target'=>'#Property_users','data-toggle'=>'tab')); ?></li>
						<li class="tab"><?php echo $this->Html->link(__l('Property Views'), array('controller' => 'property_views', 'action' => 'index', 'property_id' => $property['Property']['id'], 'view_type' => 'user_view', 'admin' => true), array('title'=>'Property views', 'class' => ' js-no-pjax','escape' => false,'data-target'=>'#Property_views','data-toggle'=>'tab')); ?></li>
					</ul>
					<div class="sep-right sep-left sep-bot tab-round tab-content" id="myTabContent2">
						<div class="tab-pane space "  id="admin-action">
							<ul class="action-link action-link-view clearfix unstyled">
								<?php if(empty($property['Property']['is_deleted'])):?>
									<li class="span4"><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'edit', $property['Property']['id'], 'admin' => true), array('escape' => false,'class' => 'graydarkc edit js-edit', 'title' => __l('Edit')));?></li>
									<li class="span4"><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $property['Property']['id'], 'admin' => true), array('escape' => false,'class' => 'graydarkc delete js-delete', 'title' => __l('Disappear property from user side')));?></li>
									<?php if($property['Property']['admin_suspend']):?>
										<?php if($property['User']['is_active']):?>
											<li class="span4">	<?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Deactivate User'), array('controller' => 'users', 'action' => 'update_status', $property['User']['id'], 'status' => 'deactivate', 'admin' => true), array('escape' => false,'class' => 'graydarkc js-admin-update-property deactive-user', 'title' => __l('Deactivate user')));?></li>
										<?php else:?>
											<li class="span4"><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Activate User'), array('controller' => 'users', 'action' => 'update_status', $property['User']['id'], 'status' => 'activate', 'admin' => true), array('escape' => false,'class' => 'graydarkc js-admin-update-property active-user', 'title' => __l('Activate user')));?></li>
										<?php endif;?>
									<?php endif;?>
									<?php if($property['Property']['is_featured']):?>
										<li class="span4">	<?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Not Featured'), array('action' => 'update_status', $property['Property']['id'], 'featured' => 'deactivate', 'admin' => true), array('escape' => false,'class' => 'graydarkc js-admin-update-property js-unfeatured not-featured', 'title' => __l('Not Featured')));?></li>
									<?php else:?>
										<li class="span4">	<?php echo $this->Html->link('<i class="icon-map-marker"></i>'.__l('Featured'), array('action' => 'update_status', $property['Property']['id'], 'featured' => 'activate', 'admin' => true), array('escape' => false,'class' => 'graydarkc js-admin-update-property js-featured featured', 'title' => __l('Featured')));?></li>
									<?php endif;?>
									<?php if($property['Property']['is_system_flagged']):?>
										<li class="span4">	<?php echo $this->Html->link(__l('Clear system flag'), array('action' => 'update_status', $property['Property']['id'], 'flag' => 'deactivate', 'admin' => true), array('escape' => false,'class' => 'graydarkc js-admin-update-property js-unflag clear-flag', 'title' => __l('Clear system flag')));?></li>
									<?php else:?>
										<li class="span4">	<?php echo $this->Html->link('<i class="icon-flag"></i>'.__l('Flag'), array('action' => 'update_status', $property['Property']['id'], 'flag' => 'active', 'admin' => true), array('escape' => false,'class' => 'graydarkc js-admin-update-property js-flag flag', 'title' => __l('Flag')));?></li>
									<?php endif;?>
									<?php if($property['Property']['is_user_flagged']):?>
										<li class="span4">	<?php echo $this->Html->link('<i class="icon-flag"></i>'.__l('Clear user flag'), array('action' => 'update_status', $property['Property']['id'], 'user_flag' => 'deactivate', 'admin' => true), array('escape' => false,'class' => 'graydarkc js-admin-update-property js-unflag clear-flag', 'title' => __l('Clear user flag')));?></li>
									<?php endif;?>
									<?php if($property['Property']['admin_suspend']):?>
										<li class="span4"><?php echo $this->Html->link('<i class="icon-repeat"></i>'.__l('Unsuspend'), array('action' => 'update_status', $property['Property']['id'], 'flag' => 'unsuspend', 'admin' => true), array('escape' => false,'class' => 'graydarkc js-admin-update-property  js-unsuspend unsuspend', 'title' => __l('Unsuspend')));?></li>
									<?php else:?>
										<li class="span4">	<?php echo $this->Html->link('<i class="icon-off"></i>'.__l('Suspend'), array('action' => 'update_status', $property['Property']['id'], 'flag' => 'suspend', 'admin' => true), array('escape' => false,'class' => 'graydarkc js-admin-update-property js-suspend suspend', 'title' => __l('Suspend')));?></li>
									<?php endif;?>
								<?php else:?>
									<li class="span4"><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Permanent Delete'), array('action' => 'delete', $property['Property']['id'], 'admin' => true), array('escape' => false,'class' => 'graydarkc delete js-delete', 'title' => __l('Permanent Delete')));?></li>
								<?php endif; ?>
								<li class="span4"><?php echo $this->Html->link((($property['Property']['is_approved']) ? '<i class="icon-thumbs-down"></i>'.__l('Disapprove') : '<i class="icon-thumbs-up"></i>'.__l('Approve')), array('action' => 'update_status',  $property['Property']['id'], 'status' => (($property['Property']['is_approved']) ? 'disapproved' : 'approved'), 'admin' => true), array('title' => (($property['Property']['is_approved']) ? __l('Disapprove') : __l('Approve')), 'class' => (( $property['Property']['is_approved']) ? 'graydarkc js-admin-update-property js-pending pending' : 'graydarkc js-admin-update-property js-approve approve'), 'escape' => false)); ?></li>
								<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == 2):?>
									<li class="span4"><?php echo $this->Html->link(__l('Waiting for verify'), array('action' => 'update_status', $property['Property']['id'], 'verify' => 'active', 'admin' => true), array('escape' => false,'class' => 'graydarkc js-admin-update-property  unsuspend', 'title' => __l('Waiting for verify')));?></li>
								<?php elseif(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == 1):?>
									<li class="span4"><?php echo $this->Html->link('<i class="icon-ok"></i>'.__l('Clear verify'), array('action' => 'update_status', $property['Property']['id'], 'verify' => 'deactivate', 'admin' => true), array('escape' => false,'class' => 'graydarkc js-admin-update-property clear', 'title' => __l('Clear verify')));?></li>
								<?php endif;?>
							</ul>
						</div>
						<div id="Property_feedbacks"></div>
						<div id="Property_favorites"></div>
						<div id="Property_users"></div>
						<div id="Property_views"></div>
						<div id="Property_flags"></div>
					</div>	
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>