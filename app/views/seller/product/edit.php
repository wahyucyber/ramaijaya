<div class="container d-flex justify-content-center mb-5 edit-product-page">
	<div class="content">
		<div class="pull-left mb-2">
			<a href="<?php echo base_url('seller/product'); ?>" class="btn btn-orange btn-sm"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
		</div>
		<form action="" id="add-product-form">
			<h5 class="d-inline-block fs-18 mb-3 ">Edit Produk</h5>
			<div class="alert alert-light border-orange mb-3 fs-13">
				Sebelum menambahkan produk, pastikan produk tersebut sudah sesuai dengan syarat dan ketentuan JPStore. Semua produk yang melanggar syarat dan ketentuan akan dinon-aktifkan oleh tim kami.
			</div>
			<div class="msg-div-add-product"></div>
			<div class="card mb-3 shadow">
				<div class="card-body">
					<h5 class="d-inline-block fs-18">Upload Produk</h5> <span class="badge badge-danger badge-pill ml-2">Wajib</span>
					<small class="d-block fs-11 fw-500 mb-3">Format gambar .jpg .jpeg .png dan ukuran minimum 300 x 300px (Untuk gambar optimal gunakan ukuran minimum 700 x 700 px)</small>

					<div class="file-upload">
						<div class="container" id="foto--produk">
							<div class="mb-3 mx-auto file-upload-item btn-browse-file active">
								<div class="img-viewer">
									<div class="display">
										<img src="<?= base_url(); ?>assets/img/logo/favicon.png" alt="" data-default="<?= base_url(); ?>passets/img/default/JP.png">
									</div>
								</div>
								<div class="action">
									<button type="button" class="btn btn-sm btn-light btn-change-file-upload"><i class="fa fa-folder"></i></button>
									<button type="button" class="btn btn-sm btn-light btn-delete-file-upload"><i class="fal fa-trash-alt"></i></button>
								</div>
								<input type="file" class="data-product-image data-base64" data-base64="" hidden>
							</div>
							<div class="mb-3 mx-auto file-upload-item btn-browse-file disabled">
								<div class="img-viewer">
									<div class="display">
										<img src="<?= base_url(); ?>assets/img/logo/favicon.png" alt="" data-default="<?= base_url(); ?>fassets/img/default/JP.png">
									</div>
								</div>
								<div class="action">
									<button type="button" class="btn btn-sm btn-light btn-change-file-upload"><i class="fa fa-folder"></i></button>
									<button type="button" class="btn btn-sm btn-light btn-delete-file-upload"><i class="fal fa-trash-alt"></i></button>
								</div>
								<input type="file" class="data-product-image data-base64" data-base64="" hidden>
							</div>
							<div class="mb-3 mx-auto file-upload-item btn-browse-file disabled">
								<div class="img-viewer">
									<div class="display">
										<img src="<?= base_url(); ?>assets/img/logo/favicon.png" alt="" data-default="<?= base_url(); ?>assets/img/default/JP.png">
									</div>
								</div>
								<div class="action">
									<button type="button" class="btn btn-sm btn-light btn-change-file-upload"><i class="fa fa-folder"></i></button>
									<button type="button" class="btn btn-sm btn-light btn-delete-file-upload"><i class="fal fa-trash-alt"></i></button>
								</div>
								<input type="file" class="data-product-image data-base64" data-base64="" hidden>
							</div>
							<div class="mb-3 mx-auto file-upload-item btn-browse-file disabled">
								<div class="img-viewer">
									<div class="display">
										<img src="<?= base_url(); ?>assets/img/logo/favicon.png" alt="" data-default="<?= base_url(); ?>assets/img/default/JP.png">
									</div>
								</div>
								<div class="action">
									<button type="button" class="btn btn-sm btn-light btn-change-file-upload"><i class="fa fa-folder"></i></button>
									<button type="button" class="btn btn-sm btn-light btn-delete-file-upload"><i class="fal fa-trash-alt"></i></button>
								</div>
								<input type="file" class="data-product-image data-base64" data-base64="" hidden>
							</div>
							<div class="mb-3 mx-auto file-upload-item btn-browse-file disabled">
								<div class="img-viewer">
									<div class="display">
										<img src="<?= base_url(); ?>assets/img/logo/favicon.png" alt="" data-default="<?= base_url(); ?>assets/img/default/JP.png">
									</div>
								</div>
								<div class="action">
									<button type="button" class="btn btn-sm btn-light btn-change-file-upload"><i class="fa fa-folder"></i></button>
									<button type="button" class="btn btn-sm btn-light btn-delete-file-upload"><i class="fal fa-trash-alt"></i></button>
								</div>
								<input type="file" class="data-product-image data-base64" data-base64="" hidden>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<div class="card mb-3 shadow">
				<div class="card-body">
					<h4 class="">Informasi Produk</h4> 
					<div class="form-group mb-4">
						<div class="row">
							<div class="col-md-3">
								<label for="" class="mb-0">Nama Produk <small class="text-danger">*</small></label>
								<small class="d-block text-muted">Tulis nama produk sesuai jenis, merek, dan rincian produk</small>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control nama_produk input--length" maxlength="70" placeholder="Contoh: Buku Bahasa Indonesia Kelas 3 SMA">
							</div>
						</div>
					</div>
					<div class="form-group mb-4">
						<div class="row">
							<div class="col-md-3">
								<label for="">Kategori <small class="text-danger">*</small></label>
							</div>
							<div class="col-md-9">
								<div class="row">
									<div class="col-md-4 mb-3">
										<select class="form-control select2 kategori" data-placeholder="Pilih Kategori">
											<option value=""></option>
										</select>
									</div>
									<div class="col-md-4 mb-3 d-none">
										<select class="form-control select2 sub_kategori" data-placeholder="Pilih Sub Kategori">
											<option value=""></option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="form-group mb-4">
						<div class="row">
							<div class="col-md-3">
								<label for="">Etalase</label>
							</div>
							<div class="col-md-9">
								<div class="row">
									<div class="col-md-6 mb-3">
										<select class="form-control select2 input-kategori" data-placeholder="Pilih Etalase">
											<option value=""></option>
											<option value="add">Tambah Etalase</option>
										</select>
									</div>
									<div class="col-md-6 mb-3">
										<input type="text" class="form-control" placeholder="Masukkan Nama Etalase">
									</div>
								</div>
							</div>
						</div>
					</div> -->
				</div>
			</div>
			<div class="card mb-3 shadow">
				<div class="card-body">
					<h4>Deskripsi Produk</h4>
					<div class="form-group mb-4">
						<div class="row">
							<div class="col-md-3">
								<label for="">Kondisi <small class="text-danger">*</small></label>
							</div>
							<div class="col-md-9">
								<div class="row">
									<div class="col-md-2 mb-3">
										<div class="custom-control custom-radio">
										  <input type="radio" id="baru" name="kondisi" class="custom-control-input" checked value="1">
										  <label class="custom-control-label curs-p" for="baru">Baru</label>
										</div>
									</div>
									<div class="col-md-2 mb-3">
										<div class="custom-control custom-radio">
										  <input type="radio" id="bekas" name="kondisi" class="custom-control-input" value="0">
										  <label class="custom-control-label curs-p" for="bekas">Bekas</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group mb-4">
						<div class="row">
							<div class="col-md-3">
								<label for="" class="mb-0">Keterangan Produk <small class="text-danger">*</small></label>
								<small class="d-block text-muted">Deskripsikan produk secara lengkap & jelas. Rekomendasi panjang: <=2000 karakter.</small>
							</div>
							<div class="col-md-9">
								<textarea rows="5" id="ckeditor" class="form-control deskripsi ckeditor input--length" id="kategori" maxlength="2000" placeholder="Berikan informasi dengan jelas dan serinci mungkin produk yang"></textarea>
							</div>
						</div>
					</div>
					<!-- <div class="form-group mb-4">
						<div class="row">
							<div class="col-md-3 mb-3">
								<label for="" class="mb-0">Video Produk</label>
								<small class="d-block text-muted">URL video yang didukung saat ini adalah URL video dari <a href="https://www.youtube.com">Youtube</a></small>
							</div>
							<div class="col-md-9">
								<button type="button" id="btn-product-add-url"
								 data-toggle="collapse" 
								 data-target=".url_product_controls" 
								 aria-controls="product-url btn-product-add-url" class="btn btn-light text-dark-2 collapse show url_product_controls"><i class="fal fa-plus"></i> Tambah URL Video</button>
								<div class="form-inline collapse url_product_controls" id="product-url">
									<div class="form-group mb-2">
									    <label for="url_youtube" class="sr-only">URL</label>
									    <input type="password" class="form-control" id="url_youtube" placeholder="Masukkan Url Video">
									  </div>
									  <button type="button" class="btn btn-primary mb-2 ml-lg-2 ml-sm-0">Simpan</button>
								</div>
							</div>
						</div>
					</div> -->
				</div>
			</div>
			<div class="card mb-3 shadow">
				<div class="card-body">
					<h4>Harga</h4>
					<div class="form-group mb-4">
						<div class="row">
							<div class="col-md-3">
								<label for="" class="mb-0">Minimum Pemesanan</label>
								<small class="d-block text-muted">Atur jumlah minimum yang harus dibeli untuk produk ini.</small>
							</div>
							<div class="col-md-9">
								<input type="number" class="form-control col-md-6 min_beli" value="1" min="1">
							</div>
						</div>
					</div>
					<div class="form-group mb-4">
						<div class="row">
							<div class="col-md-3">
								<label for="">Harga Satuan</label>
							</div>
							<div class="col-md-9">
								<div class="row">
									<div class="col-md-6">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">Rp</span>
											</div>
											<input type="number" class="form-control harga" placeholder="Masukkan Harga">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group mb-4">
						<div class="row">
							<label for="" class="col-md-3">Grosir <i><sup>(Optional)</sup></i></label>
							<div class="col-md-9">
								<table class="table grosir">
									<thead>
										<tr>
											<th>QTY Min.</th>
											<th>QTY Max.</th>
											<th>Harga</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
								<button type="button" class="btn btn-success btn-sm _repeater-tambah">Tambah</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card mb-3 shadow">
				<div class="card-body">
					<h4>Pengelolaan Produk</h4>
					<div class="form-group mb-4">
						<div class="row">
							<div class="col-md-3">
								<label for="">Status Produk</label>
								<small class="d-block text-muted">Jika status aktif, produkmu dapat dicari oleh calon pembeli.</small>
							</div>
							<div class="col-md-9">
								<div class="custom-control custom-switch">
								  <input type="checkbox" class="custom-control-input" id="status-produk" value="1" checked>
								  <label class="custom-control-label" for="status-produk">Aktif</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group mb-4">
						<div class="row">
							<div class="col-md-3">
								<label for="">Stok Produk</label>
							</div>
							<div class="col-md-9">
								<input type="number" min="0" max="999999" class="form-control col-md-8 stok" placeholder="Masukkan jumlah Stok" value="0">
							</div>
						</div>
					</div>
					<div class="form-group mb-4">
						<div class="row">
							<div class="col-md-3">
								<label for="" class="mb-0">SKU (Stok Keeping Unit)</label>
								<small class="d-block text-muted">Gunakan SKU untuk menambahkan kode unik pada produk ini.</small>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control col-md-6 sku" placeholder="Masukkan SKU">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card mb-3 shadow">
				<div class="card-body">
					<h4>Berat Pengiriman</h4>
					<div class="form-group mb-4">
						<div class="row">
							<div class="col-md-3">
								<label for="" class="mb-0">Berat <small class="text-danger">*</small></label>
								<small class="d-block text-muted">Produk ringan dengan ukuran yang besar hitung dengan Volume Weight.</small>
							</div>
							<div class="col-md-9 mb-3">
								<div class="row">
									<div class="col-md-3 mb-3">
										<select class="form-control select2 satuan-berat">
											<option value="g">Gram (g)</option>
											<option value="kg">KiloGram (Kg)</option>
										</select>
									</div>
									<div class="col-md-5 mb-3">
										<input type="number" class="form-control berat" placeholder="Masukkan Berat">
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--<div class="form-group mb-4 d-none">-->
					<!--	<div class="row">-->
					<!--		<div class="col-md-3">-->
					<!--			<label for="" class="mb-0">Asuransi Pengiriman</label>-->
					<!--			<small class="d-block text-muted">Aktifkan jaminan kerugian, kerusakan & kehilangan atas pengiriman produk ini.</small>-->
					<!--		</div>-->
					<!--		<div class="col-md-9">-->
					<!--			<div class="row">-->
					<!--				<div class="col-md-6">-->
					<!--					<div class="custom-control custom-radio custom-control-inline">-->
					<!--					  <input type="radio" id="opsional" name="asuransi" class="custom-control-input" checked value="0">-->
					<!--					  <label class="custom-control-label curs-p" for="opsional">Opsional</label>-->
					<!--					</div>-->
					<!--					<div class="custom-control custom-radio custom-control-inline">-->
					<!--					  <input type="radio" id="yes" name="asuransi" class="custom-control-input" value="1">-->
					<!--					  <label class="custom-control-label curs-p" for="yes">Ya</label>-->
					<!--					</div>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--	</div>-->
					<!--</div>-->
					<div class="form-group mb-4">
						<div class="row">
							<div class="col-md-3">
								<label for="">Preorder</label>
							</div>
							<div class="col-md-9 parent-preorder">
								<div class="custom-control custom-switch mb-3">
								  <input type="checkbox" class="custom-control-input preorder" id="input-preorder" value="0">
								  <label class="custom-control-label curs-p" for="input-preorder"><small class="text-muted">Aktifkan Preorder ini jika membutuhkan waktu proses lebih lama.</small></label>
								</div>
								<div class="waktu-preorder collapse">
									<h4 class="fs-14 mb-1">Waktu Proses</h4>
									<small class="fs-11 d-block mb-3">Aktu proses wajib diisi untuk mengetahui lama produk diproses.</small>
									<div class="row waktu_preorder">
										<div class="col-md-4">
											<input type="number" class="form-control lama--preorder input--length" max="28" value="0">
											<div class="text-right fs-13 text-muted mt-2 input-length">
												Maksimum <span class="fw-bold">28</span> Minggu
														              </div>
										</div>
										<div class="col-md-2">
											<select class="form-control select2 waktu--preorder">
												<option value="minggu">Minggu</option>
												<option value="hari">Hari</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="text-right">
				<button type="button" class="btn btn-sm btn-danger" onclick="redirect('seller/product')"><i class="fal fa-times-circle"></i>	Batal</button>
				<button class="btn btn-sm btn-success" type="button" onclick="product_edit.edit()"><i class="fal fa-save"></i>	Simpan</button>
			</div>
		</form>	
	</div>
</div>
