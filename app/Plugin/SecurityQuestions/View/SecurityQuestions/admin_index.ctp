<section class="page-header no-mar ver-space mspace">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Security Questions         </li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
 <div class="clearfix">
	<?php 
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Active) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Enabled').'">'.__l('Enabled').'</dt>
						<dd title="'.$this->Html->cInt($approved,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($approved ,false).'</dd>                  	
					</dl>'
					, array('action'=>'index','filter_id' => ConstMoreAction::Active), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Inactive) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Disabled').'">'.__l('Disabled').'</dt>
						<dd title="'.$this->Html->cInt($pending,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($pending ,false).'</dd>                  	
					</dl>'
					, array('action'=>'index','filter_id' => ConstMoreAction::Inactive), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				$class = (empty($this->request->params['named']['filter_id'])) ? 'active' : null;
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Total').'">'.__l('Total').'</dt>
						<dd title="'.$this->Html->cInt($approved + $pending,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($approved + $pending,false).'</dd>                  	
					</dl>'
					, array('action'=>'index'), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
				
				?>
				</div><div class="clearfix dc">
					
					<div class="pull-right top-space mob-clr dc top-mspace">
					 
					<?php echo $this->Html->link('<span class="ver-smspace"><i class="icon-plus-sign no-pad top-smspace"></i></span>', array('action' => 'add'), array('escape' => false,'class' => 'add btn btn-primary textb text-18 whitec','title'=>__l('Add'))); ?>
				</div>
			
     
 </div>
  </div> </div>
	   <?php echo $this->element('paging_counter');?>
<?php echo $this->Form->create('SecurityQuestion', array('action' => 'update', 'method' => 'post')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
 <div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
	<thead>
	<tr class=" well no-mar no-pad">
      <th class="select span1 dc sep-right"><div><?php echo __l('Select'); ?></div> </th>
      <th class="dc sep-right"><div><?php echo __l('Actions'); ?></div> </th>
      <th class="dc sep-right"><div><?php echo $this->Paginator->sort('created', __l('Created'));?></div></th>
      <th class="d1 sep-right"><div><?php echo $this->Paginator->sort('name', __l('Question'));?></th>
    </tr>
    <?php foreach ($questions as $question): ?>
      <?php
		if($question['SecurityQuestion']['is_active'] == '1')  :
        $status_class = 'js-checkbox-active';
		$disabled = '';
		else:
          $status_class = 'js-checkbox-inactive';
          $disabled = 'class="disable"';
          endif;
      ?>
      <tr <?php echo $disabled; ?>>
        <td class="select dc"><?php echo $this->Form->input('SecurityQuestion.'. $question['SecurityQuestion']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$question['SecurityQuestion']['id'], 'label' => "", 'div' => 'top-space',  'class' => $status_class.' js-checkbox-list')); ?></td>

		<td class="span1 dc">
			<span class="dropdown"> <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur dropdown-toggle js-no-pjax"> <span class="hide">Action</span> </span>
				<ul class="dropdown-menu arrow no-mar dl">
					<li><?php echo $this->Html->link('<i class="icon-edit"></i>' . __l('Edit'), array('action' => 'edit', $question['SecurityQuestion']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'), 'escape' => false));?></li>
					<?php echo $this->Layout->adminRowActions($question['SecurityQuestion']['id']);  ?>
				</ul>
			</span>
		</td>

					
        <td class="dc"><?php echo $this->Html->cDateTimeHighlight($question['SecurityQuestion']['created']);?></td>
        <td><?php echo $question['SecurityQuestion']['name']; ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<section class="clearfix hor-mspace bot-space">
  <?php if (!empty($questions)) : ?>
    <div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
                        <?php echo __l('Select:'); ?></span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
				<?php echo $this->Html->link(__l('Enable'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"} hor-smspace grayc', 'title' => __l('Enable'))); ?>
				<?php echo $this->Html->link(__l('Disable'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"} hor-smspace grayc', 'title' => __l('Disable'))); ?>
             </div><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit js-no-pjax span5', 'div'=>false,'label' => false, 'empty' => __l('-- More actions --'))); ?>
         </div>
    <div class="hide">
      <?php echo $this->Form->submit('Submit');  ?>
    </div>
    <div class="pull-right"><?php echo $this->element('paging_links'); ?></div>
  <?php endif; ?>
</section>
<?php echo $this->Form->end(); ?>