<div class="clearfix mob-clr pull-right top-space tab-clr top-mspace">
<div class="span6 tab-clr top-mspace right-space sep-right">
  <h3 class="textb top-space top-mspace text-24"><?php echo __l('As Host'); ?></h3>
  <dl class="top-mspace sep-bot clearfix">
	<dt class="bot-space span textn no-mar"><?php echo __l('Properties posted'); ?></dt>
	<dd class="bot-space span graydarkc textb"><?php echo $this->Html->cInt($user['User']['property_count']);?></dd>
  </dl>
  <div class="top-space clearfix">
	<dl class="sep-left dc sep-right list">
	  <dt class="pr hor-mspace text-11"><?php echo __l('Positive');?></dt>
	  <dd class="textb text-20 no-mar graydarkc pr hor-mspace"><?php echo numbers_to_higher($user['User']['positive_feedback_count']); ?></dd>
	</dl>
	<dl class="dc sep-right list">
	  <dt class="pr hor-mspace text-11"><?php echo __l('Negative');?></dt>
	  <dd class="textb text-20 no-mar graydarkc pr hor-mspace"><?php echo numbers_to_higher($user['User']['property_feedback_count'] - $user['User']['positive_feedback_count']); ?></dd>
	</dl>
	<dl class="dc  list">
	  <dt class="pr hor-smspace text-11"><?php echo __l('Success Rate'); ?></dt>
		<?php if(($user['User']['property_feedback_count']) == 0): ?>
			<dd class="textb text-20 no-mar graydarkc pr hor-mspace" title="n/a">n/a</dd>
		<?php else: ?>
			<dd class="textb text-20 no-mar graydarkc pr hor-mspace"><span class="stats-val">
		<?php	if(!empty($user['User']['positive_feedback_count'])):
				$positive = floor(($user['User']['positive_feedback_count']/$user['User']['property_feedback_count']) *100);
				$negative = 100 - $positive;
				else:
					$positive = 0;
					$negative = 100;
				endif;
				
				echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=8DCA35|F47564&amp;chf=bg,s,FFFFFF00', array('width'=>'35px','height'=>'35px','title' => $positive.'%')); ?></span>
		</dd>
		<?php endif;?> 
	</dl>
  </div>
</div>
<?php if(isPluginEnabled('Requests')) :?>
<div class="span6 tab-clr top-mspace left-space">
  <h3 class="textb top-space top-mspace text-24"><?php echo __l('As Traveler'); ?></h3>
  <dl class="clearfix top-mspace dc sep-bot">
	<dt class="bot-space span no-mar textn"><?php echo __l('Requests Posted'); ?></dt>
	<dd class="bot-space graydarkc textb span"><?php echo $this->Html->cInt($user['User']['request_count']);?></dd>
  </dl>
  <div class="top-space clearfix">
	<dl class="dc list">
	  <dt class="pr hor-mspace text-11"><?php echo __l('Positive');?></dt>
	  <dd class="textb text-20 no-mar graydarkc pr hor-mspace"><?php echo numbers_to_higher($user['User']['traveler_positive_feedback_count']); ?></dd>
	</dl>
	<dl class="dc sep-right list">
	  <dt class="pr hor-mspace text-11"><?php echo __l('Negative');?></dt>
	  <dd class="textb text-20 no-mar graydarkc pr hor-mspace" ><?php echo numbers_to_higher($user['User']['traveler_property_user_count'] - $user['User']['traveler_positive_feedback_count']); ?></dd>
	</dl>
	<dl class="dc  list">
	  <dt class="pr hor-smspace text-11"><?php echo __l('Success Rate'); ?></dt>
	  <?php if(($user['User']['traveler_property_user_count']) == 0): ?>
		<dd class="textb text-20 no-mar graydarkc pr hor-mspace" title="n/a">n/a</dd>
	   <?php else: ?>
	   <dd class="textb text-20 no-mar graydarkc pr hor-mspace"><span class="stats-val">
		<?php if(!empty($user['User']['traveler_positive_feedback_count'])):
					$positive = floor(($user['User']['traveler_positive_feedback_count']/$user['User']['traveler_property_user_count']) *100);
					$negative = 100 - $positive;
				else:
					$positive = 0;
					$negative = 100;
				endif;
					echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=8DCA35|F47564&amp;chf=bg,s,FFFFFF00', array('width'=>'35px','height'=>'35px','title' => $positive.'%')); ?>
			</span>
		</dd>
		<?php endif; ?>
	</dl>
  </div>
</div>
<?php endif; ?>
</div>