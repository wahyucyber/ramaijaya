  <section class="dashboard_store">
	<?php $this->load->view('seller/sidebar') ?>
	<div class="content-right" id="content-right">
		<h2>Wawasan Toko</h2>

		<div class="card">
				
			<div class="card-body">
				<div class="clearfix">
					<div class="float-left">
						<h6><b>Performa Toko</b></h6>
						<small>Anda bisa Upgrade jadi Power Merchant dengan minimum skor 75 poin dan telah berhasil verifikasi toko dengan cara upload KTP. Pelajari selengkapnya</small>
					</div>
					<div class="float-right">
						<a href="" class="btn btn-primary">Lihat Detail</a>
					</div>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-md-6 pr-0">
				<div class="card-body kolom-statistik border">
					<h6><b>Statistik Minggu Ini</b></h6>
					<div class="progress mb-3 mt-3" style="height: 15px;">
					  <div class="progress-bar bg-primary" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					<div class="clearfix">
						<div class="float-left">
							<h6><b>Skor Performa Toko</b></h6>
						</div>
						<div class="float-right">
							<h6><b>80/100</b></h6>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col-md-8">
							<small>Dengan poin minimum 75, tokomu siap upgrade menjadi Power Merchant.</small>
						</div>
						<div class="col-md-4">
							<a href="" class="btn btn-primary btn-block"><small>Upgrade Tokomu</small></a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6  pl-0">
				<div class="card-body kolom-statistik border">
					<h6><b>Indikator Performa Toko</b></h6>
				</div>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-md-3 pr-0">
				<div class="card-body border">
					<h6>Pendapatan Kotor</h6>
					<h6><b>Rp. 0</b></h6>
					<small>Data Tidak Tersedia</small>
				</div>
			</div>
			<div class="col-md-3 p-0">
				<div class="card-body border">
					<h6>Produk Dilihat</h6>
					<h6><b>0</b></h6>
					<small>Data Tidak Tersedia</small>
				</div>
			</div>
			<div class="col-md-3 p-0">
				<div class="card-body border">
					<h6>Tingkat Konversi</h6>
					<h6><b>0%</b></h6>
					<small>Data Tidak Tersedia</small>
				</div>
			</div>
			<div class="col-md-3 pl-0">
				<div class="card-body border">
					<h6>Produk Terjual</h6>
					<h6><b>0</b></h6>
					<small>Data Tidak Tersedia</small>
				</div>
			</div>
		</div>

		<div class="card-body border bg-primary mt-3">
			<div class="clearfix">
				<div class="float-left text-light">
					<h6><b>Data Produk</b></h6>
				</div>
				<div class="float-right">
					<a href="" class="btn btn-light">Lihat Detail</a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3 pr-0">
				<ul class="list-group">
				  <li class="list-group-item">
				  	<h6>Produk Dilihat</h6>
					<h6><b>0</b></h6>
					<small>Data Tidak Tersedia</small>
				  </li>
				  <li class="list-group-item">
				  	<h6>Transaksi Sukses</h6>
					<h6><b>0</b></h6>
					<small>Data Tidak Tersedia</small>
				  </li>
				  <li class="list-group-item">
				  	<h6>Tingkat Konversi</h6>
					<h6><b>0%</b></h6>
					<small>Data Tidak Tersedia</small>
				  </li>
				  <li class="list-group-item">
				  	<h6>Produk Terjual</h6>
					<h6><b>0</b></h6>
					<small>Data Tidak Tersedia</small>
				  </li>
				</ul>
			</div>

			<div class="col-md-9 pl-0">
				<div class="card-body border">
					<canvas id="myChart" width="400" height="200"></canvas>			
				</div>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-md-6">
				<div class="card-body border">
					<div class="no-list card-no-list text-center">
						<img src="https://ecs7.tokopedia.net/img/newtkpd/gmstat/icon_top_selling.png">
						<h6 class=""><b>Tidak ada produk di terjual dalam 30 hari terakhir</b></h6>
					</div>
				</div>
				<div class="card-footer text-center border">
					<small>Jadikan produk lainnya lebih populer dengan  fitur TopAds</small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card-body border">
					<div class="no-list card-no-list text-center">
						<img src="https://ecs7.tokopedia.net/img/newtkpd/gmstat/icon_top_wishlist.png">
						<h6 class=""><b>Tidak ada produk di wishlist dalam 30 hari terakhir</b></h6>
					</div>
				</div>
				<div class="card-footer text-center border">
					<small>Jadikan produk lainnya lebih populer dengan  fitur TopAds</small>
				</div>
			</div>
		</div>

		<div class="card-body border bg-primary mt-3">
			<div class="clearfix">
				<div class="float-left text-light">
					<h6><b>Data Transaksi</b></h6>
				</div>
				<div class="float-right">
					<a href="" class="btn btn-light">Lihat Detail</a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3 pr-0">
				<div class="card-body border text-center card-jumlah-transaksi" >
					<h6>Jumlah Transaksi</h6>
					<h6><b>0</b></h6>
					<small>Data Tidak Tersedia</small>
					<hr>
					<!-- <canvas id="myChart2" width="100%" height="100%"></canvas> -->
			        <!-- Progress bar 1 -->
			        <div class="progress-circle mx-auto mt-5" data-value='80'>
			          <span class="progress-left">
			                <span class="progress-bar border-primary"></span>
			          </span>
			          <span class="progress-right">
			                <span class="progress-bar border-primary"></span>
			          </span>
			          <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
			            <div class="h2 font-weight-bold">80%</sup></div>
			          </div>
			        </div>
			        <div class="clearfix">
			        	<div class="float-left">
							<span class="badge badge-primary">Sukses</span>
			        	</div>
			        	<div class="float-right">
			        		<small><b>80</b></small>
			        	</div>
			        </div>
			        <div class="clearfix">
			        	<div class="float-left">
							<span class="badge badge-light">Ditolak</span>
			        	</div>
			        	<div class="float-right">
			        		<small><b>20</b></small>
			        	</div>
			        </div>
			        <div class="card-body bg-light mt-3">
			        	<small>	Tersisa <b>0</b> transaksi yang belum selesai.</small>
			        </div>
				</div>
			</div>
			<div class="col-md-9 pl-0">
				<div class="card-body border card-data-transaksi-right">
					<canvas id="myChart1" width="400" height="200"></canvas>
				</div>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-md-6">
				<div class="card-header border">
					<div class="clearfix">
						<div class="float-left">
							<h6>Pendapatan</h6>
						</div>
						<div class="float-right">
							<small><a href="" class="card-link text-dark">Lihat Detail</a></small>
						</div>
					</div>
				</div>
				<div class="card-body border text-center">
					<h6>Total Pendapatan</h6>
					<h6><b>Rp. 0</b></h6>
					<small>Data Tidak Tersedia</small>
				</div>
				<div class="row">
					<div class="col-md-6 pr-0">
						<div class="card-body border text-center">
							<small>Pendapatan Bersih</small>
							<p class="m-0"><b>Rp. 0</b></p>
							<small>Data Tidak Tersedia</small>
						</div>
					</div>
					<div class="col-md-6 pl-0">
						<div class="card-body border text-center">
							<small>Pendapatan Bersih</small>
							<p class="m-0"><b>Rp. 0</b></p>
							<small>Data Tidak Tersedia</small>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card-header border">
					<div class="clearfix">
						<div class="float-left">
							<h6>Ditolak</h6>
						</div>
						<div class="float-right">
							<small><a href="" class="card-link text-dark ">Lihat Detail</a></small>
						</div>
					</div>
				</div>
				<div class="card-body border card-transaksi-wawasan">
					<small>Dana Ditolak</small>
					<p><b>Rp. 0</b></p>
					<small>Data Tidak tersedia</small>
				</div>
			</div>
			<div class="col-md-4"></div>
		</div>

		<div class="card-body border bg-primary mt-3">
			<div class="clearfix">
				<div class="float-left text-light">
					<h6><b>Data Pembeli</b></h6>
				</div>
				<div class="float-right">
					<a href="" class="btn btn-light">Lihat Detail</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 pr-0">
				<div class="card-body border">
					<h6>Jumlah Pembeli</h6>
					<h5><b>0</b></h5>
					<small>0% dari periode sebelumnya</small>
				</div>
				<div class="card-body border">
					<div class="row">
						<div class="col-md-3">
							<img src="https://ecs7.tokopedia.net/img/newtkpd/gmstat/icon_gm_stats_female.png" class="w-100" alt="">
							<small>75 %</small>
						</div>
						<div class="col-md-6">
							<div class="progress mt-4">
							  <div class="progress-bar w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
						<div class="col-md-3">
							<img src="https://ecs7.tokopedia.net/img/newtkpd/gmstat/icon_gm_stats_male.png" class="w-100" alt="">
							<small>25 %</small>
						</div>
					</div>
				</div>
				<div class="card-body border">
					<div class="17">
						<small>< 17 tahun</small>
						<div class="progress">
						  <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
						</div>
					</div>
					<div class="18 mt-2">
						<small>18-23 Tahun</small>
						<div class="progress">
						  <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
						</div>
					</div>
					<div class="24 mt-2">
						<small>24-34 Tahun</small>
						<div class="progress">
						  <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">70%</div>
						</div>
					</div>
					<div class="35 mt-2">
						<small>35-44 Tahun</small>
						<div class="progress">
						  <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
						</div>
					</div>
					<div class="45">
						<small>45+ Tahun</small>
						<div class="progress">
						  <div class="progress-bar" role="progressbar" style="width: 10%;" aria-valuenow="0" aria-valuemin="10" aria-valuemax="100">10%</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 p-0">
				<div class="card-body border card-user-statistic-dashboard">
					<div class="dekstop-card-user-statistic-dashboard text-center">
						<img src="https://ecs7.tokopedia.net/img/newtkpd/gmstat/icon_top_buyers.png" class="w-35" alt="">
						<h6><b>Tidak ada transaksi pada periode ini</b></h6>
					</div>
				</div>
			</div>
			<div class="col-md-4 pl-0">
				<div class="card-body border text-center card-transaksi-pin-map">
					<div class="dekstop-card-user-statistic-dashboard">
						<img src="https://ecs7.tokopedia.net/img/newtkpd/gmstat/icon_top_cities.png" class="w-25" alt="">
						<h6><b>Tidak ada transaksi pada periode ini</b></h6>
					</div>
				</div>
				<div class="card-footer border">
					<h6>Total Favorit</h6>
					<h6><b>0</b></h6>
				</div>
			</div>
		</div>

	</div>
</section>