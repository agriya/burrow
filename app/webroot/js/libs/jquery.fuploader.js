 (function($) {
    $.fn.fuploader = function(selector) {
        var $this = $(selector);
        // Step 2: Add the uploader
        $('.flashUploader', $this).each(function(j) {
            var $this = $(this).parent('.js-uploader');
            $oUpload = ('oUpload' + j);
            var $oUpload = $(this).uploader( {
                swfURL: __cfg('path_relative') + 'flash/jQuery.uploader.swf',
                buttonSkin: __cfg('path_relative') + 'img/jquery_uploader/buttonSkin.png',
                logging: "1",
                backendScript: __cfg('path_relative') + $this.metadata().controller + '/flashupload/' + $this.metadata().session,
                movieID: $this.metadata().movieid,
                maxFileSize: $this.metadata().filesize,
                maxQueueSize: $this.metadata().queuefilesize,
                maxQueueCount: $this.metadata().filecount
            });
            // Step 3: Overwrite the events (base events have allready been setup)
            this.__uploaderCache = $oUpload;
            // because of scope issue and to get the object for firing upload
            $oUpload.__uploaderRedirectURL = $this.metadata().redirectURL;
            $oUpload._bakendScript = __cfg('path_relative') + $this.metadata().controller + '/flashupload/' + $this.metadata().session;
            $oUpload._previewScript = __cfg('path_relative') + $this.metadata().controller + '/thumbnail/' + $this.metadata().session;
            $oUpload.__movieid = $this.metadata().movieid;
            $oUpload.__uPreview = $this.metadata().uPreview;

            jQuery.extend($oUpload.events, {
/**
				 * SWF ready handler, used to bind the events the way YOU want.
				 */
                uploaderReady: function() {
                    var _self = this;
                    var $this = jQuery('#' + this._settings.containerID).parent('.js-uploader');
                    if ($this.parent().find('.normal-uploader').length) {
						preview_movie_id = (this.__movieid).substring(13);
						jQuery('#' + this._settings.containerID).before('<div class="uploader-error"></div>');
                        jQuery('#' + this._settings.containerID).before('<div class="wuQ"></div>');
                        jQuery('#' + this._settings.containerID).after('<div class="clearAll" id="'+preview_movie_id+'"><a href="javascript://" class="clear js-preview-close {\'id\': \'' + preview_movie_id + '\'}" title="Delete ">&nbsp;</a></div>');
                        jQuery('.wuQ', $this).hide();
                        jQuery('.clearAll', $this).hide();
                        jQuery('.uploader-error', $this).hide();
                        jQuery('.normal-uploader', $this).remove();
                        // Clear the entire queue (e.g. remove all files)
                        jQuery('A.clear', $this).click(function() {
                            _self.remove();
                        });
                        this.setFilters([ {
                            description: 'Files ( ' + $this.metadata().filetype + ' )',
                            extensions: $this.metadata().filetype
                        }]);
                    }
                },


/**
				 * File added handler
				 */
                fileAdded: function(args) {
                    var $this = jQuery('#' + this._settings.containerID).parent('.js-uploader');
                    jQuery('.wuQ', $this).show();
                    //jQuery('.clearAll', $this).show();
                    var _id = '';
                    _id = args.fileData.id;
                    var sHTML = '';
                    sHTML += '<div class="wuI" id="' + _id + '">';
                    sHTML += '<div class="wuIC">';
                    //sHTML += '<a href="javascript://" class="file-delete" title="Delete upload">&nbsp;</a> ';
                    //sHTML += '&nbsp;' + args.fileData.name + '<br />';
                    sHTML += '<div class="wuICPB"><div class="wuICPBF"> 0% </div></div>';
                    //sHTML += '<div class="wuICPT"><span class="wuICBytesDone">0 bytes</span> of <span class="wuICBytesTotal">' + this.formatSize(args.fileData.size) + '</span> <span class="wuICSpeedTime">&nbsp;</span></div>';
                    sHTML += '</div></div>';
                    var _elem = jQuery(sHTML);
                    jQuery('.wuQ', $this).append(_elem);
                    // Add handler
                    var _self = this;
                    //
                    // Triggers file removal
                    jQuery('A.file-delete', _elem).click(function() {
                        uploadDelete(jQuery(this), _self)
                        });
                    if (this.__uPreview == '1') {
                        _self.upload('', this._bakendScript);
                    }
                    // Prevent me from calling this in a later function ...
                    _elem = null;
                },


/**
				 * File removed handler
				 */
                fileRemoved: function(args) {
                    jQuery('#' + args.fileData.id).slideUp("fast", function() {
                        jQuery(this).remove();
                    });
                },


/**
				 * File upload handler,
				 * in this demo used to change the icons
				 */
                fileUploadStarted: function(args) {
                    var _id = args.fileData.id;
                    var _self = this;
                    var _elem = jQuery('#' + _id);
                    // You could delete the file while uploading,
                    // (since this would trigger a "cancel" event in the Flash movie which is send to JavaScript)
                    // but for the sake of the demo, we don't allow it.
                    //
                    // Fix links
                    jQuery('A.file-delete', _elem).disableLink();
                    // Animate the progressbar
                    _elem.addClass('active').animate( {
                        height: 80
                    }, 200);
                    //
                    // Show elements
                    jQuery('DIV.wuICPB', _elem).show();
                    jQuery('DIV.wuICPT', _elem).show();
                },


/**
				 * File progress handler
				 * in this demo used to update the progressbar
				 * @param args.fileData
				 * @param args.fileProgress
				 * @param args.queueProgress
				 */
                fileUploadProgress: function(args) {
                    var _id = args.fileData.id;
                    var _self = this;
                    var _elem = jQuery('#' + _id);
                    jQuery('div.wuICPBF', _elem).css('width', args.fileProgress.progress + '%').html('&nbsp;' + args.fileProgress.progress + '%&nbsp;');
                    jQuery('span.wuICBytesDone', _elem).html(this.formatSize(args.fileProgress.bytesCompleted));
                    jQuery('span.wuICSpeedTime', _elem).html('at ' + this.formatSize(args.fileProgress.bytesPerSecond) + '/sec; ' + this.formatTime(args.fileProgress.timeRemaining) + ' remain');
                },


/**
				 * Triggered when a file is cancelled
				 */
                fileUploadCancelled: function(args) {
                    var _id = args.fileData.id;
                    var _self = this;
                    var _elem = jQuery('#' + _id);
                    uploadRestore(_elem, _self, true);

                },


/**
				 * Triggered when a file is uploaded (or has an error)
				 */
                fileUploadCompleted: function(args) {
                    var _id = args.fileData.id;
                    var _self = this;
                    var _elem = jQuery('#' + _id);
                    uploadRestore(_elem, _self, false);
                    if (args.queueProgress.filesAdded == args.queueProgress.filesCompleted) {}
                },

/**
				* Triggered for every file upload that receives data back from the server.
				 */
                fileUploadServerData: function(args) {
                    var $this = jQuery('#' + this._settings.containerID).parent('.js-uploader'); 
					var _id = args.fileData.id;
                    serverData = (args.serverData);					
                    preview_movie_id = (this.__movieid).substring(13);
                        if (this.__uPreview == '1') {
							$splited_info=serverData.split('|');
                            file_id = $splited_info[0];
							file_desc = $splited_info[1];
                            $('#preview_image' + preview_movie_id).html('<img src="' + this._previewScript + '/' + file_id + '" ><input type="hidden" name="data[Attachment][' + preview_movie_id + '][filename]" value="' + file_id + '">');	
							$('#Attachment'+ preview_movie_id+'Description').attr('value',file_desc);
							$('#Attachment'+ preview_movie_id+'Description').focus();

							jQuery('.clearAll', $this).show();
							
							jQuery('.clearAll', $this).click(function() {
								id = $(this).attr('id');								
								removePreview(id);
							});
						}
                },


/**
				 * Triggered when a file is uploaded (or has an error)
				 */
                fileUploadError: function(args) {
                    var _id = args.fileData.id;
                    var _self = this;
                    var _elem = jQuery('#' + _id);
                    uploadRestore(_elem, _self, false);
                },
                queueCleared: function() { 
                    var $this = jQuery('#' + this._settings.containerID).parent('.js-uploader');
                    jQuery('.wuQ', $this).hide();
                    jQuery('.clearAll', $this).hide();
                    jQuery('.uploader-error', $this).hide();
                },


/**
				 * Triggered for every file that the users tries to add which would exceed the maximum queue count.
				 */
                queueErrorCount: function() {
                    var $this = jQuery('#' + this._settings.containerID).parent('.js-uploader');
                    jQuery('.uploader-error', $this).show();
                    jQuery('.uploader-error', $this).html('<p class=\'errorMsg\'>You can add maximum of ' + this._settings.maxQueueCount + ' files in a queue</p>');
                    $('.uploader-error p', $this).flashMsg();
                },


/**
				 * Triggered for every file that the users tries to add which would exceed the maximum queue size.
				 */
                queueErrorSize: function() {
                    var $this = jQuery('#' + this._settings.containerID).parent('.js-uploader');
                    jQuery('.uploader-error', $this).show();
                    jQuery('.uploader-error', $this).html('<p class=\'errorMsg\'>Sorry, exceeds the maximum queue size ' + (this._settings.maxFileSize / (1024 * 1024)) + ' MB</p>');
                    $('.uploader-error p', $this).flashMsg();
                },


/**
				 * Triggered for every file that is selected, but exceeds the maximum allowed filesize.
				 */
                fileErrorSize: function(args) {
                    var $this = jQuery('#' + this._settings.containerID).parent('.js-uploader');
                    jQuery('.uploader-error', $this).show();
                    jQuery('.uploader-error', $this).html('<p class=\'errorMsg\'>\'' + args.fileData.name + '\' exceeds the maximum allowed size ' + (this._settings.maxFileSize / (1024 * 1024)) + ' MB</p>');
                    $('.uploader-error p', $this).flashMsg();
                },


/**
				 * Triggered for every file that is selected, but invalid extension.
				 */
                fileErrorExtension: function(args) {
                    var $this = jQuery('#' + this._settings.containerID).parent('.js-uploader');
                    jQuery('.uploader-error', $this).show();
                    jQuery('.uploader-error', $this).html('<p class=\'errorMsg\'>\'' + args.fileData.name + '\' is invalid extension</p>');
                    $('.uploader-error p', $this).flashMsg();
                }
            });
        });
    };
})
(jQuery);
/**
 * Disables the link
 */
jQuery.fn.disableLink = function(fn) {
    return jQuery(this).blur().unbind('click').fadeTo("fast", 0.2, (fn ? fn: null));
};
/**
 * Removes the upload (manually) by clicking the eject button
 */
function uploadDelete(_link, _self) {
    var _id = _link.parent().parent().attr('id');
    // Disable links to prevent user from clicking again which could screw up the interface
    jQuery('#' + _id + ' A.delete').disableLink();
    // Send the "remove" event to flash
    _self.remove(_id);
}
/**
 * Starts the upload (manually) by clicking the play button
 */
function uploadStart(_link, _self) {
    _self.upload(_link.parent().parent().attr('id'), jQuery.uploader.backendScript);
}
/**
 * Restores the element back to it's "not started" state.
 */
function uploadRestore(_elem, _self, _allowRemoveOrRetry) {
    //
    // Fix links
    if (_allowRemoveOrRetry) {
        jQuery('A.delete', _elem).fadeTo("fast", 1.0).click(function() {
            uploadDelete(jQuery(this), _self)
            });
    }
    // Fix progressbar
    jQuery('DIV.wuICPB', _elem).hide();
    jQuery('div.wuICPBF', _elem).width(0).html(' 0% ');
    jQuery('DIV.wuICPT', _elem).hide();
    // Animate the progressbar
    _elem.removeClass('active').animate( {
        height: 0
    }, 200);
}
function removePreview(preview_movie_id){
	$('#preview_image' + preview_movie_id).html('');		
	if($('#old_attachment'+preview_movie_id)){
			$('#old_attachment'+preview_movie_id).val('1');
	}
    return true;
}