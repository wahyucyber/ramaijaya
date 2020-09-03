<?php 
if (env('MIDTRANS_ENV') == "development") {
 ?>
 	<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo env('MIDTRANS_CLIENT_KEY'); ?>"></script>
<?php }else{ ?>
	<script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="<?php echo env('MIDTRANS_CLIENT_KEY'); ?>"></script>
<?php } ?>
<script>
	class Payment {
		constructor() {
			this.produk = '';
			this.tujuan_id = '';
			this.run();
			this.alamatPengiriman();
			this.provinsi();
			this.kabupaten();
			this.kecamatan();
		}

		run() {

			let output = $("div.check-out").html('');

			callApi("cart/checkout", {
				client_token: $jp_client_token
			}, res => {
				let content = ``;

				if (res.Error == true) {
					redirect('')
				}

				var biaya = res.Biaya

				var biaya_ppn = biaya[0].value
				var biaya_admin = biaya[1].value

				let sub_total_produk = 0;
				$.each(res.Data, function(index, val) {

					let produk = ``;
					let produk_selanjutnya = ``;
					let produk_urutan = 0;
					let produk_jumlah = val.produk.length;
					let produk_total_berat = 0;

					$.each(val.produk, function(produk_index, produk_val) {
						produk_urutan++;

						produk_total_berat += parseInt(produk_val.berat) * parseInt(produk_val.jumlah);

						if (produk_val.diskon == 0) {
							sub_total_produk += parseInt(produk_val.harga) * parseInt(produk_val.jumlah);
						}else{
							sub_total_produk += parseInt(produk_val.harga_diskon) * parseInt(produk_val.jumlah);
						}

						let foto;
						if (produk_val.foto == null) {
							foto = '<?php echo base_url('assets/img/default/no-image-small.png'); ?>';
						}else{
							foto = produk_val.foto[0].foto;
						}

						let catatan = '-';
						if (produk_val.catatan != "") {
							catatan = produk_val.catatan;
						}

						let action_produk = '';
						if (produk_jumlah > 1) {
							action_produk = `
								<div class="row">
									<div class="col-md-12 mt-2">
										<a href="javascript:;" class="produk-tampil-selengkapnya slide-down" data-toko-id="${val.toko_id}" style="font-size: 13px; color: red;"><i class="fa fa-chevron-down"></i> Tampilkan selengkapnya.</a>
									</div>
								</div>
							`;
						}

						if (produk_urutan == 1) {
							produk += `
								<div class="grid">
									<div class="payment-card bg-white">
										<div class="payment-body">
											<div class="row">
												<div class="col-md-2">
													<div style="width: 45%;">
														<img src="${foto}" alt="">
													</div>
												</div>
												<div class="col-md-3" style="font-weight: bold; margin: auto;">
													${produk_val.nama_produk}
												</div>
												<div class="col-md-1" style="margin: auto;">
													${produk_val.jumlah}
												</div>
												<div class="col-md-1" style="margin: auto;">
													${produk_val.berat}g
												</div>
												<div class="col-md-3" style="margin: auto;">
													${catatan}
												</div>
												<div class="col-md-2" style="margin: auto;font-size: 12px;">`
													if (produk_val.diskon == 0) {
														produk += `Rp. ${rupiah(parseInt(produk_val.harga) * parseInt(produk_val.jumlah))}`
													}else{
														produk += `<small class="text-secondary text-caret">Rp. ${rupiah(parseInt(produk_val.harga) * parseInt(produk_val.jumlah))}</small><br>
														 Rp. ${rupiah(parseInt(produk_val.harga_diskon) * parseInt(produk_val.jumlah))}`
													}
										produk += `</div>
											</div>
											${action_produk}
										</div>
									</div>
								</div>
							`;
						}else{
							produk_selanjutnya += `
								<div class="grid">
									<div class="payment-card bg-white">
										<div class="payment-body">
											<div class="row">
												<div class="col-md-2">
													<div style="width: 45%;">
														<img src="${foto}" alt="">
													</div>
												</div>
												<div class="col-md-3" style="font-weight: bold; margin: auto;">
													${produk_val.nama_produk}
												</div>
												<div class="col-md-1" style="margin: auto;">
													${produk_val.jumlah}
												</div>
												<div class="col-md-1" style="margin: auto;">
													${produk_val.berat}g
												</div>
												<div class="col-md-3" style="margin: auto;">
													${catatan}
												</div>
												<div class="col-md-2" style="margin: auto;font-size: 12px;">`
													if (produk_val.diskon == 0) {
														produk_selanjutnya += `Rp. ${rupiah(parseInt(produk_val.harga) * parseInt(produk_val.jumlah))}`
													}else{
														produk_selanjutnya += `<small class="text-secondary text-caret">Rp. ${rupiah(parseInt(produk_val.harga) * parseInt(produk_val.jumlah))}</small><br>
														 Rp. ${rupiah(parseInt(produk_val.harga_diskon) * parseInt(produk_val.jumlah))}`
													}
							produk_selanjutnya += `</div>
											</div>
										</div>
									</div>
								</div>
							`;
						}
					});

					content += `
						<div class="grid">
							<div class="payment-card">
								<div class="payment-title">
									NO. TRANSAKSI
								</div>
								<div class="payment-body">
									<span style="font-size: 11px; color: #ababab; font-family: arial;">Note* No. Transaksi generate otomatis oleh system.</span>
								</div>
							</div>
							<div class="payment-card">
								<div class="payment-title">
									LAPAK
								</div>
								<div class="payment-body">
									${val.toko_nama}
								</div>
							</div>
						</div>
						<div class="grid">
							<div class="payment-card bg-white">
								<div class="payment-title">
									<b>Items</b>
								</div>
							</div>
						</div>
						<div class="grid">
							<div class="payment-card bg-white">
								<div class="payment-title">
									<div class="row">
										<div class="col-md-2">Foto</div>
										<div class="col-md-3">Nama</div>
										<div class="col-md-1">QTY</div>
										<div class="col-md-1">Berat</div>
										<div class="col-md-3">Catatan</div>
										<div class="col-md-2">Subtotal</div>
									</div>
								</div>
							</div>
						</div>
						${produk}
						<div class="produk-slidetoggle-${val.toko_id} none">
						${produk_selanjutnya}
						</div>
						<div class="grid">
							<div class="payment-card">
								<div class="payment-title">
									Opsi Pengiriman
								</div>
								<div class="payment-body">
									<div class="row mb-3">
										<div class="col-10">
											<div class=""><b class="kurir-${val.toko_id} b-kurir">-</b></div>
											<input type="hidden" name="" class="kurir-select--code" data-toko-id="${val.toko_id}" />
											<input type="hidden" name="" class="kurir-select--service" data-toko-id="${val.toko_id}" />
											<input type="hidden" name="" class="kurir-select--etd" data-toko-id="${val.toko_id}" />
											<input type="hidden" name="" class="kurir-select--value" data-toko-id="${val.toko_id}" value="0"/>
											<!-- <a href="javascript:;" class="ubah--ekspedisi" data-toko-id="${val.toko_id}" data-asal="${val.asal_kecamatan_id}" data-tujuan="${val.tujuan_kecamatan_id}" data-berat="${produk_total_berat}" data-toggle="modal" data-target="#kurir">Ubah</a> -->
										</div>
										<div class="col-2">
											Rp. <span class="kurir-value-${val.toko_id} span-kurir-value">-</span>
										</div>
									</div>
									<div class="btn--dropify">
										<button class="btn ubah--ekspedisi-kurir" data-toko-id="${val.toko_id}" data-asal="${val.asal_kecamatan_id}" data-tujuan="${val.tujuan_kecamatan_id}" data-berat="${produk_total_berat}">Ubah</button>
										<ul class="dropify--content">
											<li class="dropify--item disabled text-center">
												<div class="fs-11 text-muted">Memuat..</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					`;
					
				});

				output.append(content);
				setTimeout(function(){
					$('.ubah--ekspedisi-kurir').trigger('show.kurir')
				},500)

				var ppn_highlight = ''
				var ppn = parseInt(biaya_ppn),
					admin = parseInt(biaya_admin)
				if (ppn !== 0) {
					ppn_highlight = `<small class="badge badge-danger badge-pill">${ppn}%</small>`
					ppn = parseInt((sub_total_produk * ppn) / 100);
				}

				$("div.pesanan--sub-total").html(`Rp. ${rupiah(sub_total_produk)}`);
				$('#biaya--admin').html(`Rp. ${rupiah(admin)}`)
				$("div.pesanan--ppn").html(`Rp. ${rupiah(ppn)} ${ppn_highlight}`);
				$("div.pesanan--total-bayar").html(`Rp. ${rupiah(sub_total_produk + admin + ppn)}`);
				$("input[type=hidden].pesanan--total-bayar").val(`${sub_total_produk + admin + ppn}`);

			})
		}

		alamatPengiriman() {
			let output = $("div.grid--alamat-pengiriman-add div.payment-body").html('');
			callApi("user/alamat_pengiriman/list", {
				client_token: $jp_client_token
			}, res => {

				let content = ``;
				$.each(res.Data, function(index, val) {

					if (res.Data.length == 0) {
						content = `-`;
					}
					if (val.is_utama == 1) {
						this.tujuan_id = $(val.kecamatan_id);
						$("div.alamat-selected").html(`
							<b>${val.penerima_nama}</b>&nbsp;&nbsp;&nbsp; <span style="font-size: 13px; color: #adadad;">${val.nama}, ${val.alamat}, ${val.kabupaten_nama} - ${val.kecamatan_nama}, ${val.provinsi_nama}.</span>
						`);
					}

					let content_checked = "";
					if (val.is_utama == 1) {
						content_checked = "checked";
					}
					content += `
						<label for="pilih--alamat-pengiriman-${val.id}">
							<input type="radio" ${content_checked} name="pilih--alamat-pengiriman" class="pilih--alamat-pengiriman" id="pilih--alamat-pengiriman-${val.id}" value="${val.id}" data-tujuan-id="${val.kecamatan_id}" /> <b>${val.penerima_nama}</b>&nbsp;&nbsp;&nbsp; <span style="font-size: 13px; color: #adadad;">${val.nama}, ${val.alamat}, ${val.kabupaten_nama} - ${val.kecamatan_nama}, ${val.provinsi_nama}.</span><br>
						</label>
					`;
				});
				content += `
					<div align="right">
						<button type="button" class="btn btn-success btn-sm alamat--set-utama">Set utama</button>
					</div>
				`;

				output.append(content);
			})
		}

		alamatPengirimanSetUtama(params) {
			let id = params['id'];

			callApi("user/alamat_pengiriman/set_utama", {
				client_token: $jp_client_token,
				id: id
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5000);
				}else{
					$(`b.b-kurir`).html('-');
					$(`span.span-kurir-value`).html('-');
					$(`input.kurir-select--code`).val('');
					$(`input.kurir-select--service`).val('');
					$(`input.kurir-select--etd`).val('');
					$(`input.kurir-select--value`).val('0');

					$("div.grid--alamat-pengiriman-add").attr('style', 'display: none');
					$("div.grid--alamat-pengiriman").removeAttr('style');
					this.alamatPengiriman();
					notifAlert(message, "success", 5000);
				}
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

		addAlamatPengiriman(params) {
			var id = params['id'];
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
					notifAlert(message, 'error', 5000);
				}else{
					$("input.alamat--id").val('');
					$("input.alamat--nama").val('');
					$("input.alamat--nama-penerima").val('');
					$("input.alamat--telepon-penerima").val('');
					$("select.alamat--provinsi").val('').trigger('selected');
					$("select.alamat--kabupaten").val('').trigger('selected');
					$("select.alamat--kecamatan").val('').trigger('selected');
					$("textarea.alamat--alamat").val('');
					$("div#add--alamat-pengiriman").modal('hide');
					this.alamatPengiriman();
					notifAlert(message, 'success', 5000);
				}
			})
		}

		drawKurir(params) {
			let toko_id = params['toko_id'];
			let asal_id = params['asal_id'];
			let tujuan_id = params['tujuan_id'];
			let berat = params['berat'];

			$("div.kurir--list").html(``);

			callApi("cart/checkout_kurir", {
				client_token: $jp_client_token,
				toko_id: toko_id
			}, res => {
				let content = `<option value=""></option>`;
				$.each(res.Data, function(index, val) {
					content += `<option>${val.code}</option>`;
				});
				$("select.pilih--kurir").html(content);
				$(`input.pilih-kurir--toko-id`).val(toko_id);
				$(`input.pilih-kurir--asal-id`).val(asal_id);
				$(`input.pilih-kurir--tujuan-id`).val(tujuan_id);
				$(`input.pilih-kurir--berat`).val(berat);
			})
		}

		ongkir(params) {
			let asal = params['asal'];
			// let tujuan = params['tujuan'];
			let tujuan = $("input.pilih--alamat-pengiriman:checked").data('tujuan-id');
			let berat = params['berat'];
			let kurir = params['kurir'];
			let toko_id = params['toko_id'];

			let output = $("div.kurir--list").html(`<img src="<?php echo base_url('assets/img/default/loader.gif'); ?>" style="width: 10%;" alt="">`);

			console.log(toko_id);

			callApi("ongkir", {
				asal_id: asal,
				tujuan_id: tujuan,
				berat: berat,
				kurir: kurir
			}, res => {

				let message = res.Message;

				if (res.Error == true) {
					notifAlert("Alamat pengiriman belum diset.", "error", 5000);
				}else{
					let content = ``;

					let no = 1;

					$("div.kurir--list").html(``);

					let result = res.Kurir.rajaongkir.results[0];
					let query = res.Kurir.rajaongkir.query;

					$.each(result.costs, function(index, val) {
						content += `
							<div class="grid">
								<div class="payment-card bg-white">
									<div class="payment-body">
										<div class="row" style="font-size: 13px; font-family: arial">
											<div class="col-md-1">${no++}</div>
											<div class="col-md-3">${result.name}</div>
											<div class="col-md-2">${val.description}</div>
											<div class="col-md-2">${val.cost[0].etd} Hari</div>
											<div class="col-md-2">${rupiah(val.cost[0].value)}</div>
											<div class="col-md-1"><button class="btn btn-info btn-sm pilih--kurir" data-kurir="${result.code}" data-toko-id="${toko_id}" data-code="${query.courier}" data-service="${val.description}" data-etd="${val.cost[0].etd}" data-value="${val.cost[0].value}"><i class="fa fa-check-circle"></i></button></div>
										</div>
									</div>
								</div>
							</div>
						`;
					});

					output.append(content);
				}
			})
		}

		totalOngkir() {
			let ongkir = $("input.kurir-select--value");
			let total = 0;
			let total_bayar = $("input[type=hidden].pesanan--total-bayar").val();
			$.each(ongkir, function(index, val) {
				total += parseInt($(this).val());
			});
			$("div.pesanan--total-ongkir").html(`Rp. ${rupiah(total)}`);
			$("div.pesanan--total-bayar").html(`Rp. ${rupiah(total + parseInt(total_bayar))}`);
		}

		setKurir(params) {
			let toko_id = params['toko_id'];
			let kurir = params['kurir'];
			let kurir_code = params['kurir_code'];
			let kurir_service = params['kurir_service'];
			let kurir_etd = params['kurir_etd'];
			let kurir_value = params['kurir_value'];

			callApi("user/pembelian/set_kurir", {
				client_token: $jp_client_token,
				toko_id: toko_id,
				kurir: kurir,
				kurir_code: kurir_code,
				kurir_service: kurir_service,
				kurir_etd: kurir_etd,
				kurir_value: kurir_value
			}, res => {
				let message = res.Message;
				if (res.Error == true) {
					notifAlert(message, "error", 5000);
				}
			})
		}

		buatPesanan() {
			let no_kurir = 0;
			$.each($(`input.kurir-select--value`), function(index, val) {
				if ($(this).val() != 0) {
					no_kurir++;
				}
			});

			if (no_kurir != $(`input.kurir-select--value`).length) {
				notifAlert("Kurir belum dipilih", "error", 5000);
			}else{
				let payment = $("div.payment-metode.active").data('payment');
				callApi("user/transaksi/snap_token", {
					client_token: $jp_client_token,
					payment: payment
				}, res => {
					var snapToken = res.Data.snapToken;
					var transaksi_id = res.Data.transaksi_id;
					if (payment == "midtrans") {
						snap.pay(snapToken, {
	          
				          onSuccess: function(result){
				          	callApi("user/transaksi/selesai", {
				          		client_token: $jp_client_token,
				          		transaksi_id: transaksi_id,
				          		payment_output: result
				          	}, res_transaksi => {
				          		var message = res.Message;
				          		if (res_transaksi.Error == true) {
				          			notifAlert(res_transaksi.Message, "error", 5000);
				          		}else{
				          			notifAlert(res_transaksi.Message, "success", 5000);
				          			session.destroy_userdata('checked');
				          			redirect('user/pembelian/detail/'+res_transaksi.no_invoice)
				          		}
				          	})
				          },
				          onPending: function(result){
				          	callApi("user/transaksi/selesai", {
				          		client_token: $jp_client_token,
				          		transaksi_id: transaksi_id,
				          		payment_output: result
				          	}, res_transaksi => {
				          		var message = res.Message;
				          		if (res_transaksi.Error == true) {
				          			notifAlert(res_transaksi.Message, "error", 5000);
				          		}else{
				          			notifAlert(res_transaksi.Message, "success", 5000);
				          			session.destroy_userdata('checked');
				          		// 	setInterval(function () {
				          		// 		window.location="<?php echo base_url('user/pembelian'); ?>";
				          		// 	}, 5000);
				          			// redirect('user/pembelian');
				          			// redirect('user/pembelian')
				          			redirect('user/pembelian/detail/'+res_transaksi.no_invoice)
				          		}
				          	})
				          },
				          onError: function(result){
				            notifAlert(result.status_message, "error", 5000);
				          },
				          onClose: function(result) {
				          	// callApi("user/transaksi/selesai", {
				          	// 	client_token: $jp_client_token,
				          	// 	transaksi_id: transaksi_id,
				          	// 	payment_output: result
				          	// }, res_transaksi => {
				          	// 	var message = res.Message;
				          	// 	if (res_transaksi.Error == true) {
				          	// 		notifAlert(res_transaksi.Message, "error", 5);
				          	// 	}else{
				          	// 		notifAlert(res_transaksi.Message, "success", 5);
				          	// 		session.destroy_userdata('checked');
				          	// 		setInterval(function () {
				          	// 			window.location="<?php echo base_url('user/pembelian'); ?>";
				          	// 		}, 5000);
				          	// 	}
				          	// })
				          	console.log('customer closed the popup without finishing the payment');
				          }
				      });
					}else if (payment == "manual") {
			          	callApi("user/transaksi/selesai", {
			          		client_token: $jp_client_token,
			          		transaksi_id: transaksi_id,
			          		payment_output: {
			          			"payment": "manual"
			          		}
			          	}, res_transaksi => {
			          		var message = res.Message;
			          		if (res_transaksi.Error == true) {
			          			notifAlert(res_transaksi.Message, "error", 5000);
			          		}else{
			          			notifAlert(res_transaksi.Message, "success", 5000);
			          			session.destroy_userdata('checked');
			          			redirect('user/pembelian/detail/'+res_transaksi.no_invoice)
			          		}
			          	});
					}
				});
			}
		}

	}

	let payment = new Payment;

	$(document).on('show.kurir', '.ubah--ekspedisi-kurir', function(event) {
		event.preventDefault();
		var kurir_item = $(this).parent().find('.dropify--content')
		var data = {
			toko_id: $(this).attr('data-toko-id'),
			asal_id: $(this).attr('data-asal'),
			tujuan_id: $("input.pilih--alamat-pengiriman:checked").attr('data-tujuan-id'),
			berat: $(this).attr('data-berat')
		}
		callApi('ongkir/kurir/',data,function(res){
			if (res.Error) {
				kurir_item.html(`<li class="dropify--item disabled text-center">
								<div class="fs-11 text-muted">${res.Message}</div>
							</li>`)
			}else{
				var result = res.Data,
				output = ''
				$.each(result,function(no,key){
					output += `<li class="dropify--item pilih--ekpedisi" data-toko-id="${data.toko_id}" data-kurir="${key.name}" data-code="${key.code}" data-service="${key.description}" data-etd="${key.cost[0].etd}" data-value="${key.cost[0].value}">
								<div class="fs-12 fw-600">${key.name.toUpperCase()} - ${key.description}</div>
								<div class="fs-11 text-muted">Rp. ${rupiah(key.cost[0].value)}</div>
							</li>`
				})
				kurir_item.html(output)
			}
		})
	});

	$(document).on('click', '.btn--dropify .pilih--ekpedisi', function(event) {
		event.preventDefault();
		let toko_id = $(this).data('toko-id');
		let kurir = $(this).data('kurir');
		let code = $(this).data('code');
		let service = $(this).data('service');
		let etd = $(this).data('etd');
		let value = $(this).data('value');

		$(`input.kurir-select--code[data-toko-id=${toko_id}]`).val(code);
		$(`input.kurir-select--service[data-toko-id=${toko_id}]`).val(service);
		$(`input.kurir-select--etd[data-toko-id=${toko_id}]`).val(etd);
		$(`input.kurir-select--value[data-toko-id=${toko_id}]`).val(value);

		$(`b.kurir-${toko_id}`).html(`${kurir.toUpperCase()} ${service}`);
		$(`span.kurir-value-${toko_id}`).html(rupiah(value));

		payment.setKurir({
			toko_id: toko_id,
			kurir: kurir,
			kurir_code: code,
			kurir_service: service,
			kurir_etd: etd,
			kurir_value: value
		});
		payment.totalOngkir();
	});

	$(document).on("click", "a.produk-tampil-selengkapnya", function () {
		let toko_id = $(this).data('toko-id');

		if ($(this).hasClass('slide-down') == true) {
			$(this).removeClass('slide-down');
			$(`a.produk-tampil-selengkapnya[data-toko-id=${toko_id}]`).html(`<i class="fa fa-chevron-up"></i> Tampilkan selengkapnya.`);
			$(`div.produk-slidetoggle-${toko_id}`).slideToggle('slow');
		}else {
			$(this).addClass('slide-down');
			$(`a.produk-tampil-selengkapnya[data-toko-id=${toko_id}]`).html(`<i class="fa fa-chevron-down"></i> Tampilkan selengkapnya.`);
			$(`div.produk-slidetoggle-${toko_id}`).slideToggle('slow');
		}
	})

	$(document).on("click", "button.ubah--alamat-pengiriman", function () {
		$("div.grid--alamat-pengiriman").attr('style', 'display: none');
		$("div.grid--alamat-pengiriman-add").removeAttr('style');
	})

	$(document).on("click", "button.alamat--set-utama", function () {
		payment.alamatPengirimanSetUtama({
			id: $(".pilih--alamat-pengiriman:checked").val()
		});
	})

	$(document).on("change", "select.alamat--provinsi", function () {
		provinsi_id = $(this).val();
		payment.kabupaten(provinsi_id);
	})

	$(document).on("change", "select.alamat--kabupaten", function () {
		kabupaten_id = $(this).val();
		payment.kecamatan(kabupaten_id);
	})

	$(document).on("submit", "form.form--add-alamat", function () {
		var id = $("input.alamat--id").val();
		var nama = $("input.alamat--nama").val();
		var penerima_nama = $("input.alamat--nama-penerima").val();
		var penerima_telepon = $("input.alamat--telepon-penerima").val();
		var provinsi = $("select.alamat--provinsi").val();
		var kabupaten = $("select.alamat--kabupaten").val();
		var kecamatan = $("select.alamat--kecamatan").val();
		var alamat = $("textarea.alamat--alamat").val();
		payment.addAlamatPengiriman({
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

	$(document).on("click", "a.ubah--ekspedisi", function () {
		let toko_id = $(this).data('toko-id');
		let asal_id = $(this).data('asal');
		let tujuan_id = $(this).data('tujuan');
		let berat = $(this).data('berat');
		payment.drawKurir({
			toko_id: toko_id,
			asal_id: asal_id,
			tujuan_id: tujuan_id,
			berat: berat
		})
	})

	$(document).on("change", "select.pilih--kurir", function () {
		let toko_id = $(`input.pilih-kurir--toko-id`).val();
		let asal = $(`input.pilih-kurir--asal-id`).val();
		let tujuan = $(`input.pilih-kurir--tujuan-id`).val();
		let berat = $(`input.pilih-kurir--berat`).val();
		let kurir = $(this).val();

		payment.ongkir({
			toko_id: toko_id,
			asal: asal,
			tujuan: tujuan,
			berat: berat,
			kurir: kurir
		})
	})

	$(document).on("click", "button.pilih--kurir", function () {
		let toko_id = $(this).data('toko-id');
		let kurir = $(this).data('kurir');
		let code = $(this).data('code');
		let service = $(this).data('service');
		let etd = $(this).data('etd');
		let value = $(this).data('value');

		$(`input.kurir-select--code[data-toko-id=${toko_id}]`).val(code);
		$(`input.kurir-select--service[data-toko-id=${toko_id}]`).val(service);
		$(`input.kurir-select--etd[data-toko-id=${toko_id}]`).val(etd);
		$(`input.kurir-select--value[data-toko-id=${toko_id}]`).val(value);

		$(`b.kurir-${toko_id}`).html(`${code.toUpperCase()} ${service}`);
		$(`span.kurir-value-${toko_id}`).html(rupiah(value));

		payment.setKurir({
			toko_id: toko_id,
			kurir: kurir,
			kurir_code: code,
			kurir_service: service,
			kurir_etd: etd,
			kurir_value: value
		});
		payment.totalOngkir();

		$("div#kurir").modal('hide');
	})

	$(document).on("click", "div.payment-metode", function () {
		$("div.payment-metode").removeClass('active');
		$(this).addClass('active');
	})

	$(document).on("click", "button.pesanan--buat", function () {
		payment.buatPesanan();
	})
</script>