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
					$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::PrelaunchSubscribed) ? 'active' : null;
					echo $this->Html->link( '<dl class="dc list users '.$class .' mob-clr mob-sep-none "><dt class="pr hor-mspace text-11 grayc"  title="'.__l('Subscribed for Pre-launch').'">'.__l('Subscribed for Pre-launch').'</dt><dd title="'.$this->Html->cInt($prelaunch_subscribed ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($prelaunch_subscribed ,false).'</dd></dl>', array('controller'=>'subscriptions','action'=>'index','filter_id' => ConstMoreAction::PrelaunchSubscribed), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));	
					$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::PrivateBetaSubscribed) ? 'active' : null;
					echo $this->Html->link( '<dl class="dc list users '.$class .' mob-clr mob-sep-none "><dt class="pr hor-mspace text-11 grayc"  title="'.__l('Subscribed for Private Beta').'">'.__l('Subscribed for Private Beta').'</dt><dd title="'.$this->Html->cInt($privatebeta_subscribed ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($privatebeta_subscribed ,false).'</dd></dl>', array('controller'=>'subscriptions','action'=>'index','filter_id' => ConstMoreAction::PrivateBetaSubscribed), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));				
?>				
			  </div>
<?php endif; ?>				  
			<div class="clearfix dc">
					<?php echo $this->Form->create('User', array('method' => 'get', 'class' => 'form-search bot-mspace big-input span', 'action'=>'index')); ?>
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
 <table class="table list no-round">
	<thead>
	<tr class=" well no-mar no-pad js-even">
      <th class="dc graydarkc sep-right"><?php echo __l('Select'); ?></th>
      <th class="dc graydarkc sep-right"><?php echo __l('Actions');?></th>
      <th><div><?php echo $this->Paginator->sort('email', __l('Email'));?></div></th>
      <th class="dc graydarkc sep-right"><?php echo $this->Paginator->sort('is_sent_private_beta_mail', __l('Invitation Sent')); ?></th>
      <th class="dc graydarkc sep-right"><?php echo __l('Registered');?></th>
      <th class="dc graydarkc sep-right"><?php echo __l('From Friends Invite');?></th>
      <th class="dc graydarkc sep-right"><span class="clearfix"><?php echo __l('Invitation to Friends');?></span><br /><span class="clearfix"><?php echo __l('Registered');?>&nbsp;/&nbsp;<?php echo __l('Invited');?>&nbsp;/&nbsp;<?php echo __l('Allowed invitation');?></span></th>
      <th class="dc graydarkc sep-right"><?php echo __l('Subscribed On');?></th>
      <th><?php echo $this->Paginator->sort('ip_id', __l('IP')); ?></th>
      </tr>
	  </thead>
	  <tbody>
      <?php
        if (!empty($subscriptions)):
          foreach ($subscriptions as $subscription):
            if($subscription['Subscription']['is_email_verified'] == '1')  :
              $status_class = 'js-checkbox-active';
              $disabled = '';
            else:
              $status_class = 'js-checkbox-inactive';
              $disabled = 'class="disabled"';
            endif;
      ?>
	  
      <tr <?php echo $disabled; ?>>
      <td class="select dc">
      <?php echo $this->Form->input('Subscription.'.$subscription['Subscription']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$subscription['Subscription']['id'], 'label' => "", 'class' => $status_class.' js-checkbox-list')); ?>
      </td>
      <td class="span1 dc">
        <div class="dropdown top-space">
          <a href="#" title="Actions" data-toggle="dropdown" class="icon-cog blackc text-20 dropdown-toggle js-no-pjax"><span class="hide">Action</span></a>
          <ul class="unstyled dropdown-menu dl arrow clearfix">
            <li>
              <?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), Router::url(array('action'=>'delete', $subscription['Subscription']['id']), true).'?r='.$this->request->url, array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
            </li>
          <?php if(Configure::read('site.launch_mode') == 'Private Beta' && empty($subscription['Subscription']['is_sent_private_beta_mail']))   { ?>
            <li>
              <?php echo $this->Html->link('<i class="icon-envelope"></i>'.__l('Send Invitation Code'), Router::url(array('action'=>'send_invitation', $subscription['Subscription']['id']), true).'?r='.$this->request->url, array('escape'=>false, 'title' => __l('Send Invitation Code')));?>
            </li>
          <?php }  ?>
          </ul>
          <?php echo $this->Layout->adminRowActions($subscription['Subscription']['id']); ?>
      </td>
      <td><?php echo $this->Html->cText($subscription['Subscription']['email'],false);?></td>
      <td class="dc"><?php echo $this->Html->cBool($subscription['Subscription']['is_sent_private_beta_mail'],false);?></td>
      <?php if(!empty($subscription['User']['id'])) { ?>
      <td class="span4 dl">
        <div class="row-fluid">
          <div class="span6"><?php echo $this->Html->getUserAvatar($subscription['User'], 'micro_thumb',true, '', 'admin');?></div>
          <div class="span12 vtop hor-smspace"><?php echo $this->Html->getUserLink($subscription['User']); ?></div>
        </div>
      </td>
      <?php } else { ?>
      <td class="dc"><?php echo $this->Html->cBool(($subscription['User']['id'])?'1':'0',false);?></td>
      <?php } ?>
      <?php if(!empty($subscription['Subscription']['invite_user_id'])) { ?>
      <td class="span4 dl">
        <div class="row-fluid">
          <div class="span6"><?php echo $this->Html->getUserAvatar($subscription['InviteUser'], 'micro_thumb',true, '', 'admin');?></div>
          <div class="span12 vtop hor-smspace"><?php echo $this->Html->getUserLink($subscription['InviteUser']); ?></div>
        </div>
      </td>
      <?php } else { ?>
         <td class="dc"><?php echo __l('No');?></td>
      <?php } ?>
      <td class="dc">
      <?php
        $no_of_users_to_invite = Configure::read('site.no_of_users_to_invite');
        $no_of_users_to_invite = (!empty($no_of_users_to_invite))?$no_of_users_to_invite:'-';
        $invite_count = ($subscription['User']['invite_count'] == null)?'0':$subscription['User']['invite_count'];
        echo $this->Html->cText($this->App->getUserInvitedFriendsRegisteredCount($subscription['User']['id']). ' / ' . $invite_count . ' / ' .  $no_of_users_to_invite, false);
      ?>
      </td>
      <td class="dc"><?php echo $this->Html->cDateTimeHighlight($subscription['Subscription']['created']);?></td>
      <td class="dl">
        <?php if(!empty($subscription['Ip']['ip'])): ?>
        <?php echo  $this->Html->link($subscription['Ip']['ip'], array('controller' => 'subscriptions', 'action' => 'whois', $subscription['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$subscription['Ip']['ip'], 'escape' => false));
        ?>
        <p>
        <?php
        if(!empty($subscription['Ip']['Country'])):
        ?>
        <span class="flags flag-<?php echo strtolower($this->Html->cText($subscription['Ip']['Country']['iso_alpha2'], false)); ?>" title ="<?php echo $this->Html->cText($subscription['Ip']['Country']['name'], false); ?>">
        <?php echo $this->Html->cText($subscription['Ip']['Country']['name'], false); ?>
        </span>
        <?php
        endif;
        if(!empty($subscription['Ip']['City'])):
        ?>
        <span>   <?php echo $subscription['Ip']['City']['name']; ?>  </span>
        <?php endif; ?>
        </p>
        <?php else: ?>
        <?php echo __l('n/a'); ?>
        <?php endif; ?>
      </td>
    </tr>
      <?php
      endforeach;
      else:
      ?>
    <tr>
      <td colspan="5" class="errorc space"><i class="icon-warning-sign errorc"></i> <?php echo sprintf(__l('No %s available'), __l('Users'));?></td>
    </tr>
      <?php
      endif;
      ?>
	  <tbody>
  </table>
<?php
if (!empty($subscriptions)):
?>	<div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
				<?php echo __l('Select:'); ?></span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
				<?php echo $this->Html->link(__l('Enable'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"} hor-smspace grayc', 'title' => __l('Enable'))); ?>
				<?php echo $this->Html->link(__l('Disable'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"} hor-smspace grayc', 'title' => __l('Disable'))); ?>
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