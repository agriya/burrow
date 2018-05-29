<?php /* SVN: $Id: $ */ ?>
<div class="sudopays index">
<section class="space clearfix">
<div class="pull-left hor-space">
</section>
<section class="space">
<div class="row bot-space">

<?php
if (!empty($supported_gateways)):
foreach ($supported_gateways as $gateways):
$gateway_details = unserialize($gateways['SudopayPaymentGateway']['sudopay_gateway_details']);
?>
 <div class="span11 thumbnail pull-left ver-space mspace">
    <span class="span6  pull-left">
		<?php echo $this->Html->image($gateway_details['thumb_url']); ?>
		<div class="dl"><?php echo $this->Html->cText($gateways['SudopayPaymentGateway']['sudopay_gateway_name']);?></div>
	</span>
    <span class="span4  pull-right">
		<?php 
			if(in_array($gateways['SudopayPaymentGateway']['sudopay_gateway_id'], $connected_gateways)) { ?>
				<span class="btn disabled span2 ver-mspace"> <?php echo __l('Connected');?> </span>
				
			<?php } else {
				$class = '';
				if($this->Auth->user('role_id') != ConstUserTypes::Admin){ $class=' span2'; }
				echo $this->Html->link(__l('Connect'), array('controller' => 'sudopays', 'action' => 'add_account', $project, $step, $gateways['SudopayPaymentGateway']['sudopay_gateway_id'], $user['id']), array('class' => 'btn  ver-mspace'.$class));
			}
		?>
	</span>
	</div>
<?php
  endforeach;
else:
?>

<div>
    <span colspan="6" class="errorc space"><i class="icon-warning-sign errorc"></i> <?php echo sprintf(__l('No %s available'), __l('Gateways'));?></span>
  </div>
<?php
endif;
?>
  </div>

</section>
</div>
