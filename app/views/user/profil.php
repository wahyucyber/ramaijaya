<div class="container">
	<div class="row">
		<div class="col-md-12">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb bg-white  p-0">
			    <li class="breadcrumb-item"><a class="text-dark" href="<?php echo base_url(''); ?>">Home</a></li>
			    <li class="breadcrumb-item"><a class="text-dark" href="<?php echo base_url('user/profil?tab=profil'); ?>">Akun Saya</a></li>
			    <li class="breadcrumb-item"><a class="text-dark" href="<?php echo base_url('user/profil?tab=profil'); ?>">Profil</a></li>
			  </ol>
			</nav>
		</div>
		<div class="col-md-12 profil--message"></div>
		<div class="col-md-12" style="margin-top: -11px">
			<ul class="nav nav-tabs justify-content-center">
			  <li class="nav-item">
			    <a class="nav-link active" href="<?php echo base_url('user/profil/?tab=profil'); ?>"><i class="fal fa-user"></i>	Profil</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" href="<?php echo base_url('user/profil/?tab=informasi_pengiriman'); ?>"><i class="fal fa-box-check"></i> Informasi Pengiriman</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" href="<?php echo base_url('user/profil/?tab=ubah-password'); ?>"><i class="fal fa-key"></i> Ubah Password</a>
			  </li>
			</ul>
		</div>
		<div class="col-md-3 mt-4">
			<div class="card">
				<div class="card-body">
					<div class="img-profil">
						<div class="img-rounded">
							<img src="<?php echo base_url('assets/img/default/profile.jpg'); ?>" class="img-responsive img-thumbnail img-rounded img-seller profil--img" alt="">
							<div class="img-browse-file">
								<label for="img-browse">
									<i class="fa fa-camera-retro"></i><br>
									Browse
								</label>
								<input type="file" name="" class="img-browse profil--browse-foto" id="img-browse">
							</div>
						</div>
						<div class="img-tumbhnail">
							<i>*Note</i>: Ukuran gambar atau foto maksimal 1000 x 1000 px.
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-9 mt-4">
			<div class="card">
				<div class="card-header bg-orange text-white">
					<div class="row">
						<div class="col-md-6">
							Informasi Akun
						</div>
						<div class="col-md-6" align="right">
							<button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#edit-profil"><i class="fa fa-edit"></i></button>
						</div>
					</div>
				</div>
			</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4 mb-3">
							<div class="form-group">
								<small><b>Nama :</b></small>
								<p class="profil--nama"></p>
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<div class="form-group">
								<small><b>Jenis Kelamin :</b></small>
								<p class="profil--jenis-kelamin"></p>
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<div class="form-group">
								<small><b>Tempat, Tanggal Lahir :</b></small>
								<p class="profil--tempat-tanggal-lahir"></p>
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<div class="form-group">
								<small><b>Provinsi :</b></small>
								<p class="profil--provinsi"></p>
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<div class="form-group">
								<small><b>Kabupaten :</b></small>
								<p class="profil--kabupaten"></p>
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<div class="form-group">
								<small><b>Kecamatan :</b></small>
								<p class="profil--kecamatan"></p>
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<div class="form-group">
								<small><b>Alamat :</b></small>
								<p class="profil--alamat"></p>
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<div class="form-group">
								<small><b>Kode Pos :</b></small>
								<p class="profil--kode-pos"></p>
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<div class="form-group">
								<small><b>No. Telepon :</b></small>
								<p class="profil--no-telp"></p>
							</div>
						</div>
					</div>
				</div>
		</div>
	</div>
</div>

<div class="modal fade" id="edit-profil">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="form--update-profil">
				<div class="modal-header bg-orange text-white">
					Edit Informasi Profil
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12 message"></div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="" class="control-label">Nama <span class="required">*</span></label>
								<input type="text" name="" id="" maxlength="100" class="form-control profil--nama">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="" class="control-label">Jenis Kelamin <span class="required">*</span></label>
								<select name="" id="" class="form-control profil--jenis-kelamin select2">
									<option value="">-Pilih Jenis Kelamin-</option>
									<option value="Laki-Laki">Laki-Laki</option>
									<option value="Perempuan">Perempuan</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="" class="control-label">Tempat Lahir <span class="required">*</span></label>
								<input type="text" name="" maxlength="50" id="" class="form-control profil--tempat-lahir">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-gropu">
								<label for="" class="control-label">Tanggal Lahir <span class="required">*</span></label>
								<input type="text" name="" id="" class="form-control profil--tanggal-lahir datepicker" data-provide="datepicker">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="" class="control-label">Provinsi <span class="required">*</span></label>
								<select name="" id="" class="form-control select2 profil--provinsi">
									<option value=""></option>
								</select>
							</div>
						</div>
						<div class="col-md-4 kabupaten none">
							<div class="form-group">
								<label for="" class="control-label">Kabupaten <span class="required">*</span></label>
								<select name="" id="" class="form-control profil--kabupaten select2">
									<option value=""></option>
								</select>
							</div>
						</div>
						<div class="col-md-4 kecamatan none">
							<div class="form-group">
								<label for="" class="control-label">Kecamatan <span class="required">*</span></label>
								<select name="" id="" class="form-control profil--kecamatan select2">
									<option value=""></option>
								</select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="" class="control-label">Alamat <span class="required">*</span></label>
								<input type="text" name="" id="" class="form-control profil--alamat" maxlength="200">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="" class="control-label">Kode POS <span class="required">*</span></label>
								<input type="text" name="" id="" class="form-control profil--kode-pos" maxlength="10">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="" class="control-label">No. Telp <span class="required">*</span></label>
								<input type="text" name="" id="" maxlength="13" class="form-control profil--no-telp">
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