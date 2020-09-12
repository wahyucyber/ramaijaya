<script>
	var $jp_client_token = check_auth()

	class Cart {
		constructor() {
			this.drawCart();
		}

		drawCart() {
			var getCart = $("div#contentCart").html('');
			callApi("cart/detail", {
				client_token: $jp_client_token
			}, function (req) {
				if (req.Data.length == 0) {
				// 	notif('div#contentCart', 'info', 'Keranjang belanja anda kosong.');
					$('#contentCart').html(`<div class="jumbotron cart-empty text-center bg-white shadow">
            			 <img src="<?= base_url() ?>assets/img/default/empty-cart.png" alt="" width="300" class="mb-4">
            			<h2 class="fs-20 text-muted mb-4">Keranjang Belanja Kosong</h2>
            			<a href="<?= base_url(); ?>" class="btn btn-orange"><i class="fal fa-shopping-cart"></i>	Belanja Sekarang</a>
            		</div>`)
					$("input[type=checkbox]").prop('checked', false);
					$('button.lanjut--kepembayaran').attr('disabled',true)
				}else{
					var mitra = '';
					let total_produk = 0;
					let total_produk_checked = 0;
					$.each(req.Data, function(index, val) {
						var product = '';
						var total_berat = 0;
						let jml_produk_checked = 0;
						$.each(val.toko_produk, function(produk_index, produk) {
							total_produk++;

							if (produk.foto == null) {
								var foto_produk = '<?php echo base_url('assets/img/default/no-image-small.png'); ?>';
							}else{
								var foto_produk = produk.foto[0].foto;
							}
		
							if (produk.qty > 1) {
								var disable_qty = "";
							}else{
								var disable_qty = "disabled";
							}

							if (produk.favorit == 0) {
								var produk_favorit = '';
							}else{
								var produk_favorit = 'style="color: orange;"';
							}

							let produk_checked = "";
							if (produk.checked == 1) {
								produk_checked = "checked";
								total_produk_checked++;
								jml_produk_checked++;
							}

							var harga_produk = '',
								input_harga = 0
							if (produk.diskon == 0) {
								harga_produk = `Rp ${rupiah(parseInt(produk.harga) * parseInt(produk.qty))}`
								input_harga = parseInt(produk.harga)
							}else{
								harga_produk = `<span class="fs-12 text-dark text-caret">Rp ${rupiah(parseInt(produk.harga) * parseInt(produk.qty))}</span> Rp ${rupiah(parseInt(produk.harga_diskon) * parseInt(produk.qty))}`
								input_harga = parseInt(produk.harga_diskon)
							}

							product += `
							<div class="cart-product mb-3">
								<div class="column">
									<div class="custom-control custom-checkbox">
									  <input type="checkbox" class="custom-control-input check-produk checkbox-produk-${produk.id}" data-produk-id="${produk.id}" data-toko-id="${val.toko_id}" data-produk-harga="${input_harga}" data-produk-foto="${foto_produk}" data-produk-nama="${produk.nama}" data-produk-berat="${produk.berat}" id="product-${produk.id}" ${produk_checked}>
									  <label class="custom-control-label" for="product-${produk.id}"></label>
									</div>
								</div>
								<div class="column">
									<label for="product" class="row">
										<div class="column">
											<img src="${foto_produk}" alt="">
										</div>
										<div class="column">
											<div class="product-name">
												<a href="<?= base_url(); ?>shop/${val.toko_slug}/${produk.slug}" class="text-elipsis" style="max-width: 80%">${produk.nama}</a>
											</div>
											<div>
												<div class="product-price">
													${harga_produk}
												</div>
											</div>
										</div>
									</label>
									<div class="note-for-seller _nfs ${produk.catatan? 'olc-displayed' : ''} mt-3">
										<div class="olc-wrapper fs-13">
											<div class="olc-text text-elipsis text-muted">${produk.catatan}</div>
											<span class="olc-handler curs-p ml-2 text-dominan">Ubah</span>
										</div>
										<div class="display-handler  fs-12">
											<span class="curs-p text-orange">Tulis Catatan Untuk Toko</span>
										</div>
										<div class="display-target">
											<div class="form-group">
												<div class="fs-12 mb-2 text-muted">Catatan Untuk Penjual (Opsional)</div>
												<textarea data-id="${produk.id}" maxlength="144" id="note_23" rows="1" class="note-text">${produk.catatan}</textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="column d-flex text-right">
									<div class="wishlist-btn">
										<div ${produk_favorit} class="cta-wishlist curs-p fs-23 text-white-lightern-3 poduk--favorit" data-product-id="${produk.id}"><span class="fa fa-heart"></span></div>
									</div>
									<div class="delete-btn">
										<div style="color: red;" class="cta-delete curs-p fs-23 text-white-lightern-3 produk--hapus" data-toggle="modal" data-target="#konfirmasi" data-produk-nama="${produk.nama}" data-product-id="${produk.id}"><span class="fa fa-trash"></span></div>
									</div>
									<div class="qty-input">
										<div class="quantity-input">
											<div class="qty-min qty-btn ${disable_qty}" data-produk-id="${produk.id}"></div>
											<input class="qty qty-${produk.id}" data-produk-id="${produk.id}" min="${produk.min_beli}" name="quantity" value="${produk.qty}" type="number" style="width: 22px">
											<div class="qty-plus qty-btn" data-produk-id="${produk.id}"></div>
											<button class="btn btn-sm btn-success btn-set btn-set-${produk.id} none" data-produk-id="${produk.id}" style="margin-left: 5px;">Set</button>
										</div>
									</div>
								</div>
							</div>
							`;
						});

						let lapak_checked = "";
						if (jml_produk_checked > 0) {
							lapak_checked = "checked";
						}

						mitra += `
						<div class="cart-item">
							<div class="cart-store">
								<div class="column">
									<div class="custom-control custom-checkbox">
									  <input type="checkbox" class="custom-control-input check-toko checkbox-toko-${val.toko_id}" data-toko-id="${val.toko_id}" data-toko-img="${val.toko_logo}" data-toko-nama="${val.toko_nama}" data-toko-kabupaten-id="${val.toko_kabupaten_id}" data-toko-kabupaten-nama="${val.toko_kabupaten_nama}" data-toko-kecamatan-id="${val.toko_kecamatan_id}" data-kecamatan-id-tujuan="${val.kecamatan_id_tujuan}" id="store-${val.toko_id}" ${lapak_checked}>
									  <input type="hidden" name="" class="toko-${val.toko_id}-total-berat" value=""/>
									  <label class="custom-control-label" for="store-${val.toko_id}"></label>
									</div>
								</div>
								<div class="column">
									<label for="store">
										<h6 class="m-0">${val.toko_nama}</h6>
										<small class="fs-12 text-muted">${val.toko_kabupaten_nama}</small>
									</label>
								</div>
							</div>
							${product}
						</div>
						`;
					});

					if (total_produk == total_produk_checked) {
						$("#checkAll").prop('checked', true);
					}

					$("div#contentCart").html(mitra);

					cart.getTotalBayar();
				}
			})
		}

		getTotalBerat(params) {
			var toko_id = params['toko_id'];

			var total_berat = 0;
			$.each($(`input.check-produk[data-toko-id=${toko_id}]:checked`), function(index, val) {
				total_berat += parseInt($(this).data('produk-berat')) * parseInt($("input.qty-"+$(this).data('produk-id')).val());
			});
			$(`input.toko-${toko_id}-total-berat`).val(total_berat);
		}

		addProductFavorit(produk_id) {
			callApi("user/product_favorit/add", {
				client_token: $jp_client_token,
				produk_id: produk_id
			}, res => {
				var message = res.Message;
				if (res.Error == true) {
					notifAlert(message, 'error', 5000);
				}else{
					cart.drawCart();
					notifAlert(message, 'success', 5000);
				}
			})
		}

		deleteSingleProduk(produk_id) {
			callApi("cart/delete", {
				delete: JSON.stringify({
					client_token: $jp_client_token,
					produk: [{
						id: produk_id
					}]
				})
			}, res => {
				var message = res.Message;
				if (res.Error == true) {
					notifAlert(message, 'error', 5000);
				}else{
					cart.drawCart();
					init_app.getCart();
					cart.getTotalBayar();
					notifAlert(message, 'success', 5000);
				}
			})
		}

		checkCeckbox() {
			var jumlah_toko = $("input.check-produk").length;
			var jumlah_toko_check = $("input.check-produk:checked").length;
			if (jumlah_toko == jumlah_toko_check) {
				$("input#checkAll").prop('checked', true);
			}else{
				$("input#checkAll").prop('checked', false);
			}
		}

		deleteProduct(produk) {
			callApi("cart/delete", {
				delete: JSON.stringify({
					client_token: $jp_client_token,
					produk: produk
				})
			}, res => {
				var message = res.Message;
				if (res.Error == true) {
					notifAlert(message, 'error', 5000);
				}else{
					cart.drawCart();
					init_app.getCart();
					cart.getTotalBayar();
					cart.getTotalBayarPayment();
					notifAlert(message, 'success', 5000);
				}
			})
		}

		setQty(params) {
			produk_id = params['produk_id'];
			qty = params['qty'];
			callApi("cart/set_qty", {
				produk_id: produk_id,
				qty: qty,
				client_token: $jp_client_token
			}, res => {
				var message = res.Message;
				if (res.Error == true) {
					notifAlert(message, 'error', 5000);
				}else{
					cart.drawCart();
					init_app.getCart();
					notifAlert(message, 'success', 5000);
				}
			})
		}

		setChecked() {
			var produk = [];

			$.each($("input.check-produk:checked"), function(index, val) {
				produk.push({"id": $(this).data('produk-id')});
			});

			callApi("cart/set_checked", {
				client_token: $jp_client_token,
				produk: JSON.stringify(produk)
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5000);
				};
			})

			cart.getTotalBayar();
		}

		getTotalBayar() {
			var total_bayar = 0;
			$.each($("input.check-produk:checked"), function(index, val) {
				total_bayar += parseInt($(this).data('produk-harga')) * parseInt($(`input.qty-${$(this).data('produk-id')}`).val());
			});
			$("div#grand-total-product").html("Rp. "+rupiah(total_bayar));
			$("div.payment--total").html("Rp. "+rupiah(total_bayar));
		}
		set_catatan(catatan,id)
		{
			callApi("cart/set_catatan", {
				client_token: $jp_client_token,
				catatan: catatan,
				produk_id: id
			}, function(res) {
				cart.drawCart();
			})
		}
	}

	var cart = new Cart;
	
	$(document).on("click", "div.poduk--favorit", function () {
		produk_id = $(this).data('product-id');
		cart.addProductFavorit(produk_id);
	})

	$(document).on("click", "div.produk--hapus", function () {
		produk_id = $(this).data('product-id');
		produk_nama = $(this).data('produk-nama');
		$("input.produk-id").val(produk_id);
		$("b.nama-produk").html(produk_nama);
	})

	$(document).on("click", "button.btn-hapus", function () {
		produk_id = $("input.produk-id").val();
		cart.deleteSingleProduk(produk_id);
		$("div#konfirmasi").modal('hide');
	})

	$(document).on("click", "input#checkAll", function () {
		if ($(this).prop('checked')) {
			$("input[type=checkbox]").prop('checked', true);
		}else{
			$("input[type=checkbox]").prop('checked', false);
		}
		cart.setChecked();
		cart.getTotalBayar();
	})

	$(document).on("click", "input.check-toko", function () {
		toko_id = $(this).data('toko-id');
		if ($(this).prop('checked')) {
			$(`input.check-produk[data-toko-id="${toko_id}"]`).prop('checked', true);
		}else{
			$(`input.check-produk[data-toko-id="${toko_id}"]`).prop('checked', false);
		}
		cart.checkCeckbox();
		cart.setChecked();
	})

	$(document).on("click", "input.check-produk", function () {
		toko_id = $(this).data('toko-id');
		jumlah_check = $(`input.check-produk[data-toko-id=${toko_id}]:checked`).length;
		jumlah_checkbox = $(`input.check-produk[data-toko-id=${toko_id}]`).length;
		if (jumlah_check >= 1){
			$(`input.check-toko[data-toko-id="${toko_id}"]`).prop('checked', true);
		}else{
			$(`input.check-toko[data-toko-id="${toko_id}"]`).prop('checked', false);
		}
		cart.checkCeckbox();
		cart.getTotalBerat({
			toko_id: toko_id
		});
		cart.setChecked();
		cart.getTotalBayar();
	})

	$(document).on("click", "button.btn-hapus-semua", function () {
		var produk = [];
		$.each($("input.check-produk:checked"), function(index, val) {
			produk.push({id: $(this).data('produk-id')});
		});
		cart.deleteProduct(produk);
		cart.checkCeckbox();
		cart.setChecked();
		$("div#konfirmasi-semua").modal('hide');
	})

	$(document).on("keyup", "input.qty", function () {
		produk_id = $(this).data('produk-id');
		$(`button.btn-set-${produk_id}`).removeClass('none');
	})

	$(document).on("click", "div.qty-min", function () {
		produk_id = $(this).data('produk-id');
		$(`button.btn-set-${produk_id}`).removeClass('none');
	})

	$(document).on("click", "div.qty-plus", function () {
		produk_id = $(this).data('produk-id');
		$(`button.btn-set-${produk_id}`).removeClass('none');
	})

	$(document).on("click", "button.btn-set", function () {
		produk_id = $(this).data('produk-id');
		qty = $(`input.qty-${produk_id}`).val();
		cart.setChecked();
		cart.setQty({
			produk_id: produk_id,
			qty: qty
		})
	})

	$(document).on("click", "button.lanjut--kepembayaran", function () {
		jumlah_produk = $("input.check-produk").length;
		jumlah_produk_check = $("input.check-produk:checked").length;
		var tujuan_id = $("select.payment--alamat-pengiriman").val();

		if (tujuan_id == "") {
			notifAlert("Alamat pengiriman belum dipilih.", "error", 5);
		}else{
			if (jumlah_produk_check >= 1) {
				// $("div.payment").fadeIn('slow');
				// cart.getPembayaran();
				window.location="<?php echo base_url('cart/payment'); ?>";
			}else{
				notifAlert("Produk belum dipilih", "error", 4000);
			}
		}
	})

	$(document).on("click", "button.btn--batal", function () {
		$("div.payment").fadeOut('slow');
	})

	$(document).on("click", "div.toko-slidetoggle", function () {
		var toko_id = $(this).data('toko-id');
		var asal_id = $(this).data('asal-id');
		// var tujuan_id = $(this).data('tujuan-id');
		var tujuan_id = $("select.payment--alamat-pengiriman").val();
		var berat = $(this).data('berat');
		var no_urut = $("input.toko-"+toko_id).val();

		if (no_urut + 1 == 1) {
			cart.getKurir({
				'toko_id': toko_id,
				'asal_id': asal_id,
				'tujuan_id': tujuan_id,
				'berat': berat
			});
		}
		$("input.toko-"+toko_id).val(parseInt(no_urut) + 1);
		$("div.toko-body-"+toko_id).slideToggle('slow');
	})

	$(document).on("click", "div.kurir", function() {
		toko_id = $(this).data('toko-id');
		ongkir = $(this).data('ongkir');
		$(`div.kurir[data-toko-id='${toko_id}']`).removeClass('kurir-active');
		$(this).addClass('kurir-active');
		cart.getOngkir();
	})

	$(document).on("click", "button.payment--beli", function () {
		cart.beli();
	})

	$(document).on("change", "select.alamat--provinsi", function () {
		provinsi_id = $(this).val();
		cart.kabupaten(provinsi_id);
	})

	$(document).on("change", "select.alamat--kabupaten", function () {
		kabupaten_id = $(this).val();
		cart.kecamatan(kabupaten_id);
	})

	$(document).on("submit", "form.form--add-alamat", function () {
		var id = $("input.alamat--id").val();
		var nama = $("input.alamat--nama").val();
		var penerima_nama = $("input.alamat--nama-penerima").val();
		var penerima_telepon = $("input.alamat--telepon-penerima").val();
		var provinsi = $("select.alamat--provinsi").val();
		var kabupaten = $("select.alamat--kabupaten").val();
		var kecamatan = $("select.alamat--kecamatan").val();
		var alamat = $("textarea.alamat--alamat").val();
		cart.addAlamatPengiriman({
			id: id,
			nama: nama,
			penerima_nama: penerima_nama,
			penerima_telepon: penerima_telepon,
			provinsi: provinsi,
			kabupaten: kabupaten,
			kecamatan: kecamatan,
			alamat: alamat
		});

		return false;
	})
	
	$(document).on('click','.note-for-seller .display-handler',function() {
			
		$(this).parent('.note-for-seller').addClass('textfield-displayed')
		$(this).parent('.note-for-seller').find('textarea').focus()

	});

	$(document).on('click','.note-for-seller .olc-wrapper',function() {
		
		$(this).parent('.note-for-seller').addClass('textfield-displayed')
		$(this).parent('.note-for-seller').find('textarea').focus()

	});

	$(document).on('input','.note-for-seller .display-target .form-group textarea', function() {
		
		var scroll_height = $(this).get(0).scrollHeight;

		$(this).css('height', scroll_height + 'px');
		if ($(this).val().length > 144) {
			return false;
		}

		
	});

	$(document).on('blur','.note-for-seller .display-target .form-group textarea',function() {
		
		$(this).parent().parent().parent('.note-for-seller').removeClass('textfield-displayed')
		if ($(this).val().length > 0) {
			$(this).parent().parent().parent('.note-for-seller')
			.addClass('olc-displayed');
			$(this).parent().parent().parent('.note-for-seller').find('.olc-text').html($(this).val())
		}else{
			$(this).parent().parent().parent('.note-for-seller')
			.removeClass('olc-displayed');
			$(this).parent().parent().parent('.note-for-seller').find('.olc-text').html('')
		}

		cart.set_catatan($(this).val(),$(this).attr('data-id'))

	});
</script>