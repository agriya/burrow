<?php
	if(!empty($this->request->params['named']['status'])):
   	echo $this->requestAction(array('controller' => 'affiliate_requests', 'action' => 'add', 'status' =>  $this->request->params['named']['status']), array('return'));
	else:
   	echo $this->requestAction(array('controller' => 'affiliate_requests', 'action' => 'add'), array('return'));
   	endif;
?>