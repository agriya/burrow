<?php /* SVN: $Id: $ */ ?>
<div class="js-responses js-response">
<?php 
$pjax_class=empty($this->request->params['isAjax'])?'':'js-no-pjax';
$fromAjax = FALSE;
$link_ajax = array();
if(isset($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'ajax'):
	$fromAjax = TRUE;
	$link_ajax = array("from" => "ajax");
 endif; ?>
<div class="properties index row no-mar">
<?php if(empty($this->request->params['isAjax'])) { ?>
<h2 class="ver-space sep-bot top-mspace text-32 sep-bot" ><?php echo __l('My Properties');?></h2>
<?php } ?>
<section class="row ver-space bot-mspace clearfix <?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?>">
	<div class="span20 pull-left">
				<?php $class=(empty($this->request->params['named']['status']) && !empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties')? 'active':NULL;?>
				<?php
				$link = array_merge(array('controller'=>'properties','action'=>'index','type' => 'myproperties'), $link_ajax);
				echo $this->Html->link( '
					<dl class="dc sep-left sep-right list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc">'.__l('All').'</dt>
						<dd title="'.$all_count.'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($all_count, false).'</dd>                  	
					</dl>'
					,  $link, array('escape' => false, 'class' => $pjax_class));
				?>
				<?php if (Configure::read('property.listing_fee')): ?>
             	<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'pending')?'active':NULL;?>
				<?php
				$link = array_merge(array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'pending'), $link_ajax);
				echo $this->Html->link( '
					<dl class="dc sep-left sep-right list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc">'. __l('Payment Pending').'</dt>
						<dd title="'.$pending_count.'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($pending_count, false).'</dd>                  	
					</dl>'
					,$link , array('escape' => false, 'class' => $pjax_class));
				?>
				<?php endif; ?>
			<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'active')?'active':NULL;?>
				<?php
				$link = array_merge(array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'active'), $link_ajax);
				echo $this->Html->link( '
					<dl class="dc sep-left sep-right list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc">'.__l('Enabled').'</dt>
						<dd title="'.$active_count.'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($active_count, false) .'</dd>                  	
					</dl>'
					,$link , array('escape' => false, 'class' => $pjax_class));
				?>
			<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'inactive')?'active':NULL;?>
				<?php
				$link = array_merge(array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'inactive'), $link_ajax);
				echo $this->Html->link( '
					<dl class="dc sep-left sep-right list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc">'.__l('Disabled').'</dt>
						<dd title="'.$inactive_count.'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($inactive_count, false).'</dd>                  	
					</dl>'
					, $link, array('escape' => false, 'class' => $pjax_class));
				?>
				<?php if (Configure::read('property.is_property_verification_enabled')): ?>
        			<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'verified')?'active':NULL;?>
				<?php
				$link = array_merge(array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'verified'), $link_ajax);
				echo $this->Html->link( '
					<dl class="dc sep-left sep-right list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc">'.__l('Verified').'</dt>
						<dd title="'.$verified_count.'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($verified_count, false).'</dd>                  	
					</dl>'
					,$link , array('escape' => false, 'class' => $pjax_class));
				?>
        			<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'waiting_for_verification')?'active':NULL;?>
				<?php
				$link = array_merge(array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'waiting_for_verification'), $link_ajax);
				echo $this->Html->link( '
					<dl class="dc sep-left sep-right list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc">'.__l('Waiting for verification ').'</dt>
						<dd title="'.$waiting_for_verification_count.'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($waiting_for_verification_count, false).'</dd>                  	
					</dl>'
					,$link , array('escape' => false, 'class' => $pjax_class));
				?>
				<?php endif; ?>
				<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'waiting_for_approval')?'active':NULL;?>
				<?php
				$link = array_merge(array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'waiting_for_approval'), $link_ajax);
				echo $this->Html->link( '
					<dl class="dc sep-left sep-right list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc">'.__l('Waiting for approval').'</dt>
						<dd title="'.$waiting_for_approval_count.'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($waiting_for_approval_count, false).'</dd>                  	
					</dl>'
					,$link , array('escape' => false, 'class' => $pjax_class));
				?>
        	   <?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'imported')?'active':'';?>
				<?php
				$link = array_merge(array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'imported'), $link_ajax);
				echo $this->Html->link( '
					<dl class="dc sep-left list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc">'.__l('Imported from AirBnB').'</dt>
						<dd title="'.$imported_from_airbnb_count.'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($imported_from_airbnb_count, false).'</dd>                  	
					</dl>'
					,$link , array('escape' => false, 'class' => $pjax_class));
				?>
   </div>
   <?php if(empty($this->request->params['isAjax'])) { ?>
    <div class="span4 pull-left no-mar">
         <?php
            $day1= date("D j", mktime(0, 0, 0, date("m"),date("d")-1,date("Y")));
            $day2=date("D j", mktime(0, 0, 0, date("m"),date("d")-2,date("Y")));
            $day3=date("D j", mktime(0, 0, 0, date("m"),date("d")-3,date("Y")));
            $axis1=ceil($chart_data['max_count']/3);
            $axis2=ceil($chart_data['max_count']/3)*2;
            $axis3=ceil($chart_data['max_count']/3)*3;
            	 
				 $image_url='http://chart.apis.google.com/chart?chf=a,s,000000FA|bg,s,67676700&amp;chxl=0:|0|'.$day3.'|'.$day2.'|'.$day1.'|1:|0|'.$axis1.'|'.$axis2.'|'.$axis3.'&amp;chxs=0,676767,11.5,0,lt,676767&amp;chxtc=0,4&amp;chxt=x,y&amp;chs=200x100&amp;cht=lxy&amp;chco=0066E4,F47564&amp;chds=0,3,0,'.$axis3.',0,3,0,'.$axis3.'&amp;chd=t:1,2,3|'. $chart_data['PropertyView'][3]['count'].','.$chart_data['PropertyView'][2]['count'].','.$chart_data['PropertyView'][1]['count'].'|1,2,3|'.$chart_data['PropertyUser'][3]['count'].','.$chart_data['PropertyUser'][2]['count'].','.$chart_data['PropertyUser'][1]['count'].'&amp;chdl=Views|Bookings&amp;chdlp=b&amp;chls=2,4,1|1&amp;chma=5,5,5,25';
            echo $this->Html->image($image_url);
            ?>
    </div>
	<?php } ?>
</section>

<section class="row no-mar bot-space">
<?php 
	echo $this->Form->create('Property' , array('class' => 'normal','action' => 'update'));  
	echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url));
	$view_count_url = Router::url(array(
		'controller' => 'properties',
		'action' => 'update_view_count',
	), true);
?>

<?php
if (!empty($properties)):
?>
<table class="table my-property-pad ver-mspace js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}">
<?php
$i = 0;
foreach ($properties as $property):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	
	<tr class="js-even well no-mar no-pad">
		<th class="properties-title properties-title-section actions graydarkc sep-bot sep-right">
			<div class="clearfix properties-info-block span9">
				<div class="span inline top-smspace"><div class="top-space"><?php echo $this->Form->input('Property.'.$property['Property']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$property['Property']['id'],  'class' => 'js-checkbox-list', 'label' => "")); ?></div></div>
				<div class="span inline"><h3 class="dl span7 htruncate text-24"><?php echo $this->Html->link($this->Html->cText($property['Property']['title'],false), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'] ,'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false, 'class' => 'js-bootstrap-tooltip graydarkc')); ?></h3></div>
			</div>
			<div class="select-block table-select-block dl">
              	<?php if (empty($property['Property']['is_active'])): ?>
					<span class="label pull-left smspace mob-inline"> <?php echo __l('Disabled'); ?> </span>
				<?php endif; ?>
				<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == ConstVerification::Verified): ?>
    			     <span class="label label-confirmed pull-left smspace mob-inline" title="<?php echo __l('Verified'); ?>">	<?php echo __l('Verified'); ?></span>
    			<?php endif; ?>
				<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == ConstVerification::WaitingForVerification): ?>
				    <span class="label label-warning pull-left smspace mob-inline" title="<?php	echo __l('Waiting for Verification'); ?>">	<?php	echo __l('Waiting for Verification'); ?></span>
				<?php endif; ?>
				<?php if (empty($property['Property']['is_approved'])): ?>
				    <span class="label label-pendingapproval pull-left smspace mob-inline" title="<?php	echo __l('Waiting for Approval'); ?>">	<?php	echo __l('Waiting for Approval'); ?></span>
				<?php endif; ?>
				<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] === ConstVerification::VerificationRejected): ?>
				    <span class="label label-reject pull-left smspace mob-inline" title="<?php echo __l('Verification Rejected'); ?>">	<?php echo __l('Verification Rejected'); ?></span>
				<?php endif; ?>
				<?php if (empty($property['Property']['is_paid']) && Configure::read('property.listing_fee')): ?>
				    <span class="label label-paymentpending pull-left smspace mob-inline" title="<?php	echo __l('Payment Pending'); ?>">	<?php	echo __l('Payment Pending'); ?></span>
				<?php endif; ?>
				<?php if (!empty($property['Property']['is_featured'])): ?>
					<span class="label featured pull-left smspace mob-inline" title="<?php echo __l('Featured'); ?>">	<?php echo __l('Featured'); ?></span>
				<?php endif; ?>
            </div>
		</th>
		<?php if(!Configure::read('property.is_enable_security_deposit')): ?>
		<th colspan="3" class="graydarkc sep-bot dc sep-right"><?php echo __l('Price').' ('.Configure::read('site.currency').')'; ?></th>
		<?php else: ?>
		<th colspan="4" class="graydarkc sep-bot dc sep-right"><?php echo __l('Price').' ('.Configure::read('site.currency').')'; ?></th>
		<?php endif; ?>
		<th colspan="3" class="graydarkc sep-bot dc sep-right"><?php echo __l('Booked'); ?></th>
		<th rowspan="2" class="graydarkc sep-bot dc sep-right sep-left"><?php echo $this->Paginator->sort('property_view_count',__l('Views'));?></th>
		<th colspan="3" class="graydarkc sep-bot dc sep-right"><?php echo __l('Revenue').' ('.Configure::read('site.currency').')';?></th>
	</tr>
	
	<tr class="sub-title">
	<td rowspan="2" class="actions properties-title dl graydarkc sep-bot ">
			<div class="clearfix properties-action-block">
				<div class=" pull-left">
					<?php
						$property['Attachment'][0] = !empty($property['Attachment'][0]) ? $property['Attachment'][0] : array();
						echo $this->Html->link($this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false, 'class' => 'prop-img'));
					?>
				</div>
				<div class="span4 left-space">
					<div class="clearfix"><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'edit', $property['Property']['id']), array('class' => 'edit js-edit graydarkc', 'title' => __l('Edit'),'escape'=>false));?></div>

					<div class="clearfix"><?php echo $this->Html->link('<i class=" icon-calendar"></i>'.__l('Calendar'), array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'property_id' => $property['Property']['id'], 'admin' => false), array('title' => __l('Calendar'),'class' => 'calendar graydarkc','escape'=>false));?></div>
					<?php if (!empty($property['Property']['is_active']) && !empty($property['Property']['is_paid'])) { ?>
						<div class="clearfix"><?php echo $this->Html->link('<i class=" icon-plane"></i>'.__l('Post to Craigslist'), array('controller' => 'properties', 'action' => 'post_to_craigslist', 'property_id' => $property['Property']['id'], 'admin' => false), array('title' => __l('Post to Craigslist'), 'class' => 'craigslist graydarkc', 'escape'=>false));?></div>
					<?php } ?>
					<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] === null) { ?> 
						<div class="clearfix"><?php echo $this->Html->link('<i class="icon-circle-arrow-up"></i>'.__l('Get Verified'), array('controller' => 'properties', 'action' => 'property_verify_now', $property['Property']['id'], 'admin' => false), array('title' => __l('Get Verified'),'class' => 'get-verify graydarkc', 'escape'=>false));?></div>
					<?php } ?>
					<?php if (empty($property['Property']['is_paid']) && Configure::read('property.listing_fee')): ?>
						<div class="clearfix"><?php echo $this->Html->link('<i class="icon-money"></i>'.__l('Pay Listing Fee'), array('controller' => 'properties', 'action' => 'property_pay_now', $property['Property']['id'], 'admin' => false), array('title' => __l('Pay Listing Fee'),'class' => 'listing-fee graydarkc','escape'=>false, 'escape'=>false));?></div>
					<?php endif; ?>
					<div class="clearfix">
						<?php 
							if (empty($property['Property']['is_active'])) {
								echo $this->Html->link('<i class="icon-ok-circle"></i>'.__l('Enable'), array('controller' => 'properties', 'action' => 'updateactions', $property['Property']['id'], 'active', 'admin' => false, '?r=' . $this->request->url), array('title' => __l('Enable'),'class' => 'enable graydarkc js-confirm','escape'=>false));
							} elseif(!empty($property['Property']['is_active'])) {
								echo $this->Html->link('<i class="icon-remove-circle"></i>'.__l('Disable'), array('controller' => 'properties', 'action' => 'updateactions', $property['Property']['id'], 'inactive', 'admin' => false, '?r=' . $this->request->url), array('title' => __l('Disable'),'class' => 'disable graydarkc js-confirm','escape'=>false));
							} 
						?>
					</div>
				</div>
			</div>
		</td>
		<th class="graydarkc sep-bot dr"><div class="js-pagination"><?php echo $this->Paginator->sort('price_per_night',__l('Per Night'), array('class' => 'js-no-pjax'));?></div></th>
        <th class="graydarkc sep-bot dr" ><div class="js-pagination"><?php echo $this->Paginator->sort('price_per_week',__l('Per Week'), array('class' => 'js-no-pjax'));?></div></th>
        <th class="graydarkc sep-bot dr" ><div class="js-pagination"><?php echo $this->Paginator->sort('price_per_month',__l('Per Month'), array('class' => 'js-no-pjax'));?></div></th>
		<?php if(Configure::read('property.is_enable_security_deposit')): ?>
			<th class="graydarkc" ><div class="js-pagination"><?php echo $this->Paginator->sort('security_deposit',__l('Security Deposit'), array('class' => 'js-no-pjax'));?></div></th>
		<?php endif; ?>
		<!-- @todo "Discount percentage" -->
		<th class="graydarkc sep-bot dc"><div class="js-pagination"><?php echo $this->Paginator->sort('sales_pending_count',__l('Pending'), array('class' => 'js-no-pjax'));?></div></th>
        <th class="graydarkc sep-bot dc"><div class="js-pagination"><?php echo $this->Paginator->sort('sales_pipeline_count',__l('Active'), array('class' => 'js-no-pjax'));?></div></th>
        <th class="graydarkc sep-bot dc"><div class="js-pagination"><?php echo $this->Paginator->sort('sales_completed_count',__l('Completed'), array('class' => 'js-no-pjax'));?></div></th>
		<th class="graydarkc sep-bot dc"><div class="js-pagination"><?php echo $this->Paginator->sort('sales_pipeline_amount',__l('Pipeline'), array('class' => 'js-no-pjax'));?></div></th>
        <th class="graydarkc sep-bot dc"><div class="js-pagination"><?php echo $this->Paginator->sort('sales_cleared_amount',__l('Cleared'), array('class' => 'js-no-pjax'));?></div></th>
        <th class="graydarkc sep-bot"><div class="js-pagination"><?php echo $this->Paginator->sort('sales_lost_amount',__l('Lost'), array('class' => 'js-no-pjax'));?></div></th>
	</tr>
	
	<tr <?php echo $class;?>>
		
		<td class="dr sep-bot"><?php echo $this->Html->cCurrency($property['Property']['price_per_night']);?></td>
		<td class="dr sep-bot"><?php echo ($property['Property']['price_per_week']!=0)?$this->Html->cCurrency($property['Property']['price_per_week']):'-';?></td>
		<td class="dr sep-bot"><?php echo ($property['Property']['price_per_month']!=0)?$this->Html->cCurrency($property['Property']['price_per_month']):'-';?></td>
		<?php if(Configure::read('property.is_enable_security_deposit')): ?>
		<td class="dr sep-bot sep-top"><?php echo ($property['Property']['security_deposit']!=0)?$this->Html->cCurrency($property['Property']['security_deposit']):'-';?></td>
		<?php endif; ?>
		<td class="dc sep-bot"><span><?php echo $this->Html->cInt($property['Property']['sales_pending_count']);?></span></td>
		<td class="dc sep-bot"><?php echo $this->Html->cInt($property['Property']['sales_pipeline_count']);?></td>
		<td class="dc sep-bot"><?php echo $this->Html->cInt($property['Property']['sales_completed_count']);?></td>
		<td class="sep-bot js-view-count-property-id js-view-count-property-id-<?php echo $property['Property']['id']; ?> {'id':'<?php echo $property['Property']['id']; ?>'}"><?php echo $this->Html->cInt($property['Property']['property_view_count']);?></td>
		<td class="dr sep-bot"><span class="highlight-pipeline tb"><?php echo $this->Html->cCurrency($property['Property']['sales_pipeline_amount']);?></span></td>
		<td class="dr sep-bot"><span class="highlight-cleared tb"><?php echo  $this->Html->cCurrency($property['Property']['revenue']);?></span></td>
		<td class="dr sep-bot"><span class="highlight-lost tb"><?php echo $this->Html->cCurrency($property['Property']['sales_lost_amount']);?></span></td>
	</tr>
	<tr><td colspan="12" class="empty-list no-bor">&nbsp;</td></tr>
<?php
    endforeach;
else:
?>
<?php if (!empty($properties)) :?>
    <tr>
		<th class="graydarkc sep-bot" rowspan="2"><?php echo __l('Select');?></th>
        <th class="graydarkc sep-bot" rowspan="2" class="actions"><?php echo __l('Actions');?></th>
        <th class="graydarkc sep-bot sep-top" rowspan="2"><?php echo $this->Paginator->sort( 'title',__l('Title'));?></th>
		<?php if(!Configure::read('property.is_enable_security_deposit')): ?>
        <th class="graydarkc sep-bot" colspan="3"><?php echo __l('Price'); ?></th>
		<?php else: ?>
        <th class="graydarkc sep-bot" colspan="4"><?php echo __l('Price'); ?></th>
		<?php endif; ?>
		<th class="graydarkc sep-bot" colspan="3"><?php echo __l('Booked'); ?></th>
        <th class="graydarkc sep-bot" colspan="3"><?php echo __l('Revenue');?></th>
		<th class="graydarkc sep-bot" rowspan="2"><?php echo $this->Paginator->sort('property_view_count',__l('Views'));?></th>
    </tr>
	<tr>
        <th class="graydarkc sep-right sep-bot"><?php echo $this->Paginator->sort('price_per_night',__l('Per Night').' ('.Configure::read('site.currency').')');?></th>
        <th class="graydarkc sep-right sep-bot"><?php echo $this->Paginator->sort('price_per_week',__l('Per Week').' ('.Configure::read('site.currency').')');?></th>
        <th class="graydarkc sep-right sep-bot" ><?php echo $this->Paginator->sort('price_per_month',__l('Per Month').' ('.Configure::read('site.currency').')');?></th>
		<?php if(Configure::read('property.is_enable_security_deposit')): ?>
		 <th class="graydarkc sep-right sep-bot" ><?php echo $this->Paginator->sort('security_deposit',__l('Security Deposit').' ('.Configure::read('site.currency').')');?></th>
		<?php endif; ?>
		<!-- @todo "Discount percentage" -->
		<th class="graydarkc sep-right sep-bot" ><?php echo $this->Paginator->sort('sales_pending_count',__l('Pending'));?></th>
        <th class="graydarkc sep-right sep-bot" ><?php echo $this->Paginator->sort('sales_pipeline_count',__l('Active'));?></th>
        <th class="graydarkc sep-right sep-bot" ><?php echo $this->Paginator->sort('sales_completed_count',__l('Completed'));?></th>
		<th class="graydarkc sep-right sep-bot" ><?php echo $this->Paginator->sort('sales_pipeline_amount',__l('Pipeline').' ('.Configure::read('site.currency').')');?></th>
        <th class="graydarkc sep-right sep-bot" ><?php echo $this->Paginator->sort('sales_cleared_amount',__l('Cleared').' ('.Configure::read('site.currency').')');?></th>
        <th class="graydarkc sep-right sep-bot" ><?php echo $this->Paginator->sort('sales_lost_amount',__l('Lost').' ('.Configure::read('site.currency').')');?></th>
	</tr>
  <?php endif;?>
	<tr>
		<td colspan="15">
		<div class="sep-top ">
			<p class=" space dc grayc ver-mspace top-space text-16"><?php echo __l('No Properties available');?></p>
		</div>
		</td>
	</tr>
<?php
endif;
?>
</table>



<?php

	if (!empty($properties)) :
		?>
		<div class="select-block  ver-mspace pull-left mob-clr dc span9">
		<div class="span top-mspace">
			 <span class="graydarkc">
			<?php echo __l('Select:'); ?>
			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select-all hor-smspace grayc','title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select-none hor-smspace grayc','title' => __l('None'))); ?>
			</span>
		</div>
			<?php echo $this->Form->input('more_action_id', array('class' => 'span5 js-admin-index-autosubmit js-no-pjax', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
		</div>
		<?php endif; 
 ?>
<?php
if (!empty($properties)) { ?>
		<div class="<?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?> pagination pull-right no-mar mob-clr dc">
<?php echo $this->element('paging_links'); ?>
	</div>
<?php	}
?>
<?php
    echo $this->Form->end();
?>
</section>
</div>
</div>