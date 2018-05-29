<?php 
if(!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'project') {
	echo $this->element('admin_panel_project_view', array('controller' => 'projects', 'action' => 'index', 'project' =>$project), array('plugin' => 'Projects'));
} else {
	echo $this->element('admin_panel_user_view');
}
?>