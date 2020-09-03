<?php include 'Adm.php' ?>

<script>
	
	class Promo {
		constructor()
		{
			this.KodePromo = null
			this.PromoId = null
			this.is_update = false
			this.run()
		}

		run()
		{
			this.ModalReset()
			callApi('admin/promo/',null,res => {
				var output = ''
				if (res.Error) {
					output += `<div class="col-md-12">
									<div class="alert bg-light text-center">${res.Message}</div>
								</div>`
					$('#pagination').html('')
				}else{

					var pagination = new Pagination
					pagination.make(res.Pagination,$('#pagination'))

					$.each(res.Data,(index,data) => {
						output += `<div class="col-md-3 mb-4">
							          <div class="card border-0 shadow">
							            <div class="card-body p-0">
							              <img src="${data.foto_promo? data.foto_promo : base_url('assets/img/default/promo.jpg')}" alt="" class="card-img">
							            </div>
							            <div class="card-body  ${data.status == 0? 'border-danger' : 'border-success'}"  style="border-left: 2px solid;">
							              <h5 class="card-title fs-15 fw-600">${data.nama_promo}</h5>
							              <div class="row mb-3">
							                <div class="col-6">
							                  <small>Kode Promo</small>
							                </div>
							                <div class="col-6">
							                  <h6 class="fw-700 fs-13 bg-secondary p-1 text-light text-center mb-0">${data.kode_promo}</h6>
							                </div>
							              </div>
							              <div class="row mb-3">
							                <div class="col-6">
							                  <small>Potongan</small>
							                </div>
							                <div class="col-6 d-flex">
							                  <h6 class="fs-12 fw-600 mb-0 my-auto">${data.potongan}%</h6>
							                </div>
							              </div>
							              <div class="row mb-3">
							                <div class="col-6">
							                  <small>Akhir Promo</small>
							                </div>
							                <div class="col-6 d-flex">
							                  <h6 class="fs-12 fw-600 mb-0 my-auto">${data.akhir_promo} Hari Lagi</h6>
							                </div>
							              </div>
							              <button class="btn btn-sm btn-primary btn-edit" title="Edit"
							              data-foto="${data.foto_promo}"
							              data-nama="${data.nama_promo}"
							              data-kode="${data.kode_promo}"
							              data-potongan="${data.potongan}"
							              data-jangka="${data.jangka_waktu}"
							              data-status="${data.status}"
							              data-id="${data.id_promo}"><i class="fad fa-pencil-alt"></i> Edit</button>

							              <button class="btn btn-sm btn-danger btn-delete" title="Hapus"
							              data-nama="${data.nama_promo}"
							              data-kode="${data.kode_promo}"
							              data-status="${data.status}"
							              data-id="${data.id_promo}"><i class="fad fa-trash-alt"></i> Hapus</button>
							            </div>
							          </div>
							        </div>   `
					})

				}

				$('.content--page .promo--content').html(`<div class="row">
        									${output}
      									</div>`)
			})
		}

		ModalReset()
		{
			this.is_update = false
			this.KodePromo = null
			$('#Modal .modal-title').html('');
			$('#Modal .img--promo').attr('src',base_url('assets/img/default/promo.jpg'))
			$('#Modal input.data-base64').attr('data-base64','')
			$('#Modal input').val('')
			$('#Modal input.potongan').val(0)
			$('#Modal input#auto-generate').val(0).prop('checked',false).trigger('change')
			$('#Modal input#status--promo').val(1).prop('checked',true).trigger('change')
			$('#Modal input#auto-generate').parents('.form-group').show()
			$('#Modal').modal('hide')

			$('#ModalConfirm').modal('hide')
			$('#ModalConfirm .modal-body').html('')
		}

		ModalDraw()
		{
			promo.ModalReset()
			this.is_update = false
			$('#Modal .modal-title').html('Tambah Promo');
			$('#Modal').modal('show')
		}

		ModalEditDraw(data)
		{
			promo.ModalReset()
			this.KodePromo = data.kode_promo
			this.PromoId = data.id_promo
			this.is_update = true
			$('#Modal .modal-title').html('Edit Promo '+data.nama_promo);
			$('#Modal .img--promo').attr('src',data.foto_promo)
			$('#Modal input.nama').val(data.nama_promo)
			$('#Modal input.jangka-waktu').val(data.jangka_waktu)
			$('#Modal input#auto-generate').parents('.form-group').hide()
			$('#Modal input#status--promo').val(data.status).prop('checked',data.status == 1? true : false).trigger('change')
			$('#Modal input.potongan').val(data.potongan)
			$('#Modal').modal('show')
		}

		ModalConfirmDraw(data)
		{
			promo.ModalReset()
			this.is_update = false
			this.KodePromo = data.kode_promo
			this.PromoId = data.id_promo
			$('#ModalConfirm .modal-body').html(`
				<div class="alert alert-warning">
					Apakah anda yakin ingin menghapus : <br>
					 ~ Promo : <strong>${data.nama_promo}</strong> ? <br>
					 ~ Dengan kode promo : <strong>${data.kode_promo}</strong>
				</div>
			`)
			$('#ModalConfirm').modal('show')
		}

		add()
		{
			var foto = $('#Modal input.data-base64').attr('data-base64'),
				nama_promo = $('#Modal input.nama').val(),
				kode_promo = $('#Modal input.kode-promo').val(),
				auto_generate = $('#Modal input#auto-generate').val(),
				status = $('#Modal input#status--promo').val(),
				potongan = $('#Modal input.potongan').val(),
				jangka_waktu = $('#Modal input.jangka-waktu').val(),
				data = {
					foto: foto,
					nama_promo: nama_promo,
					kode_promo: kode_promo,
					auto_generate: auto_generate,
					potongan: potongan,
					jangka_waktu: jangka_waktu,
					status: status
				}
			callApi('admin/promo/add/',data,res => {
				if (res.Error) {
					notif('#Modal .msg-content','danger',res.Message,5)
				}else{
					promo.run()
					notifAlert(res.Message,'success',5)
				}
			})
		}

		edit()
		{
			var foto = $('#Modal input.data-base64').attr('data-base64'),
				nama_promo = $('#Modal input.nama').val(),
				potongan = $('#Modal input.potongan').val(),
				jangka_waktu = $('#Modal input.jangka-waktu').val(),
				status = $('#Modal input#status--promo').val(),
				data = {
					kode_promo: this.KodePromo,
					id_promo: this.PromoId,
					foto: foto,
					nama_promo: nama_promo,
					potongan: potongan,
					jangka_waktu: jangka_waktu,
					status: status
				}
			callApi('admin/promo/edit/',data,res => {
				if (res.Error) {
					$('#ModalConfirm').modal('hide')
					notifAlert(res.Message,'error',5)
				}else{
					promo.run()
					notifAlert(res.Message,'success',5)
				}
			})
		}

		delete()
		{
			var data = {
					kode_promo: this.KodePromo,
					id_promo: this.PromoId
				}
			callApi('admin/promo/delete/',data,res => {
				if (res.Error) {
					notif('#Modal .msg-content','danger',res.Message,5)
				}else{
					promo.run()
					notifAlert(res.Message,'success',5)
				}
			})
		}
	}

	var promo = new Promo

	var upload_image = new UploadImage

	upload_image.options(500,500,true)

	$(document).on('click', '#pagination .btn-page[data-page]', function(event) {
		event.preventDefault();
		category.run($(this).data('page'))
	});

	$(document).on('click', '#Modal button.browse-img', function(event) {
		event.preventDefault();
		$('#Modal input.data-base64').trigger('click')
	});

	$(document).on('change', '#Modal input.data-base64', function(event) {
		
		upload_image.get_base64(this,$('#Modal .img--promo'),event)
		
	});

	$(document).on('submit', '#Modal form', function(event) {
		event.preventDefault();
		if (promo.is_update) {
			promo.edit()
		}else{
			promo.add()
		}
	});

	$(document).on('change', '#Modal input#auto-generate', function(event) {
		$(this).val(this.checked? 1 : 0)	
		$('#Modal input.kode-promo').attr('disabled',this.checked? true : false)
	});

	$(document).on('change', '#Modal input#status--promo', function(event) {
		$(this).val(this.checked? 1 : 0)	
	});

	$(document).on('input', '#Modal input.potongan', function(event) {
		
		if($(this).val() > 99){
			$(this).val(99)
		}
		
	});

	$(document).on('click', '.btn-edit', function(event) {
		event.preventDefault();
		var data = {
			id_promo: $(this).attr('data-id'),
			foto_promo: $(this).attr('data-foto'),
			nama_promo: $(this).attr('data-nama'),
			kode_promo: $(this).attr('data-kode'),
			potongan: $(this).attr('data-potongan'),
			jangka_waktu: $(this).attr('data-jangka'),
			status: $(this).attr('data-status')
		}
		promo.ModalEditDraw(data)
	});

	$(document).on('click', '.btn-delete', function(event) {
		event.preventDefault();
		var data = {
			id_promo: $(this).attr('data-id'),
			nama_promo: $(this).attr('data-nama'),
			kode_promo: $(this).attr('data-kode'),
			status: $(this).attr('data-status')
		}
		promo.ModalConfirmDraw(data)
	});

	$(document).on('click', '#ModalConfirm button[type=submit]', function(event) {
		event.preventDefault();
		promo.delete()
	});

</script>