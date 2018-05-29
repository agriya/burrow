function days_between(date1, date2) {
    // The number of milliseconds in one day
    var ONE_DAY = 1000 * 60 * 60 * 24;
    // Convert both dates to milliseconds
    var date1_ms = date1.getTime();
	var date2_ms = date2.getTime();
    // Calculate the difference in milliseconds
    var difference_ms = Math.abs(date1_ms - date2_ms);
    // Convert back to days and return
    return Math.round(difference_ms / ONE_DAY);
}
var $start = false;
var $week_start = false;
var $start_date = '';
var $start_month = '';
var $start_year = '';
var $end_date = '';
var $end_month = '';
var $end_year = '';
var $start_week = '';
var current_week = '';
var guest_calender = Array();
var guest_calender_date = Array();
var guest_calender_week = Array();
var view_calender = Array();
var view_calender_date = Array();
var view_calender_week = Array();
var f = 0;
var unicor = '\u2588\u2584 \u2588\u2584\u2588 \u2588\u2580 \u2588\u2580 O \u2580\u2584\u2580\u2584\u2580     \u2588\u2580\u2588 G \u2588\u2580 \u2588 \u2580\u2584\u2580 \u2588\u2580\u2588 \n';
function reinitizeView($start, $end, $class, $element){
	for (i = 1; i <= 31; i++ ) {
		if ($($element + i).metadata().status == 'available') {									
			$($element + i).children().css('border-left-color', '#97CE68');
			$($element + i).children().css('border-bottom-color', '#97CE68');
		} else if ($($element + i).metadata().available_js_color == 'available-left-half') {
			$($element + i).children().css('border-left-color', '#FCEA88');
		} else if ($($element + i).metadata().available_js_color == 'available-bottom-half') {
			$($element + i).children().css('border-bottom-color', '#FCEA88');
		}
	}
	if (__cfg('days_calculation_mode') == 'Night') {
		$('.js-day-mouse-over-night').each(function(i) {
			_this = $(this);
			_this.children().css('border-left-color', _this.metadata().border_left);
			_this.children().css('border-bottom-color', _this.metadata().border_bottom);				
		});
		$('.js-day-mouse-over-night').removeClass('js-day-mouse-over-night');
		$('.js-day-mouse-over-night-half').each(function(i) {
			_this = $(this);
			_this.children().css('border-left-color', _this.metadata().border_left);
			_this.children().css('border-bottom-color', _this.metadata().border_bottom);				
		});
		$('.js-day-mouse-over-night-half').removeClass('js-day-mouse-over-night-half');
		$('.js-current-select-date-night').each(function(i) {
			_this = $(this);
			_this.children().css('border-left-color', _this.metadata().border_left);
			_this.children().css('border-bottom-color', _this.metadata().border_bottom);				
		});
		$('.js-current-select-date-night').removeClass('js-current-select-date-night');
		$('.js-current-select-date-night-half').each(function(i) {
			_this = $(this);
			_this.children().css('border-left-color', _this.metadata().border_left);
			_this.children().css('border-bottom-color', _this.metadata().border_bottom);				
		});
		$('.js-current-select-date-night-half').removeClass('js-current-select-date-night-half');
		if (parseInt($start) > parseInt($end)) {
			for (i = $start; i >= $end; i -- ) {
				if ($($element + i).metadata().status == 'available') {									
					if (i == $start) {
						if ($($element + i).metadata().available_js_color == 'available-left-half') {
							$($element + i).children().css('border-left-color', '#FCEA88');
						} else if ($($element + i).metadata().available_js_color == 'available-bottom-half') {
							$($element + i).children().css('border-bottom-color', '#FCEA88');
						} else {
							$($element + i).children().css('border-bottom-color', $($element + i).metadata().border_bottom);
							$($element + i).children().css('border-left-color', '#FCEA88');
						}
					} else if (i == $end) {	
						if ($($element + i).metadata().available_js_color == 'available-left-half') {
							$($element + i).children().css('border-left-color', '#FCEA88');
						} else if ($($element + i).metadata().available_js_color == 'available-bottom-half') {
							$($element + i).children().css('border-bottom-color', '#FCEA88');
						} else {
							$($element + i).children().css('border-left-color', $($element + i).metadata().border_left);
							$($element + i).children().css('border-bottom-color', '#FCEA88');
						}
					} else {
						$($element + i).children().css('border-left-color', '#FCEA88');
						$($element + i).children().css('border-bottom-color', '#FCEA88');
					}
					$($element + i).addClass($class + '-night');
				} else if ($($element + i).metadata().available_js_color == 'available-left-half') {
					$($element + i).children().css('border-left-color', '#FCEA88');
				} else if ($($element + i).metadata().available_js_color == 'available-bottom-half') {
					$($element + i).children().css('border-bottom-color', '#FCEA88');
				} else {
					return false;
				}
			}
		} else if (parseInt($start) < parseInt($end)) {
			for (i = $start; i <= $end; i ++ ) {
				if ($($element + i).metadata().status == 'available') {
					if (i == $start) {
						if ($($element + i).metadata().available_js_color == 'available-left-half') {
							$($element + i).children().css('border-left-color', '#FCEA88');
						} else if ($($element + i).metadata().available_js_color == 'available-bottom-half') {
							$($element + i).children().css('border-bottom-color', '#FCEA88');
						} else {
							$($element + i).children().css('border-left-color', $($element + i).metadata().border_left);
							$($element + i).children().css('border-bottom-color', '#FCEA88');
						}
					} else if (i == $end) {
						if ($($element + i).metadata().available_js_color == 'available-left-half') {
							$($element + i).children().css('border-left-color', '#FCEA88');
						} else if ($($element + i).metadata().available_js_color == 'available-bottom-half') {
							$($element + i).children().css('border-bottom-color', '#FCEA88');
						} else {
							$($element + i).children().css('border-bottom-color', $($element + i).metadata().border_bottom);
							$($element + i).children().css('border-left-color', '#FCEA88');
						}
					} else {
						$($element + i).children().css('border-left-color', '#FCEA88');
						$($element + i).children().css('border-bottom-color', '#FCEA88');
					}
					$($element + i).addClass($class + '-night');
				} else if ($($element + i).metadata().available_js_color == 'available-left-half') {
					$($element + i).children().css('border-left-color', '#FCEA88');
				} else if ($($element + i).metadata().available_js_color == 'available-bottom-half') {
					$($element + i).children().css('border-bottom-color', '#FCEA88');
				} else {
					return false;
				}
			}
		}
	} else {
		$str = '';
		$start = parseInt($start);
		$end = parseInt($end);
		if ($start >= $end) {
			for (i = $start; i >= $end; i-- ) {
				if (view_calender[i][3] == 'available') {	
					if($str == ''){
						$str = $element + i ;
					}
					else{
						$str = $str + ', '+ $element + i ;	
					}
				}
				else{
					break;
				}
			}
		}
		else if ($start < $end) {
			for (i = $start; i <= $end; i++ ) {
				if (view_calender[i][3] == 'available') {
					if($str == ''){
						$str = $element + i ;
					}
					else{
						$str = $str + ', '+ $element + i ;	
					}
				}
				else{
					break;
				}
			}
		}	
		if($str != ''){
			$('.js-day-mouse-over').removeClass('js-day-mouse-over');
			$('.' + $class).removeClass($class);
			$($str).addClass($class);
		}
	}
}
function reinitizeweekView($start, $end, $class, $element){
	$str = '';
	$start = parseInt($start);
	$end = parseInt($end);
	$('.js-guest-week-mouseover').each(function(i) {
		_this = $(this);
		_this.children().css('border-left-color', _this.metadata().border_left);
		_this.children().css('border-bottom-color', _this.metadata().border_bottom);
	});
	$(".js-guest-week-mouseover").removeClass('js-guest-week-mouseover');
	if ($start >= $end) {
		for (i = $start; i >= $end; i -- ) {
			if (guest_calender_week[i][3] != 'undefined' && guest_calender_week[i][3] != ''){
				if (guest_calender_week[i][3] == 'available') {
					if (i == $start) {
						$($element + i).children().css('border-left-color', '#FCEA88');
					} else if (i == $end) {
						$($element + i).children().css('border-bottom-color', '#FCEA88');
					} else {
						$($element + i).children().css('border-left-color', '#FCEA88');
						$($element + i).children().css('border-bottom-color', '#FCEA88');
					}
					$($element + i).addClass('js-guest-week-mouseover');
					$($element + i).addClass('js-guest-current-select-date');
				}
				else{
					break;
				}
			}
		}
	}
	else if ($start < $end) {
		for (i = $start; i <= $end; i++ ) {
			if (guest_calender_week[i][3] != 'undefined' && guest_calender_week[i][3] != ''){
				if (guest_calender_week[i][3] == 'available') {
					if (i == $start) {
						$($element + i).children().css('border-bottom-color', '#FCEA88');
					} else if (i == $end) {
						$($element + i).children().css('border-left-color', '#FCEA88');
					} else {
						$($element + i).children().css('border-left-color', '#FCEA88');
						$($element + i).children().css('border-bottom-color', '#FCEA88');
					}
					$($element + i).addClass('js-guest-week-mouseover');
					$($element + i).addClass('js-guest-current-select-date');
				}
				else{
					break;
				}
			}
		}
	}	
}

function updatePrice($checkin, $checkout, $property_id, $guest, $type, no_of_days, guest, per_guest_amount, commisssion_amount) {
	$('.js-booking-block').block();
    var price = '';
	var param = [ { name: "checkin", value: $checkin },
                { name: "checkout", value: $checkout },
				 { name: "property_id", value: $property_id },
                { name: "guest", value: $guest },
                { name: "type", value: $type }
                ];
    $.ajax( {
        type: 'POST',
        url: __cfg('path_relative') + 'properties/update_price',
        data: param,
        cache: false,
        success: function(responses) {
			total_guest_amount = parseFloat((guest * per_guest_amount) * no_of_days);
			price = parseFloat(responses-total_guest_amount);
			var security_deposit=0;
			if ($('.js-property-desposit-amount', '#properties-view').is('.js-property-desposit-amount')) {
				security_deposit=parseFloat($('.js-property-desposit-amount').html());
			}
            subtotal = parseFloat(price + total_guest_amount);
            servicetax = 0;
            if (subtotal != 0 && commisssion_amount != 0) {
                servicetax = parseFloat(subtotal * (commisssion_amount / 100));
            }
            total_amount = parseFloat(servicetax + subtotal+security_deposit);
            $('.js-property-no_day-night').html(no_of_days);
            $('.js-property-per-night-amount').html(price.toFixed(2));
            $('.js-property-guest-amount').html(total_guest_amount.toFixed(2));
            $('.js-property-subtotal-amount').html(subtotal.toFixed(2));
            $('.js-property-servicetax-amount').html(servicetax.toFixed(2));
            $('.js-property-total-amount').html(total_amount.toFixed(2));
			$('.js-booking-block').unblock();
			$('.js-highlight').stop().animate({backgroundColor:'#FCEA88'}, 800, function() {
				$('.js-highlight').animate({backgroundColor:'#F6F6F6'}, 800);
			});
        }
    });
	return false;
}

(function($) {
	$.fn.productCalculation = function() {		
		$this = $('.js-price-for-product');
		price = '';
		date1 = new Date($('#PropertyUserCheckinYear').val() + '/' + $('#PropertyUserCheckinMonth').val() + '/' + $('#PropertyUserCheckinDay').val());
		date2 = new Date($('#PropertyUserCheckoutYear').val() + '/' + $('#PropertyUserCheckoutMonth').val() + '/' + $('#PropertyUserCheckoutDay').val());
		$checkin = $('#PropertyUserCheckinYear').val() + '-' + $('#PropertyUserCheckinMonth').val() + '-' + $('#PropertyUserCheckinDay').val();
		$checkout = $('#PropertyUserCheckoutYear').val() + '-' + $('#PropertyUserCheckoutMonth').val() + '-' + $('#PropertyUserCheckoutDay').val();
		$property_id = $('#PropertyUserPropertyId').val();	
		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth()+1;
		var curr_year = d.getFullYear();
		if (curr_date < 10) {
			curr_date='0'+curr_date;
		}
		if (curr_month < 10) {
			curr_month='0'+curr_month;
		}
		var curent_date=curr_year+'-'+curr_month+'-'+curr_date;
		if (date1<=date2 &&  $checkin >= curent_date) {
			no_of_days = days_between(date1, date2);
			if (__cfg('days_calculation_mode') == 'Day') {
				no_of_days ++;	
			}				
		} else {
			no_of_days = 0;
		}
		no_of_guest_user = parseInt($('#PropertyUserGuests').val());
		commisssion_amount = (isNaN(parseFloat($this.metadata().property_commission_amount))) ? 0: parseFloat($this.metadata().property_commission_amount);
		property_guest_user = (isNaN(parseInt($this.metadata().additional_guest))) ? 0 : parseInt($this.metadata().additional_guest);
		per_guest_amount = (isNaN(parseInt($this.metadata().additional_guest_price))) ? 0 : parseInt($this.metadata().additional_guest_price);
		guest = total_guest_amount = 0;
		guest = (no_of_guest_user == 0) ? property_guest_user: (no_of_guest_user - property_guest_user);
		guest = (guest < 0) ? 0: guest;
		if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {
			price = updatePrice($checkin, $checkout, $property_id, no_of_guest_user, 'night', no_of_days, guest, per_guest_amount, commisssion_amount);
		}
		if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {
		   price = parseFloat(updatePrice($checkin, $checkout, $property_id, no_of_guest_user, 'week', no_of_days, guest, per_guest_amount, commisssion_amount));
			week = Math.round(no_of_days / 7);
		}
		if ($('#PropertyUserBookingOptionPricePerMonth').is(':checked')) {
			price = parseFloat(updatePrice($checkin, $checkout, $property_id, no_of_guest_user, 'month', no_of_days, guest, per_guest_amount, commisssion_amount));
		}
		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth()+1;
		var curr_year = d.getFullYear();
		if (curr_date < 10) {
			curr_date='0'+curr_date;
		}
		if (curr_month < 10) {
			curr_month='0'+curr_month;
		}
		var curent_date=curr_year+'-'+curr_month+'-'+curr_date;
		if ($checkin<=$checkout && $checkin >=curent_date) {
			$('#js-checkinout-date').html(date('F d, Y', new Date($('#PropertyUserCheckinYear').val() + '/' + $('#PropertyUserCheckinMonth').val() + '/' + $('#PropertyUserCheckinDay').val())) + ' to ' + date('F d, Y', new Date($('#PropertyUserCheckoutYear').val() + '/' + $('#PropertyUserCheckoutMonth').val() + '/' + $('#PropertyUserCheckoutDay').val())));
		} else {
			$('#js-checkinout-date').html('Invalid date selection');
		}
		return false;
    };
	$.fn.productGuestFullCalenderLoad = function() {
		if($('td.js-guest-day-booking', 'div#js-ajax-modal').is('td.js-guest-day-booking')){
					guest_calender_date = new Array();
					$("td.js-guest-day-booking").each(function(i) {
						guest_calender[$(this).metadata().cell] = new Array( $(this).metadata().date, $(this).metadata().month, $(this).metadata().year,  $(this).metadata().status, $(this).metadata().cell );
						temp_date = $(this).metadata().year + '/' +$(this).metadata().month + '/' + $(this).metadata().date;
						guest_calender_date[temp_date] = $(this).metadata().cell;
					});
        }
		if($('td.js-guest-week-booking', 'div#js-ajax-modal').is('td.js-guest-week-booking ')){
					$("td.js-guest-week-booking").each(function(i) {
						guest_calender_week[$(this).metadata().week] = new Array( $(this).metadata().start_date, $(this).metadata().end_date, $(this).metadata().price,  $(this).metadata().status, $(this).metadata().week );
					});
        }
		if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {
			checkin_date = $('#PropertyUserCheckinYear').val() + '/' + parseInt($('#PropertyUserCheckinMonth').val(), 10) + '/' + parseInt($('#PropertyUserCheckinDay').val(), 10);
			checkout_date = $('#PropertyUserCheckoutYear').val() + '/' + parseInt($('#PropertyUserCheckoutMonth').val(), 10) + '/' + parseInt($('#PropertyUserCheckoutDay').val(), 10);
			checkin = new Date(checkin_date);
			checkout = new Date(checkout_date);
			var checkin_ms = checkin.getTime();
			var checkout_ms = checkout.getTime();
			var start_date_cal_date =  guest_calender[0][2] + '/' + parseInt(guest_calender[0][1], 10) + '/' + parseInt(guest_calender[0][0], 10);
			var start_date_cal =  new Date(start_date_cal_date);
			length_arr = (guest_calender.length) - 1;
			var end_date_cal_date = guest_calender[length_arr][2] + '/' + parseInt(guest_calender[length_arr][1], 10) + '/' + parseInt(guest_calender[length_arr][0], 10);		
			var end_date_cal =  new Date(end_date_cal_date);
			var start_date_cal_ms = start_date_cal.getTime();
			var end_date_cal_ms = end_date_cal.getTime();
			$starting_point = $end_point = 0;
			if( (start_date_cal_ms <= checkin_ms) && (checkout_ms <= end_date_cal_ms)){
				$starting_point = guest_calender_date[checkin_date];
				$end_point = guest_calender_date[checkout_date];
			}
			else if( (start_date_cal_ms <= checkin_ms) && (end_date_cal_ms <= checkout_ms)){
				$starting_point = guest_calender_date[checkin_date];
				$end_point = guest_calender_date[checkout_date];
			}
			if( ($starting_point != 0) || ($end_point != 0))
			{
				reinitize($starting_point, $end_point, 'js-guest-current-select-date', '#guest-cell-');
			}
		}
		if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {
			temp_date = $('#PropertyUserCheckinYear').val() + '/' + parseInt($('#PropertyUserCheckinMonth').val(), 10) + '/' + parseInt($('#PropertyUserCheckinDay').val(), 10);
			temp_date1 = $('#PropertyUserCheckoutYear').val() + '/' + parseInt($('#PropertyUserCheckoutMonth').val(), 10) + '/' + parseInt($('#PropertyUserCheckoutDay').val(), 10);
			checkin = $('#PropertyUserCheckinYear').val() + '-' + $('#PropertyUserCheckinMonth').val() + '-' + $('#PropertyUserCheckinDay').val();
			checkout = $('#PropertyUserCheckoutYear').val() + '-' + $('#PropertyUserCheckoutMonth').val() + '-' + $('#PropertyUserCheckoutDay').val();
			$starting_point = $end_point = -1;
			if(guest_calender_date[temp_date] || guest_calender_date[temp_date1]){
				for(i=0 ; i < guest_calender_week.length; i++){
					if(guest_calender_week[i][0] == checkin && $starting_point == -1){
						$starting_point = guest_calender_week[i][4];
					}
					if(guest_calender_week[i][1] == checkout){
						$end_point = guest_calender_week[i][4];
					}
				}
				if( ($starting_point != -1) && ($end_point != -1))
					reinitizeweekView($starting_point, $end_point, 'js-guest-current-select-week', '#guest-week-');
			}
		}
		
		return false;
    };
	
	
	$.fn.eachdaytooltipsadd = function() {
		if($('td.js-month-booking', 'body').is('td.js-month-booking')){	
			$("td.js-month-booking").each(function (i) {
				$this = $(this);
				if ($this.metadata().status != undefined) {
					$this.children().attr('title', $this.metadata().status);
					$this.children().attr('data-original-title', $this.metadata().status);					
					//$this.children().addClass('js-bootstrap-tooltip');
				}
			  });
		}
		return false;
    };
})
(jQuery);
