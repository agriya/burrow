<?php
    if ($current_page == 'share') {
        $redirect_url = Router::url(array(
            'controller' => 'social_marketings',
            'action' => 'publish',
            $id,
            'type' => 'twitter',
            'publish_action' => $action
        ), true);
    } else {
        $redirect_url = Router::url(array(
            'controller' => 'social_marketings',
            'action' => 'import_friends',
            'type' => 'twitter',
            'admin' => false
        ), true);
    }
?>
<script>
    top.location.href="<?php echo $redirect_url; ?>";
</script>