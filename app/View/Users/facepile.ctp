<?php
  if (!empty($users)):
  $i = 1;
  $count = count($users);
?>
<p><i class="icon-facebook-sign facebookc text-16"></i><?php echo ' ' . sprintf(__l('%s users have connected using Facebook'), $totalUserCount); ?></p>
<?php foreach($users as $user) { ?>
  <?php if ($i == 1 || $i == 7) { ?>
  <div class="space-top">
    <ul class="span6 unstyled social-avatar">
  <?php } ?>
    <li class="span"><?php echo $this->Html->getUserAvatar($user['User'], 'small_thumb', true, '', 'facebook'); ?></li>
  <?php if ($i == 6 || $i == $count) { ?>
    </ul>
  </div>
  <?php } ?>
  <?php $i++; ?>
<?php } ?>
<?php
  endif;
?>