<?php
	echo $this->requestAction(array('controller' => 'users','action' => 'recent_users', 'admin' => true), array('return'));
?>