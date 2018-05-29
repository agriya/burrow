 <div class="side-three-alt">
	<div class="side-three-curve">
            <div class="side-three-left-curve"></div>
            <div class="side-three-top-middle">
				<h2><?php echo __l('Messages'); ?></h2>
				<h3><?php echo $this->Html->link(__l('See All'),array('controller'=>'messages','action'=>'inbox'),array('title' => __l('See All'))); ?></h3>
			</div>
            <div class="side-three-right-curve"></div>
    </div>
    <div class="side-three-center">
       <p><?php echo __l('You have'); ?><span>
       <?php    if($inbox == 0) :
                    echo 'no new';
                 else:
                     echo $this->Html->link($this->Html->cHtml($inbox),array('controller'=>'messages','action'=>'inbox'),array('title' => $this->Html->cHtml($inbox)));
                endif;
		?>
        </span><?php echo __l('messages'); ?></p>
    </div>
    <div class="side-three-bottom">
      <div class="side-three-bottom-left"></div>
      <div class="side-three-bottom-middle"></div>
      <div class="side-three-bottom-right"></div>
   </div>
</div>