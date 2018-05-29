<?php if (empty($this->request->params['isAjax'])) { ?>
<div class="span23">
  <div class="js-response">
  <div class="ver-space top-mspace  clearfix sep-bot">
	<h2 class="span text-32"><?php echo __l('Followers');?></h2>
	<?php echo $this->element('sidebar', array('config' => 'sec')); ?></div>
<?php } ?>
<?php
	if (!empty($userFollowers)) {?>
		<div class="space"> <?php echo $this->element('paging_counter');?> </div>
	<?php
	}
	?>
   <ol class="friends-list unstyled clearfix top-space">
		<?php
		if (!empty($userFollowers)) {
		foreach ($userFollowers as $userFollower) { 
		?>
			<li id="friend-<?php echo $userFollower['UserFollower']['id']; ?>" class="dc span2 pull-left  list-row clearfix sep space">
			<span class="span">
			<?php
				echo $this->Html->getUserAvatar($userFollower['FollowUser'], 'medium_thumb', true);
			?>
        	<p class="meta-row author">
		        <span title="<?php echo $userFollower['FollowUser']['username'];?>"><?php echo $this->Html->link($this->Html->cText($userFollower['FollowUser']['username']), array('controller'=> 'users', 'action' => 'view', $userFollower['FollowUser']['username']), array('class' => 'grayc htruncate span1', 'escape' => false));?></span>
		    </p>
			</span>
			</li>
		<?php
		}
		} else {
		?>
		<li>
			<div class="space dc grayc">
   	<p class="ver-mspace top-space text-16">
				<?php
					echo __l('No Followings available');
				?></p></div>
		</li>
		<?php
		}
		?>
	</ol>
	<?php if (!empty($userFollowers)) {?>
		<div class="<?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?> paging clearfix space pull-right mob-clr"> <?php echo $this->element('paging_links'); ?> </div>
	<?php }?>
</div>
<?php if (empty($this->request->params['isAjax'])) { ?>
  </div>
</div>
<?php } ?>