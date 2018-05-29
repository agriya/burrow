  <?php if($this->Auth->user('id')==$property['Property']['user_id']): ?>
				<?php $all_count=$property['Property']['sales_pending_count']+$property['Property']['sales_pipeline_count']; ?>
				<div class="properties-middle-block properties-middle-inner-block1 clearfix">
					<div class="dl well inbox-option dashboard-info span5 pull-left">
						<h5 class="textb bot-space"><?php echo __l('Reservations'); ?></h5>
						
							<?php echo $this->Html->link('<span class="label smspace">'.__l('All:').' '.$all_count.'</span>', array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'property_id' => $property['Property']['id'],'status' => 'all', 'admin' => false), array('title' => __l('All'),'escape' => false,'class'=>'smspace no-pad'));?>
							<?php echo $this->Html->link('<span class="label label-warning smspace">'.__l('Waiting for acceptance:').' '.$this->Html->cInt($property['Property']['sales_pending_count'],false).'</span>', array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'property_id' => $property['Property']['id'],'status' => 'waiting_for_acceptance', 'admin' => false), array('title' => __l('Waiting for acceptance'),'escape' => false,'class'=>'smspace no-pad'));?>
							<?php echo $this->Html->link('<span class="label label-success smspace">'.__l('Pipeline:').' '.($this->Html->cInt($property['Property']['sales_pipeline_count'],false)).'</span>', array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'property_id' => $property['Property']['id'],'status' => 'pipeline', 'admin' => false), array('title' => __l('Pipeline'),'escape' => false,'class'=>'smspace no-pad'));?>
						</span>
					</div>
					<div class="bookit-all dl well verfied-info-block span5 pull-left">
						<div class="clearfix">
						<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] === null) { ?>
						<div class="show clearfix">
						<?php echo $this->Html->link('<i class="icon-circle-arrow-up"></i>'.__l('Get Verified'), array('controller' => 'properties', 'action' => 'property_verify_now', $property['Property']['id'], 'admin' => false), array('escape'=>false,'title' => __l('Get Verified'),'class' => 'verified no-pad span'));?>
						</div>
						<?php } ?>
						<div class="show clearfix">
						<?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action'=>'edit', $property['Property']['id']), array('escape'=>false,'class' => 'edit js-edit no-pad pull-left span','title' => __l('Edit')));?>
						</div>
						<?php if (empty($property['Property']['is_paid']) && Configure::read('property.listing_fee')): ?>
						<div class="clearfix"><?php echo $this->Html->link('<i class="icon-money"></i>'.__l('Pay Listing Fee'), array('controller' => 'properties', 'action' => 'property_pay_now', $property['Property']['id'], 'admin' => false), array('title' => __l('Pay Listing Fee'),'class' => 'listing-fee pull-left span no-pad graydarkc','escape'=>false, 'escape'=>false));?></div>
						<?php endif; ?>
						<div class="show clearfix">
						<?php echo $this->Html->link('<i class="icon-calendar"></i>'.__l('Calendar'), array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'property_id' => $property['Property']['id'], 'admin' => false), array('escape'=>false, 'title' => __l('Calendar'),'class' => 'calendar no-pad span'));?>
						</div>
						</div>
						<div class="clearfix text-10 show space">
						<i class="icon-question-sign"></i><?php echo __l('Manage reservations & pricing');?>
						</div>
						<div class="clearfix hor-space show">
                        <h5><?php echo __l('Enable Listing'); ?></h5>
						<?php
							$url = Router::url(array(
								'controller' => 'properties',
								'action' => 'view',
								$property['Property']['slug'],
								'admin' => false
							) , true);
							$this->request->data['Property']['is_active']= $property['Property']['is_active'];
							echo $this->Form->create('Property', array('class' => 'normal js-ajax-form option-form no-pad clearfix '));
						?>
						
							<?php
								$options=array('1'=>'ON', '0'=>'OFF');
								$attributes=array('div'=>'js-radio-style',"class" => "js-activeinactive-updated  {'id': '". $property['Property']['id'] ."', 'url':'". $url ."'}", 'legend'=>false, 'value' => $property['Property']['is_active']);
								echo $this->Form->radio('is_active', $options, $attributes);
							?>
							<?php echo $this->Form->end(); ?>
						</div>
						
                    </div>
                  	<div class="dl well gird_right enable-list span5 pull-left">
                            <?php
                            $day1= date("D j", mktime(0, 0, 0, date("m"),date("d")-1,date("Y")));
                            $day2=date("D j", mktime(0, 0, 0, date("m"),date("d")-2,date("Y")));
                            $day3=date("D j", mktime(0, 0, 0, date("m"),date("d")-3,date("Y")));
                            $axis1=ceil($chart_data['max_count']/3);
                            $axis2=ceil($chart_data['max_count']/3)*2;
                            $axis3=ceil($chart_data['max_count']/3)*3;
                            	 $image_url='http://chart.apis.google.com/chart?chf=a,s,000000FA|bg,s,67676700&amp;chxl=0:|0|'.$day3.'|'.$day2.'|'.$day1.'|1:|0|'.$axis1.'|'.$axis2.'|'.$axis3.'&amp;chxs=0,676767,11.5,0,lt,676767&amp;chxtc=0,4&amp;chxt=x,y&amp;chs=200x125&amp;cht=lxy&amp;chco=0066E4,FF0285&amp;chds=0,3,0,'.$axis3.',0,3,0,'.$axis3.'&amp;chd=t:1,2,3|'. $chart_data['PropertyView'][3]['count'].','.$chart_data['PropertyView'][2]['count'].','.$chart_data['PropertyView'][1]['count'].'|1,2,3|'.$chart_data['PropertyUser'][3]['count'].','.$chart_data['PropertyUser'][2]['count'].','.$chart_data['PropertyUser'][1]['count'].'&amp;chdl=Views|Bookings&amp;chdlp=b&amp;chls=2,4,1|1&amp;chma=5,5,5,25';
                            echo $this->Html->image($image_url); ?>
					
					</div>
				</div>
			<?php  if(!empty($this->request->params['pass'][1]) &&  !empty($this->request->params['pass'][2]) && $distance_view) : ?>
				<div class="hovst-view-block pr page-information clearfix">
					<dl class="request-list1 host-view guest clearfix">
						<dt title ="<?php echo __l('Distance');?>"><?php echo __l('Distance (km)');?></dt>
						<dd class="dc"><?php echo $this->Html->cInt($this->Html->distance($this->request->params['named']['latitude'],$this->request->params['named']['longitude'],$property['Property']['latitude'],$property['Property']['longitude'],'K')); ?></dd>
					</dl>
					<div class="city-info ">
						<?php echo __l('from') . ' ' . $this->request->params['named']['cityname'];?>
					</div>
				</div>
			<?php endif; ?>

<?php else: ?>
<div class="js-responses">
<?php echo $this->Form->create('PropertyUser', array('action' => 'add', 'class' => 'property-view-form clearfix js-search no-mar')); ?>
  <div class="row no-mar">
<?php
	$num_array=array();
	for($i=1;$i<= $property['Property']['accommodates'];$i++) {
		if($i == $property['Property']['accommodates']) {
			$num_array[$i]=$i;
		} else {
			$num_array[$i]=$i;
		}
	}
	$properties_prices['price_per_night']=' <span class="no-pad bot-space pull-left"><span class="text-18 textb dc show"><span class="graydarkc ">'.Configure::read('site.currency').$this->Html->siteWithCurrencyFormat($property['Property']['price_per_night']).'</span></span><span class="text-11 show textb  hor-mspace">'.__l('per night').'</span></span>';
	if(!empty($property['Property']['price_per_week']) && $property['Property']['price_per_week']!=0) {
		$properties_prices['price_per_week']='<span class="no-pad bot-space pull-left"><span class="text-18 textb dc show">'. $this->Html->siteCurrencyFormat($property['Property']['price_per_week']).'</span>'.'<span class="text-11 show textb  hor-mspace">'.__l('per week')."</span></span>";
	} else {
		$properties_prices['price_per_week']='<span class="no-pad right-space pull-left"><span class="text-18 textb dc show">'. $this->Html->siteCurrencyFormat($property['Property']['price_per_night']*7).'</span>'.'<span class="text-11 show textb  hor-mspace">'.__l('per week')."</span></span>";
	}
	if (!empty($property['Property']['price_per_month'])&& $property['Property']['price_per_month']!=0) {
		$properties_prices['price_per_month']= '<span class="no-pad bot-space pull-left"><span class="text-18 textb dc show">'. $this->Html->siteCurrencyFormat($property['Property']['price_per_month']).'</span>'.'<span class="text-11 show textb  hor-mspace">'.__l('per month')."</span></span>";
	} else {
		$properties_prices['price_per_month']= '<span class="no-pad bot-space pull-left"><span class="text-18 textb dc show">'. $this->Html->siteCurrencyFormat($property['Property']['price_per_night']*30).'</span>'.'<span class="text-11 show textb  hor-mspace">'.__l('per month')."</span></span>";
		$properties_prices['price_per_month']= '<span class="no-pad bot-space pull-left"><span class="text-18 textb dc show">'. $this->Html->siteCurrencyFormat($property['Property']['price_per_night']*30).'</span>'.'<span class="text-11 show textb  hor-mspace">'.__l('per month')."</span></span>";
	}
	echo $this->Form->input('property_id',array('type'=>'hidden'));
	echo $this->Form->input('property_slug',array('type'=>'hidden'));
	echo $this->Form->input('price',array('type'=>'hidden'));
?>
<?php if(isset($this->request->params['named']['cityname'])): ?>
	<?php echo $this->Form->input('original_search_address',array('type'=>'hidden','value'=>$this->request->params['named']['cityname'])); ?>
<?php endif; ?>
	<div class="form-price dc bot-space no-mar span14 clearfix">
	  <?php echo $this->Form->radio('booking_option', $properties_prices, array("legend" => false, "class" => "js-price-list",'div'=>'')); ?>
	</div>
	<div class="span15 no-mar sep-top js-book-blok top-space">
	  <div class="span7 no-mar bookitform graydarkc clearfix">
		<div class="nav-tabs no-bor show text-11  no-round space dc">
		  <ul id="myTab" class="row unstyled no-mar text-11 pull-right">
			<li class="pull-left no-mar active"><a class="no-under js-show-calendar redc" href="#" data-toggle="tab" title="<?php echo __l('Calendar'); ?>"><?php echo __l('Calendar'); ?></a></li>
			<li class="pull-left hor-smspace">/</li>
			<li class="pull-left "><a class="no-under js-show-dropdown redc"  href="#" data-toggle="tab" title="<?php echo __l('Dropdown'); ?>"><?php echo __l('Dropdown'); ?></a></li>
		  </ul>
		</div>
		<?php echo $this->element('host-calendar', array('type' => 'guest', 'ids' => $property['Property']['id'], 'config' => 'sec')); ?>
		<div class="js-calender-formfield hide ">
			<div class="clearfix checkin-form-field top-mspace">
				<?php	
					echo $this->Form->input('checkin', array('class'=>'span2','label' => __l('Check in'), 'type' => 'date', 'minYear' => date('Y'), 'maxYear' => date('Y')+1, 'orderYear' => 'asc'));
					echo $this->Form->input('checkout', array('class'=>'span2','label' => __l('Check out'), 'type' => 'date','minYear' => date('Y'), 'maxYear' => date('Y')+1, 'orderYear' => 'asc'));
				?>
			</div>
		</div>
		<div class="cals-status sep-top">
		<p class="js-date-picker-info js-cal-status span7 pull-right text-11"></p>
		<div class="bookit-all full-calendar span7 dc js-calender-form-calender ">
		
			<?php 
				echo $this->Html->link(__l('Check in/Check out dates are not in this month? Select both dates'), array('controller' => 'properties', 'action' => 'calendar', 'guest_list', 'ids' =>  $property['Property']['id']), array('title'=> __l('Check in/Check out dates are not in this month? Select both dates'), 'escape' => false, 'class' => 'linkc js-no-pjax js-guest_list_calender_opening span6 pull-right text-11 right-space top-mspace', 'id' => 'js-full-calender-open')); 
			?>
		</div>
		<div class="span7 no-mar bookit-gustselect dl">
			<?php echo $this->Form->input('guests',array('label' => __l('Guests'), 'type'=>'select','options'=>$num_array,'class'=>'span3 mob-no-mar', 'selected'=>$additional_guest)); ?>
		</div>
		<?php if(isset($this->request->params['named']['cityname'])): ?>
			<?php echo $this->Form->input('original_search_address',array('type'=>'hidden','value'=>$this->request->params['named']['cityname'])); ?>
		<?php endif; ?>
	  </div>
	  </div>
	  <div class="js-price-details-response ">
		  <div class="span7 pull-right well js-highlight mob-clr">
				<div class="dl space mspace graydarkc">
				 <h3><?php echo __l('Price Details');?></h3>
					<p id="js-checkinout-date"></p>
					<dl class="dl-horizontal top-mspace condition-list clearfix js-price-for-product {'per_night': '<?php echo $this->Html->siteWithCurrencyFormat($property['Property']['price_per_night'],false);?>', 'per_week': '<?php echo $this->Html->siteWithCurrencyFormat($property['Property']['price_per_week'],false);?>', 'per_month': '<?php echo $this->Html->siteWithCurrencyFormat($property['Property']['price_per_month'],false);?>' , 'additional_guest_price': '<?php echo $property['Property']['additional_guest_price'];?>', 'property_commission_amount': '<?php echo Configure::read('property.booking_service_fee');?>', 'additional_guest': '<?php echo $property['Property']['additional_guest'];?>'}">
						<dt><?php echo __l('No. of nights');?></dt>
							<dd class="js-property-no_day-night bot-space"><?php echo $this->Html->cInt($property['Property']['minimum_nights']); ?></dd>
						<dt class="bot-space" ><?php echo __l('Price');?></dt>
							<dd class="bot-space"><?php echo Configure::read('site.currency'); ?><span class="js-property-per-night-amount">0</span></dd>
						<dt class="bot-space" ><?php echo __l('Additional Guest Prices ');?><span class="js-no_of_guest-price"></span></dt>
							<dd class="bot-space"><?php echo Configure::read('site.currency'); ?><span class="js-property-guest-amount">0</span></dd>
						<dt class="bot-space" ><?php echo __l('Sub Total');?></dt>
							<dd class="bot-space"><?php echo Configure::read('site.currency'); ?><span class="js-property-subtotal-amount">0</span></dd>
						<dt class="bot-space" ><?php echo __l('Service Tax');?></dt>
							<dd class="bot-space"><?php echo Configure::read('site.currency'); ?><span class="js-property-servicetax-amount">0</span></dd>
						<?php if (Configure::read('property.is_enable_security_deposit')): ?>
							<dt class="bot-space"><?php echo __l('Security Deposit');?><span class=" show span label label-info"><?php echo __l('Refundable'); ?></span></dt>
							<dd class="bot-space"><?php echo Configure::read('site.currency'); ?><span class="js-property-desposit-amount"><?php echo $this->Html->siteWithCurrencyFormat($property['Property']['security_deposit'],false); ?></span><span title="<?php echo __l('Ths deposit is for security purpose. When host raise any dispute on property damage, this amount may be used for compensation. So, total refund is limited to proper stay and booking cancellation/rejection/expiration. Note that site decision on this is final.'); ?>" class="left-space js-bootstrap-tooltip"><i class=" icon-info-sign"></i></span></dd>
						<?php endif; ?>
					</dl>
					<dl class="condition-list dl-horizontal ver-mspace">
								<dt><?php echo __l('Total');?></dt>
								<dd><?php echo Configure::read('site.currency'); ?> <span class="js-property-total-amount">0</span></dd>
							</dl>
				</div>
		  </div>
	  </div>
	</div>
	<div class="span15 no-mar  top-space clearfix sep-top">
		<div class="top-smspace pull-right right-space">
		<div class="normal clearfix no-mar">
			<?php if($property['Property']['is_active'] && $property['Property']['is_approved']) { ?>
				<div class="span">
					<?php echo $this->Form->submit(__l('Book it!'),array('class'=>'show btn btn-large btn-primary textb')); ?>
				</div>
			<?php } 
			if (!empty($property['Property']['is_negotiable']) && !empty($property['Property']['is_active']) && !empty($property['Property']['is_approved'])): ?>
				<div class="top-space show pull-left dl">
					<span class="top-mspace left-space"><?php echo __l('or'); ?></span> 
					<span class="hide">
					<?php echo $this->Form->submit(__l('Contact Me'), array('name' => 'data[PropertyUser][contact]', 'div' => false ,'escape' => false, 'class' => 'btn hor-smspace', 'id'=>"js-contact-me-button")); ?>
					</span>
					<a style="padding:4px 10px; clear:none; display:inline;" class="btn hor-smspace" id="js-contact-me" title="<?php echo __l('Contact Me'); ?>" href="#"><i class="icon-phone no-pad"></i></a>
					<a class="js-bootstrap-tooltip" href="#" title=" For pricing negotiation" style="padding:0; clear:none; display:inline;"> <i class="icon-question-sign text-16 grayc top-mspace"></i></a> 
				</div> 	
			<?php endif; ?>							
		</div>
	</div>
	</div>
  </div>
  <?php echo $this->Form->end();?>	
 </div>
 <?php endif;?>