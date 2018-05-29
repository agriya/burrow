(function() {
	function xload(is_after_ajax) {
		var so = (is_after_ajax) ? ':not(.xltriggered)': '';
		$('.alpc' + so).each(function() {
			var url = '';
			if(typeof($('.alpc').metadata().pid) != 'undefined' && $('.alpc').metadata().pid !='') {
				var pid = $('.alpc').metadata().pid;
				var url = 'high_performances/show_property_comments/id:'+pid;
			}
			if(url !='') {
				$.get(__cfg('path_relative') + url, function(data) {
					$('.alpc').html(data).removeClass('hide');
				});
			}	
		}).addClass('xltriggered');
	}
	$dc = jQuery(document);
	$dc.ready(function($) {
		xload(false);
	}).ajaxStop(function() {
        xload(true);
    });
})();