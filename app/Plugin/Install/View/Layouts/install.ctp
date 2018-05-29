<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $title_for_layout; ?> - <?php echo __l('Burrow'); ?></title>
  <link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
  <link href="<?php echo $this->Html->assetUrl('install/favicon.ico', array('pathPrefix' => IMAGES_URL)); ?>" type="image/x-icon" rel="shortcut icon" />
  <?php
	echo $this->Html->css(array(
      'install/reset',
      'install/960_24_col',
      'install/install',
    ));
  ?>
</head>
<body>
<div class="installer-content">
  <div class="container_24">
    <div class="header">
      <div class="h-left">
        <div class="h-right">
          <div class="h-center">
            <h1 class="grid_left"><a href="#" title="Burrow">Burrow</a></h1>
            <p class="header-installer grid_left">Installer</p>
          </div>
        </div>
      </div>
    </div>
    <div class="main clearfix">
      <div class="side-content grid_7">
        <div class="agriya">Agriya</div>
        <ol class="list round-4 grid_6">
          <li class="round-4<?php if ($this->request->params['action'] == 'index') { ?> active<?php } ?>">1. Welcome</li>
          <li class="round-4<?php if ($this->request->params['action'] == 'requirements') { ?> active<?php } ?>">2. Server Requirments</li>
          <li class="round-4<?php if ($this->request->params['action'] == 'permissions') { ?> active<?php } ?>">3. File Permissions</li>
          <li class="round-4<?php if ($this->request->params['action'] == 'license') { ?> active<?php } ?>">4. License Configuration</li>
          <li class="round-4<?php if ($this->request->params['action'] == 'database') { ?> active<?php } ?>">5. Database</li>
          <li class="round-4<?php if ($this->request->params['action'] == 'configuration') { ?> active<?php } ?>">6. Burrow Configuration</li>
          <li class="round-4<?php if ($this->request->params['action'] == 'finish') { ?> active<?php } ?>">7. Installation is Complete!</li>
        </ol>
      </div>
      <div class="main-content grid_16">
        <?php
          echo $this->Layout->sessionFlash();
          echo $content_for_layout;
        ?>
      </div>
    </div>
    <div class="footer">
      <div class="footer-inner clearfix">
        <p>&copy;<?php echo date('Y'); ?> <a title="Burrow" href="http://burrow.dev.agriya.com/">Burrow</a>. All rights reserved.</p>
        <p class="powered clearfix"><span><a class="powered" target="_blank" title="Powered by Burrow" href="http://burrow.dev.agriya.com/">Powered by Burrow</a>,</span>
        <span>made in</span><a class="company" title="Agriya Web Development" target="_blank" href="http://www.agriya.com/">Agriya Web Development</a></p>
        <p><a class="cssilize" title="CSSilized by CSSilize, PSD to XHTML Conversion" target="_blank" href="http://www.cssilize.com/">CSSilized by CSSilize, PSD to XHTML Conversion</a></p>
      </div>
    </div>
  </div>
</div>
</body>
</html>