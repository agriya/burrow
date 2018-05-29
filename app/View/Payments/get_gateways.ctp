<div class="hor-space bot-mspace payment-gateways payment-type ver-space">
	<?php 
		$templates = array();
		$gateway_groups = array();
		$payment_gateways = array();
		$i = 1;
		foreach($gateway_types As $key => $gateway_type) {
			$gateway_groups[$key]['id'] = $key;
			$gateway_groups[$key]['name'] = $gateway_type;
			$gateway_groups[$key]['display_name'] = $gateway_type;
			if($key == ConstPaymentGateways::Wallet) {
				$gateway_groups[$key]['thumb_url'] = Router::url('/img/wallet-icon.png', true);
			}
			$payment_gateways[$key] = $gateway_groups[$key];
			$payment_gateways[$key]['group_id'] = $key;
			$payment_gateways[$key]['payment_id'] = $key;
			$i++;
		}
		if (isPluginEnabled('Sudopay') && !empty($gateway_types[ConstPaymentGateways::SudoPay])):
			$gateways_response = Cms::dispatchEvent('View.Payment.GetGatewayList', $this, array(
				'foreign_id' => $foreign_id,
				'model' => $model,
				'payment_type_id' => $transaction_type
			));
			$gatewayGroups = array();
			$groups = !empty($gateways_response->gatewayGroups) ? $gateways_response->gatewayGroups : '';	
			$gateways = !empty($gateways_response->gateways) ? $gateways_response->gateways : '';	
			if ($response['is_payment_via_api'] != ConstBrandType::VisibleBranding) {
				unset($gateway_groups[ConstPaymentGateways::SudoPay]);
				if(!empty($groups)) {
					foreach($groups As $group) {
						$gatewayGroups[$group['id']] = $group;
					}
					$gateway_groups = $gatewayGroups + $gateway_groups;
				}
				$gateway_array = array();
				$payment_gateway_arrays = array();
				unset($payment_gateways[ConstPaymentGateways::SudoPay]);
				unset($gateway_types[ConstPaymentGateways::SudoPay]);
				if(!empty($gateways)) {
					foreach($gateways as $gateway) {
						$payment_gateway_arrays[$i]['id'] = $gateway['id'];
						$payment_gateway_arrays[$i]['payment_id'] = 'sp_' . $gateway['id'];
						$payment_gateway_arrays[$i]['sp_' . $gateway['id']] = implode($gateway['_form_fields']['_extends_tpl'], ",");
						$payment_gateway_arrays[$i]['display_name'] = $gateway['display_name'];
						$payment_gateway_arrays[$i]['thumb_url'] = $gateway['thumb_url'];
						$payment_gateway_arrays[$i]['group_id'] = $gateway['group_id'];
						$templates['sp_' . $gateway['id']] = implode($gateway['_form_fields']['_extends_tpl'], ",");
						$gateway_array['sp_' . $gateway['id']] = '<div class="pull-left"><img src="'. $gateway['thumb_url'] .'" alt="'.$gateway['display_name'].'"/><span class="show">'.$gateway['display_name'].'</span></div>'; //for image
						$gateway_instructions['sp_' . $gateway['id']] = (!empty($gateway['instruction_for_manual'])) ? urldecode($gateway['instruction_for_manual']): '';
						$gateway_form['sp_' . $gateway['id']] = (!empty($gateway['_form_fields']['_fields'])) ? array_keys((array)$gateway['_form_fields']['_fields']): '';
						$i++;
					}
					$gateway_types = $gateway_array + $gateway_types;
					$payment_gateways =  $payment_gateway_arrays + $payment_gateways;
				}
			}
		endif;
	?>
	<?php if(!empty($gateway_groups)) { 
		$default_gateway_id = '';
		foreach($payment_gateways As $key => $value) {
			$default_gateway_id = $value['payment_id'];
			break;
		}
		$selected_payment_gateway_id = (!empty($this->request->params['named']['return_data'][$model]['sudopay_gateway_id']) ? 'sp_' . $this->request->params['named']['return_data'][$model]['sudopay_gateway_id'] : $default_gateway_id);
	?>
	<div id="paymentgateways-tab-container" class="">
		<ul class="nav nav-tabs no-mar">
			<?php foreach($gateway_groups As $gateway_group) { ?>
			<li><a href="#paymentGateway-<?php echo $gateway_group['id']; ?>" class="js-no-pjax" data-toggle="tab"><div class="pull-left">
			<?php if(!empty($gateway_group['thumb_url'])){ ?>
			<img src="<?php echo $gateway_group['thumb_url']; ?>" alt="<?php echo $gateway_group['display_name']; ?>" />
			<?php } ?>
			<span class="show"><?php echo $gateway_group['display_name']; ?></span></div></a></li>
			<?php } ?>
		</ul>
		<div class="sep-right sep-left sep-bot tab-round tab-content" id="myTabContent2">
			<?php foreach($gateway_groups As $gateway_group) { ?>
			<div class="tab-pane space clearfix" id="paymentGateway-<?php echo $gateway_group['id']; ?>">
				<?php 
				foreach($payment_gateways AS $payment_gateway) {
					$checked = '';
					if ($payment_gateway['payment_id'] == $selected_payment_gateway_id) {
						$checked = 'checked';
					}
					if($payment_gateway['group_id'] == $gateway_group['id']) {
						if ($payment_gateway['payment_id'] == ConstPaymentGateways::Wallet) {
							$option_value = '<div class="pull-left">' . $this->Html->image('wallet-icon.png', array('width' => '145', 'height' => '40', 'alt' => __l('Wallet'))) . '<span class="show">' . $payment_gateway['display_name'] . '</span></div>';							
						} else {
							if ($payment_gateway['group_id'] == 4922):
								$option_value = '<div class="pull-left"><span class="show">' . __l('Credit & Debit Cards') . '</span></div>';
							else:
								$option_value = '<div class="pull-left">';
								$class='top-space';
								if(!empty($gateway_group['thumb_url'])){
									$option_value .= '<img src="'. $payment_gateway['thumb_url'] .'" alt="'.$payment_gateway['display_name'].'"/>';
									$class = '';
								}
								$option_value .= '<span class="show '.$class.'">'.$payment_gateway['display_name'].'</span></div>';
							endif;
						}
						$options = array($payment_gateway['payment_id'] => $option_value);
						if ($payment_gateway['group_id'] == 4922):
							echo '<div class="hide">';
								echo $this->Form->input($model.'.payment_gateway_id', array('id' => 'PaymentGatewayId', 'legend' => false, 'type' => 'radio', 'label'=> true, 'div' => false, 'options' => $options, 'sudopay_form_fields_tpl' => $templates, 'class' => 'js-payment-type js-no-pjax pull-left', 'checked' => $checked));
							echo '</div>';
							echo '<div class="alert alert-info ver-mspace space">' . __l(' Please enter your credit card details below.') . '</div>';
						else:
							echo '<div class="clearfix pull-left">';
							echo $this->Form->input($model.'.payment_gateway_id', array('id' => 'PaymentGatewayId', 'legend' => false, 'type' => 'radio', 'label'=> true, 'div' => false, 'options' => $options, 'sudopay_form_fields_tpl' => $templates, 'class' => 'js-payment-type js-no-pjax pull-left', 'checked' => $checked));
							echo '</div>';
						endif;
					}
				}
				?>	
			</div>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
<?php
	if (!empty($gateway_instructions) && $response['is_payment_via_api'] != ConstBrandType::VisibleBranding) {
		foreach($gateway_instructions as $key => $instructions) {
			if(!empty($gateway_instructions[$key])) {
?>
<div class="js-instruction js-instruction_<?php echo $key; ?> alert alert-info hide">
	<?php echo nl2br($this->Html->cText($gateway_instructions[$key])); ?>
</div>
<?php
			}
		}
	}
?>
<?php if (!empty($gateways_response->form_fields_tpls)) { ?>
	<div class="js-form">
		<?php foreach($gateways_response->form_fields_tpls as $key => $value) { ?>
			<div class="js-gatway_form_tpl hide" id="form_tpl_<?php echo $key; ?>">
				<?php if($key == 'buyer'){ ?>
					<h3 class="well space textb text-16 ver-mspace"><?php echo __l('Payer Details'); ?></h3>
				<?php } ?>
				<?php if($key == 'credit_card'){ ?>
					<h3 class="well space textb text-16 ver-mspace"><?php echo __l('Credit Card Details'); ?><span>
					<?php echo $this->Html->link($this->Html->image('credit-detail.png', array('alt'=>'[Image: Burrow]')), '/',array('escape'=>false));?>
					</span></h3>
				<?php } ?>
				<div class="row no-mar space clearfix">
				<?php
					foreach($value['_fields'] as $field_name => $required) {
						$return_data = !empty($this->request->params['named']['return_data']['Sudopay'][$field_name]) ? $this->request->params['named']['return_data']['Sudopay'][$field_name] : '';
						$field_options = array();
						$field_name = trim($field_name);
						$type = 'text';
						$options = array();
						$value = $return_data;
						$class="";
						$input_class= " input text left-space";
						if ($field_name == 'buyer_country') {
							$type = 'select';
							$options = $countries;
							$value = (!empty($user_profile['Country']['iso_alpha2'])) ? $user_profile['Country']['iso_alpha2'] : $return_data;
							$class = " span5 ";
						}
						if ($field_name == 'buyer_email') {
							$value = (!empty($user_profile['User']['email'])) ? $user_profile['User']['email'] : $return_data;
							$class = " span7 ";
						}
						if ($field_name == 'buyer_address') {
							$value = (!empty($user_profile['UserProfile']['address'])) ? $user_profile['UserProfile']['address'] : $return_data;
							$class = " span7 ";
						}
						if ($field_name == 'buyer_city') {
							$value = (!empty($user_profile['City']['name'])) ? $user_profile['City']['name'] : $return_data;
							$class = " span7 ";
						}
						if ($field_name == 'buyer_state') {
							$value = (!empty($user_profile['State']['name'])) ? $user_profile['State']['name'] : $return_data;
							$class = " span7 ";
						}
						if ($field_name == 'buyer_phone') {
							$class = " span5 ";
						}
						if ($field_name == 'credit_card_number' || $field_name == 'credit_card_name_on_card') {
							$class = " span7 ";
						}
						if ($field_name == 'buyer_zip_code' || $field_name == 'credit_card_expire' || $field_name == 'credit_card_code') {
							$class = " span3 ";
						}
						
						//$field_name = str_replace('buyer_','',$field_name);
						
						if ($field_name == 'payment_note') {
							$type = 'textarea';
						}
						$before = $after = '';
						if (!empty($required)) {
							$cc_section = '';
							if ($field_name == 'credit_card_number') {
								$after .= '<div class="cc-type"></div><div class="cc-default"></div>';
								$cc_section = ' cc-section';
							}
							$before .= '<div class="required'. $cc_section . '">';
							$after .= '</div>';
						}
						$field_options = array(
							'id' => 'Sudopay' . Inflector::camelize($field_name),
							'legend' => false,
							'type' => $type,
							'class' => $class,
							'options' => $options,
							'value' => $value,
							'div' => $input_class.$class,
							'before' => $before,
							'after' => $after
						);
						if ($field_name == 'credit_card_number') {
							$field_options['autocomplete'] = 'off'; 
							$field_options['placeholder'] = '•••• •••• •••• ••••';
						}
						if ($field_name == 'credit_card_code') {
							$field_options['autocomplete'] = 'off'; 
							$field_options['placeholder'] = 'CVC';
						}
						if ($field_name == 'credit_card_expire') {
							$field_options['placeholder'] = 'MM/YYYY';
						}
						if ($field_name == 'buyer_country') {
							$field_options['empty'] = __l('Please Select');
							$field_options['div'] = "input select left-space ".$class;
						}
						echo $this->Form->input('Sudopay.' . $field_name , $field_options);
					}
				?>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>
<div class="submit-block form-payment-panel clearfix">
	<div class= "js-wallet-connection hide">
		<p class="text-14 top-space bot-sp textb sfont available-balance js-user-available-balance {'balance':'<?php echo $logged_in_user['User']['available_wallet_amount']; ?>'}"><?php echo __l('Your available balance:').' '. $this->Html->siteCurrencyFormat($this->Html->cCurrency($logged_in_user['User']['available_wallet_amount'], false));?></p>
		<div class="submit">
		<?php
			echo $this->Form->submit(__l('Pay with Wallet'), array('name' => 'data['.$model.'][wallet]', 'class' => '{"balance":"' . $logged_in_user['User']['available_wallet_amount'] . '"}  btn-module wallet-button btn btn-large hor-mspace btn-primary textb text-16 top-space ' . ' js-update-order-field js-no-pjax', 'div' => false));
		?>
		</div>
	</div>
	<div class="submit">
		<div class= "js-normal-sudopay hide">
			<?php
				echo $this->Form->submit(__l('Pay Now'), array('name' => 'data['.$model.'][wallet]', 'div' => false, 'id' => 'sudopay_button', 'class' => 'btn btn-large hor-mspace btn-primary textb text-16 top-space'));
			?>
		</div>
	</div>
</div>
</div>