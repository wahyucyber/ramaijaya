<script>
	var $jp_client_token = check_auth()

	class Alamat_pengiriman {

		constructor() {
			this.provinsi();
		}

		add(params) {
			var nama = params['nama'];
			var penerima_nama = params['penerima_nama'];
			var penerima_telepon = params['penerima_telepon'];
			var provinsi = params['provinsi'];
			var kabupaten = params['kabupaten'];
			var kecamatan = params['kecamatan'];
			var alamat = params['alamat'];
			callApi("user/alamat_pengiriman/add", {
				client_token: $jp_client_token,
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
					window.location="<?php echo base_url('user/profil/?tab=informasi_pengiriman'); ?>";
				}
			})
		}

		provinsi() {
			callApi("provinsi", null, res => {
				var option = `<option value="">-Piih Provinsi-</option>`;
				$.each(res.Data, function(index, val) {
					option += `<option value="${val.id_provinsi}">${val.nama_provinsi}</option>`;
				});
				$("select.alamat--provinsi").html(option);
			})
		}

		kabupaten(provinsi_id) {
			callApi("kabupaten", {
				provinsi_id: provinsi_id
			}, res => {
				var option = `<option value="">-Pilih Kabupaten/Kota</option>`;
				$.each(res.Data, function(index, val) {
					option += `<option value="${val.id_kabupaten}">${val.nama_kabupaten}</option>`;
				});
				$("select.alamat--kabupaten").html(option);
			})
		}

		kecamatan(kabupaten_id) {
			callApi("kecamatan", {
				kabupaten_id: kabupaten_id
			}, res => {
				var option = `<option value="">-Pilih Kecamatan-</option>`;
				$.each(res.Data, function(index, val) {
					option += `<option value="${val.id_kecamatan}">${val.nama_kecamatan}</option>`;
				});
				$("select.alamat--kecamatan").html(option)
			})
		}
	}

	var alamat_pengiriman = new Alamat_pengiriman;

	$(document).on("submit", "form.form--add-alamat", function () {
		var nama = $("input.alamat--nama").val();
		var penerima_nama = $("input.alamat--nama-penerima").val();
		var penerima_telepon = $("input.alamat--telepon-penerima").val();
		var provinsi = $("select.alamat--provinsi").val();
		var kabupaten = $("select.alamat--kabupaten").val();
		var kecamatan = $("select.alamat--kecamatan").val();
		var alamat = $("textarea.alamat--alamat").val();
		alamat_pengiriman.add({
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

	$(document).on("change", "select.alamat--provinsi", function () {
		provinsi_id = $(this).val();
		alamat_pengiriman.kabupaten(provinsi_id);
	})

	$(document).on("change", "select.alamat--kabupaten", function () {
		kabupaten_id = $(this).val();
		alamat_pengiriman.kecamatan(kabupaten_id);
	})
</script>