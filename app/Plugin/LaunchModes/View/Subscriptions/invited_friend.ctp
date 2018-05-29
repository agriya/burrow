<div class="space clearfix">
<span class="span10 invited clearfix">
<span  class="pull-left">
<span class="pull-left hor-space">
<?php
  echo $this->Html->getUserAvatar($this->request->data['User'], 'micro_thumb', false);
?>
</span>
<?php
	echo __l('Invitation code from ');
?>
</span>

<span class="pull-left">
   <?php
		echo sprintf(__l('%s is accepted'), $this->request->data['User']['username']);
	?>
	</span>
</span>
</div>
<div class="clearfix">
  <div class="clearfix">
    <div class="clearfix space">
    <span class="text-16 pull-left space textb"><?php echo __l('Sign In using'); ?></span>
    <ul class="unstyled row span">
      <?php if (Configure::read('facebook.is_enabled_facebook_connect')){ ?>
        <li class="top-smspace span1">
          <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'facebook', 'admin' => false), true); ?>
          <?php echo $this->Html->link('<i class="icon-facebook-sign facebookc text-24"></i><span class="hide">Facebook</span>', '#', array('escape' => false,'class' =>
          "no-under js-connect js-no-pjax {'url':'$url'}")); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('twitter.is_enabled_twitter_connect')){ ?>
        <li class="top-smspace span1">
          <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'twitter', 'admin' => false), true); ?>
          <?php echo $this->Html->link('<i class="icon-twitter-sign twitterc text-24"></i><span class="hide">Twitter</span>', '#', array('escape' => false, 'class' => "no-under js-connect js-no-pjax {'url':'$url'}")); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('linkedin.is_enabled_linkedin_connect')){ ?>
        <li class="top-smspace span1">
          <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'linkedin', 'admin' => false), true); ?>
          <?php echo $this->Html->link('<i class="icon-linkedin-sign linkedc text-24"></i><span class="hide">LinkedIn</span>', '#', array('escape' => false, 'class' => "no-under js-connect js-no-pjax {'url':'$url'}")); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('yahoo.is_enabled_yahoo_connect')){ ?>
        <li class="top-smspace span1">
          <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'yahoo', 'admin' => false), true); ?>
          <?php echo $this->Html->link('<i class="icon-yahoo yahooc text-24"></i><span class="hide">Yahoo!</span>', '#', array('escape' => false, 'class' => "no-under js-connect js-no-pjax {'url':'$url'}")); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('google.is_enabled_google_connect')) { ?>
        <li class="top-smspace span1">
          <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'google', 'admin' => false), true); ?>
          <?php echo $this->Html->link('<i class="icon-google-sign googlec text-24"></i><span class="hide">Google</span>', '#', array('escape' => false,'class' => "no-under js-connect js-no-pjax {'url':'$url'}")); ?>
        </li>
      <?php } ?>
						<?php if (Configure::read('googleplus.is_enabled_googleplus_connect')) { ?>
        <li class="top-smspace span1">
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'googleplus', 'admin' => false), true); ?>
        <?php echo $this->Html->link('<i class="icon-google-plus-sign googleplusc text-24"></i><span class="hide">Google+</span>', '#', array('title' => 'Google+', 'escape' => false,'class' => "no-under js-connect js-no-pjax {'url':'$url'}")); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('openid.is_enabled_openid_connect')) { ?>
        <li class="no-mar span1 stack">
          <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'openid', 'admin' => false), true); ?>
          <?php echo $this->Html->link(__l('OpenID'), '#', array('escape' => false,'class' => "no-under open-id show js-connect js-no-pjax {'url':'$url'}")); ?>
        </li>
      <?php } ?>
     </ul>
    </div>
  </div>
  <span class="show"><?php echo __l("If you don't want to sign up with a social network,") . ' ' .$this->Html->link(__l('click here') . '.', array('controller' => 'users', 'action' => 'register'), array('title' => __l('Click here'))); ?></span>
</div>