<?php include 'Adm.php' ?>

<script>
	
	class Diskusi {
		constructor()
		{
			this.diskusi_id = 0
			this.load()
		}
		load(page = 1)
		{
			callApi('admin/diskusi/',null,function(res){
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
						var action = ''
						if (data.diblokir == 1) {
							action = `<span class="badge badge-danger fs-13">Diblokir</span>
									<span class="text-info fs-12">${data.catatan_diblokir}</span>
									<div class="mt-2">
										<button class="btn btn-sm btn-warning p-1 fs-12" onclick="diskusi.set_id('${data.id}')" data-toggle="modal" data-target="#ModalOpenBlokir">Buka Blokir</button>
									</div>`
						}else{
							action = `<button class="btn btn-sm btn-secondary p-1 fs-12" onclick="diskusi.set_id('${data.id}')" data-toggle="modal" data-target="#ModalBlokir">Blokir</button>`
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
															<span class="text-dark fw-600 d-block">${data.nama_produk}</span>
															<small class="text-secondary">${data.nama_toko}</small>
														</div>
													</div>
												</div></div>
											</div>
										</div>
										<div class="list-box-comment">
											<div class="comment-by fs-14 text-muted mb-3">
												<span class="text-dark fw-600">${data.nama_user}</span>
												<span class="fs-12 text-white-lightern-3"> - ${data.tanggal}</span>
											</div>
											<div class="list-box-text">
												<div class="review--img-box mb-3">
													${diskusi_foto}
												</div>
												<span class="text-review text-muted fs-14">${data.diskusi}</span>
											</div>
											<div class="comment--overlay">
												${action}
											</div>
										</div>`
										if (data.reply) {
											$.each(data.reply,function(index,data){
												var sub_action = ''
												if (data.diblokir == 1) {
													sub_action = `<span class="badge badge-danger fs-13">Diblokir</span>
															<span class="text-info fs-12">${data.catatan_diblokir}</span>
															<div class="mt-2">
																<button class="btn badge badge-warning fs-12" onclick="diskusi.set_id('${data.id}')" data-toggle="modal" data-target="#ModalOpenBlokir">Buka Blokir</button>
															</div>`
												}else{
													sub_action = `<button class="btn btn-sm btn-secondary p-1 fs-12" onclick="diskusi.set_id('${data.id}')" data-toggle="modal" data-target="#ModalBlokir">Blokir</button>`
												}
												output += `<div class="review-response">
																<div class="comment-by fs-14 text-muted">
																	<span class="text-dark fw-600">${data.nama_user} </span>
																	<span class="fs-12 text-white-lightern-3"> - ${data.tanggal}</span>
																</div>
																<div class="list-box-text">
																	<span class="text-review text-muted fs-14">${data.diskusi}</span>
																</div>
																<div class="comment--overlay">
																	${sub_action}
																</div>
															</div>`
											})
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
		set_id(id)
		{
			this.diskusi_id = id
		}
		blokir_diskusi(catatan)
		{
			callApi('admin/diskusi/set/',{blokir: 1,diskusi_id: this.diskusi_id,catatan_diblokir: catatan},function(res){
				if (res.Error) {
					notif('#ModalBlokir .msg-content','danger',res.Message)
				}else{
					// this.diskusi_id = 0
					$('#ModalBlokir').modal('hide')
					diskusi.load()
				}
			})
		}
		bukablokir_diskusi()
		{
			callApi('admin/diskusi/set/',{diskusi_id: this.diskusi_id},function(res){
				if (res.Error) {

				}else{
					// this.diskusi_id = 0
					$('#ModalOpenBlokir').modal('hide')
					diskusi.load()
				}
			})
		}
	}
	var diskusi = new Diskusi

	$(document).on('submit', '#ModalBlokir form', function(event) {
		event.preventDefault();
		var catatan = $('#ModalBlokir input.catatan').val()
		diskusi.blokir_diskusi(catatan)
	});

	$(document).on('submit', '#ModalOpenBlokir form', function(event) {
		event.preventDefault();
		diskusi.bukablokir_diskusi()
	});

</script>