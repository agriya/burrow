<?php
	echo $this->requestAction(array('controller' => 'insights', 'action' => 'chart_users', 'admin' => true, 'role_id' => $role_id), array('return'));
?>