<?php /* SVN: $Id: admin_add.ctp 66983 2011-09-27 11:09:58Z josephine_065at09 $ */ ?>
<ul class="breadcrumb">
	<li>
	  <?php echo $this->Html->link(__l('Banned IPs'), array('action' => 'index'), array('title' => __l('Banned IPs')));?>
	  <span class="divider">/</span>
	</li>
	<li class="active">
	  <?php echo sprintf(__l('Add %s'), __l('Banned IP'));?>
	</li>
</ul>
<div class="bannedIps form space sep-top top-mspace">
  <div class="panel-container">
    <div id="add_form" class="tab-pane fade in active">
      <div class="js-corner" id="form-content">
        <?php echo $this->Form->create('BannedIp', array('class' => 'form-horizontal form-large-fields'));?>
          <legend><h3 class="well space textb text-16 no-mar"><?php echo __l('Current User Information'); ?></h3></legend>
          <dl class="clearfix dl-horizontal">
            <dt><?php echo __l('Your IP: ');?></dt>
            <dd><?php echo $ip;?></dd>
            <dt><?php echo __l('Your Hostname: ');?></dt>
            <dd><?php echo gethostbyaddr($ip);?></dd>
          </dl>
          <legend><h3 class="well space textb text-16 no-mar"><?php echo __l('Ban Type'); ?></h3></legend>
          <legend><h4><?php echo __l('Possibilities:'); ?></h4></legend>
          <p><?php echo __l('- Single IP/Hostname: Fill in either a hostname or IP address in the first field.'); ?></p>
          <p><?php echo __l('- IP Range: Put the starting IP address in the left and the ending IP address in the right field.'); ?></p>
          <p><?php echo __l('- Referer block: To block google.com put google.com in the first field. To block google altogether.'); ?></p>
          <?php
            echo $this->Form->input('type_id', array('type' => 'radio', 'label' => __l('Select method'),'legend' => false));
            echo $this->Form->input('address', array('label' => __l('Address/Range')));
            echo $this->Form->input('range', array('label' => '', 'info' => __l('(IP address, domain or hostname)')));
          ?>
          <legend><h3 class="well space textb text-16 no-mar"><?php echo __l('Ban Details'); ?></h3></legend>
          <?php
            echo $this->Form->input('reason', array('label' => __l('Reason'),'info' => __l('(optional, shown to victim)')));
            echo $this->Form->input('redirect', array('label' => __l('Redirect'),'info' => __l('(optional)')));
            echo $this->Form->input('duration_id', array('label' => __l('How long')));
            echo $this->Form->input('duration_time', array('label' => '', 'info' => __l('Leave field empty when using permanent. Fill in a number higher than 0 when using another option!')));
          ?>
          <legend><h4><?php echo __l('Hints and tips:'); ?></h4></legend>
          <p><?php echo __l('- Banning hosts in the 10.x.x.x / 169.254.x.x / 172.16.x.x or 192.168.x.x range probably won\'t work.'); ?></p>
          <p><?php echo __l('- Banning by internet hostname might work unexpectedly and resulting in banning multiple people from the same ISP!'); ?></p>
          <p><?php echo __l('- Wildcards on IP addresses are allowed. Block 84.234.*.* to block the whole 84.234.x.x range!'); ?></p>
          <p><?php echo __l('- Setting a ban on a range of IP addresses might work unexpected and can result in false positives!'); ?></p>
          <p><?php echo __l('- An IP address always contains 4 parts with numbers no higher than 254 separated by a dot!'); ?></p>
          <p><?php echo __l('- If a ban does not seem to work try to find out if the person you\'re trying to ban doesn\'t use <a href="http://en.wikipedia.org/wiki/DHCP" target="_blank" title="DHCP">DHCP.</a>'); ?></p>
          <div class="form-actions">
            <div class = "pull-left" >
              <?php echo $this->Form->submit(__l('Add'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
            </div>
            <div class = "hor-mspace hor-space pull-left" >
              <?php echo $this->Html->link(__l('Cancel'), array('controller' => 'banned_ips', 'action' => 'index'), array('class' => 'btn btn-large textb text-16 js-bootstrap-tooltip', 'title' => __l('Cancel'), 'escape' => false));?>
            </div>
          </div>
        <?php echo $this->Form->end(); ?>
      </div>
    </div>
  </div>
</div>