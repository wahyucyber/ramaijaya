<?php include 'Adm.php' ?>

<script>
	class Product {
		constructor() {
			this.run();
			this.runToko();
		}

		run(params = []) {
			let table = new Table;
			let toko_id = params['toko_id'];
			let status = params['status'];
			let verifikasi = params['verifikasi'];
			table.run({
				tabel: "table.data-product",
				url: "admin/product",
				data: {
					toko_id: toko_id,
					status: status,
					verifikasi: verifikasi
				},
				columns: [
					{
						data: null,
						render: function (data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1 + '.';
						}
					},
					{
						data: "nama_produk"
					},
					{
						data: null,
						render: res => {
							var harga = ''
							if (res.diskon == 0) {
								harga = `Rp. ${rupiah(res.harga)}`
							}else{
								harga = `<small class="fs-15">Rp. ${rupiah(res.harga_diskon)}</small><br> <small class="fs-13 text-secondary text-caret">Rp. ${rupiah(res.harga)}</small> <small class="badge badge-danger bagde-pill fs-13">-${res.diskon}%</small>`
							}
							return `
								<table>
									<tr height="10px">
										<td>Harga</td>
										<td>: ${harga}</td>
									</tr>
									<tr>
										<td>Berat</td>
										<td>: ${res.berat}g</td>
									</tr>
									<tr>
										<td>Stok</td>
										<td>: ${res.stok}</td>
									</tr>
								</table>
							`;
						}
					},
					{
						data: "toko_nama"
					},
					{
						data: null,
						render: res => {
							let status = '';
							if (res.status == "Aktif") {
								status = "success";
							}else{
								status = "danger";
							}

							return `
								<div class="badge badge-${status}">${res.status}</div>
							`;
						}
					},
					{
						data: null,
						render: res => {
							let verifikasi = '';
							var catatan = ''
							if (res.verifikasi == "Ter-verifikasi") {
								verifikasi = "success";
							}else{
								verifikasi = "danger";
								catatan = res.catatan_diblokir
							}

							return `
								<div class="badge badge-${verifikasi}">${res.verifikasi}</div><br>
								<small class="text-info">${catatan? catatan : ''}</small>
							`;
						}
					},
					{
						data: null,
						render: res => {
							if (res.verifikasi == "Ter-verifikasi") {
								return `
									<button type="button" class="btn btn-danger btn-sm non-verifikasi" data-id="${res.id}" data-nama="${res.nama_produk}" data-toggle="modal" data-target="#non-verifikasi"><i class="fa fa-window-close"></i></button>
									<a href="<?php echo base_url(''); ?>shop/${res.toko_slug}/${res.slug}?tab=1" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
								`;
							}else{
								return `
									<button type="button" class="btn btn-success btn-sm verifikasi" data-id="${res.id}" data-nama="${res.nama_produk}" data-toggle="modal" data-target="#verifikasi"><i class="fa fa-check-circle"></i></button>
									<a href="<?php echo base_url(''); ?>shop/${res.toko_slug}/${res.slug}?tab=1" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
								`;
							}
						}
					}
				]
			})
		}

		set_verifikasi(params) {
			let id = params['id'];

			callApi("admin/product/set_verifikasi", {
				id: id
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					this.run();
					$("div#verifikasi").modal('hide');
					notifAlert(message, "success", 5);
				}
			})
		}

		set_nonverifikasi(params) {
			let id = params['id'];

			callApi("admin/product/set_nonverifikasi", {
				id: id,
				catatan: params['catatan']
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					this.run();
					$("div#non-verifikasi").modal('hide');
					notifAlert(message, "success", 5);
					$('#non-verifikasi input.catatan').val('')
				}
			})
		}

		runToko() {
			callApi("admin/toko", null, res => {
				let option = `<option value=""></option>`;
				$.each(res.Data, function(index, val) {
					option += `<option value="${val.id}">${val.nama_toko}</option>`;
				});
				$("form.filter select.toko").html(option);
			})
		}
	}

	let product = new Product;

	$(document).on("click", "button.non-verifikasi", function () {
		let id = $(this).data('id');
		let nama = $(this).data('nama');
		$("span.non-verifikasi--nama-produk").html(nama);
		$("input.non-verifikasi--produk-id").val(id);
	})

	$(document).on("click", "button.verifikasi", function () {
		let id = $(this).data('id');
		let nama = $(this).data('nama');
		$("span.verifikasi--nama-produk").html(nama);
		$("input.verifikasi--produk-id").val(id);
	})

	$(document).on("click", "button.ya-non-verifikasi", function () {
		let id = $("input.non-verifikasi--produk-id").val();
		var catatan= $('#non-verifikasi input.catatan').val()
		product.set_nonverifikasi({
			id: id,
			catatan: catatan
		})
	})

	$(document).on("click", "button.ya-verifikasi", function () {
		let id = $("input.verifikasi--produk-id").val();
		product.set_verifikasi({
			id: id
		})
	})

	$(document).on("click", "button.product--reload", function () {
		$("form.filter select.toko").val('').trigger('change');
		$("form.filter select.status").val('').trigger('change');
		$("form.filter select.verifikasi").val('').trigger('change');

		product.run();
	})

	$(document).on("submit", "form.filter", function () {
		$("div#filter").modal('hide');

		let toko = $("form.filter select.toko").val();
		let status = $("form.filter select.status").val();
		let verifikasi = $("form.filter select.verifikasi").val();

		product.run({
			toko_id: toko,
			status: status,
			verifikasi: verifikasi
		});

		return false;
	})
</script>