<?php include 'Adm.php' ?>

<script>
	class Transaksi_pengajuan {
		constructor() {
			this.run();
		}

		run(params = []) {
			var tabel = new Table;

			tabel.run({
				tabel: "table.data-transaksi-pengajuan",
				url: "admin/Transaksi_pengajuan",
				data: {
					status: params.status
				},
				columns: [
					{
						data: null,
						render: function (data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1 + '.';
						}
					},
					{
						data: "no_transaksi"
					},
					{
						data: "toko_nama"
					},
					{
						data: null,
						render: res => {
							return `Rp. ${rupiah(res.total)}`
						}
					},
					{
						data: null,
						render: res => {
							return `
								<b>${res.toko_bank}</b><br><span style="font-size: 13px; color: grey;">${res.toko_bank_atasnama}<br>(${res.toko_rekening})</span>
							`;
						}
					},
					{
						data: null,
						render: res => {
							if (res.status == "Belum ditransfer") {
								return `<div class="badge badge-danger">${res.status}</div>`;
							}else{
								return `<div class="badge badge-success">${res.status}</div>`;
							}
						}
					},
					{
						data: null,
						render: res => {
							if (res.status == "Belum ditransfer") {
								return `<button type="button" class="btn btn-success btn-sm transaksi--transfer" data-transaksi-id="${res.transaksi_id}" data-no-transaksi="${res.no_transaksi}" data-toko-id="${res.toko_id}"><i class="fa fa-check-circle"></i></button>`;
							}else{
								return '-';
							}
						}
					}
				]
			});
		}

		transfer(params) {
			let transaksi_id = params['transaksi_id'];
			let no_transaksi = params['no_transaksi'];
			let toko_id = params['toko_id'];

			callApi("admin/transaksi_pengajuan/transfer", {
				transaksi_id: transaksi_id,
				no_transaksi: no_transaksi,
				toko_id: toko_id
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

	var transaksi_pengajuan = new Transaksi_pengajuan;

	$(document).on("click", "button.transaksi--reload", function () {
		$("form.filter select.status").val('').trigger('change');

		transaksi_pengajuan.run();
	})

	$(document).on("click", "button.transaksi--transfer", function () {
		let transaksi_id = $(this).data('transaksi-id');
		let no_transaksi = $(this).data('no-transaksi');
		let toko_id = $(this).data('toko-id');

		transaksi_pengajuan.transfer({
			transaksi_id: transaksi_id,
			no_transaksi: no_transaksi,
			toko_id: toko_id
		});
	})

	$(document).on("submit", "form.filter", function () {
		$("div#filter").modal('hide');

		let status = $("form.filter select.status").val();

		transaksi_pengajuan.run({
			status: status
		});

		return false;
	})
</script>