<?php /* SVN: $Id: admin_index.ctp 1711 2010-05-04 11:12:13Z vinothraja_091at09 $ */ ?>
<div class="bannedIps index js-response">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Banned Ips                </li>
            </ul> 
			<div class="clearfix dc">
					
					<div class="pull-right top-space mob-clr dc top-mspace">
					 
					<?php echo $this->Html->link('<span class="ver-smspace"><i class="icon-plus-sign no-pad top-smspace"></i></span>', array('controller' => 'banned_ips', 'action' => 'add'), array('escape' => false,'class' => 'add btn btn-primary textb text-18 whitec','title'=>__l('Add'))); ?>
				</div>
			</div>
		<?php echo $this->element('paging_counter'); ?>

   <?php echo $this->Form->create('BannedIp' , array('class' => 'normal clearfix', 'action' => 'update')); ?>
		<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
				<th class="sep-right dc span2"><?php echo __l('Select'); ?></th>
				<th class="sep-right dc span2"><?php echo __l('Actions'); ?></th>
				<th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'address',__l('Victims'));?></div></th>
				<th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'reason',__l('Reason'));?></div></th>
				<th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'redirect',__l('Redirect to'));?></div></th>
				<th class="dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('thetime',__l('Date Set'));?></div></th>
				<th class="dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'timespan',__l('Expiry Date'));?></div></th>
			</tr></thead><tbody>
			<?php
			if (!empty($bannedIps)):
				$i = 0;
				foreach ($bannedIps as $bannedIp):
					$class = null;
					if ($i++ % 2 == 0) :
						$class = ' class="altrow"';
					endif;
					?>
					<tr <?php echo $class;?>>
						<td class="dc">
							<?php echo $this->Form->input('BannedIp.'.$bannedIp['BannedIp']['id'].'.id', array('type' => 'checkbox', 'label' => "" , 'id' => "admin_checkbox_".$bannedIp['BannedIp']['id'], 'class' => 'js-checkbox-list')); ?>
						</td>
						<td>
							<span class="dropdown dc"> 
								<span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> 
									<span class="hide"><?php echo __l('Actions'); ?></span> 
								</span>
								<ul class="dropdown-menu arrow no-mar dl">
									<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $bannedIp['BannedIp']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
								</ul>
							 </span>
						</td>
						<td class="dl">
							<?php
								if ($bannedIp['BannedIp']['referer_url']) :
									echo $bannedIp['BannedIp']['referer_url'];
								else:
									echo long2ip($bannedIp['BannedIp']['address']);
									if ($bannedIp['BannedIp']['range']) :
										echo ' - '.long2ip($bannedIp['BannedIp']['range']);
									endif;
								endif;
							?>
						</td>
						<td class="dl"><?php echo $this->Html->cText($bannedIp['BannedIp']['reason']);?></td>
						<td class="dl"><?php echo $this->Html->cText($bannedIp['BannedIp']['redirect']);?></td>
						<td class="dc"><?php echo _formatDate('M d, Y h:i A', $bannedIp['BannedIp']['thetime']); ?></td>
						<td class="dc"><?php echo ($bannedIp['BannedIp']['timespan'] > 0) ? _formatDate('M d, Y h:i A', $bannedIp['BannedIp']['thetime']) : __l('Never');?></td>
					</tr>
			<?php
				endforeach;
			else:
			?>
				<tr>
					<td colspan="7"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Banned IPs available');?></p></div></td>
				</tr>
			<?php
			endif;
			?>
		</table>
		<?php if (!empty($bannedIps)): ?>
			<div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
				<span class="graydarkc">
                        <?php echo __l('Select:'); ?></span>
                        <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
						<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
                                        
             </div><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit js-no-pjax span5', 'div'=>false,'label' => false, 'empty' => __l('-- More actions --'))); ?>
         </div>
			<div class="js-pagination">
				<?php echo $this->element('paging_links'); ?>
			</div>
			<div class="hide">
				<?php echo $this->Form->submit(__l('Submit'));  ?>
			</div>
		<?php endif; ?>
    <?php echo $this->Form->end(); ?>
</div>