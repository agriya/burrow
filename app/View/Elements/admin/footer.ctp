  <footer id="footer" class="sep-top sep-medium hor-space" itemscope itemtype="http://schema.org/WPFooter">
    <div class="container-fluid clearfix top-space">
      <div class="clearfix top-space graydarkc">
        <p class="span" itemprop="copyrightYear">&copy; <?php echo date('Y');?> <?php echo $this->Html->link(Configure::read('site.name'), '/', array('title' => Configure::read('site.name'),'class' => 'site-name', 'escape' => false, "itemprop"=>"copyrightHolder"));?>. <?php echo __l('All rights reserved');?>. </p>		
        <p class="clearfix span"><span class="pull-left"><a href="http://burrow.dev.agriya.com" title="<?php echo 'Powered by Burrow'; ?>" target="_blank" class="powered pull-left"><?php echo 'Powered by Burrow'; ?></a>,</span> <span class="pull-left"><?php echo __l('Made in'); ?></span> <?php echo $this->Html->link('Agriya Web Development', 'http://www.agriya.com/', array('target' => '_blank', 'title' => 'Agriya Web Development', 'class' => 'company pull-left js-no-pjax'));?></p>
        <p id="cssilize"><?php echo $this->Html->link('CSSilized by CSSilize, PSD to XHTML Conversion', 'http://www.cssilize.com/', array('target' => '_blank', 'title' => 'CSSilized by CSSilize, PSD to XHTML Conversion', 'class' => 'cssilize js-no-pjax'));?></p>
      </div>
    </div>
  </footer>