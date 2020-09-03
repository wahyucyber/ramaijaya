<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item text-primary nama--toko"></li>
    <li class="breadcrumb-item" aria-current="page">Produk</li>
  </ol>
</nav>

<div class="shop-product--content">
	
	<div class="shop-product--storefront">
		
		<div class="storefront--content">
				
			<h3 class="fs-14 fw-600">Kategori Toko</h3>

			<ul class="storefront--list" id="CategoryList">
				
				<?= $loader; ?>

			</ul>

		</div>

	</div>

	<div class="shop-product--list">
		
		<form class="row mb-4" id="form-keyword">
			<div class="col-6">
				<div class="input-group">
					<input type="text" class="form-control keyword-produk" placeholder="Cari Produk di toko ini">
					<div class="input-group-append">
						<button type="submit" class="btn input-group-text"><i class="fad fa-search"></i></button>
					</div>
				</div>
			</div>
			<div class="col-6">
				<select class="form-control select2 ml-auto filter" data-placeholder="Urutkan">
					<option value="0">Semua</option>
					<option value="filter.termurah">Harga Terendah</option>
					<option value="filter.termahal">Harga Tertinggi</option>
					<option value="filter.terbaru">Produk Terbaru</option>
					<option value="filter.terlama">Produk Terlama</option>
				</select>
			</div>
		</form>

		<div class="product--content" id="produk--toko"></div>
		<div id="pagination" class="text-center mt-3"></div>

	</div>

</div>