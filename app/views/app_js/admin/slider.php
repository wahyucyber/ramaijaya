<?php include 'Adm.php' ?>

<script>
	
	class Slider {

		constructor()
		{
			this.is_update = false
			this.id_slider = null
			this.run()
		}

		run(page = 1)
		{
			this.ModalReset()
			var data = {
				page: page
			}
			callApi('admin/slider/',data,res => {
				var output = ''

				if (res.Error) {
					output += `<div class="col-md-12">
									<div class="alert bg-light text-center">${res.Message}</div>
								</div>`
					$('#pagination').html('')
				}else{
					
					var result = res.Data,
						paging = res.Pagination,
						no = paging.Data_ke

					var pagination = new Pagination
					pagination.make(paging,$('#pagination'))

					$.each(result,(index,data) => {
						output += `
							<div class="col-md-6 slide-item mb-4 ${(data.status == 1)? 'active' : ''}">
								<div class="card">
									<div class="card-header">
										<img src="${base_url(data.banner_slider)}" alt="">
									</div>
									<div class="card-body"><div class="row align-items-center h-100">
											<div class="col-md-7 d-flex align-items-center">
												<h5 class="card-title font-weight-bold">${data.title}</h5> 
											</div>
											<div class="col-md-5 text-right">
												<button class="btn btn-primary btn-sm mr-1 btn-update" 
													data-status="${data.status}" 
													data-banner="${data.banner_slider}" 
													data-title="${data.title}" 
													data-id="${data.id_slider}"
												><i class="fa fa-edit"></i> Edit</button>
												<button class="btn btn-danger btn-sm btn-delete" 
													data-status="${data.status}" 
													data-banner="${data.banner_slider}" 
													data-title="${data.title}" 
													data-id="${data.id_slider}"
												><i class="fa fa-trash-alt"></i> Hapus</button>
											</div>
										</div>
									</div>
								</div>
							</div>`;
					})


				}

				$('#slider-content').html(`<div class="row">
											${output}
										</div>`)

			})
		}

		ModalReset()
		{
			this.id_slider = null
			this.is_update = false
			$('#Modal').modal('hide')
			$('#Modal .modal-slider-img img').attr('src',base_url('assets/img/default/slider.jpg'))
			$('#Modal input.title').val('')
			$('#Modal input#show').val(1).prop('checked',true)
			$('#Modal input.file-banner').attr('data-base64','')
			$('#Modal .msg-content').html('')

			$('#ModalConfirm').modal('hide')
			$('#ModalConfirm .modal-body').html('')
		}

		ModalAddDraw()
		{
			slider.ModalReset()
			this.is_update = false
			$('#Modal .modal-title').html('Tambah Slider')
			$('#Modal').modal('show')
		}

		ModalUpdateDraw(data)
		{
			slider.ModalReset()
			this.is_update = true
			this.id_slider = data.id
			$('#Modal .modal-title').html('Edit Slider <small class="text-danger">'+data.title+'</small>')
			$('#Modal input.title').val(data.title)
			$('#Modal .modal-slider-img img').attr('src',data.banner)
			$('#Modal input#show').val(data.status).prop('checked',data.status == 1? true : false)
			$('#Modal').modal('show')
		}

		ModalConfirmDraw(data)
		{
			slider.ModalReset()
			this.is_update = false
			this.id_slider = data.id
			$('#ModalConfirm .modal-body').html(`
				<div class="alert alert-warning">
					Apakah anda yakin ingin menghapus data : <br> ~ <strong>${data.title}</strong> ?
				</div>
			`)
			$('#ModalConfirm').modal('show')
		}

		add()
		{
			var input_banner = $('#Modal input.file-banner').attr('data-base64'),
				input_title = $('#Modal input.title').val(),
				status = $('#Modal input#show').val(),
				data = {
					banner: input_banner,
					title: input_title,
					status: status
				}
			callApi('admin/slider/add/',data,res => {
				if (res.Error) {
					notif('#Modal .msg-content','danger',res.Message,4);
				}else{
					notif('.content--page .msg-content','success',res.Message,4);
					slider.run()
				}
			})
		}

		update()
		{
			var input_banner = $('#Modal input.file-banner').attr('data-base64'),
				input_title = $('#Modal input.title').val(),
				status = $('#Modal input#show').val(),
				data = {
					id_slider: this.id_slider,
					banner: input_banner,
					title: input_title,
					status: status
				}
			callApi('admin/slider/update/',data,res => {
				if (res.Error) {
					notif('#Modal .msg-content','danger',res.Message,4);
				}else{
					notif('.content--page .msg-content','success',res.Message,4);
					slider.run()
				}
			})
		}

		delete()
		{
			var data = {
				id_slider: this.id_slider
			}

			callApi('admin/slider/delete/',data,res => {

				if (res.Error) {
					$('#ModalConfirm').modal('hide')
					notif('.content--page .msg-content','danger',res.Message,4);
				}else{
					notif('.content--page .msg-content','success',res.Message,4);
					slider.run()
				}

			})
		}

	}

	var slider = new Slider

	var upload_image = new UploadImage

	upload_image.options(880,293)

	$(document).on('click', '#pagination .btn-page[data-page]', function(event) {
		event.preventDefault();
		slider.run($(this).data('page'))
	});

	$(document).on('click','#Modal .browse-img', function(event) {
		event.preventDefault();
		$('#Modal input.file-banner').trigger('click')
	});

	$(document).on('change','#Modal input.file-banner', function(e) {
		e.preventDefault();
		upload_image.get_base64(this,$('#Modal .modal-slider-img img'),e);
	});

	$(document).on('change', '#Modal input#show', function(event) {
		event.preventDefault();
		$(this).val(this.checked ? 1 : 0);
	});

	$(document).on('click', 'button.btn-update', function(event) {
		event.preventDefault();
		var data = {
			status: $(this).data('status'),
			banner: $(this).data('banner'),
			title: $(this).data('title'),
			id: $(this).data('id')
		}
		slider.ModalUpdateDraw(data)
	});
	
	$(document).on('submit', '#Modal form', function(event) {
		event.preventDefault();
		if(slider.is_update){
			slider.update()
		}else{
			slider.add()
		}
	});

	$(document).on('click', 'button.btn-delete', function(event) {
		event.preventDefault();
		var data = {
			title: $(this).data('title'),
			id: $(this).data('id')
		}
		slider.ModalConfirmDraw(data)
	});

	$(document).on('click', '#ModalConfirm button[type=submit]', function(event) {
		event.preventDefault();
		slider.delete()
	});

</script>