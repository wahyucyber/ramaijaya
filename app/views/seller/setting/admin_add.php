<section class="dashboard_store">
	<?php include __DIR__.'/../sidebar.php' ?>
	<div class="content-right" id="content-right">
		
		<div class="card-body border">
			<h6><b>Tambah Admin</b></h6>
			<hr>
			<div class="card-body border">
				<div class="row">
					<div class="col-md-3">
						<label for="">Pilih Paket</label>
						<select name="" id="" class="form-control">
							<option value="">JPMall Admin 3 Bulan</option>
							<option value="">JPMall Admin 6 Bulan</option>
							<option value="">JPMall Admin 1 Tahun</option>
						</select>
					</div>
					<div class="col-md-3">
						<label for="">Jumlah Admin</label>
						<select name="" id="" class="form-control">
							<option value="">1</option>
							<option value="">2</option>
							<option value="">3</option>
							<option value="">4</option>
							<option value="">5</option>
							<option value="">6</option>
							<option value="">7</option>
							<option value="">8</option>
							<option value="">9</option>
							<option value="">10</option>
						</select>
					</div>
					<div class="col-md-6 text-right">
						<small><b>Total Pembayaran</b></small>
						<h5 class="text-primary">Rp. 150.000</h5>
					</div>
				</div>
			</div>
			<hr>
			<div class="data-admin">
				<h6><b>Data Admin</b></h6>
				<small>Masukkan Alamat Email dan Nama orang yang ingin Anda tambahkan sebagai Admin. Dana Anda akan tetap aman, karena hanya Akun Anda yang dapat melakukan penarikan dana.</small>
				<div class="row mt-3">
					<div class="col-md-6">
						<div class="card-body border">
							<div class="form-group">
								<label for=""><b>Alamat Email</b></label>
								<div class="input-group mb-3">
								  <input type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1">
								  <div class="input-group-prepend">
								    <button class="input-group-text" id="basic-addon1">Cek</button>
								  </div>
								</div>
							</div>
							<div class="form-group">
								<label for=""><b>Nama</b></label>
								<input type="text" class="form-control">
								<small>Nama yang Anda daftarkan tidak dapat diubah lagi</small>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card-body border">
							<label for=""><b>Hak Akses</b></label>
							<ul class="list-group">
							  <li class="list-group-item bg-light">
							  	<div class="clearfix">
							  		<div class="float-left">
							  			<h6><i class="fas fa-store"></i>	Kelola Toko</h6>
							  		</div>
							  		<div class="float-right">
							  			<div class="custom-control custom-switch">
										  <input type="checkbox" class="custom-control-input" id="customSwitch1">
										  <label class="custom-control-label" for="customSwitch1"></label>
										</div>
							  		</div>
							  	</div>
							  </li>
							  <li class="list-group-item bg-light">
							  	<div class="clearfix">
							  		<div class="float-left">
							  			<h6><i class="far fa-envelope"></i>	Kelola Pesan</h6>
							  		</div>
							  		<div class="float-right">
							  			<div class="custom-control custom-switch">
										  <input type="checkbox" class="custom-control-input" id="customSwitch2">
										  <label class="custom-control-label" for="customSwitch2"></label>
										</div>
							  		</div>
							  	</div>
							  </li>
							  <li class="list-group-item bg-light">
							  	<div class="clearfix">
							  		<div class="float-left">
							  			<h6><i class="fas fa-dollar-sign"></i>	Kelola Transaksi</h6>
							  		</div>
							  		<div class="float-right">
							  			<div class="custom-control custom-switch">
										  <input type="checkbox" class="custom-control-input" id="customSwitch3">
										  <label class="custom-control-label" for="customSwitch3"></label>
										</div>
							  		</div>
							  	</div>
							  </li>
							  <li class="list-group-item bg-light">
							  	<div class="clearfix">
							  		<div class="float-left">
							  			<h6><i class="far fa-chart-bar"></i>	Kelola Statistik Toko</h6>
							  		</div>
							  		<div class="float-right">
							  			<div class="custom-control custom-switch">
										  <input type="checkbox" class="custom-control-input" id="customSwitch4">
										  <label class="custom-control-label" for="customSwitch4"></label>
										</div>
							  		</div>
							  	</div>
							  </li>
							</ul>
						</div>
					</div>
					<div class="btn-group text-right mt-3 ml-2">
						<a href="<?php echo base_url() ?>seller/settings/admin" class="btn btn-primary">Tambah</a>
						<a href="" class="btn btn-secondary ml-1">Batal</a>
					</div>
				</div>
			</div>
		</div>

	</div>
</section>