<?php if(isset($success)) : ?>
    <div class="success-msg">
        <?php echo __l('Thank you, we received your message and will get back to you as soon as possible.'); ?>
    </div>
<?php else: ?>
    <h2 class="ver-space top-mspace sep-bot text-32 sep-bot"><?php echo __l('Contact Us'); ?></h2>
    <?php
        echo $this->Form->create('Contact', array('class' => 'form-horizontal space')); ?>
		<?php
        echo $this->Form->input('first_name', array('label' => __l('First Name')));
        echo $this->Form->input('last_name', array('label' => __l('Last Name')));
        echo $this->Form->input('email', array('label' => __l('Email')));
        echo $this->Form->input('telephone', array('label' => __l('Telephone')));
        echo $this->Form->input('subject', array('label' => __l('Subject')));
        echo $this->Form->input('message', array('label' => __l('Message')));
    ?>
	<?php if(Configure::read('system.captcha_type') == "Solve Media"){?>
      <div class="input help">
        <div class="pull-left offset">
          <?php
          include_once VENDORS . DS . 'solvemedialib.php';  //include the Solve Media library
          echo solvemedia_get_html(Configure::read('captcha.challenge_key')); //outputs the widget
          ?>
        </div>
      </div>
    <?php } else { ?>
    <div class="captcha-block clearfix js-captcha-container">
        <div class="captcha-left pull-left">
            <?php echo $this->Html->image($this->Html->url(array('controller' => 'contacts', 'action' => 'show_captcha', md5(uniqid(time()))), true), array('alt' => __l('[Image: CAPTCHA image. You will need to recognize the text in it; audible CAPTCHA available too.]'), 'title' => __l('CAPTCHA image'), 'class' => 'captcha-img'));?>
        </div>
        <div class="captcha-right pull-left">
            <?php echo $this->Html->link(__l('Reload CAPTCHA'), '#', array('class' => 'js-captcha-reload captcha-reload', 'title' => __l('Reload CAPTCHA')));?>
        	<div class="play-link">
			  <?php echo $this->Html->link(__l('Click to play'), Router::url('/')."flash/securimage/play.swf?audio=". $this->Html->url(array('controller' => 'contacts', 'action'=>'captcha_play', 'register'), true) ."&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5&height=19&width=19&wmode=transparent", array('class' => 'js-captcha-play')); ?>
		   </div>
        </div>
    </div>
    <?php echo $this->Form->input('captcha', array('label' => __l('Security Code'))); ?>
	<?php } ?>
	<div class="form-actions">
		<?php
        echo $this->Form->submit(__l('Send'), array('class' => 'btn btn-large btn-primary textb text-16'));
    ?>
	</div>
			<?php
        echo $this->Form->end();
    ?>
<?php endif; ?>