<?php
$css_files = array(
	CSS . 'dev1bootstrap.less',
	CSS . 'responsive.less',
	CSS . 'bootstrap-datetimepicker.min.css',	
	CSS . 'ui.slider.extras.css',
	CSS . 'jquery-ui-1.10.3.custom.css',
	CSS . 'flag.css',
	CSS . 'calendar.css',
	CSS . 'jquery.uploader.css',
	CSS . 'jquery.autocomplete.css',
	CSS . 'amenities.css',
	CSS . 'star.rating.css',
	CSS . 'slickmap.css',
	CSS . 'dp.css',
	CSS . 'jquery.fileupload-ui.css',
);
$css_files = Set::merge($css_files, Configure::read('site.default.css_files'));
?>