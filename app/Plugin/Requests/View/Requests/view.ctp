<?php /* SVN: $Id: $ */  ?>
<?php Configure::write('highperformance.rids', $request['Request']['id']); ?>
<div class="requests view clearfix js-request-view" data-request-id="<?php echo $request['Request']['id']; ?>">
<div class="top-content pr">
		<div class="banner-content-bg pa mspace mob-ps span11">
            <div class="clearfix bot-space">
			<?php if(isPluginEnabled('PropertyFavorites')) :
				if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))):?>
				<div class="alpruf-<?php echo $request['Request']['id'];?> hide">
					<?php echo $this->Html->link('<i class="icon-star text-20"></i>', array('controller' => 'request_favorites', 'action'=>'delete', $request['Request']['slug'], 'type' => 'view'), array('escape' => false ,'class' => 'js-like un-like show span top-smspace js-no-pjax', 'title' => __l('Unlike'))); ?>
				</div>
				<div class="alprf-<?php echo $request['Request']['id'];?> hide">
					<?php	echo $this->Html->link('<i class="icon-star text-20"></i>', array('controller' => 'request_favorites', 'action' => 'add', $request['Request']['slug'], 'type' => 'view'), array('escape' => false ,'title' => __l('Like'),'escape' => false ,'class' =>'js-like like show span top-smspace graylightc no-under js-no-pjax')); ?>
				</div>
				<div class='blprf-<?php echo $request['Request']['id'];?> hide'>
					<?php	echo $this->Html->link('<i class="icon-star text-20"></i>', array('controller' => 'users', 'action' => 'login'), array('title' => __l('Like'),'escape' => false ,'class' =>'like show span top-smspace graylightc no-under ')); ?>
				</div>
			<?php else: ?>			
			<span>
			<?php
				if($this->Auth->sessionValid() && isPluginEnabled('RequestFavorites')):
					if(!empty($request['RequestFavorite'])):
						foreach($request['RequestFavorite'] as $favorite):
							if($request['Request']['id'] == $favorite['request_id'] && $favorite['user_id'] == $this->Auth->user('id')):
								if($this->Auth->user('id')!=$request['Request']['user_id']):
									 echo $this->Html->link('<i class="icon-star text-20 "></i>', array('controller' => 'request_favorites', 'action'=>'delete', $request['Request']['slug'], 'type' => 'view'), array('class' => 'js-no-pjax js-like un-like show span top-smspace no-under', 'title' => __l('Unlike'),'escape'=>false));
								endif;
							
							endif;
						endforeach;
					else:
					  if($this->Auth->user('id')!=$request['Request']['user_id']):
						echo $this->Html->link('<i class="icon-star graylightc text-20"></i>', array('controller' => 'request_favorites', 'action' => 'add', $request['Request']['slug'], 'type' => 'view'), array('title' => __l('Like'),'escape' => false ,'class' =>'js-no-pjax js-like like show span top-smspace no-under '));
					  endif;
					endif;

				endif;
			?>
			</span>
				<?php endif;
				endif; ?>			
              <h2 class="pull-left right-mspace ">
				<span class="htruncate js-bootstrap-tooltip span9" title="<?php echo $request['Request']['title'] ;?>"><?php echo $this->Html->cText($request['Request']['title']); ?></span>
			  </h2>
            </div>
            <div class="clearfix">
			<?php 
			  if(isset($share_url)){
				echo $this->Html->link('<i class="icon-share"></i>', $share_url, array('title'=>__l('Share'), 'escape' => false, 'class' => 'js-bootstrap-tooltip pull-left hor-smspace', 'target' => '_blank')); 
			  }
			  ?>
			
			<?php 
			if (isPluginEnabled('RequestFlags')):
				if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))):
		  ?>
				<div class="alvfp-<?php echo $request['Request']['id'];?> hide">
					<?php echo $this->Html->link('<i class="icon-flag pull-left text-18 no-mar right-space graylightc"></i>', array('controller' => 'request_flags', 'action' => 'add', $request['Request']['id']), array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal','title' => __l('Flag this request'),'escape' => false ,'class' =>'flag dr js-no-pjax js-thickbox')); ?>
				</div>
				<div class="blvfp-<?php echo $request['Request']['id'];?> hide">
					<?php echo $this->Html->link('<i class="icon-flag pull-left text-18 no-mar right-space graylightc"></i>', array('controller' => 'users', 'action' => 'login', '?' => 'f=request/' . $request['Request']['slug'], 'admin' => false), array( 'escape' => false,'title' => __l('Flag this request'), 'class' => 'flag dr ')); ?>
				</div>
			
			<?php else: ?>
			<?php  if ($this->Auth->sessionValid()):
						if ($request['Request']['user_id'] != $this->Auth->user('id')):
							echo $this->Html->link('<i class="icon-flag pull-left text-18 no-mar right-space graylightc"></i>', array('controller' => 'request_flags', 'action' => 'add', $request['Request']['id']), array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal','class'=>'js-no-pjax','id'=>'', 'escape' => false, 'title' => __l('Flag this request')));
						endif;
					else :
						echo $this->Html->link('<i class="icon-flag pull-left text-18 no-mar right-space graylightc"></i>', array('controller' => 'users', 'action' => 'login', '?' => 'f=request/' . $request['Request']['slug'], 'admin' => false), array('escape' => false,'title' => __l('Flag this request'), 'class' => 'flag dr '));
					endif;
				endif;
			endif; ?>
			<span class="graydarkc show">
			<?php if(!empty($request['Country']['iso_alpha2'])): ?>
						<span class="flags flag-<?php echo strtolower($request['Country']['iso_alpha2']); ?>" title ="<?php echo $request['Country']['name']; ?>"><?php echo $request['Country']['name']; ?></span>
				<?php endif; ?>
				
			<?php 
					if(empty($request['Request']['address'])) {
						$address	=	 $this->Html->cText($request['City']['name']);?>, <?php echo $this->Html->cText($request['State']['name']);?>,<?php echo $this->Html->cText($request['Country']['name']);
						$addressTitle = $this->Html->cText($request['City']['name'],false);?>, <?php echo $this->Html->cText($request['State']['name'],false);?>,<?php echo $this->Html->cText($request['Country']['name'],false);
					} else {
						$address		=	 $this->Html->cText($request['Request']['address']);
						$addressTitle	=	 $this->Html->cText($request['Request']['address'],false);
					}
				?>
				<p class="htruncate js-bootstrap-tooltip span5" title="<?php echo $addressTitle; ?>" ><?php echo $address; ?></p>
				</span>
				<div class="clearfix pull-right">
              <dl class="no-pad no-mar pull-left">
                <dt class="pull-left textn no-mar"><?php echo __l('Posted'); ?></dt>
                <dd class="pull-left graydarkc"><?php echo $this->Time->timeAgoInWords($request['Request']['created']); ?></dd>
              </dl>
						 
			  </div>
            </div>
          </div>
		  <div class="banner-content-bg pa mspace dc z-top price-section mob-ps span6">
            <div class="row no-mar">
              <h2><span class="textb" title="five hundred dollar"><?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
							  <?php echo Configure::read('site.currency').' '?>
							 <?php endif; ?>
                                  <?php echo $this->Html->cCurrency($request['Request']['price_per_night']); ?>
							<?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
							 <?php echo Configure::read('site.currency').' '?>
							 <?php endif; ?></span> <span class="text-11 show"><?php echo $this->Html->cDate($request['Request']['checkin']);?><?php echo ' - '; ?><?php echo $this->Html->cDate(getCheckoutDate($request['Request']['checkout']));?></span></h2>
							<div class="pull-right mob-clr">
							<?php if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))): ?>
								<div class="al-mao-<?php echo $request['Request']['id'];?> hide">
									<?php echo $this->Html->link(__l('Make an offer'), array('controller' => 'properties', 'action' => 'add','request',$request['Request']['id'], 'admin' => false), array('title'=>__l('Make an offer'), 'escape' => false, 'class' => 'show btn span5 top-mspace btn-large btn-primary text-18 textb')); ?>
								</div>
							<?php else: ?>
							<?php if($request['User']['id']!=$this->Auth->user('id')): ?>        	  
                    			<?php echo $this->Html->link(__l('Make an offer'), array('controller' => 'properties', 'action' => 'add','request',$request['Request']['id'], 'admin' => false), array('title'=>__l('Make an offer'), 'escape' => false, 'class' => 'show btn span5 top-mspace btn-large btn-primary text-18 textb')); ?>
							<?php endif; ?>
							<?php endif; ?>
							</div>
            </div>
          </div>
		  <div class="pr no-mar"><?php if(!empty($request['Request']['city_id'])): ?>
			<?php $map_zoom_level = !empty($request['Request']['zoom_level']) ? $request['Request']['zoom_level'] : '10';?>
						<img src="<?php echo $this->Html->formGooglemap($request['Request'],'956x260'); ?>" width="956" height="200" />
			<?php endif; ?></div>
			 <div class="row no-mar">
            <div class="big-thumb prop-owner pa img-polaroid mob-ps">
			<?php
				echo $this->Html->getUserAvatarLink($request['User'], 'small_big_thumb');
			?>
			</div>
            <div class="offset5 span tab-right mob-clr clearfix">
              <div class="top-mspace top-space clearfix">
                <dl class="sep-right list">
                  <dt class="pr hor-mspace text-11">Views</dt>
                  <dd class="textb text-20 graydarkc pr hor-mspace" title=""><?php echo  $this->Html->cInt($request['Request']['request_view_count']); ?></dd>
                </dl>
                <dl class="sep-right list">
                  <dt class="pr hor-mspace text-11">Offered</dt>
                  <dd class="textb text-20 graydarkc pr hor-mspace" title=""><?php echo $this->Html->cInt($request['Request']['property_count']);?></dd>
                </dl>
                <dl class="list">
                  <dt class="pr hor-mspace text-11">Days</dt>
                  <dd class="textb text-20 graydarkc pr hor-mspace" title=""><?php echo  $this->Html->cInt(getCheckinCheckoutDiff($request['Request']['checkin'], getCheckoutDate($request['Request']['checkout']))); ?></dd>
                </dl>
              </div>
            </div>
          </div>
			
			
			</div>
		  <div class="main-content pr">
          <section>
		  <div id="ajax-tab-container-user" class="ajax-tab-container-user">
            <ul id="myTab2" class="nav nav-tabs tabs top-space top-mspace">
              <li class="tab"><a href="#description" class="js-no-pjax" data-toggle="tab">Description</a> </li>
              <li><a href="#Trip-Details" class="js-no-pjax" data-toggle="tab">Trip Details</a></li>
			  <li><?php echo $this->Html->link(__l('Related Requests'), array('controller' => 'requests', 'action' => 'index', 'type' => 'related', 'request_id' => $request['Request']['id'], 'view' => 'compact'), array('title' => __l('Related Requests'), 'class' => 'js-no-pjax', 'data-target'=>'#Related-Requests'));?></li>
              <li><?php echo $this->Html->link(__l('Other Requests'), array('controller' => 'requests', 'action' => 'index', 'user_id' => $request['User']['id'], 'type' => 'other', 'request_id' => $request['Request']['id'], 'view' => 'compact'), array('title' => __l('Other Requests by ').$request['User']['username'], 'class' => 'js-no-pjax', 'data-target'=>'#Other-Request'));?></li>
             
            </ul>
            <div class="sep-right sep-left sep-bot tab-round tab-content" id="myTabContent2">
              <div class="tab-pane space " id="description">
			  <?php echo $this->Html->cText($request['Request']['description']);?>
			  </div>
			  <div class="tab-pane space " id="Trip-Details">
				<div class="clearfix">
				<h3 class="well space textb text-16 no-mar"> <?php echo __l('Details'); ?></h3>							
				</div>
				<div class="gryfill-m">
				<ul class="unstyled">
						<li class="clearfix space">
							<span class="db span4 pull-left hor-space"><?php echo __l('Property Type'); ?></span>
							<span class="pull-left textb"><?php echo !empty($request['PropertyType']['name']) ? $request['PropertyType']['name'] : __l('Any Type'); ?></span>
						</li>
						<li class="clearfix space">
							<span class="db span4 pull-left hor-space"><?php echo __l('Room Type'); ?></span>
							<span class="pull-left textb"><?php echo $request['RoomType']['name']; ?></span>
						</li>
						<li class="clearfix space">
							<span class="db span4 pull-left hor-space"><?php echo __l('Bed Type'); ?></span>
							<span class="pull-left textb"><?php echo $request['BedType']['name']; ?></span>
						</li>
						<li class="clearfix space">
							<span class="db span4 pull-left hor-space"><?php echo __l('Accomodates'); ?></span>
							<span class="pull-left textb"><?php echo $request['Request']['accommodates']; ?></span>
						</li>
				</ul>
                  </div>
				 
				<div class="clearfix" id="feature">
				 <?php  if(!empty($request['Amenity'])) {?>
                        	<div class="clearfix">
                                <h3 class="well space textb text-16 no-mar"> <?php echo __l('Amenities'); ?><span class="hide-button hide js-amenities-show pull-right text10 btn"><?php echo __l('Hide'); ?> </span></h3>							
                             </div>
							<?php  if(!empty($amenities_list)){
							?>
                			<ol class="amenities-list clearfix unstyled">
                			<?php
                				foreach($amenities_list as $key => $amenity) {
                					$class='not-allowed';
                					foreach($request['Amenity'] as $amen) {
                						if($amen['name']==$amenity)
                						{
                							$class='allowed';
                						}
                					}
                			?>
                			<?php $amenity_class_name = 'amenities-am-' . $key; ?>
                			<li class="clearfix">
                    			<span class="<?php echo $class; ?>" title ="<?php echo ($class == 'allowed') ? __l('Yes') : __l('No'); ?>"><?php echo ($class == 'allowed') ? __l('Yes') : __l('No');?></span>
                    			<span class="<?php echo $amenity_class_name ?>"><?php echo  $this->Html->cText($amenity); ?></span>
                			</li>
                            <?php } ?>
                			</ol>
                           <?php }?>
						  <?php } if(!empty($request['HolidayType'])){ ?>
						   <h3 class="well space textb text-16 no-mar"> <?php echo __l('Holiday Types'); ?></h3>

								<?php  if(!empty($holiday_list)){?>
										<ol class="amenities-list clearfix unstyled">
										<?php    foreach($holiday_list as $h_key => $holiday){
											$class='not-allowed';
											foreach($request['HolidayType'] as $holi)
											{
												if($holi['name']==$holiday)
												{
													$class='allowed';
												}
											}
										?>
										<li>
										<?php $holiday_class_name = 'amenities-ht-' . $h_key; ?>
										<span class="<?php echo $class; ?>" title ="<?php echo ($class == 'allowed') ? __l('Yes') : __l('No'); ?>"><?php echo ($class == 'allowed') ? __l('Yes') : __l('No');?></span>
										<span class="<?php echo $holiday_class_name; ?>"><?php echo  $this->Html->cText($holiday); ?></span>
										</li>
										<?php }?>
										</ol>
									   <?php }?>
									<?php } ?>		
													</div>
																			  </div>
							  <div class="tab-pane space " id="Related-Requests">

							  </div>
							  <div class="tab-pane space " id="Other-Request">
							  </div>
				</div>
			</div>
			</div>
			</div>			
