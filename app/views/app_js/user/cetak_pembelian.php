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