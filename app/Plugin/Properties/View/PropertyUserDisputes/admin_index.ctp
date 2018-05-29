<?php /* SVN: $Id: $ */ ?>
<div class="propertyUserDisputes index">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Booking Disputes      </li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">

                <div class="clearfix">
    <?php foreach($status_count as $status):
	$class = ((!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == $status['id']) || (empty($status['id']) && empty($this->request->params['named']['filter_id']))) ? 'active' : null;
	$class_name = str_replace(' ', '', str_replace(' ', '', strtolower(trim($status['dispaly']))));
				
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc" title="'.__l($status['dispaly']).'">'.__l($status['dispaly']).'</dt>
						<dd title="'.$this->Html->cInt($status['count'] ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($status['count'] ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'property_user_disputes','action'=>'index','filter_id' => $status['id']), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
					endforeach; ?>
			</div>
			</div>
  <div class="clearfix dc">
					<?php echo $this->Form->create('PropertyUserDispute', array('type' => 'get', 'class' => 'form-search bot-mspace big-input span', 'action'=>'index')); ?>
					<?php echo $this->Form->input('q', array('placeholder' => __l('Keyword'),'class'=>'span9 ver-mspace text-16','label' => false)); ?>
					<?php echo $this->Form->submit(__l('Search'), array('class'=>'btn btn-large hor-mspace btn-primary textb text-16'));?>
					<?php echo $this->Form->end(); ?>
					
			</div>
			<?php echo $this->element('paging_counter'); ?>
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
        <th class="sep-right span2"><?php echo __l('Actions');?></th>
        <th class="dc sep-right"><?php echo $this->Paginator->sort( 'created',__l('Created'));?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort( 'user_id',__l('User'));?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort( 'property_id',__l('Property'));?></th>
        <th class="dc sep-right"><?php echo $this->Paginator->sort( 'property_order_id',__l('Booking #'));?></th>
		<th class="dl sep-right"><?php echo $this->Paginator->sort( 'property_user_status_id',__l('Booking Status'));?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort( 'is_traveler',__l('Property User Type'));?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort( 'dispute_type_id',__l('Dispute Type'));?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort( 'reason',__l('Reason'));?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort( 'dispute_status_id',__l('Dispute Status'));?></th>
		<th class="dl sep-right"><?php echo $this->Paginator->sort( 'resolved_date',__l('Resolved'));?></th>
		<th class="dl sep-right"><?php echo $this->Paginator->sort( 'is_favor_traveler',__l('Favor user type'));?></th>
        <th class="dc sep-right"><?php echo $this->Paginator->sort( 'last_replied_date',__l('Last Replied Date'));?></th>
        <th class="dc sep-right"><?php echo $this->Paginator->sort( 'dispute_converstation_count',__l('Dispute Conversation Count'));?></th>
    </tr></thead><tbody>
<?php
if (!empty($propertyUserDisputes)):

$i = 0;
foreach ($propertyUserDisputes as $propertyUser):
	$class = null;
	if(in_array($propertyUser['PropertyUser']['property_user_status_id'], array(ConstPropertyUserStatus::Canceled, ConstPropertyUserStatus::Rejected, ConstPropertyUserStatus::Expired, ConstPropertyUserStatus::CanceledByAdmin))){
		$class = ' class="errorrow"';
	}elseif ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
	<td class="dc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			<li><?php echo $this->Html->link('<i class="icon-eye-open"></i>'.__l('View activities'), array('controller' => 'messages', 'action' => 'activities', 'order_id' => $propertyUser['PropertyUser']['id']), array('escape' => false,'class' => 'edit js-edit', 'title' => __l('View activities')));?></li>
			   </ul>
   	  </span></td>
		
		<td class="dc"><?php echo $this->Html->cDateTimeHighlight($propertyUser['PropertyUserDispute']['created']);?></td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($propertyUser['User']['username']), array('controller'=> 'users', 'action'=>'view', $propertyUser['User']['username'], 'admin' => false), array('class'=>'js-no-pjax', 'title' => $this->Html->cText($propertyUser['User']['username'], false), 'escape' => false));?></td>
		<td class="dl"><div class="htruncate js-bootstrap-tooltip span5" title="<?php echo $propertyUser['Property']['title'];?>" ><?php echo $this->Html->link($this->Html->cText($propertyUser['Property']['title'],false), array('controller'=> 'properties', 'action'=>'view', $propertyUser['Property']['slug'], 'admin' => false), array('class'=>'js-no-pjax','escape' => false));?></div></td>
		<td class="dc"><?php echo $propertyUser['PropertyUser']['id'];?></td>
		<td class="dl"><div class="htruncate js-bootstrap-tooltip span7" title="<?php echo $propertyUser['PropertyUser']['PropertyUserStatus']['name']; ?>"><?php echo !empty($propertyUser['PropertyUser']['PropertyUserStatus']['name']) ? $this->Html->cText($propertyUser['PropertyUser']['PropertyUserStatus']['name']) : '';?></div></td>
		<td class="dl"><?php echo !empty($propertyUser['PropertyUserDispute']['is_traveler']) ? __l('Traveler') : __l('Host');?></td>
		<td class="dl"><div class="htruncate js-bootstrap-tooltip span5" title="<?php echo $propertyUser['DisputeType']['name'];?>" ><?php echo $this->Html->cText($propertyUser['DisputeType']['name']);?></div></td>
		<td class="dl"><div class="htruncate js-bootstrap-tooltip span5" title="<?php echo $propertyUser['PropertyUserDispute']['reason'];?>" ><?php echo $this->Html->cText($propertyUser['PropertyUserDispute']['reason']);?></div></td>
		<td class="dl"><?php echo $this->Html->cText($propertyUser['DisputeStatus']['name']);?></td>
		<td class="dc"><?php echo !empty($propertyUser['PropertyUserDispute']['resolved_date']) ? $this->Html->cDateTimeHighlight($propertyUser['PropertyUserDispute']['resolved_date']) : __l('Not yet');?></td>
		<td class="dl"><?php echo !empty($propertyUser['PropertyUserDispute']['is_favor_traveler']) ? __l('Traveler') : __l('Host');?></td>
		<td class="dc"><?php echo !empty($propertyUser['PropertyUserDispute']['last_replied_date']) ? $this->Html->cDateTimeHighlight($propertyUser['PropertyUserDispute']['last_replied_date']) : '-';?></td>
		<td class="dc"><?php echo $this->Html->cInt($propertyUser['PropertyUserDispute']['dispute_converstation_count']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="17"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Bookings available');?></p></div></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
</div>
 <div class="js-pagination pagination pull-right no-mar mob-clr dc">
            <?php echo $this->element('paging_links'); ?>
        </div>
</div>