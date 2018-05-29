<?php
echo $this->requestAction(array('controller' => 'charts', 'action' => 'user_engagement', 'select_range_id' => $select_range_id, 'admin' => true), array('return'));
?>