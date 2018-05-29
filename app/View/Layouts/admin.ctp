<!DOCTYPE html>
<html lang="<?php echo isset($_COOKIE['CakeCookie']['user_language']) ?  strtoupper($_COOKIE['CakeCookie']['user_language']) : strtoupper(Configure::read('site.language')); ?>">
<head>
<?php echo $this->Html->charset(), "\n";?>
<title><?php echo Configure::read('site.name') . ' | ' . $title_for_layout; ?></title>
<?php   
echo $this->Html->meta('keywords', $meta_for_layout['keywords']), "\n";
echo $this->Html->meta('description', $meta_for_layout['description']), "\n";
?>
<!--[if lt IE 9]>
<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js"></script>
<![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo $this->Html->css('admin.cache.'.Configure::read('site.version'), null, array('inline' => true)); ?>

<!--[if IE 7]>
<?php echo $this->Html->css('font-awesome-ie7.css', null, array('inline' => true)); ?>

<![endif]-->
<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<?php
  echo $this->Html->meta('icon'), "\n";
?>
<link rel="apple-touch-icon" href="<?php echo Router::url('/'); ?>apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo Router::url('/'); ?>apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo Router::url('/'); ?>apple-touch-icon-114x114.png" />
<link rel="logo" type="images/svg" href="<?php echo Router::url('/'); ?>img/logo.svg"/>
<link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]--> 
<?php
  $cms = $this->Layout->js();
  $js_inline = 'var cfg = ' . $this->Js->object($cms) . ';';
  $js_inline .= "document.documentElement.className = 'js';";
  $js_inline .= "(function() {";
  $js_inline .= "var js = document.createElement('script'); js.type = 'text/javascript'; js.async = true;";
  $js_inline .= "js.src = \"" . $this->Html->assetUrl('admin.cache.'.Configure::read('site.version'), array('pathPrefix' => JS_URL, 'ext' => '.js')) . "\";";
  $js_inline .= "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(js, s);";
  $js_inline .= "})();";
  echo $this->Javascript->codeBlock($js_inline, array('inline' => true));
  echo $scripts_for_layout;
?>
<!--[if IE]><?php echo $this->Javascript->link('libs/excanvas.js', true); ?><![endif]-->
<?php
	$jsapi_menu = array('admin_stats', 'admin_analytics_chart');
	if (in_array($this->request->params['action'], $jsapi_menu)) {
?>
	<script type="text/javascript" src="//www.google.com/jsapi"></script>
	<script type="text/javascript">
		google.load('visualization', '1', {'packages':['corechart']});
		google.load('visualization', '1', {'packages': ['geochart']});
   </script>
<?php
	}
?>
</head>
<body>
<div id="<?php echo $this->Html->getUniquePageId();?>" class="content">
  <div class="wrapper">
    <header id="header">
          <?php
            echo $this->element('admin/header');
            if ($this->request->params['controller'] != 'attachments'):
              echo $this->element('admin/navigation');
            endif;
          ?>
    </header>
	<section id="pjax-body">
		<?php echo $this->Layout->sessionFlash(); ?>
		<section id="main" class="clearfix">
			<?php echo $this->element('admin/main'); ?>
		</section>
	</section>
    <div class="footer-push"></div>
  </div>
   <?php echo $this->element('admin/footer'); ?>
</div>
</body>
</html>
