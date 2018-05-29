<?php /* SVN: $Id: $ */ ?>
<div>
<h2> <?php echo __l('Labels');?></h2>
<?php
if (!empty($labels)):
?>
<ul class="label">
<?php
foreach ($labels as $label):
?>
    <li class="<?php echo (($label_slug == $label['Label']['slug']) ? 'active' : ''); ?>">
	  <?php echo $this->Html->link($this->Html->cText($label['Label']['name'], false),array('controller'=>'messages','action'=>'label',$label['Label']['slug']));?>
  	</li>
<?php
endforeach;?>
</ul> 
<?php
endif;
?>
<p> <?php echo $this->Html->link(__l('Manage labels'),array('controller'=>'labels','action'=>'index'),array('title' =>'Manage Labels'));?> </p>
<p> <?php echo $this->Html->link(__l('Create new label'),array('controller'=>'labels','action'=>'add'),array('title' =>'Create new label'));?> </p>
</div>
