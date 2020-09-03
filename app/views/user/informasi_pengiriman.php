<div class="container">
	<div class="row">
		<div class="col-md-12">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="<?php echo base_url(''); ?>">Home</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo base_url('user/profil?tab=profil'); ?>">Akun Saya</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo base_url('user/profil?tab=informasi_pengiriman'); ?>">Alamat Pengiriman</a></li>
			  </ol>
			</nav>
		</div>
		<div class="col-md-12" style="margin-top: -11px">
			<ul class="nav nav-tabs">
			  <li class="nav-item">
			    <a class="nav-link" href="<?php echo base_url('user/profil/?tab=profil'); ?>">Profil</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link active" href="<?php echo base_url('user/profil/?tab=informasi_pengiriman'); ?>">Informasi Pengiriman</a>
			  </li>
			</ul>
		</div>
		<div class="col-md-12 mt-4">
			<div class="mb-4" align="right">
				<a href="<?php echo base_url('user/profil/?tab=tambah_informasi_pengiriman'); ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
				<button class="btn btn-default btn-sm alamat--reload"><i class="fa fa-sync"></i></button>
			</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-condensed table-bordered table--alamat-pengiriman" style="width: 100%;">
					<thead class="bg-primary text-white">
						<tr>
							<th width="10px">No.</th>
							<th width="180px">Nama</th>
							<th width="">Detail</th>
							<th width="100px">#</th>
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
			<div class="modal-header">
				Edit
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
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-success">Simpan</button>
			</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">Konfirmasi</div>
			<div class="modal-body">
				<p>
					Apakah anda yakin ingin menghapus alamat <b class="alamat--nama">nama</b>.
					<input type="hidden" name="" class="alamat--hapus-id">
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
				<button type="button" class="btn btn-success alamat--ya-hapus">Ya</button>
			</div>
		</div>
	</div>
</div>