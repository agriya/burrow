<?php /* SVN: $Id: add.ctp 2451 2010-06-29 14:03:08Z vinothraja_091at09 $ */ ?>
<div class="settings form">
  <?php echo $this->Form->create('Setting', array('class' => "well form-horizontal"));?>
  <fieldset>
    <?php
    echo $this->Form->hidden('launch_type');
    $from = $this->request->data['Setting']['launch_type'];
    if ($this->request->data['Setting']['launch_type'] == 'Pre-launch') {
      $from = __l('Pre launch');
    }
    $to = __l('Launch Mode');
    if ($this->request->data['Setting']['launch_type'] == 'private_beta') {
      $from = __l('Pre launch');
      $to = __l('Private Beta');
    }
    ?>
    <p><?php echo sprintf(__l('Site mode is changing from %s to %s.  Please click "Ok" button to send invitation mail immediately to subscribed users or click "Cancel" button to send invitation mail through cron.'), $from, $to); ?></p>
  </fieldset>
  <div class="form-actions">
    <?php echo $this->Form->submit(__l('Ok'));?>
    <?php echo $this->Html->link(__l('Cancel'), array('controller' => 'settings' , 'action' => 'index'));?>
  </div>
  <?php echo $this->Form->end();?>
</div>