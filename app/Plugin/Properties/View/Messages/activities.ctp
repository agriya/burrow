<ul class="breadcrumb top-mspace top-space" itemprop="breadcrumb">
          <li><?php echo $this->Html->link($this->Html->cText($orders['Property']['title']), array('controller' => 'properties', 'action' => 'view', $orders['Property']['slug'], 'admin' => false), array('target' => '_blank', 'title' => $this->Html->cText($orders['Property']['title'], false),'escape' => false));?> <span class="divider graydarkc">/</span></li>
          <li><a class="active blackc" href="javascript:void(0);" title="<?php echo __l('Activities'); ?>"> <?php echo __l('Activities'); ?></a></li>
        </ul>
<ol class="unstyled no-mar">
	<li class="clearfix">
<?php echo $this->element('booking_guideline', array('config' => 'sec')); ?>
<?php echo !empty($orders) ? $this->element('properties-simple-view', array('slug' => $orders['Property']['slug'], 'order_id' => $orders['PropertyUser']['id'], 'config' => 'sec')) : ''; ?>
            <div class="clearfix pull-left top-mspace mob-clr">
              <dl class="sep-right list ">
                <dt class="pr hor-mspace text-11"><?php echo __l('Made On');?></dt>
                <dd class="textb text-16  graydarkc pr hor-mspace" title="<?php echo $this->Html->cDateTimeHighlight($orders['PropertyUser']['created'], false);?>"><?php echo $this->Html->cDateTimeHighlight($orders['PropertyUser']['created']);?></dd>
              </dl>
              <dl class="sep-right list">
                <dt class="pr hor-mspace text-11"><?php echo __l('Completed?');?></dt>
                <dd class="textb text-16r graydarkc pr hor-mspace" title="<?php echo (!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Completed) ? __l('Yes'): __l('No');?>"><?php echo (!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Completed) ? __l('Yes'): __l('No');?></dd>
              </dl>
			  <?php if($orders['PropertyUser']['owner_user_id'] == $this->Auth->user('id')):?>
              <dl class="sep-right list">
                <dt class="pr hor-mspace text-11"><?php echo __l('Discount'). ' ('.$orders['PropertyUser']['negotiation_discount'].'%)';?></dt>
                <dd class="textb text-16  graydarkc pr hor-mspace" title="<?php echo $this->Html->siteCurrencyFormat($orders['PropertyUser']['negotiate_amount'], false);?>"><?php echo $this->Html->siteCurrencyFormat($orders['PropertyUser']['negotiate_amount']);?></dd>
              </dl>
              <dl class="sep-right list">
                <dt class="pr hor-mspace text-11"><?php echo __l('Gross Amount');?></dt>
                <dd class="textb text-16 graydarkc pr hor-mspace" title="<?php echo $this->Html->siteCurrencyFormat($orders['PropertyUser']['price'] - $orders['PropertyUser']['host_service_amount'], false);?>"><?php echo $this->Html->siteCurrencyFormat($orders['PropertyUser']['price'] - $orders['PropertyUser']['host_service_amount']);?></dd>
              </dl>
			  <?php else: ?>
              <dl class="sep-right list">
                <dt class="pr hor-mspace text-11"><?php echo __l('Discount'). ' ('.$orders['PropertyUser']['negotiation_discount'].'%)';?></dt>
                <dd class="textb text-16  graydarkc pr hor-mspace" title="<?php echo $this->Html->siteCurrencyFormat($orders['PropertyUser']['negotiate_amount'], false);?>"><?php echo $this->Html->siteCurrencyFormat($orders['PropertyUser']['negotiate_amount']);?></dd>
              </dl>
              <dl class="sep-right list">
                <dt class="pr hor-mspace text-11"><?php echo __l('Gross Amount');?></dt>
                <dd class="textb text-16 graydarkc pr hor-mspace" title="<?php echo $this->Html->siteCurrencyFormat($orders['PropertyUser']['price'] + $orders['PropertyUser']['traveler_service_amount'], false);?>"><?php echo $this->Html->siteCurrencyFormat($orders['PropertyUser']['price'] + $orders['PropertyUser']['traveler_service_amount']);?></dd>
              </dl>
			  <?php endif; ?>
              <dl class="sep-right list">
                <dt class="pr mob-clr hor-mspace text-11"><?php echo __l('Current Status');?></dt>
				
<?php 			$status = "";
				if(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Completed):
					$status = __l('Completed');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance):
					$status = __l('Waiting for Acceptance');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed):
					$status = __l('Confirmed');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Rejected):
					$status = __l('Rejected');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Canceled):
					$status = __l('Canceled');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived):
					$status = __l('Arrived');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentCleared):
					$status = __l('Payment Cleared');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Expired):
					$status = __l('Expired');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::CanceledByAdmin):
					$status = __l('Canceled By Admin');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentPending):
					$status = __l('Payment Pending');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::AdminDisputeConversation):
					$status = __l('Admin Dispute Conversation');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::DisputeAdminAction):
					$status = __l('Admin Dispute Action');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WorkReviewed):
					$status = __l('Work Reviewed');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WorkDelivered):
					$status = __l('Work Delivered');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::DisputeClosedTemp):
					$status = __l('Dispute closed temporarily');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::DisputeClosed):
					$status = __l('Dispute Closed');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::DisputeConversation):
					$status = __l('Distpute Conversation');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::DisputeOpened):
					$status = __l('Dispute Opened');
				elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::SenderNotification):
					$status = __l('Sender Notification');
				endif;	?>				
                <dd class="textb text-16  graydarkc pr hor-mspace" title="<?php echo $status; ?>">
					<?php echo $status; ?>				
				</dd>
              </dl>
			<?php if($orders['PropertyUser']['owner_user_id'] == $this->Auth->user('id')):?>
              <dl class="list sep-right">
                <dt class="pr hor-mspace text-11"><?php echo __l('Traveler name');?></dt>
                <dd class="textb text-16 mob-inline graydarkc pr hor-mspace"><span class="htruncate width75 pull-left"><?php  echo $this->Html->link($orders['User']['username'], array('controller' => 'users', 'action' => 'view', $orders['User']['username'], 'admin' => false), array('title' => $orders['User']['username'],'class'=>'graydarkc js-bootstrap-tooltip'));?></span> <span class="pull-left show"> (<?php  echo $this->Html->link(__l('Contact Traveler'), array('controller' => 'messages', 'action' => 'compose','type'=>'contact', 'to'=>$orders['User']['username'], 'admin' => false), array('title' => __l('Contact Traveler'),'class'=>'graydarkc'));?>)</span></dd>
              </dl>			
			<?php elseif($orders['PropertyUser']['user_id'] == $this->Auth->user('id')):?>
              <dl class="list sep-right">
                <dt class="pr hor-mspace text-11"><?php echo __l('Host name');?></dt>
                <dd class="textb text-16 mob-inline graydarkc pr hor-mspace"><span class="htruncate width75 pull-left"><?php  echo $this->Html->link($orders['Property']['User']['username'], array('controller' => 'users', 'action' => 'view', $orders['Property']['User']['username'], 'admin' => false), array('title' => $orders['Property']['User']['username'],'class'=>'graydarkc js-bootstrap-tooltip'));?></span> <span class="pull-left show "> (<?php  echo $this->Html->link(__l('Contact Host'), array('controller' => 'messages', 'action' => 'compose','type'=>'contact', 'to'=>$orders['Property']['User']['username'], 'admin' => false), array('title' => __l('Contact Host'),'class'=>'graydarkc'));?>)</span></dd>
              </dl>							
			<?php else:?>
              <dl class="list sep-right">
                <dt class="pr hor-mspace text-11"><?php echo __l('Traveler name');?></dt>
                <dd class="textb text-16 mob-inline graydarkc pr hor-mspace"><span class="htruncate width75 pull-left"><?php echo !empty($orders['User']['username']) ? $this->Html->link($orders['User']['username'], array('controller' => 'users', 'action' => 'view', $orders['User']['username'], 'admin' => false),array('class'=>'graydarkc js-bootstrap-tooltip', 'title' => $orders['User']['username'])) : 'Guest'; ?><?php echo !empty($orders['User']['username']) ? ' (' . $this->Html->link(__l('Contact Traveler'), array('controller' => 'messages', 'action' => 'compose', 'type' => 'contact', 'to'=>$orders['User']['username'], 'admin' => false), array('title' => __l('Contact Traveler'),'class'=>'graydarkc')) . ')' : ''; ?></span> </dd>
              </dl>
              <dl class="list sep-right">
                <dt class="pr hor-mspace text-11"><?php echo __l('Host name');?></dt>
                <dd class="textb text-16 mob-inline graydarkc pr hor-mspace"><span class="htruncate width75 pull-left"><?php  echo $this->Html->link($orders['Property']['User']['username'], array('controller' => 'users', 'action' => 'view', $orders['Property']['User']['username'], 'admin' => false),array('class'=>'graydarkc js-bootstrap-tooltip', 'title' => $orders['Property']['User']['username']));?> (<?php  echo $this->Html->link(__l('Contact Host'), array('controller' => 'messages', 'action' => 'compose','type'=>'contact', 'to'=>$orders['Property']['User']['username'], 'admin' => false), array('title' => __l('Contact Host'),'class'=>'graydarkc'));?>)</span> </dd>
              </dl>			  				
			<?php endif;?>	
			<?php if(Configure::read('property.is_enable_security_deposit')): ?>
			<dl class="list">
                <dt class="pr hor-mspace text-11"><?php echo __l('Security Deposit');?></dt>
                <dd class="textb text-16  graydarkc pr hor-mspace" title="<?php echo $this->Html->siteCurrencyFormat($orders['Property']['security_deposit'], false); ?>"><?php echo $this->Html->siteCurrencyFormat($orders['Property']['security_deposit']); ?><span title="<?php echo __l('This deposit is for security purpose. When host raise any dispute on property damage, this amount may be used for compensation. So, total refund is limited to proper stay and booking cancellation/rejection/expiration. Note that site decision on this is final.'); ?>" class="info">&nbsp;</span></dd>
              </dl>			
			<?php endif; ?>			

            </div>
</li>
</ol>


<?php $show_checkinout = array();?>
<?php echo $this->element('message-index-conversation', array('order_id' => $orders['PropertyUser']['id'], 'config' => 'sec', 'span_size' => (!empty($this->request->params['prefix'])) ?  "span21" : "span15", 'admin_view' => (!empty($this->request->params['prefix'])) ?  true : false)); ?>
<section class="row no-mar bot-space">
  <div class="ver-space">
	<h3 class="ver-space textb"><?php echo __l('Response and actions'); ?></h3>
  </div>		
  <?php if ($orders['PropertyUserStatus']['id'] != ConstPropertyUserStatus::CanceledByAdmin && $orders['PropertyUserStatus']['id'] != ConstPropertyUserStatus::Canceled && $orders['PropertyUserStatus']['id'] != ConstPropertyUserStatus::Rejected && $orders['PropertyUserStatus']['id'] != ConstPropertyUserStatus::Expired): ?>
    <?php if((empty($this->request->params['named']['type']) && $orders['PropertyUserStatus']['id'] != ConstPropertyUserStatus::Completed) || ($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Completed )):?>
      <a name="review_your_work"></a>
      <a name="complete_your_work"></a>
      <a name="deliver_your_work"></a>
      <div class="js-response-actions status-link ui-tabs-block bot-mspace clearfix">
	    <?php $is_show_manage_bar = 1;
		if (empty($orders['PropertyUser']['is_under_dispute'])): // check property order have any dispute post or not
	      if($orders['PropertyUser']['owner_user_id'] == $this->Auth->user('id')): // Seller
	        if ($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforAcceptance):
	          echo $this->Html->link('<i class="icon-ok-sign"></i>'.__l('Confirm'), array('controller' => 'property_users', 'action' => 'update_order', $orders['PropertyUser']['id'], 'accept', 'admin' => false, '?r=' . $this->request->url), array('class'=>'confirm js-delete right-mspace js-bootstrap-tooltip','title' => __l('Confirm'), 'escape' => false));
	          echo $this->Html->link('<i class="icon-remove-sign"></i>'.__l('Reject'), array('controller' => 'property_users', 'action' => 'update_order', $orders['PropertyUser']['id'], 'reject', 'admin' => false, '?r=' . $this->request->url), array('class'=>'cancel js-delete right-mspace js-bootstrap-tooltip','title' => __l('Reject'), 'escape' => false));
	        endif;
	        if (($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Confirmed) && (date('Y-m-d') >= $orders['PropertyUser']['checkin']) && (empty($orders['PropertyUser']['is_host_checkin']))):
	          if((($orders['Property']['checkin'] == '00:00:00') || (date('H:i:s') >= $orders['Property']['checkin'])) || ($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived)):
				$show_checkinout['show'] = 1;
				$show_checkinout['value'] = __l('Check in');
				$show_checkinout['title'] = 'Checkin';
				$show_checkinout['action'] = 'check_in';
	          endif;
			endif;
			if ($this->Auth->user('id') == $orders['PropertyUser']['owner_user_id'] && ($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview ||  $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Completed ||  $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::PaymentCleared) && empty($orders['PropertyUser']['is_host_reviewed'])):
			  echo $this->Html->link('<i class="icon-refresh"></i>'.__l('Review'), array('controller'=>'property_user_feedbacks','action'=>'add','property_order_id' => $orders['PropertyUser']['id']), array('class' =>'review dl right-mspace js-bootstrap-tooltip', 'title' => __l('Review'), 'escape' => false));
			endif;
			if(empty($show_checkinout) && ($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview || $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::PaymentCleared) && (date('Y-m-d') >= $orders['PropertyUser']['checkout']) && empty($orders['PropertyUser']['is_host_checkout'])):
			if((date('Y-m-d') >$orders['PropertyUser']['checkout'])):
				$show_checkinout['show'] = 1;
				$show_checkinout['value'] = __l('Check out');
				$show_checkinout['title'] = 'Checkout';
				$show_checkinout['action'] = 'check_out';
			  elseif((date('Y-m-d') == $orders['PropertyUser']['checkout']) && (($orders['Property']['checkout'] == '00:00:00') || (date('H:i:s') >= $orders['Property']['checkout']))):
				$show_checkinout['show'] = 1;
				$show_checkinout['value'] = __l('Check out');
				$show_checkinout['title'] = 'Checkout';
				$show_checkinout['action'] = 'check_out';
			  endif;
			endif; 
		  else:	// Buyer 
			if($orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance || ($orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed && $orders['PropertyUser']['checkin'] > date('Y-m-d'))):
			  echo $this->Html->link('<i class="icon-remove"></i>'.__l('Cancel'), array('controller' => 'properties', 'action' => 'order', $orders['PropertyUser']['property_id'] , 'order_id'=>$orders['PropertyUser']['id'], 'type' => __l('cancel'), 'admin' => false),array('title' => 'Cancel' ,'class' =>'delete mspace js-bootstrap-tooltip', 'escape' => false));
			endif;
			if($orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentPending && $orders['PropertyUser']['user_id']==$this->Auth->User('id')):
			  echo $this->Html->link( '<i class="icon-bookmark"></i>'.__l('Book It'), array('controller' => 'properties', 'action' => 'order', $orders['Property']['id'], 'order_id:' . $orders['PropertyUser']['id'], 'admin' => false), array('class' => 'complete-booking js-no-pjax js-delete mspace js-bootstrap-tooltip','title' => __l('Book It'), 'escape' => false));
			endif;
			if($this->Auth->user('id')==$orders['PropertyUser']['user_id'] && ($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview)):
			  echo $this->Html->link('<i class="icon-refresh"></i>'.__l('Review'), array('controller'=>'property_feedbacks','action'=>'add','property_order_id' => $orders['PropertyUser']['id']), array('class' =>'review dl mspace js-bootstrap-tooltip', 'title' => __l('Review'), 'escape' => false));
			endif;
            $is_show_manage_bar = 0;
			// seperate the blocks, to show both checkin and checkout on multiple cases //
			if (($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Confirmed) && (date('Y-m-d') >= $orders['PropertyUser']['checkin']) && (empty($orders['PropertyUser']['is_traveler_checkin']))):
			  if ((($orders['Property']['checkin'] == '00:00:00') || (date('H:i:s') >= $orders['Property']['checkin'])) || ($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived)):
				$show_checkinout['show'] = 1;
				$show_checkinout['value'] = __l('Check in');
				$show_checkinout['title'] = 'Checkin';
				$show_checkinout['action'] = 'check_in'; 
			  endif;
			endif;
			if(empty($show_checkinout) && ($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview || $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::PaymentCleared) && (date('Y-m-d') >= $orders['PropertyUser']['checkout']) && empty($orders['PropertyUser']['is_traveler_checkout'])):
			  if((date('Y-m-d') > $orders['PropertyUser']['checkout'])):
				$show_checkinout['show'] = 1;
				$show_checkinout['value'] = __l('Check out');
				$show_checkinout['title'] = 'Checkout';
				$show_checkinout['action'] = 'check_out';
			  elseif((date('Y-m-d') == $orders['PropertyUser']['checkout']) && (($orders['Property']['checkout'] == '00:00:00') || (date('H:i:s') >= $orders['Property']['checkout']))):
				$show_checkinout['show'] = 1;
				$show_checkinout['value'] = __l('Check out');
				$show_checkinout['title'] = 'Checkout';
				$show_checkinout['action'] = 'check_out';
			  endif;
			endif; 
		  endif;
		else:
		  echo '<span class="dispute-open dispute-open1 alert alert-info">' .__l('Under dispute. Actions can be continued only after dispute gets closed.').'</span>';
		  // Dispute compose or response //
		  $this->request->params['named']['type'] = !empty($this->request->params['named']['type']) ? $this->request->params['named']['type'] : '';
		  echo $this->element('message-dispute-response', array('order_id' => $orders['PropertyUser']['id'], 'type' => $this->request->params['named']['type'], 'config' => 'sec'));
		  echo $this->element('property-order-dispute-resolve', array('order_id' => $orders['PropertyUser']['id'], 'type' => $this->request->params['named']['type'], 'config' => 'sec'));
		endif;  ?>
      </div>
    <?php else: 
      if (!empty($orders['PropertyUser']['is_under_dispute'])): // check property order have any dispute post or not
		echo '<span class="dispute-open dispute-open1 alert alert-info">' .__l('Under dispute. Actions can be continued only after dispute gets closed.').'</span>';
		echo $this->element('property-order-dispute-resolve', array('order_id' => $orders['PropertyUser']['id'], 'type' => $this->request->params['named']['type'], 'config' => 'sec'));
      endif;
    endif;
  endif; ?>
  <?php if(empty($this->request->params['named']['type']) && empty($this->request->params['prefix'])):?>
    <div class="js-dispute-container ui-tabs-block clearfix tab-container" id="ajax-tab-container-property">
      <ul class="nav nav-tabs no-mar tabs">
		<?php if ($orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentPending && !empty($orders['PropertyUser']['is_negotiation_requested'])) { ?>
		  <li class="negotiation tab active"><?php echo $this->Html->link('<i class="icon-home"></i>' .__l('Negotiation'), array('controller' => 'messages', 'action' => 'simple_compose', 'order_id' => $orders['PropertyUser']['id']), array('title' => __l('Negotiation'), 'data-target'=> "#negotiation", 'data-toggle'=>'tab' ,'escape' => false,'class'=>"js-no-pjax"));?></li>
		<?php } ?>
		<?php if(!empty($show_checkinout['show'])):?>
		  <li class="check-in tab"><?php echo $this->Html->link('<i class="icon-home"></i>'. $show_checkinout['value'], array('controller' => 'property_users', 'action' => 'process_checkinout', 'order_id' => $orders['PropertyUser']['id'], 'p_action' => $show_checkinout['action']), array('title' => $show_checkinout['title'], 'data-target'=> "#check-in", 'data-toggle'=>'tab', 'escape' => false,'class'=>"js-no-pjax"));?></li>
		<?php endif;?>
		<li class="private-note tab"><?php echo $this->Html->link('<i class="icon-file-text-alt"></i>' . __l('Private Note'), array('controller' => 'messages', 'action' => 'simple_compose', 'order_id' => $orders['PropertyUser']['id'], 'conversaction_type'=> 'private'), array('title' => __l('Private Note'), 'data-target'=> "#private-note", 'data-toggle'=>'tab','escape' => false,'class'=>"js-no-pjax"));?></li>
		<li class="pull-right sep-left dispute tab"><?php echo $this->Html->link('<i class="icon-warning-sign"></i>'.__l('Dispute'), array('controller' => 'property_users', 'action' => 'manage', 'property_user_id' => $orders['PropertyUser']['id']), array('title' => __l('Dispute'), 'data-target'=> "#disputetab",'escape' => false,'class'=>"js-no-pjax"));?></li>
      </ul>
      <div class="sep-right sep-left space bot-mspace sep-bot tab-round ">
	    <?php if ($orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentPending && !empty($orders['PropertyUser']['is_negotiation_requested'])) { ?>
	      <div id="negotiation" class="tab-pane "></div>
	    <?php } ?>
	    <?php if(!empty($show_checkinout['show'])):?>
          <div id="check-in" class="tab-pane "></div>
	    <?php endif;?>
        <div id="private-note" class="tab-pane "></div>
        <div id="disputetab" class="tab-pane "></div>
      </div>
	</div>
  <?php endif;?>
</section>