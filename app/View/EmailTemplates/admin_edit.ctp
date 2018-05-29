<div class="js-responses">
	<h3 class="well space textb text-16 no-mar"><?php echo $this->Html->cText($this->request->data['EmailTemplate']['name'], false); ?></h3>
    <?php
    	echo $this->Form->create('EmailTemplate', array('id' => 'EmailTemplateAdminEditForm'.$this->request->data['EmailTemplate']['id'], 'class' => 'form-horizontal space js-insert js-ajax-form', 'action' => 'edit'));
        ?>    
    <?php
    	echo $this->Form->input('id');
    	echo $this->Form->input('from', array('id' => 'EmailTemplateFrom'.$this->request->data['EmailTemplate']['id'], 'info' => __l('(eg. "displayname &lt;email address>")')));
    	echo $this->Form->input('reply_to', array('id' => 'EmailTemplateReplyTo'.$this->request->data['EmailTemplate']['id'], 'info' => __l('(eg. "displayname &lt;email address>")')));
    	echo $this->Form->input('subject', array('class' => 'js-email-subject', 'id' => 'EmailTemplateSubject'.$this->request->data['EmailTemplate']['id']));
    	echo $this->Form->input('email_text_content');
    	echo $this->Form->input('email_content', array('class' => 'js-email-content', 'id' => 'EmailTemplateEmailContent'.$this->request->data['EmailTemplate']['id']));
    ?>
    <div class="form-actions">
        <?php
            echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16'));
        ?>
    </div>
    <?php
        echo $this->Form->end();
    ?>
</div>