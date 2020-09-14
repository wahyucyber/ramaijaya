<?php require 'Shop.php' ?>

<script>
	
	var $kategori = null,$keyword = null,$filter = null;

	class Shop_Product {
		constructor()
		{
			this.load()
			this.getCategory()
		}

		load(page = 1,kategori = $kategori,keyword = $keyword,type = null,filter = $filter)
		{
			var data = {
				slug: uri_segment(2),
				page: page,
				kategori: kategori,
				keyword: keyword,
				filter: filter,
				client_token: $jp_client_token
			}
			$('#pagination').html(`<button class="btn btn-orange" type="button" disabled>
									  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
									  <small>Memuat...</small>
									</button>`)
			callApi('shop/product/',data,function(res){
				var output = '';
				if (res.Error) {
					// var not = notif('#produk--toko','warning',res.Message)
					output += `<div class="alert alert-warning">${res.Message}</div>`
					$('#pagination').html('')
				}else{

					var data = res.Data,
						pagination = res.Pagination,
						exists_kategori = '0'

					$.each(data,function(index,val){

						output += `<a href="<?= base_url(); ?>shop/${uri_segment(2)}/${val.slug}" class="card product-item">
							<div class="card-header head">
								<img src="${val.foto? val.foto[0].foto : base_url('assets/img/default/no-image.png')}">`
								// if (check_auth()) {
								// 	if (data.favorit == 0) {
								// 		output += `<button title="Tambahkan ke wishlist" class="wishlist btn badge badge-light add-to-wishlist produk--favorit" data-produk-id="${data.id_produk}"><i class="fa-heart _icon"></i></button>`
								// 	}else{
								// 		output += `<button title="Tambahkan ke wishlist" class="wishlist btn badge badge-light add-to-wishlist produk--favorit active" data-produk-id="${data.id_produk}"><i class="fa-heart _icon"></i></button>`
								// 	}

								// }
								if (val.preorder == 1) {
									output += `<span class="preorder badge badge-light" title="Lama ${val.lama_preorder} ${val.waktu_preorder}"><i class="fa fa-bullhorn"></i></span>`
								}
								var harga = '',
								diskon = ''
								if (val.diskon == 0) {
									harga = `<div class="price">Rp ${Format_Rupiah(val.harga)}</div>`
								}else{
									harga = `<span class="text-caret fs-13 text-secondary ml-1">Rp ${Format_Rupiah(val.harga)}</span> <span class="price">Rp ${Format_Rupiah(val.harga_diskon.toString())}</span>`
									diskon = `<span class="free-ongkir badge badge-danger">-${val.diskon}% <br> <b class="text-white">OFF</b></span>`
								}
					output += `${diskon}
							</div>
							<div class="card-body body">
								<div class="small">${val.nama}</div>
								<div class="price-product">
									${harga}
								</div>
								<div class="dtl">
									<span class="fa fa-sm fa-calendar-check"></span>
									<div class="dtl-product">
										<span class="dtl-item">${val.nama_kabupaten}</span>
										<span class="dtl-item">${val.nama_toko}</span>
									</div>
								</div>
								<div class="star_rate">
									<i class="product-rating _${val.rating}-star"></i>
									<span class="counter">(${val.rating})</span>
								</div>
								${$jp_client_token? `<div class="content-add-to-cart">
												<button class="btn btn-sm btn-orange btn-add-to-cart add--product-to-cart"  data-id="${val.id}"><i class="fal fa-cart-plus"></i><small> Tambahkan ke Keranjang </small></button>
											</div>` : ''}
							</div>
						</a>`
						
						if(val.kategori == kategori){
						    exists_kategori = val.kategori
						}

					})

					if (pagination.Jml_halaman > 1) {
						$('#pagination').html(`<button class="btn btn-orange" onclick="shop_product.load(page = ${parseInt(pagination.Halaman) + 1},kategori = ${kategori},keyword = ${keyword},type = ${type},filter = ${filter})"><i class="fal fa-angle-double-down"></i>	Lihat Lainnya</button>`)
					}else{
						$('#pagination').html(`<button class="btn btn-danger" disabled><i class="fal fa-ban"></i>	Sudah yang terakhir</button>`)
					}

				}


				if (validate({page: page,kategori: kategori,keyword: keyword,type: type,filter: filter})) {
					$('#produk--toko').html(output)
				}else{
					$('#produk--toko').append(output)
				}
				
				$('.storefront--list-item[data-id="'+exists_kategori+'"]').addClass('active').not(this).removeClass('active')

				$kategori = kategori
				$keyword = keyword
				$filter = filter
			})
		}

		getCategory()
		{
			var data = {
				slug: uri_segment(2),
				client_token: $jp_client_token
			}
			callApi('shop/category_product/',data,function(res){
				var output = ''
				if (res.Error) {
					output += ``
				}else{

					var data = res.Data
					output += `<li class="storefront--list-item active">
									<a href="javascript:;" data-id="0">Semua Kategori</a>
								</li>`
					$.each(data,function(index,data){
						output += `<li class="storefront--list-item">
										<a href="javascript:;" data-id="${data.id_kategori}">${data.nama_kategori}</a>
									</li>`
					})

				}

				$('#CategoryList').html(output)
			})
		}
		addToCart(params) {
			var produk_id = params['produk_id'];
			var qty = params['qty'];
			var catatan = params['catatan'];
			var minimal_pembelian = params['minimal_pembelian'];
			var kategori = params['kategori'];

			var toko_id = params['toko_id'] ? params['toko_id'] : "";
			var toko_foto = params['toko_foto'] ? params['toko_foto'] : "";
			var toko_nama = params['toko_nama'] ? params['toko_nama'] : "";
			var kabupaten_id = params['kabupaten_id'] ? params['kabupaten_id'] : "";
			var kabupaten_nama = params['kabupaten_nama'] ? params['kabupaten_nama'] : "";
			var kecamatan_id = params['kecamatan_id'] ? params['kecamatan_id'] : "";

			if (!check_auth()) {
				window.location="<?php echo base_url('login'); ?>";
			}else{
				console.log($jp_client_token);
				callApi("cart/add", {
					client_token: $jp_client_token,
					produk_id: produk_id,
					qty: qty,
					catatan: catatan
				}, res => {
					var pesan = res.Message;
					if (res.Error == true) {
						notifAlert(pesan, 'danger', 5000);
					}else{
						if (kategori == "beli") {
							window.location="<?php echo base_url('cart'); ?>";
						}
						init_app.getCart();
						$("input.qty").val(minimal_pembelian);
						$("input.catatan").val('');
						notifAlert(pesan, 'success', 5000);
					}
				});
			}
		}
	}

	function validate(params)
	{
		console.log(params)
		var res = false
		if (params.type == 's') {
			return true
		}else{
			if (!$kategori && !params.kategori) {
				return false
			}
		}
		if (params.filter) {
			if (params.filter !== $filter) {
				return true
			}
		}
		if (params.filter == '0') {
			return true
		}
		if (params.kategori) {
			if ($kategori == params.kategori) {
				return false
			}else{
				return true
			}
		}else{
			return true
		}
	}

	var shop_product = new Shop_Product

	// $(document).on('click', '#pagination .btn-page[data-page]', function(event) {
	// 	event.preventDefault();
	// 	shop_product.load($(this).data('page'),$kategori)
	// });

	$(document).on('click', '.add--product-to-cart', function(event) {
		event.preventDefault();
		shop_product.addToCart({
			produk_id: $(this).data('id'),
			qty: 1,
			catatan: '',
			kategori: "keranjang"
		});
	});

	$(document).on('click', '#CategoryList li.storefront--list-item:not(.active) a', function(event) {
		event.preventDefault();
		$(this).parent().addClass('active')
		$('#CategoryList li.storefront--list-item').not($(this).parent()).removeClass('active')
		$('input.keyword-produk').val('')
		$('select.filter').val([])
		var id = $(this).attr('data-id')
		id = id? id : '0';
		if (id == $kategori) {

		}else{
			shop_product.load(1,id,null,null)
		}
	});

	$(document).on('submit', '#form-keyword', function(event) {
		event.preventDefault();
		shop_product.load(1,$kategori,$('input.keyword-produk').val(),'s',$filter)
		
	});

	$(document).on('change', 'select.filter', function(event) {
		var q = $(this).val()
		q = q? q : '';
		shop_product.load(1,$kategori,$keyword,null,q)
		
	});

</script>