<section class="setting-store">
	<?php require 'sidebar.php'; ?>
	
	<div class="content-right" id="content-right">

		<div class="row">
			<div class="col-md-6" align="left">
				<h4 class="badge badge-success bg-orange fs-16"><i class="fal fa-info"></i>	Detail Transaksi</h4>
			</div>
			<div class="col-md-6 mb-2" align="right">
				<a href="" class="btn btn-info btn-sm print-pesanan"><i class="fa fa-print"></i> Cetak</a>
				<a href="<?php echo base_url('seller/penjualan/'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
			</div>
			<div class="col-md-8">
				<div class="payment-detail--loading" align="center">
					<img src="<?php echo base_url('assets/img/default/loader.gif'); ?>" style="width: 10%;" alt="">
				</div>
				<div class="payment-detail--list none">
				</div>
			</div>
			<div class="col-md-4">
				<div class="payment-detail">
					<div class="grid">
						<div class="payment-card bg-white">
							<div class="payment-title">
								NO. INVOICE
							</div>
							<div class="payment-body payment--no-invoice">
								-
							</div>
						</div>
					</div>
					<div class="grid">
						<div class="payment-card bg-white">
							<div class="payment-title">
								TANGGAL
							</div>
							<div class="payment-body payment--tanggal">
								-
							</div>
						</div>
					</div>
					<div class="grid">
						<div class="payment-card bg-white">
							<div class="payment-title">
								STATUS TAGIHAN
							</div>
							<div class="payment-body payment--status-tagihan">
								-
							</div>
						</div>
					</div>
					<!-- <div class="grid">
						<div class="payment-card bg-white">
							<div class="payment-title">
								DETAIL PEMBAYARAN
							</div>
							<div class="payment-body payment--detail-pembayaran">
								-
							</div>
						</div>
					</div> -->
					<div class="grid">
						<div class="payment-card bg-white">
							<div class="payment-title">
								TOTAL TRANSAKSI
							</div>
							<div class="payment-body payment--total-bayar">
								-
							</div>
						</div>
					</div>
					<div class="grid">
						<div class="payment-card bg-white">
							<div class="payment-title">
								ALAMAT PENGIRIMAN
							</div>
							<div class="payment-body payment--alamat-pengiriman">
								-
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	</div>

</section>

<div class="modal fade"id="ModalTracking">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Detail Status Pesanan</h5>
			</div>
			<div class="modal-body">
				<div class="tracking--content">
					<ul class="tracking--list" id="tracking">
						
					</ul>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>