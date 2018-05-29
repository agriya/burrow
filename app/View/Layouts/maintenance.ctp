<!DOCTYPE html>
<html lang="en">
<head>
<?php echo $this->Html->charset(), "\n";?>
<title><?php echo Configure::read('site.name') . ' | ' . $title_for_layout; ?></title>
<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js"></script>
<![endif]-->
<?php
echo $this->Html->meta('icon'), "\n";
if (!empty($meta_for_layout['keywords'])):
echo $this->Html->meta('keywords', $meta_for_layout['keywords']), "\n";
endif;
if (!empty($meta_for_layout['description'])):
echo $this->Html->meta('description', $meta_for_layout['description']), "\n";
endif;
?>
<link rel="apple-touch-icon" href="<?php echo Router::url('/'); ?>apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo Router::url('/'); ?>apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo Router::url('/'); ?>apple-touch-icon-114x114.png" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
<?php echo $this->Html->css('maintenance.cache.'.Configure::read('site.version'), null, array('inline' => true)); ?>
<!--[if IE 7]>
<?php echo $this->Html->css('font-awesome-ie7.css', null, array('inline' => true)); ?>
<![endif]-->
<?php
$cms = $this->Layout->js();
$js_inline = 'var cfg = ' . $this->Js->object($cms) . ';';
$js_inline .= "document.documentElement.className = 'js';";
$js_inline .= "(function() {";
$js_inline .= "var js = document.createElement('script'); js.type = 'text/javascript'; js.async = true;";
$js_inline .= "js.src = \"" . $this->Html->assetUrl('default.cache.'.Configure::read('site.version'), array('pathPrefix' => JS_URL, 'ext' => '.js')) . "\";";
$js_inline .= "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(js, s);";
$js_inline .= "})();";
echo $this->Javascript->codeBlock($js_inline, array('inline' => true));
// For other than Facebook (facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)), wrap it in comments for XHTML validation...
if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit') === false):
echo '<!--', "\n";
endif;
?>
<meta content="<?php echo Configure::read('facebook.fb_app_id');?>" property="og:app_id" />
<meta content="<?php echo Configure::read('facebook.fb_app_id');?>" property="fb:app_id" />
<?php if (!empty($meta_for_layout['title'])) { ?>
<meta property="og:title" content="<?php echo $meta_for_layout['title'];?>"/>
<?php } ?>
<?php if (!empty($meta_for_layout['project_image'])) { ?>
<meta property="og:image" content="<?php echo $meta_for_layout['project_image'];?>"/>
<?php } else { ?>
<meta property="og:image" content="<?php echo $this->Html->assetUrl('logo.png', array('pathPrefix' => IMAGES_URL));?>"/>
<?php } ?>
<meta property="og:site_name" content="<?php echo Configure::read('site.name'); ?>"/>
<?php if (Configure::read('facebook.fb_user_id')): ?>
<meta property="fb:admins" content="<?php echo Configure::read('facebook.fb_user_id'); ?>"/>
<?php endif; ?>
<?php
if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false):
echo '-->', "\n";
endif;
?>
<?php
echo $this->element('site_tracker', array('cache' => array('config' => 'sec')));
$response = Cms::dispatchEvent('View.IntegratedGoogleAnalytics.pushScript', $this, array(
'data' => $this->request->data
));
echo !empty($response->data['content'])?$response->data['content']:'';
?>
<?php echo $scripts_for_layout; ?>
</head>
  <body class="maintanace">
    <div id="<?php echo $this->Html->getUniquePageId();?>" class="content">
      <?php echo $this->Layout->sessionFlash(); ?>
      <div class="beta-block">
        <section class="thumbnail dc space thumb-alpha">
          <h1 class="ver-mspace top-space"><?php echo $this->Html->link($this->Html->image('logo.png'),  Router::url('/', true) ,array('title' => Configure::read('site.name'),'escape' => false, 'class'=>"brand"));?></h1>
          <?php echo $content_for_layout; ?>
        </section>
      </div>
    </div>
  </body>
</html>