<section class="row no-mar bot-space" id="ajax-tab-dashboard-user">
          <ul id="Tab" class="nav nav-tabs top-space top-mspace">
            <li><a href="#Dashboard" data-toggle="tab"><?php echo __l('Dashboard'); ?></a> </li>
			<li><?php echo $this->Html->link(__l('Liked Properties'), array('controller' => 'properties', 'action' => 'index', 'type'=>'favorite','admin' => false), array('tabindex' => '-1','title' => __l('Liked Properties'), 'class' => 'js-no-pjax', 'data-target'=>'#Liked-Properties'));?></li>
            <?php if(isPluginEnabled("Requests")) : ?> <li><?php echo $this->Html->link(__l('Liked Requests'), array('controller' => 'requests', 'action' => 'index', 'type'=>'favorite','admin' => false), array('tabindex' => '-1','title' => __l('Liked Properties'), 'class' => 'js-no-pjax', 'data-target'=>'#Liked-Request'));?></li> <?php endif; ?>
            <li><?php echo $this->Html->link(__l('My Properties'), array('controller' => 'properties', 'action' => 'index', 'type'=>'myproperties','admin' => false), array('tabindex' => '-1','title' => __l('My Properties'),'data-target'=>'#My-Properties', 'class' => 'js-no-pjax', 'data-toggle'=>'tab'));?>
			</li>
			 <?php if(isPluginEnabled("Requests")) : ?><li><?php echo $this->Html->link(__l('My Requests'), array('controller' => 'requests', 'action' => 'index', 'type'=>'myrequest','status' =>'active','admin' => false), array('tabindex' => '-1', 'class' => 'js-no-pjax', 'title' => __l('My Requests'),'data-target'=>'#My-Requests','data-toggle'=>'tab'));?></li> <?php endif; ?>
			 
            <li>
			<?php echo $this->Html->link(__l('Trips'), array('controller'=> 'property_users', 'action'=>'index', 'type'=>'mytours','status' => 'in_progress', 'admin' => false), array('title' => __l('Trips'), 'escape' => false,'data-target'=>'#Trip', 'class' => 'js-no-pjax', 'data-toggle'=>'tab'));?>
			</li>
          </ul>
		<div class="sep-right sep-left bot-mspace sep-bot tab-round tab-content" id="TabContent">
            <div class="tab-pane  space mspace" id="Dashboard">
				<h3 class="well space textb text-16 no-mar"><?php echo __l('Revenue');?></h3>
				<div class="row dr text-16 graydarkc ver-space ver-mspace"><?php echo __l('Total Earned'). ': '; ?> <span class="redc"><?php echo $this->Html->siteCurrencyFormat($user['User']['host_total_earned_amount']);?></span></div>
				<?php
					echo $this->element('users-hosting_panel', array('user_id' => $this->Auth->user('id'),'config' => 'sec'));
				?>
				<h3 class="well space textb text-16 no-mar"><?php echo __l('Reservation');?></h3>
				<div class="row dc ver-space ver-mspace">
					  <div class="span5 dc space pr">
						 <div class="center-box easy-pie-chart percentage easyPieChart" data-color="#D23435" data-percent="<?php echo !empty($host_all_count)?100:0; ?>" data-size="80">
								<span class="percent textb text-14" style="color:#D23435"><?php echo $this->Html->cInt($host_all_count, false); ?></span>
						</div>
						<h5><?php echo $this->Html->link(__l('All'), array('controller' => 'property_users', 'action' => 'index','type'=>'myworks', 'status' => 'all', 'admin' => false), array('escape' => false,  'title' => __l('All'), 'class' => 'grayc')); ?></h5>					
					  </div>
					  
				<?php 
					$colors = array('#828214', '#F49B00', '#FF0B89', '#8B65D6', '#49A7FF', '#FD66B5', '#DF5958', '#A5A5A5', '#B371AF', '#828214');
					$i = 0;
					foreach($host_moreActions as $host_key => $host_value):	
						$host_class_name = "";
						list($host_slug, $host_cnt,$host_class_name) = $host_value;
						$average = ($host_all_count != 0) ? ceil(($host_cnt / $host_all_count) * 100) : 0; 
						$host_count_list[] = $this->Html->cInt($host_cnt, false);
						$host_name_list[] = $host_key;
						$host_links[] = '<li> <span class="' . $host_class_name . '">' . $this->Html->link($host_key . ': ' . $this->Html->cInt($host_cnt), array('controller' => 'property_users', 'action' => 'index','type'=>'myworks','status' => $host_slug,'admin' => false), array( 'title' => $host_key, 'escape' => false))."</span> </li>";
				?>  
					  <div class="span5 dc htruncate space pr">
						 <div class="center-box easy-pie-chart percentage easyPieChart" data-color="<?php echo $colors[$i]; ?>" data-percent="<?php echo $this->Html->cInt($average, false); ?>" data-size="80">
								<span class="percent textb text-14" style="color:<?php echo $colors[$i]; ?>"><?php echo $this->Html->cInt($host_cnt, false); ?></span>
						</div>
						<h5><?php echo $this->Html->link($host_key, array('controller' => 'property_users', 'action' => 'index','type'=>'myworks','status' => $host_slug,'admin' => false), array( 'title' => $host_key, 'escape' => false, 'class' => 'grayc')); ?></h5>
					  </div>
				<?php 
					$i++;
					endforeach; ?>	  

					<div class="span5 dc space pr">
						<?php
							$host_count_display = implode(',', $host_count_list);
							$host_name_display = implode('|', $host_name_list);
							$host_color_list = '828214|F49B00|FF0B89|8B65D6|49A7FF|FD66B5|DF5958|A5A5A5|B371AF|828214';
							echo $this->Html->image('https://chart.googleapis.com/chart?cht=p&amp;chs=110x110&amp;chd=t:'.$host_count_display.'&amp;chco=' . $host_color_list  . '&amp;chf=bg,s,FFFFFF00', array('title' => 'Reservation chart'));
						?>
					</div>
				</div>
				<h3 class="well space textb text-16 no-mar"><?php echo __l('Booked Trips');?></h3>
				<div class="row dc ver-space ver-mspace">
					  <div class="span5 dc space pr">
						 <div class="center-box easy-pie-chart percentage easyPieChart" data-color="#D23435" data-percent="<?php echo !empty($all_count)?100:0; ?>" data-size="80">
								<span class="percent textb text-14" style="color:#D23435"><?php echo $this->Html->cInt($all_count, false); ?></span>
						</div>
						<h5><?php echo $this->Html->link(__l('All'), array('controller' => 'property_users', 'action' => 'index','type'=>'mytours', 'status' => 'all', 'admin' => false), array('escape' => false,  'title' => __l('All'), 'class' => 'grayc')); ?></h5>
					  </div>
					  
				<?php 
					$colors = array('#828214', '#6DC699', '#49A7FF', '#FF0B89', '#8B65D6', '#FD66B5', '#DF5958', '#A5A5A5', '#B371AF', '#EF5212');
					$i = 0;
					foreach($moreActions as $key => $value):
						$class_name = "";
						list($slug, $cnt,$class_name) = $value;
						$average = ($all_count != 0) ? ceil(($cnt / $all_count) * 100) : 0; 
						$count_list[] = $this->Html->cInt($cnt, false);
						$name_list[] = $key;	
						$links[] = '<li><span class="' . $class_name . '">' . $this->Html->link($key . ': ' . $this->Html->cInt($cnt), array('controller' => 'property_users', 'action' => 'index','type'=>'mytours','status' => $slug, 'view' => 'list','admin' => false), array( 'title' => $key, 'escape' => false))."</span></li>";
				?>  
					  <div class="span5 dc htruncate space pr">
						 <div class="center-box easy-pie-chart percentage easyPieChart" data-color="<?php echo $colors[$i]; ?>" data-percent="<?php echo $this->Html->cInt($average, false); ?>" data-size="80">
								<span class="percent textb text-14" style="color:<?php echo $colors[$i]; ?>"><?php echo $this->Html->cInt($cnt, false); ?></span>
						</div>
						<h5><?php echo $this->Html->link($key, array('controller' => 'property_users', 'action' => 'index','type'=>'mytours','status' => $slug, 'view' => 'list','admin' => false), array( 'title' => $key, 'escape' => false, 'class' => 'grayc')); ?></h5>
					  </div>
				<?php 
					$i++;
					endforeach; ?>	  			
				<div class="span5 dc space pr">
						<?php
							$count_display = implode(',', $count_list);
							$name_display = implode('|', $name_list);
							$color_list = '828214|6DC699|49A7FF|FF0B89|8B65D6|FD66B5|DF5958|A5A5A5|B371AF|EF5212';
							echo $this->Html->image('https://chart.googleapis.com/chart?cht=p&amp;chs=110x110&amp;chd=t:'.$count_display.'&amp;chco=' . $color_list . '&amp;chf=bg,s,FFFFFF00', array('title' => 'Trips chart' ));
						?>
				</div>
			</div>
			</div>
			<div class="tab-pane " id="Liked-Properties"></div>
			<div class="tab-pane " id="Liked-Request"></div>
			<div class="tab-pane " id="My-Properties"></div>
			<div class="tab-pane " id="My-Requests"></div>
			<div class="tab-pane " id="Trip"></div>
		</div>
</section>