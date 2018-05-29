<?php /* SVN: $Id: $ */ ?>
<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Affiliates'), array('controller'=>'affiliates','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Commission Settings'); ?></li>
</ul>
<div class="affiliateTypes form sep-top">
	<?php echo $this->Form->create('AffiliateType', array('class' => 'space', 'action' => 'edit'));?>
		<table class="table no-round ">
		<thead>
        <tr class="well no-mar no-pad"> 
				<th class="graydarkc dc sep-right"><?php echo __l('Name');?></th>
				<th class="graydarkc dc sep-right"><?php echo __l('Commission');?></th>
				<th class="graydarkc dc sep-right"><?php echo __l('Commission Type');?></th>
				<th class="graydarkc dc sep-right"><?php echo __l('Active?');?></th>
			</tr>
			<?php
				$types = count($this->request->data['AffiliateType']);
				for($i=0; $i<$types; $i++) {
			?>
			<tr>
				<td class="dc"><?php echo $this->Form->input('AffiliateType.'.$i.'.id', array('label' => false)); ?><?php echo $this->Form->input('AffiliateType.'.$i.'.name', array('label' => false, 'class' => 'span6')); ?></td>
				<td class="dc">
					<?php
						echo $this->Form->input('AffiliateType.'.$i.'.commission', array('label' => false, 'class' => 'span6'));
						$options = $affiliateCommissionTypes;
						if ($this->request->data['AffiliateType'][$i]['id'] == 1)
							unset($options[1]);
					?>
				</td>
				<td class="dc"><?php echo $this->Form->input('AffiliateType.'.$i.'.affiliate_commission_type_id', array('options' => $options, 'label' => false, 'class' => 'span3')); ?></td>
				<td class="dc"><?php echo $this->Form->input('AffiliateType.'.$i.'.is_active', array('label' => "")); ?></td>
			</tr>
			<?php
				}
			?>
		</table>
	<div class="form-actions">
		<?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16', 'div' => array('class' => 'submit  offset5')));?>
	</div>		
	<?php echo $this->Form->end(); ?>
</div>