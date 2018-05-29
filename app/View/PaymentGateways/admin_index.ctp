<?php /* SVN: $Id: $ */ ?>
<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
  <li class="active"><?php echo __l('Payment Gateways'); ?></li>
</ul>
<div class="space js-response">
  <?php
  $wallet_enabled = '';
  foreach ($paymentGateways as $paymentGateway1):
    if ($paymentGateway1['PaymentGateway']['id'] == ConstPaymentGateways::Wallet):
    if ($paymentGateway1['PaymentGateway']['is_active'] == '1') {
      $wallet_enabled = $paymentGateway1['PaymentGateway']['is_active'];
    }
    endif;
  endforeach;
  ?>
  <section><div class="pull-left hor-space"><?php echo $this->element('paging_counter');?></div></section>
  <section class="space">
  <table class="table table-striped table-bordered table-condensed table-hover no-mar">
    <thead>
    <tr>
      <th rowspan="3" class="dc"><?php echo __l('Actions');?></th>
      <th rowspan="3"><?php echo $this->Paginator->sort('display_name', __l('Display Name'));?></th>
      <th colspan="9" class="dc"><?php echo __l('Settings');?></th>
    </tr>
    <tr>
      <th rowspan="2" class="dc"><?php echo __l('Active');?></th>
      <th colspan="5" class="dc"><?php echo __l('Where to use?');?></th>
    </tr>
    <tr>
      <th class="dc"><?php echo __l('Add to Wallet');?></th>
      <th class="dc"><?php echo __l('Property Listing');?></th>
      <th class="dc"><?php echo __l('Property Verified');?></th>
	  <th class="dc"><?php echo __l('Book property');?></th>
	  <th class="dc"><?php echo __l('Sign Up Fee');?></th>
    </tr>
    </thead>
    <tbody>
    <?php
      if (!empty($paymentGateways)):
      foreach ($paymentGateways as $paymentGateway):
        $status_class = null;
    ?>
    <tr>
      <td class="span1 dc">
      <div class="dropdown top-space">
        <a href="#" title="Actions" data-toggle="dropdown" class="icon-cog cur blackc text-20 dropdown-toggle js-no-pjax"><span class="hide">Action</span></a>
        <ul class="unstyled dropdown-menu dl arrow clearfix">
        <li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action'=>'edit', $paymentGateway['PaymentGateway']['id']), array('class' => 'js-edit ','escape'=>false, 'title' => __l('Edit')));?></li>
        <?php echo $this->Layout->adminRowActions($paymentGateway['PaymentGateway']['id']);  ?>
        </ul>
      </div>
      </td>
      <td class="dl">
      <?php echo $this->Html->cText($paymentGateway['PaymentGateway']['name']);?>
      <span class="info span no-pad"><i class="icon-exclamation-sign"></i>
	  <?php echo $this->Html->cText($paymentGateway['PaymentGateway']['description']);?>
	  </span>
      </td>
      <td class="dc js-payment-status" id="payment-id<?php echo $paymentGateway['PaymentGateway']['id']?>" class="<?php echo ($paymentGateway['PaymentGateway']['is_active'] == 1) ? 'js-active-gateways' : 'js-deactive-gateways'; ?>"><?php 
		if($paymentGateway['PaymentGateway']['id'] != ConstPaymentGateways::Wallet) {
		  echo $this->Html->link(($paymentGateway['PaymentGateway']['is_active'] == 1) ? '<i class="icon-ok text-16 top-space"></i><span class="hide">Yes</span>' : '<i class="icon-remove text-16 top-space"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstMoreAction::Active, 'toggle' => ($paymentGateway['PaymentGateway']['is_active'] == 1) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax'));
		} else { ?>
			<i class="icon-ok text-16 top-space"></i><span class="hide">Yes</span><?php
		}
		?></td>
    <?php
      unset($properties_listing_enabled);
      unset($properties_verified_enabled);
      unset($properties_booking_enabled);
      unset($wallet_enabled);
	  unset($signup_enabled);
      foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting):
      if ($paymentGatewaySetting['name'] == 'is_enable_for_property_listing_fee'):
        $properties_listing_enabled = $paymentGatewaySetting['test_mode_value'];
      endif;
      if ($paymentGatewaySetting['name'] == 'is_enable_for_property_verified_fee'):
        $properties_verified_enabled = $paymentGatewaySetting['test_mode_value'];
      endif;
      if ($paymentGatewaySetting['name'] == 'is_enable_for_book_a_property'):
        $properties_booking_enabled = $paymentGatewaySetting['test_mode_value'];
      endif;
      if ($paymentGatewaySetting['name'] == 'is_enable_for_add_to_wallet'):
        $wallet_enabled = $paymentGatewaySetting['test_mode_value'];
      endif;
	  if ($paymentGatewaySetting['name'] == 'is_enable_for_signup_fee'):
        $signup_enabled = $paymentGatewaySetting['test_mode_value'];
      endif;
      endforeach;
    ?>
    <?php if (!isset($wallet_enabled)) { ?>
        <td class="dc">-</td>
    <?php } else{ ?>
    <td class="dc">
      <?php 
		echo $this->Html->link(($wallet_enabled == 1) ? '<i class="icon-ok text-16 top-space"></i><span class="hide">Yes</span>' : '<i class="icon-remove text-16 top-space"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstMoreAction::AddWallet, 'toggle' => ($wallet_enabled == 1) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax')); 
	  ?>
    </td>
    <?php } ?>
    <td class="dc">
      <?php echo $this->Html->link((!empty($properties_listing_enabled)) ? '<i class="icon-ok text-16 top-space"></i><span class="hide">Yes</span>' : '<i class="icon-remove text-16 top-space"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstMoreAction::PropertyListing, 'toggle' => (!empty($properties_listing_enabled)) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax')); ?>
    </td>
    <td class="dc">
      <?php echo $this->Html->link((!empty($properties_verified_enabled)) ? '<i class="icon-ok text-16 top-space"></i><span class="hide">Yes</span>' : '<i class="icon-remove text-16 top-space"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstMoreAction::PropertyVerification, 'toggle' => (!empty($properties_verified_enabled)) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax'));?>
    </td>
    <td class="dc">
      <?php echo $this->Html->link((!empty($properties_booking_enabled)) ? '<i class="icon-ok text-16 top-space"></i><span class="hide">Yes</span>' : '<i class="icon-remove text-16 top-space"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstMoreAction::PropertyBooking, 'toggle' => (!empty($properties_booking_enabled)) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax'));?>
    </td>
	<?php if($paymentGateway['PaymentGateway']['id'] != ConstPaymentGateways::Wallet): ?>
		<td class="dc"><?php echo $this->Html->link((!empty($signup_enabled)) ? '<i class="icon-ok text-16 top-space"></i><span class="hide">Yes</span>' : '<i class="icon-remove text-16 top-space"></i><span class="hide">No</span>', array('action' => 'update_status', $paymentGateway['PaymentGateway']['id'], ConstMoreAction::SignupFee, 'toggle' => (!empty($signup_enabled)) ? 0 : 1), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax'));?></td>
	<?php else: ?>
		<td class="dc"><?php echo '-'; ?></td>
    <?php endif; ?>
    </tr>
    <?php
      endforeach;
      else:
    ?>
    <tr>
	<td colspan="9"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Payment Gateways available');?></p></div></td>
    </tr>
    <?php
      endif;
    ?>
    </tbody>
  </table>
  </section>
  <section class="clearfix hor-mspace bot-space">
  <div class="js-pagination js-no-pjax pull-right">
    <?php if (!empty($paymentGateways)): ?>
    <?php echo $this->element('paging_links'); ?>
    <?php endif; ?>
  </div>
  </section>
</div>
