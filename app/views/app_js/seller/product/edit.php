
<?php include __DIR__.'/../Seller.php' ?>

<script>

	var urutan = 0;
	
	class EditProduct {
		constructor()
		{
			this.HapusFoto = []
			this.getKategori()
		}

		run()
		{
			var data = {
				client_token: $jp_client_token,
				produk_id: <?php echo $produk_id; ?>
			}

			callApi('seller/product/get/',data,res => {
				if (res.Error) {
					notifAlert(res.Message,'error')
				}else{

					var data = res.Data,
						foto_produk = data.foto_produk

					if (foto_produk) {
						for (var i = 0; i < foto_produk.length; i++) {
							$('#foto--produk .file-upload-item:nth-child('+(i+1)+') img')
							.attr('src',foto_produk[i].foto).attr('data-img-id',foto_produk[i].id_foto)
							.parents('.file-upload-item').removeClass('active')
							.removeClass('disabled')
							.next('.file-upload-item').removeClass('disabled').addClass('active')
						}
					}
					$('.edit-product-page input.nama_produk').val(data.nama_produk)
					$('.edit-product-page input[name=kondisi][value='+data.kondisi+']').prop('checked',true)
					$("textarea.deskripsi").val(data.keterangan);
					$('.edit-product-page input.min_beli').val(data.min_beli)
					$('.edit-product-page input.harga').val(data.harga)
					$('.edit-product-page input.status').val(data.status).prop('checked',(data.status == 1)? true: false).trigger('change')
					$('.edit-product-page input.stok').val(data.stok)
					$('.edit-product-page input.sku').val(data.sku_produk)
					$('.edit-product-page input.berat').val(data.berat)
					$('.edit-product-page input[name=asuransi][value='+data.asuransi+']').prop('checked',true)
					$('.edit-product-page input.preorder').val(data.preorder).prop('checked',(data.preorder == 1)? true : false)
					.parents('.parent-preorder').find('.waktu-preorder').collapse(data.preorder == 1? 'show' : 'hide')

					if (data.induk_kategori_id == 0) {
						$('.edit-product-page select.kategori').val(data.kategori_id).trigger('change')
					}else{
						$('.edit-product-page select.kategori').val(data.induk_kategori_id).trigger('change')
						setTimeout(() => {
							$('.edit-product-page select.sub_kategori').val(data.kategori_id).trigger('change')
						},1000)
					}

					if (data.preorder == 1) {

						$('.edit-product-page input.lama--preorder').val(data.lama_preorder)
						$('.edit-product-page select.waktu--preorder').val(data.waktu_preorder).trigger('change')
					}


					let html = '';
					// var urutan = 0;
					$.each(data.grosir, function (index, value) { 
						html += `
							<tr data-urutan="${urutan}">
								<td>
									<input type="number" name="qty-min[]" data-urutan="${urutan}" class="qty-min form-control" value="${value.qty_min}" id="">
								</td>
								<td>
									<input type="number" name="qty-max[]" data-urutan="${urutan}" class="qty-max form-control" value="${value.qty_max}" id="">
								</td>
								<td>
									<input type="number" name="harga[]" data-urutan="${urutan}" class="harga form-control" value="${value.harga}" id="">
								</td>
								<td><button type="button" class="btn btn-danger btm-sm _repeater-bapus" data-urutan="${urutan++}"><i class="fas fa-trash"></i></button></td>
							</tr>
						`;
					});

					$("table.grosir tbody").append(html);
				}
			})

		}

		getKategori()
		{
			callApi('category/',null,res => {

				var output = '' 

				if (res.Error) {

				}else{

					var data = res.Data;

					$.each(data,function(no, data) {
						
						output += `<option value=""></option>`
						output += `<option value="${data.id_kategori}">${data.nama_kategori}</option>`

					});

				}

				$('.edit-product-page select.kategori').html(output).select2()
				this.run()

			})
		}

		getSubKategori(kategori_id)
		{
			callApi('category/sub/',{kategori_id: kategori_id},res => {

				var output = '' 

				if (res.Error) {
					$('.edit-product-page select.sub_kategori').parent().addClass('d-none')
				}else{

					var data = res.Data;

					$.each(data,function(no, data) {
						
						output += `<option value=""></option>`
						output += `<option value="${data.id_kategori}">${data.nama_kategori}</option>`

					});
					$('.edit-product-page select.sub_kategori').parent().removeClass('d-none')

				}
				$('.edit-product-page select.sub_kategori').html(output).select2()


			})
		}

		edit()
		{
			var foto_produk = $('input.data-product-image[data-base64]'),
				data_foto_produk = null,
				nama_produk = $('.edit-product-page input.nama_produk').val(),
				kategori = $('.edit-product-page select.kategori').val(),
				sub_kategori = $('.edit-product-page select.sub_kategori').val(),
				kondisi = $('.edit-product-page input[name=kondisi]:checked').val(),
				keterangan = CKEDITOR.instances['ckeditor'].getData(),
				min_beli = $('.edit-product-page input.min_beli').val(),
				harga = $('.edit-product-page input.harga').val(),
				stok = $('.edit-product-page input.stok').val(),
				sku = $('.edit-product-page input.sku').val(),
				satuan_berat = $('.edit-product-page select.satuan-berat').val(),
				berat = $('.edit-product-page input.berat').val();
				// asuransi = $('.edit-product-page input[name=asuransi]:checked').val(),
				// preorder = $('.edit-product-page input.preorder').val(),
				// lama_preorder = $('.edit-product-page input.lama--preorder').val(),
				// waktu_preorder = $('.edit-product-page select.waktu--preorder').val()

			if (foto_produk.length> 0) {
				data_foto_produk = []
			}

			foto_produk.each((no,data) => {

				if ($(data).attr('data-base64').length > 0) {
					data_foto_produk.push($(data).attr('data-base64'))
				}

			})

			let qty_min = $("table.grosir input.qty-min");

			let grosir = [];
			$.each(qty_min, function (index, value) { 
				let urutan = $(this).data('urutan');
				grosir.push({
					qty_min: $(this).val(),
					qty_max: $(`table.grosir input.qty-max[data-urutan=${urutan}]`).val(),
					harga: $(`table.grosir input.harga[data-urutan=${urutan}]`).val(),
				});
			});

			var data = {
				client_token: $jp_client_token,
				produk_id: <?php echo $produk_id; ?>,
				foto: data_foto_produk,
				hapus_foto: this.HapusFoto,
				nama_produk: nama_produk,
				kategori: kategori,
				sub_kategori: sub_kategori,
				kondisi: kondisi,
				keterangan: keterangan,
				url_video: null,
				min_beli: min_beli,
				harga: harga,
				stok: stok,
				sku: sku,
				satuan_berat: satuan_berat,
				berat: berat,
				grosir: grosir,
				// asuransi: asuransi,
				// preorder: preorder,
				// lama_preorder: lama_preorder,
				// waktu_preorder: waktu_preorder

			}

			callApi('seller/product/edit/',data,res => {
				if (res.Error) {
					notif('.edit-product-page .msg-div-add-product','danger',res.Message)
				}else{
					session.set_flashdata('msg_success',res.Message)
					window.location="<?php echo base_url('seller/product'); ?>";
				}
			})
		}

		RemoveFotoProduk(foto_id)
		{
			this.HapusFoto.push(foto_id)
		}
	}

	var product_edit = new EditProduct

	var upload_image = new UploadImage

	upload_image.options(400,400,true)

	// uplaod file

	$('.edit-product-page').on('click', '.file-upload .img-viewer', function() {
		$(this).parent().find('input.data-product-image').trigger('click')
	});

	$(document).on('click', '.file-upload .file-upload-item button.btn-delete-file-upload', function(event) {
		event.preventDefault()
		var id_foto = $(this).parents('.file-upload-item').find('.img-viewer img').attr('data-img-id')
		if (id_foto) {
			product_edit.RemoveFotoProduk(id_foto)
		}
	})

	$('.edit-product-page').on('click', '.file-upload .btn-change-file-upload', function() {
		$(this).parents('.file-upload-item').find('input.data-product-image').trigger('click')
	});

	$('.edit-product-page').on('change', '.file-upload .file-upload-item input.data-product-image', function(event) {
		upload_image.get_base64(this,$(this).parents('.file-upload-item').find('.display img'),event)
		var id_foto = $(this).parents('.file-upload-item').find('.img-viewer img').attr('data-img-id')
		if (id_foto) {
			product_edit.RemoveFotoProduk(id_foto)
		}
	});


	// end upload file

	// $('.edit-product-page').on('submit', 'form', function(event) {
	// 	event.preventDefault();
	// 	product_edit.add()
	// });

	$('.edit-product-page').on('change', 'select.kategori', function() {
		
		product_edit.getSubKategori($(this).val())
		
	});

	$('.edit-product-page').on('change', 'input.preorder', function() {
		$(this).val(this.checked? 1 : 0)
		$(this).parents('.parent-preorder').find('.waktu-preorder').collapse(this.checked? 'show' : 'hide')
	});

	$('.edit-product-page').on('change', 'select.waktu--preorder', function() {
		var input = $(this).parents('.waktu_preorder').find('input.lama--preorder')
		if ($(this).val() == 'minggu') {
			input.attr('max',28)
			$(this).parents('.waktu_preorder').find('.input-length').html('Maksimum <span class="fw-bold">'+input.attr('max')+'</span> Minggu')
		}
		if($(this).val() == 'hari') {
			input.attr('max',210)
			$(this).parents('.waktu_preorder').find('.input-length').html('Maksimum <span class="fw-bold">'+input.attr('max')+'</span> Hari')
		}
	});

	$('.edit-product-page').on('input', 'input.waktu--preorder', function() {
		if ($(this).val() !== '') {
			$(this).val(Math.max(Math.min($(this).val(), $(this).attr('max')),0))
		}
	});

	$('.edit-product-page').on('change', 'input.preorder', function() {
		$(this).val(this.checked? 1 : 0)
	});

	$('.edit-product-page').on('change', 'input.status', function() {
		$(this).val(this.checked? 1 : 0)
		$(this).parent().find('.title-status').text(this.checked? 'Aktif' : 'Nonaktif')
	});

	$(document).on("click", "button._repeater-tambah", function() {
		let html = `
			<tr data-urutan="${urutan}">
				<td>
					<input type="number" name="qty-min[]" data-urutan="${urutan}" class="qty-min form-control" value="0" id="">
				</td>
				<td>
					<input type="number" name="qty-max[]" data-urutan="${urutan}" class="qty-max form-control" value="0" id="">
				</td>
				<td>
					<input type="number" name="harga[]" data-urutan="${urutan}" class="harga form-control" value="0" id="">
				</td>
				<td><button type="button" class="btn btn-danger btm-sm _repeater-bapus" data-urutan="${urutan++}"><i class="fas fa-trash"></i></button></td>
			</tr>
		`;

		$("table.grosir tbody").append(html);
	})

	$(document).on("click", "button._repeater-bapus", function() {
		let urutan = $(this).data('urutan');

		$(`table.grosir tbody tr[data-urutan=${urutan}]`).remove();
	})

</script>