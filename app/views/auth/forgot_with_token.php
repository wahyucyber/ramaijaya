
<section class="auth">
	<div class="container">
		<div class="box mx-auto">
			<form action="" id="form-forgot">
				<a href="<?= base_url(); ?>" class="text-link logo">
					<img src="<?= base_url(); ?>cdn/favicon.png" alt="">
				</a>
				<h6>Silahkan masukkan password baru anda</h6>
				<div class="msg-content"></div>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text bg-white"><i class="fa fa-key"></i></span>
					</div>
					<input type="password" class="form-control password" placeholder="Masukkan password baru">
					<div class="input-group-append input-password">
				        <button class="btn bg-white" type="button" data-toggle="show-password" data-target=".password"><i class="fas icon"></i></button>
				    </div>
				</div>
				<button class="btn btn-primary text-white btn-block mb-3" type="submit" id="btn-submit-login">Ubah Password</button>
			</form>
		</div>
	</div>
</section>