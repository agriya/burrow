<?php /* SVN: $Id: edit.ctp 4895 2010-05-13 08:49:37Z josephine_065at09 $ */ ?>
<?php
 if ((isset($this->request->params['prefix']) and $this->request->params['prefix'] == 'admin')) {
?>
<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Users'), array('controller'=>'users','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Edit User Profile'); ?></li>
</ul>
<?php
	}
?>
<div class="userProfiles userprofiles-form form space sep-top">
	<?php if (empty($this->request->params['prefix'])): ?>
		<h2 class="ver-space bot-mspace sep-bot clearfix text-32"><?php echo __l('Edit Profile'); ?></h2>
	    <div class="side1 ">
	<?php endif; ?>
    	<?php echo $this->Form->create('UserProfile', array('url'=>array('controller'=>'user_profiles','action' => 'edit',$this->request->data['User']['id']), 'class' => 'form-horizontal space check-form js-add-map', 'enctype' => 'multipart/form-data'));?>
       <fieldset>
	   <h3 class="well space textb text-16 no-mar"><?php echo __l('Profile'); ?></h3>
	   <div class="span3 pull-right space mob-clr"> 
		<div class="profile-image">
				<?php $this->request->data['User']['UserAvatar'] = !empty($this->request->data['User']['UserAvatar']) ? $this->request->data['User']['UserAvatar'] : array(); ?>
                <?php
					echo $this->Html->getUserAvatar($this->request->data['User'], 'big_thumb', true);
				?>
				<?php if(isPluginEnabled('SocialMarketing')) {
						echo $this->Html->link(__l('Change Image'), array('controller' => 'user_profiles', 'action' => 'profile_image',$this->request->data['User']['id'], 'admin' 
						=> false), array('class' => 'show dc')); 
					}
				?>
    		</div>
	   </div>
	   <div class="span17 top-mspace pull-left space"> 
			
    		<?php
    		   $required="required";
    			if($this->Auth->user('role_id') == ConstUserTypes::Admin):
    			 $required="required";
    				echo $this->Form->input('User.id', array('label' => __l('User')));
    			endif;
    			if($this->request->data['User']['role_id'] == ConstUserTypes::Admin):
    				echo $this->Form->input('User.username',array('readonly' => 'readonly'));
    			endif;
    			if($this->Auth->user('role_id') == ConstUserTypes::Admin):
    				echo $this->Form->input('User.email', array('label' => __l('Email')));
    			endif;
    			    echo $this->Form->input('first_name', array('label' => __l('First Name')));
            		echo $this->Form->input('last_name', array('label' => __l('Last Name')));
            		echo $this->Form->input('middle_name', array('label' => __l('Middle Name')));
					echo $this->Form->input('gender_id', array('empty' => __l('Please Select'), 'label'=>__l('Gender'), 'id' => 'js-gender')); 
			?>
					<div class="input select profile-dob-block">
						<div class="js-datetime <?php if($this->Auth->user('role_id') != ConstUserTypes::Admin) { ?> required <?php } ?>">
							<div class="js-cake-date">
								<?php echo $this->Form->input('dob', array('label' => __l('DOB'),'empty' => __l('Please Select'), 'div' => false, 'minYear' => date('Y') - 100, 'maxYear' => date('Y'), 'orderYear' => 'asc')); ?>
							</div>
						</div>
					</div>
					<?php echo $this->Form->input('about_me', array('label' => __l('About Me')));?>
					<?php echo $this->Form->input('user_education_id', array('empty' => __l('Please Select'),'label' => __l('Education'))); ?>
					<?php echo $this->Form->input('user_employment_id', array('empty' =>__l('Please Select'),'label' => __l('Employment Status'))); ?>
					<?php $currecncy_place = '<span class="currency">'.Configure::read('site.currency'). '</span>' ; ?>
					<?php echo $this->Form->input('user_income_range_id', array('empty' => __l('Please Select'),'label' => __l('Income range (').configure::read('site.currency').__l(')'))); ?>
					<?php $options = array('1' => __l('Yes'), '0' => __l('No')); ?>
					<div class="show bot-mspace">
						<label class="pull-left"><?php echo __l('Own Home?'); ?></label>
								<?php echo $this->Form->input('own_home', array('options' => $options, 'type' => 'radio', 'div'=> array('class' => 'input radio no-mar'),  'legend' => false, 'default' => 0)); ?>
					</div>
					<?php echo $this->Form->input('user_relationship_id', array('empty' => __l('Please Select'),'label' => __l('Relationship status'))); ?>
					<div class="show bot-mspace">
						<label class="pull-left"><?php echo __l('Have Children?'); ?></label>
								<?php echo $this->Form->input('have_children', array('options' => $options, 'type' => 'radio',  'div'=> array('class' => 'input radio no-mar'), 'legend' => false, 'default' => 0)); ?>			
					</div>
                	<?php echo $this->Form->input('school', array('label' => __l('School')));
                	echo $this->Form->input('work', array('label' => __l('Work'))); ?>
					<?php if(isPluginEnabled('Properties')){ ?>
						<div class="habit amenities-list">
						<p class="add-info pull-left"><?php echo __l('Habit'); ?></p>
						<?php
						echo $this->Form->input('Habit', array('type'=>'select', 'multiple'=>'checkbox', 'class'=> 'checkbox no-mar', 'id'=>'Habit1', 'label' =>false));
						?>
						</div>					
                    <?php
				    }
                   
    		?>
				<?php 
					 if(!isPluginEnabled('SocialMarketing')) {
						echo $this->Form->input('User.user_avatar_source_id', array('type' => 'hidden', 'value'=> 1));
						echo $this->Form->input('UserAvatar.filename', array('type' => 'file','size' => '33', 'label' => __l('Upload Photo'),'class' =>'browse-field'));
					}
				?>
			
			</div>
    	</fieldset>
       <fieldset>        
			<h3 class="well space textb text-16"><?php echo __l('Contact details'); ?></h3>
				<div class="contact-details result-block pr">
				<div class="mapblock-info pr">
				<?php
					echo $this->Form->input('address', array('label' => __l('Address')));
					echo $this->Form->input('City.name', array('label' => __l('City')));
					echo $this->Form->input('State.name', array('label' => __l('State')));
					echo $this->Form->input('country_id', array('id' => 'js-country_id', 'empty' => 'Please Select', 'selected' => ((!empty($this->request->data['Country']['iso_alpha2']))? $this->request->data['Country']['iso_alpha2'] : '')));
					echo $this->Form->input('zip_code', array('label' => __l('Zip code'), 'id' => 'PropertyPostalCode'));
            		echo $this->Form->input('phone', array('label' => __l('Phone')));
            		echo $this->Form->input('backup_phone', array('label' => __l('Backup Phone')));
				?>
					<div id="mapblock" class="pa">
						<div id="mapframe">
							<div id="mapwindow"></div>
						</div>
					</div>
				</div>
				</div>
    	</fieldset>
    	  <fieldset>
			<h3 class="well space textb text-16"><?php echo __l('Language'); ?></h3>
    		<?php
    			echo $this->Form->input('language_id', array('label' => __l('Language'), 'empty' => __l('Please Select')));
    		?> 
			</fieldset>
		<?php if(isPluginEnabled('SecurityQuestions') && $this->request->data['User']['security_question_id'] == 0 && $this->Auth->user('role_id') != ConstUserTypes::Admin): ?>
<?php if(empty($this->request->data['User']['is_openid_register']) && empty($this->request->data['User']['is_google_register']) && empty($this->request->data['User']['is_yahoo_register']) && empty($this->request->data['User']['is_facebook_register']) && !empty($this->request->data['User']['is_twitter_register']) && empty($this->request->data['User']['is_linkedin_register']) && empty($this->request->data['User']['is_googleplus_register'])):?>
		<fieldset>
			<h3 class="well space textb text-16 no-mar"><?php echo __l('Security Questions'); ?></h3>
    		<div class="alert alert-info clearfix">
        <?php

      echo sprintf(__l('Setting a security question helps us to identify you as the owner of your %s account.'),Configure::read('site.name'));
    ?>
        </div>
        <div class="clearfix">
        <?php
      echo $this->Form->input('User.security_question_id',array('id'=>'js-security_question_id', 'empty' => __l('Please select questions')));
      echo $this->Form->input('User.security_answer', array('label' => __l('Answer')));
    ?>
        </div>
    	</fieldset>
	   <?php endif; ?>
<?php endif; ?>
		<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
		<fieldset>
			<h3 class="well space textb text-16"><?php echo __l('Other');?></h3>
			<div>
			<?php
				echo $this->Form->input('User.is_active', array('label' => __l('Active')));
				echo $this->Form->input('User.is_email_confirmed', array('label' => __l('Email Confirmed')));
			?>
			</div>
		</fieldset>
		<?php endif; ?>
	<div class="form-actions">
		 <?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
	</div>
    <?php echo $this->Form->end();?>
	<?php if (empty($this->request->params['prefix'])): ?>
		</div>
	<?php endif; ?>
</div>