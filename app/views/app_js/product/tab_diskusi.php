<script>
	
	class DiskusiProduk {
		constructor()
		{
			this.load()
		}
		load(page = 1)
		{
			var data = {
				page: page,
				slug: uri_segment(3)
			}
			callApi('product_diskusi/',data,function(res){
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
											<div class="comment-by fs-14 text-muted mb-3">
												<span class="text-dark fw-600">${data.nama_user} </span> ${penjual_status}
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
												<button class="btn btn-sm btn-danger btn--batal-balasan"><i class="fal fa-times-circle"></i>	Batal</button>
												<button class="btn btn-sm btn-success btn--kirim-balasan" data-id="${data.id}"><i class="fal fa-paper-plane"></i>	Kirim</button>
											</div>
										</div>
									</div>`
							}
							output += `</li>`;
					})

					if (parseInt(pagination.Halaman) < parseInt(pagination.Jml_halaman)) {
						next += `<button class="btn btn-outline-orange" onclick="diskusi_produk.load(${parseInt(pagination.Halaman) + 1})"><i class="fal fa-angle-double-down"></i>	Lihat Lainnya</button>`
					}else{
						next += `<button class="btn btn-outline-secondary" disabled><i class="fal fa-ban"></i>	Sudah yang terakhir</button>`
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
		send(teks)
		{
			var data = {
				client_token: $jp_client_token,
				slug: uri_segment(3),
				diskusi: teks
			}
			callApi('product_diskusi/add/',data,function(res){
				if (res.Error) {

				}else{

					diskusi_produk.load()
					$('#pertanyaan--baru').collapse('hide')
					$('#pertanyaan--baru textarea.diskusi').val('')

				}
			})
		}

		balas(teks,diskusi_id)
		{
			var data = {
				client_token: $jp_client_token,
				diskusi_id: diskusi_id,
				slug: uri_segment(3),
				diskusi: teks
			}
			callApi('product_diskusi/balas/',data,function(res){
				if (res.Error) {

				}else{

					diskusi_produk.load()

				}
			})
		}
	}

	var diskusi_produk = new DiskusiProduk

	$(document).on('click', 'button.btn--send-diskusi', function(event) {
		event.preventDefault();
		var teks = $('#pertanyaan--baru textarea.diskusi').val()
		diskusi_produk.send(teks)
	});

	$(document).on('click', 'button.btn--kirim-balasan', function(event) {
		event.preventDefault();
		var teks = $(this).parents('.form--balasan').find('textarea.diskusi-balasan').val()
		diskusi_produk.balas(teks,$(this).attr('data-id'))
		$(this).parents('.form--balasan').find('textarea.diskusi-balasan').val('')
	});

	$(document).on('click', 'button.btn--batal-balasan', function(event) {
		event.preventDefault();
		$(this).parents('.form--balasan').find('textarea.diskusi-balasan').val('')
	});

</script>