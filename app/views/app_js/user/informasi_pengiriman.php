<script>
	var $jp_client_token = check_auth()

	class Alamat_pengiriman {
		constructor() {
			this.tabel = new Table;
			this.run();
		}

		run() {
			this.tabel.run({
				tabel: "table.table--alamat-pengiriman",
				url: "user/alamat_pengiriman/list",
				data: {
					client_token: $jp_client_token
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
						render: function (res) {
							if (res.is_utama == "1") {
								return `${res.nama} <i class="fa fa-check-circle" style="color: green;" title="Utama."></i>`;
							}else{
								return res.nama;
							}
						}
					},
					{
						data: null,
						render: function(res) {
							return `
							<table class="table" style="font-size: 13px; padding: 1px;">
								<tr>
									<td>Nama Penerima</td>
									<td align="right">${res.penerima_nama}</td>
								</tr>
								<tr>
									<td>No. Telepon Penerima</td>
									<td align="right">${res.penerima_no_telepon}</td>
								</tr>
								<tr>
									<td>Provinsi</td>
									<td align="right">${res.provinsi_nama}</td>
								</tr>
								<tr>
									<td>Kabupaten</td>
									<td align="right">${res.kabupaten_nama}</td>
								</tr>
								<tr>
									<td>Kecamatan</td>
									<td align="right">${res.kecamatan_nama}</td>
								</tr>
								<tr>
									<td>Alamat</td>
									<td align="right">${res.alamat}</td>
								</tr>
							</table>
							`;
						}
					},
					{
						data: null,
						render: function(res) {
							if (res.is_utama == 1) {
								return `
								<button type="button" class="btn btn-primary btn-sm alamat--edit" data-toggle="modal" data-target="#edit" data-id="${res.id}" data-nama="${res.nama}" data-penerima-nama="${res.penerima_nama}" data-penerima-telepon="${res.penerima_no_telepon}" data-provinsi="${res.provinsi_id}" data-kabupaten="${res.kabupaten_id}" data-kecamatan="${res.kecamatan_id}" data-alamat="${res.alamat}"><i class="fa fa-edit"></i></button>
								<button type="button" class="btn btn-danger btn-sm alamat--hapus" data-toggle="modal" data-target="#delete" data-id="${res.id}" data-nama="${res.nama}"><i class="fa fa-trash"></i></button>
								`;
							}else{
								return `
								<button type="button" class="btn btn-primary btn-sm alamat--set-utama" data-id="${res.id}"><i class="fa fa-check-circle"></i></button>
								<button type="button" class="btn btn-primary btn-sm alamat--edit" data-toggle="modal" data-target="#edit" data-id="${res.id}" data-nama="${res.nama}" data-penerima-nama="${res.penerima_nama}" data-penerima-telepon="${res.penerima_no_telepon}" data-provinsi="${res.provinsi_id}" data-kabupaten="${res.kabupaten_id}" data-kecamatan="${res.kecamatan_id}" data-alamat="${res.alamat}"><i class="fa fa-edit"></i></button>
								<button type="button" class="btn btn-danger btn-sm alamat--hapus" data-toggle="modal" data-target="#delete" data-id="${res.id}" data-nama="${res.nama}"><i class="fa fa-trash"></i></button>
								`;
							}
						}
					}
				]
			})
		}

		provinsi(provinsi_id = null) {
			callApi("provinsi", null, res => {
				var option = `<option value="">-Piih Provinsi-</option>`;
				$.each(res.Data, function(index, val) {
					option += `<option value="${val.id_provinsi}">${val.nama_provinsi}</option>`;
					if (provinsi_id == val.id_provinsi) {
						option += `<option value="${val.id_provinsi}" selected>${val.nama_provinsi}</option>`;
					}
				});
				$("select.alamat--provinsi").html(option);
			})
		}

		kabupaten(provinsi_id, kabupaten_id = null) {
			callApi("kabupaten", {
				provinsi_id: provinsi_id
			}, res => {
				var option = `<option value="">-Pilih Kabupaten/Kota</option>`;
				$.each(res.Data, function(index, val) {
					option += `<option value="${val.id_kabupaten}">${val.nama_kabupaten}</option>`;
					if (kabupaten_id == val.id_kabupaten) {
						option += `<option value="${val.id_kabupaten}" selected>${val.nama_kabupaten}</option>`;
					}
				});
				$("select.alamat--kabupaten").html(option);
			})
		}

		kecamatan(kabupaten_id, kecamatan_id = null) {
			callApi("kecamatan", {
				kabupaten_id: kabupaten_id
			}, res => {
				var option = `<option value="">-Pilih Kecamatan-</option>`;
				$.each(res.Data, function(index, val) {
					option += `<option value="${val.id_kecamatan}">${val.nama_kecamatan}</option>`;
					if (kecamatan_id == val.id_kecamatan) {
						option += `<option value="${val.id_kecamatan}" selected>${val.nama_kecamatan}</option>`;
					}
				});
				$("select.alamat--kecamatan").html(option)
			})
		}

		update(params) {
			var id = params['id'];
			var nama = params['nama'];
			var penerima_nama = params['penerima_nama'];
			var penerima_telepon = params['penerima_telepon'];
			var provinsi = params['provinsi'];
			var kabupaten = params['kabupaten'];
			var kecamatan = params['kecamatan'];
			var alamat = params['alamat'];
			callApi("user/alamat_pengiriman/update", {
				client_token: $jp_client_token,
				id: id,
				nama: nama,
				penerima_nama: penerima_nama,
				penerima_telepon: penerima_telepon,
				provinsi: provinsi,
				kabupaten: kabupaten,
				kecamatan: kecamatan,
				alamat: alamat
			}, res => {
				var message = res.Message;
				if (res.Error == true) {
					notifAlert(message, 'error', 5);
				}else{
					$("div#edit").modal('hide');
					alamat_pengiriman.run();
					notifAlert(message, 'success', 5);
				}
			})
		}

		delete(params) {
			var id = params['id'];

			callApi("user/alamat_pengiriman/delete", {
				client_token: $jp_client_token,
				id: id
			}, res => {
				var message = res.Message;
				if (res.Error == true) {
					notifAlert(message, 'error', 5);
				}else{
					$("div#delete").modal('hide');
					alamat_pengiriman.run();
					notifAlert(message, 'success', 5);
				}
			})
		}

		set_utama(params) {
			var id = params['id'];
			callApi("user/alamat_pengiriman/set_utama", {
				client_token: $jp_client_token,
				id: id
			}, res => {
				var message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					alamat_pengiriman.run();
					notifAlert(message, "success", 5);
				}
			})
		}
	}

	var alamat_pengiriman = new Alamat_pengiriman;

	$(document).on("click", "button.alamat--reload", function() {
		alamat_pengiriman.run();
	})

	$(document).on("click", "button.alamat--edit", function() {
		var id = $(this).data('id');
		var nama = $(this).data('nama');
		var penerima_nama = $(this).data('penerima-nama');
		var penerima_telepon = $(this).data('penerima-telepon');
		var provinsi = $(this).data('provinsi');
		var kabupaten = $(this).data('kabupaten');
		var kecamatan = $(this).data('kecamatan');
		var alamat = $(this).data('alamat');

		$("input.alamat--id").val(id);
		$("input.alamat--nama").val(nama);
		$("input.alamat--nama-penerima").val(penerima_nama);
		$("input.alamat--telepon-penerima").val(penerima_telepon);

		alamat_pengiriman.provinsi(provinsi);
		alamat_pengiriman.kabupaten(provinsi, kabupaten);
		alamat_pengiriman.kecamatan(kabupaten, kecamatan);

		$("textarea.alamat--alamat").val(alamat);
	})

	$(document).on("change", "select.alamat--provinsi", function () {
		provinsi_id = $(this).val();
		alamat_pengiriman.kabupaten(provinsi_id);
	})

	$(document).on("change", "select.alamat--kabupaten", function () {
		kabupaten_id = $(this).val();
		alamat_pengiriman.kecamatan(kabupaten_id);
	})

	$(document).on("submit", "form.form--edit-alamat", function () {
		var id = $("input.alamat--id").val();
		var nama = $("input.alamat--nama").val();
		var penerima_nama = $("input.alamat--nama-penerima").val();
		var penerima_telepon = $("input.alamat--telepon-penerima").val();
		var provinsi = $("select.alamat--provinsi").val();
		var kabupaten = $("select.alamat--kabupaten").val();
		var kecamatan = $("select.alamat--kecamatan").val();
		var alamat = $("textarea.alamat--alamat").val();
		alamat_pengiriman.update({
			id: id,
			nama: nama,
			penerima_nama: penerima_nama,
			penerima_telepon: penerima_telepon,
			provinsi: provinsi,
			kabupaten: kabupaten,
			kecamatan: kecamatan,
			alamat: alamat
		});

		return false;
	})

	$(document).on("click", "button.alamat--hapus", function () {
		var id = $(this).data('id');
		var nama = $(this).data('nama');
		$("input.alamat--hapus-id").val(id);
		$("b.alamat--nama").html(nama);
	})

	$(document).on("click", "button.alamat--ya-hapus", function () {
		id = $("input.alamat--hapus-id").val();
		alamat_pengiriman.delete({
			id: id
		});
	})

	$(document).on("click", "button.alamat--set-utama", function () {
		id = $(this).data('id');
		alamat_pengiriman.set_utama({
			id: id
		});
	})
</script>