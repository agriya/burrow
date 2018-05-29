<div class="ver-space clearfix sep-bot top-mspace">
	<h2 class="text-32 span"><?php echo __l('Money Transfer Accounts'); ?></h2><?php echo $this->element('sidebar', array('config' => 'sec')); ?>
</div>
<div class="thumbnail main-section">
  <?php echo $this->element('money_transfer_accounts-add'); ?>
  <div class="moneyTransferAccounts clearfix index">
    <section class="space clearfix">
      <div class="pull-left hor-space">
        <?php echo $this->element('paging_counter');?>
      </div>
    </section>
    <section class="space">
      <table class="table table-striped table-bordered table-condensed table-hover">
        <tr>
          <th class="dc"><?php echo __l('Action');?></th>
          <th class="dl"><?php echo __l('Account');?></th>
          <th class="dc"><?php echo $this->Paginator->sort('is_default', __l('Primary'));?></th>
        </tr>
        <?php
          if (!empty($moneyTransferAccounts)):
            $i = 0;
            foreach ($moneyTransferAccounts as $moneyTransferAccount):
              $class = null;
              if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
              }
        ?>
        <tr<?php echo $class;?>>
          <td class="span1 dc">
            <?php if(!$moneyTransferAccount['MoneyTransferAccount']['is_default']): ?>
				<div class="dropdown top-space">
				  <a href="#" title="Actions" data-toggle="dropdown" class="icon-cog blackc text-20 dropdown-toggle js-no-pjax cur"><span class="hide">Action</span></a>
				  <ul class="unstyled dropdown-menu dl arrow clearfix">
					<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('controller' => 'money_transfer_accounts', 'action' => 'delete', $moneyTransferAccount['MoneyTransferAccount']['id']), array('class' => 'js-confirm delete ', 'escape'=>false,'title' => __l('Delete')));?></li>
					<?php if(!$moneyTransferAccount['MoneyTransferAccount']['is_default']):?>
					  <li><?php echo $this->Html->link('<i class="icon-star"></i>'.__l('Make as primary'), array('controller' => 'money_transfer_accounts', 'action' => 'update_status', $moneyTransferAccount['MoneyTransferAccount']['id']), array('class' => 'widthdraw', 'title' => __l('Make as primary'), 'escape'=>false)); ?></li>
					<?php endif;?>
				  </ul>
				</div>
			<?php endif; ?>
          </td>
          <td class="dl"><?php echo nl2br($this->Html->cText($moneyTransferAccount['MoneyTransferAccount']['account']));?></td>
          <td class="dc"><?php echo $this->Html->cBool($moneyTransferAccount['MoneyTransferAccount']['is_default']);?></td>
        </tr>
        <?php
            endforeach;
          else:
        ?>
        <tr>
          <td colspan="4" class="errorc space">
		   <div class="space dc grayc">
    		<p class="ver-mspace top-space text-16">
			<?php echo sprintf(__l('No %s available'), __l('Money Transfer Accounts'));?>
		   </p>
	      </div>
		 </td>
        </tr>
        <?php
          endif;
        ?>
      </table>
    </section>
    <section class="clearfix hor-mspace bot-space">
      <?php if (!empty($moneyTransferAccounts)):?>
        <div class="pull-right">
          <?php echo $this->element('paging_links'); ?>
        </div>
      <?php endif;?>
    </section>
  </div>
</div>