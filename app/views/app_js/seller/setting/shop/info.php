
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

							status += `<div class="fs-14 mb-3"><img src="${base_url('assets/img/default/icon-shop-close.png')}" alt="" width="35px" /> Ditutup</div>
											<div class="fs-12 text-muted">
												Tutup sampai: 6/5/2020
											</div>
											<div class="fs-12 text-muted mb-2">
												Catatan: Catatan alasan tutup toko
											</div>
											<div id="btn-close-edit" class="shop-status-edit collapse show">
												<button class="btn btn-success btn-sm"><i class="fal fa-check-circle"></i>	Buka Toko</button>
												<button class="btn btn-light btn-sm" data-toggle="collapse" data-target=".shop-status-edit" aria-controls="close-shop btn-close-edit"><i class="fal fa-edit"></i>	Ubah jadwal Tutup Toko</button>
											</div>
											<div class="card shadow-sm collapse shop-status-edit" id="close-shop">
												<div class="card-body">
													<h4 class="fs-13 mb-3">Atur jadwal Tutup Toko </h4>
													<div class="form-group row">
														<div class="col-md-6">
															<label>Mulai Tanggal</label>
															<input type="date" class="form-control" />
														</div>
														<div class="col-md-6">
															<label>Sampai Tanggal</label>
															<input type="date" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<label>Catatan</label>
														<textarea rows="1" class="form-control"></textarea>
													</div>
													<button class="btn btn-sm btn-success"><i class="fal fa-check-circle"></i>	Ubah</button>
													<button class="btn btn-sm btn-danger" data-toggle="collapse" data-target=".shop-status-edit" aria-controls="close-shop btn-close-edit"><i class="fal fa-times-circle"></i>	Batal</button>
												</div>
											</div>`

						}else{

							status += `<div class="fs-14 mb-3"><img src="${base_url('assets/img/default/icon-shop-open.png')}" alt="" width="35px" /> Buka</div>
											<div class="card shadow-sm" id="close-shop">
												<div class="card-body">
													<h4 class="fs-13 mb-3">Atur jadwal Tutup Toko </h4>
													<div class="form-group row">
														<div class="col-md-6">
															<label>Mulai Tanggal</label>
															<input type="date" class="form-control" />
														</div>
														<div class="col-md-6">
															<label>Sampai Tanggal</label>
															<input type="date" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<div class="custom-control custom-checkbox">
														  <input type="checkbox" class="custom-control-input">
														  <label class="custom-control-label fs-13" for="remember">Tutup Sekarang</label>
														</div>
													</div>
													<div class="form-group">
														<label>Catatan</label>
														<textarea rows="1" class="form-control"></textarea>
													</div>
													<button class="btn btn-sm btn-success"><i class="fal fa-cog"></i>	Atur</button>
													<button class="btn btn-sm btn-warning"><i class="fal fa-sync"></i>	Reset</button>
												</div>
											</div>`

						}

					}else{

						status += `<div class="text-danger fs-13 mb-2">Belum Aktif</div>
				              	<p class="fs-13 mb-2 text-muted">Ayo tambah produk pertama kamu sekarang untuk mengaktifkan toko, dan segera dapatkan penjualan.</p>
				              	<a href="${base_url('seller/product/add')}" class="text-success fs-13"><i class="fal fa-plus"></i> Tambah Produk</a>`

					}

					$('#content--shop .shop-status').html(status)
				}

			})
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

</script>