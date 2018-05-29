<?php /* SVN: $Id: $ */ ?>
<div class="js-tabs clearfix">
<?php if(empty($this->request->params['isAjax'])): ?>

	<ul class="clearfix menu-tabs yes-no-link">
		<li class="yes"><?php echo $this->Html->link(__l('Yes'), array('controller' => 'property_feedbacks', 'action' => 'add', 'property_order_id' => $this->request->params['named']['property_order_id'], 'view_type' => 'simple-feedback','selected' => 'yes', 'property_type_id' => $message['property_type_id']), array('title' => __l('Yes'), 'rel' => 'address:/' . str_replace(' ', '_', 'Yes'), 'escape' => false)); ?></li>
		<li class="no"><?php echo $this->Html->link(__l('No'), array('controller' => 'property_feedbacks', 'action' => 'add', 'property_order_id' => $this->request->params['named']['property_order_id'], 'view_type' => 'simple-feedback','selected' => 'no', 'property_type_id' => $message['property_type_id']), array('title' => __l('No'), 'rel' => 'address:/' . str_replace(' ', '_', 'No'), 'escape' => false)); ?></li>
	</ul>

<?php endif;?>
<?php if(!empty($this->request->params['isAjax'])): ?>
<div class=" form clearfix">
<?php if($this->request->params['named']['selected'] == 'no'): ?>
	<?php echo $this->element('property-order-manage-tabs', array('property_order_id' => $message['property_order_id'], 'order_status_id' => $message['property_order_status_id'], 'property_type_id' => $message['property_type_id'], 'type' => 'myorders', 'config' => 'sec'));?>
<?php else:?>
<div class="js-responses">
<?php if(!empty($this->request->params['named']['selected'])): ?>
	<div class="clearfix">
	<?php echo $this->Form->create('PropertyFeedback', array('class' => 'normal js-ajax-form'));?>
	<?php
		echo $this->Form->input('is_from_activities', array('type' => 'hidden', 'value' => 1));
		echo $this->Form->input('property_id',array('type'=>'hidden','value' => $message['property_id']));
		echo $this->Form->input('property_order_id',array('type'=>'hidden','value' => $message['property_order_id']));
		echo $this->Form->input('user_id',array('type'=>'hidden','value' => $this->Auth->user('id')));
		echo $this->Form->input('property_order_user_id',array('type'=>'hidden','value' => $message['property_order_user_id']));
		echo $this->Form->input('property_order_user_email',array('type'=>'hidden','value' => $message['property_seller_email']));
		?>
     	<div class="click-info-block yes-info-block">
			<div class="click-info">
			<?php
				$is_satisfied = (!empty($this->request->params['named']['selected']) && $this->request->params['named']['selected'] == 'yes') ? '1' : '0';
				echo $this->Form->input('is_satisfied',array('value' => $is_satisfied, 'type' => 'hidden'));
			?>
			</div>
			<?php
				$thumb_class = (!empty($this->request->params['named']['selected']) && $this->request->params['named']['selected'] == 'yes') ?  'positive-feedback' : 'negative-feedback';
			?>
			<span class="feedback-list <?php echo $thumb_class;?>">
				<?php
					if($thumb_class == "positive-feedback"):
						echo __l('You are rating this work, Positive :)');
					else:
						if($message['property_type_id'] == ConstPropertyType::Offline):
							$info_mess =  __l("You are rating this work, Negative :( <p>If you are not satisfied with the work and need refund, you can open a \"dispute\".</p>");
						else:
							$info_mess =  __l("You are rating this work, Negative :( <p>You can also, request for rework, by selecting \"Request Improvement\" tab</p><p>Or, if you are not satisfied with the work and need refund, you can open a \"dispute\".</p>");						
						endif;
						echo $info_mess;
					endif;
				?>
			</span>
			
			<?php
				
				echo $this->Form->input('feedback',array('label' => __l('Review')));
			?>
			<div class="clearfix submit-block">
				<?php echo $this->Form->submit(__l('Submit'), array('class' => 'js-delete'));?>
			</div>
			<?php echo $this->Form->end();?>
		</div>
	</div>
<?php endif;?>
	</div>
<?php endif;?>

</div>
<?php endif;?>
</div>