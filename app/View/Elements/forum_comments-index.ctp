<?php
    echo $this->requestAction(array('controller' => 'forum_comments', 'action' => 'index', $forum['Forum']['id']), array('key' => $forum['Forum']['id'], 'return'));
?>