<form class="form--add-alamat">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
				    <li class="breadcrumb-item"><a href="<?php echo base_url(''); ?>">Home</a></li>
				    <li class="breadcrumb-item"><a href="<?php echo base_url(''); ?>">Akun Saya</a></li>
				    <li class="breadcrumb-item"><a href="<?php echo base_url('user/profil?tab=informasi_pengiriman'); ?>">Alamat Pengiriman</a></li>
				    <li class="breadcrumb-item"><a href="<?php echo base_url('user/profil/?tab=tambah_informasi_pengiriman'); ?>">Tambah</a></li>
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
			<div class="col-md-12 mt-4" align="right">
				<a href="<?php echo base_url('user/profil/?tab=informasi_pengiriman'); ?>" class="btn btn-danger btn-sm"><i class="fa fa-arrow-circle-left"></i></a>
			</div>
			<div class="col-md-12 mt-2">
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
					<label for="" class="control-label">Kabupaten <span class="required">*</span></label>
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
			<div class="col-md-12">
				<button type="submit" class="btn btn-success btn-lg btn-block"><i class="fa fa-save"></i> Simpan</button>
			</div>
		</div>
	</div>
</form>