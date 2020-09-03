<script>
	var $jp_client_token = check_auth()

	class Pembelian_detail {
		constructor() {
			this.run();
		}

		run() {
			var list = $("div.payment-detail--list").html('');
			$("div.payment-detail--loading").removeClass('none');
			$("div.payment-detail--list").addClass('none');
			callApi("user/pembelian/detail", {
				client_token: $jp_client_token,
				no_invoice: "<?php echo $no_invoice; ?>"
			}, res => {
				$("div.payment-detail--loading").addClass('none');
				$("div.payment-detail--list").removeClass('none');

				$.each(res.Data, function(index, val) {

					$("div.payment--status-tagihan").html(val.status);
					if (val.status == "Belum dibayar" && val.payment_metode == "manual") {
						$("div.payment--status-tagihan").html(`${val.status} <button type="button" class="btn-warning btn-xs" style="border: none; border-radius: 3px; font-size: 13px;" data-toggle="modal" data-target="#upload-payment"><i class="fa fa-upload"></i> Upload bukti pembayaran</button>`);
					}
					$("div.payment--ppn").html(`Rp. ${rupiah(val.ppn)}`);
					$("div.payment--total-bayar").html(`Rp. ${rupiah(val.total_bayar)}`);
					$("div.payment--alamat-pengiriman").html(`
						<b>${val.alamat_penerima_nama}</b> (${val.alamat_nama})<br>
						${val.alamat_detail}<br>
						${val.alamat_kecamatan_nama}, ${val.alamat_kabupaten_nama}<br>
						${val.alamat_provinsi_nama}<br>
						Telepon/Handphone: ${val.alamat_penerima_telepon}
					`);

					$("a.btn-print-transaksi").removeClass('none');
					if (val.status == "Dibatalkan") {
						$("a.btn-print-transaksi").addClass('none');
					}

					if (val.payment_bukti != null) {
						$("div.payment-bukti").html(`<img src="${val.payment_bukti}" alt="">`);
					}

					if (val.payment_metode == "midtrans") {
						var payment_detail = `-`;
						if (val.payment_output != null) {
							payment_detail = `<a href="${JSON.parse(val.payment_output).pdf_url}" target="blank" class="detail-pembayaran">klik disini untuk detail pembayaran</a>`;
						}
					}else{
						var payment_detail = `<a href="javascript:;" class="detail-pembayaran detail-pembayaran-manual" data-toggle="modal" data-target="#payment-manual">klik disini untuk detail pembayaran</a>`;
					}
					$("div.payment--detail-pembayaran").html(payment_detail);

					$("div.payment--tanggal").html(val.created_at);

					var output = '';
					$.each(val.toko, function(toko_index, toko_val) {

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

						var action = '-';
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

								action = `
								<button type="button" class="btn btn-danger btn-sm">Ajukan Pengembalian</button>
								<button type="button" class="btn btn-success btn-sm transaksi--terima-barang" data-toggle="modal" data-target="#terima-pesanan" data-no-transaksi="${toko_val.no_transaksi}">Terima Barang</button>
								`;
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
							// no_resi = `<a href="https://cekresi.com/?noresi=${toko_val.kurir_resi}" style="color: red; border-bottom: 1px dotted red;" target="blank">${toko_val.kurir_resi}</a>`;
							no_resi = `<a href="javascript:;" style="border-bottom: 1px dotted red;" class="text-primary" onclick="pembelian_detail.get_tracking('${toko_val.kurir_resi}','${toko_val.kurir_code}')">${toko_val.kurir_resi}</a>`;
						}

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

							let ulasan = '',
								komplain = '';

							if (toko_val.status == "Dikirim" || toko_val.status == "Selesai") {
								ulasan = `<button class="btn btn-ulasan mb-2" data-toko-id="${toko_val.toko_id}" data-produk-id="${produk_val.produk_id}" data-produk-foto="${foto}" data-produk-nama="${produk_val.produk_nama}" data-produk-qty="${produk_val.qty}" data-produk-berat="${produk_val.produk_berat}" data-toggle="modal" data-target="#payment-ulasan">Beri ulasan</button>`;
							}

							if(produk_val.komplain == 0 && (toko_val.status == "Dikirim" || toko_val.status == "Selesai")){
								komplain = `<button class="btn btn-sm btn-danger btn--komplain" data-produk-nama="${produk_val.produk_nama}" data-produk-id="${produk_val.produk_id}">Komplain</button>`
							}

							produk += `
								<div class="grid">
									<div class="payment-card bg-white">
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
												Rp. ${rupiah(parseInt(produk_val.produk_harga) * parseInt(produk_val.qty))} <br>
												${ulasan}<br>
												${komplain}
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
											<div class="card border-0 shadow-sm">
												<div class="card-body">
													<div class="step--status" id="step--status-${toko_val.toko_id}">
														<div class="step--status-line">
															<div class="step--status-value"></div>
														</div>
														<div class="step--status-list">
															<div class="step--list-item" data-status="Menunggu diproses">
																<div class="list-item-content" style="">
																</div>
																<small><i class="fa fa-smile"></i> Menunggu diproses</small>
															</div>
															<div class="step--list-item" data-status="Diproses">
																<div class="list-item-content" style="">
																</div>
																<small><i class="fa fa-box"></i> diproses</small>
															</div>
															<div class="step--list-item" data-status="Dikirim">
																<div class="list-item-content" style="">
																</div>
																<small><i class="fa fa-car-side"></i> Dikirim</small>
															</div>
															<div class="step--list-item" data-status="Selesai">
																<div class="list-item-content" style="">
																</div>
																<small><i class="fa fa-box-open"></i> Diterima</small>
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
							$('#step--status-'+toko_val.toko_id+' .step--list-item[data-status="'+toko_val.status+'"]').trigger('set.active')
						},1000)
					});

					list.append(output);
				});
			})
		}

		capitalize(s)
		{
		    return s[0].toUpperCase() + s.slice(1);
		}

		run_ulasan(params) {
			$("div.modal-ulasan--loading").removeClass('none');
			$("div.modal-ulasan").addClass('none');

			let toko_id = params['toko_id'];
			let produk_id = params['produk_id'];
			let produk_foto = params['produk_foto'];
			let produk_nama = params['produk_nama'];
			let produk_qty = params['produk_qty'];
			let produk_berat = params['produk_berat'];

			let ulasan = $("div.modal-ulasan").html('');

			callApi("user/pembelian/ulasan", {
				client_token: $jp_client_token,
				no_invoice: "<?php echo $no_invoice; ?>",
				produk_id: produk_id
			}, res => {
				$("div.modal-ulasan--loading").addClass('none');
				$("div.modal-ulasan").removeClass('none');

				if (res.Error) {
					var data = []
					let upload_foto = '', 
						ulasan_rating = 0,
						ulasan_content = '';
						if (data.ulasan != null) {
							ulasan_content = data.ulasan;
						}

						if (data.rating > 0) {
							ulasan_rating = data.rating;
						}

					$.each(data.foto, function(foto_index, foto_val) {
						upload_foto += `<img src="${foto_val.foto}" alt="">`;
					});

					ulasan.append(`
						<input type="hidden" name="" class="rating--produk-id" value="${produk_id}"/>
						<input type="hidden" name="" class="rating--toko-id" value="${toko_id}"/>
						<div class="ulasan">
							<div class="ulasan-header">
								<img src="${produk_foto}" alt="">
								<div class="identity">
									<div class="produk">${produk_nama}</div>
									<div class="produk-detail">
										Jumlah: ${produk_qty}<br>
										Berat: ${produk_berat}g
									</div><br>
								</div>
							</div>
							<div class="ulasan-body">
								<div class="rating">
									<span data-bintang="5" data-produk-id="${produk_id}">☆</span>
									<span data-bintang="4" data-produk-id="${produk_id}">☆</span>
									<span data-bintang="3" data-produk-id="${produk_id}">☆</span>
									<span data-bintang="2" data-produk-id="${produk_id}">☆</span>
									<span data-bintang="1" data-produk-id="${produk_id}">☆</span>
									<div data-produk-id="${produk_id}">Rating ${ulasan_rating}/5</div>
								</div>
								<div class="form-group">
									<label for="" class="control-label">Ulasan <sup style="font-size: 11px; font-family: arial;">(Opsional)</sup></label>
									<div class="ulasan-label" onselectstart="return false;" data-produk-id="${produk_id}" data-label="Harga">Harga</div>
									<div class="ulasan-label" onselectstart="return false;" data-produk-id="${produk_id}" data-label="Kualitas">Kualitas</div>
									<div class="ulasan-label" onselectstart="return false;" data-produk-id="${produk_id}" data-label="Sesuai">Sesuai</div>
									<div class="ulasan-label" onselectstart="return false;" data-produk-id="${produk_id}" data-label="Awet">Awet</div>
									<textarea placeholder="Tulis ulasan anda disini..." rows="3" style="resize: none;" class="form-control ulasan" data-produk-id="${produk_id}">${ulasan_content}</textarea>
								</div>
								<div class="form-group upload-foto" data-produk-id="${produk_id}">
									<label for="" class="control-label">Lampirkan foto barang <i style="font-size: 11px; color grey;">(Maks. 5 foto)</i></label>
									<div class="output-foto-db">
										${upload_foto}
									</div>
									<div class="output-foto">
									</div>
									<div class="upload">
										<label for="foto-produk" class="control-label"></label>
										<input type="file" id="foto-produk" data-produk-id="${produk_id}" multiple class="none foto-produk">
									</div>
								</div>
							</div>
						</div>
					`);

					let value = $("textarea.ulasan").val();
					let value_array = value.split(" ");
					$("div.ulasan-label[data-label=Harga]").removeClass('active');
					$("div.ulasan-label[data-label=Kualitas]").removeClass('active');
					$("div.ulasan-label[data-label=Sesuai]").removeClass('active');
					$("div.ulasan-label[data-label=Awet]").removeClass('active');
					if (value.toLowerCase().search('harga') >= 0) {
						$("div.ulasan-label[data-label=Harga]").addClass('active');
					}
					if (value.toLowerCase().search('kualitas') >= 0) {
						$("div.ulasan-label[data-label=Kualitas]").addClass('active');
					}
					if (value.toLowerCase().search('sesuai') >= 0) {
						$("div.ulasan-label[data-label=Sesuai]").addClass('active');
					}
					if (value.toLowerCase().search('awet') >= 0) {
						$("div.ulasan-label[data-label=Awet]").addClass('active');
					}

					$(`div.rating span[data-bintang=${ulasan_rating}]`).addClass('active');
				}else{
					var data = res.Data
					let upload_foto = '', 
						ulasan_rating = 0,
						ulasan_content = '';
						if (data.ulasan != null) {
							ulasan_content = data.ulasan;
						}

						if (data.rating > 0) {
							ulasan_rating = data.rating;
						}

					$.each(data.foto, function(foto_index, foto_val) {
						upload_foto += `<img src="${foto_val.foto}" alt="">`;
					});

					ulasan.append(`
						<input type="hidden" name="" class="rating--produk-id" value="${produk_id}"/>
						<input type="hidden" name="" class="rating--toko-id" value="${toko_id}"/>
						<div class="ulasan">
							<div class="ulasan-header">
								<img src="${produk_foto}" alt="">
								<div class="identity">
									<div class="produk">${produk_nama}</div>
									<div class="produk-detail">
										Jumlah: ${produk_qty}<br>
										Berat: ${produk_berat}g
									</div><br>
								</div>
							</div>
							<div class="ulasan-body">
								<div class="rating">
									<span data-bintang="5" data-produk-id="${produk_id}">☆</span>
									<span data-bintang="4" data-produk-id="${produk_id}">☆</span>
									<span data-bintang="3" data-produk-id="${produk_id}">☆</span>
									<span data-bintang="2" data-produk-id="${produk_id}">☆</span>
									<span data-bintang="1" data-produk-id="${produk_id}">☆</span>
									<div data-produk-id="${produk_id}">Rating ${ulasan_rating}/5</div>
								</div>
								<div class="form-group">
									<label for="" class="control-label">Ulasan <sup style="font-size: 11px; font-family: arial;">(Opsional)</sup></label>
									<div class="ulasan-label" onselectstart="return false;" data-produk-id="${produk_id}" data-label="Harga">Harga</div>
									<div class="ulasan-label" onselectstart="return false;" data-produk-id="${produk_id}" data-label="Kualitas">Kualitas</div>
									<div class="ulasan-label" onselectstart="return false;" data-produk-id="${produk_id}" data-label="Sesuai">Sesuai</div>
									<div class="ulasan-label" onselectstart="return false;" data-produk-id="${produk_id}" data-label="Awet">Awet</div>
									<textarea placeholder="Tulis ulasan anda disini..." rows="3" style="resize: none;" class="form-control ulasan" data-produk-id="${produk_id}">${ulasan_content}</textarea>
								</div>
								<div class="form-group upload-foto" data-produk-id="${produk_id}">
									<label for="" class="control-label">Lampirkan foto barang <i style="font-size: 11px; color grey;">(Maks. 5 foto)</i></label>
									<div class="output-foto-db">
										${upload_foto}
									</div>
									<div class="output-foto">
									</div>
									<div class="upload">
										<label for="foto-produk" class="control-label"></label>
										<input type="file" id="foto-produk" data-produk-id="${produk_id}" multiple class="none foto-produk">
									</div>
								</div>
							</div>
						</div>
					`);

					let value = $("textarea.ulasan").val();
					let value_array = value.split(" ");
					$("div.ulasan-label[data-label=Harga]").removeClass('active');
					$("div.ulasan-label[data-label=Kualitas]").removeClass('active');
					$("div.ulasan-label[data-label=Sesuai]").removeClass('active');
					$("div.ulasan-label[data-label=Awet]").removeClass('active');
					if (value.toLowerCase().search('harga') >= 0) {
						$("div.ulasan-label[data-label=Harga]").addClass('active');
					}
					if (value.toLowerCase().search('kualitas') >= 0) {
						$("div.ulasan-label[data-label=Kualitas]").addClass('active');
					}
					if (value.toLowerCase().search('sesuai') >= 0) {
						$("div.ulasan-label[data-label=Sesuai]").addClass('active');
					}
					if (value.toLowerCase().search('awet') >= 0) {
						$("div.ulasan-label[data-label=Awet]").addClass('active');
					}

					$(`div.rating span[data-bintang=${ulasan_rating}]`).addClass('active');
				}
			})
		}

		ulasanAdd(params) {
			callApi("user/pembelian/ulasan_add", {
				client_token: $jp_client_token,
				no_invoice: "<?php echo $no_invoice; ?>",
				toko_id: params['toko_id'],
				produk_id: params['produk_id'],
				rating: params['rating'],
				ulasan: params['ulasan'],
				foto: JSON.stringify(params['foto'])
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5000);
				}else{
					// this.run();
					notifAlert(message, "success", 5000);
					$("div#payment-ulasan").modal('hide');
				}
			})
		}

		komplainAdd(params) {
			callApi("user/pembelian/komplain_add", {
				client_token: $jp_client_token,
				no_invoice: "<?php echo $no_invoice; ?>",
				produk_id: params['produk_id'],
				komplain: params['komplain']
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
				// 	notifAlert(message, "error", 5000);
					notif('#payment-komplain .msg-content','danger',res.Message,5000)
				}else{
					// this.run();
					notif('#payment-komplain .msg-content','success',res.Message,5000)
					$("div#payment-komplain").modal('hide');
					pembelian_detail.run()
				}
			})
		}

		uploadBuktiPembayaran(params) {
			let file = params['file'];
			callApi("user/pembelian/upload_pembayaran", {
				client_token: $jp_client_token,
				no_invoice: "<?php echo $no_invoice; ?>",
				file: file
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5);
				}else{
					notifAlert(message, "success", 5);
				}
				this.run();
			})
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

		transaksiTerimaPesanan(params) {
			let no_transaksi = params['no_transaksi'];

			callApi("user/pembelian/terima", {
				client_token: $jp_client_token,
				no_invoice: "<?php echo $no_invoice; ?>",
				no_transaksi: no_transaksi
			}, res => {
				$("div#terima-pesanan").modal('hide');
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5000);
				}else{
					this.run();
					notifAlert(message, "success", 5000);
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

	var pembelian_detail = new Pembelian_detail;

	$(document).on("click", "button.transaksi--terima-barang", function () {
		let no_transaksi = $(this).data('no-transaksi');
	})

	$(document).on("click", "button.btn-ulasan", function () {
		let toko_id = $(this).data('toko-id');
		let produk_id = $(this).data('produk-id');
		let produk_foto = $(this).data('produk-foto');
		let produk_nama = $(this).data('produk-nama');
		let produk_qty = $(this).data('produk-qty');
		let produk_berat = $(this).data('produk-berat');

		pembelian_detail.run_ulasan({
			toko_id: toko_id,
			produk_id: produk_id,
			produk_foto: produk_foto,
			produk_nama: produk_nama,
			produk_qty: produk_qty,
			produk_berat: produk_berat
		});
	})

	$(document).on("change", "input.upload-pembayaran", function (e) {
		let files = e.target.files[0];
		if (files.type.search('image') >= 0) {
			$.canvasResize(files, {
		        width: 0,
		        height: 0,
		        crop: false,
		        quality: 80,
		        callback: function(data, width, height) {
		        	pembelian_detail.uploadBuktiPembayaran({
		        		file: data
		        	});
		        }
		    });
		}else{
			notifAlert("File harus berformat <b>.jpeg</b>, <b>.jpg</b>, <b>.png</b>", "error", 5);
		}
	})

	$(document).on("click", "a.detail-pembayaran-manual", function () {
		pembelian_detail.paymentManual();
	})

	$(document).on("click", "div.ulasan-label", function () {
		let produk_id = $(this).data('produk-id');
		let value = $(this).html();
		let ulasan = $(`textarea.ulasan[data-produk-id=${produk_id}]`);
		if (ulasan.val().search(value) > 0) {
			$(this).removeClass('active');
			ulasan.val(`${ulasan.val().split(` ${value}`).join('')}`);
		}else{
			$(this).addClass('active');
			let ulasan_text = ulasan.val();
			ulasan.val(`${ulasan_text} ${value}`);
		}
	})

	$(document).on("keyup", "textarea.ulasan", function () {
		let value = $(this).val();
		let value_array = value.split(" ");
		$("div.ulasan-label[data-label=Harga]").removeClass('active');
		$("div.ulasan-label[data-label=Kualitas]").removeClass('active');
		$("div.ulasan-label[data-label=Sesuai]").removeClass('active');
		$("div.ulasan-label[data-label=Awet]").removeClass('active');
		if (value.toLowerCase().search('harga') >= 0) {
			$("div.ulasan-label[data-label=Harga]").addClass('active');
		}
		if (value.toLowerCase().search('kualitas') >= 0) {
			$("div.ulasan-label[data-label=Kualitas]").addClass('active');
		}
		if (value.toLowerCase().search('sesuai') >= 0) {
			$("div.ulasan-label[data-label=Sesuai]").addClass('active');
		}
		if (value.toLowerCase().search('awet') >= 0) {
			$("div.ulasan-label[data-label=Awet]").addClass('active');
		}
	})

	$(document).on("click", "div.rating span", function () {
		let produk_id = $(this).data('produk-id');
		$(`div.rating span[data-produk-id=${produk_id}]`).removeClass('active');
		$(`div.rating div[data-produk-id=${produk_id}]`).html(`Rating: ${$(this).data('bintang')}/5`);
		$(this).addClass('active');
	})

	$(document).on("change", "input.foto-produk", function (e) {
		var files = e.target.files;
		var files_length = files.length;
		var output_img = $(`div.upload-foto[data-produk-id=${$(this).attr('data-produk-id')}] div.output-foto`).html('');
		if (files_length > 5) {
			notifAlert("Maksimal upload foto hanya 5.", "error", 5);
		}else{
			var img = '';

			$(`div.upload-foto[data-produk-id=${$(this).attr('data-produk-id')}] div.output-foto`).html(`<img src="<?php echo base_url('assets/img/default/loader.gif'); ?>" alt="">`);

			if (files_length == 0) {
				$(`div.upload-foto[data-produk-id=${$(this).attr('data-produk-id')}] div.output-foto`).html('');
			}

			for (var i = 0; i < files_length; i++) {
				$.canvasResize(files[i], {
			        width: 100,
			        height: 100,
			        crop: false,
			        quality: 80,
			        callback: function(data, width, height) {
			            img += `<img src="${data}" alt=""><input type="hidden" name="foto-ulasan[]" class="foto-ulasan" value="${data}"/>`;
			            output_img.html(img);
			        }
			    });
			}
		}
	})

	$(document).on("submit", "form.payment--ulasan", function () {
		let toko_id = $("input.rating--toko-id").val();
		let produk_id = $("input.rating--produk-id").val();
		let rating = $("div.rating span.active").data('bintang');
		let ulasan = $("textarea.ulasan").val();
		let ulasan_foto = $("input.foto-ulasan");
		let foto = new Array();
		$.each(ulasan_foto, function(index, val) {
			foto.push({"file": $(this).val()});
		});

		pembelian_detail.ulasanAdd({
			toko_id: toko_id,
			produk_id: produk_id,
			rating: rating,
			ulasan: ulasan,
			foto: foto
		});

		return false;
	})

	$(document).on('click', '.btn--komplain', function(event) {
		event.preventDefault();
		$('#payment-komplain .content strong').html($(this).attr('data-produk-nama'))
		$('#payment-komplain form').attr('data-produk-id',$(this).attr('data-produk-id'))
		$('#payment-komplain').modal('show')
	});

	$(document).on('submit', '#payment-komplain form', function(event) {
		event.preventDefault();
		var komplain = $('#payment-komplain textarea.komplain').val(),
			produk_id = $(this).attr('data-produk-id')
		pembelian_detail.komplainAdd({
			produk_id: produk_id,
			komplain: komplain
		});
	});

	$(document).on("click", "button.transaksi--terima-barang", function () {
		let no_transaksi = $(this).data('no-transaksi');
		$("input[type=hidden].terima-pesanan--no-transaksi").val(no_transaksi);
	})

	$(document).on("click", "button.transaksi--ya-teruskan", function () {
		let no_transaksi = $("input[type=hidden].terima-pesanan--no-transaksi").val();
		pembelian_detail.transaksiTerimaPesanan({
			no_transaksi: no_transaksi
		})

		return false;
	})
</script>