<?php
	echo $this->requestAction(array('controller' => 'user_comments', 'action' => 'index', $user_name, 'view' => 'popular', 'page' => $page), array('return'));
?>