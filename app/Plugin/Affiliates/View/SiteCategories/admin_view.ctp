<?php /* SVN: $Id: $ */ ?>
<div class="siteCategories view">
<h2><?php echo __l('Site Category');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($siteCategory['SiteCategory']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Created');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($siteCategory['SiteCategory']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Modified');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($siteCategory['SiteCategory']['modified']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Name');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($siteCategory['SiteCategory']['name']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Slug');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($siteCategory['SiteCategory']['slug']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Is Active');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cBool($siteCategory['SiteCategory']['is_active']);?></dd>
	</dl>
</div>

