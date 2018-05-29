<?php /* SVN: $Id: view.ctp 4973 2010-05-15 13:14:27Z aravindan_111act10 $ */ ?>
<h2 class="ver-space top-mspace text-32"><?php echo __l('Dashboard') ?></h2>
<div class="row no-mar">
    <div class="row ver-space bot-mspace mob-dc">
	  <div class="clearfix span bot-mspace tab-no-pad tab-clr">
	    <div class="thumb img-polaroid pull-left mob-inline">
	    	<?php
			echo $this->Html->getUserAvatar($user['User'], 'small_big_thumb', true); ?>
	  </div>
	  <div class="pull-left text-14 hor-space span6 no-mar">
	    <p class="graydarkc text-24 textb mob-text-24 bot-mspace show"><?php echo $this->Html->getUserLink($user['User']); ?></p>
		<?php if($this->Auth->sessionValid() && isPluginEnabled('Wallet')): ?>
		<dl class="top-mspace clearfix">
		  <dt class="bot-space span textn no-mar"><?php echo __l('Balance') ?></dt>
		  <dd class="bot-space span graydarkc textb">
			<?php 
			  $balance = $this->Html->getCurrUserInfo($this->Auth->user('id'));
			  echo $this->Html->siteCurrencyFormat($balance['User']['available_wallet_amount']);
			?>
		  </dd>
		</dl>
		<?php endif; ?>
		<?php if (isPluginEnabled('Wallet')) { ?>
		  <?php echo $this->Html->link(__l('Add Amount to Wallet'), array('controller' => 'wallets', 'action' => 'add_to_wallet', 'admin' => false), array('title' => __l('Add Amount to Wallet '),'class'=>'btn btn-large btn-primary text-14 textb pull-right mob-inline top-smspace'));?>
		<?php  } ?>
	  </div>
	  </div>
	  <div class="clearfix mob-clr pull-left left-space tab-clr">
		<div class="span hor-space sep-right">
		  <h3 class="textb text-24"><?php echo __l('Hosting') ?></h3>
		  <dl class="top-mspace clearfix">
			<dt class="bot-space span textn no-mar"><?php echo __l('Properties posted') ?></dt>
			<dd class="bot-space span graydarkc textb"><?php echo (!empty($host_all_count) ? $this->Html->cInt($host_all_count) : '0') ?></dd>
		  </dl>
		  <div class="clearfix">
			<dl class="sep-left sep-right list">
			  <dt class="pr hor-mspace text-11"><?php echo __l('Positive') ?></dt>
			  <dd title="234" class="textb text-20 graydarkc pr hor-mspace"><?php echo numbers_to_higher($user['User']['positive_feedback_count']); ?></dd>
			</dl>
			<dl class="sep-right list">
			  <dt class="pr hor-mspace text-11"><?php echo __l('Negative') ?></dt>
			  <dd title="689" class="textb text-20 graydarkc pr hor-mspace"><?php echo numbers_to_higher($user['User']['property_feedback_count'] - $user['User']['positive_feedback_count']); ?></dd>
			</dl>
			<dl class="list">
			  <dt class="pr hor-mspace text-11"><?php echo __l('Success Rate') ?></dt>
			  <?php if(empty($user['User']['property_feedback_count'])){ ?>
					<dd  class="textb text-16 no-mar graydarkc pr hor-space">n/a</dd>
			 <?php }else{ ?>
			  <dd class="textb text-20 graydarkc pr hor-mspace">
			    <?php if(!empty($user['User']['positive_feedback_count'])):
				  $positive = floor(($user['User']['positive_feedback_count']/$user['User']['property_feedback_count']) *100);
				  $negative = 100 - $positive;
				else:
				  $positive = 0;
				  $negative = 100;
				endif;
				echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=8DCA35|F47564&amp;chf=bg,s,FFFFFF00', array('width'=>'30px','height'=>'30px','title' => $positive.'%','class'=>'no-mar'));  ?>
			  </dd>
			  <?php } ?>
			</dl>
		  </div>
		</div>
		<div class="span left-space">
		  <h3 class="textb text-24"><?php echo __l('Traveling') ?></h3>
		  <dl class="clearfix top-mspace dc">
			<dt class="bot-space span no-mar textn"><?php echo __l('Requests Posted') ?></dt>
			<dd class="bot-space graydarkc textb span"><?php echo (!empty($user['User']['request_count']) ? $this->Html->cInt($user['User']['request_count']) : '0') ?></dd>
		  </dl>
		  <div class="clearfix">
			<dl class="dc sep-left sep-right list">
			  <dt class="pr hor-mspace text-11"><?php echo __l('Positive') ?></dt>
			  <dd title="234" class="textb text-20 graydarkc pr hor-mspace"><?php echo numbers_to_higher($user['User']['traveler_positive_feedback_count']); ?></dd>
			</dl>
			<dl class="sep-right list">
			  <dt class="pr hor-mspace text-11"><?php echo __l('Negative') ?></dt>
			  <dd title="689" class="textb text-20 graydarkc pr hor-mspace"><?php echo numbers_to_higher($user['User']['traveler_property_user_count'] - $user['User']['traveler_positive_feedback_count']); ?></dd>
			</dl>
			<dl class="list">
			  <dt class="pr hor-mspace text-11"><?php echo __l('Success Rate') ?></dt>
			  <?php if(empty($user['User']['traveler_positive_feedback_count'])){ ?>
					<dd  class="textb text-16 no-mar graydarkc pr hor-space">n/a</dd>
			 <?php }else{ ?>
			  <dd class="textb text-20 graydarkc pr hor-mspace">
			    <?php if(!empty($user['User']['traveler_positive_feedback_count'])):
				  $positive = floor(($user['User']['traveler_positive_feedback_count']/$user['User']['traveler_property_user_count']) *100);
				  $negative = 100 - $positive;
				else:
				  $positive = 0;
				  $negative = 100;
				endif;
				echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=8DCA35|F47564&amp;chf=bg,s,FFFFFF00', array('width'=>'30px','height'=>'30px','title' => $positive.'%')); ?>
			  </dd>
			  <?php } ?>
			</dl>
		  </div>
		</div>
		 <?php echo $this->element('sidebar', array('config' => 'sec'));?>
	  </div>
	</div>
  <?php echo $this->element('dashboard_tabs', array('config' => 'sec')); ?>
</div>
