<?php
if(!empty($request_id)):
    echo $this->requestAction(array('controller' => 'properties', 'action' => 'index'), array('type' => $type, 'property_id' => $request_id, 'view' => 'compact', 'return'));
else:
    echo $this->requestAction(array('controller' => 'properties', 'action' => 'index','is_admin' => $is_admin, 'admin' => false), array( 'type' => $type, 'request_latitude' => $latitude, 'request_longitude' => $longitude, 'view' => 'compact', 'return'));
endif;
?>