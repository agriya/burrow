<div class="propertyFeedbacks  form clearfix">

		<ol class="span24 unstyled prop-list-mob prop-list no-mar" >
		<li class="span24 clearfix ver-space sep-bot mob-no-mar js-map-num no-mar">
               
              
                <div class="span hor-mspace dc mob-no-mar">
				<?php echo $this->Html->showImage('Property', $propertyInfo['Property']['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($propertyInfo['Property']['title'], false)), 'title' => $this->Html->cText($propertyInfo['Property']['title'],false)));?>
				</div>
                <div class="span20 pull-right no-mar mob-clr tab-clr">
                  <div class="clearfix left-mspace sep-bot">
                    <div class="span bot-space no-mar">
                      <h4 class="textb text-16">
        		<?php 
				$attachment = array('id'=>$propertyInfo['Property']['User']['attachment_id']);
				?>					  
						<?php echo $this->Html->link($this->Html->cText($propertyInfo['Property']['title'],false), array('controller' => 'properties', 'action' => 'view', $propertyInfo['Property']['slug']), array('target' => '_blank', 'title' => $this->Html->cText($propertyInfo['Property']['title'], false),'escape' => false, 'class' => 'js-bootstrap-tooltip htruncate span11'));?>
					  </h4>
                      <a href="#" class="graydarkc top-smspace mob-clr htruncate span8 js-bootstrap-tooltip" title="<?php echo $this->Html->cText($propertyInfo['Property']['address'], false);?>">
					  <?php if(!empty($propertyInfo['Property']['Country']['iso_alpha2'])): ?>
						<span class="flags flag-<?php echo strtolower($propertyInfo['Property']['Country']['iso_alpha2']); ?> mob-inline top-smspace" title="<?php echo $this->Html->cText($propertyInfo['Property']['Country']['name'], false); ?>"> <?php echo $this->Html->cText($propertyInfo['Property']['Country']['name'], false); ?></span>
					  <?php endif; ?>
					  <?php echo $this->Html->cText($propertyInfo['Property']['address'], false);?></a> 				  
					</div>
                    <div class="pull-right sep-left mob-clr mob-sep-none">
                      <dl class="dc list span mob-clr">
                        <dt class="pr hor-mspace text-11"><?php echo __l('Per night');?></dt>
                        <dd class="textb text-24 graydarkc pr hor-mspace">
						<?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
							<?php echo Configure::read('site.currency').' '?>
						<?php endif; ?>
						<?php echo $this->Html->cCurrency($propertyInfo['Property']['price_per_night']);?>
						<?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
							 <?php echo ' '.Configure::read('site.currency'); ?>
						<?php endif; ?>
					</dd>
                      </dl>
                      <dl class="dc list span mob-clr">
						<dt class="pr hor-mspace text-11" ><?php echo __l('Per Week');?></dt>
						<dd class="text-11 top-space graydarkc pr hor-mspace" >
							<?php
								if ($propertyInfo['Property']['price_per_week']!=0):
									echo $this->Html->siteCurrencyFormat($propertyInfo['Property']['price_per_week']);
								else:
									echo $this->Html->siteCurrencyFormat($propertyInfo['Property']['price_per_night']*7);
								endif;
							?>
						</dd>
                      </dl>
                      <dl class="dc list span mob-clr">
						<dt class="pr hor-mspace text-11" ><?php echo __l('Per Month');?></dt>
						<dd class="text-11 top-space graydarkc pr hor-mspace" >
							<?php
								if ($propertyInfo['Property']['price_per_month']!=0):
									echo $this->Html->siteCurrencyFormat($propertyInfo['Property']['price_per_month']);
								else:
									echo $this->Html->siteCurrencyFormat($propertyInfo['Property']['price_per_night']*30);
								endif;
							?>
						</dd>
                      </dl>
                    </div>
                  </div>
                  <div class="clearfix left-mspace">
                    
                    <div class="clearfix pull-right top-mspace mob-clr">
					  
                      <dl class="dc mob-clr sep-right list">
                        <dt class="pr hor-mspace text-11" ><?php echo __l('Views');?></dt>
                        <dd class="textb text-16 no-mar graydarkc pr hor-mspace js-view-count-property-id js-view-count-property-id-<?php echo $propertyInfo['Property']['id']; ?> {'id':'<?php echo $propertyInfo['Property']['id']; ?>"><?php echo numbers_to_higher($propertyInfo['Property']['property_view_count']); ?></dd>
                      </dl>
                      <dl class="dc mob-clr sep-right list">
                        <dt class="pr hor-smspace text-11" ><?php echo __l('Positive');?></dt>
                        <dd  class="textb text-16 no-mar graydarkc pr hor-mspace"><?php echo numbers_to_higher($propertyInfo['Property']['positive_feedback_count']); ?></dd>
                      </dl>
                      <dl class="dc mob-clr sep-right list">
                        <dt class="pr hor-mspace text-11"><?php echo __l('Negative');?></dt>
                        <dd class="textb text-16 no-mar graydarkc pr hor-mspace"><?php echo numbers_to_higher($propertyInfo['Property']['property_feedback_count'] - $propertyInfo['Property']['positive_feedback_count']); ?></dd>
                      </dl>

          <?php
		  if($propertyInfo['Property']['property_user_count']!=0 && $propertyInfo['Property']['property_user_failure_count']!=0){
						$total_completed  = $propertyInfo['Property']['property_user_success_count']+$propertyInfo['Property']['property_user_failure_count'];
						$success_rate = ($total_completed/$propertyInfo['Property']['property_user_count'])*100 ;
						$on_time_rate = ($propertyInfo['Property']['property_user_success_count']/$total_completed)*100 ;
						$success_rate  = ($success_rate > 100)? 100 : $success_rate;
						$on_time_rate  = ($on_time_rate > 100)? 100 : $on_time_rate;
					?>
             <p class="property-stats-bar-block clearfix"> <span>
                 <?php if(($propertyInfo['Property']['property_user_count']) == 0): ?>
  			        <?php echo sprintf(__l('Success Rate: ').'<span class="stats-val">%s</span>', __l(' Success Rate')); ?>
                  <?php else: ?>
                      <?php echo sprintf(__l('Success Rate: ').'<span class="stats-val">%s/%s</span>', $this->Html->cInt($total_completed),$this->Html->cInt($propertyInfo['Property']['property_user_count'])); ?> <?php echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.round($success_rate).','.(100 - round($success_rate)).'&amp;chs=45x45&amp;chco=8DCA35|F47564', array('title' => round($success_rate).'%')); ?>
                          <?php if($total_completed == 0): ?>
                                  <span class="ontime-info"> (<?php echo sprintf(__l('On Time: ').'<span class="stats-val">%s</span>', __l('Still no booking'));  ?> )  </span>
                            <?php else: ?>
                                   <span class="ontime-info"> (<?php echo sprintf(__l('On Time: ').'<span class="stats-val">%s/%s</span>', $this->Html->cInt($propertyInfo['Property']['property_user_success_count']),$this->Html->cInt($total_completed)); ?> <?php echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.round($on_time_rate).','.(100 - round($on_time_rate)).'&amp;chs=45x45&amp;chco=8DCA35|F47564', array('title' => round($on_time_rate).'%')); ?> )   </span>
                           <?php endif; ?>
                   <?php endif; ?>
              </span> </p>
<?php
		  }else{
?>
		  <dl class="dc mob-clr sep-right list">
    				    <dt  class="pr mob-clr hor-mspace text-11" title ="<?php echo __l('Still no booking');?>"><?php echo __l('Success Rate');?></dt>
                          <dd class="textb text-16 no-mar graydarkc pr hor-mspace" title="<?php  echo __l('No Bookings available'); ?>">
                        <?php  echo __l('n/a'); ?>
                      </dd>
    		   </dl>
   <?php } ?>					  
                    </div>
                  </div>
                </div>
              </li>
			  </ol>
<?php echo $this->Form->create('PropertyUserFeedback', array('class' => 'form-horizontal space'));?>

	<div class="top-space massage-view-block clearfix">
	<?php
		//pr($message);
		echo $this->Form->input('property_id',array('type'=>'hidden','value' => $message['property_id']));
		echo $this->Form->input('property_user_user_id',array('type'=>'hidden','value' => $message['property_user_user_id']));
		echo $this->Form->input('traveler_user_id',array('type'=>'hidden','value' => $message['property_user_user_id']));
		echo $this->Form->input('host_user_id',array('type'=>'hidden','value' => $this->Auth->user('id')));
		echo $this->Form->input('property_order_id',array('type'=>'hidden','value' => $message['property_order_id']));
		echo $this->Form->input('property_user_id',array('type'=>'hidden','value' => $message['property_user_id']));
		echo $this->Form->input('property_order_user_email',array('type'=>'hidden','value' => $message['property_traveler_email']));
		?>
	<div class="massage-head top-space clearfix">
	<h3 class="well space textb text-16">
		<?php echo __l('Review and rate this Traveler');?>
    </h3>
	<div>
		<?php 		
			$checkin_date = strtotime($propertyInfo['PropertyUser']['checkin']);
			$checkout_date = strtotime(getCheckoutDate($propertyInfo['PropertyUser']['checkout']));
			$days = getCheckinCheckoutDiff($propertyInfo['PropertyUser']['checkin'], getCheckoutDate($propertyInfo['PropertyUser']['checkout']));
			if (strtotime($propertyInfo['Property']['checkin']) > 0) {
				$checkin_time = date('h:i a',strtotime($propertyInfo['Property']['checkin']));
			} else {
				$checkin_time = '';
			}
			if (strtotime($propertyInfo['Property']['checkout']) > 0) {
				$checkout_time = date('h:i a',strtotime($propertyInfo['Property']['checkout']));
			} else {
				$checkout_time = '';
			}

		?>
		<div class="offset5 clearfix bot-space">
			<dl class="dc span mob-clr">
                  <dt class="pr hor-mspace text-12 textb">
    	   <?php
				echo $this->Html->getUserAvatarLink($traveler['User'], 'small_thumb');
			?>
			</dt>
			<dd class="text-12 top-space graydarkc pr hor-mspace">
    	   <?php echo $this->Html->link($this->Html->cText($traveler['User']['username'],false), array('controller' => 'users', 'action' => 'view', $traveler['User']['username']), array('escape' => false));?>
    	   </dd>
		   </dl>
			<dl class="dc span mob-clr">
              <dd class="text-12 top-space graydarkc pr hor-mspace">
        		<?php echo date('D, d M Y', $checkin_date); ?>
			</dd>
			<dt class="pr hor-mspace textn top-space text-12">								
        		<?php echo $checkin_time; ?>
    	   </dt>
		   </dl>
			<dl class="dc span mob-clr offset2 top-space">
               <dt class="pr hor-mspace text-12" ><?php echo '(' . $days . ' - ' . __l('nights') . ')'; ?></dt>
				<dd class="text-12 top-space graydarkc pr hor-mspace" >
					
				</dd>
			</dl>
			<dl class="dc span mob-clr offset2">						
				<dd class="text-12 top-space graydarkc pr hor-mspace" >
            	<?php echo date('D, d M Y', $checkout_date); ?>
				</dd>
				<dt class="pr hor-mspace text-12 textn top-space" >
        		<?php echo $checkout_time; ?>				
    		</dt>
		   </dl>
		</div>
	</div>
    <?php
		//$replace = array('##REVIEW##' => '', '##NEWORDER##' => '');
		//$message_content =  strtr($message['message'],$replace);
	?>
	<?php
		if (!empty($message['attachment'])) :
			?>
			<h4><?php echo count($message['attachment']).' '. __l('attachments');?></h4>
			<ul>
			<?php
			foreach($message['attachment'] as $attachment) :
		?>
			<li>
			<span class="attachement"><?php echo $attachment['filename']; ?></span>
			<span><?php echo bytes_to_higher($attachment['filesize']); ?></span>
			<span><?php echo $this->Html->link(__l('Download') , array( 'controller' => 'messages', 'action' => 'download', $message['message_hash'], $attachment['id'])); ?></span>
			</li>
		<?php
			endforeach;
		?>
		</ul>
		<?php
		endif;
		?> 		</div>
		<fieldset>
	<div class="propertys-download-block">
        <div class="clearfix">
		<h3 class="well space textb text-16"> <?php echo __l('Are you satisfied this traveler?');?></h3>
		<div class="radio-active-style">
		<?php
			echo $this->Form->input('is_satisfied',array('label' => __l('Satisfied'),'div'=>'input radio feedback-block ', 'type'=>'radio','legend'=>false,'options'=>array('1'=>__l('Yes'),'0'=>__l('No')),'class' => '' ));
		?>
		</div>
        </div>
		<div class="js-negative-block <?php echo ($this->request->data['PropertyUserFeedback']['is_satisfied'] == 0) ? '' : 'hide'; ?>">
			<p class="negative-block-info"><?php echo __l('Please give your host a chance to improve his work before submitting a negative review. ').' '.$this->Html->link(__l('Contact Your Seller'), array('controller'=>'messages','action'=>'compose','type' => 'contact','to' => $message['property_seller_username'],'property_order_id' => $message['property_order_id'], 'review' => '1'), array('title' => __l('Contact Your Seller')));?></p>
		</div>
		<?php
			echo $this->Form->input('feedback',array('label' => __l('Review')));
		?>
	</div>  
	</fieldset>

		<div class="form-actions">
<?php echo $this->Form->submit(__l('Submit'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
</div>
</div>
<?php echo $this->Form->end();?>

</div>