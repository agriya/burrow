<?php
  echo $this->Html->link(!empty($toggle) ? '<i class="icon-ok text-16 top-space"></i><span class="hide">Yes</span>' : '<i class="icon-remove text-16 top-space"></i><span class="hide">No</span>', array('controller' => 'payment_gateways', 'action' => 'update_status', $id, $actionId, 'toggle' => empty($toggle) ? 1 : 0), array('escape' => false, 'class' => 'js-admin-update-status js-no-pjax'));
?>
