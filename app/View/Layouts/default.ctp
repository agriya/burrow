<!DOCTYPE html>
<html lang="<?php echo isset($_COOKIE['CakeCookie']['user_language']) ?  strtolower($_COOKIE['CakeCookie']['user_language']) : strtolower(Configure::read('site.language')); ?>">
<head>
<?php echo $this->Html->charset(), "\n";?>
<title><?php echo Configure::read('site.name') . ' | ' . $title_for_layout; ?></title>
<?php
if (!empty($meta_for_layout['keywords'])):
  echo $this->Html->meta('keywords', $meta_for_layout['keywords']), "\n";
endif;
?>
<?php
if (!empty($meta_for_layout['description'])):
  echo $this->Html->meta('description', $meta_for_layout['description']), "\n";
endif;
?>
<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js"></script>
<![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo $this->fetch('seo_paging'); ?>
<?php echo $this->Html->css('default.cache.'.Configure::read('site.version'), null, array('inline' => true)); ?>

<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->  
<!--[if IE 7]>
<?php echo $this->Html->css('font-awesome-ie7.css', null, array('inline' => true)); ?>

<![endif]-->
<!-- Le fav and touch icons -->
<?php
echo $this->Html->meta('icon'), "\n";
?>
<link rel="apple-touch-icon" href="<?php echo Router::url('/'); ?>apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo Router::url('/'); ?>apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo Router::url('/'); ?>apple-touch-icon-114x114.png" />
<link rel="logo" type="images/svg" href="<?php echo Router::url('/'); ?>img/logo.svg"/>
<link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
<link href="<?php echo Router::url(array('controller' => 'feeds', 'action' => 'index', 'ext' => 'rss'), true);?>" type="application/rss+xml" rel="alternate" title="RSS Feeds"/>
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
if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false || strpos(env('HTTP_USER_AGENT'), 'LinkedInBot')===false):
echo '<!--', "\n";
endif;
?>
<meta content="<?php echo Configure::read('facebook.app_id');?>" property="og:app_id" />
<meta content="<?php echo Configure::read('facebook.app_id');?>" property="fb:app_id" />
<?php if (!empty($meta_for_layout['property_name'])) { ?>
<meta property="og:title" content="<?php echo $meta_for_layout['property_name'];?>"/>
<?php } ?>
<?php if (!empty($meta_for_layout['view_image'])) { ?>
<meta property="og:image" content="<?php echo $meta_for_layout['view_image'];?>"/>
<?php } else { ?>
<meta property="og:image" content="<?php echo Router::url('/', true) . 'img/logo.png';?>"/>
<?php } ?>
<meta property="og:site_name" content="<?php echo Configure::read('site.name'); ?>"/>
<?php if (Configure::read('facebook.fb_user_id')): ?>
<meta property="fb:admins" content="<?php echo Configure::read('facebook.fb_user_id'); ?>"/>
<?php endif; ?>
<?php
if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false || strpos(env('HTTP_USER_AGENT'), 'LinkedInBot')===false):
echo '-->', "\n";
endif;
?>
<?php
echo $this->element('site_tracker', array('cache' => array('config' => 'sec')));
$response = Cms::dispatchEvent('View.IntegratedGoogleAnalytics.pushScript', $this);
echo !empty($response->data['content']) ? $response->data['content'] : '';
?>
<?php echo $scripts_for_layout; ?>
<?php
if (env('HTTP_X_PJAX') != 'true') {
	echo $this->fetch('highperformance');
}
?>
<!--[if IE]><?php echo $this->Javascript->link('libs/excanvas.js', true); ?><![endif]-->
</head>
<body>
	<div id="<?php echo $this->Html->getUniquePageId();?>" class="content clearfix">
	<div class="wrapper">
		<?php if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) { ?>
			<div class="alab hide">
				<div class="clearfix admin-wrapper pr">
					<ul class="pull-left unstyled clearfix mob-clr">
					<li class="text-16">
						<?php echo $this->Html->link((Configure::read('site.name').' '.'<span class="sfont">Admin</span>'), array('controller' => 'users', 'action' => 'stats', 'admin' => true), array('escape' => false, 'class' => 'js-no-pjax mob-clr mob-dc', 'title' => (Configure::read('site.name').' '.'Admin')));?>
					</li>
					</ul>
					<ul class="pull-right right-mspace unstyled clearfix mob-clr">
						<li class="top-mspace logout"><?php echo $this->Html->link(__l('Logout'), array('controller' => 'users' , 'action' => 'logout', 'admin' => true), array( 'class' => 'js-no-pjax  mob-clr mob-dc', 'title' => __l('Logout'))); ?></li>
					</ul>
					<p class="logged-info  dc text-11 ver-smspace mob-clr"><?php echo __l('You are logged in as Admin'); ?></p>
					<div class="container con-height clearfix pr">
						<div class="js-alab hide"></div>
					</div>
				</div>
			</div>
		<?php } else { ?>
			<?php if($this->Auth->sessionValid() && $this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
				<div class="clearfix admin-wrapper pr">
					<ul class="pull-left unstyled clearfix mob-clr">
					<li class="text-16">
						<?php echo $this->Html->link((Configure::read('site.name').' '.'<span class="sfont">Admin</span>'), array('controller' => 'users', 'action' => 'stats', 'admin' => true), array('escape' => false, 'class' => 'js-no-pjax mob-clr mob-dc', 'title' => (Configure::read('site.name').' '.'Admin')));?>
					</li>
					</ul>
					<ul class="pull-right right-mspace unstyled clearfix mob-clr">
						<li class="top-mspace logout"><?php echo $this->Html->link(__l('Logout'), array('controller' => 'users' , 'action' => 'logout', 'admin' => true), array( 'class' => 'js-no-pjax  mob-clr mob-dc', 'title' => __l('Logout'))); ?></li>
					</ul>
					<p class="logged-info  dc text-11 ver-smspace"><?php echo __l('You are logged in as Admin'); ?></p>
					<div class="container con-height clearfix pr">
						<div class="js-alab alap">
						<?php 
							if ($this->request->params['controller']=='properties' && $this->request->params['action']=='view') {
								echo $this->element('admin_panel_property_view', array('controller' => 'properties', 'action' => 'index', 'property' => $property));  
							} else if ($this->request->params['controller']=='requests' && $this->request->params['action']=='view'){
								echo $this->element('admin_panel_request_view', array('controller' => 'requests', 'action' => 'index', 'request' => $request));
							} else if ($this->request->params['controller']=='users' && $this->request->params['action']=='view'){
								echo $this->element('admin_panel_user_view');
							} 
						?>
						</div>
					</div>
				</div>
			<?php endif; ?>
		<?php } ?>
		<?php if($this->request->params['action']!='calendar_edit' ): ?>
			<header id="header" itemscope itemtype="http://schema.org/Organization">
			  <div class="navbar z-top no-mar">
				<div class="navbar-inner sep-bot no-round">
				  <div class="container">
						<h1 class="pull-left no-mar top-space"><?php echo $this->Html->link($this->Html->image('logo.png', array('itemprop' => 'logo','alt'=>'[Image: Burrow]')), '/',array('escape'=>false,'title'=>Configure::read('site.name'),'itemprop'=>'url'));?></h1>
						<a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar ver-smspace collapsed js-no-pjax"> <i class="icon-align-justify icon-24 no-pad grayc"></i></a>
						<?php echo $this->element('header', array('config' => 'sec')); ?>
					</div>
				</div>
			   </div>
			</header>
		<?php endif; ?>
		<?php
			//lazy loading image
			$lazy_allowed=true;
			//Lazy load image not allowed cases
			if($this->request->params['controller'].'/'.$this->request->params['action'] =='properties/view' || $this->request->params['controller'].'/'.$this->request->params['action'] =='properties/search' || $this->request->params['controller'].'/'.$this->request->params['action'] =='transactions/index' || (isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='collection')):
				$lazy_allowed=false;
			endif;
			if(($this->request->params['controller'].'/'.$this->request->params['action'] ==='properties/search') || ($this->request->params['controller'].'/'.$this->request->params['action'] ==='properties/view'))
				$homeClass	=	' bot-space ';
			else
				$homeClass	=	' container ';
		?>
			<section id="pjax-body">
				<?php 
				if (env('HTTP_X_PJAX') == 'true') {
					echo $this->fetch('highperformance'); 
				}
				?>
				<?php echo $this->Layout->sessionFlash(); ?>
				<section id="main" class="clearfix bot-space <?php echo $this->Html->getUniquePageId();?> bot-mspaces <?php echo $homeClass; if($lazy_allowed): ?>js-lazyload<?php endif; ?>">
						<?php echo $content_for_layout;?>
				</section>
			</section>
			<div class="footer-push"></div>
		</div>
		<?php if($this->request->params['action'] != 'calendar_edit'): ?>
		<footer id="footer" class="hor-space" itemscope itemtype="http://schema.org/WPFooter">
			<?php if (Configure::read('widget.footer_script')) { ?>
				  <div class="dc clearfix bot-space">
				  <?php echo Configure::read('widget.footer_script'); ?>
				  </div>
			<?php } ?>
			<div class="sep-top sep-medium ">
			<div class="container clearfix top-space">
			<div class="span18 clearfix">
				<ul class="unstyled clearfix top-space pull-left mob-clr">
					<li class="span no-mar"><?php echo $this->Html->link(__l('Terms & Conditions'), array('controller' => 'pages', 'action' => 'view', 'term-and-conditions', 'admin' => false), array('title' => __l('Terms & Conditions')));?></li>
					<li class="span"><?php echo $this->Html->link(__l('Privacy Policy'), array('controller' => 'pages', 'action' => 'view', 'privacy_policy', 'admin' => false), array('title' => __l('Privacy Policy')));?></li>
					<li class="span"><?php echo $this->Html->link( __l('How it Works'), array('controller' => 'pages', 'action' => 'how_it_works', 'admin' => false), array('title' => __l('How it Works'), 'escape' => false));?></li>
					<li class="span"><?php echo $this->Html->link(__l('Acceptable Use Policy'), array('controller' => 'pages', 'action' => 'view', 'aup', 'admin' => false), array('title' => __l('Acceptable Use Policy')));?> </li>
					<li class="span"><?php echo $this->Html->link(__l('Contact Us'), array('controller' => 'contacts', 'action' => 'add', 'admin' => false), array('title' => __l('Contact Us'), 'class' => 'js-no-pjax'));?></li>
					<li class="span"><?php echo $this->Html->link(__l('Map'), array('controller' => 'properties', 'action' => 'map', 'admin' => false), array('title' => __l('Map'), 'class' => 'js-no-pjax'));?></li>
					<?php if(isPluginEnabled('Collections')) : ?>
						<li class="span"><?php echo $this->Html->link(__l('Collections'), array('controller' => 'collections', 'action' => 'index', 'admin' => false), array('title' => __l('Collections')));?></li>
					<?php endif;?>
				</ul>
				<div class="clearfix top-space graydarkc pull-left span18">
					<p class="span no-mar" itemprop="copyrightYear">&copy; <?php echo date('Y');?> <?php echo $this->Html->link(Configure::read('site.name'), '/', array('title' => Configure::read('site.name'),'itemprop'=>'copyrightHolder', 'escape' => false));?>. <?php echo __l('All rights reserved');?>.</p>
					<p class="clearfix span">
						<span class="pull-left"><a href="http://burrow.dev.agriya.com" title="<?php echo 'Powered by Burrow'; ?>" target="_blank" class="powered pull-left"><?php echo 'Powered by Burrow'; ?></a>,</span>
						<span class="pull-left"><?php echo 'Made in'; ?></span><?php echo $this->Html->link('Agriya Web Development', 'http://www.agriya.com/', array('target' => '_blank', 'title' => 'Agriya Web Development', 'class' => 'company pull-left'));?>  <span class="pull-left"><?php echo Configure::read('site.version');?></span></p>
					<p  id="cssilize" class="span"><?php echo $this->Html->link('CSSilized by CSSilize, PSD to XHTML Conversion', 'http://www.cssilize.com/', array('target' => '_blank', 'title' => 'CSSilized by CSSilize, PSD to XHTML Conversion', 'class' => ' cssilize'));?></p>			  
				</div>
			</div>  
				<ul class="unstyled clearfix pull-right mob-clr">
					<li class="grayc pull-left"><a class="grayc" href="<?php echo Configure::read('facebook.site_facebook_url'); ?>" title="Follow me on facebook" target="_blank"><i class="icon-facebook-sign text-32"></i></a> </li>
					<li class="grayc pull-left"><a class="grayc" href="<?php echo Configure::read('twitter.site_twitter_url'); ?>" title="Follow me on twitter" target="_blank"> <i class=" icon-twitter-sign text-32"></i></a> </li>					
				</ul>				  
			</div>
			</div>
		  </footer>
		<?php endif; ?>
	</div>
	<!-- for modal -->
	<div class="modal hide fade" id="js-ajax-modal">
	<div class="modal-body"></div>
	<div class="modal-footer"><a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a></div>
	<!-- for modal -->
</div>
	<?php // echo $cakeDebug?>
	</body>
</html>
