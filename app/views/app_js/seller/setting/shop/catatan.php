<?php include __DIR__.'/../../Seller.php' ?>

<script>
	
	class Catatan {
		constructor()
		{
			this.updated = false
			this.catatan_id = 0
			this.load()
		}

		load(page = 1)
		{
			this.ModalReset()
			var data = {
				client_token: $jp_client_token,
				page: page
			}
			callApi('seller/catatan/',data,function(res){
				var output = ''
				if (res.Error) {
					output += `<div class="jumbotron jumbotron-fluid text-center rounded">
									<h5>${res.Message}</h5>
									<p>Tambahkan kebijakan serta syarat & ketentuan toko anda pada catatan toko di halaman toko anda</p>
									<button class="btn btn-sm btn-info" onclick="catatan.ModalAdd()"><i class="fas fa-plus"></i> Tambah catatan</button>
								</div>`
					AjaxPagination.clear()
				}else{
					var data = res.Data,
						pagination = res.Pagination
						AjaxPagination.make(pagination,'#pagination')
					output += `<div class="card">
									<div class="card-header">
										<h5 class="fs-16 mb-0">Judul Catatan</h5>
									</div>
									<div class="catatan--list">`
						$.each(data,function(index,data){
							output += `<div class="card-body d-flex">
										<h6 class="fs-13">${data.judul}</h6>
										<div class="ml-auto">
											<button class="btn btn-sm btn-info btn--preview" data-judul="${data.judul}" data-teks="${data.teks}"><i class="fa fa-eye"></i> Preview</button>
											<button class="btn btn-sm btn-primary btn--update" data-judul="${data.judul}" data-teks="${data.teks}" data-id="${data.id}"><i class="fa fa-edit"></i> Ubah</button>
											<button class="btn btn-sm btn-danger btn--delete" data-judul="${data.judul}" data-id="${data.id}"><i class="fa fa-trash-alt"></i> Hapus</button>
										</div>
									</div>`
						})
					output += `</div>
							</div>`
				}
				$('#data--catatan').html(output)
			})
		}

		add()
		{
			var data = {
				client_token: $jp_client_token,
				judul: $('#Modal input.judul').val(),
				teks: $('#Modal textarea.teks').val()
			}

			callApi('seller/catatan/add/',data,function(res){
				if (res.Error) {
                    notif('#Modal .msg--modal','danger',res.Message,5)
				}else{
					catatan.load()
				}
			})
		}

		update()
		{
			var data = {
				client_token: $jp_client_token,
				catatan_id: this.catatan_id,
				judul: $('#Modal input.judul').val(),
				teks: $('#Modal textarea.teks').val()
			}

			callApi('seller/catatan/update/',data,function(res){
				if (res.Error) {
                    notif('#Modal .msg--modal','danger',res.Message,5)
				}else{
					catatan.load()
				}
			})
		}

		delete()
		{
			var data = {
				client_token: $jp_client_token,
				catatan_id: this.catatan_id
			}

			callApi('seller/catatan/delete/',data,function(res){
				if (res.Error) {
				    catatan.load()
                    notif('.msg--content','danger',res.Message,5)
				}else{
					catatan.load()
				}
			})
		}

		ModalReset()
		{
			this.catatan_id = 0
			this.updated = false
			$('#Modal').modal('hide')
			$('#Modal input').val('')
			$('#Modal textarea').val('')
			$('#ModalConfirm').modal('hide')
		}

		ModalAdd()
		{
			catatan.ModalReset()
			$('#Modal .modal-title').html('Tambah Catatan')
			$('#Modal').modal('show')
		}

		ModalEdit(data)
		{
			catatan.ModalReset()
			this.catatan_id = data.catatan_id
			this.updated = true
			$('#Modal .modal-title').html('Edit Catatan ('+data.judul+')')
			$('#Modal input.judul').val(data.judul);
			$('#Modal textarea.teks').val(data.teks);
			$('#Modal').modal('show')
		}

		ModalDelete(data)
		{
			catatan.ModalReset()
			this.catatan_id = data.catatan_id
			$('#ModalConfirm .modal--title strong').html(data.judul)
			$('#ModalConfirm').modal('show')
		}

		ModalPreview(data)
		{
			catatan.ModalReset()
			$('#ModalPreview .judul').html(data.judul)
			$('#ModalPreview .teks').html(data.teks)
			$('#ModalPreview').modal('show')
		}
	}

	var catatan = new Catatan
	
	$(document).on('click','#pagination [data-page]',function(e){
	    e.preventDefault()
	    catatan.load($(this).attr('data-page'))
	})

	$(document).on('submit', '#Modal form', function(event) {
		event.preventDefault();
		if(catatan.updated){
			catatan.update()
		}else{
			catatan.add()
		}
	});

	$(document).on('submit', '#ModalConfirm form', function(event) {
		event.preventDefault();
		catatan.delete()
	});

	$(document).on('click', 'button.btn--update', function(event) {
		event.preventDefault();
		var data = {
			catatan_id: $(this).attr('data-id'),
			judul: $(this).attr('data-judul'),
			teks: $(this).attr('data-teks')
		}
		catatan.ModalEdit(data)
	});

	$(document).on('click', 'button.btn--preview', function(event) {
		event.preventDefault();
		var data = {
			judul: $(this).attr('data-judul'),
			teks: $(this).attr('data-teks')
		}
		catatan.ModalPreview(data)
	});

	$(document).on('click', 'button.btn--delete', function(event) {
		event.preventDefault();
		var data = {
			catatan_id: $(this).attr('data-id'),
			judul: $(this).attr('data-judul')
		}
		catatan.ModalDelete(data)
	});

</script>