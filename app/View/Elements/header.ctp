<?php if ($this->request->params['action'] != 'show_header') { ?>
	<div id="js-head-menu" class="header-right   clearfix hide">
<?php } ?>
		<div class="nav-collapse clearfix">
              <ul class="nav pull-right no-mar">
                <li class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle clearfix mob-sep-none cur js-no-pjax" href="#" title="<?php echo  __l('Hosting');?>"> <span class="top-smspace show clearfix"> <span class="pull-left top-space"><i class="icon-home top-space text-24 pull-left"></i></span><span class="show ver-space text-16 textb pull-left"><span class="hor-smspace"><?php echo  __l('Hosting');?></span><span class="caret"></span></span></span></a>
                  <ul class="dropdown-menu">
                    <li><a  tabindex="-1" class="list-space " title="<?php echo __l('List Your Property'); ?>" href="<?php echo Router::url(array('controller' => 'properties', 'action' => 'add')); ?>"><span><span class="list-property tb"><?php echo __l('List Your Property'); ?></span></span></a></li>                     
					<li><?php echo $this->Html->link(__l('Import Properties'), array('controller' => 'properties', 'action' => 'import', 'admin' => false), array('tabindex' => '-1','class' => 'import-properties','title' => __l('Import Properties')));?></li>

                   <?php if($this->Auth->sessionValid()):?>
						<li><?php echo $this->Html->link(__l('My Properties'), array('controller' => 'properties', 'action' => 'index', 'type'=>'myproperties','admin' => false), array('title' => __l('My Properties')));?></li>
						<li><?php echo $this->Html->link(__l('Calendar'), array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'status' => 'waiting_for_acceptance','admin' => false), array('title' => __l('Calendar')));?></li>
				   <?php endif; ?>
				    <?php if(isPluginEnabled("Requests")) : ?>
                    <li class="divider"></li>
                    <li><?php echo $this->Html->link(__l('Requests'), array('controller' => 'requests', 'action' => 'index','admin' => false), array('title' => __l('Requests')));?></li>
					 <?php endif; ?>
					 <?php if($this->Auth->sessionValid()):?>
						<?php if(isPluginEnabled('RequestFavorites') && isPluginEnabled('Requests')) : ?>
							<li><?php echo $this->Html->link(__l('Liked Requests'), array('controller' => 'requests', 'action' => 'index', 'type'=>'favorite','admin' => false), array('title' => __l('Liked Requests')));?></li>
						<?php endif;?>					
					 <?php endif; ?>
                  </ul>
                </li>
                <li class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle cur clearfix mob-sep-none js-no-pjax" href="#" title="<?php echo  __l('Traveling');?>"><span class="top-smspace show clearfix"><span class="pull-left top-space"><i class="icon-plane text-24 "></i></span><span class="show ver-space text-16 textb pull-left"><span class="hor-smspace"><?php echo  __l('Traveling');?></span><span class="caret"></span></span></span></a>
                  <ul class="dropdown-menu">
				  <?php if(isPluginEnabled("Requests")) : ?><li><a class="list-space " title="<?php echo __l('Post a Request'); ?>" href="<?php echo Router::url(array('controller' => 'requests', 'action' => 'add'),false); ?>"><span><span class="post-request tb"><?php echo __l('Post a Request'); ?></span></span></a></li>	<?php endif; ?>				   
					  <?php if($this->Auth->sessionValid()):?>						
						<?php if(isPluginEnabled('Requests')):?>
						<li><?php echo $this->Html->link(__l('My Requests'), array('controller' => 'requests', 'action' => 'index', 'type' => 'myrequest', 'status' => 'active', 'admin' => false), array('title' => __l('My Requests')));?></li>
						<li class="divider"></li>
						<?php endif;?>													
						<li><?php echo $this->Html->link(__l('Trips'), array('controller' => 'property_users', 'action' => 'index', 'type'=>'mytours','status' => 'in_progress', 'admin' => false), array('title' => __l('Trips')));?></li>
						<?php if(isPluginEnabled('PropertyFavorites')) : ?>
						<li ><?php echo $this->Html->link(__l('Liked Properties'), array('controller' => 'properties', 'action' => 'index', 'type'=>'favorite','admin' => false), array('title' => __l('Liked Properties')));?></li>
						<?php endif;?>

					<?php endif; ?>
                    <li class="divider"></li>
                    <li><?php echo $this->Html->link(__l('Properties'), array('controller' => 'properties', 'action' => 'index','admin' => false), array('title' => __l('Properties')));?></li>
                  </ul>
                </li>
				 <?php if(!$this->Auth->sessionValid()):?>
					<li id="js-before-login-head-menu" class="hide"><?php echo $this->Html->link('<span class="top-smspace show clearfix"><span class="show ver-space text-16 textb pull-left"><span class="hor-smspace">'.__l('Login').'</span></span></span>', array('controller' => 'users', 'action' => 'login'), array('escape'=>false,'title' => __l('Login')));?></li>
					<li id="js-before-register-head-menu" class="hide"><?php echo $this->Html->link('<span class="top-smspace show clearfix"><span class="show ver-space text-16 textb pull-left"><span class="hor-smspace">'.__l('Register').'</span></span></span>', array('controller' => 'users', 'action' => 'register','type'=>'social', 'admin' => false), array('escape'=>false,'title' => __l('Register')));?></li>
				<?php elseif($this->request->params['action'] == 'show_header'): ?>
					<?php
					$countContent = '';
					$message_count = $this->Html->getUserUnReadMessages($this->Auth->user('id'));
					$message_count = !empty($message_count) ? $message_count : '';
					?>
					<?php if(!empty($message_count)) { 
						$countContent = '<span class="label label-important pa">'.$message_count.'</span>';
					 }  ?>
					<?php $activiy_url = Router::url(array(
						'controller' => 'messages',
						'action' => 'notifications',
						'type' => 'compact'
						), true); ?>
					<li class="dropdown">
						<a class="js-notification js-no-pjax" data-target="#" data-toggle="dropdown" href="<?php echo $activiy_url; ?>">
							<span class="in-count top-space show pr">
								<i class="icon-globe hor-smspace text-24"></i>
								<span class="label label-important pa">
									<?php echo $this->Html->getUserNotification($this->Auth->user('id'));?>
								</span>
							</span>
						</a>
						<div class="dropdown-menu arrow js-notification-list clearfix span15">
							<div class="dc"><?php echo $this->Html->image('ajax-circle-loader.gif', array('alt' => __l('[Image: Loader]') ,'width' => 16, 'height' => 11)); ?></div>
						</div>
					</li> 
				    <li><?php echo $this->Html->link('<span class="in-count top-space show pr"><i class="icon-envelope hor-smspace text-24"></i>'.$countContent.'</span>', array('controller' => 'messages', 'action' => 'index'), array('escape'=>false,'title' => __l('Inbox'))); ?>				   </li>
					<li class="dropdown">
					<a data-toggle="dropdown" class="dropdown-toggle mob-sep-none js-no-pjax" href="#" title="">
						<span class="show top-space top-smspace menu-avatar"><?php 
							$user = $this->Html->getCurrUserInfo($this->Auth->user('id'));  
							echo $this->Html->getUserAvatarLink($user['User'], 'small_thumb', false);
							?>
							<span class="caret"></span>
						</span>
					</a>					
					  <ul class="dropdown-menu ">
						  <li><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'dashboard'), array('title' => __l('Dashboard')));?></li>
						 <li><?php echo $this->Html->link(__l('Settings'), array('controller' => 'user_profiles', 'action' => 'edit'), array('escape'=>false,'title' => __l('Settings')));?></li>
						 <?php /*<li><?php echo $this->Html->link(__l('Your public profile'), array('controller' => 'users', 'action' => 'view', $this->Auth->user('username')), array('title' => __l('Your public profile')));</li><?php */?>
                         <?php if(isPluginEnabled('SocialMarketing')):?>
							<li><?php echo $this->Html->link(__l('Find Friends'), array('controller' => 'social_marketings', 'action' => 'import_friends', 'type' => 'facebook'), array('escape'=>false,'title' => __l('Find Friends'))); ?></li>
						<?php endif;?>
						<?php if(isPluginEnabled('LaunchModes') && Configure::read('site.launch_mode') == "Private Beta"):?>
							<li ><?php echo $this->Html->link(__l('Invite Friends'), array('controller' => 'subscriptions', 'action' => 'invite_friends'), array('title' => __l('Invite Friends'), 'escape' => false)); ?></li>
						<?php endif;?>
						<li class="divider"></li>
						<?php if($this->Auth->sessionValid()){ ?>
							<li><?php echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('title' => __l('Logout'), 'class' => 'js-no-pjax'));?></li>
						<?php } ?>

					  </ul>
					</li>
				<?php endif; ?>
				<?php
				$currencies = $this->Html->getCurrencies();
				if(!empty($currencies)) {
					$selectedCurr = isset($_COOKIE['CakeCookie']['user_currency']) ? $currencies[$_COOKIE['CakeCookie']['user_currency']] : $currencies[Configure::read('site.currency_id')];
					?>
					<?php if(Configure::read('user.is_allow_user_to_switch_currency') && !empty($currencies)) : ?>
						<li class="dropdown dropdown-sm"><a data-toggle="dropdown" class="dropdown-toggle mob-sep-none" href="#" title="<?php echo $selectedCurr; ?>"><span class="show ver-space top-smspace text-16 textb"><span class="hor-smspace"><?php echo $selectedCurr; ?></span><span class="caret"></span></span></a>
							<ul class="dropdown-menu">
								<?php foreach($currencies AS $key => $currency) { 
									echo ($selectedCurr == $currency)? '<li Class="active">' : '<li>';
									echo $this->Html->link($currency, '#', array('title' => $currency, 'class'=>"js-currency-change" , 'data-currency_id' => $key, 'data-f' => $this->request->url));
									echo '</li>';
							   }?>
							</ul>  
						</li>
					<?php endif; ?>
				<?php } ?>
				<?php 
				if(isPluginEnabled('Translation')) :
					$languages = $this->Html->getLanguage();
					$selectedLan = isset($_COOKIE['CakeCookie']['user_language']) ?  $_COOKIE['CakeCookie']['user_language'] : Configure::read('site.language');
					if(count($languages) > 1) {
						if(Configure::read('user.is_allow_user_to_switch_language') && !empty($languages)) : ?>
						  <li class="dropdown dropdown-sm"><a data-toggle="dropdown" class="dropdown-toggle mob-sep-none" href="#" title="<?php echo $selectedLan; ?>"><span class="show ver-space top-smspace text-16 textb"><span class="hor-smspace"><?php echo $selectedLan; ?></span><span class="caret"></span></span> </a>
							<ul class="dropdown-menu">
							  <?php foreach($languages AS $key => $language) { 
										echo ($selectedLan == $language)? '<li Class="active">' : '<li>';
											echo $this->Html->link($language, '#', array('title' => $language, 'class'=>"js-lang-change" , 'data-lang_id' => $key, 'data-f' => $this->request->url));
										echo '</li>';
							  } ?>
						    </ul>
						  </li>
						<?php endif;
					} 
				endif; ?>
              </ul>
            </div>		
  <?php
	if ($this->request->params['action'] != 'show_header') {
		$script_url = Router::url(array(
			'controller' => 'users',
			'action' => 'show_header',
			'ext' => 'js',
			'admin' => false
		) , true) . '?u=' . $this->Auth->user('id');
		$js_inline = "(function() {";
		$js_inline .= "var js = document.createElement('script'); js.type = 'text/javascript'; js.async = true;";
		$js_inline .= "js.src = \"" . $script_url . "\";";
		$js_inline .= "var s = document.getElementById('js-head-menu'); s.parentNode.insertBefore(js, s);";
		$js_inline .= "})();";
?>
<script type="text/javascript">
//<![CDATA[
function getCookie (c_name) {var c_value = document.cookie;var c_start = c_value.indexOf(" " + c_name + "=");if (c_start == -1) {c_start = c_value.indexOf(c_name + "=");}if (c_start == -1) {c_value = null;} else {c_start = c_value.indexOf("=", c_start) + 1;var c_end = c_value.indexOf(";", c_start);if (c_end == -1) {c_end = c_value.length;}c_value = unescape(c_value.substring(c_start,c_end));}return c_value;}if (getCookie('_gz')) {<?php echo $js_inline; ?>} else {document.getElementById('js-head-menu').className = '';document.getElementById('js-before-login-head-menu').className = '';document.getElementById('js-before-register-head-menu').className = '';}
//]]>
</script>
<?php
	}
?>
<?php if ($this->request->params['action'] != 'show_header') { ?>
	</div>
<?php } ?>