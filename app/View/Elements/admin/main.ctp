      <article id="<?php echo $this->Html->getUniquePageId();?>">
        <div class="container-fluid">        
 			<?php 
				$user_menu = array('users','user_views', 'user_profiles',  'user_logins', 'messages', 'user_comments');
				$properties_menu=array('properties', 'property_views', 'property_favorites','property_flags','collections','property_users','property_feedbacks','property_user_feedbacks','property_user_disputes');
				$requests_menu = array('requests', 'request_views','request_favorites','request_flags');
				$payment_menu = array('payments', 'payment_gateways', 'transactions', 'user_cash_withdrawals','affiliate_cash_withdrawals');
				$partners_menu = array('affiliates', 'affiliate_requests',  'affiliate_cash_withdrawals', 'affiliate_types', 'affiliate_widget_sizes');
				$master_menu = array('currencies', 'email_templates','pages', 'transaction_types', 'translations', 'languages',  'banned_ips', 'cities', 'states', 'countries',  'user_educations', 'genders', 'user_employments', 'property_flag_categories', 'affiliate_widget_sizes', 'ips','cancellation_policies','request_flag_categories','room_types','property_types','holiday_types','bed_types','amenities','user_relationships','user_income_ranges','habits');
				$diagnostics_menu = array('search_logs');
                $currency_conversion_menu = array('currency_conversion_histories');
                $search_log_menu = array('search_logs');
                $devs_menu = array('devs');
				$class = "";
                if(in_array($this->request->params['controller'], $user_menu) && $this->request->params['action'] != 'admin_diagnostics') {
					$class = "icon-user";
				}elseif(in_array($this->request->params['controller'], $properties_menu)) {
					$class = "icon-building";
				}elseif(in_array($this->request->params['controller'], $requests_menu)) {
					$class = "icon-mail-reply-all";
				}elseif(in_array($this->request->params['controller'], $payment_menu)) {
					$class = "icon-money";
				}  elseif(in_array($this->request->params['controller'], $partners_menu) && isPluginEnabled('Affiliates')) {
					$class = "icon-money";
				} elseif(in_array($this->request->params['controller'], $master_menu)) {
					$class = "icon-align-justify";
				} elseif(in_array($this->request->params['controller'], $diagnostics_menu)) {
					$class = "diagnostics-title";
				}elseif(in_array($this->request->params['controller'], $currency_conversion_menu)) {
					$class = "icon-align-justify";
				}elseif(in_array($this->request->params['controller'], $search_log_menu)) {
					$class = "search-log-title";
				}elseif(in_array($this->request->params['controller'], $devs_menu)) {
    				$class = "dev-title";
				}elseif($this->request->params['controller'] == 'settings') {
					$class = "icon-cogs";				
				}elseif($this->request->params['controller'] == 'extensions_plugins') {
					$class = "icon-certificate";				
				} elseif($this->request->params['controller'] == 'subscriptions' && $this->request->params['action'] == 'admin_subscription_customise') {
					$class = "customize-subscriptions-title";
				} elseif($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_diagnostics') {
					$class = "diagnostics-title";
				}
		  if(($this->request->params['controller'] == 'users' && ($this->request->params['action'] == 'admin_stats' || $this->request->params['action'] == 'admin_demographic_stats'))){
                echo $content_for_layout;
             } else { ?> 
					<h4 class="well space"><i class="<?php echo $class; ?> no-pad left-space text-16"></i> <span class="hor-smspace text-14 textb">					        
							<?php if($this->request->params['controller'] == 'pages' && $this->request->params['action']== 'view') { ?>
							<?php echo __l('Page Preview');?>
							<?php } else {?>
							<?php echo $this->Html->cText($this->pageTitle,false);?>
							<?php } ?>
							
						</span>
						<?php if ($this->request->params['controller'] == 'settings' || $this->request->params['controller'] == 'payment_gateways' || $this->request->params['controller'] == 'extensions_plugins') { ?>
							<span class="setting-info info text-13 pull-right grayc hor-mspace mob-clr"><?php echo sprintf(__l('To reflect changes, you need to %s'), $this->Html->link(__l('clear cache.'), array('controller' => 'devs', 'action' => 'clear_cache', '?f=' . $this->request->url), array('title' => __l('clear cache'), 'class' => 'js-delete mob-clr')));?></span>
						<?php } ?>
						</h4>
							
                	<?php if(!isPluginEnabled('Affiliates') && in_array( $this->request->params['controller'], array('affiliates', 'affiliate_requests',  'affiliate_cash_withdrawals', 'affiliate_widget_sizes'))) { ?>
                         <div class="page-info space sep-top"><?php echo __l('Affiliate module is currently disabled. You can enable it from '); 
                          echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 9),array('title' => __l('Settings'))). __l(' page'); ?>
                          </div>
					 <?php } elseif(!Configure::read('site.is_currency_conversion_history_updation') && in_array( $this->request->params['controller'], array('currency_conversion_histories'))) { ?>
                         <div class="page-info space sep-top"><?php echo __l('Currency Conversion History Updation is currently disabled. You can enable it from '); 
                          echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 4),array('title' => __l('Settings'))). __l(' page'); ?>
                          </div>
					 <?php } else {
					 		echo $content_for_layout;
					 }?>
					 

        <?php } ?> 
       
        </div>
   </article>