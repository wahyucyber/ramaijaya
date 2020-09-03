<?php include 'Adm.php' ?>

<script>
	class Shop {
		constructor() {
			this.toko_id = 0
			this.run();
		}

		run(params = []) {
			let tabel = new Table;
			tabel.run({
				tabel: "table.data-toko",
				url: "admin/toko",
				data: {
					status: params['status']
				},
				columns: [
					{
						data: null,
						render: function (data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1 + '.';
						}
					},
					{
						data: null,
						render: function(data){
							var blokir = ''
							if (data.diblokir == 1) {
								blokir = `<span class="badge badge-danger badge-pill">Diblokir</span><br><small class="text-danger">${data.catatan_diblokir}</small>`
							}
							return `${data.nama_toko}<br>${blokir}`
						}
					},
					{
						data: "provinsi_nama"
					},
					{
						data: "kabupaten_nama"
					},
					{
						data: "kecamatan_nama"
					},
					{
						data: null,
						render: res => {
							if (res.status == "Tidak aktif") {
								return `<div class="badge badge-danger">${res.status}</div>`;
							}else{
								return `<div class="badge badge-success">${res.status}</div>`;
							}
						}
					},
					{
						data: null,
						render: res => {
							let status = ``;
							if (res.status == "Tidak aktif") {
								status = `<button type="button" class="btn mr-2 btn-success btn-sm set-aktif mb-2" data-toggle="modal" data-target="#set-aktif" data-toko-id="${res.id}}" data-toko-nama="${res.nama_toko}"><i class="fa fa-check-circle"></i></button>`;
							}else{
								status = `<button type="button" class="btn mr-2 btn-danger btn-sm set-nonaktif mb-2" data-toggle="modal" data-target="#set-nonaktif" data-toko-id="${res.id}}" data-toko-nama="${res.nama_toko}"><i class="fa fa-window-close"></i></button>`;
							}
							var blokir = ''
							if (res.diblokir == 1) {
								blokir = `<button class="btn btn-sm btn-warning mb-2" onclick="shop.set_id('${res.id}')" data-toggle="modal" data-target="#ModalBukaBlokir">Buka <i class="fa fa-ban"></i></button>`
							}else{
								blokir = `<button class="btn btn-sm btn-danger mb-2" onclick="shop.set_id('${res.id}')" data-toggle="modal" data-target="#ModalBlokir"><i class="fa fa-ban"></i></button>`
							}
							return `
								${status}${blokir}
							`;
						}
					}
				]
			})
		}

		set_id(id)
		{
			this.toko_id = id
		}

		blokir(catatan)
		{
			callApi('admin/toko/blokir/',{toko_id: this.toko_id,catatan: catatan},function(res){
				if (res.Error) {
					notif('#ModalBlokir .msg-content','danger',res.Message)
				}else{
					shop.run();
					$("#ModalBlokir").modal('hide');
					$("#ModalBlokir input").val('');
					notifAlert(res.Message, "success", 5);
				}
			})
		}

		buka_blokir(catatan)
		{
			callApi('admin/toko/buka_blokir/',{toko_id: this.toko_id},function(res){
				if (res.Error) {
					notif('#ModalBlokir .msg-content','danger',res.Message)
				}else{
					shop.run();
					$("#ModalBukaBlokir").modal('hide');
					notifAlert(res.Message, "success", 5);
				}
			})
		}

		setAktif(params) {
			let toko_id = params['toko_id'];

			callApi("admin/toko/set_aktif", {
				toko_id: toko_id
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					shop.run();
					$("div#set-aktif").modal('hide');
					notifAlert(message, "success", 5);
				}
			})
		}

		setNonAktif(params) {
			let toko_id = params['toko_id'];

			callApi("admin/toko/set_nonaktif", {
				toko_id: toko_id
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					shop.run();
					$("div#set-nonaktif").modal('hide');
					notifAlert(message, "success", 5);
					$('#set-nonaktif input.catatan').val('')
				}
			})
		}
	}

	let shop = new Shop;

	$(document).on('submit', '#ModalBlokir form', function(event) {
		event.preventDefault();
		var catatan = $('#ModalBlokir input.catatan').val()
		shop.blokir(catatan)
	});


	$(document).on('submit', '#ModalBukaBlokir form', function(event) {
		event.preventDefault();
		shop.buka_blokir()
	});

	$(document).on("click", "button.set-aktif", function () {
		let toko_id = $(this).data('toko-id');
		let toko_nama = $(this).data('toko-nama');
		$("input.set-aktif--toko-id").val(toko_id);
		$("b.set-aktif--nama-toko").html(toko_nama);
	})

	$(document).on("click", "button.set-nonaktif", function () {
		let toko_id = $(this).data('toko-id');
		let toko_nama = $(this).data('toko-nama');
		$("input.set-nonaktif--toko-id").val(toko_id);
		$("b.set-nonaktif--nama-toko").html(toko_nama);
	})

	$(document).on("click", "button.set-aktif--ya", function () {
		let toko_id = $("input.set-aktif--toko-id").val();
		shop.setAktif({
			toko_id: toko_id
		})
	})

	$(document).on("click", "button.set-nonaktif--ya", function () {
		let toko_id = $("input.set-nonaktif--toko-id").val();

		shop.setNonAktif({
			toko_id: toko_id
		})
	})

	$(document).on("click", "button.toko--reload", function () {
		$("form.filter select.status").val('').trigger('change');

		shop.run();
	})

	$(document).on("submit", "form.filter", function () {
		$("div#filter").modal('hide');

		let status = $("form.filter select.status").val();

		shop.run({
			status: status
		});

		return false;
	})
</script>