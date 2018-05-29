<?php /* SVN: $Id: $ */ ?>
<div class="label-content">
<h2 class="label"> <?php echo $this->Html->link(__l('Labels'),array('controller'=>'labels_users','action'=>'index'),array('title' =>'Labels'));?></h2>
<?php
if (!empty($labelsUsers)):
?>
<ul class="label">
<?php
foreach ($labelsUsers as $labelsUser):
?>
    <li>
	  <?php echo $this->Html->link($this->Html->cText($labelsUser['Label']['name'], false),array('controller'=>'messages','action'=>'label',$labelsUser['Label']['slug']));?>
  	</li>
<?php
endforeach;?>
</ul> 
<?php
endif;
?>
</div>
