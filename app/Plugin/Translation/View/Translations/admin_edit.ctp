<?php /* SVN: $Id: admin_edit.ctp 63884 2011-08-22 09:47:12Z arovindhan_144at11 $ */ ?>
<div class="translations form">
<?php echo $this->Form->create('Translation', array('class' => 'form-horizontal space'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('language_id');
		echo $this->Form->input('key');
		echo $this->Form->input('lang_text');
	?>
	</fieldset>
   <div class="form-actions">
            <?php
            	echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16'));
            ?>
            </div>
        <?php
        	echo $this->Form->end(); ?>
</div>
