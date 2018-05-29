<?php /* SVN: $Id: $ */ ?>
<div class="siteCategories form">
<?php echo $this->Form->create('SiteCategory', array('class' => 'normal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('is_active', array('label'=> 'Enable', 'type'=> 'checkbox'));
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>
