      <div id="ajax-tab-container-review" class="js-tabs  clearfix">
		<ul class="nav nav-tabs top-space top-mspace">
				<li><?php echo $this->Html->link(__l('Reviews'), array('controller' => 'property_feedbacks', 'action' => 'index','property_id' =>$property_id,'type'=>'property','view'=>'compact'), array('title' => __l('Reviews'), 'class' => 'js-no-pjax', 'data-target'=>'#Reviews_items','data-toggle'=>'tab'));?></li>
				<li><?php echo $this->Html->link(__l('Guest Photos'), array('controller' => 'property_feedbacks', 'action' => 'index','property_id' =>$property_id,'type'=>'photos','view'=>'compact'), array('title' => __l('Photos'), 'class' => 'js-no-pjax', 'data-target'=>'#Top_comments','data-toggle'=>'tab'));?></li>
				<li><?php echo $this->Html->link(__l('Guest Videos'), array('controller' => 'property_feedbacks', 'action' => 'index','property_id' =>$property_id,'type'=>'videos','view'=>'compact'), array('title' => __l('Videos'), 'class' => 'js-no-pjax', 'data-target'=>'#All_users','data-toggle'=>'tab'));?></li>
		</ul>
     <div class="sep-right sep-left sep-bot tab-round tab-content clearfix">
	    <div id="Shopping_friends"></div>
        <div id="Reviews_items"></div>
        <div id="Top_comments"></div>
        <div id="All_users"></div>
        </div>
    </div>