

<script>

	var $jp_client_token = check_auth()

	if (!check_auth()) {
		redirect('login?continue='+base_url('my-shop'))
	}
	
	class OpenShop {

		constructor()
		{
			this.Status = false
			if (check_auth()) {
				this.run()
			}
		}

		run()
		{
			var data = {
				client_token: $jp_client_token
			}
			callApi('get_token/',data,res => {
				if (res.Error) {
					page_found.not_found()
				}else{
					var data = res.Data
					if (data.role == 1) {
						redirect('admin/shop');
					}
					if(data.toko == 1){
						redirect('seller/home')
					}else{
						$('.new-render h6').html(`Halo <b>${split_nama(data.nama_user)[0]}</b>, Ayo isi detail Tokomu!`)
						$('.my-shop-content').removeClass('d-none')
						$('.loader-helper').remove()
						this.getProvinsi()
					}
				}
			})
		}

		getProvinsi()
		{
			callApi('provinsi/',null,res => {
				var output = ''
				if (res.Error) {
				}else{
					output += '<option value=""></option>'
					$.each(res.Data,(index, data) => {
						output += `<option value="${data.id_provinsi}">${data.nama_provinsi}</option>`
					})
				}
				$('.my-shop-content select.provinsi').html(output).select2()
			})
		}

		getKabupaten(provinsi_id)
		{
			callApi('kabupaten/',{provinsi_id: provinsi_id},res => {
				var output = ''
				if (res.Error) {
				}else{
					output += '<option value=""></option>'
					$.each(res.Data,(index, data) => {
						output += `<option value="${data.id_kabupaten}">${data.nama_kabupaten}</option>`
					})
				}
				$('.my-shop-content select.kabupaten').html(output).select2()
			})
		}

		getKecamatan(kabupaten_id)
		{
			callApi('kecamatan/',{kabupaten_id: kabupaten_id},res => {
				var output = ''
				if (res.Error) {
				}else{
					output += '<option value=""></option>'
					$.each(res.Data,(index, data) => {
						output += `<option value="${data.id_kecamatan}">${data.nama_kecamatan}</option>`
					})
				}
				$('.my-shop-content select.kecamatan').html(output).select2()
			})
		}

		getKodePos(kecamatan_id)
		{
			callApi('kodepos/',{kecamatan_id: kecamatan_id},res => {
				var output = ''
				if (res.Error) {
				}else{
					$('.my-shop-content input.kode_pos').val(res.Data.kodepos)
				}
			})
		}

		cek(nama_toko)
		{
			callApi('shop/cek/',{nama_toko:nama_toko},res => {
				if (res.Error) {
					this.Status = false
					$('.my-shop-content .msg-shop-name').addClass('text-danger').text(res.Message)
				}else{
					this.Status = true
					$('.my-shop-content .msg-shop-name').addClass('text-success').text(res.Message)
				}
			})
		}

		open()
		{
			if (this.Status) {
				var nama_toko = $('.my-shop-content input.nama_toko').val(),
					provinsi = $('.my-shop-content select.provinsi').val(),
					kabupaten = $('.my-shop-content select.kabupaten').val(),
					kecamatan = $('.my-shop-content select.kecamatan').val(),
					kodepos = $('.my-shop-content input.kode_pos').val();

				callApi('shop/open',{
					user_id: init_app.UserId,
					nama_toko: nama_toko,
					provinsi: provinsi,
					kabupaten: kabupaten,
					kecamatan: kecamatan,
					kodepos: kodepos
				}, res => {

					var output = ''

					if (res.Error) {

							output += `<div class="card card-body done-render">
									<div class="done-render-header text-center mb-3">
										<div class="icon failed fs-60"><i class="fa"></i></div>
										<h4 class="font-weight-bold m-0">${nama_toko}</h4>
										<span class="fs-13">${res.Message}</span>
									</div>
									<div class="done-render-content mb-3">
										<a href="${base_url('seller/product')}" class="btn btn-success btn-block disabled">Tambah Produk</a>
										<a href="${base_url('seller/home')}" class="btn btn-light btn-block disabled">Ke Halaman Toko</a>
										<a href="" class="btn btn-primary btn-block">Segarkan</a>
									</div>
									<div class="done-render-footer text-center">
										<p class="title fs-14">
											<b>Layanan kurir diareamu otomatis diaktifkan.</b>Yuk, tambahkan produk pertamamu untuk mulai berjualan.
										</p>
									</div>
								</div>`

							init_app.getShop()

					}else{

						output += `<div class="card card-body done-render">
									<div class="done-render-header text-center mb-3">
										<div class="icon success fs-60"><i class="fa"></i></div>
										<h4 class="font-weight-bold m-0">${nama_toko}</h4>
										<span class="fs-13">${res.Message}</span>
									</div>
									<div class="done-render-content mb-3">
										<a href="${base_url('seller/product')}" class="btn btn-success btn-block">Tambah Produk</a>
										<a href="${base_url('seller/home')}" class="btn btn-light btn-block">Ke Halaman Toko</a>
									</div>
									<div class="done-render-footer text-center">
										<p class="title fs-14">
											<b>Layanan kurir diareamu otomatis diaktifkan.</b>Yuk, tambahkan produk pertamamu untuk mulai berjualan.
										</p>
									</div>
								</div>`


					}

					$('.my-shop-content .form-content').html(output)

				})
			}
		}

	}

	var open_shop = new OpenShop

	$('.my-shop-content form').on('submit', function(event) {
		event.preventDefault();

		if (open_shop.Status) {
			open_shop.open()
		}else{
			// notifScroll('body')
			$('.my-shop-content input.nama_toko').focus()
		}
		
	});
	
	$('.my-shop-content input.nama_toko').on('change',function() {

		open_shop.cek($(this).val())
		
	});

	$('.my-shop-content input.nama_toko').on('input',function() {

		this.value = this.value.replace(/[ ](?=[ ])|[^-_,A-Za-z0-9 ]+/,'')

		var length = $(this).val().length

		$('.my-shop-content #slug-toko')
		.html(`Domain Toko : <br>
				<span class="fs-11 p-0 m-0">
						${base_url()}shop/<span class="text-success m-0 p-0">${make_slug($(this).val())}</span>
				</span>`)
		
		
	});


	$('.my-shop-content select.provinsi').on('change', function() {
		
		open_shop.getKabupaten($(this).val())
		
	});

	$('.my-shop-content select.kabupaten').on('change', function() {
		
		open_shop.getKecamatan($(this).val())
		
	});

	$('.my-shop-content select.kecamatan').on('change', function() {
		
		open_shop.getKodePos($(this).val())
		
	});

</script>