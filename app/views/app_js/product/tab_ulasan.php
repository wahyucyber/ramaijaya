<script>
	class Info {
		constructor() {
			this.ulasan();
			this.JmlPage = 0;
		}

		ulasan(page = 1) {
			// let output = $("ul.ulasan--list").html('');
			callApi("product/ulasan", {
				produk_nama: uri_segment(3),
				page: page
			}, res => {
				let content = ``;
				if (res.Error) {

				}else{
					var pagination = res.Pagination,
						next = ''
					$.each(res.Data, function(index, val) {
						let rating = val.rating;
						let rating_icon = ``;

						for (var i = 1; i <= rating; i++) {
							rating_icon += `<i class="fa fa-star rate_icon star-fill"></i>`;
						}

						let ulasan_foto = ``;

						if (val.ulasan_foto) {
							$.each(val.ulasan_foto, function(foto_index, foto_val) {
								ulasan_foto += `
									<img src="${foto_val.foto}" alt="">
								`;
							});
						}

						content += `
							<li class="list-reviews-container"> <!-- loop -->
								<div class="list-box-content">
									<div class="list-box-comment">
										<div class="mb-2">
											<span class="rate_reviews">
												${rating_icon}
											</span>
										</div>
										<div class="comment-by fs-14 text-muted mb-3">
											<span>Oleh </span>
											<span class="text-dark fw-600">${val.user_nama}</span>
											<span class="fs-12 text-white-lightern-3">${val.created_at}</span>
										</div>
										<div class="list-box-text">
											<div class="review--img-box mb-3">
												${ulasan_foto}
											</div>
											<span class="text-review text-muted fs-14">${val.ulasan}</span>
										</div>
									</div>`
									if (val.reply) {
										$.each(val.reply,function(index,data){
											content += `<div class="review-response">
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
					content += `</div>
							</li>
						`;
					});

					if (parseInt(pagination.Halaman) < parseInt(pagination.Jml_halaman)) {
						next += `<button class="btn btn-outline-primary" onclick="produk_info.ulasan(${parseInt(pagination.Halaman) + 1})">Muat Lebih Banyak</button>`
					}else{
						next += `<button class="btn btn-outline-secondary" disabled>Sudah yang terakhir</button>`
					}
					$('#Pagination').html(next)
				}
				if (page == 1) {
					$("ul.ulasan--list").html(content);
				}else{
					$("ul.ulasan--list").append(content);
				}
			})
		}
	}

	let produk_info = new Info;

</script>