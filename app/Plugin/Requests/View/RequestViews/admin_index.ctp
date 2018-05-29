<div class="requestViews index js-response">
<?php if(empty($this->request->params['named']['view_type'])) : ?>
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Request Views   </li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
<div class="clearfix dc">
					<?php echo $this->Form->create('RequestView', array('type' => 'get', 'class' => 'form-search bot-mspace big-input span', 'action'=>'index')); ?>
					<?php echo $this->Form->input('q', array('placeholder' => __l('Keyword'),'class'=>'span9 ver-mspace text-16','label' => false)); ?>
					<?php echo $this->Form->submit(__l('Search'), array('class'=>'btn btn-large hor-mspace btn-primary textb text-16'));?>
					<?php echo $this->Form->end(); ?>
					
			</div>
			
	<?php endif; ?>
	<?php echo $this->element('paging_counter'); ?>

    <?php echo $this->Form->create('RequestView' , array('class' => 'normal clearfix','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
    <div class="ver-space">
    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
            <?php if(empty($this->request->params['named']['view_type'])) : ?>
            <th class="dc  sep-right span2"><?php echo __l('Select'); ?></th>
            <?php endif; ?>
            <th class="dc span2 sep-right"><?php echo __l('Actions');?></th>
			<?php if(empty($this->request->params['named']['view_type'])) : ?>
            <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'RequestView.title',__l('Request'));?></div></th>
			<?php endif; ?>
            <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'User.username',__l('Viewed By'));?></div></th>
            <th><div class="js-pagination sep-right"><?php echo $this->Paginator->sort( 'Ip.ip',__l('IP'));?></div></th>
           	<th class="dc"><div class="js-pagination sep-right"><?php echo $this->Paginator->sort('created',__l('Viewed On'));?></div></th>
        </tr>
        <?php
               if (!empty($requestViews)):
		?>
			<tbody>
		<?php 
            $i = 0;
            foreach ($requestViews as $requestView):
                $class = null;
                if ($i++ % 2 == 0) :
                    $class = ' class="altrow"';
                endif;
                ?>
                <tr<?php echo $class;?>>
                    <?php if(empty($this->request->params['named']['view_type'])) : ?>
                    <td class="dc"><?php echo $this->Form->input('RequestView.'.$requestView['RequestView']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$requestView['RequestView']['id'], 'label' => "" , 'div' => 'top-space', 'class' => 'js-checkbox-list')); ?></td>
					<?php endif; ?>
		 <td class="dc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $requestView['RequestView']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
			   </ul>
   	  </span>
		</td>
					<?php if(empty($this->request->params['named']['view_type'])) : ?>
	                    <td class="dl"><div class="htruncate js-bootstrap-tooltip span5" title="<?php echo $requestView['Request']['title']; ?>"><?php echo $this->Html->link($this->Html->cText($requestView['Request']['title']), array('controller'=> 'requests', 'action'=>'view', $requestView['Request']['slug'], 'admin' => false), array('class'=>'js-no-pjax','escape' => false,'title' => $this->Html->cText($requestView['Request']['title'],false)));?></div>
                        </td>
					<?php endif; ?>
                    <td class="dl"><?php echo !empty($requestView['User']['username']) ? $this->Html->link($this->Html->cText($requestView['User']['username']), array('controller'=> 'users', 'action'=>'view', $requestView['User']['username'], 'admin' => false), array('class'=>'js-no-pjax','escape' => false,'title' => $this->Html->cText($requestView['User']['username'],false))) : __l('Guest');?></td>
                    <td class="dl">
					  <?php
                   if(!empty($requestView['Ip']['ip'])): ?>
                            <?php echo  $this->Html->link($requestView['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $requestView['Ip']['ip'], 'admin' => false), array('class'=>'js-no-pjax','target' => '_blank', 'title' => 'whois '.$requestView['Ip']['host'], 'escape' => false));
							?>							
							<?php
                            if(!empty($requestView['Ip']['Country'])):
                                ?>
                                <span class="flags flag-<?php echo strtolower($requestView['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $requestView['Ip']['Country']['name']; ?>">
									<?php echo $requestView['Ip']['Country']['name']; ?>
								</span>
                                <?php
                            endif;
							 if(!empty($requestView['Ip']['City'])):
                            ?>
                            <span class="htruncate js-bootstrap-tooltip span2" title="<?php echo $requestView['Ip']['City']['name'];?>"><span> 	<?php echo $requestView['Ip']['City']['name']; ?>    </span></span>
                            <?php endif; ?>
                            
                        <?php else: ?>
							<?php echo __l('N/A'); ?>
						<?php endif; ?>
					</td>
					<td class="dc"><?php echo $this->Html->cDateTimeHighlight($requestView['RequestView']['created']);?></td>
                </tr>
                <?php
            endforeach;?>
			</tbody>
        <?php else:
            ?>
			<tr class="js-odd">
				<td colspan="51"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Request Views available');?></p></div></td>
			</tr>
            <?php
        endif;
        ?>
    </table>
	</div>
    <?php
    if (!empty($requestViews)) :
        ?>
		<div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
	   <?php if(empty($this->request->params['named']['view_type'])) : ?>
                <?php echo __l('Select:'); ?>
				</span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
				
             </div><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit js-no-pjax span5', 'div'=>false,'label' => false, 'empty' => __l('-- More actions --'))); ?></span>
            <?php endif; ?>
         </div>
          <div class="js-pagination pagination pull-right no-mar mob-clr dc">
            <?php echo $this->element('paging_links'); ?>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
</div>
</div>