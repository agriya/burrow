<?php /* SVN: $Id: $ */ ?>
<?php if(!empty($this->request->params['isAjax'])):
  echo $this->element('flash_message', array('config' => 'sec'));
endif;?>
<div class="side1 ">
  <?php if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='contact'):?>
    <h2 class="ver-space sep-bot top-mspace text-32" ><?php echo __l('Pricing Negotiation');?></h2>
  <?php elseif(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='accept'):?>
    <h2 class="ver-space top-mspace text-32 sep-bot " ><?php echo __l('Booking Request Confirm');?></h2>
  <?php elseif(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='cancel'):?>
    <h2 class="ver-space top-mspace text-32 sep-bot "><?php echo __l('Booking Cancel Process');?></h2>
  <?php elseif(!empty($this->request->params['named']['order_id'])):?>
    <h2 class="ver-space top-mspace text-32 sep-bot "><?php echo __l('Book It');?></h2>
  <?php endif;?>
  <div class="bot-msapce clearfix">
    <section class="span24 mob-clr row bot-space">
      <ol class="unstyled prop-list no-mar">
        <li class="clearfix ver-space sep-bot left-mspace mob-no-mar hor-smspace">
		  <div class="span  hor-mspace dc mob-no-mar">
			<?php echo $this->Html->link($this->Html->showImage('Property', $itemDetail['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($itemDetail['Property']['title'], false)), 'title' => $this->Html->cText($itemDetail['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $itemDetail['Property']['slug'],  'admin' => false), array('title'=>$this->Html->cText($itemDetail['Property']['title'],false),'escape' => false, 'class' => 'prop-img'));?>
		  </div>
		  <div class="span19 no-mar mob-clr tab-clr">
			<div class="clearfix sep-bot">
			  <div class="span bot-space">
				<h4 class="textb text-16">
				  <?php 
				  echo $this->Html->getUserAvatarLink($itemDetail['User'], 'small_thumb');?>
				  <?php $lat = $itemDetail['Property']['latitude'];
				  $lng = $itemDetail['Property']['longitude'];
				  $id = $itemDetail['Property']['id'];
				  echo $this->Html->link($this->Html->cText($itemDetail['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $itemDetail['Property']['slug'], 'admin' => false), array('id'=>"js-map-side-$id",'class'=>"graydarkc js-map-data {'lat':'$lat','lng':'$lng'}",'title'=>$this->Html->cText($itemDetail['Property']['title'], false),'escape' => false));
				  $flexible_class = '';?>
				</h4>
				<div class="clearfix top-space dc">
				  <?php if (!empty($search_keyword['named']['is_flexible'])&& $search_keyword['named']['is_flexible'] == 1) {
					if(!in_array($itemDetail['Property']['id'], $booked_property_ids) && in_array($itemDetail['Property']['id'], $exact_ids)) {?>
					  <span class="label pull-left mob-inline"><?php echo __l('exact'); ?></span> 
					<?php }
				  }
				  if (Configure::read('property.is_property_verification_enabled') && $itemDetail['Property']['is_verified'] == ConstVerification::Verified):?>
					<span class="label label-warning pull-left right-mspace mob-inline"><?php echo __l('Verified'); ?></span>
				  <?php endif; 
				  if($itemDetail['Property']['is_featured']): ?>
					<span class="label featured pull-left hor-smspace mob-inline"> <?php echo __l('Featured'); ?></span>
				  <?php endif; ?>
				</div>
				<span title="<?php echo $itemDetail['Property']['address']; ?>" class="graydarkc top-smspace show mob-clr" >
				  <?php if(!empty($itemDetail['Country']['iso_alpha2'])): ?>
					<span class="flags flag-<?php echo strtolower($itemDetail['Country']['iso_alpha2']); ?> mob-inline top-smspace" title ="<?php echo $itemDetail['Country']['name']; ?>"><?php echo $itemDetail['Country']['name']; ?></span>
				  <?php endif;
				  echo $this->Html->cText($itemDetail['Property']['address']);?>
				</span> 
			  </div>
			  <?php $view_count_url = Router::url(array(
				'controller' => 'properties',
				'action' => 'update_view_count',
			  ), true);?>
			  <div class="pull-right sep-left mob-clr mob-sep-none">
				<dl class="dc list span mob-clr">
				  <dt class="pr hor-mspace text-11"><?php echo __l('Per night');?></dt>
				  <dd title="five hundred dollar" class="textb text-24 graydarkc pr hor-mspace">
					<?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
					  <?php echo Configure::read('site.currency').' '; ?>
					<?php endif; ?>
					<?php echo $this->Html->cCurrency($itemDetail['Property']['price_per_night']);?>
					<?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
					  <?php echo ' '.Configure::read('site.currency'); ?>
					<?php endif; ?>
				  </dd>
				</dl>
				<dl class="dc list span mob-clr">
				  <dt class="pr hor-mspace text-11"><?php echo __l('Per Week');?></dt>
				  <dd title="two thousand dollar" class="text-11 top-space graydarkc pr hor-mspace">
					<?php if($itemDetail['Property']['price_per_week']!=0):
					  echo $this->Html->siteCurrencyFormat($itemDetail['Property']['price_per_week']);
					else:
					  echo $this->Html->siteCurrencyFormat($itemDetail['Property']['price_per_night']*7);
					endif;?>
				  </dd>
				</dl>
				<dl class="dc list span mob-clr">
				  <dt class="pr hor-mspace text-11"><?php echo __l('Per Month');?></dt>
				  <dd title="three thousand five hundred dollars" class="text-11 top-space graydarkc pr hor-mspace">
					<?php if($itemDetail['Property']['price_per_month']!=0):
					  echo $this->Html->siteCurrencyFormat($itemDetail['Property']['price_per_month']);
					else:
					  echo $this->Html->siteCurrencyFormat($itemDetail['Property']['price_per_night']*30);
					endif;?>
				  </dd>
				</dl>
			  </div>
			</div>
			<div class="clearfix left-mspace">
			  <div class="clearfix pull-right top-mspace mob-clr">
				<?php if((!empty($search_keyword['named']['latitude']) || isset($near_by)) && !empty($itemDetail[0]['distance'])): ?>
				  <dl class="dc mob-clr sep-right list">
					<dt class="pr hor-mspace text-11"><?php echo __l('Distance');?><span class="dc"> <?php echo __l('(km)');?></span></dt>
					<dd class="textb text-16 no-mar graydarkc pr hor-mspace"><?php echo $this->Html->cInt($itemDetail[0]['distance']*1.60934 ,false); ?></dd>
				  </dl>
				<?php endif; ?>
				<dl class="dc mob-clr sep-right list">
				  <dt class="pr hor-mspace text-1" title ="<?php echo __l('View');?>"><?php echo __l('Views');?></dt>
				  <dd class="textb text-16 no-mar graydarkc pr hor-mspace js-view-count-property-id js-view-count-property-id-<?php echo $itemDetail['Property']['id']; ?> {'id':'<?php echo $itemDetail['Property']['id']; ?>'}">
					<?php  echo numbers_to_higher($itemDetail['Property']['property_view_count']); ?>					
				  </dd>
				</dl>
				<dl class="dc mob-clr sep-right list">
				  <dt class="pr hor-smspace text-11" title ="<?php echo __l('Positive');?>"><?php echo __l('Positive');?></dt>
				  <dd class="textb text-16 no-mar graydarkc pr hor-mspace">
					<?php echo numbers_to_higher($itemDetail['Property']['positive_feedback_count']); ?>					
				  </dd>
				</dl>
				<dl class="dc mob-clr sep-right list">
				  <dt class="pr hor-mspace text-11" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
				  <dd  class="textb text-16 no-mar graydarkc pr hor-mspace">
					<?php echo numbers_to_higher($itemDetail['Property']['property_feedback_count'] - $itemDetail['Property']['positive_feedback_count']); ?>	
				  </dd>
				</dl>
				<dl class="dc mob-clr list">
				  <dt class="pr mob-clr hor-mspace text-11" title ="<?php echo __l('Success Rate');?>"><?php echo __l('Success Rate');?></dt>
				  <?php if(empty($itemDetail['Property']['property_feedback_count'])): ?>
				    <dd class="textb text-16 no-mar graydarkc pr hor-mspace" title="<?php  echo __l('No Bookings available'); ?>"><?php  echo __l('n/a'); ?></dd>
				  <?php else:?>
				    <dd class="textb text-16 no-mar graydarkc pr hor-mspace">
				      <?php if(!empty($itemDetail['Property']['positive_feedback_count'])):
					    $positive = floor(($itemDetail['Property']['positive_feedback_count']/$itemDetail['Property']['property_feedback_count']) *100);
					    $negative = 100 - $positive;
				      else:
					    $positive = 0;
					    $negative = 100;
				      endif;
				      echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=8DCA35|F47564&amp;chf=bg,s,FFFFFF00', array('width'=>'35px','height'=>'35px','title' => $positive.'%')); ?>
				    </dd>
				  <?php endif; ?>
				</dl>
			  </div>
			</div>
		  </div>
		</li>
	  </ol>
	</section>
  </div>
  <?php	if($itemDetail['PropertyUser'][0]['guests']==1){
	$additional_guest =0;
  } else{
	$additional_guest = (!empty($itemDetail['PropertyUser'][0]['guests']) && ($itemDetail['PropertyUser'][0]['guests'] - $itemDetail['Property']['additional_guest']) > 0) ? ($itemDetail['PropertyUser'][0]['guests'] - $itemDetail['Property']['additional_guest']) : 0;
  }
  $additional_guest_price = 0;
  if($additional_guest > 0) {
	$additional_guest_price = $additional_guest * $itemDetail['Property']['additional_guest_price'];
  }
  $security_deposit=$itemDetail['PropertyUser'][0]['security_deposit'];
  $days = (!empty($itemDetail['PropertyUser'][0]['checkout']) && !empty($itemDetail['PropertyUser'][0]['checkin'])) ? getCheckinCheckoutDiff($itemDetail['PropertyUser'][0]['checkin'],getCheckoutDate($itemDetail['PropertyUser'][0]['checkout'])) : 1;
  $price = $itemDetail['PropertyUser'][0]['price'];
  $service_fee = $itemDetail['PropertyUser'][0]['traveler_service_amount'];
  $total = $service_fee + $price;
  if(!empty($itemDetail['PropertyUser'][0]['negotiation_discount'])):
	$price = !empty($itemDetail['PropertyUser'][0]['original_price']) ? $itemDetail['PropertyUser'][0]['original_price'] : 0;
	$total = $service_fee + $price;
	$discount= !empty($itemDetail['PropertyUser'][0]['negotiate_amount']) ? $itemDetail['PropertyUser'][0]['negotiate_amount'] : 0;
	$total = $total - $discount;
	$price = $price - $discount;
  endif;
  if(Configure::read('property.is_enable_security_deposit')):
	$total = $total + $security_deposit;
  endif; 
  //storing the order id in session
  if(!$this->Auth->sessionValid()) {
	$_SESSION['order_id'] = $this->request->params['named']['order_id']; 
  }
	if(isset($this->request->data['PropertyUser']['wallet']) && $this->request->data['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && !empty($sudopay_gateway_settings) && $sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
		echo $this->element('sudopay_button', array('data' => $sudopay_data, 'cache' => array('config' => 'sec')), array('plugin' => 'Sudopay')); 
	} else {	
	?>	
	<?php echo $this->Form->create('Property', array('action' => 'order', 'id' => 'PaymentOrderForm', 'class' => 'js-submit-target')); ?>
  <div class="clearfix top-space top-mspace">
	<div class="span15">
	<?php $quick_fix = false; ?>	
	  <?php if((Configure::read('user.signup_fee')==0 || $this->Auth->sessionValid() || (!$this->Auth->sessionValid() && Configure::read('user.signup_fee')==0))): ?>
		<div class="payments payments-order order js-responses js-main-order-block js-submit-target-block">
		  <?php  if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='contact'):?>
			<div class="alert alert-info span14"><?php echo __l('Host may confirm booking with other guests while you still negotiate. So, make your negotiation short and genuine to avoid disappointments.'); ?></div>
		  <?php endif; ?>
		  <?php  if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='accept'):?>
			<div class="alert alert-info span14"><?php echo __l('You can give whatever discount, but admin commission will be calculated on your property cost!'); ?></div>
		  <?php endif; ?>
		  <?php if(!$this->Auth->sessionValid() && Configure::read('user.is_enable_normal_registration')): ?>
			<?php if(Configure::read('user.signup_fee')==0): ?>
			  <div class="ver-mspace dc <?php if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='contact'):?> login-right-contact-block<?php endif; ?>">
				 <?php echo $this->Html->link(__l('Already have an account?'), array('controller' => 'users', 'action' => 'login', 'admin' => false), array('title' => __l('Already have an account?'), 'class' => 'textb js-no-pjax')); ?>
			  </div>
			<?php endif;?>
			<div class="dc ver-space">(OR)</div>
			<div class="dc clearfix">
				<?php echo $this->Html->link(__l('Sign up for an account'), array('controller' => 'users', 'action' => 'register', 'admin' => false), array('title' => __l('Sign up for an account'), 'class' => 'textb js-no-pjax')); ?>
			</div>
		  <?php elseif(!empty($user['User']['facebook_user_id']) && empty($user['User']['email'])): ?>
			<?php echo $this->Form->input('User.email',array('label' => __l('Email'))); ?>
		  <?php endif; ?>
		  <?php 
			$quick_fix_login = true;
			if(((!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'contact') && !$this->Auth->sessionValid())) {
				$quick_fix_login = false;
			}
		  ?>
		  <?php if($quick_fix_login && $this->Auth->sessionValid()) { ?>
		  <?php if(isset($this->request->params['named']['type'])) : ?>
			<div class="space">
			  <div class="space">
				<?php if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']!='cancel'):?>
				  <?php echo $this->Form->input('PropertyUser.message',array('label' => __l('Message to Host'),'div' =>'input textarea host-textarea')); ?>
				<?php elseif(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='cancel'): ?>
				  <ul class="unstyled span15">
					<?php if ($itemDetail['PropertyUser'][0]['property_user_status_id'] == ConstPropertyUserStatus::Confirmed):
					  if ($itemDetail['CancellationPolicy']['percentage'] == '0.00') {
						$percentage = 'No';
					  } elseif ($itemDetail['CancellationPolicy']['percentage'] == '100.00') {
						$percentage = 'Full';
					  } else {
						$percentage = $this->Html->cFloat($itemDetail['CancellationPolicy']['percentage'], false) . '%';
					  }?>
					  <li class="space">
						<span class="span3 pr hor-mspace text-12" ><?php echo __l('Cancellation'); ?></span>
						<span class="textb  no-mar graydarkc pr hor-mspace"><?php echo $this->Html->cText($itemDetail['CancellationPolicy']['name']) . ': ' . sprintf(__l('%s refund %s day(s) prior to arrival, except fees'), $percentage, $this->Html->cText($itemDetail['CancellationPolicy']['days'], false)); ?></span>
					  </li>
					<?php endif; ?>
					<li class="space">
					  <?php $security_deposit_label = '';
					  if(Configure::read('property.is_enable_security_deposit')):
						$security_deposit_label = ' ' . __l('+ Security Deposit');
					  endif;?>
					  <span class="span3  pr hor-mspace text-12" ><?php echo __l('Amount Paid'); ?></span>
					  <span class="textb  no-mar graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($total);?><?php echo ' ' . sprintf(__l('(Price + Service Fee %s)'), $security_deposit_label); ?></span>
					</li>
					<li class="sep-top space">
						<span class="span3  pr hor-mspace text-12" ><?php echo __l('Service Fee'); ?></span>
						<span class="textb  no-mar graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($itemDetail['PropertyUser'][0]['traveler_service_amount']);?></span>
					</li>
					<?php $refunded_amount = $price; ?>
					<?php if ($itemDetail['PropertyUser'][0]['property_user_status_id'] == ConstPropertyUserStatus::Confirmed && empty($refund_amount['full_refund'])): ?>
						<?php $refunded_amount = $refund_amount['traveler_balance']; ?>
						<li class="space">
							<span class="span3  pr hor-mspace text-12" ><?php echo __l('Cancellation Fee'); ?></span>
							<span class="textb  no-mar graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($price-$refund_amount['traveler_balance']);?></span>
						</li>
					<?php endif; ?>
					<li class="sep-top space">
					  <span class="span3  pr hor-mspace text-12" ><?php echo __l('Refundable Amount'); ?></span>
					  <span class="textb  no-mar graydarkc pr hor-mspace">
						<?php
							if (Configure::read('property.is_enable_security_deposit')) {
								$refunded_amount = $refunded_amount + $security_deposit;
							}
						?>
						<?php echo $this->Html->siteCurrencyFormat($refunded_amount); ?>
					  </span>
					</li>
				  </ul>
				<?php endif; ?>
			  </div>
			</div>
		  <?php else: ?>
			<div class="sep-bot  bot-space">
			  <div class="alert alert-info"><?php echo __l('Your order confirmation request will be expired automatically in ').(Configure::read('property.auto_expire')*24).__l(' hrs when host not yet respond.'); ?></div>
              <?php echo $this->Form->input('PropertyUser.message',array('label' => __l('Message to Host'),'div' =>'input textarea host-textarea')); ?>				
			</div>
		  <?php endif; ?>
		  <?php } ?>
		  <!-- @todo "Coupons" -->
		  <?php if(((isset($this->request->params['named']['type']) && $this->request->params['named']['type']!='cancel') || !isset($this->request->params['named']['type'])) && $this->Auth->sessionValid()):?>
			<div class="ver-mspace">
				<div class="clearfix span16">
				  <?php if ($itemDetail['CancellationPolicy']['percentage'] == '0.00') {
					$percentage = 'No';
				  } elseif ($itemDetail['CancellationPolicy']['percentage'] == '100.00') {
					$percentage = 'Full';
				  } else {
					$percentage = $this->Html->cFloat($itemDetail['CancellationPolicy']['percentage'], false) . '%';
				  }?>
				  <span class="textb span3"><?php echo __l('Cancellation'); ?></span>
				  <span class="span12"><?php echo $this->Html->cText($itemDetail['CancellationPolicy']['name']) . ': ' . sprintf(__l('%s refund %s day(s) prior to arrival, except fees'), $percentage, $this->Html->cText($itemDetail['CancellationPolicy']['days'], false)); ?></span>
				  <span class="clearfix textb span3 top-space"><?php echo __l('House Rules'); ?></span>
				  <span class="span12 top-space"><?php echo !empty($itemDetail['Property']['house_rules']) ? $this->Html->cText($itemDetail['Property']['house_rules']) : 'n/a' ; ?></span>
				  <span class="span15 pull-left">
					<?php echo $this->Form->input('is_agree_terms_conditions', array('type'=>'checkbox','label' => __l('I agree to the cancellation policy and house rules').' <sup><i class="icon-asterisk text-5 requiredc"></i></sup>', 'div'=>'top-mspace input checkbox')); 
					echo $this->Form->input('item_id', array('type' => 'hidden'));
					if(!empty($this->request->params['named']['order_id'])):
					  echo $this->Form->input('order_id', array('type' => 'hidden', 'value' => $this->request->params['named']['order_id']));
					endif;?>
				  </span>
				</div>
			</div>
		  <?php endif; ?>
		</div>
	  <?php else: ?> 
		<div class="login-account-block clearfix">
		  <p class="login-info-block no-pad"><?php echo sprintf(__l('If you have created account in %s before, you can sign in using your %s.'), Configure::read('site.name'),Configure::read('user.using_to_login')); ?></p>
		   <div class="dc clearfix">
			<?php echo $this->Html->link(__l('Already have an account?'), array('controller' => 'users', 'action' => 'login', 'admin' => false), array('title' => __l('Already have an account?'), 'class' => 'textb js-no-pjax')); ?>
		  </div>
		</div>
		<div class="dc ver-space"><?php echo __l('(OR)'); ?></div>
		<div class="dc clearfix">
			<?php echo $this->Html->link(__l('Sign up for an account'), array('controller' => 'users', 'action' => 'register', 'admin' => false), array('title' => __l('Sign up for an account'), 'class' => 'textb js-no-pjax')); ?>
		</div>
	  <?php endif; ?>
	</div>
  <aside class="span8 pull-right left-mspace sep-bot mob-clr">
	<h3 class="well space textb text-16 no-mar"><?php echo __l('Trip Details');?></h3>
	<ul class="unstyled span8 no-mar">
	  <li>
		<span class="span3 pr hor-mspace text-12" ><?php echo __l('Check in'); ?></span>
		<span class="textb  no-mar graydarkc pr hor-mspace"><?php echo !empty($itemDetail['PropertyUser'][0]['checkin']) ? $this->Html->cDate($itemDetail['PropertyUser'][0]['checkin']) : ''; ?></span>
	  </li>
	  <li>
		<span class="span3  pr hor-mspace text-12" ><?php echo __l('Check out'); ?></span>
		<span class="textb  no-mar graydarkc pr hor-mspace"><?php echo !empty($itemDetail['PropertyUser'][0]['checkout']) ? $this->Html->cDate(getCheckoutDate($itemDetail['PropertyUser'][0]['checkout'])) : ''; ?></span>
	  </li>
	  <li>
		<span class="span3  pr hor-mspace text-12" ><?php echo __l('Nights'); ?></span>
		<span class="textb  no-mar graydarkc pr hor-mspace"><?php echo round($days); ?></span>
	  </li>
	  <li>
		<span class="span3 pr hor-mspace text-12" ><?php echo __l('Guests'); ?></span>
		<span class="textb  no-mar graydarkc pr hor-mspace"><?php echo !empty($itemDetail['PropertyUser'][0]['guests']) ? $this->Html->cInt($itemDetail['PropertyUser'][0]['guests']) : 1; ?></span>
	  </li>
	  <?php  if ($additional_guest > 0) { ?>
		<li>
		  <span class="span3 pr hor-mspace text-12" ><?php echo __l('Additional Guests'); ?></span>
		  <span class="textb  no-mar graydarkc pr hor-mspace"><?php echo $additional_guest;?></span>
		</li>
	  <?php }
	  $default_currency_id = Configure::read('site.currency_id');
	  if (!empty($_COOKIE['CakeCookie']['user_currency'])) {
		$currency_id = $_COOKIE['CakeCookie']['user_currency'];
	  }
	  $display_default_currency=false;
	  if (!empty($_COOKIE['CakeCookie']['user_currency']) && $default_currency_id!=$currency_id) {
		$display_default_currency=true;
	  }?>
	  <li>
		<span class="span3 pr hor-mspace text-12" ><?php echo __l('Rate (per night)'); ?></span>
		<span class="textb  no-mar graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($itemDetail['Property']['price_per_night']);?> <span class="trips-price"> <?php if($display_default_currency): ?> / 
		<?php echo $this->Html->siteDefaultCurrencyFormat($itemDetail['Property']['price_per_night']);?><?php endif; ?></span></span>
	  </li>
	  <li>
		<span class="span3 pr hor-mspace text-12"><?php echo __l('Price'); ?></span>
		<?php if(!empty($itemDetail['PropertyUser'][0]['negotiation_discount'])): ?>
		  <span class="textb  no-mar graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($itemDetail['PropertyUser'][0]['original_price']);?> <span class="trips-price"><?php if($display_default_currency): ?>/ <?php echo $this->Html->siteDefaultCurrencyFormat($itemDetail['PropertyUser'][0]['original_price']);?><?php endif; ?></span></span>
		<?php else: ?>
		  <span class="textb  no-mar graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($itemDetail['PropertyUser'][0]['price']);?> <span class="trips-price"><?php if($display_default_currency): ?>/ <?php echo $this->Html->siteDefaultCurrencyFormat($itemDetail['PropertyUser'][0]['price']);?><?php endif; ?></span></span>
		<?php endif; ?>
	  </li>
	  <?php if($additional_guest > 0) { ?>
		<li class="clearfix bot-mspace">
		  <span class="span3 pr hor-mspace text-12"><?php echo __l('Additional Guests Price (per night)'); ?></span>
		  <span class="textb  no-mar graydarkc pr hor-mspace"><?php echo  $this->Html->siteCurrencyFormat($additional_guest_price);?> <span class="trips-price"><?php if($display_default_currency): ?>/ <?php echo  $this->Html->siteDefaultCurrencyFormat($additional_guest_price);?><?php endif; ?></span></span>
		</li>
	  <?php } ?>
	  <?php if(!empty($itemDetail['PropertyUser'][0]['negotiation_discount'])): ?>
		<li>
		  <span class="span3 pr hor-mspace text-12"><?php echo __l('Discount') . ' (' . $itemDetail['PropertyUser'][0]['negotiation_discount'] . '%)'; ?></span>
		  <span class="textb  no-mar graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($discount);?> <span class="trips-price"><?php if($display_default_currency): ?>/ <?php echo $this->Html->siteDefaultCurrencyFormat($discount);?><?php endif; ?></span></span>
		</li>
	  <?php endif; ?>
	  <li>
		<span class="span3 pr hor-mspace text-12"><?php echo __l('Subtotal'); ?></span>
		<span class="textb  no-mar graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($price);?> <span class="trips-price"><?php if($display_default_currency): ?>/ <?php echo $this->Html->siteDefaultCurrencyFormat($price);?><?php endif; ?></span></span>
	  </li>
	  <li>
		<span class="span3 pr hor-mspace text-12"><?php echo __l('Service Fee') . ' ' . '('. Configure::read('property.booking_service_fee') .'%)'; ?></span>
		<span class="textb  no-mar graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($service_fee);?> <span class="trips-price"><?php if($display_default_currency): ?>/ <?php echo $this->Html->siteDefaultCurrencyFormat($service_fee);?><?php endif; ?></span></span>
	  </li>
	  <?php if (Configure::read('property.is_enable_security_deposit')): ?>
		<li>
		  <span class="span3 pr hor-mspace text-12"><?php echo __l('Security Deposit'); ?><span class="label-refundable span no-mar text-10 round-3 sspace whitec"><?php echo __l('Refundable'); ?></span></span>
		  <span class="textb  no-mar graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($security_deposit);?> <span class="trips-price"><?php if($display_default_currency): ?>/ <?php echo $this->Html->siteDefaultCurrencyFormat($security_deposit);?><?php endif; ?></span><span title="<?php echo __l('Ths deposit is for security purpose. When host raise any dispute on property damage, this amount may be used for compensation. So, total refund is limited to proper stay and booking cancellation/rejection/expiration. Note that site decision on this is final.'); ?>" class="info">&nbsp;</span></span>
		</li>
	  <?php endif; ?>
	  <li class="sep-top top-space">
		<span class="span3 pr hor-mspace text-12"><?php echo __l('Total'); ?></span>
		<span class="textb  no-mar graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($total);?> <?php if($display_default_currency): ?> <span class="trips-price"><?php if($display_default_currency): ?>/ <?php echo $this->Html->siteDefaultCurrencyFormat($total);?><?php endif; ?></span><?php endif; ?></span>
	  </li>
	</ul>
  </aside>
  </div>
  <div class="top-mspace sep-top">
	<?php if($this->Auth->sessionValid()) { ?>	
	 <?php $currency_code = Configure::read('site.currency_id');?>
	  <div class="alert alert-info"><?php echo __l('This payment transacts in '). $GLOBALS['currencies'][$currency_code]['Currency']['symbol'].$GLOBALS['currencies'][$currency_code]['Currency']['code'].__l('. Your total charge is ').$this->Html->siteDefaultCurrencyFormat($total);?></div>
	  <?php  if(!isset($this->request->params['named']['type'])):?>
		<h3 class="sep-bot bot-mspace"><?php echo __l('Select Payment Type'); ?></h3>
		<?php echo $this->element('payment-get_gateways', array('model' => 'PropertyUser', 'type' => 'is_enable_for_book_a_property', 'foreign_id' => $this->request->params['named']['order_id'], 'transaction_type' => ConstPaymentType::BookingAmount, 'is_enable_wallet' => 1,'cache' => array('config' => 'sec')));?>
	  <?php else: ?>
		<?php if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='contact' && $quick_fix_login):?>
		  <div class="clearfix form-actions connected-paypal-block"><?php echo $this->Form->submit(__l('Contact'), array('name' => 'data[Property][contact]','class'=>'btn btn-large btn-primary  pull-right','div'=>false));?></div>
		<?php elseif(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='accept'):?>
		  <div class="clearfix form-actions connected-paypal-block"><?php echo $this->Form->submit(__l('Confirm'), array('name' => 'data[Property][accept]','class'=>'btn btn-large btn-primary  pull-right','div'=>false));?></div>
		<?php endif; ?>
	  <?php endif; ?>
	  <?php } ?>
	  <?php if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='cancel'):?>
		<div class="clearfix from-actions">
		  <div class="form-actions"><?php 	echo $this->Html->link(__l('Submit'), array('controller' => 'property_users', 'action' => 'update_order', $itemDetail['PropertyUser'][0]['id'], 'cancel', 'admin' => false), array('title' => __l('Submit'),'class' => 'js-cancel js-no-pjax pull-right cancel btn btn-large btn-primary textb text-16'));   ?></div>
		</div>
	  <?php endif; ?>
  </div>
  <?php echo $this->Form->end();?>
  <?php } ?>
</div>