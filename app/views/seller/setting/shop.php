<section class="setting_store">
	<?php include __DIR__.'/../sidebar.php' ?>
	<div class="content-right" id="content-right">
		<h3 class="mb-4 nama_toko-title"></h3>
		<div class="card">
			<ul class="nav nav-tabs" id="searchTabs" role="tablist">
			  <li class="nav-item">
			    <a class="nav-link<?= $tabs == 1? ' active' : ''; ?>" href="<?= base_url('seller/setting/shop?tab=1'); ?>"> Informasi</a>
			  </li>
			  <!-- <li class="nav-item">
			    <a class="nav-link<?= $tabs == 2? ' active' : ''; ?>"  href="<?= base_url('seller/setting/shop?tab=2'); ?>"> Etalase</a>
			  </li> -->
			   <li class="nav-item">
			    <a class="nav-link<?= $tabs == 3? ' active' : ''; ?>"  href="<?= base_url('seller/setting/shop?tab=3'); ?>"> Catatan</a>
			  </li>
			  <!-- <li class="nav-item">
			    <a class="nav-link<?= $tabs == 4? ' active' : ''; ?>"  href="<?= base_url('seller/setting/shop?tab=4'); ?>"> Pengiriman</a>
			  </li> -->
			  <!-- <li class="nav-item">
			    <a class="nav-link<?= $tabs == 5? ' active' : ''; ?>"  href="<?= base_url('seller/setting/shop?tab=5'); ?>"> Produk Unggulan</a>
			  </li> -->
			  <!-- <li class="nav-item">
			    <a class="nav-link<?= $tabs == 6? ' active' : ''; ?>"  href="<?= base_url('seller/setting/shop?tab=6'); ?>"> Template Balasan</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link<?= $tabs == 7? ' active' : ''; ?>"  href="<?= base_url('seller/setting/shop?tab=7'); ?>"> Layanan</a>
			  </li> -->
			</ul>

			<div class="tab-content">
			
				<div class="tab-pane fade show active" id="content--shop">
					<?php if ($tabs){
						include "shop/tab_$tabs.php";
					} ?>
				</div>

			</div>
		</div>
	</div>
</section>