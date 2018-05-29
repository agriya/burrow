<?php
	echo $this->requestAction(array('controller' => 'google_analytics', 'action' => 'ecommerce_transaction_chart', 'select_range_id' => $select_range_id, 'admin' => true), array('return'));
?>