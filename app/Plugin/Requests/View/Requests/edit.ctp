<?php /* SVN: $Id: $ */ ?>
<div class="requests form">
<?php echo $this->Form->create('Request', array('class' => 'form-horizontal form-request add-property check-form'));?>
	<?php if (empty($this->request->params['prefix'])): ?>
	 	<h2  class="ver-space top-mspace text-32 sep-bot"><?php echo __l('Edit Request');?></h2>
	<?php endif; ?>
<fieldset>
<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
					<div class='clearfix'>
						<h3 class="well space textb text-16"><?php echo __l('Users'); ?></h3>
						<?php
						echo $this->Form->autocomplete('Request.username', array('label'=> __l('Users'), 'acFieldKey' => 'Request.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '100', 'acMultiple' => false));
						?>
					</div>
				<?php endif;  ?>

	<h3 class="well space textb text-16 bot-mspace"><?php echo __l('Address'); ?></h3>
         <div class="mapblock-info clearfix pr">
						 <div class="address-left-block span15">
							<div class="clearfix address-input-block">
            	<?php
    				echo $this->Form->input('address', array('label' => __l('Address'), 'id' => 'RequestAddressSearch'));
					echo $this->Form->input('zoom_level', array('type' => 'hidden', 'id' => "zoomlevel"));
    			?>
    			</div>
          <div id="mapblock" class="pa">
        		<div id="mapframe">
        			<div id="mapwindow"></div>
        		</div>
        	</div>
    	</div>
    	</div>
</fieldset>
<fieldset>
		<h3 class="well space textb text-16 bot-mspace"><?php echo __l('General'); ?></h3>
    	<div class="clearfix date-time-block">
    		<div class="input date-time clearfix">
    			<div class="js-datetime">
				<div class="js-cake-date">
    				<?php echo $this->Form->input('checkin', array('orderYear' => 'asc', 'maxYear' => date('Y') + 10, 'minYear' => date('Y')-10, 'div' => false, 'empty' => __l('Please Select'))); ?>
    			</div>
    			</div>
    		</div>
    		<div class="input date-time end-date-time-block clearfix">
    			<div class="js-datetime">
				<div class="js-cake-date">
    				<?php echo $this->Form->input('checkout', array('orderYear' => 'asc', 'maxYear' => date('Y') + 10, 'minYear' => date('Y')-10, 'div' => false, 'empty' => __l('Please Select'))); ?>
    			</div>
    			</div>
    		</div>
    	</div>
		<?php 
			$currency_code = Configure::read('site.currency_id');
			Configure::write('site.currency', $GLOBALS['currencies'][$currency_code]['Currency']['symbol']);
			echo $this->Form->input('id',array('type'=>'hidden'));
			echo $this->Form->input('price_per_night',array('label'=>__l('Price Per Night (').configure::read('site.currency').__l(')')));
			// @todo "What goodies I can provide (guest)"
			echo $this->Form->input('accommodates', array('label' => __l('Guests'), 'type'=>'select', 'options'=>$accomadation));
		?>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		?>
	</fieldset><fieldset class="input ver-space ver-mspace clearfix">
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
							<div class="clearfix top-space"><div class="pull-left span4 span4-sm no-mar ver-space dr mob-dl"><span class="hor-space  show "><?php echo __l('Holiday Types'); ?></span></div>
							<div class="input checkbox pull-left hor-smspace no-mar span20">
							<?php
							echo $this->Form->input('HolidayType', array('type'=>'select','label'=>false, 'multiple'=>'checkbox', 'id'=>'HolidayType1', 'div'=>false,'class'=>'checkbox span5 no-mar'));
							?>
							</div>
							</div>
							</div>
	
							<div class="clearfix">
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
					</fieldset>
                

	<div class="form-actions">
	<?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-large btn-primary textb text-16','div'=>'pull-right submit'));?>
	</div>
	<?php echo $this->Form->end();?>
</div>
