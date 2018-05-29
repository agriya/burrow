<div class="bot-space">
<?php if (!(isset($this->request->params['prefix']) and $this->request->params['prefix'] == 'admin')) {?>
  <h2 class="ver-space top-mspace text-32 sep-bot"><?php echo sprintf(__l('Profile Image - %s'), $this->request->data['User']['username']); ?></h2>
<?php } ?>
</div>
  <div class="container top-space clearfix">          

<?php echo $this->Form->create(null, array('url' => array('controller' => 'user_profiles', 'action' => 'profile_image', $this->request->data['User']['id']) ,'class' => 'normal profileimageform', 'enctype' => 'multipart/form-data'));?>
<?php
	$checkedFaceBook = $checkedTwitter = $checkedAttach = $checkedGoogle = $checkedGooglePlus = $checkedLinkedin = false;
	
	if ($this->request->data['User']['user_avatar_source_id'] == ConstUserAvatarSource::Facebook) {
		$checkedFaceBook = 'checked';
	} elseif ($this->request->data['User']['user_avatar_source_id'] == ConstUserAvatarSource::Twitter) {
		$checkedTwitter = 'checked';
	} elseif ($this->request->data['User']['user_avatar_source_id'] == ConstUserAvatarSource::Google) {
		$checkedGoogle = 'checked';
	} elseif ($this->request->data['User']['user_avatar_source_id'] == ConstUserAvatarSource::GooglePlus) {
		$checkedGooglePlus = 'checked';
	} elseif ($this->request->data['User']['user_avatar_source_id'] == ConstUserAvatarSource::Linkedin) {
		$checkedLinkedin = 'checked';
	} else {
		$checkedAttach = 'checked';
	}
?>

		<div class="thumbnail space">
			<?php $user = $this->Html->getCurrUserInfo($this->Auth->user('id')); ?>
		<div class="row page-header space-bottom <?php echo (!empty($user['User']['is_facebook_connected']))?'social-avatar':'social-avatar1';?>">
			<?php 
			$class= (!empty($user['User']['is_facebook_connected']))?'ver-mspace ver-space':'no-mar';
			$facebook_icon='<div class="span2 text-42 '.$class.'"><i class="icon-facebook-sign facebookc"></i></div>';?>
			<?php if (!empty($user['User']['is_facebook_connected'])) { ?>
				<div class="input radio pull-left">
					<?php
					$width = Configure::read('thumb_size.medium_thumb.width');
					$height = Configure::read('thumb_size.medium_thumb.height');
					$user_image = $this->Html->getFacebookAvatar($user['User']['facebook_user_id'], $height, $width);
					$user_image1=$facebook_icon.'<div class="span13 space well">'.$user_image . ' ' . __l('You have already connected to Facebook.').'</div>';
					$options = array(ConstUserAvatarSource::Facebook=>$user_image1);
					echo $this->Form->input('User.user_avatar_source_id', array('type' => 'radio', 'checked'=> $checkedFaceBook, 'options' => $options, 'div'=>false));
					?>
				</div>
				<?php if (empty($user['User']['is_facebook_register'])): ?>
					<div class="span5 offset1">
						<?php echo $this->Html->link(sprintf(__l('Disconnect from %s'), __l('Facebook')), array('controller' => 'social_marketings', 'action' => 'myconnections', 'facebook'), array('title' => sprintf(__l('Disconnect from %s'), __l('Facebook')) ,'class' => 'span4 btn js-confirm')); ?>
					</div>
				<?php endif; ?>
			<?php } else { ?>
			<div class="input radio pull-left">
					<?php  $user_image1= $facebook_icon.'<div class="span13 space well">'.__l('Increase your reputation by showing Facebook friends count.').'</div>';
					$options = array(ConstUserAvatarSource::Facebook=>$user_image1);
					echo $this->Form->input('User.user_avatar_source_id', array('type' => 'radio', 'checked'=> $checkedFaceBook, 'options' => $options, 'div'=>false,'disabled'=>true)); 
					$connect_url = Router::url(array(
					'controller' => 'social_marketings',
					'action' => 'import_friends',
					'type' =>'facebook',
					'import' => 'facebook',
					'from' => 'social'
					), true);
				?>
				</div>
				<div class="span5 offset1"><?php echo $this->Html->link(sprintf(__l('Connect with %s'), __l('Facebook')), $connect_url, array('title' => sprintf(__l('Connect with %s'), __l('Facebook')) ,'class' => 'js-connect js-no-pjax span4 btn {"url":"'.$connect_url.'"}'));
				?></div>
			<?php } ?>
		</div>
		<div class="row page-header space-bottom <?php echo (!empty($user['User']['is_twitter_connected']))?'social-avatar':'social-avatar1';?>">
			<?php $class= (!empty($user['User']['is_twitter_connected']))?'ver-mspace ver-space':'no-mar';
				$twitter_icon='<div class="span2 text-42 '.$class.'"><i class="icon-twitter-sign twitterc"></i></div>';?>
			<?php if (!empty($user['User']['is_twitter_connected'])) { ?>
				<div class="input radio pull-left">
				<?php
					$width = Configure::read('thumb_size.medium_thumb.width');
					$height = Configure::read('thumb_size.medium_thumb.height');
					$user_image = '';
					if (!empty($user['User']['twitter_avatar_url'])):
						$user_image = $this->Html->image($user['User']['twitter_avatar_url'], array(
						'title' => $this->Html->cText($user['User']['username'], false) ,
						'width' => $width,
						'height' => $height
						));
					endif;
					$user_image1=$twitter_icon.'<div class="span13 space well"><span class="space-left">'.$user_image . ' ' . __l('You have already connected to Twitter.').'</span></div>';
					$options = array(ConstUserAvatarSource::Twitter=>$user_image1);
					echo $this->Form->input('User.user_avatar_source_id', array('type' => 'radio', 'checked'=> $checkedTwitter, 'options' => $options, 'div'=>false));
				?>
				</div>
				<?php if (empty($user['User']['is_twitter_register'])): ?>
					<div class="span5 offset1">
						<?php echo $this->Html->link(sprintf(__l('Disconnect from %s'), __l('Twitter')), array('controller' => 'social_marketings', 'action' => 'myconnections', 'twitter'), array('title' => sprintf(__l('Disconnect from %s'), __l('Twitter')),'class' => 'span4 btn js-confirm')); ?>
					</div>
				<?php endif; ?>
			<?php } else {?>
					<div class="input radio pull-left">
					<?php  $user_image1=$twitter_icon.'<div class="span13 space well">'.__l('Increase your reputation by showing Twitter followers count.').'</div>';
					$options = array(ConstUserAvatarSource::Twitter=>$user_image1);
					echo $this->Form->input('User.user_avatar_source_id', array('type' => 'radio', 'checked'=> $checkedTwitter, 'options' => $options, 'div'=>false,'disabled'=>true)); 
					$connect_url = Router::url(array(
					'controller' => 'social_marketings',
					'action' => 'import_friends',
					'type' =>'twitter',
					'import' => 'twitter',
					'from' => 'social'
					), true);
				?>
				</div>
				<div class="span5 offset1"><?php echo $this->Html->link(sprintf(__l('Connect with %s'), __l('Twitter')), $connect_url, array('title' => sprintf(__l('Connect with %s'), __l('Twitter')) ,'class' => 'js-connect js-no-pjax span4 btn {"url":"'.$connect_url.'"}'));
				?></div>

			<?php } ?>
		</div>
  
		<div class="row page-header  space-bottom <?php echo (!empty($user['User']['is_linkedin_connected']))?'social-avatar':'social-avatar1';?>">
			<?php $class= (!empty($user['User']['is_linkedin_connected']))?'ver-mspace ver-space':'no-mar';
			$linkedin_icon='<div class="span2 text-42 '.$class.'"><i class="icon-linkedin-sign linkedc"></i></div>';?>
			<?php if (!empty($user['User']['is_linkedin_connected'])) { ?>
				<div class="input radio pull-left">
					<?php
					$width = Configure::read('thumb_size.medium_thumb.width');
					$height = Configure::read('thumb_size.medium_thumb.height');
					$user_image = '';
					if (!empty($user['User']['linkedin_avatar_url'])):
						$user_image = $this->Html->image($user['User']['linkedin_avatar_url'], array(
						'title' => $this->Html->cText($user['User']['username'], false) ,
						'width' => $width,
						'height' => $height
						));
						$user_image1=$linkedin_icon.'<div class="span13 space well">'.$user_image . ' ' . __l('You have already connected to LinkedIn.').'</div>';
					else:
						$user_image = $this->Html->showImage('UserAvatar', '', array('dimension' => 'medium_thumb', 'alt' => sprintf('[Image: %s]', $this->Html->cText($this->request->data['User']['username'], false)), 'title' => $this->Html->cText($this->request->data['User']['username'], false)));
						$user_image1=$linkedin_icon.'<div class="span13 space well">'.$user_image . ' ' . __l('You have already connected to LinkedIn.').'<i class="icon-info-sign js-bootstrap-tooltip" title="Here showing site default user avatar, because LinkedIn dont have default avatar"></i></div>';
					endif;
					$options = array(ConstUserAvatarSource::Linkedin => $user_image1);
					echo $this->Form->input('User.user_avatar_source_id', array('type' => 'radio', 'checked'=> $checkedLinkedin, 'options' => $options, 'div'=>false));
				?>
				</div>
				<?php if (empty($user['User']['is_linkedin_register'])): ?>
					<div class="span5 offset1">
						<?php echo $this->Html->link(sprintf(__l('Disconnect from %s'), __l('Linkedin')), array('controller' => 'social_marketings', 'action' => 'myconnections', 'linkedin'), array('title' =>sprintf(__l('Disconnect from %s'), __l('Linkedin')),'class' => 'span4 btn js-confirm')); ?>
					</div>
				<?php endif; ?>
			<?php } else { ?>
			<div class="input radio pull-left">
				<?php  $user_image1=$linkedin_icon.'<div class="span13 space well">'.__l('Increase your reputation by showing LinkedIn connections count.').'</div>';
				  $options = array(ConstUserAvatarSource::Linkedin=>$user_image1);
					echo $this->Form->input('User.user_avatar_source_id', array('type' => 'radio', 'checked'=> $checkedLinkedin, 'options' => $options, 'div'=>false,'disabled'=>true)); 
				$connect_url = Router::url(array(
				'controller' => 'social_marketings',
				'action' => 'import_friends',
				'type' =>'linkedin',
				'import' => 'linkedin',
				'from' => 'social'
				), true);
				?>
				</div>
				<div class="span5 offset1"><?php echo $this->Html->link(sprintf(__l('Connect with %s'), __l('Linkedin')), $connect_url, array('title' => sprintf(__l('Connect with %s'), __l('Linkedin')) ,'class' => 'js-connect js-no-pjax span4 btn {"url":"'.$connect_url.'"}'));
				?></div>
			<?php } ?>
		</div>
 <div class="row page-header no-bor space-bottom">
 <div class="text-24 pull-left textb space span2 dc">Or</div>
 <div class="input radio pull-left user-profile-image" >
            <?php
				$before_span = '<span><span class="avtar-box span2 pr left-mspace">';
				$after_span = '</span></span>';
				$user_image = $before_span . $this->Html->showImage('UserAvatar', $this->request->data['UserAvatar'], array('dimension' => 'medium_thumb', 'alt' => sprintf('[Image: %s]', $this->Html->cText($this->request->data['User']['username'], false)), 'title' => $this->Html->cText($this->request->data['User']['username'], false))) . $after_span;
				 $options = array(ConstUserAvatarSource::Attachment=>$user_image);
				 echo $this->Form->input('User.user_avatar_source_id', array('type' => 'radio', 'checked'=> $checkedAttach, 'options' => $options,'div'=>false));?>
				 </div>
				 <div class="input file profileimage">
				 <?php
					echo $this->Form->input('UserAvatar.filename', array('type' => 'file', 'size' => '33', 'label' => __l('Upload Photo'),'div'=>false, 'class' => "browse-field {'UmimeType':'jpg,jpeg,png,gif', 'Uallowedsize':'5','UallowedMaxFiles':'1'}"));
				  ?>
				  </div>
				</div>
  </div>
 <table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
<div class="form-actions">
				<div class="dr"><?php echo $this->Form->submit(__l('Update'),array('class'=>'btn btn-warning textb btn-large text-20')); ?> </div>
			  </div>
      <?php echo $this->Form->end(); ?>
</div>
