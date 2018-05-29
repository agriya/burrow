	<div class="js-flickr-link  {'url':'<?php echo Configure::read('flickr.url').'='.Configure::read('flickr.api_key').'&lat='.$lat.'&lon='.$lng;?>&radius=30&safe_search=1&per_page=20'}" id="flicker">
		 <div id="flicker-images" class="clearfix flicker-images">
			<div class="space dc">
				<?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Throbber]') ,'width' => 25, 'height' => 25)); ?>
				<span class="loading show">Loading....</span>
			</div>
		</div>
   </div>
   <div class="dr smspace graylightc text-11">
   <?php echo __l('Powered by Flickr'); ?>
   </div>