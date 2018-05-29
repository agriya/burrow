<?php /* SVN: $Id: index.ctp 9088 2012-08-13 12:20:30Z rajeshkhanna_146ac10 $ */ ?>
	<?php if (!empty($cities)): ?>
	<?php //pr($cities); ?>
		 <div class="span24 no-mar ver-space">
		 <div class="span8 no-mar">
            <ol class="unstyled">
			<?php 
			$classCount = 1;
			foreach ($cities as $key => $city):
						$url = Router::url('/',true) . $city['City']['slug'] . '/properties';
						if($classCount <= 2)
							$liClass = ' sep-default-left';
						else if($classCount <= 4)
							$liClass = ' sep-primary-left';
						else
							$liClass = ' sep-secondary-left';
						++$classCount;
					?>
					<li class="bot-space span8 htruncate<?php echo $liClass; ?>">
							<span class="hor-space pull-left">
							  <?php if($key < 9) {
								  echo '0' . __l(($key + 1).'.'); 
							  } else {
								  echo __l(($key + 1).'.'); 
							  }?></span>	
						<?php 
							$CCname = $city['City']['name'].', '.$city['Country']['name'];
							echo $this->Html->link('<span class="flags top-smspace flag-'. strtolower($city['Country']['iso_alpha2']) .'" title ="'.$CCname.'"></span>' . ' <span class="">' . $CCname .'</span>' , $url, array('title' => $CCname , 'escape' => false, 'class' => 'graydarkc'));
						?>						
					</li>
					<?php if(($key + 1) % 6  == 0) : $classCount =1; ?>
				 </ol>
                </div>
                <div class="span8">
                  <ol class="unstyled">
				<?php endif; 
				endforeach;
				?>
				
				</ol>
                </div>
              </div>
	
	<?php endif ?>