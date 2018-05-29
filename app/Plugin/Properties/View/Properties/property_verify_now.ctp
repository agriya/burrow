<?php /* SVN: $Id: pay_now.ctp 1960 2010-05-21 14:46:46Z jayashree_028ac09 $ */ ?>
<div class="payments order js-responses js-main-order-block">
	<div class="main-section">
	<h2 class="ver-space top-mspace text-32 sep-bot "><?php echo __l(' Pay Verification Fee');?></h2>
	<div class="clearfix gigs-view-info-blocks">
	<?php  if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='contact'):?>
		<h2 class="ver-space top-mspace text-32 sep-bot "><?php echo __l('Booking Details');?></h2>
	<?php  elseif(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='accept'):?>
		<h2 class="ver-space top-mspace text-32 sep-bot "><?php echo __l('Booking Request Confirm');?></h2>
	<?php  elseif(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='cancel'):?>
		<h2 class="ver-space top-mspace text-32 sep-bot "><?php echo __l('Booking Cancel Process');?></h2>
	<?php elseif(!empty($this->request->params['named']['order_id'])):?>
		<h2 class="ver-space top-mspace text-32 sep-bot "><?php echo __l('Payment process');?></h2>
	<?php endif;?>
	<ol class="span24 unstyled prop-list no-mar" >
		<li class="span24 clearfix ver-space sep-bot mob-no-mar js-map-num no-mar hor-smspace">
			<div class="span hor-mspace dc mob-no-mar">
			<?php 
                 echo $this->Html->link($this->Html->showImage('Property', ((!empty($itemDetail['Attachment'][0])) ? $itemDetail['Attachment'][0] : array()), array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($itemDetail['Property']['title'], false)), 'title' => $this->Html->cText($itemDetail['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $itemDetail['Property']['slug'],  'admin' => false), array('title'=>$this->Html->cText($itemDetail['Property']['title'],false),'escape' => false));
            	 ?>
			</div>
                <div class="span20 pull-right no-mar mob-clr tab-clr">
                  <div class="clearfix left-mspace sep-bot">
                    <div class="span bot-space no-mar">
					 <h4 class="textb text-16 clearfix">
		<?php
			echo $this->Html->getUserAvatarLink($itemDetail['User'], 'small_thumb', true, 'pull-left');
			$lat = $itemDetail['Property']['latitude'];
			$lng = $itemDetail['Property']['longitude'];
			$id = $itemDetail['Property']['id'];
			echo $this->Html->link($this->Html->cText($itemDetail['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $itemDetail['Property']['slug'], 'admin' => false), array('id'=>"js-map-side-$id",'class'=>" js-bootstrap-tooltip htruncate span11 graydarkc js-map-data {'lat':'$lat','lng':'$lng'}",'title'=>$this->Html->cText($itemDetail['Property']['title'], false),'escape' => false));
			$flexible_class = '';
			if (isset($search_keyword['named']['is_flexible'])&& $search_keyword['named']['is_flexible'] == 1) {
				if(!in_array($itemDetail['Property']['id'], $booked_property_ids) && in_array($itemDetail['Property']['id'], $exact_ids)) {
					?>
					<span class="exact round-3"> <?php echo __l('exact'); ?></span>
					<?php
				}
			}
			if($itemDetail['Property']['is_verified']): ?>
				<span class="isverified"> <?php echo __l('verified'); ?></span><?php 
			endif;
			if($itemDetail['Property']['is_featured']):?>
				<span class="round-3 label featured"> <?php echo __l('Featured'); ?></span><?php 
			endif; ?>
					</h4>  
					<span class="htruncate top-space" title="<?php echo $this->Html->cText($itemDetail['Property']['address'], false);?>">
					  <?php if(!empty($itemDetail['Country']['iso_alpha2'])): ?>
						<span class="flags flag-<?php echo strtolower($itemDetail['Country']['iso_alpha2']); ?> mob-inline top-smspace" title="<?php echo $this->Html->cText($itemDetail['Country']['name'],false); ?>"><?php echo $this->Html->cText($itemDetail['Country']['name'], false); ?></span>
					  <?php endif; ?>
					  <?php echo $this->Html->cText($itemDetail['Property']['address'], false);?>
					</div>
                    <div class="pull-right sep-left mob-clr mob-sep-none">
                      <dl class="dc list span mob-clr">
                        <dt class="pr hor-mspace text-11"><?php echo __l('Per night');?></dt>
                        <dd class="textb text-24 graydarkc pr hor-mspace">
						<?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
							<?php echo Configure::read('site.currency').' '?>
						<?php endif; ?>
						<?php echo $this->Html->cCurrency($itemDetail['Property']['price_per_night']);?>
						<?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
							 <?php echo ' '.Configure::read('site.currency'); ?>
						<?php endif; ?>
					</dd>
                      </dl>
                      <dl class="dc list span mob-clr">
						<dt class="pr hor-mspace text-11" ><?php echo __l('Per Week');?></dt>
						<dd class="text-11 top-space graydarkc pr hor-mspace" >
							<?php
								if ($itemDetail['Property']['price_per_week']!=0):
									echo $this->Html->siteCurrencyFormat($itemDetail['Property']['price_per_week']);
								else:
									echo $this->Html->siteCurrencyFormat($itemDetail['Property']['price_per_night']*7);
								endif;
							?>
						</dd>
                      </dl>
                      <dl class="dc list span mob-clr">
						<dt class="pr hor-mspace text-11" ><?php echo __l('Per Month');?></dt>
						<dd class="text-11 top-space graydarkc pr hor-mspace" >
							<?php
								if ($itemDetail['Property']['price_per_month']!=0):
									echo $this->Html->siteCurrencyFormat($itemDetail['Property']['price_per_month']);
								else:
									echo $this->Html->siteCurrencyFormat($itemDetail['Property']['price_per_night']*30);
								endif;
							?>
						</dd>
                      </dl>
				  <?php if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='related' ): ?>
					  <?php if($this->Auth->user('id')!=$itemDetail['Property']['user_id']): ?>						 
						<?php echo $this->Html->link(__l('Book it!'), array('controller' => 'properties', 'action' => 'view',$itemDetail['Property']['slug'], 'admin' => false), array('title'=>__l('Make an offer'), 'escape' => false, 'class' => 'btn btn-large btn-primary textb text-16')); ?>
					 <?php endif; ?>
				 <?php endif; ?>					  
                    </div>
                  </div>
                  <div class="clearfix left-mspace">
                    
                    <div class="clearfix pull-right top-mspace mob-clr">
					<?php 
					if((!empty($search_keyword['named']['latitude']) || isset($near_by)) && !empty($itemDetail[0]['distance'])): ?>

					<dl class="dc mob-clr sep-right list">
						<dt class="pr hor-mspace text-11"><?php echo __l('Distance');?><span class="km dc"> <?php echo __l('(km)');?></span></dt>
						<dd class="textb text-16 no-mar graydarkc pr hor-mspace"><?php echo $this->Html->cInt($itemDetail[0]['distance']*1.60934 ,false); ?></dd>
					</dl>
					<?php endif; ?>					  
                      <dl class="dc mob-clr sep-right list">
                        <dt class="pr hor-mspace text-11" ><?php echo __l('Views');?></dt>
                        <dd class="textb text-16 no-mar graydarkc pr hor-mspace js-view-count-property-id js-view-count-property-id-<?php echo $itemDetail['Property']['id']; ?> {'id':'<?php echo $itemDetail['Property']['id']; ?>"><?php echo numbers_to_higher($itemDetail['Property']['property_view_count']); ?></dd>
                      </dl>
                      <dl class="dc mob-clr sep-right list">
                        <dt class="pr hor-smspace text-11" ><?php echo __l('Positive');?></dt>
                        <dd  class="textb text-16 no-mar graydarkc pr hor-mspace"><?php echo numbers_to_higher($itemDetail['Property']['positive_feedback_count']); ?></dd>
                      </dl>
                      <dl class="dc mob-clr sep-right list">
                        <dt class="pr hor-mspace text-11"><?php echo __l('Negative');?></dt>
                        <dd class="textb text-16 no-mar graydarkc pr hor-mspace"><?php echo numbers_to_higher($itemDetail['Property']['property_feedback_count'] - $itemDetail['Property']['positive_feedback_count']); ?></dd>
                      </dl>
                      <dl class="dc mob-clr list">
                        <dt class="pr mob-clr hor-mspace text-11"><?php echo __l('Success Rate');?></dt>
						<?php if(empty($itemDetail['Property']['property_feedback_count'])){ ?>
							<dd  class="textb text-16 no-mar graydarkc pr hor-mspace">n/a</dd>
						<?php }else{ ?>
						<dd class="textb text-16 no-mar graydarkc pr hor-mspace">
							<?php
								if(!empty($itemDetail['Property']['positive_feedback_count'])){
									$positive = floor(($itemDetail['Property']['positive_feedback_count']/$itemDetail['Property']['property_feedback_count']) *100);
									$negative = 100 - $positive;
								}else{
									$positive = 0;
									$negative = 100;
								}
								echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=8DCA35|F47564&amp;chf=bg,s,FFFFFF00', array('width'=>'35px','height'=>'35px','title' => $positive.'%'));
							?>
						</dd>
						<?php } ?>
						</dl>
					
					  
                    </div>
                  </div>
                </div>
              </li>
			  </ol>

<div class="clearfix js-submit-target-block">
	<?php
	if(isset($this->request->data['Property']['wallet']) && $this->request->data['Property']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && !empty($sudopay_gateway_settings) && $sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
		echo $this->element('sudopay_button', array('data' => $sudopay_data, 'cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
	} else {
	?>
 <?php echo $this->Form->create('Property', array('action' =>'property_verify_now', 'class' => 'js-submit-target clearfix'));
     echo $this->Form->input('Property.id',array('type'=>'hidden'));
 ?>
 <div class="alert alert-info">
			<?php echo sprintf(__l('When you pay verification fee, %s staff visit your premise and verify the details provided. Once the staff is satisfied with the details, your property will get "Verified" status. By getting "Verified" status, guests will get more confidence and you\'d get more bookings.'), Configure::read('site.name')); ?>
		</div>
    <dl class="top-mspace text-14 textb clearfix">
        <dt class="left-space bot-space span no-mar"><?php echo __l('Verification Fee:');?></dt>
    		<dd class="bot-space span graydarkc textb"><?php echo $this->Html->siteCurrencyFormat($total_amount);?></dd>
    </dl>
	<?php $currency_code = Configure::read('site.currency_id');?>
	<div class="alert alert-info"><?php echo __l('This payment transacts in '). $GLOBALS['currencies'][$currency_code]['Currency']['symbol'].$GLOBALS['currencies'][$currency_code]['Currency']['code'].__l('. Your total charge is ').$this->Html->siteDefaultCurrencyFormat($total_amount);?></div>
	<fieldset>
	<legend><h3><?php echo __l('Select Payment Type'); ?></h3></legend>
    <?php echo $this->element('payment-get_gateways', array('model' => 'Property', 'type' => 'is_enable_for_property_verified_fee', 'foreign_id' => $this->request->data['Property']['id'], 'transaction_type' => ConstPaymentType::PropertyVerifyFee, 'is_enable_wallet' => 1,'cache' => array('config' => 'sec')));?>
	</fieldset>
	<?php echo $this->Form->end();?>
	<?php } ?>
</div>
</div>
	</div>
