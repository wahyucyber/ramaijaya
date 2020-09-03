
<div class="container">
	
	<div class="shop-single--content" id="shop--single-content">
		
		<div class="shop-single--head">
			<img src="<?= base_url('assets/img/default/seller_no_cover_3.png'); ?>" alt="" class="banner--toko"  width="100%">
			<!-- <div class="official-store--badge">
				<i class="official-store--icon fad fa-badge-check"></i>
				<h6 class="official-store--title">Official Store</h6>
			</div> -->
		</div>

		<div class="shop-single--body">
			
			<div class="shop-single--body-content row">
				
				<div class="shop-single--content-left col-md-6 d-flex">
					
					<div class="shop-single--logo">
						<img src="<?= base_url('assets/img/default/shop.png'); ?>" alt="" class="logo--toko" width="100%">
					</div>

					<div class="shop-single--detail">
						
						<h5 class="fs-25 fw-700 nama--toko">Nama Toko</h5>

						<div class="row mb-2">
							<div class="col-auto">
								<h5 class="fs-14"><i class="fad fa-map-marker-alt"></i> <span class="kabupaten--toko">-</span></h5>
							</div>
							<!-- <div class="col-auto">
								<h5 class="fs-14"><span class="fw-600">0</span> Pengikut</h5>
							</div> -->
						</div>
						
						<button class="btn btn-sm btn-success fw-600 px-3 mr-2 mb-2"> Ikuti</button>

						<!--<button class="btn btn-sm btn-success fw-600 px-3 mr-2 mb-2"> Chat Penjual</button>-->

						<button class="btn btn-sm btn-light fw-600 px-4 mr-2 border mb-2" data-toggle="collapse" data-target=".shop--info"> Info Toko</button>

						<button class="btn btn-sm btn-light fw-600 border mb-2" data-toggle="modal" data-target="#ModalCatatanToko" title="Catatan toko"> <i class="fal fa-file-alt"></i></button>
		
					</div>

				</div>
				<div class="shop-single--content-right col-md-6">
					
					<div class="row">
						
						<div class="col-4">
							<p class="fs-16 fw-500 mb-2">Total Produk</p>
							<h2 class="fw-600 fs-24 total-produk--toko">
								0
							</h2>
						</div>

						<!-- <div class="col-8">
							<p class="fs-16 fw-500 mb-2">Statistik Toko</p>
							<div class="row">
								<div class="col-auto pr-0">
									<h2 class="fw-600 fs-24">0</h2>
								</div>
								<div class="col-6 pl-1 pr-0">
									<div class="rating--shop fs-20">
										<i class="fas fa-star icon--rating"></i>
										<i class="fas fa-star icon--rating"></i>
										<i class="fas fa-star icon--rating"></i>
										<i class="fas fa-star icon--rating"></i>
										<i class="fas fa-star icon--rating"></i>
									</div>
								</div>
								<div class="col-auto pl-0">
									<span class="tet-muted fs-12">(0 Ulasan)</span>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<button class="btn text-success btn-sm fs-12 p-0">Lihat statistik toko</button>
								</div>
								<div class="col-6 text-right">
									<button class="btn btn-sm btn-light border text-dark-2" title="Bagikan Toko Ini"><i class="fad fa-share-alt"></i></button>
								</div>
							</div>
						</div> -->

					</div>

				</div>

			</div>

			<div class="collapse shop--info pt-3">
				<h5>Deskripsi</h5>
				<p class="deskripsi--toko">Deskripsi toko tidak tersedia</p>
			</div>

		</div>

	</div>

	<!-- tabs -->

	<ul class="nav nav-tabs" role="tablist">
	  <li class="nav-item">
	    <a class="nav-link <?= $tabs == 1? 'active' : ''; ?>" id="home--menu-tab" href="<?= base_url('shop/'.$toko.'?tab=1'); ?>"><i class="fad fa-home icon"></i> Beranda</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link <?= $tabs == 2? 'active' : ''; ?>" id="produk--menu-tab" href="<?= base_url('shop/'.$toko.'?tab=2'); ?>"><i class="fad fa-briefcase icon"></i> Produk</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link <?= $tabs == 3? 'active' : ''; ?>" id="ulasan--menu-tab" href="<?= base_url('shop/'.$toko.'?tab=3'); ?>"><i class="fad fa-comment-lines icon"></i> Ulasan</a>
	  </li>
	</ul>
	<div class="tab-content" id="pills-tabContent">
	  <div class="tab-pane fade show active">
	  	<div class="container pt-3 px-lg-2 px-0">
	  		<?php if ($tabs){
	  			require 'shop/tab_'.$tabs.'.php';
	  		} ?>
		</div>
	  </div>
	</div>

</div>
