<section class="backend-settings">
	<?php require 'sidebar.php' ?>

	<div class="content-right content--page dashboard--page" id="content-right">
		<div class="card border-0 shadow">
			<div class="card-body">
				<h5 class="fs-20">Dashboard</h5>
				<div class="row">
					<div class="col-md-3" style="text-align: center; padding: 15px; border-right: 1px solid #ddd;">
						<div style="font-size: 15px; color: grey">Penjualan Hari ini</div>
						<span class="penjualan-hari-ini">
							Rp. 0
						</span>
					</div>
					<div class="col-md-3" style="text-align: center; padding: 15px; border-right: 1px solid #ddd;">
						<div style="font-size: 15px; color: grey">Penjualan Minggu ini</div>
						<span class="penjualan-minggu-ini">
							Rp. 0
						</span>
					</div>
					<div class="col-md-3" style="text-align: center; padding: 15px; border-right: 1px solid #ddd;">
						<div style="font-size: 15px; color: grey">Penjualan Bulan ini</div>
						<span class="penjualan-bulan-ini">
							Rp. 0
						</span>
					</div>
					<div class="col-md-3" style="text-align: center; padding: 15px;">
						<div style="font-size: 15px; color: grey">Total Penjualan</div>
						<span class="total-penjualan">
							Rp. 0
						</span>
					</div>
					<div class="col-md-12">
						<canvas id="canvas"></canvas>
					</div>
				</div>
			</div>
		</div>

		<div class="card border-0 shadow mt-2">
			<div class="card-body">
				<div class="row mb-4">
					<div class="col-md-4">
						<div class="card">
							<div class="card-body text-center">
								<div class="fs-17 fw-600 text-info mb-3 belum-dibayar"></div>
								<h6 class="fs-15 fw-bold">Pesanan Belum Dibayar</h6>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="card-body text-center">
								<div class="fs-17 fw-600 text-info mb-3 menunggu-diproses"></div>
								<h6 class="fs-15 fw-bold">Pesanan Menunggu Diproses</h6>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="card-body text-center">
								<div class="fs-17 fw-600 text-info mb-3 diproses"></div>
								<h6 class="fs-15 fw-bold">Pesanan telah diproses</h6>
							</div>
						</div>
					</div>
				</div>	
				<div class="row mb-4">
					<div class="col-md-4">
						<div class="card">
							<div class="card-body text-center">
								<div class="fs-17 fw-600 text-info mb-3 dikirim"></div>
								<h6 class="fs-15 fw-bold">Pesanan telah dikirim</h6>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="card-body text-center">
								<div class="fs-17 fw-600 text-info mb-3 diterima"></div>
								<h6 class="fs-15 fw-bold">Pesanan telah diterima</h6>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="card-body text-center">
								<div class="fs-17 fw-600 text-info mb-3 dibatalkan"></div>
								<h6 class="fs-15 fw-bold">Pesanan dibatalkan</h6>
							</div>
						</div>
					</div>
				</div>
				<div class="row mb-4">
					<div class="col-md-4">
						<div class="card">
							<div class="card-body text-center">
								<div class="fs-17 fw-600 text-info mb-3 total-pesanan"></div>
								<h6 class="fs-15 fw-bold">Total Semua Pesanan</h6>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="card-body text-center">
								<div class="fs-17 fw-600 text-info mb-3 total-produk"></div>
								<h6 class="fs-15 fw-bold">Total Produk</h6>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="card-body text-center">
								<div class="fs-17 fw-600 text-info mb-3 total-produk-diblokir"></div>
								<h6 class="fs-15 fw-bold">Total Produk Diblokir</h6>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="card">
							<div class="card-body text-center">
								<div class="fs-17 fw-600 text-info mb-3 total-komplain"></div>
								<h6 class="fs-15 fw-bold">Total Komplain</h6>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="card-body text-center">
								<div class="fs-17 fw-600 text-info mb-3 total-ulasan"></div>
								<h6 class="fs-15 fw-bold">Total Ulasan</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>