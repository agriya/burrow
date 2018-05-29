<ul class="unstyled clearfix row-fluid">
	<?php foreach ($setting_categories as $setting_category): ?>
		<li class="span12 no-mar">
			<div class="well mspace setting-details-info setting-category-<?php echo $setting_category['SettingCategory']['id']; ?>">
				<h3><?php echo $this->Html->link($this->Html->cText($setting_category['SettingCategory']['name'], false), array('controller' => 'settings', 'action' => 'edit', $setting_category['SettingCategory']['id']), array('title' => $setting_category['SettingCategory']['name'], 'escape' => false)); ?></h3>
				<div class="htruncate-ml3 text-13 textn js-bootstrap-tooltip">
					<?php echo str_replace('##PAYMENT_SETTINGS_URL##', Router::url(array('controller' => 'payment_gateways', 'action' => 'index')), $setting_category['SettingCategory']['description']); ?>
				</div>
			</div>
		</li>
	<?php endforeach; ?>
</ul>