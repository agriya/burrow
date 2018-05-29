<?php 
$is_show = 0;
if($order['PropertyUser']['user_id'] == $this->Auth->user('id')):				// Traveler Checky //
	if($order['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived):
		$is_show = 1;
	endif;
elseif($order['PropertyUser']['owner_user_id'] == $this->Auth->user('id')):	// Host Checky //
	if($order['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforReview || $order['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentCleared || $order['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Completed):
		$is_show = 1;
	endif;
endif;
?>
<?php if(!empty($is_show)):?>

		<div class="alert alert-info"> <!--  js-dispute-container hide -->
			<?php
				echo "<p>".__l('If you have a disagreement or argument about your booking or not satisfied about the property and looking for claim your amount or require any other support based on below show cases, you can open a dispute.<br/>Note: Your posted dispute will be monitored by administrator and favor for the traveler/host will made by administrator alone.')."</p>";
			?>
		</div>
<?php endif; ?>
<?php echo $this->element('propert_user-dispute-add', array('order_id' => $order['PropertyUser']['id'], 'config' => 'sec'));?>