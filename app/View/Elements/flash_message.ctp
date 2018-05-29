<?php
	if ($this->Session->check('Message.error')):
		echo $this->Session->flash('error');
	endif;
	if ($this->Session->check('Message.success')):
		echo $this->Session->flash('success');
	endif;
	if ($this->Session->check('Message.flash')):
			echo $this->Session->flash();
	endif;//view_compact
?>