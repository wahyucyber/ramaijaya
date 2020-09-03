<section class="backend-settings">
	<?php require 'sidebar.php' ?>
	<div class="content-right content--page" id="content-right">

		<div class="row">

			<div class="col-md-6">
				Transaksi
			</div>

			<div class="col-md-6" align="right">
				<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#filter"><i class="fa fa-filter"></i></button>
				<button type="button" class="btn btn-sm btn-default transaksi--reload"><i class="fa fa-sync"></i></button>
			</div>

		</div>
		<hr>

		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover table-striped tabel-condensed table-bordered data-transaksi">
						<thead class="bg-primary text-white">
							<tr>
								<th>No.</th>
								<th>No. Invoice</th>
								<th>Tanggal</th>
								<th>Status</th>
								<th>Total Bayar</th>
								<th>Payment</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</section>

<div class="modal fade" id="bukti-pembayaran">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<input type="hidden" name="" class="no-invoice">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
				<button type="button" class="btn btn-primary btn-sm bukti-pembayaran--konfirmasi">Konfirmasi</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="filter">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="form--filter">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="" class="control-label">Status</label>
								<select name="" id="" class="form-control filter--status">
									<option value="">Semua</option>
									<option value="0">Belum dibayar</option>
									<option value="1">Dibayar</option>
									<option value="2">Dibatalkan</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="" class="control-label">Metode Payment</label>
								<select name="" id="" class="form-control filter--payment-metode">
									<option value="">Semua</option>
									<option value="midtrans">Midtrans</option>
									<option value="manual">Manual</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-success btn-sm">Aktifkan filter</button>
				</div>
			</form>
		</div>
	</div>
</div>