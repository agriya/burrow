<div class=" clearfix">
<?php
if ((Configure::read('site.launch_mode') == 'Pre-launch' && $this->Auth->user('role_id') != ConstUserTypes::Admin) || (Configure::read('site.launch_mode') == 'Private Beta' && !$this->Auth->user('id'))) {
  echo $this->element('subscription-add', array('cache' => array('config' => 'sec')), array('plugin' => 'LaunchModes'));
} else { 
	echo $this->element('search', array('config' => 'sec')); ?>
<?php } ?>
</div>




