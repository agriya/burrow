<?php /* SVN: $Id: $ */ ?>
<div class="propertyFeedbacks">
<ol class="unstyled  no-mar top-space clearfix">
<?php
$i=0;
if (!empty($propertyFeedbacks)): ?>
<?php foreach ($propertyFeedbacks as $propertyFeedback): ?>
 <?php foreach ($propertyFeedback['Attachment'] as $Feedback): $i++; ?>
<li class="span bot-space right-space mob-no-mar">
  <?php
    	  echo $this->Html->showImage('PropertyFeedback', $Feedback, array('dimension' => 'small_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText(($Feedback['description'])?$Feedback['description']:$propertyFeedback['Property']['title'], false)), 'title' => $this->Html->cText(($Feedback['description'])?$Feedback['description']:$propertyFeedback['Property']['title'], false)));
    ?>
</li>
<?php endforeach; ?>
<?php endforeach; ?>
<?php endif; ?>
<?php if($i==0): ?>
<li>
    <div class="space dc grayc">
	<p class="ver-mspace top-space text-16"><?php echo __l('No Guest photos available'); ?></p>
</div></li>
<?php endif; ?>
</ol>

</div>
