/**
 * Uploader: unobtrusive file uploads using Flash and jQuery.
 *
 * Copyright (c) 2008, Webunity
 * All rights reserved.

 * Redistribution and use of this software in source and binary forms, with or
 * without modification, are permitted provided that the following conditions
 * are met:
 * 		- Redistributions of source code must retain the above copyright
 *        notice, this list of conditions and the following disclaimer.
 * 		- Redistributions in binary form must reproduce the above copyright
 *        notice, this list of conditions and the following disclaimer in the
 *        documentation and/or other materials provided with the distribution.
 * 		- Neither the name of Webunity nor the names of its contributors may
 *        be used to endorse or promote products derived from this software
 *        without specific prior written permission of Webunity.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF
 * THE POSSIBILITY OF SUCH DAMAGE.
 *
 * -----
 *
 * Documentation:
 * Please refer to the wiki on <http://jquery.webunity.nl> for up to date documentation.
 */
(function($) {
	//
	// Create class
	$.uploader = function(containerID, settings) {
			this.construct(containerID, settings)
		};

	//
	// Extend object
	$.extend($.uploader.prototype, {

// ----------------------------------------------------------------------------------------------------
// Public variables
// ----------------------------------------------------------------------------------------------------

			/**
			 * Event array
			 * @property events
			 * @type array
			 */
			events: new Array(),



// ----------------------------------------------------------------------------------------------------
// Private variables
// ----------------------------------------------------------------------------------------------------

			/**
			 * The cache of the events
			 * @property _eventsQueue
			 * @type array
			 * @private
			 */
			 _eventsQueue: new Array(),

			/**
			 * The cache of the SWF objects
			 * @property _cache
			 * @type array
			 * @private
			 */
			_cache: new Array(),

			/**
			 * A reference to the embedded SWF file.
			 * @property _swf
			 * @private
			 */
			_swf: null,

			/**
			 * The initializing attributes are stored here until the SWF is ready.
			 * @property _settings
			 * @type Object
			 * @private
			 */
			_settings: null,

			/**
			 * The constructor
			 */
			construct: function(containerID, settings) {
					//
					// Overwrite default properties
					settings = settings || {};

					//
					// Basic settings
					settings.containerID = containerID
					settings.movieID = settings.movieID || ('uploader' + (this._cache.length + 1));
					settings.backgroundColor = settings.backgroundColor || '#ffffff';
					settings.wmode = settings.wmode || 'transparent';

					//
					// Properties
					settings.logging = settings.logging || "0";
					settings.allowedDomain = settings.allowedDomain || "*";
					settings.enabled = settings.enabled || "1";
					settings.multiple = settings.multiple || "1";
					settings.maxFileSize = settings.maxFileSize || -1;
					settings.maxQueueSize = settings.maxQueueSize || -1;
					settings.maxQueueCount = settings.maxQueueCount || -1;
					settings.maxThreads = settings.maxThreads || "6";
					settings.autoAdvanceOnCancel = settings.autoAdvanceOnCancel || "1";
					settings.autoAdvanceOnError = settings.autoAdvanceOnError || "1";

					//
					// Check skin
					if (settings.buttonSkin == '') {
						settings.wmode = 'transparent';
					}

					//
					// set up the initial events and attributes
					this._eventsQueue = this._eventsQueue || [];
					this._configs = this._configs || {};
					this._settings = settings;

					//
					// Events which can be triggered from JavaScript
					this.events = this.events || {};
					$.extend(this.events, {
							/**
							 * ----------------
							 * fileData object:
							 * ----------------
							 *
							 * id				{String}	The unique ID of the file.
							 * name				{String}	The filename (without path).
							 * extension		{String}	The file extension.
							 * creationDate		{String}	The number of milliseconds since midnight January 1, 1970, universal time.
							 * modificationDate	{String}	The number of milliseconds since midnight January 1, 1970, universal time.
							 * size				{Integer}	The filesize in bytes.
							 */

							/**
							 * --------------------
							 * fileProgress object:
							 * --------------------
							 *
							 * status			{String}	The status of the file.
							 *								"idle"			Status of the file after it has been added to the queue.
							 *								"queued"		Status of the file after an upload command for this file is issues.
							 *								"uploading"		Status of the file after the upload has started.
							 *								"uploaded"		Status of the file after it has been uploaded succesfully.
							 *								"cancelled"		Status of the file after it has been cancelled.
							 *								"error (...)"	Status of the file in case an error (IO/HTTP/Security) has occured.
							 * bytesCompleted	{Integer}	The number of bytes that have been uploaded for this file.
							 * bytesTotal		{Integer}	The total ammount of bytes for this file.
							 * bytesRemaining	{Integer}	The number of bytes that remain to be uploaded.
							 * bytesPerSecond	{Integer}	The current speed (bytes/second).
							 * timeStarted		{Integer}	The number of milliseconds since midnight January 1, 1970, universal time.
							 * timeBusy			{Integer}	The number of seconds since we started uploading.
							 * timeRemaining	{Integer}	The number of seconds remaining for this upload.
							 * progress			{Integer}	A representation of the progress (in %).
							 */

							/**
							 * --------------------
							 * queueProgress object
							 * --------------------
							 *
							 * bytesTotal		{Integer}	The number of bytes in this queue
							 * bytesCompleted	{Integer}	The number of bytes that have been uploaded for the current queue.
							 * bytesRemaining	{Integer}	The number of bytes that remain to be uploaded.
							 * bytesPerSecond	{Integer}	The current speed (bytes/second).
							 * timeStarted		{Integer}	The number of milliseconds since midnight January 1, 1970, universal time.
							 * timeBusy			{Integer}	The number of seconds since we started uploading.
							 * timeRemaining	{Integer}	The number of seconds remaining for this upload.
							 * progress			{Integer}	A representation of the progress (in %).
							 * filesAdded		{Integer}	The number of files added to the queue.
							 * filesCompleted	{Integer}	The number of files that have been succesfully completed.
							 * filesRejected	{Integer}	The number of files that where rejected in the queue.
							 * filesErrors		{Integer}	The number of files that errored while uploading.
							 * filesCancelled	{Integer}	The number of files that the user cancelled.
							 */



						// ----------------------------------------------------------------------------------------------------
						// Constructor
						// ----------------------------------------------------------------------------------------------------

							/**
							 * Triggered after the uploader control is ready to communicate.
							 *
							 * You could (for instance) overwrite the default properties in this way:
							 * <code>
							 * 		this._swf.setMultiple(true);
							 * 		this._swf.setMaxFileSize(-1);
							 * 		this._swf.setMaxQueueSize(-1);
							 * 		this._swf.setMaxQueueCount(-1);
							 * 		this._swf.setMaxThreads(2);
							 * 		this._swf.setFilters([]);
							 * </code>
							 */
							uploaderReady: function () { },

							/**
							 * Triggered when the initialization of the uploader control failed
							 */
							uploaderFailed: function () {},

						// ----------------------------------------------------------------------------------------------------
						// UI events
						// ----------------------------------------------------------------------------------------------------

							/**
							 * Triggered when the mouse rolls over of the uploader control.
							 */
							rollOver: function() {},

							/**
							 * Triggered when the mouse is down on the uploader control.
							 */
							mouseDown: function() { },

							/**
							 * Triggered when the mouse is released after a mousedown event on the uploader control.
							 */
							mouseUp: function() {},

							/**
							 * Triggered when the mouse rolls out of the uploader control.
							 */
							rollOut: function() {},

							/**
							 * Triggered just before the dialog is openend where users can select more then 1 file.
							 * Tip: Usefull for displaying a lightbox.
							 */
							multipleFilesDialogOpened: function() {},

							/**
							 * Triggered when "browse for multiple files" dialog is closed.
							 * You should hide your lightbox here ;)
							 *
							 * @param	args.selectedFiles
							 */
							multipleFilesDialogClosed: function(args) {},

							/**
							 * Triggered when the user had the opportunity to select multiple files, but did not select any files.
							 */
							multipleFilesDialogCancelled: function() {},

							/**
							 * Triggered when the "browse for single file" is opened.
							 */
							singleFileDialogOpened: function() {},

							/**
							 * Triggered when the "browse for single file" is closed.
							 *
							 * @param	args.selectedFiles
							 */
							singleFileDialogClosed: function(args) {},

							/**
							 * Triggered when the user does not select a file in the "browse for single file" dialog.
							 */
							singleFileDialogCancelled: function() {},



						// ----------------------------------------------------------------------------------------------------
						// Queue events
						// ----------------------------------------------------------------------------------------------------

							/**
							 * Triggered for every file that is selected, but exceeds the maximum allowed filesize.
							 *
							 * @param args.fileData
							 */
							fileErrorSize: function(args) { },

							/**
							 * Triggered for every file that is selected, but does not match allowed extensions.
							 *
							 * @param args.fileData
							 */
							fileErrorExtension: function(args) { },

							/**
							 * Triggered when a file was not found in the queue. Gives back which function triggered it: "cancel", "remove" (or) "upload".
							 *
							 * @param args.where
							 */
							fileErrorNotFound: function(args) { },

							/**
							 * Triggered for every file that the users tries to add which would exceed the maximum queue size.
							 *
							 * @param args.fileData
							 */
							queueErrorSize: function(args) { },

							/**
							 * Triggered when there are no files in the queue. Gives back which function triggered it: "cancel", "remove" (or) "upload".
							 *
							 * @param args.where
							 */
							queueErrorEmpty: function(args) { },

							/**
							 * Triggered for every file that the users tries to add which would exceed the maximum queue count.
							 *
							 * @param args.fileData
							 */
							queueErrorCount: function(args) { },

							/**
							 * Triggered for every file that is succesfully added to the queue.
							 *
							 * @param args.fileData
							 * @param args.fileProgress
							 */
							fileAdded: function(args) { },

							/**
							 * Triggered for every file that is succesfully removed from the queue.
							 *
							 * @param args.fileData
							 * @param args.fileProgress
							 */
							fileRemoved: function(args) { },

							/**
							 * Triggerd when all files have been removed from the queue
							 *
							 * @param args.queueProgress
							 */
							queueCleared: function() {},



						// ----------------------------------------------------------------------------------------------------
						// Progress and status events
						// ----------------------------------------------------------------------------------------------------

							/**
							 * Triggered when the upload of the queue is starting.
							 */
							queueStarted: function() {},

							/**
							 * Triggered for every file upload that is started.
							 *
							 * @param args.fileData
							 * @param args.fileProgress
							 * @param args.queueProgress
							 */
							fileUploadStarted: function(args) { },

							/**
							 * Triggered whenever a progress event is triggered in Flash.
							 *
							 * @param args.fileData
							 * @param args.fileProgress
							 * @param args.queueProgress
							 */
							fileUploadProgress: function(args) { },

							/**
							 * Triggered for every file upload that is cancelled.
							 *
							 * @param args.fileData
							 * @param args.fileProgress
							 * @param args.queueProgress
							 */
							fileUploadCancelled: function(args) { },

							/**
							 * Triggered for every file that is succesfully uploaded.
							 *
							 * @param args.fileData
							 * @param args.fileProgress
							 * @param args.queueProgress
							 */
							fileUploadCompleted: function(args) { },

							/**
							 * Triggered for every file in case an error (IO/HTTP/Security) occured.
							 *
							 * @param args.fileData
							 * @param args.fileProgress
							 * @param args.queueProgress
							 */
							fileUploadError: function(args) { },

							/**
							 * Triggered for every file upload that receives data back from the server.
							 *
							 * @param args.fileData
							 * @param args.fileProgress
							 * @param args.queueProgress
							 * @param args.serverData
							 */
							fileUploadServerData: function(args) { },


							/**
							 * Triggered when the queue is cancelled
							 *
							 * @param args.queueProgress
							 */
							queueCancelled: function(args) {},

							/**
							 * Triggered when all files have been PROCESSED. This does not mean that all files are succesfully uploaded.
							 * You have to compare the queueProgress.filesAdded and queueProgress.filesCompleted properties for this.
							 *
							 * @param args.queueProgress
							 */
							queueCompleted: function(args) {}
						});

					//
					// Prepare the mbed
					var rand = Math.floor(Math.random() * 10000);

					//
					// Assemble flash vars
					var swfVars = new Array();
					swfVars['eventHandler'] = 'jQuery.uploader.eventHandler';
					swfVars['elementID'] = this._settings.movieID;
					if (this._settings.buttonSkin) {
						swfVars['buttonSkin'] = this._settings.buttonSkin;
					}
					swfVars['logging'] = this._settings.logging;
					swfVars['allowedDomain'] = this._settings.allowedDomain;
					swfVars['enabled'] = this._settings.enabled;
					swfVars['multiple'] = this._settings.multiple;
					swfVars['maxFileSize'] = this._settings.maxFileSize;
					swfVars['maxQueueSize'] = this._settings.maxQueueSize;
					swfVars['maxQueueCount'] = this._settings.maxQueueCount;
					swfVars['maxThreads'] = this._settings.maxThreads;
					swfVars['autoAdvanceOnCancel'] = this._settings.autoAdvanceOnCancel;
					swfVars['autoAdvanceOnError'] = this._settings.autoAdvanceOnError;
					fVars = '';
					for (var idx in swfVars) {
						if (fVars != '')
							fVars+= '&';
						fVars+= idx + '=' + swfVars[idx];
					}

					//
					// http://www.adobe.com/products/flashplayer/download/detection_kit/
					swfHTML = AC_FL_GetContent(
										'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
										'width', '100%',
										'height', '100%',
										'menu', 'false',
										'src', this._settings.swfURL + "?" + rand,
										'quality', 'high',
										'bgcolor', this._settings.backgroundColor,
										'id', this._settings.movieID,
										'name', this._settings.movieID + 'Name',
										'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
										'movie', this._settings.swfURL + "?" + rand,
										'flashvars', fVars,
										'wmode', this._settings.wmode
									);

					//
					// Add flash file to the body.
					$('#' + this._settings.containerID)[0].innerHTML = swfHTML;

					//
					// Get the handle to the flash file
					this._swf = $('#' + this._settings.movieID)[0];
					this._swf.uploader = this;
				},



// ----------------------------------------------------------------------------------------------------
// Private methods
// ----------------------------------------------------------------------------------------------------

			/**
			 * Handles or re-dispatches events received from the SWF.
			 *
			 * Because the ExternalInterface library is buggy the event calls are
			 * added to a queue and the queue then executed by a setTimeout.
			 *
			 * This ensures that events are executed in a determinate order and
			 * that the ExternalInterface bugs are avoided.
			 *
			 * @method _queueEvent
			 * @private
			 */
			_queueEvent: function(params) {
					//
					// Only process the events known to us.
					if (typeof this.events[params.type] === "function") {
						var flashObject = arguments;

						//
						// Queue the event so it gets executed in the right order
						this._eventsQueue.push(function () {
							this.events[params.type].apply(this, flashObject);
						});

						//
						// Execute the next queued event
						var self = this;
						setTimeout(function () { self._executeNextEvent(); }, 0);
					}
				},

			/**
			 * Private method used by the function "_queueEvent"
			 *
			 * @method _executeNextEvent
			 * @private
			 */
			_executeNextEvent: function() {
					var  f = this._eventsQueue ? this._eventsQueue.shift() : null;
					if (typeof(f) === "function") {
						f.apply(this);
					}
				},



// ----------------------------------------------------------------------------------------------------
// Public helper methods
// ----------------------------------------------------------------------------------------------------

			/**
			 * Helper functions which adds a zero if the value is below 10
			 * @param	iInput 			{Integer}
			 */
			addZero: function(iInput) {
					return (iInput < 10) ? '0' + iInput : iInput;
				},

			/**
			 * Retreives the current date/time
			 */
			getDateTime: function() {
					//
					// Date/time object
					var oDate = new Date();

					//
					// Build object
					var dateTime = {
							y: oDate.getFullYear(),
							m: (oDate.getMonth() + 1),
							d: oDate.getDate(),
							h: oDate.getHours(),
							i: oDate.getMinutes(),
							s: oDate.getSeconds()
						};

					//
					// Add date and time text strings
					dateTime.date = this.addZero(dateTime.d) + '-' + this.addZero(dateTime.m) + '-' + dateTime.y;
					dateTime.time = this.addZero(dateTime.h) + ':' + this.addZero(dateTime.i) + ':' + this.addZero(dateTime.s);

					//
					// Result
					return dateTime;
				},

			/**
			 * Formats input to Hours, Minutes and Seconds
			 * @param	iInput 			{Integer}
			 */
			parseTime: function(iInput) {
					iHours = Math.round(iInput / 3600);
					iInput -= (iHours * 3600);
					iMinutes = Math.round(iInput / 60);
					iInput -= (iMinutes * 60);
					iSeconds = Math.round(iInput);
					return { h: iHours, i: iMinutes, s: iSeconds };
				},

			/**
			 * Formats the input to a readable time format
			 * @param	iInput 			{Integer}
			 */
			formatTime: function(iInput) {
					var oTime = this.parseTime(iInput);
					var sTime = '';
					if (iHours > 0)
						sTime+= this.addZero(oTime.h) + ':';
					sTime+= this.addZero(oTime.i) + ':';
					sTime+= this.addZero(oTime.s);
					return sTime;
				},

			/**
			 * Originally made by Jonas Raoni Soares Silva (http://www.jsfromhell.com)
			 * Improved by Kevin van Zonneveld (http://kevin.vanzonneveld.net)
			 * bugfix by: Michael White (http://getsprink.com)
			 * bugfix by: Benjamin Lupton
			 * bugfix by: Allan Jensen (http://www.winternet.no)
			 * revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
			 * bugfix by: Howard Yeend
			 *
			 * example 1: number_format(1234.5678, 2, '.', '');
			 * returns 1: 1234.57
			 */
			formatNumber: function(number, decimals, dec_point, thousands_sep ) {
				    var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
				    var d = dec_point == undefined ? "." : dec_point;
				    var t = thousands_sep == undefined ? "," : thousands_sep, s = n < 0 ? "-" : "";
				    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
				    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
				},

			/**
			 * Formats the input to a readable filesize
			 * @param	iInput 			{Integer}
			 */
			formatSize: function(iInput) {
					if (iInput >= 1073741824) {
						iInput = this.formatNumber(iInput / 1073741824, 2, '.', '') + ' Gb';
					} else {
						if (iInput >= 1048576) {
							iInput = this.formatNumber(iInput / 1048576, 2, '.', '') + ' Mb';
						} else {
							if (iInput >= 1024) {
								iInput = this.formatNumber(iInput / 1024, 2) + ' Kb';
							} else {
								iInput = this.formatNumber(iInput, 0) + ' bytes';
							}
						}
					}

					return iInput;
				},



// ----------------------------------------------------------------------------------------------------
// Public Flash Exposed methods
// ----------------------------------------------------------------------------------------------------

			/**
			 * Enables or disables the uploader UI.
			 *
			 * @param	allow			{Boolean}
			 */
			setEnabled: function(allow) {
					this._swf.setEnabled(allow ? "1" : "0");
				},

			/**
			 * Enables or disables the logging
			 *
			 * @param	allow			{Boolean}
			 */
			setLogging: function(allow) {
					this._swf.setLogging(allow ? "1" : "0");
				},

			/**
			 * Wether to allow the selection of multiple files in the browse for file dialog.
			 *
			 * @param	allow			{Boolean}
			 */
			setMultiple: function(allow) {
					this._swf.setMultiple(allow ? "1" : "0");
				},

			/**
			 * Sets a list of file type filters for the "Open File(s)" dialog.
			 *
			 * @param	filters			{Array}		An array of sets of key-value pairs of the form:
			 * 										{
			 *											extensions: extensionString,
			 *											description: descriptionString,
			 *											macType: macTypeString [optional]
			 *										}
			 *
			 * 										The extension string is a semicolon-delimited list of elements
			 *										of the form "*.xxx", e.g. "*.jpg;*.gif;*.png".
			 *
			 *										An example would be:
			 *										<object>.setFilters( [ { description: "All files (*.*)", extensions: "*.*" } ] );
			 */
			setFilters: function(filters) {
					this._swf.setFilters(filters);
				},


			/**
			 *
			 * @param	maxSize			{Integer}
			 */
			setMaxFileSize: function(maxSize) {
					this._swf.setMaxFileSize(maxSize);
				},

			/**
			 *
			 * @param	maxSize			{Integer}
			 */
			setMaxQueueSize: function(maxSize) {
					this._swf.setMaxQueueSize(maxSize);
				},

			/**
			 *
			 * @param	maxCount		{Integer}
			 */
			setMaxQueueCount: function(maxCount) {
					this._swf.setMaxQueueCount(maxCount);
				},

			/**
			 * Sets the maximum (simultanous) upload threads to use
			 *
			 * @param	maxThreads		{Integer}
			 */
			setMaxThreads: function(maxThreads) {
					this._swf.setMaxThreads(maxThreads);
				},

			/**
			 * If (when uploading) we have to advance to the next file in the queue automatically when a file has been cancelled.
			 *
			 * @param	advance			{Boolean}
			 */
			setAutoAdvanceOnCancel: function(advance) {
					this._swf.setAutoAdvanceOnCancel(advance ? "1" : "0");
				},

			/**
			 * If (when uploading) we have to advance to the next file in the queue automatically when a file has an error.
			 *
			 * @param	advance			{Boolean}
			 */
			setAutoAdvanceOnError: function(advance) {
					this._swf.setAutoAdvanceOnError(advance ? "1" : "0");
				},

			/**
			 * Removes 1 file or the entire queue if no file ID is passed
			 *
			 * @param fileID			{String}	The id of the file to start uploading.
			 */
			remove: function(fileID) {
					this._swf.remove(fileID);
				},

			/**
			 * Cancels 1 file or the entire queue if no file ID is passed
			 *
			 * @param fileID			{String}	The id of the file to start uploading.
			 */
			cancel: function(fileID) {
					this._swf.cancel(fileID);
				},

			/**
			 * Upload 1 file or the entire queue if no file ID is passed
			 *
			 * @param fileID			{String}	The id of the file to start uploading.
			 * @param uploadScriptURL	{String}	The URL of the upload script location.
			 * @param method			{String}	Either "GET" or "POST", specifying how the variables accompanying the file upload POST request should be submitted. "GET" by default.
			 * @param vars				{Object}	The object containing variables to be sent in the same request as the file upload.
			 * @param fieldName			{String}	The name of the variable in the POST request containing the file data. "Filedata" by default.
			 */
			upload: function(fileID, uploadScriptURL, method, vars, fieldName) {
					this._swf.upload(fileID, uploadScriptURL, method, vars, fieldName);
				}
		});

	/**
	 * Receives event messages from SWF and passes them to the correct instance of uploader.
	 *
	 * @static
	 * @private
	 */
	$.uploader.eventHandler = function(elementID, params) {
		//
		// Only process events with a type associated.
		if (params.type) {
			//
			// Get flash object
			var loadedSWF = $('#' + elementID)[0];

			//
			// fix for ie: if uploader doesn't exist yet, try again in a moment
			if (!loadedSWF.uploader) {
				setTimeout(function() { $.uploader.eventHandler(elementID, params); }, 10);
				return;
			}

			//
			// Pass event to this object, queueing is done in the object.
			loadedSWF.uploader._queueEvent(params);
		}
	};

	/**
	 * jQuery plugin constructor
	 */
	$.fn.uploader = function(settings) {
			return new $.uploader(this[0].id, settings);
		};
})(jQuery);
