<div class="backend-sidebar" id="backend-sidebar">
	<div class="backend-sidebar-header d-flex align-items-center justify-content-start">
		<button class="btn btn-toggle-sidebar" id="btn-toggle-sidebar"><i class="fal"></i></button>
		<h6 class="fs-15 d-inline-block">Mulai Berjualan</h6>
	</div>
	<div class="backend-sidebar-body">
		<ul class="backend-sidebar-list">
			<li class="list-profile" id="shop-profile">
				<div class="d-flex align-items-center">
					<div class="d-flex mb-3">
						<div class="profile-img shadow">
							<img src="<?= base_url(); ?>cdn/default/shop.png" alt="" class="shop--avatar-default img-thumbnail rounded-circle">
						</div>
						<div class="text-wrapper">
							<a href="" class="fw-500 mb-0 text-elipsis shop--name text-elipsis text-orange" style="max-width: 80%" title="">Nama Toko</a>
							<div>
								<small class="mr-1 user--name" title="Pemilik Toko">Pemilik toko</small>
								<span class="status-indicator online" title="Aktif"></span>
							</div>
						</div>
					</div>
				</div>
			</li>
			<li class="list-item <?= segment(2) == '' || segment(2) == 'home'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>seller/home"><i class="fad fa-home-lg-alt _icon"></i> Beranda</a>
			</li>
			<!-- <li class="list-item <?= segment(2) == 'kurir'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>seller/kurir"><i class="fad fa-car-side _icon"></i> Kurir</a>
			</li> -->
			<li class="list-item <?= segment(2) == 'penjualan' || segment(2) == 'komplain' || segment(2) == 'ulasan'? 'active' : '' || segment(2) == 'diskusi'? 'active' : '' ; ?>">
				<a href="javascript:;" class="btn-collapse"><i class="fad fa-file-alt _icon"></i> Penjualan <span class="fa _icon-right"></span></a>
				<ul class="collapse <?= segment(2) == 'penjualan' || segment(2) == 'komplain' || segment(2) == 'ulasan'? 'show' : '' || segment(2) == 'diskusi'? 'show' : ''; ?>">
					<li class="list-item <?= segment(2) == 'penjualan'? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>seller/penjualan" class="sub-list-item"><i class="fa fa-xs _icon"></i> Pesanan 
						<!--<span class="badge badge-primary sidebar-list--notif">12</span>-->
						</a>
					</li>
					<li class="list-item <?= segment(2) == 'komplain'? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>seller/komplain" class="sub-list-item"><i class="fa fa-xs _icon"></i> Komplain 
						<!--<span class="badge badge-primary sidebar-list--notif">2</span>-->
						</a>
					</li>
					<li class="list-item <?= segment(2) == 'ulasan'? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>seller/ulasan" class="sub-list-item"><i class="fa fa-xs _icon"></i> Ulasan 
						<!--<span class="badge badge-primary sidebar-list--notif">2</span>-->
						</a>
					</li>
					<li class="list-item <?= segment(2) == 'diskusi'? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>seller/diskusi" class="sub-list-item"><i class="fa fa-xs _icon"></i> Diskusi 
						<!--<span class="badge badge-primary sidebar-list--notif">2</span>-->
						</a>
					</li>
					<!-- <li class="list-item <?= segment(2) == 'resolution_center'? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>seller/resolution_center" class="sub-list-item"><i class="fa fa-xs _icon"></i> Pusat Resolusi</a>
					</li> -->
				</ul>
			</li>
			<li class="list-item <?= segment(2) == 'product' || segment(2) == 'etalase' ? 'active' : '' ; ?>">
				<a href="javascript:;" class="btn-collapse"><i class="fad fa-briefcase _icon"></i> Produk <span class="fa _icon-right"></span></a>
				<ul class="collapse <?= segment(2) == 'product' || segment(2) == 'etalase' ? 'show' : '' ; ?>">
					<li class="list-item <?= segment(2) == 'etalase'? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>seller/etalase" class="sub-list-item"><i class="fa fa-xs _icon"></i> Daftar Etalase</a>
					</li>
					<li class="list-item <?= segment(2) == 'product'? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>seller/product" class="sub-list-item"><i class="fa fa-xs _icon"></i> Daftar Produk 
						<!--<span class="badge badge-primary sidebar-list--notif">12</span>-->
						</a>
					</li>
					<li class="list-item <?= segment(3) == 'add'? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>seller/product/add" class="sub-list-item"><i class="fa fa-xs _icon"></i> Tambah Produk</a>
					</li>
				</ul>
			</li>
			<li class="list-item <?= segment(2) == 'diskon' ? 'active' : '' ; ?>">
				<a href="javascript:;" class="btn-collapse"><i class="fas fa-badge-percent _icon"></i> Diskon <span class="fa _icon-right"></span></a>
				<ul class="collapse <?= segment(2) == 'diskon'? 'show' : '' ; ?>">
					<!--<li class="list-item <?= segment(3) == 'kategori'? 'active' : '' ; ?>">-->
					<!--	<a href="<?= base_url(); ?>seller/diskon/kategori" class="sub-list-item"><i class="fa fa-xs _icon"></i> Kategori -->
					<!--	</a>-->
					<!--</li>-->
					<li class="list-item <?= segment(3) == 'produk'? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>seller/diskon/produk" class="sub-list-item"><i class="fa fa-xs _icon"></i> Produk</a>
					</li>
				</ul>
			</li>
			<!-- <li class="list-item <?= segment(2) == 'statistic'? 'active' : '' ; ?>">
				<a href="javascript:;" class="btn-collapse"><i class="fad fa-chart-bar _icon"></i> Statistik <span class="fa _icon-right"></span></a>
				<ul class="collapse <?= segment(2) == 'statistic'? 'show' : '' ; ?>">
					<li class="list-item <?= segment(3) == 'dashboard'? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>seller/statistic/dashboard" class="sub-list-item"><i class="fa fa-xs _icon"></i> Wawasan Toko</a>
					</li>
					<li class="list-item <?= segment(3) == 'market_insight'? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>seller/statistic/market_insight" class="sub-list-item"><i class="fa fa-xs _icon"></i> Wawasan Pasar</a>
					</li>
				</ul>
			</li> -->
			<li class="list-item <?= segment(2) == 'setting'? 'active' : '' ; ?>">
				<a href="javascript:;" class="btn-collapse"><i class="fad fa-cog _icon"></i> Pengaturan Toko <span class="fa _icon-right"></span></a>
				<ul class="collapse <?= segment(2) == 'setting'? 'show' : '' ; ?>">
					<li class="list-item <?= segment(3) == 'shop'? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>seller/setting/shop" class="sub-list-item"><i class="fa fa-xs _icon"></i> Pengaturan Toko</a>
					</li>
					<!-- <li class="list-item <?= segment(3) == 'admin'? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>seller/setting/admin" class="sub-list-item"><i class="fa fa-xs _icon"></i> Pengaturan Admin</a>
					</li> -->
				</ul>
			</li>
			<li class="list-item <?= segment(2) == '' || segment(2) == 'sinkron'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>seller/sinkron"><i class="fad fa-sync _icon"></i> Sinkronisasi</a>
			</li>
			
		</ul>
	</div>
</div>