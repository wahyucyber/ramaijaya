<?php include 'Adm.php' ?>

<script>

	class Dashboard {
		constructor()
		{
			this.load()
		}
		load()
		{
			callApi('admin/dashboard/',null,function(res){
				if (res.Error) {

				}else{
					var result = res.Data[0]

					$('.dashboard--page .belum-dibayar').html(result.menunggu_dibayar)
					$('.dashboard--page .menunggu-diproses').html(result.menunggu_diproses)
					$('.dashboard--page .diproses').html(result.diproses)
					$('.dashboard--page .dikirim').html(result.dikirim)
					$('.dashboard--page .diterima').html(result.selesai)
					$('.dashboard--page .dibatalkan').html(result.dibatalkan)
					$('.dashboard--page .total-pesanan').html(result.total_pesanan)
					$('.dashboard--page .total-produk').html(result.total_produk)
					$('.dashboard--page .total-produk-diblokir').html(result.total_produk_diblokir)
					$('.dashboard--page .total-ulasan').html(result.total_ulasan)
					$('.dashboard--page .total-komplain').html(result.total_komplain)
				}
			})
		}
	}

	var dashboard = new Dashboard

	'use strict';

	window.chartColors = {
		red: 'rgb(255, 99, 132)',
		orange: 'rgb(255, 159, 64)',
		yellow: 'rgb(255, 205, 86)',
		green: 'rgb(75, 192, 192)',
		blue: 'rgb(54, 162, 235)',
		purple: 'rgb(153, 102, 255)',
		grey: 'rgb(201, 203, 207)'
	};

	(function(global) {
		var MONTHS = [
			'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'September',
			'October',
			'November',
			'December'
		];

		var COLORS = [
			'#4dc9f6',
			'#f67019',
			'#f53794',
			'#537bc4',
			'#acc236',
			'#166a8f',
			'#00a950',
			'#58595b',
			'#8549ba'
		];

		var Samples = global.Samples || (global.Samples = {});
		var Color = global.Color;

		Samples.utils = {
			// Adapted from http://indiegamr.com/generate-repeatable-random-numbers-in-js/
			srand: function(seed) {
				this._seed = seed;
			},

			rand: function(min, max) {
				var seed = this._seed;
				min = min === undefined ? 0 : min;
				max = max === undefined ? 1 : max;
				this._seed = (seed * 9301 + 49297) % 233280;
				return min + (this._seed / 233280) * (max - min);
			},

			numbers: function(config) {
				var cfg = config || {};
				var min = cfg.min || 0;
				var max = cfg.max || 1;
				var from = cfg.from || [];
				var count = cfg.count || 8;
				var decimals = cfg.decimals || 8;
				var continuity = cfg.continuity || 1;
				var dfactor = Math.pow(10, decimals) || 0;
				var data = [];
				var i, value;

				for (i = 0; i < count; ++i) {
					value = (from[i] || 0) + this.rand(min, max);
					if (this.rand() <= continuity) {
						data.push(Math.round(dfactor * value) / dfactor);
					} else {
						data.push(null);
					}
				}

				return data;
			},

			labels: function(config) {
				var cfg = config || {};
				var min = cfg.min || 0;
				var max = cfg.max || 100;
				var count = cfg.count || 8;
				var step = (max - min) / count;
				var decimals = cfg.decimals || 8;
				var dfactor = Math.pow(10, decimals) || 0;
				var prefix = cfg.prefix || '';
				var values = [];
				var i;

				for (i = min; i < max; i += step) {
					values.push(prefix + Math.round(dfactor * i) / dfactor);
				}

				return values;
			},

			months: function(config) {
				var cfg = config || {};
				var count = cfg.count || 12;
				var section = cfg.section;
				var values = [];
				var i, value;

				for (i = 0; i < count; ++i) {
					value = MONTHS[Math.ceil(i) % 12];
					values.push(value.substring(0, section));
				}

				return values;
			},

			color: function(index) {
				return COLORS[index % COLORS.length];
			},

			transparentize: function(color, opacity) {
				var alpha = opacity === undefined ? 0.5 : 1 - opacity;
				return Color(color).alpha(alpha).rgbString();
			}
		};

		// DEPRECATED
		window.randomScalingFactor = function() {
			return Math.round(Samples.utils.rand(-100, 100));
		};

		// INITIALIZATION

		Samples.utils.srand(Date.now());

		// Google Analytics
		/* eslint-disable */
		if (document.location.hostname.match(/^(www\.)?chartjs\.org$/)) {
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-28909194-3', 'auto');
			ga('send', 'pageview');
		}
		/* eslint-enable */

	}(this));

	function createConfig(details, label, data = []) {
		return {
			type: 'line',
			data: {
				labels: label,
				datasets: data
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: details.label,
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
			}
		};
	}

	function load_chart() {

		callApi("admin/dashboard/chart", null, res => {

			$("span.penjualan-hari-ini").html(res.Data.statistik.penjualan_hari_ini)
			$("span.penjualan-minggu-ini").html(res.Data.statistik.penjualan_minggu_ini)
			$("span.penjualan-bulan-ini").html(res.Data.statistik.penjualan_bulan_ini)
			$("span.total-penjualan").html(res.Data.statistik.total_penjualan)

			var label = [];
			var belum_dibayar = [];
			var menunggu_diproses = [];
			var diproses = [];
			var dikirim = [];
			var diterima = [];
			var dibatalkan = [];
			var cart = [];

			$.each(res.Data.label, function (index, key) { 
				label.push(key);
			});

			var steppedLineSettings = [{
				steppedLine: false,
				label: 'Menampilkan data tahun <?php echo date('Y'); ?>',
				color: window.chartColors.red
			}];

			$.each(res.Data.belum_dibayar, function(index, val) {
				belum_dibayar.push(val.total);
			});

			$.each(res.Data.menunggu_diproses, function(index, val) {
				menunggu_diproses.push(val.total);
			});

			$.each(res.Data.diproses, function(index, val) {
				diproses.push(val.total);
			});

			$.each(res.Data.dikirim, function(index, val) {
				dikirim.push(val.total);
			});

			$.each(res.Data.diterima, function(index, val) {
				diterima.push(val.total);
			});

			$.each(res.Data.dibatalkan, function(index, val) {
				dibatalkan.push(val.total);
			});

			cart = [
				{
					label: 'Belum dibayar',
					steppedLine: steppedLineSettings[0].speedLine,
					data: belum_dibayar,
					borderColor: window.chartColors.grey,
					fill: false
				},
				{
					label: 'Menunggu diproses',
					steppedLine: steppedLineSettings[0].speedLine,
					data: menunggu_diproses,
					borderColor: window.chartColors.orange,
					fill: false
				},
				{
					label: 'Diproses',
					steppedLine: steppedLineSettings[0].speedLine,
					data: diproses,
					borderColor: window.chartColors.blue,
					fill: false
				},
				{
					label: 'Dikrim',
					steppedLine: steppedLineSettings[0].speedLine,
					data: dikirim,
					borderColor: window.chartColors.purple,
					fill: false
				},
				{
					label: 'Diterima',
					steppedLine: steppedLineSettings[0].speedLine,
					data: diterima,
					borderColor: window.chartColors.green,
					fill: false
				},
				{
					label: 'Dibatalkan',
					steppedLine: steppedLineSettings[0].speedLine,
					data: dibatalkan,
					borderColor: window.chartColors.red,
					fill: false
				}
			];

			steppedLineSettings.forEach(function(details) {
				var ctx = document.getElementById('canvas').getContext('2d');
				var config = createConfig(details, label, cart);
				new Chart(ctx, config);
			});
		})
	}
	load_chart();
	
</script>