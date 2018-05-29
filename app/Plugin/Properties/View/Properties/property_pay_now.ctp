<?php /* SVN: $Id: pay_now.ctp 1960 2010-05-21 14:46:46Z jayashree_028ac09 $ */ ?>
<div class="payments order js-responses js-main-order-block">
	<div class="main-section">
		<h2 class="ver-space sep-bot top-mspace text-32"> <?php echo __l('Pay Listing Fee');?></h2>
		<ol class="span24 unstyled prop-list no-mar" >
			<li class="span24 clearfix ver-space sep-bot mob-no-mar js-map-num no-mar hor-smspace">
                <div class="span hor-mspace dc mob-no-mar">
					<?php 
						echo $this->Html->link($this->Html->showImage('Property', $Property['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($Property['Property']['title'], false)), 'title' => $this->Html->cText($Property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $Property['Property']['slug'],  'admin' => false), array('title'=>$this->Html->cText($Property['Property']['title'],false),'escape' => false));
					?>
				</div>				
				<div class="span20 pull-right no-mar mob-clr tab-clr">
					<div class="clearfix left-mspace sep-bot">
						<div class="span bot-space no-mar">
							<h4 class="textb text-16">
							<?php
								echo $this->Html->getUserAvatarLink($Property['User'], 'small_thumb');
								$lat = $Property['Property']['latitude'];
								$lng = $Property['Property']['longitude'];
								$id = $Property['Property']['id'];
								echo $this->Html->link($this->Html->cText($Property['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $Property['Property']['slug'], 'admin' => false), array('id'=>"js-map-side-$id",'class'=>"graydarkc left-mspace js-map-data {'lat':'$lat','lng':'$lng'}",'title'=>$this->Html->cText($Property['Property']['title'], false),'escape' => false));							
								$flexible_class = '';
								if (isset($search_keyword['named']['is_flexible'])&& $search_keyword['named']['is_flexible'] == 1) {
									if(!in_array($Property['Property']['id'], $booked_property_ids) && in_array($Property['Property']['id'], $exact_ids)) {
							?>
								<span class="exact round-3"> <?php echo __l('exact'); ?></span>
							<?php
									}
								}
								if($Property['Property']['is_verified']): 
							?>
								<span class="isverified"> <?php echo __l('verified'); ?></span>
							<?php endif; ?>
							<?php if($Property['Property']['is_featured']):?>
								<span class="round-3 label featured"> <?php echo __l('Featured'); ?></span>
							<?php endif; ?>
							</h4>				  
							<span class="top-space htruncate" title="<?php echo $this->Html->cText($Property['Property']['address'], false);?>">
							<?php if(!empty($Property['Country']['iso_alpha2'])): ?>
								<span class="flags flag-<?php echo strtolower($Property['Country']['iso_alpha2']); ?> mob-inline top-smspace" title="<?php echo $Property['Country']['name']; ?>"><?php echo $Property['Country']['name']; ?></span>
							<?php endif; ?>
							<?php echo $this->Html->cText($Property['Property']['address'], false);?>
							</span> 
						</div>
						<div class="pull-right sep-left mob-clr mob-sep-none">
							<dl class="dc list span mob-clr">
								<dt class="pr hor-mspace text-11"><?php echo __l('Per night');?></dt>
								<dd class="textb text-24 graydarkc pr hor-mspace">
								<?php 
									if (Configure::read('site.currency_symbol_place') == 'left'): 
										echo Configure::read('site.currency').' ';
									endif; 
									echo $this->Html->cCurrency($Property['Property']['price_per_night']);
									if (Configure::read('site.currency_symbol_place') == 'right'): 
										echo ' '.Configure::read('site.currency');
									endif; 
								?>
								</dd>
							</dl>
							<dl class="dc list span mob-clr">
								<dt class="pr hor-mspace text-11" ><?php echo __l('Per Week');?></dt>
								<dd class="text-11 top-space graydarkc pr hor-mspace" >
								<?php
									if ($Property['Property']['price_per_week']!=0):
										echo $this->Html->siteCurrencyFormat($Property['Property']['price_per_week']);
									else:
										echo $this->Html->siteCurrencyFormat($Property['Property']['price_per_night']*7);
									endif;
								?>
								</dd>
							</dl>
							<dl class="dc list span mob-clr">
								<dt class="pr hor-mspace text-11" ><?php echo __l('Per Month');?></dt>
								<dd class="text-11 top-space graydarkc pr hor-mspace" >
								<?php
									if ($Property['Property']['price_per_month']!=0):
										echo $this->Html->siteCurrencyFormat($Property['Property']['price_per_month']);
									else:
										echo $this->Html->siteCurrencyFormat($Property['Property']['price_per_night']*30);
									endif;
								?>
								</dd>
							</dl>
							<?php 
								if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='related' ):
									if($this->Auth->user('id')!=$Property['Property']['user_id']):
										echo $this->Html->link(__l('Book it!'), array('controller' => 'properties', 'action' => 'view',$Property['Property']['slug'], 'admin' => false), array('title'=>__l('Make an offer'), 'escape' => false, 'class' => 'btn btn-large btn-primary textb text-16'));
									endif;
								endif; 
							?>					  
						</div>
					</div>
					<div class="clearfix left-mspace">
						<div class="clearfix pull-right top-mspace mob-clr">
							<?php if((!empty($search_keyword['named']['latitude']) || isset($near_by)) && !empty($Property[0]['distance'])): ?>
							<dl class="dc mob-clr sep-right list">
								<dt class="pr hor-mspace text-11"><?php echo __l('Distance');?><span class="km dc"> <?php echo __l('(km)');?></span></dt>
								<dd class="textb text-16 no-mar graydarkc pr hor-mspace"><?php echo $this->Html->cInt($Property[0]['distance']*1.60934 ,false); ?></dd>
							</dl>
							<?php endif; ?>					  
							<dl class="dc mob-clr sep-right list">
								<dt class="pr hor-mspace text-11" ><?php echo __l('Views');?></dt>
								<dd class="textb text-16 no-mar graydarkc pr hor-mspace js-view-count-property-id js-view-count-property-id-<?php echo $Property['Property']['id']; ?> {'id':'<?php echo $Property['Property']['id']; ?>"><?php echo numbers_to_higher($Property['Property']['property_view_count']); ?></dd>
							</dl>
							<dl class="dc mob-clr sep-right list">
								<dt class="pr hor-smspace text-11" ><?php echo __l('Positive');?></dt>
								<dd  class="textb text-16 no-mar graydarkc pr hor-mspace"><?php echo numbers_to_higher($Property['Property']['positive_feedback_count']); ?></dd>
							</dl>
							<dl class="dc mob-clr sep-right list">
								<dt class="pr hor-mspace text-11"><?php echo __l('Negative');?></dt>
								<dd class="textb text-16 no-mar graydarkc pr hor-mspace"><?php echo numbers_to_higher($Property['Property']['property_feedback_count'] - $Property['Property']['positive_feedback_count']); ?></dd>
							</dl>
							<dl class="dc mob-clr list">
								<dt class="pr mob-clr hor-mspace text-11"><?php echo __l('Success Rate');?></dt>
								<?php if(empty($Property['Property']['property_feedback_count'])) { ?>
								<dd  class="textb text-16 no-mar graydarkc pr hor-mspace">n/a</dd>
								<?php } else { ?>
								<dd class="textb text-16 no-mar graydarkc pr hor-mspace">
								<?php
									if(!empty($Property['Property']['positive_feedback_count'])){
										$positive = floor(($Property['Property']['positive_feedback_count']/$Property['Property']['property_feedback_count']) *100);
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
				echo $this->Form->create('Property', array('action' =>'property_pay_now', 'class' => 'js-submit-target clearfix'));
				echo $this->Form->input('Property.id'); 
			?>
			<div class="top-space">
				<div class="alert alert-info text-20 textb">
					<span><?php echo __l('Listing Fee') . ' ' . $this->Html->siteCurrencyFormat($this->Html->cCurrency($total_amount,false));?></span>
				</div>
				<legend><h3><?php echo __l('Select Payment Type'); ?></h3></legend>
				<?php echo $this->element('payment-get_gateways', array('model' => 'Property', 'type' => 'is_enable_for_property_listing_fee', 'foreign_id' => $this->request->data['Property']['id'], 'transaction_type' => ConstPaymentType::PropertyListingFee, 'is_enable_wallet' => 1,'cache' => array('config' => 'sec')));?>
			</div>
			<?php 
				echo $this->Form->end();
			} 
			?>
		</div>
	</div>
</div>