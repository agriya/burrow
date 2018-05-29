<div id="activities" class="js-response clearfix">
	<ul class="breadcrumb top-mspace ver-space">
	  <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
	  <li class="active"><?php echo __l('Property Activities'); ?></li>
	</ul>
	<div class="tabbable ver-space sep-top top-mspace">
		<?php echo $this->element('paging_counter');?>
		<div class="ver-space">
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
			<?php if (!empty($messages)): ?>
			<div class="clearfix">
				<div class="js-pagination pagination pull-right no-mar mob-clr dc">
				<?php
					if (!empty($messages)) :
						echo $this->element('paging_links');
					endif;
				?>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>