<?php /* SVN: $Id: $ */ ?>
<div class="properties form js-responses">
<div class="clearfix">
		 <div class="cancel-block pull-right ver-space">
		<?php if(!empty($this->request->params['admin'])){
				echo $this->Html->link(__l('Back'), array('action' => 'index', 'admin' => true), array('title' => __l('Back'), 'class'=>'btn btn-large pull-right bot-space top-space'));
			}else{
				echo $this->Html->link(__l('Back'), array('action' => 'index', 'type' => 'myproperties', 'admin' => false), array('title' => __l('Back'),'class'=>'btn btn-large pull-right bot-space top-space'));
			}?>
		</div>
		</div>

<?php echo $this->Form->create('Property', array('class' => 'form-horizontal form-request check-form add-property {is_required:"false"}  js-normal-fileupload', 'enctype' => 'multipart/form-data'));?>
<div class="js-validation-part">
<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
	<fieldset>
		<h3 class="well space textb text-16 bot-mspace"><?php echo __l('Users'); ?></h3>
		<div class="address-left-block span15">
			<?php
				echo $this->Form->autocomplete('User.username', array('label'=> __l('Users'), 'acFieldKey' => 'Property.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '100', 'acMultiple' => false));

			?>
		</div>
	</fieldset>
<?php endif; ?>
<fieldset>
	<h3 class="well space textb text-16 bot-mspace"><?php echo __l('Address'); ?></h3>						
	<div class="clearfix top-space bot-space mapblock-info result-block">
	 <div class="address-left-block span15 bot-space">
				<div class="clearfix address-input-block">
					<?php echo $this->Form->input('address', array('label' => __l('Address'), 'id' => 'PropertyAddressSearch','info'=>'Address suggestion will be listed when you enter location.<br/>
(Note: If address entered is not exact/incomplete, you will be prompted to fill the missing address fields.)')); ?>
						
						</div>
				<?php
					$class = '';
					if (empty($this->request->data['Property']['address']) || (!empty($this->request->data['Property']['address1']) && !empty($this->request->data['City']['name']) &&  !empty($this->request->data['Property']['country_id']))) {
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
								echo $this->Form->input('address1', array('id' => 'js-street_id','type' => 'text', 'label' => __l('Address')));
								echo $this->Form->input('City.name', array('type' => 'text', 'label' => __l('City')));
								echo $this->Form->input('State.name', array('type' => 'text', 'label' => __l('State'), 'empty' => __l('Please Select')));
	                            echo $this->Form->input('Property.country_id',array('id' => 'js-country_id', 'empty' => __l('Please Select')));
							?>
						</div>
					</div>
				</div>
			</div>
			<div class=" ">
				<h4><?php echo __l('Point Your Location');?></h4>
				<div class="js-side-map">
					<div id="js-map-container"></div>
					<span class="span8 no-mar"><?php echo __l('Point the exact location in map by dragging marker');?></span>
				</div>
			</div>
			<div id="mapblock" class="pa">
				<div id="mapframe">
					<div id="mapwindow"></div>
				</div>
			</div>
		</div>
</fieldset>
<fieldset>
		<h3 class="well space textb text-16 bot-mspace"><?php echo __l('General'); ?></h3>
		<div class=" clearfix ver-space ">
		<?php echo $this->Form->input('title', array('label' => __l('Title'), 'class' => 'js-property-title {"count":"'.Configure::read('property.maximum_title_length').'"}'));  ?>
		<span class="character-info info"><?php echo __l('You have').' ';?><span id="js-property-title-count"></span><?php echo ' '.__l('characters left');?></span>
		<?php echo $this->Form->input('description', array('label' => __l('Description'), 'class' => 'js-property-description {"count":"'.Configure::read('property.maximum_description_length').'"}')); ?>
		<span class="character-info info"><?php echo __l('You have') . ' ';?><span id="js-property-description-count"></span><?php echo ' ' . __l('characters left'); ?></span>
		</div>
</fieldset>
  <fieldset>
	  <h3 class="well space textb text-16 bot-mspace"><?php echo __l('Features'); ?></h3>
	  <div class=" clearfix ver-space">
	<?php
		echo $this->Form->input('id', array('type' => 'hidden'));
		echo $this->Form->input('property_type_id', array('label' => __l('Property Type'), 'empty' => __l('Please Select'))); ?>
		
		<div class="clearfix">
							<div class="pull-left span4 span4-sm no-mar dr mob-dl"><span class="space show top-mspace"><?php echo __l('Room Type'); ?></span></div>
						<div class="pull-left no-mar bot-space span20 span20-sm">
							<div class="input radio radio-active-style no-mar ver-space">
							<?php
							  echo $this->Form->input('room_type_id',array('type'=>'radio','id'=>'PropertyRoomID','legend'=>false,'div'=>'js-radio-style'));
							?>
						 </div>
						</div>
						</div>
		<div class="bed-room-block">
		<?php
		echo $this->Form->input('bed_rooms',array('label' => __l('Bed Rooms'), 'type'=>'select', 'empty' => __l('Please Select'),'options'=>$accomadation));
		echo $this->Form->input('beds',array('label' => __l('Beds'), 'type'=>'select', 'empty' => __l('Please Select'),'options'=>$accomadation)); ?>
		</div>
		<div class="clearfix">
							<div class="pull-left span4 span4-sm no-mar dr mob-dl"><span class="space show top-mspace"><?php echo __l('Bed Type'); ?></span></div>
    		<div class="pull-left no-mar bot-space span20 span20-sm">
							<div class="input radio radio-active-style no-mar ver-space">
            		<?php
            		echo $this->Form->input('bed_type_id',array('type'=>'radio','legend'=>false,'div'=>'js-radio-style pr'));
                    ?>
                </div>
            </div>
        </div>
        <div class="bed-room-block">
        <?php
        echo $this->Form->input('bath_rooms',array('label' => __l('Bath Rooms'), 'type'=>'select','options'=>$bathrroom));
		echo $this->Form->input('accommodates',array('type'=>'select','label'=>__l('Max number of guests'), 'class' => 'js-max-guest', 'empty' => __l('Please Select'), 'options'=>$accomadation));
		echo $this->Form->input('size');
						?>
		</div>
						<div class="clearfix">
                             <p class="round-5 add-info tb pull-left span4 no-mar">&nbsp;</p>
							<div class="pull-left no-mar bot-space span20 span20-sm">
							<div class="input radio radio-active-style no-mar ver-space offset5">
						<?php
							echo $this->Form->input('measurement',array('type'=>'radio','legend'=>false,'div'=>'js-radio-style pr','options'=>$moreMeasureActions));
						?>
						</div>
						</div>
						</div>
		<?php
		
		echo $this->Form->input('street_view',array('options' => $moreStreetActions,'div'=>'js-street-container input select'));
		echo $this->Form->input('is_street_view',array('type' => 'hidden'));

		echo $this->Form->input('is_pets',array('label'=>__l('Pets live on this property')));?>
</div>
</fieldset>

  <fieldset class="input ver-space ver-mspace clearfix">
  <div class="padd-center">
	 <div class="amenities-list">
		<div class="clearfix">
			<div class="pull-left span4 span4-sm no-mar ver-space dr mob-dl"><span class="hor-space textb show"><?php echo __l('Amenities'); ?></span></div>
			<div class="input checkbox pull-left hor-smspace no-mar span20">
            <?php
            	echo $this->Form->input('Amenity', array('multiple' => 'checkbox', 'div' => false, 'label' => false,'class' => 'checkbox span5 no-mar'));
            ?> 
            </div>
            </div>
			<div class="amenities-list">
			<div class="clearfix"><div class="pull-left span4 span4-sm no-mar ver-space dr mob-dl"><span class="hor-space show textb"><?php echo __l('Holiday Types'); ?></span></div>
			<div class="input checkbox pull-left hor-smspace no-mar span20">
            <?php
        	echo $this->Form->input('HolidayType', array('div' => false, 'label' => false, 'multiple' => 'checkbox', 'class' => 'checkbox span5 no-mar'));
        	?>
        	</div>
        	</div>
        	</div>
	</fieldset>

	<fieldset>	  
	  <h3 class="well space textb text-16 no-mar"><?php echo __l('Price'); ?></h3>
							<div class="ver-space bot-mspace">
							<div class="alert alert-info clearfix">
		<?php 	$currency_code = Configure::read('site.currency_id');?>
		<?php echo __l('Please mention your property price details in') . ' ' . $GLOBALS['currencies'][$currency_code]['Currency']['symbol'] . $GLOBALS['currencies'][$currency_code]['Currency']['code']; ?>
	</div>
				<?php
		$guest_limit = 20;
		for ($i = 1; $i <= $guest_limit; $i++) {
			$limits[$i] = $i;
		}
		$currency_code = Configure::read('site.currency_id');
		Configure::write('site.currency', $GLOBALS['currencies'][$currency_code]['Currency']['symbol']);
		echo $this->Form->input('price_per_night',array('label'=>__l('Price Per Night (').Configure::read('site.currency').__l(')')));
		echo $this->Form->input('price_per_week',array('label'=>__l('Price Per Week (').Configure::read('site.currency').__l(')')));
		echo $this->Form->input('price_per_month',array('label'=>__l('Price Per Month (').Configure::read('site.currency').__l(')')));
		// @todo "What goodies I want (Host)"
		$class = "hide";
		if(!empty($this->request->data['Property']['accommodates']) && $this->request->data['Property']['accommodates'] > 1) {
			$class = "";
		} ?>
		<div class="clearfix guest-price-block js-guest-price <?php echo $class ?>">
			<?php echo $this->Form->input('additional_guest_price' ,array('class'=>'span4','label' => __l('Additional Guest Price') . ' (' . Configure::read('site.currency') . ')', 'div'=>'pull-left'));  ?>
			<span class="price-infor span5"><?php echo __l('per night for each additional guest after'); ?></span>
			<?php echo $this->Form->input('additional_guest',array('class'=>'span3','div'=>'false', 'label' => false, 'type' => 'select', 'empty' => __l('Please Select'), 'options' => $limits)); ?>
		</div>
		<?php 
		// @todo "Discount percentage"
		echo $this->Form->input('is_negotiable', array('label' => __l('Negotiable pricing')));
		?>
		<span class="info"><?php echo  __l('If you enable negotiable then Traveler will contact you for negotiation'); ?></span>
		<?php
		if (Configure::read('property.is_enable_security_deposit')):
			echo $this->Form->input('security_deposit' ,array('label' => __l('Security Deposit') . ' (' . Configure::read('site.currency') . ')', 'info' => __l('This deposit is for security purpose. When you raise any dispute with the guest, this amount may be used for compensation on any property damages. Note that site decision on this is final.')));
		endif;
		?>
		</fieldset>

<fieldset>
	  <h3 class="well space textb text-16 no-mar"><?php echo __l('Terms'); ?></h3>
							<div class="clearfix ver-space bot-mspace">
         <?php
		echo $this->Form->input('cancellation_policy_id', array('label' => __l('Cancellation Policy'), 'empty' => __l('Please Select')));
		echo $this->Form->input('minimum_nights',array('label' => __l('Minimum Nights'), 'type'=>'select','options'=>$minNights));
		echo $this->Form->input('maximum_nights',array('label' => __l('Maximum Nights'), 'type'=>'select','options'=>$maxNights,'empty'=>'No Maximum'));
		echo $this->Form->input('house_rules',array('label' => __l('House Rules')));
		?>
		<div class="clearfix checkin-checkout-block pr date-time-block">
							
								<div class="js-time" >
								<div class="js-cake-date">
									<?php
										echo $this->Form->input('checkin', array('type' => 'time', 'timeFormat' => 12, 'label' => __l('Check in'), 'orderYear' => 'asc'));
									?>
								</div>
								</div>
								<div class="js-time" >
								<div class="js-cake-date">
									<?php
										echo $this->Form->input('checkout', array('type' => 'time', 'timeFormat' => 12, 'label' => __l('Check out'), 'orderYear' => 'asc'));
									?>
								</div>
								</div>
						
						</div>
						</div>
		</fieldset>
		<fieldset>
	<h3 class="well space textb text-16 no-mar"><?php echo __l('Private Details'); ?></h3>
							<div class="clearfix ver-space bot-mspace">
								<div class="alert alert-info"><?php echo __l('Private details will be shown after booking request has been confirmed'); ?></div>
	<?php
   		echo $this->Form->input('house_manual',array('label' => __l('House Manual'), 'info'=>__l('Private: Traveler will get this information after confirmed reservation. For example, Parking information, Internet access details.')));
		echo $this->Form->input('phone', array('label' => __l('Phone')));
		echo $this->Form->input('backup_phone', array('label' => __l('Backup Phone')));
		echo $this->Form->input('location_manual', array('label' => __l('Location manual'), 'info' => __l(' Enter complete location details like landmark, complete address, zip code, access details, etc')));
	?>
		</fieldset>
</div>
		 <fieldset>
		<h3 class="well space textb text-16 no-mar"><?php echo __l('Photos'); ?></h3>
<div class="clearfix ver-space bot-mspace">		
<div class="alert alert-info ver-mspace">
							<p>The maximum file size for uploads is 8 MB per file.</p>
							<p>File types that can be uploaded are: jpg, gif, png, bmp </p>
							<p>You can "Browse, Cut and Paste, or Drag and Drop" one, multiple, or an entire Folder into this area to upload your image into the site. (some browser restriction apply) </p>
							</div>

							<div class="picture ">
								<div class="input file required dragdrop">
									<label for="ContestUserTitle"><?php echo __l('File'); ?></label>
									<span class="space hor-mspace">
										<span class="btn btn-success fileinput-button">
											<span><?php echo __l('Add files...'); ?></span>
											<?php
												$allowedExt = implode(', ', Configure::read('photo.file.allowedExt'));
												$success_url = Router::url(array('controller' => 'properties', 'action' => 'update_redirect', 'admin'=> false), true);
												if(!empty($this->request->data['Property']['id'])) {
													$success_url = Router::url(array('controller' => 'properties', 'action' => 'view', $this->request->data['Property']['slug'], 'admin'=> false), true);
												} ?>
												<input id="AttachmentFilename" class="fileUpload" type="file" multiple="multiple" name="data[Attachment][filename][]" data-allowed-extensions="<?php echo $allowedExt?>" data-maximum-number-of-photos="<?php echo Configure::read('property.max_upload_photo')?>" data-success-url="<?php echo $success_url?>">
												<?php //echo $this->Form->input('Attachment.filename. ', array('type' => 'file', 'label' => false, 'div' => false, 'class' => 'fileUpload', 'multiple' => 'multiple', 'data-allowed-extensions' => $allowedExt, 'data-maximum-number-of-photos' => Configure::read('property.max_upload_photo'), 'data-success-url' => $success_url));
											?>
										</span>
									</span>
								</div>
								<div class="time-desc datepicker-container clearfix">
									<table role="presentation" class="table table-striped">
										<tbody class="files">
											<?php
												if (!empty($this->request->data['Attachment'])) {
													for($p = 0; $p < count($this->request->data['Attachment']); $p++) {
														if (!empty($this->request->data['Attachment']) && !empty($this->request->data['Attachment'][$p]['filename'])) {
											?>
											<tr class="template-upload" id="js-delete-<?php echo $this->request->data['Attachment'][$p]['id']; ?>">
												<td>
													<span class="preview"><?php echo $this->Html->showImage('Property', $this->request->data['Attachment'][$p], array('dimension' => 'iphone_small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($this->request->data['Attachment'][$p]['filename'], false)), 'title' => $this->Html->cText($this->request->data['Attachment'][$p]['filename'] , false))); ?></span>
												</td>
												<td>
													<p class="name"><?php echo $this->request->data['Attachment'][$p]['filename']; ?></p>	
													<div id="js-error-message-<?php echo $this->request->data['Attachment'][$p]['id']; ?>"></div>
												</td>
												<td></td>
												<td>
													<button class="btn btn-warning js-delete-attach" data-remove_part="js-delete-<?php echo $this->request->data['Attachment'][$p]['id']; ?>" data-error="js-error-message-<?php echo $this->request->data['Attachment'][$p]['id']; ?>" data-url="<?php echo Router::url(array('controller'=> 'properties', 'action' => 'attachment_delete', $this->request->data['Attachment'][$p]['id'],'admin'=>false), true); ?>"><span>Delete</span></button>
												</td>
											</tr>
											<?php
														}
													}
												}
											?>
										</tbody>
									</table>
									<!-- The template to display files available for upload -->
									<script id="template-upload" type="text/x-tmpl">
									{% for (var i=0, file; file=o.files[i]; i++) { %}
										<tr class="template-upload fade">
											<td>
												<span class="preview"></span>
											</td>
											<td>
												<p class="name">{%=file.name%}</p>
												{% if (file.error) { %}
													<div><span class="label label-danger">Error</span> {%=file.error%}</div>
												{% } %}
											</td>
											<td>
												<p class="size">{%=o.formatFileSize(file.size)%}</p>
												{% if (!o.files.error) { %}
													<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar bar-success" style="width:0%;"></div></div>
												{% } %}
											</td>
											<td>
												{% if (!o.files.error && !i && !o.options.autoUpload) { %}
													<button class="btn btn-primary start hide">
														<span>Start</span>
													</button>
												{% } %}
												{% if (!i) { %}
													<button class="btn btn-warning cancel js-upload-cancel">
														<span>Cancel</span>
													</button>
												{% } %}
											</td>
										</tr>
									{% } %}
									</script>
									<!-- The template to display files available for download -->
									<script id="template-download" type="text/x-tmpl">
									{% for (var i=0, file; file=o.files[i]; i++) { %}
										<tr class="template-download fade">
											<td>
												<span class="preview">
													{% if (file.thumbnailUrl) { %}
														<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
													{% } %}
												</span>
											</td>
											<td>
												<p class="name">
													{% if (file.url) { %}
														<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
													{% } else { %}
														<span>{%=file.name%}</span>
													{% } %}
												</p>
												{% if (file.error) { %}
													<div><span class="label label-danger">Error</span> {%=file.error%}</div>
												{% } %}
											</td>
											<td>
												<span class="size">{%=o.formatFileSize(file.size)%}</span>
											</td>
											<td>
												{% if (file.deleteUrl) { %}
													<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
														<i class="glyphicon glyphicon-trash"></i>
														<span>Delete</span>
													</button>
												{% } else { %}
													<button class="btn btn-warning cancel js-upload-cancel">
														<span>Cancel</span>
													</button>
												{% } %}
											</td>
										</tr>
									{% } %}
									</script>
								</div>
		</div>
	</fieldset>
	<fieldset>
							<h3 class="well space textb text-16 no-mar"><?php echo __l('Video'); ?></h3>
<div class="clearfix ver-space bot-mspace">							
								<?php echo $this->Form->input('video_url',array('label'=>__l('Video URL'),'info' => __l('You can post video URL from YouTube, Vimeo etc.'))); ?>
					</fieldset>
	<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin) { ?>
		<fieldset>
	<h3 class="well space textb text-16 no-mar"><?php echo __l('Admin Actions'); ?></h3>
	<?php
		if (Configure::read('property.is_property_verification_enabled')):
			echo $this->Form->input('is_verified', array('type' => 'checkbox', 'label' => __l('Verified')));
		endif;
		echo $this->Form->input('is_featured', array('label' => __l('Featured')));
		echo $this->Form->input('is_show_in_home_page', array('label' => __l('Show in home page'),'type'=>'hidden'));
	?>
		</fieldset>
		<?php } ?>
	<div class="form-actions">
		<div class="fileupload-buttonbar submit pull-right">
			<?php echo $this->Form->submit(__l('Update'), array('class' => 'btn btn-primary btn-large textb text-16 js-fileupload-enable'));?>
		</div>
    </div>
    <?php echo $this->Form->end();?>
</div>