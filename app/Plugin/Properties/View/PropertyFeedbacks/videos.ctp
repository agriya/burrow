<?php /* SVN: $Id: $ */ ?>
<div class="propertyFeedbacks">
<ol class="unstyled  no-mar  clearfix">
<?php
$i=0;
if (!empty($propertyFeedbacks)): ?>
<?php
$this->loadHelper('Embed');
?>
<?php foreach ($propertyFeedbacks as $propertyFeedback): ?>

 <?php if (!empty($propertyFeedback['PropertyFeedback']['video_url'])): $i++?>
 <li class="clearfix ver-space sep-bot left-mspace mob-no-mar">
<div id="video-1" class="ui-corner-right">
		<?php if($this->Embed->parseUrl($propertyFeedback['PropertyFeedback']['video_url'])){
				$this->Embed->setHeight('150px');
				$this->Embed->setWidth('150px');
				echo $this->Embed->getEmbedCode();
			}
		?>		
	</div>
</li>
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
<?php if($i==0): ?>
<li>
 <div class="space dc grayc">
   	<p class="ver-mspace top-space text-16"><?php echo __l('No Guest videos available'); ?></p></div>
	</li>
<?php endif; ?>
</ol>

</div>
