<div class="messages index">
<?php echo $this->element('message_message-left_sidebar', array('config' => 'sec'));?>
<div class="mail-side-two">
<?php echo $this->element('mail-search', array('config' => 'sec')); ?>
<div class="mail-main-curve">
<?php
echo $this->Form->create("Message", array('action' => 'search'));
echo $this->Form->hidden('search', array('value' => $this->request->data['Message']['search'], 'name' => 'data[Message][search]'));
echo $this->Form->hidden('from', array('value' => $this->request->data['Message']['from'], 'name' => 'data[Message][from]'));
echo $this->Form->hidden('to', array('value' => $this->request->data['Message']['to'], 'name' => 'data[Message][to]'));
echo $this->Form->hidden('subject', array('value' => $this->request->data['Message']['subject'], 'name' => 'data[Message][subject]'));
echo $this->Form->hidden('search_by', array('value' => $this->request->data['Message']['search_by'], 'name' => 'data[Message][search_by]'));
echo $this->Form->hidden('has_the_words', array('value' => $this->request->data['Message']['has_the_words'], 'name' => 'data[Message][has_the_words]'));
echo $this->Form->hidden('doesnt_have', array('value' => $this->request->data['Message']['doesnt_have'], 'name' => 'data[Message][doesnt_have]'));
echo $this->Form->hidden('has_attachment', array('value' => $this->request->data['Message']['subject'], 'name' => 'data[Message][has_attachment]'));
echo $this->Form->hidden('from_date', array('value' => $this->request->data['Message']['from_date'], 'name' => 'data[Message][from_date]'));
echo $this->Form->hidden('to_date', array('value' => $this->request->data['Message']['to_date'], 'name' => 'data[Message][to_date]'));
?>
<div class="inbox-top-curve"></div>
<div class="inbox-center-curve">
  <h2><?php echo __l('Search results'); ?></h2></div>
	<div class="inbox-right-curve"></div>
	<div class="mail-main-center">
	  	<div class="mail-top-bg" >
	  		<div class="mail-top-bg-button mar-top">
<?php
echo $this->Form->submit('archive-button.png', array('name' => 'data[Message][Archive]'));
echo $this->Form->submit('report-spam-button.png', array('name' => 'data[Message][ReportSpam]'));
echo $this->Form->submit('js-admin-action.png', array('name' => 'data[Message][Delete]'));
?>
			</div>
			<div class="mail-top-bg-select mar-top" >
<?php
echo $this->Form->input('More Actions', array('type' => 'select', 'options' => $more_option, 'name' => 'data[Message][more_action_1]', 'label' => false, 'class' => 'js-apply-message-action-search'));
?>
            </div>
			<div class="inbox-pagging mar-top">
			   	<span class="txt-bold">
<?php if (!empty($messages)) :
    echo $this->element('paging_links');
endif;
?>
				</span>
			</div>
		<div class="clear"></div>
    <div class="select-block inbox-option select-block">
<?php echo __l('Select:'); ?>
		<span class="message-link js-select-all"><?php echo __l('All,'); ?></span>
		<span class="message-link js-select-none"><?php echo __l('None,'); ?></span>
		<span class="message-link js-select-read"><?php echo __l('Read,'); ?></span>
		<span class="message-link js-select-unread"><?php echo __l('Unread,'); ?></span>
		<span class="message-link js-select-starred"><?php echo __l('Starred,'); ?></span>
		<span class="message-link js-select-unstarred"><?php echo __l('Unstarred'); ?></span>
	</div>
</div>
<div class="mail-body">
<table class="list">
<?php
if (isset($hasattachment) and $hasattachment == 1) :
    if (!empty($messages)) :
        foreach($messages as $message => $message_attachment) :
            if (!empty($message_attachment['MessageContent']['Attachment'])) :
                $temp_message[] = $message_attachment;
            endif;
        endforeach;
        $messages = $temp_message;
    endif;
endif;
if (!empty($messages)) :
    $i = 0;
    foreach($messages as $message) :
        if ($i++ % 2 == 0) :
            $row_class = ' class="row"';
        else :
            $row_class = ' class="altrow"';
        endif;
        $message_class = "checkbox-message ";
        $is_read_class = "";
        $is_starred_class = "star";
        if ($message['Message']['is_read']) :
            $message_class.= " checkbox-read ";
        else :
            $message_class.= " checkbox-unread ";
            $is_read_class.= "unread-message-bold";
            $row_class = ' class="unread-row tb"';
        endif;
        if ($message['Message']['is_starred']) :
            $message_class.= " checkbox-starred ";
            $is_starred_class = " star-select";
        else :
            $message_class.= " checkbox-unstarred ";
        endif;
?>
  <tr<?php echo $row_class; ?>>
		<td class="w-one">
<?php
	echo $this->Form->input("Message.Id." . $message['Message']['id'], array(
            'type' => 'checkbox',
            'id' => "Message_" . $message['Message']['id'],
            'label' => false,
            'class' => $message_class
        ));
?>
		</td>
		<td class="w-two <?php echo $is_read_class; ?>">
<?php if ($message['Message']['message_folder_id'] == ConstMessageFolder::Drafts) : ?>
			<span><?php echo __l('Drafts'); ?></span>
<?php endif; ?>
			<span class="<?php echo $is_starred_class; ?>">
<?php
        echo $this->Html->link(__l('Star') , array(
            'controller' => 'messages',
            'action' => 'star',
            $message['Message']['id'],
            $is_starred_class
        ) , array(
            'class' => 'change-star-unstar'
));
?>
			</span>
            <span class="c1">
<?php
        if ($message['Message']['is_sender'] == 1) :
            echo $this->Html->link(__l('me') , array(
                'controller' => 'messages',
                'action' => 'view',
                $message['Message']['hash']
            ) , array());
        else :
            echo $this->Html->link($this->Text->truncate($message['OtherUser']['first_name'] . ' ' . $message['OtherUser']['last_name'], 16, '') , '#', array());
        endif;
?>
			</span>
		</td>
		<td class="w-three <?php echo $is_read_class; ?>">
<?php
        if ($message['Message']['message_folder_id'] == ConstMessageFolder::Inbox) : ?>
			<span><?php echo __l('Inbox'); ?></span>
    <?php endif; ?>
			<span class="c" title="one">
<?php
        echo $this->Html->link($this->Text->truncate(($message['MessageContent']['subject'] . ' - ' . substr($message['MessageContent']['message'], 0, Configure::read('messages.content_length'))) , 60, '...') , array(
            'controller' => 'messages',
            'action' => 'view',
            $message['Message']['hash']
        ) , array());
?>
			</span>
		</td>
		<td class="w-four <?php echo $is_read_class; ?>">
			<span class="c">
<?php
        if ($this->Html->convert_maketime($this->Html->change_format($message['Message']['created'], 'Y-m-d')) >= $this->Html->convert_maketime(date('Y-m-d'))) :
            echo $this->Html->change_format($message['Message']['created'], 'g:i a');
        else :
            echo $this->Html->change_format($message['Message']['created'], 'M d');
        endif;
?>
			</span>
		</td>
	</tr>
<?php endforeach;
 else : ?>
	<tr>
		<td colspan = "4">
			<?php echo __l('No messages matched your search.'); ?>
		</td>
	</tr>
<?php endif; ?>
</table>
</div>
</div>
<div class="mail-curve-bottom-left"></div>
<div class="inbox-option-bottom-center pad-top" >
<div class="mail-top-bg-button ">
<?php echo $this->Form->submit('archive-button.png', array(
    'name' => 'data[Message][Archive]'
));
echo $this->Form->submit('report-spam-button.png', array(
    'name' => 'data[Message][ReportSpam]'
));
echo $this->Form->submit('js-admin-action.png', array(
    'name' => 'data[Message][Delete]'
));
?>
</div>
<div class="mail-top-bg-select ">
<?php
echo $this->Form->input('more_action_2', array(
    'type' => 'select',
    'options' => $more_option,
    'label' => false,
    'class' => 'js-apply-message-action-search'
));
?>
</div>
<div class="inbox-pagging ">
    <span class="txt-bold">
<?php
if (!empty($messages)) :
    echo $this->element('paging_links');
endif; ?>
	</span>

</div>
<div class="clear"></div>
<div class="select-block inbox-option select-block">
<?php echo __l('Select:'); ?>
	<span class="message-link js-select-all"><?php echo __l('All,'); ?></span>
	<span class="message-link select-none"><?php echo __l('None,'); ?></span>
	<span class="message-link select-read"><?php echo __l('Read,'); ?></span>
	<span class="message-link select-unread"><?php echo __l('Unread,'); ?></span>
	<span class="message-link select-starred"><?php echo __l('Starred,'); ?></span>
	<span class="message-link select-unstarred"><?php echo __l('Unstarred'); ?></span>
</div>
</div>
<div class="mail-curve-bottom-right"></div>
<?php echo $this->Form->end();?>
</div>
</div>
</div>