<div class="backend-sidebar" id="backend-sidebar">
	<div class="backend-sidebar-header justify-content-start">
		<button class="btn btn-toggle-sidebar" id="btn-toggle-sidebar"><i class="fal"></i></button>
	</div>
	<div class="backend-sidebar-body">
		<ul class="backend-sidebar-list">
			<li class="list-profile" id="sidebar-account">
				<div class="d-flex align-items-center">
					<div class="d-flex mb-3 w-100">
						<div class="profile-img shadow">
							<img src="<?= base_url(); ?>assets/img/default/profile.jpg" alt="" class="user--avatar-default img-thumbnail rounded-circle">
						</div>
						<div class="text-wrapper">
							<a href="" class="fw-500 mb-0 text-elipsis user--name text-elipsis" style="max-width: 100%" title="">Nama User</a>
							<div>
								<small class="mr-1 role--name" title="Title">Administrator</small>
								<span class="status-indicator online" title="Aktif"></span>
							</div>
						</div>
					</div>
				</div>
			</li>
			<li class="list-item <?= segment(2) == 'dashboard' ? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>admin/dashboard"><i class="fad fa-home-lg-alt _icon"></i> Beranda</a>
			</li>
			<li class="list-item <?= segment(2) == 'tab'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>admin/tab"><i class="fad fa-tags _icon"></i> Tab</a>
			</li>
			<li class="list-item <?= segment(2) == 'slider'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>admin/slider"><i class="fad fa-film _icon"></i> Slider</a>
			</li>
			<li class="list-item <?= segment(2) == 'promo'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>admin/promo"><i class="fal fa-tags _icon"></i> Promo 
				<!--<span class="badge badge-primary sidebar-list--notif">12</span>-->
				</a>
			</li>	
			<li class="list-item <?= segment(2) == 'faq'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>admin/faq"><i class="fal fa-question-circle _icon"></i> FAQ 
				<!--<span class="badge badge-primary sidebar-list--notif">12</span>-->
				</a>
			</li>		
			<li class="list-item <?= segment(2) == 'category'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>admin/category"><i class="fad fa-list _icon"></i> Kategori 
				<!--<span class="badge badge-primary sidebar-list--notif">12</span>-->
				</a>
			</li>
			<li class="list-item <?= segment(2) == 'manual_payment'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>admin/manual_payment"><i class="fad fa-credit-card _icon"></i> Pembayaran Manual</a>
			</li>
			<!-- <li class="list-item <?= segment(2) == 'transaction'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>admin/transaction"><i class="fad fa-credit-card _icon"></i> Transaksi</a>
			</li> -->
			<li class="list-item <?= (segment(2) == 'transaction' && segment(3) == "") || (segment(2) == 'transaction' && segment(3) == 'pengajuan') || (segment(2) == 'transaction' && segment(3) == 'detail') || (segment(2) == 'transaction' && segment(3) == 'refund') ? 'active' : '' ; ?>">
				<a href="javascript:;" class="btn-collapse"><i class="fad fa-bullhorn _icon"></i> Transaksi <span class="fa _icon-right"></span></a>
				<ul class="collapse <?= (segment(2) == 'transaction' && segment(3) == "") || (segment(2) == 'transaction' && segment(3) == 'pengajuan') || (segment(2) == 'transaction' && segment(3) == 'detail') || (segment(2) == 'transaction' && segment(3) == 'refund') ? 'show' : '' ; ?>">
					<li class="list-item <?= (segment(2) == 'transaction' && segment(3) == "") || segment(3) == 'detail' ? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>admin/transaction" class="sub-list-item"><i class="fa fa-xs _icon"></i> Transaksi 
						<!--<span class="badge badge-primary sidebar-list--notif">12</span>-->
						</a>
					</li>
					<li class="list-item <?= (segment(2) == 'transaction' && segment(3) == 'pengajuan') ? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>admin/transaction/pengajuan" class="sub-list-item"><i class="fa fa-xs _icon"></i> Pengajuan Pencairan 
						<!--<span class="badge badge-primary sidebar-list--notif">12</span>-->
						</a>
					</li>
					<li class="list-item <?= (segment(2) == 'transaction' && segment(3) == 'refund') ? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>admin/transaction/refund" class="sub-list-item"><i class="fa fa-xs _icon"></i> Pengajuan Refund 
						<!--<span class="badge badge-primary sidebar-list--notif">12</span>-->
						</a>
					</li>
				</ul>
			</li>
			<li class="list-item <?= segment(2) == 'komplain'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>admin/komplain"><i class="fas fa-file _icon"></i> Komplain 
				<!--<span class="badge badge-primary sidebar-list--notif">12</span>-->
				</a>
			</li>
			<li class="list-item <?= segment(2) == 'ulasan'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>admin/ulasan"><i class="fas fa-comments _icon"></i> Ulasan 
				<!--<span class="badge badge-primary sidebar-list--notif">12</span>-->
				</a>
			</li>
			<li class="list-item <?= segment(2) == 'diskusi'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>admin/diskusi"><i class="fas fa-comments _icon"></i> Diskusi Produk 
				<!--<span class="badge badge-primary sidebar-list--notif">12</span>-->
				</a>
			</li>
			<li class="list-item <?= segment(2) == 'user'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>admin/user"><i class="fad fa-users _icon"></i> Pengguna 
				<!--<span class="badge badge-primary sidebar-list--notif">12</span>-->
				</a>
			</li>
			<!-- <li class="list-item ">
				<a href="javascript:;" class="btn-collapse"><i class="fa fa-file-alt _icon"></i> Manajemen <span class="fa _icon-right"></span></a>
				<ul class="collapse ">
					<li class="list-item">
						<a href="<?= base_url(); ?>seller/myshop_order" class="sub-list-item"><i class="fa fa-xs _icon"></i> Pesanan</a>
					</li>
					<li class="list-item ">
						<a href="<?= base_url(); ?>seller/resolution_center" class="sub-list-item"><i class="fa fa-xs _icon"></i> Pusat Resolusi</a>
					</li>
				</ul>
			</li> -->
			<li class="list-item <?= segment(2) == 'shop'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>admin/shop"><i class="fad fa-store _icon"></i> Toko 
				<!--<span class="badge badge-primary sidebar-list--notif">12</span>-->
				</a>
			</li>
			<li class="list-item <?= segment(2) == 'product'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>admin/product"><i class="fad fa-briefcase _icon"></i> Produk 
				<!--<span class="badge badge-primary sidebar-list--notif">12</span>-->
				</a>
			</li>
			<li class="list-item <?= (segment(2) == 'setting')? 'active' : '' ; ?>">
				<a href="javascript:;" class="btn-collapse"><i class="fad fa-cog _icon"></i> Pengaturan <span class="fa _icon-right"></span></a>
				<ul class="collapse <?= (segment(2) == 'setting') ? 'show' : '' ; ?>">
					<li class="list-item <?= (segment(3) == 'ppn') || segment(3) == 'detail' ? 'active' : '' ; ?>">
						<a href="<?= base_url(); ?>admin/setting/ppn" class="sub-list-item"><i class="fa fa-xs _icon"></i> PPN 
						<!--<span class="badge badge-primary sidebar-list--notif">12</span>-->
						</a>
					</li>
				</ul>
			</li>
			<!-- <li class="list-item <?= segment(2) == 'order'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>admin/order"><i class="fas fa-luggage-cart _icon"></i> Pesanan</a>
			</li>
			<li class="list-item <?= segment(2) == 'komplain'? 'active' : '' ; ?>">
				<a href="<?= base_url(); ?>admin/komplain"><i class="far fa-comments _icon"></i> Komplain</a>
			</li> -->
		</ul>
	</div>
</div>