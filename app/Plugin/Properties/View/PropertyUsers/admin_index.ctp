<?php /* SVN: $Id: $ */ ?>
<div class="propertyUsers index js-response">
<?php $url= array(
                'controller' => 'property_users',
                'action' => 'index',
                );?>
    <?php
		$all = '';
		foreach($propertyUserStatuses as $id => $propertyUserStatus):
        	$all += $propertyUserStatusesCount[$id];
    	endforeach;
	?>


<?php if(empty($this->request->params['isAjax'])) :?>	
<div class="round-5 project-chart-block clearfix">
    <ul class="project-chart clearfix unstyled">
		<li class="new-booking">
			<div class="payment-block-left">
				<div class="payment-block-right">
					<?php $url['filter_id'] = ConstPropertyUserStatus::PaymentPending;?>
					<ul class="unstyled">
						<li><span class="payment-pending"><?php echo $this->Html->link(sprintf("%s", __l('Payment Pending') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::PaymentPending]), $url, array('class' => 'all-property-user','title' => __l('Payment Pending')));?></span></li>
					</ul>
				</div>
			</div>
			<span class="new-booking"><span>New booking</span></span>
		</li>
		<li class="pending-approval">
			<div class="rejected-block">
				<ul class="unstyled">
					<?php $url['filter_id'] = ConstPropertyUserStatus::Rejected;?>
					<li><span class="rejected"><?php echo $this->Html->link(sprintf("%s", __l('Rejected') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::Rejected]), $url, array('class' => 'all-property-user','title' => __l('Rejected')));?></span></li>
					<?php $url['filter_id'] = ConstPropertyUserStatus::Canceled;?>
					<li class="canceled"><span class="canceled"><?php echo $this->Html->link(sprintf("%s", __l('Canceled') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::Canceled]), $url, array('class' => 'all-property-user','title' => __l('Canceled')));?></span></li>
				</ul>
			</div>
			<?php $url['filter_id'] = ConstPropertyUserStatus::WaitingforAcceptance;?>
			<span class="pending-approval"><?php echo $this->Html->link(sprintf("%s", __l('Pending Approval') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::WaitingforAcceptance]), $url, array('class' => 'all-property-user','title' => __l('Pending Approval')));?></span>
			<div class="expired-block">
				<ul class="unstyled">
					<?php $url['filter_id'] = ConstPropertyUserStatus::Expired;?>
					<li><span class="expired"><?php echo $this->Html->link(sprintf("%s", __l('Expired') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::Expired]), $url, array('class' => 'all-property-user','title' => __l('Expired')));?></span>
					<span class="chart-info js-bootstrap-tooltip" title="<?php echo sprintf(__l('Order confirmation request will be expired automatically in %s hrs '), Configure::read("property.auto_expire") * 24);?>"><?php echo __l('Info');?></span>
					</li>
					<?php $url['filter_id'] = ConstPropertyUserStatus::CanceledByAdmin;?>
					<li class="canceled-by-admin"><span class="canceled-by-admin"><?php echo $this->Html->link(sprintf("%s", __l('Canceled By Admin') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::CanceledByAdmin]), $url, array('class' => 'all-property-user','title' => __l('Canceled By Admin')));?></span></li>
				</ul>
			</div>
		</li>
		<li class="confirmed">
			<div class="confirmed-top-block">&nbsp;</div>
			<?php $url['filter_id'] = ConstPropertyUserStatus::Confirmed;?>
			<span class="confirmed"><?php echo $this->Html->link(sprintf("%s", __l('Confirmed') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::Confirmed]), $url, array('class' => 'all-property-user','title' => __l('Confirmed')));?></span>
			<div class="confirmed-bottom-block">&nbsp;</div>
		</li>
		<?php $url['filter_id'] = ConstPropertyUserStatus::Arrived;?>
		<li class="arrived"><span class="arrived"><?php echo $this->Html->link(sprintf("%s", __l('Arrived') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::Arrived]), $url, array('class' => 'all-property-user','title' => __l('Arrived')));?></span></li>
		<li class="cleared">
			<div class="traveler-review-block">
				<ul class="unstyled">
					<?php $url['filter_id'] = ConstPropertyUserStatus::WaitingforReview;?>
					<li><div class="traveler-arrow">&nbsp;</div><span class="traveler-review"><?php echo $this->Html->link(sprintf("%s", __l('Traveler review') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::WaitingforReview]), $url, array('class' => 'all-property-user','title' => __l('Traveler review')));?></span></li>
				</ul>
			</div>
			<?php $url['filter_id'] = ConstPropertyUserStatus::PaymentCleared;?>
			<span class="cleared"><?php echo $this->Html->link(sprintf("%s", __l('Cleared') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::PaymentCleared]), $url, array('class' => 'all-property-user','title' => __l('Cleared')));?></span>
			<span class="chart-info chart-info1 js-bootstrap-tooltip" title="<?php echo sprintf(__l('Full payment will be released on check in date at the time of booking + %s hrs'), Configure::read("property.days_after_amount_withdraw") * 24);?>"><?php echo __l('Info');?></span>

			<div class="host-review-block">
				<ul class="unstyled">
					<?php $url['filter_id'] = ConstPropertyUserStatus::HostReviewed;?>
					<li><span class="host-review"><?php echo $this->Html->link(sprintf("%s", __l('Host review') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::HostReviewed]), $url, array('class' => 'all-property-user','title' => __l('Host review')));?></span></li>
				</ul>
			</div>
		</li>
		<?php $url['filter_id'] = ConstPropertyUserStatus::Completed;?>
		<li class="completed"><span class="completed"><?php echo $this->Html->link(sprintf("%s", __l('Completed') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::Completed]), $url, array('class' => 'all-property-user','title' => __l('Completed')));?></span></li>
	</ul>
</div>
<?php endif; ?>
<div class="page-count-block clearfix">
	

<div class="">
<?php if(empty($this->request->params['named']['simple_view'])) : ?>
	<?php echo $this->Form->create('PropertyUser', array('type' => 'get', 'class' => 'form-search bot-mspace big-input span', 'action' => 'index')); ?>
		<?php echo $this->Form->input('q', array('placeholder' => __l('Keyword'),'label'=>false)); ?>
		<?php echo $this->Form->submit(__l('Search'),array('class'=>'btn btn-large hor-mspace btn-primary textb text-16'));?>
	<?php echo $this->Form->end(); ?>
<?php endif; ?>
</div>

</div>
<p class="left-mspace no-mar">
	<?php echo $this->element('paging_counter'); ?>
	</p>
<?php   
	echo $this->Form->create('PropertyUser' , array('class' => 'normal','action' => 'update'));
	echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); 
?>
<div class="overflow-block">
<table class="table table-striped table-hove">
<thead>
    <tr class="well no-mar no-pad" >
	<?php if(empty($this->request->params['named']['simple_view'])) : ?>
        <th class="graydarkc sep-right span2"><?php echo __l('Actions');?></th>
		<?php endif; ?>
        <th class="graydarkc sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('created');?></div></th>
        <th class="graydarkc sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort( 'id',__l('Trip ID #'));?></div></th>
		<th class="graydarkc sep-right dl"><div class="js-pagination"><?php echo $this->Paginator->sort( 'Property.title',__l('Property'));?></div></th>
        <th class="graydarkc sep-right dl"><div class="js-pagination"><?php echo $this->Paginator->sort( 'User.username',__l('Host'));?></div></th>
		<th class="graydarkc sep-right dl"><div class="js-pagination"><?php echo $this->Paginator->sort( 'User.username',__l('Traveler'));?></div></th>
        <th class="graydarkc sep-right dr"><div class="js-pagination"><?php echo __l('Traveler Service Fee') . ' (' . Configure::read('site.currency') . ')';?></div></th>
        <th class="graydarkc sep-right dr"><div class="js-pagination"><?php echo __l('Paid Amount to host') . ' (' . Configure::read('site.currency') . ')';?></div></th>
        <th class="graydarkc sep-right dr"><div class="js-pagination"><?php echo __l('Amount') . ' (' . Configure::read('site.currency') . ')';?></div></th>
        <th class="graydarkc sep-right dr"><div class="js-pagination"><?php echo __l('Commission Amount from Host') . ' (' . Configure::read('site.currency') . ')';?></div></th>
		<th class="graydarkc sep-right dl"><div class="js-pagination"><?php echo __l('Original Search Address');?></div></th>

    </tr>
</thead>
<tbody>
<?php
if (!empty($propertyUsers)):

$i = 0;
foreach ($propertyUsers as $propertyUser):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
<?php if(empty($this->request->params['named']['simple_view'])) : ?>
		<td class="actions dc">
			<span class="dropdown dc"> 
				<span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> 
					<span class="hide"><?php echo __l('Actions'); ?></span> 
				</span>
				<ul class="dropdown-menu arrow no-mar dl">
					<?php if($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance || $propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed):?>
						<li><?php echo $this->Html->link('<i class="icon-undo"></i>'.__l('Cancel and refund'), array('action' => 'delete', $propertyUser['PropertyUser']['id'], 'admin' => true), array('class' => 'delete js-delete', 'title' => __l('Cancel and refund'),'escape'=>false));?></li>
						<?php endif;?>
						<li>
						<?php echo $this->Html->link('<i class="icon-eye-open"></i>'.__l('View activities'), array('controller' => 'messages', 'action' => 'activities', 'type' => 'admin_order_view', 'order_id' => $propertyUser['PropertyUser']['id']), array('class' => 'view', 'title' => __l('View activities'),'escape'=>false));?>
						</li>
				</ul>
			 </span>		
		</td>
		<?php endif; ?>
		<td class="dc"><?php echo $this->Html->cDateTime($propertyUser['PropertyUser']['created']);?></td>
		<td class="dc"><?php echo $propertyUser['PropertyUser']['id'];?></td>
		<td class="dl propertys-title-info">
			<?php
				
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
            <div class="show js-bootstrap-tooltip span5 htruncate" data-original-title="<?php echo $this->Html->cText($propertyUser['Property']['title'],false); ?>" ><?php echo $this->Html->link($this->Html->cText($propertyUser['Property']['title'],false), array('controller'=> 'properties', 'action'=>'view', $propertyUser['Property']['slug'], 'admin' => false), array('escape' => false));?>
			</div>
						<span class="<?php echo $class; ?>" title="<?php echo $this->Html->cText($propertyUser['PropertyUserStatus']['name'], false);?>"><?php echo $this->Html->cText($propertyUser['PropertyUserStatus']['name'], false);?></span>
		</td>
		<td class="dl">
		<?php if(!empty($propertyUser['Property']['User']['username'])):
          echo $this->Html->link($this->Html->cText($propertyUser['Property']['User']['username']), array('controller'=> 'users', 'action'=>'view', $propertyUser['Property']['User']['username'], 'admin' => false), array('escape' => false));
          else:
          echo 'Guest';
          endif;?>
          </td>
		<td class="dl">
		<?php if(!empty($propertyUser['User']['username'])):
          echo $this->Html->link($this->Html->cText($propertyUser['User']['username']), array('controller'=> 'users', 'action'=>'view', $propertyUser['User']['username'], 'admin' => false), array('escape' => false));
          else:
          echo 'Guest';
          endif;?>
          </td>
		<td class="dr site-amount"><?php echo $this->Html->cCurrency($propertyUser['PropertyUser']['traveler_service_amount']);?></td>
		<td class="dr"><?php echo ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentCleared)?$this->Html->cCurrency($propertyUser['PropertyUser']['price'] - $propertyUser['PropertyUser']['host_service_amount']):'-';?></td>
		<td class="dr"><?php echo $this->Html->cCurrency($propertyUser['PropertyUser']['price']);?></td>
		<td class="dr site-amount"><?php echo $this->Html->cCurrency($propertyUser['PropertyUser']['host_service_amount']);?></td>
		<td class="dl"><?php echo $this->Html->cText($propertyUser['PropertyUser']['original_search_address']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="13"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Property Users available');?></p></div></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
</div>
<?php
if (!empty($propertyUsers)):
?>
        <div class="js-pagination clearfix space pull-right mob-clr dc">
            <?php echo $this->element('paging_links'); ?>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
</div>