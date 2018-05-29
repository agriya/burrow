<div class="alert alert-info mspace"><?php echo sprintf(__l('This is integrated with Google Analytics. Update settings %s.'), $this->Html->link(__l('here'), array('controller'=> 'settings', 'action' => 'plugin_settings', 'IntegratedGoogleAnalytics'), array('class' => 'googleplusc'))); ?></div>
<?php
if (Configure::read('google_analytics.access_token')) {?>
  <div class="space js-cache-load js-cache-load-admin-charts {'data_url':'admin/google_analytics/form_bounce_chart', 'data_load':'js-cache-load-admin-chart-bounces-form'}">
    <?php  echo $this->element('chart-admin_chart_form_bounces', array('cache' => array('config' => 'site_element_cache_5_hours'))); ?>
  </div>
  <div class="space js-cache-load js-cache-load-admin-charts {'data_url':'admin/google_analytics/ecommerce_chart', 'data_load':'js-cache-load-admin-ecommerce_chart'}">
    <?php echo $this->element('chart-admin_chart_ecommerce', array('cache' => array('config' => 'site_element_cache_5_hours'))); ?>
  </div>
  <div class="space js-cache-load js-cache-load-admin-charts {'data_url':'admin/google_analytics/sources_chart', 'data_load':'js-cache-load-admin-chart-sources'}">
	<?php  echo $this->element('chart-admin_chart_sources', array('cache' => array('config' => 'site_element_cache_5_hours'))); ?>
  </div>
  <?php }?>