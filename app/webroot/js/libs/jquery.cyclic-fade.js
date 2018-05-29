/*

###############################################################################
#
# Copyright (c) 2009 Logimake, Inc.
#
# Orignially distributed by bugzappy at http://www.bugzappy.com/
#
# Permission is hereby granted, free of charge, to any person obtaining a copy
# of this software and associated documentation files (the "Software"), to deal
# in the Software without restriction, including without limitation the rights
# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
# copies of the Software, and to permit persons to whom the Software is
# furnished to do so, subject to the following conditions:
#
# The above copyright notice and this permission notice shall be included in
# all copies or substantial portions of the Software.
#
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
# THE SOFTWARE.
#
##############################################################################


#
# Bugzappy's "cyclicFade" jquery plugin
#


Please post questions and comments at:

	http://www.bugzappy.com/

or send email to:

	bugzappy@logimake.com

*/

// developed and tested with jQuery version 1.3.2
	
//
// create closure
//
(function($) {
  //
  // plugin definition
  //
	$.fn.cyclicFade = function(options)
	{
		if (typeof(options) == 'string') {
			if (options=='stop') {
				$(this).stop(true);
				return this.each(function() {
					$(this).data('cyclic-fade').enabled = false;
				});
			}
			else return null;
		}
		else {
			var opts = $.extend({}, $.fn.cyclicFade.defaults, options);
			return this.each(function() {
				$(this).data('cyclic-fade', {enabled : true});
				$.fn.cyclicFade.doCycle(this,1,opts.repeat,opts.params,0);
			});
		}
	};
	
	$.fn.cyclicFade.defaults = {
		repeat: 0,
		params: [{fadeout:100, stayout:300, opout:0, fadein:100, stayin:300, opin:1.0}]
	};
	
	// this function is used internally
	$.fn.cyclicFade.doCycle = function(obj,start,finish,paramsList,paramsPos) {
		if (paramsPos >= paramsList.length) {
			paramsPos = 0;
		}
		// important: params must be a local variable (var) otherwise it gets overwritten by other
		// calls to doCycle
		var params = paramsList[paramsPos];
		if ($(obj).data('cyclic-fade').enabled) $(obj).fadeTo(params.fadeout, params.opout, function() {
			if ($(obj).data('cyclic-fade').enabled) setTimeout(function() {
				if ($(obj).data('cyclic-fade').enabled) $(obj).fadeTo(params.fadein, params.opin, function() {
					if ($(obj).data('cyclic-fade').enabled) setTimeout(function(){
						if(start!=finish) {
							// increment start only if it is bounded
							if (start<finish) {
								start++;
							}
							$.fn.cyclicFade.doCycle(obj,start,finish,paramsList,paramsPos+1);
						}
					}, params.stayin)
				})
			}, params.stayout)
		});	
	};
	
})(jQuery); 

