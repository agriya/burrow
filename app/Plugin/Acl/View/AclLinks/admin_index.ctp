<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="aclLinks index js-response">
<div class="clearfix">
    <div>
      <?php echo $this->element('paging_counter');?>
    </div>
    <div>
        <?php
			echo $this->Html->link(__l('Add'), array('action' => 'add'), array('title' => __l('Add New Acl Link')));
			echo $this->Html->link(__l('Generate Actions'), array('action' => 'generate'), array('title' => __l('It will generate actions from file structure'), 'class' => 'js-generate'));
		?>
    </div>
   </div>

        <table class="list">
            <tr>
				<th><?php echo __l('Actions'); ?></th>
				<th class="dl"><div><?php echo $this->Paginator->sort('name'); ?></div></th>
				<th class="dl"><div><?php echo $this->Paginator->sort('controller'); ?></div></th>
				<th class="dl"><div><?php echo $this->Paginator->sort('action'); ?></div></th>
				<th class="dl"><div><?php echo $this->Paginator->sort('named_key'); ?></div></th>
				<th class="dl"><div><?php echo $this->Paginator->sort('named_value'); ?></div></th>
				<th class="dl"><div><?php echo $this->Paginator->sort('pass_value'); ?></div></th>
            </tr>
            <?php
                if (!empty($aclLinks)):
                    foreach ($aclLinks as $aclLink):
                        ?>
                        <tr>
							<td>
                       		<div>
        						<span>
        							<span>&nbsp;
        							</span>
        							<span>
        								<span>
        									<?php echo __l('Action');?>
        								</span>
        							</span>
        						</span>
        						<div>
        							<div>
        								<ul class="clearfix">
        									<li><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $aclLink['AclLink']['id']), array('class' => 'js-edit', 'title' => __l('Edit')));?></li>
							             	<li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $aclLink['AclLink']['id']), array('class' => 'js-confirm', 'title' => __l('Delete')));?></li>
        								</ul>
        							</div>
        							<div></div>
        						</div>
        					</div>
     						</td>
							<td class="dl"><?php echo $this->Html->cText($aclLink['AclLink']['name']);?></td>
							<td class="dl"><?php echo $this->Html->cText($aclLink['AclLink']['controller']);?></td>
							<td class="dl"><?php echo $this->Html->cText($aclLink['AclLink']['action']);?></td>
							<td class="dl"><?php echo $this->Html->cBool($aclLink['AclLink']['named_key']);?></td>
							<td class="dl"><?php echo $this->Html->cBool($aclLink['AclLink']['named_value']);?></td>
							<td class="dl"><?php echo $this->Html->cBool($aclLink['AclLink']['pass_value']);?></td>
                        </tr>
                        <?php
                    endforeach;
            else:
                ?>
                <tr>
                    <td colspan="7">
						<div class="space dc">
							<p class="ver-mspace grayc top-space text-16 "><?php echo sprintf(__l('No %s available'), __l('Acl Links'));?></p>
						</div>
					</td>
                </tr>
                <?php
            endif;
            ?>
        </table>
        <?php
         if (!empty($aclLinks)) : ?>
         <div class="clearfix">
			<div>
				<?php echo $this->element('paging_links'); ?>
			</div>
        </div>
            <?php
         endif; ?>
        <?php echo $this->Form->end();?>

</div>
