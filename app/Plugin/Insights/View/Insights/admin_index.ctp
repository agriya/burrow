<div class="space accordion" id="accordion-admin-dashboard">
	<div class="js-cache-load js-cache-load-admin-charts {'data_url':'admin/insights/chart_overview', 'data_load':'js-cache-load-admin-charts-overview'}">
		<?php echo $this->element('chart-admin_chart_overview', array('plugin' => 'Insights')); ?>
	</div>
</div>
<div class="space accordion" id="accordion-admin-dashboard">
	<div class="js-cache-load js-cache-load-admin-charts {'data_url':'admin/insights/chart_users', 'data_load':'js-cache-load-admin-charts-users'}"> 
		<?php echo $this->element('chart-admin_chart_users', array('role_id'=> ConstUserTypes::User), array('plugin' => 'Insights')); ?>
	</div>
</div>
<div class="space accordion" id="accordion-admin-dashboard">
	<div class="js-cache-load js-cache-load-admin-charts {'data_url':'admin/insights/chart_user_logins', 'data_load':'js-cache-load-admin-charts-logins'}">
		<?php echo $this->element('chart-admin_chart_user_logins', array('role_id'=> ConstUserTypes::User), array('plugin' => 'Insights')); ?>
	</div>
</div>
<div class="space accordion" id="accordion-admin-dashboard">
	<div class="js-cache-load js-cache-load-admin-charts {'data_url':'admin/insights/chart_properties', 	'data_load':'js-cache-load-admin-charts-properties'}">
		<?php echo $this->element('chart-admin_chart_properties', array('plugin' => 'Insights'));?>
	</div>
</div>
<?php if(isPluginEnabled('Requests')) {  ?>
	<div class="space accordion" id="accordion-admin-dashboard">
		<div class="js-cache-load js-cache-load-admin-charts {'data_url':'admin/insights/chart_requests', 'data_load':'js-cache-load-admin-charts-requests'}">
			<?php echo $this->element('chart-admin_chart_requests', array('plugin' => 'Insights'));?>
		</div>
	</div>
<?php } ?>
<div class="space accordion" id="accordion-admin-dashboard">
	<div class="js-cache-load js-cache-load-admin-charts {'data_url':'admin/insights/chart_user_activities', 'data_load':'js-cache-load-admin-charts-user-activities'}">
		<?php echo $this->element('chart-admin_chart_user_activities', array('plugin' => 'Insights'));?>
	</div>
</div>