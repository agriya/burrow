<div class="clearfix">
<?php
	$subscriptionInfo[ConstBrandType::TransparentBranding] = __l('Payment will have to be handled through transparent API calls. Your users will not see ZazPay branding.');
    $subscriptionInfo[ConstBrandType::VisibleBranding] = __l('Payment will have to be handled through ZazPay payment button. Your users will visit zazpay.com and see ZazPay branding.');
    $subscriptionInfo[ConstBrandType::AnyBranding] = __l('Payment can either be handled through transparent API calls or ZazPay payment button. If using transparent API calls, your users will not see ZazPay branding.');
?>
	<div class="span hor-space pull-left clearfix well">
        <div class="clearfix top-space">
            <?php echo $this->Html->link( __l('Sync with ZazPay'), array('controller' => 'sudopays', 'action' => 'synchronize', 'admin' => true), array('escape' => false, 'class' => 'btn btn-primary', 'title' => __l('Sync with ZazPay'))); ?>
            <span class="js-bootstrap-tooltip space" title="<?php echo __l('This will fetch latest configurations (subscription plan & gateways) from zazpay.com.'); ?>"><i class="icon-question-sign"></i></span>
        </div>
		<div id="setting-sudopay_website_id" class="input text">
		<dl class="clearfix dl-horizontal">
		<dt class="span5 no-mar"><label class="span3 pull-left"><?php echo __l("Subscription Plan"); ?></label></dt>
		<dd>
			<div class="span5 pull-left">
				<div id="setting-sudopay_website_id" class="input text">
					<?php echo $gateway_settings['sudopay_subscription_plan']; ?>
				</div>
			</div>
		</dd>
		<dt class="span5 no-mar"><label class="span3 pull-left"><?php echo __l("Branding"); ?></label></dt>
		<dd>
			<div class="span5 pull-left">
				<div id="setting-sudopay_website_id" class="input text">
                    <?php
                        if ($gateway_settings['is_payment_via_api'] == ConstBrandType::TransparentBranding) {
                            $branding = 'Transparent';
                        } elseif ($gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
                            $branding = 'SudoPay';
                        } elseif ($gateway_settings['is_payment_via_api'] == ConstBrandType::AnyBranding) {
                            $branding = 'Any';
                        }
                    ?>
					<?php echo $branding; ?>&nbsp;<i class="icon-info-sign js-bootstrap-tooltip" title = "<?php echo $subscriptionInfo[$gateway_settings['is_payment_via_api']]; ?>"></i>
				</div>
			</div>
		</dd>
		<dt class="span5 no-mar"><label class="span3 pull-left"><?php echo __l("Enabled Gateways"); ?></label></dt>
		<?php
			if (!empty($supported_gateways)) {
				foreach($supported_gateways as $gateways) {
					$gateway_datails = unserialize($gateways['SudopayPaymentGateway']['sudopay_gateway_details']);
				?>
				<dt class="span5 dl no-mar top-space">
					<div class="span clearfix no-mar">
						<div class="hor-space">
						  <span class="show show"><?php echo $gateways['SudopayPaymentGateway']['sudopay_gateway_name']; ?></span>
							<span class="show top-smspace">
								<span class="span no-mar">
									<?php echo $this->Html->image($gateway_datails['thumb_url']); ?>
								</span>
						   </span>
						 </div>
					 </div>
				</dt>
				<dd class="span19 no-mar top-space sudopay-info">
					<div class="span clearfix no-mar">
						<div class="row no-mar">
							<dl>
								<dt>
									<span class="span show textb"><?php echo __l("Supported Actions"); ?></span> 
								</dt>
								<?php
								if (!empty($gateway_datails)) {
									$used_gateway_actions = array_diff($used_gateway_actions, $gateway_datails['supported_features'][0]['actions']);
									$action_arr = array();
									foreach($gateway_datails['supported_features'][0]['actions'] as $actions) {
										$action_arr[] = $actions;
									} ?>
									<dd>
										<span class="clearfix">
											<?php echo implode(', ', $action_arr); ?>
										</span>
									</dd>
								<?php } ?>
							</dl>
						</div>
					 </div>
					 <div class="span clearfix no-mar">
						<div class="row no-mar">
							<dl>
								<dt>
									<span class="span show textb"><?php echo __l("Supported Currencies"); ?></span>
								</dt>
									<?php
											if (!empty($gateway_datails)) {
												$currency_arr = array();
												foreach($gateway_datails['supported_features'][0]['currencies'] as $currencies) {
													$currency_arr[] = $currencies;
												} ?>
									<dd class ="htruncate-ml2 span19" title = "<?php echo implode(', ', $currency_arr); ?>">
										<span class="clearfix">
										<?php echo implode(', ', $currency_arr); ?>
										</span>
									</dd>
									<?php } ?>
							</dl>
						</div>
					 </div>
				</dd>
		<?php
				}
			}
		?>
		</dl>
		</div>
		<?php
		if (!empty($used_gateway_actions)) {
		$missed_gateway_actions = implode('","', $used_gateway_actions);
		?>
		<div class="alert alert-danger clearfix ver-mspace">
			<?php
				echo sprintf(__l('We have used "%s" in %s. So enable payment gateways with supporting "%s" actions in ZazPay.'), $missed_gateway_actions, Configure::read('site.name'), $missed_gateway_actions);
			?>
		</div>

		<?php
		} ?>
	</div>
</div>