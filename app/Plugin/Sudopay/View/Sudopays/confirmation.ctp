<?php /* SVN: $Id: $ */ ?>
<div class="sudopays index">
<section class="space">
<div class="thumbnail clearfix space">
	<h3>
		<?php
			echo __l('Payment Confirmation');			
		?>
	</h3>
	<div class="alert alert-info">
		<?php
			echo sprintf('Amount got revised from %s%s to %s%s as buyer is set to bear gateway fee', Configure::read('site.currency'),$amount,Configure::read('site.currency'),$sudopay_revised_amount);
		?>
	</div>
	<?php
		echo $this->Form->create('Sudopay', array('url' => array('controller' => 'sudopays', 'action'=> 'confirmation', $foreign_id,$transaction_type), 'class' => 'form-horizontal js-project-form clearfix','enctype' => 'multipart/form-data'));
	?>
	<div class = "space">
	<?php
		echo $this->Form->input('confirm', array('value' => '1', 'type' => 'hidden'));
		echo $this->Form->submit(__l('Confirm'), array('class' => 'btn btn-module', 'div' => false));
		echo $this->Html->link(__l("Cancel"),$redirect,array('class'=>'btn hor-mspace') );
		echo $this->Form->end();
	?>
	</div>
  </div>

</section>
</div>