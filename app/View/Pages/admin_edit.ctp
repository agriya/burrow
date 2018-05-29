<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Pages'), array('controller'=>'pages','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Edit Page'); ?></li>
</ul>
<?php
    if(!empty($page)):
        ?>
        <div class="js-tabs">
        <ul class="clearfix menu-tabs sep-top">
            <li><span><?php echo $this->Html->link(__l('Preview'), '#preview'); ?></span></li>
            <li><span><?php echo $this->Html->link(__l('Change'), '#add'); ?></span></li>
        </ul>
        <div id="preview">
            <div class="page">
                    <div class="entry">
                   <?php echo $page['Page']['content']; ?>
                </div>
            </div>
        </div>
        <?php
    endif;
?>
<div id="add">
  <div class="pages form">
		<?php echo $this->Form->create('Page', array('class' => 'form-horizontal space', 'enctype' => 'multipart/form-data')); ?>
		<fieldset>
			<?php
                echo $this->Form->input('id');
                echo $this->Form->input('title', array('between' => '', 'label' => __l('Page title')));
			?>
			<div class="required clearfix">
                <label class="pull-left" for="NodeBody"><?php echo __l('Body');?></label>
                <div class="input textarea bot-space span15 left-smspace">
                  <?php echo $this->Form->input('content', array('class' => 'js-editor pull-left', 'label' => false, 'div' => false)); ?>
                </div>
              </div>
		</fieldset>
		<fieldset>
			<?php
				echo $this->Form->input('meta_keywords', array('label' =>__l('Meta Keywords')));
				echo $this->Form->input('meta_description', array('type' => 'textarea', 'label' =>__l('Meta Description')));
			?>
        </fieldset>
		<div class="form-actions">
			<?php echo $this->Form->submit(__l('Update'), array('name' => 'data[Page][Update]', 'class' => 'space btn btn-large btn-primary textb text-16 pull-right','div'=>false)); ?>
			
				<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'pages', 'action' => 'index'), array('title' => 'Cancel', 'class' => 'space btn btn-large btn-primary textb text-16 pull-right','div'=>false));?>
			
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<?php if(!empty($page)): ?>
	</div>
<?php endif; ?>