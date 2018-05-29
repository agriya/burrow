<?php
echo $this->requestAction(array('controller' => 'google_analytics', 'action' => 'chart_metrics', 'select_range_id' => $select_range_id, 'from' => $from, 'admin' => true), array('return'));
?>