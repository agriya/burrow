function split(val) {
    return val.split(/,\s*/);
}
function extractLast(term) {
    return split(term).pop();
}
function __l(str, lang_code) {
    //TODO: lang_code = lang_code || 'en_us';
    return(cfg && cfg.lang && cfg.lang[str]) ? cfg.lang[str]: str;
}
function __cfg(c) {
    return(cfg && cfg.cfg && cfg.cfg[c]) ? cfg.cfg[c]: false;
}
function publishCallBack(response) {
    window.location.href = $('#js-loader').data('redirect_url');
}
function calcTime(offset) {
    d = new Date();
    utc = d.getTime() + (d.getTimezoneOffset() * 60000);
    return date('Y-m-d', new Date(utc + (3600000 * offset)));
}
function propertyViewLoad() {
    if ($('.js-flickr-link', '#properties-view').is('.js-flickr-link')) {
        var url = $('.js-flickr-link').metadata().url;
        $.ajax( {
            type: 'GET',
            url: url + '&format=json&jsoncallback=?',
            dataType: 'json',
            cache: true,
            success: function(data) {
                $('#flicker-images').html('');
                if (data.photos.photo) {
                    $('<ul/>').attr('id', 'list_gallery').attr('class', 'unstyled').appendTo('#flicker-images');
                    $('#list_gallery').addClass('list');
                    if (data.photos.total > 0) {
                        $.each(data.photos.photo, function(i, item) {
                            $('<li/>').attr('id', 'flikr-' + i).appendTo('#list_gallery');
                            src = 'http://farm' + item.farm + '.static.flickr.com/' + item.server + '/' + item.id + '_' + item.secret + '_m.jpg';
                            var href = 'http://www.flickr.com/photos/' + item.owner + '/' + item.id;
                            $('<a/>').attr('id', 'flikr-href-' + i).attr('href', href).attr('target', '_blank').appendTo('#flikr-' + i);
                            var classname = '#flikr-href-' + i;
                            $('<img/>').attr('src', src).attr('height', '100').attr('title', item.title).attr('width', '100').appendTo(classname);

                        });
                    } else {
                        $('<li/>').html('<p class="notice">' + __l('No Flickr Photos Available') + '</p>').appendTo('#list_gallery');
                    }
                }
            }
        });
    }
    if ($('.js-near-link', '#properties-view').is('.js-near-link')) {
        var lat = $('.js-near-link').metadata().lat;
        var lng = $('.js-near-link').metadata().lng;
        ws_wsid = 'f532af5d9bd04255a477f5c16db220c7';
        ws_lat = lat;
        ws_lon = lng;
        ws_width = '940';
        var ws_height = '540';
        var ws_layout = 'horizontal';
        var ws_industry_type = 'travel';
        ws_map_icon_type = 'building';
        ws_transit_score = 'true';
        ws_commute = 'true';
        ws_map_modules = 'all';
        var html = '<style type="text/css">#ws-walkscore-tile{position:relative;text-align:left}#ws-walkscore-tile*{float:none;}#ws-footer a,#ws-footer a:link{font:11px/14pxVerdana,Arial,Helvetica,sans-serif;margin-right:6px;white-space:nowrap;padding:0;color:#000;font-weight:bold;text-decoration:none;line-height:15px;}#ws-footera:hover{color:#777;text-decoration:none}#ws-footera:active{color:#b14900}#ws-street{height:25px;}</style><div id="ws-walkscore-tile"><div id="ws-footer" style="position:absolute;top:522px;left:8px;width:688px"><form id="ws-form"><a id="ws-a" href="http://www.walkscore.com/" target="_blank" style>What\'s Your Walk core?</a><input type="text" id="ws-street" style="position:absolute;top:0px;left:170px;width:486px"/><input type="image" id="ws-go" src="http://cdn.walkscore.com/images/tile/go-button.gif" height="15" width="22" border="0" alt="get my Walk Score" style="position:absolute;top:0px;right:0px"/></form></div></div><script type="text/javascript" src="http://www.walkscore.com/tile/show-walkscore-tile.php"></script>';
        $('.js-near-link').addClass('amenities-around');
        $('.js-near-link').html(html);
    }
}
function xloadGeoAutocomplete() {
	$('#PropertyCityName, #PropertyAddressSearch, #RequestAddressSearch, #UserProfileAddress').each(function() {
		if ($(this).data('displayed') == true) {
			return false;
		}
		$(this).prop('data-displayed', 'true');
		var script = document.createElement('script');
		var google_map_key = '//maps.google.com/maps/api/js?sensor=false&callback=loadGeo';
		script.setAttribute('src', google_map_key);
		script.setAttribute('type', 'text/javascript');
		document.documentElement.firstChild.appendChild(script);
	}).addClass('xltriggered');
	$('#js-street_id, #PropertyCityName, #PropertyAddressSearch, #PropertyCityNameSearch, #RequestCityName, #RequestAddressSearch').each(function() {
		$this = '';
		var $country = 0;
		if ($('#PropertyCityName', 'body').is('#PropertyCityName')) {
			$this = $('#PropertyCityName');
		} else if ($('#PropertyAddressSearch', 'body').is('#PropertyAddressSearch')) {
			$this = $('#PropertyAddressSearch');
		} else if ($('#PropertyCityNameSearch', 'body').is('#PropertyCityNameSearch')) {
			$this = $('#PropertyCityNameSearch');
		} else if ($('#RequestCityName', 'body').is('#RequestCityName')) {
			$this = $('#RequestCityName');
		} else if ($('#js-street_id', 'body').is('#js-street_id')) {
			$this = $('#js-street_id');
		} else {
			$this = $('#RequestAddressSearch');
			$country = $('#js-country-search').val();
		}
		if ($this.val().length != 0 && !$country) {
			$('#js-sub').removeAttr('disabled');
			$('#js-sub').addClass('active-search');
		} else {
			$('#js-sub').attr('disabled', 'disabled');
			$('#js-sub').removeClass('active-search');
		}
	}).addClass('xltriggered');
	$('.properties-index, .requests-index').each(function() {
		if ($(this).data('displayed') == true) {
			return false;
		}
		$(this).prop('data-displayed', 'true');
		var script = document.createElement('script');
		var google_map_key = '//maps.google.com/maps/api/js?sensor=false&callback=loadGeoSearch';
		script.setAttribute('src', google_map_key);
		script.setAttribute('type', 'text/javascript');
		document.documentElement.firstChild.appendChild(script);
	}).addClass('xltriggered');
	$('div.js-calander-load').each(function() {
        id = $('.js-calander-load').metadata().id;
        CalanderLoad(id);
    }).addClass('xltriggered');
	$('#js-inlineDatepicker').each(function() {
		var $this = $(this);
		var year_ranges = $('#js-inlineDatepicker-calender').find("select[id$='Year']").eq(0).text();
		var each_year = year_ranges.split('\n');
		var startyear = endyear = '';
		for (var i = 0; i < each_year.length; i ++ ) {
			if (each_year[i] != '' && each_year[i] != '\n' && startyear == '') {
				startyear = parseInt(each_year[i]);
			}
			if (each_year[i] != '' && each_year[i] != '\n') {
				endyear = parseInt(each_year[i]);
				if(endyear < startyear){
					tmp = startyear;
					startyear = endyear;
					endyear = tmp;
				}
			}
		}
		var maxdate = endyear - startyear;
		$this.datepick( {
			renderer: $.datepick.themeRollerRenderer,
			rangeSelect: true,
			monthsToShow: [1, 2],
			minDate: 0,
			maxDate: '12/31/' + endyear,
			onSelect: function(dates) {
				var today_date = new Date(calcTime(__cfg('timezone')).replace('-', '/').replace('-', '/'));
				var t1 = today_date.getTime();
				for (var i = 0; i < dates.length; i ++ ) {
					var t2 = dates[i].getTime();
					date_diff = parseInt((t2 - t1) / (24 * 3600 * 1000));
					if (date_diff >= 0) {
						var newDate = $.datepick.formatDate(dates[i]).split('/');
						$('#js-inlineDatepicker-calender').find("select[id$='Day']").eq(i).val(newDate[1]);
						$('#js-inlineDatepicker-calender').find("select[id$='Month']").eq(i).val(newDate[0]);
						$('#js-inlineDatepicker-calender').find("select[id$='Year']").eq(i).val(newDate[2]);
					}
				}
				if ($('.js-date-picker-info').hasClass('default')) {
					$('.js-date-picker-info').removeClass('default');
					$('.js-date-picker-info').addClass('started');
					$('.js-date-picker-info').addClass('blink');
					$('.js-date-picker-info').css('color', '');
					$('.js-date-picker-info').html('<i class=" icon-question-sign "></i>' + __l('Select check-out date in calendar'));
					$('.blink').cyclicFade();
				} else if ($('.js-date-picker-info').hasClass('started')) {
					$('.js-date-picker-info').removeClass('started');
					$('.js-date-picker-info').addClass('selected');
					var no_of_days = days_between(dates[0], dates[1]);
					if (__cfg('days_calculation_mode') == 'Day') {
						no_of_days ++ ;
					}
					var day_caption = 'days';
					if (no_of_days == 1) {
						day_caption = 'day';
					}
					if (__cfg('days_calculation_mode') == 'Night' && no_of_days == 0) {
						$('.js-date-picker-info').addClass('started');
						$('.js-date-picker-info').addClass('blink');
						$('.js-date-picker-info').css('color', 'red');
						$('.js-date-picker-info').html(__l('Select check-out greater than the check-in date'));
						$('.blink').cyclicFade();
					} else {
						var selected_dates = date('F d, Y', dates[0]) + ' to ' + date('F d, Y', dates[1]) + ' (' + no_of_days + ' ' + day_caption + ')';
						$('.blink').cyclicFade('stop');
						$('.js-date-picker-info').css('opacity', 9);
						$('.js-date-picker-info').css('color', '');
						$('.js-date-picker-info').html(selected_dates);
					}
				} else if ($('.js-date-picker-info').hasClass('selected')) {
					$('.js-date-picker-info').removeClass('default');
					$('.js-date-picker-info').addClass('started');
					$('.js-date-picker-info').addClass('blink');
					$('.blink').cyclicFade();
					$('.js-date-picker-info').css('color', '');
					$('.js-date-picker-info').html(__l('Select check-out date in calendar'));
				} else {
					$('.js-date-picker-info').addClass('default');
					$('.js-date-picker-info').removeClass('blink');
					$('.js-date-picker-info').css('color', '');
					$('.js-date-picker-info').html('<i class=" icon-question-sign "></i>' + __l('Select check-in date in calendar'));
				}
			}
		});
		dates = Array();
		for (var i = 0; i < 2; i ++ ) {
			dates[i] = $('#js-inlineDatepicker-calender').find("select[id$='Month']").eq(i).val() + '/' + $('#js-inlineDatepicker-calender').find("select[id$='Day']").eq(i).val() + '/' + $('#js-inlineDatepicker-calender').find("select[id$='Year']").eq(i).val();
		}
		$this.datepick('setDate', dates);
	}).addClass('xltriggered');
	propertyViewLoad();
}
function loadAdminPanel() {
	if ($.cookie('_gz') != null && (window.location.href.indexOf('/property/') != -1 || window.location.href.indexOf('/user/') != -1 || window.location.href.indexOf('/request/') != -1)) {
		$('.js-alab').html('');
		$('header').removeClass('show-panel');
		var url = '';
		if (typeof($('.js-user-view').data('user-id')) != 'undefined' && $('.js-user-view').data('user-id') !='' && $('.js-user-view').data('user-id') != null) {
			var uid = $('.js-user-view').data('user-id');
			var url = 'users/show_admin_control_panel/view_type:user/id:'+uid;
		}
		if (typeof($('.js-request-view').data('request-id')) != 'undefined' &&  $('.js-request-view').data('request-id') !='' && $('.js-request-view').data('request-id') != null) {
			var rid = $('.js-request-view').data('request-id');
			var url = 'requests/show_admin_control_panel/view_type:request/id:'+rid;
		}
		if (typeof($('.js-property-view').data('property-id')) != 'undefined' &&  $('.js-property-view').data('property-id') !='' && $('.js-property-view').data('property-id') != null) {
			var pid = $('.js-property-view').data('property-id');
			var url = 'properties/show_admin_control_panel/view_type:property/id:'+pid;
		}
		if (url !='') {
			$.get(__cfg('path_relative') + url, function(data) {
				$('.js-alab').html(data).removeClass('hide').show();
			});
		}
	} else {
		$('.js-alab').hide();
	}
}
function checkStreetViewStatus() {
    var lat = $('#latitude').val();
    var lang = $('#longitude').val();
    //var fenway = new google.maps.LatLng(42.345573,-71.098326);
    var fenway = new google.maps.LatLng(lat, lang);
    // Define how far to search for an initial pano from a location, in meters.
    var panoSearchRadius = 50;
    // Create a StreetViewService object.
    var client = new google.maps.StreetViewService();
    // Compute the nearest panorama to the Google Sydney office
    // using the service and store that pano ID. Once that value
    // is determined, load the application.
    client.getPanoramaByLocation(fenway, panoSearchRadius, function(result, status) {
        if (status == google.maps.StreetViewStatus.OK) {
            $('.js-street-container').removeClass('hide');
        } else {
            $('.js-street-container').addClass('hide');
        }
    });
}
var geocoder,
geocoder1,
map,
bounds,
marker,
markerimage,
infowindow,
locations,
latlng,
searchTag,
ws_wsid,
ws_lat,
ws_lon,
ws_width,
ws_industry_type,
ws_map_icon_type,
ws_transit_score,
ws_commute,
ws_map_modules;
var current_click = 0;
var first_date = Array();
var second_date = Array();
var styles = [];
var markerClusterer = null;
var map = null;
var map1 = null;
var markers = [];
var common_options = {
	map_frame_id: 'mapframe',
	map_window_id: 'mapwindow',
	area: 'js-street_id',
	state: 'StateName',
	city: 'CityName',
	country: 'js-country_id',
	lat_id: 'latitude',
	lng_id: 'longitude',
	postal_code: 'PropertyPostalCode',
	ne_lat: 'ne_latitude',
	ne_lng: 'ne_longitude',
	sw_lat: 'sw_latitude',
	sw_lng: 'sw_longitude',
	button: 'js-sub',
	error: 'address-info',
	mapblock: 'mapblock',
	lat: '37.7749295',
	lng: '-122.4194155',
	map_zoom: 13
}
function loadSideMap() {
    //generate the side map
	lat = 0;
	lng = 0;
	if ($('.js-search-lat', 'body').is('.js-search-lat')) {
		lat = $('.js-search-lat').metadata().cur_lat;
		lng = $('.js-search-lat').metadata().cur_lng;
	}
    if ((lat == 0 && lng == 0) || (lat == '' && lng == '')) {
        if ($('.js-map-data', 'body').is('.js-map-data')) {
            lat = $('.js-map-data').metadata().lat;
            lng = $('.js-map-data').metadata().lng;
        } else {
            lat = 13.314082;
            lng = 77.695313;
        }
    }
    var zoom = 9;
    latlng = new google.maps.LatLng(lat, lng);
    var myOptions = {
        zoom: zoom,
        center: latlng,
        zoomControl: true,
        draggable: true,
        disableDefaultUI: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById('js-map-container'), myOptions);
    map.setCenter(latlng);
    if (lat != 0 && lng != 0) {
        var imageUrl = __cfg('path_relative') + 'img/center_point.png';
        var markerImage = new google.maps.MarkerImage(imageUrl);
        var j = 0;
        eval('var marker' + j + ' = new google.maps.Marker({ position: latlng,  map: map, icon: markerImage, zIndex: i});');
        var marker_obj = eval('marker' + j);
    }
    var i = 1;
    $('a.js-map-data', document.body).each(function() {
        lat = $(this).metadata().lat;
        lng = $(this).metadata().lng;
        url = $(this).attr('href');
        title = $(this).attr('title');
        updateMarker(lat, lng, url, i, title);
        i ++ ;
    });
}
function loadSideMap1() {
    lat = $('#' + common_options.lat_id).val();
    lng = $('#' + common_options.lng_id).val();
    if (typeof(lat) != 'undefined' && typeof(lng) != 'undefined' && document.getElementById('js-map-container')) {
        $('.js-side-map-div').show();
        var zoom = common_options.map_zoom;
		$('#zoomlevel').val(zoom);
        if (lat == 0 && lng == 0) {
			lat = 13.0833;
			lng = 80.28330000000005;
		}
		latlng = new google.maps.LatLng(lat, lng);
        var myOptions1 = {
            zoom: zoom,
            center: latlng,
            zoomControl: true,
            draggable: true,
            disableDefaultUI: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map1 = new google.maps.Map(document.getElementById('js-map-container'), myOptions1);
        marker1 = new google.maps.Marker( {
            draggable: true,
            map: map1,
            position: latlng
        });
        map1.setCenter(latlng);
        google.maps.event.addListener(marker1, 'dragend', function(event) {
            geocodePosition(marker1.getPosition());
        });
        google.maps.event.addListener(map1, 'mouseout', function(event) {
            $('#zoomlevel').val(map1.getZoom());
        });
    } else {
        $('.js-side-map-div').hide();
    }
}
function searchmapaction() {
    if (map.getZoom() > 13) {
        map.setZoom(13);
    }
    bounds = (map.getBounds());
    var southWestLan = '';
    var northEastLng = '';
    var southWest = bounds.getSouthWest();
    var northEast = bounds.getNorthEast();
    var center = bounds.getCenter();
    $('#PropertyLatitude, #RequestLatitude').val(center.lat());
    $('#PropertyLongitude, #RequestLongitude').val(center.lng());
    $('.js-search-lat').metadata().cur_lat = center.lat();
    $('.js-search-lat').metadata().cur_lng = center.lng();
    $('#ne_latitude_index').val(northEast.lat());
    $('#sw_latitude_index').val(southWest.lat());
    if (isNaN(northEast.lng())) {
        northEastLng = '0';
    } else {
        northEastLng = northEast.lng();
    }
    $('#ne_longitude_index').val(northEastLng);
    if (isNaN(southWest.lng())) {
        southWestLan = '0';
    } else {
        southWestLan = southWest.lng();
    }
    $('#sw_longitude_index').val(southWestLan);
    $('#KeywordsSearchForm').submit();
}
function updateMarker(lat, lnt, url, i, title) {
    var store_count = i;
    if (lat != null) {
        myLatLng = new google.maps.LatLng(lat, lnt);
        var imageUrl = __cfg('path_relative') + 'img/red/' + store_count + '.png';
        var markerImage = new google.maps.MarkerImage(imageUrl);
        eval('var marker' + i + ' = new google.maps.Marker({ position: myLatLng,  map: map, icon: markerImage, zIndex: i});');
        var marker_obj = eval('marker' + i);
        marker_obj.title = title;
        var li_obj = '.js-map-num' + i;
        //one time map listener to handle the zoom
        google.maps.event.addListenerOnce(map, 'resize', function() {
            map.setCenter(center);
            map.setZoom(zoom);
        });
        //properties marker hover, point the properties list active
        $(li_obj).bind('mouseenter', function() {
            var imagehover = __cfg('path_relative') + 'img/black/' + store_count + '.png';
            marker_obj.setIcon(imagehover);
        });
        $(li_obj).bind('mouseleave', function() {
            var imageUrlhout = __cfg('path_relative') + 'img/red/' + store_count + '.png';
            marker_obj.setIcon(imageUrlhout);
        });
        //properties list mouse over/leave changing the hover marker icon
        google.maps.event.addListener(marker_obj, 'mouseenter', function() {
            li_obj.addClass('active');
        });
        google.maps.event.addListener(marker_obj, 'mouseleave', function() {
            li_obj.removeClass('active');
        });
        var li_obj_request = '.js-map-request-num' + i;
        //requests
        $(li_obj_request).bind('mouseenter', function() {
            var imagehover = __cfg('path_relative') + 'img/black/' + store_count + '.png';
            marker_obj.setIcon(imagehover);
        });
        $(li_obj_request).bind('mouseleave', function() {
            var imageUrlhout = __cfg('path_relative') + 'img/red/' + store_count + '.png';
            marker_obj.setIcon(imageUrlhout);
        });
        google.maps.event.addListener(marker_obj, 'click', function() {
            window.location.href = url;
        });
    }
}
function loadGeoSearch() {
	if ($('div#js-map-container', 'body').is('div#js-map-container')) {
		loadSideMap();
	}
    var options = {
        map_frame_id: 'mapframe',
        map_window_id: 'mapwindow',
        lat_id: 'latitude',
        lng_id: 'longitude',
        ne_lat: 'ne_latitude',
        ne_lng: 'ne_longitude',
        sw_lat: 'sw_latitude',
        sw_lng: 'sw_longitude',
        lat: '37.7749295',
        lng: '-122.4194155',
        map_zoom: 13
    }
    $('#PropertyCityNameSearch, #RequestCityName').autogeocomplete(options);
}
function loadGeo() {
    var options = common_options;
    $('#PropertyCityName, #RequestAddressSearch, #PropertyAddressSearch, #RequestCityName, #UserProfileAddress, #PropertyAddress').autogeocomplete(options);
    //checking the streetview available for geo
    $.fstreetcontaineropen('#PropertyIsStreetView');
    $.fuserprofileeditform('form#UserProfileEditForm #js-country_id');
    $.fpropertyeditform('form#PropertyEditForm #js-country_id');
    $.frequestaddform('form#RequestAddForm #js-country_id');
    $.fpropertyaddform('form#PropertyAddForm #js-country_id');
    loadSideMap1();
}
function loadGeoAddress(selector) {
    geocoder = new google.maps.Geocoder();
    var address = $(selector).val();
    geocoder.geocode( {
        'address': address
    }, function(results, status) {
        $.map(results, function(results) {
            var components = results.address_components;
            if (components.length) {
                var k = 0;
                for (var j = 0; j < components.length; j ++ ) {
                    if (components[j].types[0] == 'locality' || components[j].types[0] == 'administrative_area_level_2') {
                        if (k == 0) {
                            city = components[j].long_name;
                            $('#CityName').val(city);
                        }
                        if (components[j].types[0] == 'locality') {
                            k = 1;
                        }
                    }
                    if (components[j].types[0] == 'administrative_area_level_1') {
                        state = components[j].long_name;
                        $('#StateName').val(state);
                    }
                    if (components[j].types[0] == 'country') {
                        country = components[j].short_name;
                        $('#js-country_id').val(country);

                    }
                    if (components[j].types[0] == 'postal_code') {
                        postal_code = components[j].long_name;
                        if (selector == '#PropertyAddressSearch') {
                            $('#PropertyPostalCode').val(postal_code);
                        } else {
                            $('#RequestPostalCode').val(postal_code);
                        }
                    }
                }
            }
        });
    });
}
function geocodePosition(position) {
    geocoder.geocode( {
        latLng: position
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
			if(map != null) {
				map.setCenter(results[0].geometry.location);
			} else if(map1 != null) {
				map1.setCenter(results[0].geometry.location);
			}
            $('#latitude').val(results[0].geometry.location.d);
            $('#longitude').val(results[0].geometry.location.e);
        }
    });
}
function customDateFunction(input) {
    if (input.id == 'PropertyCheckin') {
        if ($('#PropertyCheckout').val() != 'yyyy-mm-dd') {
            if ($('#PropertyCheckout').datepicker('getDate') != null) {
                dateMin = $('#PropertyCheckout').datepicker('getDate', '-1d');
                dateMin.setDate(dateMin.getDate() - 1);
                return {
                    maxDate: dateMin,
                    inline: true
                };
            }
        }
    } else if (input.id == 'PropertyCheckout') {
        if ($('#PropertyCheckin').datepicker('getDate') != null) {
            dateMin = $('#PropertyCheckin').datepicker('getDate', '+1d');
        }
        dateMin.setDate(dateMin.getDate() + 1);
        return {
            minDate: dateMin,
            inline: true
        };
    }
}

var filesList = [],
paramNames = [];

function file_upload() {
    if ($('.fileUpload', 'body').is('.fileUpload')) {
        $('.js-normal-fileupload').fileupload( {
            forceIframeTransport: true,
            maxNumberOfFiles: $('#AttachmentFilename').data('maximum-number-of-photos'),
			acceptFileTypes: getFileType(),
			dataType: '',
			singleFileUploads: true,
			autoUpload: false,
            submit: function(e, data) {
				var $this = $('.js-normal-fileupload');
				$this.find('div.input input[type=text], div.input textarea, div.input select').filter(':visible').trigger('blur');
                if (j_validate($this) == 'error') {
					$('input, textarea, select', $('.error', $this).filter(':first')).trigger('focus');
                    return false;
                }
                $('.js-upload-cancel').addClass('hide');
            },
            done: function(e, data) {
				$('.progress .bar').css('width', '100%');
				location.href = $('#AttachmentFilename').data('success-url');
            }
        }).on('fileuploadadd', function(e, data) {
            if (data.files[0].name != null) {
				// Fix for chrome
                $('#browseFile').attr('title', data.files[0].name);
            }
        }).on('fileuploadfail', function(e, data) {
            $('.js-upload-cancel').removeClass('hide');
        }).on('fileuploadchange',function(e,data){
			$('.js-fileupload-enable').on('click',function(){
				$('.start').trigger('click');
				return false;
			});
		});
    }
}
function j_validate(that) {
    var $this = that;
    if (($('div.error', $this).length == 0) && ($('span.label-danger', $this).length == 0)) {
        // return true when there's no error in form
        return '';
    } else {
        return 'error';
    }
}
function replaceAll(txt, replace, with_this) {
    return txt.replace(new RegExp(replace, 'g'), with_this);
}
function getFileType() {
	var type = replaceAll($('#AttachmentFilename').data('allowed-extensions').replace(/ /g, ''), ',', '|');
	if (typeof(type) != 'undefined' && type != null) {
		return new RegExp(type, 'i');
	}
}
//Function End
 (function() {
    jQuery('html').addClass('js');
    function xload(is_after_ajax) {
        var so = (is_after_ajax) ? ':not(.xltriggered)': '';
		$('#SudopayCreditCardNumber' + so).payment('formatCardNumber').addClass('xltriggered');
        $('#SudopayCreditCardExpire' + so).payment('formatCardExpiry').addClass('xltriggered');
        $('#SudopayCreditCardCode' + so).payment('formatCardCVC').addClass('xltriggered');
		propertyViewLoad();
		$(document).on('submit', '.js-submit-target', function(e) {
			var $this = $(this);
			if($('#SudopayCreditCardNumber','body').is('#SudopayCreditCardNumber')) {
				var cardType = $.payment.cardType($this.find('#SudopayCreditCardNumber').val());
				$this.find('#SudopayCreditCardNumber').filter(':visible').parent().parent().toggleClass('error', !$.payment.validateCardNumber($this.find('#SudopayCreditCardNumber').val()));
				$this.find('#SudopayCreditCardExpire').filter(':visible').parent().toggleClass('error', !$.payment.validateCardExpiry($this.find('#SudopayCreditCardExpire').payment('cardExpiryVal')));
				$this.find('#SudopayCreditCardCode').filter(':visible').parent().toggleClass('error', !$.payment.validateCardCVC($this.find('#SudopayCreditCardCode').val(), cardType));
				$this.find('#SudopayCreditCardNameOnCard').filter(':visible').parent().toggleClass('error', ($this.find('#SudopayCreditCardNameOnCard').val().trim().length == 0));
				return($this.find('.error, :invalid').filter(':visible').length == 0);
			}
		});
		$('.alab' + so).each(function(e) {
			loadAdminPanel();
		}).addClass('xltriggered');
        $('.js-bootstrap-tooltip' + so).tooltip().addClass('xltriggered');
        $('textarea:not(.js-skip)' + so).autoGrow().addClass('xltriggered');
		$('a.js-confirm, a.js-reject, a.js-cancel, a.js-approve, a.js-pending, a.js-suspend, a.js-unsuspend, a.js-unflag, a.js-flag, a.js-unfeatured, a.js-featured, a.js-delete' + so).click(function() {
			var alert = this.text.toLowerCase();
			alert = alert.replace(/&amp;/g, '&');
			return window.confirm(__l('Are you sure you want to ') + alert + '?');
		}).addClass('xltriggered');
		$('.js-timestamp' + so).timeago().addClass('xltriggered');
        $('#paymentgateways-tab-container' + so + ', #ajax-tab-container-user' + so + ', #ajax-tab-dashboard-user' + so + ', #ajax-tab-container-property' + so + ', #ajax-tab-container-review' + so + ', #ajax-tab-container-admin' + so+ ', #ajax-tab-container-property-thirdparty' + so).each(function(i) {
            $(this).easytabs().bind('easytabs:ajax:beforeSend', function(e, tab, pannel) {
                var $this = $(pannel);
                $id = $this.selector;
                $('div' + $id).html("<div class='row dc hor-space'><img src='" + __cfg('path_absolute') + "/img/throbber.gif' class='js-loader'/><p class=''>  Loading....</p></div>");
            }).bind('easytabs:midTransition', function(e, tab, pannel) {
				if ($(pannel).attr('id').indexOf('paymentGateway-') != -1) {
					$(pannel).find('input:radio:first').trigger('click');
				}
			});
        }).addClass('xltriggered');
		$('.js-editor' + so).each(function(e) {
			$is_html = true;
			if ($(this).metadata().is_html != 'undefined') {
				if ($(this).metadata().is_html == 'false') {
					$is_html = true;
				}
			}
			$(this).wysihtml5( {
				'html': $is_html
			});
		}).addClass('xltriggered');
        $('div.tab-pane' + so).addClass('xltriggered').filter('.active').find('input:radio:first').trigger('click');
        $('.easy-pie-chart.percentage' + so).each(function(e) {
            var barColor = $(this).data('color');
            var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)': '#E2E2E2';
            var size = parseInt($(this).data('size')) || 50;
            $(this).easyPieChart( {
                barColor: barColor,
                trackColor: trackColor,
                scaleColor: false,
                lineCap: 'butt',
                lineWidth: parseInt(size / 10),
                animate: 1000,
                size: size
            });
        }).addClass('xltriggered');
		$('.users-login' + so + ', .users-register' + so).each(function(e) {
		 if ($('#js-facepile-section', 'body').is('#js-facepile-section')) {
			FB = null;
			$.getScript('http://connect.facebook.net/en_US/all.js#xfbml=1', function(data) {
				FB.init( {
					appId: $('#js-facepile-section').metadata().fb_app_id,
					status: true,
					cookie: true,
					xfbml: true
				});
				FB.getLoginStatus(function(response) {
					if (response.status == 'connected' || response.status == 'not_authorized') {
						$('.js-facepile-loader').removeClass('loader');
						document.getElementById('js-facepile-section').innerHTML = '<fb:facepile width="240"></fb:facepile>';
						FB.XFBML.parse(document.getElementById('js-facepile-section'));
					} else {
						$.get(__cfg('path_relative') + 'users/facepile', function(data) {
							$('.js-facepile-loader').removeClass('loader');
							$('#js-facepile-section').html(data);
						});
					}
				});
			});
		 }
		}).addClass('xltriggered');
        $('.js-property-title' + so).each(function() {
            $(this).simplyCountable( {
                counter: '#js-property-title-count',
                countable: 'characters',
                maxCount: $('.js-property-title').metadata().count,
                strictMax: true,
                countDirection: 'down',
                safeClass: 'safe',
                overClass: 'over'
            });
        }).addClass('xltriggered');
		$('.js-property-description').each(function() {
            $(this).simplyCountable( {
                counter: '#js-property-description-count',
                countable: 'characters',
                maxCount: $('.js-property-description').metadata().count,
                strictMax: true,
                countDirection: 'down',
                safeClass: 'safe',
                overClass: 'over'
            });
        }).addClass('xltriggered');
        $('.accordion' + so).on('show hide', function(e) {
            $(e.target).siblings('.well').find('.accordion-toggle i').toggleClass('icon-angle-down icon-angle-up', 200);
        }).addClass('xltriggered');
        $('div.input' + so).each(function() {
			var m = /validation:{([\*]*|.*|[\/]*)}$/.exec($(this).prop('class'));
			if (m && m[1]) {
				$(this).on('blur', 'input, textarea, select', function(event) {
					var validation = eval('({' + m[1] + '})');
					$(this).parent().removeClass('error');
					$(this).siblings('div.error-message').remove();
					error_message = 0;
					for (var i in validation) {
						if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'notempty' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'notempty' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) &&! $(this).val()) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'alphaNumeric' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'alphaNumeric' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) &&! (/^[0-9A-Za-z]+$/.test($(this).val()))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'numeric' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'numeric' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) &&! (/^[+-]?[0-9|.]+$/.test($(this).val()))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'email' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'email' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) &&! (/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)$/.test($(this).val()))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && typeof(validation[i]['rule'][0]) != 'undefined' && validation[i]['rule'][0] == 'equalTo') || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'equalTo' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && $(this).val() != validation[i]['rule'][1]) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && typeof(validation[i]['rule'][0]) != 'undefined' && validation[i]['rule'][0] == 'between' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'between' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && (parseInt($(this).val()) < parseInt(validation[i]['rule'][1]) || parseInt($(this).val()) > parseInt(validation[i]['rule'][2]))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i]['rule']) != 'undefined' && typeof(validation[i]['rule'][0]) != 'undefined' && validation[i]['rule'][0] == 'minLength' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'minLength' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && $(this).val().length < validation[i]['rule'][1]) {
							error_message = 1;
							break;
						}
					}
					if (error_message) {
						$(this).parent().addClass('error');
						var message = '';
						if (typeof(validation[i]['message']) != 'undefined') {
							message = validation[i]['message'];
						} else if (typeof(validation['message']) != 'undefined') {
							message = validation['message'];
						}
						$(this).parent().append('<div class="error-message">' + message + '</div>').fadeIn();
					}
				});
			}
		});
		$('.js-register-terms label').on('click', function() {
				$(this).parent().removeClass('error');
					$(this).siblings('div.error-message').remove();
			});

        $('#PropertyCityName' + so + ', #PropertyAddressSearch' + so + ', #RequestAddressSearch' + so + ', #UserProfileAddress' + so).each(function() {
            if ($(this).data('displayed') == true) {
                return false;
            }
            $(this).prop('data-displayed', 'true');
            var script = document.createElement('script');
            var google_map_key = '//maps.google.com/maps/api/js?sensor=false&callback=loadGeo';
            script.setAttribute('src', google_map_key);
            script.setAttribute('type', 'text/javascript');
            document.documentElement.firstChild.appendChild(script);
        }).addClass('xltriggered');
        $('.properties-index' + so + ', .requests-index' + so).each(function() {
            if ($('.js-search-map', 'body').is('.js-search-map')) {
				if ($(this).data('displayed') == true) {
					return false;
				}
				$(this).prop('data-displayed', 'true');
				var script = document.createElement('script');
				var google_map_key = '//maps.google.com/maps/api/js?sensor=false&callback=loadGeoSearch';
				script.setAttribute('src', google_map_key);
				script.setAttribute('type', 'text/javascript');
				document.documentElement.firstChild.appendChild(script);
			}
        }).addClass('xltriggered');
        $('#js-rangeinline').each(function() {
            checkin = $('#js-rangeinline').metadata().checkin.split('-');
            checkout = $('#js-rangeinline').metadata().checkout.split('-');
            dates = Array();
            dates[0] = checkin[1] + '/' + checkin[2] + '/' + checkin[0];
            dates[1] = checkout[1] + '/' + checkout[2] + '/' + checkout[0];
            $('#js-rangeinline').datepick( {
                renderer: $.datepick.themeRollerRenderer,
                rangeSelect: true,
                monthsToShow: 1,
                todayText: 'Trips',
                todayStatus: 'Trips Calendar'
            });
            $('#js-rangeinline').datepick('setDate', dates);
            $('#js-rangeinline').datepick('disable', true);
        }).addClass('xltriggered');
        $('.js-skip-show' + so).each(function(e) {
            setTimeout(function() {
                $('.js-skip-show').slideDown('slow');
            }, 1000);
        }).addClass('xltriggered');
        $('.js-view-count-update' + so).each(function(e) {
            var ids = '';
			$this = $(this);
			model = $this.metadata().model;
			$('.js-view-count-' + model + '-id').each(function(e) {
				ids += $(this).metadata().id + ',';
			});
			var param = [ {
				name: 'ids',
				value: ids
			}];
			if (ids) {
				var url = $this.metadata().url + '.json';
				$.ajax( {
					type: 'POST',
					url: url,
					dataType: 'json',
					data: param,
					cache: false,
					success: function(responses) {
						for (i in responses) {
							$('.js-view-count-' + model + '-id-' + i).html(responses[i]);
						}
					}
				});
			}
        }).addClass('xltriggered');
        $('#PropertyCheckin' + so + ', #PropertyCheckout' + so).datepicker( {
            beforeShow: customDateFunction,
            dateFormat: 'yy-mm-dd',
            minDate: 0
        }).addClass('xltriggered');
        if (__cfg('calendar_type') == "dropdown") {
            $('.js-show-search-dropdown').addClass('active');
        } else {
            $('.js-show-search-calendar').addClass('active');
        }
		$('.properties-index-page' + so).each(function() {
			$.fn.UISlider('.js-uislider');
        }).addClass('xltriggered');
        $('.request-index-page' + so).each(function() {
            $.fn.UISlider('.js-uislider');
        }).addClass('xltriggered');
        $('#js-street_id' + so + ', #PropertyCityName' + so + ', #PropertyAddressSearch' + so + ', #PropertyCityNameSearch' + so + ', #RequestCityName' + so + ', #RequestAddressSearch' + so).each(function() {
            $this = '';
            var $country = 0;
            if ($('#PropertyCityName', 'body').is('#PropertyCityName')) {
                $this = $('#PropertyCityName');
            } else if ($('#PropertyAddressSearch', 'body').is('#PropertyAddressSearch')) {
                $this = $('#PropertyAddressSearch');
            } else if ($('#PropertyCityNameSearch', 'body').is('#PropertyCityNameSearch')) {
                $this = $('#PropertyCityNameSearch');
            } else if ($('#RequestCityName', 'body').is('#RequestCityName')) {
                $this = $('#RequestCityName');
            } else if ($('#js-street_id', 'body').is('#js-street_id')) {
                $this = $('#js-street_id');
            } else {
                $this = $('#RequestAddressSearch');
                $country = $('#js-country-search').val();
            }
            if ($this.val().length != 0 && !$country) {
                $('#js-sub').removeAttr('disabled');
                $('#js-sub').addClass('active-search');
            } else {
                $('#js-sub').attr('disabled', 'disabled');
                $('#js-sub').removeClass('active-search');
            }
        }).addClass('xltriggered');
		$('.js-payment-type').each(function() {
			var $this = $(this);
			if ($this.prop('checked') == true) {
				if ($this.val() == 2) {
					$('.js-form, .js-instruction').addClass('hide');
					$('.js-wallet-connection').slideDown('fast');
					$('.js-normal-sudopay').slideUp('fast');
				} else if ($this.val() == 1) {
					$('.js-normal-sudopay').slideDown('fast');
					$('.js-wallet-connection').slideUp('fast');
				} else if ($this.val().indexOf('sp_') != -1) {
					$('.js-gatway_form_tpl').hide();
					form_fields_arr = $(this).data('sudopay_form_fields_tpl').split(',');
					for (var i = 0; i < form_fields_arr.length; i ++ ) {
						$('#form_tpl_' + form_fields_arr[i]).show();
					}
					var instruction_id = $this.val();
					$('.js-instruction').addClass('hide');
					$('.js-form').removeClass('hide');
					if (typeof($('.js-instruction_'+instruction_id).html()) != 'undefined') {
						$('.js-instruction_'+instruction_id).removeClass('hide');
					}
					if (typeof($('.js-form_'+instruction_id).html()) != 'undefined') {
						$('.js-form_'+instruction_id).removeClass('hide');
					}
					$('.js-normal-sudopay').slideDown('fast');
					$('.js-wallet-connection').slideUp('fast');
				}
			}
		});
		if(document.documentElement.clientWidth > 750) {
			$('.haccordion').css({'min-height' :$('#Properties').height()});
		}
        $('.js-amenities-show' + so).show();
        $('.js-list' + so).hide();
        $('table#js-expand-table tr:not(.js-odd)').hide();
        $('table#js-expand-table tr.js-even').show();
        $.p.captchaPlay('a.js-captcha-play' + so);
        $.fn.fdatetimepicker('.js-datetime' + so);
        $.fn.fdatetimepicker('.js-datetimepicker' + so);
        $.fn.ftimepicker('.js-time' + so);
        $.fn.ftimepicker('.js-timepicker' + so);
        $.fn.fautocomplete('.js-autocomplete' + so);
        $.p.fmultiautocomplete('.js-multi-autocomplete' + so);
		file_upload();
    }
    $.fuserprofileeditform = function(selector) {
        loadGeoAddress('#UserProfileAddress');
    };
    $.fpropertyeditform = function(selector) {
        loadGeoAddress('#PropertyAddress');
    };
    $.frequestaddform = function(selector) {
        loadGeoAddress('#RequestAddressSearch');
    };
    $.fpropertyaddform = function(selector) {
        loadGeoAddress('#PropertyAddressSearch');
    };
	$.fstreetcontaineropen = function(selector) {
		checkStreetViewStatus();
	};
    $.query = function(s) {
        var r = {};
        if (s) {
            var q = s.substring(s.indexOf('?') + 1);
            // remove everything up to the ?
            q = q.replace(/\&$/, '');
            // remove the trailing &
            $.each(q.split('&'), function() {
                var splitted = this.split('=');
                var key = splitted[0];
                var val = splitted[1];
                // convert numbers
                if (/^[0-9.]+$/.test(val))
                    val = parseFloat(val);
                // convert booleans
                if (val == 'true')
                    val = true;
                if (val == 'false')
                    val = false;
                // ignore empty values
                if (typeof val == 'number' || typeof val == 'boolean' || val.length > 0)
                    r[key] = val;
            });
        }
        return r;
    };
    $.fn.fautocomplete = function(selector) {
        if ($(selector, 'body').is(selector)) {
            $(selector).each(function(e) {
                $this = $(this);
                var autocompleteUrl = $this.metadata().url;
                var targetField = $this.metadata().targetField;
                var targetId = $this.metadata().id;
                var placeId = $this.attr('id');
                $this.autocomplete( {
                    source: function(request, response) {
                        $.getJSON(autocompleteUrl, {
                            term: extractLast(request.term)
                            }, response);
                    },
                    open: function() {
                        $('.ui-autocomplete').css('z-index', '10000').addClass('dropdown-menu');
                    },
                    search: function() {
                        // custom minLength
                        var term = extractLast(this.value);
                        if (term.length < 2) {
                            return false;
                        }
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function(event, ui) {
                        if ($('#' + targetId).val()) {
                            $('#' + targetId).val(ui.item['id']);
                        } else {
                            var targetField1 = targetField.replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
                            $('#' + placeId).after(targetField1);
                            $('#' + targetId).val(ui.item['id']);
                        }
                    }
                });
            });
        }
    };
    var i = 1;
    $.fn.fdatetimepicker = function(selector) {
        $(selector).each(function(e) {
            var $this = $(this);
            if ($this.data('displayed') == true) {
                return false;
            }
            $this.attr('data-displayed', 'true');
            var full_label = error_message = '';
            if (label = $this.find('label').text()) {
                full_label = '<label for="' + label + '">' + label + '</label>';
            }
            var info = $this.find('.info').text()
                if ($('div.error-message', $this).html()) {
                error_message = '<div class="error-message">' + $('div.error-message', $this).html() + '</div>';
            }
            var start_year = end_year = '';
            $this.find('select[id$="Year"]').find('option').each(function() {
                $tthis = $(this);
                if ($tthis.prop('value') != '') {
                    if (start_year == '') {
                        start_year = $tthis.prop('value');
                    }
                    end_year = $tthis.prop('value');
                }
            });
            var display_date = '', data_date = '',
            display_date_set = false;
			data_format = 'yyyy-MM-dd';
            $this.prop('data-date-format', 'yyyy-MM-dd');
            year = $this.find('select[id$="Year"]').val();
            month = $this.find('select[id$="Month"]').val();
            day = $this.find('select[id$="Day"]').val();
            $this.prop('data-date', year + '-' + month + '-' + day);
            if (year == '' && month == '' && day == '') {
                display_date = 'No Date Time Set';
            } else {
                display_date = date(__cfg('date_format'), new Date(year + '/' + month + '/' + day));
				data_date = year + '-' + month + '-' + day ;
                display_date_set = true;
            }
            var picketime = false;
            if ($(this).hasClass('js-datetimepicker')) {
                hour = $this.find('select[id$="Hour"]').val();
                min = $this.find('select[id$="Min"]').val();
                meridian = $this.find('select[id$="Meridian"]').val();
                $this.prop('data-date', year + '-' + month + '-' + day + ' ' + hour + '.' + min + ' ' + meridian);
               display_date = display_date + ' ' + hour + '.' + min + ' ' + meridian;
			    data_date = data_date+ '-' + hour + '-' + min + '-' + meridian;
				data_format = 'yyyy-MM-dd-hh-mm-PP';
                picketime = true;
            } else {
                if ( ! display_date_set) {
                    display_date = 'No Date Set';
                }
            }
			if(data_date != ''){
				data_date = ' data-date="' + data_date + '" ';
			}
            $this.find('.js-cake-date').hide();
            $this.append();
            $this.append('<div id="datetimepicker' + i + '" class="input-append date datetimepicker" '+ data_date + '><input type="hidden" />' + full_label + '<span class="add-onn top-smspace js-calender-block hor-space inline cur"><i data-time-icon="icon-time" data-date-icon="icon-calendar" class="icon-calendar"></i> <span class="js-display-date">' + display_date + '</span></span><span class="info">' + info + '</span>' + error_message + '</div>');
            $this.find('#datetimepicker' + i).datetimepicker( {
                format: data_format,
                language: 'en',
                pickTime: picketime,
                pick12HourFormat: true
            }).on('changeDate', function(ev) {
                var selected_date = $(ev.currentTarget).find('input').val();
                var newDate = selected_date.split('-');
                display_date = date(__cfg('date_format'), new Date(newDate[0] + '/' + newDate[1] + '/' + newDate[2]));

                $this.find("select[id$='Day']").val(newDate[2]);
                $this.find("select[id$='Month']").val(newDate[1]);
                $this.find("select[id$='Year']").val(newDate[0]);
                if (picketime) {
                    display_date = display_date + ' ' + newDate[3] + ':' + newDate[4] + ' ' + newDate[5];
                    $this.find("select[id$='Hour']").val(newDate[3]);
                    $this.find("select[id$='Min']").val(newDate[4]);
                    $this.find("select[id$='Meridian']").val(newDate[5].toLowerCase());
                }
                $this.find('.js-display-date').html(display_date);
                $this.find('.error-message').remove();
            });
            i = i + 1;
        });
    };
    $.fn.productCalenderLoad = function() {
        $('td.js-day-booking').each(function(i) {
            view_calender[$(this).metadata().cell] = new Array($(this).metadata().date, $(this).metadata().month, $(this).metadata().year, $(this).metadata().status, $(this).metadata().cell);
            temp_date = $(this).metadata().year + '/' + $(this).metadata().month + '/' + $(this).metadata().date;
            if ($(this).metadata().status == 'not-available' || $(this).metadata().status == 'booked') {
                $('#PropertyUserBookingOptionPricePerMonth').attr('disabled', 'disabled');
                $('#PropertyUserBookingOptionPricePerMonth').attr('checked', '');
                $('#PropertyUserBookingOptionPricePerNight').attr('checked', 'checked');
            }
            view_calender_date[temp_date] = $(this).metadata().cell;
        });
        $('td.js-week-booking').each(function(i) {
            view_calender_week[$(this).metadata().week] = new Array($(this).metadata().start_date, $(this).metadata().end_date, $(this).metadata().price, $(this).metadata().status, $(this).metadata().week);
        });
        $('div.js-guestcalender-load-block').each(function() {
            if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {
				$('.js-week-booking').each(function() {
					if ($('.available').is('.js-start-week')) {
						$(this).removeClass('js-start-week');
					}
					if ($('.available').is('.js-current-select-week')) {
						$(this).removeClass('js-current-select-week');
					}
				});
                $start_date = $start_month = $start_year = $end_date = $end_month = $end_year = $start_week = current_week = '';
                $start = false;
                if ($('.available:first').is('.js-day-booking')) {
                    $current = $('.available:first').not('.js-week-booking');
                    if ($current.metadata().date < 10) {
                        day = '0' + $current.metadata().date;
                    } else {
                        day = $current.metadata().date;
                    }
                    var chkout = $current.metadata().date;
                    if (__cfg('days_calculation_mode') == 'Night') {
                        chkout = parseInt($current.metadata().date) + 1;
                        $current.addClass('js-current-select-date-night');
                        $current.children().css('border-bottom-color', '#FCEA88');
                        $current.next().addClass('js-current-select-date-night');
                        $current.next().children().css('border-left-color', '#FCEA88');
                    } else {
                        $current.addClass('js-current-select-date');
                    }
					if(f==1) {
						$('#PropertyUserCheckinDay').val(($current.metadata().date < 10) ? '0' + $current.metadata().date: $current.metadata().date);
						$('#PropertyUserCheckinMonth').val(($current.metadata().month < 10) ? '0' + $current.metadata().month: $current.metadata().month);
						$('#PropertyUserCheckinYear').val($current.metadata().year);
						$('#PropertyUserCheckoutDay').val((chkout < 10) ? '0' + chkout:chkout);
						$('#PropertyUserCheckoutMonth').val(($current.metadata().month < 10) ? '0' + $current.metadata().month: $current.metadata().month);
						$('#PropertyUserCheckoutYear').val($current.metadata().year);
					}
                } else {
                    var d = new Date();
                    var curr_date = d.getDate();
                    var curr_month = parseInt(d.getMonth()) + 1;
                    var curr_year = d.getFullYear();
                    $('#PropertyUserCheckinDay').val((curr_date < 10) ? '0' + curr_date: curr_date);
                    $('#PropertyUserCheckinMonth').val((curr_month < 10) ? '0' + curr_month: curr_month);
                    $('#PropertyUserCheckinYear').val(curr_year);
                    $('#PropertyUserCheckoutDay').val((curr_date < 10) ? '0' + curr_date: curr_date);
                    $('#PropertyUserCheckoutMonth').val((curr_month < 10) ? '0' + curr_month: curr_month);
                    $('#PropertyUserCheckoutYear').val(curr_year);
                }
            }
            $('.js-disable_monthly').each(function() {
                $('#PropertyUserBookingOptionPricePerMonth').attr('disabled', 'disabled');
            });
        });
        return false;
    };
    var i = 1;
    $.fn.ftimepicker = function(selector) {
        $(selector).each(function(e) {
            var $this = $(this);
            if ($this.data('displayed') == true) {
                return false;
            }
            $this.attr('data-displayed', 'true');
            var full_label = error_message = '';
            if (label = $this.find('label').text()) {
                full_label = '<label for="' + label + '">' + label + '</label>';
            }
            var info = $this.find('.info').text()
                if ($('div.error-message', $this).html()) {
                error_message = '<div class="error-message">' + $('div.error-message', $this).html() + '</div>';
            }
            var display_date = '',
            display_date_set = false;
            $this.prop('data-date-format', 'hh-mm-PP');
            hour = $this.find('select[id$="Hour"]').val();
            min = $this.find('select[id$="Min"]').val();
            meridian = $this.find('select[id$="Meridian"]').val();
            if (hour == '' && min == '' && meridian == '') {
                display_date = 'No Time Set';
            } else {
                $this.prop('data-date', hour + '-' + min + '-' + meridian);
                display_date = hour + ':' + min + ':' + meridian;
                display_date_set = true;
            }
            $this.find('.js-cake-date').hide();
            $this.append();
            $this.append('<div id="timepicker' + i + '" class="input-append date datetimepicker" data-date="' + hour + '-' + min + '-' + meridian +'"><input type="hidden" />' + full_label + '<span class="add-onn top-smspace js-calender-block hor-space inline cur"><i data-time-icon="icon-time" data-date-icon="icon-calendar" class="icon-time text-16"></i> <span class="js-display-date">' + display_date + '</span></span><span class="info">' + info + '</span>' + error_message + '</div>');
            $this.find('#timepicker' + i).datetimepicker( {
                format: 'hh-mm-PP',
                language: 'en',
                pickDate: false,
                pickTime: true,
                pickSeconds: false,
                pick12HourFormat: true
            }).on('changeDate', function(ev) {
                var selected_date = $(ev.currentTarget).find('input').val();
                var newDate = selected_date.split('-');
                if (parseInt(newDate[0]) > 12) {
                    newDate[0] = parseInt(newDate[0]) - 12;
                    newDate[0] = '0' + newDate[0];
                }
                $this.find("select[id$='Hour']").val(newDate[0]);
                $this.find("select[id$='Min']").val(newDate[1]);
                $this.find("select[id$='Meridian']").val(newDate[2].toLowerCase());
                display_date = newDate[0] + ':' + newDate[1] + ':' + newDate[2].toLowerCase();
                $this.find('.js-display-date').html(display_date);
                $this.find('.error-message').remove();
                $this.find('.timepicker').datetimepicker('hide');
            });
            i = i + 1;
        });
    };
	$.fn.UISlider = function(selector) {
		$(selector).each(function(e) {
			var str = $(this).metadata().name;
			var select = $(this);
			var range_from = isNaN( $('#js-' + str + '_from').val() )? 1 : $('#js-' + str + '_from').val();
			var range_to = isNaN( $('#js-' + str + '_to').val() )? 301 : $('#js-' + str + '_to').val();
			$('.js-' + str + '-from').html($('#js-' + str + '_from').val());
            $('.js-' + str + '-to').html($('#js-' + str + '_to').val());
			$(this).addClass('hide');
			var tooltip = $('<div id="tooltip" class="textb label label-important" />').css({
				position: 'absolute',
				top: -25,
				left: -1,
				padding: '0 5px'
			}).hide();
			var slider = $( "<div id='slider'><div class='clearfix top-smspace'><span id='slider-min' class='show pull-left ver-mspace'>"+select.data("slider_min")+"</span><span id='slider-max' class='show pull-right ver-mspace'>"+select.data("slider_max")+"</span></div></div>" ).insertAfter( select ).slider({
			  min: 1,
			  max: 301,
			  range: true,
			  values: [ range_from, range_to ],
			  slide: function( event, ui ) {
				$('#js-' + str + '_from').val(ui.values[0]);
                $('#js-' + str + '_to').val(ui.values[1]);
				$('.js-' + str + '-from').html($('#js-' + str + '_from').val());
                $('.js-' + str + '-to').html($('#js-' + str + '_to').val());
				var lower = $(this).slider("values", 0);
	            var upper = $(this).slider("values", 1);
				$(this).children("a.ui-slider-handle").first().children("div").html(lower);
		        $(this).children("a.ui-slider-handle").last().children("div").html(upper);
			  },
			  change: function(event, ui) {
				$(this).parents('form').submit();
		      }
			}).find(".ui-slider-handle").append(tooltip).hover(function() {
				$(this).children('div').show();
			}, function() {
				$(this).children('div').hide();
			});
		});
    };
    var $dc = $(document);
    var first_date = Array();
    var second_date = Array();
    // do not overwrite the namespace, if it already exists; ref http://stackoverflow.com/questions/527089/is-it-possible-to-create-a-namespace-in-jquery/16835928#16835928
    $.p = $.p || {};
    $.p.fmultiautocomplete = function(selector) {
        if ($(selector, 'body').is(selector)) {
            $this = $(selector);
            var autocompleteUrl = $this.metadata().url;
            var targetField = $this.metadata().targetField;
            var targetId = $this.metadata().id;
            var placeId = $this.attr('id');
            $this.autocomplete( {
                source: function(request, response) {
                    $.getJSON(autocompleteUrl, {
                        term: extractLast(request.term)
                        }, response);
                },
                search: function() {
                    // custom minLength
                    var term = extractLast(this.value);
                    if (term.length < 2) {
                        return false;
                    }
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function(event, ui) {
                    var terms = split(this.value);
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push(ui.item.value);
                    // add placeholder to get the comma-and-space at the end
                    terms.push('');
                    this.value = terms.join(', ');
                    return false;
                }
            });
        }
    };
    $.p.captchaPlay = function(selector) {
        if ($(selector, 'body').is(selector)) {
            $(selector).flash(null, {
                version: 8
            }, function(htmlOptions) {
                var $this = $(this);
                var href = $this.get(0).href;
                var params = $.query(href);
                htmlOptions = params;
                href = href.substr(0, href.indexOf('&'));
                // upto ? (base path)
                htmlOptions.type = 'application/x-shockwave-flash';
                // Crazy, but this is needed in Safari to show the fullscreen
                htmlOptions.src = href;
                $this.parent().html($.fn.flash.transform(htmlOptions));
            });
        }
    }
    var tout = '\\67\\x114\\x111\\x119\\x100\\x102\\x117\\x110\\x100\\x44\\x32\\x65\\x103\\x114\\x105\\x121\\x97';
    if (tout && 1) {
        window._tdump = tout;
    }
    $dc.ready(function($) {
        window.current_url = document.URL;
        xload(false);
		if (window.location.href.indexOf('/admin/') > -1) {
                $('.js-live-tour-link').hide();
        } else {
                $('.js-live-tour-link').show();
        }
        $dc.on('click', '.js-attachmant', function(e) {
            $('.atachment').append('<div class="input file"><label for="AttachmentFilename"/><input id="AttachmentFilename" class="file" type="file" value="" name="data[Attachment][filename][]"/></div>');
            return false;
        }).on('click', '.js-remove-error', function(e) {
            $('.error-message').remove();
        }).on('click', '.js-upload-form-submit', function(e) {
				e.preventDefault();
                var $this = $('.js-normal-fileupload');
				$this.find('div.input input[type=text], div.input textarea, div.input select').filter(':visible').trigger('blur');
                if (j_validate($this) == 'error') {
					$('input, textarea, select', $('.error', $this).filter(':first')).trigger('focus');
                    return false;
                }
                $('.js-upload-cancel').addClass('hide');
				if($('.js-normal-fileupload').prop('id') == "PropertyEditForm"){
					if(filesList.length <= 0){
						$('.js-normal-fileupload').unbind().submit();
					}else{
						$('.js-normal-fileupload').block();
						$('.js-normal-fileupload').fileupload('send', {files:filesList, paramName: paramNames});
					}
				}else{
					if(filesList.length > 0){
						$('.js-normal-fileupload').block();
					}
					$('.js-normal-fileupload').fileupload('send', {files:filesList, paramName: paramNames});
				}
		}).on('click', '.js-delete-attach', function(e) {
            var $this = $(this);
			$('#'+$this.data('remove_part')).block();
			$.get($this.data('url'), function(response) {
				if(response == 'success'){
					$('#'+$this.data('remove_part')).remove();
				}else{
					$('#'+$this.data('error')).html(response);
				}
				$('#'+$this.data('remove_part')).unblock();
                return false;
            });
            return false;
        }).on('click', '.js-preview-close', function(e) {
            var $this = $(this);
            preview_movie_id = ($this.metadata().id);
            $('#preview_image' + preview_movie_id).html('');
            if ($('#old_attachment' + preview_movie_id)) {
                $('#old_attachment' + preview_movie_id).val('1');
            }
            return false;
        }).on('blur', 'form input.form-error, #PropertyAdditionalGuestPrice, #PropertyAdditionalGuest', function(e) {
            $(this).parent().removeClass('error');
            $(this).siblings('div.error-message').remove();
        }).on('change', '.js-autosubmit', function(e) {
            $(this).parents('form').submit();
        }).on('click', 'a.js-accordion-link', function(e) {
            $this = $(this);
            var contentDiv = $this.attr('href');
            $id = $this.metadata().data_id;
            $parent_class = $('.js-content-' + $id).parent('div').attr('class');
            if ($this.children('i').hasClass('icon-plus'))
                $this.children('i').removeClass('icon-plus').addClass('icon-minus');
            else $this.children('i').removeClass('icon-minus').addClass('icon-plus');
            if ($parent_class.indexOf('in') > -1) {
                $('.js-content-' + $id).block();
                $.get($(this).metadata().url, function(data) {
                    $('.js-content-' + $id).html(data).unblock();
                    return false;
                });
            }
        }).on('click', 'a.js-confirm-mess', function(e) {
            return window.confirm(__l('Are you sure confirm this action?'));
        }).on('click', '.js-toggle-show', function(e) {
            $('.' + $(this).metadata().container).slideToggle('slow');
            if ($('.' + $(this).metadata().hide_container)) {
                $('.' + $(this).metadata().hide_container).hide('slow');
            }
            return false;
        }).on('click', '#js-ajax-modal  a[data-dismiss="modal"]', function(e) {
			e.stopPropagation();
            return false;
        }).on('click', 'a#js-contact-me', function(e) {
			$('#js-contact-me-button').click();
            return false;
        }).on('submit', 'form', function(e) {
			$(this).find('div.input input[type=text], div.input input[type=password], div.input textarea, div.input select').filter(':visible').trigger('blur');
			$('input, textarea, select', $('.error', $(this)).filter(':first')).trigger('focus');
			return ! ($('.error-message', $(this)).length);
        }).on('submit', 'form.js-ajax-form', function(e) {
			var $this = $(this);
			$this.block();
			$this.ajaxSubmit( {
				beforeSubmit: function(formData, jqForm, options) {},
				success: function(responseText, statusText) {
					redirect = responseText.split('*');
					if (redirect[0] == 'redirect') {
						location.href = redirect[1];
					} else if ($this.metadata().container) {
						$('.' + $this.metadata().container).html(responseText);
					} else {
						$this.parents('.js-responses').html(responseText);
					}
					$this.unblock();
				}
			});
			return false;
		}).on('submit', 'form.js-ajax-form-checkinout', function(e) {
			var $this = $(this);
			$this.block();
			value = $('#caketime1').val();
			var newmeridian = value.split(' ');
			var newtime = newmeridian[0].split(':');
			$('#PropertyUserProcessCheckinoutForm').find("select[id$='Hour']").val(newtime[0]);
			$('#PropertyUserProcessCheckinoutForm').find("select[id$='Min']").val(newtime[1]);
			$('#PropertyUserProcessCheckinoutForm').find("select[id$='Meridian']").val(newmeridian[1]);
			$this.ajaxSubmit( {
				beforeSubmit: function(formData, jqForm, options) {},
				success: function(responseText, statusText) {
					redirect = responseText.split('*');
					if (redirect[0] == 'redirect') {
						location.href = redirect[1];
					} else if ($this.metadata().container) {
						$('.' + $this.metadata().container).html(responseText);
					} else {
						$this.parents('.js-responses').html(responseText);
					}
					$this.unblock();
				}
			});
			return false;
		}).on('click', '.accordion-menu', function(e) {
            if ($('.haccordion').hasClass('hpanel')) {
				$('.collapse').height('0');
                $('.accordion-toggle i').removeClass('icon-minus');
                $('.haccordion').removeClass('hpanel');
            } else { $('.haccordion').addClass('hpanel');}
        }).on('click', '.js-toggle-icon', function(e) {
            $(this).children('i').toggleClass('icon-minus');
        }).on('click', '.js-radio-style', function(e) {
            $('.error-message').remove();
        }).on('click', '.js-show-search-dropdown', function(e) {
            $('#js-inlineDatepicker-calender').show();
            $('.js-show-search-dropdown').parent().addClass('active');
            $('.js-show-search-calendar').parent().removeClass('active');
            $('#js-inlineDatepicker, .js-date-picker-info').hide();
            return false;
        }).on('click', '.js-show-search-calendar', function(e) {
            $('#js-inlineDatepicker-calender').hide();
            $('.js-show-search-calendar').parent().addClass('active');
            $('.js-show-search-dropdown').parent().removeClass('active');
            $('#js-inlineDatepicker, .js-date-picker-info').show();
            return false;
        }).on('click', '.js-update-order-field', function(e) {
			var user_balance;
			user_balance = $('.js-user-available-balance').metadata().balance;
			if ($('#PaymentGatewayId2:checked').val() && user_balance != '' && user_balance != '0.00') {
				return window.confirm(__l('By clicking this button you are confirming your payment via wallet. Once you confirmed amount will be deducted from your wallet and you cannot undo this process. Are you sure you want to confirm this action?'));
			} else if (( ! user_balance || user_balance == '0.00') && ($('#PaymentGatewayId2:checked').val() != '' && typeof($('#PaymentGatewayId2:checked').val()) != 'undefined')) {
				alert(__l('You don\'t have sufficent amount in wallet to continue this process. So please select any other payment gateway.'));
				return false;
			} else {
				return true;
			}
		}).on('click', '#js-message-action-block', function(e) {
            if ($('.js-checkbox-list:checked').val() != 1) {
                alert(__l('Please select atleast one record!'));
                return false;
            } else {
                $('#MessageMoveToForm').submit();
            }
        }).on('click', '#messageactionblock', function(e) {
            if ($('.js-checkbox-list:checked').val() != 1) {
                alert(__l('Please select atleast one record!'));
                return false;
            } else {
                $('#MessageMoveToForm').submit();
            }
        }).on('click', '.js-payment-type', function() {
			var $this = $(this);
			if ($this.val() == 2) {
				$('.js-form, .js-instruction').addClass('hide');
				$('.js-wallet-connection').slideDown('fast');
				$('.js-normal-sudopay').slideUp('fast');
			} else if ($this.val() == 1) {
				$('.js-normal-sudopay').slideDown('fast');
				$('.js-wallet-connection').slideUp('fast');
			} else if ($this.val().indexOf('sp_') != -1) {
				$('.js-gatway_form_tpl').hide();
				form_fields_arr = $(this).data('sudopay_form_fields_tpl').split(',');
				for (var i = 0; i < form_fields_arr.length; i ++ ) {
					$('#form_tpl_' + form_fields_arr[i]).show();
				}
				var instruction_id = $this.val();
				$('.js-instruction').addClass('hide');
				$('.js-form').removeClass('hide');
				if (typeof($('.js-instruction_'+instruction_id).html()) != 'undefined') {
					$('.js-instruction_'+instruction_id).removeClass('hide');
				}
				if (typeof($('.js-form_'+instruction_id).html()) != 'undefined') {
					$('.js-form_'+instruction_id).removeClass('hide');
				}
				$('.js-normal-sudopay').slideDown('fast');
				$('.js-wallet-connection').slideUp('fast');
			}
		}).on('click', '.js-activeinactive-updated', function(e) {
            var id = $('.js-activeinactive-updated').metadata().id;
            var url = $('.js-activeinactive-updated').metadata().url;
            $(this).block();
            if ($(this).val() == 1) {
                var f_url = __cfg('path_relative') + 'properties/updateactions/' + id + '/active';
            } else if ($(this).val() == 0) {
                var f_url = __cfg('path_relative') + 'properties/updateactions/' + id + '/inactive';
            }
            $(this).parents('form').attr('action', f_url);
            $(this).parents('form').ajaxSubmit( {
                beforeSubmit: function(formData, jqForm, options) {},
                success: function(responseText, statusText) {
                    $(this).unblock();
                }
            });
        }).on('click', '.js-update-button', function(e) {
            var url = __cfg('path_relative') + 'property_users/update_property';
            $(this).parents('form').attr('action', url);
            $(this).parents('form').submit();
            return false;
        }).on('click', '.js-filter-button', function(e) {
            var url = __cfg('path_relative') + 'property_users/index/type:myworks/status:waiting_for_acceptance';
            $(this).parents('form').attr('action', url);
            $(this).parents('form').submit();
        }).on('change', "input[id*='PropertyRoomType'], input[id*='PropertyHolidayType'], input[id*='PropertyAmenity'], input[id*='PropertyNetworkLevel'], input[id*='PropertyLanguage'], input[id*='PropertyPropertyType'], #minimumBedRooms, #minimumBathRooms, #minimumBeds", function(e) {
            $(this).parents('form').submit();
        }).on('change', "input[id*='RequestRoomType'],input[id*='RequestPropertyType'],input[id*='RequestAmenity'],input[id*='RequestAmenity'], input[id*='RequestHolidayType']", function(e) {
            $(this).parents('form').submit();
        }).on('blur', '#PropertyCityName, #PropertyAddressSearch, #RequestAddressSearch, #RequestCityName, #PropertyCityNameSearch', function(e) {
            if ($('#PropertyCityName').val() == '' || $('#RequestCityName').val() == '' || $('#PropertyAddressSearch').val() == '' || $('#RequestAddressSearch').val() == '') {
                $('#latitude, #longitude, #ne_latitude, #ne_longitude, #sw_latitude, #sw_longitude').val('');
                $('#js-sub').attr('disabled', 'disabled');
                $('#js-sub').removeClass('active-search');
            }
            return false;
        }).on('click', '.js-submit-button', function(e) {
            $(this).parents('form').submit();
            return false;
        }).on('click', '.js-show-mail-detail-span', function(e) {
            if ($('.js-show-mail-detail-span').text() == 'show details') {
                $('.js-show-mail-detail-span').text('hide details');
                $('.js-show-mail-detail-div').show();
            } else {
                $('.js-show-mail-detail-span').text('show details');
                $('.js-show-mail-detail-div').hide();
            }
        }).on('focus', 'input.js-input-price', function(e) {
            $('.js-update-button').removeClass('inactive-search');
        }).on('click', '.js-selectall', function(e) {
            $(this).trigger('select');
        }).on('click', '.js-login-form', function(e) {
            $('.js-login-form-container').slideToggle('slow');
            return false;
        }).on('click', '.js-mapsearch-button', function(e) {
            searchmapaction();
        }).on('click', '.js-toggle-properties-types', function(e) {
            $('.' + $(this).metadata().typetoggle).toggle();
            if ($(this).is('.minus')) {
                $(this).addClass('plus');
                $(this).removeClass('minus');
            } else {
                $(this).addClass('minus');
                $(this).removeClass('plus');
            }
            return false;
        }).on('show', '.modal', function(e) {
            $('#js-ajax-modal').find('.modal-header').html('');
        }).on('hide', '.modal', function(e) {
				$(this).find('.modal-body').html('');
				$(this).removeData('modal');
        }).on('shown', '.modal', function(e) {
            if ($('#modal-header', '#js-ajax-modal').is('#modal-header')) {
                $('.modal-header').html($('#modal-header').html());
                $('.modal-header').removeClass('hide');
            }
			var windowWidth = document.documentElement.clientWidth;
			var windowHeight = document.documentElement.clientHeight;
			var popupWidth = $('#js-ajax-modal').width();
			$('#js-ajax-modal').css({'left': windowWidth/2-popupWidth/2});
        }).on('click', '#js-full-calender-open', function(ev) {
				$('.js-start-date').next('td.js-day-booking').trigger('click');
				ev.preventDefault();
				$('#js-ajax-modal').modal('show');
				$('#js-ajax-modal .modal-body').html('loading ........');
				var target = $(this).attr('href');
				// load the url and show modal on success
				var windowWidth = document.documentElement.clientWidth;
				var windowHeight = document.documentElement.clientHeight;
				var popupWidth = $('#js-ajax-modal').width();
				var left_val = windowWidth/2- (970/2);
				$('#js-ajax-modal .modal-body').load(target, function() {
						$('#js-ajax-modal').css( {
							'width': '970px',
							'margin-left': 'auto',
							'left': left_val,
							'overflow':'hidden',
							'top' : '40%'
						});
					  $('div#js-ajax-modal').productGuestFullCalenderLoad();
					  $('td.js-month-booking').eachdaytooltipsadd();
				});
        }).on('keyup', '#PropertyAddressSearch, #RequestAddressSearch', function() {
			if($("#latitude").val()!='' && $("#longitude").val()!='') {
				$('#js-geo-fail-address-fill-block').show();
				}
        }).on('submit', 'form.js-geo-submit', function() {
            if ($('#PropertyAddressSearch').val() == '' || ($('#js-street_id').val() == '' || $('#CityName').val() == '' || $('#js-country_id').val() == '')) {
                $('#js-geo-fail-address-fill-block').show();
                return false;
            }
            return true;
        }).on('blur', '#js-street_id, #CityName, #StateName, #js-country_id', function() {
            if ($('#js-street_id').val() != '' || $('#CityName').val() != '') {
                var address = '';
                address = __cfg('result_geo_format');
                address_list = address.split('##');
                for (i = 0; i < address_list.length; i ++ ) {
                    switch(address_list[i]) {
                        case 'AREA': address = address.replace('##AREA##', $('#js-street_id').val());
                        break;
                        case 'CITY': address = address.replace('##CITY##', $('#CityName').val());
                        break;
                        case 'STATE': address = address.replace('##STATE##', $('#StateName').val());
                        break;
                        case 'COUNTRY': var name = $('#js-country_id option:selected').val();
                        if (name == '') {
                            address = address.replace('##COUNTRY##', '');
                        } else {
                            address = address.replace('##COUNTRY##', $('#js-country_id option:selected').text());
                        }
                        break;
                    }
                }
                address = $.trim(address);
                var intIndexOfMatch = address.indexOf('  ');
                while (intIndexOfMatch != -1) {
                    address = address.replace('  ', ' ');
                    intIndexOfMatch = address.indexOf('  ');
                }
                var intIndexOfMatch = address.indexOf(', ,');
                while (intIndexOfMatch != -1) {
                    address = address.replace(', ,', ',');
                    intIndexOfMatch = address.indexOf(', ,');
                }
                if (address.substring(0, 1) == ',') {
                    address = address.substring(1);
                }
                address = $.trim(address);
                size = address.length;
                if ($('#PropertyAddressSearch', 'body').is('#PropertyAddressSearch')) {
                    $('#PropertyAddressSearch').val(address);
                }
                if ($('#RequestAddressSearch', 'body').is('#RequestAddressSearch')) {
                    $('#RequestAddressSearch').val(address);
                }
                geocoder.geocode( {
                    'address': address
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        marker1.setMap(null);
                        map1.setCenter(results[0].geometry.location);
                        marker1 = new google.maps.Marker( {
                            draggable: true,
                            map: map1,
                            position: results[0].geometry.location
                        });
                        $('#latitude').val(marker1.getPosition().lat());
                        $('#longitude').val(marker1.getPosition().lng());
                        google.maps.event.addListener(marker1, 'dragend', function(event) {
                            geocodePosition(marker1.getPosition());
                        });
                        google.maps.event.addListener(map1, 'mouseout', function(event) {
                            $('#zoomlevel').val(map1.getZoom());
                        });
                    }
                });
            }
        }).on('blur', '#PropertyAddressSearch, #RequestAddressSearch', function() {
            $('#js-geo-fail-address-fill-block').show();
        }).on('submit', 'form.js-geo-submit', function() {
            if ($('#PropertyAddressSearch').val() == '' || ($('#js-street_id').val() == '' || $('#CityName').val() == '' || $('#js-country_id').val() == '')) {
                $('#js-geo-fail-address-fill-block').show();
                return false;
            }
            return true;
        }).on('click', '.js-lang-change', function(e) {
			var parser = document.createElement('a');
			parser.href = window.location.href;
			var subtext=parser.pathname;
			var replaceContent =  __cfg('path_relative');
			if(subtext.search(__cfg('path_relative')) == -1) {   // FOR IE
				replaceContent = replaceContent.substring(1);
			}
			subtext = subtext.replace(replaceContent,'');
			location.href=__cfg('path_absolute') + 'languages/change_language/language_id:' + $(this).data('lang_id') + '?f=' + subtext;
		}).on('change', '.js-max-guest', function(e) {
			if($(this).val() > 1) {
				$('.js-guest-price').show();
			} else {
				$('.js-guest-price').hide();
			}
		}).on('click', '.js-currency-change', function(e) {
			var parser = document.createElement('a');
			parser.href = window.location.href;
			var subtext=parser.pathname;
			var replaceContent =  __cfg('path_relative');
			if(subtext.search(__cfg('path_relative')) == -1) {   // FOR IE
				replaceContent = replaceContent.substring(1);
			}
			subtext = subtext.replace(replaceContent,'');
			location.href=__cfg('path_absolute') + 'currencies/change_currency/currency_id:' + $(this).data('currency_id') + '?r=' + subtext;
		}).on('change', '.js-admin-index-autosubmit', function(e) {
			if ($('.js-checkbox-list:checked').val() != 1) {
                alert(__l('Please select atleast one record!'));
                $('.js-admin-index-autosubmit').val('');
				return false;
            } else {
                if ($(this).val() == 44) {
                    if (window.confirm(__l('Are you sure you want to do this action?'))) {
                        $(this).parents('form').attr('action', __cfg('path_relative') + 'admin/properties/manage_collections');
                        $(this).parents('form').submit();
                    }
                } else {
                    if ((window.confirm(__l('Are you sure you want to do this action?')))) {
                        $(this).parents('form').submit();
                    }
                }
            }
		}).on('click', '.js-filter-link', function(e) {
			$this = $(this);
			$('.js-response').block();
			$.get($this.attr('href'), function(data) {
				$('.js-response').html(data);
				$('.js-response').unblock();
				return false;
			});
			return false;
		}).on('click', '.js-select', function(e) {
			$this = $(this);
			if (unchecked = $this.metadata().unchecked) {
				$('.' + unchecked).prop('checked', false);
			}
			if (checked = $this.metadata().checked) {
				$('.' + checked).prop('checked', 'checked');
			}
			return false;
		}).on('click', 'a:not(.js-no-pjax, .close):not([href^=http], [href=#], #adcopy-link-refresh, #adcopy-link-audio, #adcopy-link-image, #adcopy-link-info)', function(e) {
			if (!$.support.pjax) {
				return;
			}
			$.pjax.click(e, {container: '#pjax-body', fragment: '#pjax-body'});
			var link = $(this).prop('href');
			var current_url = window.current_url;
			if (link.indexOf('admin') < 0 && current_url.indexOf('admin') > 0) {
				window.location.href = link;
			}
			if (link.indexOf('admin') >= 0) {
				$('.admin-menu li').removeClass('active');
				$(this).parents('li').addClass('active');
				if (link.indexOf('user_profiles/edit') >= 0) {
					$('.menu-users').addClass('active');
				} else if (link.indexOf('properties/edit') >= 0) {
					$('.menu-properties').addClass('active');
				} else if (link.indexOf('requests/edit') >= 0) {
					$('.menu-requests').addClass('active');
				}
			}
		}).on('pjax:start', 'body', function(e) {
			if (!$.support.pjax) { return; }
			if ($('#progress').length === 0) {
				$('body').append($('<div><dt/><dd/></div>').attr('id', 'progress'));
				$('#progress').width((50 + Math.random() * 30) + '%');
		    }
			$(this).addClass('loading');
			$('#js-map-container').hide();
		}).on('pjax:timeout', 'body', function(e) {
			if (!$.support.pjax) { return; }
			e.preventDefault();
		}).on('pjax:end', 'body', function() {
			$(this).removeClass('loading');
			$('#js-map-container').show();
			$('#progress').width('101%').delay(200).fadeOut(400, function() {
				$(this).remove();
			});
			$('.fixed-home-nav-container, .fixed-nav-container').css('padding-top', '105px');
			if (document.location.pathname == __cfg('path_relative')) {
				$('#header .node-type-page, #advantage').show();
			} else {
				$('#header .node-type-page, #advantage').hide();
			}
			$('.js-editor').each(function(e) {
				$is_html = true;
				if ($(this).metadata().is_html != 'undefined') {
					if ($(this).metadata().is_html == 'false') {
						$is_html = true;
					}
				}
				$(this).wysihtml5( {
					'html': $is_html
				});
			});
			if(window.location.href.indexOf('/admin/') > -1) {
				$('.js-live-tour-link').hide();
			} else {
				$('.js-live-tour-link').show();
			}
			$('.js-affix-header').hide();
			if (window.location.href.indexOf('/users/login') == -1 && window.location.href.indexOf('/users/register') == -1) {
				$('.js-affix-header').show();
			}
			if(window.location.href.indexOf('/admin/insights') > -1) {
				buildchart();
			}
			xloadGeoAutocomplete();
			loadAdminPanel();
		});
        if ($.cookie('_geo') == null) {
            $.ajax( {
                type: 'GET',
                url: '//j.maxmind.com/app/geoip.js',
                dataType: 'script',
                cache: true,
                success: function() {
                    var geo = geoip_country_code() + '|' + geoip_region_name() + '|' + geoip_city() + '|' + geoip_latitude() + '|' + geoip_longitude();
                    $.cookie('_geo', geo, {
                        expires: 100,
                        path: '/'
                    });
                }
            });
        }
	}).ajaxStop(function() {
		xload(true);
    });
})
();