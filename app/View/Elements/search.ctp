<?php 
$type=isset($type)?$type:'home';
$num_array=array();
for($i=1;$i<=16;$i++) {
  if($i == 16) {
	$num_array[$i]=$i . '+';
  } else {
	$num_array[$i]=$i;
  }
}
if (isset($this->request->params['named']['checkin'])) {
  $this->request->data['Property']['checkin'] = $this->request->params['named']['checkin'];
}
if (isset($this->request->params['named']['checkout'])) {
  $this->request->data['Property']['checkout'] = $this->request->params['named']['checkout'];
}
if (isset($this->request->params['named']['is_flexible']) && $this->request->params['named']['is_flexible']) {
  $this->request->data['Property']['is_flexible'] = $this->request->params['named']['is_flexible'];
}?>
<?php echo $this->Form->create('Property', array('class' => 'normal place-search js-search-map clearfix', 'action'=>'index', 'enctype' => 'multipart/form-data'));?>
<?php if($type=='home'): ?>
  <div class="banner">
	<div class="container">
	  <div class="banner-content">
		<div class="clearfix" itemprop="description">
		  <h2 class="span19 dc banner-content-bg offset2 graydarkc"><?php echo __l('Agriya\'s Online Booking Software for Real estate marketplace (Realty marketplace), Rental booking, Room sharing, Hotel booking, Office/Parking Space sharing, Car sharing, Bike sharing, Boat sharing, etc'); ?></h2>
		</div>
		<div class="top-space top-mspace clearfix">
		  <div class="span13 banner-content-bg offset5 graydarkc">
			<?php if(!isset($view)) { ?>
			  <div class="hor-space hor-mspace">
				<h3 class="test-24 hor-space hor-smspace mob-no-mar mob-no-pad"><?php echo Configure::read('site.slogan_text'); ?>&hellip;</h3>
			  </div>
			<?php } ?>
			<div class="clearfix dc"> <span class="top-space top-smspace show pull-left mob-clr"><i class="icon-map-marker text-24 top-space hor-mspace pull-left mob-clr"></i></span>
			  <div class="form-search bot-mspace ">
				<div class="result-block">
				  <?php echo $this->Form->input('Property.cityName', array('id'=>'PropertyCityName','class'=>'span9 ver-mspace','placeholder'=>'Where?','label' =>false));
				  echo $this->Form->input('Property.latitude', array('id' => 'latitude', 'type' => 'hidden'));
				  echo $this->Form->input('Property.longitude', array('id' => 'longitude', 'type' => 'hidden'));
				  echo $this->Form->input('Property.ne_latitude', array('id' => 'ne_latitude', 'type' => 'hidden'));
				  echo $this->Form->input('Property.ne_longitude', array('id' => 'ne_longitude', 'type' => 'hidden'));
				  echo $this->Form->input('Property.sw_latitude', array('id' => 'sw_latitude', 'type' => 'hidden'));
				  echo $this->Form->input('Property.sw_longitude', array('id' => 'sw_longitude', 'type' => 'hidden'));
				  echo $this->Form->input('Property.type', array( 'value' =>'search', 'type' => 'hidden'));?> 
				  <div id="mapblock" class="pa">
					<div id="mapframe">
					  <div id="mapwindow"></div>
					</div>
				  </div>
				  <?php echo $this->Form->submit(__l('Search'), array('value'=>__l('Search'),'id' => 'js-sub', 'class' => 'btn btn-large hor-mspace btn-primary textb text-16 top-space' ,'disabled' => 'disabled','div'=>false));?>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
  <?php if(!isset($view)) { ?>
	<div class="clearfix hide">
	  <?php echo $this->Form->input('Property.checkin',array('label' => __l('Check in'),'type'=>'date' ,'minYear'=>date('Y'), 'maxYear'=>date('Y')+1, 'orderYear' => 'asc'));
	  echo $this->Form->input('Property.checkout',array('label' => __l('Check out'), 'type'=>'date','minYear'=>date('Y'), 'maxYear'=>date('Y')+1, 'orderYear' => 'asc'));
	  echo $this->Form->input('Property.additional_guest', array('label' => __l('Guests'), 'type' => 'hidden', 'options' => $num_array));
	  echo $this->Form->input('Property.is_flexible', array('label' => sprintf(__l('Include non-%s matches (recommended)'), '<span class="exact round-3">' . __l('exact') . '</span>'), 'type' => 'hidden','checked'=>'checked')); ?>
	</div>
  <?php } ?>			
  <section class="row no-mar">
	<?php echo $this->element('popular-properties', array('config' => 'sec')); ?>
	<section class="row no-mar">
	  <div class="well no-pad no-round no-mar">
		<div class="container block-space">
		  <h3 class="dc bot-space bot-mspace"><?php echo __l('Popular Locations'); ?></h3>
		  <?php $city = '';
		  if ($this->request->url == 'properties' || $this->request->url == 'requests'):
		    $city = 'all';
		  endif;
		  if ($this->request->params['controller'] == 'requests' && isPluginEnabled('Requests')):
		    $is_request = 1;
		  else:
		    $is_request = 0;
		  endif;
		  echo $this->element('cities-index', array('is_request' => $is_request, 'city' => !empty($this->request->params['named']['city']) ? $this->request->params['named']['city'] : $city, 'config' => 'sec'));?>
		</div>
	  </div>
	</section>
	<section class="row no-mar">
	  <div class="container block-space">
		<h3 class="dc space bot-mspace">
		  <span class="btn-primary space img-circle">
			<?php echo $this->Html->image('burrow-icon.png', array('itemprop' => 'logo','alt'=>'[Image: Burrow]'));?>
		  </span>
		  <span class="show top-space top-mspace">Agriya Burrow Advantages</span>
		</h3>
		<div class="span24 no-mar ver-space">
		  <div class="span8 no-mar">
			<ol class="unstyled graydarkc">
			  <li class="bot-space sep-default-left span8 no-mar htruncate js-bootstrap-tooltip" title="First and complete multipurpose booking software"><span class="span7 htruncate">1. First and complete multipurpose booking software</span></li>
			  <li class="bot-space sep-default-left span8 no-mar htruncate js-bootstrap-tooltip" title="Has many revenue options (Signup fee, Property listing fee, Property verification fee, Commission on booking, Affiliate, Ads)"><span class="span7 htruncate">2. Has many revenue options (Signup fee, Property listing fee, Property verification fee, Commission on booking, Affiliate, Ads)</span></li>
			  <li class="bot-space sep-primary-left span8 no-mar htruncate js-bootstrap-tooltip" title="Multilingual support"><span class="span7 htruncate">3. Multilingual support</span></li>
			  <li class="bot-space sep-primary-left span8 no-mar htruncate js-bootstrap-tooltip" title="With MVC and plugin based architecture"><span class="span7 htruncate">4. With MVC and plugin based architecture</span></li>
			</ol>
		  </div>
		  <div class="span8">
			<ol class="unstyled graydarkc">
			  <li class="bot-space sep-default-left  span8 no-mar htruncate js-bootstrap-tooltip" title="Growth hacking plugin for improving user growth"><span class="span7 htruncate " >5. Growth hacking plugin for improving user growth</span></li>
			  <li class="bot-space sep-default-left span8 no-mar htruncate js-bootstrap-tooltip" title="High performance and cloud ready"><span class="span7 htruncate">6. High performance and cloud ready</span></li>
			  <li class="bot-space span8 sep-primary-left no-mar htruncate js-bootstrap-tooltip" title="Mobile friendly"><span class="span7 htruncate">7.  Mobile friendly</span></li>
			  <li class="bot-space sep-primary-left span8 no-mar htruncate js-bootstrap-tooltip" title="Streamlined workflow and hence no maintenance headaches"><span class="span7 htruncate">8. Streamlined workflow and hence no maintenance headaches</span></li>
			</ol>
		  </div>
		  <div class="span8">
			<ol class="unstyled graydarkc">
			 <li class="bot-space sep-default-left span8 no-mar htruncate js-bootstrap-tooltip" title="Smart implementation of ZazPay Payment Gateway."><span class="span7 htruncate " >9. 	Smart implementation of ZazPay Payment Gateway.</span></li>
			 <li class="bot-space sep-default-left span8 no-mar htruncate js-bootstrap-tooltip" title="Actively under development with customer suggestions and requests."><span class="span7 htruncate " >10.  Actively under development with customer suggestions and requests.</span></li>
			  <li class="bot-space dc sep-primary-left span8 no-mar htruncate">
				<?php echo $this->Html->link(__l("Contact Agriya"), "http://www.agriya.com/contact" ,array("escape" => false, 'target' => '_blank', 'class' => 'btn btn-large btn-primary textb top-mspace', 'title' => __l("Contact Agriya")));  ?> 
			  </li>
			</ol>
		  </div>
		</div>
		<div class="span24 no-mar top-space hor-mspace clearfix">
		  <h5 class="top-smspace right-space mob-no-pad textb span">Clone of</h5>
		  <span class="clone clearfix mob-bot-mspace "><?php echo $this->Html->image('cloneof.png', array('alt'=>__l("[Image: airbnb.com, 9flats.com, wimdu.com, roomorama.com, thestorefront.com, homeaway.com, onefinestay.com, vayable.com, sublet.com, vrbo.com, myfriendshotel.com, istopover.com, couchsurfing.org, stay4free.com, lodjee.com, evergreenclub.com, wheretosleep.co.uk]"), 'width' => '850', 'height' => '99', 'title'=>__l('airbnb.com, 9flats.com, wimdu.com, roomorama.com, thestorefront.com, homeaway.com, onefinestay.com, vayable.com, sublet.com, vrbo.com, myfriendshotel.com, istopover.com, couchsurfing.org, stay4free.com, lodjee.com, evergreenclub.com, wheretosleep.co.uk'))); ?></span>
		</div>
	  </div>
	</section>
  </section>	
<?php else: ?>
  <section class="row ver-space no-mar">
	<div class="span10 no-mar ver-space">
	  <div class="clearfix ver-space dc">
		<span class="top-space top-smspace show pull-left mob-clr"><i class="icon-map-marker text-24 top-space hor-mspace pull-left mob-clr"></i></span>
		<div class="form-search bot-mspace ">
		  <div class="result-block">
			<?php echo $this->Form->input('Property.cityName', array('id' => 'PropertyCityNameSearch','class'=>'span9 ver-mspace','placeholder'=>'Where?','label' =>false));
			echo $this->Form->input('Property.latitude', array('id' => 'latitude', 'type' => 'hidden'));
			echo $this->Form->input('Property.longitude', array('id' => 'longitude', 'type' => 'hidden'));
			echo $this->Form->input('Property.ne_latitude', array('id' => 'ne_latitude', 'type' => 'hidden'));
			echo $this->Form->input('Property.ne_longitude', array('id' => 'ne_longitude', 'type' => 'hidden'));
			echo $this->Form->input('Property.sw_latitude', array('id' => 'sw_latitude', 'type' => 'hidden'));
			echo $this->Form->input('Property.sw_longitude', array('id' => 'sw_longitude', 'type' => 'hidden'));
			echo $this->Form->input('Property.type', array( 'value' =>'search', 'type' => 'hidden'));?> 
			<div id="mapblock" class="pa">
			  <div id="mapframe">
			    <div id="mapwindow"></div>
			  </div>
		    </div>
		  </div>
		  <div class="input select span3">
			<?php echo $this->Form->input('Property.additional_guest',array('id'=>'additional_guest','div'=>false, 'label' => __l('Guests'),'class'=>'span2', 'type'=>'select','options'=>$num_array));?> 
		  </div>
		  <span class="span top-space show top-mspace mob-no-mar"> 
			<span class="ver-space show checkbox ver-mspace mob-no-mar">
			  <?php echo $this->Form->input('Property.is_flexible', array('label' => false, 'div' => false,'type' => 'checkbox', 'checked' => !empty($this->request->data['Property']['is_flexible']) ? 'checked' : '')); ?>
			  <label class="checker-img dl graydarkerc text-11" for="PropertyIsFlexible">
			  <?php echo __('Include non-'); ?><span class="label"><?php echo __('exact'); ?></span> <span class="show"><?php echo __('matches(recommended)'); ?></span></label>
			</span> 
		  </span>
		  <div class="submit pull-right right-space ver-space ver-mspace mob-no-pad mob-no-mar top-space mob-clr">
			<?php echo $this->Form->submit(__l('Search'), array('id' => 'js-sub', 'class' => 'btn btn-large hor-mspace btn-primary textb top-mspace text-16 top-space'  ,'disabled' => 'disabled'));?>
		  </div>
		</div>
	  </div>
	</div>
	<div class="span14">
	  <div class="nav-tabs no-bor ver-smspace clearfix">
		<ul id="myTab" class="row unstyled no-mar text-11 pull-right">
		  <li class="pull-left no-mar active">
			<a title="<?php echo __l('Calendar'); ?>" data-toggle="tab" href="#" class="no-under js-show-search-calendar"><?php echo __l('Calendar'); ?></a>
		  </li>
		  <li class="pull-left hor-smspace">/</li>
		  <li class="pull-left ">
			<a title="<?php echo __l('Dropdown'); ?>" data-toggle="tab" href="#" class="no-under js-show-search-dropdown"><?php echo __l('Dropdown'); ?></a>
		  </li>
		</ul>
	  </div>
	  <div class="tab-content" id="myTabContent"> 
		<div class="clearfix pull-right mob-clr dc">
		  <div id="js-inlineDatepicker-calender" class="<?php echo (Configure::read('property.set_default_calendar_type')  == 'calendar') ? 'hide' : null; ?>">
			<div class="input select clearfix">
			  <?php echo $this->Form->input('Property.checkin',array('div'=>false,'class'=>'span3','label' => '<b>'.__l('Check in').'</b>', 'type' => 'date' ,'minYear'=>date('Y'), 'maxYear'=>date('Y')+1, 'orderYear' => 'asc')); ?>
			</div>
			<div class="clearfix top-mspace">
			  <?php echo $this->Form->input('Property.checkout',array('div'=>false,'class'=>'span3','label' => '<b>'.__l('Check out').'</b>', 'type' => 'date','minYear'=>date('Y'), 'maxYear'=>date('Y')+1, 'orderYear' => 'asc'));		?>
			</div>
		  </div>
		  <div id="js-inlineDatepicker" class="<?php echo (Configure::read('property.set_default_calendar_type')  == 'dropdown') ? 'hide' : null; ?> span14 no-mar"></div>
		  <div class="span14 no-mar dr grayc text-11">
		    <span class="js-date-picker-info <?php echo (Configure::read('property.set_default_calendar_type')  == 'dropdown') ? 'hide' : null; ?>"></span>
		  </div>
		</div>
	  </div>
	</div>
  </section>
<?php endif; ?>
<?php echo $this->Form->end();?>
  