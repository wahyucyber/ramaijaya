<section class="backend-settings">
	<?php require 'sidebar.php' ?>
	<div class="content-right content--page" id="content-right">

		<div class="row">

			<div class="col-md-6">
				Toko
			</div>

			<div class="col-md-6" align="right">
				<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#filter"><i class="fa fa-filter"></i></button>
				<button type="button" class="btn btn-sm btn-default toko--reload"><i class="fa fa-sync"></i></button>
			</div>

		</div>
		<hr>

		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover table-striped tabel-condensed table-bordered data-toko" style="width: 100%;">
						<thead class="bg-primary text-white">
							<tr>
								<th>No.</th>
								<th>Toko</th>
								<th>Provinsi</th>
								<th>Kabupaten</th>
								<th>Kecamatan</th>
								<th>Status</th>
								<th width="60px">#</th>
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

<div class="modal fade" id="set-aktif">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Konfirmasi
			</div>
			<div class="modal-body">
				<p>
					Apakah anda yakin ingin meng-aktifkan toko <b class="set-aktif--nama-toko">Nama Toko.</b>
				</p>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="" class="set-aktif--toko-id">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tidak</button>
				<button type="button" class="btn btn-success btn-sm set-aktif--ya">Ya</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="set-nonaktif">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Konfirmasi
			</div>
			<div class="modal-body">
				<p>
					Apakah anda yakin ingin me-nonaktifkan toko <b class="set-nonaktif--nama-toko">Nama Toko.</b>
				</p>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="" class="set-nonaktif--toko-id">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tidak</button>
				<button type="button" class="btn btn-success btn-sm set-nonaktif--ya">Ya</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="ModalBlokir">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-danger text-white">
				Konfirmasi
			</div>
			<form action="">
			<div class="modal-body">
				<div class="msg-content"></div>
				<p>
					Apakah anda yakin ingin memblokir toko ini
				</p>
				<div class="form-group">
					<small class="text-danger">Catatan :</small>
					<input type="text" class="form-control catatan" placeholder="Masukkan catatan..">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tidak</button>
				<button type="submit" class="btn btn-success btn-sm">Ya</button>
			</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="ModalBukaBlokir">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header  bg-warning text-white">
				Konfirmasi
			</div>
			<form action="">
			<div class="modal-body">
				<div class="msg-content"></div>
				<p>
					Apakah anda yakin ingin membuka blokir toko ini
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tidak</button>
				<button type="submit" class="btn btn-success btn-sm">Ya</button>
			</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="filter">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"></div>
			<form class="filter">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="" class="control-label">Status</label>
								<select name="" id="" class="form-control status select2">
									<option value=""></option>
									<option value="1">Aktif</option>
									<option value="0">Tidak aktif</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-success btn-sm">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>