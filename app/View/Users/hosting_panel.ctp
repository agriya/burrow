<table class="table table-striped graydarkc">
	<thead>
	<tr class="well">
		<th colspan="1">&nbsp;</th>
		<?php foreach($periods as $key => $period){ ?>
		<th class="dc">
			<?php echo $period['display'].' ('.Configure::read('site.currency').')'; ?>
		</th>
		<?php } ?>
		</th>
	</tr>
	</thead>
	<tbody>
		<?php 
			foreach($models as $unique_model){ ?>
				<?php foreach($unique_model as $model => $fields){
					$aliasName = isset($fields['alias']) ? $fields['alias'] : $model;
				?>
					
						<?php $element = isset($fields['colspan']) ? 'rowspan ="'.$fields['colspan'].'"' : ''; ?>						

						<?php if(!isset($fields['isSub'])) :?>
							<tr>
							<td class="sub-title" <?php echo $element;?>>
								<?php echo $fields['display']; ?>
							</td>
						<?php endif;?>
	
						<?php if(!isset($fields['colspan'])) :?>
							<?php foreach($periods as $key => $period){ ?>
									<td class="dc"><span class="<?php echo (!empty($fields['class']))? $fields['class'] : ''; ?>">
											<?php 					
												if(empty($fields['type'])) {
													$fields['type'] = 'cInt';
												}
												if (!empty($fields['link'])):
													$fields['link']['stat'] = $key;
													echo $this->Html->link($this->Html->{$fields['type']}(${$aliasName.$key}), $fields['link'], array('escape' => false, 'title' => __l('Click to View Details')));
												else:
													echo $this->Html->{$fields['type']}(${$aliasName.$key});
												endif; ?></span>
									</td>
							<?php } ?>
							</tr>
						<?php endif; ?>		
					
				 <?php } ?>
			<?php } ?>
		</tbody>
</table>
