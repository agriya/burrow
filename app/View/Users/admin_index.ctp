<?php /* SVN: $Id: admin_index.ctp 4852 2010-05-12 12:58:27Z aravindan_111act10 $ */ ?>
<div class="users index js-response js-responses">
			<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active"><?php echo __l('Users'); ?></li>
            </ul>
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
                <div class="clearfix">
				<?php
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Active) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">
						<dt class="pr hor-mspace text-11 grayc" title="'.__l('Active Users').'">'.__l('Active Users').'</dt>
						<dd title="'.$this->Html->cInt($approved ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($approved ,false).'</dd>
					</dl>'
					, array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Active), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Inactive) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">
						<dt class="pr hor-mspace text-11 grayc" title="'.__l('Inactive Users').'">'.__l('Inactive Users').'</dt>
						<dd title="'.$this->Html->cInt($pending ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($pending ,false).'</dd>
					</dl>'
					, array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::OpenID) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('OpenID Users').'">'.__l('OpenID Users').'</dt>
						<dd title="'.$this->Html->cInt($openid ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($openid ,false).'</dd>
					</dl>'
					, array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::OpenID), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Gmail) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Gmail Users').'">'.__l('Gmail Users').'</dt>
						<dd title="'.$this->Html->cInt($gmail ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($gmail ,false).'</dd>
					</dl>'
					, array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Gmail), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Yahoo) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Yahoo Users').'">'.__l('Yahoo Users').'</dt>
						<dd title="'.$this->Html->cInt($yahoo ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($yahoo ,false).'</dd>
					</dl>'
					, array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Yahoo), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Facebook) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Facebook Users').'">'.__l('Facebook Users').'</dt>
						<dd title="'.$this->Html->cInt($facebook ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($facebook ,false).'</dd>
					</dl>'
					, array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Facebook), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Twitter) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Twitter Users').'">'.__l('Twitter Users').'</dt>
						<dd title="'.$this->Html->cInt($twitter ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($twitter ,false).'</dd>
					</dl>'
					, array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Twitter), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::LinkedIn) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('LinkedIn Users').'">'.__l('LinkedIn Users').'</dt>
						<dd title="'.$this->Html->cInt($linkedin ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($linkedin ,false).'</dd>
					</dl>'
					, array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::LinkedIn), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::GooglePlus) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Google+ Users').'">'.__l('Google+ Users').'</dt>
						<dd title="'.$this->Html->cInt($googleplus ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($googleplus ,false).'</dd>
					</dl>'
					, array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::GooglePlus), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstUserTypes::Admin) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Admin Users').'">'.__l('Admin Users').'</dt>
						<dd title="'.$this->Html->cInt($admin_count ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($admin_count ,false).'</dd>
					</dl>'
					, array('controller'=>'users','action'=>'index','main_filter_id' => ConstUserTypes::Admin), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == 			ConstUserTypes::User) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Normal Users').'">'.__l('Normal Users').'</dt>
						<dd title="'.$this->Html->cInt($users_count ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($users_count ,false).'</dd>
					</dl>'
					, array('controller'=>'users','action'=>'index','main_filter_id' => ConstUserTypes::User), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				if(isPluginEnabled('LaunchModes')) : 				
					$class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Prelaunch) ? 'active' : null;
					echo $this->Html->link( '<dl class="dc list users '.$class .' mob-clr mob-sep-none "><dt class="pr hor-mspace text-11 grayc"  title="'.__l('Pre-launch Users').'">'.__l('Pre-launch  Users').'</dt><dd title="'.$this->Html->cInt($prelaunch_users ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($prelaunch_users ,false).'</dd></dl>', array('controller'=>'users','action'=>'index','main_filter_id' => ConstMoreAction::Prelaunch), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
					$class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::PrivateBeta) ? 'active' : null;
					echo $this->Html->link( '<dl class="dc list users '.$class .' mob-clr mob-sep-none "><dt class="pr hor-mspace text-11 grayc"  title="'.__l('Private Beta Users').'">'.__l('Private Beta  Users').'</dt><dd title="'.$this->Html->cInt($privatebeta_users ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($privatebeta_users ,false).'</dd></dl>', array('controller'=>'users','action'=>'index','main_filter_id' => ConstMoreAction::PrivateBeta), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));						
				endif; 				
				$class = (empty($this->request->params['named']['filter_id']) && empty($this->request->params['named']['main_filter_id'])) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Total Users').'">'.__l('Total Users').'</dt>
						<dd title="'.$this->Html->cInt($approved+$pending ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($approved +$pending,false).'</dd>
					</dl>'
					, array('controller'=>'users','action'=>'index'), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));

				?>
              </div>
<?php if(isPluginEnabled('LaunchModes')) :  ?>			  
			  <div class="clearfix">
<?php 
					$class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::PrelaunchSubscribed) ? 'active' : null;
					echo $this->Html->link( '<dl class="dc list users '.$class .' mob-clr mob-sep-none "><dt class="pr hor-mspace text-11 grayc"  title="'.__l('Subscribed for Pre-launch').'">'.__l('Subscribed for Pre-launch').'</dt><dd title="'.$this->Html->cInt($prelaunch_subscribed ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($prelaunch_subscribed ,false).'</dd></dl>', array('controller'=>'subscriptions','action'=>'index','filter_id' => ConstMoreAction::PrelaunchSubscribed), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));	
					$class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::PrivateBetaSubscribed) ? 'active' : null;
					echo $this->Html->link( '<dl class="dc list users '.$class .' mob-clr mob-sep-none "><dt class="pr hor-mspace text-11 grayc"  title="'.__l('Subscribed for Private Beta').'">'.__l('Subscribed for Private Beta').'</dt><dd title="'.$this->Html->cInt($privatebeta_subscribed ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($privatebeta_subscribed ,false).'</dd></dl>', array('controller'=>'subscriptions','action'=>'index','filter_id' => ConstMoreAction::PrivateBetaSubscribed), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));				
?>				
			  </div>
<?php endif; ?>			  
			<div class="clearfix dc">
					<?php echo $this->Form->create('User', array('type' => 'get', 'class' => 'form-search bot-mspace big-input span', 'action'=>'index')); ?>
					<?php echo $this->Form->input('q', array('placeholder' => __l('Keyword'),'class'=>'span9 ver-mspace text-16','label' => false)); ?>
					<?php echo $this->Form->submit(__l('Search'), array('class'=>'btn btn-large hor-mspace btn-primary textb text-16'));?>
					<?php echo $this->Form->end(); ?>
					<div class="pull-right top-space mob-clr dc top-mspace">
					<?php echo $this->Html->link('<span class="ver-smspace no-pad icon-plus-sign"></span>', array('controller' => 'users', 'action' => 'add'), array('escape' => false,'class' => 'btn right-mspace btn-primary textb text-18','title'=>__l('Add'))); ?>					
					 <?php echo $this->Html->link('<span class="ver-smspace"><i class="icon-signout no-pad top-smspace"></i></span>', array_merge(array('controller' => 'users', 'action' => 'index', 'ext' => 'csv', 'admin' => true), $this->request->params['named']), array('escape' => false, 'title' => __l('CSV'), 'class' => 'btn btn-inverse textb text-18 js-no-pjax whitec')); ?>
				</div>
			</div>
			<?php echo $this->element('paging_counter'); ?>
			 <div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
<?php   echo $this->Form->create('User' , array('class' => 'normal','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
 <table class="table list no-round" id="js-expand-table">
	<thead>
	<tr class=" well no-mar no-pad js-even">
		<th class="dc graydarkc sep-right"  rowspan="2 span2"><?php echo __l('Select'); ?></th>
		<th rowspan="2" class="graydarkc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort( 'username',__l('User')); ?></div></th>
        <th colspan="2" class="dc graydarkc sep-bot sep-right "><?php echo __l('As Traveler');?></th>
        <th colspan="2" class="dc graydarkc sep-bot sep-right"><?php echo __l('As Host');?></th>
        <?php if(isPluginEnabled('Wallet')) : ?><th rowspan="2" class="dr graydarkc sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.available_wallet_amount',__l('Available Balance')).' ('.Configure::read('site.currency').')'; ?></div></th><?php endif;?>
        <th class="dc graydarkc sep-bot sep-right " colspan="3"><?php echo __l('Logins');?></th>
	   <th  class="dl graydarkc " rowspan="2"><?php echo __l('Registered IP'); ?></th>

 	</tr>
 	<tr class="well no-mar no-pad js-even">
        <th class="dc sep-right graydarkc"><?php echo __l('Bookings');?></th>
        <th class="dr sep-right graydarkc"><?php echo __l('Site Revenue').' ('.Configure::read('site.currency').')';?></th>
        <th class="dc sep-right graydarkc"><?php echo __l('Properties');?></th>
        <th class="dr sep-right graydarkc"><?php echo __l('Site Revenue').' ('.Configure::read('site.currency').')';?></th>
        <th class="dc sep-right graydarkc"><?php echo __l('Count'); ?></th>
        <th class="dc sep-right graydarkc"><?php echo __l('Time'); ?></th>
        <th class="dl sep-right graydarkc"><?php echo __l('IP'); ?></th>
      </tr>
	 </thead>
<?php
if (!empty($users)):
$i = 0;
foreach ($users as $user):
	$class = null;
	$active_class = '';
	if ($i++ % 2 == 0):
		$class = 'altrow';
	endif;
	$email_active_class = ' email-not-comfirmed';
	if($user['User']['is_email_confirmed']):
	$email_active_class = ' email-comfirmed';
	endif;
	if($user['User']['is_active']):
		$status_class = 'js-checkbox-active';
	else:
		$active_class = 'disable';
		$status_class = 'js-checkbox-inactive';
	endif;
		$email_active_class = ' email-not-comfirmed';
		if($user['User']['is_email_confirmed']):
		$email_active_class = ' email-comfirmed';
		endif;
    $reg_type_class='';
    $title = '';
    $icon_class = '';
	$icon_img = '';
    if(!empty($user['User']['is_facebook_register'])):
    $icon_class = 'icon-facebook-sign';
    elseif(!empty($user['User']['is_twitter_register'])):
         $icon_class = 'icon-twitter-sign';
    elseif(!empty($user['User']['is_linkedin_register'])):
         $icon_class = 'icon-linkedin-sign';
    elseif(!empty($user['User']['is_google_register'])):
         $icon_class = 'icon-google-sign';
	elseif(!empty($user['User']['is_googleplus_register'])):
         $icon_class = 'icon-google-plus-sign';
    elseif(!empty($user['User']['is_yahoo_register'])):
         $icon_class = 'icon-yahoo';
    elseif(!empty($user['User']['is_openid_register'])):
	    $icon_img = $this->Html->image('open-id.png', array('alt' => __l('[Image: OpenID]') ,'width' => 14, 'height' => 14, 'class' => 'text-12 hor-smspace'));
     endif;
  ?>
<tbody>
     <tr class="<?php echo $class.' '.$active_class;?> expand-row js-odd">
     	<td class="<?php echo $class;?>"><?php echo $this->Form->input('User.'.$user['User']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$user['User']['id'], 'label' => "", 'div' => 'top-space', 'before' => '<span class="show pull-left hor-smspace"><i class="icon-caret-down"></i></span>', 'class' => $status_class.' js-checkbox-list')); ?></td>     	
		<td class="span5 no-mar">
			<div class="clearfix">
				<div class="pull-left admin-avatar"><?php echo $this->Html->getUserAvatar($user['User'], 'micro_thumb',true, '', 'admin');?></div>
				<div class="span3 htruncate"><span class="hor-smspace"><?php echo $this->Html->getUserLink($user['User']); ?></span></div>
			</div>
			<?php if($user['User']['is_affiliate_user']):?>
			  <span class="label label-info"><?php echo __l('Affiliate'); ?></span>
			<?php endif; ?>
			<?php if($user['User']['role_id'] == ConstUserTypes::Admin):?>
			  <span class="label label-info"><?php echo __l('Admin'); ?></span>
			<?php endif; ?>
			<div class="clearfix">
				<?php if(!empty($user['UserProfile']['Country'])): ?>
					<span class="pull-left flags flag-<?php echo strtolower($user['UserProfile']['Country']['iso_alpha2']); ?>" title ="<?php echo $user['UserProfile']['Country']['name']; ?>"><?php echo $user['UserProfile']['Country']['name']; ?></span>
				<?php endif; ?>
				<?php if (empty($icon_img)) : ?>
					<i class="<?php echo $icon_class;?> graydarkc hor-smspace pull-left"></i>
				<?php else:
					echo $icon_img;
				endif;
				?>
				<?php if(!empty($user['User']['email'])):?>
					<i class="icon-envelope-alt graydarkc pull-left"></i>
					<span class="pull-left" title="<?php echo $user['User']['email']; ?>">
				<?php
				if (strlen($user['User']['email']) > 20):
					echo '..' . substr($user['User']['email'], strlen($user['User']['email'])-15, strlen($user['User']['email']));
				else:
					echo $user['User']['email'];
				endif;
				?>
				</span>
				<?php endif; ?>
			</div>
        </td>
       <td class="dc"><?php echo $this->Html->cInt($user['User']['travel_total_booked_count']); ?></td>
       <td class="dr site-amount"><?php echo $this->Html->cCurrency($user['User']['travel_total_site_revenue']); ?></td>
       <td class="dc"><?php echo $this->Html->cInt($user['User']['property_count']); ?></td>
       <td class="dr site-amount"><?php echo $this->Html->cCurrency($user['User']['host_total_site_revenue']);?></td>
       <?php if(isPluginEnabled('Wallet')) :?><td class="dr"><?php echo $this->Html->cCurrency($user['User']['available_wallet_amount']);?></td><?php endif;?>
       <td class="dc"><?php echo $this->Html->cInt($user['User']['user_login_count']); ?></td>
       <td class="dc"><?php echo ($user['User']['last_logged_in_time']=='0000-00-00 00:00:00')? '-': $this->Html->cDateTimeHighlight($user['User']['last_logged_in_time']);?></td>
       <td class="dl">
		<?php if(!empty($user['LastLoginIp']['ip'])): ?>
			<?php echo  $this->Html->link($user['LastLoginIp']['ip'], array('controller' => 'users', 'action' => 'whois', $user['LastLoginIp']['ip'], 'admin' => false), array('target' => '_blank', 'class'=>'js-no-pjax grayc', 'title' => 'whois '.$user['LastLoginIp']['host'], 'escape' => false));
			?>
			<?php
				if(!empty($user['LastLoginIp']['Country'])):
			?>
					<div><span class="flags flag-<?php echo strtolower($user['LastLoginIp']['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($user['LastLoginIp']['Country']['name'], false); ?>"><?php echo $user['LastLoginIp']['Country']['name'];  ?></span> <p class="inline span2 htruncate"><?php if(!empty($user['LastLoginIp']['City'])): echo $user['LastLoginIp']['City']['name'];  endif; ?> </p></div>
			<?php endif; ?>
			<?php else: ?>
				<?php echo __l('N/A'); ?>
			<?php endif; ?>
		</td>
		<td class="dl">
			<?php
			if(!empty($user['Ip']['ip'])):
					echo  $this->Html->link($user['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $user['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class'=>'js-no-pjax grayc',  'title' => 'whois '.$user['Ip']['ip'], 'escape' => false));
			?>
			<?php
				if(!empty($user['Ip']['Country'])):
			?>
					<div><span class="flags flag-<?php echo strtolower($user['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($user['Ip']['Country']['name'], false); ?>"><?php echo $user['Ip']['Country']['name'];  ?></span> <p class="inline span2 htruncate"><?php if(!empty($user['Ip']['City'])): echo $user['Ip']['City']['name'];  endif; ?></p></div>
			<?php endif; ?>
			<?php else: ?>
				<?php echo __l('n/a'); ?>
			<?php endif; ?>
		</td>
   </tr>
                      <tr class="hide sep-bot sep-medium">
                        <td colspan="11"><div class="top-space clearfix">
                            <div class="clearfix activities-block">
                              <div class="pull-right dropdown"> <a data-toggle="dropdown" class="dropdown-toggle btn btn-large text-14 textb graylighterc no-shad" title="Edit" href="#"><i class="icon-cog graydarkc  no-pad text-16"></i> <span class="caret"></span></a>
                                <ul class="dropdown-menu arrow arrow-right">
                                  <li><?php if(Configure::read('user.is_email_verification_for_register') and ($user['User']['is_email_confirmed'] == 0)):
    					     	echo $this->Html->link('<i class="icon-reply"></i>'.__l('Resend Activation'), array('controller' => 'users', 'action' => 'resend_activation', $user['User']['id'], 'admin' => false),array('escape' => false,'title' => __l('Resend Activation'),'class' =>'activate-user graydarkc'));
    				            endif;?>
    			            </li>
    			            <li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('controller' => 'user_profiles', 'action'=>'edit', $user['User']['id']), array('escape' => false,'class' => 'edit js-edit graydarkc', 'title' => __l('Edit')));?></li>
                               <?php if($user['User']['role_id'] != ConstUserTypes::Admin){ ?>
                            <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action'=>'delete', $user['User']['id']), array('escape' => false,'class' => 'delete js-delete graydarkc', 'title' => __l('Delete')));?></li>
                                    <?php } ?>
    		                  	<?php if(!empty($user['User']['facebook_user_id']) || !empty($user['User']['twitter_user_id']) || !empty($user['User']['is_openid_register'])):?>
    			                <?php else:?>
                             <li>
                                   <?php if(!($user['User']['is_openid_register']) && !($user['User']['is_yahoo_register']) && !($user['User']['is_google_register'])&& !($user['User']['facebook_user_id'])&& !($user['User']['twitter_user_id']) ):?>
                            				<?php echo $this->Html->link('<i class="icon-key"></i>'.__l('Change Password'), array('controller' => 'users', 'action'=>'admin_change_password', $user['User']['id']), array('class' => 'password graydarkc', 'escape' => false, 'title' => __l('Change password')));?>
                            			<?php endif ?> </li>
    			                 <?php endif?>
								  <?php echo $this->Layout->adminRowActions($user['User']['id']);  ?>
                                </ul>
                              </div>
                              <ul id="myTab3" class="nav nav-tabs top-smspace">
                                <li class="active"><a href="#As-Host-<?php echo $user['User']['id']; ?>" data-toggle="tab"><?php echo __l('As Host'); ?></a> </li>
                                <li><a href="#As-Traveler-<?php echo $user['User']['id']; ?>" data-toggle="tab"><?php echo __l('As Traveler'); ?></a></li>
                                <li><a  data-toggle="tab" href="#As-User-<?php echo $user['User']['id']; ?>"><?php echo __l('As User'); ?></a></li>
                              </ul>
                              <div class="sep-right sep-left sep-bot tab-round tab-content" id="myTabContent3">
                                <div class="tab-pane space active" id="As-Host-<?php echo $user['User']['id']; ?>">
                                  <div class="row no-mar">
                                    <div class="pull-left">
                                      <div class="span8">
                                        <h3 class="well space textb text-16 no-mar"><?php echo __l('Amount'); ?></h3>
                                        <div class="clearfix ver-space bot-mspace">
                                          <dl class="list">
                                            <dt class="pr hor-mspace text-11"><?php echo __l('Earned'); ?></dt>
                                            <dd title="<?php echo $user['User']['host_total_earned_amount']; ?>" class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($user['User']['host_total_earned_amount']); ?></dd>
                                          </dl>
										  <dl class="list">
        								   <dt class="pr hor-mspace text-11"><?php echo __l('Lost'); ?></dt>
										   <dd  title="<?php echo $user['User']['host_total_lost_amount']; ?>" class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($user['User']['host_total_lost_amount']); ?></dd>
										    </dl>
											<dl class="list">
											   <dt class="pr hor-mspace text-11"><?php echo __l('Pipeline'); ?></dt>
											   <dd  title="<?php echo $user['User']['host_total_pipeline_amount']; ?>" class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($user['User']['host_total_pipeline_amount']); ?></dd>
										     </dl>
											 <dl class="list">
												<dt class="pr hor-mspace text-11"><?php echo __l('Site Revenue'); ?></dt>
												<dd  title="<?php echo $user['User']['host_total_site_revenue']; ?>" class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($user['User']['host_total_site_revenue']); ?></dd>
										    </dl>

                                        </div>
                                      </div>
                                    </div>
                                    <div class="pull-right">
                                      <div class="span8">
                                        <h3 class="well space textb text-16 no-mar"><?php echo __l('Properties'); ?></h3>
                                        <div class="clearfix ver-space bot-mspace">
										<dl class="list">
											<dt class="pr hor-mspace text-11"><?php echo __l('Pending Approval'); ?></dt>
											<dd title="<?php echo $user['User']['property_pending_approval_count']; ?>" class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->cInt($user['User']['property_pending_approval_count']); ?></dd>
										</dl>
										<dl class="list">
										   <dt class="pr hor-mspace text-11"><?php echo __l('Enabled'); ?></dt>
										   <dd title="<?php echo $user['User']['property_count']; ?>" class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->cInt($user['User']['property_count']); ?></dd>
									   </dl>
									   <dl class="list">
										   <dt class="pr hor-mspace text-11"><?php echo __l('Disabled'); ?></dt>
										   <dd title="<?php echo $user['User']['property_inactive_count'];?>" class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->cInt($user['User']['property_inactive_count']); ?></dd>
									   </dl>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row no-mar top-space">
                                    <div class="pull-left">
                                      <div class="span8">
                                        <h3 class="well space textb text-16 no-mar"><?php echo __l('Bookings'); ?></h3>
                                        <div class="clearfix ver-space bot-mspace">
										<dl class="list">
        								   <dt class="pr hor-mspace text-11"><?php echo __l('Successful'); ?></dt>
										   <dd class="textb text-16 graydarkc pr hor-mspace" title="<?php echo $this->Html->cInt($user['User']['host_total_booked_count'], false); ?>"><?php echo $this->Html->cInt($user['User']['host_total_booked_count']); ?></dd>
										   </dl>
                                          <dl class="sep-left list">
        								   <dt class="pr hor-mspace text-11"><?php echo __l('Unsuccessful'); ?></dt>
										   <dd class="textb text-16 graydarkc pr hor-mspace" title="<?php echo $this->Html->cInt($user['User']['host_total_lost_booked_count'], false); ?>"><?php echo $this->Html->cInt($user['User']['host_total_lost_booked_count']); ?></dd>
										  </dl>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="pull-right">
                                      <div class="span8">
                                        <h3 class="well space textb text-16 no-mar"><?php echo __l('Reviews'); ?></h3>
                                        <div class="clearfix ver-space bot-mspace">
										<dl class="list">
											<dt  class="pr hor-mspace text-11" title ="<?php echo __l('Positive');?>"><?php echo __l('Positive');?></dt>
											<dd class="textb text-16 graydarkc pr hor-mspace"><?php echo numbers_to_higher($user['User']['positive_feedback_count']); ?>
										</dl>
										<dl class="list">
											<dt class="pr hor-mspace text-11" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
											<dd class="textb text-16 graydarkc pr hor-mspace">
											<?php echo numbers_to_higher($user['User']['property_feedback_count'] - $user['User']['positive_feedback_count']); ?>
											</dd>
										</dl>
										<dl class="list">
											<?php
											$success_rate = $user['User']['property_feedback_count'] - $user['User']['positive_feedback_count'];
											?>
											<dt  class="pr hor-mspace text-11" title ="<?php echo __l('Success Rate');?>"><?php echo __l('Success Rate');?></dt>
											<?php if(empty($user['User']['property_feedback_count'])): ?>
											<dd class="textb text-16 graydarkc pr hor-mspace" title="<?php  echo __l('No Bookings available'); ?>"><?php echo __l('n/a'); ?></dd>
											<?php else: ?>
											<dd class="textb text-16 graydarkc pr hor-mspace" >
											<?php if(!empty($user['User']['positive_feedback_count'])):
											$positive = floor(($user['User']['positive_feedback_count']/$user['User']['property_feedback_count']) *100);
											$negative = 100 - $positive;
											else:
											$positive = 0;
											$negative = 100;
											endif;

											echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=8DCA35|F47564&amp;chf=bg,s,FFFFFF00', array('width'=>'35px','height'=>'35px','title' => $positive.'%'));  ?>
											</dd>
											<?php endif; ?>
										</dl>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div id="As-Traveler-<?php echo $user['User']['id']; ?>" class="tab-pane space" >
                                  <div class="row no-mar">
                                    <div class="pull-left">
                                      <div class="span8">
                                        <h3 class="well space textb text-16 no-mar"><?php echo __l('Amount'); ?></h3>
                                        <div class="clearfix ver-space bot-mspace">
										   <dl class="list">
											   <dt class="pr hor-mspace text-11"><?php echo __l('Paid'); ?></dt>
											   <dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($user['User']['travel_total_booked_amount']); ?></dd>
										   </dl>
										   <dl class="sep-left list">
											   <dt class="pr hor-mspace text-11"><?php echo __l('Site Revenue'); ?></dt>
											   <dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($user['User']['travel_total_site_revenue']); ?></dd>
											</dl>						
                                        </div>
                                      </div>
                                    </div>
                                    <div class="pull-right">
                                      <div class="span8">
                                        <h3 class="well space textb text-16 no-mar"><?php echo __l('Bookings'); ?></h3>
                                        <div class="clearfix ver-space bot-mspace">
											<dl class="list">
        								   <dt class="pr hor-mspace text-11"><?php echo __l('Successful'); ?></dt>
										   <dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->cInt($user['User']['travel_total_booked_count']); ?></dd>
										   </dl>
										   <dl class="sep-left list">
        								   <dt class="pr hor-mspace text-11"><?php echo __l('Unsuccessful'); ?></dt>
										   <dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->cInt($user['User']['travel_total_lost_booked_count']); ?></dd>
										   </dl>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row no-mar top-space">
                                    <div class="pull-left">
                                      <div class="span8">
                                        <h3 class="well space textb text-16 no-mar"><?php echo __l('Reviews'); ?></h3>
                                        <div class="clearfix ver-space bot-mspace">
											<dl class="list">										
												<dt class="pr hor-smspace text-11" title ="<?php echo __l('Positive');?>"><?php echo __l('Positive');?></dt>
												<dd class="textb text-16 graydarkc pr hor-mspace">
													<?php echo numbers_to_higher($user['User']['traveler_positive_feedback_count']); ?>
												</dd>
                                            </dl>
                                            <dl class="list">
												<dt class="pr hor-smspace text-11" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
												<dd class="textb text-16 graydarkc pr hor-mspace"> <?php echo numbers_to_higher($user['User']['traveler_property_user_count'] - $user['User']['traveler_positive_feedback_count']);?>	</dd>
                                            </dl>
                                            <?php if(($user['User']['traveler_property_user_count']) == 0): ?>
                                            		<dl class="list">
														<dt class="pr hor-smspace text-11"><?php echo __l('Success Rate'); ?></dt>
														<dd class="textb text-16 graydarkc pr hor-mspace" title="<?php  echo __l('No Bookings available'); ?>"><?php echo __l('n/a'); ?></dd>
                                            		</dl>
                                           <?php else: ?>
												<dl class="list">
													<dt class="pr hor-smspace text-11"><?php echo __l('Success Rate'); ?></dt>
													<dd class="textb text-16 graydarkc pr hor-mspace"> 
														<span class="stats-val">
                                            <?php if(!empty($user['User']['traveler_positive_feedback_count'])):
                                            		$positive = floor(($user['User']['traveler_positive_feedback_count']/$user['User']['traveler_property_user_count']) *100);
                                            		$negative = 100 - $positive;
                                            		else:
                                            		$positive = 0;
                                            		$negative = 100;
                                            		endif;

                                            		echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=8DCA35|F47564&amp;chf=bg,s,FFFFFF00', array('width'=>'35px','height'=>'35px','title' => $positive.'%')); ?>
														</span>
													</dd>
												</dl>
                                		   <?php endif; ?>										
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div id="As-User-<?php echo $user['User']['id']; ?>" class="tab-pane space">
                                  <div class="row no-mar">
                                    <div class="span12 right-space">
                                      <div class="clearfix ver-space bot-mspace">
										<dl class="sep-right list">
                                           <dt class="pr hor-mspace text-11"><?php echo __l('Deposited'); ?></dt>
										   <dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($user['User']['total_amount_deposited']); ?></dd>
										 </dl>
										 <?php if(isPluginEnabled('Wallet')) : ?>                                           
                                        <dl class="sep-right list">
                                           <dt class="pr hor-mspace text-11"><?php echo __l('Wallet'); ?></dt>
										   <dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($user['User']['available_wallet_amount']); ?></dd>
										 </dl>
										   <?php endif;?>
                                        <dl class="sep-right list">
                                           <dt class="pr hor-mspace text-11"><?php echo __l('Withdrawn'); ?></dt>
										   <dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($user['User']['total_amount_withdrawn']); ?></dd>
										 </dl>
                                        <dl class="list">
                                           <dt class="pr hor-mspace text-11"><?php echo __l('Total Site Revenue'); ?></dt>
										   <dd class="textb text-16 graydarkc pr hor-mspace"><?php echo $this->Html->siteCurrencyFormat($user['User']['travel_total_site_revenue'] + $user['User']['host_total_site_revenue']); ?></dd>
										 </dl>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="clearfix details-block no-mar pull-right">
                              <div class="thumb pull-left hor-space bot-mspace">
							  <?php echo $this->Html->link($this->Html->getUserAvatar($user['User'], 'small_big_thumb',false, 'img-polaroid'), array('controller' => 'users', 'action' => 'view', $user['User']['username'], 'admin' => false),array('class' => 'show js-no-pjax','title' => $user['User']['username'], 'escape' => false)); ?>	  
							</div>
                              <div class="pull-left hor-space bot-mspace "> <?php echo $this->Html->link($this->Html->cText($user['User']['username'], false), array('controller' => 'users', 'action' => 'view', $user['User']['username'], 'admin' => false),array('title' => $user['User']['username'], 'escape' => false, 'class' => 'graydarkc text-24 textb mob-text-24 bot-mspace show js-no-pjax')); ?>	  
                                <dl class="no-mar clearfix">
									<dt class="pull-left textn no-mar"> <?php echo __l('Registered 0n'); ?></dt>
									<dd class="pull-left hor-space graydarkc textb"><?php echo $this->Html->cDateTimeHighlight($user['User']['created']);?></dd>
                                </dl>
								 <?php if(!empty($user['SignupIp']['ip'])):?>
								 <dl class="deal-img-list clearfix">
									<dt class="pull-left textn no-mar"><?php echo __l('Signup IP'); ?></dt>
									<dd class="pull-left hor-space graydarkc textb"><?php echo $this->Html->cText($user['SignupIp']['ip']); ?></dd>
								 </dl>
								 <?php endif;?>
								 <?php if(!empty($user['User']['facebook_user_id'])):?>
								 <dl class="no-mar clearfix">
									<dt class="pull-left textn no-mar"> <?php echo __l('Facebook User ID'); ?></dt>
									<dd class="pull-left hor-space graydarkc textb"><?php echo $this->Html->cText($user['User']['facebook_user_id']); ?></dd>
								 </dl>
								 <?php endif;?>
								 <?php if(!empty($user['User']['twitter_user_id'])):?>
								 <dl class="no-mar clearfix">
									<dt class="pull-left textn no-mar"><?php echo __l('Twitter User ID'); ?></dt>
									<dd class="pull-left hor-space graydarkc textb"><?php echo $this->Html->cText($user['User']['twitter_user_id']); ?></dd>
								 </dl>
								 <?php endif;?>
								 <?php if(Configure::read('user.signup_fee')):?>
								 <dl class="no-mar clearfix">
									<dt class="pull-left textn no-mar"><?php echo __l('Membership Paid'); ?></dt>
									<dd class="pull-left hor-space graydarkc textb"><?php echo $this->Html->cBool($user['User']['is_paid']);?></dd>
								 </dl>
								 <?php endif;?>
								 <dl class="no-mar clearfix">
									 <dt class="pull-left textn no-mar"><?php echo __l('Email Activated'); ?></dt>
									 <dd class="pull-left hor-space graydarkc textb"><?php echo $this->Html->cBool($user['User']['is_email_confirmed']);?></dd>
								 </dl>
                              </div>
                            </div>
                          </div></td>
                      </tr>

<?php
    endforeach;
else:
?>
	 <tr class="js-odd">
		<td colspan="14"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Users available');?></p></div></td>
	</tr>
<?php
endif;
?></tbody>
</table>
<?php
if (!empty($users)):
?>	<div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
				<?php echo __l('Select:'); ?></span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
				<?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"} hor-smspace grayc', 'title' => __l('Inactive'))); ?>
				<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"} hor-smspace grayc', 'title' => __l('Active'))); ?>
				<span class="hor-mspace">
                </div><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit js-no-pjax span5', 'div'=>false,'label' => false, 'empty' => __l('-- More actions --'))); ?></span>

         </div>
          <div class="js-pagination pagination pull-right no-mar mob-clr dc">
            <?php echo $this->element('paging_links'); ?>
        </div>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
</div>
</div>
</div>