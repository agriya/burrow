/*------------------------------------------------------

	@Google Maps Autocomplete

------------------------------------------------------- */

(function($) {

    // google map variables
    var geocoder;
    var map;
    var marker;

    // set this to true if you want US only results
    var US_only = false;

    // set plugin options
    var map_frame_id;
    var map_window_id;
    var lat_id;
    var lng_id;
    var addr_id;
    var lat;
    var lng;
    var state;
    var city;
	var country;
	var postal_code;
    var map_zoom;
	var request_string;
	var ne_lat;
	var ne_lng;
	var sw_lat;
	var sw_lng;
	var button;
	var error;
	var mapblock;
	var first_lat;
	var first_lng;

    $.fn.extend({

        autogeocomplete: function(options){

            // extend plugin options
            options = $.extend({}, $.fn.autogeocomplete.defaults, options);
            map_window_id = options.map_window_id;
            map_frame_id = options.map_frame_id;
            button = options.button;
            error = options.error;
            lat_id = options.lat_id;
            lng_id = options.lng_id;
            addr_id = options.addr_id;
            lat = options.lat;
            lng = options.lng;
			area = options.area;
            state = options.state;
            city = options.city;
            postal_code = options.postal_code;
            country = options.country;
            map_zoom = options.map_zoom;
            ne_lat = options.ne_lat;
            ne_lng = options.ne_lng;
            sw_lat = options.sw_lat;
            sw_lng = options.sw_lng;
			mapblock = options.mapblock;

            // init google map and geocoder
            this.initialize();
            geocoder = new google.maps.Geocoder();

            this.autocomplete({

                // fetch address values
                source: function(request, response) {
					request_string = request.term;
                    geocoder.geocode( {'address': request.term}, function(results, status) {

                        // limit number of returned values to top 5
                        var item_count = 0;

                        // limit to US only results
                        var filter_results = [];

                        if(US_only){
                            $.each(results, function(item){
                                if(results[item].formatted_address.toLowerCase().indexOf(", usa") !== -1)
                                {
                                    filter_results.push(results[item]);
                                }
                            });
                        }
                        else{
                            filter_results = results;
                        }
                        // default render map to top result
						if(filter_results != ''){
							first_lat = filter_results[0].geometry.location.lat();
							first_lng = filter_results[0].geometry.location.lng();
	                        setMap(filter_results[0].geometry.location.lat(), filter_results[0].geometry.location.lng());
						}

                        // parse and format returned suggestions
                        response($.map(filter_results, function(item) {

                            // split returned string
                            var place_parts = item.formatted_address.split(",");
                            var place = place_parts[0];
                            var place_details = "";

                            // parse city, state, and zip
                            for(i=1;i<place_parts.length;i++){
                                place_details += place_parts[i];
                                if(i !== place_parts.length-1) place_details += ",";
                            }

                            // return top 5 results
                            if (item_count < 5) {

								var street = '';
								var area = '';
								var city ='';
								var country_long ='';
								var country ='';
								var state = '';
								var postal_code= '';
								var ne_lat = '';
								var ne_lng = '';
								var sw_lat = '';
								var sw_lng = '';
								label_val = '';
								var country_lang = '';
								var components = item.address_components;
								if(components.length){
									for(var j=0; j<components.length; j++){
										if(components[j].types[0]=="point_of_interest" || components[j].types[0]=="route" || components[j].types[0]=="street_number"){
											if(street){
												street = street + ' '+components[j].long_name;
												label_val = label_val + ' '+components[j].long_name;
											}
											else{
												street = components[j].long_name;
												label_val = components[j].long_name;
											}
										}
										if(components[j].types[0]=="sublocality" || components[j].types[0]=="sublocality_level_1"){
											if(area == ''){
												if(street == ''){
													area = components[j].long_name;
													label_val = components[j].long_name;
												}
												else{
													area = street + ', '+components[j].long_name;
													label_val = label_val +  ', ' + components[j].long_name;
												}
											}
										}
										if(components[j].types[0]=="locality" || components[j].types[0]=="administrative_area_level_2" || components[j].types[0]=="administrative_area_level_3"){
											if(!city){
												city = components[j].long_name;
												label_val = (label_val) ? label_val+  ', ' + components[j].long_name : components[j].long_name;
											}
										}
										if(components[j].types[0]=="administrative_area_level_1"){
											state = components[j].long_name;
											label_val = (label_val) ? label_val+  ', ' + components[j].long_name : components[j].long_name;
										}
										if(components[j].types[0]=="country"){
											country = components[j].short_name;
											country_lang = components[j].long_name;
											label_val = (label_val) ? label_val+  ', ' + components[j].long_name : components[j].long_name;
										}
										if(components[j].types[0]=="postal_code"){
											postal_code = components[j].long_name;
											label_val = (label_val) ? label_val+  ', ' + components[j].long_name : components[j].long_name;
										}
									}
								}
								if(components.length <= 2){
									if (item.geometry.bounds.getSouthWest().lat() != undefined) {
										sw_lat = item.geometry.bounds.getSouthWest().lat();
										sw_lng = item.geometry.bounds.getSouthWest().lng();
										ne_lat = item.geometry.bounds.getNorthEast().lat();
										ne_lng = item.geometry.bounds.getNorthEast().lng();
									} else {
										sw_lat = 0;
										sw_lng = 0;
										ne_lat = 0;
										ne_lng = 0;
									}
								}

                                item_count++;
								if( area == '' && street != ''){
									area = street;
								}
								state = (state) ? state : '';
								temp = __cfg('result_geo_format');
								address_list = temp.split('##');
								for(i=0; i<address_list.length; i++){
									switch(address_list[i]){
										case 'AREA':
													temp = temp.replace("##AREA##", area);
													break;
										case 'CITY':
													temp = temp.replace("##CITY##", city);
													break;
										case 'STATE':
													temp = temp.replace("##STATE##", state);
													break;
										case 'COUNTRY':
													temp = temp.replace("##COUNTRY##", country_lang + ' ' + postal_code);
													break;

									}
								}
								temp = $.trim(temp);
								var intIndexOfMatch = temp.indexOf("  ");
								while (intIndexOfMatch != -1){
								  temp = temp.replace("  ", " ");
								  intIndexOfMatch = temp.indexOf("  ");
								}
								var intIndexOfMatch = temp.indexOf(", ,");
								while (intIndexOfMatch != -1){
								  temp = temp.replace(", ,", ",");
								  intIndexOfMatch = temp.indexOf(", ,");
								}
								if (temp.substring(0, 1) == ",") {
									temp = temp.substring(1);
								}
								temp = $.trim(temp);
								size = temp.length;

								if (temp.substring(size-1, size) == ",") {
									temp = temp.substring(0, size-1);
								}
                                return {
                                    label:  place,
                                    value: temp, //item.formatted_address,
                                    desc: place_details,
                                    area: area,
                                    city: city,
                                    state: state,
                                    country: country,
									postal_code:postal_code,
									sw_lat:sw_lat,
									sw_lng:sw_lng,
									ne_lat:ne_lat,
									ne_lng:ne_lng,
                                    latitude: item.geometry.location.lat(),
                                    longitude: item.geometry.location.lng()
                                }
                            }

                        }));
                    })
                },
                // set the minimum length of string to autocomplete
                minLength: 2,
                // set geocoder data when an address is selected
                select: function(event, ui) {
					$('#address-info').hide();
					$('#address-info').removeClass('error-message');
					$("#" + lat_id).val(ui.item.latitude);
                    $("#" + lng_id).val(ui.item.longitude);
					$("#" + area).val(ui.item.area);
                    $("#" + state).val(ui.item.state);
                    $("#" + city).val(ui.item.city);
                    $("#" + postal_code).val(ui.item.postal_code);
					$("#" + sw_lat).val(ui.item.sw_lat);
					$("#" + sw_lng).val(ui.item.sw_lng);
					$("#" + ne_lat).val(ui.item.ne_lat);
					$("#" + ne_lng).val(ui.item.ne_lng);
					$("#" + country).val(ui.item.country);
					if ($(this).attr('id') == 'PropertyAddressSearch' || $(this).attr('id') == 'RequestAddressSearch') {
						if (!ui.item.sw_lat) {
							$('#js-sub').attr('disabled', false);
							$('#js-sub').addClass('active-search');
						} else {
							$('#js-sub').attr('disabled', true);
							$('#address-info').show();
							$('#address-info').addClass('error-message');
							$('#js-sub').removeClass('active-search');
						}
						if (ui.item.country == '' || ui.item.latitude == '' || ui.item.longitude == '') {
							$('#js-geo-fail-address-fill-block').show();
							if ($(this).siblings(".error-message").is('.error-message')) {
								$(this).siblings(".error-message").html('Must be Enter Detail Address');
								$('#js-sub').attr('disabled', true);
								$('#js-sub').removeClass('active-search');
							} else {
								error_msg = $( "<div></div>" ).addClass('error-message').html('Must be Enter Detail Address');
								$(this).after(error_msg);
								$('#js-sub').attr('disabled', true);
								$('#js-sub').removeClass('active-search');
							}
						}
						loadSideMap1();
					} else {
						$('#js-sub').attr('disabled', false);
						$('#js-sub').addClass('active-search');
					}

               },
                // set map to visible when autosuggester is activated
                open: function(event, ui){
                    $("#" + map_frame_id).css("visibility", "visible");
                    $("#mapblock").css("display", "block");
                    $("#" + map_window_id).css("z-index", "0");
                    $(".ui-autocomplete").css("z-index", "10000").addClass("dropdown-menu");

                    // hard coded css width in javascript to avoid editing jQuery css files
                    $('.ui-menu-item').css("width", "auto");
	                $('.ui-menu-item').css("z-index", "10000");
					google.maps.event.trigger(map, 'resize');
					setMap(first_lat, first_lng);
                },
                // set map to invisible when autosuggester is deactivated
                close: function(event, ui){
                    $("#" + map_frame_id).css("visibility", "hidden");
					 $("#mapblock").css("display", "none");
                },
                // update map rendering on mouseover / keyover
                focus: function(event, ui){
                    setMap(ui.item.latitude, ui.item.longitude);
                }
            })
			.data( "ui-autocomplete" )._renderMenu = function( menuUl, items ) {
				  $.each( items, function( index, item ) {
					first =  request_string.split(' ');
					second =  (item.value).split(' ');

					$(first).each(function(index, item) {
						$is_array = true;
						temp = item.replace(",", "").toLowerCase();
						if(temp == 'street')
							item = 'St,'
						$(second).each(function(se_index, se_item) {
							if(se_item.replace(",", "").toLowerCase() == item.replace(",", "").toLowerCase() && $is_array != false){
								first[index] = '';
							}

						});
					});

					generate_string = first.join(" ") + item.value;


					var li = $( "<li></li>" )
						.data( "ui-autocomplete-item", item )
						.select(function() {
						   $(this).children('ul').show();
						  return false;
						})
						.mouseover(function() {
						  $(this).children('ul').show();
						  return false;
						})
						.mouseout(function() {
						 $(this).children('ul').hide();
						  return false;
						})
						.appendTo( menuUl ),

					  label = $( "<a class='js-no-pjax'></a>" )
                        .text(  item.value )
						.appendTo( li ),

					  mapblock_obj=$('#mapblock');
				  menuUl.appendTo(mapblock_obj);
				  });

				};

            // update geo coordinates and refresh map display
            function setMap(lat, lng){
				$('.menu-over-ul').hide();
				$('#ui-active-menuitem').siblings('ul').show();
                map_location = new google.maps.LatLng(lat, lng);
                marker.setPosition(map_location);
                map.setCenter(map_location);
            }
        },

        initialize: function(){

            // init map
            var latlng = new google.maps.LatLng(lat, lng);
            var myOptions = {
                zoom: map_zoom,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scaleControl : false,
                mapTypeControl : false
            }
            map = new google.maps.Map(document.getElementById(map_window_id), myOptions);
            marker = new google.maps.Marker({
                map: map,
                draggable: true
            });

            google.maps.event.addListener(map, 'click', function(event){

                // put the lat and lng values in the input boxes
                $("#" + lat_id).val(event.latLng.b);
                $("#" + lng_id).val(event.latLng.c);

                // set marker position to event click
                var marker_position = event.latLng;

                // create a new geocode object to reverse geocode click position
                var reversegeocoder = new google.maps.Geocoder();

                // geocoder returns an array or nearest matching address, take the first result and put it in the relevant drop down box
                reversegeocoder.geocode({ 'latLng': event.latLng }, function(results, status){
                    $("#" + addr_id).val(results[0].formatted_address);
                });
            });
        }

    });

    // set default values for everything
    $.fn.autogeocomplete.defaults = {
        map_frame_id: "mapframe",
        map_window_id: "mapwindow",
        lat_id: "filter_lat",
        lng_id: "filter_lng",
        addr_id: "filter_address",
        lat: "37.7749295",
        lng: "-122.4194155",
        map_zoom: 13
    };

})(jQuery);

