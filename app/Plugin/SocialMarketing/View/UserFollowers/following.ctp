<div class="userFriends index js-response">
<?php
	if(!$this->Auth->user('id')) {
?>
	<h2><?php echo $this->pageTitle;?></h2>
<?php } else { ?>
	<h2><?php echo __l('Following Users'); ?></h2>
<?php } ?>
	<ol class="friends-list clearfix js-response">
		<?php
		if (!empty($userFollowers)) {
		foreach ($userFollowers as $userFollower) {?>
			<li id="friend-<?php echo $userFollower['UserFollower']['id']; ?>" class="sep-bot clearfix ver-space dc list-row clearfix ">
			<?php
				echo $this->Html->getUserAvatar($userFollower['User'], 'medium_thumb');
			?>
        	<p class="meta-row author">
		        <cite><span title="<?php echo $userFollower['User']['username'];?>"><?php echo $this->Html->link($this->Html->cText($userFollower['User']['username']), array('controller'=> 'users', 'action' => 'view', $userFollower['User']['username']), array('escape' => false));?></span></cite>
		    </p>
			</li>
		<?php
		}
		} else {
		?>
		<li class="sep-bot clearfix ver-space">
			<div class="space dc grayc">
				<p class="ver-mspace top-space text-16 "><i class="icon-warning-sign errorc"></i><?php echo __l('No following users available');?></p>
			</div>
		</li>
		<?php
		}
		?>
	</ol>
	<div class="<?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?>">
		<?php
	if (!empty($userFriends)) {
	if(count($userFriends)>10):
		echo $this->element('paging_links');
	endif;
	}
	?>
</div>