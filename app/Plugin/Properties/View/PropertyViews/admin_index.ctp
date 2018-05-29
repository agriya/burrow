<div class="propertyViews index js-response">
<?php if(empty($this->request->params['named']['view_type'])) : ?>
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Property Views </li>
            </ul> 
<?php endif; ?>					
            <div class="tabbable ver-space <?php echo (empty($this->request->params['named']['view_type'])) ? "sep-top" : "";?> top-mspace">
                <div id="list" class="tab-pane active in no-mar">
<?php if(empty($this->request->params['named']['view_type'])) : ?>				
			<div class="clearfix dc">
					<?php echo $this->Form->create('PropertyView', array('type' => 'get', 'class' => 'form-search bot-mspace big-input span', 'action'=>'index')); ?>
					<?php echo $this->Form->input('q', array('placeholder' => __l('Keyword'),'class'=>'span9 ver-mspace text-16','label' => false)); ?>
					<?php echo $this->Form->submit(__l('Search'), array('class'=>'btn btn-large hor-mspace btn-primary textb text-16'));?>
					<?php echo $this->Form->end(); ?>
			</div>
<?php endif; ?>					
			<?php echo $this->element('paging_counter'); ?>
 
    <?php echo $this->Form->create('PropertyView' , array('class' => 'normal clearfix','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
	<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
            <?php if(empty($this->request->params['named']['view_type'])) : ?>
            <th class="dc graydarkc sep-right span2"><?php echo __l('Select'); ?></th>
            <?php endif; ?>
            <th class="dc graydarkc sep-right span2"><?php echo __l('Actions');?></th>
			<?php if(empty($this->request->params['named']['view_type'])) : ?>
            <th class="dl graydarkc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'PropertyView.title',__l('Property'));?></div></th>
			<?php endif; ?>
            <th class="dl graydarkc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'User.username',__l('Viewed By'));?></div></th>
            <th class="dl graydarkc sep-right span4"><div class="js-pagination"><?php echo $this->Paginator->sort('Ip.ip',__l('IP'));?></div></th>
           	<th class="dc graydarkc sep-right span2"><div class="js-pagination"><?php echo $this->Paginator->sort('created',__l('Viewed On'));?></div></th>
        </tr></thead>
        <?php
               if (!empty($propertyViews)):
            $i = 0;
            foreach ($propertyViews as $propertyView):
                $class = null;
                if ($i++ % 2 == 0) :
                    $class = ' class="altrow"';
                endif;
                ?>
                <tr<?php echo $class;?>>
                    <?php if(empty($this->request->params['named']['view_type'])) : ?>
                    <td class="dc"><?php echo $this->Form->input('PropertyView.'.$propertyView['PropertyView']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$propertyView['PropertyView']['id'], 'label' => "", 'div' => 'top-space', 'class' => 'js-checkbox-list')); ?></td>
                    <?php endif; ?>
                    <td class="dc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $propertyView['PropertyView']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
			   </ul>
   	  </span>
		</td>
					<?php if(empty($this->request->params['named']['view_type'])) : ?>
	                    <td class="dl"><div class="htruncate js-bootstrap-tooltip span6" title="<?php echo $propertyView['Property']['title'];?>" ><?php echo $this->Html->link($this->Html->cText($propertyView['Property']['title'],false), array('controller'=> 'properties', 'action'=>'view', $propertyView['Property']['slug'], 'admin' => false), array('escape' => false, 'class' => 'js-no-pjax', 'title' => $this->Html->cText($propertyView['Property']['title'],false)));?></div>
                        </td>
					<?php endif; ?>
                    <td class="dl"><?php echo !empty($propertyView['User']['username']) ? $this->Html->link($this->Html->cText($propertyView['User']['username']), array('controller'=> 'users', 'action'=>'view', $propertyView['User']['username'], 'admin' => false), array('escape' => false, 'class' => 'js-no-pjax', 'title' => $this->Html->cText($propertyView['User']['username'],false))) : __l('Guest');?></td>
                    <td class="dl">
					     <?php if(!empty($propertyView['Ip']['ip'])): ?>
                            <?php echo  $this->Html->link($propertyView['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $propertyView['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'title' => 'whois '.$propertyView['Ip']['host'], 'escape' => false));
							?>
							<div>
							<?php
                            if(!empty($propertyView['Ip']['Country'])):
                                ?>
                                <span class="flags flag-<?php echo strtolower($propertyView['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $propertyView['Ip']['Country']['name']; ?>">
									<?php echo $propertyView['Ip']['Country']['name']; ?>
								</span>
                                <?php
                            endif;
							 if(!empty($propertyView['Ip']['City'])):
                            ?>
                             <p class="htruncate js-bootstrap-tooltip span2" title="<?php echo $propertyView['Ip']['City']['name'];?>"><?php echo $propertyView['Ip']['City']['name']; ?>    </p>
                            <?php endif; ?></div>
                        <?php else: ?>
							<?php echo __l('N/A'); ?>
						<?php endif; ?>
					</td>
					<td class="dc"><?php echo $this->Html->cDateTimeHighlight($propertyView['PropertyView']['created']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="7"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Property Views available');?></p></div></td>
            </tr>
            <?php
        endif;
        ?>
    </table>

    <?php
    if (!empty($propertyViews)) :
        ?>
		<div class="admin-select-block ver-mspace pull-left mob-clr dc">
	   <?php if(empty($this->request->params['named']['view_type'])) : ?>
	   <div class="span top-mspace">
       <span class="graydarkc">
                <?php echo __l('Select:'); ?>
				</span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
             </div><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit js-no-pjax span5', 'div'=>false,'label' => false, 'empty' => __l('-- More actions --'))); ?>
            <?php endif; ?>
         </div>
          <div class="js-pagination pagination pull-right space no-mar mob-clr dc">
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
		