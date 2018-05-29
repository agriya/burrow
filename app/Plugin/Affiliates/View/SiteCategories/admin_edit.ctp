<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('States'), array('controller'=>'states','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Edit State'); ?></li>
</ul>
<div class="siteCategories form sep-top">
<?php echo $this->Form->create('SiteCategory', array('class' => 'form-horizontal space'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('is_active', array('label'=> 'Enable', 'type'=> 'checkbox'));
	?>
	</fieldset>
	<div class="form-actions">
		 <?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
		 <?php echo $this->Form->end();?>
	</div>
</div>
