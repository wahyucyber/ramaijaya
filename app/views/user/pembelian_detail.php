<div class="container">
	<div class="row">
		<div class="col-md-12">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="<?php echo base_url(''); ?>">Home</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo base_url('user/profil?tab=profil'); ?>">Akun Saya</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo base_url('user/pembelian'); ?>">Pembelian</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo base_url('user/pembelian/detail/'.$no_invoice); ?>"><?php echo $no_invoice ?></a></li>
			  </ol>
			</nav>
		</div>
		<div class="col-md-6" align="left">
			<u>Detail Transaksi</u>
		</div>
		<div class="col-md-6 mb-2" align="right">
			<a href="<?php echo base_url('user/pembelian/cetak/'.$no_invoice); ?>" class="btn btn-info btn-print-transaksi btn-sm"><i class="fa fa-print"></i></a>
			<a href="<?php echo base_url('user/pembelian/'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-circle-left"></i></a>
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
				<!-- <div class="grid">
					<div class="payment-card bg-white">
						<div class="payment-title">
							PPN 10%
						</div>
						<div class="payment-body payment--ppn">
							-
						</div>
					</div>
				</div> -->
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

<div class="modal fade" id="payment-ulasan">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="payment--ulasan">
				<div class="modal-body">
					<div class="modal-ulasan--loading" align="center">
						<img src="<?php echo base_url('assets/img/default/loader.gif'); ?>" style="width: 10%;" alt="">
					</div>
					<div class="modal-ulasan">
					</div>
					<div align="right">
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-success btn-sm">Simpan ulasan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


<div class="modal fade" id="payment-komplain">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form>
				<div class="modal-body">
				    <div class="msg-content"></div>
					<div class="content fs-18 mb-3">
						Komplain : 
						<strong></strong>
					</div>
					<div class="form-group">
						<textarea rows="3" class="form-control komplain" placeholder="Ketik komplain anda disini.."></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-success btn-sm">Kirim komplain</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="upload-payment">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<label class="payment-upload" for="upload-pembayaran">
					<h2><i class="fa fa-upload"></i></h2>
					Klik untuk browse foto bukti pembayaran.<br>
					<i>Note*: Format file jpg, jpeg, png.</i>
					<input type="file" name="" id="upload-pembayaran" class="upload-pembayaran none">
				</label>
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

<div class="modal fade" id="terima-pesanan">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<p>
					Apakah anda yakin ingin menerima pesanan dan meneruskan uang ke lapak?
				</p>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="" class="terima-pesanan--no-transaksi">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-success btn-sm transaksi--ya-teruskan">Ya teruskan</buttonp>
			</div>
		</div>
	</div>
</div>

<div class="modal fade"id="ModalTracking">
	<div class="modal-dialog  modal-lg">
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