
<?php include 'Seller.php' ?>

<script>

	var pesanan_status = ''
	
	class SellerHome {
		constructor()
		{
			this.load()
		}
		load()
		{
			var data = {
				client_token: $jp_client_token
			}
			callApi('seller/dashboard/',data,function(res){
				if (res.Error) {

				}else{
					var val = res.Data

					$('.total_ulasan').html(val.total_ulasan)
					$('.total_komplain').html(val.total_komplain)
					$('.total_produk').html(val.total_produk)
					$('.total_pesanan').html(val.total_pesanan)
					$('.order--status--filter .menunggu_diproses').html(val.menunggu_diproses)
					$('.order--status--filter .diproses').html(val.diproses)
					$('.order--status--filter .dikirim').html(val.dikirim)
					$('.order--status--filter .selesai').html(val.selesai)
					$('.order--status--filter .dibatalkan').html(val.dibatalkan)

				}
			})
		}
		pesanan(page = 1,keyword = '',status = 'all')
		{
			var data = {
				client_token: $jp_client_token,
				page: page,
				status: status,
				keyword: keyword
			}

			callApi('seller/dashboard/pesanan/',data,function(res){
				var output = ''
				if (res.Error) {
					$('#Pagination').html('')
					output += `<div class="card">
									<div class="card-body d-flex align-items-center justify-content-center">
										<div class="order-empty text-center">
											<img src="<?= base_url() ?>assets/img/default/no-order.png" class="w-25">
											<h6 class="mt-3 fw-600">${res.Message}</h6>
											<small>Anda tidak memiliki pesanan</small>
										</div>
									</div>
								</div>`
				}else{
					var result = res.Data,
						pagination = res.Pagination
					$.each(result,function(index,data){
						var status_class = ''
						if (data.status == "Belum dibayar") {
							status_class =  'text-warning';
						}else if (data.status == "Dibayar") {
							status_class =  'text-success';
						}else if (data.status == "Dibatalkan") {
							status_class =  'text-danger';
						}

						output += `<div class="order--list-item mb-3">
										<div class="order--list-item_header">
											<div class="fs-13 text-secondary date--created">${data.tanggal}</div>
										</div>
										<div class="order--list-item_body">
											<div class="row">
												<div class="col-md-3 border-right mb-2 mb-lg-0">
													<div class="fs-14 fw-600">${data.no_invoice}</div>
												</div>
												<div class="col-md-5 border-right mb-2 mb-lg-0">
													<div class="fs-13 fw-400">
														Status
													</div>
													<h6 class="fw-600 fs-14 ${status_class}">${data.status}</h6>
													<div class="fs-13 fw-400">
														Alamat Penerima
													</div>
													<h6 class="fs-13 mb-1"><strong>${data.penerima_nama}</strong> (${data.alamat_penerima_nama})</h6>
													<h6 class="fw-400 fs-12 mb-0 text-secondary">
														${data.alamat_penerima}<br>
														${data.alamat_kecamatan_nama}, ${data.alamat_kabupaten_nama}<br>
														${data.alamat_provinsi_nama}<br>
														Telepon/Handphone: ${data.penerima_no_telepon}
													</h6>
												</div>
												<div class="col-md-4">
													<div class="fs-13 fw-400">
														Total Belanja
													</div>
													<h5 class="fw-600 text-orange fs-15">Rp ${rupiah(data.total_bayar)}</h5>
													<h6 class="fw-600 fs-14">${data.detail_status}</h6>
												</div>
											</div>
										</div>
										<div class="order--list-item_footer border-top text-center text-lg-right">
											<button class="btn btn-sm btn-orange mb-2" onclick="redirect('seller/penjualan/detail/${data.no_transaksi}')"><i class="fal fa-info"></i> Detail Pesanan</button>
										</div>
									</div>`
					})
					var next = ''
					if (parseInt(pagination.Halaman) < parseInt(pagination.Jml_halaman)) {
						next += `<button class="btn btn-outline-primary" onclick="seller_home.pesanan(${parseInt(pagination.Halaman) + 1})"><i class="fal fa-angle-double-dow"></i>	Lihat Lainnya</button>`
					}else{
						next += `<button class="btn btn-outline-secondary" disabled><i class="fal fa-ban"></i> Sudah yang terakhir</button>`
					}
					$('#Pagination').html(next)

				}
				if (status == pesanan_status) {
					$('#order--list').append(output)
				}else{
					$('#order--list').html(output)
				}
				pesanan_status = status
			})
		}
	}

	var seller_home = new SellerHome

	$(document).on("click", ".order--status--filter .btn_filter:not(.active)", function (e) {
		e.preventDefault()

		var status = $(this).attr('data-status');
		$(this).addClass('active')
		$('.order--status--filter .btn_filter').not($(this)).removeClass('active')

		seller_home.pesanan(1,'',status)

	})

	$('.order--status--filter .btn_filter[data-status="all"]').trigger('click')

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

		callApi("seller/dashboard/chart", {
			client_token: $jp_client_token
		}, res => {

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