<?php /* SVN: $Id: admin_index.ctp 801 2009-07-25 13:22:35Z boopathi_026ac09 $ */ ?>
<div class="userLogins index js-response">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">User Logins </li>
            </ul> 
			 <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
<div class="clearfix dc">
					<?php echo $this->Form->create('UserLogin', array('type' => 'get', 'class' => 'form-search bot-mspace big-input span', 'action'=>'index')); ?>
					<?php echo $this->Form->input('q', array('placeholder' => __l('Keyword'),'class'=>'span9 ver-mspace text-16','label' => false)); ?>
					<?php echo $this->Form->submit(__l('Search'), array('class'=>'btn btn-large hor-mspace btn-primary textb text-16'));?>
					<?php echo $this->Form->end(); ?>
					
			</div>
			</div>
			</div>
			<?php echo $this->element('paging_counter'); ?>
 <div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">

    <?php echo $this->Form->create('UserLogin' , array('class' => 'normal','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>

    <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad js-even">
            <th class="dc graydarkc sep-right span2"><?php echo __l('Select'); ?></th>
            <th class="dc graydarkc sep-right span2"><?php echo __l('Actions');?></th>
            <th class="dc graydarkc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'created',__l('Login Time'));?></div></th>
            <th class="dl graydarkc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'User.username',__l('Username'));?></div></th>
            <th class="dl graydarkc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('user_login_ip_id',__l('User Login IP'));?></div></th>
            <th class="dl graydarkc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'user_agent',__l('User Agent'));?></div></th>
        </tr></thead>
		<tbody>
        <?php
        if (!empty($userLogins)):
            $i = 0;
            foreach ($userLogins as $userLogin):
                $class = null;
                if ($i++ % 2 == 0) :
                    $class = ' class="altrow"';
                endif;
                ?>
                <tr <?php echo $class;?>>
                    <td class="dc"><?php echo $this->Form->input('UserLogin.'.$userLogin['UserLogin']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userLogin['UserLogin']['id'], 'label' => "", 'div' => 'top-space', 'class' => 'js-checkbox-list')); ?></td>
					<td class="dc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $userLogin['UserLogin']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
			   </ul>
				  </span>
					</td>
                   
                    <td class="dc"><?php echo $this->Html->cDateTimeHighlight($userLogin['UserLogin']['created']);?></td>
                    <td class="dl"><?php echo $this->Html->link($this->Html->cText($userLogin['User']['username']), array('controller'=> 'users', 'action'=>'view', $userLogin['User']['username'], 'admin' => false), array('escape' => false));?></td>
                   	<td class="dl">
                        <?php if(!empty($userLogin['Ip']['ip'])): ?>
                            <?php echo  $this->Html->link($userLogin['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $userLogin['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$userLogin['Ip']['host'], 'escape' => false));
							?>
							<p>
							<?php
                            if(!empty($userLogin['Ip']['Country'])):
                                ?>
                                <span class="flags flag-<?php echo strtolower($userLogin['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $userLogin['Ip']['Country']['name']; ?>">
									<?php echo $userLogin['Ip']['Country']['name']; ?>
								</span>
                                <?php
                            endif;
							 if(!empty($userLogin['Ip']['City'])):
                            ?>
                            <span> 	<?php echo $userLogin['Ip']['City']['name']; ?>    </span>
                            <?php endif; ?>
                            </p>
                        <?php else: ?>
							<?php echo __l('N/A'); ?>
						<?php endif; ?>
						</td>
                    <td class="dl"><?php echo $this->Html->cText($userLogin['UserLogin']['user_agent']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="6"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No User Logins available');?></p></div></td>
            </tr>
            <?php
        endif;
        ?></tbody>
    </table>

    <?php
    if (!empty($userLogins)) :
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

       