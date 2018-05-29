<?php /* SVN: $Id: $ */ ?>
<div class="mail-right-block ">
	<div class="block2-tl">
    	<div class="block2-tr">
    		<div class="block2-tm">
                    <h4><?php echo __l('Mail');?></h4>
            </div>
         </div>
	</div>
	<div class="block1-cl">
		<div class="block1-cr">
			<div class="block1-cm">
				<div class="main-section main-message-block">
					<?php echo $this->element('message_message-left_sidebar', array('config' => 'sec')); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="block2-bl">
		<div class="block2-br">
			<div class="block2-bm">
			</div>
		</div>
	</div>
</div>
<div class="messages message-side2 ">
	<div class="block2-tl">
		<div class="block2-tr">
			<div class="block2-tm">
                <h2 class="title"><?php echo __l('Labels'); ?></h2>
			</div>
		</div>
	</div>
		<div class="block1-cl">
		<div class="block1-cr">
			<div class="block1-cm">
				<div class="main-section">
					<div class="add clearfix">
						<div class="">
							<?php
							echo $this->Html->link(__l('Add'), array('action' => 'add'), array('class' => 'add','title'=>__l('Add')));
							?>
						</div>
					</div>
					<?php if (!empty($labels)):
						echo $this->element('paging_counter');
					endif;?>
					<table class="list">
						<tr>
							<th class="actions"><?php echo __l('Actions');?></th>
							<th><?php echo $this->Paginator->sort('name');?></th>
						</tr>
					<?php
					if (!empty($labels)):

					$i = 0;
					foreach ($labels as $label):
						$class = null;
						if ($i++ % 2 == 0) {
							$class = ' class="altrow"';
						}
					?>
						<tr<?php echo $class;?>>
							<td class="actions"><span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $label['User'][0]['LabelsUser']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span> <span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete',  $label['User'][0]['LabelsUser']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></td>
							<td><?php echo $this->Html->cText($label['Label']['name']);?></td>
						</tr>
					<?php
						endforeach;
					else:
					?>
						<tr>
							<td colspan="6">
							  <div class="space dc grayc">
								<p class="ver-mspace top-space text-16 "><?php echo __l('No Labels available');?></p>
							  </div>
							</td>
						</tr>
					<?php
					endif;
					?>
					</table>

					<?php
					if (!empty($labels)) {
						echo $this->element('paging_links');
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="block2-bl">
		<div class="block2-br">
			<div class="block2-bm">
			</div>
		</div>
	</div>
</div>

