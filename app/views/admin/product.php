<section class="backend-settings">
	<?php require 'sidebar.php' ?>
	<div class="content-right content--page" id="content-right">

		<div class="row">

			<div class="col-md-6">
				Produk
			</div>

			<div class="col-md-6" align="right">
				<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#filter"><i class="fa fa-filter"></i></button>
				<button type="button" class="btn btn-sm btn-default product--reload"><i class="fa fa-sync"></i></button>
			</div>

		</div>
		<hr>

		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover table-striped tabel-condensed table-bordered data-product">
						<thead class="bg-primary text-white">
							<tr>
								<th width="5px">No.</th>
								<th>Produk</th>
								<th>Detail</th>
								<th>Toko</th>
								<th width="10px">Status</th>
								<th width="15px">Verifikasi</th>
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

<div class="modal fade" id="non-verifikasi">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Konfirmasi
			</div>
			<div class="modal-body">
				<p>
					Apakah anda yakin ingin merubah status produk <span class="non-verifikasi--nama-produk" style="font-weight: bold;"></span> menjadi <u>Tidak ter-verifikasi.</u>
				</p>
				<div class="form-group">
					<small class="text-danger">Catatan :</small>
					<input type="text" class="form-control catatan" placeholder="Masukkan Catatan...">
				</div>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="" class="non-verifikasi--produk-id">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tidak</button>
				<button type="button" class="btn btn-danger btn-sm ya-non-verifikasi">Ya</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="verifikasi">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Konfirmasi
			</div>
			<div class="modal-body">
				<p>
					Apakah anda yakin ingin merubah status produk <span class="verifikasi--nama-produk" style="font-weight: bold;"></span> menjadi <u>Ter-verifikasi.</u>
				</p>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="" class="verifikasi--produk-id">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tidak</button>
				<button type="button" class="btn btn-danger btn-sm ya-verifikasi">Ya</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="filter">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Filter
			</div>
			<form class="filter">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="" class="control-label">Toko</label>
								<select name="" id="" class="form-control toko select2">
									<option value=""></option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="" class="control-label">Status</label>
								<select name="" id="" class="form-control status select2">
									<option value=""></option>
									<option value="1">Aktif</option>
									<option value="0">Tidak aktif</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="" class="control-label">Verifikasi</label>
								<select name="" id="" class="form-control verifikasi select2">
									<option value=""></option>
									<option value="1">Ter-verifikasi</option>
									<option value="0">Tidak ter-verifikasi</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-success btn-sm">Filter</button>
				</div>
			</form>
		</div>
	</div>
</div>