<?php
if(empty($user_id)){
	$user_id =0;
}
    echo $this->requestAction(array('controller' => 'property_feedbacks', 'action' => 'index','user_id'=>$user_id,'property_id' =>$property_id,'type'=>'property','view'=>'compact'), array('return'));
?>