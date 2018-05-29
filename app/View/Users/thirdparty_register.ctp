 <h2 class="ver-space sep-bot top-mspace text-32"><?php echo __l('Register'); ?></h2>
 <article class="thumbnail clearfix">
<?php if (!empty($referredByUser)) { ?>
  <div class="clearfix page-header ver-mspace top-space">
    <div class="space offset6 clearfix">
      <div class="pull-left">
        <?php echo $this->Html->getUserAvatar($referredByUser['User'], 'micro_thumb', 0); ?>
      </div>
      <h4 class="span14 invited pull-left ver-space">
        <?php echo sprintf(__l('%s has invited you to join %s'), $referredByUser['User']['username'], Configure::read('site.name')); ?>
      </h4>
    </div>
  </div>
<?php } ?>
  <div class="page-header">
  <h4 class="dc textb"><?php echo __l('Quick Sign Up');?></h4>
  </div>
  <div class="row offset4 ver-space login-block login-twtface dc">
  <div class="page-header ver-space span15 no-mar">
    <?php if (Configure::read('facebook.is_enabled_facebook_connect')): ?>
    <div class="span7 pr">
      <?php if (isPluginEnabled('SocialMarketing')) { ?>
      <span class="js-facepile-loader loader pull-left offset1 pa space"></span>
      <span id="js-facepile-section" class="{'fb_app_id':'<?php echo Configure::read('facebook.app_id'); ?>'} sfont"></span>
      <?php } ?>
      &nbsp;
    </div>
    <div class="span7">
      <p class="row">
      <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'facebook', 'admin' => false), true); ?>
      <?php echo $this->Html->link($this->Html->image('facebook.png', array('alt' => __l('Login with Facebook'))), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}")); ?>
      </p>
    </div>
    <?php endif; ?>
  </div>
  </div>
  <?php if (Configure::read('twitter.is_enabled_twitter_connect')): ?>
    <?php if (Configure::read('facebook.is_enabled_facebook_connect')): ?>
      <h4 class="dc pr"><span class="space or-hor pa"><?php echo __l('Or');?></span></h4>
    <?php endif; ?>
  <div class="row page-header space no-border no-mar">
    <div class="bot-space offset8">
      <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'twitter', 'admin' => false), true); ?>
      <p class="row ver-space"><?php echo $this->Html->link($this->Html->image('twitter.png', array('alt' => __l('Login with Twitter'))), '#', array('escape' => false, 'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
    </div>
  </div>
  <h4 class="dc pr"><span class="or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <?php endif;?>
  <?php if(Configure::read('linkedin.is_enabled_linkedin_connect')):?>
    <?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect'))): ?>
	  <h4 class="dc pr"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
	<?php endif;?>
  <div class="row page-header space no-border no-mar">
    <div class="bot-space offset8">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'linkedin', 'admin' => false), true); ?>
    <p class="row ver-space"><?php echo $this->Html->link($this->Html->image('login-linkedin.png', array('alt' => __l('Login with LinkedIn'))), '#', array('escape' => false, 'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
    </div>
  </div>
    <h4 class="dc pr"><span class="space or-hor pa textb">Or</span></h4>
  <?php endif;?>
  <?php if(Configure::read('yahoo.is_enabled_yahoo_connect')):?>
  <?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect') || Configure::read('linkedin.is_enabled_linkedin_connect'))): ?>
  <h4 class="dc pr"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
    <?php endif; ?>
  <div class="row page-header space no-border no-mar login-twtface">
    <div class="offset8 bot-space">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'yahoo', 'admin' => false), true); ?>
    <p class="row ver-space"><?php echo $this->Html->link($this->Html->image('login-yahoo.png', array('alt' => __l('Login with Yahoo!'))), '#', array('escape' => false, 'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
    </div>
  </div>
    <h4 class="dc pr"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <?php endif;?>
  <?php if(Configure::read('google.is_enabled_google_connect')):?>
    <?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect') || Configure::read('linkedin.is_enabled_linkedin_connect') || Configure::read('yahoo.is_enabled_yahoo_connect'))): ?>
      <h4 class="dc pr"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
    <?php endif;?>
  <div class="row page-header space no-border no-mar login-twtface">
    <div class="offset8 bot-space">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'google', 'admin' => false), true); ?>
    <p class="row ver-space"><?php echo $this->Html->link($this->Html->image('login-google.png', array('alt' => __l('Login with Google'))), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
    </div>
  </div>
    <h4 class="dc pr"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <?php endif;?>
  <?php if(Configure::read('googleplus.is_enabled_googleplus_connect')):?>
    <?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect') || Configure::read('linkedin.is_enabled_linkedin_connect') || Configure::read('yahoo.is_enabled_yahoo_connect') ||  Configure::read('google.is_enabled_google_connect'))): ?>
      <h4 class="dc pr"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
    <?php endif;?>
  <div class="row page-header space no-border no-mar login-twtface">
    <div class="offset8 bot-space">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'googleplus', 'admin' => false), true); ?>
    <p class="row ver-space"><?php echo $this->Html->link($this->Html->image('login-googleplus.png', array('alt' => __l('Login with GooglePlus'))), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
    </div>
  </div>
    <h4 class="dc pr"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <?php endif;?>
  <?php if(Configure::read('openid.is_enabled_openid_connect')):?>
    <?php if((Configure::read('twitter.is_enabled_twitter_connect') || Configure::read('facebook.is_enabled_facebook_connect') || Configure::read('linkedin.is_enabled_linkedin_connect') || Configure::read('yahoo.is_enabled_yahoo_connect') ||  Configure::read('google.is_enabled_google_connect') || Configure::read('googleplus.is_enabled_googleplus_connect'))): ?>
      <h4 class="dc pr"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
    <?php endif;?>
  <div class="row page-header space no-border login-twtface">
    <div class="offset8 bot-space">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'openid', 'admin' => false), true); ?>
    <p class="row"><?php echo $this->Html->link($this->Html->image('login-openid.png', array('alt' => __l('Login with OpenId'))), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
    </div>
  </div>
    <h4 class="dc pr"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <?php endif; ?>
  <div class="offset7 span10 dc">
  <p><span class="show"><?php echo __l('Sign up with a social network to follow your friends ') ?></span> <span class="show"><?php echo __l('By signing up you agree to the  '); ?><?php echo $this->Html->link(__l('Terms & Conditions'), array('controller' => 'pages', 'action' => 'view', 'term-and-conditions'), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => __l('Terms & Conditions'), 'escape' => false)); ?></span><span class="show"><?php echo __l("If you don't want to sign up with a social network,") . ' ' .$this->Html->link(__l('click here'), array('controller' => 'users', 'action' => 'register'), array('title' => __l('Click here'), 'class' => 'js-no-pjax')) . '.'; ?></span></p>
  <p><?php echo __l('Already have an account?') . ' ' . $this->Html->link(__l('Login'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Login'))); ?></p>
  </div>
</article>
<div id="fb-root"></div>