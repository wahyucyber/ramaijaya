<section class="setting_store">
	<?php require 'sidebar.php'; ?>
	<div class="content-right" id="content-right">
		<div class="card-header shadow mb-3 bg-orange text-white">
			<div class="row">
				<div class="col-6">
					<h5 class=" ">Hai, <span class="shop--name"></span></h5>
				</div>
				<div class="col-6 text-right">
					<h5 class=""><i class="fal fa-tachometer-alt-fastest"></i>	Dashboard</h5>
				</div>
			</div>
		</div>
		<div class="card border-0 mb-3 shadow">
			<div class="card-body">
				<div class="row">
					<div class="col-md-3" style="text-align: center; padding: 15px; border-right: 1px solid #ee4d2d;">
						<div style="font-size: 15px; color: #ee4d2d"><b> Penjualan Hari Ini </b></div>
						<span class="penjualan-hari-ini">
							Rp. 0
						</span>
					</div>
					<div class="col-md-3" style="text-align: center; padding: 15px; border-right: 1px solid #ee4d2d;">
						<div style="font-size: 15px; color: #ee4d2d"><b> Penjualan Minggu Ini </b></div>
						<span class="penjualan-minggu-ini">
							Rp. 0
						</span>
					</div>
					<div class="col-md-3" style="text-align: center; padding: 15px; border-right: 1px solid #ee4d2d;">
						<div style="font-size: 15px; color: #ee4d2d"><b> Penjualan Bulan Ini </b></div>
						<span class="penjualan-bulan-ini">
							Rp. 0
						</span>
					</div>
					<div class="col-md-3" style="text-align: center; padding: 15px;">
						<div style="font-size: 15px; color: #ee4d2d"><b> Total Penjualan </b></div>
						<span class="total-penjualan">
							Rp. 0
						</span>
					</div>
					<div class="col-md-12 mt-3">
						<canvas id="canvas"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="card mb-3 border-0 shadow">
			<div class="card-body">
				<div class="row">
					<div class="col-6 col-lg-3 text-center mb-3 mb-lg-0" style=" border-right: 1px solid #ee4d2d;">
						<div>
							<i class="text-orange fal fa-smile" ></i>
							<span class="ml-1 total_ulasan">0</span>
						</div>
						<span class="fs-11">Total Ulasan</span>
					</div>
					<div class="col-6 col-lg-3 text-center mb-3 mb-lg-0" style=" border-right: 1px solid #ee4d2d;">
						<div>
							<i class="text-orange fal fa-frown"></i>
							<span class="ml-1 total_komplain">0</span>
						</div>
						<span class="fs-11">Total Komplain</span>
					</div>
					<div class="col-6 col-lg-3 text-center mb-0 mb-lg-0" style=" border-right: 1px solid #ee4d2d;">
						<div>
							<i class="text-orange fal fa-box-open"></i>
							<span class="ml-1 total_produk">0</span>
						</div>
						<span class="fs-11">Total Produk</span>
					</div>
					<div class="col-6 col-lg-3 text-center mb-0 mb-lg-0">
						<div>
							<i class="text-orange fal fa-boxes"></i>
							<span class="ml-1 total_pesanan">	0</span>
						</div>
						<span class="fs-11">Total Pesanan</span>
					</div>
				</div>
			</div>
		</div>
		<div class="card my-3 border-0 shadow">
			<div class="card-body">
				<div class="reviews-filter">
					<div class="row">
						<div class="col-md-1 pr-0 d-flex align-items-center">
							<h6 class="fs-15">Status</h6>
						</div>
						<div class="col-md-11" style="overflow-x: auto;overflow-y: hidden;padding: .5rem 0;">
							<ul class="btn_list-filter mb-0 order--status--filter">
								<li><button class="btn fs-13 btn_filter" data-status="all">Semua Pesanan <span class="badge badge-primary bg-orange total_pesanan">0</span></button></li>
								<li><button class="btn fs-13 btn_filter" data-status="1">Menunggu Diproses <span class="badge badge-primary bg-orange menunggu_diproses">0</span></button></li>
								<li><button class="btn fs-13 btn_filter" data-status="2">Diproses <span class="badge badge-primary bg-orange diproses">0</span></button></li>
								<li><button class="btn fs-13 btn_filter" data-status="3">Dikirim <span class="badge badge-primary bg-orange dikirim">0</span></button></li>
								<li><button class="btn fs-13 btn_filter" data-status="4">Pesanan Selesai <span class="badge badge-primary bg-orange selesai">0</span></button></li>
								<li><button class="btn fs-13 btn_filter" data-status="dibatalkan">Pesanan Dibatalkan <span class="badge badge-primary bg-orange dibatalkan">0</span></button></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body">

				<div class="order--list" id="order--list">
					<div class="card">
						<div class="card-body d-flex align-items-center justify-content-center">
							<div class="order-empty text-center">
								<img src="https://ecs7.tokopedia.net/assets-frontend-resolution/production/media/ic-laporkan-masalah-copy-5@2x.14ca80fb.png" class="w-25">
								<h6 class="mt-3 fw-600">Belum Ada Pesanan</h6>
								<small>Anda tidak memiliki pesanan</small>
							</div>
						</div>
					</div>
				</div>
				<div id="Pagination" class="text-center"></div>
			</div>
		</div>
	</div>
</section>