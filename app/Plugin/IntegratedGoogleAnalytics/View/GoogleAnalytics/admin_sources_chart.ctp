<div class="js-sources js-cache-load-admin-chart-sources">
  <div class="accordion-group" >
    <div class="accordion-heading bootstro" data-bootstro-step="3" data-bootstro-content="<?php echo __l("Traffic is use to measure how actively the visitors are engaging with site and content. Visits per source is use to analyze by which source most of user visit the website. Visit & new visits is use to analyze which user mostly visit the site either new only or already existing user. Geo graph is use to analyze in which region most of the visits from.");?>" data-bootstro-width="600px" data-bootstro-title="Traffic">
      <div class="well no-pad no-mar no-bor clearfix box-head">
        <h5>
          <span class="space pull-left">
            <i class="icon-bar-chart no-bg"></i>
            <?php echo __l('Traffic'); ?>
          </span>
          <a class="accordion-toggle js-toggle-icon js-no-pjax grayc no-under clearfix pull-right" href="#sources" data-parent="#accordion-admin-dashboard" data-toggle="collapse">
            <i class="icon-angle-up pull-right text-16 textb"></i>
          </a>
          <div class="dropdown pull-right ver-space">
            <a class="dropdown-toggle js-no-pjax js-overview grayc no-under" data-toggle="dropdown" href="#">
              <i class="icon-wrench no-pad"></i>
            </a>
            <ul class="dropdown-menu pull-right arrow arrow-right">
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastDays') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-sources"}' title="<?php echo __l('Last 7 days'); ?>"  href="<?php echo Router::url('/', true)."admin/google_analytics/sources_chart/select_range_id:lastDays";?>"><?php echo __l('Last 7 days'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastWeeks') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-sources"}' title="<?php echo __l('Last 4 weeks'); ?>" href="<?php echo Router::url('/', true)."admin/google_analytics/sources_chart/select_range_id:lastWeeks";?>"><?php echo __l('Last 4 weeks'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastMonths') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-sources"}' title="<?php echo __l('Last 3 months'); ?>" href="<?php echo Router::url('/', true)."admin/google_analytics/sources_chart/select_range_id:lastMonths";?>"><?php echo __l('Last 3 months'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastYears') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-sources"}' title="<?php echo __l('Last 3 years'); ?>"  href="<?php echo Router::url('/', true)."admin/google_analytics/sources_chart/select_range_id:lastYears";?>"><?php echo __l('Last 3 years'); ?></a> </li>
            </ul>
          </div>
        </h5>
      </div>
    </div>
    <div id="sources" class="accordion-body in collapse over-hide">
      <div class="accordion-inner">
        <section class="span19 center-box js-cache-load-admin-chart-bounces">
            <?php $select_range_id = (!empty($this->request->params['named']['select_range_id']))?$this->request->params['named']['select_range_id']:'lastDays'; ?>
            <?php echo $this->element('chart-admin_chart_bounces', array('select_range_id' => $select_range_id, 'from_section' => 'traffic','cache' => array('config' => 'site_element_cache_15_min'))); ?>
        </section>
        <div class="row-fluid ver-space">
			<div class="span24">
                <div class="span12">
                    <section class="span dc no-mar">
					<h3><?php echo __l("Visits Per Source"); ?></h3>
						<?php
						$visit_by_sources_arr = array();
						if(!empty($visit_by_sources_stats->rows)){
                          foreach($visit_by_sources_stats->rows as $visit_by_sources):
                            $visit_by_sources_arr[] = '["' . $visit_by_sources[0] . '", ' . $visit_by_sources[1] . ']';
                          endforeach;
						  }
                        ?>
                        <script type="text/javascript">
                          <?php if(empty($this->request->params['isAjax'])) { ?>
						  google.setOnLoadCallback(drawChart);
						  function drawChart() {
						  <?php } ?>
                            var data = google.visualization.arrayToDataTable([
                              ['Sources', 'Visits'],
                              <?php echo implode(',', $visit_by_sources_arr); ?>
                            ]);
                            var chart = new google.visualization.PieChart(document.getElementById('visit_by_sources_chart'));
                            chart.draw(data);
                          <?php if(empty($this->request->params['isAjax'])) { ?>
						  }
						  <?php } ?>
                        </script>
                         <div class="dc" id="visit_by_sources_chart" style="width: 600px; height: 400px;"></div>
                    </section>
                </div>
                <div class="span12">
                <?php
                    $select_range_id = (!empty($this->request->params['named']['select_range_id']))?$this->request->params['named']['select_range_id']:'lastDays';
                    echo $this->element('chart-admin_chart_visitors', array('select_range_id' => $select_range_id, 'from' => 'sources_chart', 'cache' => array('config' => 'site_element_cache_15_min')));
                ?>
                </div>
            </div>
			<section class="span24 dc">
			<h3><?php echo __l('Visits Per Country'); ?></h3>
				<?php
				$countries_arr = array();
				if(!empty($countries_stats->rows)){
				  foreach($countries_stats->rows as $countries):
					$countries_arr[] = '["' . $countries[0] . '", ' . $countries[1] . ']';
				  endforeach;
				  }
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
					var chart = new google.visualization.GeoChart(document.getElementById('countries_chart'));
					chart.draw(data);
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