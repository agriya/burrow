<?php /* SVN FILE: $Id: default.ctp 123 2008-08-12 15:59:58Z rajesh_04ag02 $ */ ?>
<?php
header('Content-Disposition: inline; filename="' . str_replace('/', '_', $this->request->url) . '"');
?>
<?php echo $content_for_layout; ?>