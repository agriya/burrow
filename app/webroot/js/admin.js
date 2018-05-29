function loopy_call(hidden) { (function loopy() {
        var objs = hidden.removeClass('needsSparkline');
        hidden = hidden.filter('.needsSparkline');
        if (objs.length) {
            objs.css( {
                'display': '',
                'visibility': 'hidden'
            });
            $.sparkline_display_visible();
            objs.css( {
                'display': 'none',
                'visibility': ''
            });
            setTimeout(loopy, 250);
        }
    })
    ();
}
function xload(is_after_ajax) {
    var so = (is_after_ajax) ? ':not(.xltriggered)': '';
	$('.js-sparkline-chart' + so).each(function(e) {
		var sparklines = $(this).sparkline('html', {
			type: 'bar',
			height: '40',
			barWidth: 5,
			barColor: $(this).metadata().colour,
			negBarColor: '#',
			stackedBarColor: []
			});
		var hidden = sparklines.parent().filter(':hidden').addClass('needsSparkline');
		loopy_call(hidden);
		sparklines.parent().filter(':hidden').show();
	}).addClass('xltriggered');
	$('.js-line-chart' + so).each(function(e) {
		var sparkliness = $(this).sparkline('html', {
			type: 'line',
			width: '32',
			height: '16',
			lineColor: $(this).metadata().colour,
			fillColor: $(this).metadata().colour,
			lineWidth: 0,
			spotColor: undefined,
			minSpotColor: undefined,
			maxSpotColor: undefined,
			highlightSpotColor: undefined,
			highlightLineColor: undefined,
			spotRadius: 0
		});
		var hidden = sparkliness.parent().filter(':hidden').addClass('needsSparkline');
		loopy_call(hidden);
		sparkliness.parent().filter(':hidden').show();
	}).addClass('xltriggered');
	$('div.js-cache-load' + so).each(function() {
		var data_url = $(this).metadata().data_url;
		var data_load = $(this).metadata().data_load;
		$('.' + data_load).block();
		$.get(__cfg('path_relative') + data_url, function(data) {
			$('.' + data_load).html(data);
			$('.' + data_load).unblock();
			return false;
		});
	}).addClass('xltriggered');
} (function() {
    var $dc = $(document);
    $dc.ready(function($) {
		xload(false);
        $dc.on('click', '.accordion-menu', function(e) {
            if ($('.haccordion').hasClass('hpanel')) {
                $('.collapse').collapse('hide');
                $('.accordion-toggle i').removeClass('icon-minus');
                $('.haccordion').removeClass('hpanel');
            } else $('.haccordion').addClass('hpanel');
        }).on('click', '.js-toggle-icon', function(e) {
            $(this).children('i').toggleClass('icon-minus');
        }).on('click', 'table#js-expand-table tr.js-odd', function(e) {
            display = $(this).next('tr').css('display');
            if ($(this).hasClass('inactive-record')) {
                $(this).addClass('inactive-record-backup');
                $(this).removeClass('inactive-record');
            } else if ($(this).hasClass('inactive-record-backup')) {
                $(this).addClass('inactive-record');
                $(this).removeClass('inactive-record-backup');
            }
            $this = $(this);
            if ($(this).hasClass('active-row')) {
                $(this).next('tr').toggle().prev('tr').removeClass('active-row');
                $(this).next('tr').css('display', 'none');
                $(this).next('tr').addClass('hide')
                } else {
                $(this).next('tr').toggle().prev('tr').addClass('active-row');
                $(this).next('tr').css('display', 'table-row');
                $(this).next('tr').removeClass('hide')
                }
            $(this).find('.icon-caret-down').toggleClass('icon-caret-up');
        }).on('click', '.js-link', function(e) {
            $this = $(this);
            dataloading = $this.metadata().data_load;
            $('.' + dataloading).block();
            $.get($this.attr('href'), function(data) {
                $('.' + dataloading).html(data);
                $('.' + dataloading).unblock();
            });
            return false;
        }).on('click', 'span.js-chart-showhide', function(e) {
            dataurl = $(this).metadata().dataurl;
            dataloading = $(this).metadata().dataloading;
            classes = $(this).attr('class');
            classes = classes.split(' ');
            if ($.inArray('down-arrow', classes) != -1) {
                $this = $(this);
                $(this).removeClass('down-arrow');
                if ((dataurl != '') && (typeof(dataurl) != 'undefined')) {
                    $this.parents('div.js-responses').eq(0).block();
                    $.get(__cfg('path_relative') + dataurl, function(data) {
                        $this.parents('div.js-responses').eq(0).html(data);
                        $this.parents('div.js-responses').eq(0).unblock();
                    });
                }
                $(this).addClass('up-arrow');
            } else {
                $(this).removeClass('up-arrow');
                $(this).addClass('down-arrow');
            }
            $('#' + $(this).metadata().chart_block).slideToggle('slow');
        }).on('change', 'form select.js-chart-autosubmit', function(e) {
            var $this = $(this).parents('form');
            $this.block();
            $this.ajaxSubmit( {
                beforeSubmit: function(formData, jqForm, options) {
                    $this.block();
                },
                success: function(responseText, statusText) {
                    $this.parents('div.js-responses').eq(0).html(responseText);
                    $this.unblock();
                }
            });
            return false;
        }).on('click', '.js-admin-update-status', function(e) {
			$this = $(this);
			var status = '';
			if ($this.parents('td').hasClass('js-payment-status')) {
				status = 1;
			}
			$this.html('<img src="' + __cfg('path_absolute') + 'img/small_loader.gif">');
			$.get($this.prop('href'), function(data) {
				$this.parent('td').html(data);
				if (status == 1) {
					$.p.fwarninginfochange('.js-wallet' + so + ', .js-payment-all' + so);
				}
			});
			return false;
		}).on('click', 'a.js-dragdrop', function(e) {
            var $this = $(this);
            var current_content_rel = jQuery(this).attr('rel');
            if (current_content_rel == 'reorder') {
                $('table.' + $this.metadata().met_tab + ' tr').removeClass('altrow');
                $('.' + $this.metadata().met_tab).addClass($this.metadata().met_drag_cls);
                $('.' + $this.metadata().met_drag_cls).tableDnD();
                if ($this.metadata().met_data_action == 'js-rank') {
                    $this.text('I am done reranking');
                } else {
                    $this.text(__l('I am done reordering'));
                }
                $this.attr('rel', 'reordering');
            } else {
                $('.' + $this.metadata().met_tab).removeClass($this.metadata().met_drag_cls);
                $('.js-dragdrop').text(__l('Reorder'));
                $('.js-dragdrop').attr('rel', 'reorder');
                var position = 0;
                $('table.' + $this.metadata().met_tab + ' tr').each(function() {
                    $thistr = $(this);
                    $('.' + $this.metadata().met_tab_order, $thistr).val(position);
                    $thistr.addClass(position % 2 ? 'altrow': '');
                    position += 1;
                });
                $('div.' + $this.metadata().met_form_cls).block();
                $('form.' + $this.metadata().met_form_cls).submit();
                $('div.' + $this.metadata().met_form_cls).unblock();
                $('.' + $this.metadata().met_tab).removeClass($this.metadata().met_drag_cls);
            }
            return false;
        }).on('click', '.js-live-tour', function(e) {
			bootstro.start();
			return false;
		}).on('click', '.bootstro-goto', function(e) {
			bootstro.start();
			bootstro.go_to(1);
			return false;
		});
    }).ajaxStop(function() {
        xload(true);
    });
})
();