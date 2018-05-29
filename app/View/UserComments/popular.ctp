<?php
		$pull_class = 'unstyled mob-inline medium-thumb mob-clr top-space clearfix pull-right';
		$thumb_size = 'medium_thumb';
		if(!empty($this->request->params['named']['page'])) {
			if($this->request->params['named']['page'] == 'home') {
				$thumb_size = 'small_thumb';
				$pull_class = 'unstyled small-thumb top-mspace left-space clearfix';
			} else if($this->request->params['named']['page'] == 'listing') {
				$pull_class = 'unstyled mob-inline medium-thumb mob-clr top-space clearfix pull-left';
			}else if($this->request->params['named']['page'] == 'my_request') {
				$pull_class = 'unstyled medium-thumb mob-clr top-space clearfix pull-left mob-inline';
			}
		}
?>
<ul class="<?php echo $pull_class; ?>">
	<?php
		$i = 0;
		for($i = 0; $i<6; $i++){
			if(!empty($userComments[$i])) {
				if($i != 5) {
	?>
		<li class="pull-left">
			<?php echo $this->Html->getUserAvatar($userComments[$i]['PostedUser'], $thumb_size, true, '', 'admin','','',false);?>
		</li>	
	<?php
				} else {
	?>
		<li class="pull-left sep dc">
			<?php echo  $this->Html->link(__l("More"), array('controller' => 'users', 'action' => 'view', $userComments[$i]['User']['username'], 'admin' => false, '#Recommendations'), array('target' => '_blank', 'class'=>'more show text-9', 'title' => __l("More"), 'escape' => false));
			?>
		</li>
	<?php
				}
			} else {
				?>
		<li class="pull-left sep"></li>
				<?php
			}
	}	
	?>
</ul>