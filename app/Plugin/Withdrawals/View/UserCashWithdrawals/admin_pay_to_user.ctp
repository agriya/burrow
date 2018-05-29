<?php /* SVN: $Id: admin_index.ctp 69757 2011-10-29 12:35:25Z josephine_065at09 $ */ ?>
	<?php 
		if(!empty($this->request->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
    <div class="userCashWithdrawals index js-response">
  
    <?php echo $this->Form->create('UserCashWithdrawal' , array('class' => 'form-horizontal space','action' => 'pay_to_user')); ?> 
  
  <table class="table no-round table-striped">
	<thead>
	  <tr class="well no-mar no-pad">
            <th class="dc graydarkc sep-right"><?php echo __l('User');?></th>
			<th class="dc graydarkc sep-right"><?php echo __l('Amount') .' ('.Configure::read('site.currency').')';?></th>
			<th class="dc graydarkc sep-right"><?php echo __l('Gateway');?></th>
			<th class="dc graydarkc sep-right"><?php echo __l('Paid Amount');?></th>
        </tr>
    <?php
    if (!empty($userCashWithdrawals)):
    
    $i = 0;
    foreach ($userCashWithdrawals as $userCashWithdrawal):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
    ?>
        <tr<?php echo $class;?>>
            <td class="dl">
              <div class="paypal-status-info">
             <?php echo $this->Form->input('UserCashWithdrawal.'.($i-1).'.id', array('type' => 'hidden', 'value' => $userCashWithdrawal['UserCashWithdrawal']['id'], 'label' => false)); ?>
			<?php echo $this->Html->getUserAvatarLink($userCashWithdrawal['User'], 'micro_thumb',false);	?>
            <?php echo $this->Html->getUserLink($userCashWithdrawal['User']);?>
            </div>
			</td>
            <td class="dr"><?php echo $this->Html->cCurrency($userCashWithdrawal['UserCashWithdrawal']['amount']);?></td>
            <td class="dc"><?php echo $this->Form->input('UserCashWithdrawal.'.($i-1).'.gateways',array('type' => 'select', 'options' => $userCashWithdrawal['paymentways'], 'label' => false, 'class' => "js-payment-gateway_select {container:'js-info-".($i-1)."-container'}")); ?>
            	<div class="<?php echo "js-info-".($i-1)."-container"; ?>">
            	<?php echo $this->Form->input('UserCashWithdrawal.'.($i-1).'.info',array('type' => 'textarea', 'label' => false, 'info' => 'Info for Paid')); ?>
                </div>
            </td>
            <td class="dr"><?php echo $this->Html->siteCurrencyFormat($userCashWithdrawal['User']['total_amount_withdrawn']); ?></td>
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