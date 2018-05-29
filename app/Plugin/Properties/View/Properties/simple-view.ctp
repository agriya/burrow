<?php /* SVN: $Id: $ */ ?>
<?php 
	$user_avatar_grid = '';
	$user_avatar_inner_left_grid = '';
	$user_avatar_inner_right_grid = '';
	$city_list_grid = '';
	$price_info_right_grid = '';
	if (preg_match('/admin\/messages/s', $_SERVER['REDIRECT_URL'])) {
		$user_avatar_grid = '';
		$user_avatar_inner_left_grid = '';
		$user_avatar_inner_right_grid = '';
		$city_list_grid = '4';
		$price_info_right_grid = '2';
	}
?>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<div class="ver-space sep-bot clearfix list-view">
              <div class="span dc avtar-box">
			  <?php echo $this->Html->link($this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'],false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('target' => '_blank', 'title' => $this->Html->cText($property['Property']['title'], false),'escape' => false)); ?>			  
			  </div>
              <div class="span20 right-mspace mob-clr tab-clr">
                <div class="clearfix hor-space sep-bot">
                  <div class="span10 bot-space">
                    <h4><?php echo $this->Html->link($this->Html->cText($property['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('target' => '_blank', 'title' => $this->Html->cText($property['Property']['title'], false),'escape' => false, 'class' => 'textb text-16 graydarkc span9 no-mar js-bootstrap-tooltip htruncate' ));?></h4>
					<?php if(!empty($property['Country']['iso_alpha2'])): ?>
                    <span title="<?php echo $this->Html->cText($property['Property']['address'], false); ?>" class="graydarkc top-smspace show mob-clr mob-dc span9 js-bootstrap-tooltip htruncate"><span title="<?php echo $this->Html->cText($property['Country']['name'], false); ?>" class="flags flag-<?php echo strtolower($property['Country']['iso_alpha2']); ?> mob-inline top-smspace"></span><?php echo $this->Html->cText($property['Property']['address'], false); ?></span>
					<?php endif; ?>
                    <div class="clearfix mob-dc"><span><?php echo __l('Posted on'); ?></span> <span class="graydarkc"  title="<?php echo strftime(Configure::read('site.datetime.tooltip'), strtotime($property['Property']['created'])); ?>"> <?php echo  $this->Time->timeAgoInWords($property['Property']['created']);?></span> </div>
                  </div>
                  <div class="pull-right sep-left mob-clr mob-sep-none">
                    <dl class="dc list mob-clr">
                      <dt class="pr hor-mspace text-11"><?php echo __l('Per night');?></dt>
                      <dd class="textb text-24 graydarkc pr hor-mspace" title="five hundred dollar">
					  <?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
                 <?php echo Configure::read('site.currency');?>
				 <?php endif; ?>
                  <?php echo $this->Html->cCurrency($property['Property']['price_per_night']);?>
				<?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
                 <?php echo Configure::read('site.currency');?>
				 <?php endif; ?>
					  
					  </dd>
                    </dl>
                    <dl class="dc list mob-clr">
                      <dt class="pr hor-mspace text-11"><?php echo __l('Per Week');?></dt>
                      <dd class="text-11 top-space graydarkc pr hor-mspace" title="two thousand dollar">
					  <?php 
						if($property['Property']['price_per_week']!=0):
							echo $this->Html->siteCurrencyFormat($property['Property']['price_per_week']);
						else:
							echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']*7);
						endif;					  
						?>
					  </dd>
                    </dl>
                    <dl class="dc list mob-clr">
                      <dt class="pr hor-mspace text-11"><?php echo __l('Per Month');?></dt>
                      <dd class="text-11 top-space graydarkc pr hor-mspace" title="three thousand five hundred dollars"><?php
					  if($property['Property']['price_per_month']!=0):
					  echo $this->Html->siteCurrencyFormat($property['Property']['price_per_month']);
					  else:
						echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']*30);
					endif;
					  ?></dd>
                    </dl>
                  </div>
                </div>
                <div class="clearfix hor-space">
                  <div class="span11 no-mar">
                        <div class="clearfix">
                        <div class="pull-left">
                          <dl class="list">
                            <dt class="pr hor-mspace text-11"><?php echo __l('Check in');?></dt>
                            <dd class="top-space  pr no-mar blackc" title="<?php echo $this->Html->cDate($propertyUser['PropertyUser']['checkin'], false);?>"> <?php echo $this->Html->cDate($propertyUser['PropertyUser']['checkin']);?></dd>
                          </dl>
                          </div>
                          <div class="pull-right">
                            <dl class="dc list ">
                              <dt class="pr hor-mspace text-11"><?php echo __l('Check out');?></dt>
                              <dd class="top-space  pr hor-mspace blackc" title="<?php echo $this->Html->cDate(getCheckoutDate($propertyUser['PropertyUser']['checkout']), false);?>"> <?php echo $this->Html->cDate(getCheckoutDate($propertyUser['PropertyUser']['checkout']));?></dd>
                            </dl>
                          </div>
                        </div>
						<?php
								$total_days = getCheckinCheckoutDiff($propertyUser['PropertyUser']['checkin'],getCheckoutDate($propertyUser['PropertyUser']['checkout']));
								$completed_days = (strtotime(date('Y-m-d')) - strtotime($propertyUser['PropertyUser']['checkin'])) /(60*60*24);
								if($completed_days == 0) {
									$completed_days = 1;
								} elseif($completed_days < 0) {
									$completed_days = 0;
								} elseif($completed_days > $total_days) {
									$completed_days = $total_days;	
								}
                                $pixels = round(($completed_days/$total_days) * 100);
                            ?>						
                        <div class="span clearfix left-mspace">
                          <div class="progress progress-info bot-mspace">
                            <div style="width:<?php echo $pixels; ?>%;" class="bar"></div>
                          </div>
                        </div>
                      </div>
                  <div class="clearfix pull-right top-mspace mob-clr">
                    <dl class="sep-right list">
                      <dt class="pr hor-mspace text-11"><?php echo __l('Views');?></dt>
                      <dd title="<?php echo $property['Property']['property_view_count']; ?>" class="textb text-16  graydarkc pr hor-mspace"><?php echo numbers_to_higher($property['Property']['property_view_count']); ?></dd>
                    </dl>
                    <dl class="sep-right list">
                      <dt class="pr hor-mspace text-11"> <?php echo __l('Positive');?></dt>
                      <dd title="<?php echo $property['Property']['positive_feedback_count']; ?>	" class="textb text-16  graydarkc pr hor-mspace"><?php echo numbers_to_higher($property['Property']['positive_feedback_count']); ?>	</dd>
                    </dl>
                    <dl class="sep-right list">
                      <dt class="pr hor-mspace text-11">Negative</dt>
                      <dd title="<?php echo $property['Property']['property_feedback_count'] - $property['Property']['positive_feedback_count']; ?>	" class="textb text-16  graydarkc pr hor-mspace"><?php echo numbers_to_higher($property['Property']['property_feedback_count'] - $property['Property']['positive_feedback_count']); ?>	</dd>
                    </dl>
                    <dl class="list">
                      <dt class="pr mob-clr hor-mspace text-11">Success Rate</dt>
					  <?php if(empty($property['Property']['property_feedback_count'])): ?>
					  <dd class="textb text-16  graydarkc pr hor-mspace" title="<?php  echo __l('No Bookings available'); ?>"><?php  echo __l('n/a'); ?></dd>
					<?php else:?>
								 <dd class="textb text-16  graydarkc pr hor-mspace">
										<?php if(!empty($property['Property']['positive_feedback_count'])):
										$positive = floor(($property['Property']['positive_feedback_count']/$property['Property']['property_feedback_count']) *100);
										$negative = 100 - $positive;
										else:
										$positive = 0;
										$negative = 100;
										endif;
										
										echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=8DCA35|F47564&chf=bg,s,FFFFFF00', array('width'=>'40px','height'=>'40px','title' => $positive.'%'));  ?>
								</dd>
							<?php endif; ?>					  
                    </dl>
                  </div>
                </div>
              </div>
            </div>
