<?php
	echo $this->element('admin_panel_property_view', array('controller' => 'properties', 'action' => 'index', 'property' =>$property), array('plugin' => 'Properties'));
?>