<?php include 'Seller.php' ?>

<script>

	class Diskusi {
		constructor()
		{
			this.load()
		}

		load(page = 1)
		{
			var data = {
				page: page,
				client_token: $jp_client_token
			}
			callApi('seller/diskusi/',data,function(res){
				var output = ''
				if (res.Error) {
					output += `<li class="discuss-list-container">
						<div class="alert alert-light text-center border-light">Tidak ada diskusi</div>
					</li>`
				}else{
					var data = res.Data
					var pagination = res.Pagination,
							next = ''
					$.each(data,function(index,data){
						var diskusi_foto = ''
						if (data.diskusi_foto) {
							$.each(data.diskusi_foto,function(index,data){
								diskusi_foto += `<img src="${data.foto}" alt="">`
							})
						}
						var penjual_status = ''
						if (data.penjual == 1) {
							penjual_status = `<span class="badge badge-success">Penjual</span>`
						}
						output += `<li class="list-reviews-container"> <!-- loop -->
									<div class="list-box-content">
										<div class="list-box-comment">
											<div class="comment-by fs-14 text-muted">
												<div class="card shadow-sm border-0"><div class="card-body">
													<div class="row">
														<div class="col-4 col-lg-1">
															<img src="${data.foto_produk}" alt="">
														</div>
														<div class="col-8 col-lg-11 pl-0">
															<span class="text-dark fw-600">${data.nama_produk}</span>
														</div>
													</div>
												</div></div>
											</div>
										</div>
										<div class="list-box-comment">
											<div class="comment-by fs-14 text-muted mb-3">
												<span class="text-dark fw-600">${data.nama_user}</span>${penjual_status}
												<span class="fs-12 text-white-lightern-3"> - ${data.tanggal}</span>
											</div>
											<div class="list-box-text">
												<div class="review--img-box mb-3">
													${diskusi_foto}
												</div>
												<span class="text-review text-muted fs-14">${data.diskusi}</span>
											</div>
										</div>`
										if (data.reply) {
											$.each(data.reply,function(index,data){
												var balas_status = ''
												if (data.penjual == 1) {
													balas_status = `<span class="badge badge-success">Penjual</span>`
												}
												output += `<div class="review-response">
																<div class="comment-by fs-14 text-muted">
																	<span class="text-dark fw-600">${data.nama_user} </span>${balas_status}
																	<span class="fs-12 text-white-lightern-3"> - ${data.tanggal}</span>
																</div>
																<div class="list-box-text">
																	<span class="text-review text-muted fs-14">${data.diskusi}</span>
																</div>
															</div>`
											})
										}
							if (check_auth()) {
								output += `<div class="review-response form--balasan">
											<div class="form-group">
												<textarea rows="1" class="form-control diskusi-balasan" placeholder="Balas diskusi.."></textarea>
											</div>
											<div class="text-right">
												<button class="btn btn-secondary btn--batal-balasan">Batal</button>
												<button class="btn btn-success btn--kirim-balasan" data-id="${data.id}">Kirim</button>
											</div>
										</div>
									</div>`
							}
							output += `</li>`;
					})

					if (parseInt(pagination.Halaman) < parseInt(pagination.Jml_halaman)) {
						next += `<button class="btn btn-outline-primary" onclick="diskusi.load(${parseInt(pagination.Halaman) + 1})">Muat Lebih Banyak</button>`
					}else{
						next += `<button class="btn btn-outline-secondary" disabled>Sudah yang terakhir</button>`
					}
					$('#Pagination').html(next)
				}
				if (page == 1) {
					$('.diskusi--list').html(output)
				}else{
					$('.diskusi--list').append(output)
				}
			})
		}
		balas(teks,diskusi_id)
		{
			var data = {
				client_token: $jp_client_token,
				diskusi_id: diskusi_id,
				diskusi: teks
			}
			callApi('seller/diskusi/balas/',data,function(res){
				if (res.Error) {

				}else{

					diskusi.load()

				}
			})
		}
	}

	var diskusi = new Diskusi

	$(document).on('click', 'button.btn--kirim-balasan', function(event) {
		event.preventDefault();
		var teks = $(this).parents('.form--balasan').find('textarea.diskusi-balasan').val()
		diskusi.balas(teks,$(this).attr('data-id'))
	});
	
</script>