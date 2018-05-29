 <?php
	$foldertype = isset($folder_type) ? $folder_type : '';
	$is_starred = isset($is_starred) ? $is_starred : '';
	$compose = ( isset($this->request->params['action']) and ($this->request->params['action'] =='compose')) ? 'compose' : '';
	$contacts = ( isset($this->request->params['action']) and ($this->request->params['action'] =='contacts')) ? 'contacts' : '';
	$settings = ( isset($this->request->params['action']) and ($this->request->params['action'] =='settings')) ? 'settings' : '';
	echo $this->requestAction(array('controller'=>'messages','action'=>'left_sidebar'), array('return', 'folder_type'  => $foldertype, 'is_starred' => $is_starred, 'contacts' => $contacts,
	'compose' => $compose, 'settings' => $settings));
	?>