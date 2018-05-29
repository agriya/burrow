<?php /* SVN: $Id: admin_index.ctp 71492 2011-11-15 14:01:05Z aravindan_111act10 $ */ ?>
	<?php 
		if(!empty($this->request->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>   
<div class="userCashWithdrawals index js-response">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Withdraw Fund Requests - Pending         </li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
	<div class="clearfix">
		
				<?php 
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstWithdrawalStatus::Pending) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Pending').'">'.__l('Pending').'</dt>
						<dd title="'.$this->Html->cInt($pending ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($pending ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'user_cash_withdrawals','action'=>'index','filter_id' => ConstWithdrawalStatus::Pending), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstWithdrawalStatus::Rejected) ? 'active' : null;
				
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Rejected').'">'.__l('Rejected').'</dt>
						<dd title="'.$this->Html->cInt($rejected ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($rejected ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'user_cash_withdrawals','action'=>'index','filter_id' => ConstWithdrawalStatus::Rejected), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstWithdrawalStatus::Success) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Success').'">'.__l('Success').'</dt>
						<dd title="'.$this->Html->cInt($success ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($success ,false).'</dd>                  	
					</dl>'
					, array('controller'=>'user_cash_withdrawals','action'=>'index','filter_id' => ConstWithdrawalStatus::Success), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
								$class = (empty($this->request->params['named']['filter_id'])) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('All').'">'.__l('All').'</dt>
						<dd title="'.$this->Html->cInt(($approved + $pending + $rejected + $success) ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt(($approved + $pending + $rejected + $success), false).'</dd>                  	
					</dl>'
					, array('controller'=>'user_cash_withdrawals','action'=>'index'), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				
				?>
    </div>
		<?php 
		if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 4):?>
		<div class="page-info">
			<?php echo __l('Withdrawal fund frequest which were unable to process will be returned as failed. The amount requested will be automatically refunded to the user.');?>			
		</div>
	<?php endif;?>
		<?php if($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Approved): ?>
			<div class="page-info">		
				<?php echo __l('Following withdrawal request has been submitted to payment geteway API, These are waiting for IPN from the payment geteway API. Eiether it will move to Success or Failed'); ?>
			</div>
		<?php endif; ?>
			<div class="clearfix page-count-block">
	<?php echo $this->element('paging_counter');?>
    <?php echo $this->Form->create('UserCashWithdrawal' , array('class' => 'normal','action' => 'update')); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
		    <?php if (!empty($userCashWithdrawals) && (empty($this->request->params['named']['filter_id']) || (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending))):?>
			<th class="sep-right dc span2">
            	<?php echo __l('Select'); ?>
			</th>    
			<?php endif;?>
			 <?php if (!empty($userCashWithdrawals) && (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Approved)):?>
			<th class="sep-right dc">
            	<?php echo __l('Action'); ?>
			</th>    
            <?php endif;?>        
            <th class="dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('UserCashWithdrawal.created',__l('Requested on'));?></div></th>
            <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username',__l('User'));?></div></th>
            <th class="dr sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'UserCashWithdrawal.amount', __l('Amount'). ' ('.Configure::read('site.currency').')');?> </div></th>
            <?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Success) { ?>
                <th class="dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('UserCashWithdrawal.modified',__l('Paid on'));?></div></th>
            <?php } ?>
            <?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') { ?>
                <th class="dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('WithdrawalStatus.name',__l('Status'));?></div></th>
            <?php } ?>
        </tr>
		</thead>
    <?php
    if (!empty($userCashWithdrawals)): ?>
	<tbody>
    <?php 
    $i = 0;
    foreach ($userCashWithdrawals as $userCashWithdrawal):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
    ?>
        <tr<?php echo $class;?>>
		    <?php if (!empty($userCashWithdrawals) && (empty($this->request->params['named']['filter_id']) || (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending))):?>
			<td class="dc">			
                <?php echo $this->Form->input('UserCashWithdrawal.'.$userCashWithdrawal['UserCashWithdrawal']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userCashWithdrawal['UserCashWithdrawal']['id'], 'label' => "", 'div' => 'top-space', 'class' => 'js-checkbox-list ' )); ?>
			</td>
			<?php endif;?>
		    <?php if (!empty($userCashWithdrawals) && (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Approved)):?>
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
    						<li><?php echo $this->Html->link(__l('Move to success'), array('action' => 'move_to', $userCashWithdrawal['UserCashWithdrawal']['id'], 'type' => 'success'), array('class' => 'move-to-success', 'title' => __l('Move to success')));?></li>
    						<li><?php echo $this->Html->link(__l('Move to failed'), array('action' => 'move_to', $userCashWithdrawal['UserCashWithdrawal']['id'], 'type' => 'failed'), array('class' => 'move-to-failed', 'title' => __l('Move to failed')));?></li>
						</ul>
					   </div>
						<div class="action-bottom-block"></div>
					  </div>
				 </div>
  		    </td>
			<?php endif;?>
           <td class="dc">	<?php  echo $this->Html->cDateTimeHighlight($userCashWithdrawal['UserCashWithdrawal']['created']);  ?> </td>
		   <td class="dl">
			<?php echo $this->Html->getUserAvatarLink($userCashWithdrawal['User'], 'micro_thumb',false);	?>
            <?php echo $this->Html->getUserLink($userCashWithdrawal['User']);?>
		
			</td>
            <td class="dr"><?php echo $this->Html->cCurrency($userCashWithdrawal['UserCashWithdrawal']['amount']);?></td>
             <?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Success) { ?>
            <td class="dc">	<?php  echo $this->Html->cDateTimeHighlight($userCashWithdrawal['UserCashWithdrawal']['modified']);  ?> </td>
            <?php } ?>
            <?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') { ?>
                <td><?php echo $this->Html->cText($userCashWithdrawal['WithdrawalStatus']['name']);?></td>
            <?php } ?>
        </tr>
    <?php
        endforeach;
	?>
	<tbody>
	<?php
    else:
    ?>
        <tr>
            <td colspan="8"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Records available');?></p></div></td>
        </tr>
    <?php
    endif;
    ?>
    </table>
    <div class="clearfix">
    <?php if (!empty($userCashWithdrawals) && (empty($this->request->params['named']['filter_id']) || (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending))):?>
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
        <div class="hide">
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
        <?php
    echo $this->Form->end();
    ?>
</div>