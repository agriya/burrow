<?php /* SVN: $Id: admin_index.ctp 801 2009-07-25 13:22:35Z boopathi_026ac09 $ */ ?>
<div class="userViews index js-response">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">User Views </li>
            </ul>
			 <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
   <div class="clearfix dc">
					<?php echo $this->Form->create('UserView', array('type' => 'get', 'class' => 'form-search bot-mspace big-input span', 'action'=>'index')); ?>
					<?php echo $this->Form->input('q', array('placeholder' => __l('Keyword'),'class'=>'span9 ver-mspace text-16','label' => false)); ?>
					<?php echo $this->Form->submit(__l('Search'), array('class'=>'btn btn-large hor-mspace btn-primary textb text-16'));?>
					<?php echo $this->Form->end(); ?>
					
			</div>
			</div>
			</div>
			<?php echo $this->element('paging_counter'); ?>
 <div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">

    <?php echo $this->Form->create('UserView' , array('class' => 'normal','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>

    <table class="table no-round table-striped">
	
	<tr class=" well no-mar no-pad">
            <th class="dc sep-right span2"><?php echo __l('Select'); ?></th>
            <th class="sep-right span2"><?php echo __l('Actions');?></th>
            <th class="dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('created',__l('Viewed Time'));?></div></th>
            <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username',__l('Username'));?></div></th>
            <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('ViewingUser.username',__l('Viewed User'));?></div></th>
            <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('Ip.ip',__l('IP'));?></div></th>
        </tr><thead><tbody>
        <?php
        if (!empty($userViews)):
            $i = 0;
            foreach ($userViews as $userView):
                $class = null;
                if ($i++ % 2 == 0) :
                    $class = ' class="altrow"';
                endif;
                ?>
                <tr<?php echo $class;?>>
                    <td class="dc"><?php echo $this->Form->input('UserView.'.$userView['UserView']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userView['UserView']['id'], 'label' => "", 'div' => 'top-space', 'class' => 'js-checkbox-list')); ?></td>
					<td class=""><div class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $userView['UserView']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
			   </ul>
				  </div>
					</td>
                   
                    <td class="dc"><?php echo $this->Html->cDateTimeHighlight($userView['UserView']['created']);?></td>
                    <td class="dl"><?php echo $this->Html->link($this->Html->cText($userView['User']['username'],false), array('controller'=> 'users', 'action'=>'view', $userView['User']['username'], 'admin' => false), array('escape' => false,'title' => $this->Html->cText($userView['User']['username'],false) ));?></td>
                    <td class="dl"><?php echo !empty($userView['ViewingUser']['username']) ? $this->Html->link($this->Html->cText($userView['ViewingUser']['username'],false), array('controller'=> 'users', 'action'=>'view', $userView['ViewingUser']['username'], 'admin' => false), array('escape' => false,'title' => $this->Html->cText($userView['ViewingUser']['username'],false))) : __l('Guest');?></td>
                    <td class="dl">
					<?php if(!empty($userView['Ip']['ip'])): ?>
                            <?php echo  $this->Html->link($userView['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $userView['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$userView['Ip']['host'], 'escape' => false));
							?>
							<div>
							<?php
                            if(!empty($userView['Ip']['Country'])):
                                ?>
                                <span class="flags flag-<?php echo strtolower($userView['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $userView['Ip']['Country']['name']; ?>">
									<?php echo $userView['Ip']['Country']['name']; ?>
								</span>
                                <?php
                            endif;
							 if(!empty($userView['Ip']['City'])):
                            ?>
                            <p class="htruncate js-bootstrap-tooltip span2" title="<?php echo $userView['Ip']['City']['name'];?>"><?php echo $userView['Ip']['City']['name']; ?>   </p>
                            <?php endif; ?></div>
                            
                        <?php else: ?>
							<?php echo __l('N/A'); ?>
						<?php endif; ?>
					</td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="7"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No User Views available');?></p></div></td>
            </tr>
            <?php
        endif;
        ?></tbody>
    </table>

    <?php
    if (!empty($userViews)) :
        ?>
      <div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
                <?php echo __l('Select:'); ?>
				</span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
             </div><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit js-no-pjax span5', 'div'=>false,'label' => false, 'empty' => __l('-- More actions --'))); ?></span>
            
         </div>
          <div class="js-pagination pagination pull-right no-mar mob-clr dc">
            <?php echo $this->element('paging_links'); ?>
        </div>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
</div>
