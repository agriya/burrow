<ul class="breadcrumb top-mspace ver-space">
		<?php if($this->request->params['controller'] == 'settings' && $this->request->params['action'] == 'index') { ?>
			<li><?php echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'index'), array('title' => __l('Back to Settings')));?> </li>				
		<?php }elseif($this->request->params['controller'] == 'settings' && $this->request->params['action'] == 'admin_edit' ) { ?>
			<li><?php echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'index'), array('title' => __l('Back to Settings')));?> <span class="divider">/</span></li> <li class="active"> <?php echo $setting_categories['SettingCategory']['name']; ?> </li>					
		<?php } elseif((!empty($diagnostics_menu) && in_array( $this->request->params['controller'], $diagnostics_menu)) || $this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_logs') { ?>
			<li><?php echo $this->Html->link(__l('Diagnostics'), array('controller' => 'users', 'action' => 'diagnostics', 'admin' => true), array('title' => __l('Diagnostics')));?> <span class="divider">/</span></li> <li class="active"> <?php echo $this->pageTitle;?></li>
		<?php } ?>		
</ul>
<div class="js-response js-clone space sep-top">
<div class="padd-center">
 <?php if (!empty($setting_categories['SettingCategory']['description'])):?>
		<div class="alert alert-info">
			<?php
				if(stristr($setting_categories['SettingCategory']['description'], '##PAYMENT_SETTINGS_URL##') === FALSE) {
					echo $setting_categories['SettingCategory']['description'];
				} else {
					echo $category_description = str_replace('##PAYMENT_SETTINGS_URL##',Router::url('/', true) . 'admin/payment_gateways',$setting_categories['SettingCategory']['description']);
				}
			?>
		</div>
	<?php endif;?>
	<?php
		if (!empty($settings)):
			echo $this->Form->create('Setting', array('action' => 'edit', 'class' => 'form-horizontal space setting-add-form add-live-form','enctype' => 'multipart/form-data'));
			echo $this->Form->input('setting_category_id', array('label' => __l('Setting Category'),'type' => 'hidden'));
			if (!empty($plugin_name)) {
				echo $this->Form->input('plugin_name', array('label' => __l('Plugin Name'),'type' => 'hidden', 'value'=>$plugin_name));
			}
			$is_changed = $prev_cat_id = 0;
			foreach ($settings as $key=>$setting):
			
				if($setting['Setting']['name'] == 'site.language' && isPluginEnabled('Translation')):
					$empty_language = 0;
					$get_language_options = $this->Html->getLanguage();
					if(!empty($get_language_options)):
						$options['options'] = $get_language_options;
					else:
						$empty_language = 1;
					endif;
				endif;
				$field_name = explode('.', $setting['Setting']['name']);
				if(isset($field_name[2]) && ($field_name[2] == 'is_not_allow_resize_beyond_original_size' || $field_name[2] == 'is_handle_aspect')){
					continue;
				}
				 if ($setting['Setting']['id'] == 427) {
                        $find_Replace = array(
                            '##TEST_CONNECTION##' => $this->Html->link(__l('Test Connection'), array('controller' => 'high_performances', 'action' => 'check_s3_connection', '?f=' . $this->request->url))
                        );
                        $setting['Setting']['description'] = strtr($setting['Setting']['description'], $find_Replace);
                    }
				if($setting['Setting']['id'] == 326)
				{
					if(!isPluginEnabled("Requests"))
					{
						$find_Replace = array("and request " => "");
						 $setting['Setting']['description'] = strtr($setting['Setting']['description'], $find_Replace);
					}
				}
				$options['type'] = $setting['Setting']['type'];
				$options['value'] = $setting['Setting']['value'];
				$options['div'] = array('id' => "setting-{$setting['Setting']['name']}");
				if($options['type'] == 'checkbox' && $options['value']):
					$options['checked'] = 'checked';
				endif;
				if($options['type'] == 'select'):
					$selectOptions = explode(',', $setting['Setting']['options']);
					$setting['Setting']['options'] = array();
					if(!empty($selectOptions)):
						foreach($selectOptions as $key => $value):
							if(!empty($value)):
								$setting['Setting']['options'][trim($value)] = trim($value);
							endif;
						endforeach;
					endif;
					$options['options'] = $setting['Setting']['options'];
				elseif ($options['type'] == 'radio'):
						$selectOptions = explode(',', $setting['Setting']['options']);
						$setting['Setting']['options'] = array();
						//$options['legend'] = '<span class="round-5">' . $setting['Setting']['label'] . '</span>';
						$options['div'] = array('class' => 'input radio no-mar bot-space');
						if(!empty($selectOptions)):
							foreach($selectOptions as $key => $value):
								if(!empty($value)):
									$setting['Setting']['options'][trim($value)] = trim($value);
								endif;
							endforeach;
						endif;
						$options['options'] = $setting['Setting']['options'];
				endif;
				if(empty($prev_cat_id)){
					$prev_cat_id = $setting['SettingCategory']['id'];
					$is_changed = 1;
				} else {
					$is_changed = 0;
					if($setting_categories['SettingCategory']['id'] != 16 && $setting['SettingCategory']['id'] != $prev_cat_id ){
						$is_changed = 1;
						$prev_cat_id  = $setting['SettingCategory']['id'];
						  
					}
				} ?>
				
				
			<?php	if(!empty($is_changed)): 

					if($setting_categories['SettingCategory']['id'] != 12) :
					if(in_array($setting['SettingCategory']['id'], array(68, 69, 70, 71, 72, 73, 74))){ echo '</div></div></div>';}
?>					
					<?php if ($setting['Setting']['id'] == 404) { ?>
						<h3 class="well space textb text-16"><?php echo __l('Instant Scaling'); ?></h3>
						<div class="alert alert-info"><?php echo __l('By enabling these easy options, site can achieve instant scaling.');;?></div>
					<?php } ?>
					<div class="clearfix  row-fluid">
					<div class="<?php echo (in_array( $setting['SettingCategory']['id'], array(67,68,69,70))) ? 'span23 offset1' : '' ;?>">

					<fieldset class="form-block">
							<h3 class="well space textb text-16" id="<?php echo str_replace(' ','',$setting['SettingCategory']['name']); ?>"> <?php echo $setting['SettingCategory']['name']; ?></h3>
						 
							<?php if (!empty($setting['SettingCategory']['description']) && $setting_categories['SettingCategory']['id'] != 16):?>
								<div class="alert alert-info clearfix">
									<?php
										$findReplace = array(
											'##TRANSLATIONADD##' => $this->Html->link(Router::url('/', true) . 'admin/translations/add', Router::url('/', true) . 'admin/translations/add', array('title' => __l('Translations add'))),
											'##APPLICATION_KEY##' => $this->Html->link($appliation_key_link . '#SolveMedia',$appliation_key_link . '#SolveMedia'),
						'##CATPCHA_CONF##' => $this->Html->link($captcha_conf_link . '#CAPTCHA',$captcha_conf_link . '#CAPTCHA'),
						'##DEMO_URL##' => $this->Html->link('http://dev1products.dev.agriya.com/doku.php?id=burrow-install#how_to','http://dev1products.dev.agriya.com/doku.php?id=burrow-install#how_to', array('target' => '_blank')),
										);
										$setting['SettingCategory']['description'] = strtr($setting['SettingCategory']['description'], $findReplace);
										echo $setting['SettingCategory']['description'];
									?>
								</div>
							<?php endif;?>
						</fieldset>
					<?php endif; ?>
					
			<?php 	endif; ?> 		
				<?php if(!empty($is_changed)) { ?>
					<?php if ($setting['SettingCategory']['id'] == 68) { ?>
                            
                                <div class="span10 well pull-right">
                                    <h4><?php echo __l('Configuration steps:');?></h4> <br>
                                    <?php echo __l('1. Sign in using your google account in <a target="blank" href="https://developers.google.com/speed/pagespeed/service">https://developers.google.com/speed/pagespeed/service</a>.'); ?><br/>
                                    <?php echo __l('2. Click sign up now button and answer simple questions. Google will enable PageSpeed service within 2 hours.'); ?><br/>
                                    <?php echo __l('3. You have to configure this service in this link <a target="blank" href="https://code.google.com/apis/console">https://code.google.com/apis/console</a>, please follow the steps mentioned in this link <a target="blank" href="https://developers.google.com/speed/pagespeed/service/setup">https://developers.google.com/speed/pagespeed/service/setup</a>'); ?>
                                </div>
                           
                        <?php } elseif ($setting['SettingCategory']['id'] == 67) { ?>
						 <div class="span10 well pull-right">
                            <h4><?php echo __l('Configuration steps:'); ?></h4><br>
                            <?php echo __l('1. Create a CloudFlare account, configure the domain and change DNS.'); ?><br>
                            <?php echo __l('2. To create token please refer '); ?> <a target="blank" href="http://blog.cloudflare.com/2-factor-authentication-now-available">http://blog.cloudflare.com/2-factor-authentication-now-available</a><br>
                            <?php echo __l('3. Create three page rules like /, /property/*, /user/* in this link'); ?> <a target="blank" href="https://www.cloudflare.com/page-rules?z=<?php echo $_SERVER["SERVER_NAME"]; ?>">https://www.cloudflare.com/page-rules?z=<?php echo $_SERVER["SERVER_NAME"]; ?></a><?php echo __l('. Note: Please select \'Cache Everything\' option for \'Custom Caching\' setting.'); ?><br>
                            <?php echo __l('4. Update your CloudFlare Email and Token and enable CloudFlare option here.'); ?><br>
                            <?php echo __l('5. Minimum cache timing for free users will be 30 minutes. Only enterprise users can reduce upto 30 seconds.'); ?>
                         </div>
						<?php }  elseif ($setting['SettingCategory']['id'] == 69) { ?>
						<div class="span10 well pull-right">
                            <h4><?php echo __l('Configuration steps:');?></h4> <br>
                            <?php echo __l('1. Amazon CloudFront: To setup Amazon CloudFront CDN please follow the step mentioned in this <a target="blank" href="http://aws.amazon.com/console/#cf">http://aws.amazon.com/console/#cf</a> and watch this screencast <a href="http://d36cz9buwru1tt.cloudfront.net/videos/console/cloudfront_console_4.html" target="blank">http://d36cz9buwru1tt.cloudfront.net/videos/console/cloudfront_console_4.html</a>'); ?><br>
                            <?php echo __l('2. CloudFlare: To setup CloudFlare please follow the step mentioned in this link <a href="https://support.cloudflare.com/entries/22054357-How-do-I-do-CNAME-setup-" target="blank">https://support.cloudflare.com/entries/22054357-How-do-I-do-CNAME-setup-</a>'); ?><br>
                        </div>
						<?php } elseif ($setting['SettingCategory']['id'] == 70) { ?>
						<div class="span10 well pull-right">
                            <h4><?php echo __l('Configuration steps:');?></h4> <br>
                            <?php echo __l('You can configure SMTP server by any one of the followings Amazon SES, Sendgrid, Mandrill, Gmail and your own host SMTP settings'); ?><br>
                            <?php echo __l('1. Amazon SES: To get your security credentials, login with amazon and go to <a target="blank" href="https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials">https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials</a> . To create your smtp username password go to <a target="blank" href="https://console.aws.amazon.com/ses/home#smtp-settings">https://console.aws.amazon.com/ses/home#smtp-settings</a>'); ?><br>
                            <?php echo __l('2. Sendgrid: To get your security credentials, refer <a target="blank" href="http://sendgrid.com/docs/Integrate/index.html">http://sendgrid.com/docs/Integrate/index.html</a>'); ?><br>
                            <?php echo __l('3. Mandrill:  To get your security credentials, login with Mandrill and go to <a target="blank" href="https://mandrillapp.com/settings">https://mandrillapp.com/settings</a>'); ?><br>
                            <?php echo __l('4. Gmail: To use gmail please refer <a target="blank" href="http://gmailsmtpsettings.com/gmail-smtp-settings">http://gmailsmtpsettings.com/gmail-smtp-settings</a>'); ?>
                         </div>
					   <?php }  if ($setting['SettingCategory']['id'] == 74) { ?>
						<div class="span10 well pull-right">
							<h4><?php echo __l('Configuration steps:'); ?></h4><br>
							<?php echo __l('1. To get your security credentials, login with amazon and go to <a target="blank" href="https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials">https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials</a><br>2. To create bucket name go to <a target="blank" href="https://console.aws.amazon.com/s3/home">https://console.aws.amazon.com/s3/home</a> and click s3 link.'); ?>
						</div>
				<?php } ?> 
					<?php if(in_array($setting['SettingCategory']['id'], array(71, 72, 73, 74, 79))){ ?>
						<div class="span13">
					<?php } else { ?>
						<div>
					<?php } ?>
				<?php } ?>
				<?php if (in_array( $setting['Setting']['id'], array(181, 178, 231, 172, 175, 174, 350))) : ?>

                        <h3 class="well space textb text-16">
                           <?php echo (in_array($setting['Setting']['id'], array(181, 172))) ? __l('Application Info') : ''; ?>
                           <?php echo (in_array($setting['Setting']['id'], array(178, 175, 350))) ? __l('Credentials') : ''; ?>
                           <?php echo (in_array($setting['Setting']['id'], array(231, 174))) ? __l('Other Info') : ''; ?>
                        </h3>
						<?php if(in_array( $setting['Setting']['id'], array(178, 175, 350))):?>
                            <div class="alert alert-info">
                                <?php
                                    if($setting['Setting']['id'] == 178) :
                                        echo __l('Here you can update Facebook credentials . Click \'Update Facebook Credentials\' link below and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.');
                                    elseif($setting['Setting']['id'] == 175) :
                                        echo __l('Here you can update Twitter credentials like Access key and Accss Token. Click \'Update Twitter Credentials\' link below and Follow the steps. Please make sure that you have updated the Consumer Key and  Consumer secret before you click this link.');
                                    elseif($setting['Setting']['id'] == 350) :
										echo __l('Here you can update Google Analytics credentials . Click  \'Update Google Analytics Credentials\' link below and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.');
									endif;
                                ?>
                            </div>
                        <?php endif;?>
						<?php
							if($setting['Setting']['id'] == 178) : ?>

							<div class="clearfix credentials-info-block">
							<div class=" credentials-left">
						      	<div class="credentials-right">
        							<?php	echo $this->Html->link('<span><i class="icon-facebook-sign facebookc space text-16"></i>' . __l('Update Facebook Credentials') . '</span>', $fb_login_url, array('escape'=>false,'class' => 'facebook-link btn bot-mspace', 'title' => __l('Here you can update Facebook credentials . Click this link and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.')));
                                    ?>
                                </div>
                            </div>
                            <div class=" credentials-right-block">
                            <?php
                            elseif($setting['Setting']['id'] == 175) :
                            ?>
                            <div class="clearfix credentials-info-block">
                            <div class=" credentials-left">
						      	<div class="credentials-right">
                                    <?php
                                    	echo $this->Html->link('<span><i class="icon-twitter-sign twitterc space text-16"></i>' . __l('Update Twitter Credentials') . '</span>', $tw_login_url, array('escape'=>false,'class' => 'twitter-link btn bot-mspace', 'title' => __l('Here you can update Twitter credentials like Access key and Accss Token. Click this link and Follow the steps. Please make sure that you have updated the Consumer Key and  Consumer secret before you click this link.')));
                                    ?>
                                </div>
                             </div>
                             <div class=" credentials-right-block">
							 <?php
                            elseif($setting['Setting']['id'] == 350) :
                            ?>
                            <div class="clearfix credentials-info-block">
                            <div class=" credentials-left">
						      	<div class="clearfix bot-space">
  	<?php echo $this->Html->link('<span><i class="icon-google-sign googlec space text-16"></i>' . __l('Update Google Analytics Credentials') . '</span>', array('controller' => 'settings', 'action' => 'update_credentials', 'type' => 'google'), array('class' => 'btn tp-credential js-bootstrap-tooltip', 'escape' => false, 'title' => __l('Here you can update Google Analytics credentials like Access Token. Click this link and Follow the steps. Please make sure that you have updated the Consumer Key and Consumer secret before you click this link.'))); ?>
                                </div>
                             </div>
                             <div class=" credentials-right-block">
                            <?php
                        	endif;
						?>
				<?php endif; ?>
				<?php if ($setting['Setting']['id'] == 430) { ?>
							<div class="clearfix bot-space show">
								<?php echo $this->Html->link('<span>' . __l('Copy static contents to S3') . '</span>', array('controller' => 'high_performances', 'action' => 'copy_static_contents', '?f=' . $this->request->url), array('class' => 'js-connect js-confirm js-bootstrap-tooltip js-no-pjax btn btn-primary  dc', 'escape' => false, 'title' => __l('Clicking this button will copy static contents such as CSS, JavaScript, images files in <code>webroot</code> folder of this server to Amazon S3 and will enable them to be delivered from there.'))); ?>
							</div>
						<?php } ?>
				<?php
					if ($setting['Setting']['name'] == 'site.is_ssl_enabled' && !($ssl_enable)) {
						$options['disabled'] = 'disabled';
					}
				?>
				<?php
				$findReplace = array(
					'##ANALYTICS_IMAGE##' => Router::url('/', true).'img/google_analytics_example.gif',
				);
				$setting['Setting']['description'] = strtr($setting['Setting']['description'], $findReplace);
				if ($setting['Setting']['name'] == 'cdn.images' || $setting['Setting']['name'] == 'cdn.js' || $setting['Setting']['name'] == 'cdn.css'){	
					$options['class'] = 'js-remove-error';
				}
					if ($setting['Setting']['name'] == 'twitter.site_user_access_key' || $setting['Setting']['name'] == 'twitter.site_user_access_token' || $setting['Setting']['name'] == 'facebook.fb_access_token' || $setting['Setting']['name'] == 'facebook.fb_user_id' || $setting['Setting']['name'] == 'google_analytics.access_token'):
						$options['readonly'] = true;
						$options['class'] = 'disabled';
					endif;
					if ($setting['Setting']['name'] == 'site.language' && isPluginEnabled('Translation')):
						$options['options'] = $this->Html->getLanguage();
					endif;
					if ($setting['Setting']['name'] == 'site.currency_id'):
						$options['options'] = $this->Html->getCurrencies();
					endif;
					if ($setting['Setting']['name'] == 'site.paypal_currency_converted_id'):
						$options['options'] = $this->Html->getSupportedCurrencies();
					endif;
					$options['label'] = $setting['Setting']['label'];
					if ($setting['SettingCategory']['id'] == 47 && $setting['Setting']['id'] == 165):
						$options['class'] = 'image-settings';
						echo '<div class="outer-image-settings clearfix">';
					endif;
					if (in_array($setting['Setting']['name'], array('user.referral_deal_buy_time', 'user.referral_cookie_expire_time', 'affiliate.referral_cookie_expire_time'))):
						$options['after'] = __l('hrs') . '<span class="info">' . $setting['Setting']['description'] . '</span>';
					endif;
					if (in_array( $setting['Setting']['name'], array('wallet.min_wallet_amount', 'wallet.max_wallet_amount', 'user.minimum_withdraw_amount', 'user.maximum_withdraw_amount','user.signup_fee', 'affiliate.payment_threshold_for_threshold_limit_reach','property.booking_service_fee','property.host_commission_amount','property.listing_fee','property.verify_fee'))):
						$options['after'] = $GLOBALS['currencies'][Configure::read('site.currency_id')]['Currency']['symbol'] . '<span class="info">' . $setting['Setting']['description'] . '</span>';
					endif;
					$findReplace = array(
						'##SITE_NAME##' => Configure::read('site.name'),
						'##MASTER_CURRENCY##' => $this->Html->link(Router::url('/', true) . 'admin/currencies', Router::url('/', true) . 'admin/currencies', array('title' => __l('Currencies'))),
						'##USER_LOGIN##' => $this->Html->link(Router::url('/', true) . 'admin/user_logins', Router::url('/', true) . 'admin/user_logins', array('title' => __l('User Logins'))),
						'##REGISTER##' => $this->Html->link('registration', '#', array('title' => __l('registration'))),
					);
					$setting['Setting']['description'] = strtr($setting['Setting']['description'], $findReplace);
					if (!empty($setting['Setting']['description']) && empty($options['after'])):
						$options['help'] = "{$setting['Setting']['description']}";
					endif;
					if($setting['Setting']['name'] == 'Site.logo'):
						 $options['after'] = '<div class="settings-site-logo">'.$this->Html->showImage('SiteLogo', $attachment['SiteLogo'], array('full_url' => true,'dimension' => 'site_logo_thumb', 'alt' => sprintf(__l('[Image: %s]'), "SiteLogo"), 'title' =>  __l('SiteLogo'), 'type' => 'png', 'class' => 'siteLogo')).'</div>';
					endif;
					if(($options['type'] == 'checkbox' || $options['type'] == 'radio' ) && !empty($options['help']))
					{
						$options['help_tag'] = 'p';
					}
					
					?>
                  <div class="show"> 
						<?php 
						if (in_array( $setting['Setting']['id'], array(206, 304, 265, 264, 319, 373))){
							$options['legend'] = false;
						?>		
								<label> <?php echo $setting['Setting']['label']; ?> </label>
						<?php 		
								}
						?>
						<?php if ($setting['SettingCategory']['id'] != 68) { ?>
					  <?php echo $this->Form->input("Setting.{$setting['Setting']['id']}.name", $options); ?> 
					  <?php } ?>
				  </div>
                    <?php
					if ($setting['SettingCategory']['id'] == 47 && $setting['Setting']['id'] == 166):
						echo '</div>';
					endif;
					unset($options);
					if(in_array($setting['Setting']['id'], array(179, 176) ) ) {
					?>
                        </div>
                        </div>
					<?php
					} ?>
					
					
		<?php endforeach; ?>
	</div></div></div>
		<?php
		if(!empty($beyondOriginals)){
            echo $this->Form->input('not_allow_beyond_original', array('label' => __l('Not Allow Beyond Original'),'type' => 'select', 'multiple' => 'multiple', 'options' => $beyondOriginals));
        }
        if(!empty($aspects)){
            echo $this->Form->input('allow_handle_aspect', array('label' => __l('Allow Handle Aspect'),'type' => 'select', 'multiple' => 'multiple', 'options' => $aspects));
        } ?>
    <div class="submit-block clearfix form-actions">
    <?php	echo $this->Form->submit('Update',array('class' => 'btn btn-large btn-primary textb text-16')); ?>
    </div>
        <?php	echo $this->Form->end(); ?>
    <?php
	else:
?>
		<div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Settings available'); ?></p></div>
<?php
	endif;
?>
</div>

</div>