<h2 class="ver-space top-mspace text-32 sep-bot"><?php echo $this->pageTitle; ?></h2>
<div class="row space thumbnail">
  <div class="clearfix">
  <div class="row page-header">
    <div class="span"><span class="label span4 share-follow <?php echo ($this->request->params['named']['type'] == 'facebook')? 'badge-module' : ''; ?>"><?php echo __l('Facebook'); ?></span></div>
    <div class="span"><span class="label span4 share-follow <?php echo ($this->request->params['named']['type'] == 'twitter') ? 'badge-module' : ''; ?>"><?php echo __l('Twitter'); ?></span></div>
    <div class="span"><span class="label span4 share-follow <?php echo ($this->request->params['named']['type'] == 'gmail')? 'badge-module' : ''; ?>"><?php echo __l('Gmail'); ?></span></div>
    <div class="span"><span class="label span4 share-follow <?php echo ($this->request->params['named']['type'] == 'yahoo')? 'badge-module' : ''; ?>"><?php echo __l('Yahoo!'); ?></span></div>
  </div>
  </div>
  <?php $user = $this->Html->getCurrUserInfo($this->Auth->user('id'));?>
  <div class="ver-space mspace">
    <div class="tab-content" id="myTabContent">
      <?php if ($this->request->params['named']['type'] == 'facebook') { ?>
        <div id="facebook" class="loader fade in active" data-fb_app_id="<?php echo Configure::read('facebook.app_id') ?>">
          <?php
            if (!empty($user['User']['facebook_access_token'])) {
              $replace_content = array(
                '##SITE_NAME##' => Configure::read('site.name'),
                '##REFERRAL_URL##' => Router::url(array('controller' => 'users', 'action' => 'refer',  'r' =>$this->Auth->user('username')), true)
              );
              $share_content = strtr(Configure::read('invite.facebook'), $replace_content);
              $feed_url = 'https://www.facebook.com/dialog/apprequests?app_id=' . Configure::read('facebook.app_id') . '&display=iframe&access_token=' . $user['User']['facebook_access_token'] . '&show_error=true&link=' . Router::url('/', true) . '&message=' . $share_content. '&data=' . $this->Auth->user('id') . '&redirect_uri=' . Router::url('/', true) . 'social_marketings/publish_success/invite';
          ?>
			  <div id="js-fb-login-check" class="hide">
              <div class="span16">
                <iframe src="<?php echo $feed_url; ?>" height="500" width="500"  frameborder="0" scrolling="no"></iframe>
              </div>
              <div class="span5">
                <?php echo $this->element('follow-friends', array('type' => 'facebook', 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
              </div>
			  </div>
          <?php
            }
              $connect_url = Router::url(array(
                'controller' => 'social_marketings',
                'action' => 'import_friends',
                'type' => 'facebook',
                'import' => 'facebook',
              ), true);
          ?>
		  <div id="js-fb-invite-friends-btn" class="hide">
          <div class="alert alert-info"><?php echo __l("We couldn't find any of your friends from Facebook because you haven't connected with Facebook. Click the button below to connect.")?></div>
          <div class="dc"><?php echo $this->Html->link($this->Html->image('find-friends-facebook.png', array('alt' => __l('Find Friends From Facebook'), 'class'=>'js-connect js-no-pjax {"url":"'.$connect_url.'"}')), array('controller' => 'social_marketings', 'action' => 'import_friends', 'type' => $this->request->params['named']['type'], 'import' => 'facebook'), array('title' => __l('Find Friends From Facebook'),'escape' => false)); ?></div></div>
		 </div>
      <?php } elseif ($this->request->params['named']['type'] == 'twitter') { ?>
        <div id="twitter">
          <?php if (!empty($user['User']['is_twitter_connected'])) { ?>
            <?php
				$replace_content = array(
				"##SITE_NAME##"=> Configure::read('site.name'),
				"##REFERRAL_URL##"=> Router::url(array('controller' => 'users', 'action' => 'refer',  'r' =>$this->Auth->user('username')), true)
				);
				$default_content = strtr(Configure::read('invite.twitter'), $replace_content);
			?>
			<div class="span16 space">&nbsp;
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo Router::url('/', true); ?>" data-text="<?php echo $default_content;?>" data-size="large">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div>
            <div class="span5">
              <?php echo $this->element('follow-friends', array('type' => 'twitter', 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
            </div>
          <?php } else { ?>
            <?php
              $connect_url = Router::url(array(
                'controller' => 'social_marketings',
                'action' => 'import_friends',
                'type' => 'twitter',
                'import' => 'twitter',
              ), true);
            ?>
            <div class="alert alert-info"><?php echo __l("We couldn't find any of your friends from Twitter because you haven't connected with Twitter. Click the button below to connect.")?></div>
            <div class="dc"><?php echo $this->Html->link($this->Html->image('find-friends-twitter.png', array('alt' => __l('Find Friends From Twitter'), 'class'=>'js-connect js-no-pjax {"url":"' . $connect_url . '"}')), $connect_url, array('title' => __l('Find Friends From Twitter'), 'escape' => false)); ?></div>
          <?php } ?>
        </div>
      <?php } elseif ($this->request->params['named']['type'] == 'gmail') { ?>
        <div id="gmail">
          <?php if (!empty($user['User']['is_google_connected'])) { ?>
            <?php  echo $this->element('contacts-index', array('type' => 'gmail')); ?>
          <?php } else { ?>
            <?php
              $connect_url = Router::url(array(
                'controller' => 'social_marketings',
                'action' => 'import_friends',
                'type' => $this->request->params['named']['type'],
                'import' => 'google',
              ), true);
            ?>
            <div class="alert alert-info"><?php echo __l("We couldn't find any of your friends from Gmail because you haven't connected with Gmail. Click the button below to connect.")?></div>
            <div class="dc"><?php echo $this->Html->link($this->Html->image('find-friends-gmail.png', array('alt' => __l('Find Friends From Gmail'), 'class'=>'js-connect js-no-pjax {"url":"'.$connect_url.'"}')), array('controller' => 'social_marketings', 'action' => 'import_friends', 'type' => $this->request->params['named']['type'], 'import' => 'google'), array('title' => __l('Find Friends From Gmail'), 'escape' => false)); ?></div>
          <?php } ?>
        </div>
      <?php } elseif ($this->request->params['named']['type'] == 'yahoo') { ?>
        <div id="yahoo">
          <?php if (!empty($user['User']['is_yahoo_connected'])) { ?>
             <?php  echo $this->element('contacts-index', array('type' => 'yahoo')); ?>
          <?php } else { ?>
            <?php
              $connect_url = Router::url(array(
                'controller' => 'social_marketings',
                'action' => 'import_friends',
                'type' => $this->request->params['named']['type'],
                'import' => 'yahoo',
              ), true);
              $connect_url.= '?r=' . $this->request->url;
            ?>
            <div class="alert alert-info"><?php echo __l("We couldn't find any of your friends from Yahoo! because you haven't connected with Yahoo. Click the button below to connect.")?></div>
            <div class="dc"><?php echo $this->Html->link($this->Html->image('find-friends-yahoo.png', array('alt' => __l('Find Friends From Yahoo!'), 'class'=>'js-connect js-no-pjax {"url":"'.$connect_url.'"}')), array('controller' => 'social_marketings', 'action' => 'import_friends', 'type' => $this->request->params['named']['type'], 'import' => 'yahoo'), array('title' => __l('Find Friends From Yahoo'), 'escape' => false)); ?></div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </div>
  <div class="form-actions">
    <?php
      if ($this->request->params['named']['type'] == 'yahoo') {
        echo $this->Html->link(__l('Done'), array('controller' => 'users', 'action' => 'dashboard'), array('title' => __l('Done'), 'class' => 'btn pull-right js-bootstrap-tooltip mspace'));
      } else {
        echo $this->Html->link(__l('Skip') . ' >>', array('controller' => 'social_marketings', 'action' => 'import_friends',  'type' => $next_action), array('title' => 'Skip', 'class' => 'blackc pull-right js-bootstrap-tooltip mspace'));
      }
    ?>
  </div>
</div>
<div id="fb-root"></div>