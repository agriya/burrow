<?php /* SVN: $Id: $ */ ?>
<div class="sudopayTransactionLogs index js-response">
	<section class="space clearfix">
		<div class="pull-left hor-space">
			<?php echo $this->element('paging_counter');?>
		</div>
	</section>
	<section class="space">
		<table class="table table-striped table-bordered table-condensed table-hover">
			<tr>
				<th class="dc"><?php echo __l('Actions');?></th>
				<th class="dc"><div><?php echo $this->Paginator->sort('created', __l('Created'));?></div></th>
				<th class="dl"><div><?php echo $this->Paginator->sort('class');?></div></th>
				<th class="dc"><div><?php echo $this->Paginator->sort('payment_id', __l('Payment'));?></div></th>
				<th class="dr"><div><?php echo $this->Paginator->sort('amount', __l('Amount')) .' ('.Configure::read('site.currency').')';?></div></th>
				<th class="dc"><div><?php echo $this->Paginator->sort('sudopay_pay_key', __l('Pay Key'));?></div></th>
				<th class="dc"><div><?php echo $this->Paginator->sort('merchant_id', __l('Merchant'));?></div></th>
				<th class="dc"><div><?php echo $this->Paginator->sort('gateway_name', __l('Gateway'));?></div></th>
				<th class="dc"><div><?php echo $this->Paginator->sort('status', __l('Status'));?></div></th>
				<th class="dc"><div><?php echo $this->Paginator->sort('payment_type', __l('Payment Type'));?></div></th>
				<th class="dc"><div><?php echo $this->Paginator->sort('buyer_email', __l('Buyer Email'));?></div></th>
				<th class="dc"><div><?php echo $this->Paginator->sort('buyer_address', __l('Buyer Address'));?></div></th>
			</tr>
			<?php
				if (!empty($sudopayTransactionLogs)):
					foreach ($sudopayTransactionLogs as $sudopayTransactionLog):
			?>
			<tr>
				<td class="span1 dc">
					<div class="dropdown top-space">
						<a href="#" title="Actions" data-toggle="dropdown" class="icon-cog blackc text-20 dropdown-toggle js-no-pjax"><span class="hide">Action</span></a>
						<ul class="unstyled dropdown-menu dl arrow clearfix">
							<li>
								<?php echo $this->Html->link('<i class="icon-share-alt"></i>'.__l('View'), array('controller' => 'sudopay_transaction_logs', 'action'=>'view', $sudopayTransactionLog['SudopayTransactionLog']['id']), array('class' => '', 'escape'=>false,'title' => __l('View')));?>
							</li>
						</ul>
					</div>
				</td>
				<td class="dc"><?php echo $this->Html->cDateTimeHighlight($sudopayTransactionLog['SudopayTransactionLog']['created']);?></td>
				<td><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['class']);?></td>
				<td class="dc"><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['payment_id']);?></td>
				<td class="dr"><?php echo $this->Html->cCurrency($sudopayTransactionLog['SudopayTransactionLog']['amount']);?></td>
				<td class="dc"><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['sudopay_pay_key']);?></td>
				<td class="dc"><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['merchant_id']);?></td>
				<td class="dc"><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['gateway_name']);?></td>
				<td class="dc"><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['status']);?></td>
				<td class="dc"><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['payment_type']);?></td>
				<td class="dc"><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['buyer_email']);?></td>
				<td class="dc"><?php echo $this->Html->cText($sudopayTransactionLog['SudopayTransactionLog']['buyer_address']);?></td>
			</tr>
			<?php
					endforeach;
				else:
			?>
			<tr class="js-odd">
				<td colspan="12"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo sprintf(__l('No %s available'), __l('ZazPay Transaction Logs'));?></p></div></td>
			</tr>
			<?php
				endif;
			?>
		</table>
	</section>
	<?php if (!empty($sudopayTransactionLogs))  : ?>
	<section class="clearfix hor-mspace bot-space">
		<div class="clearfix">
			<div class="pull-right">
				<?php echo $this->element('paging_links');?>
			</div>
		</div>
	</section>
	<?php endif; ?>
</div>
