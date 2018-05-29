<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php
Configure::write('highperformance.uids', $this->Auth->user('id'));
if (!empty($requests)) {
	foreach ($requests as $request) {
		foreach($request as $tmp_request) {
			Configure::write('highperformance.rids', Set::merge(Configure::read('highperformance.rids') , $tmp_request['Request']['id']));
		}
	}
}
?>
<?php
$hash = !empty($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
$salt = !empty($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : '';
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
    $keyword = isset($search_keyword['named']['keyword']) ? $search_keyword['named']['keyword'] : '';
    $cityy = isset($search_keyword['named']['city']) ? $search_keyword['named']['city'] : 'all';
    //this->request->data['Request']=$search_keyword['named'];
    if (!empty($rangeto)) {
        $this->request->data['Request']['range_to'] = $rangeto;
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
    $keyword = isset($this->request->params['named']['keyword']) ? $this->request->params['named']['keyword'] : '';
    $cityy = isset($this->request->params['named']['city']) ? $this->request->params['named']['city'] : 'all';
    if (!empty($rangeto)) {
        $this->request->data['Request']['range_to'] = $rangeto;
    }
}
if (isset($is_favorite)) {
    $class_name = '';
} else {
    $class_name = 'request-index-page';
}
?>
<?php if ($search == 'normal' && !isset($is_favorite)): ?>
				<?php echo $this->element('request_search', array('config' => 'sec', 'type' => 'search')); ?>
<?php endif; ?>
<section class="row no-mar">
	<div class="span24 no-mar pr <?php echo ($search == 'normal' || !empty($this->request->params['isAjax'])) ? 'js-responses  js-response' : ''; ?>">
	<div class="clearfix <?php echo $class_name; ?>">
		
		<span class="js-search-lat {'cur_lat':'<?php echo $current_latitude; ?>','cur_lng':'<?php echo $current_longitude; ?>'}"></span>
		<?php 
		$fromAjax = FALSE;
		$widthClass= 'span21 span20-sm';
		if(isset($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'ajax'):
			$fromAjax = TRUE;
			$widthClass= 'span21 span20-sm';
		 endif; ?>
	<?php if(empty($this->request->params['isAjax'])):?>
			<?php if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'favorite'): ?>
					<h2 class="ver-space top-mspace text-32 sep-bot"><?php echo __l('Liked Requests'); ?></h2>
				<?php else: ?>
				
				<div class="well space clearfix">
					<h2 class="ver-space pull-left redc textb text-16"><?php echo __l('Requests'); ?></h2>
					</div>
				<?php endif; 				endif;
				?>
				<?php if (!isset($is_favorite)): ?>
				<?php $widthClass= 'span20 span20-sm'; ?>
		<aside class="haccordion pa mob-ps">
            <ul class="unstyled text-16">
			 <?php echo $this->Form->create('Request', array('id'=> 'KeywordsSearchForm','class' => 'check-form js-search-map js-ajax-search-form norma keywords no-mar','action'=>'index')); ?>
              <li class="sep-bot">
                <div class="graydarkc no-under" title="<?php echo __l('Refine'); ?>">
                  <div id="accordion1" class="accordion no-mar">
                    <div class="space clearfix"> 
					<span class="accordion-menu cur pull-left">
					<span class="width22 pull-left show dc"><i class="icon-map-marker cur text-20 no-pad"></i></span>
						<span class="hor-space left-mspace"><?php echo __l('Refine'); ?></span>
					</span>
                      <div class="accordion-list thumbnail no-round no-pad pull-right"> <a href="#collapseOne" data-parent="#accordion1" data-toggle="collapse" class="whitec hor-smspace accordion-toggle js-toggle-icon"><i class="icon-plus no-pad graylightc text-10"></i></a></div>
                    </div>
                  </div>
                  <div id="collapseOne" class="accordion-body collapse">
                    <div class="thumbnail no-bor no-shad no-round space cleafix">
					<span class="show">
					<div class="js-side-map block2">
						<div id="js-map-container"></div>
					</div>
					</span> 
					<a href="javascript:void(0);" class="show btn btn-large ver-smspace btn-primary textb text-16 map-button js-mapsearch-button" title="<?php echo __l('Update'); ?>"><?php echo __l('Update'); ?></a>
                      <div class="form-search ver-mspace cleafix">
                        <div class="input text"> <span class="span no-mar">
                          <?php echo $this->Form->input('Request.keyword', array('label' =>__l('Keywords'),'value'=>$keyword,'label'=>false,'div'=>false,'class'=>'span4 text-16')); ?>
                          </span> </div>
                        <a href="javascript:void(0);" class="pull-right mob-clr show btn btn-large textb text-16 js-submit-button" title="Search"><i class="icon-search no-pad no-mar textb text-16"></i></a>
						</div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="sep-bot">
                <div class="graydarkc no-under" title="<?php echo __l('Room Types'); ?>">
                  <div id="accordion2" class="accordion no-mar">
                    <div class="space clearfix"> <span class="accordion-menu cur pull-left"><span class="width22 pull-left show dc"><i class="icon-home cur text-18 no-pad"></i></span> <span class="hor-space left-mspace"><?php echo __l('Room Types'); ?></span> </span>
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
						<?php echo $this->Form->input('Request.PropertyType', array('type'=>'select', 'multiple'=>'checkbox',  'class' => 'show top-mspace checkbox clearfix', 'label' =>false)); ?>
						 </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="sep-bot">
                <div class="graydarkc no-under" title="<?php echo __l('Holiday Types'); ?>">
                  <div id="accordion4" class="accordion no-mar">
                    <div class="space clearfix"> <span class="accordion-menu cur pull-left"><span class="width22 pull-left show dc"><i class="icon-umbrella cur text-18 no-pad"></i></span><span class="hor-space left-mspace"><?php echo __l('Holiday Types'); ?></span></span>
                      <div class="accordion-list thumbnail no-round no-pad pull-right"> <a href="#collapseFour" data-parent="#accordion4" data-toggle="collapse" class="whitec hor-smspace accordion-toggle js-toggle-icon"><i class="icon-plus no-pad graylightc text-10"></i></a></div>
                    </div>
                  </div>
                  <div id="collapseFour" class="accordion-body collapse">
                    <div class="thumbnail no-bor no-shad no-round space clearfix">
                      <div class="bot-mspace">
                        <div class="graydarkerc text-14"> 
						<?php echo $this->Form->input('Request.HolidayType', array('type'=>'select', 'multiple'=>'checkbox',  'class' =>'show top-mspace checkbox clearfix', 'label' =>false)); ?>
						</div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="sep-bot">
                <div class="graydarkc no-under" title="<?php echo __l('Price Range'); ?>">
                  <div id="accordion5" class="accordion no-mar">
                    <div class="space clearfix"> <span class="accordion-menu cur pull-left"><span class="width22 pull-left show dc"><i class="icon-money cur text-18 no-pad"></i></span><span class="hor-space left-mspace"><?php echo __l('Price Range'); ?></span></span>
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
						  <?php echo $this->Form->input('Request.range_from', array('type'=>'hidden', 'id'=>'js-range_from', 'label' =>false)); ?>
						  <?php echo $this->Form->input('Request.range_to', array('type'=>'hidden', 'id'=>'js-range_to','label' =>false)); ?>
						  <div class="input select top-mspace">
						  <?php echo $this->Form->input('Request.price_range', array('type'=>'select', 'data-slider_min' => 1, 'data-slider_max' => 301, 'id'=>'js-price-range', 'label' =>false, 'class' => 'js-uislider { name: "range"} hide', 'div'=>false )); ?>
						</div>
						</div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
			   <li class="sep-bot">
                <div class="graydarkc no-under" title="<?php echo __l('Amenities'); ?>">
                  <div id="accordion7" class="accordion no-mar">
                    <div class="space clearfix"> <span class="accordion-menu cur pull-left"><span class="width22 pull-left show dc"><i class="icon-link cur text-18 no-pad"></i></span><span class="hor-space left-mspace"><?php echo __l('Amenities'); ?></span></span>
                      <div class="accordion-list thumbnail no-round no-pad pull-right"> <a href="#collapseSeven" data-parent="#accordion7" data-toggle="collapse" class="whitec hor-smspace accordion-toggle js-toggle-icon"><i class="icon-plus no-pad graylightc text-10"></i></a></div>
                    </div>
                  </div>
                  <div id="collapseSeven" class="accordion-body collapse">
                    <div class="thumbnail no-bor no-shad no-round space clearfix">
                      <div class="bot-mspace">
                        <div class="graydarkerc text-14"> 
							<?php echo $this->Form->input('Request.Amenity', array('type'=>'select', 'multiple'=>'checkbox',  'class'=>'show top-mspace checkbox clearfix', 'label' =>false)); ?>
                         </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
			
									<?php
							echo $this->Form->input('cityName', array(
								'type' => 'hidden',
								'id' => 'city_index',
								'value' => $city
							));
							echo $this->Form->input('latitude', array(
								'type' => 'hidden',
								'value' => $latitude
							));
							echo $this->Form->input('longitude', array(
								'type' => 'hidden',
								'value' => $longitude
							));
							echo $this->Form->input('checkin', array(
								'type' => 'hidden',
								'value' => $checkin
							));
							echo $this->Form->input('checkout', array(
								'type' => 'hidden',
								'value' => $checkout
							));
							echo $this->Form->input('additional_guest', array(
								'type' => 'hidden',
								'value' => $additional_guest
							));
							echo $this->Form->input('type', array(
								'type' => 'hidden',
								'value' => 'search'
							));
							echo $this->Form->input('search', array(
								'type' => 'hidden',
								'value' => 'side'
							));
							echo $this->Form->input('roomtype', array(
								'type' => 'hidden',
								'value' => $roomtype
							));
							echo $this->Form->input('holidaytype', array(
								'type' => 'hidden',
								'value' => $holidaytype
							));
							echo $this->Form->input('amenity', array(
								'type' => 'hidden',
								'value' => $amenity
							));
							echo $this->Form->input('ne_longitude', array(
								'type' => 'hidden',
								'id' => 'ne_longitude_index'
							));
							echo $this->Form->input('sw_longitude', array(
								'type' => 'hidden',
								'id' => 'sw_longitude_index'
							));
							echo $this->Form->input('sw_latitude', array(
								'type' => 'hidden',
								'id' => 'sw_latitude_index'
							));
							echo $this->Form->input('ne_latitude', array(
								'type' => 'hidden',
								'id' => 'ne_latitude_index'
							));
						?>
            <?php echo $this->Form->end(); ?>
			</ul>
			
          </aside>
		  <?php
		  endif;
						$view_count_url = Router::url(array(
							'controller' => 'requests',
							'action' => 'update_view_count',
						), true);
					?>	
		<section id="Properties" class="<?php echo (isset($is_favorite))? 'span24':'span23 property-content' ?> mob-clr row pull-right bot-space">
		<ol class="unstyled prop-list prop-list-mob no-mar js-view-count-update top-space {'model':'request','url':'<?php echo $view_count_url; ?>'}" start="<?php echo $this->Paginator->counter(array('format' => '%start%')); ?>">
				<?php
					if (!empty($requests)):
						$num = 1;
						
						foreach($requests as $key => $requests_date):
				?>
								
						<?php
							$i = 0;
							foreach($requests_date as $request):
								$class = null;
								if ($i++%2 == 0) {
									$class = ' class="altrow"';
								}
						?>
			<li class="clearfix ver-space sep-bot js-map-request-num<?php echo $num; ?>  hor-smspace">
				 <div class="span dc"> <span class="label label-important textb show text-11 prop-count"><?php echo $num; ?></span>						
						<?php if(isPluginEnabled('RequestFavorites')) {
							if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))){?>
							<div class="alpruf-<?php echo $request['Request']['id'];?> hide">
								<?php	echo $this->Html->link('<i class="icon-star no-pad text-18"></i>' , array('controller' => 'request_favorites', 'action' => 'delete', $request['Request']['slug']) , array('class' => 'js-no-pjax js-like un-like tb top-space  show',  'escape' => false, 'title' => __l('Unlike'))); ?>
							</div>	
							<div class="alprf-<?php echo $request['Request']['id'];?> hide">
								<?php echo $this->Html->link('<i class="icon-star-empty grayc no-pad text-18"></i>' , array('controller' => 'request_favorites', 'action' => 'add', $request['Request']['slug']) , array('title' => __l('Like') , 'escape' => false, 'class' => 'js-no-pjax js-like tb like top-space show')); ?>
							</div>
							<div class="blprf-<?php echo $request['Request']['id'];?> hide">
									<?php	echo $this->Html->link('<i class="icon-star-empty no-pad text-18"></i>' , array('controller' => 'users', 'action' => 'login') , array('title' => __l('Like') , 'escape' => false, 'class' => ' like tb top-space  show')); ?>
							</div>
						<?php }else{ ?>
							<span>
							<?php
								if ($this->Auth->sessionValid()){
									if (!empty($request['RequestFavorite'])){
										foreach($request['RequestFavorite'] as $favorite):
											if ($request['Request']['id'] == $favorite['request_id'] && $request['Request']['user_id'] != $this->Auth->user('id')):
												echo $this->Html->link('<i class="icon-star no-pad text-18"></i>' , array('controller' => 'request_favorites', 'action' => 'delete', $request['Request']['slug']) , array('class' => 'js-no-pjax js-like un-like tb top-space  show','escape' => false, 'title' => __l('Unlike')));
											endif;
										endforeach;
									}else{
										if ($request['Request']['user_id'] != $this->Auth->user('id')){
											echo $this->Html->link('<i class="grayc icon-star-empty no-pad text-18"></i>' , array('controller' => 'request_favorites', 'action' => 'add', $request['Request']['slug']) , array('title' => __l('Like') , 'escape' => false, 'class' => 'js-no-pjax js-like tb like top-space show'));
										}
									}
								}else{
									echo $this->Html->link('<i class="grayc icon-star-empty no-pad text-18"></i>' , array('controller' => 'users', 'action' => 'login') , array('title' => __l('Like') , 'escape' => false, 'class' => ' like tb top-space  show'));
								}
							?>
							</span>
							<?php } 
						} ?>
						<?php if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))):?>
				<div class="aloed-<?php echo $request['Request']['id']; ?> hide">
					<div class="dropdown"> <a href="#" title="Edit" class="dropdown-toggle text-14 textb graylighterc no-shad" data-toggle="dropdown"><i class="icon-cog graylightc no-pad text-16"></i></a>
						<ul class="dropdown-menu dl arrow">
						  <li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action'=>'edit', $request['Request']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'),'escape'=>false));?></li>
						  <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action'=>'delete', $request['Request']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete'),'escape'=>false));?> </li>
						</ul>
					</div>
					</div>
				<?php else:
					if ($request['Request']['user_id'] == $this->Auth->user('id')) : ?>
					<div class="dropdown"> <a href="#" title="Edit" class="dropdown-toggle text-14 textb graylighterc no-shad" data-toggle="dropdown"><i class="icon-cog graylightc no-pad text-16"></i></a>
						<ul class="dropdown-menu dl arrow">
						  <li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action'=>'edit', $request['Request']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'),'escape'=>false));?></li>
						  <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action'=>'delete', $request['Request']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete'),'escape'=>false));?> </li>
						</ul>
					  </div>
				<?php endif; 
				endif;?>			
				 </div>
				 <?php $date = explode('-', $key); ?>
				 <span class="img-rounded sep date-block span cur no-under show no-pad dc graydarkc"> 
				 <span class="show well no-mar hor-space"><?php echo date('M', mktime(0, 0, 0, $date[1], $date[2], $date[0])); ?></span> <span class="show textb text-24"><?php echo date('d', mktime(0, 0, 0, $date[1], $date[2], $date[0])); ?></span> <span class="show sep-top"><?php echo date('D', mktime(0, 0, 0, $date[1], $date[2], $date[0])); ?></span> </span>
				 
				 <div class="<?php echo $widthClass; ?> pull-right no-mar mob-clr">
								<div class=" clearfix <?php echo (isset($is_favorite))? '':'sep-bot' ?>">
									<div class="span dc no-mar user-avatar">
										<?php
											echo $this->Html->getUserAvatar($request['User'], 'medium_thumb', true);
										?>
									</div>
									<div class="clearfix">
										<div class="span10">
											<h4 class="textb text-16 clearfix">
												<?php
													$lat = $request['Request']['latitude'];
													$lng = $request['Request']['longitude'];
													$id = $request['Request']['id'];
													echo $this->Html->link($this->Html->cText($request['Request']['title']) , array('controller' => 'requests', 'action' => 'view', $request['Request']['slug'], $hash, $salt, 'admin' => false) , array('id' => "js-map-side-$id", 'class' => "graydarkc js-map-data {'lat':'$lat','lng':'$lng'}", 'title' => $this->Html->cText($request['Request']['title'], false), 'escape' => false, 'class' => 'htruncate clearfix js-bootstrap-tooltip span6 graydarkc no-mar mob-clr', 'data-placement' => 'bottom'));
												?>
											</h4>
											<?php
												$flexible_class = '';
												if (isset($search_keyword['named']['is_flexible']) && $search_keyword['named']['is_flexible'] == 1) {
													if (!empty($exact_ids) && in_array($request['Request']['id'], $exact_ids)) {
											?><div class="clearfix top-space dc">
												<span class="label pull-left mob-inline"><?php echo __l('exact'); ?></span></div>
												
											<?php
													}
												}
											?>
										
										<span class=" graydarkc top-smspace show mob-dc mob-clr">
											<?php if (!empty($request['Country']['iso_alpha2'])): ?>
												<span class="flags mob-inline top-smspace flag-<?php echo strtolower($request['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($request['Country']['name'], false); ?>"><?php echo $this->Html->cText($request['Country']['name'], false); ?></span>
                                        	<?php endif; ?>
											<div class="htruncate js-bootstrap-tooltip no-mar span9" title="<?php echo $this->Html->cText($request['Request']['address'], false);?>"><?php echo $this->Html->cText($request['Request']['address'], false);?></div>
											
										</span>
										<div class="no-mar">
										<p class="htruncate js-bootstrap-tooltip span9  no-mar mob-dc" title="<?php echo $this->Html->cText($request['Request']['description'], false);?>"><?php echo $this->Html->cText($request['Request']['description'], false); ?>
											</p>
											</div>
									
									</div>
									<div class="pull-right mob-clr tab-clr">
									<?php if (isset($is_favorite)): ?>
									<div class="clearfix pull-left mob-clr top-mspace mob-inline">
											<dl class="list">
											  <dt class="pr hor-space  text-11"><?php echo __l('Views'); ?></dt>
											  <dd title="234" class="textb text-20 graydarkc pr hor-mspace js-view-count-request-id js-view-count-request-id-<?php echo $request['Request']['id']; ?> {'id':'<?php echo $request['Request']['id']; ?>'}"><?php echo numbers_to_higher($request['Request']['request_view_count']); ?></dd>
											</dl>
											<dl class="list">
											  <dt class="pr hor-space  text-11"><?php echo __l('Offered'); ?></dt>
											  <dd title="689" class="textb text-20 graydarkc pr hor-mspace"><?php echo $this->Html->cInt($request['Request']['property_count']); ?></dd>
											</dl>
											<dl class="list">
											  <dt class="pr hor-space  text-11"><?php echo __l('Days'); ?></dt>
											  <dd title="n/a" class="textb text-20 graydarkc pr hor-mspace"><?php echo $this->Html->cInt(getCheckinCheckoutDiff($request['Request']['checkin'], getCheckoutDate($request['Request']['checkout']))); ?></dd>
											</dl>
										  </div>
									<?php endif; ?>
										<div class="clearfix pull-left hor-space left-mspace sep-left mob-sep-none tab-no-mar mob-clr mob-dc">
											<p class="no-mar"><?php echo $this->Html->cDate($request['Request']['checkin']); ?><?php echo ' - '; ?><?php echo $this->Html->cDate(getCheckoutDate($request['Request']['checkout'])); ?></p>
											<dl class="dc list span mob-clr">
											<dt class="pr hor-mspace text-11"><?php echo __l('Per night');?></dt>
											<dd class="textb text-24 graydarkc pr hor-mspace">
											<?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
												<?php echo Configure::read('site.currency').' '?>
											<?php endif; ?>
											<?php echo $this->Html->cCurrency($request['Request']['price_per_night']);?>
											<?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
												 <?php echo ' '.Configure::read('site.currency'); ?>
											<?php endif; ?>
										</dd>
										</div>
									</div>
									</div>
									</div>
									<?php if (!isset($is_favorite)): ?>
									<div class="clearfix mob-dc">
										  <div class="clearfix pull-left mob-clr top-mspace mob-inline">
											<dl class="list">
											  <dt class="pr hor-space  text-11"><?php echo __l('Views'); ?></dt>
											  <dd title="234" class="textb text-20 graydarkc pr hor-mspace js-view-count-request-id js-view-count-request-id-<?php echo $request['Request']['id']; ?> {'id':'<?php echo $request['Request']['id']; ?>'}"><?php echo numbers_to_higher($request['Request']['request_view_count']); ?></dd>
											</dl>
											<dl class="list">
											  <dt class="pr hor-space  text-11"><?php echo __l('Offered'); ?></dt>
											  <dd title="689" class="textb text-20 graydarkc pr hor-mspace"><?php echo $this->Html->cInt($request['Request']['property_count']); ?></dd>
											</dl>
											<dl class="list">
											  <dt class="pr hor-space  text-11"><?php echo __l('Days'); ?></dt>
											  <dd title="n/a" class="textb text-20 graydarkc pr hor-mspace"><?php echo $this->Html->cInt(getCheckinCheckoutDiff($request['Request']['checkin'], getCheckoutDate($request['Request']['checkout']))); ?></dd>
											</dl>
										  </div>
										  <div class="pull-right mob-clr right-mspace">
										  <?php if ($request['User']['id'] != $this->Auth->user('id')): ?>
												<?php if ($request['Request']['checkin'] >= date('Y-m-d') && $request['Request']['checkout'] >= date('Y-m-d')): ?>
													<?php echo $this->Html->link(__l('Make an offer') , array('controller' => 'properties', 'action' => 'add', 'request', $request['Request']['id'], 'admin' => false) , array('title' => __l('Make an offer') , 'escape' => false, 'class' => 'show btn  top-mspace btn-large btn-primary text-18 textb')); ?>
												<?php endif; ?>
											<?php endif; ?>
										  </div>
										</div>
										<?php endif; ?>
									  </div>
			
					<?php $num++; endforeach; ?>
				
			
			<?php
					endforeach;
					?>
				</li></ol>
			<?php else:
			?>
			
			<ol class="clearfix unstyled">
				<li>
					<div class="space dc grayc">
						<p class="ver-mspace top-space text-16">
							<?php echo __l('No Requests available');?>
						</p>
					</div>
				</li>			
			</ol>
			<?php
				endif;
			?>
			<?php
				if (!empty($requests) && count($requests) > 10) { ?>
						<div class="js-pagination paging clearfix space pull-right mob-clr"><?php echo $this->element('paging_links'); ?></div>
			<?php } ?>
		</section>
        </div>
 		</div>
     </section>
