<?php  if (!empty($messages)): ?>
  <ol class="unstyled left-space activities-list">
	<?php		
	 $span_size = 'span8 grayc';
        foreach($messages as $message):
       // quick fix for host review message
			if (!empty($message['Message']['property_user_status_id']) && $message['Message']['property_user_status_id'] == ConstPropertyUserStatus::HostReviewed):
				continue;
			endif;
	?>
		<?php if(!empty($message['Message']['property_user_status_id'])):?>
		
			<!-- DISPUTE -->
			<?php if(!empty($message['Message']['property_user_dispute_id']) && ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeOpened || $message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeClosed) && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::NegotiateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::PrivateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::FromTravelerConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::RequestNegotiation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::SecurityDepositRefund):?>
			<?php
				$avatar_positioning_class = "avatar_middle_container";
				$user_type_container_class = "activities_system_container";
			?>
			<li class="bot-space <?php echo $user_type_container_class;?>">
				<div class="row no-mar"> 
				<span data-toggle="popover" data-placement="right" class="date-info blackc textb span3 ">
					<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
				</span>
                <div class="thumbnail no-round pull-right mob-no-mar span11 mob-ps pr">
					<span class="dispute-status dc span2 tab-clr hor-mspace text-11 textb bot-space graydarkerc">
						<?php if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeOpened):?>
						<?php echo __l('Dispute - Opened');?>
					<?php elseif($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeClosed):?>
						<?php echo __l('Dispute - Closed');?>					
					<?php else:?>
						<?php echo __l('Dispute');?>					
					<?php endif;?>
					</span>
					<p class="<?php echo $span_size;?>   clearfix no-mar"> <?php echo $this->Html->cText($message['MessageContent']['subject']);?> </p>
                </div>
              </div>	
			</li>
			<?php endif;?>
			
			<!-- DISPUTE CONVERSATION -->
			<?php if(!empty($message['Message']['property_user_dispute_id']) && ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeConversation || $message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeAdminAction || $message['Message']['property_user_status_id'] == ConstPropertyUserStatus::AdminDisputeConversation) && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::NegotiateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::PrivateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::FromTravelerConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::RequestNegotiation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::SecurityDepositRefund):?>
			<?php
				if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeConversation):
					$status_message = __l('Dispute - Under Discussion');
					if($message['Message']['user_id'] == $message['PropertyUser']['owner_user_id']): // if message is to seller, then, requester is buyer //
						$avatar_positioning_class = "avatar_right_container pull-left";
						$user_type_container_class = "activities_buyer_container";
						$avatar = $message['PropertyUser']['User'];						
					elseif($message['Message']['user_id'] == $message['PropertyUser']['user_id']): // if message is to buyer, then, requester is seller //
						$avatar_positioning_class = "avatar_left_container";
						$user_type_container_class = "activities_seller_container";
						$avatar = $message['Property']['User'];
					endif;
				elseif($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeAdminAction):
					$avatar_positioning_class = "avatar_middle_container";
					$user_type_container_class = "activities_system_container";
					$status_message = __l('Dispute - Waiting for Administrator Decision');
				elseif($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::AdminDisputeConversation):
					$avatar_positioning_class = "avatar_right_container pull-left";
					$user_type_container_class = "activities_buyer_container";
					$avatar = $message['OtherUser'];
				endif;
			?>
			<li class="bot-space <?php echo $user_type_container_class;?>">
				<div class="row no-mar"> 
					<span data-toggle="popover" data-placement="right" class="date-info blackc textb span3 ">
						<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
					</span>
					<div class="thumbnail no-round pull-right mob-no-mar span11 mob-ps pr">
						<span class="waitting-status dc span2 tab-clr hor-mspace text-11 textb bot-space graydarkerc">
							<?php echo $status_message;?>
						</span>
						<div class="<?php echo $span_size;?>    clearfix no-mar"> 
						<?php if($message['Message']['property_user_status_id'] != ConstPropertyUserStatus::DisputeAdminAction):?>
							<div class="<?php echo $avatar_positioning_class;?>">	
								<?php if(!empty($avatar['User']['attachment_id'])):?>
								<cite class="pull-left right-mspace no-pad">
									<?php
										echo $this->Html->getUserAvatarLink($avatar['User'], 'micro_thumb');
									?>
								</cite>
								<?php endif;?>
								<span class="pull-left right-space"><?php echo $this->Html->cText($avatar['username'], false);?></span>
							</div>
						<?php endif;?>
						<div <?php if($message['Message']['property_user_status_id'] != ConstPropertyUserStatus::DisputeAdminAction):?> class="avatar-info-block" <?php endif;?>>
						<?php echo nl2br($this->Html->cText($message['MessageContent']['message'], false));?>
						</div>						
						</div>
					</div>
				</div>			
			</li>
			<?php endif;?>
			
			<!-- WORK DELIVERED/REVIEWED -->
			<?php if(!empty($message['Message']['property_user_status_id']) && ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::WorkDelivered || $message['Message']['property_user_status_id'] == ConstPropertyUserStatus::WorkReviewed) && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::NegotiateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::PrivateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::FromTravelerConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::RequestNegotiation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::SecurityDepositRefund):?>
				<?php
					if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::WorkDelivered):
						$avatar_positioning_class = "avatar_left_container";
						$user_type_container_class = "activities_seller_container";
						$avatar = $message['Property']['User'];
					elseif($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::WorkReviewed):
						$avatar_positioning_class = "avatar_right_container pull-left";
						$user_type_container_class = "activities_buyer_container";
						$avatar = $message['PropertyUser']['User'];
					endif;
				?>
				<li class="bot-space <?php echo $user_type_container_class;?>">	
					<div class="row no-mar"> 
						<span data-toggle="popover" data-placement="right" class="date-info blackc textb span">2 months ago</span>
						<div class="thumbnail no-round pull-right mob-no-mar span11 space mob-ps pr">
							<span class="expired-status dc span2 tab-clr hor-mspace text-11 textb bot-space graydarkerc">
								<?php echo __l('Conversation');?>
							</span>
						  <div class="<?php echo $span_size;?>   clearfix no-mar"> 
							<div class="<?php echo $avatar_positioning_class;?>">	
								<cite class="pull-left right-mspace no-pad">
									<?php
										echo $this->Html->getUserAvatarLink($avatar['User'], 'micro_thumb');
									?>
								</cite>
								<span class="pull-left right-space"><?php echo $this->Html->cText($avatar['username'], false);?></span>
							</div>
		
							<div class="avatar-info-block">
								<blockquote>
								   <?php echo $this->Html->cText($message['MessageContent']['message']);?>
								</blockquote>
								<?php if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::WorkReviewed && !empty($message['PropertyUser']['PropertyFeedback'])):?>
									<?php $rating_class = ($message['PropertyUser']['PropertyFeedback']['is_satisfied']) ? 'positive-feedback' : 'negative-feedback';?>
									(<span class="feedback-list <?php echo $rating_class;?>"><?php echo ($message['PropertyUser']['PropertyFeedback']['is_satisfied']) ? __l('Rated Positive') : __l('Rated Negative');?></span>)
								<?php endif;?>	
								<ul class="attachement-list">
								<?php
									$attachment = !empty($message['MessageContent']['Attachment']['0']) ? $message['MessageContent']['Attachment']['0'] : '';
									if (!empty($message['MessageContent']['Attachment']['0'])) :
										echo "<li>".__l('Attached').': '.$this->Html->link($attachment['filename'] , array( 'controller' => 'messages', 'action' => 'download', $message['Message']['hash'], $attachment['id']))."</li>";
									endif;
								?>
								</ul>
							</div>
						  </div>
						</div>
              </div>
			</li>
			<?php endif;?>
			
			<!-- ORDER STATUS CHANGED -->
			<?php if($message['Message']['property_user_status_id'] != ConstPropertyUserStatus::SenderNotification && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::WorkDelivered  && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::WorkReviewed && empty($message['Message']['property_user_dispute_id']) && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::NegotiateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::PrivateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::FromTravelerConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::RequestNegotiation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::SecurityDepositRefund):?>				
				<?php
					$avatar_positioning_class = '';
					$avatar = array();
					// Avatar positioning //
						$avatar_positioning_class = "avatar_middle_container";
						$user_type_container_class = "activities_system_container";
						if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::CanceledByAdmin):
							$user_type_container_class = "activities_administrator_container";
							$avatar_positioning_class = "avatar_admin_container";
						endif;
					// Eop //
				
				?>
				<?php if($message['Message']['property_user_status_id'] != ConstPropertyUserStatus::Arrived && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::WaitingforReview):?>
				<li class="bot-space <?php echo $message['PropertyUserStatus']['slug'];?> activity-status clearfix <?php echo $user_type_container_class;?>">
					<div class="row no-mar"> 
						<span data-toggle="popover" data-placement="right" class="date-info blackc textb span3 ">
							<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
						</span>
						<div class="thumbnail no-round pull-right mob-no-mar span11 mob-ps pr">
							<span class="waitting-status dc span2 tab-clr hor-mspace text-11 textb bot-space graydarkerc">
								<?php echo $message['PropertyUserStatus']['name'];?>
							</span>
							<p class="<?php echo $span_size;?>  clearfix no-mar"><?php echo $this->Html->conversationDescription($message, 'redc no-mar no-pad');?> </p>
						</div>
					</div>				
				</li>
				<?php endif;?>
				<?php if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::Arrived):?>
					<?php 
						$checked_ins = array('is_auto_checkin' => 'auto_checkin_date', 'is_host_checkin' => 'host_checkin_date', 'is_traveler_checkin' => 'traveler_checkin_date');
						foreach($checked_ins as $key => $value):
							if(!empty($message['PropertyUser'][$key])):?>
								<li class="bot-space <?php echo $user_type_container_class;?>">
								  <div class="row no-mar"> 
									<span data-toggle="popover" data-placement="right" class="date-info blackc textb span3 ">
										<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
									</span>
									<div class="thumbnail no-round pull-right mob-no-mar span11 mob-ps pr">
										<span class="arrive-status dc span2 tab-clr hor-mspace text-11 textb bot-space graydarkerc">		<?php
											if($key == 'is_auto_checkin'):
												echo __l('Arrived - Auto');
											elseif($key == 'is_host_checkin'):
												echo __l('Arrived - Host');
											elseif($key == 'is_traveler_checkin'):
												echo __l('Arrived - Traveler');
											endif;
										?>
										</span>
									  <p class="<?php echo $span_size;?>  clearfix no-mar">
										<?php
												if($key == 'is_auto_checkin'):
													echo __l('Status changed automatically to "Arrived". Changed at') . ' ' . $this->Html->cDateTimeHighlight($message['PropertyUser'][$value]);
												elseif($key == 'is_host_checkin'):
													echo __l('Host changed the status to "Arrived". Changed at') . ' ' . $this->Html->cDateTimeHighlight($message['PropertyUser'][$value]);
												elseif($key == 'is_traveler_checkin'):
													echo __l('Traveler changed the status to "Arrived". Changed at') . ' ' . $this->Html->cDateTimeHighlight($message['PropertyUser'][$value]);
												endif;
											?>
										</p>
									</div>
								  </div>								
								</li>
							<?php endif;						
						endforeach;					
					?>					
				<?php endif;?>
				<?php if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforReview):?>
					<?php 
						$checked_outs = array('is_auto_checkout' => 'auto_checkout_date', 'is_host_checkout' => 'host_checkout_date', 'is_traveler_checkout' => 'traveler_checkout_date');
						foreach($checked_outs as $key => $value):
							if(!empty($message['PropertyUser'][$key])):?>
								<li class="bot-space activities-status_<?php echo $message['PropertyUserStatus']['slug'];?>  <?php echo $user_type_container_class;?>">
								  <div class="row no-mar"> 
									<span data-toggle="popover" data-placement="right" class="date-info blackc textb span3 ">
										<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
									</span>
									<div class="thumbnail no-round pull-right mob-no-mar span11 mob-ps pr">
										<span class="waitting-status dc span2 tab-clr hor-mspace text-11 textb bot-space graydarkerc">
										<?php
											if($key == 'is_auto_checkout'):
												echo __l('Checked Out - Auto');
											elseif($key == 'is_host_checkout'):
												echo __l('Checked Out - Host');
											elseif($key == 'is_traveler_checkout'):
												echo __l('Checked Out - Traveler');
											endif;
										?>
										</span>
									  <p class="<?php echo $span_size;?>  clearfix no-mar">
											<?php
												if($key == 'is_auto_checkout'):
													echo __l('Status changed automatically to "Checked Out". Changed at') . ' ' . $this->Html->cDateTimeHighlight($message['PropertyUser'][$value]);
												elseif($key == 'is_host_checkout'):
													echo __l('Host changed the status to "Checked Out". Changed at') . ' ' . $this->Html->cDateTimeHighlight($message['PropertyUser'][$value]);
												elseif($key == 'is_traveler_checkout'):
													echo __l('Traveler changed the status to "Checked Out"') . ' ' . $this->Html->cDateTimeHighlight($message['PropertyUser'][$value]);
												endif;
											?>
										</p>
									</div>
								  </div>								
								</li>
							<?php endif;						
						endforeach;					
					?>					
				<?php endif;?>
			<?php endif;?>
			<!-- NEGOTIATE -->
			<?php if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::NegotiateConversation):?>				
				<?php
					$avatar_positioning_class = '';
					$avatar = array();
					if($message['Message']['user_id'] == $message['PropertyUser']['owner_user_id']): // if message is to seller, then, requester is buyer //
						$avatar_positioning_class = "avatar_right_container pull-left";
						$user_type_container_class = "activities_buyer_container";
						$avatar = $message['PropertyUser']['User'];
						
					elseif($message['Message']['user_id'] == $message['PropertyUser']['user_id']): // if message is to buyer, then, requester is seller //
						$avatar_positioning_class = "avatar_left_container";
						$user_type_container_class = "activities_seller_container";
						$avatar = $message['Property']['User'];						
					endif;
				
				?>
				
				<li class="bot-space <?php echo $user_type_container_class;?>">
				
			  <div class="row no-mar"> 
				<span data-toggle="popover" data-placement="right" class="date-info blackc textb span3 ">
					<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
				</span>
				<div class="thumbnail no-round pull-right mob-no-mar span11 mob-ps pr">
					<span class="negotiation-status dc span2 tab-clr hor-mspace text-11 textb bot-space graydarkerc">		<?php echo __l('Negotiation Conversation')?>
					</span>
				 <div class="<?php echo $span_size;?>  clearfix no-mar">
					<?php if($avatar_positioning_class == "avatar_left_container" || $avatar_positioning_class == "avatar_right_container pull-left"):?>
						<span class="<?php echo $avatar_positioning_class;?> hor-mspace">	
							<cite class="pull-left right-mspace no-pad">
								<?php
									echo $this->Html->getUserAvatarLink($avatar['User'], 'micro_thumb');
								?>
							</cite>
							<?php if($message['PropertyUser']['user_id'] == $message['Message']['user_id']){ ?>
							<span class="pull-left right-space"><?php
								echo $this->Html->cText($avatar['username'], false);?></span>
							<?php if(!empty($message['PropertyUser']['negotiation_discount'])): ?>
								<span><?php echo __l('Offered discount') . ' ' . $this->Html->cFloat($message['PropertyUser']['negotiation_discount']) . '%';?></span>
							<?php endif;
								}?>
						</span>
					<?php endif;?>
					<div class="clearfix">
					<span class="hor-space">
					   <?php echo $this->Html->cText($message['MessageContent']['message']);?>
					</span>
					<?php
						if(isset($message['MessageContent']['Attachment']['0'])){
						$attachment = $message['MessageContent']['Attachment']['0'];
						if (!empty($message['MessageContent']['Attachment']['0'])) : ?>
							<ul class="attachement-list">
							<?php echo "<li>".__l('Attached').': '.$this->Html->link($attachment['filename'] , array( 'controller' => 'messages', 'action' => 'download', $message['Message']['hash'], $attachment['id']))."</li>"; ?>
							</ul>
							<?php
						endif;
						}
					?>
					</div>										
					</div>
				</div>
			  </div>				
				
		</li>
		<?php endif;?>
		<!-- PRIVATE NOTE -->
		<?php if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::PrivateConversation && $message['Message']['user_id'] == $this->Auth->user('id')):?>				
				<?php
					$avatar_positioning_class = "avatar_right_container pull-left";
					$user_type_container_class = "activities_buyer_container";
					$avatar = $message['User'];					
				?>
				
				<li class="bot-space <?php echo $user_type_container_class;?>">
				  <div class="row no-mar"> 
					<span data-toggle="popover" data-placement="right" class="date-info blackc textb span3 ">
						<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
					</span>
					<div class="thumbnail no-round pull-right mob-no-mar span11 mob-ps pr">
						<span class="conform-status dc span2 tab-clr hor-mspace text-11 textb bot-space graydarkerc">
						<?php echo __l('Private Note'); ?>
						</span>
					  <div class="<?php echo $span_size;?>  clearfix no-mar">
						<?php if($avatar_positioning_class == "avatar_left_container" || $avatar_positioning_class == "avatar_right_container pull-left"):?>
							<div class="<?php echo $avatar_positioning_class;?>">	
								<?php if(!empty($avatar['UserAvatar']['id'])):?>
								<cite class="pull-left right-mspace no-pad">
									<?php 
										echo $this->Html->getUserAvatarLink($avatar, 'micro_thumb');
									?>
								</cite>
								<?php endif;?>
								<span class="pull-left right-space"><?php echo $this->Html->cText($avatar['username'], false);?></span>
							</div>
						<?php endif;?>
						<div class="">
						   <?php echo $this->Html->cText($message['MessageContent']['message']);?>
						<ul class="attachement-list">
						<?php
							if(isset($message['MessageContent']['Attachment']['0'])){
							$attachment = $message['MessageContent']['Attachment']['0'];
							if (!empty($message['MessageContent']['Attachment']['0'])) :
								echo "<li>".__l('Attached').': '.$this->Html->link($attachment['filename'] , array( 'controller' => 'messages', 'action' => 'download', $message['Message']['hash'], $attachment['id']))."</li>";
							endif;
							}
						?>
						</ul>
						</div>
						</div>
					</div>
				  </div>				
		</li>
		<?php endif;?>
		<?php if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::RequestNegotiation):?>				
				<?php
					$avatar_positioning_class = "avatar_right_container pull-left";
					$user_type_container_class = "activities_buyer_container";
					$avatar = $message['User'];					
				?>
				
				<li class="bot-space <?php echo $user_type_container_class;?>">
				  <div class="row no-mar"> 
					<span data-toggle="popover" data-placement="right" class=" blackc textb span2 ">
						<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
					</span>
					<div class="thumbnail no-round pull-right mob-no-mar span11 mob-ps pr">
						<span class="negotiation-status dc span2 tab-clr hor-mspace text-11 textb bot-space graydarkerc">
							<?php echo __l('Private Note'); ?>
						</span>
					  <div class="<?php echo $span_size;?>  clearfix no-mar">
					<?php if($avatar_positioning_class == "avatar_left_container" || $avatar_positioning_class == "avatar_right_container pull-left"):?>
						<div class="<?php echo $avatar_positioning_class;?>">	
							<?php if(!empty($avatar['UserAvatar']['id'])):?>
							<cite class="pull-left right-mspace no-pad">
								<?php
									echo $this->Html->getUserAvatarLink($avatar, 'micro_thumb');
								?>
							</cite>
							<?php endif;?>
							<span class="pull-left right-space"><?php echo $this->Html->cText($avatar['username'], false);?></span>
						</div>
					<?php endif;?>
					<div class="">
					   <?php echo $this->Html->cText($message['MessageContent']['message']);?>
					<ul class="attachement-list">
					<?php
						if(isset($message['MessageContent']['Attachment']['0'])){
						$attachment = $message['MessageContent']['Attachment']['0'];
						if (!empty($message['MessageContent']['Attachment']['0'])) :
							echo "<li>".__l('Attached').': '.$this->Html->link($attachment['filename'] , array( 'controller' => 'messages', 'action' => 'download', $message['Message']['hash'], $attachment['id']))."</li>";
						endif;
						}
					?>
					</ul>
					</div>						</div>
					</div>
				  </div>				
		</li>
		<?php endif;?>
		<!-- MESSAGE FROM TRAVELER -->
		<?php if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::FromTravelerConversation):?>				
				<?php
					$avatar_positioning_class = '';
					$avatar = array();
					if($message['Message']['user_id'] == $message['PropertyUser']['owner_user_id']): // if message is to seller, then, requester is buyer //
						$avatar_positioning_class = "avatar_right_container pull-left";
						$user_type_container_class = "activities_buyer_container";
						$avatar = $message['PropertyUser']['User'];
						
					elseif($message['Message']['user_id'] == $message['PropertyUser']['user_id']): // if message is to buyer, then, requester is seller //
						$avatar_positioning_class = "avatar_left_container";
						$user_type_container_class = "activities_seller_container";
						$avatar = $message['Property']['User'];						
					endif;			
				?>
				
				<li class="bot-space<?php echo $user_type_container_class;?>">
				  <div class="row no-mar"> 
					<span data-toggle="popover" data-placement="right" class="date-info blackc textb span3 ">
						<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
					</span>
					<div class="thumbnail no-round pull-right mob-no-mar span11 mob-ps pr">
						<span class="conform-status dc span2 tab-clr hor-mspace text-11 textb bot-space graydarkerc">
							<?php echo __l('From Traveler'); ?>
						</span>
					  <div class="<?php echo $span_size;?>   clearfix no-mar">
					<?php if($avatar_positioning_class == "avatar_left_container" || $avatar_positioning_class == "avatar_right_container pull-left"):?>
						<div class="<?php echo $avatar_positioning_class;?>">	
							<cite class="pull-left right-mspace no-pad">
								<?php 
									echo $this->Html->getUserAvatarLink($avatar, 'micro_thumb');
								?>
							</cite>
							<span class="pull-left right-space"><?php echo $this->Html->cText($avatar['username'], false);?></span>
						</div>
					<?php endif;?>
					<div class="">
					   <?php echo $this->Html->cText($message['MessageContent']['message']);?>
					<ul class="attachement-list">
					<?php
						if(isset($message['MessageContent']['Attachment']['0'])){
						$attachment = $message['MessageContent']['Attachment']['0'];
							if (!empty($message['MessageContent']['Attachment']['0'])) :
								echo "<li>".__l('Attached').': '.$this->Html->link($attachment['filename'] , array( 'controller' => 'messages', 'action' => 'download', $message['Message']['hash'], $attachment['id']))."</li>";
							endif;
						}
					?>
					</ul>
					</div>
					</div>
					</div>
				  </div>		
		</li>
		<?php endif;?>
		<?php else:?>
		
		<!-- NORMAL CONVERSATION -->
		<?php
			$avatar_positioning_class = '';
			$avatar = array();
			if($message['Message']['user_id'] == $message['PropertyUser']['owner_user_id']): // if message is to seller, then, requester is buyer //
				$avatar_positioning_class = "avatar_right_container pull-left";
				$user_type_container_class = "activities_buyer_container";
				$avatar = $message['PropertyUser']['User'];
				$status_name = __l('Mutual cancel request');
			elseif($message['Message']['user_id'] == $message['PropertyUser']['user_id']): // if message is to buyer, then, requester is seller //
				$avatar_positioning_class = "avatar_left_container";
				$user_type_container_class = "activities_seller_container";
				$avatar = $message['Property']['User'];
				$status_name = __l('Mutual cancel request');
			endif;
		?>
		<li class="bot-space <?php echo $user_type_container_class;?>">
			  <div class="row no-mar"> 
				<span data-toggle="popover" data-placement="right" class="date-info blackc textb span3 ">
					<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
				</span>
				<div class="thumbnail no-round pull-right mob-no-mar span11 mob-ps pr">
					<span class="conform-status dc span2 tab-clr hor-mspace text-11 textb bot-space graydarkerc">
						<?php echo __l('Conversation'); ?>
					</span>
				  <div class="<?php echo $span_size;?>   clearfix no-mar">
					<?php if($avatar_positioning_class == "avatar_left_container" || $avatar_positioning_class == "avatar_right_container pull-left"):?>
						<div class="<?php echo $avatar_positioning_class;?>">	
							<cite class="pull-left right-mspace no-pad">
								<?php 
									echo $this->Html->getUserAvatarLink($avatar['User'], 'micro_thumb', true, 'redc no-mar no-pad span');
								?>
							</cite>
							<span class="pull-left right-space"><?php echo $this->Html->cText($avatar['username'], false);?></span>
						</div>
					<?php endif;?>
					<div class="">
					   <?php echo $this->Html->cText($message['MessageContent']['message']);?>
					<ul class="attachement-list">
					<?php
						$attachment = $message['MessageContent']['Attachment']['0'];
						if (!empty($message['MessageContent']['Attachment']['0'])) :
							echo "<li>".__l('Attached').': '.$this->Html->link($attachment['filename'] , array( 'controller' => 'messages', 'action' => 'download', $message['Message']['hash'], $attachment['id']))."</li>";
						endif;
					?>
					</ul>
					</div>
					</div>
				</div>
			  </div>		
		</li>
		<?php endif;?>
        <?php
        endforeach;
		
	?>
</ol>
<?php if (!empty($messages)): ?>
	<section>
		<div class="pull-left space">
			<?php echo $this->Html->link(__l('See all activities'), array('controller' => 'messages', 'action' => 'notifications', 'type' => 'list', 'admin' => false), array('class' => 'linkc top-mspace','escape' => false));?>
		</div>
		<div class="pull-right space">
			<?php echo $this->Html->link(__l('Clear activities'), array('controller' => 'messages', 'action' => 'clear_activities', 'admin' => false, 'final_id' => $final_id['Message']['id']), array('class' => 'mspace js-no-pjax btn','escape' => false));?>
		</div>
    </section>
<?php endif; 
	else: ?><ol class="unstyled">
				<li class="space dc grayc">
					<p class="ver-mspace top-space text-16 "><?php echo __l('No Activities available'); ?></p>
				</li>
				</ol>
			<?php
endif; ?>