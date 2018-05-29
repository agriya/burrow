<div class="regions index">
  <div class="clearfix">
  <div>
    <?php echo $this->element('paging_counter');?>
  </div>
  <div>
    <?php echo $this->Html->link(__l('Add Region'), array('controller' => 'regions', 'action' => 'add'), array('title' => __l('Add Region'))); ?>
  </div>
  </div>
<table class="table table-striped table-bordered table-condensed table-hover no-mar">
  <tr>
    <th><?php echo __l('Actions'); ?></th>
    <th><div><?php echo $this->Paginator->sort('title', __l('Title')); ?></div></th>
    <th><div><?php echo $this->Paginator->sort('alias', __l('Alias')); ?></div></th>
  </tr>
  <?php
    if (!empty($regions)):
    foreach ($regions AS $region) {
  ?>
    <tr>
    <td>
      <div>
      <span>
        <span>&nbsp;
        </span>
        <span>
        <span>
          <?php echo __l('Action');?>
        </span>
        </span>
      </span>
      <div>
        <div>
        <ul class="clearfix">
          <li><?php echo $this->Html->link(__l('Edit'), array('controller' => 'regions', 'action' => 'edit', $region['Region']['id']), array('title' => __l('Edit')));?>
          </li>
          <li><?php echo $this->Html->link(__l('Delete'), array('controller' => 'regions', 'action' => 'delete', $region['Region']['id']), array('class' => 'js-confirm', 'title' => __l('Delete')));?>
          </li>
          <?php echo $this->Layout->adminRowActions($region['Region']['id']);  ?>
        </ul>
        </div>
        <div></div>
      </div>
      </div>
    </td>
    <td><?php echo $this->Html->cText($region['Region']['title']);?></td>
    <td><?php echo $this->Html->cText($region['Region']['alias']);?></td>
    </tr>
  <?php
    }
    else:
  ?>
  <tr>
    <td colspan="5"><div class="space dc grayc"><p class="ver-mspace top-space text-16 "> <?php echo sprintf(__l('No %s available'), __l('Regions'));?></p></div></td>
  </tr>
  <?php
    endif;
  ?>
  </table>
  <div class="clearfix">
  <div>
    <?php echo $this->element('paging_links'); ?>
  </div>
  </div>
</div>