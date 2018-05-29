          <?php
            if ($pageviews_percentage > 0) {
              $pageviews_color = '#459D1C';
            } elseif ($pageviews_percentage == 0) {
              $pageviews_color = '#757575';
            } elseif ($pageviews_percentage < 0) {
              $pageviews_color = '#BA1E20';
            }
            if ($visitors_percentage > 0) {
              $visitors_color = '#459D1C';
            } elseif ($visitors_percentage == 0) {
              $visitors_color = '#757575';
            } elseif ($visitors_percentage < 0) {
              $visitors_color = '#BA1E20';
            }
            if ($bounce_rate_percentage < 0) {
              $bounce_rate_color = '#459D1C';
            } elseif ($bounce_rate_percentage == 0) {
              $bounce_rate_color = '#757575';
            } elseif ($bounce_rate_percentage > 0) {
              $bounce_rate_color = '#BA1E20';
            }
          ?>
          <section class="span24 offset2">
            <div class="row">
              <div class="span7 dc space no-mar pr">
                <div class="btn dc show span8">
                  <div class="js-line-chart {'colour':'<?php echo $pageviews_color; ?>'}"><?php echo $pageviews; ?></div>
                  <div class="textb" style="color:<?php echo $pageviews_color; ?>"><?php echo $pageviews_percentage . '%'; ?></div>
                </div>
                <div class="dc show span16">
                  <h2><?php echo $total_pageviews; ?></h2>
                  <h5><?php echo __l('Page Views'); ?></h5>
                </div>
              </div>
              <div class="span7 dc space no-mar pr">
                <div class="btn dc show span8">
                  <div class="js-line-chart {'colour':'<?php echo $visitors_color; ?>'}"><?php echo $visitors; ?></div>
                  <div class="textb" style="color:<?php echo $visitors_color; ?>"><?php echo $visitors_percentage . '%'; ?></div>
                </div>
                <div class="dc show span16">
                  <h2><?php echo $total_visitors; ?></h2>
                  <h5><?php echo __l('Visitors'); ?></h5>
                </div>
              </div>
              <div class="span7 dc space no-mar pr">
                <div class="btn dc show span8">
                  <div class="js-line-chart {'colour':'<?php echo $bounce_rate_color; ?>'}"><?php echo $bounces; ?></div>
                  <div class="textb" style="color:<?php echo $bounce_rate_color; ?>"><?php echo $bounce_rate_percentage . '%'; ?></div>
                </div>
                <div class="dc show span16">
                  <h2><?php echo $total_bounces; ?></h2>
                  <h5><?php echo __l('Bounces'); ?></h5>
                </div>
              </div>
            </div>
          </section>