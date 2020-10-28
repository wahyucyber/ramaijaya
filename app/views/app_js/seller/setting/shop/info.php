
<?php include __DIR__.'/../../Seller.php' ?>

<script>

	
	class SettingShop {

		constructor()
		{
			this.TokoId = null
			this.merchant = false
			this.run()
		}

		run()
		{
			var data = {
				client_token: $jp_client_token
			}
			callApi('seller/shop/',data,res => {

				if (res.Error) {
					notifAlert(res.Message,'error')
				}else{
					var data = res.Data,
						status = ''

					this.TokoId = data.id_toko

					$('#content--shop .banner img').attr('src',data.banner_toko? base_url(data.banner_toko) : base_url('assets/img/default/seller_no_cover_3.png'))

					$('#content--shop .logo img').attr('src',data.logo_toko? data.logo_toko : base_url('assets/img/default/shop.png'));

					$('.nama_toko-title').html(`<i class="fad fa-store text-orange"></i> ${data.nama_toko}`)

					$('#content--shop input.nama_toko').val(data.nama_toko)

					$('#content--shop input.slogan').val(data.slogan? data.slogan : '')

					$('#content--shop textarea.deskripsi').val(data.deskripsi? data.deskripsi : '')
					$('#content--shop input.bank').val(data.bank_nama);
					$('#content--shop input.atasnama').val(data.bank_atasnama);
					$('#content--shop input.no-rekening').val(data.bank_rekening);

					if (data.power_merchant != 0 && data.power_merchant != null) {
						$('.lock-screen').remove()
						this.merchant = true
					}

					if (data.status_toko == 1) {

						if (data.buka_toko == 0) {

							var tanggal = `-`;
							var catatan = ``;
							var tutup_sekarang = ``;

							if(data.akhir_tutup != null) {
								tanggal = `${data.akhir_tutup}`;
							}

							if(data.catatan_tutup != null) {
								catatan = data.catatan_tutup;
							}

							if(data.buka_toko == 0) {
								tutup_sekarang = `checked`;
							}

							status += `<div class="fs-14 mb-3"><img src="${base_url('assets/img/default/icon-shop-close.png')}" alt="" width="35px" /> Ditutup</div>
											<div class="fs-12 text-muted">
												Tutup sampai: ${tanggal}
											</div>
											<div class="fs-12 text-muted mb-2">
												Catatan: ${catatan}
											</div>
											<div id="btn-close-edit" class="shop-status-edit collapse show">
												<button class="btn btn-success btn-sm _status--buka-toko"><i class="fal fa-check-circle"></i>	Buka Toko</button>
											</div>`;

						}else{

							var tanggal = `-`;
							var catatan = ``;
							var tutup_sekarang = ``;

							if(data.akhir_tutup != null) {
								tanggal = `${data.akhir_tutup}`;
							}

							if(data.catatan_tutup != null) {
								catatan = data.catatan_tutup;
							}

							if(data.buka_toko == 0) {
								tutup_sekarang = `checked`;
							}

							status += `<div class="fs-14 mb-3"><img src="${base_url('assets/img/default/icon-shop-open.png')}" alt="" width="35px" /> Buka</div>
											<div class="card shadow-sm" id="close-shop">
												<div class="card-body">
													<h4 class="fs-13 mb-3">Atur jadwal Tutup Toko </h4>
													<div class="form-group row">
														<div class="col-md-6">
															<label>Tanggal</label>
															<input type="text" name="" id="" class="form-control _daterangepicker">
															<input type="hidden" name="" class="_daterangepicker--dari-tanggal">
															<input type="hidden" name="" class="_daterangepicker--ke-tanggal">
														</div>
													</div>
													<div class="form-group">
														<div class="custom-control custom-checkbox">
														  <input type="checkbox" id="remember" ${tutup_sekarang} class="custom-control-input tutup-sekarang">
														  <label class="custom-control-label fs-13" for="remember">Tutup Sekarang</label>
														</div>
													</div>
													<div class="form-group">
														<label>Catatan</label>
														<textarea rows="1" class="form-control catatan-tutup">${catatan}</textarea>
													</div>
													<button class="btn btn-sm btn-success _set--status-toko"><i class="fal fa-cog"></i>	Atur</button>
													<button class="btn btn-sm btn-warning _set--reset-status-toko"><i class="fal fa-sync"></i>	Reset</button>
												</div>
											</div>`

						}

					}else{

						status += `<div class="text-danger fs-13 mb-2">Belum Aktif</div>
				              	<p class="fs-13 mb-2 text-muted">Ayo tambah produk pertama kamu sekarang untuk mengaktifkan toko, dan segera dapatkan penjualan.</p>
				              	<a href="${base_url('seller/product/add')}" class="text-success fs-13"><i class="fal fa-plus"></i> Tambah Produk</a>`

					}

					$('#content--shop .shop-status').html(status)

					var config_daterangepicker = {
						autoUpdateInput: false,
						locale: {
							cancelLabel: 'Clear'
						},
						ranges: {
							'Today': [moment(), moment()],
							'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
							'Last 7 Days': [moment().subtract(6, 'days'), moment()],
							'Last 30 Days': [moment().subtract(29, 'days'), moment()],
							'This Month': [moment().startOf('month'), moment().endOf('month')],
							'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
						}
					};

					if(data.awal_tutup != null && data.akhir_tutup != null) {
						config_daterangepicker = {
							autoUpdateInput: false,
							startDate: data.awal_tutup == null ? "" : setting_shop._date(data.awal_tutup),
							endDate: data.akhir_tutup == null ? "" : setting_shop._date(data.akhir_tutup),
							locale: {
								cancelLabel: 'Clear'
							},
							ranges: {
								'Today': [moment(), moment()],
								'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
								'Last 7 Days': [moment().subtract(6, 'days'), moment()],
								'Last 30 Days': [moment().subtract(29, 'days'), moment()],
								'This Month': [moment().startOf('month'), moment().endOf('month')],
								'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
							}
						}

						$("input._daterangepicker").val(setting_shop._dateFormat(data.awal_tutup) + ' - ' + setting_shop._dateFormat(data.akhir_tutup));
						$("input[type=hidden]._daterangepicker--dari-tanggal").val(setting_shop._dateFormat(data.awal_tutup));
						$("input[type=hidden]._daterangepicker--ke-tanggal").val(setting_shop._dateFormat(data.akhir_tutup));
					}
					$('input._daterangepicker').daterangepicker(config_daterangepicker);

					$('input._daterangepicker').on('apply.daterangepicker', function(ev, picker) {
						$(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
						$("input[type=hidden]._daterangepicker--dari-tanggal").val(picker.startDate.format('YYYY-MM-DD'));
						$("input[type=hidden]._daterangepicker--ke-tanggal").val(picker.endDate.format('YYYY-MM-DD'));
					});

					$('input._daterangepicker').on('cancel.daterangepicker', function(ev, picker) {
						$(this).val(``);
						$("input[type=hidden]._daterangepicker--dari-tanggal").val(``);
						$("input[type=hidden]._daterangepicker--ke-tanggal").val(``);
					});
				}

			})
		}

		_date(date) {
			let dt = new Date(date);
			let d = dt.getDate();
			let m = dt.getMonth() + 1;
			let y = dt.getFullYear();

			return m+"/"+d+"/"+y;
		}

		_dateFormat(date) {
			let dt = new Date(date);
			let d = dt.getDate();
			let m = dt.getMonth() + 1;
			let y = dt.getFullYear();

			return y+"/"+m+"/"+d;
		}

		edit()
		{
			var data = {
				client_token: $jp_client_token,
				nama: $("input.nama_toko").val(),
				slogan: $('#content--shop input.slogan').val(),
				deskripsi: $('#content--shop textarea.deskripsi').val(),
				bank: $("input.bank").val(),
				atasnama: $("input.atasnama").val(),
				rekening: $("input.no-rekening").val()
			}

			callApi('seller/shop/edit/',data,res => {
				let message = res.Message;
				if (res.Error) {
					notifAlert(message, "error", 5000);
				}else{
					notifAlert(message, "success", 5000);
					setting_shop.run()
				}
			})
		}

		logo(logo) {
			callApi("seller/shop/upload_logo", {
				client_token: $jp_client_token,
				logo: logo
			}, res => {
				let message = res.Message;
				if (res.Error) {
					notifAlert(message, "error", 5000);
				}else{
					notifAlert(message, "success", 5000);
					setting_shop.run()
				}
			})
		}

		banner(banner) {
			callApi("seller/shop/upload_banner", {
				client_token: $jp_client_token,
				banner: banner
			}, res => {
				let message = res.Message;
				if (res.Error) {
					notifAlert(message, "error", 5000);
				}else{
					notifAlert(message, "success", 5000);
					setting_shop.run()
				}
			})
		}

		status(params) {
			callApi("seller/shop/status_toko", params, e => {
				let message = e.Message;
				if (e.Error) {
					notifAlert(message, "error", 5000);
				}else{
					notifAlert(message, "success", 5000);
					setting_shop.run()
				}
			});
		}

	}

	var setting_shop = new SettingShop

	var upload_image = new UploadImage

	$(document).on('click', 'button.browse-banner', function(event) {
		$('#content--shop input.data-banner').trigger('click')
	});

	$(document).on('change', 'input.data-banner', function(event) {
		upload_image.options(1024,258)
		upload_image.get_base64(this,$('#content--shop .banner img'),event, res => {
			setting_shop.banner(res);
		})
	});

	$('#content--shop .header-shop').on('click', 'button.browse-logo', function(event) {
		event.preventDefault();
		$('#content--shop input.data-logo').trigger('click')
	});

	$('#content--shop .header-shop').on('change', 'input.data-logo', function(event) {
		upload_image.options(500,500)
		upload_image.get_base64(this,$('#content--shop .header-shop .logo img'),event, res => {
			setting_shop.logo(res);
		})
	});

	$(document).on("submit", "form.update-profil-toko", function () {
		setting_shop.edit();

		return false;
	})

	$(document).on("click", "button._set--status-toko", function() {
		let dari_tanggal = $("input._daterangepicker--dari-tanggal").val();
		let ke_tanggal = $("input._daterangepicker--ke-tanggal").val();
		let tutup = $("input[type=checkbox].tutup-sekarang").prop('checked') ? 1 : 0;
		let catatan = $("textarea.catatan-tutup").val();

		setting_shop.status({
			client_token: $jp_client_token,
			dari_tanggal: dari_tanggal,
			ke_tanggal: ke_tanggal,
			tutup: tutup,
			catatan: catatan
		});
	})

	$(document).on("click", "button._status--buka-toko", function() {
		setting_shop.status({
			client_token: $jp_client_token
		});
	})

	$(document).on("click", "button._set--reset-status-toko", function() {
		$("input._daterangepicker").val(``);
		$("input._daterangepicker--dari-tanggal").val(``);
		$("input._daterangepicker--ke-tanggal").val(``);
		$("input[type=checkbox].tutup-sekarang").prop('checked', false);
		$("textarea.catatan-tutup").val(``);
	})

</script>