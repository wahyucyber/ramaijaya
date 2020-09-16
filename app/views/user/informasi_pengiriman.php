<div class="container">
	<div class="row">
		<div class="col-md-12">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb bg-white ">
			    <li class="breadcrumb-item"><a class="text-dark" href="<?php echo base_url(''); ?>">Home</a></li>
			    <li class="breadcrumb-item"><a class="text-dark" href="<?php echo base_url('user/profil?tab=profil'); ?>">Akun Saya</a></li>
			    <li class="breadcrumb-item"><a class="text-dark" href="<?php echo base_url('user/profil?tab=informasi_pengiriman'); ?>">Alamat Pengiriman</a></li>
			  </ol>
			</nav>
		</div>
		<div class="col-md-12" style="margin-top: -11px">
			<ul class="nav nav-tabs justify-content-center">
			  <li class="nav-item">
			    <a class="nav-link " href="<?php echo base_url('user/profil/?tab=profil'); ?>"><i class="fal fa-user"></i>	Profil</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link active" href="<?php echo base_url('user/profil/?tab=informasi_pengiriman'); ?>"><i class="fal fa-box-check"></i> Informasi Pengiriman</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" href="<?php echo base_url('user/profil/?tab=ubah-password'); ?>"><i class="fal fa-key"></i> Ubah Password</a>
			  </li>
			</ul>
		</div>
		<div class="col-md-12 mt-4">
			<div class="mb-4 " >
				<a href="<?php echo base_url('user/profil/?tab=tambah_informasi_pengiriman'); ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>	Tambah Alamat Pengiriman</a>
				<button class="btn btn-warning btn-sm alamat--reload"><i class="fa fa-sync"></i> Refresh</button>
			</div>
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered table--alamat-pengiriman" style="width: 100%;">
					<thead class="bg-orange text-white">
						<tr>
							<th width="10px">No.</th>
							<th width="180px">Nama</th>
							<th width="">Detail</th>
							<th width="100px">Aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="edit">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="form--edit-alamat">
				<input type="hidden" name="" class="alamat--id">
			<div class="modal-header bg-orange text-white">
				<h5>Edit</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="" class="control-label">Nama <span class="required">*</span></label>
							<input type="text" name="" id="" class="form-control alamat--nama" maxlength="50">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Nama Penerima <span class="required">*</span></label>
							<input type="text" name="" id="" class="form-control alamat--nama-penerima" maxlength="50">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">No. Telepon Penerima <span class="required">*</span></label>
							<input type="number" name="" id="" class="form-control alamat--telepon-penerima" maxlength="13">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="" class="control-label">Provinsi <span class="required">*</span></label>
							<select name="" id="" class="form-control alamat--provinsi select2">
								<option value="">-Pilih Provinsi-</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="" class="control-label">Kabupaten/Kota <span class="required">*</span></label>
							<select name="" id="" class="form-control alamat--kabupaten select2">
								<option value="">-Pilih Kabupaten/Kota-</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="" class="control-label">Kecamatan <span class="required">*</span></label>
							<select name="" id="" class="form-control alamat--kecamatan select2">
								<option value="">-Pilih Kecamatan-</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="" class="control-label">Alamat <span class="required">*</span></label>
							<textarea name="" id="" rows="4" class="form-control alamat--alamat" style="resize:" none=""></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fal fa-times-circle"></i>	Batal</button>
				<button type="submit" class="btn btn-success"><i class="fal fa-save"></i>	Simpan</button>
			</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-orange text-white"><h5> Konfirmasi </h5></div>
			<div class="modal-body">
				<div class="alert alert-warning">
					Apakah anda yakin ingin menghapus alamat <b class="alamat--nama">nama</b>.
					<input type="hidden" name="" class="alamat--hapus-id">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fal fa-times-circle"></i>	Tidak</button>
				<button type="button" class="btn btn-success alamat--ya-hapus"><i class="fal fa-check-circle"></i>	Ya</button>
			</div>
		</div>
	</div>
</div>