<div id="activities" class="js-response clearfix">
	<section>
	<?php
		if (!empty($messages)) :
			foreach($messages as $message):
	?>
				<div class="clearfix bot-mspace">
					<span class="pull-left">
						<?php echo $this->Html->displayActivities($message); ?>
					</span>
					<?php  $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created'])); ?>
					<span class="js-timestamp pull-left left-smspace" title="<?php echo $time_format;?>"><?php echo $message['Message']['created']; ?></span>				
				</div>   
	<?php
			endforeach;
		else: ?>
			<div class="space dc grayc">
				<p class="ver-mspace top-space text-16 "><?php echo __l('No Activities available'); ?></p>
			</div>
	<?php
		endif;
	?>
	</section>
</div>