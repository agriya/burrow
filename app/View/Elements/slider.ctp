<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<div class="top-content pr space request">
<h2 class="space"><?php echo !empty($collections['Collection']['title']) ? $this->Html->cText($collections['Collection']['title'], false) : ''; ?></h2>
		<?php
	$view_count_url = Router::url(array(
		'controller' => 'properties',
		'action' => 'update_view_count',
	), true);
?> <?php if (!empty($properties)): ?>
        <div id="myCarousel" class="carousel slide pr no-mar js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}">
          <div class="carousel slide no-mar">
            <div class="carousel-inner">
			<?php 
			$i = 0;
			foreach($properties As $property) { ?>
			<?php if(isset($property['Attachment'][0])): ?>
              <div class="item <?php if($i == 0) { ?> active <?php } ?>"><?php echo $this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'very_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))); ?>
			  <div class="carousel-caption">
               <div class="span12">
				 <div class="clearfix bot-space">
					  <h2 class="span right-mspace span12 htruncate">
							<?php
								echo $this->Html->getUserAvatarLink($property['User'], 'small_thumb');
							?>
				<?php echo $this->Html->link($this->Html->cText($property['Property']['title'],false), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false),array('title'=>$this->Html->cText($property['Property']['title'], false),'class'=> 'graydarkc')); ?> </h2>
				</div>
          <div class="clearfix">
		  <?php if(!empty($property['Country']['iso_alpha2'])): ?>
						<span class="flags flag-<?php echo strtolower($property['Country']['iso_alpha2']); ?>" title ="<?php echo $property['Country']['name']; ?>"><?php echo $property['Country']['name']; ?></span>
				<?php endif; ?>
            			<p class="span11 htruncate graydarkc"><?php echo $this->Html->cText($property['Property']['address']);?>
		  </div>
		  </div>
		  <div class="clearfix pull-right">
            <div class="top-mspace top-space clearfix">
						<dl class="dc sep-right list">
							<dt class="pr hor-mspace text-11" title ="<?php echo __l('Views');?>"><?php echo __l('Views');?></dt>
							<dd class="dtextb text-20 graydarkc pr hor-mspace js-view-count-property-id dc js-view-count-property-id-<?php echo $property['Property']['id']; ?> {'id':'<?php echo $property['Property']['id']; ?>'}"><?php  echo numbers_to_higher($property['Property']['property_view_count']); ?></dd>
						</dl>
						<dl class="dc sep-right list">
							<dt class="pr hor-mspace text-11" title ="<?php echo __l('Positive');?>"><?php echo __l('Positive');?></dt>
							<dd class="dtextb text-20 graydarkc pr hor-mspace"><?php  echo $this->Html->cInt($property['Property']['positive_feedback_count']); ?></dd>
						</dl>
						<dl class="dc sep-right list">
							<dt class="pr hor-mspace text-11" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
							<dd  class="dtextb text-20 graydarkc pr hor-mspace"><?php  echo $this->Html->cInt($property['Property']['property_feedback_count'] - $property['Property']['positive_feedback_count']); ?></dd>
						</dl>
						<dl class="dc list">
    						<dt class="pr hor-mspace text-11" title ="<?php echo __l('Success Rate');?>"><?php echo __l('Success Rate');?></dt>
							<?php if($property['Property']['property_feedback_count'] == 0): ?>
								<dd class="dtextb text-20 graydarkc pr hor-mspace" title="<?php  echo __l('No Bookings available'); ?>"><?php  echo __l('n/a'); ?></dd>
							<?php else:?>
							<dd class="dtextb text-20 graydarkc pr hor-mspace">
                               <?php
										if(!empty($property['Property']['positive_feedback_count'])):
										$positive = floor(($property['Property']['positive_feedback_count']/$property['Property']['property_feedback_count']) *100);
										$negative = 100 - $positive;
										else:
										$positive = 0;
										$negative = 100;
										endif;
										
										echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=8DCA35|F47564&amp;chf=bg,s,FFFFFF00', array('width' => '30px', 'height' => '30px', 'class' => 'js-skip-gallery', 'title' => $positive.'%')); ?>
							</dd>
							<?php endif; ?>
    					</dl>
					</div>
				
					</div>
				
			  </div>
			  </div>
              <?php endif; 
				$i++;
			  } ?> 
            </div>
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
			<a class="right carousel-control" href="#myCarousel" data-slide="next">›</a> </div>
        </div>
		<?php endif; ?>
        <div class="row no-mar pull-right">
          <div class="span tab-right mob-clr clearfix">
            <div class="top-mspace top-space clearfix">
              <dl class="dc sep-right list">
                <dt class="pr hor-mspace text-11"><?php echo __l('Properties');?></dt>
                <dd title="<?php echo !empty($property_count) ? $this->Html->cInt($property_count, false) : 0; ?>" class="textb text-20 graydarkc pr hor-mspace"> <?php echo !empty($property_count) ? $this->Html->cInt($property_count, false) : 0; ?></dd>
              </dl>
              <dl class="dc sep-right list">
                <dt class="pr hor-mspace text-11"><?php echo __l('Cities');?></dt>
                <dd title="<?php echo !empty($collections['Collection']['city_count']) ? $this->Html->cInt($collections['Collection']['city_count'], false) : 0; ?>" class="textb text-20 graydarkc pr hor-mspace"><?php echo !empty($collections['Collection']['city_count']) ? $this->Html->cInt($collections['Collection']['city_count'], false) : 0; ?></dd>
              </dl>
              <dl class="dc list">
                <dt class="pr hor-smspace text-11"><?php echo __l('Countries');?></dt>
                <dd title="<?php echo !empty($collections['Collection']['country_count']) ? $this->Html->cInt($collections['Collection']['country_count'], false) : 0; ?>" class="textb text-20 graydarkc pr hor-mspace"><?php echo !empty($collections['Collection']['country_count']) ? $this->Html->cInt($collections['Collection']['country_count'], false) : 0; ?></dd>
              </dl>
            </div>
          </div>
        </div>
		<div class="row no-mar ">
			<h3><?php echo __l("Description"); ?> </h3>
			<p> <?php echo $this->Html->cText($property['Property']['description']);?></p>
		</div>
      </div>

  <div id="fb-root"></div>
  <script type="text/javascript">
	  window.fbAsyncInit = function() {
		FB.init({appId: '<?php echo Configure::read('facebook.app_id');?>', status: true, cookie: true,
				 xfbml: true});
	  };
	  (function() {
		var e = document.createElement('script'); e.async = true;
		e.src = document.location.protocol +
		  '//connect.facebook.net/en_US/all.js';
		document.getElementById('fb-root').appendChild(e);
	  }());

	</script>