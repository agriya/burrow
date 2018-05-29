<?php /* SVN: $Id: $ */ ?>
<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Collections'), array('controller'=>'collections','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Add Collection'); ?></li>
</ul>
<div class="collections form sep-top">
<?php echo $this->Form->create('Collection', array('class' => 'form-horizontal space', 'enctype' => 'multipart/form-data'));?>
	<fieldset>
    <?php
		echo $this->Form->input('title', array('label' => __l('Title')));
		echo $this->Form->input('description', array('label' => __l('Description')));
		echo $this->Form->input('Attachment.filename', array('type' => 'file','size' => '33', 'label' => __l('Upload Photo'), 'class' =>'browse-field'));

		echo $this->Form->input('is_active', array('label' => __l('Enable')));
	?>
    </fieldset>
    <div class="form-actions">
     <?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>
