<div class="js-countries">
  <div class="accordion-group">
    <div class="accordion-heading">
      <div class="well no-pad no-mar no-bor clearfix box-head">
        <h5>
          <span class="space pull-left">
            <i class="icon-bar-chart no-bg"></i>
            <?php echo __l('Visits per Country'); ?>
          </span>
          <a class="accordion-toggle js-toggle-icon js-no-pjax grayc no-under clearfix pull-right" href="#countries" data-parent="#accordion-admin-dashboard" data-toggle="collapse">
            <i class="icon-angle-up pull-right text-16 textb"></i>
          </a>
          <div class="dropdown pull-right ver-space">
            <a class="dropdown-toggle js-no-pjax js-overview grayc no-under" data-toggle="dropdown" href="#">
              <i class="icon-wrench no-pad"></i>
            </a>
            <ul class="dropdown-menu pull-right arrow arrow-right">
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastDays') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-countries"}' title="<?php echo __l('Last 7 days'); ?>"  href="<?php echo Router::url('/', true)."admin/google_analytics/analytics_chart/select_range_id:lastDays";?>"><?php echo __l('Last 7 days'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastWeeks') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-countries"}' title="<?php echo __l('Last 4 weeks'); ?>" href="<?php echo Router::url('/', true)."admin/google_analytics/analytics_chart/select_range_id:lastWeeks";?>"><?php echo __l('Last 4 weeks'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastMonths') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-countries"}' title="<?php echo __l('Last 3 months'); ?>" href="<?php echo Router::url('/', true)."admin/google_analytics/analytics_chart/select_range_id:lastMonths";?>"><?php echo __l('Last 3 months'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastYears') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-countries"}' title="<?php echo __l('Last 3 years'); ?>"  href="<?php echo Router::url('/', true)."admin/google_analytics/analytics_chart/select_range_id:lastYears";?>"><?php echo __l('Last 3 years'); ?></a> </li>
            </ul>
          </div>
        </h5>
      </div>
    </div>
    <div id="countries" class="accordion-body in collapse over-hide">
      <div class="accordion-inner">
        <div class="row-fluid ver-space">
          <section class="span24 dc">
            <?php
              foreach($countries_stats->rows as $countries):
                $countries_arr[] = '["' . $countries[0] . '", ' . $countries[1] . ']';
              endforeach;
            ?>
            <script type='text/javascript'>
              <?php if(empty($this->request->params['isAjax'])) { ?>
				  google.setOnLoadCallback(drawChart);
                  function drawChart() {
			  <?php } ?>
                var data = google.visualization.arrayToDataTable([
                  ['Country', 'Visits'],
                  <?php echo implode(',', $countries_arr); ?>
                ]);
                var options = {};
                var chart = new google.visualization.GeoChart(document.getElementById('countries_chart'));
                chart.draw(data, options);
              <?php if(empty($this->request->params['isAjax'])) { ?>	
                  }
			  <?php } ?>
            </script>
            <div class="dc" id="countries_chart" style="width: 900px; height: 500px;"></div>
          </section>
        </div>
      </div>
    </div>
  </div>
</div>