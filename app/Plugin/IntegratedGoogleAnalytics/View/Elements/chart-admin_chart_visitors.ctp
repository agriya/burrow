<?php
	echo $this->requestAction(array('controller' => 'google_analytics', 'action' => 'admin_chart_visitors', 'select_range_id' => $select_range_id, 'from' => $from, 'admin' => true), array('return'));
?>