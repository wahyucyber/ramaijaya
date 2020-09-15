

<script>
	var pesanan_status = ''
	class Pembelian {
		constructor()
		{
			// this.load()
		}
		load(page = 1,keyword = '',status = 'all')
		{
			var data = {
				client_token: $jp_client_token,
				page: page,
				status: status,
				keyword: keyword
			}

			callApi('user/pembelian/',data,function(res){
				var output = ''
				if (res.Error) {
					$('#Pagination').html('')
					output += `<div class="card">
									<div class="card-body d-flex align-items-center justify-content-center">
										<div class="order-empty text-center">
											<img src="<?= base_url() ?>assets/img/default/no-order.png" class="w-25">
											<h6 class="mt-3 fw-600">${res.Message}</h6>
											<small>Anda tidak memiliki pesanan</small>
										</div>
									</div>
								</div>`
				}else{
					var result = res.Data,
						pagination = res.Pagination
					$.each(result,function(index,data){
						var status_class = ''
						if (data.status == "Belum dibayar") {
							status_class =  'text-warning';
						}else if (data.status == "Dibayar") {
							status_class =  'text-success';
						}else if (data.status == "Dibatalkan") {
							status_class =  'text-danger';
						}

						var batal_pesanan = ''

						if(data.status == 'Belum dibayar'){
					        batal_pesanan = `<button class="btn btn-sm btn-danger mb-2" onclick="pembelian.M_Cancel('${data.no_invoice}')"><i class="fal fa-times-circle"></i> Batalkan Pesanan</button>`
					    }

					    var detail_pembayaran = ''
						
						if (data.status !== 'Dibatalkan' && data.status !== 'Dibayar') {
							if (data.payment_metode == "midtrans") {
								if (data.payment_output) {
									detail_pembayaran = `<a href="${JSON.parse(data.payment_output).pdf_url}" target="blank" class="text-orange fs-12">Detail Pembayaran</a>`;
								}
							}else{
								detail_pembayaran = `<a href="javascript:;" class="detail-pembayaran detail-pembayaran-manual text-orange fs-12" data-toggle="modal" data-target="#payment-manual">klik disini untuk detail pembayaran</a>`;
							}
						}

						output += `<div class="order--list-item mb-3">
										<div class="order--list-item_header">
											<div class="fs-13 text-secondary date--created">${data.tanggal}</div>
										</div>
										<div class="order--list-item_body">
											<div class="row">
												<div class="col-md-3 border-right mb-2 mb-lg-0">
													<div class="fs-14 fw-600">${data.no_invoice}</div>
													${detail_pembayaran}
												</div>
												<div class="col-md-5 border-right mb-2 mb-lg-0">
													<div class="fs-13 fw-400">
														Status
													</div>
													<h6 class="fw-600 fs-14 ${status_class}">${data.status}</h6>
													<div class="fs-13 fw-400">
														Alamat Penerima
													</div>
													<h6 class="fs-13 mb-1"><strong>${data.penerima_nama}</strong> (${data.alamat_penerima_nama})</h6>
													<h6 class="fw-400 fs-12 mb-0 text-secondary">
														${data.alamat_penerima}<br>
														${data.alamat_kecamatan_nama}, ${data.alamat_kabupaten_nama}<br>
														${data.alamat_provinsi_nama}<br>
														Telepon/Handphone: ${data.penerima_no_telepon}
													</h6>
												</div>
												<div class="col-md-4">
													<div class="fs-13 fw-400">
														Total Belanja
													</div>
													<h5 class="fw-600 text-primary fs-15">Rp ${rupiah(data.total_bayar)}</h5>
													<h6 class="fw-600 fs-14">${data.detail_status}</h6>
												</div>
											</div>
										</div>
										<div class="order--list-item_footer border-top text-center text-lg-right">
											<button class="btn btn-sm btn-orange mb-2" onclick="redirect('user/pembelian/detail/${data.no_invoice}')"><i class="fal fa-info"></i> Detail Pesanan</button>
											${batal_pesanan}
										</div>
									</div>`
					})
					var next = ''
					if (parseInt(pagination.Halaman) < parseInt(pagination.Jml_halaman)) {
						next += `<button class="btn btn-outline-primary" onclick="pembelian.load(${parseInt(pagination.Halaman) + 1})">Muat Lebih Banyak</button>`
					}else{
						next += `<button class="btn btn-outline-secondary" disabled>Sudah yang terakhir</button>`
					}
					$('#Pagination').html(next)

				}
				if (page == 1) {
					$('#order--list').html(output)
				}else{
					$('#order--list').append(output)
				}
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
		M_Cancel(invoice)
		{
		    this.no_invoice = invoice
    	    $('#ModalCancel .content--title').html(`No. Invoice : `+invoice)
		    $('#ModalCancel').modal('show')
		}
		cancel()
		{
		    callApi("user/pembelian/batalkan/", {
		        client_token: $jp_client_token,
		        no_invoice: this.no_invoice
		    }, function(res){
				if(res.Error){
				    notif(".msg--content", "danger", res.Message,5000);
				    $('#ModalCancel').modal('hide')
				}else{
				    notif(".msg--content", "success", res.Message,5000);
				    $('#ModalCancel').modal('hide')
				    var status = $('.order--status--filter .btn_filter.active').attr('data-status')
				    pembelian.load(1,'',status)
				}
			})
		}
	}

	var pembelian = new Pembelian

	$(document).on("click", "a.detail-pembayaran-manual", function () {
		pembelian.paymentManual();
	})
	
	$(document).on('submit','#ModalCancel form',function(e){
	    e.preventDefault()
	    pembelian.cancel()
	})
	$(document).on('submit','#ModalDelete form',function(e){
	    e.preventDefault()
	    pembelian.delete()
	})


	$(document).on("click", ".order--status--filter .btn_filter:not(.active)", function (e) {
		e.preventDefault()

		var status = $(this).attr('data-status');
		$(this).addClass('active')
		$('.order--status--filter .btn_filter').not($(this)).removeClass('active')

		pembelian.load(1,'',status)

	})

	$('.order--status--filter .btn_filter[data-status="all"]').trigger('click')

</script>