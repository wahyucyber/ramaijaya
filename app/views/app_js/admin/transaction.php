<?php include 'Adm.php' ?>

<script>
	class Transaksi {
		constructor() {
			this.run();
		}

		run(status = null, payment_metode = null) {
			// let status = params['status'];
			// let payment_metode = params['payment_metode'];
			let Tabel = new Table;
			Tabel.run({
				tabel: "table.data-transaksi",
				url: "admin/transaksi/",
				data: {
					status: status,
					payment: payment_metode
				},
				columns: [
					{
						data: null,
						render: function (data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1 + '.';
						}
					},
					{
						data: "no_invoice"
					},
					{
						data: "created_at"
					},
					{
						data: "status"
					},
					{
						data: null,
						render: res => {
							return `Rp. ${rupiah(res.total_bayar)}`;
							// return `Rp. ${res.total_bayar}`;
						}
					},
					{
						data: "payment_metode"
					},
					{
						data: null,
						render: res => {
							let action = `<a href="<?php echo base_url('admin/transaction/detail/'); ?>${res.no_invoice}/${res.user_id}" class="btn btn-sm btn-success text-white" style="cursor: pointer;"><i class="fa fa-eye"></i></a> `;
							if (res.payment_metode == "manual" && res.status == "Belum dibayar") {
								action += `<button type="button" class="btn btn-primary btn-sm bukti-pembayaran" data-toggle="modal" data-target="#bukti-pembayaran" data-bukti-pembayaran="${res.payment_bukti}" data-no-invoice="${res.no_invoice}"><i class="fa fa-check-circle"></i></button>`;
							}

							return action;
						}
					}
				]
			});
		}

		verifikasi(params) {
			let no_invoice = params['no_invoice'];

			callApi("admin/transaksi/verifikasi_pembayaran", {
				no_invoice: no_invoice
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, 'error', 5);
				}else{
					notifAlert(message, 'success', 5);
					this.run();
					$("div#bukti-pembayaran").modal('hide');
				}
			})
		}
	}

	var transaksi = new Transaksi;

	$(document).on("click", "button.bukti-pembayaran", function() {
		let bukti_pembayaran = $(this).data('bukti-pembayaran');
		let no_invoice = $(this).data('no-invoice');

		$("div#bukti-pembayaran input[type=hidden].no-invoice").val(no_invoice);

		if (bukti_pembayaran == null) {
			notif("div#bukti-pembayaran div.modal-body", "danger", "Bukti pembayaran belum diupload.");
		}else{
			$("div#bukti-pembayaran div.modal-body").attr('align', 'center');
			$("div#bukti-pembayaran div.modal-body").html(`
				<img src="${bukti_pembayaran}" alt="">
			`);
		}
	})

	$(document).on("click", "button.bukti-pembayaran--konfirmasi", function () {
		let no_invoice = $("div#bukti-pembayaran input[type=hidden].no-invoice").val();

		transaksi.verifikasi({
			no_invoice: no_invoice
		});
	})

	$(document).on("click", "button.transaksi--reload", function () {
		$("select.filter--status").val('');
		$("select.filter--payment-metode").val('');
		transaksi.run();
	})

	$(document).on("submit", "form.form--filter", function () {
		let status = $("select.filter--status").val();
		let payment_metode = $("select.filter--payment-metode").val();

		transaksi.run(status, payment_metode);

		$("div#filter").modal('hide');

		return false;
	})
</script>