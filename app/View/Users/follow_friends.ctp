<?php if (!empty($followFriends)): ?>
  <div class="js-response">
      <h3><?php echo __l('Follow Friends'); ?></h3>
  <div class="thumbnail clearfix">
      <?php echo $this->Form->create('UserFollower' , array('action' => 'add_multiple')); ?>
      <?php
        $url = Router::url(array(
          'controller' => 'social_marketings',
          'action' => 'import_friends',
          'type' => $this->request->params['named']['type']
        ), true);
      ?>
      <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $url)); ?>
      <div>
        <?php foreach($followFriends as $followFriend) { ?>
          <div class="bot-space clearfix">
            <span class="pull-left ver-space"><?php echo $this->Form->input('UserFollower.'.$followFriend['User']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$followFriend['User']['id'], 'div' => false, 'label' => '', 'class' => ' js-checkbox-list')); ?></span>
            <span class="pull-left ver-space"><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'view', $followFriend['User']['username'])); ?>" title="<?php echo $followFriend['User']['username']; ?>" class="blackc no-mar  dropdown-toggle js-no-pjax span show"><span class="pull-left  span"><?php echo $this->Html->getUserAvatar($followFriend['User'],  'micro_thumb',  0); ?></span><span class="span2 blackc hor-mspace htruncate"><?php echo $followFriend['User']['username']; ?></span></a></span>
          </div>
        <?php } ?>
      </div>
      <div class="submit-block hor-space pull-right"><?php echo $this->Form->submit(__l('Follow')); ?></div>
      <?php echo $this->Form->end(); ?>
      <div class="<?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?> js-no-pjax pull-right top-space"><?php echo $this->element('paging_links'); ?></div>
    </div>
  </div>
<?php endif; ?>