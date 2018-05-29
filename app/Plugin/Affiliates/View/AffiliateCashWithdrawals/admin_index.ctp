<?php /* SVN: $Id: admin_index.ctp 2077 2010-04-20 10:42:36Z josephine_065at09 $ */ ?>
<div class="affiliateCashWithdrawals index js-response js-admin-index-autosubmit js-no-pjax-over-block">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Withdraw Fund Requests - Pending</li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
	<div class="page-info alert alert-info">
		<?php echo __l('Affiliate module is currently enabled. You can disable or configure it from').' '.$this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 14), array('target' => '_blank')). __l(' page');?>
	</div>
	<div class="clearfix">
				<?php 
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstAffiliateCashWithdrawalStatus::Pending) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc  list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Pending').'">'.__l('Pending').'</dt>
						<dd title="'.$this->Html->cInt($pending ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($pending ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'affiliate_cash_withdrawals','action'=>'index','filter_id' => ConstAffiliateCashWithdrawalStatus::Pending), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstAffiliateCashWithdrawalStatus::Rejected) ? 'active' : null;
				
				echo $this->Html->link( '
					<dl class="dc  list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Rejected').'">'.__l('Rejected').'</dt>
						<dd title="'.$this->Html->cInt($rejected ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($rejected ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'affiliate_cash_withdrawals','action'=>'index','filter_id' => ConstAffiliateCashWithdrawalStatus::Rejected), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstAffiliateCashWithdrawalStatus::Success) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc  list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Success').'">'.__l('Success').'</dt>
						<dd title="'.$this->Html->cInt($success ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($success ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'affiliate_cash_withdrawals','action'=>'index','filter_id' => ConstAffiliateCashWithdrawalStatus::Success), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (empty($this->request->params['named']['filter_id'])) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc  list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('All').'">'.__l('All').'</dt>
						<dd title="'.$this->Html->cInt($approved + $pending + $rejected + $success ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt(($approved + $pending + $rejected + $success), false).'</dd>                  	
					</dl>'
					, array('controller'=>'affiliate_cash_withdrawals','action'=>'index'), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				
				?>
              </div>
		 <?php echo $this->element('paging_counter');?>
    <?php echo $this->Form->create('AffiliateCashWithdrawal' , array('class' => 'normal','action' => 'update')); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
	<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
            <?php if (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Pending):?>
            <th class="select dc sep-right">Select</th>
            <?php endif; ?>
			 <?php if (!empty($affiliateCashWithdrawals) && (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Approved)):?>
			<th>
            	<?php echo __l('Action'); ?>
			</th>    
            <?php endif;?>        
            <th class="dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.created',__l('Requested on'));?></div></th>
            <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username',__l('User'));?></div></th>
            <th class="dr sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'AffiliateCashWithdrawal.amount',__l('Amount')).' ('.Configure::read('site.currency').')';?> </div></th>
            <?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Success) { ?>
                <th class="dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.modified',__l('Paid on'));?></div></th>
            <?php } ?>
            
            <?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') { ?>
                <th class="dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.name',__l('Status'));?></div></th>
            <?php } ?>
        </tr></thead><tbody>
    <?php
    if (!empty($affiliateCashWithdrawals)):
    
    $i = 0;
    foreach ($affiliateCashWithdrawals as $affiliateCashWithdrawal):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
    ?>
        <tr <?php echo $class;?>>
            <?php if (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Pending):?>
                <td class="select dc">
                    <?php echo $this->Form->input('AffiliateCashWithdrawal.'.$affiliateCashWithdrawal['AffiliateCashWithdrawal']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$affiliateCashWithdrawal['AffiliateCashWithdrawal']['id'], 'label' => "", 'div' => 'top-space', 'class' => 'js-checkbox-list ' )); ?>	
                </td>
            <?php endif; ?>
		    <?php if (!empty($affiliateCashWithdrawals) && (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Approved)):?>
			<td class="actions">
                      <div class="action-block">
                        <span class="action-information-block">
                            <span class="action-left-block">&nbsp;
                            </span>
                                <span class="action-center-block">
                                    <span class="action-info">
                                        <?php echo __l('Action');?>
                                     </span>
                                </span>
                            </span>
                            <div class="action-inner-block">
                            <div class="action-inner-left-block">
                                <ul class="action-link clearfix">
                                	
						<li><?php echo $this->Html->link(__l('Move to success'), array('action' => 'move_to', $affiliateCashWithdrawal['AffiliateCashWithdrawal']['id'], 'type' => 'success'), array('class' => 'move-to-success', 'title' => __l('Move to success')));?></li>
						<li><?php echo $this->Html->link(__l('Move to failed'), array('action' => 'move_to', $affiliateCashWithdrawal['AffiliateCashWithdrawal']['id'], 'type' => 'failed'), array('class' => 'move-to-failed', 'title' => __l('Move to failed')));?></li>
        						</ul>
        					   </div>
        						<div class="action-bottom-block"></div>
							  </div>
						 </div>
  					</td>            
			<?php endif;?>   
           <td class="dc">	<?php  echo $this->Html->cDateTimeHighlight($affiliateCashWithdrawal['AffiliateCashWithdrawal']['created']);  ?> </td>                     
            <td class="dl">
               <div class="clearfix">
			<?php if(!empty($affiliateCashWithdrawal['User']['UserAvatar'])) { ?>
            <?php echo $this->Html->showImage('UserAvatar', $affiliateCashWithdrawal['User']['UserAvatar'], array('dimension' => 'micro_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($affiliateCashWithdrawal['User']['username'], false)), 'title' => $this->Html->cText($affiliateCashWithdrawal['User']['username'], false)));?>
            <?php } ?>
			<?php echo $this->Html->link($this->Html->cText($affiliateCashWithdrawal['User']['username']), array('controller'=> 'users', 'action'=>'view', $affiliateCashWithdrawal['User']['username'],'admin' => false), array('title'=>$this->Html->cText($affiliateCashWithdrawal['User']['username'],false),'class'=>'js-no-pjax','escape' => false));?>
            </div>
			</td>
            <td class="dr"><?php echo $this->Html->cCurrency($affiliateCashWithdrawal['AffiliateCashWithdrawal']['amount']);?></td>
             <?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Success) { ?>
            <td class="dc">	<?php  echo $this->Html->cDateTimeHighlight($affiliateCashWithdrawal['AffiliateCashWithdrawal']['modified']);  ?> </td>
            <?php } ?>            
            <?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') { ?>
                <td class="dc">
					<?php 
						if($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Pending):
							echo __l('Pending');
						elseif($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Approved):
							echo __l('Approved');
						elseif($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Rejected):
							echo __l('Rejected');
						elseif($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Failed):
							echo __l('Failed');
						elseif($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Success):
							echo __l('Success');
						else:
							echo $this->Html->cText($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['name']);
						endif;
					?>
				</td>
            <?php } ?>
        </tr>
    <?php
        endforeach;
    else:
    ?>
        <tr>
            <td colspan="8">
				<div class="space dc">
					<p class="ver-mspace grayc top-space text-16 "><?php echo __l('No Records available');?></p>
				</div>
			</td>
        </tr>
    <?php
    endif;
    ?></tbody>
    </table>
    <?php if (!empty($affiliateCashWithdrawals) && (empty($this->request->params['named']['filter_id']) || (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Pending))):?>
      <div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
                <?php echo __l('Select:'); ?>
				</span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
				
             </div><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit js-no-pjax span5', 'div'=>false,'label' => false, 'empty' => __l('-- More actions --'))); ?></span>
            <?php endif; ?>
         </div>
          <div class="js-pagination pagination pull-right no-mar mob-clr dc">
            <?php echo $this->element('paging_links'); ?>
        </div>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
        <?php
    echo $this->Form->end();
    ?>
</div>