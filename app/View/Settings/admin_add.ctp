<?php
	echo $this->Form->create('Setting', array('class' => 'normal'));
	echo $this->Form->input('name');
	echo $this->Form->input('value');
	echo $this->Form->input('description');
	echo $this->Form->input('type', array('type' => 'select', 'options' => array('text' => 'text', 'textarea' => 'textarea', 'checkbox' => 'checkbox', 'radio' => 'radio', 'password' => 'password')));
	echo $this->Form->input('label');
	echo $this->Form->end('Add');
	echo $this->Html->link(__l('Cancel'), array('controller' => 'settings', 'action' => 'index'),array('title' => __l('Cancel')));
?>