<?php
	$username = (isset($username)) ? $username : '';
    echo $this->requestAction(array('controller' => 'photo_tags', 'action' => 'index', 'username' => $username), array('return'));
?>