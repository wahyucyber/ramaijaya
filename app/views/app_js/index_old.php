<script type="text/javascript">

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
			
		}

		run()
		{
			var data = {
				client_token: $jp_client_token
			}
			callApi('get_token/',data,res => {
				if (res.Error) {
					session.destroy_userdata($storage)
					notifAlert(res.Message,'error')
				}else{
					this.Role = res.Data.role
					this.UserId = res.Data.id_user
					this.NamaUser = res.Data.nama_user
					init_app.AccountDraw(res.Data)
					$('#navbar #form-keyword').addClass('_363be')
					$('#navbar #navbar_right').addClass('_363be')

					<?php if(segment(1) !== 'seller' && segment(1) !== 'admin'): ?>
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
											output_category_header += `
												<li>
													<a href="${link_kategori}">${data.nama_kategori}</a>
												</li>
											`;
											var sub_kategori = data.sub_kategori
											output += `<li class="category--nav-item">
															<a href="javascript:;" class="parent-category search-category" data-id="${data.id_kategori}">
																${data.nama_kategori}`
																if (sub_kategori) {
																	output += `<span class="fal fa-angle-right right--arrow"></span>`
																}
															output += `</a>`
															if (sub_kategori) {
																output += `<ul class="sub-category--nav-list">`
																	$.each(sub_kategori,(index, data) => {
																		output += `<li class="sub-category--nav-item">
																					<a href="javascript:;" class="child-category search-category" data-id="${data.id_kategori}">
																						<img src="${data.icon_kategori}" alt="" class="sub-category--icon">
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
			$("div.category-header2 ul").html(output_category_header);

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
				output += `<div class="dropdowns to-left">
								<a href="${link_cart}" class="btn btn-dropdowns"><i class="fad fa-shopping-cart icon--btn-dropdowns"></i> <span class="badge badge-info" style="margin-top: -1px; color: white; margin-left: -5px; display: inline-block; position: absolute; padding: 4px;">${jumlah_keranjang}</span></a>
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
										total_keranjang += data.harga * data.jumlah;
										output += `<a href="${base_url('cart')}" class="cart--nav-list-item">
													<img src="${data.produk_foto[0].foto}" alt="">
													<div class="cart--nav-list-title">
														<span>${data.produk_nama}</span>
													</div>
													<div class="cart--nav-list-detail">
														<div class="price">Rp ${rupiah(data.harga * data.jumlah)}</div>
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
							<a href="${link_cart}" class="btn btn-dropdowns"><i class="fad fa-shopping-cart icon--btn-dropdowns"></i></a>
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
												<div class="menu--card-nav-detail">
													<img src="${data.logo_toko? data.logo_toko : base_url('assets/img/default/shop.png')}" alt="" class="menu--card-nav-avatar">
													<div class="menu--card-nav-detail-info">
														<a href="javascript:;" class="text-dark">
															<h3 class="m-0 fs-16">${data.nama_toko}`
												if (data.status_toko == 1) {

													output += `<i class="fad fa-check-circle fs-15 text-success"></i>`
												}
												output += `</h3>
														</a>
														<div class="m-0">
															<label for="" class="fs-11 text-white-lightern-3">Regular Merchant</label>
														</div>
													</div>
												</div>
												<div class="nav--menu-list">
													<ul class="list-group">
														<li><a href="${base_url('seller/penjualan')}" class="list-group-item list-group-item-action">Pesanan</a></li>
														<li><a href="${base_url('seller/product')}" class="list-group-item list-group-item-action">Daftar Produk </a> </li>
														<li><a href="${base_url('seller/setting/shop')}" class="list-group-item list-group-item-action">Pengaturan Toko</a></li>
													</ul>
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
											<div class="menu--card-nav-detail">
												<img src="${data.foto_user?data.foto_user : base_url('assets/img/default/profile.jpg')}" alt="" class="menu--card-nav-avatar profil--img">
												<div class="menu--card-nav-detail-info">
													<a href="" class="text-dark">
														<h3 class="m-0 fs-16">${data.nama_user}`
														if (data.status == 1) {
															output += `<i class="fad fa-check-circle fs-15 text-success"></i>`
														}
										output += `</h3></a>
													<div class="m-0">
														<label for="" class="fs-11 text-white-lightern-3">Klik Untuk Melihat Profil</label>
													</div>
												</div>
											</div>
											<div class="nav--menu-list">
												<ul class="list-group col-md-6">`
												if(data.role == 1){
													output += `<li><a href="${base_url()}admin/dashboard" class="list-group-item list-group-item-action">Administrator</a></li>`
												}else{
													output += `
													<li><a href="${base_url('user/pembelian')}" class="list-group-item list-group-item-action">Pembelian</a>
													</li>
													<!--<li><a href="${base_url('wishlist')}" class="list-group-item list-group-item-action">Wishlist</a>
													</li>
													<li><a href="${base_url('fav_shop')}" class="list-group-item list-group-item-action">Toko Favorit</a></li>-->`
												}
												if (data.role == 2) {
													var link_profile = `${base_url('user/profil?tab=profil')}`;
												}else if (data.role == 1) {
													var link_profile = `${base_url('profile')}`;
												}
												output +=`
													<li><a href="${link_profile}" class="list-group-item list-group-item-action">Pengaturan Akun</a>
													</li>
												</ul>
											</div>
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
		                    return {
		                    	status: true,
		                        label: item.label, 
		                        // slug: item.slug,
		                        slug: encodeURIComponent(item.label),
		                        category: item.kategori,
		                        logo: item.logo? item.logo : '',
		                        kabupaten: item.kabupaten? item.kabupaten : ''
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

	$(document).on('click', '#modalLogout button[type=submit]', function(event) {
		var cookie = new Cookie;
		event.preventDefault();
		session.destroy_userdata($userdata)
		cookie.remove('role')
		redirect('')
	});

	$(document).on("click", "a.search-category", function () {
		let id = $(this).data('id');
		let q = $("form.search input[name=q]").val();

		window.location=`<?php echo base_url('search'); ?>?q=${q}&st=produk&kategori=${id}`;
	})

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

					redirect('')

				}
			})
		}

	}

	$(document).on('submit', '#modalLogin form', function(event) {
		event.preventDefault();
		new Login
	});

</script>