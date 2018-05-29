<div class="navbar-inner no-round sep-bot container-fluid">
<div class="row ver-mspace">
  <h1 class="span7 no-mar text-16" itemscope itemtype="http://schema.org/Organization"><?php echo $this->Html->link($this->Html->image('logo.png', array('itemprop'=>"logo")).'<span class="text-11 blackc">Admin</span>', array('controller' => 'users', 'action' => 'stats', 'admin' => true), array('escape' => false, 'title' => (Configure::read('site.name').' '.'Admin'), 'class' => 'brand blackc no-under js-no-pjax', 'itemprop'=> "url"));?>
   </h1>
  <div class="pull-right ver-smspace mob-clr">
	<ul class="unstyled span no-mar dc active-link">
			<li class="span js-live-tour-link "><a href="#" class="bootstro-goto grayc bootstro js-no-pjax" data-bootstro-step="0" data-bootstro-title="Live Tour" data-bootstro-content="Look out for a Live Tour link in the top of page for live demo of product" data-bootstro-placement="bottom" escape="false">Live Tour</a></li>
			<?php $class = ($this->request->params['controller'] == 'properties') ? ' class="span active"' : 'class="span"'; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('View Site'), Router::url('/', true), array('escape' => false, 'title' => __l('View Site')));?></li>
			<?php $class = (($this->request->params['controller'] == 'users') && ($this->request->params['action'] == 'admin_diagnostics')) ? ' class="span active"' : 'class="span"'; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Diagnostics'), array('controller' => 'users', 'action' => 'diagnostics', 'admin' => true),array('title' => __l('Diagnostics'), 'class'=> 'grayc')); ?></li>
			<?php $class = ($this->request->params['controller'] == 'pages') ? ' class="span active"' : 'class="span"'; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Tools'), array('controller' => 'pages', 'action' => 'display', 'tools', 'admin' => true), array('escape' => false, 'title' => __l('View Site'), 'class'=> 'grayc'));?></li>
			<?php $class = ($this->request->params['controller'] == 'user_profiles') ? ' class="span active"' : 'class="span"'; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('My Account'), array('controller' => 'user_profiles', 'action' => 'edit', $this->Auth->user('id')), array('title' => __l('My Account'), 'class'=> 'grayc'));?></li>
			<?php $class = (($this->request->params['controller'] == 'users') && ($this->request->params['action'] == 'change_password')) ? ' class="span active"' : 'class="span"'; ?>
			<li <?php echo $class;?>><?php echo $this->Html->link(__l('Change Password'), array('controller' => 'users', 'action' => 'admin_change_password'), array('title' => __l('Change Password'), 'class'=> 'grayc'));?></li>
			<li class="span"><?php echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('title' => __l('Logout'), 'class' => 'js-no-pjax'));?></li>			
	</ul>
  </div>
</div>
</div>
