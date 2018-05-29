<div class="mail-right-block js-response">						
<?php
	if ($is_starred == 1) :
		$folder_type = 'Starred';
	endif;
?>
<div class ="ver-space clearfix sep-bot top-mspace ">
	<h2 class="text-32 span"><?php echo sprintf(__l('My %s Messages'), ucfirst($folder_type));?></h2>
</div>
 <section class="row top-space top-mspace">	
 <aside>
 <?php echo $this->element('message_message-left_sidebar', array('config' => 'sec')); ?>
 </aside>
 <?php if (!empty($messages)) { ?>
<section class="span bot-mspace user-dashboard sep mob-sep-none mob-no-pad message-block tab-no-mar">
<?php }else{ ?>
<section class="span22 bot-mspace user-dashboard sep mob-sep-none mob-no-pad message-block tab-no-mar">
<?php } ?>
<?php echo $this->Form->create('Message', array('action' => 'move_to', 'class' => 'normal')); ?>
<?php
$refresh_folder_type = $folder_type;
if ($folder_type == 'draft') $refresh_folder_type = 'drafts';
if ($folder_type == 'sent') $refresh_folder_type = 'sentmail';
echo $this->Form->hidden('folder_type', array('value' => $folder_type, 'name' => 'data[Message][folder_type]'));
echo $this->Form->hidden('is_starred', array('value' => $is_starred, 'name' => 'data[Message][is_starred]'));
?>


<table class="table table-striped table-hover">
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
	$is_starred_class = "grayc icon-star-empty";
	$param	=	1;
    if ($message['Message']['is_read']) :
        $message_class .= " checkbox-read ";
    else :
        $message_class .= " checkbox-unread ";
        $is_read_class .= " textb ";
        $row_class=$row_class.' unread-row tb';
    endif;
    if ($message['Message']['is_starred']):
        $message_class .= " checkbox-starred ";
        $is_starred_class = "icon-star";
		$param	=	0;
    else:
        $message_class .= " checkbox-unstarred ";
    endif;
	$row_class='class="'.$row_class.'"';

	$row_three_class='w-three';
	 if (!empty($message['MessageContent']['Attachment'])):
			$row_three_class.=' has-attachment';
	endif;
if ($folder_type == 'draft'):
	$view_url=array('controller' => 'messages','action' => 'compose',$message['Message']['id'],'draft');
else:
	$view_url=array('controller' => 'messages','action' => 'v',$message['Message']['id']);
endif;

?>
    <tr>
		<td class="space span4 textb grayc ">
				<span>
					<?php echo $this->Html->link('<i class="'.$is_starred_class.' text-14"></i>' , array('controller' => 'messages', 'action' => 'star', $message['Message']['id'], $param) , array('escape'=>false, 'class' => 'change-star-unstar js-like js-no-pjax'));?>
				</span>
				<span class="user-name-block pull-right span3 htruncate js-bootstrap-tooltip" title="<?php echo $this->Html->cText($message['OtherUser']['username'], false);?>">
                    <?php
                    if ($message['Message']['is_sender'] == 1) :
                        echo $this->Html->link(__l('To: ') . $this->Html->cText($message['OtherUser']['username'], false) , $view_url);
                    elseif ($message['Message']['is_sender'] == 2) :
                        echo $this->Html->link(__l('Me   : ') , $view_url, array('escape'=>false, 'class' => 'grayc'));
                    else:
                        echo $this->Html->link($this->Html->cText($message['OtherUser']['username'], false), $view_url, array('escape'=>false, 'class' => 'grayc '));
                    endif;
                    ?>
				</span>
                <div class="clear"></div>
            </td>
        <td  class=" grayc span14 <?php echo $row_three_class;?> <?php  echo $is_read_class;?>">
			<?php 
				echo $this->Html->link($this->Html->cText($message['MessageContent']['subject'] . ' - ' . substr(trim(strip_tags($message['MessageContent']['message'])), 0, Configure::read('messages.content_length')), false), $view_url, array('escape'=>false, 'class' => 'grayc span16 htruncate'));?>
        </td>
        <td  class="grayc w-four <?php echo $is_read_class;?>"><?php echo $this->Html->cDateTimeHighlight($message['Message']['created']);?></td>
    </tr>
<?php
    endforeach;
else :
?>
<tr>
    <td colspan="4">
	  <div class="space dc grayc">
		<p class="ver-mspace top-space text-16 "><?php echo __l('No') ?> <?php echo $folder_type; ?> <?php echo __l('Messages available') ?></p>
	  </div>
	</td>
</tr>
<?php
endif;
?>
</table>
<div class="clearfix">
<div class="span4 pull-left bot-space">
<?php
	if (!empty($is_starred)) :
		echo $this->Html->link('<i class="icon-refresh text-16 no-pad"></i>'.__l(' Refresh') , array('controller' => 'messages', 'action' => 'starred'),array('escape'=>false, 'class' => 'refresh whitec btn btn-large btn-primary', 'title' => __l('Refresh')));
	else:
		echo $this->Html->link('<i class="icon-refresh text-16 no-pad"></i>'.__l(' Refresh') , array('controller' => 'messages', 'action' => $refresh_folder_type), array('escape'=>false, 'class' => 'refresh whitec btn btn-large btn-primary', 'title' => __l('Refresh')));
	endif;
?>
</div>
    <div class="pull-right hor-space <?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?> mob-clr mob-no-pad">
         <?php
        if (!empty($messages)) :
            echo $this->element('paging_links');
        endif;
        ?>
    </div>
</div>
<?php echo $this->Form->end();?></div>
