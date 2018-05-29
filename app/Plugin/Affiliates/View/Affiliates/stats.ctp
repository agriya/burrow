   <div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
					<h3 class="ver-space bot-mspace  textb text-16"><?php echo __l('Stats');?></h3>
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
			
				<th colspan="2"></th>
				<?php foreach($periods as $key => $period){ ?>
				<th class="sep-left">
					<?php echo $period['display']; ?>
				</th>
				<?php } ?>
			</tr></thead></tbody>
			<?php 
			foreach($models as $unique_model){ ?>
				<?php foreach($unique_model as $model => $fields){
					$aliasName = isset($fields['alias']) ? $fields['alias'] : $model;
				?>
					
						<?php $element = isset($fields['colspan']) ? 'rowspan ="'.$fields['colspan'].'"' : ''; ?>						
						<?php if(!isset($fields['isSub'])) :?>
							<tr>
							<td class="sub-title	" <?php echo $element;?>>
								<?php echo $fields['display']; ?>
							</td>
						<?php endif;?>
						<?php if(isset($fields['isSub'])) :	?>
							<td>
								<?php echo $fields['display']; ?>
							</td>
						<?php endif; ?>		
						<?php if(!isset($fields['colspan'])) :?>
							<?php foreach($periods as $key => $period){ ?>
									<td>
										<span class="<?php echo (!empty($fields['class']))? $fields['class'] : ''; ?>">
											<?php											
												if(empty($fields['type'])) {
													$fields['type'] = 'cInt';
												}
												if (!empty($fields['link'])):
													$fields['link']['stat'] = $key;
													echo $this->Html->link($this->Html->{$fields['type']}(${$aliasName.$key}), $fields['link'], array('escape' => false, 'title' => __l('Click to View Details')));
												else:
													echo $this->Html->{$fields['type']}(${$aliasName.$key});
												endif;											
											?>
										</span>
									</td>
							<?php } ?>
							</tr>
						<?php endif; ?>		
					
				 <?php } ?>
			<?php } ?>
			</table>
      </div>