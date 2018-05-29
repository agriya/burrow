<?php /* SVN: $Id: $ */ ?>
<div class="requests form">
	<?php if (empty($this->request->params['prefix'])): ?>
		<h2 class="ver-space top-mspace text-32 sep-bot"><?php echo $this->pageTitle;?></h2>
	<?php endif; ?>
	<?php if(!empty($steps) && $steps <= 5):  ?>
	<div class="clearfix ver-space bot-mspace">
		<ul id="stage" class="unstyled dc clearfix pull-left mob-clr">
			<li class="pull-left ver-space right-mspace sep-bot sep-medium mob-clr <?php if($steps == 1): ?>highlight<?php endif; ?> <?php if($steps >= 1): ?>complete<?php endif; ?>"><?php echo __l('Address');?></li>
			<li class="pull-left ver-space right-mspace sep-bot sep-medium mob-clr <?php if($steps == 2): ?>highlight<?php endif; ?> <?php if($steps >= 2): ?>complete<?php else: ?>inactive<?php endif; ?>"><?php echo __l('General');?></li>
			<li class="pull-left ver-space right-mspace sep-bot sep-medium mob-clr <?php if($steps == 3): ?>highlight<?php endif; ?> <?php if($steps >= 3): ?>complete<?php else: ?>inactive<?php endif; ?>"><?php echo __l('Amenities');?></li>
			<?php if($steps >= 4): ?>
			<li class="pull-left ver-space right-mspace sep-bot sep-medium mob-clr <?php if($steps == 4): ?>highlight<?php endif; ?> <?php if($steps >= 4): ?>complete<?php else: ?>inactive<?php endif; ?>"><?php echo __l('Related Properties');?></li>
			<?php endif; ?>
		</ul>
		</div>
	<?php endif; ?>
	<div class="js-response">
		<?php 
			$form_class = '';
				if(!empty($request_filters)):
					$form_class = '';
					if(!empty($this->request->data)):
					$admin = 0;
						// @todo "What goodies I can provide (guest)"
						if(!empty($this->request->params['admin'])){
                            $admin = 1;
                        }
						echo $this->element('related-properties-index', array('config' => 'sec', 'type' => 'related','is_admin'=>$admin, 'latitude' => $this->request->data['Request']['latitude'], 'longitude' => $this->request->data['Request']['longitude']));
					endif;
				endif;
		?>
	</div>
	<?php
		if(isset($hash_keyword) && isset($salt)):
			echo $this->Form->create('Request', array('class' => 'form-horizontal form-request add-property check-form','id'=>'RequestAddForm','action'=>'add/'.$hash_keyword.'/'.$salt));
		else:
			echo $this->Form->create('Request', array('class' => 'form-horizontal form-request add-property','action'=>'add'));
		endif;
	?>
		<div class="clearfix <?php echo $form_class; ?>">
			<?php if (!empty($steps) && $steps >= 1 ): ?>
				<div <?php if ($steps > 1): ?>class="hide"<?php endif;?>>

				<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
					<div class='clearfix'>
						<h3 class="well space textb text-16"><?php echo __l('Users'); ?></h3>
						<?php
						echo $this->Form->autocomplete('Request.username', array('label'=> __l('Users'), 'acFieldKey' => 'Request.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '100', 'acMultiple' => false));
						?>
						<?php if($steps > 1): ?>
						<?php echo $this->Form->input('user_id', array('type' => 'text'));?>
						<?php endif;?>
					</div>
				<?php endif;  ?>

					<fieldset>
							<h3 class="well space textb text-16 bot-mspace"><?php echo __l('Address'); ?></h3>						
						<div class="clearfix top-space pr bot-space result-block mapblock-info">
						 <div class="address-left-block span15 bot-space">
							<div class="clearfix address-input-block">
								<div class="input text required">
								<?php
                                    echo $this->Form->input('address', array('label' => __l('Address'), 'div' => false, 'id' => 'RequestAddressSearch','placeholder' => __l('Address'), 'value' => isset($search_keyword) ? $search_keyword['named']['address'] : ''));
                                ?>
								<span class="info mob-no-mar"><?php echo __l('Address suggestion will be listed when you enter location.<br/> (Note: If address entered is not exact/incomplete, you will be prompted to fill the missing address fields.)'); ?></span>
								</div>
							</div>
        		<?php
								$class = '';
								if (empty($this->request->data['Request']['address']) || ( !empty($this->request->data['Request']['address1']) && !empty($this->request->data['City']['name']) &&  !empty($this->request->data['Request']['country_id']))) {
									$class = 'hide';
								}
							?>
							<div id="js-geo-fail-address-fill-block" class="<?php echo $class;?>">
								<div class="clearfix">
									<div class=" map-address-left-block address-input-block">
							<?php
								echo $this->Form->input('latitude', array('id' => 'latitude', 'type' => 'hidden'));
								echo $this->Form->input('longitude', array('id' => 'longitude', 'type' => 'hidden'));
								echo $this->Form->input('request_id', array('id' => 'request_id', 'type' => 'hidden'));
								echo $this->Form->input('Request.address1', array('placeholder' => __l('Address'),'id' => 'js-street_id','type' => 'text', 'label' => __l('Address')));
	                            echo $this->Form->input('Request.country_id',array('id' => 'js-country_id', 'empty' => __l('Please Select')));
								echo $this->Form->input('State.name', array('placeholder' => __l('City'),'type' => 'text', 'label' => __l('State'), 'empty' => __l('Please Select')));
								echo $this->Form->input('City.name', array('placeholder' => __l('State'),'type' => 'text', 'label' => __l('City')));
								echo $this->Form->input('zoom_level', array('type' => 'hidden', 'id' => "zoomlevel"));
							?>
									</div>
								</div>
							</div>
						</div>
								
									<div class="  js-side-map-div span <?php echo $class;?>">
										<h4><?php echo __l('Point Your Location');?></h4>
										<div class="js-side-map">
											<div id="js-map-container"></div>
											<span><?php echo __l('Point the exact location in map by dragging marker');?></span>
										</div>
									</div>
							<!-- <div id="address-info sfont" class="hide"><?php echo __l('Please select correct address value'); ?></div> -->
							<div id="mapblock" class="pa">
								<div id="mapframe">
									<div id="mapwindow"></div>
								</div>
							</div>
						</div>
					</fieldset>
									</div>
									
					
						<?php
							if($steps == 1): ?>
								<div class="form-actions">
							<?php echo $this->Form->submit(__l('Next'),array('name' => 'data[Request][step1]', 'class' => 'inactive-search btn btn-large btn-primary textb text-16','id' => 'js-sub','div'=>array('class'=>'pull-right submit'))); ?>
							</div>
							<?php endif;
						?>
					
				</div>
			<?php endif; ?>
			<?php if (!empty($steps) && $steps >= 2):  ?>
				<div <?php if($steps > 2): ?>class="hide"<?php endif;?>>
					<fieldset>
							<h3 class="well space textb text-16 bot-mspace"><?php echo __l('General'); ?></h3>
							
							<div class="clearfix date-time-block">
								<div class="input date-time clearfix">
									<div class="js-datetime">
									<div class="js-cake-date">
										<?php echo $this->Form->input('checkin', array('orderYear' => 'asc', 'maxYear' => date('Y') + 10, 'minYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
									</div>
									</div>
								</div>
								<div class="input date-time end-date-time-block clearfix">
									<div class="js-datetime">
									<div class="js-cake-date">
										<?php echo $this->Form->input('checkout', array('orderYear' => 'asc', 'maxYear' => date('Y') + 10, 'minYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
									</div>
									</div>
								</div>
							</div>
							<?php 
								$currency_code = Configure::read('site.currency_id');
								Configure::write('site.currency', $GLOBALS['currencies'][$currency_code]['Currency']['symbol']);
								echo $this->Form->input('price_per_night',array('label'=>__l('Price Per Night (').configure::read('site.currency').__l(')')));
								// @todo "What goodies I can provide (guest)"
								echo $this->Form->input('accommodates', array('label' => __l('Guests'), 'type'=>'select', 'options'=>$accomadation));
								echo $this->Form->input('title');
								echo $this->Form->input('description');
							?>
					</fieldset>
					<div class="form-actions">
						<?php 
							if($steps == 2):
								echo $this->Form->submit(__l('Next'),array('name' => 'data[Request][step2]', 'class' => 'btn btn-large btn-primary textb text-16','div'=>'pull-right submit'));
							endif;
						?>
					</div>
				</div>
			<?php endif; ?>
			<?php if (!empty($steps) && $steps >= 3):  ?>
				<div <?php if($steps > 3): ?>class="hide"<?php endif;?>>
					<?php
						if(isset($this->request->params['named']['checkin'])) {
							$checkin_date=explode('-',$this->request->params['named']['checkin']);
							$this->request->data['Request']['checkin']['month']=$checkin_date[1];
							$this->request->data['Request']['checkin']['year']=$checkin_date[0];
							$this->request->data['Request']['checkin']['day']=$checkin_date[2];
						}
						if(isset($this->request->params['named']['checkout'])) {
							$checkout_date=explode('-',$this->request->params['named']['checkout']);
							$this->request->data['Request']['checkout']['month']=$checkout_date[1];
							$this->request->data['Request']['checkout']['year']=$checkout_date[0];
							$this->request->data['Request']['checkout']['day']=$checkout_date[2];
						}
					?>
					 <fieldset>
					 <h3 class="well space textb text-16 bot-mspace"><?php echo __l('Amenities'); ?></h3>
						  <div class="padd-center">
							 <div class="amenities-list">
												 <div class="clearfix"><div class="pull-left span4 span4-sm no-mar ver-space dr mob-dl"><span class="hor-space show "><?php echo __l('Amenities'); ?></span></div>
													<div class="input checkbox pull-left hor-smspace no-mar span20">
									<?php
										echo $this->Form->input('Amenity', array('type'=>'select','label'=>false, 'multiple'=>'checkbox', 'id'=>'Amenity1','div'=>false,'class'=>'checkbox span5 no-mar'));
										?>
									</div>
									</div>
							<div class="amenities-list top-space">
							<div class="clearfix top-space"><div class="pull-left span4 span4-sm no-mar ver-space dr mob-dl"><span class="hor-space show "><?php echo __l('Holiday Types'); ?></span></div>
							<div class="input checkbox pull-left hor-smspace no-mar span20">
							<?php
							echo $this->Form->input('HolidayType', array('type'=>'select','label'=>false, 'multiple'=>'checkbox', 'id'=>'HolidayType1', 'div'=>false ,'class'=>'checkbox span5 no-mar'));
							?>
							</div>
							</div>
							</div>
	
							<div class="clearfix sep-top">
							<div class="pull-left span4 span4-sm no-mar dr mob-dl"><span class="space show top-mspace"><?php echo __l('Bed Type'); ?></span></div>
							<div class="pull-left no-mar bot-space span20 span20-sm">
							<div class="input radio radio-active-style no-mar ver-space">
                          
                           <?php
											echo $this->Form->input('bed_type_id', array('empty' => __l('Any Type'),'legend'=>false,'type'=>'radio','div'=>'js-radio-style pr','value'=>isset($this->request->data['Request']['bed_type_id'])?$this->request->data['Request']['bed_type_id']:$bed_default));
										?>
                       
                            </div>
                            </div>
                            </div>
								
							<div class="clearfix room-type">
							<div class="pull-left span4 span4-sm no-mar dr mob-dl"><span class="space show top-mspace"><?php echo __l('Room Type'); ?></span></div>
							<div class="pull-left no-mar bot-space span20 span20-sm">
							<div class="input radio radio-active-style no-mar ver-space">
							<?php
											echo $this->Form->input('room_type_id', array('empty' => __l('Any Type'),'type'=>'radio','legend'=>false,'div'=>'js-radio-style pr','id'=>'RequestRoom','value'=>isset($this->request->data['Request']['room_type_id'])?$this->request->data['Request']['room_type_id']:$room_default));
										?>
                            </div>
                            </div>
                            </div>
								
							<div class="property-type"><?php echo $this->Form->input('property_type_id', array('empty' => __l('Any Type'))); ?></div>

						</div>
						</div>
						
					</fieldset>
					<div class="form-actions">
						<?php
							if($steps == 3):
								echo $this->Form->submit(__l('Finish'),array('name' => 'data[Request][step3]', 'class' => 'btn btn-large btn-primary textb text-16','div'=>'pull-right submit'));
							endif;
						?>
					</div>
					
					</div>
			<?php endif;  ?>
			<?php if(!empty($steps) && $steps >= 4 && !empty($request_filters)):  ?>
				<div>
					<div class="dc space textb"><?php echo __l('(OR)'); ?></div>
					<div class="alert alert-info clearfix"><?php echo __l('If the above related property does not match your exact request . You can click "Post" below to create a new one'); ?></div>
					<div class="form-actions">
						<?php
							if($steps == 4):
								echo $this->Form->submit(__l('Post'),array('name' => 'data[Request][step4]', 'class' => 'btn btn-large btn-primary textb text-16','div'=>'pull-right submit'));
							endif;
						?>
					</div>
				</div>
			<?php endif; ?>
		<?php echo $this->Form->end();?>
	</div>