<?php
  if (Configure::read('site.launch_mode') == 'Pre-launch') {
    echo $this->requestAction(array('controller' => 'subscriptions', 'action' => 'add'), array('return'));
  } elseif(Configure::read('site.launch_mode') == 'Private Beta' && !$this->Auth->user('id')) {
    echo $this->requestAction(array('controller' => 'subscriptions', 'action' => 'add', 'type' => 'invite_page'), array('return'));
  }
?>