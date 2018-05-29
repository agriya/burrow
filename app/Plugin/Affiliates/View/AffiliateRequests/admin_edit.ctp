<?php /* SVN: $Id: $ */ ?>
<ul class="breadcrumb top-mspace ver-space">
  <li><?php echo $this->Html->link( __l('Affiliate Request'), array('controller'=>'affiliate_requests','action'=>'index', 'admin' => 'true'), array('escape' => false));?><span class="divider">/</span></li>
  <li class="active"><?php echo __l('Edit Affiliate Request'); ?></li>
</ul>
<div class="affiliateRequests form sep-top">
<?php echo $this->Form->create('AffiliateRequest', array('class' => 'form-horizontal space'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->autocomplete('AffiliateRequest.username', array('label'=> __l('Users'), 'acFieldKey' => 'AffiliateRequest.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '100', 'acMultiple' => false));
		echo $this->Form->input('site_category_id', array('label' => __l('Site Category')));
		echo $this->Form->input('site_name', array('label' => __l('Site Name')));
		echo $this->Form->input('site_description', array('label' => __l('Site Description')));
		echo $this->Form->input('site_url', array('label' => __l('Site URL')));
		echo $this->Form->input('why_do_you_want_affiliate', array('label' => __l('Why Do You Want An Affiliate?')));
		echo $this->Form->input('is_web_site_marketing', array('label' => __l('Web Site Marketing?')));
	?>
	<div class="show"> 
	<?php
		echo $this->Form->input('is_search_engine_marketing', array('label' => __l('Search Engine Marketing?')));
	?>
	</div>
	<div class="show"> 
	<?php
		echo $this->Form->input('is_email_marketing', array('label' => __l('Email Marketing?')));
	?>
	</div>
	<div class="show"> 
	<?php
		echo $this->Form->input('special_promotional_method', array('label' => __l('Special Promotional Method')));
	?>
	</div>
	<?php 
		echo $this->Form->input('special_promotional_description', array('label' => __l('Special Promotional Description')));?>
		<div class="show bot-mspace">
		<label>	<?php echo __l('Approved'); ?> </label>	
  <?php echo $this->Form->input('is_approved', array('legend' =>false, 'type' => 'radio','div'=> array('class' => 'input radio no-mar'), 'options' => array(0 => 'Waiting for approval', 1 => 'Approved', '2' => 'Rejected')));
	?>
		</div>
	<div class="form-actions">
		<?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16'));?>
	</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
