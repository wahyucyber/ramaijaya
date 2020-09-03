<script>
	var $jp_client_token = check_auth()
	class Pembelian {
		constructor() {
		    this.no_invoice;
			this.tabel = new Table;
			this.run();
		}

		tagihan() {
			this.tabel.run({
				tabel: "table.table--pembelian",
				url: "user/pembelian/tagihan",
				data: {
					client_token: $jp_client_token
				},
				columns: [
					{
						data: null,
						render: function (data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1 + '.';
						}
					},
					{
						data: null,
						render: res => {
							if (res.status == "Belum dibayar") {
								var status = `<div class="badge badge-warning">${res.status}</div>`;
							}else if (res.status == "Dibayar") {
								var status = `<div class="badge badge-success">${res.status}</div>`;
							}else if (res.status == "Dibatalkan") {
								var status = `<div class="badge badge-danger">${res.status}</div>`;
							}
							return `
							<span style="font-size: 15px; font-weight: bold; font-family: times new roman;">
								${res.no_invoice}<br><i class="text-danger">(<u>Rp. ${rupiah(res.total_bayar)}</u>)</i>
							</span> ${status}
							<div style="font-size: 13px;">
								${res.created_at}
							</div>`;
						}
					},
					{
						data: null,
						render: res => {
							let payment_detail = ``;
							if (res.payment_metode == "midtrans") {
								if (res.payment_output != null) {
									payment_detail = `<a href="${JSON.parse(res.payment_output).pdf_url}" target="blank">Detail Pembayaran</a>`;
								}
							}else{
								payment_detail = `<a href="javascript:;" class="detail-pembayaran detail-pembayaran-manual" data-toggle="modal" data-target="#payment-manual">klik disini untuk detail pembayaran</a>`;
							}
							return `
							<table class="table" style="font-size: 13px;">
								<tbody>
									<tr>
										<td>Alamat Pengiriman</td>
										<td align="right">
											<b>${res.alamat_penerima_nama}</b> (${res.alamat_nama})<br>
											${res.alamat_detail}<br>
											${res.alamat_kecamatan_nama}, ${res.alamat_kabupaten_nama}<br>
											${res.alamat_provinsi_nama}<br>
											Telepon/Handphone: ${res.alamat_penerima_telepon}
										</td>
									</tr>
									<tr>
										<td>Detail Pembayaran</td>
										<td align="right">${payment_detail}</td>
									</tr>
								</tbody>
							</table>
							`;
						}
					},
					{
						data: null,
						className: "text-center",
						render: res => {
						    if(res.status == 'Belum dibayar'){
						        var action = `<button type="button" onclick="pembelian.M_Cancel('${res.no_invoice}')" class="btn btn-danger btn-sm" title="Batalkan"><i class="fa fa-times"></i></button>`
						    }else if (res.status == "Dibatalkan") {
								var action = `<button type="button" onclick="pembelian.M_Delete('${res.no_invoice}')" class="btn btn-danger btn-sm" title="Hapus"><i class="fa fa-trash-alt"></i></button>`;
							}else{
							    var action = ''
							}
						    return `<button type="button" data-link="<?php echo base_url('user/pembelian/detail/'); ?>${res.no_invoice}" class="btn btn-success btn-sm mb-3 pembelian--detail"><i class="fa fa-eye"></i></button> ${action}`;
						}
					}
				]
			})
		}

		run() {
			this.tabel.run({
				tabel: "table.table--pembelian",
				url: "user/pembelian",
				data: {
					client_token: $jp_client_token
				},
				columns: [
					{
						data: null,
						render: function (data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1 + '.';
						}
					},
					{
						data: null,
						render: res => {
							if (res.status == "Belum dibayar") {
								var status = `<div class="badge badge-warning">${res.status}</div>`;
							}else if (res.status == "Dibayar") {
								var status = `<div class="badge badge-success">${res.status}</div>`;
							}else if (res.status == "Dibatalkan") {
								var status = `<div class="badge badge-danger">${res.status}</div>`;
							}

							var status_detail = "";
							if (res.status == "Menunggu diproses") {
								var status_detail = `<div class="badge badge-warning">${res.status}</div>`;
							}else if (res.status == "Diproses") {
								var status_detail = `<div class="badge badge-primary">${res.status}</div>`;
							}else if (res.status == "Dikirim") {
								var status_detail = `<div class="badge badge-secondary">${res.status}</div>`;
							}else if (res.status == "Diterima") {
								var status_detail = `<div class="badge badge-success">${res.status}</div>`;
							}
							return `
							<span style="font-size: 15px; font-weight: bold; font-family: times new roman;">
								${res.no_invoice}
							</span> ${status} ${status_detail}
							<div style="font-size: 13px;">
								${res.created_at}
							</div>`;
						}
					},
					{
						data: null,
						render: res => {
							return `
							`;
						}
					},
					{
						data: null,
						className: "text-center",
						render: res => {
						    if(res.status == 'Belum dibayar'){
						        var action = `<button type="button" onclick="pembelian.M_Cancel('${res.no_invoice}')" class="btn btn-danger btn-sm" title="Batalkan"><i class="fa fa-times"></i></button>`
						    }else if (res.status == "Dibatalkan") {
								var action = `<button type="button" onclick="pembelian.M_Delete('${res.no_invoice}')" class="btn btn-danger btn-sm" title="Hapus"><i class="fa fa-trash-alt"></i></button>`;
							}else{
							    var action = ''
							}
						    return `<button type="button" data-link="<?php echo base_url('user/pembelian/detail/'); ?>${res.no_invoice}" class="btn btn-success btn-sm mb-3 pembelian--detail"><i class="fa fa-eye"></i></button> ${action}`;
						}
					}
				]
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
		M_Delete(invoice)
		{
		    this.no_invoice = invoice
    	    $('#ModalDelete .content--title').html(`No. Invoice : `+invoice)
		    $('#ModalDelete').modal('show')
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
				    $('table.table--pembelian').DataTable().ajax.reload()
				}
			})
		}
		delete()
		{
		    callApi("user/pembelian/hapus/", {
		        client_token: $jp_client_token,
		        no_invoice: this.no_invoice
		    }, function(res){
				if(res.Error){
				    notif(".msg--content", "danger", res.Message);
				    $('#ModalDelete').modal('hide')
				}else{
				    notif(".msg--content", "success", res.Message);
				    $('#ModalDelete').modal('hide')
				    $('table.table--pembelian').DataTable().ajax.reload()
				}
			})
		}
	}

	var pembelian = new Pembelian;

	$(document).on("click", "button.alamat--reload", function () {
		pembelian.run();
	})

	$(document).on("click", "button.pembelian--detail", function () {
		var link = $(this).data('link');
		window.location=link;
	})

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

	$(document).on("click", "button.btn--tab", function () {
		$("button.btn--tab").removeClass("btn-success");
		$("button.btn--tab").addClass("btn-secondary");
		$(this).addClass("btn-success");

		let tab = $(this).data('tab');

		if (tab == "pembelian") {
			pembelian.run();
		}else{
			pembelian.tagihan();
		}
	})
</script>