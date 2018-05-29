<?php /* SVN: $Id: $ */ ?>
    <h2 class="top-space top-mspace sep-bot"><?php echo __l('Mail');?></h2>
		<section class="row top-space top-mspace">	
		<aside>
        <?php echo $this->element('message_message-left_sidebar', array('config' => 'sec')); ?>
        </aside>
<section class="span bot-mspace user-dashboard sep mob-sep-none mob-no-pad message-block tab-no-mar span22">
	<?php
        echo $this->Form->create('Message', array('action' => 'move_to','class' => 'form-horizontal'));
        echo $this->Form->hidden('folder_type', array('value' => $folder_type,'name' => 'data[Message][folder_type]'));
        echo $this->Form->hidden('is_starred', array('value' => $is_starred,'name' => 'data[Message][is_starred]'));
        echo $this->Form->hidden("Message.Id." . $message['Message']['id'], array('value' => '1'));
    ?>
    <div class="mail-main-curve">
			<p class="well space textb text-16 span21 top-mspace">
			<?php
                if (!empty($is_starred)) :
                    echo $this->Html->link(__l('Back to Starred') , array('controller' => 'messages','action' => 'starred'), array('class' => 'backto'));
                else :
                    echo $this->Html->link(__l('Back to') . ' ' . $back_link_msg, array('controller' => 'messages','action' => $folder_type), array('class' => 'backto'));
                endif;
            ?>
			</p>
           
			   <div class="js-show-mail-detail-div show-mail">
				<dl class="dl-horizontal space">
				<?php
                    if ($message['Message']['is_sender'] == 0) : ?>
						<dt class="bot-space top-space"><?php echo __l('From').': ';  ?></dt>
						<dd class="bot-space"><?php echo $message['OtherUser']['username']; ?></dd>	  
                    <?php
                    else : ?>
						<dt class="bot-space"><?php echo __l('From').': ';  ?></dt>
						<dd class="bot-space"><?php echo $message['User']['username']; ?> < <?php echo $message['User']['email']; ?> ></dd>
        			<?php
                    endif; ?>
						<dt class="bot-space"><?php echo __l('To').': ';  ?></dt>
						<dd class="bot-space"><?php echo $show_detail_to; ?></dd>
						<dt class="bot-space"><?php echo __l('Date').': ';  ?></dt>
						<dd class="bot-space"><?php echo $this->Html->cDateTimeHighlight($message['Message']['created']); ?> (<?php echo $this->Time->timeAgoInWords($message['Message']['created']); ?>)</dd>
						<?php if (!empty($message['Message']['property_id'])) :?>
						<dt class="bot-space"><?php echo __l('Property').':'.' '; ?></dt>
						<dd class="bot-space"><?php echo $this->Html->link($message['Property']['title'], array('controller' => 'properties', 'action' => 'view', $message['Property']['slug']), array('title' => $message['Property']['title']));?></dd>
						<?php endif;?>
					<?php if (!empty($message['Message']['request_id']) && isPluginEnabled('Requests')) :?>
						<dt class="bot-space"><?php echo __l('Request').':'.' '; ?></dt>
						<dd class="bot-space"><?php echo $this->Html->link($message['Request']['title'], array('controller' => 'requests', 'action' => 'view', $message['Request']['slug']), array('title' => $message['Request']['title']));?></dd>
					<?php endif;?>
					<?php if (!empty($message['Message']['property_user_id'])) :?>
						<dt class="bot-space"><?php echo __l('Activity').':'.' '; ?></dt>
						<dd class="bot-space"><?php echo $this->Html->link($message['Message']['property_user_id'], array('controller' => 'messages', 'action' => 'activities', 'order_id' => $message['Message']['property_user_id']), array('title' => $message['Message']['property_user_id']));?></dd>
					<?php endif; ?>
						<dt class="bot-space"><?php echo __l('Subject').': ';  ?></dt>
						<dd class="bot-space"><?php echo $this->Html->cText($message['MessageContent']['subject']); ?></dd>
					</dl>
				</div>
                <div class="message-inner-content">
					<?php
						$this->loadHelper('Text');
						if (!empty($message['Message']['property_user_status_id']) && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::FromTravelerConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::PrivateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::NegotiateConversation):
							echo nl2br($this->Text->autoLinkUrls($message['MessageContent']['message']));
						else:
							echo $this->Html->cHtml(nl2br($this->Text->autoLinkUrls($message['MessageContent']['message'])));
						endif;
				 ?>
                </div>
				<?php if(ConstUserTypes::Admin != $message['OtherUser']['role_id'] && empty($message['Message']['is_sender'])): ?>
					<div class="clearfix space pull-right">
						<?php echo $this->Html->link(__l('Reply') , array('controller' => 'messages','action' => 'compose',$message['Message']['id'],'reply'), array('escape' => false,'class'=>'btn btn-primary textb text-16')); ?>
					</div>
				<?php endif;?>
                <div class="download-block bot-mspace">
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
                    <span><?php echo $this->Html->link(__l('Download') , array( 'action' => 'download', $message['Message']['id'], $attachment['id'])); ?></span>
					</li>
                <?php
                    endforeach;
				?>
				</ul>
				<?php
                endif;
                ?>
                </div>       
	 <p class="well space textb text-16 span21 top-mspace bot-mspace">
    <?php
    if (!empty($is_starred)) :
        echo $this->Html->link('Back to Starred', array('controller' => 'messages','action' => 'starred'), array('class' => 'backto'));
    else :
        echo $this->Html->link(__l('Back to') . ' ' . $back_link_msg, array(
            'controller' => 'messages',
            'action' => $folder_type
        ), array('class' => 'backto'));
    endif;
    ?>
</p>
	<?php echo $this->Form->end(); ?>

	</div>
</section>
</section>