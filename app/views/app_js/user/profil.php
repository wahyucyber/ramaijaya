<script>
	var $jp_client_token = check_auth()

	class Profil {
		constructor() {
			this.run();
			this.provinsi();
		}

		run() {
			callApi("user/profil/", {
				client_token: $jp_client_token
			}, res => {
				$.each(res.Data, function(index, val) {
					if (val.jenis_kelamin == null) {
						var jenis_kelamin = "~";
						profil.notifLengkapiData();
					}else{
						var jenis_kelamin = val.jenis_kelamin;
					}

					if (val.tempat_lahir == null || val.tanggal_lahir == null) {
						var tempat_tanggal_lahir = "~";
						profil.notifLengkapiData();
					}else{
						var tempat_tanggal_lahir = `${val.tempat_lahir}, ${val.tanggal_lahir}`;
					}

					if (val.provinsi_nama == null) {
						var provinsi = "~";
						profil.notifLengkapiData();
					}else{
						var provinsi = val.provinsi_nama;
					}

					if (val.kabupaten_nama == null) {
						var kabupaten = "~";
						profil.notifLengkapiData();
						$("div.kabupaten").addClass('none');
					}else{
						$("div.kabupaten").removeClass('none');
						var kabupaten = val.kabupaten_nama;
					}

					if (val.kecamatan_nama == null) {
						var kecamatan = "~";
						profil.notifLengkapiData();
						$("div.kecamatan").addClass('none');
					}else{
						$("div.kecamatan").removeClass('none');
						var kecamatan = val.kecamatan_nama;
					}

					if (val.alamat == null) {
						profil.notifLengkapiData();
						var alamat = "~";
					}else{
						var alamat = val.alamat;
					}

					if (val.kode_pos == null) {
						profil.notifLengkapiData();
						var kode_pos = "~";
					}else{
						var kode_pos = val.kode_pos;
					}

					if (val.no_telepon == null) {
						profil.notifLengkapiData();
						var no_telepon = "~";
					}else{
						var no_telepon = val.no_telepon;
					}

					if (val.foto != null) {
						$("img.profil--img").attr('src', val.foto);
					}

					$("p.profil--nama").html(val.nama);
					$("p.profil--jenis-kelamin").html(jenis_kelamin);
					$("p.profil--tempat-tanggal-lahir").html(tempat_tanggal_lahir);
					$("p.profil--provinsi").html(provinsi);
					$("p.profil--kabupaten").html(kabupaten);
					$("p.profil--kecamatan").html(kecamatan);
					$("p.profil--alamat").html(alamat);
					$("p.profil--kode-pos").html(kode_pos);
					$("p.profil--no-telp").html(no_telepon);

					$("input.profil--nama").val(val.nama);
					$("select.profil--jenis-kelamin").val(val.jenis_kelamin).trigger('selected');
					$("input.profil--tempat-lahir").val(val.tempat_lahir);
					$("input.profil--tanggal-lahir").val(val.tanggal_lahir);
					$("input.profil--alamat").val(val.alamat);
					$("input.profil--kode-pos").val(val.kode_pos);
					$("input.profil--no-telp").val(val.no_telepon);

					profil.provinsi(val.provinsi_id);
					profil.kabupaten(val.provinsi_id, val.kabupaten_id);
					profil.kecamatan(val.kabupaten_id, val.kecamatan_id);
				});
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
				$("select.profil--provinsi").html(option);
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
				$("select.profil--kabupaten").html(option);
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
				$("select.profil--kecamatan").html(option)
			})
		}

		notifLengkapiData() {
			notif("div.profil--message", "warning", "Lengkapi semua data anda.");
		}

		update(params) {
			var nama = params['nama'];
			var jenis_kelamin = params['jenis_kelamin'];
			var tempat_lahir = params['tempat_lahir'];
			var tanggal_lahir = params['tanggal_lahir'];
			var provinsi = params['provinsi'];
			var kabupaten = params['kabupaten'];
			var kecamatan = params['kecamatan'];
			var alamat = params['alamat'];
			var kode_pos = params['kode_pos'];
			var no_telp = params['no_telp'];

			callApi("user/profil/update", {
				client_token: $jp_client_token,
				nama: nama,
				jenis_kelamin: jenis_kelamin,
				tempat_lahir: tempat_lahir,
				tanggal_lahir: tanggal_lahir,
				provinsi: provinsi,
				kabupaten: kabupaten,
				kecamatan: kecamatan,
				alamat: alamat,
				kode_pos: kode_pos,
				no_telepon: no_telp
			}, res => {
				var message = res.Message;
				if (res.Error == true) {
					notif("div#edit-profil div.message", "danger", message);
				}else{
					notifAlert(message, "success", 4);
					profil.run();
					init_app.run();
					$("div#edit-profil").modal('hide');
				}
			})
		}

		uploadImage(img) {
			callApi("user/profil/uploadImage", {
				client_token: $jp_client_token,
				img: img
			}, res => {
				var message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 4);
				}else{
					notifAlert(message, "success", 4);
					profil.run();
					init_app.run();
				}
			})
		}
	}

	var profil = new Profil;
	var datepicker = new Datepicker;
	datepicker.run({
		input: "input.datepicker",
		container: "div#edit-profil"
	})

	$(document).on("change", "select.profil--provinsi", function() {
		$("div.kabupaten").addClass('none');
		$("div.kecamatan").addClass('none');
		var provinsi_id = $(this).val();
		if (provinsi_id == "") {
			$("div.kabupaten").addClass('none');
			$("div.kecamatan").addClass('none');
		}else{
			$("div.kabupaten").removeClass('none');
			profil.kabupaten(provinsi_id);
		}
	})

	$(document).on("change", "select.profil--kabupaten", function() {
		var kabupaten_id = $(this).val();
		if (kabupaten_id == "") {
			$("div.kecamatan").addClass('none');
		}else{
			$("div.kecamatan").removeClass('none');
			profil.kecamatan(kabupaten_id);
		}
	})

	$(document).on("submit", "form.form--update-profil", function() {
		var nama = $("input.profil--nama").val();
		var jenis_kelamin = $("select.profil--jenis-kelamin").val();
		var tempat_lahir = $("input.profil--tempat-lahir").val();
		var tanggal_lahir = $("input.profil--tanggal-lahir").val();
		var provinsi = $("select.profil--provinsi").val();
		var kabupaten = $("select.profil--kabupaten").val();
		var kecamatan = $("select.profil--kecamatan").val();
		var alamat = $("input.profil--alamat").val();
		var kode_pos = $("input.profil--kode-pos").val();
		var no_telp = $("input.profil--no-telp").val();

		profil.update({
			nama: nama,
			jenis_kelamin: jenis_kelamin,
			tempat_lahir: tempat_lahir,
			tanggal_lahir: tanggal_lahir,
			provinsi: provinsi,
			kabupaten: kabupaten,
			kecamatan: kecamatan,
			alamat: alamat,
			kode_pos: kode_pos,
			no_telp: no_telp
		});

		return false;
	})

	var uploadImage = new UploadImage;

	uploadImage.options(1000, 1000, 80);

	$(document).on("change", "input.profil--browse-foto", function (e) {
		uploadImage.get_base64(this, $("img.profil--img"), e, function (img) {
			profil.uploadImage(img);
		});
	})
</script>