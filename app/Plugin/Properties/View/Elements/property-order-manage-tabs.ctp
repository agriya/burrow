<?php 
if(!empty($this->request->params['named']['property_user_id']) && empty($property_user_id)):
	$property_user_id = $this->request->params['named']['property_user_id'];
endif;
if(!empty($this->request->params['named']['property_type_id'])):
	$property_type_id = $this->request->params['named']['property_type_id'];
endif;
?>

<div class="js-tabs disputes-order-block clearfix">
	<ul class="clearfix menu-tabs order-link-block">
		<?php if(empty($is_under_dispute)):?>
			<?php if(($order_status_id == ConstPropertyUserStatus::InProgress || $order_status_id == ConstPropertyUserStatus::InProgressOvertime || $order_status_id == ConstPropertyUserStatus::Redeliver) && $this->request->params['named']['type'] == 'myworks'):?>
			<li class="order">
				<?php
					echo $this->Html->link(__l('Deliver Order'), array('controller' => 'messages', 'action' => 'compose', 'property_user_id' => $property_user_id, 'order' => 'deliver', 'view_type' => 'simple-deliver'), array('title' => __l('Deliver Order'), 'rel' => 'address:/' . str_replace(' ', '_', 'Delivery_order'), 'escape' => false));
				?>
			</li>
			<?php endif;?>
			<?php if($order_status_id == ConstPropertyUserStatus::WaitingforReview && $this->request->params['named']['type'] != 'myworks'):?>
				<li class="want-to-close"><?php echo $this->Html->link(__l('Want to Close'), array('controller' => 'property_feedbacks', 'action' => 'add', 'property_user_id' => $property_user_id, 'view_type' => 'simple-feedback','selected' => 'want_to_close'), array('title' => __l('Want to close'), 'rel' => 'address:/' . str_replace(' ', '_', 'Want_to_close'), 'escape' => false)); ?></li>
				<li class="require"><?php echo $this->Html->link(__l('Request Improvement'), array('controller' => 'property_users', 'action' => 'manage', 'property_user_id' => $property_user_id, 'view_type' => 'simple-feedback','selected' => 'redeliver'), array('title' => __l('Request Improvement'), 'rel' => 'address:/' . str_replace(' ', '_', 'Request_Improvement'), 'escape' => false)); ?></li>
			<?php endif;?>
		<?php endif;?>
		<?php if($order_status_id == ConstPropertyUserStatus::WaitingforReview && !empty($is_redeliver_request) && $this->request->params['named']['type'] != 'myorders' && $property_type_id == ConstPropertyType::Online):?>
			<li class="require"><?php echo $this->Html->link(__l('Request Improvement'), array('controller' => 'property_users', 'action' => 'manage', 'property_user_id' => $property_user_id, 'view_type' => 'simple-feedback','selected' => 'redeliver'), array('title' => __l('Request Improvement'), 'rel' => 'address:/' . str_replace(' ', '_', 'Request_Improvement'), 'escape' => false)); ?></li>
		<?php endif;?>
		<?php if($order_status_id == ConstPropertyUserStatus::InProgress || $order_status_id == ConstPropertyUserStatus::InProgressOvertime || $order_status_id == ConstPropertyUserStatus::Redeliver || $order_status_id == ConstPropertyUserStatus::WaitingforReview):?>
			<li class="mutual-cancel"><?php echo $this->Html->link(__l('Mutual Cancel'), array('controller' => 'property_users', 'action' => 'manage', 'property_user_id' => $property_user_id, 'view_type' => 'simple-feedback','selected' => 'mutual_cancel'), array('title' => __l('Mutual Cancel'), 'rel' => 'address:/' . str_replace(' ', '_', 'mutual_cancel'), 'escape' => false)); ?></li>
		<?php endif;?>		
	</ul>
</div>
