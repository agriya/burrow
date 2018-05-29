<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="userAddWalletAmounts index">
<div>
<h2><?php echo __l('User Add Wallet Amounts');?></h2>
</div>
<?php echo $this->element('paging_counter');?>
<ol class="unstyled" start="<?php echo $paginator->counter(array(
  'format' => '%start%'
));?>">
<?php
if (!empty($userAddWalletAmounts)):
foreach ($userAddWalletAmounts as $userAddWalletAmount):
?>
  <li>
    <p><?php echo $html->cInt($userAddWalletAmount['UserAddWalletAmount']['id']);?></p>
    <p><?php echo $html->cDateTime($userAddWalletAmount['UserAddWalletAmount']['created']);?></p>
    <p><?php echo $html->cDateTime($userAddWalletAmount['UserAddWalletAmount']['modified']);?></p>
    <p><?php echo $html->link($html->cText($userAddWalletAmount['User']['username']), array('controller'=> 'users', 'action' => 'view', $userAddWalletAmount['User']['username']), array('escape' => false));?></p>
    <p><?php echo $html->cCurrency($userAddWalletAmount['UserAddWalletAmount']['amount']);?></p>
    <p><?php echo $html->cText($userAddWalletAmount['UserAddWalletAmount']['paypal_pay_key']);?></p>
    <p><?php echo $html->link($html->cText($userAddWalletAmount['PaymentGateway']['name']), array('controller'=> 'payment_gateways', 'action' => 'view', $userAddWalletAmount['PaymentGateway']['id']), array('escape' => false));?></p>
    <p><?php echo $html->cBool($userAddWalletAmount['UserAddWalletAmount']['is_success']);?></p>
    <div><?php echo $html->link(__l('Edit'), array('action'=>'edit', $userAddWalletAmount['UserAddWalletAmount']['id']), array('class' => 'js-edit', 'title' => '<i class="icon-edit"></i><span class="hide">' . __l('Edit') . '</span>'));?><?php echo $html->link('<i class="icon-remove"></i><span class="hide">'.__l('Delete').'</span>', array('action'=>'delete', $userAddWalletAmount['UserAddWalletAmount']['id']), array('class' => 'js-confirm', 'title' => __l('Delete')));?></div>
  </li>
<?php
  endforeach;
else:
?>
  <li>
    <div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo sprintf(__l('No %s available'), __l('User Add Wallet Amounts'));?></p></div>
  </li>
<?php
endif;
?>
</ol>

<?php
if (!empty($userAddWalletAmounts)) {
  echo $this->element('paging_links');
}
?>
</div>