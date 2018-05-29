<?php /* SVN: $Id: admin_index.ctp 71528 2011-11-15 16:48:55Z anandam_023ac09 $ */ ?>
<div class="translations index">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Translations               </li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
<div class="add-block dr">
	<?php echo $this->Html->link('<i class="icon-plus-sign"></i>' . __l('Make New Translation'), array('controller' => 'translations', 'action' => 'add'), array('class' => 'add right-mspace', 'title'=>__l('Make New Translation'), 'escape' => false)); ?>
	<?php echo $this->Html->link('<i class="icon-plus-sign"></i>' . __l('Add New Text'), array('controller' => 'translations', 'action' => 'add_text'), array('class' => 'add', 'title'=>__l('Add New Text'), 'escape' => false)); ?>
</div>
<?php
if (empty($translations)): ?>
<div class = "page-info">
	<?php echo __l('Sorry, in order to translate, default English strings should be extracted and available. Please contact support.');?>
</div>
<?php endif; ?>
 <div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
		<th class="dc sep-right span2"><?php echo __l('Actions');?></th>
		<th class="dl sep-right"><?php echo __l('Language');?></th>
		<th class="dc sep-right"><?php echo __l('Verified');?></th>
		<th class="dc sep-right"><?php echo __l('Not Verified');?></th>
		
    </tr></thead><tbody>
<?php
if (!empty($translations)):

$i = 0;
foreach ($translations as $language_id => $translation):
	$class = null;
	if ($i++ % 2 == 0):
		$class = ' class="altrow"';
    endif;
?>
	<tr<?php echo $class;?>>
	<td class="dc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">        			
					<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Manage'), array('action' => 'manage', 'language_id' => $language_id), array('escape' => false,'class' => 'edit js-edit', 'title' => __l('Manage')));?></li>
        			<li><?php if($language_id != '42'): echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'index', 'remove_language_id' => $language_id), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete'))); endif;?></li>
			   </ul>
							 </span>
 	</td>
		<td class="dl"><?php echo $this->Html->cText($translation['name']);?></td>
		
		<td class="dc"><?php
			if($translation['verified']){
				echo $this->Html->link($translation['verified'], array('action' => 'manage', 'filter' => 'verified', 'language_id' => $language_id),array('class'=>'js-no-pjax'));
			} else {
				echo $this->Html->cText($translation['verified']);
			}
			?>
		</td>
		<td class="dc"><?php
			if($translation['not_verified']){
				echo $this->Html->link($translation['not_verified'], array('action' => 'manage', 'filter' => 'unverified', 'language_id' => $language_id),array('class'=>'js-no-pjax'));
			} else {
				echo $this->Html->cText($translation['not_verified']);
			}
			;?></td>
			
		
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Translations available');?></p></div></td>
	</tr>
<?php
endif;
?></tbody>
</table>
</div>