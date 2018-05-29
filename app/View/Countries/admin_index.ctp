<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="countries index js-response">
<ul class="breadcrumb top-mspace ver-space">
              <li><?php echo $this->Html->link(__l('Dashboard'), array('controller'=>'users','action'=>'stats'), array('class' => 'js-no-pjax', 'escape' => false));?> <span class="divider">/</span></li>
              <li class="active">Countries       </li>
            </ul> 
            <div class="tabbable ver-space sep-top top-mspace">
                <div id="list" class="tab-pane active in no-mar">
<div class="clearfix dc">
					<?php echo $this->Form->create('Country', array('method' => 'get', 'class' => 'form-search bot-mspace big-input span', 'action'=>'index')); ?>
					<?php echo $this->Form->input('q', array('placeholder' => __l('Keyword'),'class'=>'span9 ver-mspace text-16','label' => false)); ?>
					<?php echo $this->Form->submit(__l('Search'), array('class'=>'btn btn-large hor-mspace btn-primary textb text-16'));?>
					<?php echo $this->Form->end(); ?>
					<div class="pull-right top-space mob-clr dc top-mspace">
					<?php echo $this->Html->link('<span class="ver-smspace"><i class="icon-plus-sign no-pad top-smspace"></i></span>', array('controller' => 'countries', 'action' => 'add'), array('escape' => false,'class' => 'add btn  btn-primary textb text-18','title'=>__l('Add'))); ?>
				</div>
			</div>
			<?php echo $this->element('paging_counter'); ?>
            <?php echo $this->Form->create('Country' , array('action' => 'update','class'=>'normal'));?>
            <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
           <div class="ver-space">
                    <div id="active-users" class="tab-pane active in no-mar">
     <table class="table no-round table-striped">
      <thead>
        <tr>
          <th rowspan="2" class="select span1 dc graydarkc"><?php echo __l('Select');?></th>
          <th rowspan="2" class="dc graydarkc"><?php echo __l('Actions');?></th>
          <th rowspan="2" class="dl"><div><?php echo $this->Paginator->sort('name');?></div></th>
          <th rowspan="2" class="dl"><div><?php echo $this->Paginator->sort('fips_code');?></div></th>
          <th rowspan="2" class="dl"><div><?php echo $this->Paginator->sort('iso_alpha2');?></div></th>
          <th rowspan="2" class="dl"><div><?php echo $this->Paginator->sort('iso_alpha3');?></div></th>
          <th rowspan="2" class="dc"><div><?php echo $this->Paginator->sort('iso_numeric');?></div></th>
          <th rowspan="2" class="dl"><div><?php echo $this->Paginator->sort('capital');?></div></th>
          <th colspan="2" class="dc graydarkc"><?php echo __l('Currency');?></th>
        </tr>
        <tr>
          <th class="dl"><div><?php echo $this->Paginator->sort('currency',__l('Name'));?></div></th>
          <th class="dl"><div><?php echo $this->Paginator->sort('currency_code',__l('Code'));?></div></th>
        </tr>
      </thead>
				<tbody>
                <?php
                if (!empty($countries)):
                    $i = 0;
                    foreach ($countries as $country):
                        $class = null;
                         $active_class = '';
                        if ($i++ % 2 == 0) :
                             $class = 'altrow';
                        endif;
                        ?>
          <tr>
            <td class="select dc">
              <?php echo $this->Form->input('Country.'.$country['Country']['id'].'.id',array('type' => 'checkbox', 'id' => "admin_checkbox_".$country['Country']['id'],'label' => '' , 'div' => 'top-space', 'class' => 'js-checkbox-list')); ?>
            </td>
            <td class="span1 dc">
              <div class="dropdown top-space">
                <a href="#" title="Actions" data-toggle="dropdown" class="icon-cog blackc text-20 dropdown-toggle js-no-pjax"><span class="hide">Action</span></a>
                <ul class="unstyled dropdown-menu dl arrow clearfix">
                  <li>
                    <?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array( 'action'=>'edit', $country['Country']['id']), array('class' => '','escape'=>false, 'title' => __l('Edit')));?>
                  </li>
                  <li>
                    <?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), Router::url(array('action'=>'delete',$country['Country']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
                    <?php echo $this->Layout->adminRowActions($country['Country']['id']);?>
                  </li>
                <?php echo $this->Layout->adminRowActions($country['Country']['id']); ?>
                </ul>
              </div>
            </td>
            <td class="dl"><?php echo $this->Html->cText($country['Country']['name']);?></td>
            <td class="dl"><?php echo $this->Html->cText($country['Country']['fips_code']);?></td>
            <td class="dl"><?php echo $this->Html->cText($country['Country']['iso_alpha2']);?></td>
            <td class="dl"><?php echo $this->Html->cText($country['Country']['iso_alpha3']);?></td>
            <td class="dc"><?php echo $this->Html->cText($country['Country']['iso_numeric']);?></td>
            <td class="dl"><?php echo $this->Html->cText($country['Country']['capital']);?></td>
            <td class="dl"><?php echo $this->Html->cText($country['Country']['currencyname']);?></td>
            <td class="dl"><?php echo $this->Html->cText($country['Country']['currency']);?></td>
          </tr>
                        <?php
                    endforeach;
                else:
                    ?>
                    <tr>
                        <td colspan="19"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No Countries available');?></p></div></td>
                    </tr>
                    <?php
                endif;
                ?></tbody>
            </table>
            <?php if (!empty($countries)): ?>
           <div class="admin-select-block ver-mspace pull-left mob-clr dc"><div class="span top-mspace">
       <span class="graydarkc">
                <?php echo __l('Select:'); ?>
				</span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"} hor-smspace grayc', 'title' => __l('None'))); ?>
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