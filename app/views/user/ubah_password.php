<div class="container">
	<div class="row">
		<div class="col-md-12">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb bg-white p-0">
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
						<a class="nav-link " href="<?php echo base_url('user/profil/?tab=profil'); ?>"><i class="fal fa-user"></i>	Profil</a>
					</li>
					<li class="nav-item">
						<a class="nav-link " href="<?php echo base_url('user/profil/?tab=informasi_pengiriman'); ?>"><i class="fal fa-box-check"></i> Informasi Pengiriman</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="<?php echo base_url('user/profil/?tab=ubah-password'); ?>"><i class="fal fa-key"></i> Ubah Password</a>
					</li>
				</ul>
		</div>
	</div>
	<div class="card border-0 shadow-sm">
		<div class="card-body">
			<div class="msg--content"></div>
			<div class="form-group">
				<small>Password Lama</small>
				<input type="password" class="form-control password_lama" placeholder="Masukkan password lama">
			</div>
			<div class="row mb-3">
				<div class="col-md-6">
					<div class="form-group">
						<small>Password baru</small>
						<input type="password" class="form-control password_baru" placeholder="Masukkan password">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<small>Konfirmasi password baru</small>
						<input type="password" class="form-control konfirmasi_password_baru" placeholder="Konfirmasi password baru">
					</div>
				</div>
			</div>
			<div class="form-group text-right">
				<button class="btn btn-success" data-toggle="modal" data-target="#ModalConfirm"><i class="fal fa-save"></i>	Simpan Password</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="ModalConfirm" tabindex="-1" role="dialog" aria-labelledby="modalLogoutLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-orange">
        <h5 class="modal-title text-white">Konfirmasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <form action="">
	      <div class="modal-body">
	      	<div class="alert alert-warning">
				Apakah anda yakin ingin mengubah <strong>Password </strong> sekarang?
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fal fa-times-circle"></i>	Batal</button>
	        <button type="submit" class="btn btn-danger"><i class="fal fa-check-circle"></i>	Iya</button>
	      </div>
      </form>
    </div>
  </div>
</div>