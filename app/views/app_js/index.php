 <script src="https://js.pusher.com/6.0/pusher.min.js"></script>
    <script>
    // 	Pusher.logToConsole = true;
    
        var Pusher = new Pusher('<?= env('PUSHER_APP_KEY'); ?>', {
          	cluster: '<?= env('PUSHER_APP_CLUSTER'); ?>'
        });
        
</script>
    
<script>

	var $jp_client_token = check_auth();

	var windowSize = $(window).width()

	class InitApp {

		constructor()
		{
			this.Role = null;
			this.MessageShop = ''
			this.UserId = null
			this.NamaUser = null
			if (!$jp_client_token) {
				this.CartDraw([])
				this.NotAccountDraw()
			}else{
				// this.getShop();
				this.run()
			}
			this.getCategory()
			this.drawFooter()
			
		}

		run()
		{
			var data = {
				client_token: $jp_client_token
			}
			callApi('get_token/',data,res => {
				if (res.Error) {
					cookie.remove($userdata[1])
					this.CartDraw([])
					this.NotAccountDraw()
				}else{
					this.Role = res.Data.role
					this.UserId = res.Data.id_user
					this.NamaUser = res.Data.nama_user
					init_app.AccountDraw(res.Data)
					$('#navbar #form-keyword').addClass('_363be')
					$('#navbar #navbar_right').addClass('_363be')
                    this.Notification()
                    // this.ChatNotification()
					<?php if(segment(1) !== 'admin'): ?>
						this.getCart()
						this.getShop()
					<?php endif ?>

				}
			})
		}

		getCategory()
		{
			callApi('category/',null,res => {
				if (res.Error) {
					init_app.CategoryDraw()
				}else{
					if (windowSize > 539) {
						<?php if(segment(1) !== 'seller' && segment(1) !== 'admin'): ?>
						init_app.CategoryDraw(res.Data)
						<?php endif ?>
					}else{
						init_app.CategoryDraw_mobile(res.Data)
					}
				}
			})
		}

		CategoryDraw(result = null)
		{
			var output = ''
			var output_category_header = '';
			if (result) {
				output += `<div class="dropdowns">
								<a href="" class="btn btn-dropdowns">Kategori</a>
								<div class="dropdowns-item">
									<ul class="category--nav-list">`
										$.each(result,(index, data) => {
											// let output_subcategory_header;
											// if (data.sub_kategori.length != 0) {
											// 	output_subcategory_header = `
											// 		<div>
											// 			<span>${data.nama_kategori}</span>
											// 			<ul>
											// 	`;
											// 	$.each(data.sub_kategori, (index, data) => {
											// 		output_subcategory_header += `
											// 			<li><a href="javascript:;" class="search-category" data-id="${data.id_kategori}">${data.nama_kategori}</a></li>
											// 		`;
											// 	});
											// 	output_subcategory_header += `
											// 			</ul>
											// 		</div>
											// 	`;
											// }
											let link_kategori;
											if (data.sub_kategori.length == 0) {
												link_kategori = `<?php echo base_url(''); ?>search?q=&st=produk&kategori=${data.id_kategori}`;
											}else{
												link_kategori = `<?php echo base_url(''); ?>category/${data.id_kategori}`;
											}
											// output_category_header += `
											// 	<li>
											// 		<a href="${link_kategori}">${data.nama_kategori}</a>
											// 	</li>
											// `;
											var sub_kategori = data.sub_kategori
											output += `<li class="category--nav-item">
															<a href="javascript:;" class="parent-category search-category" data-id="${data.id_kategori}">
																${data.nama_kategori}`
																if (sub_kategori.length > 0) {
																	output += `<span class="fal fa-angle-right right--arrow"></span>`
																}
															output += `</a>`
															if (sub_kategori.length > 0) {
																output += `<ul class="sub-category--nav-list">`
																	$.each(sub_kategori,(index, data) => {
																		output += `<li class="sub-category--nav-item">
																					<a href="javascript:;" class="child-category search-category" data-id="${data.id_kategori}">
																						<img src="${base_url(data.icon_kategori)}" alt="" class="sub-category--icon">
																						<span class="label--sub">${data.nama_kategori}</span>
																					</a>
																				</li>`
																	})
																output += `</ul>`
															}		
												output += `</li>`
										})		
						output += `</ul>
								</div>
							</div>`
			}else{
				output += `<div class="dropdowns">
								<a href="" class="btn btn-dropdowns">Kategori</a>
							</div>`
			}

			$('#category--nav-list').html(output)
			// $("div.category-header2 ul").html(output_category_header);

			init_app.categorySlide();
		}

		categorySlide() {
			$("ul.category-header-list").slick({
				  speed: 300,
				  slidesToShow: 1,
				  infinite: false,
				  variableWidth: true,
				  dots: false
			});
		}

		CategoryDraw_mobile(result = null)
		{
			var output = ''

			$.each(result,(index, data) => {
				var sub_kategori = data.sub_kategori
				output += `<li class="list-sidebar">
								<a href="javascript:;" class="list-group-item search-category" data-id="${data.id_kategori}">${data.nama_kategori}</a>
							</li>`
			})		

			$('#sidebar--category-list').html(output)
		}

		getCart()
		{
			var output = [];
			var data = {
				client_token: $jp_client_token
			}
			callApi('cart/list',data,res => {
				output = res.Data;
				// if (res.Error == true) {
				// 	init_app.CartDraw();
				// }else{
					init_app.CartDraw(output);
				// }
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
							<a href="">
								<img src="<?= base_url(''); ?>assets/img/default/MOCKUP SMARTPHONE JPSTORE.png" alt="Mobile App" width="100%">
							</a>
						</div>
					</div>
				`;

				output.append(content);
			})

		}
		
		Notification()
		{
			var data = {
				client_token: $jp_client_token
			}
			var html = ''
			callApi('notifikasi/',data,res => {
				var data = res.Data;
				if (res.Error) {
					html += `
						<div class="dropdowns to-left">
							<a href="javascript:;" class="btn btn-dropdowns" title="Notifikasi"><i class="fal fa-bell icon--btn-dropdowns"></i> </a>
							<div class="dropdowns-item">
								<div class="dropdowns-header--sm">
									<button class="btn btn-dropdowns--header"><i class="fa fa-times"></i></button>
									<h5 class="title-dropowns--header">Notifikasi </h5>
								</div>
								<div class="nav--notification pt-2">
									<div class="alert alert-light border text-center mx-2"><small>${res.Message}</small></div>
								</div>
							</div>
						</div>`;
				}else{
					html += `
						<div class="dropdowns to-left">
							<a href="javascript:;" class="btn btn-dropdowns" title="Notifikasi"><i class="fas fa-bell icon--btn-dropdowns"></i> ${res.Jumlah > 0? `<span class="badge badge-info" style="margin-top: -1px; color: white; margin-left: -5px; display: inline-block; position: absolute; padding: 4px;">${res.Jumlah}</span>` : ''}</a>
							<div class="dropdowns-item">
								<div class="dropdowns-header--sm">
									<button class="btn btn-dropdowns--header"><i class="fa fa-times"></i></button>
									<h5 class="title-dropowns--header">Notifikasi </h5>
								</div>
								<div class="nav--notification">
									<ul class="nav--notification-list">`
										$.each(data,function(index,data){
											html += `<li class="nav--notification-item ${data.dilihat == 0? 'active' : ''}" title="${data.konten}">
														<a href="${base_url(data.link)}" data-id="${data.id}" class="notification--item-content notif--list-item">
															<div class="notification--info">
																<strong>${data.tipe} <small class="ml-auto">${data.created_at}</small></strong>
																<p class="mb-0 notification--text">${data.konten}</p>
															</div>
														</a>
													</li>`
										})
							html += `</ul>
								</div>
							</div>
						</div>`;
				}
				$('#navbar_right .notif--user').html(html);
			})
				
		}
		
// 		ChatNotification()
// 		{
// 		    var data = {
// 		        client_token: $jp_client_token
// 		    }
		    
// 		    callApi('notifikasi/chat/',data,function(res){
// 		        if(res.Error){
// 		            $('.nav--menu-list .counter--chat').remove()
// 		        }else{
// 		            var data = res.Data,
// 		            	jumlah = res.Jumlah
// 		            	if(jumlah > 0){
// 		            		$('.nav--menu-list .counter--chat').html(jumlah)
// 		            	}else{
// 		            		$('.nav--menu-list .counter--chat').remove()
// 		            	}
// 		        }
// 		    })
		    
// 		}


		CartDraw(result)
		{
			var output = '';
			if (check_auth() == false) {
				var link_cart = `${base_url('login')}`;
			}else{
				var link_cart = `${base_url('cart')}`;
			}

			if (result.length > 0) {
				let jumlah_keranjang = 0;
				$.each(result, (index,data) => {
					jumlah_keranjang += parseInt(data.jumlah);
				});
				output += `<div class="dropdowns to-left ml-0 ml-lg-1">
								<a href="${link_cart}" class="btn btn-dropdowns"><i class="fal fa-shopping-cart icon--btn-dropdowns"></i> <span class="badge badge-info" style="margin-top: -1px; color: white; margin-left: -5px; display: inline-block; position: absolute; padding: 4px;">${jumlah_keranjang}</span></a>
								<div class="dropdowns-item">
									<div class="dropdowns-header--sm">
										<button class="btn btn-dropdowns--header"><i class="fa fa-times"></i></button>
										<h5 class="title-dropowns--header">Keranjang Belanja</h5>
									</div>
									<div class="cart--nav">
										<div class="cart--nav-content">
											<div class="cart--nav-list">`

									var total_keranjang = 0;
									$.each(result, (index,data) => {
										var harga = ''
										if (data.diskon == 0) {
											total_keranjang += data.harga * data.jumlah;
											harga = `Rp ${rupiah(data.harga * data.jumlah)}`
										}else{
											total_keranjang += data.harga_diskon * data.jumlah;
											harga = `<span class="fs-13 text-caret text-dark">Rp ${rupiah(data.harga * data.jumlah)}</span><br> <span class="fs-14">Rp ${rupiah(data.harga_diskon * data.jumlah)}</span>`
										}
										output += `<a href="${base_url('cart')}" class="cart--nav-list-item">
													<img src="${data.produk_foto[0].foto}" alt="">
													<div class="cart--nav-list-title">
														<span>${data.produk_nama}</span>
													</div>
													<div class="cart--nav-list-detail">
														<div class="price">
														${harga}
														</div>
														<div class="count">${data.jumlah} Buah</div>
													</div>
												</a>`
									})

								output += `</div>
											<div class="see-all">
												<span>Total: <strong>${rupiah(total_keranjang)} Produk</strong></span>
												<a href="${base_url('cart')}">Lihat Semua</a>
											</div>
										</div>
									</div>
								</div>
							</div>`
			}else{
				output += `<div class="dropdowns to-left">
							<a href="${link_cart}" class="btn btn-dropdowns"><i class="fal fa-shopping-cart icon--btn-dropdowns"></i></a>
							<div class="dropdowns-item">
								<div class="dropdowns-header--sm">
									<button class="btn btn-dropdowns--header"><i class="fa fa-times"></i></button>
									<h5 class="title-dropowns--header">Keranjang Belanja</h5>
								</div>

								<div class="cart--nav">
									<div class="cart--nav-empty">
										<div class="cart--nav-empty-inner">
											<p class="cart--nav-empty-title">
												Keranjang Belanja Anda Kosong
											</p>
											<p class="cart--nav-empty-sub-title">
													Untuk saat ini, Anda tidak ada keranjang belanja
											</p>
											<div class="btn-cart--nav-empty">
												<a href="${base_url('cart')}" class="btn btn-sm btn-success">Belanja Sekarang</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>`
			}
			$('#navbar_right .cart--user').html(output);
		}

		getShop()
		{
			var data = {
				client_token: $jp_client_token
			}
			callApi('shop/',data,res => {
				this.MessageShop = res.Message
				if (res.Error) {
					init_app.ShopDraw()
				}else{
					init_app.ShopDraw(res.Data)
					$('#found--shop').html('')
				}
			})
		}

		ShopDraw(data = null)
		{
			var output = ''
			if (data) {
				var menu = ''
				if (data.diblokir == 1) {
					menu += `<div class="alert alert-danger"><small><b>Akun anda di blokir Admin, karena Alasan : </b><br>"${data.catatan_diblokir ?data.catatan_diblokir : 'diBlokir'}", <br> <b>silahkan hubungi Customer Center untuk info lebih lanjut</b></small></div>`
				}else{
					menu += `<div class="nav--menu-list">
								<ul class="list-group">
									<li><a href="${base_url('seller/penjualan')}" class="list-group-item list-group-item-action">Pesanan</a></li>
									<li><a href="${base_url('seller/product')}" class="list-group-item list-group-item-action">Daftar Produk </a> </li>
									<li><a href="${base_url('seller/setting/shop')}" class="list-group-item list-group-item-action">Pengaturan Toko</a></li>
									<li><a href="${base_url('seller/komplain')}" class="list-group-item list-group-item-action">Komplain</a></li>
									<li><a href="${base_url('seller/ulasan')}" class="list-group-item list-group-item-action">Ulasan</a></li>
									<li><a href="${base_url('seller/diskusi')}" class="list-group-item list-group-item-action">Diskusi</a></li>
									<li><a href="${base_url('chat')}" class="list-group-item list-group-item-action">Chat</a></li>
								</ul>
							</div>`
				}
				output += `<div class="dropdowns to-left">
								<a href="javascript:;" class="btn btn-dropdowns with-avatar">
									<img src="${data.logo_toko? data.logo_toko : base_url('assets/img/default/shop.png')}" alt="" class="avatar--dropdowns">
									<span style="max-width: 80%" class="text-elipsis">${data.nama_toko}</span>
								</a>
								<div class="dropdowns-item">
									<div class="dropdowns-header--sm">
										<button class="btn btn-dropdowns--header"><i class="fa fa-times"></i></button>
										<h5 class="title-dropowns--header">Menu Toko</h5>
									</div>
									<div class="shop--nav">
										<div class="menu--card-nav">
											<div class="menu--card-nav-content">
												<div class="menu--card-nav-detail ${data.diblokir == 1? 'border border-danger' : ''}">
													<img src="${data.logo_toko? data.logo_toko : base_url('assets/img/default/shop.png')}" alt="" class="menu--card-nav-avatar">
													<div class="menu--card-nav-detail-info">
														<a href="javascript:;" class="text-dark">
															<h3 class="m-0 fs-16">${data.nama_toko}`
												if (data.status_toko == 1) {

													output += `<i class="fad fa-check-circle fs-15 text-success ml-2"></i>`
												}else{
													output += `<i class="fad fa-times fs-15 text-danger ml-2"></i>`

												}
												output += `</h3>
														</a>
														<div class="m-0">
															<label for="" class="fs-11 text-white-lightern-3">Regular Merchant</label>
														</div>
													</div>
												</div>
												${menu}
												
												<div class="w-100 border-top pt-2 px-3">
													<h6 class="fs-14 mb-0"><?= env('APP_NAME'); ?> Seller</h6>
													<span class="fs-11">Atur & pantau tokomu di satu tempat</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>`
			}else{
				output += `<div class="dropdowns to-left">
								<a href="" class="btn btn-dropdowns with-avatar">
									<img src="${base_url('assets/img/default/shop.png')}" alt="" class="avatar--dropdowns">
									<span style="max-width: 80%" class="text-elipsis">Buka Toko</span>
								</a>
								<div class="dropdowns-item">
									<div class="dropdowns-header--sm">
										<button class="btn btn-dropdowns--header"><i class="fa fa-times"></i></button>
										<h5 class="title-dropowns--header">Menu Toko</h5>
									</div>

									<div class="shop--nav">
										<div class="shop--nav-empty">
											<span class="text-white-lightern-3 fs-12 mb-2 d-block">${init_app.MessageShop}</span>
											<a href="${base_url('my-shop')}" class="text-link d-block btn btn-sm btn-success btn-block mb-2 ${this.Role == '1'? 'disabled' : ''}">Buka Toko</a>
											<a href="javascript:;" class="text-link fs-12 text-success">Pelajari Lebih Lanjut Di Seller Center</a>
										</div>
									</div>
								</div>
							</div>`
			}
			$('#navbar_right .shop--user').html(output);
		}

		AccountDraw(data)
		{
			var menu = '',
			event = ''

			if (data.diblokir == '0') {
				menu += `<div class="nav--menu-list">
							<ul class="list-group col-md-6">`
							if(data.role == 1){
								menu += `<li><a href="${base_url()}admin/dashboard" class="list-group-item list-group-item-action">Administrator</a></li>`
							}else{
								menu += `
								<li><a href="${base_url('user/pembelian')}" class="list-group-item list-group-item-action">Pembelian</a>
								</li>
								<li><a href="${base_url('user/komplain')}" class="list-group-item list-group-item-action">Komplain</a>
								</li>
								<li><a href="${base_url('user/ulasan')}" class="list-group-item list-group-item-action">Ulasan</a>
								</li> 
								<!--<li><a href="${base_url('wishlist')}" class="list-group-item list-group-item-action">Wishlist</a>
								</li>
								<li><a href="${base_url('fav_shop')}" class="list-group-item list-group-item-action">Toko Favorit</a></li>-->`
							}
							// if (data.role == 2) {
								var link_profile = `${base_url('user/profil?tab=profil')}`;
							// }else if (data.role == 1) {
							// 	var link_profile = `${base_url('user/profil')}`;
							// }
							menu +=`
								<li><a href="${link_profile}" class="list-group-item list-group-item-action">Pengaturan Akun</a>
								</li>
								<li><a href="${base_url('chat')}" class="list-group-item list-group-item-action">Chat <!-- <span class="badge badge-info counter--chat" style="color: white;position: absolute;top: 50%;right: 10px;transform: translateY(-50%);display: inline-block;"></span> --></a>
								</li>
							</ul>
						</div>`
				event = `onclick="redirect('user/profil?tab=profil')"`;
			}else{
				menu += `<div class="alert alert-danger"><small><b>Akun anda di blokir Admin, karena Alasan : </b><br>"${data.catatan_diblokir ?data.catatan_diblokir : 'diBlokir'}", <br> <b>silahkan hubungi Customer Center untuk info lebih lanjut</b></small></div>`
			}

			var output = `<div class="dropdowns to-left">
							<a href="javascript:;" class="btn btn-dropdowns with-avatar">
								<img src="${data.foto_user?data.foto_user : base_url('assets/img/default/profile.jpg')}" alt="" class="avatar--dropdowns profil--img">
								<span style="max-width: 80%" class="text-elipsis">${data.nama_user}</span>
							</a>
							<div class="dropdowns-item">
								<div class="dropdowns-header--sm">
									<button class="btn btn-dropdowns--header"><i class="fa fa-times"></i></button>
									<h5 class="title-dropowns--header">Menu Profil </h5>
								</div>

								<div class="account--nav">
									<div class="menu--card-nav">
										<div class="menu--card-nav-content">
											<div class="menu--card-nav-detail ${data.diblokir == 1? 'border border-danger' : ''}">
												<img src="${data.foto_user?data.foto_user : base_url('assets/img/default/profile.jpg')}" alt="" class="menu--card-nav-avatar profil--img">
												<div class="menu--card-nav-detail-info">
													<a href="javascript:;" class="text-dark" ${event}>
														<h3 class="m-0 fs-16">${data.nama_user}`
														if (data.status == 1 && data.diblokir == 0) {
															output += `<i class="fad fa-check-circle fs-15 text-success ml-2"></i>`
														}else{
															output += `<i class="fad fa-times fs-15 text-danger ml-2"></i>`

														}
										output += `</h3></a>
													<div class="m-0">
														<label for="" class="fs-11 text-white-lightern-3">Klik Untuk Melihat Profil</label>
													</div>
												</div>
											</div>
											${menu}
											<div class="col-12 text-right mb-3">
												<a href="javascript:;" class="text-link text-danger mr-3" data-toggle="modal" data-target="#modalLogout">
													<span>Keluar</span> <i class="fad fa-sign-out-alt"></i>
												</a>
											</div>
											<div class="w-100 border-top pt-2 px-3">
												<h6 class="fs-14 mb-0"><?= env('APP_NAME'); ?> Seller</h6>
												<span class="fs-11">Atur & pantau tokomu di satu tempat</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>`
			$('#navbar_right .account--user').html(output)
		}

		NotAccountDraw()
		{
			var output = `
						<div class="btn-login-sm-inner">
							<button class="btn btn-login-sm" onclick="redirect('login')" title="Masuk"><i class="fa fa-sign-in-alt"></i></button>
						</div>
						<div class="btn-login-inner">
							<button class="btn btn-login" data-toggle="modal" data-target="#modalLogin">Masuk</button>
						</div>
						<div class="btn-register-inner">
							<button class="btn btn-register" onclick="redirect('register')"><i class="fal fa-sign-in-alt d-xl-none"></i><span>Daftar</span></button>
						</div>`;
			$('#navbar_right .account--user').html(output)
		}

	}

	var init_app = new InitApp
	
	function playNotification()
	{
	    var audio = new Audio(base_url('assets/audio/notification.mp3'));
		audio.play();
	}
	
	var NotificationChannel = Pusher.subscribe('notification');
    NotificationChannel.bind('load', function(data) {
    	if(data.Token == $jp_client_token){
    	    init_app.Notification()
    	    playNotification()
    	   // init_app.ChatNotification()
    	}
    });
	
	$(document).on('click','.notif--list-item',function(e){
	    e.preventDefault()
	    var link = $(this).attr('href')
	    var data = {
	        client_token: $jp_client_token,
	        id: $(this).attr('data-id')
	    }
	    callApi('notifikasi/set_baca/',data,function(res){
	        if(res.Error){
	            
	        }else{
	            redirect(link)
	        }
	    })
	})
	
	$(function() {
		$('#navbar-search-input').catcomplete({
			appendTo: $('#result-autocomplete'),
			delay: 0,
			minLength:0,
			source: function(request, response){

				callApi('search/',{
					q: request.term, 
					recent: session.flashdata('recent')
				},res => {

					if (res.Error) {

						var error = [{
										status: false,
				                        label: "Data tidak ditemukan",
				                        slug: ''
									}]

						response(error)

					}else{

						// response($.each(res.Data, function(index, item) {
						// 	return {
		    //                 	status: true,
		    //                     label: item.label, 
		    //                     // slug: item.slug,
		    //                     slug: encodeURIComponent(item.label),
		    //                     category: item.kategori,
		    //                     logo: item.logo? item.logo : '',
		    //                     kabupaten: item.kabupaten? item.kabupaten : ''
		    //                 }
						// }));

						
						response($.map(res.data, function (item) {
		                    if (item.kategori == '' || item.kategori == 'rekomendasi') {
		                    	return {
			                    	status: true,
			                        label: item.label, 
			                        // slug: item.slug,
			                        slug: encodeURIComponent(item.label),
			                        category: item.kategori,
			                        logo: item.logo? item.logo : '',
			                        kabupaten: item.kabupaten? item.kabupaten : ''
			                    }
		                    }else{
		                    	return {
			                    	status: true,
			                        label: item.label, 
			                        // slug: item.slug,
			                        slug: item.slug,
			                        category: item.kategori,
			                        logo: item.logo? item.logo : '',
			                        kabupaten: item.kabupaten? item.kabupaten : ''
			                    }
		                    }
		                }))

					}

				})

			},
			response: function(e, result) {
				if (!result.content.length) {
				}
			}

		}).bind('focus', function(){ $(this).catcomplete("search"); } );
	})

	$(document).on("click", "a.search-category", function () {
		let id = $(this).data('id');
		let q = $("form.search input[name=q]").val();

		window.location=`<?php echo base_url('search'); ?>?q=${q}&st=produk&kategori=${id}`;
	})
	
	var current_url = $('meta[property="og:url"]').attr('content')

	class Login {

		constructor()
		{
			this.run()
		}

		run(){
			var email = $('#modalLogin input.email').val(),
				password = $('#modalLogin input.password').val(),
				data = {
					email: email,
					password: password
				}
			callApi('login/',data,function(res){
				if(res.Error){
					notif('#modalLogin .msg-content','danger',res.Message)
				}else {
					notif('#modalLogin .msg-content','success',res.Message)
					$('#modalLogin input').val('')
					var data = res.Data
					cookie.set(data)

					redirect(current_url)

				}
			})
		}

	}

	$(document).on('submit', '#modalLogin form', function(event) {
		event.preventDefault();
		new Login
	});
	
	$(document).on('click', '#modalLogout button[type=submit]', function(event) {
		gapi.auth2.getAuthInstance().signOut();
		var cookie = new Cookie;
		event.preventDefault();
		session.destroy_userdata($userdata)
		cookie.remove('role')
		FB.logout();
		redirect('');
	});

	$('input._daterangepicker').daterangepicker({
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
	});

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

	$('[data-toggle="tooltip"]').tooltip();

</script>