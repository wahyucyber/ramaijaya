
<section class="auth">
	<div class="container">
		<div class="box mx-auto">
		<form action="#" id="register-form">
			<a href="<?= base_url(); ?>" class="text-link logo">
				<img src="<?= base_url(); ?>assets/img/logo/logo-light.png" class="w-75" alt="">
			</a>
			<h6>Daftar Akun Baru Sekarang</h6>
			<div id="status"></div>
			<div class="msg-content"></div>
			<div class="line-separtor">
				<span class="line-separator-text">Informasi Akun</span>
			</div>
			<div class="form-group">
				<label for="" id="lb_ac">Nama</label>
				<input type="text" class="form-control nama" placeholder="Masukkan Nama" value="">
			</div>
			<div class="form-group">
				<label for="">Email</label>
				<input type="email" class="form-control email" placeholder="Masukkan Email" value="">
			</div>
			<div class="form-group row">
				<div class="col-md-6 mb-3 mb-lg-0">
					<label for="">Password</label>
					<input type="password" class="form-control password" placeholder="Masukkan Password">
				</div>
				<div class="col-md-6">
					<label for="">Konfirmasi Password</label>
					<input type="password" class="form-control konfirmasi_password" placeholder="Konfirmasi Password">
				</div>
			</div>
			<div class="form-group">
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="syarat-ketentuan">
				  <label class="custom-control-label fs-13" for="syarat-ketentuan">
				  	Saya telah membaca dan menyetujui 
				  		<a href="https://jpstore.id/content/6" class="text-orange text-link" target="_blank">Syarat dan Ketentuan</a>
				  	Ramai Jaya
				  	</label>
				</div>
			</div>
			<button class="btn btn-orange btn-block mb-3" type="submit" id="submit-register"><i class="fal fa-user-plus"></i>	Daftar</button>
		</form>
			<div class="row mt-3">
				<!-- <div class="col-md-12 mb-3">
					<button class="btn btn-block btn-facebook"><i class="fab fa-facebook-square fs-20"></i> <small class="fs-12">Login dengan </small><b>Facebook</b></button>
				</div>
				<div class="col-md-12 mb-3">
					<button class="btn btn-block btn-google"><i class="fab fa-google"></i> <small class="fs-12">Daftar dengan </small><b>Google</b></button>
				</div> -->
				<div class="col-md-12">
					<div class="g-signin2" data-longtitle="true" data-onsuccess="Google_signIn" data-theme="light" data-width="397"></div>
				</div>
				<div class="col-md-12 mt-2">
					<div class="fb-login-button" data-size="large" data-button-type="continue_with" onlogin="checkLoginState()" data-layout="default" data-auto-logout-link="false" data-use-continue-as="false" data-width=""></div>
				</div>
			</div>
			<div class="text-center mt-3 mb-3">
				<span class="fs-14">Sudah punya akun? <a href="<?= base_url(); ?>login" class="text-link text-orange">Silahkan Login</a></span>
			</div>
		</div>
		
	</div>
</section>