<h2><?php echo __l('Activate your account'); ?></h2>
<?php
	if(!empty($show_resend)):
		echo sprintf(__l('You have not yet activated your account. Please activate it. If you have not received the activation mail, %s to resend the activation mail.'), $this->Html->link('click here', $resend_url));
	endif;
?>