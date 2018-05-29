(function() {
	function xload(is_after_ajax) {
		var so = (is_after_ajax) ? ':not(.xltriggered)': '';
		$('.js-load-line-graph' + so).each(function() {
			$this = $(this);
			data_container = $this.metadata().data_container;
			chart_container = $this.metadata().chart_container;
			chart_title = $this.metadata().chart_title;
			chart_y_title = $this.metadata().chart_y_title;
			var table = document.getElementById(data_container);
			options = {
				colors: [
					'#50b432',
					'#058dc7',
					'#ed561b',
					'#f83a22',
					'#fad165',
					'#a47ae2',
					'#f691b2',
					'#ac725e',
					'#42d692',
					'#ffee34'
				],
				chart: {
					renderTo: chart_container,
					defaultSeriesType: 'line'
				},
				title: {
					text: chart_title
				},
				xAxis: {
					tickWidth: 0,
					labels: {
						rotation :- 90
					}
				},
				yAxis: {
					title: {
						text: chart_y_title
					}
				},
				tooltip: {
					crosshairs: true,
					shared: true
				},
				series: {
					cursor: 'pointer',
					marker: {
						lineWidth: 1
					}
				}
			};
			// the categories
			options.xAxis.categories = [];
			jQuery('tbody th', table).each(function(i) {
				options.xAxis.categories.push(this.innerHTML);
			});
			// the data series
			options.series = [];
			jQuery('tr', table).each(function(i) {
				var tr = this;
				jQuery('th, td', tr).each(function(j) {
					if (j > 0) {
						// skip first column
						if (i == 0) {
							// get the name and init the series
							options.series[j - 1] = {
								name: this.innerHTML,
								data: []
								};
						} else {
							// add values
							options.series[j - 1].data.push(parseFloat(this.innerHTML));
						}
					}
				});
			});
			var chart = new Highcharts.Chart(options);
		}).addClass('xltriggered');
		$('.js-load-pie-chart').each(function() {
			$this = $(this);
			data_container = $this.metadata().data_container;
			chart_container = $this.metadata().chart_container;
			chart_title = $this.metadata().chart_title;
			chart_y_title = $this.metadata().chart_y_title;
			var table = document.getElementById(data_container);
			options = {
				colors: [
					'#50b432',
					'#058dc7',
					'#ed561b',
					'#f83a22',
					'#fad165',
					'#a47ae2',
					'#f691b2',
					'#ac725e',
					'#42d692',
					'#ffee34'
				],
				chart: {
					renderTo: chart_container,
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: chart_title
				},
				tooltip: {
					formatter: function() {
						return '<b>' + this.point.name + '</b>: ' + (this.percentage).toFixed(2) + ' %';
					}
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: false
						},
						showInLegend: true
					}
				},
				series: [ {
					type: 'pie',
					name: chart_y_title,
					data: []
					}]
				};
			options.series[0].data = [];
			jQuery('tr', table).each(function(i) {
				var tr = this;
				jQuery('th, td', tr).each(function(j) {
					if (j == 0) {
						options.series[0].data[i] = [];
						options.series[0].data[i][j] = this.innerHTML
					} else {
						// add values
						options.series[0].data[i][j] = parseFloat(this.innerHTML);
					}
				});
			});
			var chart = new Highcharts.Chart(options);
		}).addClass('xltriggered');
		$('.js-load-column-chart').each(function() {
			$this = $(this);
			data_container = $this.metadata().data_container;
			chart_container = $this.metadata().chart_container;
			chart_title = $this.metadata().chart_title;
			chart_y_title = $this.metadata().chart_y_title;
			var table = document.getElementById(data_container);
			seriesType = 'column';
			if ($this.metadata().series_type) {
				seriesType = $this.metadata().series_type;
			}
			options = {
				colors: [
					'#50b432',
					'#058dc7',
					'#ed561b',
					'#f83a22',
					'#fad165',
					'#a47ae2',
					'#f691b2',
					'#ac725e',
					'#42d692',
					'#ffee34'
				],
				chart: {
					renderTo: chart_container,
					defaultSeriesType: seriesType,
					margin: [50, 50, 100, 80]
					},
				title: {
					text: chart_title
				},
				xAxis: {
					categories: [],
					labels: {
						rotation :- 90,
						align: 'right',
						style: {
							font: 'normal 13px Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: chart_y_title
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					formatter: function() {
						return '<b>' + this.x + '</b><br/>' + Highcharts.numberFormat(this.y, 1);
					}
				},
				series: [ {
					name: 'Data',
					data: [],
					dataLabels: {
						enabled: true,
						rotation :- 90,
						color: '#FFFFFF',
						align: 'right',
						x :- 3,
						y: 10,
						formatter: function() {
							return '';
						},
						style: {
							font: 'normal 13px Verdana, sans-serif'
						}
					}
				}]
				};
			// the categories
			options.xAxis.categories = [];
			options.series[0].data = [];
			jQuery('tr', table).each(function(i) {
				var tr = this;
				jQuery('th, td', tr).each(function(j) {
					if (j == 0) {
						options.xAxis.categories.push(this.innerHTML);
					} else {
						// add values
						options.series[0].data.push(parseFloat(this.innerHTML));
					}
				});
			});
			chart = new Highcharts.Chart(options);
		}).addClass('xltriggered');
	}
	var unicor = 'C \u2588\u2580 O \u2580\u2584\u2580\u2584\u2580 \u2584\u2588 F \u2588\u2584\u2588 \u2588\u2580\u2588 \u2584\u2588   \u2588\u2580\u2588 G \u2588\u2580 \u2588 \u2580\u2584\u2580 \u2588\u2580\u2588';
    var $dc = $(document);
	$dc.ready(function($) {
		xload(false);
	}).ajaxStop(function() {
        xload(true);
    });
})();