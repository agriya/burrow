<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php Configure::write('highperformance.uids', $this->Auth->user('id'));
if (!empty($properties)) {
  foreach ($properties as $property){
    Configure::write('highperformance.pids', Set::merge(Configure::read('highperformance.pids') , $property['Property']['id']));
  }
}?>
<?php 
$hash = !empty($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
$salt = !empty($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : '';
$allow = true;
if (isset($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'favorite' && isPluginEnabled('PropertyFavorites')) || isset($near_by) || (isset($this->request->params['named']['view']) && $this->request->params['named']['view'] == 'compact')):
 $allow = false;
endif;
if ((isset($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'user' && $this->request->params['named']['type'] != 'favorite' && !isset($near_by)) || empty($this->request->params['named'])) {
  if ($search_keyword) {
	$city = isset($search_keyword['named']['cityname']) ? $search_keyword['named']['cityname'] : '';
	$latitude = isset($search_keyword['named']['latitude']) ? $search_keyword['named']['latitude'] : '';
	$longitude = isset($search_keyword['named']['longitude']) ? $search_keyword['named']['longitude'] : '';
	$checkin = isset($search_keyword['named']['checkin']) ? $search_keyword['named']['checkin'] : '';
	$checkout = isset($search_keyword['named']['checkout']) ? $search_keyword['named']['checkout'] : '';
	$additional_guest = isset($search_keyword['named']['additional_guest']) ? $search_keyword['named']['additional_guest'] : '';
	$type = isset($search_keyword['named']['type']) ? $search_keyword['named']['type'] : '';
	$is_flexible = isset($search_keyword['named']['is_flexible']) ? $search_keyword['named']['is_flexible'] : '';
	$holidaytype = isset($search_keyword['named']['holidaytype']) ? $search_keyword['named']['holidaytype'] : '';
	$roomtype = isset($search_keyword['named']['roomtype']) ? $search_keyword['named']['roomtype'] : '';
	$amenity = isset($search_keyword['named']['amenity']) ? $search_keyword['named']['amenity'] : '';
	$rangefrom = isset($search_keyword['named']['range_from']) ? $search_keyword['named']['range_from'] : '1';
	$rangeto = isset($search_keyword['named']['range_to']) ? $search_keyword['named']['range_to'] : '300+';
	$depositfrom = isset($search_keyword['named']['deposit_from']) ? $search_keyword['named']['deposit_from'] : '0';
	$depositto = isset($search_keyword['named']['deposit_to']) ? $search_keyword['named']['deposit_to'] : '300+';
	$keyword = isset($search_keyword['named']['keyword']) ? $search_keyword['named']['keyword'] : '';
	$cityy = isset($search_keyword['named']['city']) ? $search_keyword['named']['city'] : 'all';
	$min_beds = isset($search_keyword['named']['min_beds']) ? $search_keyword['named']['min_beds'] : '1';
	$min_bedrooms = isset($search_keyword['named']['min_bedrooms']) ? $search_keyword['named']['min_bedrooms'] : '1';
	$min_bathrooms = isset($search_keyword['named']['min_bathrooms']) ? $search_keyword['named']['min_bathrooms'] : '1';
	if (!empty($rangeto)) {
	  $this->request->data['Property']['range_to'] = $rangeto;
    }
  } else {
	$city = isset($this->request->params['named']['cityname']) ? $this->request->params['named']['cityname'] : '';
	$latitude = isset($this->request->params['named']['latitude']) ? $this->request->params['named']['latitude'] : '';
	$longitude = isset($this->request->params['named']['longitude']) ? $this->request->params['named']['longitude'] : '';
	$checkin = isset($this->request->params['named']['checkin']) ? $this->request->params['named']['checkin'] : '';
	$checkout = isset($this->request->params['named']['checkout']) ? $this->request->params['named']['checkout'] : '';
	$additional_guest = isset($this->request->params['named']['additional_guest']) ? $this->request->params['named']['additional_guest'] : '';
	$type = isset($this->request->params['named']['type']) ? $this->request->params['named']['type'] : '';
	$is_flexible = isset($this->request->params['named']['is_flexible']) ? $this->request->params['named']['is_flexible'] : '';
	$holidaytype = isset($this->request->params['named']['holidaytype']) ? $this->request->params['named']['holidaytype'] : '';
	$roomtype = isset($this->request->params['named']['roomtype']) ? $this->request->params['named']['roomtype'] : '';
	$amenity = isset($this->request->params['named']['amenity']) ? $this->request->params['named']['amenity'] : '';
	$rangefrom = isset($this->request->params['named']['range_from']) ? $this->request->params['named']['range_from'] : '1';
	$rangeto = isset($this->request->params['named']['range_to']) ? $this->request->params['named']['range_to'] : '300+';
	$depositfrom = isset($this->request->params['named']['deposit_from']) ? $this->request->params['named']['deposit_from'] : '0';
	$depositto = isset($this->request->params['named']['deposit_to']) ? $this->request->params['named']['deposit_to'] : '300+';
	$keyword = isset($this->request->params['named']['keyword']) ? $this->request->params['named']['keyword'] : '';
	$cityy = isset($this->request->params['named']['city']) ? $this->request->params['named']['city'] : 'all';
	$min_beds = isset($this->request->params['named']['min_beds']) ? $this->request->params['named']['min_beds'] : '1';
	$min_bedrooms = isset($this->request->params['named']['min_bedrooms']) ? $this->request->params['named']['min_bedrooms'] : '1';
	$min_bathrooms = isset($this->request->params['named']['min_bathrooms']) ? $this->request->params['named']['min_bathrooms'] : '1';
	if (!empty($rangeto)) {
	$this->request->data['Property']['range_to'] = $rangeto;
	}
  }
  $network_level_arr = array(
	  '1' => 'st',
	  '2' => 'nd',
	  '3' => 'rd',
	  '4' => 'th',
  );
  for ($n = 1; $n <= Configure::read('property.network_level'); $n++) {
    $network_count = !empty($network_property_count[$n]) ? $network_property_count[$n] : 0;
    $networkLevels[$n] = $n . $network_level_arr[$n] . ' ' . __l('level') . ' (' . $network_count . ')';
  }
  if ($search == 'normal'):
    if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='collection' && isPluginEnabled('Collections')):
	  echo $this->element('slider', array('config' => 'sec','properties' => $properties, 'collections' => $collections));
    elseif($allow):
	  echo $this->element('search', array('config' => 'sec','type'=>'search'));
    endif;
  endif;
  if((!empty($this->request->params['named']['latitude']) && !empty($this->request->params['named']['longitude'])) || (!empty($search_keyword['named']['latitude']) && !empty($search_keyword['named']['longitude']))) {
    if(empty($current_latitude)) {
	  $current_latitude=!empty($property['Property']['latitude'])?$property['Property']['latitude']:'';
	  $current_longitude=!empty($property['Property']['longitude'])?$property['Property']['longitude']:'';
    }
  }
} 
if($is_searching): ?>
  <section class="row no-mar">
	<div class="span24 no-mar pr <?php echo ($search == 'normal' || !empty($this->request->params['isAjax'])) ? 'js-responses  js-response' : ''; ?>">
	  <?php if($search == 'normal'): ?>
		<span class="js-search-lat {'cur_lat':'<?php echo $current_latitude; ?>','cur_lng':'<?php echo $current_longitude; ?>'}"></span>
	  <?php endif; ?>
	<div class="clearfix <?php if ($allow) { ?> properties-index-page <?php } ?>">
	 <?php
	  if((!empty($search_keyword['named']['sw_latitude']))): ?>
		<div class="page-information"><?php echo __l('Narrow your search to street or at least city level to get better results.'); ?></div>
	  <?php endif;
	  if((isset($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'user' && $this->request->params['named']['type'] != 'related' && !isset($near_by) && $allow) || empty($this->request->params['named']) || (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'favorite' && isPluginEnabled('PropertyFavorites'))) {
		if($allow): ?>
		  <div class="well space clearfix">
			<div class="js-toggle-show-block">
			  <h3 class="ver-space pull-left redc textb text-16">
			    <a class="js-toggle-show {'container':'js-share-results'}" href="#"><?php echo __l('Share Results'); ?></a>
			  </h3>
			</div>
			<div class="pull-right graydarkerc top-space dropdown"><?php echo $this->Html->Cint($total_result); ?> <?php echo __l('results'); ?>
			  <?php $sortby = __l('Distance');
			  if(!empty($this->request->params['named']['sortby'])):
				if($this->request->params['named']['sortby'] == 'high') :
				  $sortby = __l('Price low to high');
				elseif($this->request->params['named']['sortby'] == 'low') :
				  $sortby = __l('Price high to low');
				else:
				  $sortby = ucfirst($this->request->params['named']['sortby']);
				endif;
			  endif;?>
			  <a href="#" data-toggle="dropdown" class="btn text-14 textb graylighterc no-shad hor-mspace dropdown-toggle" title="<?php echo $sortby; ?>">
				<span class="show right-space pull-left"><?php echo $sortby; ?></span>
				<span class="show pull-left"><i class="icon-caret-down no-pad no-mar"></i></span>
			  </a>
			  <ul class="dropdown-menu arrow arrow-right hor-mspace">
				<?php if((!empty($search_keyword['named']['latitude'])) ):
				  $class=((isset($this->request->params['named']['sortby'])&& $this->request->params['named']['sortby']=='distance') || !isset($this->request->params['named']['sortby']))?'active':''; ?>
				  <li  class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Distance'), array('controller' => 'properties', 'action' => 'index',$hash,$salt,'sortby' =>'distance','admin' => false), array('title'=>$this->Html->cText('Distance',false),'escape' => false));	?>	</li>
				<?php endif;
				if(isPluginEnabled('PropertyFavorites')) :
				  $class=(isset($this->request->params['named']['sortby'])&& $this->request->params['named']['sortby']=='favorites')?'active':''; ?>
				  <li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Favorites'), array('controller' => 'properties', 'action' => 'index',$hash,$salt,'sortby' =>'favorites',  'admin' => false), array('title'=>__l('Favorites'),'escape' => false));	?>	</li>
				<?php endif;
				$class=(isset($this->request->params['named']['sortby'])&& $this->request->params['named']['sortby']=='high')?'active':''; ?>
				<li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Price low to high'), array('controller' => 'properties', 'action' => 'index',$hash,$salt,'sortby' =>'high',  'admin' => false), array('title'=>__l('Price low to high'),'escape' => false));	?>	</li>
				<?php $class=(isset($this->request->params['named']['sortby'])&& $this->request->params['named']['sortby']=='low')?'active':''; ?>
				<li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Price high to low'), array('controller' => 'properties', 'action' => 'index',$hash,$salt,'sortby' =>'low', 'admin' => false), array('title'=>__l('Price high to low'),'escape' => false));	?>	</li>
				<?php $class=(isset($this->request->params['named']['sortby'])&& $this->request->params['named']['sortby']=='recent')?'active':''; ?>
				<li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Recent'), array('controller' => 'properties', 'action' => 'index',$hash,$salt,'sortby' =>'recent',  'admin' => false), array('title'=>__l('Recent'),'escape' => false));	?>	</li>
				<?php $class=(isset($this->request->params['named']['sortby'])&& $this->request->params['named']['sortby']=='reviews')?'active':''; ?>
				<li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Reviews'), array('controller' => 'properties', 'action' => 'index',$hash,$salt,'sortby' =>'reviews',  'admin' => false), array('title'=>__l('Reviews'),'escape' => false));	?>	</li>
				<?php $class=(isset($this->request->params['named']['sortby'])&& $this->request->params['named']['sortby']=='featured')?'active':''; ?>
				<li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Featured'), array('controller' => 'properties', 'action' => 'index',$hash,$salt,'sortby' =>'featured',  'admin' => false), array('title'=>__l('Featured'),'escape' => false));	?>	</li>
			  </ul>
			</div>
		  </div>
		  <div class="js-share-results hide clearfix">
			<div class="pr pull-left">
			  <?php if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'collection' && isPluginEnabled('Collections')) { 
				$slug = isset($this->request->params['named']['slug'])? $this->request->params['named']['slug']:$search_keyword['named']['slug'];
				$embed_code = Router::url('/',true).'collection/'.$slug;
			  } else {
				$embed_code = Router::url(array('controller'=>'properties','action'=>'index',$hash,$salt), true);
			  }
			  echo $this->Form->input('share_url', array('class' => 'clipboard js-selectall', 'readonly' => 'readonly', 'label' => false, 'value' => $embed_code));?>
			  <span class="js-toggle-show {'container':'js-share-results'} share-close redc pa"><i class="icon-remove-sign cur"></i></span>
			</div>
		  </div>
		<?php elseif(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='favorite' && isPluginEnabled('PropertyFavorites')):
		  if(empty($this->request->params['isAjax'])):?>
			<h2 class="ver-space top-mspace text-32 sep-bot"><?php  echo __l('Liked Properties'); ?></h2>
		  <?php endif;
		endif;
	  } ?>
	  <?php if((isset($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'user' && $this->request->params['named']['type'] != 'related' && !isset($near_by) && $allow) || empty($this->request->params['named'])) { ?>
		<aside class="haccordion pa mob-ps">
		  <ul class="unstyled text-16">
			<?php echo $this->Form->create('Property', array('id'=> 'KeywordsSearchForm','class' => 'check-form js-search-map js-ajax-search-form norma keywords no-mar','action'=>'index')); ?>
			<li class="sep-bot">
			  <div class="graydarkc no-under" title="<?php echo __l('Refine'); ?>">
				<div id="accordion1" class="accordion no-mar">
				  <div class="space clearfix"><span class="accordion-menu cur pull-left"><span class="width22 pull-left show dc"><i class="icon-map-marker cur text-20 no-pad"></i></span><span class="hor-space left-mspace"><?php echo __l('Refine'); ?></span></span>
				    <div class="accordion-list thumbnail no-round no-pad pull-right"> <a href="#collapseOne" data-parent="#accordion1" data-toggle="collapse" class="whitec hor-smspace accordion-toggle js-toggle-icon"><i class="icon-plus no-pad graylightc text-10"></i></a></div>
				  </div>
			    </div>
			    <div id="collapseOne" class="accordion-body collapse block2">
			      <div class="thumbnail no-bor no-shad no-round space clearfix">
				    <div id="js-map-container"></div>
				    <a href="javascript:void(0);" class="show btn btn-large ver-smspace btn-primary textb text-16 map-button js-mapsearch-button" title="<?php echo __l('Update'); ?>"><?php echo __l('Update'); ?></a>
				    <div class="form-search ver-mspace  clearfix">
				      <div class="input text pull-left"> 
					    <span class="span no-mar">
					      <?php echo $this->Form->input('Property.keyword', array('placeholder' =>__l('Keywords'),'label'=>false,'div'=>false,'value'=>$keyword,'class'=>'span4 text-16')); ?>
					    </span>
				      </div>
				      <a href="javascript:void(0);" class="pull-right mob-clr show btn btn-large textb text-16 js-submit-button" title="Search"><i class="icon-search no-pad no-mar textb text-16"></i></a>
				    </div>
			      </div>
			    </div>
		      </div>
			</li>
			<li class="sep-bot">
			  <div class="graydarkc no-under" title="<?php echo __l('Room Types'); ?>">
				<div id="accordion2" class="accordion no-mar">
				  <div class="space clearfix"><span class="accordion-menu cur pull-left"> <span class="width22 pull-left show dc"><i class="icon-home cur text-18 no-pad"></i></span> <span class="hor-space left-mspace"><?php echo __l('Room Types'); ?></span></span>
				    <div class="accordion-list thumbnail no-round no-pad pull-right"> <a href="#collapseTwo" data-parent="#accordion2" data-toggle="collapse" class="whitec hor-smspace accordion-toggle js-toggle-icon"><i class="icon-plus no-pad graylightc text-10"></i></a></div>
				  </div>
				</div>
				<div id="collapseTwo" class="accordion-body collapse">
				  <div class="thumbnail no-bor no-shad no-round space clearfix">
					<div class="bot-mspace">
					  <div class="graydarkerc text-14"> 
						<?php echo $this->Form->input('RoomType', array('type'=>'select', 'multiple'=>'checkbox', 'class'=>' checkbox clearfix show top-mspace', 'label' =>false)); ?>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</li>
			<li class="sep-bot">
			  <div class="graydarkc no-under" title="<?php echo __l('Property Types'); ?>">
				<div id="accordion3" class="accordion no-mar">
				  <div class="space clearfix"> <span class="accordion-menu cur pull-left"><span class="width22 pull-left show dc"><i class="icon-building cur text-18 no-pad"></i></span><span class="hor-space left-mspace"><?php echo __l('Property Types'); ?></span></span>
					<div class="accordion-list thumbnail no-round no-pad pull-right"> <a href="#collapseThree" data-parent="#accordion3" data-toggle="collapse" class="whitec hor-smspace accordion-toggle js-toggle-icon"><i class="icon-plus no-pad graylightc text-10"></i></a></div>
				  </div>
				</div>
				<div id="collapseThree" class="accordion-body collapse">
				  <div class="thumbnail no-bor no-shad no-round space clearfix">
					<div class="bot-mspace">
					  <div class=" text-14"> 
						<?php echo $this->Form->input('Property.PropertyType', array('type'=>'select', 'multiple'=>'checkbox',  'class' => 'show top-mspace checkbox clearfix', 'label' =>false)); ?>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</li>
			<li class="sep-bot">
			  <div class="graydarkc no-under" title="<?php echo __l('Holiday Types'); ?>">
				<div id="accordion4" class="accordion no-mar">
				  <div class="space clearfix"> <span class="accordion-menu cur pull-left"><span class="width22 pull-left show dc"><i class="icon-umbrella cur text-18	no-pad"></i></span><span class="hor-space left-mspace"><?php echo __l('Holiday Types'); ?></span></span>
					<div class="accordion-list thumbnail no-round no-pad pull-right"> <a href="#collapseFour" data-parent="#accordion4" data-toggle="collapse" class="whitec hor-smspace accordion-toggle js-toggle-icon"><i class="icon-plus no-pad graylightc text-10"></i></a></div>
				  </div>
				</div>
				<div id="collapseFour" class="accordion-body collapse">
				  <div class="thumbnail no-bor no-shad no-round space clearfix">
					<div class="bot-mspace">
					  <div class="graydarkerc text-14"> 
						<?php echo $this->Form->input('Property.HolidayType', array('type'=>'select', 'multiple'=>'checkbox',  'class' =>'show top-mspace checkbox clearfix', 'label' =>false)); ?>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</li>
			<li class="sep-bot">
			  <div class="graydarkc no-under" title="<?php echo __l('Price Range'); ?>">
				<div id="accordion5" class="accordion no-mar">
				  <div class="space clearfix"> <span class="accordion-menu cur pull-left"><span class="width22 pull-left show dc"><i class="icon-money cur text-1818 no-pad"></i></span><span class="hor-space left-mspace"><?php echo __l('Price Range'); ?></span></span>
					<div class="accordion-list thumbnail no-round no-pad pull-right"> <a href="#collapseFive" data-parent="#accordion5" data-toggle="collapse" class="whitec hor-smspace accordion-toggle js-toggle-icon"><i class="icon-plus no-pad graylightc text-10"></i></a></div>
				  </div>
				</div>
				<div id="collapseFive" class="accordion-body collapse">
				  <div class="thumbnail no-bor no-shad no-round space clearfix">
					<div class="bot-mspace">
					  <div class="graydarkerc text-14">
						<div class="price-range-info-block dc">
						  <span class="price-range tb ver-space"><?php echo __l('Price range ');?></span>
						  <span class="js-rang-from"><?php echo $rangefrom; ?></span><?php echo __l(' to '); ?><span class="js-rang-to"><?php echo $rangeto; ?></span>
						</div>
						<div class="clearfix">
						  <?php echo $this->Form->input('Property.range_from', array('type'=>'hidden', 'id'=>'js-range_from', 'label' =>false)); ?>
						  <?php echo $this->Form->input('Property.range_to', array('type'=>'hidden', 'id'=>'js-range_to','label' =>false)); ?>
						  <div class="input select top-mspace">
						  <?php echo $this->Form->input('Property.price_range', array('type'=>'select', 'data-slider_min' => 1, 'data-slider_max' => 301, 'id'=>'js-price-range', 'label' =>false, 'class' => 'js-uislider { name: "range"} hide', 'div'=>false )); ?>
							</div>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</li>
			<?php if (Configure::read('property.is_enable_security_deposit')): ?>
			  <li class="sep-bot">
				<div class="graydarkc no-under" title="<?php echo __l('Security Deposit'); ?>">
				  <div id="accordion6" class="accordion no-mar">
					<div class="space clearfix"> <span class="accordion-menu cur pull-left"><span class="width22 pull-left show dc"><i class="icon-lock cur text-18 no-pad"></i></span><span class="hor-space left-mspace"><?php echo __l('Security Deposit'); ?></span></span>
					  <div class="accordion-list thumbnail no-round no-pad pull-right"> <a href="#collapseSix" data-parent="#accordion6" data-toggle="collapse" class="whitec hor-smspace accordion-toggle js-toggle-icon"><i class="icon-plus no-pad graylightc text-10"></i></a></div>
					</div>
				  </div>
				  <div id="collapseSix" class="accordion-body collapse">
					<div class="thumbnail no-bor no-shad no-round space clearfix">
					  <div class="bot-mspace">
						<div class="graydarkerc text-14">
						  <div class="price-range-info-block dc">
							<span class="price-range tb"><?php echo __l('Deposit range ');?></span>
							<span class="js-deposit-from"><?php echo $depositfrom; ?></span><?php echo __l(' to '); ?>
							<span class="js-deposit-to"><?php echo $depositto; ?></span>
						  </div>	
						<div class="clearfix space">				
						<?php echo $this->Form->input('Property.deposit_from', array('type'=>'hidden', 'id'=>'js-deposit_from', 'label' =>false)); ?>
						  <?php echo $this->Form->input('Property.deposit_to', array('type'=>'hidden', 'id'=>'js-deposit_to','label' =>false)); ?>
						  <div class="input select top-mspace">
						  <?php echo $this->Form->input('Property.deposit_range', array('type'=>'select', 'data-slider_min' => 1, 'data-slider_max' => 301, 'id'=>'js-deposit-range', 'label' =>false, 'class' => 'js-uislider { name: "deposit"} hide','div'=>false)); ?>
						  </div>
						 </div>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </li>
			<?php endif; ?> 
			<li class="sep-bot">
			  <div class="graydarkc no-under" title="<?php echo __l('Amenities'); ?>">
				<div id="accordion7" class="accordion no-mar">
				  <div class="space clearfix"> <span class="accordion-menu cur pull-left"><span class="width22 pull-left show dc"><i class="icon-link cur text-18	no-pad"></i></span><span class="hor-space left-mspace"><?php echo __l('Amenities'); ?></span></span>
					<div class="accordion-list thumbnail no-round no-pad pull-right"> <a href="#collapseSeven" data-parent="#accordion7" data-toggle="collapse" class="whitec	hor-smspace accordion-toggle js-toggle-icon"><i class="icon-plus no-pad graylightc text-10"></i></a></div>
				  </div>
				</div>
				<div id="collapseSeven" class="accordion-body collapse">
				  <div class="thumbnail no-bor no-shad no-round space clearfix">
					<div class="bot-mspace">
					  <div class="graydarkerc text-14"> 
						<?php echo $this->Form->input('Property.Amenity', array('type'=>'select', 'multiple'=>'checkbox',  'class'=>'show top-mspace checkbox clearfix', 'label' =>false)); ?>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</li>
			<?php if (!empty($_SESSION['network_level']) || ($this->Auth->user('id') && !$this->Auth->user('is_facebook_friends_fetched'))): ?>
			  <li class="sep-bot">
				<div class="graydarkc no-under" title="<?php echo __l('Social Networks'); ?>">
				  <div id="accordion10" class="accordion no-mar">
					<div class="space clearfix"> <span class="accordion-menu cur pull-left"><span class="width22 pull-left show dc"><i class="icon-globe cur text-18 no-pad"></i></span><span class="hor-space left-mspace"><?php echo __l('Social Networks'); ?></span></span>
					  <div class="accordion-list thumbnail no-round no-pad pull-right"> <a href="#collapseTen" data-parent="#accordion10" data-toggle="collapse" class="whitec hor-smspace accordion-toggle js-toggle-icon"><i class="icon-plus no-pad graylightc text-10"></i></a></div>
					</div>
				  </div>
				  <div id="collapseTen" class="accordion-body collapse">
					<div class="thumbnail no-bor no-shad no-round space clearfix">
					  <div class="bot-mspace">
						<div class="graydarkerc text-14"> 
						  <?php if (!empty($_SESSION['network_level'])): ?>
							<?php echo $this->Form->input('Property.network_level', array('type' => 'select', 'multiple' => 'checkbox', 'id' => 'SocialNetworks', 'options' => $networkLevels, 'label' => false)); ?>
						  <?php elseif ($this->Auth->user('id') && !$this->Auth->user('is_facebook_friends_fetched')): ?>
							<div class="social-network-connect">
							  <?php echo $this->Html->link(__l('Connect with Facebook'), $fb_login_url, array('class' => 'facebook-connect-link', 'title' => __l('Connect with Facebook'))); ?>
							  <?php echo '<span>' . ' ' . __l('to filter by Social Network level') . '</span>'; ?>
							</div>
						  <?php endif; ?>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </li>
			<?php endif; ?> 
			<li class="sep-bot">
			  <div class="graydarkc price-range no-under" title="<?php echo __l('Size'); ?>">
				<div id="accordion8" class="accordion no-mar">
				  <div class="space clearfix"> <span class="accordion-menu cur pull-left"><span class="width22 pull-left show dc"><i class="icon-fullscreen cur text-18 no-pad"></i></span><span class="hor-space left-mspace"><?php echo __l('Size'); ?></span></span>
					<div class="accordion-list thumbnail no-round no-pad pull-right"> <a href="#collapseEight" data-parent="#accordion8" data-toggle="collapse" class="whitec hor-smspace accordion-toggle js-toggle-icon"><i class="icon-plus no-pad graylightc text-10"></i></a></div>
				  </div>
				</div>
				<div id="collapseEight" class="accordion-body collapse">
				  <div class="thumbnail no-bor no-shad no-round space clearfix">
					<div  class="bot-mspace">
					  <div class="input checkbox graydarkerc text-14"> 
						<div class="ver-space">
						  <?php echo $this->Form->input('Property.min_bedrooms', array('type'=>'select', 'options'=>$minimum, 'id'=>'minimumBedRooms', 'label' =>__l('Min Bedrooms') . '<span class="js-min-bedroom-range">' . $min_bedrooms . '</span>', 'class' => 'hide')); ?>
						</div>
						<div class="ver-space">
						  <?php echo $this->Form->input('Property.min_bathrooms', array('type'=>'select', 'options'=>$minimum, 'id'=>'minimumBathRooms', 'label' =>__l('Min Bathrooms') . '<span class="js-min-bath-range">' . $min_bathrooms . '</span>', 'class' => 'hide')); ?>
						</div>
						<div class="ver-space">
						  <?php echo $this->Form->input('Property.min_beds', array('type'=>'select', 'options'=>$minimumBeds, 'id'=>'minimumBeds', 'label' =>__l('Min Beds') . '<span class="js-min-bed-range">' . $min_beds . '</span>', 'class' => 'hide')); ?>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</li>
			<li class="sep-bot">
			  <div class="graydarkc no-under" title="<?php echo __l('Languages Spoken'); ?>">
				<div id="accordion9" class="accordion no-mar">
				  <div class="space clearfix"> <span class="accordion-menu cur pull-left"><span class="width22 pull-left show dc"><i class="icon-group cur text-18 no-pad"></i></span><span class="hor-space left-mspace"><?php echo __l('Languages Spoken'); ?></span></span>
					<div class="accordion-list thumbnail no-round no-pad pull-right"> <a href="#collapseNine" data-parent="#accordion9" data-toggle="collapse" class="whitec hor-smspace accordion-toggle js-toggle-icon"><i class="icon-plus no-pad graylightc text-10"></i></a></div>
				  </div>
				</div>
				<div id="collapseNine" class="accordion-body collapse">
				  <div class="thumbnail no-bor no-shad no-round space clearfix">
					<div class="bot-mspace">
					  <div class="graydarkerc text-14"> 
						<?php echo $this->Form->input('Property.language', array('type'=>'select', 'multiple'=>'checkbox', 'class'=>'show top-mspace checkbox clearfix',  'label' =>false)); ?>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</li>
			<?php echo $this->Form->input('cityName', array('type' => 'hidden',	'id' => 'city_index', 'value' => $city));
			echo $this->Form->input('latitude', array('type' => 'hidden', 'value' => $latitude));
			echo $this->Form->input('longitude', array('type' => 'hidden', 'value' => $longitude));
			echo $this->Form->input('checkin', array('type' => 'hidden', 'value' => $checkin));
			echo $this->Form->input('checkout', array('type' => 'hidden', 'value' => $checkout));
			echo $this->Form->input('additional_guest', array('id' => 'property_additional_guest', 'type' => 'hidden', 'value' => $additional_guest));
			echo $this->Form->input('type', array('id' => 'type', 'type' => 'hidden', 'value' => (!empty($search_keyword['named']['type']) ? $search_keyword['named']['type'] : $this->request->params['named']['type'])));
			$type = !empty($search_keyword['named']['type']) ? $search_keyword['named']['type'] : $this->request->params['named']['type'];
			if ($type == 'collection' && isPluginEnabled('Collections')) {
			  echo $this->Form->input('slug', array('type' => 'hidden', 'value' => $collections['Collection']['slug']));
			}
			echo $this->Form->input('roomtype', array('type' => 'hidden', 'value' => $roomtype));
			echo $this->Form->input('holidaytype', array('type' => 'hidden', 'value' => $holidaytype));
			echo $this->Form->input('amenity', array('type' => 'hidden', 'value' => $amenity));
			echo $this->Form->input('city', array('type' => 'hidden', 'value' => $cityy));
			echo $this->Form->input('ne_longitude', array('type' => 'hidden', 'id' => 'ne_longitude_index'));
			echo $this->Form->input('sw_longitude', array('type' => 'hidden', 'id' => 'sw_longitude_index'));
			echo $this->Form->input('sw_latitude', array('type' => 'hidden', 'id' => 'sw_latitude_index'));
			echo $this->Form->input('ne_latitude', array('type' => 'hidden', 'id' => 'ne_latitude_index'));?>
			<div class="submit hide">
			  <?php echo $this->Form->submit(__l('Search'),array('div'=>false)); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		  </ul>
		</aside>
	  <?php }
	  $sectionRight = ' span23 pull-right';
	  if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='favorite')
		$sectionRight = '';?>
	  <section  id="Properties" class="mob-clr  bot-space <?php echo $sectionRight; ?>">
		<?php $view_count_url = Router::url(array('controller' => 'properties',	'action' => 'update_view_count'), true); ?>
		<ol class="unstyled prop-list-mob prop-list  no-mar js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}" start="<?php echo $this->Paginator->counter(array('format' => '%start%'));?>" >
		  <?php	if (!empty($properties)):
			$i = 0;
			$num= $this->Paginator->counter(array('format' => '%start%'));
			foreach ($properties as $property):
			  $class = null;
			  if ($i++ % 2 == 0) {
				$class = ' altrow';
			  }
			  if ($property['Property']['is_featured']) {
				$featured_class='featured';
			  } else {
				$featured_class='';
			  }	?>
			  <li class="clearfix ver-space sep-bot left-mspace mob-no-mar js-map-num <?php echo $num; ?>">
				<div class="span dc no-mar mob-no-pad"> <span class="label label-important textb show text-11 prop-count map_number "><?php echo $num; ?> </span> 
				  <?php if(isPluginEnabled('PropertyFavorites')) :
					if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))):?>
					  <div class="alpuf-<?php echo $property['Property']['id'];?> hide">
						<?php echo $this->Html->link('<i class="icon-star no-pad text-18"></i>', array('controller' => 'property_favorites', 'action'=>'delete', $property['Property']['slug']), array('escape' => false ,'class' => 'js-like js-no-pjax un-like top-space show no-under', 'title' => __l('Unlike'))); ?>
					  </div>
			 		  <div class="alpf-<?php echo $property['Property']['id'];?> hide">
						<?php echo $this->Html->link('<i class="grayc icon-star-empty no-pad text-18"></i>', array('controller' => 'property_favorites', 'action' => 'add', $property['Property']['slug']), array('escape' => false ,'title' => __l('Like'),'escape' => false ,'class' =>'js-like js-no-pjax like top-space show grayc no-under')); ?>
					  </div>
			  		  <div class='blpf-<?php echo $property['Property']['id'];?> hide'>
						<?php echo $this->Html->link('<i class="grayc icon-star-empty no-pad text-18"></i>', array('controller' => 'users', 'action' => 'login', '?' => 'f='. $this->request->url), array('title' => __l('Like'),'escape' => false ,'class' =>'like top-space show graylightc no-under')); ?>
					  </div>
					<?php else: ?>
					  <span>
						<?php if($this->Auth->sessionValid()):
						  if(!empty($property['PropertyFavorite'])):
							foreach($property['PropertyFavorite'] as $favorite):
							  if($property['Property']['id'] == $favorite['property_id'] && $property['Property']['user_id'] != $this->Auth->user('id')):
								echo $this->Html->link('<i class="icon-star no-pad text-18"></i>', array('controller' => 'property_favorites', 'action'=>'delete', $property['Property']['slug']), array('escape' => false ,'class' => 'js-like js-no-pjax un-like top-space show no-under', 'title' => __l('Unlike')));
							  endif;
							endforeach;
						  else:
							if( $property['Property']['user_id'] != $this->Auth->user('id')):
							  echo $this->Html->link('<i class="grayc icon-star-empty no-pad text-18"></i>', array('controller' => 'property_favorites', 'action' => 'add', $property['Property']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'js-like js-no-pjax like top-space show grayc no-under'));
							endif;
						  endif;
						else:
						  echo $this->Html->link('<i class="grayc icon-star-empty no-pad text-18"></i>', array('controller' => 'users', 'action' => 'login', '?' => 'f='. $this->request->url), array('title' => __l('Like'),'escape' => false ,'class' =>'like top-space show graylightc no-under'));
						endif;?>
					  </span>
					<?php endif;
				  endif;
				  if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))):?>
					<div class="aloed-<?php echo $property['Property']['id']; ?> hide">
					  <div class="dropdown">
					    <a href="#" title="Edit" class="dropdown-toggle text-14 textb graylighterc no-shad" data-toggle="dropdown"><i class="icon-cog graylightc no-pad text-16"></i></a>
						<ul class="dropdown-menu dl arrow">
						  <li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action'=>'edit', $property['Property']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'),'escape'=>false));?></li>
						  <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action'=>'delete', $property['Property']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete'),'escape'=>false));?> </li>
						</ul>
					  </div>
					</div>
				  <?php else:
					if ($property['Property']['user_id'] == $this->Auth->user('id')) : ?>
					  <div class="dropdown">
					    <a href="#" title="Edit" class="dropdown-toggle text-14 textb graylighterc no-shad" data-toggle="dropdown"><i class="icon-cog graylightc no-pad text-16"></i></a>
						<ul class="dropdown-menu dl arrow">
						  <li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action'=>'edit', $property['Property']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'),'escape'=>false));?></li>
						  <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action'=>'delete', $property['Property']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete'),'escape'=>false));?> </li>
						</ul>
					  </div>
					<?php endif; 
				  endif;?>
				</div>
				<div class="span hor-smspace dc mob-no-mar">
				  <?php $property['Attachment'][0] = !empty($property['Attachment'][0]) ? $property['Attachment'][0] : array();
				  echo $this->Html->link($this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'],$hash, $salt,  'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false, 'class' => 'prop-img'));?>
				</div>
				<?php if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'favorite')
					$spanClass = " span19 ";
				else
					$spanClass = " span18 ";
				?>
				<div class="<?php echo $spanClass; ?> pull-right no-mar mob-clr tab-clr">
				  <div class="clearfix left-mspace sep-bot">
					<div class="span10 bot-space no-mar">
					  <h4 class="textb text-16 ">
						<div class="htruncate bot-space clearfix span9 no-mar dl" data-placement="bottom">
						  <?php	
						  $lat = $property['Property']['latitude'];
						  $lng = $property['Property']['longitude'];
						  $id = $property['Property']['id'];
						  echo $this->Html->link($this->Html->cText($property['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], $hash, $salt, 'admin' => false), array('id'=>"js-map-side-$id",'class'=>"js-bootstrap-tooltip graydarkc js-map-data {'lat':'$lat','lng':'$lng'}",'title'=>$this->Html->cText($property['Property']['title'], false),'escape' => false));?>
						</div>
					  </h4>
					  <div class="clearfix bot-space dl span10 no-mar">
						<?php $flexible_class = '';
						if(isset($search_keyword['named']['is_flexible'])&& $search_keyword['named']['is_flexible'] ==1 && !empty($search_keyword['named']['latitude'])) {
						  if(!in_array($property['Property']['id'], $booked_property_ids) && in_array($property['Property']['id'], $exact_ids)) {?>
							<span class="label pull-left mob-inline right-mspace"><?php echo __l('exact'); ?></span> 
						  <?php	}
						}
						if (Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified']==ConstVerification::Verified):?>
						  <span class="label label-warning pull-left right-mspace mob-inline"><?php echo __l('Verified'); ?></span>
						<?php endif;
						if ($property['Property']['is_featured']): ?>
						  <span class="label featured pull-left  mob-inline"> <?php echo __l('Featured'); ?></span>
						<?php endif; ?>
					  </div>
					  	<p class="no-mar js-bootstrap-tooltip  htruncate span9 graydarkc" title="<?php echo $property['Property']['address'];?>">
						  <?php if(!empty($property['Country']['iso_alpha2'])): ?>
							<span class="flags flag-<?php echo strtolower($property['Country']['iso_alpha2']); ?> mob-inline top-smspace" title="<?php echo $property['Country']['name']; ?>"><?php echo $property['Country']['name']; ?></span>
						  <?php endif; ?>
						  <?php echo $this->Html->cText($property['Property']['address'], false);?>
						</p>
					</div>
					<div class="pull-right sep-left mob-clr mob-sep-none">
					  <dl class="dc list span mob-clr">
						<dt class="pr hor-mspace text-11"><?php echo __l('Per night');?></dt>
						<dd class="textb text-24 graydarkc pr hor-mspace">
						  <?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
							<?php echo Configure::read('site.currency').' '?>
						  <?php endif; ?>
						  <?php echo $this->Html->cCurrency($property['Property']['price_per_night']);?>
						  <?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
							<?php echo ' '.Configure::read('site.currency'); ?>
						  <?php endif; ?>
						</dd>
					  </dl>
					  <dl class="dc list span mob-clr">
						<dt class="pr hor-mspace text-11" ><?php echo __l('Per Week');?></dt>
						<dd class="text-11 top-space graydarkc pr hor-mspace" >
						  <?php if ($property['Property']['price_per_week']!=0):
							echo $this->Html->siteCurrencyFormat($property['Property']['price_per_week']);
						  else:
							echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']*7);
						  endif;?>
						</dd>
					  </dl>
					  <dl class="dc list span mob-clr">
						<dt class="pr hor-mspace text-11" ><?php echo __l('Per Month');?></dt>
						<dd class="text-11 top-space graydarkc pr hor-mspace" >
						  <?php if ($property['Property']['price_per_month']!=0):
							echo $this->Html->siteCurrencyFormat($property['Property']['price_per_month']);
						  else:
							echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']*30);
						  endif;?>
						</dd>
					  </dl>
					</div>
				  </div>
				  <div class="clearfix left-mspace">
					<ul class="unstyled mob-inline medium-thumb mob-clr top-space clearfix pull-left">
						<?php
							$i = 0;
							for($i = 0; $i<6; $i++){
								if(!empty($property['User']['UserComment'][$i])) {
									if($i != 5) {
						?>
							<li class="pull-left">
								<?php echo $this->Html->getUserAvatar($property['User']['UserComment'][$i]['PostedUser'], 'medium_thumb', true, '', 'admin','','',false);?>
							</li>	
						<?php
									} else {
						?>
							<li class="pull-left sep dc">
								<?php echo  $this->Html->link(__l("More"), array('controller' => 'users', 'action' => 'view', $property['User']['username'], 'admin' => false, '#Recommendations'), array('target' => '_blank', 'class'=>'js-no-pjax ver-space show text-11', 'title' => __l("More"), 'escape' => false));
								?>
							</li>
						<?php
									}
								} else {
									?>
							<li class="pull-left sep"></li>
									<?php
								}
						}	
						?>
					</ul>
					<div class="clearfix pull-right top-mspace mob-clr">
					  <?php if((!empty($search_keyword['named']['latitude']) || isset($near_by)) && !empty($property[0]['distance'])){?>
						<dl class="dc mob-clr sep-right list">
						  <dt class="pr hor-mspace text-11"><?php echo __l('Distance');?> <?php echo __l('(km)');?></dt>
						  <dd class="textb text-16 no-mar graydarkc pr hor-mspace"><?php echo $this->Html->cInt($property[0]['distance']*1.60934 ); ?></dd>
						</dl>
					  <?php } ?>
					  <dl class="dc mob-clr sep-right list">
						<dt class="pr hor-mspace text-11" ><?php echo __l('Views');?></dt>
						<dd class="textb text-16 no-mar graydarkc pr hor-mspace js-view-count-property-id js-view-count-property-id-<?php echo $property['Property']['id']; ?> {'id':'<?php echo $property['Property']['id']; ?>'}"><?php echo numbers_to_higher($property['Property']['property_view_count']); ?></dd>
					  </dl>
					  <dl class="dc mob-clr sep-right list">
						<dt class="pr hor-smspace text-11" ><?php echo __l('Positive');?></dt>
						<dd  class="textb text-16 no-mar graydarkc pr hor-mspace"><?php echo numbers_to_higher($property['Property']['positive_feedback_count']); ?></dd>
					  </dl>
					  <dl class="dc mob-clr sep-right list">
						<dt class="pr hor-mspace text-11"><?php echo __l('Negative');?></dt>
						<dd class="textb text-16 no-mar graydarkc pr hor-mspace"><?php echo numbers_to_higher($property['Property']['property_feedback_count'] - $property['Property']['positive_feedback_count']); ?></dd>
					  </dl>
					  <dl class="dc mob-clr list">
						<dt class="pr mob-clr hor-mspace text-11"><?php echo __l('Success Rate');?></dt>
						<?php if(empty($property['Property']['property_feedback_count'])){ ?>
						  <dd  class="textb text-16 no-mar graydarkc pr hor-mspace">n/a</dd>
						<?php }else{ ?>
						  <dd class="textb text-16 no-mar graydarkc pr hor-mspace">
							<?php if(!empty($property['Property']['positive_feedback_count'])){
							  $positive = floor(($property['Property']['positive_feedback_count']/$property['Property']['property_feedback_count']) *100);
							  $negative = 100 - $positive;
							}else{
							  $positive = 0;
							  $negative = 100;
							}
							echo	$this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=8DCA35|F47564&amp;chf=bg,s,FFFFFF00', array('width'=>'35px','height'=>'35px','title' => $positive.'%'));?>
						  </dd>
						<?php } ?>
					  </dl>
					  <?php if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))){?>
						<dl class="dc mob-clr list sep-left">
						  <dt class="pr hor-mspace text-11" title="<?php echo __l('Network Level'); ?>"><?php echo __l('Network'); ?></dt>
						  <dd class="textb text-16 no-mar graydarkc pr hor-mspace blfbr-<?php echo $property['Property']['id'];?> hide" title="<?php  echo __l('Connect with Facebook to find your friend level with host'); ?>"><?php  echo '?'; ?></dd>
						  <dd class="textb text-16 no-mar graydarkc pr hor-mspace alfbr-fb-e-<?php echo $property['Property']['id'];?> hide" title="<?php  echo __l('Enable Facebook friends level display in social networks page'); ?>"><?php  echo '?'; ?></dd>
						  <dd class="textb text-16 no-mar graydarkc pr hor-mspace alfbr-fb-d-<?php echo $property['Property']['id'];?> hide" title="<?php  echo __l('Host is not connected with Facebook'); ?>"><?php  echo '?'; ?></dd>
						  <dd class="textb text-16 no-mar graydarkc pr hor-mspace alfbr-fb-nl-<?php echo $property['Property']['id'];?> hide" title="<?php  echo __l('Network Level'); ?>"><?php  echo !empty($network_level[$property['Property']['user_id']]) ? $network_level[$property['Property']['user_id']] : ''; ?></dd>
						  <dd class="textb text-16 no-mar graydarkc pr hor-mspace alfbr-fb-na-<?php echo $property['Property']['id'];?> hide" title="<?php  echo __l('Not available'); ?>"><?php  echo __l('n/a'); ?></dd>
						</dl>
					  <?php }else{ ?>
						<?php if ($this->Auth->user('id') != $property['Property']['user_id']): ?>
						  <dl class="dc mob-clr sep-left list">
							<dt class="pr hor-mspace text-11" title="<?php echo __l('Network Level'); ?>"><?php echo __l('Network'); ?></dt>
							<?php if (!$this->Auth->user('is_facebook_friends_fetched')): ?>
							  <dd class="textb text-16 no-mar graydarkc pr hor-mspace" title="<?php  echo __l('Connect with Facebook to find your friend level with host');	?>"><?php  echo '?'; ?></dd>
							<?php elseif(!$this->Auth->user('is_show_facebook_friends')): ?>
							  <dd class="textb text-16 no-mar graydarkc pr hor-mspace" title="<?php  echo __l('Enable Facebook friends level display in social networks page'); ?>"><?php  echo '?'; ?></dd>
							<?php elseif(empty($property['User']['is_facebook_friends_fetched'])): ?>
							  <dd class="textb text-16 no-mar graydarkc pr hor-mspace" title="<?php  echo __l('Host is not connected with Facebook'); ?>"><?php  echo '?'; ?></dd>
							<?php elseif(!empty($network_level[$property['Property']['user_id']])): ?>
							  <dd class="textb text-16 no-mar graydarkc pr hor-mspace" title="<?php  echo __l('Network Level'); ?>"><?php  echo $network_level[$property['Property']['user_id']]; ?></dd>
							<?php else: ?>
							  <dd class="textb text-16 no-mar graydarkc pr hor-mspace" title="<?php  echo __l('Not available'); ?>"><?php  echo __l('n/a'); ?></dd>
							<?php endif; ?>
						  </dl>
						<?php endif;
					  } ?>
					</div>
				  </div>
				</div>
			  </li>
			  <?php $num++;
			endforeach;?>
		  <?php else:?>
		  	<li <?php if(empty($this->request->params['isAjax']) && $search == 'normal') { ?>class="sep-top" <?php } ?>>
			  <div class="space dc grayc">
				<?php if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'search' && isPluginEnabled('Requests')): ?>
				  <p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No properties available. You may %s on this address for others to respond.'), $this->Html->link(__l('create a request'), array('controller' => 'requests', 'action' => 'add', $hash,$salt,'admin' => false), array('title'=>__l('create a request'))));?></p>
				<?php else: ?>
				  <p class="ver-mspace top-space text-16"> <?php echo __l('No properties available.'); ?> </p>
				<?php endif; ?>
			  </div>
			</li>
		  <?php endif; ?>
		</ol>
		<?php if (!empty($properties)) {?>
				<div class="<?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?> paging clearfix space pull-right mob-clr"> <?php echo $this->element('paging_links'); ?> </div>
		<?php }?>	
	  </section>
	</div>
	</div>
  </section>
<?php else:?>
  <div class="page-information alert"><?php echo __l('Please enter your search criteria'); ?></div>
<?php endif;?>
<?php if(empty($this->request->params['isAjax'])) { ?>
<?php if (Configure::read('widget.browse_script')) { ?>
  <div class="dc clearfix bot-space">
    <?php echo Configure::read('widget.browse_script'); ?>
  </div>
<?php } ?>
<?php } ?>
