<?php
	echo $this->requestAction(array('controller' => 'users', 'action' => 'login', 'payment_id' => $payment_id, 'order_id' => $order_id, 'type' => $type), array('return'));
?>