<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="propertyOrders index js-response  js-responses">
<?php 
$fromAjax = FALSE;
if(isset($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'ajax'):
	$fromAjax = TRUE;
 endif; ?>
<h2 class="ver-space top-mspace text-32 sep-bot"><?php echo __l('Calendar');?></h2>
<section class="row ver-space bot-mspace clearfix">
		<?php
			$stat_class = (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'all') ? 'active' : null;
			$active_filter=(!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'all') ? 'active-filter' : null;
		?>
		<?php echo $this->Html->link( '
					<dl class="dc list users '.$stat_class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc">'.__l('All').'</dt>
						<dd title="'.$all_count.'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt((!empty($all_count) ? $all_count : '0'),false).'</dd>                  	
					</dl>'
					,  array('controller' => 'property_users', 'action' => 'index','type'=>'myworks', 'status' => 'all'), array('escape' => false, 'title' => 'All'));
				?>
		<?php
			if (!empty($data_status_count)):

				foreach($data_status_count as $value => $data):
					$class_name = $propertyStatusClass[$value] ? $propertyStatusClass[$value] :"";
					$stat_class = (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == $value) ? 'active' : null;
			?>
          
	 		<?php echo	$this->Html->link( '
					<dl class="dc list users '.$stat_class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc">'.$data['label'].'</dt>
						<dd title="'.$data['count'].'" class="textb text-20 no-mar graydarkc pr hor-mspace ">'.$this->Html->cInt($data['count'], false).'</dd></dl>'
						,  array('controller'=>'property_users', 'action'=>'index', 'type' => 'myworks', 'status' => $value,), array('escape' => false, 'title' => $data['label']));
				
			?>
			<?php
				endforeach;
			endif;
		?>
</section>

<?php  if(isset($this->request->params['named']['status']) && $this->request->params['named']['status']=='negotiation_requested'): ?>
 <div class="alert alert-info"><?php echo __l('You can give whatever discount, but admin commission will be calculated on your property cost!'); ?></div>
<?php endif; ?>
<?php
if (!empty($propertyUsers)):?>
	<div class="space"><?php echo $this->element('paging_counter');?></div>
<?php endif; ?>
<div class="alert alert-info"><?php echo __l('Order confirmation request will be expired automatically in ').(Configure::read('property.auto_expire')*24).__l(' hrs, please hurry to confirm.'); ?></div>
<?php $row_span_class='';
if(!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'confirmed'){
	$row_span_class=' rowspan="2"';
}
?>
<table class="revenues-list po-list table table-striped">
<thead>
	<tr class="well no-mar no-pad">
		<th class="graydarkc sep-right" <?php echo $row_span_class;?>><?php echo __l('Action'); ?></th>
		<th class="graydarkc sep-right" <?php echo $row_span_class;?>><?php echo $this->Paginator->sort('checkin',__l('Check in Date')); ?></th>
		<th class="graydarkc sep-right" <?php echo $row_span_class;?>><?php echo $this->Paginator->sort('checkout',__l('Check out Date')); ?></th>
		<th class="graydarkc sep-right span4" <?php echo $row_span_class;?>><?php echo $this->Paginator->sort('Property.title',__l('Property')); ?></th>
		<th class="graydarkc sep-right" <?php echo $row_span_class;?>><?php echo $this->Paginator->sort('User.username',__l('Traveler')); ?></th>
		<th class="graydarkc sep-right" <?php echo $row_span_class;?>><?php echo $this->Paginator->sort('id',__l('Trip Id')); ?></th>
		<th class="graydarkc sep-right" <?php echo $row_span_class;?>><?php echo $this->Paginator->sort('guests',__l('Guests')); ?></th>
		<!-- @todo "Guest details" -->
		<th class="graydarkc sep-right" <?php echo $row_span_class;?>><?php echo $this->Paginator->sort( 'price',__l('Gross') . ' ('. Configure::read('site.currency') . ')'); ?></th>
		<?php if(!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'confirmed'): ?>
			<th colspan="2" class="graydarkc sep-right"><?php echo $this->Paginator->sort(__l('Booking code')); ?></th>
		<?php endif; ?>	
		<th class="graydarkc sep-right" <?php echo $row_span_class;?>><?php echo __l('No of Days');?></th>
		<th class="graydarkc sep-right" <?php echo $row_span_class;?>><?php echo $this->Paginator->sort('created',__l('Booked Date'));?></th>
		<th class="graydarkc " <?php echo $row_span_class;?>><?php echo $this->Paginator->sort('host_private_note',__l('Private Note')); ?></th>
	</tr>
	<?php if(!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'confirmed'): ?>
	<tr>		
		<th class="graydarkc sep-right sep-top" ><?php echo $this->Paginator->sort(__l('Top Code'),'top_code'); ?></th>
		<th class="graydarkc sep-right sep-top" ><?php echo $this->Paginator->sort(__l('Bottom Code'),'bottum_code'); ?></th>
	</tr>
	<?php endif; ?>
	</thead>
	<tbody>
<?php
if (!empty($propertyUsers)):

$i = 0;
foreach ($propertyUsers as $propertyUser):
?>
	<tr>
		<td class="actions">
                    <div class="dropdown dc"> 
						<a data-toggle="dropdown" class="dropdown-toggle text-14 textb graylighterc no-shad" title="Edit" href="#"><i class="icon-cog no-pad text-16"></i></a>
					  <ul class="dropdown-menu dl arrow">
									<?php
							if(empty($propertyUser['PropertyUser']['is_under_dispute'])){
								if($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforAcceptance) { ?>
									<li><?php echo $this->Html->link('<i class="icon-check"></i>' . __l('Confirm'), array('controller' => 'property_users', 'action' => 'update_order', $propertyUser['PropertyUser']['id'],  'accept', 'admin' => false, '?r=' . $this->request->url), array('class' => 'confirm js-delete','escape'=>false, 'title' => __l('Confirm'))); ?>
								</li>
									
									<li><?php 
									echo $this->Html->link('<i class="icon-remove-sign"></i>' . __l('Reject'), array('controller' => 'property_users', 'action' => 'update_order', $propertyUser['PropertyUser']['id'],  'reject', 'admin' => false, '?r=' . $this->request->url), array('class' => 'cancel js-delete','escape'=>false, 'title' => __l('Reject'))); ?> 
									</li><?php
								}
								if (($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Confirmed) && (date('Y-m-d') >= $propertyUser['PropertyUser']['checkin']) && (empty($propertyUser['PropertyUser']['is_host_checkin']))) {
									if ((($propertyUser['Property']['checkin'] == '00:00:00') || (date('H:i:s') >= $propertyUser['Property']['checkin'])) || ($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived)) {?>
									<li><?php 
										echo $this->Html->link('<i class="icon-signin"></i>' . __l('Check in'), array('controller' => 'messages', 'action' => 'activities','order_id' => $propertyUser['PropertyUser']['id'].'#Checkin'), array('class' => 'checkin','escape'=>false, 'id' => 'Checkin', 'title' => __l('Check in'))); ?> 
									</li><?php
									}
								} 
								elseif(($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::PaymentCleared) && (date('Y-m-d') >= $propertyUser['PropertyUser']['checkout']) && empty($propertyUser['PropertyUser']['is_host_checkout'])){
									if(date('Y-m-d') > $propertyUser['PropertyUser']['checkout']){?>
									<li><?php 
										echo $this->Html->link('<i class="icon-signout"></i>' . __l('Check out'), array('controller' => 'messages', 'action' => 'activities','order_id' => $propertyUser['PropertyUser']['id'].'#Checkout'), array('class' => 'checkout', 'id' => 'Checkout','escape'=>false, 'title' => __l('Check out'))); ?> 
									</li>
									<?php }else if((date('Y-m-d') == $propertyUser['PropertyUser']['checkout']) && (($propertyUser['Property']['checkout'] == '00:00:00') || (date('H:i:s') >= $propertyUser['Property']['checkout']))){?>
									<li><?php 
										echo $this->Html->link('<i class="icon-signout"></i>' . __l('Check out'), array('controller' => 'messages', 'action' => 'activities','order_id' => $propertyUser['PropertyUser']['id'].'#Checkout'), array('class' => 'checkout', 'id' => 'Checkout','escape'=>false, 'title' => __l('Check out'))); ?> 
									</li><?php
									}
								}
								if ($this->Auth->user('id') == $propertyUser['PropertyUser']['owner_user_id'] && ($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::PaymentCleared || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Completed) && empty($propertyUser['PropertyUser']['is_host_reviewed'])) {?>
									<li><?php 
									echo $this->Html->link('<i class="icon-sun"></i>' . __l('Review'), array('controller'=>'property_user_feedbacks','action'=>'add','property_order_id' => $propertyUser['PropertyUser']['id']), array('class' =>'review','escape'=>false, 'title' => __l('Review'))); ?> 
									</li><?php
								}
							} else { ?>
								<li><div class="left-space left-mspace "><i class="icon-info-sign js-bootstrap-tooltip" title="<?php echo __l('Under dispute. Continued only after dispute gets closed.');?>"></i><?php echo __l('Under Dispute');?></div></li>
							<?php } ?>
									<li><?php 
							echo $this->Html->link('<i class="icon-zoom-in"></i>' . __l('View activities'), array('controller' => 'messages', 'action' => 'activities',  'order_id' => $propertyUser['PropertyUser']['id']), array('class' => 'view-activities','escape'=>false));
							$note_url = Router::url(array(
							'controller' => 'messages',
							'action' => 'activities',
							'order_id' => $propertyUser['PropertyUser']['id'],
						) , true); ?> 
									</li>
									<li><?php 
						echo $this->Html->link('<i class="icon-pencil"></i>' . __l('Private note'), $note_url.'#private-note', array('class' =>'add-note','escape'=>false, 'title' => __l('Private note')));?></li>
						<?php if (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'negotiation') { ?>
							<li><?php echo $this->Html->link('<i class="icon-mail-reply-all"></i>' . __l('Respond'), array('controller' => 'messages', 'action' => 'activities', 'order_id' => $propertyUser['PropertyUser']['id'], 'admin' => false), array('class' => 'respond', 'title' => __l('Respond'),'escape'=>false)); ?> 
									</li><?php
						}
						?>
								</ul> 
					</div>
	
		</td>
		<td><?php echo $this->Html->cDate($propertyUser['PropertyUser']['checkin']);?></td>
		<td><?php echo $this->Html->cDate(getCheckoutDate($propertyUser['PropertyUser']['checkout']));?></td>
		<td class="dl status-data">
			<span class="span4 htruncate js-bootstrap-tooltip" data-original-title="<?php echo $this->Html->cText($propertyUser['Property']['title'],false); ?>">
				<?php echo $this->Html->link($this->Html->cText($propertyUser['Property']['title'] . "&nbsp",false), array('controller'=> 'properties', 'action' => 'view', $propertyUser['Property']['slug']), array('title' => $this->Html->cText($propertyUser['Property']['title'], false), 'escape' => false));?>
			</span>
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
			<span class="<?php echo $class; ?>">
		    	   <?php echo $this->Html->cText($propertyUser['PropertyUserStatus']['name'],false); ?>
			</span>
			<?php if (!empty($propertyUser['PropertyUser']['is_negotiation_requested'])): ?>
				<span class="hor-smspace label label-negotiate"><?php echo __l('Negotiation'); ?></span>
			<?php endif; ?>
			<?php endif; ?>
			<?php if(!empty($propertyUser['PropertyUser']['is_under_dispute'])): ?>
				<span class="hor-smspace label label-warning"><?php echo __l('Under Dispute'); ?></span>
			<?php endif; ?>
		</td>
		<td><?php echo $this->Html->link($this->Html->cText($propertyUser['User']['username'], false), array('controller' => 'users', 'action' => 'view', $propertyUser['User']['username'] ,'admin' => false), array('title'=>$this->Html->cText($propertyUser['User']['username'],false),'escape' => false)); ?>
		</td>
		<td><?php echo $propertyUser['PropertyUser']['id'];?></td>
 		<td><?php echo $this->Html->cInt($propertyUser['PropertyUser']['guests']);?></td>
		<td><?php 
		    $negotiate_discount = $propertyUser['PropertyUser']['negotiate_amount'];			
			$traveler_gross = $propertyUser['PropertyUser']['price'] - $propertyUser['PropertyUser']['host_service_amount'];
			
			echo $this->Html->cCurrency($traveler_gross);
		    if(!empty($propertyUser['PropertyUser']['is_negotiated'])):
				?>
					<div class="select-block table-select-block">
                <span class="label label-negotiate"><?php echo __l('Negotiated');?>
                </span>
                </div>

                <?php
				
				echo '(-'.$this->Html->siteCurrencyFormat($negotiate_discount).')';
			endif;
		?></td>
		<?php if(!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'confirmed'): ?>
			<td><?php echo $this->Html->cText($propertyUser['PropertyUser']['top_code']);?></td>
			<td><?php echo $this->Html->cText($propertyUser['PropertyUser']['bottum_code']);?></td>
		<?php endif; ?>
		<td><?php echo $this->Html->cInt(getCheckinCheckoutDiff($propertyUser['PropertyUser']['checkin'],getCheckoutDate($propertyUser['PropertyUser']['checkout'])));?></td>
		<td><?php echo $this->Html->cDateTimeHighlight($propertyUser['PropertyUser']['created']);?></td>
		<td>
			<span class="span4 htruncate js-bootstrap-tooltip" data-original-title="<?php echo $this->Html->cText($propertyUser['PropertyUser']['host_private_note'],false); ?>">
				<?php echo $this->Html->cText($propertyUser['PropertyUser']['host_private_note']);?>
			</span>
		</td>
	</tr>
<?php
    endforeach;
    
else:
?>
<tr>
	<td colspan="14">
		<div class="space dc grayc">
			<p class="ver-mspace top-space text-16 "><?php echo __l('No Bookings available');?></p>
		</div>
	</td>
</tr>
<?php
endif;
?> 
</tbody>
</table>

<?php
if (!empty($propertyUsers)) { ?>
<div class= "clearfix">
	<div class="clearfix space pull-right mob-clr dc">
<?php
		echo $this->element('paging_links'); ?>
	</div>
</div>
<?php	}
?>
<div class="my-property clearfix">
<div class="alert alert-info js-responses-update">
<?php echo __l('In the calendar, you can override your properties prices and also confirm bookings.');?>
<?php echo '<br/>' . __l('If you want to view property wise calendar, visit') . ' ' . $this->Html->link(__l('My Properties'), array('controller' => 'properties', 'action' => 'index', 'type' => 'myproperties'), array('title' => __l('My Properties')));?>
</div>
<div class="my-property-inner-block clearfix">
    <div class="span8 clearfix">
         <?php   echo $this->element('properties-index_lst_my_properties', array('property_id' => isset($this->request->params['named']['property_id']) ? $this->request->params['named']['property_id'] : '')); ?>
        <div class="clearfix">
            <div class="properties-middle-block no-pad clearfix">
                <h3 class="well space textb text-16"><?php echo __l('Legends');?></h3>
				<ul class="clearfix unstyled">
					<li class="top-mspace"><span class="label label-confirmed"><?php echo __l('Available');?></span></li>
					<li class="top-mspace"><span class="label label-important"><?php echo __l('Not Available');?></span></li>
					<li class="top-mspace"><span class="label label-pendingapproval"><?php echo __l('Booking Requested');?></span></li>
					<li class="top-mspace"><span class="label label-completed"><?php echo __l('Booking Confirmed');?></span></li>
					<li class="top-mspace"><span class="label label-negotiate"><?php echo __l('Negotiation Requested');?></span></li>
				</ul>
            </div>
        </div>
    </div>
    <div class="span15 clearfix">
    <?php   echo $this->element('properties-calendar', array('property_id' => isset($this->request->params['named']['property_id']) ? $this->request->params['named']['property_id'] : '', 'config' => 'sec')); ?>
    </div>
    </div>
</div>
</div>