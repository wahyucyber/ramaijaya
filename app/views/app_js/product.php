
<script>

	var $jp_client_token = check_auth();
	class Product {

		constructor()
		{
			this.detail();
			this.get_produk_meta()
			this.Produk_id;
			if ($jp_client_token) {
				this.load_chat()
			}
		}
		
		load_chat()
		{
			var data = {
				slug_toko: uri_segment(2),
				client_token: $jp_client_token
			}

			callApi('chat/single/',data,function(res){
				var output = ''
				if (res.Error) {

				}else{

					var data = res.Data

					$.each(data,function(index,data){
						if(data.meta == '1'){
						    output += `<li class="chat--msg-item meta">
                                            <div class="msg--text-content">
                                                <div class="msg--meta">
                                                    <div class="meta--image">
                                                        <img src="${data.meta_image? data.meta_image : base_url('fav.ico')}" alt="">
                                                    </div>
                                                    <div class="meta--info">
                                                        <div class="meta--title" onclick="redirect('${data.meta_url}')">${data.meta_title}</div>
                                                    <div class="meta--description">${data.meta_description}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>`
						}else{
							 output += `
							 <li class="chat--msg-item ${data.reply? 'reply' : ''}"> 
								<div class="msg--text-content"> 
									<div class="msg--text">${data.pesan}</div>
									<div class="msg--since">${data.waktu}</div>
								</div> 
							</li>`

							if(data.files.length != 0) {
								$.each(data.files, function (indexFile, valueFile) { 
									 output += `
										<li class="chat--msg-item ${data.reply? 'reply' : ''}"> 
											<div class="msg--text-content"> 
												<div class="msg--text" style="font-size: 11px;"><a href="${valueFile.file}" target="_blank">${valueFile.file.replace('<?php echo base_url('cdn/chat/'); ?>', '')}</a></div>
												<div class="msg--since">${data.waktu}</div>
											</div> 
										</li>`;
								});
							}
						}
					})

				}
				$('#chat--content').html(output)
				$('.chat--content').trigger('sendChat')
			})
		}
		
		chat_send(content, files)
		{
			var data = {
				slug_toko: uri_segment(2),
				client_token: $jp_client_token,
				pesan: content,
				files: files
			}
			callApi('chat/send/',data,function(res){
				if (res.Error) {

				}else{
					product.load_chat()
				}
			})
		}
		
		chat_send_meta(data)
		{
			var data = {
				slug_toko: uri_segment(2),
				client_token: $jp_client_token,
				meta_url: data.url,
				meta_image: data.image,
				meta_title: data.title,
				files: data.files,
				meta_description: data.description
			}
			callApi('chat/send_meta/',data,function(res){
				if (res.Error) {

				}else{
					product.load_chat()
				}
			})
		}

		get_produk_meta()
		{
			var url = $('meta[property="og:url"]').attr('content')
			callApi('get_urlmeta/',{url: url},function(res){
				if (res.Error) {
					$('.chat--content .placeholder--meta').remove()
				}else{
					var data = res.Data
					$('.chat--content .placeholder--meta').attr('data-url',res.Url)
					$('.chat--content .placeholder--meta').attr('data-image',data.image)
					$('.chat--content .placeholder--meta').attr('data-title',data.title)
					$('.chat--content .placeholder--meta').attr('data-description',data.description)
					$('.chat--content .meta--image img').attr('src',data.image)
					$('.chat--content .meta--title').html(data.title)
					$('.chat--content .meta--description').html(data.description)
				}
			})
		}

		detail() {
			callApi("product/detail", {
				produk_nama: uri_segment(3),
				toko_nama: uri_segment(2),
				client_token: $jp_client_token
			}, res => {
				$.each(res.Data, function(index, val) {
					product.otherProduct({
						produk_id: val.id,
						kategori_id: val.kategori_id,
						toko_id: val.toko_id,
						client_token: $jp_client_token
					});
					this.Produk_id = val.id;
					sessionStorage.setItem('produk_id', val.id);
					$("button.produk--favorit").attr('data-produk-id', val.id);
					$("h3.nama--produk, li.produk--nama").html(val.nama);
					if (val.diskon == 0) {
						$("#harga--produk").html(`<span class="text-harga">Rp ${Format_Rupiah(val.harga)}</span>`);
						$('span.total--beli').html(`Rp ${Format_Rupiah(val.harga)}`)
						$("input.harga--produk").val(val.harga);
					}else{
						$("#harga--produk").html(` 
							<div class="text-secondary text-caret ml-2 d-inline-block fs-16">Rp ${Format_Rupiah(val.harga)}</div>
							<span class="text-harga">Rp ${Format_Rupiah(val.harga_diskon.toString())}</span>
							<small class="badge badge-danger badge-pill fs-11 ml-1">-${val.diskon}% OFF</small>`);
						$('span.total--beli').html(`Rp ${Format_Rupiah(val.harga_diskon.toString())}`)
						$("input.harga--produk").val(val.harga_diskon);
					}

					$('#rating--ulasan').html(`<i class="product-rating _${val.rating}-star"></i>
							<span class="counter ml-1">${val.jumlah_ulasan} ulasan</span>`)

					$("a.kategori--nama").html(val.kategori_nama);
					$(".nama--toko").html(val.toko_nama)
					$('.link--toko').attr('href',base_url('shop/'+uri_segment(2)));
					$("span.toko--kabupaten").html(val.toko_kabupaten_nama);
					if (val.toko_logo == null || val.toko_logo == "") {
						var toko_logo = "<?= base_url(); ?>cdn/fav.png";
					}else{
						var toko_logo = base_url(val.toko_logo);
					}
					if (val.favorit == 0) {
						$("button.produk--favorit").removeAttr('style');
					}else{
						$("button.produk--favorit").attr('style', 'color: red;');
					}
					$("img.toko--logo").attr('src', toko_logo);
					$("div.dilihat--").html(Format_Rupiah(val.dilihat));
					$("div.kondisi--").html(val.kondisi);
					$("div.minimal--beli").html(Format_Rupiah(val.minimal_beli));
					$("input.jumlah_produk").attr({
						"min": val.minimal_beli,
						"value": val.minimal_beli,
						"data-minimal-beli": val.minimal_beli
					});
					$("div.produk--deskripsi").html(val.keterangan);

					$("button.add--to-cart, button.add--to-cart-order").attr({
						"data-produk-id": val.id
					});
                    
					if (val.toko_catatan.length == 0) {
						notif("div.catatan--toko", "warning", `
							<div style="font-size: 13px; font-family: Arial;">
								Toko tidak memiliki catatan apapun.
							</div>
						`);
					}else{
						var catatan = '';
						console.log(val.toko_catatan)
						$.each(val.toko_catatan, function(catatan_index, data) {
							catatan += `<div class="card-body bg-light fs-14 curs-p" data-toggle="collapse" data-target="#catatan--${data.id}-menu">
                                        	${data.judul}
                                        </div>
                                        <div class="card-body collapse fs-11" id="catatan--${data.id}-menu">
                                        	${data.teks}
                                        </div>`;
						});
						$("div.catatan--toko").html(catatan);
					}

					if (val.foto != null) {
						var slider = '',
							slider_nav = '';
						$.each(val.foto, function(foto_index, foto) {
							slider += `<img src="${foto.foto}" alt="">`
							slider_nav += `
								<div class="item curs-p">
									<img src="${foto.foto}" alt="">
								</div>
							`;
						});
						$("div#slider-product-single").html(slider).slick({
						  slidesToShow: 1,
						  slidesToScroll: 1,
						  arrows: false,
						  fade: true,
						  draggable:true,
						  asNavFor: '#slider-product-nav',
						  infinite: true,
						  autoplay: true,
                          autoplaySpeed: 3000,
						  responsive: [
							    {
							      breakpoint: 540,
							      settings: {
									infinite: true,
							        fade: false
							      }
							    },
						    ]
						});
						$("div#slider-product-nav").html(slider_nav).slick({
						  slidesToShow: 3,
						  slidesToScroll: 1,
						  asNavFor: '#slider-product-single',
						  dots: false,
						  centerMode: true,
						  draggable:false,
						  infinite: false,
						  focusOnSelect: true,
						  autoplay: true,
                          autoplaySpeed: 3000
						});
					}
				});
			})
		}

		viewFoto(foto) {
			$("div#slider-product-single").html(`
				<img src="${foto}" alt="" style="width: 100%; height: auto;">
			`);
		}

		getProdukId() {
			return this.Produk_id;
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
				redirect('login')
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
							redirect('cart')
						}
						init_app.getCart();
						$("input.qty").val(minimal_pembelian);
						$("input.catatan").val('');
						notifAlert(pesan, 'success', 5000);
					}
				});
			}
		}

		hitungTotal(value) {
			$("span.total--beli").html('Rp. '+rupiah(value));
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
					this.detail();
					notifAlert(message, 'success', 5);
				}
			})
		}

		otherProduct(params) {
			let kategori_id = params['kategori_id'];
			let toko_id = params['toko_id'];
			let client_token = params['client_token'];
			let produk_id = params['produk_id'];

			let output = $("div.other-product").html('');

			callApi("product/other_product", {
				produk_id: produk_id,
				kategori_id: kategori_id,
				toko_id: toko_id,
				client_token: client_token
			}, res => {
				let content = '';
				$.each(res.Data, function(index, val) {
					let foto = '';
					if (val.foto.length == 0) {
						foto = '<?php echo base_url('assets/img/default/no-image.png'); ?>';
					}else{
						foto = val.foto[0].foto;
					}

					let favorit = '';
					if (val.favorit == 1) {
						favorit = "active";
					}
					var harga = '',
					diskon = ''
					if (val.diskon == 0) {
						harga = `<div class="price">Rp ${Format_Rupiah(val.harga)}</div>`
					}else{
						harga = `<span class="price">Rp ${Format_Rupiah(val.harga_diskon.toString())}</span><span class="text-caret fs-13 text-secondary ml-1">Rp ${Format_Rupiah(val.harga)}</span>`
						diskon = `<span class="free-ongkir badge badge-danger">-${val.diskon}% <br><b class="text-light">OFF</b></span>`
					}

					content += `
						<a href="<?= base_url(); ?>shop/${val.toko_slug}/${val.slug}?tab=1" class="card product-item">
							<div class="card-header head">
								<img src="${foto}">`
								// if (check_auth()) {
								// 	if (data.favorit == 0) {
								// 		output += `<button title="Tambahkan ke wishlist" class="wishlist btn badge badge-light add-to-wishlist produk--favorit" data-produk-id="${data.id_produk}"><i class="fa-heart _icon"></i></button>`
								// 	}else{
								// 		output += `<button title="Tambahkan ke wishlist" class="wishlist btn badge badge-light add-to-wishlist produk--favorit active" data-produk-id="${data.id_produk}"><i class="fa-heart _icon"></i></button>`
								// 	}

								// }
								
					content += `${diskon}
							</div>
							<div class="card-body body">
								<div class="small">${val.nama}</div>
								<div class="price-product">
									${harga}
								</div>
								<div class="dtl">
									<span class="fa fa-sm fa-calendar-check"></span>
									<div class="dtl-product">
										<span class="dtl-item">${val.toko_kabupaten_nama}</span>
										<span class="dtl-item">${val.toko_nama}</span>
									</div>
								</div>
								<div class="star_rate">
									<i class="product-rating _${val.rating}-star"></i>
									<span class="counter">(${val.rating})</span>
								</div>
								${$jp_client_token? `<div class="content-add-to-cart">
												<button class="btn btn-sm btn-orange btn-add-to-cart add--product-to-cart"  data-id="${val.id}"><i class="fal fa-cart-plus"></i> <small>Tambahkan ke Keranjang</small></button>
											</div>` : ''}
							</div>
						</a>
					`;
				});
				output.append(content);
				// $("div#other-product").slick({
				// 	speed: 300,
				// 	slidesToShow: 5,
				// 	infinite: false,
				// 	variableWidth: true,
				// 	dots: true
				// });
			})
		}

		getBase64(file) {
			// for (let index = 0; index < file.length; index++) {
				var reader = new FileReader();
				// reader.readAsDataURL(file[index]);
				reader.readAsDataURL(file);
				reader.onload = function () {
					$("div._files--output").append(`<input type="hidden" name="" class="_files" value="${reader.result}">`);
				};
				reader.onerror = function (error) {
					console.log('Error: ', error);
				};
			// }
		}

	}

	var product = new Product;

	$("#emojionearea").emojioneArea({
      hideSource: false,
		useSprite: false,
		inline: true
    });
	
	function playNotif()
	{
		var audio = new Audio(base_url('assets/audio/chat_notification.mp3'));
		audio.play();
	}

	var ChatingChannel = Pusher.subscribe('chating');
    ChatingChannel.bind('load', function(data) {
    	if(data.Token == $jp_client_token){
    	    product.load_chat()
    	    playNotif()
    	}
    });
	
	$(document).on('click', '.chat--content .btn--chat-send', function(event) {
		event.preventDefault();

		var files = [];
		var no = 1;
		$.each($("input[type=hidden]._files"), function (index, value) { 
			files.push($(this).val());
		});

		var meta_url = $('.chat--content .placeholder--meta').attr('data-url'),
		meta_image = $('.chat--content .placeholder--meta').attr('data-image'),
		meta_title = $('.chat--content .placeholder--meta').attr('data-title'),
		meta_description = $('.chat--content .placeholder--meta').attr('data-description'),
		text = $('.chat--content .form--type-msg').val(),
		data = {
		    url: meta_url,
		    image: meta_image,
			 title: meta_title,
			 files: files,
		    description: meta_description
		}
		if (meta_url && text) {
			product.chat_send_meta(data)
			$('.chat--content .placeholder--meta').remove()
			if(windowSize <= 539){
        	    $('.chat--content .chat--body').css({
        	        height: '600px'
        	    })
        	}else{
        	    $('.chat--content .chat--body').css({
        	        height: '335px'
        	    })
        	}
		}
		product.chat_send(text, files)
		$("div.emojionearea-editor").html('');
		$("div._files--output").html(``);
		$('.chat--content .form--type-msg').val('')
	});

	$(document).on("click", "div.view-foto", function () {
		foto = $(this).data('foto');
		product.viewFoto(foto);
	})

	$(document).on("click", "button.add--to-cart", function () {
		var qty = $("input.qty").val();
		var catatan = $("input.catatan").val();
		var minimal_beli = $("input.qty").data('minimal-beli');

		product.addToCart({
			produk_id: $(this).data('produk-id'),
			qty: qty,
			catatan: catatan,
			minimal_pembelian: minimal_beli,
			kategori: "keranjang"
		});
	})

	$(document).on('click', 'button.add--product-to-cart', function(event) {
		event.preventDefault();
		product.addToCart({
			produk_id: $(this).data('id'),
			qty: 1,
			catatan: '',
			kategori: "keranjang"
		});
	});

	$(document).on("click", "button.add--to-cart-order", function () {
		var qty = $("input.qty").val();
		var catatan = $("input.catatan").val();
		var minimal_beli = $("input.qty").data('minimal-beli');

		product.addToCart({
			produk_id: $(this).data('produk-id'),
			qty: qty,
			catatan: catatan,
			minimal_pembelian: minimal_beli,
			kategori: "beli"
		});
	})

	$(document).on("click", "div.qty-plus", function () {
		qty = parseInt($("input.jumlah_produk").val());
		harga = parseInt($("input.harga--produk").val());
		console.log(qty * harga);
		product.hitungTotal((qty + 1) * harga);
	})

	$(document).on("click", "div.qty-min", function () {
		qty = parseInt($("input.jumlah_produk").val());
		harga = parseInt($("input.harga--produk").val());
		product.hitungTotal((qty - 1) * harga);
	})

	$(document).on("click", "button.produk--favorit", function () {
		produk_id = $(this).data('produk-id');
		if ($jp_client_token) {
			product.addProductFavorit(produk_id);
		}else{
			redirect('login?continue='+base_url(window.location.pathname))
		}

	})

	$(document).on("click", "div._files", function() {
		$("input[type=file]._files").trigger('click');
	})

	$(document).on("change", "input[type=file]._files", function(e) {
		for (let index = 0; index < e.target.files.length; index++) {
			product.getBase64(e.target.files[index]);
		}
	})
	

</script>

<?php 
if ($_GET['tab'] == '1') {
	include 'product/tab_info.php';
}else if ($_GET['tab'] == '2') {
	include 'product/tab_ulasan.php';
}else if ($_GET['tab'] == '3') {
	include 'product/tab_diskusi.php';
}
 ?>