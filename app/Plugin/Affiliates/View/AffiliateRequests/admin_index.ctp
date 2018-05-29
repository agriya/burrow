<?php /* SVN: $Id: $ */ ?>
<div class="affiliateRequests index">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Affiliate Requests        </li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
<div class="clearfix dc">
					<?php echo $this->Form->create('AffiliateRequest', array('method' => 'get', 'class' => 'form-search bot-mspace big-input span', 'action'=>'index')); ?>
					<?php echo $this->Form->input('q', array('placeholder' => __l('Keyword'),'class'=>'span9 ver-mspace text-16','label' => false)); ?>
					<?php echo $this->Form->submit(__l('Search'), array('class'=>'btn btn-large hor-mspace btn-primary textb text-16'));?>
					<?php echo $this->Form->end(); ?>
					<div class="pull-right top-space mob-clr dc top-mspace">
					<?php echo $this->Html->link('<span class="ver-smspace"><i class="icon-plus-sign no-pad top-smspace"></i></span>', array('controller' => 'affiliate_requests', 'action' => 'add'), array('escape' => false,'class' => 'add btn  btn-primary textb text-18','title'=>__l('Add'))); ?>
				</div>
			</div>
			<?php echo $this->element('paging_counter'); ?>
<?php echo $this->Form->create('AffiliateRequest' , array('class' => 'normal','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
 <div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
        <th class="sep-right dc"><?php echo __l('Select');?></th>
        <th class="sep-right dc span2"><?php echo __l('Actions');?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort( 'User.username',__l('User'));?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort( 'site_name',__l('Site'));?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort( 'site_url',__l('Site URL'));?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort( 'site_category_id',__l('Site Category'));?></th>
        <th class="dl sep-right"><?php echo $this->Paginator->sort( 'why_do_you_want_affiliate',__l('Why Do You Want Affiliate'));?></th>
        <th class="dc sep-right"><?php echo $this->Paginator->sort( 'is_web_site_marketing',__l('Website Marketing?'));?></th>
        <th class="dc sep-right"><?php echo $this->Paginator->sort('is_search_engine_marketing',__l('Search Engine Marketing?'));?></th>
        <th class="dc sep-right"><?php echo $this->Paginator->sort('is_email_marketing',__l('Email Marketing'));?></th>
         <th class="dl sep-right"><?php echo $this->Paginator->sort('special_promotional_method',__l('Promotional Method'));?></th>
        <th class="dc sep-right"><?php echo $this->Paginator->sort('is_approved',__l('Approved?'));?></th>
    </tr></thead><tbody>
<?php
if (!empty($affiliateRequests)):

$i = 0;
foreach ($affiliateRequests as $affiliateRequest):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	if($affiliateRequest['AffiliateRequest']['is_approved']):
		$status_class = 'js-checkbox-active';
	else:
		$status_class = 'js-checkbox-inactive';
	endif;
	
	
	}
?>
	<tr<?php echo $class;?>>
         <td class="select"><?php echo $this->Form->input('AffiliateRequest.'.$affiliateRequest['AffiliateRequest']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$affiliateRequest['AffiliateRequest']['id'], 'label' => "", 'div' => 'top-space', 'class' => $status_class.' js-checkbox-list')); ?></td>
		 
		<td class="dc"><span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle"> <span class="hide">Action</span> </span>
                                <ul class="dropdown-menu arrow no-mar dl">
        			<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'edit', $affiliateRequest['AffiliateRequest']['id']), array('escape' => false,'class' => 'edit js-edit', 'title' => __l('Edit')));?></li>
        			<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $affiliateRequest['AffiliateRequest']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
			   </ul>
   	  </span>
		</td>
			
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($affiliateRequest['User']['username']), array('controller'=> 'users', 'action'=>'view', $affiliateRequest['User']['username'], 'admin' => false), array('title' => $this->Html->cText($affiliateRequest['User']['username'], false), 'class'=>'js-no-pjax','escape' => false));?></td>
		<td class="dl"><?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['site_name']);?></td>
		<td class="dl"><div class="htruncate js-bootstrap-tooltip span5" title="<?php echo $affiliateRequest['AffiliateRequest']['site_url'];?>" ><?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['site_url']);?></div></td>
		<td class="dl"><?php echo $this->Html->cText($affiliateRequest['SiteCategory']['name']);?></td>
		<td class="dl"><div class="htruncate js-bootstrap-tooltip span5" title="<?php echo $affiliateRequest['AffiliateRequest']['why_do_you_want_affiliate'];?>" ><?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['why_do_you_want_affiliate']);?></div></td>
		<td class="dc"><?php echo $this->Html->cBool($affiliateRequest['AffiliateRequest']['is_web_site_marketing']);?></td>
		<td class="dc"><?php echo $this->Html->cBool($affiliateRequest['AffiliateRequest']['is_search_engine_marketing']);?></td>
		<td class="dc"><?php echo $this->Html->cBool($affiliateRequest['AffiliateRequest']['is_email_marketing']);?></td>
        <td class="dc"><div class="htruncate js-bootstrap-tooltip span4" title="<?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['special_promotional_method'],false);?>"><?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['special_promotional_method'], false);?></div></td>
		<td class="dc"><?php if($affiliateRequest['AffiliateRequest']['is_approved'] == 0){
					echo __l('Waiting for Approval');
				  } else if($affiliateRequest['AffiliateRequest']['is_approved'] == 1){
				  	echo __l('Approved');
				  } else if($affiliateRequest['AffiliateRequest']['is_approved'] == 2){
				  	echo __l('Rejected');
				  }
		?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="16">
			<div class="space dc">
				<p class="ver-mspace grayc top-space text-16 "><?php echo __l('No Affiliate Requests available');?></p>
			</div>
		</td>
	</tr>
<?php
endif;
?></tbody>
</table>
</div>
<?php
if (!empty($affiliateRequests)) :
        ?>
        <div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
                <?php echo __l('Select:'); ?>
				</span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
				<?php echo $this->Html->link(__l('Disapprove'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"} hor-smspace grayc', 'title' => __l('Disapprove'))); ?>
				<?php echo $this->Html->link(__l('Approve'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"} hor-smspace grayc', 'title' => __l('Approve'))); ?>
				<span class="hor-mspace">
		        </div><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit js-no-pjax span5', 'div'=>false,'label' => false, 'empty' => __l('-- More actions --'))); ?></span>
            <?php endif; ?>
         </div>
          <div class="js-pagination pagination pull-right no-mar mob-clr dc">
            <?php echo $this->element('paging_links'); ?>
        </div>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
        <?php
    echo $this->Form->end();
    ?>
</div>