<?php /* SVN: $Id: $ */ ?>
<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Employments '), array('controller'=>'user_employments','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Add Employments '); ?></li>
</ul>
<div class="userEmployments form sep-top">
<?php echo $this->Form->create('UserEmployment', array('class' => 'form-horizontal space'));?>
	<fieldset>
	<?php
		echo $this->Form->input('employment', array('label' => __l('Employment')));
		echo $this->Form->input('is_active',array('label' => __l('Enable'),'checked' => 'checked'));
	?>
	</fieldset>
     <div class="form-actions">
    <?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>
