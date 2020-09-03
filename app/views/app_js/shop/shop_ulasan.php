<?php require 'Shop.php' ?>

<script>
	
	class Shop_Ulasan {
		constructor()
		{
			this.load()
		}

		load(page = 1)
		{
			var data = {
				slug: uri_segment(2),
				client_token: $jp_client_token,
				page: page
			}
			callApi('shop/ulasan/',data,function(res){
				var output = '',
					next = ''
				if (res.Error) {
					output += `<div class="jumbotron bg-white text-center shadow-sm">
							<h4>Tidak ada ulasan</h4>
						</div>`
				}else{

					var data = res.Data,
						pagination = res.Pagination
					$.each(data,function(index,data){
						var ulasan_foto = '',
							rating_icon = ''
						if (data.ulasan_foto) {
							$.each(data.ulasan_foto,function(index,data){
								ulasan_foto += `<img src="${data.foto}" alt="">`
							})
						}
						for (var i = 0; i < data.rating; i++) {
							rating_icon += `<i class="fa fa-star rate_icon star-fill"></i>`;
						}
						output += `<li class="list-reviews-container"> <!-- loop -->
										<div class="list-box-content">
											<div class="list-box-comment">
												<div class="mb-1">
													<span class="rate_reviews">
														${rating_icon}
													</span>
												</div>
												<div class="mb-1">
													<span class="text-muted fs-14">Produk >> </span> <a href="${base_url(`shop/${uri_segment(2)}/${data.slug_produk}`)}" class="text-link fs-14">${data.nama_produk}</a>
												</div>
												<div class="comment-by fs-14 text-muted mb-3">
													<span>Oleh </span>
													<span class="text-dark fw-600">${data.user_nama}</span>
													<span class="fs-12 text-white-lightern-3">${data.created_at}</span>
												</div>
												<div class="list-box-text">
													<div class="review--img-box mb-3">
														${ulasan_foto}
													</div>
													<span class="text-review text-muted fs-14">${data.ulasan}</span>
												</div>
											</div>`
											if (data.reply) {
												$.each(data.reply,function(index,data){
													output += `<div class="review-response">
																	<div class="comment-by fs-14 text-muted">
																		<span>Oleh </span>
																		<span class="text-dark fw-600">${data.user_nama} </span>
																	</div>
																	<div class="mb-3">
																		<span class="badge badge-success badge-pill fs-11">Penjual</span>
																		<span class="fs-12 text-white-lightern-3">${data.created_at}</span>
																	</div>
																	<div class="list-box-text">
																		<span class="text-review text-muted fs-14">${data.ulasan}</span>
																	</div>
																</div>`
												})
											}
							output += `</div>
									</li>
								`;

					})
					if (pagination.Jml_halaman > 1) {
						next += `<button class="btn btn-outline-primary" onclick="ulasan_toko.load(${parseInt(pagination.Halaman) + 1})">Muat Lebih Banyak</button>`
					}else{
						next += `<button class="btn btn-outline-secondary" disabled>Sudah yang terakhir</button>`
					}

				}
				$('.ulasan--list').html(output)
				$('#Pagination').html(next)
			})
		}

	}

	var ulasan_toko = new Shop_Ulasan

</script>