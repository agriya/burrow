<?php
	echo $this->requestAction(array('controller' => 'insights','action' => 'chart_user_logins', 'admin' => true, 'role_id'=> $role_id), array('return'));
?>