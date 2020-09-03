<section class="backend-settings">
	<?php require 'sidebar.php' ?>
	<div class="content-right content--page" id="content-right">

		<div class="row">
			
			<div class="col-md-6">
				<h4 class="fs-24">Pesanan</h4>
			</div>

			<div class="col-md-6 text-right">
				<button class="btn btn-outline-secondary bg-white text-secondary"><i class="fa fa-download"></i> Unduh Laporan Penjualan</button>
			</div>

		</div>

		<div class="card my-3">
			<div class="card-body pb-0">
				<div class="row mb-2">
					<div class="col-md-10">
						<div class="reviews-filter mb-3">
							<div class="row">
								<div class="col-md-1 pr-0 d-flex align-items-center">
									<h6 class="fs-15">Status</h6>
								</div>
								<div class="col-md-11 pl-0">
									<ul class="btn_list-filter mb-0" id="filter-o">
										<li><button class="btn fs-13 btn_filter active" data-status="all">Semua Pesanan</button></li>
										<li><button class="btn fs-13 btn_filter" data-status="new">Pesanan Baru</button></li>
										<li><button class="btn fs-13 btn_filter" data-status="ready">Siap Dikirim</button></li>
										<li><button class="btn fs-13 btn_filter" data-status="delivery">Dalam Pengiriman</button></li>
										<li><button class="btn fs-13 btn_filter" data-status="done">Pesanan Selesai</button></li>
										<li><button class="btn fs-13 btn_filter" data-status="cancel">Pesanan Dibatalkan</button></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="curs-p fs-12" id="btn-toggle-filter">Sembunyikan Filter <i class="fa fa-angle-up"></i></div>
					</div>
				</div>
				<form action="">
					<div class="row fs-13 collapse show" id="filter-b">
						<div class="col-md-2 mb-3">
							<select class="form-control select2 fs-13" data-placeholder="Pilih Filter">
								<option value=""></option>
							</select>
						</div>
						<div class="col-md-3 mb-3">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fa fa-calendar"></i></span>
								</div>
								<input type="text" class="form-control fs-13" placeholder="Pilih Tanggal">
							</div>
						</div>
						<div class="col-md-2 mb-3">
							<select class="form-control select2 fs-13" data-placeholder="Urut Berdasarkan">
								<option value=""></option>
							</select>
						</div>
						<div class="col-md-4 mb-3">
							<div class="input-group">
								<input type="text" class="form-control fs-13" placeholder="Cari nama pembeli atau produk atau invoice atau no resi">
								<div class="input-group-append">
									<button class="input-group-text"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>
						<div class="col-md-1 mb-3 d-flex align-items-center">
							<button class="btn text-primary fs-13 w-100 p-0" type="reset">Reset</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<!-- <div class="card">
			<div class="card-body d-flex align-items-center justify-content-center">
				<div class="order-empty text-center">
					<img src="https://ecs7.tokopedia.net/assets-frontend-resolution/production/media/ic-laporkan-masalah-copy-5@2x.14ca80fb.png" class="w-25">
					<h6 class="mt-3 fw-600">Belum Ada Pesanan</h6>
					<small>Anda Belum Menerima Pesanan</small>
				</div>
			</div>
		</div> -->

		<ul class="order-list-fill mb-3 table-responsive" id="order-content-status">
		 	<li class="order-item fs-14 shadow">
		 		<div class="order-item-head">
		 			<a href="">INV/20190806/XVI/X/512344657</a> 
		 			<span class="ml-2">(Masteguh)</span> 
		 			<span class="fs-12 text-white-lightern-3 ml-2">06 Aug 2019 14:03 WIB</span> 
		 			<span class="badge badge-secondary ml-2">Pesanan Baru</span>
		 			<span class="text-white-lightern-3 ml-2">Batas Respons</span>
		 			<span class="badge badge-warning ml-2"><i class="fas fa-clock"></i> 5 hari</span>
		 		</div>
		 		<div class="order-item-body">
		 			<div class="order-details">
		 				<div class="img-product column-1">
		 					<img src="https://ecs7.tokopedia.net/img/cache/100-square/default_v3-shopnophoto.png" alt="">
		 				</div>
		 				<div class="detail-product column-2">
		 					<a href="" class="name fs-16 text-primary fw-600 d-block">Buku Bahasa Indonesia</a>
		 					<span class="code d-block fs-14 text-white-lightern-3">SKU - 1234567890123456123</span>
		 					<p class="weight-price d-block fs-13 text-dark">1 Produk (500gram) <span class="text-danger">Rp 3.000.000</span> </p>
		 					<p class="fs-12">"Tolong Rapikan Bukunya agar bisa di lihat lebih baik"</p>
		 				</div>
		 				<div class="address-shipping column-3">
		 					<h6 class="fs-16 fw-600">Alamat Pengiriman</h6>
		 					<span class="ship-name fs-12">Masteguh</span>
		 					<p class="address fs-12">Jl Soekartijo RW 02 RT 07</p>
		 				</div>
		 				<div class="kurir column-4">
		 					<h6 class="fs-16 fw-600">Kurir</h6>
		 					<span class="kurir-name d-block fs-12">JNE - Reguler <small class="text-white-lightern-3 fs-12">(Rp 15.000)</small> </span>
		 					<div class="msg-info alert alert-warning fs-12 mt-2 text-warning d-inline-block">Sudah Dicetak</div>
		 				</div>
		 				<div class="price column-5">
		 					<h6 class="fs-16 fw-600">Total Harga</h6>
		 					<h3 class="fs-20 text-danger">Rp 3.000.000</h3>
		 				</div>
		 			</div>
		 		</div>
		 		<div class="order-item-footer">
		 			<div class="clearfix">
		 				<div class="float-left">
		 					<button class="btn text-white-lightern-3"><i class="fa fa-comment"></i> Chat Pembeli</button>
		 					<button class="btn text-white-lightern-3"><i class="fa fa-file"></i> Status Pesanan</button>
		 					<button class="btn text-white-lightern-3"><i class="fa fa-print"></i> Cetak Label</button>
		 				</div>
		 				<div class="float-right">
		 					<button class="btn btn-success">Terima Pesanan</button>
		 				</div>
		 			</div>
		 		</div>
		 	</li>
		 </ul>

	</div>
</section>