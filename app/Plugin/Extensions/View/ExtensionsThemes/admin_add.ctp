
   <ul class="breadcrumb top-mspace ver-space">
    <li><?php echo $this->Html->link(__l('Themes'), array('action' => 'index'),array('title' => __l('Themes')));?><span class="divider"> / </span></li>
    <li class="active"><?php echo __l('Upload Theme');?></li>
  </ul>
 <div class="sep-top">
    <?php
    echo $this->Form->create('Theme', array('url' => array('controller' => 'extensions_themes','action' => 'add',),'type' => 'file','class'=>'form-horizontal space'));
  ?>
  <div class="panel-container">
  <div id="add_form" class="tab-pane fade in active">
  <?php
    echo $this->Form->input('Theme.file', array('label' => __l('Upload'), 'type' => 'file',));
  ?>
  </div>
  </div>
  <div class="clearfix form-actions">
  <div class="pull-left">
    <?php  echo $this->Form->submit(__l('Upload'),array('class'=>'btn btn-large btn-primary textb text-16')); ?>
  </div>
  <div class="hor-mspace hor-space pull-left">
    <?php
      echo $this->Html->link(__l('Cancel'), array( 'action' => 'index',), array('class' => 'btn btn-large textb text-16'));
    ?>
  </div>
  </div>
    <?php echo $this->Form->end();?>
</div>

