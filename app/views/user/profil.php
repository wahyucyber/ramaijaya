<div class="container">
	<div class="row">
		<div class="col-md-12">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="<?php echo base_url(''); ?>">Home</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo base_url('user/profil?tab=profil'); ?>">Akun Saya</a></li>
			    <li class="breadcrumb-item"><a href="<?php echo base_url('user/profil?tab=profil'); ?>">Profil</a></li>
			  </ol>
			</nav>
		</div>
		<div class="col-md-12 profil--message"></div>
		<div class="col-md-12" style="margin-top: -11px">
			<ul class="nav nav-tabs">
			  <li class="nav-item">
			    <a class="nav-link active" href="<?php echo base_url('user/profil/?tab=profil'); ?>">Profil</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" href="<?php echo base_url('user/profil/?tab=informasi_pengiriman'); ?>">Informasi Pengiriman</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" href="<?php echo base_url('user/profil/?tab=ubah-password'); ?>">Ubah Password</a>
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
				<div class="card-header">
					<div class="row">
						<div class="col-md-6">
							Informasi Akun
						</div>
						<div class="col-md-6" align="right">
							<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit-profil"><i class="fa fa-edit"></i></button>
						</div>
					</div>
				</div>
				<div class="card-body">
					<table class="table" style="font-size: 14px;">
						<tr>
							<td>Nama</td>
							<td align="right" class="profil--nama" style="font-weight: bold; font-style: italic">~</td>
						</tr>
						<tr>
							<td>Jenis Kelamin</td>
							<td align="right" class="profil--jenis-kelamin" style="font-weight: bold; font-style: italic">~</td>
						</tr>
						<tr>
							<td>Tempat, Tanggal Lahir</td>
							<td align="right" class="profil--tempat-tanggal-lahir" style="font-weight: bold; font-style: italic">~</td>
						</tr>
						<tr>
							<td>Provinsi</td>
							<td align="right" class="profil--provinsi" style="font-weight: bold; font-style: italic">~</td>
						</tr>
						<tr>
							<td>Kabupaten</td>
							<td align="right" class="profil--kabupaten" style="font-weight: bold; font-style: italic">~</td>
						</tr>
						<tr>
							<td>Kecamatan</td>
							<td align="right" class="profil--kecamatan" style="font-weight: bold; font-style: italic">~</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td align="right" class="profil--alamat" style="font-weight: bold; font-style: italic">~</td>
						</tr>
						<tr>
							<td>Kode Pos</td>
							<td align="right" class="profil--kode-pos" style="font-weight: bold; font-style: italic">~</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="edit-profil">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="form--update-profil">
				<div class="modal-header">
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
						<div class="col-md-12">
							<div class="form-group">
								<label for="" class="control-label">Provinsi <span class="required">*</span></label>
								<select name="" id="" class="form-control select2 profil--provinsi">
									<option value=""></option>
								</select>
							</div>
						</div>
						<div class="col-md-12 kabupaten none">
							<div class="form-group">
								<label for="" class="control-label">Kabupaten <span class="required">*</span></label>
								<select name="" id="" class="form-control profil--kabupaten select2">
									<option value=""></option>
								</select>
							</div>
						</div>
						<div class="col-md-12 kecamatan none">
							<div class="form-group">
								<label for="" class="control-label">Kecamatan <span class="required">*</span></label>
								<select name="" id="" class="form-control profil--kecamatan select2">
									<option value=""></option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
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
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-success">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>