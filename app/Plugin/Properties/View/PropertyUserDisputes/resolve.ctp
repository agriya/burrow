<?php /* SVN: $Id: $ */ ?>

<div class="user-info-block-right disputes-info-block clearfix ">
	<?php if($this->Auth->user('role_id') != ConstUserTypes::Admin):?>
		<?php if($dispute['DisputeStatus']['id'] != ConstDisputeStatus::WaitingForAdministratorDecision):?>
			<div class="page-information clearfix">	
				<p>
					<?php
						if($this->Auth->user('id') == $dispute['Property']['user_id']):
							$other_user = $this->Html->link($this->Html->cText($dispute['PropertyUser']['User']['username']), array('controller'=> 'users', 'action'=>'view', $dispute['PropertyUser']['User']['username']), array('escape' => false));
						else:
							$other_user = $this->Html->link($this->Html->cText($dispute['Property']['User']['username']), array('controller'=> 'users', 'action'=>'view', $dispute['Property']['User']['username']), array('escape' => false));
						endif;
					?>
					<?php echo __l("Auto Dispute Action:").' '.__l("If").' '.$other_user.' '.__l("makes a reply/opens a dispute, you need to make a reply within").' '."<b>".Configure::read('dispute.days_left_for_disputed_user_to_reply').__l('days')."</b>".' '.__l("in booking to avoid making decision in favor of").' '.$other_user.__l(", after that it'll").' '.$other_user.' '.__l("turn to make a response until the same alloted days for him to avoid dispute be closed in favor of you.");?>
				</p>
				<p>
					<?php echo __l('Administrator Decision:').' '.__l('The administrator decision will takes place when the total converstation count for the dispute reaches').' '.Configure::read('dispute.discussion_threshold_for_admin_decision');?>
				</p>
			</div>
		<?php endif;?>
	<?php endif;?>

      <h3><?php echo __l('Dispute Information');?></h3>
	  <div class="clearfix">
		<dl class="dl-horizontal">
			<dt><?php echo __l('Dispute ID').'#';?></dt>
				<dd><span class="stats-val"><?php echo $this->Html->cInt($dispute['PropertyUserDispute']['id']); ?></span></dd>
			<dt><?php echo __l('Disputer');?></dt>
				<dd><span class="stats-val"><?php echo $this->Html->link($this->Html->cText($dispute['User']['username']), array('controller'=> 'users', 'action'=>'view', $dispute['User']['username']), array('escape' => false)) . ' ';?><?php echo (!empty($dispute['PropertyUserDispute']['is_traveler']) ? ' ('.__l('Traveler').')' : ' ('.__l('Host').')');?></span></dd>
			<dt><?php echo __l('Dispute Status');?></dt>
				<dd>
					<span class="stats-val"><?php echo $dispute['DisputeStatus']['name'];?>
					<?php 
						if($dispute['DisputeStatus']['id'] == ConstDisputeStatus::Open):
							echo ' ('.__l("Waiting for response from the other user").')';
						elseif($dispute['DisputeStatus']['id'] == ConstDisputeStatus::UnderDiscussion):
							echo '('.__l("Converstation Underway").')';
						endif
					?></span>
				</dd>
			<dt><?php echo __l('Last Replied');?></dt>
				<dd><span class="stats-val"><?php echo !empty($dispute['PropertyUserDispute']['last_replied_date']) ? $this->Html->cDateTime($dispute['PropertyUserDispute']['last_replied_date']) : __l('Not yet');?></span></dd>
		    <dt><?php echo __l('Disputed On');?></dt>
				<dd><span class="stats-val"><?php echo $this->Html->cDateTime($dispute['PropertyUserDispute']['created']);?></span></dd>
			<dt><?php echo __l('Disputed');?></dt>
				<dd><span class="stats-val"><?php $disputed_user = ($dispute['User']['username'] == $dispute['Property']['User']['username']) ? $dispute['PropertyUser']['User']['username']: $dispute['Property']['User']['username'];?><?php echo $this->Html->link($this->Html->cText($disputed_user), array('controller'=> 'users', 'action'=>'view', $disputed_user), array('escape' => false)) . ' ';?><?php echo (empty($dispute['PropertyUserDispute']['is_traveler']) ? ' ('.__l('Traveler').')' : ' ('.__l('Host').')');?></span></dd>
			<dt><?php echo __l('Dispute Reason');?></dt>
				<dd><span class="stats-val"><?php echo $dispute['DisputeType']['name'];?></span></dd>
			<dt><?php echo __l('Reason');?></dt>
				<dd><span class="stats-val"><?php echo $this->Html->cText($dispute['PropertyUserDispute']['reason']);?></span></dd>
		</dl>
	  </div>
	</div>
<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin):?>
<div id="js-confirm-message-block">
	<h3><?php echo __l('Dispute Actions');?></h3>
	<?php echo $this->Form->create('PropertyUserDispute', array('action' => 'resolve', 'class' => 'normal'));?>
	<?php echo $this->Form->input('property_user_id', array('type' => 'hidden', 'value' => $dispute['PropertyUserDispute']['property_user_id']));?>
		<div class="resolve-comment">
			<?php foreach($dispute_close_types as $dispute_close_type):?>
				<div class="clearfix"><?php echo $this->Form->submit($dispute_close_type['DisputeClosedType']['name'].' ['.$dispute_close_type['DisputeClosedType']['resolve_type'].']', array('class'=>'js-confirm-mess','name' => 'data[PropertyUserDispute][close_type_'.$dispute_close_type['DisputeClosedType']['id'].']'));?></div>
				<?php if($dispute_close_type['DisputeClosedType']['id'] == 7 || $dispute_close_type['DisputeClosedType']['id'] == 8 || $dispute_close_type['DisputeClosedType']['id'] == 9):?>
					<?php echo __l("The below action will be automatically be taken, if the disputer didn't reply in").' '.Configure::read('dispute.days_left_for_disputed_user_to_reply').__l('days');?>
				<?php endif;?>
				<div class="alert alert-info clearfix ver-mspace">
					<p><?php echo $dispute_close_type['DisputeClosedType']['reason'];?></p>
				</div>
			<?php endforeach;?>
		</div>
	<?php echo $this->Form->end();?>		
</div>
<?php endif;?>