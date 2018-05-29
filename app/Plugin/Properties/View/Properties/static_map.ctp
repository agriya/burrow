<div id="map-2" class="ui-corner-right">
	<?php if(!empty($property['Property']['address'])): ?>
		<?php $map_zoom_level = !empty($property['Property']['map_zoom_level']) ? $property['Property']['zoom_level'] : '10';?>
		<a href="//maps.google.com/maps?q=<?php echo $property['Property']['latitude']; ?>,<?php echo $property['Property']['longitude']; ?>&amp;z=<?php echo $map_zoom_level; ?>" class="show space" target="_blank">
		<img src="<?php echo $this->Html->formGooglemap($property['Property'],'648x402'); ?>" width="950" height="402" />
		</a>
	<?php endif; ?>
</div>