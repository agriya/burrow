<?php /* SVN: $Id: $ */ ?>
<div class="propertyFeedbacks index js-response">
<?php if(empty($this->request->params['named']['simple_view'])) : ?>
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Feedback To Host     </li>
            </ul> 
<?php endif; ?>					
            <div class="tabbable ver-space <?php echo (empty($this->request->params['named']['simple_view'])) ? "sep-top" : "";?> top-mspace">
                <div id="list" class="tab-pane active in no-mar">
<?php if(empty($this->request->params['named']['simple_view'])) : ?>				
			<div class="clearfix dc">
					<?php echo $this->Form->create('PropertyFeedback', array('type' => 'get', 'class' => 'form-search bot-mspace big-input span', 'action'=>'index')); ?>
					<?php echo $this->Form->input('q', array('placeholder' => __l('Keyword'),'class'=>'span9 ver-mspace text-16','label' => false)); ?>
					<?php echo $this->Form->submit(__l('Search'), array('class'=>'btn btn-large hor-mspace btn-primary textb text-16'));?>
					<?php echo $this->Form->end(); ?>
					
			</div>
<?php endif; ?>					
			<?php echo $this->element('paging_counter'); ?>
    <?php echo $this->Form->create('PropertyFeedback' , array('class' => 'normal','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>


<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
	    <th class="sep-right dc"><?php echo __l('Select');?></th>
        <?php if(empty($this->request->params['named']['simple_view'])) : ?>
        <th class="sep-right dc span2"><?php echo __l('Actions');?></th>
        <?php endif; ?>
        <th class="dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('created',__l('Created'));?></div></th>
        <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'Property.title',__l('Property'));?></div></th>
        <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username',__l('Host'));?></div></th>
        <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username',__l('Traveler'));?></div></th>
        <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('feedback',__l('Feedback'));?></div></th>
        <th class="dl sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('Ip.ip',__l('IP'));?></div></th>
		<th class="dc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'is_satisfied',__l('Satisfied')); ?></div></th>
    </tr>
<?php if (!empty($propertyFeedbacks)): ?>
<tbody>
<?php 
$i = 0;
foreach ($propertyFeedbacks as $propertyFeedback):
 $class = null;
	if ($i++ % 2 == 0):
		$class = ' class="altrow"';
	endif;
	if($propertyFeedback['PropertyFeedback']['is_satisfied']):
		$status_class = 'js-checkbox-active';
	else:
		$status_class = 'js-checkbox-inactive';
	endif;
?>
	<tr<?php echo $class;?>>
        <?php if(empty($this->request->params['named']['simple_view'])) : ?>
		  <td class="dc"><?php echo $this->Form->input('PropertyFeedback.'.$propertyFeedback['PropertyFeedback']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$propertyFeedback['PropertyFeedback']['id'], 'label' => "", 'div' => 'top-space', 'class' => $status_class.' js-checkbox-list')); ?></td>
        <?php endif; ?>
		 <td class="dc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'edit', $propertyFeedback['PropertyFeedback']['id']), array('escape' => false,'class' => 'edit js-edit', 'title' => __l('Edit')));?></li>
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $propertyFeedback['PropertyFeedback']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
			   </ul>
   	  </span>
		</td>
		
		<td class="dc"><?php echo $this->Html->cDateTimeHighlight($propertyFeedback['PropertyFeedback']['created']);?></td>
		<td class="dl"><div class="htruncate js-bootstrap-tooltip span5" title="<?php echo $propertyFeedback['Property']['title'];?>" ><?php echo $this->Html->link($this->Html->cText($propertyFeedback['Property']['title'],false), array('controller'=> 'propertys', 'action'=>'view', $propertyFeedback['Property']['slug'], 'admin' => false), array('class'=>'js-no-pjax','escape' => false));?></div></td>
		<td class="dl">
		<?php 
		if(isset($propertyFeedback['Property']['User'])){
			echo $this->Html->link($this->Html->cText($propertyFeedback['Property']['User']['username']), array('controller'=> 'users', 'action'=>'view', $propertyFeedback['Property']['User']['username'], 'admin' => false), array('class'=>'js-no-pjax', 'title' => $this->Html->cText($propertyFeedback['Property']['User']['username'], false), 'escape' => false));
		}
		?>
		</td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($propertyFeedback['PropertyUser']['User']['username']), array('controller'=> 'users', 'action'=>'view', $propertyFeedback['PropertyUser']['User']['username'], 'admin' => false), array('class'=>'js-no-pjax', 'title' => $this->Html->cText($propertyFeedback['PropertyUser']['User']['username'], false), 'escape' => false));?></td>
		<td class="dl"> <div class="htruncate span5 js-bootstrap-tooltip" title="<?php echo $this->Html->cText($propertyFeedback['PropertyFeedback']['feedback'], false); ?>"><?php echo $this->Html->cText($propertyFeedback['PropertyFeedback']['feedback']);?></td>
		<td class="dl">
		  <?php if(!empty($propertyFeedback['Ip']['ip'])): ?>
                            <?php echo  $this->Html->link($propertyFeedback['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $propertyFeedback['Ip']['ip'], 'admin' => false), array('class'=>'js-no-pjax','target' => '_blank', 'title' => 'whois '.$propertyFeedback['Ip']['host'], 'escape' => false));
							?>
								<div>
							<?php
                            if(!empty($propertyFeedback['Ip']['Country'])):
                                ?>
                                <span class="flags flag-<?php echo strtolower($propertyFeedback['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $propertyFeedback['Ip']['Country']['name']; ?>">
									<?php echo $propertyFeedback['Ip']['Country']['name']; ?>
								</span>
                                <?php
                            endif;
							 if(!empty($propertyFeedback['Ip']['City'])):
                            ?>
                            <p class="htruncate js-bootstrap-tooltip span2 inline" title="<?php echo $propertyFeedback['Ip']['City']['name'];?>"><?php echo $propertyFeedback['Ip']['City']['name'];?>     </p>
                            <?php endif; ?></div>
                            
                        <?php else: ?>
							<?php echo __l('N/A'); ?>
						<?php endif; ?>
			
		</td>
		<td class="dc"><?php echo $this->Html->cBool($propertyFeedback['PropertyFeedback']['is_satisfied']);?></td>
	</tr>
<?php
    endforeach;
?>
</tbody>
<?php 	
else:
?>
	<tr>
		<td colspan="9"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Feedbacks available');?></p></div></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($propertyFeedbacks)):
        ?>
        <div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
	   <?php if(empty($this->request->params['named']['simple_view'])) : ?>
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