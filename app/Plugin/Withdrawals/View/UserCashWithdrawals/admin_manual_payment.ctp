<?php /* SVN: $Id: edit.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
<div class="userCashWithdrawals form">
<?php echo $this->Form->create('UserCashWithdrawal', array('action' => 'admin_manual_payment'));?>
  <fieldset>
     <h2><?php echo __l('Manual Payment');?></h2>
  <?php
    echo $this->Form->input('id');
    echo $this->Form->input('description',array('type' => 'textarea', 'label' => __l('Description')));
  ?>
  </fieldset>
  <div class="clearfix">
    <?php echo $this->Form->end(__l('Pay'));?>
  </div>
</div>
