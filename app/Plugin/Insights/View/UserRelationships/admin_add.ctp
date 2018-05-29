<?php /* SVN: $Id: $ */ ?>
<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Relationships'), array('controller'=>'user_relationships','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Add Relationships'); ?></li>
</ul>
<div class="userRelationships form sep-top">
<?php echo $this->Form->create('UserRelationship', array('class' => 'form-horizontal space'));?>
	<fieldset>
	<?php
		echo $this->Form->input('relationship');
		echo $this->Form->input('is_active',array('label' => 'Enable','checked' => 'checked'));
	?>
	</fieldset>
   <div class="form-actions">
    <?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>
