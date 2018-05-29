<div class="messages index js-response js-responses">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active"><?php echo __l('Messages'); ?></li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
   <div class="clearfix">
	<?php 
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Suspend) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Suspended messages').'">'.__l('Suspended messages').'</dt>
						<dd title="'.$this->Html->cInt($suspended ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($suspended ,false).'</dd>                  	
					</dl>'
					, array('action'=>'index','filter_id' => ConstMoreAction::Suspend), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Flagged) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('System flagged  messages').'">'.__l('System flagged  messages').'</dt>
						<dd title="'.$this->Html->cInt($system_flagged ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($system_flagged ,false).'</dd>                  	
					</dl>'
					, array('action'=>'index','filter_id' => ConstMoreAction::Flagged), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (empty($this->request->params['named']['filter_id'])) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Total messages').'">'.__l('Total messages').'</dt>
						<dd title="'.$this->Html->cInt($all ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt( $all,false).'</dd>                  	
					</dl>'
					, array('action'=>'index'), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				
				?>
				</div><div class="clearfix dl">
					<?php
							echo $this->Form->create('Message' , array('action' => 'admin_index', 'type' => 'post', 'class' => 'normal search-form clearfix ')); //js-ajax-form
						?>
						<?php
							echo "<span class='hor-space'>".$this->Form->input('filter_id', array('type' =>'hidden'));
							echo $this->Form->autocomplete('Message.username', array('label'=>false,'div'=>false,'placeholder' => __l('From'), 'acFieldKey' => 'Message.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255', 'class' => 'span5'))."</span>";
							echo "<span class='hor-space'>".$this->Form->autocomplete('Message.other_username', array('label'=>false,'div'=>false,'placeholder'=> __l('To'), 'acFieldKey' => 'Message.other_user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255', 'class' => 'span5'))."</span>";
							echo "<span class='hor-space'>".$this->Form->autocomplete('Property.title', array('label'=>false,'div'=>false,'placeholder'=>__l('Property'), 'acFieldKey' => 'Property.id', 'acFields' => array('Property.title'), 'acSearchFieldNames' => array('Property.title'), 'maxlength' => '255', 'class' => 'span5'))."</span>";

						?>
						<?php echo $this->Form->submit(__l('Filter'), array('class'=>'btn btn-large hor-mspace btn-primary textb text-16'));?>
						<?php echo $this->Form->end();?>
				</div>
			
     
 </div>
	   <?php echo $this->element('paging_counter');?>
   
<?php echo $this->Form->create('Message' , array('class' => 'normal','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
	<th class="dc sep-right">Select</th>
	<th class="sep-right dc"><?php echo __l('Action');?></th>
	<th class="dl sep-right"><?php echo __l('Subject'); ?></th>
	<th class="dl sep-right"><?php echo __l('Property'); ?></th>
	<th class="dl sep-right"><?php echo __l('From'); ?></th>
	<th class="dl sep-right"><?php echo __l('To'); ?></th>
	<th class="dc sep-right"><?php echo __l('Date'); ?></th>
</tr></thead><tbody>
<?php
if (!empty($messages)) :
$i = 0;
foreach($messages as $message):
   // if empty subject, showing with (no suject) as subject as like in gmail
    if (!$message['MessageContent']['subject']) :
		$message['MessageContent']['subject'] = '(no subject)';
    endif;
	if ($i++ % 2 == 0) :
		$row_class = 'row';
	else :
		$row_class = 'altrow';
    endif;
	
	$message_class = "checkbox-message ";
	
	$is_read_class = "";
	
    if ($message['Message']['is_read']) :
        $message_class .= "js-checkbox-active";
    else :
        $message_class .= "js-checkbox-inactive";
        $is_read_class .= "unread-message-bold";
        $row_class=$row_class.' unread-row tb';
    endif;
	$row_class='class="'.$row_class.'"';

	$row_three_class='w-three';
	 if (!empty($message['MessageContent']['Attachment'])):
			$row_three_class.=' has-attachment';
	endif;
	
	if($message['MessageContent']['admin_suspend']):
		$message_class.= ' js-checkbox-suspended';
	else:
		$message_class.= ' js-checkbox-unsuspended';
	endif;
	if(isset($message['MessageContent']['is_system_flagged'])&& $message['MessageContent']['is_system_flagged'] ):
		$message_class.= ' js-checkbox-flagged';
	else:
		$message_class.= ' js-checkbox-unflagged';
	endif;
	
		$view_url=array('controller' => 'messages','action' => 'v',$message['Message']['id'], 'admin' => false);
?>
    <tr>

		<td class="w-one dc">
				<?php echo $this->Form->input('Message.'.$message['MessageContent']['id'], array('type' => 'checkbox', 'id' => 'admin_checkbox_'.$message['Message']['id'], 'label' => "", 'div' => 'top-space', 'class' => $message_class.' js-checkbox-list'));?>
		</td>
		
		<td class="dc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
                            <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action'=>'delete', $message['Message']['id']), array('escape'=>false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
			 <?php if($message['MessageContent']['admin_suspend']):?>
				<li><?php echo $this->Html->link('<i class="icon-repeat"></i>'.__l('Unsuspend Message'), array('action' => 'admin_update_status', $message['MessageContent']['id'], 'flag' => 'unsuspend'), array('escape'=>false,'class' => 'unsuspend js-delete', 'title' => __l('Unsuspend Message')));?>
				</li>
			<?php else:?>
					<li><?php echo $this->Html->link('<i class="icon-off"></i>'.__l('Suspend Message'), array('action' => 'admin_update_status', $message['MessageContent']['id'], 'flag' => 'suspend'), array('escape'=>false,'class' => 'suspend js-delete', 'title' => __l('Suspend Message')));?>
					</li>
			<?php endif;?>
			<?php 
				if(isset($message['MessageContent']['is_system_flagged']) && $message['MessageContent']['is_system_flagged']):
					echo '<li>'.$this->Html->link('<i class="icon-remove-circle"></i>'.__l('Clear flag'), array('action' => 'admin_update_status', $message['MessageContent']['id'], 'flag' => 'deactivate'), array('escape'=>false,'class' => 'clear-flag js-delete', 'title' => __l('Clear flag'))).'</li>';
				else:
					echo '<li>'.$this->Html->link('<i class="icon-flag"></i>'.__l('Flag'), array('action' => 'admin_update_status', $message['MessageContent']['id'], 'flag' => 'active'), array('escape'=>false,'class' => ' flag js-delete', 'title' => __l('Flag'))).'</li>';
				endif;
			?>
			 </ul>
        							</span>
        						
		</td>
		
        <td  class="dl <?php echo $row_three_class;?>">
          <div class="clearfix">
				 <div class="htruncate js-bootstrap-tooltip span5" title="<?php echo $message['MessageContent']['subject'];?>">
			     <?php  echo $this->Html->link($message['MessageContent']['subject'] . ' - ' . substr(trim(strip_tags($message['MessageContent']['message'])), 0, Configure::read('messages.content_length')) ,$view_url, array('class' => 'js-no-pjax'));?>
				 </div>
				 <div class="clearfix">
            	<?php if($message['MessageContent']['admin_suspend']): ?>
				<div>
				<?php	echo '<span class="label suspended" title="Admin Suspended">'.__l('Admin Suspended').'</span>'; ?>
				<?php endif; ?>
				</div>
    			<?php if(isset($message['MessageContent']['is_system_flagged']) && $message['MessageContent']['is_system_flagged']): ?>
				<div>
    			<?php echo '<span class="label system-flagged"  title="System Flagged">'.__l('System Flagged').'</span>'; ?>
				</div>
    			<?php endif; ?>
            </div>
               <?php
               if (!empty($message['Label'])):
					?>
					<ul class="message-label-list">
						<?php foreach($message['Label'] as $label): ?>
							<li>
								<span class="htruncate js-bootstrap-tooltip span5"><?php echo $this->Html->cText($label['name'], false);?></span>
							</li>
						<?php
						endforeach;
					?>
					</ul>
					<?php
                endif;
			?>
        </td>
		
		<td class="dl">
		<div class="htruncate js-bootstrap-tooltip span5" title="<?php echo $message['Property']['title'];?>">
			<?php
				if(!empty($message['Property']['title'])):
					echo $this->Html->link($message['Property']['title'], array('controller' => 'properties', 'action' => 'view', $message['Property']['slug'], 'admin' => false), array('title' => $this->Html->cText($message['Property']['title'], false), 'class' => 'js-no-pjax', 'escape' => false));
				else:
					echo '-';
				endif;
			?>
			</div>
		</td>	
		

            <td class="w-two dl <?php  echo $is_read_class;?>">
				<span class="user-name-block c1">
					<?php echo $this->Html->link($this->Html->cText($message['User']['username']), array('controller' => 'users', 'action' => 'view', $message['User']['username'], 'admin' => false), array('title' => $message['User']['username'], 'class' => 'js-no-pjax', 'escape' => false));?>
				</span>
                <div class="clear"></div>
            </td>
			<td class="w-two dl <?php  echo $is_read_class;?>">
				<span class="user-name-block c1">
					<?php echo $this->Html->link($this->Html->cText($message['OtherUser']['username']), array('controller' => 'users', 'action' => 'view', $message['OtherUser']['username'], 'admin' => false), array('title' => $message['OtherUser']['username'], 'class' => 'js-no-pjax', 'escape' => false));?>
				</span>
                <div class="clear"></div>
            </td>

        <td class="w-four dc<?php echo $is_read_class;?>"><?php echo $this->Html->cDateTimeHighlight($message['Message']['created']);?></td>
    </tr>
<?php
    endforeach;
else :
?>
<tr>
    <td colspan="8"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Messages available') ?></p></div></td>
</tr>
<?php
endif;
?>
</table>
<?php
if (!empty($messages)):
        ?>
        <div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
                        <?php echo __l('Select:'); ?></span>
			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
			<?php echo $this->Html->link(__l('Flagged'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-flagged","unchecked":"js-checkbox-unflagged"} hor-smspace grayc', 'title' => __l('Flagged'))); ?>
			<?php echo $this->Html->link(__l('Unflagged'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-unflagged","unchecked":"js-checkbox-flagged"} hor-smspace grayc', 'title' => __l('Unflagged'))); ?>
			<?php echo $this->Html->link(__l('Suspended'), '#', array('class' => 'js-select js-no-pjax	{"checked":"js-checkbox-suspended","unchecked":"js-checkbox-unsuspended"} hor-smspace grayc', 'title' => __l('Suspended'))); ?>
			<?php echo $this->Html->link(__l('Unsuspended'), '#', array('class' => 'js-select js-no-pjax	{"checked":"js-checkbox-unsuspended","unchecked":"js-checkbox-suspended"} hor-smspace grayc', 'title' => __l('Unsuspended'))); ?>
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
    echo $this->Form->end();
    ?>
</div>