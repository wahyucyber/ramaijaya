<section class="backend-settings">
	<?php require 'sidebar.php' ?>
	<div class="content-right content--page" id="content-right">

		<div class="row">

			<div class="col-md-6">
				Transaksi Detail
			</div>

			<div class="col-md-6" align="right">
				<a href="<?php echo base_url('admin/transaction/cetak/'.$no_invoice.'/'.$user_id); ?>" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
				<a href="<?php echo base_url('admin/transaction'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-circle-left"></i></a>
			</div>

		</div>
		<hr>

		<div class="row">
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
							<div class="payment-body">
								#<?php echo $no_invoice ?>
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
					<div class="grid">
						<div class="payment-card bg-white">
							<div class="payment-title">
								DETAIL PEMBAYARAN
							</div>
							<div class="payment-body payment--detail-pembayaran">
								-
							</div>
						</div>
					</div>
					<div class="grid">
						<div class="payment-card bg-white">
							<div class="payment-title">
								TOTAL PEMBAYARAN
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

<div class="modal fade" id="upload-payment">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<!-- <label class="payment-upload" for="upload-pembayaran">
					<h2><i class="fa fa-upload"></i></h2>
					Klik untuk browse foto bukti pembayaran.<br>
					<i>Note*: Format file jpg, jpeg, png.</i>
					<input type="file" name="" id="upload-pembayaran" class="upload-pembayaran none">
				</label> -->
				<div class="payment-bukti" align="center"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="payment-manual">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>