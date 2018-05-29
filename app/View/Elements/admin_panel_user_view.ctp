<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
	<div class="accordion-admin-panel" id="js-admin-panel">
		<div class="clearfix js-admin-panel-head admin-panel-block">
			<div class="admin-panel-inner span3 pa accordion-heading no-mar no-bor clearfix box-head admin-panel-menu mob-ps">
				<a data-toggle="collapse" data-parent="#accordion-admin-panel" href="#adminPanel" class="btn js-show-panel accordion-toggle span3 js-no-pjax blackc no-under clearfix"><i class="pull-right caret"></i><i class="icon-user"></i> <?php echo __l('Admin Panel'); ?></a>
			</div>
			<div class="accordion-body no-round no-bor collapse" id="adminPanel">
				<div id="ajax-tab-container-admin" class="accordion-inner thumbnail clearfix no-bor tab-container admin-panel-inner-block">
					<ul class="nav no-float nav-tabs tabs">
						<li class="tab"><?php echo $this->Html->link(__l('Actions'), '#admin-actions',array('class' => 'js-no-pjax', 'title'=>__l('Actions'), 'data-toggle'=>'tab', 'rel' => 'address:/admin_actions')); ?></li>
						<li class="tab"><em></em><?php echo $this->Html->link(sprintf(__l('User Logins (%s)'), $this->Html->cInt($user['User']['user_login_count'])), array('controller' => 'user_logins', 'action' => 'index', 'user_id' => $user['User']['id'], 'view_type' => 'user_view', 'admin' => true), array('class' => 'js-no-pjax', 'data-target'=>'#admin-user-logins','escape' => false)); ?></li>
					</ul>
					<article class="panel-container">
						<div class="span20 tab-pane fade in active" id="admin-actions" style="display: block;">
							<ul class="unstyled clearfix">
								<?php if (Configure::read('user.is_email_verification_for_register') and !$user['User']['is_email_confirmed']): ?>
								<li class="pull-left dc mspace">
								<?php echo $this->Html->link(__l('Resend Activation'), array('controller' => 'users', 'action'=>'resend_activation', $user['User']['id'], 'admin' => true),array('class' => 'btn blackc js-no-pjax', 'title' => __l('Resend Activation'))); ?>
								</li>
							  <?php endif; ?>
								<li class="pull-left dc mspace">
								  <?php echo $this->Html->link('<i class="icon-edit"></i> '.__l('Edit'), array('controller' => 'user_profiles', 'action'=>'edit', $user['User']['id'],'admin' => true), array('class' => 'btn blackc js-edit js-no-pjax','escape'=>false, 'title' => __l('Edit')));?>
								</li>
								  <?php if($user['User']['role_id'] != ConstUserTypes::Admin){ ?>
								<li class="pull-left dc mspace">
								  <?php echo $this->Html->link('<i class="icon-remove"></i> '.__l('Delete'), Router::url(array('action'=>'delete', $user['User']['id'],'admin'=> true),true).'?r='.$this->request->url, array('class' => 'btn blackc js-confirm js-no-pjax', 'escape'=>false,'title' => __l('Delete')));?>
								</li>
								  <?php } ?>
								  <?php if (empty($user['User']['is_facebook_register']) && empty($user['User']['is_twitter_register']) && empty($user['User']['is_yahoo_register']) && empty($user['User']['is_google_register']) && empty($user['User']['is_googleplus_register']) && empty($user['User']['is_linkedin_register']) && empty($user['User']['is_openid_register'])): ?>
								<li class="pull-left dc mspace">
								  <?php echo $this->Html->link('<i class="icon-lock"></i> '.__l('Change password'), array('controller' => 'users', 'action'=>'change_password', $user['User']['id'], 'admin' => true), array('class' => 'btn blackc js-no-pjax', 'escape'=>false,'title' => __l('Change password')));?>
								</li>
							  <?php endif; ?>
							</ul>
						</div>
						<div class="tab-pane fade in active" id="admin-user-logins" style="display: block;"></div>
					</article>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>