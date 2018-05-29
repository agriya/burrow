<?php
	echo $this->requestAction(array('controller' => 'properties', 'action' => 'view', $slug, 'view_type' => 'simple-view', 'order_id' => $order_id, 'admin' => false), array('return'));
?>
