<?php /* SVN: $Id: admin_add.ctp 196 2009-05-25 14:59:50Z siva_43ag07 $ */ ?>
<div class="translations form">
	<ul class="breadcrumb top-mspace ver-space">
		<li><?php echo $this->Html->link( 'Translations', array('action'=>'index'), array('escape' => false));?> <span class="divider">/</span></li>
		<li class="active"><?php echo __l('Add New Language Variable'); ?></li>
	</ul> 
	<div class="tabbable ver-space sep-top top-mspace">
		<div id="list" class="tab-pane active in no-mar">
			<?php echo $this->Form->create('Translation', array('class' => 'form-horizontal space', 'action' => 'add_text')); ?>
			<fieldset>
				<?php echo $this->Form->input('Translation.name', array('label' => __l('Original'))); ?>
				<?php foreach ($languages as $lang_id => $lang_name) : ?>
					<h3 class="well space textb text-16 no-mar"><?php echo $lang_name;?></h3>
					<?php echo $this->Form->input('Translation.'.$lang_id.'.lang_text'); ?>
				<?php endforeach; ?>
			</fieldset>
			<div class="form-actions">
				<?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
			</div>
			<?php echo $this->Form->end();?>
		</div>
	</div>
</div>