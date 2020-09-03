<?= script([
	// 'ext/slick/slick.min.js',
	'ext/expander/jquery.expander.min.js',
]); ?> 

<script>
	
	class Home {

		constructor()
		{
			this.DrawProduct()
			this.get_diskon_produk()
			this.DrawProductList()
			// this.DrawKategoriList()
			this.DrawCategory()
			this.DrawSlider()
			this.drawFooter();
		}

		DrawCategory()
		{
			callApi('category/',null,res => {
				var output = '' 
				if (res.Error) {
					
				}else{
					var data = res.Data,
					link_kategori;
					$.each(data,(index,data) => {
						if (data.sub_kategori.length == 0) {
							link_kategori = `<?php echo base_url(''); ?>search?q=&st=produk&kategori=${data.id_kategori}`;
						}else{
							link_kategori = `<?php echo base_url(''); ?>category/${data.id_kategori}`;
						}
						output += `<a href="${link_kategori}" class="category--box-items">
										<img src="${base_url(data.icon_kategori)}" width="100%" alt="">
									</a>`
					})
				}
				$('#home--category').html(output)
			})
		}

		DrawSlider()
		{
			callApi('slider/',null,res => {
				var output = ''
				if (res.Error) {
					// notifAlert(res.Message,'error',10)
				}else{
					$.each(res.Data,(index ,data) => {

						output += `<a href="javascript:;"><img src="${data.banner_slider}" alt="${data.title}"></a>`

					})

					$('#top-slider').removeClass('d-none').html(output)
					$('#slick-slider-inner').removeClass('_c287e')

					$('#top-slider').slick({
						draggable: false,
						centerMode: true,
						centerPadding: '60px',
						dots: true,
						speed: 400,
						useTransform: true,
						cssEase: 'cubic-bezier(0.770, 0.000, 0.175, 1.000)',
						slidesToShow: 1,
						slidesToScroll: 1,
						adaptiveHeight: true,
						variableWidth: true,
						autoplay: true,
						autoplaySpeed: 3000,
					});
				}
			})
		}

		DrawProduct()
		{
			var data = {
				client_token: $jp_client_token
			}
			callApi('product/',data,res => {
				var output = ''
				if (res.Error) {
					// notifAlert(res.Message,'error')
				}else{
					$.each(res.Data,(no,data) => {

						let img_produk = '<?php echo base_url('assets/img/default/no-image.png'); ?>';

						if (data.foto_produk != null) {
							img_produk = data.foto_produk;
						}

						output += `<a href="${base_url()}shop/${data.slug_toko}/${data.slug_produk}" class="card product-item" ${(no == 4) ? 'style="margin-right: 19px"' : ''}>
										<div class="card-header head">
											<img src="${img_produk}">`

											// if (check_auth()) {
											// 	if (data.favorit == 0) {
											// 		output += `<button title="Tambahkan ke wishlist" class="wishlist btn badge badge-light add-to-wishlist produk--favorit" data-produk-id="${data.id_produk}"><i class="fa-heart _icon"></i></button>`
											// 	}else{
											// 		output += `<button title="Tambahkan ke wishlist" class="wishlist btn badge badge-light add-to-wishlist produk--favorit active" data-produk-id="${data.id_produk}"><i class="fa-heart _icon"></i></button>`
											// 	}

											// }

											if (data.preorder == 1) {
												output += `<span class="preorder badge badge-light" title="Lama ${data.lama_preorder} ${data.waktu_preorder}"><i class="fa fa-bullhorn"></i></span>`
											}
											var harga = '',
											diskon = ''
											if (data.diskon == 0) {
												harga = `<div class="price">Rp ${Format_Rupiah(data.harga)}</div>`
											}else{
												harga = `<span class="price">Rp ${Format_Rupiah(data.harga_diskon.toString())}</span><span class="text-caret fs-13 text-secondary ml-1">Rp ${Format_Rupiah(data.harga)}</span>`
												diskon = `<span class="free-ongkir badge badge-danger">-${data.diskon}%</span>`
											}
								output += `${diskon}
										</div>
										<div class="card-body body">
											<div class="small" title="${data.nama_produk}">${data.nama_produk}</div>
											<div class="price-product">
												${harga}
											</div>
											<div class="dtl">
												<span class="fad fa-sm fa-store"></span>
												<div class="dtl-product">
													<span class="dtl-item">${data.nama_kabupaten}</span>
													<span class="dtl-item">${data.nama_toko}</span>
												</div>
											</div>
											<div class="star_rate">
												<i class="product-rating _${data.rating}-star"></i>
												<span class="counter">(${data.rating})</span>
											</div>
											${$jp_client_token?
												 `<div class="content-add-to-cart">
												 	<button class="btn btn-sm btn-primary btn-add-to-cart add--product-to-cart" data-id="${data.id_produk}"><i class="fas fa-cart-plus"></i> Tambahkan ke Keranjang</button>
													</div>` : ''}
										</div>
									</a>`

					})
				}

				$('#new-product-list').html(output)

				$('#new-product-list').slick({
					// draggable: false,
					infinite: false,
					speed: 300,
					slidesToShow: 5,
					slidesToScroll: 5,
					adaptiveHeight: true,
					variableWidth: true,
				    cssEase: 'linear',
				    responsive: [
					    {
					      breakpoint: 540,
					      settings: {
					        slidesToShow: 2,
					        slidesToScroll: 2,
					      }
					    },
				    ]
				})
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

		DrawPromo()
		{
			callApi('promo/',null,res => {
				var output = ''
				if (res.Error) {
					output += `<div class="alert alert-light text-center">${res.Message}</div>`
				}else{
					$.each(res.Data,(index, data) => {
						output += `<a href="${base_url('promo/'+data.slug)}" class="item-promo-inner">
										<div class="item-promo">
											<img src="${data.foto_promo}" alt="">
											<span class="end-product">${data.akhir_promo} Hari Lagi</span>
										</div>
										<div class="category-promo">
											${data.nama_promo}
										</div>
									</a>`
					})
				}

				$('#promo--content').html(output)
			})
		}

		DrawProductList(page = 1)
		{
			$('#product-list .more-inner').html(`<button class="btn btn-primary" type="button" disabled>
									  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
									  <small>Memuat...</small>
									</button>`)
			var data = {
				client_token: $jp_client_token,
				recent: session.flashdata('recent'),
				page: page
			}
			callApi('product/list/',data,function(res){
				var output = '',
					next = ''
				if (res.Error) {

				}else{
					var data = res.Data,
						pagination = res.Pagination
					$.each(res.Data,(index,data) => {

						let img_produk = '<?php echo base_url('assets/img/default/no-image.png'); ?>';

						if (data.foto_produk != null) {
							img_produk = data.foto_produk;
						}

						output += `<a href="${base_url()}shop/${data.slug_toko}/${data.slug_produk}" class="card product-item">
										<div class="card-header head">
											<img src="${img_produk}">`
											// if (check_auth()) {
											// 	if (data.favorit == 0) {
											// 		output += `<button title="Tambahkan ke wishlist" class="wishlist btn badge badge-light add-to-wishlist produk--favorit" data-produk-id="${data.id_produk}"><i class="fa-heart _icon"></i></button>`
											// 	}else{
											// 		output += `<button title="Tambahkan ke wishlist" class="wishlist btn badge badge-light add-to-wishlist produk--favorit active" data-produk-id="${data.id_produk}"><i class="fa-heart _icon"></i></button>`
											// 	}

											// }
											if (data.preorder == 1) {
												output += `<span class="preorder badge badge-light"><i class="fa fa-bullhorn"></i></span>`
											}
											var harga = '',
												diskon = ''
											if (data.diskon == 0) {
												harga = `<div class="price">Rp ${Format_Rupiah(data.harga)}</div>`
											}else{
												harga = `<span class="price">Rp ${Format_Rupiah(data.harga_diskon.toString())}</span><span class="text-caret fs-13 text-secondary ml-1">Rp ${Format_Rupiah(data.harga)}</span>`
												diskon = `<span class="free-ongkir badge badge-danger">-${data.diskon}%</span>`
											}
								output += `${diskon}
										</div>
										<div class="card-body body">
											<div class="small" title="${data.nama_produk}">${data.nama_produk}</div>
											<div class="price-product">
												${harga}
											</div>
											<div class="dtl">
												<span class="fad fa-sm fa-store"></span>
												<div class="dtl-product">
													<span class="dtl-item">${data.nama_kecamatan}</span>
													<span class="dtl-item">${data.nama_toko}</span>
												</div>
											</div>
											<div class="star_rate">
												<i class="product-rating _${data.rating}-star"></i>
												<span class="counter">(${data.rating})</span>
											</div>
											${$jp_client_token? `<div class="content-add-to-cart">
												<button class="btn btn-sm btn-primary btn-add-to-cart add--product-to-cart"  data-id="${data.id_produk}"><i class="fas fa-cart-plus"></i> Tambahkan ke Keranjang</button>
											</div>` : ''}
											
										</div>
									</a>`

					})

					// if (pagination.Jml_data >= pagination.Limit) {
					// 	next += `<button class="btn btn-more" onclick="home.DrawProductList(${parseInt(pagination.Halaman) + 1})">Muat Lebih Banyak</button>`
					// }

					if (parseInt(pagination.Halaman) < parseInt(pagination.Jml_halaman)) {
						next += `<button class="btn btn-outline-primary" onclick="home.DrawProductList(${parseInt(pagination.Halaman) + 1})">Muat Lebih Banyak</button>`
					}else{
						next += `<button class="btn btn-outline-secondary" disabled>Sudah yang terakhir</button>`
					}

					$('#product-list .more-inner').html(next)

				}

				$('#product-list .w-100 .product--loader').remove()
				$('#product-list .w-100').append(output)
			})
		}

		DrawKategoriList()
		{
			callApi('category/list/',null,res => {
				var output = ''
				if (res.Error) {

				}else{
					output += '<div class="category-content">'
					$.each(res.Data,(no,data) => {
						output += `<div class="category-item">
									<a href="javascript:;" class="box-item text-link search-category" data-id="${data.id_kategori}">
										<img src="${data.icon_kategori?
													data.icon_kategori :
													base_url('assets/img/default/category.png')}" alt="${data.nama_kategori}" class="box-logo">
										<span class="box-title text-elipsis">${data.nama_kategori}</span>
									</a>
								</div>`
					})
					output += '</div>'
				}
				$('#category-list').html(output)
			})
		}

		addProductFavorit(produk_id) {
			callApi("user/product_favorit/add", {
				client_token: $jp_client_token,
				produk_id: produk_id
			}, res => {
				var message = res.Message;
				if (res.Error == true) {
					notifAlert(message, 'error', 5);
				}else{
					this.DrawProduct();
					this.DrawProductList();
					notifAlert(message, 'success', 5);
				}
			})
		}

		drawFooter() {
			let output = $("div.footer-main").html('');

			callApi("footer", null, res => {
				if (res.Data.length == 0) {
					$("div.footer-main").html('');
				}

				let content = '';
				$.each(res.Data, function(index, val) {

					let sub_content = '';

					$.each(val.tab_content, function(tab_content_index, tab_content_val) {
						sub_content += `
							<li><a href="<?php echo base_url('content'); ?>/${tab_content_val.id}">${tab_content_val.title}</a></li>
						`;
					});

					if (val.tab_content.length != 0) {
						content += `
							<div class="footer-item">
								<h3>${val.nama}</h3>
								<ul>
									${sub_content}
								</ul>
							</div>
						`;
					}else{
						content += `
							<div class="footer-item">
								<h3>${val.nama}</h3>
							</div>
						`;
					}
				});

				content += `
					<div class="footer-item">
						<div class="box">
							<a href="https://play.google.com/store/apps/details?id=com.mascitra.jpmall">
								<img src="<?= base_url(''); ?>assets/img/default/MOCKUP SMARTPHONE JPSTORE.png" alt="Mobile App" width="100%">
							</a>
						</div>
					</div>
				`;

				output.append(content);
			})
		}

		get_diskon_produk()
		{
			callApi('product/produk_diskon/',null,function(res){
				if (res.Error) {
					$('#produk-diskon').parents('.produk--diskon').addClass('d-none')
				}else{
					var data = res.Data,
					output = ''

					$.each(data,function(index,key){
						output += `<a href="<?= base_url(); ?>shop/${key.slug_toko}/${key.slug_produk}" class="card flash-item">
									<div class="card-header head">
										<img src="${key.foto_produk}" class="shine">
										<span class="label-discount badge">-${key.diskon}%</span>
									</div>
									<div class="card-body body">
										<div class="small">${key.nama_produk}</div>
										<div class="price-flash-sale">
											<div class="price-original">Rp ${rupiah(key.harga)}</div>
											<div class="price-reduced">Rp ${rupiah(key.harga_diskon)}</div>
										</div>
										<span class="stock_sw">${key.stok} tersisa</span>
									</div>
								</a>`
					})
					$('#produk-diskon').html(output)
					$('#produk-diskon').parents('.produk--diskon').removeClass('d-none')
					$('#produk-diskon').slick({
						// draggable: false,
						infinite: false,
						speed: 300,
						slidesToShow: 5,
						slidesToScroll: 5,
						adaptiveHeight: true,
						variableWidth: true,
					    cssEase: 'linear',
					    responsive: [
						    {
						      breakpoint: 540,
						      settings: {
						        slidesToShow: 2,
						        slidesToScroll: 2,
						      }
						    },
					    ]
					})
				}
			})
		}

	}

	var home = new Home
	
	$('#brand-slider').slick({
		draggable: false,
		infinite: false,
		speed: 300,
		slidesToShow: 5,
		slidesToScroll: 5,
		adaptiveHeight: true,
		variableWidth: true,
		lazyLoad: 'ondemand',
	    lazyLoadBuffer: 0,
	    cssEase: 'linear',
	    responsive: [
		    {
		      breakpoint: 540,
		      settings: {
		        slidesToShow: 2,
		        slidesToScroll: 2,
		      }
		    },
	    ]
	});

	$('#newsletter-readmore').expander({
        slicePoint: 550,
        expandText: 'Selengkapnya',
        userCollapseText: '',
        expandEffect: 'fadeIn',
    });

    $(document).on("click", "button.produk--favorit", function () {
		produk_id = $(this).data('produk-id');
		product.addProductFavorit(produk_id);
	})

	$(document).on('click', 'button.add--product-to-cart', function(event) {
		event.preventDefault();
		home.addToCart({
			produk_id: $(this).data('id'),
			qty: 1,
			catatan: '',
			kategori: "keranjang"
		});
	});

	$(document).on("mouseover", "div.show-password", function () {
		$("div.show-password i").removeClass('fa-eye-slash');
		$("div.show-password i").addClass('fa-eye');
		$("input.password").attr('type', 'text');
	})

	$(document).on("mouseout", "div.show-password", function () {
		$("div.show-password i").removeClass('fa-eye');
		$("div.show-password i").addClass('fa-eye-slash');
		$("input.password").attr('type', 'password');
	})

</script>