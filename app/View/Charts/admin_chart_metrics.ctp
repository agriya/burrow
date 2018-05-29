<div class="js-metrics metrics-section">

      <div class="no-mar no-bor clearfix box-head bootstro" data-bootstro-step="12" data-bootstro-content="<?php echo __l("A page view is an instance of a page being loaded by a browser. The Page views metric is the total number of pages viewed; repeated views of a single page are also counted. Visitors is number of user visit the site. Bounces represents the percentage of visitors who enter the site and 'bounce' (leave the site) rather than continue viewing other pages within the site. Also it shows the graphical representation of the already existing user's visit and new user visit rate. Recent Activity shows the last 3 site activities. To see the list of all activities please click 'More' button. User engagment shows current status site users. An overview of site activities such as registerations, logins, posts, funfs, revenue and performance comparison with previous period");?>" data-bootstro-placement='bottom' data-bootstro-width="600px" data-bootstro-title="Overview">
            <div class="no-bor clearfix well no-mar space">
              <h5 class="pull-left textb graydarkc text-14"><i class="icon-bar-chart hor-smspace text-16"></i><span> <?php echo __l('Overview'); ?></span></h5>
              <div class="pull-right"> 
          <a class="accordion-toggle js-toggle-icon js-no-pjax grayc no-under clearfix pull-right" href="#metrics" data-parent="#accordion-admin-dashboard" data-toggle="collapse">
            <i class="icon-angle-up text-16 textb"></i>
          </a>
          <div class="dropdown pull-right">
            <a class="dropdown-toggle js-no-pjax js-overview grayc no-under" data-toggle="dropdown" href="#">
              <i class="ver-smspace hor-space icon-wrench"></i>
            </a>
            <ul class="dropdown-menu dl arrow arrow-right">
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastDays') ? ' class="active"' : ''; ?>><a class='js-link js-no-pjax {"data_load":"js-metrics"}' title="<?php echo __l('Last 7 days'); ?>"  href="<?php echo Router::url('/', true)."admin/charts/chart_metrics/select_range_id:lastDays";?>"><?php echo __l('Last 7 days'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastWeeks') ? ' class="active"' : ''; ?>><a class='js-link js-no-pjax {"data_load":"js-metrics"}' title="<?php echo __l('Last 4 weeks'); ?>" href="<?php echo Router::url('/', true)."admin/charts/chart_metrics/select_range_id:lastWeeks";?>"><?php echo __l('Last 4 weeks'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastMonths') ? ' class="active"' : ''; ?>><a class='js-link js-no-pjax {"data_load":"js-metrics"}' title="<?php echo __l('Last 3 months'); ?>" href="<?php echo Router::url('/', true)."admin/charts/chart_metrics/select_range_id:lastMonths";?>"><?php echo __l('Last 3 months'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastYears') ? ' class="active"' : ''; ?>><a class='js-link js-no-pjax {"data_load":"js-metrics"}' title="<?php echo __l('Last 3 years'); ?>"  href="<?php echo Router::url('/', true)."admin/charts/chart_metrics/select_range_id:lastYears";?>"><?php echo __l('Last 3 years'); ?></a> </li>
            </ul>
          </div>			  
			  

              </div>
            </div>	  
		


    <div id="metrics" class="accordion-body in collapse over-hide">
      <div class="accordion-inner">
        <div class="row-fluid ver-space">
        <?php
          $select_range_id = (!empty($this->request->params['named']['select_range_id']))?$this->request->params['named']['select_range_id']:'lastDays';
              if (isPluginEnabled('IntegratedGoogleAnalytics') && Configure::read('google_analytics.access_token')): ?>
				<?php echo $this->element('chart-admin_chart_google_analytics', array('select_range_id' => $select_range_id, 'from' => 'chart_metrics', 'cache' => array('config' => 'site_element_cache_5_hours'))); ?>
		      <?php endif; ?>

		<div class="span24 center-box">
		<div class="js-cache-load js-cache-load-admin-charts {'data_url':'admin/charts/user_engagement/select_range_id:<?php echo $select_range_id;?>/from:chart_metrics', 'data_load':'js-cache-load-admin-charts-user-engagement'}">
			<?php  echo $this->element('chart-admin_chart_engagement', array('select_range_id' => $select_range_id, 'from' => 'chart_metrics', 'cache' => array('config' => 'site_element_cache_5_hours'))); ?>
		 </div>
		 </div>
			<div class="pull-left js-cache-load js-cache-load-admin-charts {'data_url':'admin/charts/user_activities/select_range_id:<?php echo $select_range_id;?>/from:chart_metrics', 'data_load':'js-cache-load-admin-user-activities'}">
		   <?php echo $this->element('chart-admin_user_activities', array('select_range_id' => $select_range_id, 'from' => 'chart_metrics', 'cache' => array('config' => 'site_element_cache_5_hours')));?>
		   </div>

        </div>
      </div>
    </div>
  </div>
</div>