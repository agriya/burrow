<?php
 if(!isset($user_id))
 {
	$user_id='';
 }
  if(!isset($request_id))
 {
	$request_id='';
 }
  if(!isset($type))
 {
	$type='';
 }
    echo $this->requestAction(array('controller' => 'requests', 'action' => 'index'), array('user_id' =>$user_id,'type'=>$type,'request_id'=>$request_id,'view'=>'compact', 'return'));
?>