<?php /* SVN: $Id: admin_add.ctp 68881 2011-10-13 09:47:54Z josephine_065at09 $ */ ?>
<div class="translations form">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link( 'Translations', array('action'=>'index'), array('escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Add Translation          </li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
<?php echo $this->Form->create('Translation', array('class' => 'form-horizontal space'));?>
	<fieldset>
	<?php
		echo $this->Form->input('from_language', array('value' => __l('English'), 'disabled' => true));
		echo $this->Form->input('language_id', array('label' => __l('To Language')));?>
       
        <?php
		if(Configure::read('google.translation_api_key')): 
			$disabled = false;
		else:
			$disabled = true;
		endif; ?>
		<div class="clearfix translation-index-block">
			<div class="translation-left-block  ">
				<div class="clearfix">
        		<?php
        		echo $this->Form->submit('Manual Translate', array('name' => 'data[Translation][manualTranslate]','class'=>'btn btn-large hor-mspace btn-primary textb text-16'));
        		?>
				</div>
    	         <div class="alert alert-info"><?php echo __l('It will only populate site labels for selected new language. You need to manually enter all the equivalent translated labels.');?>
                    </div>
                
            </div>
            <div class="translation-right-block  ">
				<div class="clearfix">
                <?php echo $this->Form->submit('Google Translate', array('name' => 'data[Translation][googleTranslate]', 'disabled' => $disabled,'class'=>'btn btn-large hor-mspace btn-primary textb text-16'));	?>
				</div>
                <span class="info"><i class="grayc icon-info-sign"></i><?php echo __l('It will automatically translate site labels into selected language with Google. You may then edit necessary labels.');?> </span>
               <?php if(!Configure::read('google.translation_api_key')): ?>
                    <div class="error-notice alert alert-info">
                    	<p><?php echo __l('Google Translate service is currently a paid service and you\'d need API key to use it.');?><?php echo __l('Please enter Google Translate API key in ');
                    	echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'plugin_settings', 'Translation'), array('title' => __l('Settings'))). __l(' page');?>
                	</p>
                	</div>
                <?php endif; ?>
        	</div>
	</div>
	</fieldset>
<?php echo $this->Form->end();?>
</div>
</div>
</div>

