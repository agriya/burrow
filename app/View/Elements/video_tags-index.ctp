<?php
	$username = (isset($username)) ? $username : '';
    echo $this->requestAction(array('controller' => 'video_tags', 'action' => 'index', 'username' => $username), array('return'));
?>