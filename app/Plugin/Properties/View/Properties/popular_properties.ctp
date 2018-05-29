<?php
	if(!empty($popular_properties)) {
?>
<div class="container block-space">
          <h3 class="dc bot-space bot-mspace"><?php echo __l("Popular Properties"); ?></h3>
          <div class="ver-space clearfix">
			<ol class="text-16 span8 no-mar clearfix unstyled graydarkc">
<?php
	$z = 0;
	foreach($popular_properties as $property) {
		$z++;
		$class = "secondary";
		if($z%3 == 1) {
			$class = "default";
		} else if($z%3 == 2) {
			$class = "primary";
		}
?>                          
                <li class="sep-<?php echo $class; ?>-left medium-thumb ver-space <?php echo ($z%3 != 0)? "sep-bot" : "" ?> span8 no-mar">
                  <div class="span no-mar left-space"><span class="right-space show pull-left"><?php echo $z; ?>.</span>
					<?php echo $this->Html->link($this->Html->showImage('Property', (!empty($property['Attachment'][0]) ? $property['Attachment'][0] : ''), array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'class' => '', 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false, 'class' => 'show pull-left js-bootstrap-tooltip')) ;?>
				  </div>
                  <div class="span no-mar">
                    <div class="clearfix left-space">
                      <h4 class="span5 no-mar htruncate"> 
						<?php echo $this->Html->link($property['Property']['title'], array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false, 'class' => 'graydarkc js-bootstrap-tooltip'));?>
					 </h4>
                    </div>
                    <ul class="unstyled mob-inline small-thumb mob-clr top-mspace left-space clearfix pull-left">
						<?php
							$i = 0;
							for($i = 0; $i<6; $i++){
								if(!empty($property['User']['UserComment'][$i])) {
									if($i != 5) {
						?>
							<li class="pull-left">
								<?php echo $this->Html->getUserAvatar($property['User']['UserComment'][$i]['PostedUser'], 'medium_thumb', true, '', 'admin','','',false);?>
							</li>	
						<?php
									} else {
						?>
							<li class="pull-left sep dc">
								<?php echo  $this->Html->link(__l("More"), array('controller' => 'users', 'action' => 'view', $property['User']['username'], 'admin' => false, '#Recommendations'), array('target' => '_blank', 'class'=>'more show text-9', 'title' => __l("More"), 'escape' => false));
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
                  </div>
                </li> 
			  <?php
				if($z%3 == 0) {
				?>
					</ol>   
					<ol class="text-16 span8 no-mar clearfix unstyled graydarkc">
				<?php
				}
			  ?>              
<?php
	}	
?>          
			</ol>  
             
            
          </div>
        </div>
<?php
}			  
?>