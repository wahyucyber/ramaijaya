<?php include 'Seller.php' ?>

<script>
	
	class UlasanDetail {
		constructor()
		{
			this.load()
		}
		load()
		{
			var data = {
				client_token: $jp_client_token,
				ulasan_id: uri_segment(4)
			}
			callApi('seller/ulasan/detail/',data,function(res){
				var output = ''
				if (res.Error) {



				}else{

					var data = res.Data
					var rate = ''
					var foto_ulasan = ''

					for(var i = 0;i < data.rating;i++){
						rate += `<i class="fa fa-star rate_icon star-fill"></i>`
					}

					if (data.ulasan_foto) {
						$.each(data.ulasan_foto,function(index,data){
							foto_ulasan += `<img src="${data.foto}" alt=""">`
						})
					}

					output += `<li class="list-reviews-container mb-0"> <!-- loop -->
								<div class="list-box-content">
									<div class="list-box-comment">
										<div class="mb-2">
											<span class="rate_reviews" title="">
												${rate}
											</span>
										</div>
										<div class="comment-by fs-14 text-muted mb-3">
											<span>Oleh </span>
											<span class="text-dark fw-600">${data.user_nama}</span>
											<span class="fs-12 text-white-lightern-3">${data.created_at}</span>
										</div>
										<div class="list-box-text">
											<div class="review--img-box mb-3">
												${foto_ulasan}
											</div>
											<span class="text-review text-muted fs-14">${data.ulasan}</span>
										</div>
									</div>
									`
									var reply = data.reply
									if (reply) {
										$.each(reply,function(index,data){
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
									}else{
										output += `<div class="review-response">
														<div class="form-group">
															<textarea rows="1" class="form-control ulasan" placeholder="Masukkan jawaban anda disini"></textarea>
														</div>
														<div class="text-right">
															<button class="btn btn-secondary btn-sm">Batal</button>
															<button class="btn btn-success btn-sm btn--kirim-ulasan" data-id="${data.id}">Kirim</button>
														</div>
													</div>`
									}
					output += `</div>
							</li>`

				}
				$('#ulasan--content').html(output)
			})
		}
		send(id,teks)
		{
			var data = {
				client_token: $jp_client_token,
				ulasan_id: id,
				ulasan: teks
			}
			callApi('seller/ulasan/add/',data,function(res){
				if (res.Error) {

				}else{
					ulasan_detail.load()
				}
			})
		}
	}

	var ulasan_detail = new UlasanDetail

	$(document).on('click', 'button.btn--kirim-ulasan', function(event) {
		event.preventDefault();
		var teks = $('textarea.ulasan').val()
		ulasan_detail.send($(this).attr('data-id'),teks)
	});

</script>