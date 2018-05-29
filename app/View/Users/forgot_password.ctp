<div>
<h2 class="ver-space sep-bot top-mspace text-32"><?php echo __l('Forgot your password?');?></h2>
<div class="top-space">
	<div class="alert alert-info">
		<?php echo __l('Enter your Email, and we will send you instructions for resetting your password.'); ?>
	</div>
</div>
<?php
	echo $this->Form->create('User', array('action' => 'forgot_password', 'class' => 'form-horizontal space')); ?>

	<?php
		echo $this->Form->input('email', array('type' => 'text'));
		if (Configure::read('user.is_enable_forgot_password_captcha')){
	?>
		<?php if (Configure::read('system.captcha_type') == 'Solve Media') { ?>
		  <div class="offset3 help">
		  <?php
			include_once VENDORS . DS . 'solvemedialib.php';  //include the Solve Media library
			echo solvemedia_get_html(Configure::read('captcha.challenge_key'));  //outputs the widget
		  ?>
		  </div>
		<?php } else { ?>
			<div class="captcha-block clearfix js-captcha-container">
					<div class="captcha-left pull-left">
					  <?php echo $this->Html->image($this->Html->url(array('controller' => 'users', 'action' => 'show_captcha', 'register', md5(uniqid(time()))), true), array('alt' => __l('[Image: CAPTCHA image. You will need to recognize the text in it; audible CAPTCHA available too.]'), 'title' => __l('CAPTCHA image'), 'class' => 'captcha-img'));?>
					</div>
					<div class="captcha-right pull-left">
						<?php echo $this->Html->link(__l('Reload CAPTCHA'), '#', array('class' => 'js-captcha-reload captcha-reload', 'title' => __l('Reload CAPTCHA')));?>
					   <div class="play-link">
						  <?php echo $this->Html->link(__l('Click to play'), Router::url('/')."flash/securimage/play.swf?audio=". $this->Html->url(array('controller' => 'users', 'action'=>'captcha_play', 'register'), true) ."&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5&height=19&width=19&wmode=transparent", array('class' => 'js-captcha-play')); ?>
					   </div>
					</div>
				</div>
				<?php echo $this->Form->input('captcha', array('label' => __l('Security Code'))); ?>
				<?php
				}
			}
				?>
<div class="form-actions">
<?php echo $this->Form->submit(__l('Send'), array('class' => 'btn btn-large btn-primary textb text-16'));?>	
</div> 
<?php echo $this->Form->end();?>
</div>