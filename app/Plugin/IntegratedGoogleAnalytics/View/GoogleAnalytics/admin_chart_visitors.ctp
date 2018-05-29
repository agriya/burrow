          <section class="span13 pull-left js-cache-load-admin-chart-visitors sep-right">
            <div class="row-fluid">
              <div class="span no-mar">
              <?php if (!empty($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'sources_chart') { ?>
                <h3><?php echo __l("Visits & New Visits"); ?></h3>
              <?php } ?>
                <script type="text/javascript">
                    <?php if(empty($this->request->params['isAjax'])) { ?>
                        google.setOnLoadCallback(drawChart);
                        function drawChart() {
                    <?php } ?>
                    var data = google.visualization.arrayToDataTable([
                      ['Date', 'Visits', 'New Visits'],
                      <?php echo $visits_vs_newvisits; ?>
                    ]);
                    <?php if (!empty($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'chart_metrics') { ?>
                        var options = {
                          title: '<?php echo __l("Visits & New Visits"); ?>'
                        };
                    <?php } ?>
                    var chart = new google.visualization.LineChart(document.getElementById('visits_vs_newvisits_chart'));
                    <?php if (!empty($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'chart_metrics') { $width = '100%'; $height = '200px'; ?>
                    chart.draw(data, options);
                    <?php } else { $width = '600px'; $height = '400px'; ?>
                    chart.draw(data);
                    <?php } ?>
                    <?php if(empty($this->request->params['isAjax'])) { ?>
                        }
                    <?php } ?>
                </script>
                <div class="dc" id="visits_vs_newvisits_chart" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>;"></div>
              </div>
             </div>
           </section>
		   <?php
		   if(!empty($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'chart_metrics') {?>
		   <section class="span10 hor-space hor-mspace">
		   <h4 class="bot-mspace textb"><?php echo  __l('Recent activity');?></h4>
		   <?php echo $this->element('admin-activities-compact-view', array('type' => 'compact')); ?>
		   <div class="pull-right">
				<?php echo $this->Html->link(__l('More'), array('controller' => 'messages', 'action' => 'notifications', 'type' => 'list'), array('class' => 'btn js-bootstrap-tooltip', 'title' => __l('More'), 'escape' => false));?>
		    </div>
		   </section>
		   <?php } ?>
