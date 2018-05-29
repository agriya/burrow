<?php
	echo $this->requestAction(array('controller' => 'property_user_disputes', 'action' => 'resolve', 'order_id' => $order_id, 'admin' => false), array('return'));
?>