<p>
<?php
if (!empty($messages)) :
foreach($messages as $message):
   		$view_url=array('controller' => 'messages','action' => 'v',$message['Message']['id'], 'admin' => false);
?>
	<span class="show text-12 top-smspace span24">
		    <?php  echo $this->Html->link($message['MessageContent']['subject'] ,$view_url, array('class' => 'htruncate span15 js-bootstrap-tooltip'));?>
	</span>    
<?php
    endforeach;
endif;
?>
</p>