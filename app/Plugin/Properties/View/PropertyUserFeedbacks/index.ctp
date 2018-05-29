<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="propertyUserFeedbacks js-response index property-feedbacks-block">
 
 <?php if (!empty($propertyUserFeedbacks)) { ?>
 <div class="space">
	<?php echo $this->element('paging_counter');?>
</div>
<?php } ?>
<ol class="unstyled  no-mar js-comment-responses clearfix" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($propertyUserFeedbacks)):
$i = 0;
 $num=1;
foreach ($propertyUserFeedbacks as $propertyUserFeedback):
?>
	<li class="sep-bot clearfix ver-space">
    		<div class="span">
        		<?php
					echo $this->Html->getUserAvatarLink($propertyUserFeedback['User'], 'small_thumb');
				?>
            </div>
			<div class="span22" >
			
			<div class="clearfix">
				<h5 class="pull-left"><?php echo $this->Html->link($this->Html->cText($propertyUserFeedback['User']['username']), array('controller'=> 'users', 'action' => 'view', $propertyUserFeedback['User']['username']), array('title' => $this->Html->cText($propertyUserFeedback['User']['username'],false), 'escape' => false));?></h5>
				<p class="pull-right"><?php echo __l('Reviewed on');?>  <?php echo $this->Time->timeAgoInWords($propertyUserFeedback['PropertyUserFeedback']['created']);?></p>
		
				</div>
				<?php
				if($propertyUserFeedback['PropertyUserFeedback']['is_satisfied']) 
					echo  '<i class="icon-thumbs-up-alt text-20"></i>'; 
				else
					echo '<i class="icon-thumbs-down-alt text-20"></i>';
				?>
        		<?php echo $this->Html->cText($propertyUserFeedback['PropertyUserFeedback']['feedback']);?>
    		</div>
	
	</li>
<?php
$num=$num+1;
    endforeach;
	else:
?>
	<li>
	<div class="space dc">
		<p class="ver-mspace top-space text-16"><?php echo __l('No Reviews available');?></p>
	</div>
	</li>
<?php
endif;
?>
</ol>
	<?php
if (!empty($propertyUserFeedbacks)) { ?>
	<div class="<?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?> clearfix space pull-right mob-clr dc">
<?php
		echo $this->element('paging_links'); ?>
	</div>
<?php	}
?>
</div>