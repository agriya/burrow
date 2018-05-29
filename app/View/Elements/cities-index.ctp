<?php
	echo $this->requestAction(array('controller' => 'cities', 'action' => 'index'), array('named' => array('admin' => false, 'city' => $city, 'is_request' => $is_request), 'return'));
?>