<?php /* SVN: $Id: index.ctp 15559 2010-07-26 05:23:23Z sakthivel_135at10 $ */ ?>

<div class="js-response">
<h2>
<?php
if (empty($username)):
	echo __l('Recommendations');
endif;
?>
</h2>
<?php if (!empty($userComments)) { ?>
<div class="space">
<?php echo $this->element('paging_counter'); ?>
</div>
<?php } ?>
  <ol class="unstyled  no-mar js-comment-responses prop-list1" start="<?php echo $this->Paginator->counter(array('format' => '%start%')); ?>">
  <?php
if (!empty($userComments)):
    foreach($userComments as $userComment):
?>
	<li class="sep-bot clearfix ver-space" id="comment-<?php echo $userComment['UserComment']['id']; ?>">
	<?php if ($userComment['PostedUser']['id'] == $this->Auth->user('id')) { ?>
			<div class="span pull-left">
				<span class="dropdown"> 
				<span class="graylightc icon-cog text-18 left-space hor-smspace  cur dropdown-toggle" data-toggle="dropdown" title="Actions">  </span>
					<ul class="dropdown-menu arrow no-mar dl">
						<li>
						<?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('controller' => 'user_comments', 'action' => 'delete', $userComment['UserComment']['id']), array('class' => 'delete js-delete ', 'title' => __l('Delete'),'escape'=>false));?>
						</li>
					</ul>
				</span>
			</div>
		<?php } ?> 
	  <div class="span avtar-box"><?php 
				echo $this->Html->getUserAvatarLink($userComment['PostedUser'], 'small_thumb');
			?></div>
<?php if ($userComment['PostedUser']['id'] == $this->Auth->user('id')) { ?>	
	  <div class="span21">
	 <?php }else{ ?>
	  <div class="span22">
	 <?php } ?>
		<div class="clearfix">
		  <h5 class="pull-left"><?php echo $this->Html->link($userComment['PostedUser']['username'], array('controller' => 'users', 'action' => 'view', $userComment['PostedUser']['username']), array('escape' => false));?></h5>
		  <p class="pull-right"><?php echo __l('Recommended'); ?> <?php echo $this->Time->timeAgoInWords($userComment['UserComment']['created']) ;?></p>
		</div>
		 <?php echo $this->Html->cText(nl2br($userComment['UserComment']['comment']));?>
		 
	  </div>
	  
	</li>
	<?php
    endforeach;
else:
?>
	<li class='no-message'>
	<div class="space dc grayc">
		<p  class="ver-mspace top-space text-16"><?php echo __l('No Recommendations available'); ?></p>
	</div>
	</li>
<?php
endif;
?>
  </ol>
<?php
if (!empty($userComments)) { ?>
	<div class="js-pagination clearfix space pull-right mob-clr dc">
<?php
		echo $this->element('paging_links'); ?>
	</div>
<?php	}
?>
  <?php if($this->Auth->user('id') and $this->Auth->user('id') != $user['User']['id']): ?>
		<?php echo $this->element('../UserComments/add', array('config' => 'sec'));?>
	<?php endif; ?>
 </div>
          

