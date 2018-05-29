<?php /* SVN: $Id: admin_view.ctp 6866 2010-06-03 16:00:30Z senthilkumar_017ac09 $ */ ?>
<div class="userComments view">
<h2><?php echo __l('User Comment');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($userComment['UserComment']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Created');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($userComment['UserComment']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Modified');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($userComment['UserComment']['modified']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('User');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->getUserLink($userComment['User']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Posted User Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($userComment['UserComment']['posted_user_id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Comment');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($userComment['UserComment']['comment']);?></dd>
	</dl>
</div>

