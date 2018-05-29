<?php /* SVN: $Id: $ */ ?>
<?php //echo "<pre>"; print_r($propertyInfo); exit; ?>
<div class="propertyFeedbacks  form clearfix">

<div class="clearfix">
	

		<div class="top-space">
		<ol class="span24 unstyled prop-list-mob prop-list no-mar" >
		<li class="span24 clearfix ver-space sep-bot mob-no-mar js-map-num no-mar">
               
              
                <div class="span hor-mspace dc mob-no-mar">
				<?php echo $this->Html->showImage('Property', $propertyInfo['Property']['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($propertyInfo['Property']['title'], false)), 'title' => $this->Html->cText($propertyInfo['Property']['title'],false)));?>
				</div>
                <div class="span20 pull-right no-mar mob-clr tab-clr">
                  <div class="clearfix left-mspace sep-bot">
                    <div class="span bot-space no-mar">
                      <h4 class="textb text-16">
						<?php echo $this->Html->link($this->Html->cText($propertyInfo['Property']['title'],false), array('controller' => 'properties', 'action' => 'view', $propertyInfo['Property']['slug']), array('target' => '_blank', 'title' => $this->Html->cText($propertyInfo['Property']['title'], false),'escape' => false, 'class' => 'graydarkc span9 js-bootstrap-tooltip htruncate'));?>
					  </h4>
                      <a href="#" class="graydarkc top-smspace show mob-clr dc" title="<?php echo $propertyInfo['Property']['address'];?>">
					  <?php if(!empty($propertyInfo['Country']['iso_alpha2'])): ?>
						<span class="flags flag-in mob-inline top-smspace" title="<?php echo $propertyInfo['Country']['name']; ?>"><?php echo $propertyInfo['Country']['name']; ?></span>
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
                      <dl class="dc mob-clr sep-right list">
                        <dt class="pr mob-clr hor-mspace text-11"><?php echo __l('Success Rate');?></dt>
						<?php if(empty($propertyInfo['Property']['property_feedback_count'])){ ?>
							<dd  class="textb text-16 no-mar graydarkc pr hor-mspace">n/a</dd>
						<?php }else{ ?>
						<dd class="textb text-16 no-mar graydarkc pr hor-mspace">
							<?php
								if(!empty($propertyInfo['Property']['positive_feedback_count'])){
									$positive = floor(($propertyInfo['Property']['positive_feedback_count']/$propertyInfo['Property']['property_feedback_count']) *100);
									$negative = 100 - $positive;
								}else{
									$positive = 0;
									$negative = 100;
								}
								echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=8DCA35|F47564&amp;chf=bg,s,FFFFFF00', array('width'=>'35px','height'=>'35px','title' => $positive.'%'));
							?>
						</dd>
						<?php } ?>
						</dl>
					
					  
                    </div>
                  </div>
                </div>
              </li>
			  </ol>
			  </div>
			  </div>
		
<?php echo $this->Form->create('PropertyFeedback', array('class' => 'form-horizontal','enctype' => 'multipart/form-data'));?>

	<div class="top-space sep-bot massage-view-block clearfix">
	<h3 class="well space textb text-16 no-mar"><?php echo __l('Review this property and host');?></h3>
	<?php
		//pr($message);
		echo $this->Form->input('property_id',array('type'=>'hidden','value' => $message['property_id']));
		echo $this->Form->input('property_user_user_id',array('type'=>'hidden','value' => $message['property_user_user_id']));
		echo $this->Form->input('user_id',array('type'=>'hidden','value' => $this->Auth->user('id')));
		echo $this->Form->input('property_order_id',array('type'=>'hidden','value' => $message['property_order_id']));
		echo $this->Form->input('property_user_id',array('type'=>'hidden','value' => $message['property_user_id']));
		echo $this->Form->input('property_order_user_email',array('type'=>'hidden','value' => $message['property_seller_email']));
		?>
	
	
	
	
		<?php 
			$checkin_date = strtotime($propertyInfo['PropertyUser']['checkin']);
			$checkout_date = strtotime($propertyInfo['PropertyUser']['checkout']);
			$days = getCheckinCheckoutDiff($propertyInfo['PropertyUser']['checkin'],getCheckoutDate($propertyInfo['PropertyUser']['checkout']));
		?>
		<div class="offset5 clearfix bot-space">
                      <dl class="dc span mob-clr">
                        <dd class="text-12 top-space graydarkc pr hor-mspace">
							<?php echo date('D, d M Y', $checkin_date); ?>
						</dd>
						<dt class="pr hor-mspace textn top-space text-12"><?php echo date('h:i a', $checkin_date); ?></dt>
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
						<dt class="pr hor-mspace text-12 textn top-space" ><?php echo '11:59 pm'; ?></dt>
                      </dl>
		
		</div>
	</div>
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
		?> 		
		<fieldset>
		
		 
    <div class="padd-center clearfix">
	
	<div class="propertys-download-block">
        <div class="clearfix">
		<div class="pull-left span4 span4-sm no-mar dr mob-dl">
			<span class="space show top-mspace"><?php echo __l('Are you satisfied in the trips?');?></span>
			</div>
		<div class="pull-left no-mar bot-space span20 span20-sm">
			<div class="input radio radio-active-style no-mar top-space">
		<?php
			echo $this->Form->input('is_satisfied',array('label' => __l('Satisfied'),'div'=>'input radio no-mar ', 'type'=>'radio','legend'=>false,'options'=>array('1'=>__l('Yes'),'0'=>__l('No')),'class' => '' ));
		?>
		</div>
		</div>
        </div>
		<div class="js-negative-block <?php echo ($this->request->data['PropertyFeedback']['is_satisfied'] == 0) ? '' : 'hide'; ?>">
			<p class="negative-block-info"><?php echo __l('Please give your host a chance to improve his work before submitting a negative review. ').' '.$this->Html->link(__l('Contact Your Seller'), array('controller'=>'messages','action'=>'compose','type' => 'contact','to' => $message['property_seller_username'],'property_order_id' => $message['property_order_id'], 'review' => '1'), array('title' => __l('Contact Your Seller')));?></p>
		</div>
		<?php
			echo $this->Form->input('feedback',array('label' => __l('Review')));
		?>
	</div>
  
    </div>
	
	</fieldset>
	<div class="alert alert-info"><?php echo __l('Optional: Upload the photos and videos you have taken in/about this property. This will help other future guests.'); ?></div>
<fieldset>
<h3 class="well space textb text-16 no-mar"><?php echo __l('Photos');?></h3>

						
						<div class="padd-center">
							   				
							<div class="picture">
								<ol class=" upload-list clearfix unstyled">
									<?php	for($i = 0; $i<Configure::read('propertyfeedbacks.max_upload_photo'); $i++):  ?>
										
										<li class="dc clearfix inline">
											<?php echo $this->Form->file('Attachment.'.$i.'.filename', array('label' => false)); ?>
										</li>
									<?php
									endfor;
									?>
								</ol>
									
							</div>
						</div>
			</fieldset>
			<fieldset>
	
	<h3 class="well space textb text-16 no-mar">Video</h3>
							
						<div class="padd-center">
							 				
								<?php echo $this->Form->input('video_url', array('label' => __l('Video URL'))); ?>
						</div>
						
					</fieldset>
		<div class="form-actions">
<?php echo $this->Form->submit(__l('Submit'),array('class'=>'btn btn-large btn-primary textb text-16'));?>

<?php echo $this->Form->end();?>

</div>