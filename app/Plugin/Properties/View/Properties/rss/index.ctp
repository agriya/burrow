<?php /* SVN: $Id: index.ctp 12757 2010-07-09 15:01:40Z jayashree_028ac09 $ */ ?>
  <?php if(!empty($properties)): ?>
      <?php
        foreach($properties as $property):
          $project_image = '';
          if(!empty($property['Attachment'])):
		    $image_url = getImageUrl('Property',$property['Attachment'][0], array('full_url' => true, 'dimension' => 'big_thumb'));
			$project_image = '<img src="'.$image_url.'" alt="'. sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)) .'" title="'. $this->Html->cText($property['Property']['title'], false) .'">';
          endif;
          $project_image = (!empty($project_image)) ? '<p>'.$project_image.'</p>':'';

          echo $this->Rss->item(array() , array(
              'title' => $property['Property']['title'],
              'link' => array(
                'controller' => 'projects',
                'action' => 'view',
                $property['Property']['slug']
              ) ,
              'description' => array(
				'value' => $project_image.'<p>'.$this->Html->cText($property['Property']['description']).'</p>',
				'cdata' => true,
				'convertEntities' => false,
			   )
            ));
        endforeach;
      ?>
  <?php endif; ?>
