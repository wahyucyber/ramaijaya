
<section class="search">
	<div class="search-inner">
		<div class="search-content d-block">
			<div class="column">
				<!-- <h6 class="d-xl-none mb-2">Filter</h6> -->
				<!-- <div class="filter" id="filter">
					<div class="item-content">
						<div class="header-content">
							<a href="javascript:;" data-toggle="collapse" data-target="#category">Kategori</a>
						</div>
						<div class="content collapse show category" id="category">
							<div class="dropdown_inner">
								<span class="sub-header-menu" data-toggle="collapse" data-target="#menu1">
									Buku
									<i class="fa fa-angle-down arrow-icon"></i>
								</span>
								<div class="collapse list-menu" id="menu1">
									<a href="">Pengetahuan</a>
								</div>
							</div>
						</div>
					</div>
					<div class="item-content">
						<div class="header-content">
							<a href="javascript:;" data-toggle="collapse" data-target="#location">Lokasi</a>
						</div>
						<div class="content collapse show location" id="location">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="" class="control-label">Provinsi</label>
										<select name="" id="" class="form-control provinsi form-control-sm" style="height: 30px;">
											<option value="">Provinsi</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="" class="control-label">Kabupaten</label>
										<select name="" id="" class="form-control kabupaten form-control-sm" style="height: 30px;">
											<option value="">Kabupaten</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="" class="control-label">Kecamatan</label>
										<select name="" id="" class="form-control kecamatan form-control-sm" style="height: 30px;">
											<option value="">Kecamatan</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="item-content">
						<div class="header-content">
							<a href="javascript:;" data-toggle="collapse" data-target="#price">Harga</a>
						</div>
						<div class="content collapse show price" id="price">
							<div class="form-group">
								<span>Rp</span>
								<input type="number" class="form-control" placeholder="Minimum">
							</div>
							<div class="form-group">
								<span>Rp</span>
								<input type="number" class="form-control" placeholder="Maksimum">
							</div>
						</div>
					</div>
					<div class="item-content text-left p-3">
						<button class="btn btn-success btn-sm"><i class="fa fa-filter"></i> Filter</button>
					</div>
					<div class="item-content">
						<div class="header-content">
							<a href="javascript:;" data-toggle="collapse" data-target="#offer">Penawaran</a>
						</div>
						<div class="content collapse show offer" id="offer">
							<div class="form-group">
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" id="free-ongkir">
								  <label class="custom-control-label" for="free-ongkir">Gratis Ongkir</label>
								</div>
							</div>
						</div>
					</div>
				</div> -->
			</div>
			<div class="column w-100 pl-0">
				<ul class="nav nav-tabs" id="searchTabs" role="tablist">
				  <li class="nav-item">
				    <a class="nav-link <?= $tabs == 'produk'? 'active' : ''; ?>" href="<?= base_url('search?q='.urlencode($keyword).'&st=produk&kategori='.$_GET['kategori'].'&filter='.$_GET['filter'].'&page='.$_GET['page'].'&provinsi='.$_GET['provinsi'].'&kabupaten='.$_GET['kabupaten'].'&kecamatan='.$_GET['kecamatan']); ?>"><i class="fa fa-archive icon"></i> Produk</a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link <?= $tabs == 'katalog'? 'active' : ''; ?>" href="<?= base_url('search?q='.urlencode($keyword).'&st=katalog&kategori='.$_GET['kategori'].'&filter='.$_GET['filter'].'&page='.$_GET['page'].'&provinsi='.$_GET['provinsi'].'&kabupaten='.$_GET['kabupaten'].'&kecamatan='.$_GET['kecamatan']); ?>"><i class="fa fa-book icon"></i> Katalog</a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link <?= $tabs == 'toko'? 'active' : ''; ?>" href="<?= base_url('search?q='.urlencode($keyword).'&st=toko&kategori='.$_GET['kategori'].'&filter='.$_GET['filter'].'&page=1&provinsi='.$_GET['provinsi'].'&kabupaten='.$_GET['kabupaten'].'&kecamatan='.$_GET['kecamatan']); ?>"><i class="fa fa-store icon"></i> Toko</a>
				  </li>
				</ul>
				<div class="tab-content pt-3" id="searchTabsContent">
				  <div class="tab-pane fade <?= $tabs == 'produk'? 'show active' : ''; ?>" id="product">
					<div class="inner">
						<div class="row">
							<div class="col-md-9 mb-3 search--result">
								<!-- <span>Menampilkan <b>0</b> Produk untuk <b>"<?= str_replace('-',' ',str_replace('+',' ',$keyword)); ?>"</b> (<b>0</b> Dari <b>0 </b>) </span> -->
							</div>
							<div class="col-md-3 mb-3">
								<select name="" id="" class="form-control ml-auto produk-filter" data-placeholder="Pilih Filter">
									<option value=""><?php echo $this->input->get('filter'); ?></option>
									<option value="Terbaru">Terbaru</option>
									<option value="Banyak Dilihat">Banyak Dilihat</option>
									<option value="Harga Tertinggi">Harga Tertinggi</option>
									<option value="Harga Terendah">Harga Terendah</option>
								</select>
							</div>
						</div>
						<div class="product-content mt-2" id="produk-search--content">
							<?= product_loader(); ?>
						</div>
					</div>
				  </div>
				  <div class="tab-pane fade <?= $tabs == 'katalog'? 'show active' : ''; ?>" id="catalog">
					
					<div class="inner">
						<div class="row">
							<div class="col-md-9 mb-3 search--result">
								<!-- <span>Menampilkan <b>0</b> Katalog untuk <b>"<?= str_replace('-',' ',str_replace('+',' ',$keyword)); ?>"</b> (<b>0</b> Dari <b>0 </b>) </span> -->
							</div>
							<div class="col-md-3 mb-3">
								<select name="" id="" class="form-control ml-auto produk-filter" data-placeholder="Pilih Filter">
									<option value=""><?php echo $this->input->get('filter'); ?></option>
									<option value="Terbaru">Terbaru</option>
									<option value="Banyak Dilihat">Banyak Dilihat</option>
									<option value="Harga Tertinggi">Harga Tertinggi</option>
									<option value="Harga Terendah">Harga Terendah</option>
								</select>
							</div>
						</div>
						<div class="product-content mt-3" id="katalog-search--content">
						</div>
					</div>

				  </div>
				  <div class="tab-pane fade <?= $tabs == 'toko'? 'show active' : ''; ?>" id="store">
				  	
					<div class="inner">
						<div class="text-left mb-3 search--result">
							<!-- <span>Menampilkan <b>0</b> Toko untuk <b>"<?= str_replace('-',' ',str_replace('+',' ',$keyword)); ?>"</b> (<b>0</b> Dari <b>0 </b>) </span> -->
						</div>
						<div class="store-content" id="shop-search--content">
							
						</div>
					</div>

				  </div>
				</div>
			</div>
		</div>
	</div>
</section>