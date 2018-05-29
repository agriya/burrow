<?php /* SVN: $Id: $ */ ?>
<div class="requestFlags index js-response js-responses">
<?php if(empty($this->request->params['named']['view_type'])) : ?>
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Request Flags    </li>
            </ul> 
<?php endif; ?>			
            <div class="tabbable ver-space <?php echo (empty($this->request->params['named']['view_type'])) ? "sep-top" : "";?> top-mspace">
                <div id="list" class="tab-pane active in no-mar">
<?php echo $this->element('paging_counter');?>
<?php   
	echo $this->Form->create('RequestFlag' , array('class' => 'normal','action' => 'update'));
	echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); 
?>
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped" >
	<thead>
	<tr class=" well no-mar no-pad">
	<?php if(empty($this->request->params['named']['view_type'])) : ?>
		<th class="sep-right span2"><?php echo __l('Select'); ?></th>
		<?php endif;?>
        <th class="sep-right span2"><?php echo __l('Actions');?></th>
        <th class="dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'created',__l('Created'));?></div></th>
        <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'User.username',__l('User'));?></div></th>
        <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'Request.name',__l('Request'));?></div></th>
        <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'RequestFlagCategory.name',__l('Request Flag Category'));?></div></th>
        <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'message',__l('Message'));?></div></th>
        <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'Ip.ip',__l('IP'));?></div></th>
    </tr>
<?php
if (!empty($requestFlags)):
?>
	<tbody>
<?php 
$i = 0;
foreach ($requestFlags as $requestFlag):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
	<?php if(empty($this->request->params['named']['view_type'])) : ?>
		<td class="dc"><?php echo $this->Form->input('RequestFlag.'.$requestFlag['RequestFlag']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$requestFlag['RequestFlag']['id'], 'label' => "", 'div' => 'top-space', 'class' => 'js-checkbox-list')); ?></td>
		<?php endif; ?>
		 <td class="dc">
			<span class="dropdown dc"> 
				<span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> 
					<span class="hide"><?php echo __l('Actions'); ?></span> 
				</span>
				<ul class="dropdown-menu arrow no-mar dl">
					<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'edit', $requestFlag['RequestFlag']['id']), array('escape' => false,'class' => 'edit js-edit', 'title' => __l('Edit')));?></li>
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $requestFlag['RequestFlag']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
				</ul>
			 </span>
		</td>
			
		<td class="dc"><?php echo $this->Html->cDateTime($requestFlag['RequestFlag']['created']);?></td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($requestFlag['User']['username']), array('controller'=> 'users', 'action'=>'view', $requestFlag['User']['username'], 'admin' => false), array('class'=>'js-no-pjax','escape' => false));?></td>
		<td class="dl"><div class="htruncate js-bootstrap-tooltip span7" title="<?php echo $requestFlag['Request']['title']; ?>"><?php echo $this->Html->link($this->Html->cText($requestFlag['Request']['title']), array('controller'=> 'requests', 'action'=>'view', $requestFlag['Request']['slug'], 'admin' => false), array('class'=>'js-no-pjax','escape' => false));?></div></td>
		<td class="dl"><?php echo $this->Html->cText($requestFlag['RequestFlagCategory']['name']);?></td>
		<td class="dl"><div class="htruncate js-bootstrap-tooltip span7" title="<?php echo $requestFlag['RequestFlag']['message']; ?>"><?php echo $this->Html->cText($requestFlag['RequestFlag']['message']);?></div></td>
		<td class="dc">
			    <?php
                 if(!empty($requestFlag['Ip']['ip'])): ?>
                            <?php echo  $this->Html->link($requestFlag['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $requestFlag['Ip']['ip'], 'admin' => false), array('class'=>'js-no-pjax','target' => '_blank', 'title' => 'whois '.$requestFlag['Ip']['host'], 'escape' => false));
							?>
							<div>
							<?php
                            if(!empty($requestFlag['Ip']['Country'])):
                                ?>
                                <span class="flags flag-<?php echo strtolower($requestFlag['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $requestFlag['Ip']['Country']['name']; ?>">
									<?php echo $requestFlag['Ip']['Country']['name']; ?>
								</span>
                                <?php
                            endif;
							 if(!empty($requestFlag['Ip']['City'])):
                            ?>
                            <p class="htruncate js-bootstrap-tooltip span2" title="<?php echo $requestFlag['Ip']['City']['name'];?>"><?php echo $requestFlag['Ip']['City']['name']; ?>    </p>
                            <?php endif; ?></div>                            
                        <?php else: ?>
							<?php echo __l('N/A'); ?>
						<?php endif; ?>
		</td>
	</tr>
<?php
    endforeach; ?>
</tbody>
<?php 	
else:
?>
	<tr>
		<td colspan="10"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Request Flags available');?></p></div></td>
	</tr>
<?php
endif;
?>
</table>
<?php
if (!empty($requestFlags)):
?><div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
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
        </div>
        <div class="hide">
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
</div>