<div class="users form register-form-block">
<h2 class="ver-space sep-bot top-mspace text-32"><?php echo __l('Register'); ?></h2>
<?php echo $this->Form->create('User', array('action' => 'register', 'class' => 'form-horizontal space')); ?>

 <?php if(Configure::read('twitter.is_enabled_twitter_connect') OR Configure::read('facebook.is_enabled_facebook_connect') OR Configure::read('linkedin.is_enabled_linkedin_connect') OR Configure::read('yahoo.is_enabled_yahoo_connect') OR  Configure::read('google.is_enabled_google_connect') OR Configure::read('googleplus.is_enabled_googleplus_connect') OR Configure::read('openid.is_enabled_openid_connect')) {?>
<div class="clearfix sep-bot ver-mspace">
    <div class="ver-space ver-mspace clearfix register-social-icons">
      <h4 class="offset6 space span dc textb"><?php echo __l('Sign In using'); ?></h4>
      <ul class="unstyled top-mspace row span bot-space">
      <?php if (Configure::read('facebook.is_enabled_facebook_connect')){ ?>
        <li class="no-mar span pull-left mob-dc">
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'facebook', 'admin' => false), true); ?>
        <?php echo $this->Html->link('<i class="icon-facebook-sign facebookc text-24"></i><span class="hide">Facebook</span>', '#', array('title' => 'Facebook', 'escape' => false,'class' =>
        "no-under js-connect js-no-pjax {'url':'$url'}")); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('twitter.is_enabled_twitter_connect')){ ?>
        <li class="no-mar span pull-left mob-dc">
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'twitter', 'admin' => false), true); ?>
        <?php echo $this->Html->link('<i class="icon-twitter-sign twitterc text-24"></i><span class="hide">Twitter</span>', '#', array('title' => 'Twitter', 'escape' => false, 'class' => "no-under js-connect js-no-pjax {'url':'$url'}")); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('linkedin.is_enabled_linkedin_connect')){ ?>
        <li class="no-mar span pull-left mob-dc">
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'linkedin', 'admin' => false), true); ?>
        <?php echo $this->Html->link('<i class="icon-linkedin-sign linkedc text-24"></i><span class="hide">LinkedIn</span>', '#', array('title' => 'LinkedIn', 'escape' => false, 'class' => "no-under js-connect js-no-pjax {'url':'$url'}")); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('yahoo.is_enabled_yahoo_connect')){ ?>
        <li class="no-mar span pull-left mob-dc yahoo-icon">
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'yahoo', 'admin' => false), true); ?>
        <?php echo $this->Html->link('<i class="icon-yahoo yahooc text-24"></i><span class="hide">Yahoo!</span>', '#', array('title' => 'Yahoo!', 'escape' => false, 'class' => "no-under js-connect js-no-pjax {'url':'$url'}")); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('google.is_enabled_google_connect')) { ?>
        <li class="no-mar span pull-left mob-dc  google-sign">
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'google', 'admin' => false), true); ?>
        <?php echo $this->Html->link('<i class="icon-google-sign googlec text-24"></i><span class="hide">Google</span>', '#', array('title' => 'Google', 'escape' => false,'class' => "no-under js-connect js-no-pjax {'url':'$url'}")); ?>
        </li>
      <?php } ?>
	  <?php if (Configure::read('googleplus.is_enabled_googleplus_connect')) { ?>
        <li class="no-mar span pull-left mob-dc">
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'googleplus', 'admin' => false), true); ?>
        <?php echo $this->Html->link('<i class="icon-google-plus-sign googleplusc text-24"></i><span class="hide">Google+</span>', '#', array('title' => 'Google+', 'escape' => false,'class' => "no-under js-connect js-no-pjax {'url':'$url'}")); ?>
        </li>
      <?php } ?>
      <?php if (Configure::read('openid.is_enabled_openid_connect')) { ?>
        <li class="no-mar span stack pull-left mob-dc">
        <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'openid', 'admin' => false), true); ?>
        <?php echo $this->Html->link(__l('OpenID'), '#', array('title' => 'OpenID', 'escape' => false,'class' => "no-under inline js-connect js-no-pjax {'url':'$url'}")); ?>
        </li>
      <?php } ?>
       </ul>
     </div>
  </div>
 <h4 class="dc pr"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
    <?php } ?>
<?php if(Configure::read('user.is_enable_normal_registration') || !empty($facebook_connect) || !empty($twitter_connect) || !empty($openid_connect)): ?>
<div class="offset2">
	<?php
		$terms = $this->Html->link(__l('Terms & Conditions'), array('controller' => 'pages', 'action' => 'view', 'term-and-conditions'), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => __l('Terms & Conditions'), 'escape' => false));	
		if(!empty($this->request->data['User']['openid_url'])):
			echo $this->Form->input('openid_url', array('type' => 'hidden', 'value' => $this->request->data['User']['openid_url']));
		endif;
		echo $this->Form->input('username');
		if(empty($this->request->data['User']['openid_url']) && empty($this->request->data['User']['is_openid_register']) && empty($this->request->data['User']['facebook_user_id']) && empty($this->request->data['User']['twitter_user_id']) && empty($this->request->data['User']['is_yahoo_register']) && empty($this->request->data['User']['is_google_register']) && empty($this->request->data['User']['is_googleplus_register'])&& empty($this->request->data['User']['is_linkedin_register'])):
			echo $this->Form->input('passwd', array('label' => __l('Password')));
		endif;
		echo $this->Form->input('email'); ?>
<?php endif; ?>
		<div>
          <?php
		    if(!empty($this->request->params['named']['order_id'])) :
                echo $this->Form->input('order_id', array('type' => 'hidden', 'value' => $this->request->params['named']['order_id']));
            endif;

			if (!empty($this->request->data['User']['facebook_user_id'])):
				echo $this->Form->input('is_facebook_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_facebook_register']));
				echo $this->Form->input('is_facebook_connected', array('type' => 'hidden', 'value' => 1));
				echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 2));
				echo $this->Form->input('facebook_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['facebook_user_id']));
				if (!empty($this->request->data['User']['facebook_access_token'])):
					echo $this->Form->input('facebook_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['facebook_access_token']));
				endif;
			endif;
			if (!empty($this->request->data['User']['twitter_user_id'])):
				echo $this->Form->input('twitter_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['twitter_user_id']));
				echo $this->Form->input('is_twitter_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_twitter_register']));
				echo $this->Form->input('is_twitter_connected', array('type' => 'hidden', 'value' => 1));
				echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 3));
				if (!empty($this->request->data['User']['photoURL'])):
				  echo $this->Form->input('twitter_avatar_url', array('type' => 'hidden', 'value' => $this->request->data['User']['photoURL']));
				endif;
				if (!empty($this->request->data['User']['twitter_access_token'])):
				  echo $this->Form->input('twitter_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['twitter_access_token']));
				endif;
				if (!empty($this->request->data['User']['twitter_access_key'])):
				  echo $this->Form->input('twitter_access_key', array('type' => 'hidden', 'value' => $this->request->data['User']['twitter_access_key']));
				endif;
			endif;	
			if (!empty($this->request->data['User']['is_yahoo_register'])):
				echo $this->Form->input('is_yahoo_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_yahoo_register']));
				echo $this->Form->input('is_yahoo_connected', array('type' => 'hidden', 'value' => 1));
				echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 1));
				echo $this->Form->input('yahoo_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['yahoo_user_id']));
			endif;
            if (!empty($this->request->data['User']['is_google_register'])):
				echo $this->Form->input('is_google_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_google_register']));
				echo $this->Form->input('is_google_connected', array('type' => 'hidden', 'value' => 1));
				echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 4));
				echo $this->Form->input('google_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['google_user_id']));
				echo $this->Form->input('google_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['google_access_token']));
				if (!empty($this->request->data['User']['photoURL'])):
				  echo $this->Form->input('google_avatar_url', array('type' => 'hidden', 'value' => $this->request->data['User']['photoURL']));
				endif;
			endif;	
			if (!empty($this->request->data['User']['is_googleplus_register'])):
				echo $this->Form->input('is_googleplus_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_googleplus_register']));
				echo $this->Form->input('is_googleplus_connected', array('type' => 'hidden', 'value' => 1));
				echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 6));
				echo $this->Form->input('googleplus_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['googleplus_user_id']));
				echo $this->Form->input('googleplus_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['googleplus_access_token']));
				if (!empty($this->request->data['User']['photoURL'])):
				  echo $this->Form->input('googleplus_avatar_url', array('type' => 'hidden', 'value' => $this->request->data['User']['photoURL']));
				endif;
			endif;
			if (!empty($this->request->data['User']['is_linkedin_register'])):
				echo $this->Form->input('is_linkedin_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_linkedin_register']));
				echo $this->Form->input('is_linkedin_connected', array('type' => 'hidden', 'value' => 1));
				echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 5));
				echo $this->Form->input('linkedin_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['linkedin_user_id']));
				echo $this->Form->input('linkedin_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['linkedin_access_token']));
				if (!empty($this->request->data['User']['photoURL'])):
				  echo $this->Form->input('linkedin_avatar_url', array('type' => 'hidden', 'value' => $this->request->data['User']['photoURL']));
				endif;
			endif;
			if (!empty($this->request->data['User']['is_openid_register'])):
				echo $this->Form->input('is_openid_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_openid_register']));
				echo $this->Form->input('openid_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['openid_user_id']));
				echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 1));
			endif;
			echo $this->Form->input('referred_by_user_id',array('type' => 'hidden'));
		  ?>
		  
        </div>
	<?php if(Configure::read('user.is_enable_normal_registration') || !empty($facebook_connect) || !empty($twitter_connect) || !empty($openid_connect)): ?>
    <?php
			if(empty($this->request->data['User']['openid_url'])): 
				if (Configure::read('system.captcha_type') == 'Solve Media') {
	?> 
					<div class="clearfix">
						<div class="help span8 mob-no-mar">
						<?php
							include_once VENDORS . DS . 'solvemedialib.php';  //include the Solve Media library
							echo solvemedia_get_html(Configure::read('captcha.challenge_key'));  //outputs the widget
						?>
						</div>
					</div>
	<?php } else { ?>
				<div class="captcha-block clearfix js-captcha-container">
					<div class="captcha-left pull-left">
					  <?php echo $this->Html->image($this->Html->url(array('controller' => 'users', 'action' => 'show_captcha', 'register', md5(uniqid(time()))), true), array('alt' => __l('[Image: CAPTCHA image. You will need to recognize the text in it; audible CAPTCHA available too.]'), 'title' => __l('CAPTCHA image'), 'class' => 'captcha-img'));?>
					</div>
					<div class="captcha-right pull-left pr">
						<?php echo $this->Html->link(__l('Reload CAPTCHA'), '#', array('class' => 'js-captcha-reload captcha-reload', 'title' => __l('Reload CAPTCHA')));?>
					   <div class="play-link pa">
						  <?php echo $this->Html->link(__l('Click to play'), Router::url('/')."flash/securimage/play.swf?audio=". $this->Html->url(array('controller' => 'users', 'action'=>'captcha_play', 'register'), true) ."&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5&height=19&width=19&wmode=transparent", array('class' => 'js-captcha-play')); ?>
					   </div>
					</div>
				</div>
				<?php echo $this->Form->input('captcha', array('label' => __l('Security Code'))); ?>
				<?php
			}
			endif; 
			if(empty($this->request->data['User']['openid_url']) && empty($this->request->data['User']['facebook_user_id']) && empty($this->request->data['User']['twitter_user_id']) && empty($this->request->data['User']['is_yahoo_register']) && empty($this->request->data['User']['is_google_register']) && empty($this->request->data['User']['is_googleplus_register']) && empty($this->request->data['User']['is_linkedin_register']) && empty($this->request->data['User']['is_openid_register'])):
				if(isPluginEnabled('SecurityQuestions')) {
					echo '<div class="clearfix">';
					echo $this->Form->input('security_question_id',array('id'=>'js-security_question_id', 'empty' => __l('Please select questions')));
					echo '</div>';
					echo $this->Form->input('security_answer', array('label' => __l('Answer')));
				}
			endif;
	  endif;
	?>
	<div class="mob-no-mar input checkbox required profile-gender-block js-register-terms ">
	<?php echo $this->Form->input('is_agree_terms_conditions', array('div' => false, 'type' => 'checkbox','label' => __l('I have read, understood & agree to the').' '.$terms.'<sup><i class="icon-asterisk text-5 requiredc"></i></sup>')); ?>
	</div>
<?php if(Configure::read('user.is_enable_normal_registration') || !empty($facebook_connect) || !empty($twitter_connect) || !empty($openid_connect)): ?>
      <div class="submit-block clearfix">
<?php echo $this->Form->submit(__l('Submit'), array('class' => 'btn btn-large btn-primary textb text-16')); ?>
</div>
<div>
<?php endif; ?>
<?php echo $this->Form->end(); ?>
</div>
