<div class="js-responses js-response">
<div class="propertyUsers index js-request-responses">

<?php 
$fromAjax = FALSE;
if(isset($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'ajax'):
	$fromAjax = TRUE;
 endif; ?>
 <?php if(empty($this->request->params['isAjax'])) { ?>
	<div class="clearfix sep-bot">
	<h2 class="ver-space top-mspace text-32 pull-left"><?php echo __l('Trips');?></h2>
        <div class="jobs-inbox-option show-block  clearfix pull-right top-mspace top-space">
        	<div class="dropdown top-mspace top-space"> 
			<a data-toggle="dropdown" class="dropdown-toggle text-14 textb graylighterc no-shad js-no-pjax" title="<?php echo __l('Layout'); ?>" href="#"><i class="icon-list-alt no-pad text-16"></i> <?php echo __l('Layout'); ?></a>
		  <ul class="dropdown-menu dl arrow">
			<li class="active"><?php echo $this->Html->link('<i class="icon-list"></i>'.__l('List'), array('controller'=> 'property_users', 'action'=>'index', 'type'=>'mytours', 'status' => $this->request->params['named']['status'], 'view' => 'list', 'admin' => false), array('title' => __l('List'), 'class' => 'list','escape' => false));?></li>
			<li><?php echo $this->Html->link('<i class="icon-th"></i>'.__l('Grid'), array('controller'=> 'property_users', 'action'=>'index', 'type'=>'mytours', 'status' => $this->request->params['named']['status'], 'admin' => false), array('title' => __l('Grid'), 'class' => 'grid status_selected','escape' => false));?></li>
		  </ul>
		</div>
        </div>
    </div>
	<?php } else { ?>
		<div class="clearfix sep-bot">
			<h2 class="ver-space top-mspace text-32 pull-left"><?php echo __l('Trips');?></h2>
			<div class="jobs-inbox-option show-block  clearfix ">
				<div class="dropdown top-mspace top-space pull-right right-mspace"> 
					<a data-toggle="dropdown" class="dropdown-toggle text-14 right-mspace textb graylighterc no-shad js-no-pjax" title="<?php echo __l('Layout'); ?>" href="#"><i class="icon-list-alt no-pad text-16"></i> <?php echo __l('Layout'); ?></a>
					<ul class="dropdown-menu dl arrow arrow-right right-mspace js-pagination">
						<li class="active"><?php echo $this->Html->link('<i class="icon-list"></i>'.__l('List'), array('controller'=> 'property_users', 'action'=>'index', 'type'=>'mytours', 'status' => $this->request->params['named']['status'], 'view' => 'list', 'admin' => false), array('title' => __l('List'), 'class' => 'list js-no-pjax','escape' => false));?></li>
						<li><?php echo $this->Html->link('<i class="icon-th"></i>'.__l('Grid'), array('controller'=> 'property_users', 'action'=>'index', 'type'=>'mytours', 'status' => $this->request->params['named']['status'], 'admin' => false), array('title' => __l('Grid'), 'class' => 'grid status_selected js-no-pjax','escape' => false));?></li>
					</ul>
				</div>
			</div>
		</div>
	<?php } ?>
			<div class="row ver-space bot-mspace clearfix <?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?>">
			<?php 
				$stat_class = (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'all') ? 'active' : null;
				$active_filter=(!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'all') ? 'active-filter' : null;
				$link = array('controller'=>'property_users','action'=>'index','status' => 'all', 'type'=>'mytours','status' => 'all','admin' => false );
				if(!empty($this->request->params['isAjax'])) {
					$link = array_merge($link, array("from" => "ajax"));
				}
				 echo $this->Html->link( '
					<dl class="dc list users '.$stat_class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc">'.__l('All').'</dt>
						<dd title="'.$all_count.'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt((!empty($all_count) ? $all_count : '0'),false).'</dd>                  	
					</dl>'
					, $link , array('escape' => false, 'class' => 'js-filter-link js-no-pjax' ));
				
				
				foreach($moreActions as $key => $value) {
					$counts = explode(":", $key);
					$class_name = $propertyStatusClass[$value] ? $propertyStatusClass[$value] :"";
					$stat_class = (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == $value) ? 'active' : null;
					$link = array('controller'=>'property_users','action'=>'index','status' => $value, 'type'=>'mytours', 'status' => $value,'admin' => false);
					echo	$this->Html->link( '
					<dl class="dc list users '.$stat_class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc">'.$counts[0].'</dt>
						<dd title="'.$counts[1].'" class="textb text-20 no-mar graydarkc pr hor-mspace ">'.$this->Html->cInt($counts[1], false).'</dd></dl>'
						,  $link, array('escape' => false, 'class' => 'js-filter-link js-no-pjax'));
				
				 } ?>		
		</div>
			  <ol class="js-response-actions unstyled prop-list-mob prop-list  no-mar top-space property-list prop-list-mob" start="<?php echo $this->Paginator->counter(array('format' => '%start%'));?>">
			  <?php
		if (!empty($propertyUsers)) {
			$i = 0;
			$num = $this->Paginator->counter(array('format' => '%start%'));
			foreach ($propertyUsers as $propertyUser) {
	?>
                <li class="ver-space sep-bot js-map-num<?php echo $num; ?> clearfix list-view">
                  <div class="span dc left-smspace"> <span class="label label-important textb show text-11 prop-count bot-mspace"><?php echo $num; ?> </span>
                    <div class="dropdown"> 
			<a data-toggle="dropdown" class="dropdown-toggle text-14 textb graylighterc no-shad js-no-pjax" title="<?php echo __l('Action'); ?>" href="#"><i class="icon-cog graylightc no-pad text-16"></i></a>
			<ul class="dropdown-menu dl arrow">
					 <?php if(empty($propertyUser['PropertyUser']['is_under_dispute'])) { ?>
									 	<?php if(!empty($propertyUser['PropertyUser']['is_payment_cleared'])) { ?>
                                      <li><?php echo $this->Html->link('<i class="icon-print"></i>'.__l('Print Ticket'), array('controller' => 'property_user', 'action' => 'view', $propertyUser['PropertyUser']['id'], 'type'=>'print', 'admin' => false), array('class' => 'print-ticket dl  js-no-pjax', 'target' => '_blank', 'title'=>__l('Print Ticket'), false, 'escape' => false));  ?></li>
									<?php } 
									if($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Confirmed && $propertyUser['PropertyUser']['checkin'] > date('Y-m-d') || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforAcceptance ) {?>
									<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Cancel'), array('controller' => 'properties', 'action' => 'order', $propertyUser['PropertyUser']['property_id'] , 'order_id'=>$propertyUser['PropertyUser']['id'], 'type' => 'cancel', 'admin' => false),array('title' => __l('Cancel'), 'class'=>'js-delete delete','escape' => false));  ?></li>
									<?php } ?>
									<?php if (($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Confirmed) && (date('Y-m-d') >= $propertyUser['PropertyUser']['checkin']) && (empty($propertyUser['PropertyUser']['is_traveler_checkin']))) { 
									if((($propertyUser['Property']['checkin'] == '00:00:00') || (date('H:i:s') >= $propertyUser['Property']['checkin'])) || ($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived)) { ?>
									<li><?php echo $this->Html->link('<i class="icon-signin"></i>'.__l('Check in'), array('controller' => 'messages', 'action' => 'activities', 'order_id' => $propertyUser['PropertyUser']['id'].'#Checkin'), array('class' => 'checkin', 'id'=>'Checkin','title' => __l('Check in'),'escape' => false)); ?></li>
									<?php } } 
									elseif (($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::PaymentCleared) && (date('Y-m-d') >= $propertyUser['PropertyUser']['checkout']) && empty($propertyUser['PropertyUser']['is_traveler_checkout'])) {
									if(date('Y-m-d') > $propertyUser['PropertyUser']['checkout']){ ?>
										<li><?php echo $this->Html->link('<i class="icon-signout"></i>'.__l('Check out'), array('controller' => 'messages', 'action' => 'activities', 'order_id' => $propertyUser['PropertyUser']['id'].'#Checkout'), array('class' => 'checkout', 'id'=>'Checkout','title' => __l('Check out'),'escape' => false)); ?></li>
									<?php }
									elseif ((date('Y-m-d') == $propertyUser['PropertyUser']['checkout']) && (($propertyUser['Property']['checkout'] == '00:00:00') || (date('H:i:s') >= $propertyUser['Property']['checkout']))) { ?>
									<li><?php echo $this->Html->link('<i class="icon-signout"></i>'.__l('Check out'), array('controller' => 'messages', 'action' => 'activities', 'order_id' => $propertyUser['PropertyUser']['id'].'#Checkout'), array('class' => 'checkout', 'id'=>'Checkout','title' => __l('Check out'),'escape' => false)); ?></li>
									<?php } } 
									if($this->Auth->user('id') == $propertyUser['PropertyUser']['user_id'] && $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview ){?>
									<li><?php echo $this->Html->link('<i class=" icon-refresh"></i>'.__l('Review'), array('controller'=>'property_feedbacks','action'=>'add','property_order_id' => $propertyUser['PropertyUser']['id']), array('class' =>'review', 'title' => __l('Review'),'escape' => false)); ?></li>
									<?php } ?>
									<?php } ?>
									 <li> <?php echo $this->Html->link('<i class="icon-eye-open"></i>'.__l('View activities'), array('controller' => 'messages', 'action' => 'activities',  'order_id' => $propertyUser['PropertyUser']['id']), array('class' =>'view-activities', 'title' => __l('View activities'), 'escape' => false)); ?> </li>
										<?php $note_url = Router::url(array(
										'controller' => 'messages',
										'action' => 'activities',
										'order_id' => $propertyUser['PropertyUser']['id'],
									) , true);
									?>
									<li><?php echo $this->Html->link('<i class="icon-bookmark"></i>'.__l('Private note'), $note_url.'#private-note', array('class' => 'add-note',  'title' => __l('Private note'),'escape' => false)); ?></li>
									<?php if(($this->request->params['named']['status'] == 'negotiation' && !empty($propertyUser['PropertyUser']['is_negotiation_requested']))|| $this->request->params['named']['status'] == 'payment_pending'){ ?>
									<li><?php echo $this->Html->link('<i class="icon-save"></i>'.__l('Book it'), array('controller' => 'properties', 'action' => 'order', $propertyUser['PropertyUser']['property_id'], 'order_id:' . $propertyUser['PropertyUser']['id'], 'admin' => false), array('class' => 'book-it', 'title' => __l('Book it'),'escape' => false)); ?></li>
									<?php } ?>
			</ul>
		</div>
                  </div>
                  <div class="span hor-mspace dc avtar-box">
				  <?php
								$propertyUser['Property']['Attachment'][0] = !empty($propertyUser['Property']['Attachment'][0]) ? $propertyUser['Property']['Attachment'][0] : array();
    							echo $this->Html->link($this->Html->showImage('Property', $propertyUser['Property']['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($propertyUser['Property']['title'], false)), 'title' => $this->Html->cText($propertyUser['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $propertyUser['Property']['slug'], 'admin' => false), array('title'=>$this->Html->cText($propertyUser['Property']['title'], false), 'escape' => false));
    						?>
            				
				</div>
                  <div class="span19 pull-right no-mar mob-clr tab-clr">
				  <?php if (!empty($propertyUser['PropertyUser']['is_under_dispute'])) {
        							echo '<span class="dispute-open">' . __l('Under dispute. Continued only after dispute gets closed.') . '</span>';
        					 }?>
                    <div class="clearfix left-mspace sep-bot">
                      <div class="span bot-space no-mar dl">
                        <h4 class="textb text-16">
						<?php
									$lat = $propertyUser['Property']['latitude'];
									$lng = $propertyUser['Property']['longitude'];
									$id = $propertyUser['Property']['id'];
									echo $this->Html->link($this->Html->cText($propertyUser['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $propertyUser['Property']['slug'], 'admin' => false), array('id'=>"js-map-side-$id",'class'=>"js-bootstrap-tooltip graydarkc js-map-data {'lat':'$lat','lng':'$lng'}",'title'=>$this->Html->cText($propertyUser['Property']['title'], false),'escape' => false));
								?>
						
						</h4>
						<?php
									if(!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'all'):
										$class = '';
										if ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance) {
											$class = 'label label-pendingapproval';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed) {
											$class = 'label label-confirmed';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Rejected) {
											$class = 'label label-reject';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Canceled) {
											$class = 'label label-cancel';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::CanceledByAdmin) {
											$class = 'label label-cancelbyadmin';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived) {
											$class = 'label label-arrived';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforReview) {
											$class = 'label label-review';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Completed) {
											$class = 'label label-completed';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Expired) {
											$class = 'label';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentPending) {
											$class = 'label label-paymentpending';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentCleared) {
											$class = 'label label-cleared';
										}
								?>
										<span class="round-3 <?php echo $class; ?>">
										<?php echo $this->Html->cText($propertyUser['PropertyUserStatus']['name'],false); ?>
										</span>
								<?php
									endif;
								?>
									<?php if(!empty($propertyUser['PropertyUser']['is_under_dispute'])): ?>
										<span class="hor-smspace label label-warning"><?php echo __l('Under Dispute'); ?></span>
									<?php endif; ?>
								<?php
									$negotiate_discount = $propertyUser['PropertyUser']['negotiate_amount'];
									$traveler_gross = $propertyUser['PropertyUser']['price'] + $propertyUser['PropertyUser']['traveler_service_amount'];
									if($propertyUser['PropertyUser']['is_negotiation_requested'] == 1) {
								?>
										<span class="hor-smspace label label-negotiate"><?php echo __l('Negotiation'); ?></span>
										<span class="negotiate-amount">
											<?php																				
												$traveler_gross = $traveler_gross;	
												echo '(-'.$this->Html->siteCurrencyFormat($negotiate_discount).')';
											?>
										</span>
								<?php
									}
								?>
                        <span class="graydarkc top-smspace show mob-clr dc">
						
						<?php if(!empty($propertyUser['Property']['Country']['iso_alpha2'])): ?>
									<span class="flags flag-<?php echo strtolower($propertyUser['Property']['Country']['iso_alpha2']); ?> mob-inline top-smspace" title ="<?php echo $propertyUser['Property']['Country']['name']; ?>"><?php echo $propertyUser['Property']['Country']['name']; ?></span>
							<?php endif; ?>
						<?php echo $this->Html->cText($propertyUser['Property']['address']);?>
						</div>
                      <div class="pull-right hor-space sep-left mob-clr mob-sep-none">
                        <div class="clearfix">
                          <dl class="dc list span mob-clr">
                            <dt class="pr hor-mspace text-11"><?php echo __('per night'); ?></dt>
                            <dd class="textb text-24 graydarkc pr hor-mspace" title="five hundred dollar">
							<?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
								<?php echo Configure::read('site.currency').' '?>
							<?php endif; ?>
							<?php	echo $this->Html->cCurrency($traveler_gross);?>
							<?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
								<?php echo Configure::read('site.currency').' '?>
							<?php endif; ?>
							</dd>
                          </dl>
                        </div>
						<?php if(Configure::read('property.is_enable_security_deposit')): ?> 
							<p class="clearfix">+ <?php echo __l('Security Deposit'); ?> <span class="graydarkc text-11"><?php echo $this->Html->siteCurrencyFormat($propertyUser['Property']['security_deposit']); ?></span></p>
						<?php endif; ?>
                      </div>
                    </div>
                    <div class="clearfix left-mspace">
                      <div class="span12 no-mar">
                        <div class="span clearfix no-mar">
                          <dl class="list span8 mob-clr">
                            <dt class="pr hor-mspace text-11"><?php echo __l('Check in');?></dt>
                            <dd  class="top-space  pr no-mar blackc"><?php echo $this->Html->cDate($propertyUser['PropertyUser']['checkin']);?></dd>
                          </dl>
                          <dl class="dc list span mob-clr">
                            <dt class="pr hor-mspace text-11"><?php echo __l('Check out');?></dt>
                            <dd  class="top-space  pr hor-mspace blackc"> <?php echo $this->Html->cDate(getCheckoutDate($propertyUser['PropertyUser']['checkout']));?></dd>
                          </dl>
                        </div>
                        <div class="span clearfix no-mar">
						<?php
								$total_days = getCheckinCheckoutDiff($propertyUser['PropertyUser']['checkin'], getCheckoutDate($propertyUser['PropertyUser']['checkout']));
								$completed_days = (strtotime(date('Y-m-d')) - strtotime($propertyUser['PropertyUser']['checkin'])) /(60*60*24);
								if($completed_days == 0) {
									$completed_days = 1;
								} elseif($completed_days < 0) {
									$completed_days = 0;
								} elseif($completed_days > $total_days) {
									$completed_days = $total_days;	
								}
                                $pixels = round(($completed_days/$total_days) * 100);
                            ?> 
							
                          <div class="progress progress-info bot-mspace">
                            <div class="bar" style="width:<?php echo $pixels; ?>%;"></div>
                          </div>
                        </div>
                      </div>
                      <div class="clearfix pull-right top-mspace right-space mob-clr">
                        <dl class="dc mob-clr sep-right list">
                          <dt class="pr hor-smspace text-11"><?php echo __l('Trip Id# '); ?></dt>
                          <dd title="<?php echo $propertyUser['PropertyUser']['id']; ?>" class="textb text-16 no-mar graydarkc pr hor-space"><?php echo $propertyUser['PropertyUser']['id'];?></dd>
                        </dl>
                        <dl class="dc mob-clr sep-right list">
                          <dt class="pr hor-mspace text-11"> <?php echo __l('Host'); ?></dt>
                          <dd  class="textb text-16 no-mar graydarkc pr hor-space">	<?php echo !empty($propertyUser['Property']['User']['username']) ? $this->Html->link($this->Html->cText($propertyUser['Property']['User']['username'], false), array('controller' => 'users', 'action' => 'view', $propertyUser['Property']['User']['username'] ,'admin' => false), array('title'=>$this->Html->cText($propertyUser['Property']['User']['username'],false),'escape' => false,'class'=>'graydarkc')) : ''; ?></dd>
                        </dl>
                        <dl class="dc mob-clr sep-right list">
                          <dt class="pr mob-clr hor-mspace text-11"><?php echo __l('Guests');?></dt>
                          <dd title="<?php echo $propertyUser['PropertyUser']['guests']; ?>" class="textb text-16 no-mar graydarkc pr hor-space"><?php  echo $this->Html->cInt($propertyUser['PropertyUser']['guests']); ?></dd>
                        </dl>
                        <dl class="dc mob-clr list">
                          <dt class="pr hor-mspace text-11"><?php echo __l('Days');?></dt>
                          <dd title="<?php echo getCheckinCheckoutDiff($propertyUser['PropertyUser']['checkin'], getCheckoutDate($propertyUser['PropertyUser']['checkout'])); ?>" class="textb text-16 no-mar graydarkc pr hor-space"><?php echo $this->Html->cInt(getCheckinCheckoutDiff($propertyUser['PropertyUser']['checkin'], getCheckoutDate($propertyUser['PropertyUser']['checkout']))); ?></dd>
                        </dl>
                      </div>
                    </div>
					<?php if(!empty($propertyUser['PropertyUser']['traveler_private_note'])): ?>
							<p class="text16"><span class="textb"><?php echo __l('Private note: '); ?></span><?php echo $this->Html->cText($propertyUser['PropertyUser']['traveler_private_note']);?></p>
							<?php endif; ?>
                  </div>		
                </li>
               
                  
<?php 
				$num++;
			}  ?>
			</ol>
		<?php } else { ?>
		<ol class="unstyled sep-top">
					<li>
						<div class="space dc grayc">
							<p class="ver-mspace top-space text-16">
								<?php echo __l('No Trips available');?>
							</p>
						</div>
					</li>	
		</ol>
	<?php 
		}
	?>
	

<?php
if (!empty($propertyUsers)) { ?>
	<div class="<?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?> clearfix space pull-right mob-clr dc">
		<?php
		echo $this->element('paging_links'); ?>
	</div>
<?php	}
?>

</div>
</div>