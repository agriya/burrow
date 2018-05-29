<?php /* SVN: $Id: $ */ ?>
<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( 'Payment Gateways', array('controller'=>'PaymentGateways','action'=>'index'), array('escape' => false));?> <span class="divider">/</span></li>
  <li class="active"><?php echo __l(' Edit Payment Gateway'); ?></li>
</ul>
<div class="paymentGateways form  sep-top">
	<div class="row-fluid">
	<?php
		if(!empty($SudoPayGatewaySettings['sudopay_merchant_id']) && $id == ConstPaymentGateways::SudoPay) {
			echo $this->element('sudopay-info', array('cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
		}		
	?>
	</div>
	<?php echo $this->Form->create('PaymentGateway', array('class' => 'form-horizontal space setting-add-form add-live-form'));?>
	<fieldset>
		<?php
			echo $this->Form->input('id'); ?>
			<?php if ($this->request->data['PaymentGateway']['id'] != ConstPaymentGateways::Wallet): ?>
				<div class="input checkbox mob-no-mar">
					<?php echo $this->Form->input('is_live_mode', array('type' => 'checkbox', 'label' => __l('Live Mode?'), 'info' => __l('On enabling this, live account will used instead of sandbox payment details. (Enable this, When site is in production stage)'), 'div' => false)); ?>
				</div>
			<?php endif; ?>
			<?php
			foreach($paymentGatewaySettings as $paymentGatewaySetting) {
				if ($this->request->data['PaymentGateway']['id'] == ConstPaymentGateways::Wallet && $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_add_to_wallet'):
					continue;
				endif;
				$options['type'] = $paymentGatewaySetting['PaymentGatewaySetting']['type'];
				if($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_property_listing_fee'):
					$options['label'] = __l('Enable for property listing');
				elseif($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_property_verified_fee'):
					$options['label'] = __l('Enable for property verified');
				elseif($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_add_to_wallet'):
					$options['label'] = __l('Enable for add to wallet');
				elseif($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_book_a_property'):
					$options['label'] = __l('Enable for book property');
				elseif($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_signup_fee'):
					$options['label'] = __l('Enable for sign up fee');
				endif;
				$options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['test_mode_value'];
				$options['div'] = array('id' => "setting-{$paymentGatewaySetting['PaymentGatewaySetting']['name']}");
				if($options['type'] == 'checkbox'){
					$options['div'] = array('class' => 'input checkbox mob-no-mar', 'id' => "setting-{$paymentGatewaySetting['PaymentGatewaySetting']['name']}");
				}
				if($options['type'] == 'checkbox' && !empty($options['value'])):
					$options['checked'] = 'checked';
				else:
					$options['checked'] = '';
				endif;
				if($options['type'] == 'select'):
					$selectOptions = explode(',', $paymentGatewaySetting['PaymentGatewaySetting']['options']);
					$paymentGatewaySetting['PaymentGatewaySetting']['options'] = array();
					if(!empty($selectOptions)):
						foreach($selectOptions as $key => $value):
							if(!empty($value)):
								$paymentGatewaySetting['PaymentGatewaySetting']['options'][trim($value)] = trim($value);
							endif;
						endforeach;
					endif;
					$options['options'] = $paymentGatewaySetting['PaymentGatewaySetting']['options'];
				endif;
				if (!empty($paymentGatewaySetting['PaymentGatewaySetting']['description']) && empty($options['after'])):
					$options['help'] = "{$paymentGatewaySetting['PaymentGatewaySetting']['description']}";
				else:
					$options['help'] = '';
				endif;
				if(($options['type'] == 'checkbox' || $options['type'] == 'radio' ) && !empty($options['help']))
					{
						$options['help_tag'] = 'p';
					}
					
				if ($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_signup_fee' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_property_listing_fee' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_property_verified_fee' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_add_to_wallet' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_book_a_property'):
					echo '<div class="show" >'.$this->Form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.test_mode_value", $options).'</div>';
				endif;
			}		
			if ($paymentGatewaySettings && $this->request->data['PaymentGateway']['id'] != ConstPaymentGateways::Wallet) { ?>
			<div class="clearfix">
				<div class="span12">
					<span class="show textb dr"><?php echo __l('Test Mode'); ?></label>
				</div>
				<div class="span12">
					<span class="show textb dr"><?php echo __l('Live Mode'); ?></label>
				</div>
			</div>
	<?php 
    $j = $i = $z = $n = $x= 0;
    foreach($paymentGatewaySettings as $paymentGatewaySetting) {
      $options['type'] = $paymentGatewaySetting['PaymentGatewaySetting']['type'];
      $options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['test_mode_value'];
      $options['div'] = array('id' => "setting-{$paymentGatewaySetting['PaymentGatewaySetting']['name']}");
      if($options['type'] == 'checkbox' && $options['value']):
      $options['checked'] = 'checked';
      endif;
      if($options['type'] == 'select'):
            $selectOptions = explode(',', $paymentGatewaySetting['PaymentGatewaySetting']['options']);
            $paymentGatewaySetting['PaymentGatewaySetting']['options'] = array();
            if(!empty($selectOptions)):
              foreach($selectOptions as $key => $value):
                if(!empty($value)):
                  $paymentGatewaySetting['PaymentGatewaySetting']['options'][trim($value)] = trim($value);
                endif;
              endforeach;
            endif;
            $options['options'] = $paymentGatewaySetting['PaymentGatewaySetting']['options'];
          endif;
      $options['label'] = false;
      if (!empty($paymentGatewaySetting['PaymentGatewaySetting']['description']) && empty($options['after'])):
      $options['help'] = "{$paymentGatewaySetting['PaymentGatewaySetting']['description']}";
      else:
      $options['help'] = '';
      endif;
    ?>
      </fieldset>
      <?php if($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_merchant_id' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_website_id' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_secret_string' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_api_key'): ?>
	  <?php if($x == 0):?>
        <h3><?php echo __l('ZazPay API Details'); ?></h3>
      <?php endif;?>
		<div class="clearfix">
          <label class="pull-left">
			<?php
				if ($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_merchant_id') {
					echo __l('Merchant ID in ZazPay');
				} elseif ($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_website_id') {
					echo __l('Website ID in ZazPay');
				} elseif ($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_secret_string') {
					echo __l('Secret Key in ZazPay');
				} elseif ($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_api_key') {
					echo __l('API Key in ZazPay');
				}
			?>
		</label>
          <div class="offset2 clearfix pull-left hor-space">
			<div class="pull-left hor-mspace hor-space">
				<?php echo $this->Form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.test_mode_value", $options); ?>
			</div>
			<div class="pull-left hor-mspace hor-space">
				<?php
					$options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['live_mode_value'];
					echo $this->Form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.live_mode_value", $options);
				?>
			</div>
			</div>
        </div>
      <?php $x++;?>
	  <?php endif; ?>
  <?php
      }
  }
  ?>

	</fieldset>
	<div class="form-actions">
		<?php echo $this->Form->submit(__l('Update'),array('class'=>'btn btn-large btn-primary textb text-16'));?>
	</div>
	<?php echo $this->Form->end();?>
</div>
