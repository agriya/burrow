<?php /* SVN: $Id: $ */ ?>
<div class="propertyUsers form">
<?php 
echo $this->Form->create('PropertyUser', array('class' => 'normal js-ajax-form')); ?>
	<fieldset>
	 <?php
	  echo $this->Form->input('property_id',array('type'=>'hidden'));
	  echo $this->Form->input('property_slug',array('type'=>'hidden'));
	  echo $this->Form->input('price',array('type'=>'hidden'));
	  echo $this->Form->input('checkin',array('type'=>'date', 'orderYear' => 'asc'));
	  echo $this->Form->input('checkout',array('type'=>'date', 'orderYear' => 'asc')); 
	  ?>
	</fieldset>
<?php echo $this->Form->end(__l('Book it!')); ?>
</div>

