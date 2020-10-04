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
												<input type="hidden" class="body" data-id="${data.id_slider}" value="${data.body}"/>
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
			_ckeditor('add-ckeditor');
			$('#Modal .modal-title').html('Tambah Slider')
			$('#Modal').modal('show')
		}

		ModalUpdateDraw(data)
		{
			slider.ModalReset()

			$("#edit div.modal-body").html(`
				<div class="msg-content"></div>
				<div class="form-group">
					<div class="modal-slider-img mb-3">
						<img src="<?= base_url(); ?>cdn/default/slider.jpg" alt="">
					</div>
					<small class="text-muted d-block mb-3"><span class="text-danger">*</span> Note: <i>Gunakan gambar berukuran minimal 1336px x 494px dengan format .png</i></small>
					<button class="btn btn-secondary btn-sm browse-img" type="button"><i class="fa fa-file-image"></i> Browse</button>
					<input type="file" class="d-none file-banner" data-base64="" hidden>
				</div>
				<div class="form-group">
					<label for="">Judul</label>
					<input type="text" class="form-control title" placeholder="Title">
				</div>
				<div class="form-group">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="show" value="1" checked>
						<label class="custom-control-label" for="show">Tampilkan Di Halaman Utama</label>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Body</label>
					<textarea name="" class="form-control edit-ckeditor" id="edit-ckeditor"></textarea>
				</div>
			`);

			this.is_update = true
			this.id_slider = data.id
			$('#edit .modal-title').html('Edit Slider <small class="text-danger">'+data.title+'</small>')
			$('#edit input.title').val(data.title)
			$('#edit .modal-slider-img img').attr('src',data.banner)
			$('#edit input#show').val(data.status).prop('checked',data.status == 1? true : false)
			$("#edit textarea").val($(`input[type=hidden].body[data-id=${this.id_slider}]`).val());
			$('#edit').modal('show')

			_ckeditor('edit-ckeditor');
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
				body = CKEDITOR.instances['add-ckeditor'].getData(),
				data = {
					banner: input_banner,
					title: input_title,
					status: status,
					body: body
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
			var input_banner = $('#edit input.file-banner').attr('data-base64'),
				input_title = $('#edit input.title').val(),
				status = $('#edit input#show').val(),
				body = CKEDITOR.instances['edit-ckeditor'].getData(),
				data = {
					id_slider: this.id_slider,
					banner: input_banner,
					title: input_title,
					status: status,
					body: body
				}
			callApi('admin/slider/update/',data,res => {
				if (res.Error) {
					notif('#edit .msg-content','danger',res.Message,4);
				}else{
					$("#edit").modal('hide');
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
		slider.add()
	});

	$(document).on('submit', '#edit form', function(event) {
		event.preventDefault();
		slider.update()
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