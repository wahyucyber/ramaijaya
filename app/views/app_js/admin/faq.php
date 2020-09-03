<?php include 'Adm.php' ?>

<script>

	var TableList = new Table
	
	class Faq {
		constructor()
		{
			this.menu_updated = false
			this.menu_detail_updated = false
			this.id_menu = 0
			this.menu_id = 0
			this.id_menu_detail = 0
			this.load()
		}
		load()
		{
			this.ModalReset()
			callApi('admin/faq/',null,function(res){
				var menu = ''
				if (res.Error) {
					$('#menu--content').html('<div class="alert alert-warning text-center w-100 mb-0">Faq tidak ditemukan</div>')
					$('#menu--detail').parents('.card-body').addClass('d-none')
				}else{
					var result = res.Data,
							active_menu,
							active_menu_name;

					$.each(result,function(index,data){
						if (index == 0) {
							active_menu = data.id
							active_menu_name = data.menu
						}
						menu += `<a href="javascript:;" class="text-sm-center curs-p nav-link btn--menu mr-2 ${index == 0? 'active' : ''}" data-id="${data.id}" data-menu="${data.menu}">${data.menu} </a>`
					})
					$('#menu--content').html(menu)
					faq.detail(active_menu,active_menu_name)
				}

			})
		}

		detail(id_menu,menu)
		{
			$('#menu--detail').parents('.card-body').removeClass('d-none')
			$('.menu--active-action').html(`
				<div class="row">
					<div class="col-md-6">
						<button class="btn btn-primary btn-sm btn--menu-edit" data-id="${id_menu}" data-menu="${menu}"><i class="fal fa-edit"></i> Menu</button>
						<button class="btn btn-danger btn-sm btn--menu-delete" data-id="${id_menu}"><i class="fal fa-trash-alt"></i> Menu</button>
					</div>
					<div class="col-md-6 text-right">
						<button class="btn btn-success btn-sm" onclick="faq.menuDetailAdd('${id_menu}')"><i class="fal fa-plus"></i> Pertanyaan</button>
					</div>
				</div>
			`)
			TableList.destroy('table#menu--detail')
			TableList.run({
				tabel: "table#menu--detail",
				url: "admin/faq/detail/",
				data: {
					id_menu: id_menu
				},
				columns: [
					{
						data: null,
						render: function (data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1 + '.';
						}
					},
					{
						data: "pertanyaan"
					},
					{
						data: "jawaban"
					},
					{
						data: null,
						render: function(data)
						{
							return `
								<button class="btn btn-sm btn-primary btn--edit-menu-detail" onclick="faq.menuDetailEdit('${data.id}')"><i class="fal fa-edit"></i> Edit</button>
								<button class="btn btn-sm btn-danger btn--delete-menu-detail" onclick="faq.menuDetailDelete('${data.id}')"><i class="fal fa-trash-alt"></i> Hapus</button>
							`
						}
					}
				]
			})
		}
		ModalReset()
		{
			this.menu_updated = false
			this.id_menu = 0
			$('#ModalMenu input').val('')
			$('#ModalMenu').modal('hide')
			$('#ModalConfirmMenu').modal('hide')

			// detail

			$('#ModalMenuDetail input').val('')
			$('#ModalMenuDetail textarea').val('')
			$('#ModalMenuDetail').modal('hide')
			$('#ModalConfirmMenuDetail').modal('hide')
		}
		menuAdd()
		{
			faq.ModalReset()
			$('#ModalMenu .modal-title').html('Tambah Menu')
			$('#ModalMenu').modal('show')
		}
		menuEdit(data)
		{
			faq.ModalReset()
			this.menu_updated = true
			this.id_menu = data.id
			$('#ModalMenu .modal-title').html('Edit Menu')
			$('#ModalMenu input.menu').val(data.menu)
			$('#ModalMenu').modal('show')
		}
		menuDelete(data)
		{
			faq.ModalReset()
			this.menu_updated = true
			this.id_menu = data.id
			$('#ModalConfirmMenu').modal('show')
		}
		menuDetailAdd(id_menu)
		{
			faq.ModalReset()
			this.menu_id = id_menu
			$('#ModalMenuDetail .modal-title').html('Tambah Menu')
			$('#ModalMenuDetail').modal('show')
		}
		menuDetailEdit(id)
		{
			faq.ModalReset()
			this.menu_detail_updated = true
			this.id_menu_detail = id
			$('#ModalMenuDetail .modal-title').html('Edit Menu')
			callApi('admin/faq/detail_single/',{id_detail: id},function(res){
				if (res.Error) {

				}else{
					var data = res.Data
					$('#ModalMenuDetail input.pertanyaan').val(data.pertanyaan)
					$('#ModalMenuDetail textarea.jawaban').val(data.jawaban)
					$('#ModalMenuDetail').modal('show')
				}
			})
		}
		menuDetailDelete(id)
		{
			faq.ModalReset()
			this.menu_detail_updated = false
			this.id_menu_detail = id
			$('#ModalConfirmMenuDetail').modal('show')
		}
		add_menu()
		{
			var data = {
				menu: $('#ModalMenu input.menu').val()
			}
			callApi('admin/faq/add_menu/',data,function(res){
				if (res.Error) {

				}else{
					faq.load()
				}
			})
		}
		edit_menu()
		{
			var data = {
				menu: $('#ModalMenu input.menu').val(),
				id_menu: this.id_menu
			}
			callApi('admin/faq/edit_menu/',data,function(res){
				if (res.Error) {

				}else{
					faq.load()
				}
			})
		}
		delete_menu()
		{
			var data = {
				id_menu: this.id_menu
			}
			callApi('admin/faq/delete_menu/',data,function(res){
				if (res.Error) {

				}else{
					faq.load()
				}
			})
		}
		add_menu_detail()
		{
			var data = {
				id_menu: this.menu_id,
				pertanyaan: $('#ModalMenuDetail input.pertanyaan').val(),
				jawaban: $('#ModalMenuDetail textarea.jawaban').val()
			}
			callApi('admin/faq/add_detail/',data,function(res){
				if (res.Error) {

				}else{
					faq.load()
				}
			})
		}
		edit_menu_detail()
		{
			var data = {
				id_detail: this.id_menu_detail,
				pertanyaan: $('#ModalMenuDetail input.pertanyaan').val(),
				jawaban: $('#ModalMenuDetail textarea.jawaban').val()
			}
			callApi('admin/faq/edit_detail/',data,function(res){
				if (res.Error) {

				}else{
					faq.load()
				}
			})
		}
		delete_menu_detail()
		{
			var data = {
				id_detail: this.id_menu_detail
			}
			callApi('admin/faq/delete_detail/',data,function(res){
				if (res.Error) {

				}else{
					faq.load()
				}
			})
		}
	}

	var faq = new Faq

	$(document).on('submit', '#ModalMenu form', function(event) {
		event.preventDefault();
		if (faq.menu_updated) {
			faq.edit_menu()
		}else{
			faq.add_menu()
		}
	});

	$(document).on('click', '.btn--menu:not(.active)', function(event) {
		event.preventDefault();
		$(this).addClass('active')
		$('.btn--menu').not($(this)).removeClass('active')
		faq.detail($(this).attr('data-id'),$(this).attr('data-menu'))
	});

	$(document).on('click', '.btn--menu-edit', function(event) {
		event.preventDefault();
		var data = {
			id: $(this).attr('data-id'),
			menu: $(this).attr('data-menu')
		}
		faq.menuEdit(data)
	});

	$(document).on('click', '.btn--menu-delete', function(event) {
		event.preventDefault();
		var data = {
			id: $(this).attr('data-id'),
			menu: $(this).attr('data-menu')
		}
		faq.menuDelete(data)
	});

	$(document).on('submit', '#ModalConfirmMenu form', function(event) {
		event.preventDefault();
		faq.delete_menu()
	});

	// detail

	$(document).on('submit', '#ModalMenuDetail form', function(event) {
		event.preventDefault();
		if (faq.menu_detail_updated) {
			faq.edit_menu_detail()
		}else{
			faq.add_menu_detail()
		}
	});

	$(document).on('submit', '#ModalConfirmMenuDetail form', function(event) {
		event.preventDefault();
		faq.delete_menu_detail()
	});

</script>