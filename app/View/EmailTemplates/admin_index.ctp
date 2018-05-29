<div class="">
  <?php
    if(!empty($this->request->params['isAjax'])):
      echo $this->element('flash_message');
    endif;
  ?>
  <?php if (!empty($emailTemplates)): ?>
    <div class="accordion" id="accordion-admin-email-template">
      <?php foreach ($emailTemplates as $emailTemplate): ?>
        <?php $url= Router::url(array('controller' => 'email_templates', 'action' => 'edit', $emailTemplate['EmailTemplate']['id']),true);?>
        <div class="accordion-group">
          <div class="accordion-heading">
          <h6><a class="blackc accordion-toggle clearfix js-accordion-link js-toggle-icon js-no-pjax {'url':'<?php echo $url;?>','data_id':'<?php echo $emailTemplate['EmailTemplate']['id'];?>'}" href="#email-content-<?php echo $emailTemplate['EmailTemplate']['id'];?>" data-parent="#accordion-admin-email-template" data-toggle="collapse"><span class="pull-left"><?php echo $this->Html->cText($emailTemplate['EmailTemplate']['name'], false).' - '. '</span><span class="sfont textn pull-left top-smspace hor-space"><span class="htruncate">'.$this->Html->cText($emailTemplate['EmailTemplate']['description'], false).'</span></span>'; ?><i class="icon-plus pull-right top-smspace"></i></a></h6>
          </div>
          <div id="email-content-<?php echo $emailTemplate['EmailTemplate']['id'];?>"  class="accordion-body collapse">
          <div class="accordion-inner js-content-<?php echo $emailTemplate['EmailTemplate']['id'];?>"> </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="space dc grayc"><p class="ver-mspace top-space text-16 "><?php echo __l('No e-mail templates added yet.'); ?></p></div>
  <?php endif; ?>
</div>