<?php
	echo $this->element('admin_panel_request_view', array('controller' => 'requests', 'action' => 'index', 'request' =>$request), array('plugin' => 'Requests'));
?>