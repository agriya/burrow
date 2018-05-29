<?php
	$class = " admin-dashboard-chart";
	$class_edu = " admin-dashboard-edu-chart";
?>
<?php if(!empty($chart_pie_education_data)): ?>
	<div class="js-load-pie-chart  chart-half-section {'data_container':'user_pie_education_data<?php echo $role_id; ?>', 'chart_container':'user_pie_education_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo __l('Education');?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
		<div class="dashboard-tl">
			<div class="dashboard-tr">
				<div class="dashboard-tc"></div>
			</div>
		</div>
		<div class="dashboard-cl">
			<div class="dashboard-cr">
				<div class="dashboard-cc clearfix">
					<div id="user_pie_education_chart<?php echo $role_id; ?>" class="<?php echo $class_edu; ?>"></div>
					<div class="hide">
						<table id="user_pie_education_data<?php echo $role_id; ?>" class="list">
							<tbody>
								<?php foreach($chart_pie_education_data as $display_name => $val): ?>
								<tr>
								   <th><?php echo $display_name; ?></th>
								   <td><?php echo $val; ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="dashboard-bl">
				<div class="dashboard-br">
					<div class="dashboard-bc"></div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php if(!empty($chart_pie_relationship_data)): ?>
	<div class="js-load-pie-chart  chart-half-section {'data_container':'user_pie_relationship_data<?php echo $role_id; ?>', 'chart_container':'user_pie_relationship_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo __l('Relationship');?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
		<div class="dashboard-tl">
			<div class="dashboard-tr">
				<div class="dashboard-tc"></div>
			</div>
		</div>
		<div class="dashboard-cl">
			<div class="dashboard-cr">
				<div class="dashboard-cc clearfix">
					<div id="user_pie_relationship_chart<?php echo $role_id; ?>" class="<?php echo $class_edu; ?>"></div>
					<div class="hide">
						<table id="user_pie_relationship_data<?php echo $role_id; ?>" class="list">
							<tbody>
								<?php foreach($chart_pie_relationship_data as $display_name => $val): ?>
								<tr>
								   <th><?php echo $display_name; ?></th>
								   <td><?php echo $val; ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="dashboard-bl">
				<div class="dashboard-br">
					<div class="dashboard-bc"></div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php if(!empty($chart_pie_employment_data)): ?>
	<div class="js-load-pie-chart  chart-half-section {'data_container':'user_pie_employment_data<?php echo $role_id; ?>', 'chart_container':'user_pie_employment_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo __l('Employment');?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
		<div class="dashboard-tl">
			<div class="dashboard-tr">
				<div class="dashboard-tc"></div>
			</div>
		</div>
		<div class="dashboard-cl">
			<div class="dashboard-cr">
				<div class="dashboard-cc clearfix">
					<div id="user_pie_employment_chart<?php echo $role_id; ?>" class="<?php echo $class_edu; ?>"></div>
					<div class="hide">
						<table id="user_pie_employment_data<?php echo $role_id; ?>" class="list">
							<tbody>
								<?php foreach($chart_pie_employment_data as $display_name => $val): ?>
								<tr>
								   <th><?php echo $display_name; ?></th>
								   <td><?php echo $val; ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="dashboard-bl">
				<div class="dashboard-br">
					<div class="dashboard-bc"></div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php if(!empty($chart_pie_income_data)): ?>
	<div class="js-load-pie-chart  chart-half-section {'data_container':'user_pie_income_data<?php echo $role_id; ?>', 'chart_container':'user_pie_income_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo __l('Income');?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
		<div class="dashboard-tl">
			<div class="dashboard-tr">
				<div class="dashboard-tc"></div>
			</div>
		</div>
		<div class="dashboard-cl">
			<div class="dashboard-cr">
				<div class="dashboard-cc clearfix">
				        	<div id="user_pie_income_chart<?php echo $role_id; ?>" class="<?php echo $class_edu; ?>"></div>
					<div class="hide">
						<table id="user_pie_income_data<?php echo $role_id; ?>" class="list">
							<tbody>
								<?php foreach($chart_pie_income_data as $display_name => $val): ?>
								<tr>
								   <th><?php echo $display_name; ?></th>
								   <td><?php echo $val; ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="dashboard-bl">
				<div class="dashboard-br">
					<div class="dashboard-bc"></div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php if(!empty($chart_pie_gender_data)): ?>
	<div class="js-load-pie-chart  chart-half-section {'data_container':'user_pie_gender_data<?php echo $role_id; ?>', 'chart_container':'user_pie_gender_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo __l('Gender');?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
		<div class="dashboard-tl">
			<div class="dashboard-tr">
				<div class="dashboard-tc"></div>
			</div>
		</div>
		<div class="dashboard-cl">
			<div class="dashboard-cr">
				<div class="dashboard-cc clearfix">
					<div id="user_pie_gender_chart<?php echo $role_id; ?>" class="<?php echo $class; ?>"></div>
					<div class="hide">
						<table id="user_pie_gender_data<?php echo $role_id; ?>" class="list">
							<tbody>
								<?php foreach($chart_pie_gender_data as $display_name => $val): ?>
								<tr>
								   <th><?php echo $display_name; ?></th>
								   <td><?php echo $val; ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="dashboard-bl">
				<div class="dashboard-br">
					<div class="dashboard-bc"></div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php if(!empty($chart_pie_age_data)): ?>
	<div class="js-load-pie-chart  chart-half-section {'data_container':'user_pie_age_data<?php echo $role_id; ?>', 'chart_container':'user_pie_age_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo __l('Age');?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
		<div class="dashboard-tl">
			<div class="dashboard-tr">
				<div class="dashboard-tc"></div>
			</div>
		</div>
		<div class="dashboard-cl">
			<div class="dashboard-cr">
				<div class="dashboard-cc clearfix">
					<div id="user_pie_age_chart<?php echo $role_id; ?>" class="<?php echo $class; ?>"></div>
					<div class="hide">
						<table id="user_pie_age_data<?php echo $role_id; ?>" class="list">
							<tbody>
								<?php foreach($chart_pie_age_data as $display_name => $val): ?>
								<tr>
								   <th><?php echo $display_name; ?></th>
								   <td><?php echo $val; ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="dashboard-bl">
			<div class="dashboard-br">
				<div class="dashboard-bc"></div>
			</div>
		</div>
	</div>
<?php endif; ?>