<?php /* SVN: $Id: $ */ ?>
<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Educations'), array('controller'=>'user_educations','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Edit Education'); ?></li>
</ul>
<div class="userEducations form sep-top">
<?php echo $this->Form->create('UserEducation', array('class' => 'form-horizontal space'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('education', array('label' => __l('Education')));
		echo $this->Form->input('is_active', array('label' => __l('Enable')));
	?>
	</fieldset>
    <div class="form-actions">
    <?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>
