<?php $success = isset($_GET['success'])? $_GET['success'] : '' ?>
<?php if (!empty($success) && $success == true): ?>
	<section class="auth">
		<div class="container">
			<div class="box mx-auto">
					<a href="<?= base_url(); ?>" class="text-link logo">
						<img src="<?= base_url(); ?>assets/img/logo/logo-light.png" class="w-75" alt="">
					</a>
					<div class="alert alert-light border-secondary text-center">
						<i class="fa fa-envelope fs-30"></i><br>
						<div class="msg-content text-danger"></div>
					</div>
				</form>
			</div>
		</div>
	</section>
<?php else: ?>
	<section class="auth">
		<div class="container">
			<div class="box mx-auto">
				<form action="" id="form-forgot">
					<a href="<?= base_url(); ?>" class="text-link logo">
						<img src="<?= base_url(); ?>assets/img/logo/logo-light.png" class="w-75" alt="">
					</a>
					<h6>Silahkan masukkan email anda</h6>
					<div class="msg-content"></div>
					<div class="input-group mb-3">
			          <div class="input-group-prepend">
			            <span class="input-group-text bg-white"><i class="fal fa-envelope"></i></span>
			          </div>
						<input type="email" class="form-control email" placeholder="Masukkan Email">
					</div>
					<button class="btn btn-warning text-white btn-block mb-3" type="submit" id="btn-submit-login"><i class="fal fa-sync"></i>	Reset Password</button>
				</form>
				<div class="text-center mt-3 mb-3">
					<span class="fs-14">Sudah punya akun? <a href="<?= base_url(); ?>login" class="text-link text-orange">Silahkan Masuk</a></span>
				</div>
			</div>
		</div>
	</section>
<?php endif ?>