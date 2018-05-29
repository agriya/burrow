<?php /* SVN: $Id: $ */ ?>
<?php 
$this->loadHelper('Embed');
$lat =$property['Property']['latitude']; 
$lng = $property['Property']['longitude'];
$hash = !empty($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : '';
$salt = !empty($this->request->params['pass'][2]) ? $this->request->params['pass'][2] : '';
?>
<div class="clearfix js-property-view" data-property-id="<?php echo $property['Property']['id']; ?>">
    <div class="user-affix clearfix affix-top z-top hidden-sm" data-offset-top="400" data-spy="affix">
      <div class="affix-bg clearfix mspace">
        <div class="span17 no-mar">
		<div class="pull-left">
		<?php echo $this->Html->getUserAvatar($property['User'], 'medium_thumb', true); ?>
		</div>
          <div data-placement="bottom" class="htruncate-m12 js-bootstrap-tooltip right-mspace pull-left" title="<?php echo $property['Property']['title'] ;?>">
		  <h2 class="span">
		  <a href="#"  class="graydarkc"><?php echo $this->Html->cText($property['Property']['title'],false);?></a></h2></div>
          <span class="show span top-smspace">
		 
			<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified']==ConstVerification::Verified):?>
				<span class="label label-warning span smspace show"><?php echo __l('Verified'); ?></span>
			<?php endif; ?>
			<?php if($property['Property']['is_featured']):?>
				<span class="label featured span smspace show"> <?php echo __l('Featured'); ?></span>
			<?php endif; ?>
		  </span> </div>
        <div class="pull-right span12 clearfix">
          <h2 class="pull-left right-space"><span class="textb show pull-left top-smspace right-space"><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']);?></span> <span class="text-11 show span top-space top-smspace"><?php echo __l('Per night');?></span></h2>
		 <div class="normal pull-left no-mar">
          <div class="pull-right  right-space right-mspace">
		  <?php if($this->Auth->user('id')==$property['Property']['user_id']): ?>
            <a href="#hostpanel" data-trigger="#hostpanel" class="show btn span5 btn-large btn-primary textb js-bookitaffix js-no-pjax" title="<?php echo __l('Host Panel'); ?>">  <?php echo __l('Host Panel'); ?></a>
		<?php else: ?>	
			<a href="#bookit" data-trigger="#bookit" class="show btn span5 btn-large btn-primary textb js-bookitaffix js-no-pjax" title="<?php echo __l('Book it'); ?>">  <?php echo __l('Book it'); ?></a>
		<?php endif; ?>
          </div>
		  <span class="small-screen pa hide"><i class="icon-remove-circle text-24 cur js-expand"></i></span>
				
         </div> 
        </div>
      </div>
    </div>
    <div class="container">
      <div class="top-content banner-block pr">
        <div class="banner-content-bg pa mspace mob-ps mob-dc span11">
          <div class="clearfix bot-space">
			<?php if(isPluginEnabled('PropertyFavorites')) :
				if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))):?>
				<div class="alpuf-<?php echo $property['Property']['id'];?> hide">
					<span class="dc">
						<?php echo $this->Html->link('<i class="icon-star text-20"></i>', array('controller' => 'property_favorites', 'action'=>'delete', $property['Property']['slug'], 'type' => 'view'), array('escape' => false ,'class' => 'js-like un-like show span top-smspace js-no-pjax', 'title' => __l('Unlike'))); ?>
					</span>
				</div>
				<div class="alpf-<?php echo $property['Property']['id'];?> hide">
					<span class="dc">
						<?php	echo $this->Html->link('<i class="icon-star text-20"></i>', array('controller' => 'property_favorites', 'action' => 'add', $property['Property']['slug'], 'type' => 'view'), array('escape' => false ,'title' => __l('Like'),'escape' => false ,'class' =>'js-like like show span top-smspace graylightc no-under js-no-pjax')); ?>
					</span>
				</div>
				<div class='blpf-<?php echo $property['Property']['id'];?> hide'>
					<span class="dc">
						<?php	echo $this->Html->link('<i class="icon-star text-20"></i>', array('controller' => 'users', 'action' => 'login', '?' => 'f='. $this->request->url), array('title' => __l('Like'),'escape' => false ,'class' =>'like show span top-smspace graylightc no-under ')); ?>
					</span>
				</div>
			<?php else: ?>
				<span class="dc">
				<?php
					if($this->Auth->sessionValid()):
						if(!empty($property['PropertyFavorite'])):
							foreach($property['PropertyFavorite'] as $favorite):
								if($property['Property']['id'] == $favorite['property_id'] && $property['Property']['user_id'] != $this->Auth->user('id')):
									echo $this->Html->link('<i class="icon-star text-20"></i>', array('controller' => 'property_favorites', 'action'=>'delete', $property['Property']['slug'], 'type' => 'view'), array('escape' => false ,'class' => 'js-like un-like show span top-smspace no-under js-no-pjax', 'title' => __l('Unlike')));
								endif;
							endforeach;
						else:
							if( $property['Property']['user_id'] != $this->Auth->user('id')):
								echo $this->Html->link('<i class="icon-star text-20"></i>', array('controller' => 'property_favorites', 'action' => 'add', $property['Property']['slug'], 'type' => 'view'), array('title' => __l('Like'),'escape' => false ,'class' =>'js-like js-no-pjax like show span top-smspace graylightc no-under'));
							endif;
						endif;
					else:
						echo $this->Html->link('<i class="icon-star text-20"></i>', array('controller' => 'users', 'action' => 'login', '?' => 'f='. $this->request->url), array('title' => __l('Like'),'escape' => false ,'class' =>'like show span top-smspace graylightc no-under'));
					endif;
				?>
				</span>
				<?php endif;
				endif; ?>
			
            <h2 class="pull-left right-mspace no-mar span7 htruncate js-bootstrap-tooltip" title="<?php echo $property['Property']['title'] ;?>"><a href="#" title="<?php echo __l($property['Property']['title']);?>" class="graydarkc"><?php echo $this->Html->cText($property['Property']['title'],false);?></a></h2>
            
			<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified']==ConstVerification::Verified):?>
						<span class="label label-warning pull-left mob-inline top-mspace"><?php echo __l('Verified'); ?></span>
        			<?php endif; ?>
        			<?php if($property['Property']['is_featured']):?>
        				<span class="top-mspace show label label-info pull-right"> <?php echo __l('Featured'); ?></span>
        			<?php endif; ?>
			</div>
          <div class="clearfix">
		  <?php 
			  if(isset($share_url)){
				echo $this->Html->link('<i class="icon-share"></i>', $share_url, array('title'=>__l('Share'), 'escape' => false, 'class' => 'js-bootstrap-tooltip pull-left hor-smspace', 'target' => '_blank')); 
			  }
			  ?>	
		  <?php 
			if(isPluginEnabled('PropertyFlags')):
				if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))):
		  ?>
				<div class="alvfp-<?php echo $property['Property']['id'];?> hide">
					<?php echo $this->Html->link('<i class="icon-flag pull-left text-18 no-mar right-space grayc"></i>', array('controller' => 'property_flags', 'action' => 'add', $property['Property']['id']), array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal','title' => __l('Flag this property'),'escape' => false ,'class' =>'flag dr  js-thickbox')); ?>
				</div>
				<div class="blvfp-<?php echo $property['Property']['id'];?> hide">
					<?php echo $this->Html->link('<i class="icon-flag pull-left text-18 no-mar right-space grayc"></i>', array('controller' => 'users', 'action' => 'login', '?' => 'f=property/' . $property['Property']['slug'], 'admin' => false), array( 'escape' => false,'title' => __l('Flag this property'), 'class' => 'flag dr ')); ?>
				</div>
			
			<?php else: ?>
			<?php if ($this->Auth->sessionValid()):
					if ($property['Property']['user_id'] != $this->Auth->user('id')):
						echo $this->Html->link('<i class="icon-flag pull-left text-18 no-mar right-space grayc"></i>', array('controller' => 'property_flags', 'action' => 'add', $property['Property']['id']), array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal','class'=>'js-no-pjax', 'escape' => false, 'title' => __l('Flag this property')));
					endif;
				  else :
					echo $this->Html->link('<i class="icon-flag pull-left text-18 no-mar right-space grayc"></i>', array('controller' => 'users', 'action' => 'login', '?' => 'f=property/' . $property['Property']['slug'], 'admin' => false), array('escape' => false,'title' => __l('Flag this property'), 'class' => 'flag dr '));
				  endif;
				endif;
			endif; ?>
		  <?php if(!empty($property['Country']['iso_alpha2'])): ?>
					<span class="top-smspace flags flag-<?php echo strtolower($property['Country']['iso_alpha2']); ?>" title ="<?php echo $property['Country']['name']; ?>"><?php echo $property['Country']['name']; ?></span>
				<?php endif; ?>
				<p class="htruncate clearfix js-bootstrap-tooltip span8 graydarkc no-mar dl" title="<?php echo $property['Property']['address'];?>"><?php echo $this->Html->cText($property['Property']['address']) ?></p>
				
			</div>
        </div>
        <div class="banner-content-bg pa mspace dc z-top price-section mob-ps span7">
          <div class="row no-mar">
		  <?php if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))):?>
			 <div class="al-php-<?php echo $property['Property']['id']; ?> hide">
				<div class="pull-right dropdown mob-clr">
				  <?php echo $this->Html->link(__l('Host Panel'), array('controller' => 'properties', 'action' => 'bookit', $property['Property']['slug']), array('title' => __l('Host Panel'),'id'=>'hostpanel', "data-trigger"=>"#hostpanel_response",'class'=>"js-no-pjax show dropdown-toggle btn span6 top-mspace btn-large btn-primary text-18 textb",'data-toggle'=>'dropdown'));?>
				  <ul class="span19 unstyled dropdown-menu no-mar arrow arrow-right book-it-drop">
				   <li class="book-it-inner js-pending-list space no-mar clearfix">
					 <div class="clearfix host-panel-block" id="hostpanel_response">
						<!-- Bookit content from ajax -->
					 </div>
					 </li>
				   </ul>
				 </div>
			 </div>
			 <div class="al-pbi-<?php echo $property['Property']['id']; ?> hide">
			   <h2><span class="textb"><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']);?></span> <span class="text-11"><?php echo __l('Per night');?></span></h2>
			   <div class="pull-right dropdown mob-clr">
				  <?php echo $this->Html->link(__l('Book it'), array('controller' => 'properties', 'action' => 'bookit', $property['Property']['slug'],$hash,$salt), array('title' => __l('Book it'),'id'=>'bookit', "data-trigger"=>"#bookit_response",'class'=>"js-no-pjax show dropdown-toggle btn span6 top-mspace btn-large btn-primary text-18 textb",'data-toggle'=>'dropdown'));?>
				  <ul class="unstyled dropdown-menu no-mar js-booking-block arrow arrow-right book-it-drop">
				    <li class="book-it-inner js-pending-list space no-mar clearfix">
					  <div class="" id="bookit_response">
					    <!-- Bookit content from ajax -->
					  </div>
				    </li>
				  </ul>
				</div>
			 </div>
		  <?php else: ?>
			  <?php if($this->Auth->user('id')==$property['Property']['user_id']): ?>
				<div class="pull-right dropdown mob-clr">
				  <?php echo $this->Html->link(__l('Host Panel'), array('controller' => 'properties', 'action' => 'bookit', $property['Property']['slug']), array('title' => __l('Host Panel'),'id'=>'hostpanel', "data-trigger"=>"#hostpanel_response",'class'=>"js-no-pjax show dropdown-toggle btn span6 top-mspace btn-large btn-primary text-18 textb",'data-toggle'=>'dropdown'));?>
				  <ul class="span19 unstyled dropdown-menu no-mar arrow arrow-right book-it-drop">
				   <li class="book-it-inner js-pending-list space no-mar clearfix">
					 <div class="clearfix host-panel-block" id="hostpanel_response">
						<!-- Bookit content from ajax -->
					 </div>
					 </li>
				   </ul>
				 </div>
				<?php else:?>
				<h2><span class="textb"><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']);?></span> <span class="text-11"><?php echo __l('Per night');?></span></h2>
				<div class="pull-right dropdown mob-clr">
				  <?php echo $this->Html->link(__l('Book it'), array('controller' => 'properties', 'action' => 'bookit', $property['Property']['slug'],$hash,$salt), array('title' => __l('Book it'),'id'=>'bookit', "data-trigger"=>"#bookit_response",'class'=>"js-no-pjax show dropdown-toggle btn span6 top-mspace btn-large btn-primary text-18 textb",'data-toggle'=>'dropdown'));?>

				  <ul class="unstyled dropdown-menu no-mar js-booking-block arrow arrow-right book-it-drop">
				    <li class="book-it-inner js-pending-list space no-mar clearfix">
					  <div class="" id="bookit_response">
					    <!-- Bookit content from ajax -->
					  </div>
				    </li>
				  </ul>
				</div>
			<?php endif;?>
		  <?php endif;?>
          </div>
        </div>
		<?php if (!empty($property['Attachment'])) { ?>
			<div class="carousel slide pr no-mar" id="myCarousel">
				<div class="js-expand carousel-inner cur">
					<div class="expand-circle">
						<span class="show"><i class="icon-resize-full text-18 whitec no-pad cur show"></i></span>
						<p class="full-screen"><?php echo __l('Go full screen');?></p>
					</div>
					<?php
						$ci = 1;
						foreach($property['Attachment'] as $attachment):
					?>
						<div class="item <?php if($ci == 1) { ?> active <?php } ?>">
							<?php $lowResImage = getImageUrl('Property', $attachment, array('dimension' => 'normal_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false), 'full_url' => true)); ?>
							<?php $highResImage = getImageUrl('Property', $attachment, array('dimension' => 'original', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false), 'full_url' => true)); ?>
							<div class="fill bg-image" style="background:url(<?php echo $lowResImage; ?>) no-repeat center;background-size:cover;" data-high_res_image="<?php echo $highResImage; ?>"></div>
						</div>
					<?php
						$ci++;
						endforeach;
					?>
				</div>
				<div class="clearfix controls hide">
					<div class="carousel-indicators carousel-linked-nav carousel-thumbnails">
						<div class="thumb-box">
							<ol class="unstyled pr no-mar clearfix">
								<?php
									$ci = 1;
									foreach($property['Attachment'] as $attachment):
								?>
									<li class="cur<?php if($ci == 1) { ?> active <?php } ?>" data-slide-to="<?php echo $ci; ?>" data-target="#myCarousel"><?php echo $this->Html->showImage('Property', $attachment, array('dimension' => 'iphone_small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false), 'width' => 50, 'height' => 50)); ?></li>
								<?php
									$ci++;
									endforeach;
								?>
							</ol>
						</div>
					</div>
					<a data-slide="prev" href="#myCarousel" class="left js-left-carousel carousel-control thumb-control">&lsaquo;</a>
					<span class="js-cover cur image-size-contain js-bootstrap-tooltip" title="<?php echo __l('Fit Screen/Show All'); ?>"> <i class="icon-resize-small js-icon-class whitec cur"></i> </span>
					<a data-slide="next" href="#myCarousel" class="right js-right-carousel carousel-control thumb-control">&rsaquo;</a>
				</div>
				<a data-slide="prev" href="#myCarousel" class="left carousel-control">&lsaquo;</a>
				<a data-slide="next" href="#myCarousel" class="right carousel-control">&rsaquo;</a>
			</div>
		<?php } else { ?>
			<div class="carousel slide pr no-mar" id="myCarousel">
				<div class="carousel slide no-mar">
					<div class="carousel-inner">
						<div class="item active">
							<?php echo $this->Html->showImage('Property', $attachment, array('dimension' => 'very_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))); ?>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

        
        <div class="row no-mar">
		<?php
		$view_count_url = Router::url(array(
			'controller' => 'properties',
			'action' => 'update_view_count',
		), true);
		?>
		<div class="big-thumb prop-owner pa img-polaroid mob-ps">
		
		<?php echo $this->Html->getUserAvatar($property['User'], 'small_big_thumb', true); ?>
		</div>
          <div class="offset5 span tab-right mob-clr clearfix">
            <div class="top-mspace top-space clearfix js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}">
			<?php if(!empty($this->request->params['named']['latitude']) && !empty($this->request->params['named']['longitude'])) { ?>
              <dl class="dc list">
                <dt class="pr hor-mspace text-11"><?php echo __l('Distance (km)'	);?></dt>
                <dd class="textb text-20 graydarkc pr hor-mspace"><?php echo $this->Html->cInt($this->Html->distance($this->request->params['named']['latitude'],$this->request->params['named']['longitude'],$property['Property']['latitude'],$property['Property']['longitude'],'K')); ?></dd>
              </dl>
			  <?php } ?>
              <dl class="dc sep-right list">
                <dt class="pr hor-mspace text-11"><?php echo __l('Views');?></dt>
                <dd class="textb text-20 graydarkc pr hor-mspace js-view-count-property-id js-view-count-property-id-<?php echo $property['Property']['id']; ?> {'id':'<?php echo $property['Property']['id']; ?>'}"><?php echo numbers_to_higher($property['Property']['property_view_count']); ?></dd>
              </dl>
              <dl class="dc sep-right list">
                <dt class="pr hor-smspace text-11"><?php echo __l('Positive');?></dt>
                <dd class="textb text-20 graydarkc pr hor-mspace"> <?php  echo numbers_to_higher($property['Property']['positive_feedback_count']); ?></dd>
              </dl>
              <dl class="dc sep-right list">
                <dt class="pr hor-mspace text-11"><?php echo __l('Negative');?></dt>
                <dd class="textb text-20 graydarkc pr hor-mspace"><?php echo numbers_to_higher($property['Property']['property_feedback_count'] - $property['Property']['positive_feedback_count']); ?></dd>
              </dl>
              <dl class="dc sep-right list">
                <dt class="pr hor-mspace text-11"><?php echo __l('Success Rate');?></dt>
				<?php if(empty($property['Property']['property_feedback_count'])): ?>
					<dd class="textb text-20 graydarkc pr hor-mspace" title="<?php  echo __l('No Bookings available'); ?>"><?php  echo __l('n/a'); ?></dd>
				<?php else:?>
				<dd class="textb text-20 graydarkc pr hor-mspace">
						<?php
							if(!empty($property['Property']['positive_feedback_count'])):
								$positive = floor(($property['Property']['positive_feedback_count']/$property['Property']['property_feedback_count']) *100);
								$negative = 100 - $positive;
							else:
								$positive = 0;
								$negative = 100;
							endif;
							echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=8DCA35|F47564&amp;chf=bg,s,FFFFFF00', array('width'=>'35px','height'=>'35px','title' => $positive.'%'));
						?>
						</dd>
					<?php endif; ?>
              </dl>
              
			  <?php if ($this->Auth->user('id') != $property['Property']['user_id']): ?>
				<dl class="dc sep-right list">
					    <dt class="pr hor-mspace text-11" ><?php echo __l('Network Level'); ?></dt>
					<?php if (!$this->Auth->user('is_facebook_friends_fetched')): ?>
						<dd class="textb text-20 graydarkc pr hor-mspace" title="<?php  echo __l('Connect with Facebook to find your friend level with host'); ?>"><?php  echo '?'; ?></dd>
					<?php elseif(!$this->Auth->user('is_show_facebook_friends')): ?>
						<dd class="textb text-20 graydarkc pr hor-mspace" title="<?php  echo __l('Enable Facebook friends level display in social networks page'); ?>"><?php  echo '?'; ?></dd>
					<?php elseif(empty($property['User']['is_facebook_friends_fetched'])): ?>
						<dd class="textb text-20 graydarkc pr hor-mspace" title="<?php  echo __l('Host is not connected with Facebook'); ?>"><?php  echo '?'; ?></dd>
					<?php elseif(!empty($network_level[$property['Property']['user_id']])): ?>
						<dd class="textb text-20 graydarkc pr hor-mspace" title="<?php  echo __l('Network Level'); ?>"><?php  echo $network_level[$property['Property']['user_id']]; ?></dd>
					<?php else: ?>
						<dd class="textb text-20 graydarkc pr hor-mspace" title="<?php  echo __l('Not available'); ?>"><?php  echo __l('n/a'); ?></dd>
					<?php endif; ?>
				</dl>
			<?php endif; ?>
            </div>
          </div>
		  <?php
			echo $this->element('popular-comment-users', array('user_name' => $property['User']['username'],'page' => 'view', 'config' => 'sec'));
		 ?>
        </div>
      </div> 
      <div class="main-content pr">
         <div id="ajax-tab-container-property" class="ajax-tab-container-property">
          <ul id="myTab2" class="nav nav-tabs top-space top-mspace">
            <li><a href="#description" data-toggle="tab" ><?php echo __l('Description'); ?></a> </li>
            <li>
				<?php	$hash = !empty($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : '';
					$salt = !empty($this->request->params['pass'][2]) ? $this->request->params['pass'][2] : '';
				echo $this->Html->link(__l('Nearby Properties'),array('controller' => 'properties', 'action' => 'index',$hash,$salt,'limit'=>5,'from'=>'ajax','property_id'=>$property['Property']['id'],'city_id'=>$property['City']['id'],'view'=>'compact', 'return'), array('title' => __l('Nearby Properties'), 'class' => 'js-no-pjax', 'data-target'=>'#Nearby-Properties','data-toggle'=>'tab')); ?>
			</li>
			
			<li><?php echo $this->Html->link(__l('Reviews'), array('controller' => 'properties', 'action' => 'review_index','property_id' =>$property['Property']['id'],'type'=>'property','view'=>'compact'), array('title' => __l('Reviews'),'data-target'=>'#reviews', 'class' => 'js-no-pjax', 'data-toggle'=>'tab'));?></li>
            <li>
			<?php echo $this->Html->link(__l('Recommendations'), array('controller' => 'user_comments', 'action' => 'index', $property['User']['username']), array('title' => __l('Recommendations'), 'class' => 'js-no-pjax', 'data-target'=>'#recom','data-toggle'=>'tab'));?>
			</li>
			<?php if(Configure::read('property.is_show_flickr') || Configure::read('property.is_show_amenities_around')) : ?>
				<li>
				<?php echo $this->Html->link(__l('Insights'), '#insights', array('title' => __l('Insights'), 'class' => 'js-no-pjax', 'data-toggle'=>'tab'));?>
				</li>
			<?php endif; ?>
			<?php if(!Configure::read('property.is_show_flickr') && !Configure::read('property.is_show_amenities_around')) : ?>
				<li><?php echo $this->Html->link(__l('Host\'s Other Property Reviews'), array('controller' => 'property_feedbacks', 'action' => 'index','user_id'=>$property['Property']['user_id'],'property_id' =>$property['Property']['id'],'type'=>'property','view'=>'compact'), array('title' => __l('Host\'s Other Property Reviews'), 'class' => 'js-no-pjax', 'data-target'=>'#opr','data-toggle'=>'tab'));?></li>
			<?php endif; ?>	
			<?php if(Configure::read('friend.is_enabled')){?>
				<li>
					<?php echo $this->Html->link(__l('Followings'), array('controller' => 'user_followers', 'action' => 'index','user'=>$property['Property']['user_id'],'type'=>'user','view'=>'compact'), array('title' => __l('Followings'), 'class' => 'js-no-pjax', 'data-target'=>'#friends','data-toggle'=>'tab'));?>
				
				</li>
			<?php } ?>
			<?php if(!empty($property['Property']['video_url'])): ?>
			<li><?php echo $this->Html->link(__l('Video'),  '#videos', array('title' => __l('Video'), 'class' => 'js-no-pjax', 'data-toggle'=>'tab'));?></li>
			<?php endif; ?>
			<li><?php echo $this->Html->link(__l('Map'), array('controller' => 'properties', 'action' => 'static_map', $property['Property']['slug']), array('title' => __l('Map'), 'class' => 'js-no-pjax', 'data-toggle'=>'tab', 'data-target'=>'#maps'));?></li>
			
			
          </ul>
          <div class="sep-right sep-left sep-bot tab-round tab-content" id="myTabContent2">
            <div class="tab-pane space active" id="description">
              <h3 class="well space textb text-16 no-mar"><?php echo __l('Description'); ?></h3>
              <p class="ver-mspace"><?php echo $this->Html->cText($property['Property']['description']);?></p>
              <h2 class="space textb text-20 no-mar"><?php echo __l('Features'); ?></h2>
				<div class="properties-left" id="feature">
                                <h3 class="well textb text-16 space clearfix top-mspace"> 
					<span class="pull-left"><?php echo __l('Amenities'); ?></span>
					<span class="hide-button hide js-amenities-show pull-right text10 btn"><?php echo __l('Hide'); ?> </span>
				</h3>							
                             
				<?php if(!empty($amenities_list)) { ?>
					<ol class="amenities-list clearfix js-amenity unstyled">
						<?php    
							foreach($amenities_list as $key => $amenity) {
								$class='not-allowed';
								foreach($property['Amenity'] as $amen) {
									if ($amen['name']==$amenity) {
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
				<?php } ?>
				<h3 class="well space textb text-16 no-mar"> <?php echo __l('Holiday Types'); ?></h3>
				<?php if (!empty($holiday_list)) {?>
					<ol class="amenities-list clearfix unstyled">
						<?php
							foreach($holiday_list as $h_key => $holiday) {
								$class='not-allowed';
								foreach($property['HolidayType'] as $holi) {
									if($holi['name']==$holiday) {
										$class='allowed';
									}
								}
						?>
						<li>
							<?php $holiday_class_name = 'amenities-ht-' . $h_key; ?>
							<span class="<?php echo $class; ?>" title ="<?php echo ($class == 'allowed') ? __l('Yes') : __l('No'); ?>"><?php echo ($class == 'allowed') ? __l('Yes') : __l('No');?></span>
							<span class="<?php echo $holiday_class_name; ?>"><?php echo  $this->Html->cText($holiday); ?></span>
						</li>
						<?php } ?>
					</ol>
				<?php } ?>
			</div>
			<div class="properties-right">
					<div class="bot-mspace clearfix">
					<h3 class="well space textb text-16 no-mar"> <?php echo __l('Additional Features'); ?></h3>
						<div class="space clearfix">
						<dl class="dc sep-right list top-space">
							<dt class="pr hor-mspace text-11"><?php echo __l('Room Type');?></dt>
							<dd class="textb  pr hor-mspace"><?php echo $this->Html->cText($property['RoomType']['name']);?></dd>
						</dl>
						<dl class="dc sep-right list">
							<dt class="pr hor-mspace text-11"><?php echo __l('Bed Type');?></dt>
							<dd class="textb  pr hor-mspace"><?php echo $this->Html->cText($property['BedType']['name']);?></dd>
						</dl>
						<dl class="dc sep-right list">
							<dt class="pr hor-mspace text-11"><?php echo __l('Accommodates');?></dt>
							<dd class="textb  pr hor-mspace"><?php echo $this->Html->cInt($property['Property']['accommodates']);?></dd>
						</dl>
						<dl class="dc sep-right list">
							<dt class="pr hor-mspace text-11"><?php echo __l('Bed rooms');?></dt>
							<dd class="textb  pr hor-mspace"><?php echo $this->Html->cInt($property['Property']['bed_rooms']);?></dd>
						</dl>
						<dl class="dc sep-right list">
							<dt class="pr hor-mspace text-11"><?php echo __l('Bath rooms');?></dt>
							<dd class="textb  pr hor-mspace"><?php echo $this->Html->cInt($property['Property']['bath_rooms']);?></dd>
						</dl>
						<?php if (!empty($property['Property']['property_size'])): ?>
						<dl class="dc sep-right list">
							<dt class="pr hor-mspace text-11"><?php echo __l('Size');?></dt>
							<?php $measure=(ConstMeasureAction::Squarefeet==$property['Property']['measurement'])?__l('Square Feet'):__l('Square Meters'); ?>
							<dd class="textb  pr hor-mspace"><?php echo $this->Html->cInt($property['Property']['property_size']).' '.$this->Html->cText($measure,false);?></dd>
						</dl>
						<?php endif; ?>
						<dl class="dc  list bot-space">
							<dt class="pr hor-mspace text-11"><?php echo __l('Pets allowed');?></dt>
							<?php $allowed=($property['Property']['is_pets'])?__l('Yes'):__l('No'); ?>
							<dd class="textb  pr hor-mspace"><?php echo $this->Html->cText($allowed);?></dd>
						</dl>
						</div>
					</div>
			</div>
			<div class="bot-mspace clearfix">
			  <h3 class="well space textb text-16 no-mar"><?php echo __l('Rate Details'); ?></h3>
			  <div class="space clearfix">
				<dl class="dc sep-right list">
					<dt class="pr hor-mspace text-11"><?php echo __l('Per night');?></dt>
					<dd class="textb  pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']);?></dd>
				</dl>
				<dl class="dc sep-right list">
					<dt class="pr hor-mspace text-11"><?php echo __l('Per week');?></dt>
					<dd class="textb  pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_week']);?></dd>
				</dl>
				<dl class="dc sep-right list">
					<dt class="pr hor-mspace text-11"><?php echo __l('Per month');?></dt>
					<dd class="textb  pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_month']);?></dd>
				</dl>
				<dl class="dc sep-right list">
					<dt class="pr hor-mspace text-11"><?php echo __l('Extra people');?></dt>
					<?php if($property['Property']['additional_guest_price']>0): ?>
						<dd class="textb  pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($property['Property']['additional_guest_price']);?><?php echo ' ' . __l('per night after') . ' ' . $this->Html->cInt($property['Property']['additional_guest']) . ' ' . __l('guest');?></dd>
					<?php else: ?>
						<dd class="textb  pr hor-mspace"><?php echo __l('No Additional Cost'); ?> </dd>
					<?php endif; ?>
				</dl>
				<dl class="dc sep-right list">
					<dt class="pr hor-mspace text-11"><?php echo __l('Minimum Stay');?></dt>
					<dd class="textb  pr hor-mspace"><?php echo $this->Html->cInt($property['Property']['minimum_nights']) . ' ' . __l('nights');?></dd>
				</dl>
				<dl class="dc  list">
					<dt class="pr hor-mspace text-11"><?php echo __l('Maximum Stay');?></dt>
					<dd class="textb pr hor-mspace"><?php echo ($property['Property']['maximum_nights'])?$this->Html->cInt($property['Property']['maximum_nights']) . ' ' . __l('nights') : __l('No Maximum');?></dd>
				</dl>
			</div>
			</div>
			 <h3 class="well space textb text-16 no-mar"><?php echo __l('Conditions');?></h3>
				<div class="space mspace clearfix tooltip-big">
				<?php if(!empty($property['CancellationPolicy'])) { ?>
					<?php
						if ($property['CancellationPolicy']['percentage'] == '0.00') {
							$percentage = 'No';
						} elseif ($property['CancellationPolicy']['percentage'] == '100.00') {
							$percentage = 'Full';
						} else {
							$percentage = $this->Html->cFloat($property['CancellationPolicy']['percentage'], false) . '%';
						}
					?>
				<dl class="dc sep-right list top-space">
					<dt class="pr hor-mspace text-11"><?php echo __l('Cancellation Policy'); ?></dt>
					<dd class="textb  pr hor-mspace"><?php echo $this->Html->cText($property['CancellationPolicy']['name']); ?> <span class="js-bootstrap-tooltip" title="<?php echo sprintf(__l('%s refund %s day(s) prior to arrival, except fees'), $percentage, $this->Html->cText($property['CancellationPolicy']['days'], false)); ?>"><i class="icon-question-sign"></i></span></dd>
				</dl>
				<?php } ?>
				<dl class="dc sep-right list top-space">
					<dt class="pr hor-mspace text-11"><?php echo __l('Min nights'); ?></dt>
					<dd class="textb  pr hor-mspace"><?php echo $this->Html->cInt($property['Property']['minimum_nights']); ?></dd>
				</dl>
				<dl class="dc sep-right list top-space">
					<dt class="pr hor-mspace text-11"><?php echo __l('Max nights'); ?></dt>
					<dd class="textb  pr hor-mspace"><?php echo ($property['Property']['maximum_nights'] == 0) ? __l('No Maximum') : $this->Html->cInt($property['Property']['maximum_nights']); ?></dd>
				</dl>
				<dl class="dc  list top-space">
					<dt class="pr hor-mspace text-11"><?php echo __l('Max Guests'); ?></dt>
					<dd class="textb  pr hor-mspace"><?php echo $this->Html->cInt($property['Property']['accommodates']); ?></dd>
				</dl>
				</div>
              <h3 class="well space textb text-16 "><?php echo __l('House Rules'); ?></h3>
              <div class="ver-mspace">
				<?php if(!empty($property['Property']['house_rules'])): ?>
					<?php echo $this->Html->cText($property['Property']['house_rules']);?>
				<?php else: ?>
						<div class="space dc grayc">
							<span class="ver-mspace top-space text-16">
					<?php echo __l('No house rules available');?></span></div>
				<?php endif; ?>
			  </div>
             
            </div>
			<div id="Nearby-Properties" class="tab-pane tab-round"> </div>
			<div id="reviews" class="tab-pane"></div>
			<div id="recom"  class="tab-pane"></div>
			<div id="insights" class="tab-pane">
				<div id="ajax-tab-container-property-thirdparty" class="ajax-tab-container-property-thirdparty">
				  <ul id="myTab2" class="nav nav-tabs tabs top-space top-mspace">
					<li><?php echo $this->Html->link(__l('Host\'s Other Property Reviews'), array('controller' => 'property_feedbacks', 'action' => 'index','user_id'=>$property['Property']['user_id'],'property_id' =>$property['Property']['id'],'type'=>'property','view'=>'compact'), array('title' => __l('Host\'s Other Property Reviews'), 'class' => 'js-no-pjax', 'data-target'=>'#insiteopr','data-toggle'=>'tab'));?></li>
					<?php if(Configure::read('property.is_show_flickr')) : ?>
					<li><?php echo $this->Html->link(__l('Photos Around'), array('controller' => 'properties', 'action' => 'flickr',$lat,$lng), array('title' => __l('Photos Around'),'data-target'=>'#flickr','data-toggle'=>'tab','class'=>"js-no-pjax"));?></li>
					<?php endif; ?>
					<?php if(Configure::read('property.is_show_amenities_around')) : ?>
					<li><?php echo $this->Html->link(__l('Amenities Around'), array('controller' => 'properties', 'action' => 'amenities_around',$lat,$lng), array('title' => __l('Amenities Around'),'data-target'=>'#amenities_around','data-toggle'=>'tab','class'=>"js-no-pjax"));?></li>
					<?php endif; ?>
				  </ul>
				  <div class="sep-right sep-left sep-bot tab-round tab-content" id="myTabContent2">
					<div id="insiteopr" class="tab-pane"></div>
					<div id="flickr" class="tab-pane tab-round"> </div>
					<div id="amenities_around" class="tab-pane tab-round"> </div>
				  </div>
				</div>
			</div>
			<div id="opr" class="tab-pane"></div>
			<div id="friends" class="tab-pane"></div>
			<div id="videos" class="tab-pane">
				<?php if (!empty($property['Property']['video_url'])): ?>
							<div id="video-1" class="space dc">
								<?php
									if($this->Embed->parseUrl($property['Property']['video_url'])) {
										$this->Embed->setHeight('410px');
										$this->Embed->setWidth('647px');
										echo $this->Embed->getEmbedCode();
									}
								?>
							</div>
						<?php endif; ?>
			</div>
			<div id="maps" class="tab-pane"></div>
          </div>
        </div>
      </div>
</div>
<?php if (Configure::read('widget.property_script')) { ?>
	<div class="dc clearfix ver-space">
		<?php echo Configure::read('widget.property_script'); ?>
	</div>
<?php } ?>
<div id="fb-root"></div>
<?php Configure::write('highperformance.pids', $property['Property']['id']); ?>

</div>