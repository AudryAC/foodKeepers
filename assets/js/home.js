var BarsChart = (function() {
	var $chart = $('#chart-bars');
	// Init chart
	function initChart($chart) {
		// Create chart
		var ordersChart = new Chart($chart, {
			type: 'bar',
			data: {
				labels: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				datasets: [{
					label: 'Sales',
					data: [25, 20, 30, 22, 17, 29]
				}]
			}
		});
		// Save to jQuery object
		$chart.data('chart', ordersChart);
	}
	// Init chart
	if ($chart.length) {
		initChart($chart);
	}
})();

var SalesChart = (function() {
	// Variables
	var $chart = $('#chart-sales');
	// Methods
	function init($this) {
		var salesChart = new Chart($this, {
			type: 'line',
			options: {
				scales: {
					yAxes: [{
						gridLines: {
							color: Charts.colors.gray[200],
							zeroLineColor: Charts.colors.gray[200]
						},
						ticks: {

						}
					}]
				}
			},
			data: {
				labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				datasets: [{
					label: 'Performance',
					data: [0, 20, 10, 30, 15, 40, 20, 60, 60]
				}]
			}
		});
		// Save to jQuery object
		$this.data('chart', salesChart);
	};
	// Events
	if ($chart.length) {
		init($chart);
	}

})();
