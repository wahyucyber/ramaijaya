<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLoginTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-document-md" role="document">
    <div class="modal-content" style="border-radius: 8px;">
      <div class="modal-header border-0">
        <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
      </div>
      <?= form_open(''); ?>
      <div class="modal-body">
        <div class="text-center mb-4">
          <img src="<?= base_url(); ?>cdn/favicon.png" style="width: 75%">
        </div>
      	<h4 class="text-center mb-3">Masuk Dengan Akun Kamu</h4>
      	<div class="msg-content"></div>
    <div class="input-group mb-2">
          <!-- <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-user"></i></span>
          </div> -->
			<input type="email" class="form-control email" placeholder="Masukkan Email">
		</div>
		<div class="input-group input-password">
        <input type="password" class="form-control password" id="password-input" placeholder="Masukkan Password">
        <button class="btn" type="button" data-toggle="show-password" data-target="#password-input"><i class="fas icon"></i></button>
    </div>
		<div class="row mb-3">
			<div class="col-md-6">
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="remember">
				  <label class="custom-control-label fs-13" for="remember">Ingat Saya</label>
				</div>
			</div>
			<div class="col-md-6 text-right">
				<a href="<?= base_url('forgot') ?>" class="text-link text-primary fs-13">Lupa Password?</a>
			</div>
		</div>
		<button class="btn btn-primary btn-block mb-3" type="submit" id="btn-submit-login">Login</button>
		<?= form_close(); ?>
		<div class="line-separtor mb-3">
			<span class="line-separator-text">Atau</span>
		</div>
		<div class="text-center mt-3">
			<span class="fs-13">Belum punya akun? <a href="<?= base_url(); ?>register" class="text-link text-primary">Silahkan Daftar</a></span>
		</div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalLogout" tabindex="-1" role="dialog" aria-labelledby="modalLogoutLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white">Konfirmasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>	
      <div class="modal-body">
      	<div class="alert alert-warning">
			Apakah anda yakin ingin mengakhiri <strong>Sesi</strong> ini ?
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger">Iya</button>
      </div>
    </div>
  </div>
</div>