<div class="space">
    <div class="pull-right hor-space">
      <?php echo $this->Html->link('<i class="icon-plus-sign no-pad top-smspace"></i>', array('action' => 'add'), array('class' => 'add btn btn-primary textb text-18 whitec', 'title' =>  __l('Add'), 'escape' => false)); ?>
    </div>
    <div class="clearfix">
       <div class="clearfix"><h5 class="pull-left ver-space"><?php echo __l('Current Theme'); ?></h5></div>
    </div>
     <div class="thumbnail space clearfix">

    <?php
      if (!Configure::read('site.theme')) {
        echo $this->Html->tag('div', $this->Html->image($currentTheme['screenshot'], array('class' => 'thumbnail', 'width' => 310, 'height' => 295)), array('class' => 'clearfix'));
      } else {
        echo $this->Html->tag('div', $this->Html->image('/theme/' . Configure::read('site.theme') . '/img/' . $currentTheme['screenshot'], array('class' => 'thumbnail', 'width' => 310, 'height' => 295)), array('class' => 'span'));
      }
    ?>

    <div><h5>
    <?php
      $author = $currentTheme['author'];
      if (isset($currentTheme['authorUrl']) && strlen($currentTheme['authorUrl']) > 0) {
        $author = $this->Html->link($author, $currentTheme['authorUrl']);
      }
      echo $currentTheme['name'] . ' ' . __l('by') . ' ' . $author;
    ?>
    </h5>
    </div>
    <div><?php echo $currentTheme['description']; ?></div>
    <?php if (!empty($currentTheme['regions'])): ?>
      <p><?php echo __l('Regions supported: ') . implode(', ', $currentTheme['regions']); ?></p>
    <?php endif; ?>
    </div>
   <div class="clearfix"><h5 class="ver-space"><?php echo __l('Available Themes'); ?></h5></div>
   <div class="thumbnail">
    <ol class="unstyled clearfix space">
    <?php
      foreach ($themesData AS $themeAlias => $theme) {
        if ($themeAlias != Configure::read('site.theme') &&
          (!isset($theme['adminOnly']) || $theme['adminOnly'] != 'true') &&
          !($themeAlias == 'default' && !Configure::read('site.theme'))) {
          $is_themes_available = 1;
          echo '<li class="span8">';
            if ($themeAlias == 'default') {
    ?>
              <div class="span">
			  <?php echo $this->Html->image($theme['screenshot'], array('alt' => $themeAlias ,'width' => 310, 'height' => 295)); ?></div>
    <?php
            } else {
              echo $this->Html->tag('div', $this->Html->image('/theme/' . $themeAlias . '/img/' . $theme['screenshot'], array('class' => 'thumbnail', 'width' => 310, 'height' => 295)), array('class' => 'span'));
            }
            $author = $theme['author'];
            if (isset($theme['authorUrl']) && strlen($theme['authorUrl']) > 0) {
              $author = $this->Html->link($author, $theme['authorUrl']);
            }
            echo $this->Html->tag('h3', $theme['name'] . ' ' . __l('by') . ' ' . $author, array());
            echo $this->Html->tag('p', $theme['description']);
            if (!empty($theme['regions'])):
              echo $this->Html->tag('p', __l('Regions supported: ') . implode(', ', $theme['regions']));
            endif;
            echo $this->Html->tag('div', $this->Html->link('<i class="icon-ok"></i>'.__l('Activate'), array('action' => 'activate', $themeAlias), array('class' => 'js-confirm right-mspace','escape' => false, 'title' => __l('Activate'))) . $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $themeAlias), array('class' => 'js-confirm','escape' => false, 'title' => __l('Delete'))));
          echo '</li>';
        }
      }
      if (empty($is_themes_available)) {
        echo '<li><div class="space dc"><p class="ver-mspace grayc top-space text-16 ">' . sprintf(__l('No %s available'), __l('Themes')) . '</p></div></li>';
      }
    ?>
    </ol>
    </div>

</div>
