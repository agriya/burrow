<div class="js-response js-cache-load-admin-charts-user-engagement">
 <div class="row-fluid ver-space">
	<div class="pull-left span5 dc ver-mspace ver-space"><h4 class="block-space pull-left textb mob-clr mob-no-pad"><?php echo __l('Users Engagement'); ?></h4></div>
	  <section class="span19 pull-left">
		<div class="row span24 show">
		  <div class="span5 dc space pr">
			 <div class="center-box easy-pie-chart percentage easyPieChart" data-color="#D23435" data-percent="<?php echo $this->Html->cFloat(($idle_users/$total_users) * 100, false); ?>" data-size="80">
					<span class="percent"><?php echo $this->Html->cInt($idle_users, false); ?></span>
			</div>
			<h5><?php echo __l('Idle'); ?></h5>
		  </div>
		  <div class="span5 dc space pr">
			<div class="center-box easy-pie-chart percentage easyPieChart" data-color="#9ABB30" data-percent="<?php echo $this->Html->cFloat(($posted_users/$total_users) * 100, false); ?>" data-size="80">
					<span class="percent"><?php echo $this->Html->cInt($posted_users, false); ?></span>
			</div>
			<h5><?php echo __l('Posted '); ?></h5>
		  </div>
		  <div class="span5 dc space pr">
			<div class="center-box easy-pie-chart percentage easyPieChart" data-color="#3C84BF" data-percent="<?php echo $this->Html->cFloat(($requested_users/$total_users) * 100, false); ?>" data-size="80">
					<span class="percent"><?php echo $this->Html->cInt($requested_users, false); ?></span>
			</div>
			<h5><?php echo __l('Requested '); ?></h5>
		  </div>
		  <div class="span5 dc space pr">
			<div class="center-box easy-pie-chart percentage easyPieChart" data-color="#CE59DE" data-percent="<?php echo $this->Html->cFloat(($booked_users/$total_users) * 100, false); ?>" data-size="80">
					<span class="percent"><?php echo $this->Html->cInt($booked_users, false); ?></span>
			</div>
			<h5><?php echo __l('Booked'); ?></h5>
		  </div>
		</div>
	  </section>
	</div>
</div>