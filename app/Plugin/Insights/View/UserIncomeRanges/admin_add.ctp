<?php /* SVN: $Id: $ */ ?>
<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Income Ranges'), array('controller'=>'user_income_ranges','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Add Income Ranges'); ?></li>
</ul>
<div class="userIncomeRanges form sep-top">
<?php echo $this->Form->create('UserIncomeRange', array('class' => 'form-horizontal space'));?>
	<fieldset>
	<?php
		echo $this->Form->input('income', array('label' => __l('Income')));
		echo $this->Form->input('is_active',array('label' => __l('Enable'),'checked' => 'checked'));
	?>
	</fieldset>
   <div class="form-actions">
    <?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>
