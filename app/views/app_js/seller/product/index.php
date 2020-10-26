
<?php include __DIR__.'/../Seller.php' ?>

<script>

	var msg_success = session.flashdata('msg_success')

	if (msg_success) {
		notifAlert(msg_success,'success',10)
	}
	
	class Product {
		constructor()
		{
			this.Keyword = '';
			this.ProdukId = null;
			this.run();
			this.getCategory();
			this.getEtalase();
		}

		run(params = "")
		{
			var kategori_id = params['kategori_id'];
			var etalase_id = params['etalase_id'];
			var status= params['status'];
			this.ProdukId = null
			var data = {
				client_token: $jp_client_token,
				kategori_id: kategori_id,
				etalase_id: etalase_id,
				status: status
			}

			var table = new Table;
			table.run({
				tabel: "table.table-product",
				url: 'seller/product/',
				data: data,
				columns: [
					{
						data: null,
						render: function (data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1 + '.';
						}
					},
					{
						data: null,
						render: function (data) {
							var blokir = '';
							var etalase = '';

							if (data.verifikasi == 0) {
								blokir += `<span class="badge badge-danger badge-pill">Diblokir</span><br>
								<small class="text-danger">${data.catatan_diblokir}</small>`
							}

							if(data.etalase_id != null) {
								etalase = `<span class="badge badge-success fs-10">${data.etalase_nama}</span>`;
							}

							return `
							<div class="media">
								<img src="${data.foto_produk}" alt="" width="47px" class="img-thumbnail">
								<div class="media-body ml-3">
									<h5 class="m-0 fs-14 fw-600">
									<a href="${base_url()}shop/${data.slug_toko}/${data.slug_produk}" target="_blank" class="text-orange">${data.nama_produk}</a></h5>
									<span class="badge badge-success bg-orange fs-10">${data.nama_kategori}</span>
									${etalase}
									<br/>
									<small class="text-muted fs-10">${data.keterangan}</small>
								</div>
							</div>
							${blokir}
							`;
						}
					},
					{
						data: null,
						render: function (data) {
							if (data.diskon == 0) {
								return `Rp `+rupiah(data.harga);
							}else{
								return `Rp ${rupiah(data.harga_diskon)} <span class="fs-10 text-secondary text-caret">${rupiah(data.harga)}</span> <small class="badge badge-danger ml-1">-${data.diskon}%</small>`;
							}
						}
					},
					{
						data: null,
						render: function (data) {
							var output;
							output = `<small class="fs-13 mb-0">Status :</small>`;

							if (data.status_produk == 0) {
								output += `
								<span class="text-danger fs-13 mb-1">Nonaktif</span>
								<button class="btn btn-sm btn-success fs-12 set-status"
								data-id="${data.id_produk}"><i class="fal fa-check-circle fs-13"></i> Set Aktif</button>`
							}else{
								output += `
								<span class="text-success fs-13 mb-1">Aktif</span>
								<span class="d-block fs-13 mb-1">Stok: <i class="text-success">${data.stok}</i></span>
								<button class="btn btn-sm btn-danger fs-12 set-status" 
								data-id="${data.id_produk}"><i class="fal fa-times-circle fs-13"></i> Set Nonaktif</button>`
							}

							return output;
						}
					},
					{
						data: null,
						render: function (data) {
							return `
							<a href="${base_url()}seller/product/edit/${data.id_produk}" class="btn btn-primary btn-sm " title="edit"><i class="fal fa-edit"></i></a>
							<button class="btn btn-sm btn-delete  btn-danger" title="hapus" 
							data-nama="${data.nama_produk}"
							data-id="${data.id_produk}"><i class="fal fa-trash-alt"></i></button>
							`;
						}
					}
				]
			})
		}

		ModalConfirmDraw(data)
		{
			this.ProdukId = data.produk_id
			$('#ModalConfirm .modal-body').html(`
				<div class="alert alert-warning text-center">
					Apakah anda yakin ingin menghapus produk : <br> ~ <strong>${data.nama_produk}</strong> ?
				</div>
			`)

			$('#ModalConfirm').modal('show')
		}

		delete()
		{
			var data = {
				client_token: $jp_client_token,
				produk_id: this.ProdukId
			}

			callApi('seller/product/delete/',data,res => {
				if (res.Error) {
					notifAlert(res.Message,'error',5000)
				}else{
					notifAlert(res.Message,'success',5000)
					$('#ModalConfirm').modal('hide')
					this.run();
				}
			})
		}

		SetStatusProduk(produk_id)
		{
			var data = {
				client_token: $jp_client_token,
				produk_id: produk_id
			}

			callApi('seller/product/set_status/',data,res => {
				if (res.Error) {
					notifAlert(res.Message,'error',5000)
				}else{
					notifAlert(res.Message,'success',5000)
					// this.run()
				}
			})
		}

		getCategory()
		{
			callApi('category/',null,function (res) {
				var option = '<option value="">Semua</option>';
				$.each(res.Data, function(index, val) {
					option += `<option value="${val.id_kategori}">${val.nama_kategori}</option>`;

					$.each(val.sub_kategori, function(index_sub_kategori, sub_kategori) {
						option += `<option value="${sub_kategori.id_kategori}">${sub_kategori.nama_kategori}</option>`;
					});

				});

				$("select.filter-kategori-product").html(option);
			})
		}

		getEtalase() {
			callApi("seller/etalase/get", {
				client_token: $jp_client_token
			}, e => {
				var option = `<option value=""></option>`;
				$.each(e.Data, function (index, value) { 
					 option += `<option value="${value.id}">${value.nama}</option>`;
				});

				$("select.filter-etalase").html(option);
			})
		}

		refresh() {
			this.run()
			this.getCategory()
			$("select.filter-kategori-product").val('').trigger('change');
			$("select.filter-etalase").val('').trigger('change');
			$("select.filter-status-product").val('').trigger('change');
		}

		slideFilter() {
			$("div.panel-filter").slideToggle('slow');
		}
	}

	var product = new Product

	// $(document).on('click', '#pagination .btn-page[data-page]', function(event) {
	// 	event.preventDefault();
	// 	product.run()
	// });

	// $('#cari-produk').on('submit', function(event) {
	// 	event.preventDefault();
	// 	var val = $('#cari-produk input.cari').val()
	// 	product.run()
	// });

	$(document).on('click', '.manage-product-page .btn-delete', function(event) {
		event.preventDefault();
		var data = {
			produk_id: $(this).attr('data-id'),
			nama_produk: $(this).attr('data-nama')
		}
		product.ModalConfirmDraw(data)
	});

	$(document).on('click', '.manage-product-page .set-status', function(event) {
		event.preventDefault();
		product.SetStatusProduk($(this).attr('data-id'))
		product.run();
	});

	$('.manage-product-page').on('submit', '#ModalConfirm form', function(event) {
		event.preventDefault();
		product.delete()
	});

	$(document).on("change", ".filter-kategori-product", function () {
		kategori_id = $(this).val();
		status = $("select.filter-status-product").val();
		etalase_id = $("select.filter-etalase").val();
		product.run({
			kategori_id: kategori_id,
			etalase_id: etalase_id,
			status: status
		});
	})

	$(document).on("change", ".filter-etalase", function () {
		kategori_id = $("select.filter-kategori-product").val();
		etalase_id = $(this).val();
		status = $("select.filter-status-product").val();
		product.run({
			kategori_id: kategori_id,
			etalase_id: etalase_id,
			status: status
		});
	})

	$(document).on("change", ".filter-status-product", function () {
		status = $(this).val();
		kategori_id = $("select.filter-kategori-product").val();
		etalase_id = $("select.filter-etalase").val();
		product.run({
			status: status,
			kategori_id: kategori_id,
			etalase_id: etalase_id
		});
	})

	$(document).on("click", "button.btn-refresh", function () {
		product.refresh();
	})

	$(document).on("click", "button.btn-slideFilter", function () {
		product.slideFilter();
	})

</script>