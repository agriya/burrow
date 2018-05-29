<?php
echo $this->requestAction(array('controller' => 'user_comments', 'action' => 'index'), array('named' => array('limit' => 5), 'pass' => array($username), 'return'));
?>