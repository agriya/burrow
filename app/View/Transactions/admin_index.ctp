<?php /* SVN: $Id: admin_index.ctp 2077 2010-04-20 10:42:36Z josephine_065at09 $ */ ?>
<?php $credit = 1;
$debit = 1;
$debit_total_amt = $credit_total_amt = $gateway_total_fee = 0;
if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == ConstTransactionTypes :: AddedToWallet) && !empty($this->request->params['named']['stat'])) {
    $debit = 0;
}?>
<?php if(empty($this->request->params['isAjax'])): ?>
  <div class="transactions index js-response js-responses">
	<ul class="breadcrumb top-mspace ver-space">
      <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
      <li class="active"><?php echo __l('Transactions'); ?>             </li>
    </ul> 
	<div class="clearfix ver-space sep-top top-mspace">
    <div class="tabbable span9">
      <div id="list" class="tab-pane active in no-mar">
 		
		  <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') ? 'active' : null;
		  echo $this->Html->link( '<dl class="dc list users '.$class .' mob-clr mob-sep-none ">	<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Admin').'">'.__l('Admin').'</dt> <dd class="textb text-20 no-mar graydarkc pr hor-mspace">&nbsp;</dd> </dl>', array('action'=>'index'), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
		  $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') ? 'active' : null;
		  echo $this->Html->link( '<dl class="dc list users '.$class .' mob-clr mob-sep-none ">	<dt class="pr hor-mspace text-11 grayc"  title="'.__l('All').'">'.__l('All').'</dt>	<dd class="textb text-20 no-mar graydarkc pr hor-mspace">&nbsp;</dd></dl>', array('action'=>'index','filter_id' =>'all'), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));?>
		  </div>
		  </div>
		  <div class="pull-left">	
			<?php echo $this->Form->create('Transaction' , array('action' => 'admin_index', 'type' => 'post', 'class' => 'form-search search-form')); 
    		echo $this->Form->autocomplete('User.username', array('label' => false,'div'=>'span right-mspace','class'=>'span4','placeholder'=>__l('User'), 'acFieldKey' => 'Transaction.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));
    		echo $this->Form->input('PropertyUser.Id', array('label' => false, 'div' => 'span4 right-mspace', 'placeholder' => __l('Booking#'), 'class'=>'span4'));
    		echo $this->Form->autocomplete('Property.title', array('label' => false,'div'=>'span right-mspace','class'=>'span4','placeholder' => __l('Property'), 'acFieldKey' => 'Property.id', 'acFields' => array('Property.title'), 'acSearchFieldNames' => array('Property.title'), 'maxlength' => '255')); ?>
			<div class="date-time-block pull-left">
			  <div class="input date-time">
				<div class="js-datetime">
				  <div class="js-cake-date">
					<?php echo $this->Form->input('from_date', array('orderYear' => 'asc', 'type' => 'date', 'label' => 'From', 'minYear' => date('Y')-5, 'maxYear' => date('Y') + 10, 'div' => false, 'empty' => __l('Please Select'))); ?>
				  </div>
				</div>
			  </div>
			  <div class="input date-time today-date-block">
				<div class="js-datetime">
				  <div class="js-cake-date">
					<?php echo $this->Form->input('to_date', array('orderYear' => 'asc', 'type' => 'date', 'label' => 'To', 'minYear' => date('Y')-5, 'maxYear' => date('Y') + 10, 'div' => false, 'empty' => __l('Please Select'))); ?>
				  </div>
				</div>
			  </div>
			</div>
			<?php echo $this->Form->input('filter_id', array('type' => 'hidden'));
				echo $this->Form->submit(__l('Filter'),array('class'=>'btn top-space hor-mspace btn-primary textb text-16')); ?>
			<?php echo $this->Form->end(); ?>
		  </div>
		</div>
<?php endif;?>

	<div class="clearfix">
	<div class="span20 top-space pull-left">
					<?php echo $this->element('paging_counter'); ?>
	</div>
					<div class="pull-right mob-clr dc">
								
					 <?php echo $this->Html->link('<span class="ver-smspace"><i class="icon-signout no-pad top-smspace"></i></span>', array_merge(array('action' => 'index', 'ext' => 'csv', 'admin' => true), $this->request->params['named']), array('escape' => false,'title' => __l('CSV'), 'class' => 'btn btn-inverse textb text-18 whitec')); ?>
				</div>
			</div>
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
            <th class="dc sep-right"><?php echo $this->Paginator->sort( 'Transaction.created',__l('Date'));?></th>
            <th class="dl sep-right"><?php echo $this->Paginator->sort( 'User.username',__l('User'));?></th>
            <th class="dl sep-right"><?php echo $this->Paginator->sort('TransactionType.name',__l('Description'));?></th>
			<th class="dr sep-right"><?php echo $this->Paginator->sort( 'Transaction.amount',__l('Credit')) . ' (' . Configure::read('site.currency') . ')';?></th>
			<th class="dr sep-right"><?php echo $this->Paginator->sort( 'Transaction.amount',__l('Debit')) . ' (' . Configure::read('site.currency') . ')';?></th>
        </tr></thead><tbody>
    <?php
    if (!empty($transactions)):

    $i = 0;
    foreach ($transactions as $transaction):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
    ?>
		<?php 
			$paypal_text = '';
		?>
        <tr<?php echo $class;?>>
                <td class="dc"><?php echo $this->Html->cDateTimeHighlight($transaction['Transaction']['created']);?></td>
                <td class="dl">
                <?php
					echo $this->Html->getUserAvatarLink($transaction['User'], 'micro_thumb');
					echo $this->Html->getUserLink($transaction['User']);
				?>
				</td>
                <td class="dl">
                    <?php
                        $class = $transaction['Transaction']['class'];               			
                    ?>
					<?php if(in_array($transaction['Transaction']['transaction_type_id'], array(ConstTransactionTypes::AdminAddFundToWallet, ConstTransactionTypes::AdminDeductFundFromWallet, ConstTransactionTypes::CashWithdrawalRequestApproved)) && !empty($transaction['Transaction']['description'])) {
               				echo $this->Html->cText($transaction['Transaction']['description']);
						} else {
							echo $this->Html->transactionDescription($transaction);
						} ?>
                </td>
                <td class="dr">
					<?php
					if (!empty($transaction['TransactionType'][$credit_type])) {
					  echo $this->Html->cCurrency($transaction['Transaction']['amount']);
					} else {
					  echo '--';
					}
					?>
				  </td>
				  <td class="dr">
					<?php
					if (!empty($transaction['TransactionType'][$credit_type])) {
					  echo '--';
					} else {
					  echo $this->Html->cCurrency($transaction['Transaction']['amount']);
					}
					?>
				  </td>
            </tr>
    <?php
        endforeach;
	?>
	<tr class="total-block">
		<td colspan="3" class="dr"><?php echo __l('Total');?></td>
		 <?php if(!empty($total_credit_amount)) {?>
		<td class="dr"><?php echo $this->Html->siteCurrencyFormat($total_credit_amount);?></td>
		 <?php } if(!empty($total_debit_amount)) {?>
		<td class="dr"><?php echo $this->Html->siteCurrencyFormat($total_debit_amount);?></td>
		<?php } ?>
	</tr>
	<?php
    else:
    ?>
        <tr>
            <td colspan="11"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Transactions available');?></p></div></td>
        </tr>
    <?php
    endif;
    ?>
    </table>
    <?php
    if (!empty($transactions)) {
        ?>
            <div class="js-pagination pagination pull-right no-mar mob-clr dc">
                <?php echo $this->element('paging_links'); ?>
            </div>
        <?php
    }
    ?>
</div>