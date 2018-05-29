<?php /* SVN: $Id: add.ctp 40929 2011-01-11 12:15:19Z ramkumar_136act10 $ */ ?>
<div class="userComments form js-ajax-form-container bot-space">
    <div class="userComments-add-block js-corner round-5">
        <?php echo $this->Form->create('UserComment', array('action'=>'add','class' => "normal comment-form clearfix  hor-space no-mar js-comment-form {container:'js-ajax-form-container',responsecontainer:'js-responses'}"));?>
        	<div class="text textarea pull-left">

				<label class="text-16 graydarkc bot-mspace"><?php 
					if(!empty($user['User']['username'])):
						echo __l('Add your recommendation for ').$user['User']['username']; 
					else:
						echo __l('Add your recommendation'); 
					endif;
				?></label>

        	<?php
        		echo $this->Form->input('user_id', array('type' => 'hidden'));
        		echo $this->Form->input('comment', array('type' => 'textarea','label' =>false,'class'=>'span23 space pull-right','rows'=>3));
        	?>
        	</div>
<div class="submit-block clearfix">
<?php
	echo $this->Form->submit(__l('Add'),array('class'=>'btn btn-large ver-mspace btn-primary textb ','div'=>array('class'=>'text-16 pull-right')));
?>
</div>
<?php
	echo $this->Form->end();
?>
    </div>
</div>
