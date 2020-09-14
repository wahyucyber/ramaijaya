
<div class="container">
	
	<div class="shop-single--content" id="shop--single-content">
		
		

		<div class="shop-single--body">
			
			<div class="shop-single--body-content row">
				
				<div class="shop-single--content-left col-md-6 d-flex">

					<!-- <div class="shop-single--head"> -->
						<img src="<?= base_url('assets/img/default/seller_no_cover_3.png'); ?>" alt="" class="shop-single--banner banner--toko"  width="100%" style="">
					<!-- </div> -->
					
					<div class="shop-single--info-overlay">
						
						<div class="shop-single--detail">
							
							<div class="shop-single--logo">
								<img src="<?= base_url('assets/img/default/shop.png'); ?>" alt="" class="logo--toko" width="100%">
							</div>
							<div class="shop-single-info pl-3">
								<h5 class="fs-25 fw-700 nama--toko">Nama Toko</h5>

								<div class="row mb-2">
									<div class="col-auto">
										<h6 class=""><i class="fad fa-map-marker-alt"></i> <span class="kabupaten--toko">-</span></h6>
									</div>
									<!-- <div class="col-auto">
										<h5 class="fs-14"><span class="fw-600">0</span> Pengikut</h5>
									</div> -->
								</div>
								<div class="shop-single--info-action">
									<button class="btn btn-sm btn-orange fw-600 px-3 mr-2 mb-2"><i class="fal fa-plus"></i> Ikuti</button>
		
									<!--<button class="btn btn-sm btn-success fw-600 px-3 mr-2 mb-2"> Chat Penjual</button>-->
		
									<!-- <button class="btn btn-sm btn-light fw-600 px-4 mr-2 border mb-2" data-toggle="collapse" data-target=".shop--info"> Info Toko</button> -->
		
									<button class="btn btn-sm btn-light fw-600 border mb-2" data-toggle="modal" data-target="#ModalCatatanToko" title="Catatan toko"> <i class="fal fa-file-alt"></i>	Catatan Toko</button>
								
								</div>
							</div>
							
							
						</div>
					</div>

				</div>

				<div class="shop-single--content-right col-md-6 pl-4">
					
					<div class="row">
						
						<div class="col-12">
							<div class="form-group mb-3">
								<p class=" mb-2"><i class="fal fa-box-open"></i>	Total Produk : <b class=" total-produk--toko"> 0 </b></p> 
							</div>
							<div class="form-group">
								<p class="mb-0 badge badge-success bg-orange fs-14"> <i class="fal fa-stream"></i>	<b> Deskripsi :</b></p>
								<p class="deskripsi--toko">Deskripsi toko tidak tersedia</p>
							</div>
						</div>

					</div>

				</div>

			</div>

			<div class="collapse shop--info pt-3">
				
			</div>

		</div>

	</div>

	<!-- tabs -->

	<ul class="nav nav-tabs justify-content-center" role="tablist">
	  <li class="nav-item">
	    <a class="nav-link <?= $tabs == 1? 'active' : ''; ?>" id="home--menu-tab" href="<?= base_url('shop/'.$toko.'?tab=1'); ?>"><i class="fal fa-home icon"></i> Beranda</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link <?= $tabs == 2? 'active' : ''; ?>" id="produk--menu-tab" href="<?= base_url('shop/'.$toko.'?tab=2'); ?>"><i class="fal fa-briefcase icon"></i> Produk</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link <?= $tabs == 3? 'active' : ''; ?>" id="ulasan--menu-tab" href="<?= base_url('shop/'.$toko.'?tab=3'); ?>"><i class="fal fa-comment-lines icon"></i> Ulasan</a>
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
