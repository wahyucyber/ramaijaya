<?php include 'Adm.php' ?>

<script>
	class Transaksi_refund {
		constructor() {
			this.run();
		}

		run(params = []) {
			let table = new Table;

			table.run({
				tabel: "table.data--transaksi-refund",
				url: "admin/Transaksi_refund",
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
						data: "user_nama"
					},
					{
						data: null,
						render: res => {
							return `Rp. ${rupiah(res.total)}`;
						}
					},
					{
						data: null,
						render: res => {
							let status = ``;
							if (res.status == "Belum ditransfer") {
								status = `danger`;
							}else{
								status = `success`;
							}
							return `<div class="badge badge-${status}">${res.status}</div>`;
						}
					},
					{
						data: null,
						render: res => {
							if (res.status == "Belum ditransfer") {
								return `<button type="button" class="btn btn-success btn-sm transaksi--transfer" data-transaksi-id="${res.transaksi_id}" data-no-transaksi="${res.no_transaksi}"><i class="fa fa-check-circle"></i></button>`;
							}else{
								return '-';
							}
						}
					}
				]
			})
		}

		transfer(params) {
			let transaksi_id = params['transaksi_id'];
			let no_transaksi = params['no_transaksi'];

			callApi("admin/transaksi_refund/transfer", {
				transaksi_id: transaksi_id,
				no_transaksi: no_transaksi
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

	let transaksi_refund = new Transaksi_refund;

	$(document).on("click", "button.transaksi--reload", function () {
		$("form.filter select.status").val('').trigger('change');

		transaksi_refund.run();
	})

	$(document).on("click", "button.transaksi--transfer", function () {
		let transaksi_id = $(this).data('transaksi-id');
		let no_transaksi = $(this).data('no-transaksi');

		transaksi_refund.transfer({
			transaksi_id: transaksi_id,
			no_transaksi: no_transaksi
		});
	})

	$(document).on("submit", "form.filter", function () {
		$("div#filter").modal('hide');

		let status = $("form.filter select.status").val();

		transaksi_refund.run({
			status: status
		});

		return false;
	})
</script>