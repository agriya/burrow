<div class="js-ecommerce js-cache-load-admin-ecommerce_chart">
  <div class="accordion-group">
    <div class="accordion-heading bootstro" data-bootstro-step="2" data-bootstro-content="<?php echo __l(" Ecommerce represents the total transactions made in the selected period and transaction revenue for the site. It shows the pie chart representation for revenue gather by which source and pie chart representation for revenue gather by which project type either pledge, donate, invest or lend.");?>" data-bootstro-width="600px" data-bootstro-title="Ecommerce">
      <div class="well no-pad no-mar no-bor clearfix box-head">
        <h5>
          <span class="space pull-left">
            <i class="icon-bar-chart no-bg"></i>
            <?php echo __l('Ecommerce'); ?>
          </span>
          <a class="accordion-toggle js-toggle-icon js-no-pjax grayc no-under clearfix pull-right" href="#ecommerce" data-parent="#accordion-admin-dashboard" data-toggle="collapse">
            <i class="icon-angle-up pull-right text-16 textb"></i>
          </a>
          <div class="dropdown pull-right ver-space">
            <a class="dropdown-toggle js-no-pjax js-overview grayc no-under" data-toggle="dropdown" href="#">
              <i class="icon-wrench no-pad"></i>
            </a>
            <ul class="dropdown-menu pull-right arrow arrow-right">
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastDays') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-ecommerce"}' title="<?php echo __l('Last 7 days'); ?>"  href="<?php echo Router::url('/', true)."admin/google_analytics/ecommerce_chart/select_range_id:lastDays";?>"><?php echo __l('Last 7 days'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastWeeks') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-ecommerce"}' title="<?php echo __l('Last 4 weeks'); ?>" href="<?php echo Router::url('/', true)."admin/google_analytics/ecommerce_chart/select_range_id:lastWeeks";?>"><?php echo __l('Last 4 weeks'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastMonths') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-ecommerce"}' title="<?php echo __l('Last 3 months'); ?>" href="<?php echo Router::url('/', true)."admin/google_analytics/ecommerce_chart/select_range_id:lastMonths";?>"><?php echo __l('Last 3 months'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastYears') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-ecommerce"}' title="<?php echo __l('Last 3 years'); ?>"  href="<?php echo Router::url('/', true)."admin/google_analytics/ecommerce_chart/select_range_id:lastYears";?>"><?php echo __l('Last 3 years'); ?></a> </li>
            </ul>
          </div>
        </h5>
      </div>
    </div>
	<?php $select_range_id = (!empty($this->request->params['named']['select_range_id']))?$this->request->params['named']['select_range_id']:'lastDays'; ?>
    <div id="ecommerce" class="accordion-body in collapse over-hide">
      <div class="accordion-inner">
	  <?php echo $this->element('chart-admin_ecommerce_transaction_chart', array('select_range_id' => $select_range_id, 'cache' => array('config' => 'site_element_cache_15_min'))); ?>
        <div class="row-fluid ver-space">
			<section class="span12 no-mar dc">
			<h3><?php echo __l("E-Commerce Per Source"); ?></h3>
				<?php
				$ecommerce_stats_arr = array();
				if(!empty($ecommerce_stats->rows)){
				  foreach($ecommerce_stats->rows as $ecommerce_stats):
					$ecommerce_stats_arr[] = '["' . $ecommerce_stats[0] . '", ' . $ecommerce_stats[1] . ']';
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
						<?php echo implode(',', $ecommerce_stats_arr); ?>
					]);
					var formatter = new google.visualization.NumberFormat({
						fractionDigits: 2,
						prefix: '$'
					});
					formatter.format(data, 1);
					var chart = new google.visualization.PieChart(document.getElementById('ecommerce_chart'));
					chart.draw(data);
				<?php if(empty($this->request->params['isAjax'])) { ?>
				  }
				<?php } ?>
				</script>
                <div class="dc" id="ecommerce_chart" style="width: 450px; height: 400px;"></div>
              </section>
			  <section class="span12 no-mar dc sep">
			  <h3><?php echo __l("E-Commerce Per Category"); ?></h3>
				<?php
				$ecommerce_stats_category_arr = array();
				if(!empty($ecommerce_stats_category->rows)){
				  foreach($ecommerce_stats_category->rows as $ecommerce_stats_category):
					$ecommerce_stats_category_arr[] = '["' . $ecommerce_stats_category[0] . '", ' . $ecommerce_stats_category[1] . ']';
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
						<?php echo implode(',', $ecommerce_stats_category_arr); ?>
					]);
					var formatter = new google.visualization.NumberFormat({
						fractionDigits: 2,
						prefix: '$'
					});
					formatter.format(data, 1);
					var chart = new google.visualization.PieChart(document.getElementById('ecommerce_chart_category'));
					chart.draw(data);
				   <?php if(empty($this->request->params['isAjax'])) { ?>
					}
				   <?php } ?>
				</script>
				<div class="dc" id="ecommerce_chart_category" style="width: 450px; height: 400px;"></div>
              </section>
        </div>
      </div>
    </div>
  </div>
</div>