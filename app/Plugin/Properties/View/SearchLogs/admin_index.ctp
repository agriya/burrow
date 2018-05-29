<?php /* SVN: $Id: $ */ ?>
<div class="searchLogs index js-response">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Search Logs   </li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
<div class="clearfix dc">
					<?php echo $this->Form->create('SearchLog', array('type' => 'get', 'class' => 'form-search bot-mspace big-input span', 'action'=>'index')); ?>
					<?php echo $this->Form->input('q', array('placeholder' => __l('Keyword'),'class'=>'span9 ver-mspace text-16','label' => false)); ?>
					<?php echo $this->Form->submit(__l('Search'), array('class'=>'btn btn-large hor-mspace btn-primary textb text-16'));?>
					<?php echo $this->Form->end(); ?>
					
			</div>
			<?php echo $this->element('paging_counter'); ?>

	<?php echo $this->Form->create('SearchLog', array('class' => 'normal', 'action'=>'update')); ?>
	<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
        <th class="dc sep-right"><?php echo __l('Select');?></th>
        <th class="dc sep-right span2"><?php echo __l('Actions');?></th>
        <th class="dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'created',__l('Added On'));?></div></th>
        <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'search_keyword_id',__l('Search Keyword'));?></div></th>
		<th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'user_id',__l('User'));?></div></th>
      	<th class="dl sep-right"><?php echo __l('Ip');?></th>
    </tr></thead>
   <?php
if (!empty($searchLogs)):

$i = 0;
foreach ($searchLogs as $searchLog):

	$class = null;
	$status_class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}

	//salt and hash prepartion
	$keyword_id=$searchLog['SearchLog']['search_keyword_id'];
	$salt = $keyword_id+786;
	$hash=dechex($keyword_id);
	$salt=substr(dechex($salt) , 0, 2);
?>
	<tr<?php echo $class;?>>
    <td class="dc"><?php echo $this->Form->input('SearchLog.'.$searchLog['SearchLog']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$searchLog['SearchLog']['id'], 'label' => "", 'div' => 'top-space', 'class' => $status_class.' js-checkbox-list')); ?></td>
		<td class="dc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
					<li><?php echo $this->Html->link('<i class="icon-search"></i>'.__l('Search'), array('controller'=> 'properties', 'action' => 'index',$hash,$salt, 'admin' => false), array('class' => 'search','escape' => false));?></li>
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $searchLog['SearchLog']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
			   </ul>
   	  </span></td>
		<td class="dc"><?php echo $this->Time->timeAgoInWords($searchLog['SearchLog']['created']);?></td>
		<td><div class="htruncate js-bootstrap-tooltip span5" title="<?php echo $searchLog['SearchKeyword']['keyword'];?>"><?php echo $this->Html->cText($searchLog['SearchKeyword']['keyword']);?></div></td>
		<td><?php echo !empty($searchLog['User']['username'])?$this->Html->link($this->Html->cText($searchLog['User']['username']), array('controller'=> 'users', 'action' => 'view', $searchLog['User']['username'], 'admin' => false), array( 'class' => 'js-no-pjax', 'escape' => false)):__l('Guest');?></td>
		<td class="dl">
          	<?php if(!empty($searchLog['Ip']['ip'])): ?>
                            <?php echo  $this->Html->link($searchLog['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $searchLog['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$searchLog['Ip']['host'], 'escape' => false));
							?>
							<div>
							<?php
                            if(!empty($searchLog['Ip']['Country'])):
                                ?>
                                <span class="flags flag-<?php echo strtolower($searchLog['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $searchLog['Ip']['Country']['name']; ?>">
									<?php echo $searchLog['Ip']['Country']['name']; ?>
								</span>
                                <?php
                            endif;
							 if(!empty($searchLog['Ip']['City'])):
                            ?>
                            <p class="htruncate js-bootstrap-tooltip span2" title="<?php echo $searchLog['Ip']['City']['name'];?>"><span> 	<?php echo $searchLog['Ip']['City']['name']; ?>    </p>
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
		<td colspan="6"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Search Logs available');?></p></div></td>
	</tr>
<?php
endif;
?>
</table>
</div>

<?php
if (!empty($searchLogs)) {  ?>
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
	}
    echo $this->Form->end();
    ?>
</div>