<?php include 'Adm.php' ?>

<script>
	var TableUser = new Table;
	class User {

		constructor()
		{
			this.is_update = false
			this.id_user = null
			this.run()
			this.getProvinsi()
		}

		getProvinsi()
		{
			callApi('provinsi/',null,res => {
				var output = ''
				if (res.Error) {

				}else{
					output += '<option value=""></option>'
					$.each(res.Data, (index,data) => {
						output += `<option value="${data.id_provinsi}">${data.nama_provinsi}</option>`
					})
				}
				$('#Modal select.provinsi').html(output)
			})
		}

		getKabupaten(provinsi_id)
		{
			callApi('kabupaten/',{provinsi_id: provinsi_id},res => {
				var output = ''
				if (res.Error) {

				}else{
					output += '<option value=""></option>'
					$.each(res.Data, (index,data) => {
						output += `<option value="${data.id_kabupaten}">${data.nama_kabupaten}</option>`
					})
				}
				$('#Modal select.kabupaten').html(output)
			})
		}

		getKecamatan(kabupaten_id)
		{
			callApi('kecamatan/',{kabupaten_id: kabupaten_id},res => {
				var output = ''
				if (res.Error) {

				}else{
					output += '<option value=""></option>'
					$.each(res.Data, (index,data) => {
						output += `<option value="${data.id_kecamatan}">${data.nama_kecamatan}</option>`
					})
				}
				$('#Modal select.kecamatan').html(output)
			})
		}

		getKodePos(kecamatan_id)
		{
			callApi('kodepos/',{kecamatan_id: kecamatan_id},res => {
				var output = ''
				if (res.Error) {

				}else{
					$('#Modal input.kode_pos').val(res.Data.kodepos)					
				}
			})
		}

		run()
		{
			this.ModalReset()
			TableUser.run({
				tabel: "table.table-user",
				url: "admin/user/",
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
							return `
							<div class="avatar--table rounded-circle">
								<img src="${
									data.foto_user?
									data.foto_user :
									base_url('assets/img/default/profile.jpg')
								}"> 
							</div>
							<small>${data.nama_user}</small>
							<button class="btn text-primary btn-sm see-detail" 
								data-foto="${data.foto_user}"
								data-email="${data.email}"
								data-telepon="${data.telepon}"
								data-provinsi="${data.nama_provinsi}"
								data-kabupaten="${data.nama_kabupaten}"
								data-kecamatan="${data.nama_kecamatan}"
								data-kodepos="${data.kode_pos}"
								data-alamat="${data.alamat}"
								data-jeniskelamin="${data.jenis_kelamin}"
								data-tnaggallahir="${data.tanggal_lahir}"
								data-tempatlahir="${data.tempat_lahir}"
								data-status="${data.status}"
								data-id="${data.id_user}"><i class="fa fa-info-circle"></i></button>
							`;
						}
					},
					{
						data: "email"
					},
					{
						data: null,
						render: function (data) {
							var not_set = '<small class="text-muted"><i>Belum Diset</i></small>';

							return `${data.telepon? data.telepon : not_set}`;
						}
					},
					{
						data: null,
						render: function (data) {
							var content = ''
							if (data.diblokir == 1) {
								content += `<span class="badge badge-danger badge-pill">Diblokir</span><br>
								<small class="text-danger">${data.catatan_diblokir}</small>`
							}else{
								if (data.status > 0) {
									content += '<span class="badge badge-success badge-pill"><i class="fa fa-check"></i> Diverifikasi</span>'
								}else{
									content += '<span class="badge badge-danger badge-pill"><i class="fa fa-times"></i> Belum Diverifikasi</span>'
								}
							}
							return content
						}
					},
					{
						data: null,
						render: function (data) {
							var btn_blokir = ''
							if (data.diblokir == 0) {
								btn_blokir = `<button class="btn btn-danger btn-sm mb-2 btn--blokir" data-toggle="modal" data-target="#ModalBlokir" title="Blokir" data-id="${data.id_user}">
												<i class="fa fa-times"></i>
											</button>`
							}else{
								btn_blokir = `<button class="btn btn-success btn-sm mb-2 btn--buka-blokir" title="Buka Blokir" data-toggle="modal" data-target="#ModalBukaBlokir" data-id="${data.id_user}">
												<i class="fa fa-check"></i>
											</button>`
							}
							return `
							${btn_blokir}
							<button class="btn btn-primary btn-sm btn-edit mb-2" title="Edit" 
								data-foto="${data.foto_user? data.foto_user : ''}"
								data-email="${data.email}"
								data-nama="${data.nama_user}"
								data-telepon="${data.telepon? data.telepon : ''}"
								data-provinsi="${data.provinsi_id? data.provinsi_id : ''}"
								data-kabupaten="${data.kabupaten_id? data.kabupaten_id : ''}"
								data-kecamatan="${data.kecamatan_id? data.kecamatan_id : ''}"
								data-kodepos="${data.kode_pos? data.kode_pos : ''}"
								data-alamat="${data.alamat? data.alamat : ''}"
								data-jeniskelamin="${data.jenis_kelamin? data.jenis_kelamin : ''}"
								data-tnaggallahir="${data.tanggal_lahir? data.tanggal_lahir : ''}"
								data-tempatlahir="${data.tempat_lahir? data.tempat_lahir : ''}"
								data-status="${data.status}"
								data-role="${data.role}"
								data-id="${data.id_user}"><i class="fa fa-edit"></i></button>
							<button class="btn btn-info btn-sm btn-reset mb-2" 
								data-email="${data.email}"
								data-nama="${data.nama_user}"
								data-status="${data.status}"
								data-id="${data.id_user}" title="Reset Password"><i class="fa fa-key"></i></button>
							<button class="btn btn-danger btn-sm btn-delete mb-2"
								data-email="${data.email}"
								data-nama="${data.nama_user}"
								data-id="${data.id_user}"><i class="fa fa-trash-alt"></i></button>
							`;
						}
					}
				]
			});
		}

		ModalReset()
		{
			this.is_update = false
			this.id_user = null

			$('#Modal').modal('hide')
			$('#Modal .msg-content').html('')
			$('#Modal input').val('')
			$('#Modal input.password').parents('.form-group').show()
			$('#Modal input.send-mail').val(0).prop('checked',false)
			$('#Modal select.provinsi').val('').trigger('change')
			$('#Modal select.kabupaten').html('<option value=""></option>').select2()
			$('#Modal select.kecamatan').html('<option value=""></option>').select2()
			$('#Modal textarea.alamat').val('')

			$('#ModalConfrim').modal('hide')
			$('#ModalConfrim .modal-body').html('')

			$('#ModalReset').modal('hide')
			$('#ModalReset input').val('')
		}

		ModalAddDraw()
		{
			user.ModalReset()
			this.is_update = false
			$('#Modal .modal-title').html('Tambah Pengguna')
			$('#Modal').modal('show')
		}

		ModalResetDraw(data)
		{
			user.ModalReset()
			this.is_update = false
			this.id_user = data.id_user
			$('#ModalReset .modal-title').html('Reset Password Pengguna '+data.nama_user)
			$('#ModalReset').modal('show')
		}

		ModalEditDraw(data)
		{
			this.ModalReset()
			this.is_update = true
			this.id_user = data.id_user
			$('#Modal input.nama').val(data.nama)
			$('#Modal input.email').val(data.email)
			$('#Modal input.password').parents('.form-group').hide()
			$('#Modal input.konfirmasi_password').parents('.form-group').hide()
			$('#Modal select.provinsi').val(data.provinsi).trigger('change')
			setTimeout(() => {
				$('#Modal select.kabupaten').val(data.kabupaten).trigger('change')
			},1000)
			setTimeout(() => {
				$('#Modal select.kecamatan').val(data.kecamatan).trigger('change')
			},1500)
			$('#Modal textarea.alamat').val(data.alamat)
			$('#Modal input.kode_pos').val(data.kode_pos)
			$('#Modal input.telepon').val(data.telepon)
			$('#Modal select.rule').val(data.role).trigger('change')
			$('#Modal input.send-mail').val(data.status).prop('checked',data.status == 1? true : false)
			$('#Modal').modal('show')
		}

		add()
		{
			var kirim_email = $('#Modal input.send-mail').val(),
				nama = $('#Modal input.nama').val(),
				email = $('#Modal input.email').val(),
				password = $('#Modal input.password').val(),
				konfirmasi_password = $('#Modal input.konfirmasi_password').val(),
				provinsi = $('#Modal select.provinsi').val(),
				kabupaten = $('#Modal select.kabupaten').val(),
				kecamatan = $('#Modal select.kecamatan').val(),
				alamat = $('#Modal textarea.alamat').val(),
				kode_pos = $('#Modal input.kode_pos').val(),
				telepon = $('#Modal input.telepon').val(),
				rule = $('#Modal select.rule').val(),
				data = {
					kirim_email: kirim_email,
					nama: nama,
					email: email,
					password: password,
					konfirmasi_password: konfirmasi_password,
					provinsi: provinsi,
					kabupaten: kabupaten,
					kecamatan: kecamatan,
					alamat: alamat,
					kode_pos: kode_pos,
					telepon: telepon,
					role: rule
				}

			callApi('admin/user/add/',data,res => {

				if (res.Error) {
					notif('#Modal .msg-content','danger',res.Message,5)
				}else{
					notif('.content--page .msg-content','success',res.Message,5)
					user.run()
				}
			})

		}

		edit()
		{
			var kirim_email = $('#Modal input.send-mail').val(),
				nama = $('#Modal input.nama').val(),
				email = $('#Modal input.email').val(),
				provinsi = $('#Modal select.provinsi').val(),
				kabupaten = $('#Modal select.kabupaten').val(),
				kecamatan = $('#Modal select.kecamatan').val(),
				alamat = $('#Modal textarea.alamat').val(),
				kode_pos = $('#Modal input.kode_pos').val(),
				telepon = $('#Modal input.telepon').val(),
				rule = $('#Modal select.rule').val(),
				data = {
					kirim_email: kirim_email,
					id_user: this.id_user,
					nama: nama,
					email: email,
					provinsi: provinsi,
					kabupaten: kabupaten,
					kecamatan: kecamatan,
					alamat: alamat,
					kode_pos: kode_pos,
					telepon: telepon,
					role: rule
				}

			callApi('admin/user/update/',data,res => {

				if (res.Error) {
					notif('#Modal .msg-content','danger',res.Message,5)
				}else{
					notif('.content--page .msg-content','success',res.Message,5)
					user.run()
				}
			})

		}

		reset()
		{
			var data = {
				id_user: this.id_user,
				password: $('#ModalReset input.password').val(),
				konfirmasi_password: $('#ModalReset input.konfirmasi_password').val()
			}
			callApi('admin/user/reset/',data,res => {

				if (res.Error) {
					notif('#ModalReset .msg-content','danger',res.Message,5)
				}else{
					notif('.content--page .msg-content','success',res.Message,5)
					user.run()
				}
			})
		}

		set_user_id(id)
		{
			this.id_user = id
		}

		blokir(stat = null)
		{
			var url = '',
			data;
			if (stat) {
				url = 'admin/user/buka_blokir'
				data = {
					user_id: this.id_user
				}
			}else{
				url = 'admin/user/blokir'
				data = {
					user_id: this.id_user,
					catatan: $('#ModalBlokir input.catatan').val()
				}
			}
			callApi(url,data,function(res){
				if (res.Error) {

				}else{
					$('#ModalBlokir').modal('hide')
					$('#ModalBukaBlokir').modal('hide')
					user.run()
				}
			})
		}

	}

	var user = new User

	$(document).on('click', '#pagination .btn-page[data-page]', function(event) {
		event.preventDefault();
		usser.run($(this).data('page'))
	});

	$(document).on('change', '#Modal input.send-mail', function(event) {
		event.preventDefault();
		$(this).val(this.checked ? 1 : 0);
	});

	$(document).on('submit', '#Modal form', function(event) {
		event.preventDefault();
		if (user.is_update) {
			user.edit()
		}else{
			user.add()
		}
	});

	$(document).on('change', '#Modal select.provinsi', function() {
		user.getKabupaten($(this).val())		
	});

	$(document).on('change', '#Modal select.kabupaten', function() {
		user.getKecamatan($(this).val())		
	});

	$(document).on('change', '#Modal select.kecamatan', function() {
		user.getKodePos($(this).val())		
	});

	$(document).on('click', '.content--page table .btn-edit', function(event) {
		event.preventDefault();
		var data = {
			id_user: $(this).attr('data-id'),
			nama: $(this).attr('data-nama'),
			email: $(this).attr('data-email'),
			provinsi: $(this).attr('data-provinsi'),
			kabupaten: $(this).attr('data-kabupaten'),
			kecamatan: $(this).attr('data-kecamatan'),
			alamat: $(this).attr('data-alamat'),
			kode_pos: $(this).attr('data-kodepos'),
			telepon: $(this).attr('data-telepon'),
			status: $(this).attr('data-status'),
			role: $(this).attr('data-role')
		}

		user.ModalEditDraw(data)

	});

	$(document).on('click', '.content--page table .btn-reset', function(event) {
		event.preventDefault();
		var data = {
			id_user: $(this).attr('data-id'),
			nama: $(this).attr('data-nama'),
			email: $(this).attr('data-email'),
			status: $(this).attr('data-status')
		}
		user.ModalResetDraw(data)
	})

	$(document).on('submit', '#ModalReset form', function(event) {
		event.preventDefault();
		user.reset()
	});

	$(document).on('click', 'button.btn--blokir,button.btn--buka-blokir', function(event) {
		event.preventDefault();
		var id = $(this).attr('data-id')
		user.set_user_id(id)
	});

	$(document).on('submit', '#ModalBlokir form', function(event) {
		event.preventDefault();
		user.blokir()
	});

	$(document).on('submit', '#ModalBukaBlokir form', function(event) {
		event.preventDefault();
		user.blokir('buka')
	});


</script>