<?php
	echo $this->requestAction(array('controller' => 'google_analytics', 'action' => 'admin_chart_bounces', 'select_range_id' => $select_range_id, 'from_section' => $from_section, 'admin' => true), array('return'));
?>