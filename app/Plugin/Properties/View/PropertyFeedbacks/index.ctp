<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="js-response js-responses">
 
<ol class="unstyled no-mar prop-list-mob prop-list clearfix" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($propertyFeedbacks)):
$i = 0;
 $num=1;
foreach ($propertyFeedbacks as $propertyFeedback):
	$icon = ($propertyFeedback['PropertyFeedback']['is_satisfied']) ? ' <i class="icon-thumbs-up-alt text-16 greenc"></i>' : ' <i class="icon-thumbs-down-alt text-16 redc"></i>';
?>
	<li class="clearfix ver-space sep-bot left-mspace mob-no-mar">
	 <?php if(isset($this->request->params['named']['user_id'])): ?>
		<div class="span dc no-mar mob-no-pad"><span class="label label-important textb show text-11 prop-count map_number"><?php echo $num; ?></span></div>
		<div class="span">
    	  <?php
			echo $this->Html->link($this->Html->showImage('Property', $propertyFeedback['Property']['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($propertyFeedback['Property']['title'], false)), 'title' => $this->Html->cText($propertyFeedback['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $propertyFeedback['Property']['slug'],  'admin' => false), array('title'=>$this->Html->cText($propertyFeedback['Property']['title'],false),'escape' => false));
    	 ?>
	 </div>
	 <?php endif; ?>
		<div class="2">
    		<div class="span hor-space avtar-box">
        		<?php
					echo $this->Html->getUserAvatarLink($propertyFeedback['PropertyUser']['User'], 'small_thumb');
				?>
            </div>
			
        	<div class="clearfix"> 
			<?php if(isset($this->request->params['named']['user_id'])): ?>
				<h5 class="no-pad pull-left">
				<?php 
				echo $this->Html->link($this->Html->cText($propertyFeedback['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $propertyFeedback['Property']['slug'], 'admin' => false), array('title'=>$this->Html->cText($propertyFeedback['Property']['title'], false),'escape' => false)); ?>
				</h5>
			<?php else: ?>
        		<h5 class="no-pad pull-left"><?php echo $this->Html->link($this->Html->cText($propertyFeedback['PropertyUser']['User']['username']), array('controller'=> 'users', 'action' => 'view', $propertyFeedback['PropertyUser']['User']['username']), array('title' => $this->Html->cText($propertyFeedback['PropertyUser']['User']['username'],false), 'escape' => false));?></h5>
		<?php endif; ?>
			
				<div class="pull-right right-mspace clearfix">
        				 <?php echo __l('Reviewed ');?><?php echo $this->Time->timeAgoInWords($propertyFeedback['PropertyFeedback']['created']);?>
				</div>
			<div class="span18 top-space">
        		 <p class="left-space"><?php echo $icon; ?><?php echo $this->Html->cText($propertyFeedback['PropertyFeedback']['feedback']);?></p>
			</div>
    		</div>
		</div>
	</li>
<?php
$num=$num+1;
    endforeach; ?>
	</ol>
<?php 	else:
?>
	<ol class="unstyled">
	<li>
	<div class="space dc grayc">
		<p class="ver-mspace top-space text-16"><?php echo __l('No Reviews available');?></p>
	</div>
	</li>
	</ol>
<?php
endif;
?>

	<div class="<?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?> clearfix space pull-right mob-clr dc">
		<?php
		if (!empty($propertyFeedbacks)) {
			
			echo $this->element('paging_links');
			}
		?>
	</div>
</div>