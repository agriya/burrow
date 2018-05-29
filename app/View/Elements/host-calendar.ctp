<?php
	if(!isset($type)) {
		$type = 'host';
	}
    echo $this->requestAction(array('controller' => 'properties', 'action' => 'calendar', $type, 'ids' => $ids), array('return'));
?>