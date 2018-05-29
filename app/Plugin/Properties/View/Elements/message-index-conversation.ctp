<?php
	echo $this->requestAction(array('controller' => 'messages', 'action' => 'index', 'order_id' => $order_id, 'admin' => false, 'admin_view' => $admin_view, 'span_size' => $span_size), array('return'));
?>