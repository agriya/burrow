<?php
    echo $this->requestAction(array('controller' => 'photo_comments', 'action' => 'index', $photo['Photo']['id']), array('key' => $photo['Photo']['id'], 'return'));
?>