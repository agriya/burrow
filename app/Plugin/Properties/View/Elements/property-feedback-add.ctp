<?php
	echo $this->requestAction(array('controller' => 'property_feedbacks', 'action' => 'add', 'property_order_id' => $order_id, 'view_type' => 'simple-feedback'), array('return'));
?>