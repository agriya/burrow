<h2 class="top-space top-mspace sep-bot"><?php echo __l('Compose');?></h2>
<section class="row top-space top-mspace">	
<aside>
	<?php echo $this->element('message_message-left_sidebar', array('config' => 'sec')); ?>						
 </aside>
 <section class="span bot-mspace user-dashboard sep mob-sep-none mob-no-pad message-block tab-no-mar span22">
<?php echo $this->Form->create('Message', array('action' => 'compose', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')); ?>
<?php
if((!empty($this->request->params['named']['type']) == 'contact') || (!empty($this->request->data['Message']['type']) && (($this->request->data['Message']['type']  == 'contact') || ($this->request->data['Message']['type']  == 'user')))){
?>
<div class="top-mspace">
    <div class="clearfix bot-mspace top-mspace">
    <label>
        <?php 	echo __l('From'); ?>
    </label>
             <?php echo $this->Html->link($this->Html->cText($this->Auth->user('username')), array('controller'=> 'users', 'action' => 'view', $this->Auth->user('username')), array('class' => 'top-smspace inline', 'title' => $this->Html->cText($this->Auth->user('username'),false),'escape' => false)); ?>
    </div>
 <div class="clearfix bot-mspace top-space">
     <label>
       <?php 	echo __l('To'); ?>
    </label>
	  <?php echo !empty($this->request->data['Message']['to_username']) ? $this->Html->link($this->Html->cText($this->request->data['Message']['to_username']), array('controller'=> 'users', 'action' => 'view', $this->request->data['Message']['to_username']), array('class' => 'top-smspace inline', 'title' => $this->Html->cText($this->request->data['Message']['to_username'],false),'escape' => false)) : 'Guest'; ?>
 </div>
    <?php if (!empty($this->request->data['Message']['property_name']) || !empty($this->request->data['Message']['request_name'])): ?>
    <div class="clearfix bot-mspace top-mspace">
		<label class=" message-title-left dr">
			<?php echo $this->request->data['Message']['from'];  ?>
		</label>
		<?php if($this->request->data['Message']['from']=='Property'): ?>
		<?php echo $this->Html->link($this->Html->cText($this->request->data['Message']['property_name']), array('controller' => 'properties', 'action' => 'view',  $this->request->data['Message']['property_slug']), array('title' => $this->Html->cText($this->request->data['Message']['property_name'],false),'escape' => false));?>
		<?php elseif($this->request->data['Message']['from']=='Request' && isPluginEnabled('Requests')): ?>
		<?php echo $this->Html->link($this->Html->cText($this->request->data['Message']['request_name']), array('controller' => 'requests', 'action' => 'view',  $this->request->data['Message']['request_slug']), array('title' => $this->Html->cText($this->request->data['Message']['request_name'],false),'escape' => false));?>
		<?php endif; ?>
    </div>
 <?php	endif;  ?>
 <?php if(!empty($this->request->params['named']['property_user_id']) || !empty($this->request->data['Message']['property_user_id'])):?>
	<p class="clearfix">
		<span class="message-title"><?php 	echo __l('Booking#'); ?></span>
		 <?php	if(!empty($this->request->params['named']['property_user_id'])){
				echo $this->request->params['named']['property_user_id'];
			}elseif(!empty($this->request->data['Message']['property_user_id'])){
				echo $this->request->data['Message']['property_user_id'];	
			}
		 ?>
	</p>
	<?php endif;?>
	</div>
<?php }?>
<div class="compose-box">
			<?php
				echo $this->Form->input('parent_message_id', array('type' => 'hidden'));
				echo $this->Form->input('type', array('type' => 'hidden'));
					if(!empty($this->request->data['Message']['to_username'])):
						echo $this->Form->input('to_username', array('type' => 'hidden', 'id' => 'message-to'));
						echo $this->Form->input('to', array('type' => 'hidden', 'id' => 'message-to-name', 'value' => $this->request->data['Message']['to_username']));
					else:
						echo $this->Form->input('to', array('type' => 'hidden', 'id' => 'message-to'));
					endif;
					if (!empty($this->request->data['Message']['property_slug'])):
						if(empty($this->request->data['Message']['negotiable'])){
							$this->request->data['Message']['negotiable'] = '';
						}
						echo $this->Form->input('purpose', array('class'=>'js-contact-purpose {"negotiable":"'.$this->request->data['Message']['negotiable'].'"}','type' => 'select','options'=>$contact_purposes,'default'=>4));
					endif;?>
					<div class="js-response"></div>
					<div class="js-contactus-container">
				<?php 
					
					if (!empty($this->request->data['Message']['contact_type']) && ($this->request->data['Message']['contact_type'] == 'deliver')):
							echo $this->Form->input('subject', array('id' => 'MessSubject', 'type' => 'hidden', 'label' => __l('Subject')));
						else:
							echo $this->Form->input('subject', array('id' => 'MessSubject', 'label' => __l('Subject')));
					endif;
					if (!empty($this->request->data['Message']['property_id'])):
						echo $this->Form->input('property_id', array('type' => 'hidden'));
					endif;
					if (!empty($this->request->data['Message']['property_slug'])):
						echo $this->Form->input('property_slug', array('type' => 'hidden'));
					endif;
					if (!empty($this->request->data['Message']['property_name'])):
						echo $this->Form->input('property_name', array('type' => 'hidden'));
					endif;
					if (!empty($this->request->data['Message']['property_user_id'])):
						echo $this->Form->input('property_user_id', array('type' => 'hidden'));
					endif;
					if (!empty($this->request->data['Message']['request_id'])):
						echo $this->Form->input('request_id', array('type' => 'hidden'));
					endif;
					if (!empty($this->request->data['Message']['request_slug'])):
						echo $this->Form->input('request_slug', array('type' => 'hidden'));
					endif;
					if (!empty($this->request->data['Message']['request_name'])):
						echo $this->Form->input('request_name', array('type' => 'hidden'));
					endif;
					echo $this->Form->input('ordered_date', array('type' => 'hidden'));
					echo $this->Form->input('property_amount', array('type' => 'hidden'));
					echo $this->Form->input('contact_type', array('type' => 'hidden'));
            ?>
            <div class="clearfix">
				<?php
					if(!empty($this->request->params['named']['order']) == 'deliver'):
						$label =  __l('Message to buyer');
					else:
						$label = __l('Message');
					endif;
				?>
			<?php echo $this->Form->input('message', array('type' => 'textarea', 'label' => $label)); ?>
			</div>

<div class="form-actions clearfix" >
<div class="pull-right">
	<?php echo $this->Form->submit(__l('Send'),array('class'=>'btn btn-large btn-primary textb text-16')); ?>
	
		<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'messages', 'action' => 'inbox') , array('title' => __l('Cancel'), 'class' =>'btn btn-large textb text-16')); ?>
    </div>
</div>

</div>
</div>
<?php echo $this->Form->end(); ?>
	</section>				
</section>