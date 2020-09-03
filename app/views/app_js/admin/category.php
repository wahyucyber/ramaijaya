<?php include 'Adm.php' ?>

<script type="text/javascript">
	
	class Category {

		constructor()
		{
			this.is_update = false
			this.id_kategori = null
			this.run()
		}

		run(page = 1)
		{
			this.ModalReset()
			this.ModalListKategori()
			var Tabel = new Table;
			Tabel.run({
				tabel: "table.tabel-category",
				url: 'admin/category/',
				columns: [
					{
						data: null,
						render: function (data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1 + '.';
						}
					},
					{
						data: null,
						className: "d-flex align-items-center",
						render: function (data) {
							var icon_kategori = data.icon_kategori?
							data.icon_kategori :
							base_url('assets/img/default/category.png')

							return `
								<div class="modal-sub-icon" style="max-width: 100px;">
									<img src="${icon_kategori}"> 
								</div>
								<b>${data.nama_kategori}</b>
							`;
						}
					},
					{
						data: null,
						render: function (data) {
							var output = '';
							if (data.kategori) {
								output += `<ul class="list-group">
												<li>
													~ <small class="name">${data.kategori.nama_kategori}</small>
												</li>
											</ul>`
							}else{
								output += `<small class="text-primary">Ya</small> `
							}

							return output;
						}
					},
					{
						data: null,
						render: res => {
							if (res.kategori_id == 0) {
								return `
									<button type="button" class="btn btn-info btn-sm set-down" data-id="${res.id_kategori}"><i class="fa fa-angle-down"></i></button> 
									<button type="button" class="btn btn-info btn-sm set-up" data-id="${res.id_kategori}"><i class="fa fa-angle-up"></i></button>
								`;
							}else{
								return '-';
							}
						}
					},
					{
						data: null,
						render: function (data) {
							var icon_kategori = data.icon_kategori?
							data.icon_kategori :
							base_url('assets/img/default/category.png')

							return `
							<button class="btn btn-primary btn-sm btn-update" 
								data-icon="${icon_kategori}"
								data-nama="${data.nama_kategori}"
								data-kategori="${data.kategori_id}"  
								data-id="${data.id_kategori}"
							><i class="fa fa-edit"></i></button>
							<button class="btn btn-danger btn-sm btn-delete"
								 data-icon="${icon_kategori}"
								 data-nama="${data.nama_kategori}"
								 data-kategori="${data.kategori_id}"  
								 data-id="${data.id_kategori}"
							 ><i class="fa fa-trash-alt"></i></button>
							`;
						}
					}
				]
			});
		}

		ModalListKategori()
		{
			callApi('admin/category/list/',null,res => {

				var output = ''

				if (res.Error) {
					output += '<option value="0" selected>Ya</option>'
				}else{
					var result = res.Data
					output += '<option value="0" selected>Ya</option>'
					$.each(result,(index,data) => {
						output += `<option value="${data.id_kategori}">${data.nama_kategori}</option>`
					})

				}

				$('#Modal select.kategori').html(output).select2()

			})
		}

		ModalReset()
		{
			$('#Modal').modal('hide')
			$('#Modal .msg-content').html('')
			$('#Modal input.nama').val('')
			$('#Modal select.kategori').val(0).trigger('change')
			$('#Modal .modal-sub-icon img').attr('src',base_url('assets/img/default/category.png'));
			$('#Modal input.file-icon').attr('data-base64','')

			$('#ModalConfirm').modal('hide')
			$('#ModalConfirm .modal-body').html('')
		}

		ModalAddDraw()
		{
			category.ModalReset()
			this.is_update = false
			$('#Modal .modal-title').html('Tambah Kategori')
			$('#Modal').modal('show')

		}

		ModalConfirmDraw(data)
		{
			category.ModalReset()
			this.is_update = false
			this.id_kategori = data.id
			$('#ModalConfirm .modal-body').html(`
				<div class="alert alert-warning">
					Apakah anda yakin ingin menghapus data : <br> ~ <strong>${data.nama_kategori}</strong> ?
				</div>
			`)
			$('#ModalConfirm').modal('show')
		}

		ModalUpdateDraw(data)
		{
			category.ModalReset()
			this.is_update = true
			this.id_kategori = data.id
			$('#Modal .modal-title')
				.html('Edit Kategori <small class="text-danger">'+data.nama_kategori+'</small>')
			$('#Modal input.nama').val(data.nama_kategori)
			$('#Modal select.kategori').val(data.kategori_id).trigger('change')
			$('#Modal .modal-sub-icon img')
				.attr('src',data.icon_kategori? data.icon_kategori : base_url('assets/img/default/category.png'));
			$('#Modal').modal('show')
		}

		add()
		{
			var nama = $('#Modal input.nama').val(),
				icon = $('#Modal input.file-icon').attr('data-base64'),
				kategori = $('#Modal select.kategori').val(),
				data = {
					nama: nama,
					icon: icon,
					kategori: kategori
				}

			callApi('admin/category/add/',data,res => {
				if (res.Error) {
					notif('#Modal .msg-content','danger',res.Message,4);
				}else{
					notif('.content--page .msg-content','success',res.Message,4);
					category.run()
				}

			})
		}

		update()
		{
			var nama = $('#Modal input.nama').val(),
				icon = $('#Modal input.file-icon').attr('data-base64'),
				kategori = $('#Modal select.kategori').val(),
				data = {
					id_kategori: this.id_kategori,
					nama: nama,
					icon: icon,
					kategori: kategori
				}

			callApi('admin/category/update/',data,res => {
				if (res.Error) {
					notif('#Modal .msg-content','danger',res.Message,4);
				}else{
					notif('.content--page .msg-content','success',res.Message,4);
					category.run()
				}

			})
		}

		delete()
		{
			var data = {
					id_kategori: this.id_kategori
				}

			callApi('admin/category/delete/',data,res => {
				if (res.Error) {
					$('#ModalConfirm').modal('hide')
					notif('.content--page .msg-content','danger',res.Message,4);
				}else{
					notif('.content--page .msg-content','success',res.Message,4);
					category.run()
				}

			})
		}

		setUp(params) {
			let id = params['id'];

			callApi("admin/category/set_up", {
				id: id
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					this.run();
					notifAlert(message, "success", 5);
				}
			})
		}

		setDown(params) {
			let id = params['id'];

			callApi("admin/category/set_down", {
				id: id
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					this.run();
					notifAlert(message, "success", 5);
				}
			})
		}

	}

	var category = new Category

	var upload_image = new UploadImage

	upload_image.options(0,0)

	$(document).on('click', '#pagination .btn-page[data-page]', function(event) {
		event.preventDefault();
		category.run($(this).data('page'))
	});

	$(document).on('submit', '#Modal form', function(event) {
		event.preventDefault();
		if(category.is_update){
			category.update()
		}else{
			category.add()
		}
	});

	$(document).on('click','#Modal .browse-img', function(event) {
		event.preventDefault();
		$('#Modal input.file-icon').trigger('click')
	});

	$(document).on('change','#Modal input.file-icon', function(e) {
		e.preventDefault();
		upload_image.get_base64(this,$('#Modal .modal-sub-icon img'),e);

	});

	$(document).on('click','.content--page button.btn-update', function(event) {
		event.preventDefault();
		var data = {
			id: $(this).data('id'),
			icon_kategori: $(this).data('icon'),
			nama_kategori: $(this).data('nama'),
			kategori_id: $(this).data('kategori'),
		}
		category.ModalUpdateDraw(data)
	});

	$(document).on('click','.content--page button.btn-delete', function(event) {
		event.preventDefault();
		var data = {
			id: $(this).data('id'),
			icon_kategori: $(this).data('icon'),
			nama_kategori: $(this).data('nama'),
			kategori_id: $(this).data('kategori'),
		}
		category.ModalConfirmDraw(data)
	});

	$(document).on('click', '#ModalConfirm button[type=submit]', function(event) {
		event.preventDefault();
		category.delete()
	});

	$(document).on("click", "button.set-up", function () {
		let id = $(this).data('id');

		category.setUp({
			id: id
		});
	})

	$(document).on("click", "button.set-down", function () {
		let id = $(this).data('id');

		category.setDown({
			id: id
		});
	})
</script>