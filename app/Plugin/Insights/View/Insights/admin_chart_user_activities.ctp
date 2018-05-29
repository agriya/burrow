<div class="js-user-activities js-cache-load-admin-charts-user-activities">
  <div class="accordion-group">
    <?php
      $role_id = $this->request->data['Chart']['role_id'];
      $collapse_class = 'in';
      if ($this->request->params['isAjax']) {
        $collapse_class ="in";
      }
    ?>
    <div class="accordion-heading">
      <div class="well no-pad no-mar no-bor clearfix box-head">
        <h5 class="pull-left">
          <span class="space pull-left">
            <i class="icon-bar-chart no-bg"></i>
            <?php echo __l('Activities')  ?>
          </span>
		  </h5>
		  <div class="pull-right span3">
          <a class="accordion-toggle js-toggle-icon js-no-pjax grayc no-under clearfix pull-right" href="#userActivities" data-parent="#accordion-admin-dashboard" data-toggle="collapse">
             <i class="icon-angle-up text-16 textb"></i>
          </a>
          <div class="dropdown pull-right ver-space">
            <a class="dropdown-toggle js-no-pjax js-overview grayc no-under" data-toggle="dropdown" href="#">
              <i class="icon-wrench no-pad"></i>
            </a>
            <ul class="dropdown-menu pull-right arrow arrow-right">
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastDays') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-user-activities"}' title="<?php echo __l('Last 7 days'); ?>"  href="<?php echo Router::url('/', true)."admin/insights/chart_user_activities/select_range_id:lastDays";?>"><?php echo __l('Last 7 days'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastWeeks') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-user-activities"}' title="<?php echo __l('Last 4 weeks'); ?>" href="<?php echo Router::url('/', true)."admin/insights/chart_user_activities/select_range_id:lastWeeks";?>"><?php echo __l('Last 4 weeks'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastMonths') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-user-activities"}' title="<?php echo __l('Last 3 months'); ?>" href="<?php echo Router::url('/', true)."admin/insights/chart_user_activities/select_range_id:lastMonths";?>"><?php echo __l('Last 3 months'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastYears') ? ' class="active"' : ''; ?>><a class='js-link {"data_load":"js-user-activities"}' title="<?php echo __l('Last 3 years'); ?>"  href="<?php echo Router::url('/', true)."admin/insights/chart_user_activities/select_range_id:lastYears";?>"><?php echo __l('Last 3 years'); ?></a> </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div id="userActivities" class="accordion-body collapse over-hide <?php echo $collapse_class;?>">
      <div class="accordion-inner">
        <div class="row-fluid ver-space" id="userfollower">
		  <?php
		  if(isPluginEnabled('SocialMarketing')) {
			  $chart_title = __l('User Followers');
			  $chart_y_title = __l('Users');
			  $div_class = "js-load-column-chart";
			  ?>
			  <section class="span12 no-mar">
				  <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'user_activities_chart_data', 'chart_container':'user_activities_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
					<div class="clearfix">
					  <div id="user_activities_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
					  <div class="hide">
						<table id="user_activities_chart_data" class="table table-striped table-bordered table-condensed">
						  <tbody>
							<?php foreach($user_follow_data as $key => $_data): ?>
							  <tr>
								<th><?php echo $key; ?></th>
								<td><?php echo $_data[0]; ?></td>
							  </tr>
							<?php endforeach; ?>
						  </tbody>
						</table>
					  </div>
					</div>
				  </div>
			  </section>
          <?php }
		  if(isPluginEnabled('PropertyFlags')) {
			  $chart_title = __l('Property Flags');
			  $chart_y_title = __l('Property Flags'); ?>
			  <section class="span12 sep-left no-mar">
				  <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'property_flags_data', 'chart_container':'property_flags_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
				  <div class="clearfix">
					<div id="property_flags_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
					<div class="hide">
					 <table id="property_flags_data" class="table table-striped table-bordered table-condensed">
						<tbody>
						  <?php foreach($property_flags_data as $key => $_data): ?>
						  <tr>
							 <th><?php echo $key; ?></th>
							 <td><?php echo $_data[0]; ?></td>
						  </tr>
						  <?php endforeach; ?>
						</tbody>
						</table>
					</div>
				  </div>
				</div>
			  </section>
		  <?php } ?>
        </div>
		<div class="row-fluid ver-space" id="propertyFavorites">
		  <?php if(isPluginEnabled('PropertyFavorites')) {
				  $chart_title = __l('Property Favorites');
			  $chart_y_title = __l('Property Favorites'); ?>
			  <section class="span12">
				  <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'property_favorites_data', 'chart_container':'property_favorites_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
				  <div class="clearfix">
					<div id="property_favorites_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
					<div class="hide">
					 <table id="property_favorites_data" class="table table-striped table-bordered table-condensed">
						<tbody>
						  <?php foreach($property_favorites_data as $key => $_data): ?>
						  <tr>
							 <th><?php echo $key; ?></th>
							 <td><?php echo $_data[0]; ?></td>
						  </tr>
						  <?php endforeach; ?>
						</tbody>
						</table>
					</div>
				  </div>
				</div>
			  </section>
		  <?php }
		  if(isPluginEnabled('RequestFavorites')) { ?>
			  <?php $chart_title = __l('Request Favorites');
			  $chart_y_title = __l('RequestFavorites'); ?>
			  <section class="span12 sep-left no-mar">
				  <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'request_favorite_data', 'chart_container':'request_favorite_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
				  <div class="clearfix">
					<div id="request_favorite_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
					<div class="hide">
					 <table id="request_favorite_data" class="table table-striped table-bordered table-condensed">
						<tbody>
						  <?php foreach($request_favorite_data as $key => $_data): ?>
						  <tr>
							 <th><?php echo $key; ?></th>
							 <td><?php echo $_data[0]; ?></td>
						  </tr>
						  <?php endforeach; ?>
						</tbody>
					  </table>
					</div>
				  </div>
				</div>
			  </section>
		  <?php } ?>
        </div>
		<?php if(isPluginEnabled('RequestFlags')) { ?>
			<div class="row-fluid ver-space" id="requestFlags">
			  <?php $chart_title = __l('Request Flags');
			  $chart_y_title = __l('Request Flags'); ?>
			  <section class="span12">
				  <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'request_flag_data', 'chart_container':'request_flag_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
				  <div class="clearfix">
					<div id="request_flag_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
					<div class="hide">
					 <table id="request_flag_data" class="table table-striped table-bordered table-condensed">
						<tbody>
						  <?php foreach($request_flag_data as $key => $_data): ?>
						  <tr>
							 <th><?php echo $key; ?></th>
							 <td><?php echo $_data[0]; ?></td>
						  </tr>
						  <?php endforeach; ?>
						</tbody>
						</table>
					</div>
				  </div>
				</div>
			  </section>
			</div>
		<?php } ?>
      </div>
    </div>
  </div>
</div>