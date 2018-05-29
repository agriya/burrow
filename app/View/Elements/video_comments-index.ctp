<?php
    echo $this->requestAction(array('controller' => 'video_comments', 'action' => 'index', $video['Video']['id']), array('key' => $video['Video']['id'], 'return'));
?>