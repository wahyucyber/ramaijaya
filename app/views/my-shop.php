
<section class="my-shop">
	<div class="my-shop-inner">
		<?= loader(); ?>
		<div class="my-shop-content d-none">
			<div class="column">
				<img src="<?= base_url(); ?>cdn/default/jpmall-open-shop.png" alt="">
			</div>
			<div class="column form-content">
				<div class="card card-body new-render">
					<h6 class="fs-16 my-3 d-block text-center"></h6>
					<form action="">
						<div class="form-group">
							<small>Nama Toko</small>
							<input type="text" class="form-control nama_toko" placeholder="Nama Toko" maxlength="24">
							<div class="row">
								<div class="col-md-9">
									<div class="msg-shop-name fs-11"></div>					
								</div>
								<div class="col-md-3 text-right fs-11 text-dark-2">
									<span class="nama-toko-length">0</span>/24
								</div>
							</div>
							<small id="slug-toko" class="text-muted"></small>
						</div>
						<div class="form-group">
							<small>Provinsi</small>
							<select class="form-control select2 provinsi" data-placeholder="Pilih Provinsi">
								<option value=""></option>
							</select>
						</div>
						<div class="form-group">
							<small>Kabupaten</small>
							<select class="form-control select2 kabupaten" data-placeholder="Pilih Kabupaten">
								<option value=""></option>
							</select>
						</div>
						<div class="form-group">
							<small>Kecamatan</small>
							<select class="form-control select2 kecamatan" data-placeholder="Pilih Kecamatan">
								<option value=""></option>
							</select>
						</div>
						<div class="form-group">
							<small>Kode Pos</small>
							<input type="number" class="form-control kode_pos" placeholder="Kode Pos">
						</div>
						<div class="form-group">
							<div class="custom-control custom-checkbox">
							  <input type="checkbox" class="custom-control-input" id="remember" checked>
							  <label class="custom-control-label fs-13" for="remember">
							  	Saya telah membaca dan menyetujui 
							  		<a href="" class="text-primary text-link">Aturan Penggunaan </a> 
							  	dan 
							  		<a href="" class="text-primary text-link"> Kebijakan Privasi</a>
							  	<?= env('APP_NAME') ?>
							  	</label>
							</div>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-block">Buka Toko Gratis</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>