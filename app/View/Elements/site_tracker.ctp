<?php
if (env('SERVER_ADDR') != env('REMOTE_ADDR')):
    echo Configure::read('site.tracking_script');
endif;
?>