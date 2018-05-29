<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="affiliates index">
<?php if ($user['User']['is_affiliate_user']): ?>
   <div class="clearfix">
    <div class="ver-space ver-mspace sep-bot clearfix"><h2  class="text-32 span"><?php echo __l('Affiliate');?></h2>
	<?php echo $this->element('sidebar', array('config' => 'sec')); ?></div>
	<div class="add-block  dr">
			<?php echo $this->Html->link('<i class="icon-money grayc"></i>'.__l('Affiliate Cash Withdrawal Requests'), array('controller' => 'affiliate_cash_withdrawals', 'action' => 'index'),array('class'=>'cash', 'title' => __l('Affiliate Cash Withdrawal Requests'),'escape'=>false)); ?>
     </div>
    </div>
	     
       	<p class="share-info tb">
            <?php echo __l('Share your below unique link for referral purposes'); ?>
            	</p>
                <input type="text" class="refer-box" readonly="readonly" value="<?php echo Router::url(array('controller' => 'users', 'action' => 'refer',  'r' =>$this->Auth->user('username')), true);?>" onclick="this.select()"/>

        	<p class="share-info tb"><?php echo __l('Share your below unique link by appending to end of site URL for referral'); ?>
            </p>
                <input type="text" class="refer-box" readonly="readonly" value="<?php echo  '/r:'.$this->Auth->user('username');?>" onclick="this.select()"/>

  <?php  echo $this->element('affiliate_stat', array('config' => 'sec')); ?>
<h3 class="ver-space bot-mspace textb text-16"><?php echo __l('Commission History');?></h3>
<?php if (!empty($affiliates)):
	echo $this->element('paging_counter');
endif;?>
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
        <th class="sep-right dc"><?php echo $this->Paginator->sort('created',__l('Created'));?></th>
        <th class="sep-right"><?php echo __l('User/Property');?></th>
        <th class="sep-right"><?php echo $this->Paginator->sort('AffiliateType.name',__l('Type'));?></th>
        <th class="sep-right"><?php echo $this->Paginator->sort( 'AffiliateStatus.name',__l('Status'));?></th>
        <th class="dc"><?php echo $this->Paginator->sort( 'commission_amount',__l('Commission (').configure::read('site.currency').__l(')'));?></th>
    </tr>
<?php
if (!empty($affiliates)):

$i = 0;
foreach ($affiliates as $affiliate):
?>
	<tr>
		<td class="dc"> <?php echo $this->Html->cDateTimeHighlight($affiliate['Affiliate']['created']);?></td>
        <td>
        	<?php
				if ($affiliate['Affiliate']['class'] == 'User' && !empty($affiliate['User']['username'])) {
			?>
					<?php echo $this->Html->link($this->Html->cText($affiliate['User']['username']), array('controller'=> 'users', 'action' => 'view', $affiliate['User']['username']), array('escape' => false));?>
			<?php
			   } else{
			?>
					<?php 
					if(!empty($affiliate['PropertyUser'])) {
						echo $this->Html->link($this->Html->cText($affiliate['PropertyUser']['Property']['title'],false), array('controller'=> 'properties', 'action' => 'view', $affiliate['PropertyUser']['Property']['slug']), array('escape' => false));?>
						(<?php echo $this->Html->link($this->Html->cText($affiliate['PropertyUser']['User']['username']), array('controller'=> 'users', 'action' => 'view', $affiliate['PropertyUser']['User']['username'], 'admin' => false), array('escape' => false));?>)
					
		<?php   } }?>
		</td>
		<td><?php echo $this->Html->cText($affiliate['AffiliateType']['name']);?></td>
		<td>
           <?php echo $this->Html->cText($affiliate['AffiliateStatus']['name']);   ?>
           <?php  if($affiliate['AffiliateStatus']['id'] == ConstAffiliateStatus::PipeLine): ?>
                   <?php echo $this->Html->cDateTimeHighlight($affiliate['Affiliate']['commission_holding_start_date']);?>
           <?php endif; ?>
        </td>

		<td class="dr"><?php echo $this->Html->cCurrency($affiliate['Affiliate']['commission_amount']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="6">
			<div class="space dc grayc">
				<p class="ver-mspace top-space text-16 "><?php echo __l('No Commission history available');?></p>
			</div>
		</td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($affiliates)) {
    echo $this->element('paging_links');
}
?>
<?php else: 
		echo $this->element('pages-terms_and_policies', array('config' => 'sec'));
		if ($this->Auth->sessionValid()):
			echo $this->element('affiliate_request-add', array('config' => 'sec'));
		endif;
	?>
<?php endif; ?>
</div>