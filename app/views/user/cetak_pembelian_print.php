<script>
		$app_url = '<?= base_url(); ?>';
		$api_url = '<?= api_url(); ?>';
		$cdn_url = '<?= cdn_url(); ?>';
		$csrf = "<?= base64_encode(json_encode($get_token)); ?>";
	</script>
	<?= stylesheet_url('https://fonts.googleapis.com/css?family=Roboto&display=swap'); ?>
	<?= stylesheet([
		'ext/fontawesome/css/all.min.css',
		'ext/bootstrap/css/bootstrap.min.css',
		'ext/bootstrap-datepicker/css/bootstrap-datepicker.standalone.min.css',
		'ext/DataTables/dataTables.min.css',
		'ext/DataTables/dist/css/dataTables.bootstrap4.min.css',
		'ext/jquery-ui/jquery-ui.min.css',
		'ext/select2/dist/css/select2.min.css',
		'ext/slick/slick-theme.css',
		'ext/slick/slick.css',
		'css/bundle.css',
		'css/seller-profil.css'
	]); ?>
	<?= $default_css; ?>

<div class="col-md-12 print-media cetak-pembelian mt-2" id="print-media">
</div>

<?= script([
	// 'ext/jquery.min.js',
	'ext/jquery-3.4.0.min.js',
	'ext/jquery-ui/jquery-ui.min.js',
	'ext/bootstrap/js/bootstrap.min.js',
	'js/jquery.cookie.min.js',
	'ext/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
	'ext/select2/dist/js/select2.min.js',
	'ext/canvasResize/binaryajax.js',
	'ext/canvasResize/exif.js',
	'ext/canvasResize/jquery.exif.js',
	'ext/canvasResize/jquery.canvasResize.js',
	'ext/canvasResize/canvasResize.js',
	'ext/DataTables/dist/js/jquery.dataTables.min.js',
	'ext/DataTables/dist/js/dataTables.bootstrap4.js',
	'ext/ckeditor/ckeditor.js',
	'ext/slick/slick.min.js',
	'js/bundle.js',
	'js/module.js'
]); ?>

<!-- <script>
	var $jp_client_token = check_auth();

	class Cetak_pembelian {
		constructor() {
			this.run();
		}

		run() {
			callApi("user/pembelian/cetak", {
				client_token: $jp_client_token,
				no_invoice: "<?php echo $no_invoice; ?>",
				no_transaksi: "<?php echo $no_transaksi; ?>"
			}, res => {
				let produk = ``;
				$.each(res.data, function(index, val) {

					let total_bayar = 0;

					$("td.penjual").html(`${val.toko_nama}`);
					$("td.kurir").html(`${val.kurir} (${val.kurir_service})`);
					$("td.kurir-ongkir").html(`Rp. ${rupiah(val.kurir_value)}`);

					$.each(val.produk, function(index_produk, val_produk) {
						if (val_produk.produk_foto[0].length == 0) {
							var foto = '<?php echo base_url('assets/img/default/no-image.png'); ?>';
						}else{
							var foto = val_produk.produk_foto[0].foto;
						}

						var catatan = '-';
						if (val_produk.catatan != "") {
							catatan = val_produk.catatan;
						}

						total_bayar += parseInt(val_produk.produk_harga) * parseInt(val_produk.qty);

						produk += `
							<div class="item item-produk">
								<div class="item-img">
									<img src="${foto}" alt="">
								</div>
								<div class="item-info">
									<b>${val_produk.produk_nama}</b>
									<div>
										jumlah: ${rupiah(val_produk.qty)}<br>
										berat: ${val_produk.produk_berat}g<br>
										catatan: ${catatan}
									</div>
								</div>
								<div class="item-info" style="width: 780px; text-align: right; line-height: 70px;">
									<b>Rp. ${rupiah(parseInt(val_produk.produk_harga) * parseInt(val_produk.qty))}</b>
								</div>
							</div>
						`;
					});

					produk += `
						<div class="item" style="border-top: 3px solid black; padding: 7px; border-left: 1px solid #e0e0e0; border-right: 1px solid #e0e0e0;">
							<div style="width: 50%; float: left;">Total Bayar</div>
							<div style="width: 50%; float: right; text-align: right; padding-right: 10px;">Rp. ${rupiah(total_bayar + parseInt(val.kurir_value))}</div>
						</div>
					`;
				});

				$("div.produk-list").append(produk);

				window.print();
			})
		}
	}

	let cetak_pembelian = new Cetak_pembelian;
</script> -->
<script>
	var $jp_client_token = check_auth()

	class Cetak_pembelian {
		constructor() {
			this.run();
		}

		run() {
			callApi("user/pembelian/cetak", {
				client_token: $jp_client_token,
				no_invoice: "<?php echo $no_invoice; ?>",
				no_transaksi: "<?php echo $no_transaksi; ?>"
			}, res => {
				let cetak = '';
					cetak = `
						<div class="row">
							<div class="col-md-6">
								<h4>Informasi Pemesanan</h4>
							</div>
							<div class="col-md-6" align="right">
								<h4>
									No. <span style="color: red;">#${res.Data.no_invoice}</span><br>
									${res.Data.status}
								</h4>
							</div>
							<div class="col-md-12" style="font-size: 13px;">
								<p>
									Kepada ${res.Data.pembeli}
								</p>
								<p>
									Terima kasih atas kepercayaan Anda bertransaksi melalui <?php echo env('APP_NAME'); ?>.
								</p>
							</div>
						</div>

						<table class="cetak">
							<thead>
								<tr>
									<th align="center" colspan="6">Informasi Pemesanan</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="350px">No. Invoice</td>
									<td colspan="5"><b>${res.Data.no_invoice}</b></td>
								</tr>
								<tr>
									<td>Waktu Transaksi</td>
									<td colspan="5"><b>${res.Data.tgl_transaksi}</b></td>
								</tr>
								<tr>
									<td>Pembeli</td>
									<td colspan="5"><b>${res.Data.pembeli}</b></td>
								</tr>
								<tr>
									<td>Tujuan Pengiriman</td>
									<td colspan="5">
										<b>${res.Data.alamat_pengiriman.penerima_nama}</b><br>
										${res.Data.alamat_pengiriman.alamat}<br>
										${res.Data.alamat_pengiriman.kecamatan_nama} ${res.Data.alamat_pengiriman.kabupaten_nama}<br>
										${res.Data.alamat_pengiriman.provinsi_nama}<br>
										No. Telp: ${res.Data.alamat_pengiriman.penerima_telepon}<br>
									</td>
								</tr>
							</tbody>
					`;

					$.each(res.Data.pesanan, function(index, val) {

						let produk = ``;

						let produk_harga = 0;

						$.each(val.produk, function(index_produk, val_produk) {
							produk += `
								<tr>
									<td><b>${val_produk.nama_produk}</b></td>
									<td>${val_produk.sku_produk}</td>
									<td>${val_produk.catatan}</td>
									<td align="center">${val_produk.qty}</td>
									<td align="right">Rp. ${rupiah(val_produk.harga)}</td>
									<td align="right">Rp. ${rupiah(parseInt(val_produk.harga) * parseInt(val_produk.qty))}</td>
								</tr>
							`;

							produk_harga += parseInt(val_produk.harga) * parseInt(val_produk.qty);
						});

						cetak += `
							<thead>
								<tr>
									<th colspan="6">
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th colspan="6">
										Transaksi #${val.no_transaksi}
									</th>
								</tr>
								<tr>
									<td>Nomor Transaksi</td>
									<td colspan="5"><b>${val.no_transaksi}</b></td>
								</tr>
								<tr>
									<td>Status</td>
									<td colspan="5"><b>${val.status}</b></td>
								</tr>
								<tr>
									<td>Pelapak</td>
									<td colspan="5">${val.nama_toko}, ${val.kabupaten_nama}</td>
								</tr>
								<tr>
									<th>Nama</th>
									<th>SKU</th>
									<th>Catatan</th>
									<th>Jumlah</th>
									<th>Harga</th>
									<th>Sub. Total</th>
								</tr>
								${produk}
								<tr>
									<td colspan="5">PPN 10%</td>
									<td align="right">Rp. ${rupiah(val.ppn)}</td>
								</tr>
								<tr>
									<td colspan="5">Biaya Pengiriman</td>
									<td align="right">Rp. ${rupiah(val.kurir_value)}</td>
								</tr>
								<tr>
									<td colspan="5">Subtotal Transaksi</td>
									<td align="right">Rp. ${rupiah(val.subtotal_transaksi)}</td>
								</tr>
							</tbody>
						`;
					});

					cetak += `
							<thead>
								<tr>
									<th colspan="6">
										Rincian Tagihan
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="5">Subtotal Tagihan</td>
									<td align="right">Rp. ${rupiah(res.Data.rincian_tagihan.subtotal_tagihan)}</td>
								</tr>
								<tr>
									<td colspan="5">Biaya Penanganan</td>
									<td align="right">Rp. ${rupiah(res.Data.rincian_tagihan.biaya_penanganan)}</td>
								</tr>
								<tr>
									<td colspan="5">TOTAL PEMBAYARAN</td>
									<td align="right">Rp. ${rupiah(res.Data.rincian_tagihan.total_pembayaran)}</td>
								</tr>
							</tbody>
						</table>

						<div class="row">
							<div class="col-md-12 mt-4" style="font-size: 13px;">
								<p>
									Yuk jangan lupa ulas barang setelah barang sampai untuk membantu pembeli lain mengetahui kualitasnya.
								</p>
								<p>
									<b>Deklarasi:</b>
								</p>
								<p>
									<?php echo env('APP_NAME'); ?> merupakan pasar daring yang menjadi perantara antar penjual dan pembeli. <br>
									<?php echo env('APP_NAME'); ?> menyatakan bahwa bukti pembayaran ini menunjukkan harga sebenarnya dari barang yang diuraikan dan bahwa semua keterangan adalah benar dan tepat. <br>
									Bukti pembayaran ini dihasilkan oleh sistem dan tidak memerlukan tanda tangan.
								</p>
							</div>
						</div>
					`;

				$("div.cetak-pembelian").html(cetak);
				window.print();
			})
		}

		printPartOfPage(elementId) {
	        var printContent = document.getElementById(elementId);
	        
	        var printWindow = window.open('', '', 'left=10,top=10,width=740,height=600');

	        printWindow.document.write(printContent.innerHTML);
	        printWindow.document.close();
	        printWindow.focus();
	        printWindow.print();
	        printWindow.close();
	    }
	}

	let cetak_pembelian = new Cetak_pembelian;

	$(document).on("click", "button.print", function () {
		cetak_pembelian.printPartOfPage("print-media");
	})
</script>