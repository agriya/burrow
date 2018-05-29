<?php /* SVN: $Id: admin_index.ctp 69757 2011-10-29 12:35:25Z josephine_065at09 $ */ ?>
	<?php 
		if(!empty($this->request->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
    <div class="affiliateCashWithdrawals index js-response">
  
    <?php echo $this->Form->create('AffiliateCashWithdrawal' , array('class' => 'normal','action' => 'pay_to_user')); ?> 
  
    <table class="table no-round ">
	<thead>
        <tr class="well no-mar no-pad">
            <th class="graydarkc dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username',__l('User'));?></div></th>
            <th class="graydarkc dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'AffiliateCashWithdrawal.amount',__l('Amount')).' ('.Configure::read('site.currency').')';?> </div></th>
            <th class="graydarkc sep-right dl"><?php echo __l('Gateway');?></th>
             <th class="graydarkc dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.commission_paid_amount',__l('Paid Amount'));?></div></th>
        </tr>
	</thead>
    <?php
    if (!empty($affiliateCashWithdrawals)):
    
    $i = 0;
    foreach ($affiliateCashWithdrawals as $affiliateCashWithdrawal):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
    ?>
        <tr<?php echo $class;?>>
            <td class="dl">
            <div class="paypal-status-info">
             <?php echo $this->Form->input('AffiliateCashWithdrawal.'.($i-1).'.id', array('type' => 'hidden', 'value' => $affiliateCashWithdrawal['AffiliateCashWithdrawal']['id'], 'label' => false)); ?>
			<?php echo $this->Html->getUserAvatarLink($affiliateCashWithdrawal['User'], 'micro_thumb',false);	?>
            <?php echo $this->Html->getUserLink($affiliateCashWithdrawal['User']);?>
            </div>
			</td>
            <td class="dl"><?php echo $this->Html->cCurrency($affiliateCashWithdrawal['AffiliateCashWithdrawal']['amount']);?></td>
            <td class="dl"><?php echo $this->Form->input('AffiliateCashWithdrawal.'.($i-1).'.gateways',array('type' => 'select', 'options' => $affiliateCashWithdrawal['paymentways'], 'label' => false, 'class' => "js-payment-gateway_select {container:'js-info-".($i-1)."-container'}")); ?>
            	<div class="<?php echo "js-info-".($i-1)."-container"; ?>">
            	<?php echo $this->Form->input('AffiliateCashWithdrawal.'.($i-1).'.info',array('type' => 'textarea', 'label' => false, 'info' => 'Info for Paid')); ?>
                </div>
            </td>
            <td class="dr"><?php echo $this->Html->siteCurrencyFormat($affiliateCashWithdrawal['User']['commission_paid_amount']); ?></td>
        </tr>
    <?php
        endforeach;
    else:
    ?>
        <tr>
            <td colspan="8" class="notice"><?php echo __l('No Records available');?></td>
        </tr>
    <?php
    endif;
    ?>
    </table>
    	<div class="form-actions">
    	<?php
        	echo $this->Form->submit(__l('Proceed'), array('class' => 'btn btn-large btn-primary textb text-16'));
        ?>
        </div>
      <?php echo $this->Form->end(); ?>
    </div>