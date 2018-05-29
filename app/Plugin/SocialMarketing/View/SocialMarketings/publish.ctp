<?php
  if ($this->request->params['isAjax']) {
    $js_skip_btn = 'js-skip-btn js-no-pjax';
    $class = 'js-social-load social_marketings-publish thumbnail';
    $span_class = '';
  } else {
    $js_skip_btn = '';
    $class = 'span20 thumbnail top-space bottom-space js-social-load';
    $span_class = 'span4';
  }
?>
<section class="<?php echo $class; ?>">
  <div>
    <div class="clearfix"><h3 class="ver-space top-mspace text-32"><?php echo $this->Html->cText($this->pageTitle, false); ?></h3></div>
    <?php if ($this->request->params['named']['type'] != 'import') { ?>

      <div class="row hor-mspace">
        <div class="span19 page-header">
          <div class="span"><span class="label span4 share-follow <?php echo ($this->request->params['named']['type'] == 'facebook')? 'badge-module' : ''; ?>"><?php echo __l('Facebook'); ?></span></div>
          <div class="span"><span class="label span4 share-follow <?php echo ($this->request->params['named']['type'] == 'twitter')? 'badge-module' : ''; ?>"><?php echo __l('Twitter'); ?></span></div>
          <div class="span"><span class="label span4 share-follow <?php echo ($this->request->params['named']['type'] == 'others')? 'badge-module' : ''; ?>"><?php echo __l('Others'); ?></span></div>
        </div>
      </div>
    <?php } ?>
    <div class="clearfix">
      <div class="<?php echo ($this->request->params['named']['type'] != 'others') ? 'span12' : ''; ?>">
        <div class="hide"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Throbber]') ,'width' => 25, 'height' => 25)); ?><img width="220" height="165" src="<?php echo $property_image; ?>"/></div>
        <?php if ($this->request->params['named']['type'] == 'facebook') { ?>
          <?php
            $redirect_url = Router::url(array(
              'controller' => 'social_marketings',
              'action' => 'publish',
              $id,
              'type' => $next_action,
              'publish_action' => $this->request->params['named']['publish_action']
            ), true);
            $connect_url = Router::url(array(
              'controller' => 'social_marketings',
              'action' => 'import_friends',
              'type' => 'facebook',
              'import' => 'facebook',
              'from' => 'publish',
            ), true);
            $fb_connect = false;
            if (!empty($logged_in_user['User']['is_facebook_connected']) || !empty($logged_in_user['User']['is_facebook_register'])) {
              $fb_connect = true;
            }
          ?>
          <div class="loader" id="js-loader" data-fb_connect="<?php echo $fb_connect; ?>" data-fb_app_id="<?php echo Configure::read('facebook.app_id'); ?>" data-project_url="<?php echo $property_url; ?>" data-project_image="<?php echo $property_image; ?>" data-project_name="<?php echo urlencode($this->Html->cText($property['Property']['title'], false)); ?>" data-caption="<?php echo urlencode($this->Html->cText($property['Property']['information'], false)); ?>" data-description="<?php echo urlencode($this->Html->cText($property['Property']['description'], false)); ?>" data-redirect_url="<?php echo $redirect_url; ?>" data-type="iframe">
            <!-- data-type="popup" -> set that popup to load share other than loaded to iframe -->
            <span id="js-FB-Share-description" class="hide"><?php echo $this->Html->cText($property['Property']['description'], false); ?></span>
            <span id="js-FB-Share-title"  class="hide"><?php echo $this->Html->cText($property['Property']['title'], false); ?></span>
			<span id="js-FB-Share-caption"  class="hide"><?php echo  Configure::read('site.name');   ?></span>
            <div id="js-FB-Share-iframe" class="hide"></div>
			<div id="fb-root"></div>
            <div id="js-FB-Share-beforelogin" class="hide">
              <div class ="hor-space mspace">
                <p class="clearfix"><?php echo $this->Html->link($this->Html->image('facebooklogin.png', array('alt' => __l('Connect with Facebook'))), $connect_url, array('title' => __l('Connect with Facebook'),'class' => "pull-left js-bootstrap-tooltip js-connect js-no-pjax {url:'".$connect_url."'}", 'escape' => false)); ?></p>
                <p class="no-mar"> <?php echo __l("Please login to share in facebook");?> </p>
              </div>
              <p id="msg"></p>
            </div>
          </div>
        <?php } else if($this->request->params['named']['type'] == 'twitter') { ?>
        <?php
			$replace_content = array(
			'##PROPERTY_NAME##' => $this->Html->cText($property['Property']['information'], false),
			'##SHARE_URL##' => ''
			);
			$default_content = strtr(Configure::read('share.twitter'), $replace_content);
		?>
		<div id="js-twitter" class="hor-space mspace">
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $property_url; ?>" data-text="<?php echo $default_content;?>" data-count="none" data-size="large">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
        <?php } else if($this->request->params['named']['type'] == 'others') { ?>
          <div class="clearfix space mspace" id="js-others">
            <ul class="unstyled span19 other-social nav-pills clearfix top-space">
              <li class="span6"><div><a href="https://www.linkedin.com/cws/share?url=<?php echo $property_url;?>" class="twitter-share-button no-under" target="_blank"><i class="icon-linkedin-sign text-32 pull-left linkedc"></i><span class="text-14 <?php echo $span_class;?> blackc"><?php echo sprintf(__l('Share about this %s on LinkedIn'), __l('property'));?></span></a>
              </div></li>
              <li class="span6"><div><a href="https://plus.google.com/share?url=<?php echo $property_url;?>" onclick="javascript:window.open(this.href,  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="no-under"><i class="pull-left icon-google-plus-sign text-32 googlec"></i><span class="text-14  <?php echo $span_class;?>  blackc"><?php echo sprintf(__l('Share about this %s on '), __l('property')) .'Google+'; ?></span></a></div></li>
              <li class="span6"><div><a href="http://pinterest.com/pin/create/button/?url=<?php echo $property_url;?>&media=<?php if(!empty( $property_image)) echo $property_image ; ?>&description=<?php echo $this->Html->cText($property['Property']['information'], false); ?>" target="_blank" class="no-under"><i class="pull-left icon-pinterest-sign text-32 pinterestc"></i><span class="text-14 <?php echo $span_class;?>  blackc"><?php echo sprintf(__l('Share about this %s on Pinterest'), __l('property'));?></span></a></div></li>
            </ul>
          </div>
        <?php } ?>
      </div>
    </div>
	<div class="clearfix">
    <div class="clearfix form-actions dr span19 js-skip-show hide">
      <?php
        if ($this->request->params['named']['type'] == 'others') {
          echo $this->Html->link('Done', array('controller' => 'properties', 'action' => 'view', $property['Property']['slug']), array('title' => 'Done','class' => 'pull-right js-bootstrap-tooltip'));
        } else {
          echo $this->Html->link(__l('Skip') . ' >>', array('controller' => 'social_marketings', 'action' => 'publish', !empty($id) ? $id : '', 'type' => $next_action, 'publish_action' => $this->request->params['named']['publish_action']), array('title' => __l('Skip'), 'class' => 'pull-right blackc js-bootstrap-tooltip ' . $js_skip_btn));
        }
      ?>
    </div>
	</div>
  </div>
</section>