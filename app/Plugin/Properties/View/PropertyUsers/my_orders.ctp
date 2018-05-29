<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="propertyUsers index js-response js-responses">
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
			<a data-toggle="dropdown" class="dropdown-toggle text-14 textb graylighterc no-shad" title="<?php echo __l('Layout'); ?>" href="#"><i class="icon-list-alt no-pad text-16"></i> <?php echo __l('Layout'); ?></a>
		  <ul class="dropdown-menu dl arrow">
			<li><?php echo $this->Html->link('<i class="icon-list"></i>'.__l('List'), array('controller'=> 'property_users', 'action'=>'index', 'type'=>'mytours', 'status' => $this->request->params['named']['status'], 'view' => 'list', 'admin' => false), array('title' => __l('List'), 'class' => 'list ','escape' => false));?></li>
			<li class="active"><?php echo $this->Html->link('<i class="icon-th"></i>'.__l('Grid'), array('controller'=> 'property_users', 'action'=>'index', 'type'=>'mytours', 'status' => $this->request->params['named']['status'], 'admin' => false), array('title' => __l('Grid'), 'class' => 'grid status_selected','escape' => false));?></li>
		  </ul>
		</div>
        </div>	
    </div>
<?php } else { ?>
		<div class="clearfix  sep-bot">
			<h2 class="ver-space top-mspace text-32 pull-left"><?php echo __l('Trips');?></h2>
			<div class="jobs-inbox-option show-block  clearfix ">
				<div class="dropdown top-mspace top-space pull-right"> 
					<a data-toggle="dropdown" class="dropdown-toggle right-mspace text-14 textb graylighterc no-shad js-no-pjax" title="<?php echo __l('Layout'); ?>" href="#"><i class="icon-list-alt no-pad text-16"></i> <?php echo __l('Layout'); ?></a>
					<ul class="dropdown-menu dl arrow arrow-right right-mspace js-pagination">
						<li><?php echo $this->Html->link('<i class="icon-list"></i>'.__l('List'), array('controller'=> 'property_users', 'action'=>'index', 'type'=>'mytours', 'status' => $this->request->params['named']['status'], 'view' => 'list', 'admin' => false), array('title' => __l('List'), 'class' => 'list js-no-pjax','escape' => false));?></li>
						<li class="active"><?php echo $this->Html->link('<i class="icon-th"></i>'.__l('Grid'), array('controller'=> 'property_users', 'action'=>'index', 'type'=>'mytours', 'status' => $this->request->params['named']['status'], 'admin' => false), array('title' => __l('Grid'), 'class' => 'grid status_selected js-no-pjax','escape' => false));?></li>
					</ul>
				</div>
			</div>
		</div>
	<?php } ?>
<section class="row ver-space bot-mspace clearfix">
			
			<?php 
				$stat_class = (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'all') ? 'active' : null;
				$active_filter=(!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'all') ? 'active-filter' : null;
				 echo $this->Html->link( '
					<dl class="dc list users '.$stat_class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc">'.__l('All').'</dt>
						<dd title="'.$all_count.'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt((!empty($all_count) ? $all_count : '0'),false).'</dd>                  	
					</dl>'
					,  array('controller'=>'property_users','action'=>'index','status' => 'all', 'type'=>'mytours','status' => 'all','view'=>'list','admin' => false), array('class' => 'js-no-pjax js-filter-link', 'escape' => false));
				
				$arr_count = count($moreActions);
				$i = 0;
				foreach($moreActions as $key => $value) {
					$counts = explode(":", $key);
					$class_name = $propertyStatusClass[$value] ? $propertyStatusClass[$value] :"";
					$stat_class = (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == $value) ? 'active' : null;
					$i++;
					$bclass = ($arr_count != $i)? ' sep-right' : '';
					echo	$this->Html->link( '
					<dl class="dc list users sep-left '.$stat_class .' mob-clr mob-sep-none'. $bclass.' ">					         	
						<dt class="pr hor-mspace text-11 grayc">'.$counts[0].'</dt>
						<dd title="'.$counts[1].'" class="textb text-20 no-mar graydarkc pr hor-mspace ">'.$this->Html->cInt($counts[1], false).'</dd></dl>'
						,  array('controller'=>'property_users','action'=>'index','status' => $value, 'type'=>'mytours', 'status' => $value,'view'=>'list','admin' => false), array('class' => 'js-no-pjax js-filter-link', 'escape' => false));
				
				 } ?>		
</section>
<section class="row no-mar bot-space">
<?php if (!empty($propertyUsers)): ?>
	<div class="clearfix"><?php echo $this->element('paging_counter');?></div>
<?php endif; ?>
<div class="ver-space">
<table class="js-response-actions table list no-round table-striped">
<thead>
	<tr class="well no-mar no-pad">
		<th class="graydarkc sep-right" rowspan="2"><?php echo __l('Action'); ?></th>
		<th class="graydarkc sep-right sep-bot dc" colspan="5"><?php echo __l('Trip Details'); ?></th>
		<th class="graydarkc sep-right " rowspan="2" class="dl"><div class="property-title"><?php echo $this->Paginator->sort('Property.title',__l('Property')); ?></div></th>
		<th class="graydarkc sep-right " rowspan="2"><?php echo $this->Paginator->sort('User.username',__l('Host')); ?></th>
		<!-- @todo "Guest details" -->
		<th class="graydarkc sep-right " rowspan="2"><?php echo $this->Paginator->sort( 'price',__l('Gross') . ' ('. Configure::read('site.currency') . ')'); ?></th>
		<?php if(empty($this->request->params['named']['status']) || $this->request->params['named']['status']=='negotiation_requested' || $this->request->params['named']['status']=='negotiation_rejected' || $this->request->params['named']['status']=='negotiation_confirmed'): ?>
			<th class="graydarkc sep-right " rowspan="2"><?php echo $this->Paginator->sort('PropertyUserStatus.name',__l('Current Status')); ?></th>
		<?php endif; ?>
		<th class="graydarkc" rowspan="2"><?php echo $this->Paginator->sort('created', __l('Booked On'));?></th>
	</tr>
	<tr class="well no-mar no-pad">
		<th class="graydarkc sep-right"><?php echo $this->Paginator->sort( 'checkin',__l('ID')); ?></th>
		<th class="graydarkc sep-right"><?php echo $this->Paginator->sort( 'checkin',__l('Checkin')); ?></th>
		<th class="graydarkc sep-right"><?php echo $this->Paginator->sort( 'checkout',__l('Checkout')); ?></th>
		<th class="graydarkc sep-right"><?php echo __l('Days');?></th>
		<th class="graydarkc sep-right"><?php echo __l('Guest');?></th>
	</tr>
</thead>
 <tbody>
<?php
if (!empty($propertyUsers)):

$i = 0;
foreach ($propertyUsers as $propertyUser):
?>
	<tr>
		<td class="actions dc">			 
			<div class="dropdown"> 
			<a data-toggle="dropdown" class="dropdown-toggle text-14 textb graylighterc no-shad js-no-pjax" title="<?php echo __l('Action'); ?>" href="#"><i class="icon-cog graylightc no-pad text-16"></i></a>
			<ul class="dropdown-menu dl arrow">
					 <?php if(empty($propertyUser['PropertyUser']['is_under_dispute'])) { ?>
									 	<?php if(!empty($propertyUser['PropertyUser']['is_payment_cleared'])) { ?>
                                      <li><?php echo $this->Html->link('<i class="icon-print"></i>'.__l('Print Ticket'), array('controller' => 'property_user', 'action' => 'view', $propertyUser['PropertyUser']['id'], 'type'=>'print', 'admin' => false), array('class' => 'print-ticket dl js-no-pjax', 'target' => '_blank', 'title'=>__l('Print Ticket'), false, 'escape' => false));  ?></li>
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
									<?php } elseif ((date('Y-m-d') == $propertyUser['PropertyUser']['checkout']) &&(($propertyUser['Property']['checkout'] == '00:00:00') || (date('H:i:s') >= $propertyUser['Property']['checkout']))) { ?>
									<li><?php echo $this->Html->link('<i class="icon-signout"></i>'.__l('Check out'), array('controller' => 'messages', 'action' => 'activities', 'order_id' => $propertyUser['PropertyUser']['id'].'#Checkout'), array('class' => 'checkout', 'id'=>'Checkout','title' => __l('Check out'),'escape' => false)); ?></li>
									<?php } } 
									if($this->Auth->user('id') == $propertyUser['PropertyUser']['user_id'] && $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview &&  !empty($propertyUser['PropertyUser']['is_traveler_checkout'])){?>
									<li><?php echo $this->Html->link('<i class=" icon-refresh"></i>'.__l('Review'), array('controller'=>'property_feedbacks','action'=>'add','property_order_id' => $propertyUser['PropertyUser']['id']), array('class' =>'review', 'title' => __l('Review'),'escape' => false)); ?></li>
									<?php } ?>
									<?php } else { ?><li>
									<div class="left-space left-mspace "><i class="icon-info-sign js-bootstrap-tooltip" title="<?php echo __l('Under dispute. Continued only after dispute gets closed.');?>"></i><?php echo __l('Under Dispute');?></div>
									</li>
									<?php } ?>
									 <li> <?php echo $this->Html->link('<i class="icon-eye-open"></i>'.__l('View activities'), array('controller' => 'messages', 'action' => 'activities',  'order_id' => $propertyUser['PropertyUser']['id']), array('class' =>'view-activities','escape' => false)); ?> </li>
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
		</td>
		<td><?php echo $propertyUser['PropertyUser']['id'];?></td>
		<td><?php echo $this->Html->cDateTimeHighlight($propertyUser['PropertyUser']['checkin']);?></td>
		<td><?php echo $this->Html->cDateTimeHighlight(getCheckoutDate($propertyUser['PropertyUser']['checkout']));?></td>
		<td><?php echo $this->Html->cInt(getCheckinCheckoutDiff($propertyUser['PropertyUser']['checkin'],getCheckoutDate($propertyUser['PropertyUser']['checkout']))); ?></td>
		<td><?php echo $this->Html->cInt($propertyUser['PropertyUser']['guests']);?></td>
  <td class="dl status-data">
      
			
			<?php echo $this->Html->link($this->Html->cText($propertyUser['Property']['title'],false), array('controller'=> 'properties', 'action' => 'view', $propertyUser['Property']['slug']), array('title' => $this->Html->cText($propertyUser['Property']['title'], false), 'class' => 'graydarkc textb', 'escape' => false));?>
   			<span class="grayc top-smspace show mob-dc mob-clr">
				<?php if(!empty($propertyUser['Property']['Country']['iso_alpha2'])): ?>
				    <span title="<?php echo $propertyUser['Property']['Country']['name']; ?>" class="flags mob-inline top-smspace flag-<?php echo strtolower($propertyUser['Property']['Country']['iso_alpha2']); ?>"><?php echo $propertyUser['Property']['Country']['name']; ?></span>
				 <?php endif; ?>
				<div title="" class="htruncate js-bootstrap-tooltip no-mar span6 bot-space" data-original-title="<?php echo $propertyUser['Property']['address'];?>"><?php echo $this->Html->cText($propertyUser['Property']['address']);?></div>
			</span>
			<span>
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
					<span class="<?php echo $class; ?>" title="<?php echo $this->Html->cText($propertyUser['PropertyUserStatus']['name'], false);?>"><?php echo $this->Html->cText($propertyUser['PropertyUserStatus']['name'], false);?></span>
			<?php
				endif;
			?>
			<?php
				$negotiate_discount = $propertyUser['PropertyUser']['negotiate_amount'];
				$traveler_gross = $propertyUser['PropertyUser']['price'] + $propertyUser['PropertyUser']['traveler_service_amount'];
				$traveler_gross = $traveler_gross;	
				$traveler_gross_amt = $negotiate_discount;
				if($propertyUser['PropertyUser']['is_negotiation_requested'] == 1 && empty($propertyUser['PropertyUser']['is_negotiated'])) {
			?>
					<span class="hor-smspace label label-negotiate" title="Negotiation Requested (<?php echo $traveler_gross_amt;?>)"><?php echo __l('Negotiation'); ?></span>					
			<?php
				}
			?>
  	</span>
		</td>
		<td><?php echo !empty($propertyUser['Property']['User']['username']) ? $this->Html->link($this->Html->cText($propertyUser['Property']['User']['username'], false), array('controller' => 'users', 'action' => 'view', $propertyUser['Property']['User']['username'] ,'admin' => false), array('title'=>$this->Html->cText($propertyUser['Property']['User']['username'],false),'escape' => false)) : ''; ?>
			<?php if(!empty($propertyUser['PropertyUser']['traveler_private_note'])): ?>
          	<span class="info" title="<?php echo $propertyUser['PropertyUser']['traveler_private_note']; ?>">&nbsp;</span>
			<?php endif; ?>
        </td>
		<td class="dr">
		<?php 
		     $negotiate_discount = $propertyUser['PropertyUser']['negotiate_amount'];			
			$traveler_gross = $propertyUser['PropertyUser']['price'] + $propertyUser['PropertyUser']['traveler_service_amount'];						
			echo $this->Html->cCurrency($traveler_gross);
		    if(!empty($propertyUser['PropertyUser']['is_negotiated'])):
				?>
				<div class="select-block table-select-block">
                      <span class="label label-negotiate"><?php echo __l('Negotiated');?></span>
               </div>
                <?php
				
				echo '(-'.$negotiate_discount.')';
			endif;
		?>
		<?php if(Configure::read('property.is_enable_security_deposit')): ?>
						<div class="secuirty-deposit sfont ">
						+<span class="deposite-info"><?php echo __l('Security Deposit') . ': '; ?></span><span><?php echo $this->Html->siteCurrencyFormat($propertyUser['Property']['security_deposit']); ?></span>
						</div>
			</td>
		<?php endif; ?>
		<td><?php echo $this->Html->cDateTimeHighlight($propertyUser['PropertyUser']['created']);?></td>
</tr>
<?php
    endforeach;
else:
?>
<tr>
	<td colspan="15">
	<div class="space dc grayc">
		<p class="ver-mspace top-space text-16 "><?php echo __l('No Trips available');?></p>
	</div>
	</td>
</tr>
<?php
endif;
?>
 </tbody>
</table>
</div>
<?php
if (!empty($propertyUsers)) {
?>
<div class="<?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?> clearfix space pull-right mob-clr dc">
		<?php  echo $this->element('paging_links'); ?>
	</div>
<?php }
?> 
</section>
</div>
