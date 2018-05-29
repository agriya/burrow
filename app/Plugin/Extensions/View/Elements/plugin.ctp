<div class="<?php echo 'offset' . ($depth+1); ?> space">
  <div class="clearfix">
   <div class="span2 pull-left plug-img dc top-space">
<?php $image_plugin_icons = array(
			'donate-s',
			'pledge-s',
			'lend-s',
			'invest-s',
			'touch',
			'sudopay',
		);
		if (in_array($pluginData['icon'], $image_plugin_icons)):
			echo $this->Html->image($pluginData['icon'].'-icon' . '.png');
		else :
			echo '<i class="icon-'.$pluginData['icon'].' text-46"></i>';
		endif; ?>
	 </div>
    <div class="span18 top-space">
      <h4><?php echo $this->Html->cText($pluginData['name']); ?></h4>
      <div class="grayc top-space"><?php echo $pluginData['description']; ?></div>
    </div>
	<div class="span3 pull-right top-space">
	  <div class="row-fluid">
		<div class="pull-right">
		  <div class="btn-group">
			<button class="btn <?php echo (!empty($pluginData['active'])) ? '' : 'disabled grayc'; ?>"><?php echo (!empty($pluginData['active'])) ? __l('Enabled') : __l('Disabled'); ?></button>
			<button data-toggle="dropdown" class="btn dropdown-toggle js-no-pjax"><i class="icon-cog"></i><span class="caret"></span></button>
			<ul class="dropdown-menu arrow arrow-right pull-right">
			  <?php if(!empty($pluginData['disable']) || empty($pluginData['active'])) { ?>
			  <li><?php echo $this->Html->link((!empty($pluginData['active'])) ? '<i class="icon-minus-sign"></i>'.__l('Disable') : '<i class="icon-plus-sign"></i>'.__l('Enable'), array('action' => 'toggle', $pluginData['plugin_folder_name']), array('escape' => false, 'class' => 'js-confirm js-no-pjax', 'title' => !empty($pluginData['active']) ? __l('Disable') : __l('Enable') )); ?></li>
			  <?php } ?>
			  <?php if (!empty($pluginData['settings']) && $pluginData['active']) { ?>
				<?php if ($pluginData['name'] == ConstPaymentGatewaysName::SudoPay) { ?>
					<li><?php echo $this->Html->link('<i class="icon-cog"></i>' . __l('Settings'), array('controller' => 'payment_gateways', 'action' => 'edit', ConstPaymentGateways::SudoPay), array('escape'=>false,'title' => __l('Settings')));?></li>
				<?php } else { ?>
				  <li><?php echo $this->Html->link('<i class="icon-cog"></i>' . __l('Settings'), array('controller' => 'settings', 'action' => 'plugin_settings', $pluginData['plugin_folder_name']), array('escape'=>false,'title' => __l('Settings')));?></li>
				<?php } ?>
			  <?php } ?>
			  <?php if(!empty($pluginData['delete'])) { ?>
			  <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $pluginData['plugin_folder_name']), array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?></li>
			  <?php } ?>
			</ul>
		  </div>
		</div>
	  </div>
	</div>
  </div>
  <div class="sep-bot bot-space"></div>
</div>