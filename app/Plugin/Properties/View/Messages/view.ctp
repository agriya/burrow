<?php /* SVN: $Id: view.ctp 4960 2010-05-15 12:02:46Z aravindan_111act10 $ */ ?>
<?//php pr($message);?>
<div class="messages view message-view-block">
<div class="main-content-block js-corner round-5">
<div class="mail-side-two">
	<?php
        echo $this->Form->create('Message', array('action' => 'move_to','class' => 'normal'));
        echo $this->Form->hidden('folder_type', array('value' => $folder_type,'name' => 'data[Message][folder_type]'));
        echo $this->Form->hidden('is_starred', array('value' => $is_starred,'name' => 'data[Message][is_starred]'));
        echo $this->Form->hidden("Message.Id." . $message['Message']['id'], array('value' => '1'));
    ?>
   <div class="high-light-block">
	<?php
		if($this->Auth->sessionValid() && ($this->Auth->user('role_id') == ConstUserTypes::Admin)):
			$bad_words = unserialize($message['MessageContent']['detected_suspicious_words']);
			if(!empty($bad_words)):
			echo '<h3>'.__l('System Flag Words: ').'</h3>';
				echo '<ul>';
				foreach($bad_words as $bad_word){
					echo '<li>'.$bad_word.'</li>';
				}
				echo '</ul>';
			endif;
		endif;
	?>
	</div>
    <div class="mail-main-curve">   
	<div class="inbox-block clearfix">
	 <p class="user-status-info user-status-information">
    	<?php
			if($this->Auth->sessionValid() && ($this->Auth->user('role_id') == ConstUserTypes::Admin)):
				if($message['MessageContent']['is_system_flagged']):
					echo $this->Html->link(__l('Clear flag'), array('action' => 'update_status', $message['MessageContent']['id'], 'flag' => 'deactivate', 'admin' => true), array('class' => 'clear-flag js-admin-update-property', 'title' => __l('Clear flag')));
				else:
					echo $this->Html->link(__l('Flag'), array('action' => 'update_status', $message['MessageContent']['id'], 'flag' => 'active', 'admin' => true), array('class' => 'flag js-admin-update-property', 'title' => __l('Flag')));
				endif;
				if($message['User']['role_id'] != ConstUserTypes::Admin):
					if($message['User']['is_active']):
						echo $this->Html->link(__l('Deactivate sender'), array('controller' => 'users', 'action' => 'update_status', $message['User']['id'], 'status' => 'deactivate', 'admin' => true), array('class' => 'deactive-user js-admin-update-property', 'title' => __l('Deactivate user')));
					else:
						echo $this->Html->link(__l('Activate sender'), array('controller' => 'users', 'action' => 'update_status', $message['User']['id'], 'status' => 'activate', 'admin' => true), array('class' => 'active-user js-admin-update-property', 'title' => __l('Activate user')));
					endif;
				endif;
			endif;				
		?>
    </p>
			<div class="inbox-block1 message-view-inbox clearfix">
		
			<?php if (!empty($is_starred)) : ?>
                <p>
                <?php
                    echo $this->Html->link(__l('Back to Starred') , array('controller' => 'messages','action' => 'starred'));
                ?>
                </p>
                <?php
                else :
                ?>
					<?php if(ConstUserTypes::Admin == $this->Auth->user('role_id')):?>
						<p><?php echo $this->Html->link(__l('Inbox') , array('controller' => 'messages','action' => 'index', 'admin' => false));?></p>
					<?php else:?>
						<?php 
							if($back_link_msg == 'inbox'):
								$back_link_msg = __l('Inbox');
							else:
								$back_link_msg = ucfirst($back_link_msg);
							endif;
						?>
						<p><?php echo $this->Html->link($back_link_msg, array('controller' => 'messages','action' => $folder_type));?></p>
						<p><?php echo $this->Html->link(__l('Sent items') , array('controller' => 'messages','action' => 'sentmail')); ?></p>
					<?php endif;?>					
                <?php endif;?>
				</div>
			</div>
			<div class="message-block clearfix">
				<div class="message-block-left "  >
			</div>
			<div class="message-block-right  clearfix">
    			<?php
                    echo $this->Form->submit(__l('Delete'), array('class' => 'js-alert-message','name' => 'data[Message][Delete]'));

                ?>
                
				<?php if(ConstUserTypes::Admin != $message['OtherUser']['role_id'] && empty($message['Message']['is_sender'])): ?>
					<div class="cancel-block">
					<?php
						echo $this->Html->link(__l('Reply') , array('controller' => 'messages', 'action' => 'compose', $message['Message']['hash'],'reply') , null, array('inline' => false, 'class' => 'dc'));
					?>
					</div>
				<?php endif;?>
			</div>
        </div>
              <div class="mail-body js-corner mail-content-curve-middle">

                    <div class="clearfix">
                    <div class="mail-sender-name">
                <p class="clearfix">
				<?php if (($message['Message']['is_sender'] == 1) || ($message['Message']['is_sender'] == 2)) : ?>
                   <span class="sender-name tb"> 
					<?php echo __l('From').': ';  ?>		
						<?php
							if(ConstUserTypes::Admin == $message['OtherUser']['role_id']): 
								echo $this->Html->cText($message['User']['username']); 
							else:
								echo $this->Html->link($this->Html->cText($message['User']['username']), array('controller'=> 'users', 'action' => 'view', $message['User']['username']), array('title' => $this->Html->cText($message['User']['username'],false),'escape' => false));
							endif;
						?>
					</span>
   					<?php
                        else :
                    ?>
                    <span class="sender-name tb">
					<span class="message-title"><?php echo __l('From').': ';  ?></span>
						<?php 
							if(ConstUserTypes::Admin == $message['OtherUser']['role_id']): 
								echo $this->Html->cText($message['OtherUser']['username']); 
							else:
								echo $this->Html->link($this->Html->cText($message['OtherUser']['username']), array('controller'=> 'users', 'action' => 'view', $message['OtherUser']['username']), array('title' => $this->Html->cText($message['OtherUser']['username'],false),'escape' => false));
							endif;
						?>
					</span>
					<?php endif; ?>
					</p>
				</div>
                <div class="mail-date-time sfont dr ">
                    <p class="<?php echo $message['Message']['id'] ?> clearfix">
						<span class="js-show-mail-detail-span message-title">
							<?php echo __l('Date: '); ?>
						</span>
							<?php echo $this->Html->cDateTimeHighlight($message['Message']['created']); ?> (<?php echo $this->Time->timeAgoInWords($message['Message']['created']); ?>)
					</p>
                </div>
                </div>

                <div class="mail-content-curve-middle clearfix">
			   <div class="js-show-mail-detail-div" style="display:none;">
				<?php
                    if ($message['Message']['is_sender'] == 0) : ?>
                    	<p  class="clearfix" ><span class="show-details-left dr message-title"><?php echo __l('from').': ';  ?></span> <?php echo $message['OtherUser']['username']; ?> < <?php echo $message['OtherUser']['email']; ?> ></p>
                    <?php
                    else : ?>
                    	<p  class="clearfix"><span class="show-details-left dr message-title"><?php echo __l('from').': ';  ?></span> <?php echo $message['User']['username']; ?> < <?php echo $message['User']['email']; ?> ></p>
        			<?php
                    endif; ?>
    				<p  class="clearfix"><span class="show-details-left dr message-title"><?php echo __l('to').': ';  ?></span><?php echo $show_detail_to; ?></p>
					<p  class="clearfix"><span class="show-details-left dr message-title"><?php echo __l('date').': ';  ?></span><?php echo $this->Html->cDateTimeHighlight($message['Message']['created']); echo __l('at') . $this->Html->cDateTimeHighlight($message['Message']['created']); ?> </p>
				</div>
               	<p  class="clearfix">
					<span class="show-details-left dr message-title">
						<?php echo __l('Property: ');  ?>
					</span>
					<?php if(!empty($property['name'])):?>
						<?php echo $this->Html->link($this->Html->cText($property['name']), array('controller' => 'properties', 'action' => 'view', $property['slug']), array('title' => $this->Html->cText($property['name'],false),'escape' => false));?>
					<?php endif;?>
				</p>
                <?php if(!empty($message['Message']['property_user_id'])):?>
              	<p  class="clearfix"><span class="show-details-left message-title dr"><?php echo __l('Booking').': ';  ?></span>
                   	<?php echo $this->Html->cText($message['Message']['property_user_id']); ?>
     			</p>
                <?php endif;?>
				<?php if(!empty($review_url)): ?>
					<p>
						<?php echo "<a href = ".$review_url.">".__l('Click here to review your Booking')."</a>";?>
					</p>
				<?php endif;?>
				<p class="subject-info clearfix"><span class="show-details-left dr message-title"><?php echo __l('Subject').': ';  ?></span>
					<?php
						if($this->Auth->sessionValid() && ($this->Auth->user('role_id') == ConstUserTypes::Admin) && !empty($message['MessageContent']['is_system_flagged'])):
							echo $this->Html->filterSuspiciousWords($this->Html->cText($message['MessageContent']['subject']), $message['MessageContent']['detected_suspicious_words']); 
						else:
							echo $this->Html->cText($message['MessageContent']['subject']); 						
						endif;
					?>
				</p>
				<div class="message-description">
					<?php 
						if($this->Auth->sessionValid() && ($this->Auth->user('role_id') == ConstUserTypes::Admin) && !empty($message['MessageContent']['is_system_flagged'])):
							echo $this->Html->filterSuspiciousWords($this->Html->cHtml($message['MessageContent']['message']), $message['MessageContent']['detected_suspicious_words']); 
						else:				
							echo nl2br($this->Html->cHtml($message['MessageContent']['message'])); 
						endif;
					?>
				</div>
                <div class="download-block">
				<?php
					if(!empty($message['PropertyUser']['property_user_status_id']) && $message['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance && $message['Property']['user_id'] == $message['Message']['user_id']):
						if (!empty($message['PropertyUser']['Attachment'])) :?>
							<?php echo '<p>'.__l('Attachment from buyer').':</p>';?>
							<span><?php echo $this->Html->link($message['PropertyUser']['Attachment'][0]['filename'], array('controller' => 'property_users', 'action' => 'download', $message['PropertyUser']['Attachment'][0]['id']), array('title' => __l('Click to download this file').': '.$message['PropertyUser']['Attachment'][0]['filename'] )); ?></span>
						<?php endif;?>
						<?php if (!empty($message['PropertyUser']['information_from_buyer'])) :?>
							<?php echo '<p>'.__l('Information from buyer').':</p>';?>
							<?php echo '<p>'.$message['PropertyUser']['information_from_buyer'].'</p>';?>
						<?php endif;?>
						<?php
					endif;
				?>
                <?php
                if (!empty($message['MessageContent']['Attachment'])) :
					?>
					<h4><?php echo count($message['MessageContent']['Attachment']).' '. __l('attachments');?></h4>
					<ul>
					<?php
                    foreach($message['MessageContent']['Attachment'] as $attachment) :
                ?>
					<li>
                	<span class="attachement"><?php echo $attachment['filename']; ?></span>
                	<span><?php echo bytes_to_higher($attachment['filesize']); ?></span>
                    <span><?php echo $this->Html->link(__l('Download') , array( 'action' => 'download', $message['Message']['hash'], $attachment['id'])); ?></span>
					</li>
                <?php
                    endforeach;
				?>
				</ul>
				<?php
                endif;
                ?>
                </div>
            </div>
       </div>
     </div>
	<?php echo $this->Form->end();
?>
</div>
</div>
</div>