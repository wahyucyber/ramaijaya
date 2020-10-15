
<?php include __DIR__.'/../Seller.php' ?>

<script>

	var msg_success = session.flashdata('msg_success')
	
	var adding = false;

	if (msg_success) {
		notifAlert(msg_success,'success',10)
	}
	
	class Product_Add {

		constructor()
		{
			this.getKategori()
			this.getEtalase();
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

				$('.add-product-page select.kategori').html(output).select2()

			})
		}

		getSubKategori(kategori_id)
		{
			callApi('category/sub/',{kategori_id: kategori_id},res => {

				var output = '' 

				if (res.Error) {
					$('.add-product-page select.sub_kategori').parent().addClass('d-none')
				}else{

					var data = res.Data;

					$.each(data,function(no, data) {
						
						output += `<option value=""></option>`
						output += `<option value="${data.id_kategori}">${data.nama_kategori}</option>`

					});
					$('.add-product-page select.sub_kategori').parent().removeClass('d-none')

				}
				$('.add-product-page select.sub_kategori').html(output).select2()


			})
		}

		getEtalase() {
			callApi("seller/etalase/get", { client_token: $jp_client_token }, e => {
				var option = `<option value="">Pilih Etalase</option>`;
				$.each(e.Data, function (index, value) { 
					option += `<option value="${value.id}">${value.nama}</option>`;
				});
				$("select.etalase").html(option);
				$("select.etalase").select2('refresh');
			})
		}

		add(cons)
		{
			var foto_produk = $('input.data-product-image[data-base64]'),
				data_foto_produk = null,
				nama_produk = $('.add-product-page input.nama_produk').val(),
				kategori = $('.add-product-page select.kategori').val(),
				sub_kategori = $('.add-product-page select.sub_kategori').val(),
				etalase = $("select.etalase").val(),
				kondisi = $('.add-product-page input[name=kondisi]:checked').val(),
				keterangan = CKEDITOR.instances['ckeditor'].getData(),
				min_beli = $('.add-product-page input.min_beli').val(),
				harga = $('.add-product-page input.harga').val(),
				stok = $('.add-product-page input.stok').val(),
				sku = $('.add-product-page input.sku').val(),
				satuan_berat = $('.add-product-page select.satuan-berat').val(),
				berat = $('.add-product-page input.berat').val();
				// asuransi = $('.add-product-page input[name=asuransi]:checked').val(),
				// preorder = $('.add-product-page input.preorder').val(),
				// lama_preorder = $('.add-product-page input.lama--preorder').val(),
				// waktu_preorder = $('.add-product-page select.waktu--preorder').val()

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
				foto: data_foto_produk,
				nama_produk: nama_produk,
				kategori: kategori,
				sub_kategori: sub_kategori,
				etalase: etalase,
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
            // if(adding){
                
            // }else{
                $('button.btn--add,button.btn--add-only').attr('disabled',true)
    			callApi('seller/product/add/',data,res => {
    				if (res.Error) {
    					notif('.add-product-page .msg-div-add-product','danger',res.Message)
    					adding = false
    					$('button.btn--add,button.btn--add-only').attr('disabled',false)
    				}else{
    					session.set_flashdata('msg_success',res.Message)
    					redirect('seller/'+cons)
    				}
    			})
            // }
            // adding = true
		}

	}

	var product_add = new Product_Add

	var upload_image = new UploadImage

	upload_image.options(400,400,true)
	
	$(document).on('click','button.btn--add',function(e){
	    e.preventDefault()
    	    product_add.add('product/add')
	})
	$(document).on('click','button.btn--add-only',function(e){
	    e.preventDefault()
    	    product_add.add('product/')
	})

	// uplaod file

	$('.add-product-page').on('click', '.file-upload .img-viewer', function() {
		$(this).parent().find('input.data-product-image').trigger('click')
	});

	$('.add-product-page').on('click', '.file-upload .btn-change-file-upload', function() {
		$(this).parents('.file-upload-item').find('input.data-product-image').trigger('click')
	});

	$('.add-product-page').on('change', '.file-upload .file-upload-item input.data-product-image', function(event) {
		upload_image.get_base64(this,$(this).parents('.file-upload-item').find('.display img'),event)		
	});

	// end upload file

	// $('.add-product-page').on('submit', 'form', function(event) {
	// 	event.preventDefault();
	// 	product_add.add()
	// });

	$('.add-product-page').on('change', 'select.kategori', function() {
		
		product_add.getSubKategori($(this).val())
		
	});

	$('.add-product-page').on('change', 'input.preorder', function() {
		$(this).val(this.checked? 1 : 0)
		$(this).parents('.parent-preorder').find('.waktu-preorder').collapse(this.checked? 'show' : 'hide')
	});

	$('.add-product-page').on('change', 'select.waktu--preorder', function() {
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

	$('.add-product-page').on('input', 'input.lama--preorder', function() {
		if ($(this).val() !== '') {
			$(this).val(Math.max(Math.min($(this).val(), $(this).attr('max')),0))
		}
	});

	$('.add-product-page').on('change', 'input.preorder', function() {
		$(this).val(this.checked? 1 : 0)
	});

	var urutan = 0;
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