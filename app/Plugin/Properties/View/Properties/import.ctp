<?php /* SVN: $Id: $ */ ?>
<div class="properties properties-import">
	<div class="clearfix">

	<h2 class="ver-space top-mspace text-32 sep-bot"><?php echo __l('Import your properties from AirBnB') . ' ';?></h2></div>
	<?php if($steps <= 3):  ?>
		<div class="clearfix ver-space bot-mspace">
			<ul id="stage" class="unstyled dc clearfix pull-left mob-clr">
				<li class="pull-left ver-space right-mspace sep-bot sep-medium mob-clr  <?php if($steps == 1): ?> complete highlight<?php endif; ?> <?php if($steps >= 1): ?>active<?php endif; ?>"><?php echo __l('AirBnB Login');?></li>
				<li class="pull-left ver-space right-mspace sep-bot sep-medium mob-clr <?php if($steps == 2): ?> complete highlight<?php endif; ?> <?php if($steps >= 2): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo __l('Import Properties');?></li>
			</ul>
		</div>
	<?php endif; ?>
	<?php echo $this->Form->create('Property', array('action' => 'import', 'class' => 'form-horizontal form-request check-form'));?>

		<?php if($steps >= 1):  ?>
			<div <?php if($steps > 1): ?>class="hide"<?php endif;?>>
				<fieldset>
					<p class="alert alert-info"><?php echo __l('Note: We will not store your AirBnB email and password.'); ?></p>

						<?php echo $this->Form->input('airbnb_email', array('label' => __l('AirBnB Email')));  ?>
						<?php echo $this->Form->input('airbnb_password', array('label' => __l('AirBnB Password'), 'type' => 'password')); ?>

					
				</fieldset>
				<div class="form-actions clearfix">
					<?php 
						if($steps == 1):

							echo $this->Form->submit(__l('Next'),array('name' => 'data[Property][step1]','class'=>'btn btn-large btn-primary textb text-16','div'=>'pull-right submit'));

						endif;
					?>
				</div>
			</div>
		<?php endif; ?>
		<?php if($steps >= 2):  ?>
			<div <?php if($steps > 2): ?>class="hide"<?php endif;?>>
				<fieldset>
						<table class="table list no-round">
						<thead>
							<tr class=" well no-mar no-pad">
								<th class="dc graydarkc sep-right"><?php echo __l('Select'); ?></th>
								<th class="dl graydarkc sep-right"><?php echo __l('Property'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php $is_show_import_button = 0; ?>
							<?php if (!empty($properties)): ?>
								<?php foreach($properties as $property): ?>
									<?php $disabled = (in_array($property['Property']['id'], array_values($importedProperties))) ? true : false; ?>
									<?php
										if (!$disabled):
											$is_show_import_button = 1;
										endif;
									?>
									<tr>
										<td class="dc"><?php echo ($disabled) ? '<span class="active label label-success">' . __l('Imported') . '</span>' : '<div class="input checkbox no-mar">'.$this->Form->input('Property.' . $property['Property']['id'] . '.id', array('type' => 'checkbox', 'id' => 'admin_checkbox_' . $property['Property']['id'], 'label' => "", 'div' => false,'class' => 'js-checkbox-list')).'</div>'; ?></td>
										<td class="dl"><?php echo $property['Property']['title']; ?><?php echo $this->Form->input('Property.' . $property['Property']['id'] . '.title', array('type' => 'hidden', 'value' => $this->Html->cText($property['Property']['title'],false))); ?></td>
									</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr>
									<td colspan="2">
										<div class="space dc grayc">
											<p class="ver-mspace top-space text-16 "><?php echo __l('No Properties available');?></p>
										</div>
									</td>
								</tr>
							<?php endif; ?>
							</tbody>
						</table>

					
				</fieldset>
				<div class="form-actions">
					<?php if (!empty($properties) && $is_show_import_button): ?>
						<?php 
							if($steps == 2):
								echo $this->Form->submit(__l('Import'),array('name' => 'data[Property][step2]','class' => 'btn btn-large btn-primary textb text-16'));
							endif;
						?>
					<?php endif; ?>
					<div class="cancel-block">
						<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'properties', 'action' => 'index', 'type' => 'myproperties', 'status' => 'imported'), array('class' => 'cancel-link btn btn-large textb text-16 dc', 'title' => __l('Cancel'), 'escape' => false));?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php echo $this->Form->end();?>
</div>