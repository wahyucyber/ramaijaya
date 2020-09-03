<?php include 'Adm.php' ?>

<script>
	class Pembelian_detail {
		constructor() {
			this.run();
		}

		run() {
			var list = $("div.payment-detail--list").html('');
			$("div.payment-detail--loading").removeClass('none');
			$("div.payment-detail--list").addClass('none');
			callApi("admin/transaksi/detail", {
				no_invoice: "<?php echo $no_invoice; ?>"
			}, res => {
				$("div.payment-detail--loading").addClass('none');
				$("div.payment-detail--list").removeClass('none');

				$.each(res.Data, function(index, val) {

					$("div.payment--status-tagihan").html(val.status);
					if (val.status == "Belum dibayar") {
						$("div.payment--status-tagihan").html(`${val.status} <button type="button" class="btn-warning btn-xs" style="border: none; border-radius: 3px; font-size: 13px;" data-toggle="modal" data-target="#upload-payment">Bukti pembayaran</button>`);
					}
					$("div.payment--total-bayar").html(`Rp. ${rupiah(val.total_bayar)}`);
					$("div.payment--tanggal").html(`${val.created_at}`);
					$("div.payment--alamat-pengiriman").html(`
						<b>${val.alamat_penerima_nama}</b> (${val.alamat_nama})<br>
						${val.alamat_detail}<br>
						${val.alamat_kecamatan_nama}, ${val.alamat_kabupaten_nama}<br>
						${val.alamat_provinsi_nama}<br>
						Telepon/Handphone: ${val.alamat_penerima_telepon}
					`);

					if (val.payment_bukti != null) {
						$("div.payment-bukti").html(`<img src="${val.payment_bukti}" alt="">`);
					}

					if (val.payment_metode == "midtrans") {
						var payment_detail = `-`;
						if (res.payment_output != null) {
							payment_detail = `<a href="${JSON.parse(val.payment_output).pdf_url}" target="blank" class="detail-pembayaran">klik disini untuk detail pembayaran</a>`;
						}
					}else{
						var payment_detail = `<a href="javascript:;" class="detail-pembayaran detail-pembayaran-manual" data-toggle="modal" data-target="#payment-manual">klik disini untuk detail pembayaran</a>`;
					}
					$("div.payment--detail-pembayaran").html(payment_detail);

					var output = '';
					$.each(val.toko, function(toko_index, toko_val) {

						var produk = ``;
						$.each(toko_val.produk, function(produk_index, produk_val) {
							if (produk_val.produk_foto[0].length == 0) {
								var foto = '<?php echo base_url('assets/img/default/no-image.png'); ?>';
							}else{
								var foto = produk_val.produk_foto[0].foto;
							}

							var catatan = '-';
							if (produk_val.catatan != "") {
								catatan = produk_val.catatan;
							}
							produk += `
								<div class="grid">
									<div class="payment-card">
										<div class="payment-body">
											<div class="produk--img">
												<img src="${foto}" alt="">
											</div>
											<div class="produk--informasi">
												<b>${produk_val.produk_nama}</b><br>
												<div class="informasi">
													jumlah: ${produk_val.qty} <br>
													berat: ${parseInt(produk_val.produk_berat) * parseInt(produk_val.qty)}g <br>
													Catatan: ${catatan}
												</div>
											</div>
											<div class="produk--total">
												Rp. ${rupiah(parseInt(produk_val.produk_harga) * parseInt(produk_val.qty))}
											</div>
										</div>
									</div>
								</div>
							`;
						});

						var status = `
							<div class="payment-status">
								<i class="fa fa-smile"></i> Menunggu diproses
							</div>
							<div class="payment-status">
								<i class="fa fa-box"></i> Diproses
							</div>
							<div class="payment-status">
								<i class="fa fa-car-side"></i> Dikirim
							</div>
							<div class="payment-status">
								<i class="fa fa-box-open"></i> Selesai
							</div>
						`;
						var info = '-';

						if (val.status == "Dibayar") {
							if (toko_val.status == "Menunggu diproses") {
								status = `
									<div class="payment-status payment-active">
										<i class="fa fa-smile"></i> Menunggu diproses
									</div>
									<div class="payment-status">
										<i class="fa fa-box"></i> Diproses
									</div>
									<div class="payment-status">
										<i class="fa fa-car-side"></i> Dikirim
									</div>
									<div class="payment-status">
										<i class="fa fa-box-open"></i> Selesai
									</div>
								`;
								info = `Pesanan akan dibatalkan secara otomatis oleh system jika pesanan belum dikirim sampai tanggal <b>${toko_val.expired_at}</b>`;
							}else if (toko_val.status == "Diproses") {
								status = `
									<div class="payment-status payment-active">
										<i class="fa fa-smile"></i> Menunggu diproses
									</div>
									<div class="payment-status payment-active" title="${toko_val.log_diproses}">
										<i class="fa fa-box"></i> Diproses
									</div>
									<div class="payment-status">
										<i class="fa fa-car-side"></i> Dikirim
									</div>
									<div class="payment-status">
										<i class="fa fa-box-open"></i> Selesai
									</div>
								`;
								info = `Pesanan akan dibatalkan secara otomatis oleh system jika pesanan belum dikirim sampai tanggal <b>${toko_val.expired_at}</b>`;
							}else if (toko_val.status == "Dikirim") {
								status = `
									<div class="payment-status payment-active">
										<i class="fa fa-smile"></i> Menunggu diproses
									</div>
									<div class="payment-status payment-active" title="${toko_val.log_diproses}">
										<i class="fa fa-box"></i> Diproses
									</div>
									<div class="payment-status payment-active" title="${toko_val.log_dikirim}">
										<i class="fa fa-car-side"></i> Dikirim
									</div>
									<div class="payment-status">
										<i class="fa fa-box-open"></i> Selesai
									</div>
								`;

								info = `Pesanan <u>dikirim</u> pada tanggal <b>${toko_val.log_dikirim}</b>`;
							}else if (toko_val.status == "Selesai") {
								status = `
									<div class="payment-status payment-active">
										<i class="fa fa-smile"></i> Menunggu diproses
									</div>
									<div class="payment-status payment-active" title="${toko_val.log_diproses}">
										<i class="fa fa-box"></i> Diproses
									</div>
									<div class="payment-status payment-active" title="${toko_val.log_dikirim}">
										<i class="fa fa-car-side"></i> Dikirim
									</div>
									<div class="payment-status payment-active" title="${toko_val.log_diterima}">
										<i class="fa fa-box-open"></i> Selesai
									</div>
								`;

								info = `Pesanan <u>sampai</u> pada tanggal <b>${toko_val.log_diterima}</b>`;
							}else if (toko_val.status == "Dibatalkan") {
								info = `Pesanan <u><b>dibatalkan</b></u>`;
							}
						}

						var no_resi = '-';
						if (toko_val.kurir_resi != "") {
							no_resi = `<a href="https://cekresi.com/?noresi=${toko_val.kurir_resi}" style="color: red; border-bottom: 1px dotted red;" target="blank">${toko_val.kurir_resi}</a>`;
						}

						output+= `
							<div class="payment-detail">
								<div class="grid">
									<div class="payment-card">
										<div class="payment-title">
											NO. TRANSAKSI
										</div>
										<div class="payment-body">
											${toko_val.no_transaksi}
										</div>
									</div>
									<div class="payment-card">
										<div class="payment-title">
											TOKO
										</div>
										<div class="payment-body">
											${toko_val.toko_nama}
										</div>
									</div>
								</div>
								${produk}
								<div class="grid">
									<div class="payment-card bg-white">
										<div class="payment-title">
											STATUS PEMBELIAN
										</div>
										<div class="payment-body">
											${status}
										</div>
									</div>
								</div>
								<div class="grid">
									<div class="payment-card bg-white">
										<div class="payment-title">
											JASA PENGIRIMAN
										</div>
										<div class="payment-body">
											<b>${toko_val.kurir}</b> (${toko_val.kurir_service})
										</div>
									</div>
									<div class="payment-card bg-white">
										<div class="payment-title">
											NO. RESI
										</div>
										<div class="payment-body">
											${no_resi}
										</div>
									</div>
									<div class="payment-card bg-white">
										<div class="payment-title">
											ONGKIR
										</div>
										<div class="payment-body">
											Rp. ${rupiah(toko_val.kurir_value)}
										</div>
									</div>
								</div>
								<div class="grid">
									<div class="payment-card bg-white">
										<div class="payment-title">
											Info
										</div>
										<div class="payment-body" style="font-size: 13px;">
											${info}
										</div>
									</div>
								</div>
							</div>
						`;
					});

					list.append(output);
				});
			})
		}

		capitalize(s)
		{
		    return s[0].toUpperCase() + s.slice(1);
		}

		paymentManual() {
			callApi("user/pembelian/payment_manual", null, res => {
				if (res.Data.length == 0) {
					notif("div#payment-manual div.modal-body", "danger", "Pembayaran manual content belum tersedia.");
				}else{
					$("div#payment-manual div.modal-body").html(res.Data.content);
				}
			})
		}
	}

	var pembelian_detail = new Pembelian_detail;

	$(document).on("click", "a.detail-pembayaran-manual", function () {
		pembelian_detail.paymentManual();
	})
</script>