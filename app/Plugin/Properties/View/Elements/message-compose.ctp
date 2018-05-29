<?php
	if(!empty($type) && $type == 'deliver'):
		echo $this->requestAction(array('controller' => 'messages', 'action' => 'compose', 'property_user_id' => $property_user_id, 'order' => 'deliver', 'view_type' => 'simple-deliver'), array('return'));
	else:
		echo 'yet to come';
	endif;
?>