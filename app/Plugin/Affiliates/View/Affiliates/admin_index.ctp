<?php /* SVN: $Id: $ */ ?>
<div class="affiliates index">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Affiliates       </li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
				
				
				<div class="clearfix dc">
		<div class="record-info clearfix record-info1 select-block pull-right">
			<?php $class = ($this->request->params['controller'] == 'affiliate_requests') ? ' class="active"' : null; ?>
				<span class="waitingforyourreview round-3 no-bor right-space <?php echo $class;?>"><?php echo $this->Html->link('<i class="icon-certificate text-16"></i>' . __l('Affiliate  Requests'), array('controller' => 'affiliate_requests', 'action' => 'index'),array('title' => __l('Affiliates  Requests'), 'class' => 'tb', 'escape' => false)); ?></span>
			<?php $class = ($this->request->params['controller'] == 'affiliate_cash_withdrawals') ? ' class="active"' : null; ?>
				<span class="waitingforyourreview round-3 no-bor right-space <?php echo $class;?>"><?php echo $this->Html->link('<i class="icon-briefcase text-16"></i>' . __l('Affiliate Cash Withdrawal Requests'), array('controller' => 'affiliate_cash_withdrawals', 'action' => 'index'),array('title' => __l('Affiliate Cash Withdrawal Requests'), 'class' => 'tb', 'escape' => false)); ?></span>
				<span class="all round-3 no-bor"><?php echo $this->Html->link('<i class="icon-cog text-16"></i>' . __l('Settings'), array('controller' => 'settings', 'action' => 'edit', 14),array('title' => __l('Settings'), 'class' => 'tb', 'escape' => false)); ?></span>
                
		</div>
		</div>
    

<?php echo $this->element('admin_affiliate_stat', array('config' => 'sec')); ?>
<h2><?php echo __l('Commission History');?></h2>
<div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
                <div class="clearfix">
			<?php
			$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::Pending) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc  list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Pending').'">'.__l('Pending').'</dt>
						<dd title="'.$this->Html->cInt($pending,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($pending,false).'</dd>
						
					</dl>'
					, array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::Pending), array('escape' => false,'class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Pending')));
			$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::Canceled) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc  list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Canceled').'">'.__l('Canceled').'</dt>
						<dd title="'.$this->Html->cInt($canceled,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($canceled,false).'</dd>
						
					</dl>'
					, array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::Canceled), array('escape' => false,'class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Canceled')));
			$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::PipeLine) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc  list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('PipeLine').'">'.__l('PipeLine').'</dt>
						<dd title="'.$this->Html->cInt($pipeline,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($pipeline,false).'</dd>
						
					</dl>'
					, array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::PipeLine), array('escape' => false,'class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('PipeLine')));
			$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::Completed) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc  list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Completed').'">'.__l('Completed').'</dt>
						<dd title="'.$this->Html->cInt($completed,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($completed,false).'</dd>
						
					</dl>'
					, array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::Completed), array('escape' => false,'class' => 'no-under show pull-left mob-clr bot-space bot-mspace cur', 'title' => __l('Completed')));
			
			?>
           
			  
</div>
</div>
<?php echo $this->element('paging_counter');?>
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
        <th class="sep-right dc"><?php echo $this->Paginator->sort( 'created',__l('Created'));?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort( 'AffiliateUser.username',__l('Affiliate User'));?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort( 'AffiliateType.name',__l('Type'));?></th>
        <th class="dc sep-right"><?php echo $this->Paginator->sort( 'AffiliateStatus.name',__l('Status'));?></th>
        <th class="dr sep-right"><?php echo $this->Paginator->sort( 'commission_amount',__l('Commission').' ('.Configure::read('site.currency').')');?></th>
    </tr></thead><tbody>
<?php
if (!empty($affiliates)):

$i = 0;
foreach ($affiliates as $affiliate):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
        <td class="dc"> <?php echo $this->Html->cDateTimeHighlight($affiliate['Affiliate']['created']);?></td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($affiliate['AffiliateUser']['username']), array('controller'=> 'users', 'action'=>'view', $affiliate['AffiliateUser']['username'], 'admin' => false), array('class'=>'js-no-pjax', 'title' => $this->Html->cText($affiliate['AffiliateUser']['username'], false), 'escape' => false));?></td>
		 
        <td class="dl"> <?php echo $this->Html->cText($affiliate['AffiliateType']['name']);?> </td>
		
		<td class="dc">
           <?php echo $this->Html->cText($affiliate['AffiliateStatus']['name']);   ?>
           <?php  if($affiliate['AffiliateStatus']['id'] == ConstAffiliateStatus::PipeLine): ?>
                   <?php echo '['.__l('Since').': '.$this->Html->cDateTimeHighlight($affiliate['Affiliate']['commission_holding_start_date']). ']';?>
           <?php endif; ?>
        </td>
		<td class="dr"><?php echo $this->Html->cCurrency($affiliate['Affiliate']['commission_amount']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="11">
			<div class="space dc">
				<p class="ver-mspace grayc top-space text-16 "><?php echo __l('No Commission history available');?></p>
			</div>
		</td>
	</tr>
<?php
endif;
?></tbody>
</table>

<?php
if (!empty($affiliates)) {
    echo $this->element('paging_links');
}
?>
</div>