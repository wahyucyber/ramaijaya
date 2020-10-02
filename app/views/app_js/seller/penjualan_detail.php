<?php include 'Seller.php' ?>

<script>
	var $jp_client_token = check_auth()

	class Penjualan_detail {
		constructor() {
			this.run();
		}

		run() {
			var list = $("div.payment-detail--list").html('');
			$("div.payment-detail--loading").removeClass('none');
			$("div.payment-detail--list").addClass('none');
			callApi("seller/pesanan/detail", {
				client_token: $jp_client_token,
				no_transaksi: "<?php echo $no_transaksi; ?>"
			}, res => {
				$("div.payment-detail--loading").addClass('none');
				$("div.payment-detail--list").removeClass('none');

				var output = '';

				// $.each(res.Data, function(index, val) {

					$("a.print-pesanan").attr({
						href: `<?php echo base_url('seller/penjualan/cetak/'); ?>${res.Data.no_invoice}/${res.Data.no_transaksi}/${res.Data.user_id}`,
						property2: 'value2'
					});

					$("div.payment--no-invoice").html(`#${res.Data.no_invoice}`);
					$("div.payment--status-tagihan").html(res.Data.status);
					$("div.payment--total-bayar").html(`Rp. ${rupiah(res.Data.total_transaksi)}`);
					$("div.payment--tanggal").html(`${res.Data.created_at}`);
					$("div.payment--alamat-pengiriman").html(`
						<b>${res.Data.user_alamat.penerima_nama}</b> (${res.Data.user_alamat.nama})<br>
						${res.Data.user_alamat.detail}<br>
						${res.Data.user_alamat.kecamatan_nama}, ${res.Data.user_alamat.kabupaten_nama}<br>
						${res.Data.user_alamat.provinsi_nama}<br>
						Telepon/Handphone: ${res.Data.user_alamat.penerima_no_telepon}
					`);


					// var payment_detail = `<a href="${JSON.parse(res.Data.payment_output).pdf_url}" target="blank" class="detail-pembayaran">klik disini untuk detail pembayaran</a>`;
					var payment_detail = `-`;
					if (res.payment_output != null) {
						payment_detail = `<a href="${JSON.parse(val.payment_output).pdf_url}" target="blank" class="detail-pembayaran">klik disini untuk detail pembayaran</a>`;
					}
					$("div.payment--detail-pembayaran").html(payment_detail);

					var action = '-';
					var info = '-';

					if (res.Data.status_transaksi == "Dibayar") {
						if (res.Data.status == "Menunggu diproses") {
							action = `
								<button type="button" class="btn btn-danger btn-sm"><i class="fal fa-times-circle"></i>	Tolak</button>
								<button type="button" class="btn btn-success btn-sm transaksi--proses" data-no-invoice="${res.Data.no_invoice}"><i class="fal fa-check-circle"></i>	Prosess</button>
							`;
							info = `Pesanan akan dibatalkan secara otomatis oleh system jika pesanan belum dikirim sampai tanggal <b>${res.Data.expired_at}</b>`;
						}else if (res.Data.status == "Diproses") {
							action = `
								<form class="transaksi--input-resi">
								  <div class="form-row" style="float: right;">
								    <div class="col-auto">
								      <input type="text" class="form-control mb-2 form-control-sm no-resi" data-no-invoice="${res.Data.no_invoice}" placeholder="Input No. RESI">
								    </div>
								    <div class="col-auto">
								      <button type="submit" class="btn btn-warning mb-2 btn-sm"><i class="fal fa-paper-plane"></i>	Kirim</button>
								    </div>
								  </div>
								</form>
							`;
							info = `Pesanan akan dibatalkan secara otomatis oleh system jika pesanan belum dikirim sampai tanggal <b>${res.Data.expired_at}</b>`;
						}else if (res.Data.status == "Dikirim") {
							info = `Pesanan <u>dikirim</u> pada tanggal <b>${res.Data.log_dikirim}</b>`;
						}else if (res.Data.status == "Selesai") {
							info = `Pesanan <u>sampai</u> pada tanggal <b>${res.Data.log_diterima}</b>`;
						}
					}else if (res.Data.payment_metode == "manual") {
						if (res.Data.status == "Menunggu diproses") {
							action = '';
						}else if (res.Data.status == "Dikirim") {
							action = '';
						}else if (res.Data.status == "Selesai") {
							action = '';
						}
					}

					var no_resi = '-';
					if (res.Data.kurir_resi != "") {
						no_resi = `<a href="javascript:;" class="text-link text-dark" onclick="penjualan_detail.get_tracking('${res.Data.kurir_resi}','${res.Data.kurir_code}')">${res.Data.kurir_resi}</a>`;
					}

					var produk = '';
					$.each(res.Data.produk, function(produk_index, produk_val) {
						if (produk_val.produk_foto.length == 0) {
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
												Rp. ${rupiah(parseInt(produk_val.harga) * parseInt(produk_val.qty))}
											</div>
										</div>
									</div>
								</div>
							`;
					});

					output+= `
						<div class="payment-detail">
							<div class="grid">
								<div class="payment-card">
									<div class="payment-title">
										NO. TRANSAKSI
									</div>
									<div class="payment-body">
										${res.Data.no_transaksi}
									</div>
								</div>
								<div class="payment-card">
									<div class="payment-title">
										PEMBELI
									</div>
									<div class="payment-body">
										${res.Data.user_nama}
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
										<div class="card border-0 shadow-sm">
											<div class="card-body">
												<div class="step--status" id="step--status-${res.Data.user_id}">
													<div class="step--status-line">
														<div class="step--status-value"></div>
													</div>
													<div class="step--status-list">
														<div class="step--list-item" data-status="Menunggu diproses" data-toggle="tooltip" data-placement="top" title="${res.Data.created_at}">
															<div class="list-item-content" style="">
															</div>
															<small><i class="text-orange fal fa-smile"></i> Menunggu diproses</small>
														</div>
														<div class="step--list-item" data-status="Diproses" data-toggle="tooltip" data-placement="top" title="${res.Data.log_diproses ?? ""}">
															<div class="list-item-content" style="">
															</div>
															<small><i class="text-orange fal fa-box"></i> diproses</small>
														</div>
														<div class="step--list-item" data-status="Dikirim" data-toggle="tooltip" data-placement="top" title="${res.Data.log_dikirim ?? ""}">
															<div class="list-item-content" style="">
															</div>
															<small><i class="text-orange fal fa-car-side"></i> Dikirim</small>
														</div>
														<div class="step--list-item" data-status="Selesai" data-toggle="tooltip" data-placement="top" title="${res.Data.log_diterima ?? ""}">
															<div class="list-item-content" style="">
															</div>
															<small><i class="text-orange fal fa-box-open"></i> Diterima</small>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="grid">
								<div class="payment-card bg-white">
									<div class="payment-title">
										JASA PENGIRIMAN
									</div>
									<div class="payment-body">
										<b>${res.Data.kurir}</b> (${res.Data.kurir_service})
									</div>
								</div>
								<div class="payment-card bg-white">
									<div class="payment-title">
										NO. RESI
									</div>
									<div class="payment-body ">
										${no_resi}
									</div>
								</div>
								<div class="payment-card bg-white">
									<div class="payment-title">
										ONGKIR
									</div>
									<div class="payment-body">
										Rp. ${rupiah(res.Data.kurir_value)}
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
								<div class="payment-card bg-white">
									<div class="payment-title">
										AKSI
									</div>
									<div class="payment-body" align="right">
										${action}
									</div>
								</div>
							</div>
						</div>
					`;
					setTimeout(function(){
						$('#step--status-'+res.Data.user_id+' .step--list-item[data-status="'+res.Data.status+'"]').trigger('set.active')
					},1000)
				// });

				list.append(output);
			})
		}

		proses(params) {
			var no_invoice = params['no_invoice'];
			callApi("seller/pesanan/proses", {
				client_token: $jp_client_token,
				no_invoice: no_invoice,
				no_transaksi: "<?php echo $no_transaksi; ?>"
			}, res => {
				var message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					penjualan_detail.run();
					notifAlert(message, "success", 5);
				}
			})
		}

		kirim(params) {
			var no_invoice = params['no_invoice'];
			var no_resi = params['no_resi'];

			callApi("seller/pesanan/kirim", {
				client_token: $jp_client_token,
				no_invoice: no_invoice,
				no_transaksi: "<?php echo $no_transaksi; ?>",
				no_resi: no_resi
			}, res => {
				var message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					penjualan_detail.run();
					notifAlert(message, "success", 5);
				}
			})
		}
		
		get_tracking(no_resi,courier_code)
		{
			var data = {
				no_resi: no_resi,
				courier_code: courier_code
			}

			callApi('tracking/',data,function(res){
				var output = ''
				if (res.Error) {
					notifAlert(res.Message,'error',5000)
				}else{
					var result = res.Data

					$.each(result,function(index,data){
						output += `<li>
									<div class="tracking--detail">
										<h6 class="tracking--title">${data.manifest_title}</h6>
										<div class="tracking--time">${data.manifest_time}</div>
									</div>
									<div class="tracking--description">${data.manifest_description}</div>
								</li>`
					})

					$('#ModalTracking #tracking').html(output)
					$('#ModalTracking').modal('show')
				}

			})
		}
	}

	var penjualan_detail = new Penjualan_detail;

	$(document).on("click", "button.transaksi--proses", function () {
		var no_invoice = $(this).data('no-invoice');
		penjualan_detail.proses({
			no_invoice: no_invoice
		});
	})

	$(document).on("submit", "form.transaksi--input-resi", function () {
		var input = $("input.no-resi");
		var no_resi = input.val();
		var no_invoice = input.data('no-invoice');

		penjualan_detail.kirim({
			no_invoice: no_invoice,
			no_resi: no_resi
		});

		return false;
	})
</script>