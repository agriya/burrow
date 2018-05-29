<?php /* SVN: $Id: $ */ ?>
<div class="requestFlags form js-responses">
<h2><?php echo __l('Flag This Request');?></h2>
<?php echo $this->Form->create('RequestFlag', array('class' => 'normal js-ajax-form flag-form'));?>
	<?php
		if($this->Auth->user('role_id') == ConstUserTypes::Admin):
           echo $this->Form->input('user_id', array('empty' => __l('Select')));
        endif;
			 echo $this->Form->input('Request.id',array('type'=>'hidden'));
		echo $this->Form->input('request_flag_category_id', array('label' => __l('Category')));
		echo $this->Form->input('message', array('label' => __l('Message')));
    ?>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Submit'));?>
	</div>
    <?php echo $this->Form->end();?>
</div>