<div class="js-responses js-response">
<?php    $pjax_class=empty($this->request->params['isAjax'])?'':'js-no-pjax';
		$fromAjax = FALSE;
		$link_ajax = array();
		if(isset($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'ajax'):
			$fromAjax = TRUE;
			$link_ajax = array("from" => "ajax");
		 endif; ?>
	<?php if(empty($this->request->params['isAjax'])){?>
		<h2 class="ver-space top-mspace text-32 sep-bot"><?php echo __l('My Requests');?></h2>
    <?php } ?>		
		<div class="tabbable ver-space top-mspace">
				<div class="clearfix <?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?>">
				<?php 
				$class = (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == "active") ? 'active' : null;
				$link = array_merge(array('controller'=>'requests','action'=>'index','type' => 'myrequest','status' => 'active'), $link_ajax);
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Enabled').'">'.__l('Enabled').'</dt>
						<dd title="'.$this->Html->cInt($active_count ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($active_count ,false).'</dd>                  	
					</dl>'
					, $link, array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur '.$pjax_class));
				$class = (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'inactive') ? 'active' : null;
				$link = array_merge(array('controller'=>'requests','action'=>'index','type' => 'myrequest','status' => 'inactive'), $link_ajax);
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Disabled').'">'.__l('Disabled').'</dt>
						<dd title="'.$this->Html->cInt($inactive_count ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($inactive_count ,false).'</dd>                  	
					</dl>'
					, $link , array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur '.$pjax_class));
				$class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myrequest' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'offered')?'active':'';		
				$link = array_merge(array('controller'=>'requests','action'=>'index','type' => 'myrequest','status' => 'offered'), $link_ajax);				
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Offered').'">'.__l('Offered').'</dt>
						<dd title="'.$this->Html->cInt($offered_count ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($offered_count,false).'</dd>                  	
					</dl>'
					, $link , array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur '.$pjax_class));
				$class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myrequest' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'past')?'active':'';
				$link = array_merge(array('controller'=>'requests','action'=>'index','type' => 'myrequest','status' => 'past'), $link_ajax);
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('Past').'">'.__l('Past').'</dt>
						<dd title="'.$this->Html->cInt($past_count ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($past_count,false).'</dd>                  	
					</dl>'
					, $link, array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur '.$pjax_class));
					$class=(empty($this->request->params['named']['status']) && !empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myrequest')? 'active':'';
					$link = array_merge(array('controller'=>'requests','action'=>'index','type' => 'myrequest'), $link_ajax);
				echo $this->Html->link( '
					<dl class="dc list users '.$class .' mob-clr mob-sep-none ">					         	
						<dt class="pr hor-mspace text-11 grayc"  title="'.__l('All').'">'.__l('All').'</dt>
						<dd title="'.$this->Html->cInt($all_count ,false).'" class="textb text-20 no-mar graydarkc pr hor-mspace">'.$this->Html->cInt($all_count,false).'</dd>                  	
					</dl>'
					, $link, array('escape' => false,'class'=>'no-under show pull-left mob-clr bot-space bot-mspace cur '.$pjax_class));
				$class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myrequest' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'offered')?'active':'';
				?>
				
		</div>
		</div>
		<?php 
					echo $this->Form->create('Request' , array('class' => 'normal','action' => 'update'));  
					echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); 
						$view_count_url = Router::url(array(
							'controller' => 'requests',
							'action' => 'update_view_count',
						), true);
					?>
					<ol class="unstyled prop-list prop-list-mob no-mar top-space js-view-count-update {'model':'request','url':'<?php echo $view_count_url; ?>'}">
						<?php
							if (!empty($requests)):
								$i = 0;
								foreach ($requests as $key => $requestt):
									$class = null;
									foreach($requestt as $request):
										if ($i++ % 2 == 0) {
											$class = ' altrow';
										}
						?>
						<li>
						<ol class="unstyled">
							<li class="sep-bot ver-space clearfix">
							<div class="span dc">
							<?php if(empty($this->request->params['isAjax'])){?>
								<div class="input checkbox graydarkerc no-mar  left-space">
								 <?php echo $this->Form->input('Request.'.$request['Request']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$request['Request']['id'], 'label' => "", 'class' => 'js-checkbox-list' , 'div' =>false)); ?>
								</div>
								<?php } ?>
								<div class="dropdown left-space"> <a data-toggle="dropdown" class="dropdown-toggle text-14 textb graylighterc no-shad" title="setting" href="#"><i class="icon-cog graylightc no-pad text-16"></i></a>
								
								  <ul class="dropdown-menu dl arrow left-mspace">
									<li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action' => 'edit', $request['Request']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'),'escape'=>false));?></li>
									<li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $request['Request']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete'),'escape'=>false));?></li>
									<?php if($request['Request']['is_active'] == 0) {?>
									<li><?php echo $this->Html->link('<i class="icon-eye-close"></i>'.__l('Enable'), array('controller' => 'requests', 'action' => 'updateactions', $request['Request']['id'], 'active', 'admin' => false, '?r=' . $this->request->url), array('title' => __l('Enable'), 'class' => 'enable js-confirm-mess','escape'=>false));?></li>
									<?php }?>
									<?php if($request['Request']['is_active'] == 1) {?>
									<li><?php echo $this->Html->link('<i class="icon-eye-close"></i>'.__l('Disable'), array('controller' => 'requests', 'action' => 'updateactions', $request['Request']['id'], 'inactive', 'admin' => false, '?r=' . $this->request->url), array('title' => __l('Disable'), 'class' => 'disable js-confirm-mess','escape'=>false));?></li>
									<?php }?>
								  </ul>
								</div>
							  </div>
							  <?php $date = explode('-', $key); ?>
							 <span class="img-rounded sep date-block span cur no-under show no-pad dc graydarkc"> 
							 <span class="show well no-mar hor-space"><?php echo date('M', mktime(0, 0, 0, $date[1], $date[2], $date[0])); ?></span> <span class="show textb text-24"><?php echo date('d', mktime(0, 0, 0, $date[1], $date[2], $date[0])); ?></span> <span class="show sep-top"><?php echo date('D', mktime(0, 0, 0, $date[1], $date[2], $date[0])); ?></span> </span>
							  <div class="span dc"><?php
								echo $this->Html->getUserAvatar($request['User'], 'medium_thumb', true);
								?>
							</div>
							<div class=" pull-left mob-dc mob-clr tab-clr">
							<div class="clearfix">
										<div class="span11">
											<h4 class="textb text-16 clearfix">
													<?php echo $this->Html->link($this->Html->cText($request['Request']['title']), array('controller'=> 'requests', 'action' => 'view', $request['Request']['slug']), array('title' => $this->Html->cText($request['Request']['title'], false), 'escape' => false, 'class' => 'graydarkc mob-dc mob-clr span6 no-mar htruncate js-bootstrap-tooltip'));?>
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
										
										<div class="graydarkc top-smspace clearfix show mob-dc mob-clr">
											<?php if (!empty($request['Country']['iso_alpha2'])): ?>
												<span class="flags mob-inline top-smspace flag-<?php echo strtolower($request['Country']['iso_alpha2']); ?>" title ="<?php echo $this->Html->cText($request['Country']['name'], false); ?>"><?php echo $this->Html->cText($request['Country']['name'], false); ?></span>
                                        	<?php endif; ?>
											<div class="htruncate js-bootstrap-tooltip no-mar span5" title="<?php echo $request['Request']['address'];?>"><?php echo $this->Html->cText($request['Request']['address'], false);?></div><span><?php echo  '(' . $this->Time->timeAgoInWords($request['Request']['created']) . ')';?></span>
											
										</div>
										<p class=" span10 span-5-sm no-mar mob-dc htruncate js-bootstrap-tooltip" title="<?php echo $this->Html->cText($request['Request']['description'], false);?>"><?php echo $this->Html->cText($request['Request']['description'], false); ?>
											</p>
									</div>
									<div class="pull-right mob-clr tab-clr">
									<div class="clearfix pull-left mob-clr top-mspace mob-inline">
											<dl class="list">
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
										<div class="clearfix pull-left hor-space left-mspace sep-left mob-sep-none tab-no-mar mob-clr mob-dc">
											<p class="no-mar"><?php echo $this->Html->cDate($request['Request']['checkin']); ?><?php echo ' - '; ?><?php echo $this->Html->cDate(getCheckoutDate($request['Request']['checkout'])); ?></p>
											 <dl class="dc list span mob-clr">
												  <dt class="pr hor-mspace text-11"><?php echo __l('Per night'); ?> </dt>
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
							</li>
							</ol>
							<?php if(!empty($request['PropertiesRequest'])): ?>
								<?php
									$view_count_url = Router::url(array(
										'controller' => 'properties',
										'action' => 'update_view_count',
									), true);
									$num= $this->Paginator->counter(array('format' => '%start%'));
								?>
								<ol class="unstyled js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}">
									<?php 
										foreach($request['PropertiesRequest'] as $property):
											if(!empty($property['Property'])):
									?>
									 <li class="clearfix offset1 ver-space sep-bot js-map-num <?php echo $num; ?>  hor-smspace">
										<div class="span dc no-mar left-space mob-no-pad"> <span class="label label-important left-smspace textb show text-11 prop-count map_number "><?php echo $num; ?> </span> 
										
												<?php if(isPluginEnabled('PropertyFavorites')) :
													if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))):?>
													<div class="alpuf-<?php echo $property['Property']['id'];?> hide">
														<?php echo $this->Html->link('<i class="icon-star left-smspace no-pad text-18"></i>', array('controller' => 'property_favorites', 'action'=>'delete', $property['Property']['slug']), array('escape' => false ,'class' => 'js-no-pjax js-like un-like top-space show no-under', 'title' => __l('Unlike'))); ?>
													</div>
													<div class="alpf-<?php echo $property['Property']['id'];?> hide">
														<?php	echo $this->Html->link('<i class="icon-star left-smspace no-pad text-18"></i>', array('controller' => 'property_favorites', 'action' => 'add', $property['Property']['slug']), array('escape' => false ,'title' => __l('Like'),'escape' => false ,'class' =>'js-no-pjax js-like like top-space show graylightc no-under')); ?>
													</div>
													<div class='blpf-<?php echo $property['Property']['id'];?> hide'>
														<?php	echo $this->Html->link('<i class="icon-star left-smspace no-pad text-18"></i>', array('controller' => 'users', 'action' => 'login', '?' => 'f='. $this->request->url), array('title' => __l('Like'),'escape' => false ,'class' =>'like top-space show graylightc no-under')); ?>
													</div>
												<?php else: ?>
													<span>
													<?php
														if($this->Auth->sessionValid()):
															if(!empty($property['PropertyFavorite'])):
																foreach($property['PropertyFavorite'] as $favorite):
																	if($property['Property']['id'] == $favorite['property_id'] && $property['Property']['user_id'] != $this->Auth->user('id')):
																		echo $this->Html->link('<i class="icon-star left-smspace  no-pad text-18"></i>', array('controller' => 'property_favorites', 'action'=>'delete', $property['Property']['slug']), array('escape' => false ,'class' => 'js-no-pjax js-like un-like top-space show no-under', 'title' => __l('Unlike')));
																	endif;
																endforeach;
															else:
																if( $property['Property']['user_id'] != $this->Auth->user('id')):
																	echo $this->Html->link('<i class="icon-star left-smspace no-pad text-18"></i>', array('controller' => 'property_favorites', 'action' => 'add', $property['Property']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'js-no-pjax js-like like top-space show graylightc no-under'));
																endif;
															endif;
														else:
															echo $this->Html->link('<i class="icon-star no-pad left-smspace text-18"></i>', array('controller' => 'users', 'action' => 'login', '?' => 'f='. $this->request->url), array('title' => __l('Like'),'escape' => false ,'class' =>'like top-space show graylightc no-under'));
														endif;
													?>
													</span>
													<?php endif;
													endif; ?>
										<?php if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))):?>
											<div class="aloed-<?php echo $property['Property']['id']; ?> hide">
											<div class="dropdown"> <a href="#" title="Edit" class="dropdown-toggle text-14 textb graylighterc no-shad" data-toggle="dropdown"><i class="icon-cog graylightc no-pad text-16"></i></a>
												<ul class="dropdown-menu dl arrow">
												  <li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action'=>'edit', $property['Property']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'),'escape'=>false));?></li>
												  <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action'=>'delete', $property['Property']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete'),'escape'=>false));?> </li>
												</ul>
											</div>
											</div>
										<?php else:
											if ($property['Property']['user_id'] == $this->Auth->user('id')) : ?>
											<div class="dropdown"> <a href="#" title="Edit" class="dropdown-toggle text-14 textb graylighterc no-shad" data-toggle="dropdown"><i class="icon-cog graylightc no-pad text-16"></i></a>
												<ul class="dropdown-menu dl arrow">
												  <li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action'=>'edit', $property['Property']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'),'escape'=>false));?></li>
												  <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action'=>'delete', $property['Property']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete'),'escape'=>false));?> </li>
												</ul>
											  </div>
										<?php endif; 
										endif;?>
										</div>
									  
										<div class="span hor-mspace dc mob-no-mar">
										<?php
											$property['Property']['Attachment'][0] = !empty($property['Property']['Attachment'][0]) ? $property['Property']['Attachment'][0] : array();
											echo $this->Html->link($this->Html->showImage('Property', $property['Property']['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'],  'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false));
										?>
										</div>
										<div class="span18 pull-right no-mar mob-clr tab-clr">
									  <div class="clearfix left-mspace sep-bot">
										<div class="span bot-space no-mar">
										  <h4 class="textb text-16">
											<?php
												$lat = $property['Property']['latitude'];
												$lng = $property['Property']['longitude'];
												$id = $property['Property']['id'];
												echo $this->Html->link($this->Html->cText($property['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('id'=>"js-map-side-$id",'class'=>"graydarkc bot-space htruncate js-bootstrap-tooltip span9 dl no-mar js-map-data {'lat':'$lat','lng':'$lng'}",'title'=>$this->Html->cText($property['Property']['title'], false),'escape' => false));
											?>
										  </h4>
										  <div class="clearfix top-space dc">
										  
											<?php 
											$flexible_class = '';
											if(isset($search_keyword['named']['is_flexible'])&& $search_keyword['named']['is_flexible'] ==1 && !empty($search_keyword['named']['latitude'])) {
												if(!in_array($property['Property']['id'], $booked_property_ids) && in_array($property['Property']['id'], $exact_ids)) {
											?>
													<span class="label pull-left mob-inline"><?php echo __l('exact'); ?></span> 
											<?php
												}
											}
											if (Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified']==ConstVerification::Verified):
											?>
												<span class="label label-warning pull-left right-mspace mob-inline"><?php echo __l('Verified'); ?></span>
											<?php
											endif;
											?>
											<?php if ($property['Property']['is_featured']): ?>
												 <span class="label featured pull-left hor-smspace mob-inline"> <?php echo __l('Featured'); ?></span>
											<?php endif; ?>
										  <span class="label label-success pull-left hide hor-smspace mob-inline">lorm</span>
										  </div>
										  <a href="#" class="graydarkc top-smspace show mob-clr dc" title="<?php echo $property['Property']['address'];?>">
										  <?php if(!empty($request['Country']['iso_alpha2'])): ?>
												<span class="flags flag-<?php echo strtolower($request['Country']['iso_alpha2']); ?>" title ="<?php echo $request['Country']['name']; ?>"><?php echo $request['Country']['name']; ?></span>
											<?php endif; ?>
											</a>
										  <div class="htruncate js-bootstrap-tooltip span9 dl no-mar" title="<?php echo $request['Request']['address'];?>"><?php echo $this->Html->cText($request['Request']['address']);?></div>
										</div>
										<div class="pull-right sep-left mob-clr mob-sep-none">
										  <dl class="dc list span mob-clr">
											<dt class="pr hor-mspace text-11"><?php echo __l('Per night');?></dt>
											<dd class="textb text-24 graydarkc pr hor-mspace">
											<?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
												<?php echo Configure::read('site.currency').' '?>
											<?php endif; ?>
											<?php echo $this->Html->cCurrency($property['Property']['price_per_night']);?>
											<?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
												 <?php echo ' '.Configure::read('site.currency'); ?>
											<?php endif; ?>
											</dd>
										  </dl>
										  <div class="clearfix dc">
											<?php echo $this->Html->link(__l('Book it'), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('class'=>'btn btn-primary', 'title'=>__l('Book it'), 'escape' => false)); ?>
										  </div>
										</div>
										
									  </div>
									  <div class="clearfix left-mspace">
										<?php
											echo $this->element('popular-comment-users', array('user_name' => $property['Property']['User']['username'],'page' => 'my_request', 'config' => 'sec'));
										?>
										<div class="clearfix pull-right top-mspace mob-clr">
										  <?php if((!empty($search_keyword['named']['latitude']) || isset($near_by)) && !empty($property[0]['distance'])){?>
												<dl class="dc mob-clr sep-right list">
													<dt class="pr hor-mspace text-11"><?php echo __l('Distance');?> <?php echo __l('(km)');?></dt>
													<dd class="textb text-16 no-mar graydarkc pr hor-mspace"><?php echo $this->Html->cInt($property[0]['distance']*1.60934 ); ?></dd>
												</dl>
											<?php } ?>
										  <dl class="dc mob-clr sep-right list">
											<dt class="pr hor-mspace text-11" ><?php echo __l('Views');?></dt>
											<dd class="textb text-16 no-mar graydarkc pr hor-mspace js-view-count-property-id js-view-count-property-id-<?php echo $property['Property']['id']; ?> {'id':'<?php echo $property['Property']['id']; ?>"><?php echo numbers_to_higher($property['Property']['property_view_count']); ?></dd>
										  </dl>
										  <dl class="dc mob-clr sep-right list">
											<dt class="pr hor-smspace text-11" ><?php echo __l('Positive');?></dt>
											<dd  class="textb text-16 no-mar graydarkc pr hor-mspace"><?php echo numbers_to_higher($property['Property']['positive_feedback_count']); ?></dd>
										  </dl>
										  <dl class="dc mob-clr sep-right list">
											<dt class="pr hor-mspace text-11"><?php echo __l('Negative');?></dt>
											<dd class="textb text-16 no-mar graydarkc pr hor-mspace"><?php echo numbers_to_higher($property['Property']['property_feedback_count'] - $property['Property']['positive_feedback_count']); ?></dd>
										  </dl>
										  <dl class="dc mob-clr list">
											<dt class="pr mob-clr hor-mspace text-11"><?php echo __l('Success Rate');?></dt>
											<?php if(empty($property['Property']['property_feedback_count'])){ ?>
												<dd  class="textb text-16 no-mar sep-left graydarkc pr hor-mspace">n/a</dd>
											<?php }else{ ?>
											<dd class="textb text-16 no-mar graydarkc sep-left pr hor-mspace">
												<?php
													if(!empty($property['Property']['positive_feedback_count'])){
														$positive = floor(($property['Property']['positive_feedback_count']/$property['Property']['property_feedback_count']) *100);
														$negative = 100 - $positive;
													}else{
														$positive = 0;
														$negative = 100;
													}
													echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=8DCA35|F47564&amp;chf=bg,s,FFFFFF00', array('width'=>'35px','height'=>'35px','title' => $positive.'%'));
												?>
											</dd>
											<?php } ?>
											</dl>
										  
										</div>
									  </div>
									</div>
								  </li>
								<?php
										endif;
									endforeach;
								?>
							</ol>
						<?php endif; ?>
					</li>
				<?php
						endforeach;
					endforeach; ?>
				</ol>
				<?php else: ?>
				<ol class="unstyled">
					<li class="<?php if(empty($this->request->params['isAjax'])) { ?> sep-top <?php } ?>">
						<div class="space dc grayc">
							<p class="ver-mspace top-space text-16">
								<?php echo __l('No Requests available');?>
							</p>
						</div>
					</li>
				<?php endif; ?>
			</ol>
		<div class="clearfix top-mspace">
		<?php if(empty($this->request->params['isAjax'])){?>
			<?php if (!empty($requests)): ?>
				<div class="select-block ver-mspace pull-left mob-clr dc span8">
				<div class="span top-mspace">
					<span class="graydarkc">
                        <?php echo __l('Select:'); ?></span>
						<?php echo $this->Html->link(__l('All'), '#', array('class' => 'hor-smspace grayc  js-select-all','title' => __l('All'))); ?>
						<?php echo $this->Html->link(__l('None'), '#', array('class' => 'hor-smspace grayc  js-select-none','title' => __l('None'))); ?>
					  </div><?php echo $this->Form->input('more_action_id', array('class' => 'span5 js-admin-index-autosubmit js-no-pjax', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
					</div>
			 
			<?php endif; ?>
			<?php } ?>
				<?php if (!empty($requests)&& count($requests) > 10) { ?>
			<div class="<?php echo (!empty($this->request->params['isAjax'])) ? " js-pagination" : "" ; ?> pagination pull-right no-mar mob-clr">
				<?php 	echo $this->element('paging_links'); ?>
			</div>
				<?php 	} 	?>
			
		</div>
		<?php echo $this->Form->end(); ?>

</div>