<div class="install form">
    <h2><?php echo $title_for_layout; ?></h2>
	<iframe frameborder="0" width="630px" height="80px" src="http://installer.dev.agriya.com/info4.html"></iframe>
	<?php
		Configure::write('debug', 0);
			echo $this->Form->create('Install', array('url' => array('controller' => 'install', 'action' => 'license'), 'class' => 'normal')); ?>
	<div class="content-block round-4">
			<?php 
			echo $this->Form->input('Install.license', array('label' => 'License Key')); ?>
	</div>
	<div class="clearfix">
		<div class="grid_right">
			<?php echo $this->Form->submit('Submit'); ?>
		</div>
	</div>
		<?php echo $this->Form->end(); ?>
</div>