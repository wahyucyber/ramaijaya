<section class="admin_store">
	<?php include __DIR__.'/../sidebar.php' ?>
	<div class="content-right" id="content-right">

		<!-- <h5>Diskon Produk</h5> -->
		<div id="msg--content"></div>

		<div class="card border-0 shadow mb-3">
			<div class="card-body">
				<div class="form-group mb-2">
					<span class="badge badge-success bg-orange">Tambah Diskon</span>
				</div>
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<!-- <small>Diskon</small> -->
							<div class="input-group">
								<input type="number" class="form-control diskon" placeholder="Masukkan Diskon" min="1" max="100">
								<div class="input-group-append">
									<span class="input-group-text">%</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group mb-0">
							<!-- <small>Produk</small> -->
							<select class="form-control select2 produk" data-placeholder="Pilih Produk" multiple>
								<option value=""></option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group mb-0">
							<input type="text" name="" id="" class="form-control _daterangepicker">
							<input type="hidden" name="" class="_daterangepicker--dari-tanggal">
							<input type="hidden" name="" class="_daterangepicker--ke-tanggal">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<!-- <small class="d-inline-block">&nbsp;</small> -->
							<button class="btn btn-orange btn-block" onclick="diskon_produk.add()">
								<i class="fa fa-plus"></i> Tambah
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="card border-0 shadow">
			<div class="card-body">
				<table class="table " id="data--diskon">
					<thead class="bg-orange text-white">
						<tr>
							<th>No</th>
							<th>Nama Produk</th>
							<th>Harga</th>
							<th>Harga Diskon</th>
							<th>Masa Diskon</th>
							<th>Aksi</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

	</div>
</section>

<div class="modal fade" id="ModalDelete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-danger text-white">
				<h5 class="modal-title">Konfirmasi</h5>
			</div>
			<div class="modal-body">
				<div class="alert alert-warning">Apakah anda yakin ingin menghapus diskon kategori ini?</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
				<button class="btn btn-danger btn-sm btn--delete">Iya</button>
			</div>
		</div>
	</div>
</div>