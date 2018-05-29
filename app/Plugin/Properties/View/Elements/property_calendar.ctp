<div>
 <h2><?php echo __l('Availability'); ?></h2>
</div>
<?php
	echo $this->requestAction(array('controller' => 'properties', 'action' => 'calendar','guest','ids'=>$property_id), array('return')); 
?>
 