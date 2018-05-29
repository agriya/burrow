<?php
	$limit = !empty($limit) ? $limit : '';
	if ($type == 'user'):
		echo $this->requestAction(array('controller' => 'properties', 'action' => 'index'), array('user' =>$user_id,'type'=>'user','view'=>'compact', 'return'));
	elseif($type=='property'):
		if (empty($user_id) && empty($property_id)) {
			echo  $this->requestAction(array('controller' => 'properties', 'action' => 'index'), array('property' => 'my_properties', 'view' => 'compact', 'request_id' => $request_id, 'request_longitude' => $request_longitude, 'request_latitude' => $request_latitude, 'return'));
		} else {
			echo $this->requestAction(array('controller' => 'properties', 'action' => 'index'), array('user_id' =>$user_id,'property_id'=>$property_id,'view'=>'compact', 'return'));
		}
	else:
		echo $this->requestAction(array('controller' => 'properties', 'action' => 'index',$hash,$salt), array('limit'=>$limit,'property_id'=>$property_id,'city_id'=>$city_id,'view'=>'compact', 'return'));
	endif;
?>