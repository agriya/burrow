<div class ="ver-space clearfix sep-bot top-mspace ">
	<h2 class="text-32 span"><?php echo $this->Html->cText($page['Page']['title'], false); ?></h2>
	<?php echo ($page['Page']['slug'] == 'affiliate') ? $this->element('sidebar', array('config' => 'sec')) : ''; ?>
</div>
<div class="space">
<?php echo $page['Page']['content']; ?>
<?php if($this->request->params['pass'][0]=='order-purchase-completed'): ?>
<div class="form-actions clearfix">
<?php if(isset($this->request->params['named']['property-id']) && isPluginEnabled('SocialMarketing')) {?>
	
		<?php echo $this->Html->link(__l('Share'), array('controller' => 'social_marketings', 'action' => 'publish', $this->request->params['named']['property-id'], 'type' => 'facebook', 'publish_action' => 'add', 'admin' => false), array('class' => 'list-property span btn btn-large btn-primary textb text-16', 'title' => __l('Share')));?>
	
<?php } ?>
	
		<?php echo $this->Html->link(__l('Continue'), array('controller' => 'property_users', 'action' => 'index', 'type' => 'mytours', 'status' => 'waiting_for_acceptance', 'view' => 'list', 'admin' => false), array('class' => 'cancel-order pull-right btn btn-large btn-primary textb text-16 span', 'title' => __l('Continue')));?>
	</div>
<?php endif; ?>
	</div>