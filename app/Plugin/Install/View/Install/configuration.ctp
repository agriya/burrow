<div class="install form">
	<h2><?php echo $title_for_layout; ?></h2>
	<iframe frameborder="0" width="630px" height="80px" src="http://installer.dev.agriya.com/info6.html"></iframe>
	<?php echo $this->Form->create('Install', array('url' => array('controller' => 'install', 'action' => 'configuration'), 'class' => 'normal')); ?>
	<div class="content-block round-4">
		<fieldset>
			<h3><?php echo __l('System'); ?></h3>
			<?php echo $this->Form->input('site.name', array('label' => __l('Site Name'), 'info' => __l('This name will be used in all pages, emails.'))); ?>
			<?php echo $this->Form->input('site.from_email', array('label' => __l('From Email Address'), 'info' => __l('This is the email address that will appear in the "From" field of all emails sent from the site.'))); ?>
			<?php echo $this->Form->input('site.admin_email', array('label' => __l('Contact Email Address'), 'info' => __l('This is the email address to which you will receive the mail from contact form.'))); ?>
		</fieldset>
		<fieldset>
			<h3><?php echo __l('Facebook'); ?></h3>
			<div class="configration-details info-details">Facebook is used for login and posting message using its account details. For doing above, our site must be configured with existing Facebook account. <a href="http://dev1products.dev.agriya.com/doku.php?id=facebook-setup"> http://dev1products.dev.agriya.com/doku.php?id=facebook-setup </a></div>
			<?php echo $this->Form->input('facebook.fb_app_id', array('label' => __l('Application ID'), 'type' => 'text', 'info' => __l('This is the application ID used in login and post.'))); ?>
			<?php echo $this->Form->input('facebook.fb_secrect_key', array('label' => __l('Secret Key'), 'info' => __l('This is the Facebook secret key used for authentication and other Facebook related plugins support'))); ?>
			<?php echo $this->Form->input('facebook.site_facebook_url', array('label' => __l('Account URL'), 'info' => __l('This is the site Facebook URL used displayed in the footer'))); ?>
		</fieldset>
		<fieldset>
			<h3><?php echo __l('Twitter'); ?></h3>
			<div class="configration-details info-details">Twitter is used for login and posting message using its account details. For doing above, our site must be configured with existing Twitter account. <a href="http://dev1products.dev.agriya.com/doku.php?id=twitter-setup"> http://dev1products.dev.agriya.com/doku.php?id=twitter-setup </a></div>
			<?php echo $this->Form->input('twitter.consumer_key', array('label' => __l('Consumer Key'), 'info' => __l('This is the consumer key used for authentication and posting on Twitter.'))); ?>
			<?php echo $this->Form->input('twitter.consumer_secret', array('label' => __l('Consumer Secret Key'), 'info' => __l('This is the consumer secret key used for authentication and posting on Twitter.'))); ?>
			<?php echo $this->Form->input('twitter.site_twitter_url', array('label' => __l('Account URL'), 'info' => __l('This is the site Twitter URL used for displaying in the footer.'))); ?>
		</fieldset>
	</div>
	<div class="clearfix">
		<div class="grid_right">
			<?php echo $this->Form->submit('Submit'); ?>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>