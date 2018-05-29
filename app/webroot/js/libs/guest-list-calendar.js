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
var $full_start = false;
var $first_select = '';
var $full_start_date = '';
var $full_start_month = '';
var $full_start_year = '';
var $full_end_date = '';
var $full_end_month = '';
var $full_end_year = '';
var $full_start_week = '';
var $full_current_week = '';
var unicor = '\u2588\u2584 \u2588\u2584\u2588 \u2588\u2580 \u2588\u2580 O \u2580\u2584\u2580\u2584\u2580     \u2588\u2580\u2588 G \u2588\u2580 \u2588 \u2580\u2584\u2580 \u2588\u2580\u2588 \n';
function reinitize($start, $end, $class, $element){
	$start=parseInt($start);
	$end=parseInt($end);
	if (__cfg('days_calculation_mode') == 'Night') {
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
						if ($($element + i).metadata().available_js_color == 'available-left-half') {
							$($element + i).children().css('border-left-color', '#FCEA88');
						} else if ($($element + i).metadata().available_js_color == 'available-bottom-half') {
							$($element + i).children().css('border-bottom-color', '#FCEA88');
						} else {
							$($element + i).children().css('border-left-color', '#FCEA88');
							$($element + i).children().css('border-bottom-color', '#FCEA88');
						}
					}
					$($element + i).addClass($class + '-night');
				} else if ($($element + i).metadata().available_js_color == 'available-bottom-half') {
					$($element + i).children().css('border-bottom-color', '#FCEA88');
					$($element + i).addClass('js-guest-day-mouseover-night-half');
					return false;
				} else if ($($element + i).metadata().available_js_color == 'available-left-half') {
					$($element + i).children().css('border-left-color', '#FCEA88');
					$($element + i).addClass('js-guest-day-mouseover-night-half');
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
						if ($($element + i).metadata().available_js_color == 'available-left-half') {
							$($element + i).children().css('border-left-color', '#FCEA88');
						} else if ($($element + i).metadata().available_js_color == 'available-bottom-half') {
							$($element + i).children().css('border-bottom-color', '#FCEA88');
						} else {
							$($element + i).children().css('border-left-color', '#FCEA88');
							$($element + i).children().css('border-bottom-color', '#FCEA88');
						}
					}
					$($element + i).addClass($class + '-night');
				} else if ($($element + i).metadata().available_js_color == 'available-left-half') {
					$($element + i).children().css('border-left-color', '#FCEA88');
					$($element + i).addClass('js-guest-day-mouseover-night-half');
					return false;
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
				if (guest_calender[i][3] == 'available') {
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
				if (guest_calender[i][3] == 'available') {
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
			$('.js-guest-day-mouseover').removeClass('js-guest-day-mouseover');
			$('.' +$class).removeClass($class);
			$($str).addClass($class);
		}
	}
}

function selectDateGuestCalaender($start, $end, $class){
	$str = '';
	if (guest_calender[$start][3] == 'available') {
		$full_start_date = parseInt(guest_calender[$start][0]);
		$full_start_month = parseInt(guest_calender[$start][1]);
		$full_start_year = parseInt(guest_calender[$start][2]);
	}
	if (__cfg('days_calculation_mode') == 'Night') {
		if ($start >= $end) {
			for (i = $start; i >= $end; i -- ) {
				var stop = false;
				if ($('.guest-cell-' + i).metadata().status == 'available') {
					if(i == $start) {
						if ($('.guest-cell-' + i).metadata().available_js_color == 'available-left-half') {
							$('#guest-cell-' + i).children().css('border-left-color', '#FCEA88');
						} else if ($('.guest-cell-' + i).metadata().available_js_color == 'available-bottom-half') {
							$('#guest-cell-' + i).children().css('border-bottom-color', '#FCEA88');
						} else {
							$('#guest-cell-' + i).children().css('border-left-color', '#FCEA88');
							$('#guest-cell-' + i).children().css('border-bottom-color', '#FCEA88');
						}
					} else if (i == $end) {
						if ($('.guest-cell-' + i).metadata().available_js_color == 'available-left-half') {
							$('#guest-cell-' + i).children().css('border-left-color', '#FCEA88');
						} else if ($('.guest-cell-' + i).metadata().available_js_color == 'available-bottom-half') {
							$('#guest-cell-' + i).children().css('border-bottom-color', '#FCEA88');
						} else {
							$('#guest-cell-' + i).children().css('border-left-color', '#FCEA88');
							$('#guest-cell-' + i).children().css('border-bottom-color', '#FCEA88');
						}
					} else {
						if ($('.guest-cell-' + i).metadata().available_js_color == 'available-left-half') {
							$('#guest-cell-' + i).children().css('border-left-color', '#FCEA88');
						} else if ($('.guest-cell-' + i).metadata().available_js_color == 'available-bottom-half') {
							$('#guest-cell-' + i).children().css('border-bottom-color', '#FCEA88');
						} else {
							$('#guest-cell-' + i).children().css('border-bottom-color', '#FCEA88');
							$('#guest-cell-' + i).children().css('border-left-color', '#FCEA88');
						}
					}
					$('#guest-cell-' + i).addClass('js-guest-current-select-date-night');
					$end_month = parseInt($('.guest-cell-' + i).metadata().month);
					$end_date = parseInt($('.guest-cell-' + i).metadata().date);
					$end_year = parseInt($('.guest-cell-' + i).metadata().year);
					stop = true;
				} else if ($('.guest-cell-' + i).metadata().available_js_color == 'available-left-half') {
					$('#guest-cell-' + i).children().css('border-left-color', '#FCEA88');
					$end_month = parseInt($('.guest-cell-' + i).metadata().month);
					$end_date = parseInt($('.guest-cell-' + i).metadata().date);
					$end_year = parseInt($('.guest-cell-' + i).metadata().year);
					$('#guest-cell-' + i).addClass('js-guest-current-select-date-night-half');
					stop = true;
				} else if ($('.guest-cell-' + i).metadata().available_js_color == 'available-bottom-half') {
					$('#guest-cell-' + i).children().css('border-bottom-color', '#FCEA88');
					$end_month = parseInt($('.guest-cell-' + i).metadata().month);
					$end_date = parseInt($('.guest-cell-' + i).metadata().date);
					$end_year = parseInt($('.guest-cell-' + i).metadata().year);
					$('#guest-cell-' + i).addClass('js-guest-current-select-date-night-half');
					stop = true;
				} else {
				   return false;
				}
				if (stop) {
					if ($full_start_date != '' || $end_date != '') {
						if ($end_date == '') {
							$end_date = $full_start_date;
							$end_date = $full_start_month;
							$end_date = $full_start_year;
						}
						$('.js-guest-start-date').removeClass('js-guest-start-date');
					}
				}
			}
		} else if ($start < $end) {
			for (i = $start; i <= $end; i ++ ) {
				var stop = false;
				if ($('.guest-cell-' + i).metadata().status == 'available') {
					if(i == $start) {
						if ($('.guest-cell-' + i).metadata().available_js_color == 'available-left-half') {
							$('#guest-cell-' + i).children().css('border-left-color', '#FCEA88');
						} else if ($('.guest-cell-' + i).metadata().available_js_color == 'available-bottom-half') {
							$('#guest-cell-' + i).children().css('border-bottom-color', '#FCEA88');
						} else {
							$('#guest-cell-' + i).children().css('border-left-color', '#FCEA88');
							$('#guest-cell-' + i).children().css('border-bottom-color', '#FCEA88');
						}
					} else if (i == $end) {
						if ($('.guest-cell-' + i).metadata().available_js_color == 'available-left-half') {
							$('#guest-cell-' + i).children().css('border-left-color', '#FCEA88');
						} else if ($('.guest-cell-' + i).metadata().available_js_color == 'available-bottom-half') {
							$('#guest-cell-' + i).children().css('border-bottom-color', '#FCEA88');
						} else {
							$('#guest-cell-' + i).children().css('border-left-color', '#FCEA88');
							$('#guest-cell-' + i).children().css('border-bottom-color', '#FCEA88');
						}
					} else {
						if ($('.guest-cell-' + i).metadata().available_js_color == 'available-left-half') {
							$('#guest-cell-' + i).children().css('border-left-color', '#FCEA88');
						} else if ($('.guest-cell-' + i).metadata().available_js_color == 'available-bottom-half') {
							$('#guest-cell-' + i).children().css('border-bottom-color', '#FCEA88');
						} else {
							$('#guest-cell-' + i).children().css('border-bottom-color', '#FCEA88');
							$('#guest-cell-' + i).children().css('border-left-color', '#FCEA88');
						}
					}
					$('#guest-cell-' + i).addClass('js-guest-current-select-date-night');
					$end_month = parseInt($('.guest-cell-' + i).metadata().month);
					$end_date = parseInt($('.guest-cell-' + i).metadata().date);
					$end_year = parseInt($('.guest-cell-' + i).metadata().year);
					stop = true;
				} else if ($('.guest-cell-' + i).metadata().available_js_color == 'available-left-half') {
					$('#guest-cell-' + i).children().css('border-left-color', '#FCEA88');
					$end_month = parseInt($('.guest-cell-' + i).metadata().month);
					$end_date = parseInt($('.guest-cell-' + i).metadata().date);
					$end_year = parseInt($('.guest-cell-' + i).metadata().year);
					$('#guest-cell-' + i).addClass('js-guest-current-select-date-night-half');
					stop = true;
				} else if ($('.guest-cell-' + i).metadata().available_js_color == 'available-bottom-half') {
					$('#guest-cell-' + i).children().css('border-bottom-color', '#FCEA88');
					$end_month = parseInt($('.guest-cell-' + i).metadata().month);
					$end_date = parseInt($('.guest-cell-' + i).metadata().date);
					$end_year = parseInt($('.guest-cell-' + i).metadata().year);
					$('#guest-cell-' + i).addClass('js-guest-current-select-date-night-half');
					stop = true;
				} else {
					return false;
				}
				if (stop) {
					if ($full_start_date != '' || $end_date != '') {
						if ($end_date == '') {
							$end_date = $full_start_date;
							$end_date = $full_start_month;
							$end_date = $full_start_year;
						}
						$('.js-guest-start-date').removeClass('js-guest-start-date');
					}
				}
			}
		}
		if ($full_start_date != '' || $end_date != '') {
			if ($end_date == '') {
				$end_date = $full_start_date;
				$end_date = $full_start_month;
				$end_date = $full_start_year;
			}
		   $('.js-guest-start-date').removeClass('js-guest-start-date');
			$full_start_month = ($full_start_month < 10) ? ('0' + $full_start_month): $full_start_month;
			$end_month = ($end_month < 10) ? ('0' + $end_month): $end_month;
			$end_date = ($end_date < 10) ? ('0' + $end_date): $end_date;
			$full_start_date = ($full_start_date < 10) ? ('0' + $full_start_date): $full_start_date;
			var chk_in=new Date($full_start_year+"/"+$full_start_month+"/"+$full_start_date);
			var chk_out=new Date($end_year+"/"+$end_month+"/"+$end_date);
			if (chk_in.getTime() < chk_out.getTime()) {
				$('#PropertyUserCheckinDay').val($full_start_date);
				$('#PropertyUserCheckinMonth').val($full_start_month);
				$('#PropertyUserCheckinYear').val($full_start_year);
				$('#PropertyUserCheckoutDay').val($end_date);
				$('#PropertyUserCheckoutMonth').val($end_month);
				$('#PropertyUserCheckoutYear').val($end_year);
			} else {
				$('#PropertyUserCheckoutDay').val($full_start_date);
				$('#PropertyUserCheckoutMonth').val($full_start_month);
				$('#PropertyUserCheckoutYear').val($full_start_year);
				$('#PropertyUserCheckinDay').val($end_date);
				$('#PropertyUserCheckinMonth').val($end_month);
				$('#PropertyUserCheckinYear').val($end_year);
			}
			$('.js-price-for-product').productCalculation();
			$full_start_date = $full_start_month = $full_start_year = $end_date = $end_month = $end_year = '';
			$full_start = false;
		}
	} else {
		if ($start >= $end) {
			for (i = $start; i >= $end; i -- ) {
				if (guest_calender[i][3] == 'available') {
					if($str == ''){
						$str = '#guest-cell-' + i ;
					}
					else{
						$str = $str + ', #guest-cell-' + i ;
					}
					$full_end_date = parseInt(guest_calender[i][0]);
					$full_end_month = parseInt(guest_calender[i][1]);
					$full_end_year = parseInt(guest_calender[i][2]);
				}
				else{
					break;
				}
			}
		}
		else if ($start < $end) {
			for (i = $start; i <= $end; i++ ) {
				if (guest_calender[i][3] == 'available') {
					if($str == ''){
						$str = '#guest-cell-' + i ;
					}
					else{
						$str = $str + ', #guest-cell-' + i ;
					}
					$full_end_date = parseInt(guest_calender[i][0]);
					$full_end_month = parseInt(guest_calender[i][1]);
					$full_end_year = parseInt(guest_calender[i][2]);
				}
				else{
					break;
				}
			}
		}
		if($str != ''){
			$('.' +$class).removeClass($class);
			$($str).addClass($class);
		}
		$full_start_month = ($full_start_month < 10) ? ('0' + $full_start_month): $full_start_month;
		$full_end_month = ($full_end_month < 10) ? ('0' + $full_end_month): $full_end_month;
		$full_end_date = ($full_end_date < 10) ? ('0' + $full_end_date): $full_end_date;
		$full_start_date = ($full_start_date < 10) ? ('0' + $full_start_date): $full_start_date;
		if ($start < $end) {
			$('#PropertyUserCheckinMonth').val($full_start_month);
			$('#PropertyUserCheckinDay').val($full_start_date);
			$('#PropertyUserCheckinYear').val($full_start_year);
			$('#PropertyUserCheckoutDay').val($full_end_date);
			$('#PropertyUserCheckoutMonth').val($full_end_month);
			$('#PropertyUserCheckoutYear').val($full_end_year);
		}
		else{
			$('#PropertyUserCheckinMonth').val($full_end_month);
			$('#PropertyUserCheckoutMonth').val($full_start_month);
			$('#PropertyUserCheckoutDay').val($full_start_date);
			$('#PropertyUserCheckinDay').val($full_end_date);
			$('#PropertyUserCheckoutYear').val($full_start_year);
			$('#PropertyUserCheckinYear').val($full_end_year);
		}
	}
	$(".js-guest-start-date").removeClass('js-guest-start-date');
	viewCalenderReselect();
	$first_select = $full_start_date = $full_start_month = $full_start_year = $full_end_date = $full_end_month = $full_end_year = '';
	$full_start = false;
}

function viewCalenderReselect(){
		if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {
			checkin_date = $('#PropertyUserCheckinYear').val() + '/' + parseInt($('#PropertyUserCheckinMonth').val(), 10) + '/' + parseInt($('#PropertyUserCheckinDay').val(), 10);
			checkout_date = $('#PropertyUserCheckoutYear').val() + '/' + parseInt($('#PropertyUserCheckoutMonth').val(), 10) + '/' + parseInt($('#PropertyUserCheckoutDay').val(), 10);
			checkin = new Date(checkin_date);
			checkout = new Date(checkout_date);
			var checkin_ms = checkin.getTime();
			var checkout_ms = checkout.getTime();
			var start_date_cal_date =  view_calender[1][2] + '/' + parseInt(view_calender[1][1], 10) + '/' + parseInt(view_calender[1][0], 10);
			var start_date_cal =  new Date(start_date_cal_date);
			length_arr = view_calender.length - 1;
			var end_date_cal_date = view_calender[length_arr][2] + '/' + parseInt(view_calender[length_arr][1], 10) + '/' + parseInt(view_calender[length_arr][0], 10);
			var end_date_cal =  new Date(end_date_cal_date);
			var start_date_cal_ms = start_date_cal.getTime();
			var end_date_cal_ms = end_date_cal.getTime();
			$starting_point = $end_point = 0;
			if( (start_date_cal_ms <= checkin_ms) && (checkout_ms <= end_date_cal_ms)){
				$starting_point = view_calender_date[checkin_date];
				$end_point = view_calender_date[checkout_date];
			}
			else if( (checkin_ms  <= start_date_cal_ms) && (checkout_ms <= end_date_cal_ms)){
				$starting_point = view_calender_date[start_date_cal_date];
				$end_point = view_calender_date[checkout_date];
			}
			else if( (checkin_ms  <= start_date_cal_ms) && (end_date_cal_ms <= checkout_ms)){
				$starting_point = view_calender_date[start_date_cal_date];
				$end_point = view_calender_date[end_date_cal_date];
			}
			else if( (start_date_cal_ms <= checkin_ms) && (end_date_cal_ms <= checkout_ms) && (checkin_ms <= end_date_cal_ms)){
				$starting_point = view_calender_date[checkin_date];
				$end_point = view_calender_date[end_date_cal_date];
			}
			if (__cfg('days_calculation_mode') == 'Night') {
				reinitizeView($starting_point, $end_point, 'js-current-select-date-night', '#cell-');
			} else {
				if (($starting_point != 0) || ($end_point != 0)){
						reinitizeView($starting_point, $end_point, 'js-current-select-date', '#cell-');
				} else {
					$('.js-day-mouse-over').removeClass('js-day-mouse-over');
					$('.js-current-select-date').removeClass('js-current-select-date');
				}
			}
		}
		if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {

			temp_date = $('#PropertyUserCheckinYear').val() + '/' + parseInt($('#PropertyUserCheckinMonth').val(), 10) + '/' + parseInt($('#PropertyUserCheckinDay').val(), 10);
			temp_date1 = $('#PropertyUserCheckoutYear').val() + '/' + parseInt($('#PropertyUserCheckoutMonth').val(), 10) + '/' + parseInt($('#PropertyUserCheckoutDay').val(), 10);
			checkin = $('#PropertyUserCheckinYear').val() + '-' + $('#PropertyUserCheckinMonth').val() + '-' + $('#PropertyUserCheckinDay').val();
			checkout = $('#PropertyUserCheckoutYear').val() + '-' + $('#PropertyUserCheckoutMonth').val() + '-' + $('#PropertyUserCheckoutDay').val();
			$starting_point = $end_point = -1;
			if(view_calender_date[temp_date] || view_calender_date[temp_date1]){
				for(i=1 ; i <= view_calender_week.length; i++){
					if(view_calender_week[i]){
						if(view_calender_week[i][0] == checkin && $starting_point == -1){
							$starting_point = view_calender_week[i][4];
							$end_point = view_calender_week[i][4];
						}
						if(view_calender_week[i][1] == checkout || $starting_point != -1){
							$end_point = view_calender_week[i][4];
						}
					}
				}
				if(($starting_point != -1) || ($end_point != -1) )
					reinitizeweekView($starting_point, $end_point, 'js-current-select-week', '#week-');
				else{
					$('.js-week-mouseover').removeClass('js-week-mouseover');
					$('.js-current-select-week').removeClass('js-current-select-week');
				}
			}
			else{
				$('.js-week-mouseover').removeClass('js-week-mouseover');
				$('.js-current-select-week').removeClass('js-current-select-week');
			}
		}

}

function reinitizeweek($start, $end, $class, $element){
	$str = '';
	$start = parseInt($start);
	$end = parseInt($end);
	if ($start >= $end) {
		for (i = $start; i >= $end; i -- ) {
			if (guest_calender_week[i][3] == 'available') {

				if($str == ''){
					$str = $element + i ;
				}
				else{
					$str = $str + ', '+$element + i ;
				}
			}
			else{
				break;
			}
		}
	}
	else if ($start < $end) {
		for (i = $start; i <= $end; i++ ) {
			if (guest_calender_week[i][3] == 'available') {
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
		$('.js-guest-week-mouseover').removeClass('js-guest-week-mouseover');
		$('.' +$class).removeClass($class);
		$($str).addClass($class);
	}
}

jQuery(document).ready(function($) {
	$('div#js-ajax-modal').delegate('.js-guest-day-booking', 'click', function() {
        $this = $(this);
        if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {
			if($(".js-guest-start-date", "div#js-ajax-modal").is(".js-guest-start-date")){
				$thist = $(".js-guest-start-date", "div#js-ajax-modal");
				$full_start = true;
				$first_select = parseInt($thist.metadata().cell);
				$full_start_month = parseInt($thist.metadata().month);
				$full_start_date = parseInt($thist.metadata().date);
				$full_start_year = parseInt($thist.metadata().year);
			}
            if ($full_start == false) {
				var stop = false;
				cell = parseInt($this.metadata().cell);
                if ($this.metadata().status == 'available') {
                    $this.addClass('js-guest-start-date');
					$full_start = true;
					if (__cfg('days_calculation_mode') == 'Night') {
						$('.js-guest-current-select-date-night').each(function(i) {
							_this = $(this);
							_this.children().css('border-left-color', _this.metadata().border_left);
							_this.children().css('border-bottom-color', _this.metadata().border_bottom);
						});
						$('.js-guest-current-select-date-night').removeClass('js-guest-current-select-date-night');
						$('.js-guest-current-select-date-night-half').each(function(i) {
							_this = $(this);
							_this.children().css('border-left-color', _this.metadata().border_left);
							_this.children().css('border-bottom-color', _this.metadata().border_bottom);
						});
						$('.js-guest-current-select-date-night-half').removeClass('js-guest-current-select-date-night-half');
						$this.addClass('js-guest-current-select-date-night');
					} else {
						$(".js-guest-current-select-date").removeClass('js-guest-current-select-date');
	                    $this.addClass('js-guest-current-select-date-night-half');
					}
					stop = true;
                } else if ($this.metadata().available_js_color == 'available-left-half') {
					$('#guest-cell-' + cell).children().css('border-left-color', '#FCEA88');
					$this.addClass('js-guest-current-select-date-night-half');
					stop = true;
                } else if ($this.metadata().available_js_color == 'available-bottom-half') {
					$('#guest-cell-' + cell).children().css('border-bottom-color', '#FCEA88');
					$this.addClass('js-guest-current-select-date-night-half');
					stop = true;
				} else {
					stop = true;
				}
				if (stop) {
					$first_select = parseInt($this.metadata().cell);
                    $full_start_month = parseInt($this.metadata().month);
                    $full_start_date = parseInt($this.metadata().date);
                    $full_start_year = parseInt($this.metadata().year);
                    if ($full_end_date != '') {
                        $('#PropertyUserCheckinMonth').val($full_start_month);
                        $('#PropertyUserCheckoutMonth').val($full_start_month);
                        $('#PropertyUserCheckoutDay').val($full_start_date);
                        $('#PropertyUserCheckinDay').val($full_start_date);
                        $('#PropertyUserCheckoutYear').val($full_start_year);
                        $('#PropertyUserCheckinYear').val($full_start_year);
                        $('.js-price-for-product').productCalculation();
                    }
					$full_start = true;
				}
            } else {
                current_date = parseInt($this.metadata().cell);
				selectDateGuestCalaender($first_select, current_date, 'js-guest-current-select-date');
				//viewCalenderReselect();
				$('.js-price-for-product').productCalculation();
				$('#js-ajax-modal').modal('hide');
				return false;
            }
        } else {
            alert('Please select per night option');
        }
        return false;
    });
	$('div#js-ajax-modal').delegate('.js-guest-day-booking', 'mouseenter', function() {
		$this = $(this);
		if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {
			if (__cfg('days_calculation_mode') == 'Night') {
				var chk_class = 'js-guest-current-select-date-night';
			} else {
				var chk_class = 'js-guest-current-select-date';
			}
			if (!($this.is('.' + chk_class))) {
				if ($full_start == true) {
					current_date = parseInt($this.metadata().cell);
					if (__cfg('days_calculation_mode') == 'Night') {
						$('.js-guest-day-mouseover-night').each(function(i) {
							_this = $(this);
							_this.children().css('border-left-color', _this.metadata().border_left);
							_this.children().css('border-bottom-color', _this.metadata().border_bottom);
						});
						$('.js-guest-day-mouseover-night').removeClass('js-guest-day-mouseover-night');
						$('.js-guest-day-mouseover-night-half').each(function(i) {
							_this = $(this);
							_this.children().css('border-left-color', _this.metadata().border_left);
							_this.children().css('border-bottom-color', _this.metadata().border_bottom);
						});
						$('.js-guest-day-mouseover-night-half').removeClass('js-guest-day-mouseover-night-half');
					} else {
						$(".js-guest-day-mouseover").removeClass('js-guest-day-mouseover');
					}
					reinitize($first_select, current_date, 'js-guest-day-mouseover', '#guest-cell-');
					return false;
				} else {
					cell = parseInt($this.metadata().cell);
					if ($this.metadata().status == 'available') {
						if (__cfg('days_calculation_mode') == 'Night') {
							$('#guest-cell-' + cell).addClass('js-guest-day-mouseover-night');
							$('#guest-cell-' + cell).children().css('border-bottom-color', '#FCEA88');
							$('#guest-cell-' + cell).children().css('border-left-color', $('#guest-cell-' + cell).metadata().border_left);
						} else {
							$('#guest-cell-' + cell).addClass('js-guest-day-mouseover');
						}
					} else if ($this.metadata().available_js_color == 'available-left-half') {
						$('#guest-cell-' + cell).children().css('border-left-color', '#FCEA88');
						$('#guest-cell-' + cell).addClass('js-guest-day-mouseover-night-half');
					} else if ($this.metadata().available_js_color == 'available-bottom-half') {
						$('#guest-cell-' + cell).children().css('border-bottom-color', '#FCEA88');
						$('#guest-cell-' + cell).addClass('js-guest-day-mouseover-night-half');
					}
				}
			}
		}
        return false;
    }).delegate('td.js-guest-day-booking', 'mouseleave', function() {
		//$.doTimeout( 'hover' );
		if ($('#PropertyUserBookingOptionPricePerNight').is(':checked')) {
			$this = $(this);
			if (__cfg('days_calculation_mode') == 'Night') {
				var chk_class = 'js-guest-current-select-date-night';
			} else {
				var chk_class = 'js-guest-current-select-date';
			}
			 if (($this.metadata().status == 'available' || $this.metadata().available_js_color == 'available-left-half' || $this.metadata().available_js_color == 'available-bottom-half') && $start == false && !($this.is('.' + chk_class)) && !($this.is('.js-guest-current-select-date-night-half'))) {
				first_date['date'] = parseInt($this.metadata().cell);
				if (__cfg('days_calculation_mode') == 'Night') {
					$('#guest-cell-' + first_date['date']).removeClass('js-guest-day-mouseover-night');
					$('#guest-cell-' + first_date['date']).removeClass('js-guest-day-mouseover-night-half');
					$('#guest-cell-' + first_date['date']).children().css('border-left-color', $('#guest-cell-' + first_date['date']).metadata().border_left);
					$('#guest-cell-' + first_date['date']).children().css('border-bottom-color', $('#guest-cell-' + first_date['date']).metadata().border_bottom);
				} else {
					$('#guest-cell-' + first_date['date']).removeClass('js-guest-day-mouseover');
				}
			}
		}
  });
	$('div#js-ajax-modal').delegate('.js-guest-calender-prev, .js-guest-calender-next', 'click', function() {
        var $this = $(this);
        var url = $this.metadata().url;
        $('.modal-body').block();
        $.get(url, function(data) {
            $('.js-guest-calendar-response').html(data);
            if (data.indexOf('js-disable_monthly') != -1) {
                if ($('#PropertyUserBookingOptionPricePerMonth').is(':checked')) {
                    $('#PropertyUserBookingOptionPricePerNight').attr('checked', 'checked');
                }
                $('#PropertyUserBookingOptionPricePerMonth').attr('disabled', 'disabled');
            } else {
                $('#PropertyUserBookingOptionPricePerMonth').removeAttr("disabled");
            }
			$('td.js-month-booking').eachdaytooltipsadd();
			$('div#js-ajax-modal').productGuestFullCalenderLoad();
            $('.modal-body').unblock();
            return false;
        });
        return false;
    });
   $('div#js-ajax-modal').delegate('td.js-guest-week-booking', 'mouseenter', function() {
		$this = $(this);
		if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {
			var chk_class = 'js-guest-current-select-week';
			if (!($this.is('.' + chk_class))) {
				if ($full_start == true) {
					$full_current_week = parseInt($this.metadata().week);
					$('.js-guest-week-mouseover').each(function(i) {
						_this = $(this);
						_this.children().css('border-left-color', _this.metadata().border_left);
						_this.children().css('border-bottom-color', _this.metadata().border_bottom);
					});
					$(".js-guest-week-mouseover").removeClass('js-guest-week-mouseover');
					if ($full_start_week > $full_current_week) {
						for (i = $full_start_week; i >= $full_current_week; i -- ) {
							if ($('.guest-week-' + i).metadata().status == 'available') {
								if (i == $full_start_week) {
									$('#guest-week-' + i).children().css('border-left-color', '#FCEA88');
								} else if (i == $full_current_week) {
									$('#guest-week-' + i).children().css('border-bottom-color', '#FCEA88');
								} else {
									$('#guest-week-' + i).children().css('border-left-color', '#FCEA88');
									$('#guest-week-' + i).children().css('border-bottom-color', '#FCEA88');
								}
								$('#guest-week-' + i).addClass('js-guest-week-mouseover');
							} else {
								return false;
							}
						}
					} else if ($full_start_week < $full_current_week) {
						for (i = $full_start_week; i <= $full_current_week; i ++ ) {
						   if ($('.guest-week-' + i).metadata().status == 'available') {
								if (i == $full_start_week) {
									$('#guest-week-' + i).children().css('border-bottom-color', '#FCEA88');
								} else if (i == $full_current_week) {
									$('#guest-week-' + i).children().css('border-left-color', '#FCEA88');
								} else {
									$('#guest-week-' + i).children().css('border-left-color', '#FCEA88');
									$('#guest-week-' + i).children().css('border-bottom-color', '#FCEA88');
								}
								$('#guest-week-' + i).addClass('js-guest-week-mouseover');
							} else {
								return false;
							}
						}
					}
				}
				else{
					if ($this.metadata().status == 'available') {
						week = parseInt($this.metadata().week);
						$('#guest-week-' + week).addClass('js-guest-week-mouseover');
						$('#guest-week-' + week).children().css('border-bottom-color', '#FCEA88');
						$('#guest-week-' + week).children().css('border-left-color', $('#guest-week-' + first_date['week']).metadata().border_left);
					}
				}
			}
		}
        return false;
    }).delegate('td.js-guest-week-booking', 'mouseleave', function() {
		$this = $(this);
        if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {
            if ($this.metadata().status == 'available' && $full_start == false && !($this.is('.js-guest-current-select-week'))) {
                first_date['date'] = parseInt($this.metadata().week);
				$('#guest-week-' + first_date['date']).removeClass('js-guest-week-mouseover');
				$('#guest-week-' + first_date['date']).removeClass('js-week-mouseover');
				$('#guest-week-' + first_date['date']).children().css('border-left-color', $('#guest-week-' + first_date['date']).metadata().border_left);
				$('#guest-week-' + first_date['date']).children().css('border-bottom-color', $('#guest-week-' + first_date['date']).metadata().border_bottom);
            }
        }
        return false;
    });
	$('div#js-ajax-modal').delegate('td.js-guest-week-booking', 'click', function() {
        $this = $(this);
        if ($('#PropertyUserBookingOptionPricePerWeek').is(':checked')) {
            if ($full_start == false) {
                if ($this.metadata().status == 'available') {
                    $this.addClass('js-guest-start-week');
					$full_start = true;
					$(".js-guest-current-select-week").removeClass('js-guest-current-select-week');
                    $full_start_week = $(this).metadata().week;
                    $this.addClass('js-guest-current-select-week');
                    first_date = ($(this).metadata().start_date).split('-');

                    $full_start_month = parseInt(first_date[1]);
                    $full_start_date = parseInt(first_date[2]);
                    $full_start_year = parseInt(first_date[0]);
                    temp_dates = ($this.metadata().end_date).split('-');
                    $temp_month = parseInt(temp_dates[1]);
                    $temp_date = parseInt(temp_dates[2]);
                    $temp_year = parseInt(temp_dates[0]);

                    $full_start_month = ($full_start_month < 10) ? ('0' + $full_start_month): $full_start_month;
                    $full_start_date = ($full_start_date < 10) ? ('0' + $full_start_date): $full_start_date;
                    $temp_month = ($temp_month < 10) ? ('0' + $temp_month): $temp_month;
                    $temp_date = ($temp_date < 10) ? ('0' + $temp_date): $temp_date;

					$(".js-guest-current-select-date").removeClass('js-guest-current-select-date');
					$('.js-guest-start-date').removeClass('js-guest-start-date');

                    $('#PropertyUserCheckinDay').val($full_start_date);
                    $('#PropertyUserCheckinMonth').val($full_start_month);
                    $('#PropertyUserCheckinYear').val($full_start_year);
                    $('#PropertyUserCheckoutDay').val($temp_date);
                    $('#PropertyUserCheckoutMonth').val($temp_month);
                    $('#PropertyUserCheckoutYear').val($temp_year);
                    $('.js-price-for-product').productCalculation();
					viewCalenderReselect();
                }
            } else {
                $full_current_week = parseInt($this.metadata().week);
				if ($full_start_week >= $full_current_week) {
                    for (i = $full_start_week; i >= $full_current_week; i -- ) {
                        if ($('.guest-week-' + i).metadata().status != 'available') {
							$full_current_week = i+1;
						}
					}
				}
				else if ($full_start_week < $full_current_week) {
                    for (i = $full_start_week; i <= $full_current_week; i ++ ) {
                        if ($('.guest-week-' + i).metadata().status != 'available') {
							$full_current_week = i-1;
						}
					}
				}
                if ($full_start_week >= $full_current_week) {
                    for (i = $full_start_week; i >= $full_current_week; i -- ) {
                        if ($('.guest-week-' + i).metadata().status == 'available') {
                            $('#guest-week-' + i).addClass('js-guest-current-select-week');
                            first_date = ($this.metadata().end_date).split('-');
                            $full_end_month = parseInt(first_date[1]);
                            $full_end_date = parseInt(first_date[2]);
                            $full_end_year = parseInt(first_date[0]);
                        } else {
                            if ($full_start_week != '' && $full_current_week != '') {
								$(".js-guest-week-booking").each(function(i) {
									if ($(this).is(".js-guest-start-week")) {
										$(this).removeClass('js-guest-start-week');
									}
								});
                                if ($full_start_week < $full_current_week) {
                                    first_date = ($('.guest-week-' + $full_start_week).metadata().start_date).split('-');
                                    $full_start_month = parseInt(first_date[1], 10);
                                    $full_start_date = parseInt(first_date[2], 10);
                                    $full_start_year = parseInt(first_date[0]);
                                    second_date = ($('.guest-week-' + $full_current_week).metadata().end_date).split('-');
                                    $full_end_month = parseInt(second_date[1], 10);
                                    $full_end_date = parseInt(second_date[2], 10);
                                    $full_end_year = parseInt(second_date[0]);
                                } else {
                                    second_date = ($('.guest-week-' + $full_current_week).metadata().start_date).split('-');
                                    first_date = ($('.guest-week-' + $full_start_week).metadata().end_date).split('-');
                                    $full_start_month = parseInt(first_date[1], 10);
                                    $full_start_date = parseInt(first_date[2], 10);
                                    $full_start_year = parseInt(first_date[0]);
                                    $full_end_month = parseInt(second_date[1], 10);
                                    $full_end_date = parseInt(second_date[2], 10);
                                    $full_end_year = parseInt(second_date[0]);
                                }
                                $full_start_month = ($full_start_month < 10) ? ('0' + $full_start_month): $full_start_month;
                                $full_end_month = ($full_end_month < 10) ? ('0' + $full_end_month): $full_end_month;
                                $full_end_date = ($full_end_date < 10) ? ('0' + $full_end_date): $full_end_date;
                                $full_start_date = ($full_start_date < 10) ? ('0' + $full_start_date): $full_start_date;

                                if ($full_start_week <= $full_current_week) {
                                    $('#PropertyUserCheckinDay').val($full_start_date);
                                    $('#PropertyUserCheckinMonth').val($full_start_month);
                                    $('#PropertyUserCheckinYear').val($full_start_year);
                                    $('#PropertyUserCheckoutDay').val($full_end_date);
                                    $('#PropertyUserCheckoutMonth').val($full_end_month);
                                    $('#PropertyUserCheckoutYear').val($full_end_year);
                                } else {
                                    $('#PropertyUserCheckoutDay').val($full_start_date);
                                    $('#PropertyUserCheckoutMonth').val($full_start_month);
                                    $('#PropertyUserCheckoutYear').val($full_start_year);
                                    $('#PropertyUserCheckinDay').val($full_end_date);
                                    $('#PropertyUserCheckinMonth').val($full_end_month);
                                    $('#PropertyUserCheckinYear').val($full_end_year);
                                }
								viewCalenderReselect();
                                $('.js-price-for-product').productCalculation();
                                $full_start_date = $full_start_month = $full_start_year = $full_end_date = $full_end_month = $full_end_year = $full_start_week = $full_current_week = '';
                                $full_start = false;
								  $('#js-ajax-modal').modal('hide');
                            }
                            return false;
                        }
                    }
                } else if ($full_start_week < $full_current_week) {
                    for (i = $full_start_week; i <= $full_current_week; i ++ ) {
                        if ($('.guest-week-' + i).metadata().status == 'available') {
                            $('#guest-week-' + i).addClass('js-guest-current-select-week');
                            first_date = ($('.guest-week-' + i).metadata().end_date).split('-');
                            $full_end_month = parseInt(first_date[1]);
                            $full_end_date = parseInt(first_date[2]);
                            $full_end_year = parseInt(first_date[0]);
                        } else {
                            if ($full_start_week != '' && $full_current_week != '') {
								$(".js-guest-start-week").removeClass('js-guest-start-week');
                                if ($full_start_week <= $full_current_week) {
                                    first_date = ($('.guest-week-' + $full_start_week).metadata().start_date).split('-');
                                    $full_start_month = parseInt(first_date[1], 10);
                                    $full_start_date = parseInt(first_date[2], 10);
                                    $full_start_year = parseInt(first_date[0]);
                                    second_date = ($('.guest-week-' + $full_current_week).metadata().end_date).split('-');
                                    $full_end_month = parseInt(second_date[1], 10);
                                    $full_end_date = parseInt(second_date[2], 10);
                                    $full_end_year = parseInt(second_date[0]);
                                } else {
                                    second_date = ($('.guest-week-' + $full_current_week).metadata().start_date).split('-');
                                    first_date = ($('.guest-week-' + $full_start_week).metadata().end_date).split('-');
                                    $full_start_month = parseInt(first_date[1], 10);
                                    $full_start_date = parseInt(first_date[2], 10);
                                    $full_start_year = parseInt(first_date[0]);
                                    $full_end_month = parseInt(second_date[1], 10);
                                    $full_end_date = parseInt(second_date[2], 10);
                                    $full_end_year = parseInt(second_date[0]);
                                }
                                $full_start_month = ($full_start_month < 10) ? ('0' + $full_start_month): $full_start_month;
                                $full_end_month = ($full_end_month < 10) ? ('0' + $full_end_month): $full_end_month;
                                $full_end_date = ($full_end_date < 10) ? ('0' + $full_end_date): $full_end_date;
                                $full_start_date = ($full_start_date < 10) ? ('0' + $full_start_date): $full_start_date;
                                if ($full_start_week <= $full_current_week) {
                                    $('#PropertyUserCheckinDay').val($full_start_date);
                                    $('#PropertyUserCheckinMonth').val($full_start_month);
                                    $('#PropertyUserCheckinYear').val($full_start_year);
                                    $('#PropertyUserCheckoutDay').val($full_end_date);
                                    $('#PropertyUserCheckoutMonth').val($full_end_month);
                                    $('#PropertyUserCheckoutYear').val($full_end_year);
                                } else {
                                    $('#PropertyUserCheckoutDay').val($full_start_date);
                                    $('#PropertyUserCheckoutMonth').val($full_start_month);
                                    $('#PropertyUserCheckoutYear').val($full_start_year);
                                    $('#PropertyUserCheckinDay').val($full_end_date);
                                    $('#PropertyUserCheckinMonth').val($full_end_month);
                                    $('#PropertyUserCheckinYear').val($full_end_year);
                                }
								viewCalenderReselect();
                                $('.js-price-for-product').productCalculation();
                                $full_start_date = $full_start_month = $full_start_year = $full_end_date = $full_end_month = $full_end_year = $full_start_week = $full_current_week = '';
                                $full_start = false;
								  $('#js-ajax-modal').modal('hide');
                            }
                            return false;
                        }
                    }
                }
                if ($full_start_week != '' && $full_current_week != '') {
					$(".js-guest-start-week").removeClass('js-guest-start-week');
                    if ($full_start_week <= $full_current_week) {
                        first_date = ($('.guest-week-' + $full_start_week).metadata().start_date).split('-');
                        $full_start_month = parseInt(first_date[1], 10);
                        $full_start_date = parseInt(first_date[2], 10);
                        $full_start_year = parseInt(first_date[0]);
                        second_date = ($('.guest-week-' + $full_current_week).metadata().end_date).split('-');
                        $full_end_month = parseInt(second_date[1], 10);
                        $full_end_date = parseInt(second_date[2], 10);
                        $full_end_year = parseInt(second_date[0]);
                    } else {
                        second_date = ($('.guest-week-' + $full_current_week).metadata().start_date).split('-');
                        first_date = ($('.guest-week-' + $full_start_week).metadata().end_date).split('-');
                        $full_start_month = parseInt(first_date[1], 10);
                        $full_start_date = parseInt(first_date[2], 10);
                        $full_start_year = parseInt(first_date[0]);
                        $full_end_month = parseInt(second_date[1], 10);
                        $full_end_date = parseInt(second_date[2], 10);
                        $full_end_year = parseInt(second_date[0]);
                    }
                    $full_start_month = ($full_start_month < 10) ? ('0' + $full_start_month): $full_start_month;
                    $full_end_month = ($full_end_month < 10) ? ('0' + $full_end_month): $full_end_month;
                    $full_end_date = ($full_end_date < 10) ? ('0' + $full_end_date): $full_end_date;
                    $full_start_date = ($full_start_date < 10) ? ('0' + $full_start_date): $full_start_date;
                    if ($full_start_week <= $full_current_week) {
                        $('#PropertyUserCheckinDay').val($full_start_date);
                        $('#PropertyUserCheckinMonth').val($full_start_month);
                        $('#PropertyUserCheckinYear').val($full_start_year);
                        $('#PropertyUserCheckoutDay').val($full_end_date);
                        $('#PropertyUserCheckoutMonth').val($full_end_month);
                        $('#PropertyUserCheckoutYear').val($full_end_year);
                    } else {
                        $('#PropertyUserCheckoutDay').val($full_start_date);
                        $('#PropertyUserCheckoutMonth').val($full_start_month);
                        $('#PropertyUserCheckoutYear').val($full_start_year);
                        $('#PropertyUserCheckinDay').val($full_end_date);
                        $('#PropertyUserCheckinMonth').val($full_end_month);
                        $('#PropertyUserCheckinYear').val($full_end_year);
                    }
					viewCalenderReselect();
                    $('.js-price-for-product').productCalculation();
                    $full_start_date = $full_start_month = $full_start_year = $full_end_date = $full_end_month = $full_end_year = $full_start_week = $full_current_week = '';
                    $full_start = false;
					  $('#js-ajax-modal').modal('hide');
                }
            }
        } else {
            alert('Please select per week option');
        }
        return false;
    });

});