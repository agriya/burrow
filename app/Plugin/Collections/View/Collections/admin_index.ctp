<?php /* SVN: $Id: $ */ ?>
<div class="collections index js-response">
  <ul class="breadcrumb top-mspace ver-space">
	<li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
	<li class="active"><?php echo __l('Collections'); ?></li>
  </ul> 
  <div class="tabbable ver-space sep-top top-mspace">                
	<div id="list" class="tab-pane active in no-mar">
	  <div class="clearfix">
		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Active) ? 'active' : null;
		echo $this->Html->link( '
			<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
			<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Enabled').'">'.__l('Enabled').'</dt>
			<dd title="'.$this->Html->cInt($active ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($active ,false).'</dd>                  	
			</dl>'
			, array('controller'=>'collections','action'=>'index','filter_id' => ConstMoreAction::Active), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
			$class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 			ConstMoreAction::Inactive) ? 'active' : null;
		echo $this->Html->link( '
			<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
			<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Disabled').'">'.__l('Disabled').'</dt>
			<dd title="'.$this->Html->cInt($inactive ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($inactive ,false).'</dd>                  	
			</dl>'
			, array('controller'=>'collections','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));
			$class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'total') ? 'active' : null;
		echo $this->Html->link( '
			<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
			<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Total').'">'.__l('Total').'</dt>
			<dd title="'.$this->Html->cInt($active+$inactive ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($active+$inactive	 ,false).'</dd>                  	
			</dl>'
			, array('controller'=>'collections','action'=>'index','type' => 'total'), array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur'));?>
	  </div>
	  <div class="clearfix dc">
		<?php echo $this->Form->create('Collection', array('type' => 'get', 'class' => 'form-search bot-mspace big-input span', 'action'=>'index')); ?>
		<?php echo $this->Form->input('q', array('placeholder' => __l('Keyword'),'class'=>'span9 ver-mspace text-16','label' => false)); ?>
		<?php echo $this->Form->submit(__l('Search'), array('class'=>'btn btn-large hor-mspace btn-primary textb text-16'));?>
		<?php echo $this->Form->end(); ?>
		<div class="pull-right top-space mob-clr dc top-mspace">
		  <?php echo $this->Html->link('<span class="ver-smspace"><i class="icon-plus-sign no-pad top-smspace"></i></span>', array('controller' => 'collections', 'action' => 'add'), array('escape' => false,'class' => 'add btn right-mspace btn-primary textb text-18','title'=>__l('Add'))); ?>
		</div>
	  </div>				
	</div>
  </div>
  <?php echo $this->element('paging_counter');
  echo $this->Form->create('Collection' , array('class' => 'normal','action' => 'update'));
  echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <div class="ver-space">
	<div id="active-users" class="tab-pane active in no-mar">
	  <table class="table table-striped">
		<thead>
		  <tr class=" well no-mar no-pad">
			<th class="dc graydarkc sep-right span2"><?php echo __l('Select'); ?></th>
			<th class="dc graydarkc sep-right span2"><?php echo __l('Actions');?></th>
			<th class="dc graydarkc sep-right"><?php echo $this->Paginator->sort( 'created',__l('Created'));?></th>
			<th class="dl graydarkc sep-right"><?php echo $this->Paginator->sort( 'title',__l('Title'));?></th>
			<th class="dl graydarkc sep-right"><?php echo $this->Paginator->sort( 'description',__l('Description'));?></th>
			<th class="dc graydarkc sep-right"><?php echo $this->Paginator->sort( 'property_count',__l('Properties'));?></th>
			<th class="dc graydarkc sep-right"><?php echo $this->Paginator->sort( 'city_count',__l('Cities'));?></th>
			<th class="dc graydarkc sep-right"><?php echo $this->Paginator->sort( 'country_count',__l('Countries'));?></th>
		  </tr>
		</thead>
		<tbody>
		  <?php if (!empty($collections)):
			$i = 0;
			foreach ($collections as $collection):
			  $class = null;
			  $active_class = '';
			  if ($i++ % 2 == 0) {
				$class = 'altrow';
			  }
			  if($collection['Collection']['is_active']):
				$status_class = 'js-checkbox-active';
			  else:
				$active_class = 'disable';
				$status_class = 'js-checkbox-inactive';
			  endif;?>
			  <tr class="<?php echo $class.' '.$active_class;?>">
				<td class="dc"><?php echo $this->Form->input('Collection.'.$collection['Collection']['id'].'.id', array('type' => 'checkbox', 'id' =>	"admin_checkbox_".$collection['Collection']['id'], 'label' => "", 'div' => 'top-space', 'class' => $status_class.' js-checkbox-list')); ?></td>
				<td class="dc">
				  <span class="dropdown"> 
				    <span title="Actions" data-toggle="dropdown" class="graydarkc left-space hor-smspace icon-cog text-18 cur	dropdown-toggle"> <span class="hide">Action</span> </span>
					<ul class="dropdown-menu arrow no-mar dl">
					  <li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'edit', $collection['Collection']['id']), array('escape' => false,'class' => 'edit js-edit', 'title' => __l('Edit')));?></li>
					  <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $collection['Collection']['id']), array('escape' => false,'class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
					</ul>
				  </span>
				</td>
				<td class="dc"><?php echo $this->Html->cDateTime($collection['Collection']['created']);?></td>
				<td class="dl span8"><?php echo $this->Html->link($this->Html->cText($collection['Collection']['title']), array('controller'=> 'collections', 'action' => 'view', $collection['Collection']['slug'], 'admin' => false), array('escape' => false,'class' => 'js-no-pjax', 'title' => $collection['Collection']['title']));?></td>
				<td class="dl span10"><div class="htruncate js-bootstrap-tooltip span9 fluid-pull-left" title="<?php echo $collection['Collection']['description'];?>"><?php echo $this->Html->cText($collection['Collection']['description']);?></div></td>
				<td class="dc"><?php echo $this->Html->cInt($collection['Collection']['property_count']);?></td>
				<td class="dc"><?php echo $this->Html->cInt($collection['Collection']['city_count']);?></td>
				<td class="dc"><?php echo $this->Html->cInt($collection['Collection']['country_count']);?></td>		
			  </tr>
			<?php endforeach;
		  else:?>
			<tr>
			  <td colspan="9">
				<div class="space dc">
				  <p class="ver-mspace grayc top-space text-16 "><?php echo __l('No Collections available');?></p>
				</div>
			  </td>
			</tr>
		  <?php endif;?>
		</tbody>
	  </table>
	</div>
  </div>
  <?php if (!empty($collections)):?>
    <div class="clearfix">
	<div class="admin-select-block ver-mspace pull-left mob-clr dc">
	  <div class="span top-mspace">
		<span class="graydarkc">
		  <?php echo __l('Select:'); ?>
		</span>
		<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
		<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
		<?php echo $this->Html->link(__l('Enable'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"} hor-smspace grayc', 'title' => __l('Enable'))); ?>
		<?php echo $this->Html->link(__l('Disable'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"} hor-smspace grayc', 'title' => __l('Disable'))); ?>
	  </div>
	  <?php echo $this->Form->input('more_action_id', array('class' => 'span5 js-admin-index-autosubmit js-no-pjax', 'div'=>false,'label' => false, 'empty' => __l('-- More actions --'))); ?>            
	</div>
	<div class="js-pagination pagination pull-right no-mar mob-clr dc">
	  <?php echo $this->element('paging_links'); ?>
	</div>
	<div class="hide">
	  <?php echo $this->Form->submit(__l('Submit'));  ?>
	</div>
	</div>
  <?php endif;
  echo $this->Form->end();?>
</div>
