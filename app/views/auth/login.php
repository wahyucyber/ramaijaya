
<section class="auth">
	<div class="container">
		<div class="box mx-auto">
			<form action="" id="login-form">
				<a href="<?= base_url(); ?>" class="text-link logo">
					<img src="<?= base_url(); ?>assets/img/logo/logo-light.png" class="w-75" alt="">
				</a>
				<!-- <h6>Silahkan masuk dengan akun kamu</h6> -->
				<div class="msg-content">
					<?php if (flashdata('msg_success')): ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <?= flashdata('msg_success'); ?>
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						  </button>
						</div>
					<?php endif ?>
					<?php if (flashdata('msg_error')): ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <?= flashdata('msg_error'); ?>
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						  </button>
						</div>
					<?php endif ?>
				</div>
				<div id="msg-login-page"></div>
				<div class="input-group mb-3">
		          <!-- <div class="input-group-prepend">
		            <span class="input-group-text"><i class="fa fa-user"></i></span>
		          </div> -->
					<input type="email" class="form-control email" placeholder="Masukkan Email">
				</div>
				<div class="input-group input-password mb-3">
	                <input type="password" class="form-control password" id="password-input" placeholder="Masukkan Password">
	                <button class="btn" type="button" data-toggle="show-password" data-target="#password-input"><i class="fas icon"></i></button>
	            </div>
				<div class="row mb-3">
					<div class="col-6">
						<div class="custom-control custom-checkbox">
						  <input type="checkbox" name="remember" class="custom-control-input" id="remember">
						  <label class="custom-control-label fs-13" for="remember">Ingat Saya</label>
						</div>
					</div>
					<div class="col-6 text-right">
						<a href="<?= base_url('forgot'); ?>" class="text-link text-orange fs-13">Lupa Password?</a>
					</div>
				</div>
				<button class="btn btn-orange btn-block mb-3" type="submit" id="btn-submit-login"><i class="fal fa-sign-in"></i>	Login</button>
			</form>
			<!-- <button class="btn btn-block btn-facebook"><i class="fab fa-facebook-square fs-20"></i> <small class="fs-12">Login dengan</small> <b>Facebook</b></button>
			<button class="btn btn-block btn-google"><i class="fab fa-google"></i> <small class="fs-12">Login dengan</small> <b>Google</b></button> -->
				<div class="g-signin2" data-longtitle="true" data-onsuccess="Google_signIn" data-theme="light" data-width="397"></div>
				<div class="fb-login-button mt-2" data-size="large" data-button-type="continue_with" onlogin="checkLoginState()" data-layout="default" data-auto-logout-link="false" data-use-continue-as="false" data-width=""></div>
			<div class="text-center mt-3 mb-3">
				<span class="fs-14">Belum punya akun? <a href="<?= base_url(); ?>register" class="text-link text-orange">Silahkan Daftar</a></span>
			</div>
		</div>
		
	</div>
</section>