<section class="setting-store manage-product-page">
	<?php include __DIR__.'/../sidebar.php'; ?>
	<div class="content-right" id="content-right">
		
		<div class="clearfix mb-1">
			<div class="float-left">
				<h5 class="fs-24 mb-3">Daftar produk</h5>
			</div>
			<div class="float-right">
				<button class="btn btn-default btn-sm btn-refresh"><i class="fa fa-retweet"></i></button>
				<button class="btn btn-default btn-sm btn-info btn-slideFilter"><i class="fa fa-filter"></i></button>
				<a href="<?php base_url(''); ?>product/import" class="btn btn-success btn-add-once btn-sm"><i class="fa fa-cloud-upload"></i></a>
				<a href="<?= base_url(); ?>seller/product/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
			</div>
		</div>

		<!-- <div class="card card-produk-teratas shadow mb-3">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div class="row">
						<div class="col-md-2">
							<img src="https://ecs7.tokopedia.net/img/ta/display/cpm/digital/illustration/oneclick.png" class="w-75">
						</div>
						<div class="col-md-7">
							<h6><b>Mau produkmu tampil teratas?</b></h6>
							<small>Yuk simak tips ampuh menaikkan posisi produk di halaman pencarian</small>
						</div>
						<div class="col-md-3 d-flex align-items-center">
							<a href="" class="btn btn-primary ml-auto">Cek Selengkapnya</a>
						</div>
					</div>
				</div>
			</div>
		</div> -->

		<!-- <div class="clearfix mb-3">
			<div class="float-left">
				<form action="" id="cari-produk">
					<div class="input-group">
						<input type="text" class="form-control cari" placeholder="Cari">
						<div class="input-group-append">
							<button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</form>
			</div>
			<div class="float-right">
				<select class="form-control select2" data-placeholder="Urutkan">
					<option value=""></option>
					<option value="1">Utama</option>
					<option value="1">Harga Tertinggi</option>
					<option value="1">Produk Baru</option>
					<option value="1">Pembaruan Terakhir</option>
					<option value="1">Nama Produk</option>
					<option value="1">Dilihat Terbanyak</option>
					<option value="1">Diskusi Terbanyak</option>
					<option value="1">Harga Terendah</option>
				</select>
			</div>
		</div> -->

		<div class="card mb-1 panel-filter">
			<div class="card-body">
				<h6 class="fs-15">Filter</h6>
				<div class="row">
					<!-- <div class="col-md-4">
						<select class="form-control select2" data-placeholder="Berdasarkan Produk">
							<option value=""></option>
							<option value="*">Semua Produk</option>
							<option value="1">Semua Etalase</option>
							<option value="2">Produk Terjual</option>
						</select>
					</div> -->
					<div class="col-md-4">
						<select class="form-control filter-kategori-product select2" data-placeholder="Berdasarkan Kategori">
						</select>
					</div>
					<div class="col-md-4">
						<select class="form-control filter-status-product select2" data-placeholder="Status">
							<option value="">Samua</option>
							<option value="1">Aktif</option>
							<option value="0">Tidak aktif</option>
						</select>
					</div>
					
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-body">
				<div class="msg-div-manage-product"></div>
				<div class="table-responsive">
					<table class="table table-borderless table-hover table-product" style="width: 100%;">
						<thead class="bg-primary text-white">
							<tr>
								<th>No</th>
								<th>Produk</th>
								<th>Pengaturan Harga</th>
								<!-- <th><i class="fal fa-star fs-15"></i> 0/5</th> -->
								<th>Stok</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<div id="pagination"></div>
			</div>
		</div>


	</div>

	<div class="modal fade" id="ModalConfirm">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-danger">
	        <h5 class="modal-title text-white">Konfirmasi</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true" class="text-white">&times;</span>
	        </button>
	      </div>
	      <?= form_open(); ?>
	      <div class="modal-body">
	      	
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
	        <button type="submit" class="btn btn-danger">Iya</button>
	      </div>
	      <?= form_close(); ?>
	    </div>
	  </div>
	</div>

</section>