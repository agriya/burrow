<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="requests index js-response js-responses">
<?php
	$view_count_url = Router::url(array(
		'controller' => 'requests',
		'action' => 'update_view_count',
	), true);
?>
<ol class="unstyled prop-list prop-list-mob no-mar js-view-count-update {'model':'request','url':'<?php echo $view_count_url; ?>'}">
<?php 
		$divsize = "span21";
		if(isset($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'ajax' && isset($this->request->params['named']['user_id'])):
			$divsize = "span22";
		 endif; ?>
<?php
if (!empty($requests)):
	if(empty($this->request->params['isAjax'])) {
		echo $this->element('paging_counter');
	}
$i = 0;
foreach ($requests as $request):

?>
	<li class="clearfix ver-space sep-bot hor-smspace">
			<?php $date = explode('-', $request['Request']['checkin']); ?>
				 <span class="img-rounded sep date-block span cur no-under show no-pad dc graydarkc "> 
				 <span class="show well no-mar hor-space"><?php echo date('M', mktime(0, 0, 0, $date[1], $date[2], $date[0])); ?></span> <span class="show textb text-24"><?php echo date('d', mktime(0, 0, 0, $date[1], $date[2], $date[0])); ?></span> <span class="show sep-top"><?php echo date('D', mktime(0, 0, 0, $date[1], $date[2], $date[0])); ?></span> </span>
				 
                              <div class="<?php echo $divsize; ?> span20-sm pull-right no-mar mob-clr">
								<div class=" clearfix <?php echo (isset($is_favorite))? '':'sep-bot' ?>">
									<div class="span dc no-mar user-avatar">
										<?php
											echo $this->Html->getUserAvatar($request['User'], 'medium_thumb', true);
										?>
									</div>
									<div class="clearfix">
										<div class="<?php echo (isset($is_favorite))? 'span10':'span' ?>">
											<h4 class="textb text-16">
												<?php
													$lat = $request['Request']['latitude'];
													$lng = $request['Request']['longitude'];
													$id = $request['Request']['id'];
													echo $this->Html->link($this->Html->cText($request['Request']['title']) , array('controller' => 'requests', 'action' => 'view', $request['Request']['slug'], 'admin' => false) , array('id' => "js-map-side-$id", 'class' => "graydarkc js-map-data {'lat':'$lat','lng':'$lng'}", 'title' => $this->Html->cText($request['Request']['title'], false), 'escape' => false, 'class' => 'graydarkc'));
												?>
											</h4>
											<?php
												$flexible_class = '';
												if (isset($search_keyword['named']['is_flexible']) && $search_keyword['named']['is_flexible'] == 1) {
													if (!empty($exact_ids) && in_array($request['Request']['id'], $exact_ids)) {
											?><div class="clearfix top-space dc">
												<span class="label pull-left mob-inline"><?php echo __l('exact'); ?></span></div>
												
											<?php
													}
												}
											?>
										
										<span class="graydarkc top-smspace show mob-dc mob-clr">
											<?php if (!empty($request['Country']['iso_alpha2'])): ?>
												<span class="flags mob-inline top-smspace flag-<?php echo strtolower($request['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($request['Country']['name'], false); ?>"><?php echo $this->Html->cText($request['Country']['name'], false); ?></span>
                                        	<?php endif; ?>
											<?php echo $this->Html->cText($request['Request']['address']), false; ?>
											
										</span>
										<p class="span11 htruncate no-mar mob-dc"><?php echo $this->Html->cText($request['Request']['description'], false); ?>
											</p>
									
									</div>
									<div class="pull-right mob-clr tab-clr">
									<?php if (isset($is_favorite)): ?>
									<div class="clearfix pull-left mob-clr top-mspace mob-inline">
											<dl class=" sep-right list">
											  <dt class="pr hor-space  text-11"><?php echo __l('Views'); ?></dt>
											  <dd title="234" class="textb text-20 graydarkc pr hor-mspace js-view-count-request-id js-view-count-request-id-<?php echo $request['Request']['id']; ?> {'id':'<?php echo $request['Request']['id']; ?>'}"><?php echo numbers_to_higher($request['Request']['request_view_count']); ?></dd>
											</dl>
											<dl class="sep-right list">
											  <dt class="pr hor-space  text-11"><?php echo __l('Offered'); ?></dt>
											  <dd title="689" class="textb text-20 graydarkc pr hor-mspace"><?php echo $this->Html->cInt($request['Request']['property_count']); ?></dd>
											</dl>
											<dl class="list">
											  <dt class="pr hor-space  text-11"><?php echo __l('Days'); ?></dt>
											  <dd title="n/a" class="textb text-20 graydarkc pr hor-mspace"><?php echo $this->Html->cInt(getCheckinCheckoutDiff($request['Request']['checkin'], getCheckoutDate($request['Request']['checkout']))); ?></dd>
											</dl>
										  </div>
									<?php endif; ?>
										<div class="clearfix pull-left hor-space left-mspace sep-left mob-sep-none tab-no-mar mob-clr mob-dc">
											<p class="no-mar"><?php echo $this->Html->cDate($request['Request']['checkin']); ?><?php echo ' - '; ?><?php echo $this->Html->cDate(getCheckoutDate($request['Request']['checkout'])); ?></p>
											<dl class="dc list span mob-clr">
												  <dt class="pr hor-mspace text-11"><?php echo __l('Per night'); ?></dt>
												  <dd class="textb text-24 graydarkc pr hor-mspace"><?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
												<?php echo Configure::read('site.currency') . ' ' ?>
											<?php endif; ?>
											<?php echo $this->Html->cCurrency($request['Request']['price_per_night']); ?>
											<?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
												<?php echo Configure::read('site.currency') . ' ' ?>
											<?php endif; ?></dd>
											</dl>
										</div>
									</div>
									</div>
									</div>
									<?php if (!isset($is_favorite)): ?>
									<div class="clearfix mob-dc">
										  <div class="clearfix pull-left mob-clr top-mspace mob-inline">
											<dl class=" sep-right list">
											  <dt class="pr hor-space  text-11"><?php echo __l('Views'); ?></dt>
											  <dd title="234" class="textb text-20 graydarkc pr hor-mspace js-view-count-request-id js-view-count-request-id-<?php echo $request['Request']['id']; ?> {'id':'<?php echo $request['Request']['id']; ?>'}"><?php echo numbers_to_higher($request['Request']['request_view_count']); ?></dd>
											</dl>
											<dl class="sep-right list">
											  <dt class="pr hor-space  text-11"><?php echo __l('Offered'); ?></dt>
											  <dd title="689" class="textb text-20 graydarkc pr hor-mspace"><?php echo $this->Html->cInt($request['Request']['property_count']); ?></dd>
											</dl>
											<dl class="list">
											  <dt class="pr hor-space  text-11"><?php echo __l('Days'); ?></dt>
											  <dd title="n/a" class="textb text-20 graydarkc pr hor-mspace"><?php echo $this->Html->cInt(getCheckinCheckoutDiff($request['Request']['checkin'], getCheckoutDate($request['Request']['checkout']))); ?></dd>
											</dl>
										  </div>
										  <div class="pull-right mob-clr right-mspace">
										  <?php if ($request['User']['id'] != $this->Auth->user('id')): ?>
												<?php if ($request['Request']['checkin'] >= date('Y-m-d') && $request['Request']['checkout'] >= date('Y-m-d')): ?>
													<?php echo $this->Html->link(__l('Make an offer') , array('controller' => 'properties', 'action' => 'add', 'request', $request['Request']['id'], 'admin' => false) , array('title' => __l('Make an offer') , 'escape' => false, 'class' => 'show btn  top-mspace btn-large btn-primary text-18 textb')); ?>
												<?php endif; ?>
											<?php endif; ?>
										  </div>
										</div>
										<?php endif; ?>
									  </div>
	</li>
<?php
    endforeach; ?>
	</ol>
<?php else:
?>
<ol class="unstyled">
	<li>
		<div class="space dc gray"> <p class="ver-mspace top-space text-16"><?php echo __l('No Requests available');?></p> </div>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($requests)&& count($requests) > 10) { ?>
    <div class="<?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?> paging clearfix space pull-right mob-clr dc"> <?php   echo $this->element('paging_links'); ?> </div>
<?php }
?>

</div>
