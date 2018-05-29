<div id="nearest_place" class="js-near-link {'lat':'<?php echo $lat; ?>','lng':'<?php echo $lng; ?>'}">
	<div class="space dc">
		<?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Throbber]') ,'width' => 25, 'height' => 25)); ?>
		<span class="loading show">Loading....</span>
	</div>
</div>